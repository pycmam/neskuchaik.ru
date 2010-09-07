<?php

/**
 * Авторизация через loginza.ru
 */
class loginzaActions extends sfActions
{
    /**
     * Личные данные
     */
    public function executeSignup()
    {
        $loginzaData = $this->getUser()->getAttribute('loginza.identity', false, 'loginza');

        $this->forward404Unless($loginzaData);

        $user = new sfGuardUser();
        $user->fromArray($loginzaData);
        $this->form = new sfGuardUserForm($user);
    }

    /**
     * Зарегистрировать
     */
    public function executeCreate(sfWebRequest $request)
    {
        $this->executeSignup();

        $this->form->bind($request->getParameter($this->form->getName()));

        if ($this->form->isValid()) {
            $user = $this->form->save();

            $loginzaData = $this->getUser()->getAttribute('loginza.identity', false, 'loginza');

            // связываем юзера с идентификатором
            $identity = new Identity();
            $identity->setIdentity($loginzaData['identity']);
            $identity->setProvider($loginzaData['provider']);
            $identity->setUser($user);
            $identity->save();

            $this->getUser()->setAttribute('identity.id', $identity->getId());

            // авторизуем
            $this->getUser()->signin($user, true);
        }

        if (! $this->form->hasErrors()) {
            if ($request->isXmlHttpRequest()) {
                return $this->renderText("<script type='text/javascript'>window.location.href='/';</script>");
            } else {
                return $this->redirect('homepage');
            }
        }

        $this->setTemplate('signup');
    }

    /**
     * Loginza TokenUrl
     */
    public function executeAuth(sfWebRequest $request)
    {
        $this->forward404Unless($token = $request->getParameter('token'));

        $loginza = new LoginzaAPI();
        $response = $loginza->getAuthInfo($token);

        $this->forward404Unless(isset($response->identity));

        $identity = IdentityTable::getInstance()->findOneByIdentity($response->identity);

        if ($identity) {
            $this->getUser()->signin($identity->getUser(), true);

            return $this->redirect('homepage');
        } else {
            $this->getUser()->setAttribute('loginza.identity', array(
                'identity' => $response->identity,
                'provider' => $response->provider,
                'email_address' =>  isset($response->email) ? $response->email : '',
                'username' => isset($response->nickname) ? $response->nickname : '',
                'first_name' => isset($response->name->first_name) ? $response->name->first_name : '',
                'last_name' => isset($response->name->last_name) ? $response->name->last_name : '',
            ), 'loginza');

            return $this->redirect('loginza_signup');
        }
    }
}