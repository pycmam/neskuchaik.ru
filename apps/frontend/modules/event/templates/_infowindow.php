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

<div class="point-infowindow-desc">
    <?php echo link_to('<span>'.$event->getUser()->getUsername().'</span>', 'user_show', $event->getUser(), array(
        'class' => 'ajax userlink',
        'title' => 'отметил',
    )) ?>

    <?php echo link_to('<span>комментарии</span>', 'comment', $event, array(
        'class' => 'overlay point-comments',
        'rel' => '#overlay',
    )) ?>
</div>
