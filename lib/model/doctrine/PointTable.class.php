<?php


class PointTable extends myBaseTable
{

    public static function getInstance()
    {
        return Doctrine_Core::getTable('Point');
    }

    public function queryActive(Doctrine_Query $q = null)
    {
        if (is_null($q)) {
            $q = $this->createQuery('a');
        }

        $alias = $q->getRootAlias();

        return $q->andWhere($alias . '.model = ?', 'place')
            ->orWhere(sprintf('(%1$s.model = ? AND %1$s.fire_at > NOW() AND %1$s.place_id IS NULL)', $alias), 'event');
    }

    /**
     * Запрос для формирования feed-ленты
     *
     * @return Doctrine_Query
     */
    public function queryFeed()
    {
        return $this->createQuery('a')
            ->select('a.*, u.username as author_name')
            ->leftJoin('a.User u')
            ->orderBy('a.created_at DESC');
    }
}