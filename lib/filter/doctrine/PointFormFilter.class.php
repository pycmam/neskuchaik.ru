<?php

/**
 * Point filter form.
 *
 * @package    change me
 * @subpackage filter
 * @author     pycmam <pycmam@gmail.com>
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PointFormFilter extends BasePointFormFilter
{
    public function configure()
    {
        /*
        $icons = sfConfig::get('app_marker_icons');

        $this->widgetSchema['icon'] = new sfWidgetFormChoice(array(
            'choices' => array_combine($icons, $icons),
        ));
        $this->validatorSchema['icon'] = new sfValidatorChoice(array(
            'choices' => $icons,
        ));
        */

        $this->useFields(array('title', 'description', 'user_id'));
    }
}
