<?php

/**
 * ApplicationConfiguration
 */
class frontendConfiguration extends sfApplicationConfiguration
{
    /**
     * Config
     */
    public function configure()
    {
    }

    /**
     * Инициализировать плагины
     *
     * @see ProjectConfiguration::setup
     */
    protected function initPlugins()
    {
        $plugins = array(
            'sfDoctrinePlugin',
            'sfJqueryReloadedPlugin',
            'npAssetsOptimizerPlugin',
            'sfSimpleGoogleSitemapPlugin',
            'myContentPlugin',
            'sfRichMenuPlugin',
            'sfFeedPlugin',
        );

        if ('test' == $this->getEnvironment()) {
            $plugins[] = 'sfPhpunitPlugin';
        }

        $this->enablePlugins($plugins);
    }

    /**
     * Init
     *
     * Все конфиги инициализированы, автозагрузка подключена
     * Фабрики НЕ инициализированы
     */
    public function initialize()
    {
        $dispatcher = $this->getEventDispatcher();
        $this->dispatcher->connect('context.load_factories', array($this, 'onLoad'));
    }

    /**
     * Обработчик context.load_factories
     * Приложение полностью инициализировано перед обработкой запроса
     */
    public function onLoad(sfEvent $event)
    {
        include(sfContext::getInstance()->getConfigCache()->checkConfig('config/domain.yml'));
    }


    /**
     * Настройки Doctrine
     */
    public function configureDoctrine(Doctrine_Manager $manager)
    {
        parent::configureDoctrine($manager);

        if ('test' == $this->getEnvironment()) {
            $manager->setAttribute(Doctrine::ATTR_RESULT_CACHE, new Doctrine_Cache_Array());
            $manager->setAttribute(Doctrine::ATTR_RESULT_CACHE_LIFESPAN, 0);
        } else {
            $cacheDriver = new Doctrine_Cache_Memcache(array(
                 'servers'     => array(
                    'host'       => 'localhost',
                    'port'       => 11211,
                    'persistent' => true
                ),
                 'compression' => true,
            ));

            $manager->setAttribute(Doctrine::ATTR_RESULT_CACHE, $cacheDriver);
            $manager->setAttribute(Doctrine::ATTR_RESULT_CACHE_LIFESPAN, 3600); // 1h

            $manager->setAttribute(Doctrine::ATTR_QUERY_CACHE, $cacheDriver);
            $manager->setAttribute(Doctrine::ATTR_QUERY_CACHE_LIFESPAN, 600); // 10m
        }
    }

}
