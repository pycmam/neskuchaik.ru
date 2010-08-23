<?php

/**
 * Пользователи
 */
class userActions extends sfActions
{
    /**
     * Список пользователей
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->users = sfGuardUserTable::getInstance()
            ->createQuery('u')
            ->where('u.is_active = 1')
            ->orderBy('u.username ASC')
            ->execute()
            ->getData();
    }

    /**
     * Инфа пользователя
     */
    public function executeShow(sfWebRequest $request)
    {
        $this->user = $this->getRoute()->getObject();
    }
}