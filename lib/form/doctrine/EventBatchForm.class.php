<?php

class EventBatchForm extends EventForm
{
    public function configure()
    {
        parent::configure();

        $this->widgetSchema['title'] = new sfWidgetFormTextarea();

        unset($this['id'], $this['geo_lat'], $this['geo_lng'], $this['place_id']);

        $this->useFields(array('title', 'description', 'fire_at'));
        $this->disableLocalCSRFProtection();
    }
}