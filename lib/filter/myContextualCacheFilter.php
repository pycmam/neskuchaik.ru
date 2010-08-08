<?php

/**
 * Отключить кеш для авторизованных пользователей
 */
class myContextualCacheFilter extends sfFilter
{
    public function execute($filterChain)
    {
        $context = $this->getContext();
        if ($context->getUser()->isAuthenticated()) {
            sfConfig::set('sf_ignore_cache', true);
        }

        // Execute next filter
        $filterChain->execute();
    }
}
