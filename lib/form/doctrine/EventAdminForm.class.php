<?php

class EventAdminForm extends EventForm
{
    public function configure()
    {
        parent::configure();

        $this->widgetSchema['gmap'] = new myWidgetFormGoogleMap();
        $this->validatorSchema['gmap'] = new sfValidatorString();

        $this->widgetSchema['fire_at']->setAttribute('class', 'datepicker');

        $this->useFields(array('title', 'icon', 'description', 'fire_at', 'place_id', 'gmap'));
    }

    /**
     * Загрузка значений формы из объекта
     */
    public function updateDefaultsFromObject()
    {
        parent::updateDefaultsFromObject();

        $point = $this->getObject();

        // координаты
        if ($point->getGeoLat() && $point->getGeoLng()) {
            $this->setDefault('gmap', sprintf('%s,%s', $point->getGeoLat(), $point->getGeoLng()));
        }
    }


    /**
     * Обновление записи
     *
     * @param array $values
     */
    protected function doUpdateObject($values)
    {
        // координаты объекта
        if ($values['gmap']) {
            $coords = explode(',', $values['gmap'], 2);
            if (count($coords) == 2) {
                $values['geo_lat'] = $coords[0];
                $values['geo_lng'] = $coords[1];
            }
        }

        parent::doUpdateObject($values);
    }
}