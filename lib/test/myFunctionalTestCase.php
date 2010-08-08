<?php

/**
 * Base test class for all functional tests
 */
abstract class myFunctionalTestCase extends sfPHPUnitFunctionalTestCase
{
    /**
     * Inject your own functional testers
     *
     * @see sfTestFunctionalBase::setTesters()
     *
     * @return array
     *          'request'  => 'sfTesterRequest',
     *          'response' => 'sfTesterResponse',
     *          'user'     => 'sfTesterUser',
     */
    protected function getFunctionalTesters()
    {
        return array(
            'request'  => 'myFunctionalTesterRequest',
            'response' => 'myFunctionalTesterResponse',
            'model'    => 'sfTesterDoctrine',
            'mail'     => 'myFunctionalTesterMail',
        );
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
        $context = $this->browser->getContext();

        $context->getUser()->signOut();
        $context->getUser()->signIn($user);

        // Пользователь сбрасывает данные в SessionStorage
        $context->getUser()->shutdown();
        // Сохраняет сессию в файл
        $context->getStorage()->shutdown();

        return $user;
    }

    /**
     * Путь до файла в фикстурах
     *
     * @param string $filename
     * @return string
     */
    protected function getFilePath($filename)
    {
        return sfConfig::get('sf_test_dir') . '/fixtures/files/' . $filename;
    }

}
