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
     * Добавление сортировки по дате начала
     *
     * @param string $alias
     * @return Doctrine_Query
     */
    public function createQuery($alias = 'a')
    {
        return parent::createQuery($alias)
            ->orderBy($alias . '.fire_at ASC');
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
             ));
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

        return $q->andWhere($q->getRootAlias() . '.is_active = 1')
            ->andWhere($q->getRootAlias() . '.fire_at > ?', date('Y-m-d H:i:s'));
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
        return  $this->queryActive($q = parent::queryFeed())
            ->orderBy($q->getRootAlias() . '.fire_at ASC');
    }
}