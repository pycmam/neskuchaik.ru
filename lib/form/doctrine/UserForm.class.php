<?php

class UserForm extends sfGuardUserForm
{
    public function configure()
    {
        parent::configure();

        $this->setDefault('phone', '+7');

        $this->useFields(array('first_name', 'last_name', 'email_address',
            'icq', 'jabber', 'phone'));
    }
}