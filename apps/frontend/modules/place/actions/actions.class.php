<?php

/**
 * Места
 */
class placeActions extends sfActions
{
    /**
     * Index
     */
    public function executeIndex()
    {
    }

    /**
     * Добавить
     */
    public function executeNew(sfWebRequest $request)
    {
        $user = $this->getUser()->getGuardUser();

        $this->place = new Place();
        $this->place->setGeoLat($request->getParameter('geo_lat'));
        $this->place->setGeoLng($request->getParameter('geo_lng'));
        $this->place->setUser($user);

        $this->form = new PlaceForm($this->place);
    }

    /**
     * Создать
     */
    public function executeCreate(sfWebRequest $request)
    {
        $this->executeNew($request);

        $this->form->bind($request->getParameter($this->form->getName()));
        if ($this->form->isValid()) {
            $place = $this->form->save();
        }

        if (! $this->form->hasErrors()) {
            if ($request->isXmlHttpRequest()) {
                return $this->renderPartial('place/show', array('place' => $place));
            } else {
                return $this->redirect('place_show', $place);
            }
        }

        $this->setTemplate('new');
    }

    /**
     * Показать
     */
    public function executeShow()
    {
        $this->place = $this->getRoute()->getObject();
    }

    /**
     * Следить за событиями
     */
    public function executeFollow(sfWebRequest $request)
    {
        $place = $this->getRoute()->getObject();
        $user = $this->getUser()->getGuardUser();

        if (! $place->hasFollower($user->id)) {
            $accept = new PointUser();
            $accept->setPoint($place);
            $accept->setUser($user);
            $accept->save();
        }

        if ($request->isXmlHttpRequest()) {
            return $this->renderPartial('place/show', array(
                'place' => $place,
                'move' => false, // не дергать карту
            ));
        } else {
            return $this->redirect('place_show', $place);
        }
    }

    /**
     * Перестать следить
     */
    public function executeUnfollow(sfWebRequest $request)
    {
        $place = $this->getRoute()->getObject();
        $user = $this->getUser()->getGuardUser();

        if ($accept = $place->hasFollower($user->id)) {
            $accept->delete();
        }

        // обновить событие
        $place = PlaceTable::getInstance()->findOneById($place->id);

        if ($request->isXmlHttpRequest()) {
            return $this->renderPartial('place/show', array(
                'place' => $place,
                'move' => false, // не дергать карту
            ));
        } else {
            return $this->redirect('place_show', $place);
        }
    }


    /**
     * Данные о местах в JSON
     */
    public function executePlaces()
    {
        $this->points = PointTable::getInstance()
            ->queryActive()
            ->execute(array(), Doctrine::HYDRATE_ARRAY);
    }

    /**
     * Удалить
     */
    public function executeDelete(sfWebRequest $request)
    {
        $request->chechCSRFProtection();
        $place = $this->getRoute()->getObject();
        $place->delete();

        if ($request->isXmlHttpRequest()) {
            $this->forward('event', 'index');
        }

        $this->redirect('event');
    }
}