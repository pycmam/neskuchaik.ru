<?php


class EventTable extends PointTable
{
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Event');
    }
}