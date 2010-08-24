<?php
/**
 * Загрузка/удаление фото
 *
 * @param Point $point
 */
?>

<?php echo javascript_include_tag('/myImageUploadPlugin/js/swfupload/swfupload.js') ?>
<?php echo javascript_include_tag('/myImageUploadPlugin/js/swfupload/swfupload.queue.js') ?>

<h2>Редактирование галереи к <?php echo $point ?></h2>

<?php echo link_to('Назад к галерее', 'photo', $point, array(
    'class' => 'ajax',
    'rel' => '#overlay',
)) ?>

<div id="point-photos-container" class="container-scrollable">
    <?php include_partial('image/upload_gallery', array(
        'object' => $point,
        'form' => new ImagePointForm,
        'routePrefix' => 'point',
    )) ?>
</div>

