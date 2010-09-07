<?php

/**
 * События
 */
class eventActions extends sfActions
{
    /**
     * События
     */
    public function executeIndex(sfWebRequest $request)
    {
        $date = $request->getParameter('date', date('Y-m-d'));

        $dates = array(
            'today' => date('Y-m-d'),
            'tomorrow' => date('Y-m-d', strtotime('+1 day')),
            'datomorrow' => date('Y-m-d', strtotime('+2 days')),
        );

        $this->events = EventTable::getInstance()
            ->queryByDate(isset($dates[$date]) ? $dates[$date] : $date)
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
        $this->setTemplate('new');
        return $this->processForm($this->form, $request);
    }

    /**
     * Редактировать
     */
    public function executeEdit()
    {
        $this->event = $this->getRoute()->getObject();
        $this->form = new EventForm($this->event);
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
     * @param EventForm $form
     * @param sfWebRequest $request
     */
    protected function processForm(EventForm $form, sfWebRequest $request)
    {
        $form->bind($request->getParameter($form->getName()));

        if ($form->isValid()) {
            $event = $form->save();

            if ($request->isXmlHttpRequest()) {

                $event = EventTable::getInstance()
                    ->queryWithCount(null, 'e')
                    ->where('e.id = ?', $event->id)
                    ->fetchOne();

                return $this->renderPartial('event/show', array('event' => $event));
            } else {
                return $this->redirect('event_show', $event);
            }
        }

        return sfView::SUCCESS;
    }

    /**
     * Я иду!
     */
    public function executeFollow(sfWebRequest $request)
    {
        $event = $this->getRoute()->getObject();
        $user = $this->getUser()->getGuardUser();

        if (! $event->hasFollower($user->id)) {
            $accept = new PointUser();
            $accept->setPoint($event);
            $accept->setUser($user);
            $accept->save();
        }

        if ($request->isXmlHttpRequest()) {
            return $this->renderPartial('event/show', array(
                'event' => $event,
                'move' => false, // не дергать карту
            ));
        } else {
            return $this->redirect('event_show', $event);
        }
    }

    /**
     * Я передумал :-/
     */
    public function executeUnfollow(sfWebRequest $request)
    {
        $event = $this->getRoute()->getObject();
        $user = $this->getUser()->getGuardUser();

        if ($accept = $event->hasFollower($user->id)) {
            $accept->delete();
        }

        // обновить событие
        $event = EventTable::getInstance()->findOneById($event->id);

        if ($request->isXmlHttpRequest()) {
            return $this->renderPartial('event/show', array(
                'event' => $event,
                'move' => false, // не дергать карту
            ));
        } else {
            return $this->redirect('event_show', $event);
        }
    }


    /**
     * Удалить
     */
    public function executeDelete(sfWebRequest $request)
    {
        $request->chechCSRFProtection();
        $event = $this->getRoute()->getObject();
        $event->delete();

        if ($request->isXmlHttpRequest()) {
            $this->forward('event', 'index');
        }

        $this->redirect('event');
    }
}