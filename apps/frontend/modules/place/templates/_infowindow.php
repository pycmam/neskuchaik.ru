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

<?php if ($count = count($events = $place->getActualEvents())): ?>
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
    <?php echo link_to('<span>'.$place->getUser()->getUsername().'</span>', 'user_show', $place->getUser(), array(
        'class' => 'ajax userlink',
        'title' => 'отметил',
    )) ?>

    <?php echo link_to('<span>комментарии</span>', 'comment', $place, array(
        'class' => 'overlay point-comments',
        'rel' => '#overlay',
    )) ?>
</div>
