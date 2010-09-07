<?php
/**
 * @param array of Event $events
 * @param boolean $showPlace
 */
?>

<?php foreach ($events as $event): ?>
<div class="item event">
    <span class="time"><?php echo date('H:i', strtotime($event->getFireAt())) ?></span>
    <?php if ($place = $event->getPlace()): ?>
        <span class="place"><?php echo link_to($place, 'place_show', $place, array('class' => 'ajax')) ?></span> &rarr;
    <?php endif ?>
    <span class="event"><?php echo link_to($event, 'event_show', $event, array('class' => 'ajax')) ?></span>
    <div class="desc">
        <?php echo link_to_comments($event, sprintf('комментарии (%d)', $event->COMMENTS_COUNT)) ?>
        <?php echo link_to_photos($event, sprintf('фото (%d)', $event->IMAGES_COUNT)) ?>
    </div>
</div>
<?php endforeach ?>