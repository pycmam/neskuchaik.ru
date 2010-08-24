<?php

/**
 * Базовая таблица
 */
class myBaseTable extends Doctrine_Table
{
    /**
     * Грязный хак, без него не работают i18n поля при использовании кэша
     */
    public function construct()
    {
        if ($this->hasTemplate('I18n')) {
            $this->unshiftFilter(new sfDoctrineRecordI18nFilter);
            $this->setOption('has_symfony_i18n_filter', true);
        }
    }


    /**
     * Добавить JOIN к таблице переводов
     *
     * @param  Doctrine_Query $q
     * @param  string         $rootAlias - алиас к таблице, которую надо перевести
     * @return Doctrine_Query
     */
    public function withI18n(Doctrine_Query $q = null, $rootAlias = null)
    {
        if (!$q) {
            $q = $this->createQuery($rootAlias);
        }

        if (!$rootAlias) {
            $rootAlias  = $q->getRootAlias();
        }
        $transAlias = $this->getTranslationQueryAlias($rootAlias);
        $q->leftJoin("{$rootAlias}.Translation {$transAlias} WITH {$transAlias}.lang = ?",
            sfDoctrineRecord::getDefaultCulture());

        return $q;
    }


    /**
     * Получить Alias к таблице переводов
     *
     * @param  Doctrine_Query|string $q - Запрос или алиас к таблице, которую надо перевести
     * @return string
     */
    public function getTranslationQueryAlias($alias)
    {
        if (is_object($alias) && $alias instanceof Doctrine_Query) {
            $alias = $alias->getRootAlias();
        }
        return $alias . 'trans';
    }


    /**
     * Найти объект по первичному ключу с выборкой по I18N
     *
     * @param  Doctrine_Query $q
     * @return Doctrine_Record|null
     */
    public function findOneWithI18n(Doctrine_Query $q)
    {
        // limit(1) включает механизм анализа при наличии join,
        // см doc:"The limit-subquery-algorithm"
        return $this->withI18n($q)->fetchOne();
    }


    /**
     * Проверить, что выборка принадлежит текущему авторизованному пользователю
     *
     * @param  Doctrine_Query $q
     * @param  string         $ownerColumn
     * @return Doctrine_Query
     */
    public function withOwnerCheck(Doctrine_Query $q, $ownerColumn = 'user_id')
    {
        $user = sfContext::getInstance()->getUser();
        if ($user->isAuthenticated()) {
            $userId = $user->getGuardUser()->getId();
        } else {
            $userId = 0;
        }

        $rootAlias = $q->getRootAlias();
        $q->addWhere("{$rootAlias}.{$ownerColumn} = ?", $userId);

        return $q;
    }


    /**
     * Проверить, что выборка принадлежит текущему авторизованному пользователю
     *
     * @param  Doctrine_Query $q
     * @param  string         $ownerColumn
     * @return Doctrine_Collection
     */
    public function getWithOwnerCheck(Doctrine_Query $q, $ownerColumn = 'user_id')
    {
        return $this->withOwnerCheck($q, $ownerColumn)->execute();
    }
}
