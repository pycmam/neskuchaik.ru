<?php
/**
 * Каталог
 */
?>

<script type="text/javascript">
$(function(){
    $('#types-menu a').live('click', function(){
        $('#objects-container .objects').hide();
        $('#objects-container ' + $(this).attr('href')).show();
        return false;
    });

    $('#types-menu .first a').click();
});
</script>

<ul id="types-menu" class="menu">
    <li class="first"><a href="#all">Все</a></li>
    <li><a href="#places">Места</a></li>
    <li><a href="#events">События</a></li>
</ul>

<div id="objects-container">
    <div id="all" class="objects">
        <?php foreach ($all as $point): ?>
            <p><?php echo link_to($point, 'catalog_show', $point, array('class' => 'ajax')) ?></p>
        <?php endforeach ?>
    </div>

    <div id="places" class="objects">
        <p>Тут только места</p>
    </div>

    <div id="events" class="objects">
        <p>Тут только события</p>
    </div>
</div>