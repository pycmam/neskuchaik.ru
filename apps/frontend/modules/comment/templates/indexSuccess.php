<?php
/**
 * Комменты
 *
 * @param Point $point
 */
?>

<h2>
    <?php echo link_to('Подписка на комментарии', 'feed_comments', $point, array(
        'class' => 'feed block',
        'title' => 'подписаться на комментарии',
    )) ?>
    <span><?php echo $point ?></span>
</h2>

<?php if (count($comments = $pager->getResults())): ?>
    <ul class="comments">
    <?php foreach ($comments as $comment): ?>
        <?php include_partial('comment/comment', array('comment' => $comment)) ?>
    <?php endforeach ?>
    </ul>

    <div class="comment-actions">
        <?php echo link_to('Добавить комментарий', 'comment_new', $point, array('class' => 'ajax', 'rel' => '#overlay')) ?>
    </div>

    <?php include_partial('comment/pagination', array('pager' => $pager, 'point' => $point)) ?>
<?php else: ?>
    <p>Комментариев нет, Вы можете написать первый.</p>

    <?php include_partial('comment/form', array(
        'form' => $form,
        'point' => $point,
        'showCancel' => false,
    )) ?>
<?php endif ?>



