<?php


class IdentityTable extends myBaseTable
{

    public static function getInstance()
    {
        return Doctrine_Core::getTable('Identity');
    }
}