<?php
/**
 * Контент балуна, появляющегося при клике по маркеру
 *
 * @param Event $event
 */
?>
<h2><?php echo $event ?></h2>
<p><?php echo nl2br($event->getDescription()) ?></p>