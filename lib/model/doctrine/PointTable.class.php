<?php

/**
 * Точка на карте, базовый класс
 */
class PointTable extends myBaseTable
{
    /**
     * Instance
     *
     * @return PointTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Point');
    }

    /**
     * Активные точки
     *
     * @param Doctrine_Query $q
     * @return Doctrine_Query
     */
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
     * Запрос с подсчетом количества фото и комментов
     *
     * @param Doctrine_Query $q
     * @param string $alias
     * @return Doctrine_Query
     */
    public function queryWithCount(Doctrine_Query $q = null, $alias = 'a')
    {
        if (is_null($q)) {
            $q = $this->createQuery($alias);
        }

        $alias = $q->getRootAlias();

        return $q->select($alias . '.*, COUNT(DISTINCT img.id) as IMAGES_COUNT, COUNT(DISTINCT com.id) as COMMENTS_COUNT')
            ->leftJoin($alias . '.Images img')
            ->leftJoin($alias . '.Comments com')
            ->groupBy($alias . '.id');
    }

    /**
     * Выборка с подсчетом количества фото и комментов
     *
     * @param Doctrine_Query $q
     * @param string $alias
     * @return Doctrine_Сollection
     */
    public function getWithCount(Doctrine_Query $q = null, $alias = 'a')
    {
        return $this->queryWithCount($q, $alias)
            ->execute();
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