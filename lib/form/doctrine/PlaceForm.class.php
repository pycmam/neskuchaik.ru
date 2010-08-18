<?php

/**
 * Place form.
 *
 * @package    neskuchaik
 * @subpackage form
 * @author     pycmam <pycmam@gmail.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PlaceForm extends BasePlaceForm
{
  /**
   * @see PointForm
   */
    public function configure()
    {
        parent::configure();

        $this->useFields(array('title', 'description', 'geo_lat', 'geo_lng'));
    }
}
