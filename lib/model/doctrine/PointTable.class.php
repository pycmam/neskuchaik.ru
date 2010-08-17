<?php


class PointTable extends myBaseTable
{

    public static function getInstance()
    {
        return Doctrine_Core::getTable('Point');
    }
}