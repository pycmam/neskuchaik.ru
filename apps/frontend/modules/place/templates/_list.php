<?php
/**
 * @param array of Place $places
 */
?>

<?php foreach ($places as $place): ?>
<div class="item place">
    <span class="place"><?php echo link_to($place, 'place_show', $place, array('class' => 'ajax')) ?></span>
    <div class="desc">
        <?php echo link_to_comments($place, sprintf('комментарии (%d)', $place->COMMENTS_COUNT)) ?>
        <?php echo link_to_photos($place, sprintf('фото (%d)', $place->IMAGES_COUNT)) ?>
    </div>
</div>
<?php endforeach ?>