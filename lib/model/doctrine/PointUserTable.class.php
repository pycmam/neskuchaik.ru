<?php

/**
 * Связь точка-юзер
 */
class PointUserTable extends Doctrine_Table
{
    /**
     * Instance
     *
     * @return PointUserTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PointUser');
    }
}