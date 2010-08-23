<?php

/**
 * Комментарии
 */
class CommentTable extends Doctrine_Table
{

    public static function getInstance()
    {
        return Doctrine_Core::getTable('Comment');
    }

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
}