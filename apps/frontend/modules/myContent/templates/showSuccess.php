<?php
/**
 * Просмотр страницы
 *
 * @param myContent $page
 */
?>

<h2><?php echo $page->getTitle() ?></h2>

<?php echo $page->getContent(ESC_RAW) ?>