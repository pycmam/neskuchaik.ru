<?php
/**
 * Места
 *
 * @param array of Point
 */
?>

<div id="point-items" class="place-items">
<?php if (count($places)): ?>
    <?php include_partial('place/list', array('places' => $places)) ?>
<?php endif ?>
</div>