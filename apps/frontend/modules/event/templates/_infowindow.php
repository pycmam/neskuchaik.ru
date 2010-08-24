<?php
/**
 * Контент балуна, появляющегося при клике по маркеру
 *
 * @param Event $event
 */
?>

<h2><?php echo $event ?></h2>

<p><?php echo human_date($event->getFireAt(), true) ?>
 (<?php echo distance_of_time_in_words(time(), strtotime($event->getFireAt())) ?> до начала)</p>

<div class="point-infowindow-desc">
    <?php echo link_to_user($event->getUser()) ?>
    <?php echo link_to_comments($event) ?>
    <?php echo link_to_photos($event) ?>
</div>
