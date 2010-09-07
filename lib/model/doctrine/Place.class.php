<?php

/**
 * Place
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    change me
 * @subpackage model
 * @author     pycmam <pycmam@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Place extends BasePlace
{
    /**
     * Актульаные события места
     *
     * @param integer $max
     * @return Doctrine_Collection
     */
    public function getActualEvents($max = false)
    {
        $q = EventTable::getInstance()->queryActive();

        return EventTable::getInstance()
            ->queryWithCount($q)
            ->andWhere($q->getRootAlias() . '.place_id = ?', (int) $this->getId())
            ->limit($max)
            ->execute();
    }
}
