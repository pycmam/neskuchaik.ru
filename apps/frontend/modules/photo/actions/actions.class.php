<?php

/**
 * Фотки объектов
 */
class photoActions extends sfActions
{
    /**
     * Фотки объекта
     */
    public function executeIndex()
    {
        $this->point = $this->getRoute()->getObject();
    }

    public function executeEdit()
    {
        $this->point = $this->getRoute()->getObject();
    }
}