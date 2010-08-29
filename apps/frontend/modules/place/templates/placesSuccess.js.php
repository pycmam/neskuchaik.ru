<?php
/**
 * Данные о местах
 *
 * @param array $points
 */
?>

$(function(){
    <?php foreach (sfConfig::get('app_marker_icons') as $icon): ?>
    map.addIcon('<?php echo $icon ?>');

    <?php endforeach ?>

    var places = {};
    <?php foreach($points as $i => $point): ?>
    places[<?php echo $point['id'] ?>] = new GMarker(
        new GLatLng(<?php echo $point['geo_lat'], ', ', $point['geo_lng'] ?>), {
            title: '<?php echo str_replace(array('"', '&quot;'), array('\"', '\"'), $point['title']) ?>',
            icon: map.getIcon('<?php echo $point['icon'] ?>')
        });

    GEvent.addListener(places[<?php echo $point['id'] ?>], 'click', function() {
        <?php include_partial('global/listener', array('point' => $point)) ?>
    });
    <?php endforeach ?>

    map.setPoints(places);
});