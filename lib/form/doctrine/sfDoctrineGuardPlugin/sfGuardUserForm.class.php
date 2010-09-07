<?php

/**
 * sfGuardUser form.
 *
 * @package    change me
 * @subpackage form
 * @author     pycmam <pycmam@gmail.com>
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardUserForm extends PluginsfGuardUserForm
{
    public function configure()
    {
        $this->validatorSchema['email_address'] = new sfValidatorEmail(array(
            'max_length' => 255,
        ));

        $this->widgetSchema->setHelps(array(
            'phone' => 'В формате +7...',
        ));

        $this->useFields(array('username', 'email_address', 'first_name', 'last_name',
            'icq', 'jabber', 'phone'));

        $this->widgetSchema->setNameFormat('user[%s]');
    }
}
