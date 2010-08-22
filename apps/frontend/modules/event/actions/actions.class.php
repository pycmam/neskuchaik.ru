<?php

class eventActions extends sfActions
{
    /**
     * События
     */
    public function executeIndex(sfWebRequest $request)
    {
        $date = $request->getParameter('date', date('d.m.Y'));

        $this->events = EventTable::getInstance()
            ->queryByDate($date)
            ->execute()
            ->getData();
    }

    /**
     * Просмотр события
     */
    public function executeShow(sfWebRequest $request)
    {
        $this->event = $this->getRoute()->getObject();
    }


    /**
     * Добавить
     */
    public function executeNew(sfWebRequest $request)
    {
        $user = $this->getUser()->getGuardUser();

        $this->event = new Event();
        $this->event->setUser($user);
        $this->event->setFireAt(date('Y-m-d H:i:s'));

        if ($request->hasParameter('place') && $placeId = (int) $request->getParameter('place')) {
            $this->place = PlaceTable::getInstance()->findOneById($placeId);
            $this->forward404Unless($this->place);
            $this->event->setPlace($this->place);
            $this->event->setGeoLat($this->place->getGeoLat());
            $this->event->setGeoLng($this->place->getGeoLng());
        } else {
            $this->event->setGeoLat($request->getParameter('geo_lat'));
            $this->event->setGeoLng($request->getParameter('geo_lng'));
        }

        $this->form = new EventForm($this->event);
    }

    /**
     * Создать
     */
    public function executeCreate(sfWebRequest $request)
    {
        $this->executeNew($request);

        $this->form->bind($request->getParameter($this->form->getName()));
        if ($this->form->isValid()) {
            $event = $this->form->save();
        }

        if (! $this->form->hasErrors()) {
            if ($request->isXmlHttpRequest()) {
                return $this->renderPartial('event/show', array('event' => $event));
            } else {
                return $this->redirect('event_show', $event);
            }
        }

        $this->setTemplate('new');
    }
}