<?php
/**
 * События
 *
 * @param array of Event $events
 */
?>

<?php if (count($events)): ?>
    <?php foreach ($events as $event): ?>
    <div class="item event">
        <span class="time"><?php echo date('H:i', strtotime($event->getFireAt())) ?></span>
        <?php if ($place = $event->getPlace()): ?>
            <span class="place"><?php echo link_to($place, 'place_show', $place, array('class' => 'ajax')) ?></span> &rarr;
        <?php endif ?>
        <span class="event"><?php echo link_to($event, 'event_show', $event, array('class' => 'ajax')) ?></span>
        <?php echo link_to($event->getUser(), '/#user', array('class' => 'userlink ajax')) ?>
    </div>
    <?php endforeach ?>
<?php else: ?>
    <p>На этот день событий нет.</p>
<?php endif ?>