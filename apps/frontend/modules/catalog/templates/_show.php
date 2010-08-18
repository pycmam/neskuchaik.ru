<?php
/**
 * Просмотр места
 *
 * @param Place $place
 */
?>

<?php include_partial('catalog/goTo.js', array('point' => $point)) ?>

<h2>
    <?php echo link_to('&larr;', 'homepage', array(), array('class' => 'ajax')) ?>
    <?php echo $point ?>
</h2>

<?php if ($description = $point->getDescription()): ?>
    <p><?php echo nl2br($description) ?>
<?php endif ?>

<p>
    <?php echo link_to('#', 'catalog_show', $point, array('title' => 'Прямая ссылка')) ?>,
    добавил <?php echo $point->getUser()->getUsername() ?>,
    <?php echo date('d.m.Y в H:i', strtotime($point->getCreatedAt())) ?>
</p>