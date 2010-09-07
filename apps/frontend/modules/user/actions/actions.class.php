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


    /**
     * Редактирование профиля
     */
    public function executeEdit()
    {
        $this->user = $this->getUser()->getGuardUser();
        $this->form = new UserForm($this->user);
    }

    /**
     * Обновление профиля
     */
    public function executeUpdate(sfWebRequest $request)
    {
        $this->executeEdit();
        $this->form->bind($request->getParameter($this->form->getName()));
        if ($this->form->isValid()) {
            $this->form->save();

            $this->success = true;
        }

        $this->setTemplate('edit');
    }
}