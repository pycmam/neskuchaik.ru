<?php

class myAdminUser extends sfGuardSecurityUser
{
    private $_password;

    /**
     * Придумать пароль
     *
     * Небольшой хак, чтобы поделиться придуманным паролем с тестами
     *
     * @return string
     */
    public function generatePassword()
    {
        if (null === $this->_password) {
            $this->_password = mt_rand(0,999999);
        }
        return $this->_password;
    }
}
