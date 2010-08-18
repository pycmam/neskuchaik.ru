<?php
/**
 * @param Point $point
 */
?>

<script type="text/javascript">
$(function(){
    var point = new GLatLng(<?php echo $point->getGeoLat(), ', ', $point->getGeoLng() ?>);
    map.markerPosition(point);
    map.markerShow();
    map.getMap().panTo(point);
});
</script>