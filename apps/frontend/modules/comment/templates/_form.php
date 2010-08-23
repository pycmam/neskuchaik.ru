<?php
/**
 * Форма комментария
 *
 * @param CommentForm $form
 * @param Point $point
 * @param boolean $showCancel
 */

$showCancel = isset($showCancel) ? $showCancel : true;
?>

<?php if ($sf_user->isAuthenticated()): ?>

<h2>Добавить комментарий</h2>

<?php echo jq_form_remote_tag(array(
    'url' => url_for('comment_create', $point),
    'update' => 'overlay .content',
), array(
    'id' => 'comment-form',
)) ?>
    <?php echo $form->renderHiddenFields() ?>
        <?php echo $form->renderGlobalErrors() ?>

    <ul>
        <li class="form-item">
            <?php echo $form['comment']->renderLabel('Ваш комментарий') ?>
            <?php echo $form['comment']->renderError() ?>
            <?php echo $form['comment'] ?>
        </li>
        <li class="form-item">
            <input type="submit" value="Отправить" />

            <?php if ($showCancel): ?>
                <?php echo link_to('Отмена', 'comment', $point, array(
                    'class' => 'ajax',
                    'rel' => '#overlay'
                )) ?>
            <?php endif ?>
        </li>
    </ul>
</form>

<?php else: ?>
    <h2>Авторизуйтесь, чтобы добавлять комментарии.</h2>
    <p>Для этого у нас есть куча способов ;)</p>
<?php endif ?>