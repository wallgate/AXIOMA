<?php

namespace Axioma\Auth;

use Db\UserService,
    Axioma\Db\AuthServiceInterface;

class Adapter implements \Zend_Auth_Adapter_Interface {

    const ERROR_MESSAGE = 'Введены неверные данные';

    private $login;
    private $password;
    private $service;

    function __construct(AuthServiceInterface $service) {
        $this->service = $service;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * Атентификация (метод вызывает экземпляр Zend_Auth)
     *
     * @return \Zend_Auth_Result
     */
    public function authenticate() {
        $user = $this->service->authenticate($this->login, $this->password);
        if ($user)
            return new \Zend_Auth_Result(\Zend_Auth_Result::SUCCESS, $user);
        return new \Zend_Auth_Result(\Zend_Auth_Result::FAILURE, NULL, array(self::ERROR_MESSAGE));
    }
}