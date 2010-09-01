<?php

/**
 * Шаблоны уведомлений
 */
class MessageTemplateTable extends myBaseTable
{

    public static function getInstance()
    {
        return Doctrine_Core::getTable('MessageTemplate');
    }
}