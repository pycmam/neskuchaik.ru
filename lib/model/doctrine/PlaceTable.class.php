<?php

/**
 * Место
 */
class PlaceTable extends PointTable
{
    /**
     * Instance
     *
     * @return PlaceTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Place');
    }

    /**
     * Добавление сортировки по дате создания
     *
     * @param string $alias
     * @return Doctrine_Query
     */
    public function createQuery($alias = 'a')
    {
        return parent::createQuery($alias)
            ->orderBy($alias . '.created_at DESC');
    }
}