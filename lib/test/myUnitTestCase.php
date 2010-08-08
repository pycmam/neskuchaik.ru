<?php

/**
 * Base test class for all unit tests
 */
abstract class myUnitTestCase extends sfPHPUnitTestCase
{
    /**
     * Returns database connection to wrap tests with transaction
     */
    protected function getConnection()
    {
        return Doctrine_Manager::getInstance()->getConnection('doctrine');
    }


    /**
     * Creates new helper
     *
     * @return myTestObjectHelper
     */
    protected function makeHelper()
    {
        return new myTestObjectHelper;
    }

    /**
     * Создать и авторизовать пользователя
     *
     * @param sfGuardUser $user
     * @return sfGuardUser
     */
    protected function authenticateUser(sfGuardUser $user = null)
    {
        if (is_null($user)) {
            $user = $this->helper->makeUserWithProfile(true);
        }

        // При создании браузера инициализируется сессия
        $context = sfContext::getInstance();

        $context->getUser()->signOut();
        $context->getUser()->signIn($user);

        // Пользователь сбрасывает данные в SessionStorage
        $context->getUser()->shutdown();
        // Сохраняет сессию в файл
        $context->getStorage()->shutdown();

        return $user;
    }

}
