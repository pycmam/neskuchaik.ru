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
        $this->places = PlaceTable::getInstance()
            ->queryWithCount(null, 'p')
            ->execute()
            ->getData();
    }

    /**
     * Показать
     */
    public function executeShow()
    {
        $this->place = $this->getRoute()->getObject();
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
        $this->setTemplate('new');
        return $this->processForm($this->form, $request);
    }

    /**
     * Редактировать
     */
    public function executeEdit()
    {
        $this->place = $this->getRoute()->getObject();
        $this->form = new PlaceForm($this->place);
    }

    /**
     * Обновить
     */
    public function executeUpdate(sfWebRequest $request)
    {
        $this->executeEdit();
        $this->setTemplate('edit');
        return $this->processForm($this->form, $request);
    }

    /**
     * Обработка формы
     *
     * @param PlaceForm $form
     * @param sfWebRequest $request
     */
    protected function processForm(PlaceForm $form, sfWebRequest $request)
    {
        $form->bind($request->getParameter($form->getName()));

        if ($form->isValid()) {
            $place = $form->save();

            if ($request->isXmlHttpRequest()) {
                $place = PlaceTable::getInstance()
                    ->queryWithCount(null, 'e')
                    ->where('e.id = ?', $place->id)
                    ->fetchOne();

                return $this->renderPartial('place/show', array('place' => $place));
            } else {
                return $this->redirect('place_show', $place);
            }
        }

        return sfView::SUCCESS;
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
     * Скрипт инициализации маркеров на карте
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