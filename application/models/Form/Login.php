<?php

namespace Form;

use Axioma\Form\Base,
    Axioma\Exception,
    Axioma\Auth\Adapter,
    Axioma\Form\AuthInterface,
    Axioma\Form\Decorator\Strategy\BaseInterface;

/**
 * Форма аутентификации, содержит текстовые поля для ввода логина и пароля
 */
class Login extends Base implements AuthInterface {

    const ERROR_INVALID = 'Пожалуйста, заполните все поля';
    const ERROR_ADAPTER = 'Ошибка инициализации адаптера';

    /**
     * Адаптер аутентификации
     * @var Adapter
     */
    protected $adapter;

    protected function build($data = array()) {
        $login = new \Zend_Form_Element_Text('login');
        $login->setLabel('Логин')
              ->setRequired();

        $password = new \Zend_Form_Element_Password('password');
        $password->setLabel('Пароль')
                 ->setRequired();

        $submit = new \Zend_Form_Element_Submit('submit');
        $submit->setLabel('Вход')
               ->setDecorators($this->decorationStrategy->getButtonDecorators());

        $this->addElements(array($login, $password))
             ->setElementDecorators($this->decorationStrategy->getInputDecorators())
             ->addElement($submit)
             ->setDecorators($this->decorationStrategy->getFormDecorators());

        return $this;
    }

    public function process() {
        if (!$this->isValid($this->getValues())) {
            throw new Exception(self::ERROR_INVALID);
        }
        if (!$this->adapter instanceof \Zend_Auth_Adapter_Interface) {
            throw new Exception(self::ERROR_ADAPTER);
        }

        // инициализация адаптера
        $this->adapter->setLogin($this->getValue('login'));
        $this->adapter->setPassword($this->getValue('password'));
        $result = \Zend_Auth::getInstance()->authenticate($this->adapter);

        if ($result->getCode() != \Zend_Auth_Result::SUCCESS) {
            $errorMessages = $result->getMessages();
            throw new Exception($errorMessages[0]);
        }
    }

    public function setAdapter(\Zend_Auth_Adapter_Interface $adapter) {
        $this->adapter = $adapter;
    }
}