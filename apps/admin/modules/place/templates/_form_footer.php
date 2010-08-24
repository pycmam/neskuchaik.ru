<?php
/**
 * Подвал формы
 *
 * @param Place $place
 */
?>

<h1>Фото места</h1>

<?php include_partial('image/upload_gallery', array(
    'object' => $place,
    'form' => new ImagePointForm,
    'routePrefix' => 'point',
)) ?>
