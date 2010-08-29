<?php

/**
 * Комментарии
 */
class CommentTable extends myBaseTable
{

    /**
     * Instance
     *
     * @return CommentTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Comment');
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
            ->orderBy($alias . '.created_at DESC');
    }

    /**
     * Запрос комментов объекта
     *
     * @param integer $pointId
     * @return Doctrine_Query
     *
     */
    public function queryByPoint($pointId)
    {
        return $this->createQuery('a')
            ->leftJoin('a.User u')
            ->where('a.point_id = ?', (int) $pointId);
    }

    /**
     * Запрос для формирования feed-ленты
     *
     * @return Doctrine_Query
     */
    public function queryFeed()
    {
        return $this->createQuery('c')
            ->select('c.*, p.id as point_id, p.title as title, c.comment as description, u.username as author_name')
            ->leftJoin('c.User u')
            ->leftJoin('c.Point p')
            ->orderBy('c.created_at DESC');
    }
}