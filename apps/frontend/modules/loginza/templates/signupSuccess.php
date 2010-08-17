<?php
/**
 * Создание профиля
 *
 * @param LoginzaSignupForm $form
 */
?>

<form action="<?php echo url_for('loginza_create') ?>" method="post">
    <?php echo $form ?>
    <input type="submit" value="Сохранить" />
</form>