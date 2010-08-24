<?php
/**
 * Фото объекта
 *
 * @param Point $point
 */
?>

<h2>Фотогалерея <?php echo $point ?></h2>

<?php if ($sf_user->isAuthenticated() && $point->getUserId() == $sf_user->getGuardUser()->getId()): ?>
    <?php echo link_to('Редактировать галерею', 'photo_edit', $point, array(
        'class' => 'ajax',
        'rel' => '#overlay',
        'title' => 'загрузить или удалить фото',
    )) ?>
<?php endif ?>

<div id="point-photos-container" class="container-scrollable">
    <?php if (count($images = $point->getImages())): ?>
        <ul id="point-photos">
            <?php foreach ($images as $image): ?>
            <li><?php echo link_to(image_tag($image->getImagePath('thumb')),  $image->getImagePath('full'), array(
                    'target' => '_blank',
                )) ?>
            </li>
            <?php endforeach ?>
        </ul>
    <?php else: ?>
        <p>Фото отсутствуют.</p>
    <?php endif ?>
</div>
