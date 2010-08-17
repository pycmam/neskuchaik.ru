<?php
/**
 * Карта
 */

?>

<script src="http://maps.google.com/maps?file=api&v=2&key=<?php echo sfConfig::get('dm_google_maps') ?>&sensor=false"
        type="text/javascript">
</script>

<script type="text/javascript">
$(function() {
    var map = new GMap2(document.getElementById("map_canvas"));
    map.setCenter(new GLatLng(<?php echo sfConfig::get('app_google_map_default_coordinates') ?>), 14);
    map.setMapType(G_SATELLITE_MAP);
    map.addControl(new GOverviewMapControl());
    map.addControl(new GLargeMapControl());
    map.addControl(new GMapTypeControl());
    map.enableScrollWheelZoom();
});

</script>

<div id="map_canvas">
</div>