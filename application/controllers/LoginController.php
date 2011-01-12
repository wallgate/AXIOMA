<?php

class LoginController extends Zend_Controller_Action {

    public function init() {
        // отключаем представление
        $this->_helper->viewRenderer->setNoRender(true);
        // вместо стандартного макета ставим макет 'login.phtml'
        $this->_helper->layout()->setLayout('login');
    }

    public function indexAction() {
        // если пользователь уже авторизован, ему сюда нельзя
        if (Zend_Auth::getInstance()->hasIdentity())
            $this->_redirect('/');

        $form = new Form\Login(new Axioma\Form\Decorator\Strategy\Login());

        // если был постбэк
        if ($this->getRequest()->isPost()) {
            try {
                // создаём адаптер, передаём его в форму, заполняем её и обрабатываем данные
                $userService = new Db\UserService(\Zend_Registry::get('em'));
                $form->setAdapter(new Axioma\Auth\Adapter($userService));
                $form->populate($this->getRequest()->getParams());
                $form->process();
                // если ошибки до сих пор не возникло, то мы успешно авторизовались
                setcookie('auth_id', Zend_Auth::getInstance()->getIdentity()->id, time()+60*60*6); /** @todo хранить, конечно, нужно не просто id */
                // сохраняем время аутентификации
                Zend_Registry::get('em')->flush();
                $this->_redirect('/');
            } catch (Axioma\Exception $e) {
                $this->view->errorMessage = $e->getMessage();
            }
        }

        $this->view->form = $form;
    }

    public function logoutAction() {
        Zend_Auth::getInstance()->clearIdentity();
        setcookie('auth_id', Zend_Auth::getInstance()->getIdentity()->id, time()-1);
        $this->_redirect('/login');
    }
}