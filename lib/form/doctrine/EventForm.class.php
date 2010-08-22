<?php

/**
 * Event form.
 *
 * @package    change me
 * @subpackage form
 * @author     pycmam <pycmam@gmail.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EventForm extends BaseEventForm
{
    /**
    * @see PointForm
    */
    public function configure()
    {
        parent::configure();

        $this->widgetSchema['place_id'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['fire_at'] = new sfWidgetFormInput();

        $this->useFields(array('title', 'icon', 'description', 'fire_at', 'geo_lat', 'geo_lng', 'place_id'));

        $this->setDefault('fire_at', date('d.m.Y', strtotime('+1 day')) . ' 12:00');

        $this->widgetSchema->setNameFormat('point[%s]');
    }

    /**
     * Загрузка значений формы из объекта
     */
    public function updateDefaultsFromObject()
    {
        if (! $this->object->isNew()) {
            $this->setDefault('fire_at', date('d.m.Y H:i', strtotime($this->object->getFireAt())));
        }

        parent::updateDefaultsFromObject();
    }
}
