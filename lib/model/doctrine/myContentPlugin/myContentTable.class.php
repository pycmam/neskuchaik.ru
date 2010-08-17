<?php


class myContentTable extends PluginmyContentTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('myContent');
    }
}