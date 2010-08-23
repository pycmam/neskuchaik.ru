<?php
/**
 * Постраничка
 *
 * @param sfDoctrinePager $pager
 */
?>

<?php if ($pager->haveToPaginate()): ?>
<div class="pagination">
<?php foreach ($pager->getLinks(sfConfig::get('app_pager_links_count', 10)) as $page):
    if ($page == $pager->getPage()):
        echo "<span>{$page}</span>";
    elseif ($page == 1):
        echo link_to($page, 'comment', $point, array('class' => 'ajax', 'rel' => '#overlay'));
    else:
        echo link_to($page, 'comment', array('id' => $point->id, 'page' => $page), array('class' => 'ajax', 'rel' => '#overlay'));
    endif;
endforeach; ?>
</div>
<?php endif ?>