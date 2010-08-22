<?php
/**
 * Скрипт открытия балуна выбранной точки
 *
 * @param Point $point
 */
?>
<script type="text/javascript">
document.title = "<?php echo str_replace('"', '\"', $point->getTitle()) ?> | Нескучайк" ;

$(function(){
    var point = new GLatLng(<?php echo $point->getGeoLat(), ', ', $point->getGeoLng() ?>);
    map.getMap().panTo(point);
    map.getMarker().hide();

    <?php if (! 'event' == $point->getModel() && ! $point->getPlace()): ?>
    var marker = map.getPoint('<?php echo $point->getId() ?>');
    if (! marker) {
        marker = map.createPoint(point, '<?php echo $point->getTitle() ?>', map.getIcon('<?php echo $point->getIcon() ?>'));
    }
    <?php endif ?>
    map.getMap().openInfoWindowHtml(point, "<?php echo str_replace(array('"', "\n"), array('\"', " "), get_partial($point->getModel().'/infowindow', array($point->getModel() => $point)))  ?>");
});
</script>
