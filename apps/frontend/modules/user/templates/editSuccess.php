<?php
/**
 * Редактирование профиля
 *
 * @param sfGuardUser $user
 * @param UserForm $form
 */
?>

<h2>Редактирование профиля</h2>

<?php if (isset($success) && $success): ?>
<div class="flash success">Профиль успешно сохранен.</div>
<?php endif ?>

<?php echo jq_form_remote_tag(array(
    'url' => 'profile_update',
    'update' => 'overlay .content',
), array(
    'id' => 'profile-form',
)) ?>
    <?php echo $form->renderHiddenFields() ?>
    <?php echo $form->renderGlobalErrors() ?>

    <ul>
        <li class="form-item">
            <?php echo $form['first_name']->renderLabel('Ваше имя:') ?>
            <?php echo $form['first_name']->renderError() ?>
            <?php echo $form['first_name'] ?>
        </li>

        <li class="form-item">
            <?php echo $form['last_name']->renderLabel('Фамилия:') ?>
            <?php echo $form['last_name']->renderError() ?>
            <?php echo $form['last_name'] ?>
        </li>

        <li class="form-item">
            <?php echo $form['email_address']->renderLabel('Электропочта: *') ?>
            <?php echo $form['email_address']->renderError() ?>
            <?php echo $form['email_address'] ?>
        </li>

        <li class="form-item">
            <?php echo $form['icq']->renderLabel('ICQ:') ?>
            <?php echo $form['icq']->renderError() ?>
            <?php echo $form['icq'] ?>
        </li>

        <li class="form-item">
            <?php echo $form['phone']->renderLabel('Мобильный телефон:') ?>
            <?php echo $form['phone']->renderError() ?>
            <?php echo $form['phone'] ?>
            <?php echo $form['phone']->renderHelp() ?>
        </li>

        <li class="form-item">
            <input type="submit" value="Сохранить" />
        </li>
    </ul>
</form>