<?php

class myQuery extends Doctrine_Query
{
    /**
     * Кэш-драйвер
     */
    protected static $_cache = null;

    /**
     * Ищет метод в корневой таблице. Если найден, тогда вызывает его и передает
     * себя в качестве первого параметра
     */
    public function __call($method, $arguments)
    {
        $table = $this->getRoot();
        if (method_exists($table, $method)) {
            array_unshift($arguments, $this);
            return call_user_func_array(array($table, $method), $arguments);
        }

        throw new Exception(__CLASS__.": method `{$method}` not found");
    }


    /**
     * Добавить JOIN к таблице переводов
     *
     * @param  string         $alias - алиас к таблице, которую надо перевести
     * @return Doctrine_Query
     */
    public function withI18n($alias = null)
    {
        if (null === $alias) {
            $alias  = $this->getRootAlias();
        }
        $transAlias = $this->getTransAlias($alias);
        //$this->innerJoin("{$alias}.Translation {$transAlias} WITH {$transAlias}.lang = ?",
        $this->leftJoin("{$alias}.Translation {$transAlias} WITH {$transAlias}.lang = ?",
            sfDoctrineRecord::getDefaultCulture());

        return $this;
    }


    /**
     * Получить Alias к таблице переводов
     *
     * @param  Doctrine_Query|string $q - Запрос или алиас к таблице, которую надо перевести
     * @return string
     */
    public function getTransAlias($alias)
    {
        if (is_object($alias) && $alias instanceof Doctrine_Query) {
            $alias = $alias->getRootAlias();
        }
        return $alias . 'trans';
    }


    /**
     * Получить алиас по имени модели используемой в запросе
     *
     * @param  string $model
     * @return string
     */
    public function getAliasByModel($model)
    {
        // Init query
        $this->getRootAlias();

        foreach ($this->getQueryComponents() as $alias => $arrComponent) {
            if ($arrComponent['table']->getClassnameToReturn() == $model) {
                return $alias;
            }
        }

        throw new Exception(__METHOD__.": No component found for model `{$model}`");
    }

    /**
     * Очистить кэш
     *
     * @param string $pattern
     */
    public static function clearCache($pattern)
    {
        if (is_null(self::$_cache)) {
            self::$_cache = new Doctrine_Cache_Memcache(array(
                'servers'     => array(
                    'host'       => 'localhost',
                    'port'       => 11211,
                    'persistent' => true
                ),
                'compression' => false,
            ));
        }

        self::$_cache->delete($pattern);
    }

}
