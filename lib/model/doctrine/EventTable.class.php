<?php

/**
 * События
 */
class EventTable extends PointTable
{
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Event');
    }

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
        return $this->createQuery($alias)
            ->leftJoin($alias . '.Place pl')
            ->where($alias . '.fire_at BETWEEN ? AND ?', array(
                date('Y-m-d H:i:s', strtotime($date . ' 00:00:00')),
                date('Y-m-d H:i:s', strtotime($date . ' 23:59:59')),
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
            $q = $this->createQuery('a');
        }

        return $q->andWhere($q->getRootAlias() . '.is_active = 1')
            ->andWhere($q->getRootAlias() . '.fire_at > NOW()');
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
}