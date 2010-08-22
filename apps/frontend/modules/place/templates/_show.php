<?php
/**
 * Просмотр места
 *
 * @param Place $place
 */
?>

<?php include_partial('global/show.js', array('point' => $place)) ?>

<h2 class="title icon-<?php echo $place->getIcon() ?>"><?php echo $place ?></h2>

<?php if ($description = $place->getDescription()): ?>
    <p class="point-desc"><?php echo nl2br($description) ?></p>
<?php endif ?>

<?php if ($count = count($events = $place->getActualEvents())): ?>
<div class="place-events">
    <h3>События (<?php echo $count ?>):</h3>
    <?php include_partial('event/list', array('events' => $events)) ?>
</div>
<?php endif ?>

<?php if ($sf_user->isAuthenticated()): ?>
<h2 class="place-add-event">
    <?php echo link_to('Добавить событие', 'event_new', array('place' => $place->getId()), array('class' => 'ajax')) ?>
</h2>
<?php endif ?>

<?php echo link_to('<span>комментарии</span>', 'place_comments', $place, array('class' => 'overlay point-comments')) ?>

