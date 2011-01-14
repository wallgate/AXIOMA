<?php

namespace Axioma\Controller\Plugin;

/**
 * Плагин фронт-контроллера, закрывающий систему неаутентифицированному пользователю
 */
class Acl extends \Zend_Controller_Plugin_Abstract {

    /*
     * Набор контроллеров, где плагин действовать не должен
     */
    private $exceptions = array();

    public function dispatchLoopStartup(\Zend_Controller_Request_Abstract $request) {
        $controller = $request->getControllerName();
        if (in_array($controller, $this->exceptions)) return; // если контроллер входит в исключения - ничего не делать

        if (!\Zend_Auth::getInstance()->hasIdentity()) {
            /** @todo хранить, конечно, нужно не просто id */
            $auth_id = $this->getRequest()->getCookie('auth_id');
            if ($auth_id) {
                $user = \Zend_Registry::get('em')->find('\Db\Entity\User', $auth_id);
                if ($user instanceof \Db\Entity\User) {
                    \Zend_Auth::getInstance()->getStorage()->write($user);
                    return;
                }
            }

            $redirector = \Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
            $redirector->gotoUrl('/login');
        }
    }

    /**
     * Установка контроллеров, где плагин действовать не должен
     * @param array $exceptions исключения
     */
    public function setExceptions(array $exceptions) {
        $this->exceptions = $exceptions;
    }
}