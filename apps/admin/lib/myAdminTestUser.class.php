<?php

class myAdminTestUser extends myAdminUser
{
    /**
     * Всегда авторизован
     */
    public function isAuthenticated()
    {
        return true;
    }


    /**
     * Суперадмин
     */
    public function isSuperAdmin()
    {
        return true;
    }


    /**
     * Имеет все права
     */
    public function hasCredential($credential, $useAnd = true)
    {
        return true;
    }


    /**
     * Поскольку GuardUser не инициализирован, надо вернуть имя
     */
    public function __toString()
    {
        return 'Admin';
    }
}
