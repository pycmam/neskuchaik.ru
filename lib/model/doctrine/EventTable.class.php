<?php

/**
 * Событие
 */
class EventTable extends PointTable
{
    /**
     * Instance
     *
     * @return EventTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Event');
    }

    /**
     * Запрос по дате
     *
     * @param $date
     * @param $alias
     * @return Doctrine_Query
     */
    public function queryByDate($date, $alias = 'a')
    {
        if (date('Y-m-d') == $date) {
            $timeFrom = strtotime($date . date('H:i:s'));
        } else {
            $timeFrom = strtotime($date . ' 00:00:00');
        }

        $timeTo = strtotime($date . ' 23:59:59');

        return $this->createQuery($alias)
            ->leftJoin($alias . '.Place pl')
            ->where($alias . '.fire_at BETWEEN ? AND ?', array(
                date('Y-m-d H:i:s', $timeFrom),
                date('Y-m-d H:i:s', $timeTo),
             ))
             ->orderBy($alias . '.fire_at ASC');;
    }

    /**
     * Запрос актуальных событий
     *
     * @param Doctrine_Query $q
     * @return Doctrine_Query
     */
    public function queryActive(Doctrine_Query $q = null)
    {
        if (is_null($q)) {
            $q = $this->createQuery('a')
                ->leftJoin('a.Comments com');
        }

        $alias = $q->getRootAlias();

        return $q->andWhere($alias . '.is_active = 1')
            ->andWhere($alias . '.fire_at > ?', date('Y-m-d H:i:s'))
            ->orderBy($alias . '.fire_at ASC');;
    }

    /**
     * Выборка актуальных событий
     *
     * @param Doctrine_Query $q
     * @return Doctrine_Collection
     */
    public function getActive(Doctrine_Query $q = null)
    {
        return $this->queryActive($q)->execute();
    }

    /**
     * Запрос для формирования feed-ленты
     *
     * @return Doctrine_Query
     */
    public function queryFeed()
    {
        return  $this->queryActive($q = parent::queryFeed());
    }
}