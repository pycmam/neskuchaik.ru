<?php

/**
 * Event filter form.
 *
 * @package    change me
 * @subpackage filter
 * @author     pycmam <pycmam@gmail.com>
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EventFormFilter extends BaseEventFormFilter
{
    /**
     * @see PointFormFilter
     */
    public function configure()
    {
        parent::configure();

        $this->widgetSchema['place_id'] = new sfWidgetFormDoctrineChoice(array(
            'model' => $this->getRelatedModelName('Place'),
            'add_empty' => true,
        ));
        $this->validatorSchema['place_id'] = new sfValidatorDoctrineChoice(array(
            'required' => false,
            'model' => $this->getRelatedModelName('Place'),
            'column' => 'id',
        ));

        $this->useFields(array('title', 'description', 'place_id', 'user_id'));
    }

    public function addPlaceIdColumnQuery(Doctrine_Query $query, $field, $values)
    {
        $query->andWhere($query->getRootAlias() . '.place_id = ?', $values);
    }
}
