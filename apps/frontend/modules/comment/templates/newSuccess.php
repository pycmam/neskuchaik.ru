<?php
/**
 * Добавить коммент
 *
 * @param Point $point
 * @param CommentForm $form
 */
?>

<h2 class="title icon-<?php echo $point->getIcon() ?>"><?php echo $point ?></h2>

<?php include_partial('comment/form', array(
    'form' => $form,
    'point' => $point,
)) ?>