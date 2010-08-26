<?php
require_once dirname(__FILE__).'/../../bootstrap/all.php';


/**
 * event
 */
class frontend_eventTest extends myFunctionalTestCase
{
    public function testSecurity()
    {
        $this->browser
            ->getAndCheck('event', 'new', $this->generateUrl('event_new'), 404);
    }

    public function testCreate()
    {
        $user = $this->authenticateUser();
        $place = $this->helper->makePlace($user, true);

        $data = array(
            'title' => $this->helper->makeText('title'),
            'description' => $this->helper->makeText('description'),
            'fire_at' => date('Y-m-d H:i:s'),
            'geo_lat' => 50,
            'geo_lng' => 50,
        );

        $this->browser
            // test normal
            ->getAndCheck('event', 'new', $this->generateUrl('event_new'), 200)
                ->click('Сохранить', array('point' => $data))
                ->with('request')->checkModuleAction('event', 'create')
                ->with('form')->hasErrors(0)
                ->with('response')->isStatusCode(302)
            // test ajax
            ->getAndCheck('event', 'new', $this->generateUrl('event_new'), 200)
                ->setHttpHeader('X-Requested-With', 'XMLHttpRequest')
                ->click('Сохранить', array('point' => $data))
                ->with('request')->checkModuleAction('event', 'create')
                ->with('form')->hasErrors(0)
                ->with('response')->isStatusCode(200)
                ->with('model')->check('Event', $data, 2)
            // test add to place
            ->getAndCheck('event', 'new', $this->generateUrl('event_new', array('place' => $place->id)), 200)
                ->click('Сохранить', array('point' => $data))
                ->with('request')->checkModuleAction('event', 'create')
                ->with('form')->hasErrors(0)
                ->with('model')->check('Event', $data + array('place_id' => $place->id), 1);
    }

    public function testShow()
    {
        $user = $this->helper->makeUser(true);
        $event = $this->helper->makeEvent($user, true);

         $this->browser
            ->getAndCheck('event', 'show', $this->generateUrl('event_show', $event), 200);
    }

    public function testFollowing()
    {
        $user = $this->authenticateUser();
        $event = $this->helper->makeEvent($user, true);

        $this->browser
            // show
            ->getAndCheck('event', 'show', $this->generateUrl('event_show', $event), 200)
            // follow
            ->setHttpHeader('X-Requested-With', 'XMLHttpRequest')
            ->post($this->generateUrl('event_follow', $event))
                ->with('request')->checkModuleAction('event', 'follow')
                ->with('response')->isStatusCode(200)
                ->with('model')->check('PointUser', array(
                    'point_id' => $event->id,
                    'user_id' => $user->id,
                ), 1)
            // unfollow
            ->setHttpHeader('X-Requested-With', 'XMLHttpRequest')
            ->post($this->generateUrl('event_unfollow', $event))
                ->with('request')->checkModuleAction('event', 'unfollow')
                ->with('response')->isStatusCode(200)
                ->with('model')->check('PointUser', array(
                    'point_id' => $event->id,
                    'user_id' => $user->id,
                ), 0);
    }
}
