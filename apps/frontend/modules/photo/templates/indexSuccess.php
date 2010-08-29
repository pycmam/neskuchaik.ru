<?php
/**
 * Фото объекта
 *
 * @param Point $point
 */
?>

<h2>Фотогалерея <?php echo $point ?></h2>

<?php if ($sf_user->isAuthenticated()): ?>
    <?php echo link_to($point->getUserId() == $sf_user->getGuardUser()->getId() ? 'Редактировать галерею' : 'Добавить фото', 'photo_edit', $point, array(
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

        <?php if (! $sf_user->isAuthenticated()): ?>
            <h2>Авторизуйтесь, чтобы добавлять фото.</h2>
            <p>Для этого у нас есть куча способов ;)</p>
        <?php endif ?>
    <?php endif ?>
</div>
