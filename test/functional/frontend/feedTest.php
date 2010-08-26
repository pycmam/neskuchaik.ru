<?php
require_once dirname(__FILE__).'/../../bootstrap/all.php';


/**
 * Feeds
 */
class frontend_feedTest extends myFunctionalTestCase
{
    public function testFeeds()
    {
        $user = $this->helper->makeUser(true);

        $place1 = $this->helper->makePlace($user, true);
        $place2 = $this->helper->makePlace($user, true);
        $event = $this->helper->makeEvent($user, true);

        // places event
        $place_event = $this->helper->makeEvent($user, true, array('place_id' => $place1->id));

        // comments
        $this->helper->makeComment($place1, $user, true);
        $this->helper->makeComment($place2, $user, true);
        $this->helper->makeComment($event, $user, true);

        $this->browser
            ->getAndCheck('feed', 'lastComments', $this->generateUrl('feed_last_comments'), 200)
                ->with('response')->begin()
                    ->checkElement(sprintf('entry link[href="%s"]', $this->generateUrl('comment', $place1, true)), 1)
                    ->checkElement(sprintf('entry link[href="%s"]', $this->generateUrl('comment', $place2, true)), 1)
                    ->checkElement(sprintf('entry link[href="%s"]', $this->generateUrl('comment', $event, true)), 1)
                ->end()

            ->getAndCheck('feed', 'comments', $this->generateUrl('feed_comments', $place1), 200)
                ->with('response')->begin()
                    ->checkElement('entry', 1)
                    ->checkElement(sprintf('entry link[href="%s"]', $this->generateUrl('comment', $place1, true)), 1)
                ->end()

            ->getAndCheck('feed', 'comments', $this->generateUrl('feed_comments', $event), 200)
                ->with('response')->begin()
                    ->checkElement('entry', 1)
                    ->checkElement(sprintf('entry link[href="%s"]', $this->generateUrl('comment', $event, true)), 1)
                ->end()

            ->getAndCheck('feed', 'places', $this->generateUrl('feed_places'), 200)
                ->with('response')->begin()
                    ->checkElement(sprintf('entry link[href="%s"]', $this->generateUrl('place_show', $place1, true)), 1)
                    ->checkElement(sprintf('entry link[href="%s"]', $this->generateUrl('place_show', $place2, true)), 1)
                ->end()

            ->getAndCheck('feed', 'events', $this->generateUrl('feed_events'), 200)
                ->with('response')->begin()
                    ->checkElement(sprintf('entry link[href="%s"]', $this->generateUrl('event_show', $event, true)), 1)
                ->end()

            ->getAndCheck('feed', 'placeEvents', $this->generateUrl('feed_place_events', $place1), 200)
                ->with('response')->begin()
                    ->checkElement('entry', 1)
                    ->checkElement(sprintf('entry link[href="%s"]', $this->generateUrl('event_show', $place_event, true)), 1)
                ->end()

            ->getAndCheck('feed', 'placeEvents', $this->generateUrl('feed_place_events', $place2), 200)
                ->with('response')->checkElement('entry', 0)

            ->getAndCheck('feed', 'userEvents', $this->generateUrl('feed_user_events', $user), 200)
                ->with('response')->begin()
                    ->checkElement('entry', 2)
                    ->checkElement(sprintf('entry link[href="%s"]', $this->generateUrl('event_show', $event, true)), 1)
                    ->checkElement(sprintf('entry link[href="%s"]', $this->generateUrl('event_show', $place_event, true)), 1)
                ->end();
    }
}
