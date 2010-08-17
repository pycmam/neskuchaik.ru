<?php


class PlaceTable extends PointTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Place');
    }
}