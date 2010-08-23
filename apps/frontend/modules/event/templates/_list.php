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
        <?php echo link_to('<span>'.$event->getUser()->getUsername().'</span>', 'user_show', $event->getUser(), array(
            'class' => 'ajax userlink',
        )) ?>

        <?php echo link_to('<span>комментарии</span>', 'comment', $event, array(
            'class' => 'overlay point-comments',
            'rel' => '#overlay',
        )) ?>
    </div>
</div>
<?php endforeach ?>