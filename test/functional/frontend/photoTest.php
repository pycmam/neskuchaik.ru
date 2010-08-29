<?php
require_once dirname(__FILE__).'/../../bootstrap/all.php';


/**
 * photo
 */
class frontend_photoTest extends myFunctionalTestCase
{
    public function testSecurity()
    {
        $place = $this->helper->makePlace($this->helper->makeUser(true), true);
        $this->browser
            ->getAndCheck('photo', 'edit', $this->generateUrl('photo_edit', $place), 404);
    }

    public function testActions()
    {
        $user = $this->authenticateUser();
        $place = $this->helper->makePlace($user, true);

        $this->browser
            ->getAndCheck('photo', 'index', $this->generateUrl('photo', $place), 200)
            ->getAndCheck('photo', 'edit', $this->generateUrl('photo_edit', $place), 200);
    }
}
