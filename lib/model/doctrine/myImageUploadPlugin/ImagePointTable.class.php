<?php

/**
 * Фото объектов
 */
class ImagePointTable extends PluginImagePointTable
{
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ImagePoint');
    }

    /**
     * Запрос с выборкой по объекту
     *
     * @param Point $point
     * @return Doctrine_Query
     */
    public function queryByPoint(Point $point)
    {
        $q = $this->createQuery('i')
            ->where('i.point_id = ?', $point->getId());

        return $this->withPrimaryOrder($q, $point);
    }

    /**
     * Возвращает запрос изображений принадлежащих объектам текущего юзера
     *
     * @param Doctrine_Query $q
     * @return Doctrine_Query
     */
    public function queryByOwner(Doctrine_Query $q = null)
    {
        if (is_null($q)) {
            $q = $this->createQuery('i');
        }

        $alias = $q->getRootAlias();
        if ($user = sfContext::getInstance()->getUser()->getGuardUser()) {
            return $q->innerJoin($alias.'.Point p')
                ->addWhere('p.user_id = ?', $user->getId());
        } else {
            throw new sfException(__METHOD__.': Not authenticated');
        }
    }


    /**
     * Возвращает изображения принадлежащие объектам текущего пользователя
     *
     * @param Doctrine_Query $q
     * @return Doctrine_Collection
     */
    public function getByOwner(Doctrine_Query $q = null)
    {
        return $this->queryByOwner($q)->execute();
    }
}