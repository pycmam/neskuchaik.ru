<?php
/**
 * Создание профиля
 *
 * @param sfGuardUserForm $form
 */
?>

<h2>Создание профиля</h2>

<?php echo jq_form_remote_tag(array(
    'url' => 'loginza_create',
    'update' => 'content .content',
), array(
    'id' => 'profile-form',
)) ?>
    <?php echo $form->renderHiddenFields() ?>
    <?php echo $form->renderGlobalErrors() ?>

    <ul>
        <li class="form-item">
            <?php echo $form['username']->renderLabel('Ник *') ?>
            <?php echo $form['username']->renderError() ?>
            <?php echo $form['username'] ?>
        </li>

        <li class="form-item">
            <?php echo $form['email_address']->renderLabel('Электропочта *') ?>
            <?php echo $form['email_address']->renderError() ?>
            <?php echo $form['email_address'] ?>
        </li>

        <li class="form-item">
            <input type="submit" value="Готово!" />
        </li>
    </ul>
</form>