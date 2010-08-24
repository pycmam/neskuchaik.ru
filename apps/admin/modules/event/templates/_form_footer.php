<?php
/**
 * Подвал формы
 *
 * @param Event $event
 */
?>

<h1>Фото события</h1>

<?php include_partial('image/upload_gallery', array(
    'object' => $event,
    'form' => new ImagePointForm,
    'routePrefix' => 'point',
)) ?>
