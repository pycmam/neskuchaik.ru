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
                return $this->renderPartial('catalog/show', array('point' => $place));
            } else {
                return $this->redirect('catalog_show', $place);
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
}