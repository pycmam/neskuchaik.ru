<?php

/**
 * Init
 */
define('DIR', realpath(dirname(__FILE__).'/..'));

require_once DIR . '/lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

require_once DIR . '/lib/config/sfDomainConfigHandler.class.php';

/**
 * ProjectConfiguration
 */
class ProjectConfiguration extends sfProjectConfiguration
{
    /**
     * Массив sfPatternRouting по приложениям
     */
    private $_appRouting = array();


    /**
     * SetUp
     */
    public function setup()
    {
        $this->initPlugins();

        // Escaper
        sfOutputEscaper::markClassesAsSafe(array(
            'sfFeed',
            // some safe classes
        ));
    $this->enablePlugins('sfDoctrineGuardPlugin');
  }


    /**
     * Инициализировать плагины
     */
    protected function initPlugins()
    {
        $this->enableAllPluginsExcept(array('sfPropelPlugin'));
    }


    /**
     * Получить хост для указанного приложения
     *
     * @param  string $appName - Название приложения
     * @return string
     */
    public function getHost($appName)
    {
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';

        // Обрезать поддомены
        if (strpos($host, 'admin.') === 0) {
            $host = substr($host, 6);
        }

        return sprintf(sfConfig::get('app_host_'.$appName), $host);
    }


    /**
     * Получить роутинг для указанного приложения
     *
     * @param  string $appName - Название приложения
     * @return sfPatternRouting
     */
    public function getAppRouting($appName)
    {
        if (!isset($this->appRouting[$appName])) {
            $this->appRouting[$appName] = new sfPatternRouting(new sfEventDispatcher());

            $config = new sfRoutingConfigHandler();
            $routes = $config->evaluate(array(sfConfig::get('sf_apps_dir')."/{$appName}/config/routing.yml"));

            $this->appRouting[$appName]->setRoutes($routes);
        }

        return $this->appRouting[$appName];
    }


    /**
     * Создать URL на основе роутинга указанного приложения
     *
     * @param  string $appName    - Название приложения
     * @param  string $routeName  - Название правила маршрутизации
     * @param  mixed  $parameters - Параметры маршрута
     * @return string
     */
    public function generateAppUrl($appName, $routeName, $parameters = array())
    {
        $host = $this->getHost($appName);

        return 'http://' . $host . sfConfig::get('app_host_script_name')
             . $this->getAppRouting($appName)->generate($routeName, $parameters);
    }


    /**
     * Настройки Doctrine
     */
    public function configureDoctrine(Doctrine_Manager $manager)
    {
        $manager->setAttribute(Doctrine::ATTR_QUERY_CLASS, 'MyQuery');
        $manager->setAttribute(Doctrine::ATTR_USE_DQL_CALLBACKS, true);
        $manager->setAttribute(Doctrine::ATTR_QUOTE_IDENTIFIER, true);
    }

}
