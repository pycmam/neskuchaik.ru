<?php
/**
 * Контент балуна, появляющегося при клике по маркеру
 *
 * @param Place $place
 */
?>
<h2><?php echo $place ?></h2>
<p><?php echo nl2br($place->getDescription()) ?></p>

<?php if ($count = count($place->getEvents())): ?>
<p>Событий: <b><?php echo $count ?></b></p>
<?php endif ?>