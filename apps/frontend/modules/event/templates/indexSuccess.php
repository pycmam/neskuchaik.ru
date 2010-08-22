<?php
/**
 * События
 *
 * @param array of Event $events
 */
?>

<?php if (count($events)): ?>
    <?php include_partial('event/list', array('events' => $events)) ?>
<?php else: ?>
    <p>На этот день событий нет.</p>
<?php endif ?>