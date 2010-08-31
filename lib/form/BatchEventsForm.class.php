<?php

/**
 * Пакетное добавление событий
 */
class BatchEventsForm extends BaseForm
{
    private
        $_items = array();

    /**
     * Конструктор
     *
     * @param  array $items
     * @param sfGuardUser $user
     * @param Place $place
     */
    public function __construct(array $items)
    {
        $this->_items = $items;

        parent::__construct();
    }


    /**
     * SetUp
     */
    public function setup()
    {
        foreach ($this->_items as $i => $item) {
            $event = new Event();
            $event->fromArray($item);
            $form = new EventBatchForm($event);
            $form->getWidgetSchema()->setFormFormatterName('Inline');

            $this->embedForm($i, $form);
        }

        $this->widgetSchema->setNameFormat('events[%s]');
        $this->validatorSchema->setOption('allow_extra_fields', true);

        $this->disableLocalCSRFProtection();
    }
}
