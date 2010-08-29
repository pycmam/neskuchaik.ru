<?php
/**
 * Коммент
 *
 * @param Comment $comment
 */
?>
<li class="comment" id="comment-<?php echo $comment->id ?>">
    <div class="desc">
        <?php echo link_to('<span>' . $comment->getUser()->getUsername() . '</span>', 'user_show', $comment->getUser(), array('class' => 'ajax userlink')) ?>

        <span class="date"><?php echo human_date($comment->getCreatedAt(), true) ?></span>
        <span class="action">
        <?php echo link_to_comment_delete($comment) ?>
        </span>
    </div>
    <div class="text">
        <?php echo simple_format_text($comment->getComment()) ?>
    </div>
</li>