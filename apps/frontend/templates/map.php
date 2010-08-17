<?php
/**
 * Шаблон с картой
 */
?>
<?php include_partial('global/header') ?>

<div id="map-layout">
    <div id="map">
        <?php include_partial('map/map') ?>
    </div>

    <div id="sidebar">
        <div class="content">
            <?php echo $sf_content ?>
        </div>
    </div>
</div>

<?php include_partial('global/footer') ?>