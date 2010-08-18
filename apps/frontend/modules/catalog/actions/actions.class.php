<?php

class catalogActions extends sfActions
{
    public function executeIndex(sfWebRequest $request)
    {
        $this->all = PointTable::getInstance()->createQuery('a')
            ->where('a.is_active = 1')
            ->orderBy('created_at DESC')
            ->execute();
    }

    public function executeShow(sfWebRequest $request)
    {
        $this->point = $this->getRoute()->getObject();
    }
}