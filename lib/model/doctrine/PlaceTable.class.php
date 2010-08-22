<?php


class PlaceTable extends PointTable
{
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Place');
    }

    public function createQuery($alias = 'a')
    {
        return parent::createQuery($alias)
            ->orderBy($alias . '.created_at DESC');
    }
}