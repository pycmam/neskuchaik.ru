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
            title: '<?php echo str_replace("'", "\'", $point['title']) ?>',
            icon: map.getIcon('<?php echo $point['icon'] ?>')
        });

    GEvent.addListener(places[<?php echo $point['id'] ?>], 'click', function() {
        $.ajax({
            url: '<?php echo url_for($point['model'] . '_show', array('id' => $point['id'])) ?>',
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