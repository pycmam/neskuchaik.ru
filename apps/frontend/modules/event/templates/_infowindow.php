<?php
/**
 * Контент балуна, появляющегося при клике по маркеру
 *
 * @param Event $event
 */
?>
<h2><?php echo $event ?></h2>

<p><?php echo human_date($event->getFireAt(), true) ?></p>

<?php if ($description = $event->getDescription()): ?>
<p><?php echo nl2br($description) ?></p>
<?php endif ?>