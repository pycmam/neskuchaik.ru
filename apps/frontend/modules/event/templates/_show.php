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

<p class="estimate-time"><?php echo distance_of_time_in_words(time(), strtotime($event->getFireAt())) ?> до начала</p>

<?php if ($description = $event->getDescription()): ?>
    <p class="point-desc"><?php echo nl2br($description) ?></p>
<?php endif ?>

<?php if ($count = count($users = $event->getUsers())): ?>
<div class="event-users">
    <?php foreach ($users as $user): ?>
        <?php echo link_to($user->getUsername(), 'user_show', $user, array(
            'class' => 'ajax',
            'title' => 'идет на это событие',
        )) ?>
    <?php endforeach ?>
</div>
<?php endif ?>

<?php if ($sf_user->isAuthenticated()): ?>
    <div class="point-actions">
        <h2><?php echo link_to_follow($event, $sf_user->getGuardUser(), 'Я иду!', 'Я передумал идти') ?></h2>
    </div>
<?php endif ?>

<?php echo link_to_user($event->getUser()) ?>
<?php echo link_to_comments($event) ?>
<?php echo link_to_photos($event) ?>

