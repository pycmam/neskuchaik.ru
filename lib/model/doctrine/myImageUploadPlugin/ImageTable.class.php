<?php


class ImageTable extends PluginImageTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Image');
    }
}