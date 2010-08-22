<?php
/**
 * Просмотр события
 *
 * @param Event $event
 * @param boolean $move
 */
$move = isset($move) ? $move : true;
?>

<?php if ($move): ?>
    <?php include_partial('global/show.js', array('point' => $event)) ?>
<?php endif ?>

<?php if ($event->getPlaceId()): ?>
    <?php $place = $event->getPlace() ?>

    <h2><?php echo $event ?></h2>

    <h2 class="title icon-<?php echo $place->getIcon() ?>"><?php echo link_to($place, 'place_show', $place, array('class' => 'ajax')) ?></h2>
<?php else: ?>
    <h2 class="title icon-<?php echo $event->getIcon() ?>"><?php echo $event ?></h2>
<?php endif ?>

<h2 class="event-fire-at"><?php echo human_date($event->getFireAt(), true) ?></h2>

<?php if ($description = $event->getDescription()): ?>
    <p class="point-desc"><?php echo nl2br($description) ?></p>
<?php endif ?>

<?php if ($count = count($users = $event->getUsers())): ?>
<div class="event-users">
    <?php foreach ($users as $user): ?>
        <?php echo link_to($user->getUsername(), 'user_show', $user, array('class' => 'ajax')) ?>
    <?php endforeach ?>
</div>
<?php endif ?>

<?php if ($sf_user->isAuthenticated()): ?>
<h2 class="event-go">
    <?php if ($event->hasAcceptFrom($sf_user->getGuardUser()->getId())): ?>
        <?php echo link_to('Я передумал идти', 'event_reject', $event, array('class' => 'ajax ajax-post')) ?>
    <?php else: ?>
        <?php echo link_to($count ? 'Я тоже пойду!' : 'Пойду первым!', 'event_accept', $event, array('class' => 'ajax ajax-post')) ?>
    <?php endif ?>
</h2>
<?php endif ?>

<?php echo link_to('<span>комментарии</span>', 'event_comments', $event, array('class' => 'overlay point-comments')) ?>
