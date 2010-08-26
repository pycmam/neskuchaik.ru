<?php
require_once dirname(__FILE__).'/../../bootstrap/all.php';


/**
 * place
 */
class frontend_placeTest extends myFunctionalTestCase
{
    public function testSecurity()
    {
        $this->browser
            ->getAndCheck('place', 'new', $this->generateUrl('place_new'), 404);
    }

    public function testCreate()
    {
        $user = $this->authenticateUser();

        $data = array(
            'title' => $this->helper->makeText('title'),
            'description' => $this->helper->makeText('description'),
            'geo_lat' => 50,
            'geo_lng' => 50,
        );

        $this->browser
            // test normal
            ->getAndCheck('place', 'new', $this->generateUrl('place_new'), 200)

                ->click('Сохранить', array('point' => $data))
                ->with('request')->checkModuleAction('place', 'create')
                ->with('form')->hasErrors(0)
                ->with('response')->isStatusCode(302)
            // test ajax
            ->getAndCheck('place', 'new', $this->generateUrl('place_new'), 200)
                ->setHttpHeader('X-Requested-With', 'XMLHttpRequest')
                ->click('Сохранить', array('point' => $data))
                ->with('request')->checkModuleAction('place', 'create')
                ->with('form')->hasErrors(0)
                ->with('response')->isStatusCode(200)
                ->with('model')->check('Place', $data, 2);
    }

    public function testShow()
    {
        $user = $this->helper->makeUser(true);
        $place = $this->helper->makePlace($user, true);

         $this->browser
            ->getAndCheck('place', 'show', $this->generateUrl('place_show', $place), 200);
    }

    public function testFollowing()
    {
        $user = $this->authenticateUser();
        $place = $this->helper->makePlace($user, true);

        $this->browser
            // follow
            ->setHttpHeader('X-Requested-With', 'XMLHttpRequest')
            ->post($this->generateUrl('place_follow', $place))
                ->with('request')->checkModuleAction('place', 'follow')
                ->with('response')->isStatusCode(200)
                ->with('model')->check('PointUser', array(
                    'point_id' => $place->id,
                    'user_id' => $user->id,
                ), 1)
            // unfollow
            ->setHttpHeader('X-Requested-With', 'XMLHttpRequest')
            ->post($this->generateUrl('place_unfollow', $place))
                ->with('request')->checkModuleAction('place', 'unfollow')
                ->with('response')->isStatusCode(200)
                ->with('model')->check('PointUser', array(
                    'point_id' => $place->id,
                    'user_id' => $user->id,
                ), 0);
    }
}
