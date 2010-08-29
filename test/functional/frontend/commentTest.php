<?php
require_once dirname(__FILE__).'/../../bootstrap/all.php';


/**
 * comment
 */
class frontend_commentTest extends myFunctionalTestCase
{
    public function testIndex()
    {
        $user = $this->helper->makeUser(true);
        $place = $this->helper->makePlace($user, true);

        $comment1 = $this->helper->makeComment($place, $user, true);
        $comment2 = $this->helper->makeComment($place, $user, true);

        // noise
        $event = $this->helper->makeEvent($user, true);
        $this->helper->makeComment($event, $user, true);

        $this->browser
            // comments list
            ->getAndCheck('comment', 'index', $this->generateUrl('comment', $place), 200)
                ->with('response')->begin()
                    ->checkElement('.comments .comment', 2)
                    ->checkElement('#comment-' . $comment1->id, 1)
                    ->checkElement('#comment-' . $comment2->id, 1)
                ->end();
    }


    public function testActions()
    {
        $user = $this->authenticateUser();
        $place = $this->helper->makePlace($user, true);

        $this->browser
            // list
            ->getAndCheck('comment', 'index', $this->generateUrl('comment', $place), 200)
                ->with('response')->checkElement('.comments .comment', 0)
            // send comment
            ->setHttpHeader('X-Requested-With', 'XMLHttpRequest')
            ->click('Отправить', array('comment' => array(
                'comment' => $commentText = $this->helper->makeText('comment'),
            )))
            ->with('request')->checkModuleAction('comment', 'create')
            //->with('form')->hasErrors(0)
            ->with('response')->begin()
                ->isStatusCode(200)
                ->checkElement('.comments .comment', 1)
            ->end()
            ->with('model')->check('Comment', array(
                'point_id' => $place->id,
                'user_id' => $user->id,
                'comment' => $commentText,
            ), 1);
    }

    public function testDelete()
    {
        $user = $this->authenticateUser();
        $place = $this->helper->makePlace($user, true);
        $comment = $this->helper->makeComment($place, $user, true);
        $comment_restrict = $this->helper->makeComment($place, $this->helper->makeUser(true), true);

        $this->browser
            ->post($this->generateUrl('comment_delete', $comment))
            ->with('request')->checkModuleAction('comment', 'delete')
            ->with('response')->isStatusCode(302)
            ->with('model')->check('Comment', array('id' => $comment->id), 0)
            ->post($this->generateUrl('comment_delete', $comment_restrict))
            ->with('response')->isStatusCode(404)
            ->with('model')->check('Comment', array('id' => $comment_restrict->id), 1);

    }
}
