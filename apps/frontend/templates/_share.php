<?php
/**
 * Кнопки расшаривания
 *
 * @param Point $point
 */
$url = url_for($point->getModel() . '_show', $point, true);
?>

<div id="share-buttons">
    <div id="share-twitter" class="share-button">
        <a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo $url ?>" data-count="horizontal" data-via="neskuchaik">Tweet</a>
    </div>
</div>

<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>