<?php

/**
 * Гуглокарта
 */
class myWidgetFormGoogleMap extends sfWidgetFormInputHidden
{
    /**
     * Config
     *
     * @param array $options
     * @param array $attributes
     */
    protected function configure($options = array(), $attributes = array())
    {
        parent::configure($options, $attributes);

        $this->addOption('canvas_class', 'google_map');
        $this->setOption('is_hidden', false);
    }

    /**
     * Отрисовка
     *
     * @param mixed $name
     * @param mixed $value
     * @param mixed $attributes
     * @param mixed $errors
     * @return string
     */
    public function render($name, $value = null, $attributes = array(), $errors = array())
    {
        sfContext::getInstance()->getResponse()->addJavascript(
            'http://maps.google.com/maps?file=api&v=2&key=' . sfConfig::get('dm_google_maps')
        );

        $js = '
<div class="'.$this->getOption('canvas_class').'" id="'.$this->generateId($name . '_canvas').'"></div>
<script type="text/javascript">
//<[CDATA[
    window.onload = initialize;
    window.onunload = GUnload;

    function initialize()
    {
        var map = new GMap2(document.getElementById("'.$this->generateId($name . '_canvas').'"), 10);';

        if ($value) {
            $js .= '
        map.setCenter(new GLatLng('.$value.'), 10);';
        } else {
            $js .= '
        map.setCenter(new GLatLng('.sfConfig::get('app_google_map_default_coordinates').'), 10);';
        }

        $js .= '
        map.addControl(new GOverviewMapControl());
        map.addControl(new GLargeMapControl());
        map.addControl(new GMapTypeControl());
        map.enableScrollWheelZoom();

        var marker = new GMarker(map.getCenter(), {draggable: true});

        GEvent.addListener(marker, "dragend", function() {
            document.getElementById("'.$this->generateId($name).'").value = marker.getLatLng().lat() + "," + marker.getLatLng().lng();
        });
        GEvent.addListener(map, "click", function(overlay, latlng) {
            marker.setLatLng(latlng);
            map.panTo(latlng);
            document.getElementById("'.$this->generateId($name).'").value = marker.getLatLng().lat() + "," + marker.getLatLng().lng();
        });
        map.addOverlay(marker);
    }
//]]>
</script>';

        return parent::render($name, $value = null, $attributes = array(), $errors = array()) . $js;
    }
}
