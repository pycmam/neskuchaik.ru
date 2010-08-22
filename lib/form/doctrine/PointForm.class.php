<?php

/**
 * Point form.
 *
 * @package    change me
 * @subpackage form
 * @author     pycmam <pycmam@gmail.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PointForm extends BasePointForm
{
    public function configure()
    {
        $this->widgetSchema['geo_lat'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['geo_lng'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['tags'] = new sfWidgetFormInput();
        $this->widgetSchema['icon'] = new myWidgetFormIcon(array(
            'icons' => sfConfig::get('app_marker_icons'),
            'path' => '/images/marker',
            'target' => '#point_icon',
        ));

        $this->widgetSchema->setNameFormat('point[%s]');
    }
}
