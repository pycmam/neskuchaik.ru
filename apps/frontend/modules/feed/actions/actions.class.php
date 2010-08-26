<?php

/**
 * Feed-ленты
 */
class feedActions extends sfActions
{
    /**
     * Места
     */
    public function executePlaces()
    {
        $places = PlaceTable::getInstance()->queryFeed()
            ->limit(sfConfig::get('app_feeds_places_count', 30))
            ->execute(array(), Doctrine::HYDRATE_ARRAY);

        $this->buildFeed($places, array(
            'title' => 'Новые места | НеСкучайк!',
            'permalink_url' => 'place_show',
        ));
    }

    /**
     * События
     */
    public function executeEvents()
    {
        $events = EventTable::getInstance()->queryFeed()
            ->limit(sfConfig::get('app_feeds_events_count', 30))
            ->execute(array(), Doctrine::HYDRATE_ARRAY);

        $this->buildFeed($events, array(
            'title' => 'События | НеСкучайк!',
            'permalink_url' => 'event_show',
        ));
    }

    /**
     * Комментарии к чему-то
     */
    public function executeComments()
    {
        $point = $this->getRoute()->getObject();

        $comments = CommentTable::getInstance()->queryFeed()
            ->andWhere('c.point_id = ?', $point->id)
            ->limit(sfConfig::get('app_feeds_comments_count', 30))
            ->execute(array(), Doctrine::HYDRATE_ARRAY);

        $this->buildFeed($comments, array(
            'title' => sprintf('Комментарии к "%s" | НеСкучайк!', $point->title),
            'permalink_url' => 'comment',
            'permalink_param_name' => 'id',
            'permalink_param_column' => 'point_id',
        ));
    }

    /**
     * Последние комментарии
     */
    public function executeLastComments()
    {
        $comments = CommentTable::getInstance()->queryFeed()
            ->limit(sfConfig::get('app_feeds_last_comments_count', 30))
            ->execute(array(), Doctrine::HYDRATE_ARRAY);

        $this->buildFeed($comments, array(
            'title' => 'Последние комментарии | НеСкучайк!',
            'permalink_url' => 'comment',
            'permalink_param_name' => 'id',
            'permalink_param_column' => 'point_id',
        ));
    }

    /**
     * События какого-то места
     */
    public function executePlaceEvents()
    {
        $place = $this->getRoute()->getObject();

        $events = EventTable::getInstance()->queryFeed()
            ->andWhere('a.place_id = ?', $place->id)
            ->limit(sfConfig::get('app_feeds_events_count', 30))
            ->execute(array(), Doctrine::HYDRATE_ARRAY);

        $this->buildFeed($events, array(
            'title' => sprintf('События в %s | НеСкучайк!', $place->title),
            'permalink_url' => 'event_show',
        ));
    }

    /**
     * События какого-то юзера
     */
    public function executeUserEvents()
    {
        $user = $this->getRoute()->getObject();

        $events = EventTable::getInstance()->queryFeed()
            ->andWhere('a.user_id = ?', $user->id)
            ->limit(sfConfig::get('app_feeds_events_count', 30))
            ->execute(array(), Doctrine::HYDRATE_ARRAY);

        $this->buildFeed($events, array(
            'title' => sprintf('События пользователя %s | НеСкучайк!', $user->username),
            'permalink_url' => 'event_show',
        ));
    }

    /**
     * Создать ленту
     *
     * @param array $rows
     * @param array $parameters
     *
     * @return sfFeed
     */
    private function buildFeed(array $rows, array $parameters)
    {
        // default parameters
        $parameters = array_merge(sfConfig::get('app_feeds_default_parameters', array()), $parameters);

        $feed = sfFeed::newInstance($parameters['feed_type']);

        $feed->setTitle($parameters['title']);
        $feed->setLink($parameters['link']);
        $feed->setAuthorName($parameters['author_name']);

        if (isset($parameters['author_email'])) {
            $feed->setAuthorEmail($parameters['author_email']);
        }

        foreach ($rows as $row) {
            $item = new sfFeedItem();
            $item->setTitle($row['title']);
            $item->setAuthorName($row['author_name']);

            if (isset($parameters['permalink_url'])) {
                $item->setLink(sprintf('@%s?%s=%s', $parameters['permalink_url'], $parameters['permalink_param_name'], $row[$parameters['permalink_param_column']]));
            }

            if (isset($row['author_email'])) {
                $item->setAuthorEmail($row['author_email']);
            }

            $item->setPubdate(strtotime($row['created_at']) - date('Z', strtotime($row['created_at'])));
            $item->setUniqueId($row['id']);
            $item->setDescription($row['description']);

            $feed->addItem($item);
        }

        $this->feed = $feed;
        $this->getContext()->getResponse()->setContentType($feed->getContentType());
        $this->setTemplate('feed');
    }
}