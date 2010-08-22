<?php
/**
 * Скрипт инициализации маркера для выбора места
 */
?>
<script type="text/javascript">
$(function(){
    map.getMarker().setLatLng(map.getMap().getCenter());
    map.getMarker().enableDragging();
    map.getMarker().show();

    GEvent.addListener(map.getMarker(), 'dragend', function(point) {
        $('#point-form #point_geo_lat').val(point.lat());
        $('#point-form #point_geo_lng').val(point.lng());
    });
});
</script>
