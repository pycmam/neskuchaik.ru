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

    <?php include_partial('event/list', array(
        'events' => $events,
    )) ?>
</div>
<?php endif ?>

<?php if ($sf_user->isAuthenticated()): ?>
    <div class="point-actions">
        <h2><?php echo link_to_event_new($place) ?></h2>
        <h2><?php echo link_to_follow($place, $sf_user->getGuardUser(), 'Следить за событиями', 'Перестать следить') ?></h2>
    </div>
<?php endif ?>

<!--
<?php echo link_to_place_edit($place) ?>
-->
<?php echo link_to_user($place->getUser()) ?>
<?php echo link_to_comments($place) ?>
<?php echo link_to_photos($place) ?>
