<?php

/**
 * Импортирование событий из внешних источников
 */
class importActions extends sfActions
{
    public function executeIndex()
    {
        $this->form = new ImportChoiceForm(array(
            'icon' => 'movie',
        ));
    }

    public function executeImport(sfWebRequest $request)
    {
        $importers = sfConfig::get('app_import_sources');

        $this->config = $request->getParameter('import');

        $this->forward404Unless($importer = $importers[$this->config['importer']]);

        $importer = new $importer['class'];

        $items = $importer->import();

        foreach($items as &$item) {
            $item = array_merge($item, $this->config);
        }

        $this->form = new BatchEventsForm($items);
    }

    public function executeSave(sfWebRequest $request)
    {
        $items = $request->getParameter('events');
        $config = $request->getParameter('config');

        $place = PlaceTable::getInstance()->findOneById((int) $config['place_id']);
        $user = $this->getUser()->getGuardUser();

        $this->events = array();

        foreach($items as $item) {
            $event = new Event();
            $event->fromArray(array(
                'icon'          => $config['icon'],
                'title'         => $item['title'],
                'description'   => $item['description'],
                'fire_at'       => date('Y-m-d H:i:s', strtotime($item['fire_at'])),
                'place_id'      => (int) $config['place_id'],
                'user_id'       => $user->id,
                'geo_lat'       => $place->geo_lat,
                'geo_lng'       => $place->geo_lng,
            ));

            $event->save();

            $this->events[] = $event;
        }
    }
}