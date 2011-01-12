<?php

namespace Axioma\View\Helper;

/**
 * Помощник вида, предоставляющий информацию об аутентифицированном пользователе
 */
class Identity extends \Zend_View_Helper_Abstract {

    public function identity() {
        if (\Zend_Auth::getInstance()->hasIdentity()) {
            return \Zend_Auth::getInstance()->getIdentity();
        }
    }
}