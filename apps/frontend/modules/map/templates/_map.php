<?php
/**
 * Карта
 */

?>

<script src="http://maps.google.com/maps?file=api&v=2&key=<?php echo sfConfig::get('dm_google_maps') ?>&sensor=false" type="text/javascript"></script>
<script src="http://gmaps-utility-library.googlecode.com/svn/trunk/markermanager/release/src/markermanager.js" type="text/javascript"></script>

<script type="text/javascript">
$(function() {
    map = new Map('map_canvas', [<?php echo sfConfig::get('app_google_map_default_coordinates') ?>], 14);

    <?php if ($sf_user->isAuthenticated()): ?>
    GEvent.addListener(map.getMap(), 'click', function(overlay, point) {
        if (point) {
            map.markerPosition(point);
            map.markerShow();

            GEvent.addListener(map.getMarker(), 'dragend', function(point) {
                $('#point-form #point_geo_lat').val(point.lat());
                $('#point-form #point_geo_lng').val(point.lng());
            });

            $.ajax({
                url: "<?php echo url_for('place_new') ?>?geo_lat="+point.lat()+"&geo_lng="+point.lng(),
                dataType: 'html',
                success: function(data) { $('#content .content').html(data); }
            });
        }
    });
    <?php endif ?>
});

</script>

<div id="map_canvas">
</div>
