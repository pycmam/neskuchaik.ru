<?php
/**
 * Просмотр места
 *
 * @param Place $place
 */
?>

<?php include_partial('global/show.js', array('point' => $place)) ?>

<h2 class="place-title"><?php echo $place ?></h2>

<?php if ($description = $place->getDescription()): ?>
    <p><?php echo nl2br($description) ?>
<?php endif ?>

<p>
    <?php echo link_to('#', 'place_show', $place, array('title' => 'Прямая ссылка')) ?>,
    добавил <?php echo $place->getUser()->getUsername() ?>,
    <?php echo date('d.m.Y в H:i', strtotime($place->getCreatedAt())) ?>
</p>

<?php echo link_to('Добавить событие в этом месте', 'event_new', array('place' => $place->getId()), array('class' => 'ajax app-place')) ?>