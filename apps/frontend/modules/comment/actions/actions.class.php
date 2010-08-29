<?php

/**
 * Комменты
 */
class commentActions extends sfActions
{
    /**
     * Лента комментов
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->executeNew();

        $this->pager = new sfDoctrinePager('Comment', sfConfig::get('app_comments_per_page', 10));
        $this->pager->setQuery(CommentTable::getInstance()->queryByPoint($this->point->getId()));
        $this->pager->setPage($request->getParameter('page'));
        $this->pager->init();
    }


    /**
     * Добавить коммент
     */
    public function executeNew()
    {
        $this->point = $this->getRoute()->getObject();
        $user = $this->getUser()->getGuardUser();

        $comment = new Comment();
        $comment->setUser($user);
        $comment->setPoint($this->point);

        $this->form = new CommentForm($comment);
    }


    /**
     * Создать
     */
    public function executeCreate(sfWebRequest $request)
    {
        $this->executeNew();

        $this->form->bind($request->getParameter($this->form->getName()));
        if ($this->form->isValid()) {
            $comment = $this->form->save();
        }

        if (! $this->form->hasErrors()) {
            if ($request->isXmlHttpRequest()) {
                $this->executeIndex($request);
                return $this->setTemplate('index');
            } else {
                return $this->redirect('comment', $this->point);
            }
        }

        $this->setTemplate('new');
    }


    /**
     * Удалить
     */
    public function executeDelete(sfWebRequest $request)
    {
        $comment = $this->getRoute()->getObject();
        $point = $comment->getPoint();
        $comment->delete();

        $this->redirect('comment', $point);
    }
}