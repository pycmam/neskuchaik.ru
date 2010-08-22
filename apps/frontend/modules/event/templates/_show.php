<?php
/**
 * Просмотр события
 *
 * @param Event $event
 */
?>

<?php include_partial('global/show.js', array('point' => $event)) ?>

<h2 class="event-title"><?php echo $event ?></h2>

<p><?php echo date('d.m.Y в H:i', strtotime($event->getFireAt())) ?></p>

<?php if ($description = $event->getDescription()): ?>
    <p><?php echo nl2br($description) ?>
<?php endif ?>

<p>
    <?php echo link_to('#', 'event_show', $event, array('title' => 'Прямая ссылка')) ?>,
    добавил <?php echo $event->getUser()->getUsername() ?>,
    <?php echo date('d.m.Y в H:i', strtotime($event->getCreatedAt())) ?>
</p>