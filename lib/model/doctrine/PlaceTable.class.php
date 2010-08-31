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

}