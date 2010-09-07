<?php
/**
 * События
 *
 * @param array of Event $events
 */
?>

<!--
<div id="point-search">
    <input type="text" name="s" />
</div>
 -->

<div id="events-nav">
    <span>Не скучать:</span>
    <ul>
        <?php include_component('sfRichMenu', 'menu', array('menu' => 'events')) ?>
    </ul>
</div>

<div id="point-items">
<?php if (count($events)): ?>
    <?php include_partial('event/list', array('events' => $events)) ?>
<?php else: ?>
    <p>На этот день событий нет.</p>
<?php endif ?>
</div>