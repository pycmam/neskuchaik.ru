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
});

</script>
<script type="text/javascript" src="<?php echo url_for('place_js') ?>"></script>

<div id="map_canvas">
</div>
