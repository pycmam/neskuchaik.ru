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
     * Запрос с подсчетом количества фото и комментов
     *
     * @param Doctrine_Query $q
     * @param string $alias
     * @return Doctrine_Query
     */
    public function queryWithCount(Doctrine_Query $q = null, $alias = 'a')
    {
        return parent::queryWithCount($q, $alias)
            ->orderBy($alias . '.title')
            ->addOrderBy($alias . '.created_at DESC');
    }

}