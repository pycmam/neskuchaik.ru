<?php

class ImportChoiceForm extends BaseForm
{
    public function configure()
    {
        $importers = array();
        foreach (sfConfig::get('app_import_sources') as $name => $import) {
            $importers[$name] = $import['name'];
        }

        $this->widgetSchema['importer'] = new sfWidgetFormChoice(array(
            'choices' => $importers,
        ));
        $this->validatorSchema['importer'] = new sfValidatorChoice(array(
            'choices' => array_keys($importers),
        ));
        $this->widgetSchema['place_id'] = new sfWidgetFormDoctrineChoice(array(
            'model' => 'Place',
            'query' => PlaceTable::getInstance()
                ->createQuery('p')
                ->orderBy('p.title'),
        ));
        $this->validatorSchema['place_id'] = new sfValidatorDoctrineChoice(array(
            'model' => 'Place',
        ));
        $this->widgetSchema['icon'] = new myWidgetFormIcon(array(
            'icons' => sfConfig::get('app_marker_icons'),
            'path' => '/images/marker',
            'target' => '#icon',
        ));
        $this->validatorSchema['icon'] = new sfValidatorChoice(array(
            'choices' => sfConfig::get('app_marker_icons'),
        ));

        $this->widgetSchema->setNameFormat('import[%s]');
        $this->disableLocalCSRFProtection();
    }
}