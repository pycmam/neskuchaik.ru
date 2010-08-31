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
        $this->widgetSchema['fire_at'] = new sfWidgetFormInput(array(), array(
            'class' => 'datepicker',
        ));
        $this->widgetSchema['iamgoing'] = new sfWidgetFormInputCheckbox();
        $this->validatorSchema['iamgoing'] = new sfValidatorBoolean();
        $this->validatorSchema['title']->setOption('max_length', sfConfig::get('app_event_title_max_length', 60));

        $this->useFields(array('title', 'icon', 'description', 'fire_at', 'iamgoing', 'geo_lat', 'geo_lng', 'place_id'));

        $this->setDefault('fire_at', date('d.m.Y H:i', strtotime('+1 hour')));

        $this->widgetSchema->setNameFormat('point[%s]');
    }

    /**
     * Загрузка значений формы из объекта
     */
    public function updateDefaultsFromObject()
    {
        parent::updateDefaultsFromObject();

        if ($this->object && $this->object->getFireAt()) {
            $this->setDefault('fire_at', date('d.m.Y H:i', strtotime($this->object->getFireAt())));
        }
    }

    protected function doUpdateObject($values)
    {
        // событие перенесено?
        if (strtotime($this->object->getFireAt()) != strtotime($values['fire_at'])) {
            $values['last_fire_at'] = $this->object->getFireAt();
        }

        parent::doUpdateObject($values);

        // "я иду"
        if (isset($values['iamgoing']) && $values['iamgoing']) {
            $user = sfContext::getInstance()->getUser()->getGuardUser();

            if (! $this->object->hasFollower($user->getId())) {
                $accept = new PointUser();
                $accept->setPoint($this->object);
                $accept->setUser($user);
                $accept->save();
            }
        }
    }
}
