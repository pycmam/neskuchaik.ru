<?php

/**
 * Уведомления
 */
class MessageTable extends myBaseTable
{

    public static function getInstance()
    {
        return Doctrine_Core::getTable('Message');
    }
}