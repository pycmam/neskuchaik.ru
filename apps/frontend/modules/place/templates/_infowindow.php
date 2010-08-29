<?php
/**
 * Контент балуна, появляющегося при клике по маркеру
 *
 * @param Place $place
 */
?>

<h2>
    <?php echo link_to('Подписка на события', 'feed_place_events', $place, array(
        'class' => 'feed block',
        'title' => 'подписаться на события',
    )) ?>
    <span><?php echo $place ?></span>
</h2>

<?php if ($count = count($events = $place->getActualEvents(sfConfig::get('app_max_events_in_infowindow', 10)))): ?>
<div class="place-infowindow-events">
    <h3>События (<?php echo $count ?>):</h3>
    <?php foreach ($events as $event): ?>
    <div class="item">
        <?php echo link_to($event, 'event_show', $event, array('class' => 'ajax')) ?>
        <span class="event-fire-at"><?php echo human_date($event->getFireAt(), true) ?></span>
    </div>
    <?php endforeach ?>
</div>
<?php endif ?>

<div class="point-infowindow-desc">
    <?php echo link_to_user($place->getUser()) ?>
    <?php echo link_to_comments($place) ?>
    <?php echo link_to_photos($place) ?>
</div>
