<?php
/**
 * Данные о местах
 *
 * @param array $places
 */
?>

$(function(){
    <?php foreach (sfConfig::get('app_marker_icons') as $icon): ?>
    map.addIcon('<?php echo $icon ?>');

    <?php endforeach ?>

    var places = {};
    <?php foreach($places as $i => $place): ?>
    places[<?php echo $place['id'] ?>] = new GMarker(
        new GLatLng(<?php echo $place['geo_lat'], ', ', $place['geo_lng'] ?>), {
            title: '<?php echo $place['title'] ?>',
            icon: map.getIcon('<?php echo $place['icon'] ?>')
        });

    GEvent.addListener(places[<?php echo $place['id'] ?>], 'click', function() {
        $.ajax({
            url: '<?php echo url_for('place_show', array('id' => $place['id'])) ?>',
            type: 'get',
            dataType: 'html',
            cache: false,
            timeout: 5000,
            beforeSend: function() {
                $('#content .content').hide();
                $('#content .loader').fadeIn(100);
            },
            success: function(data, statusCode) {
                $('#content .loader').hide();
                $('#content .content').html(data).show();
            }
        });
    });
    <?php endforeach ?>

    map.setPoints(places);
});