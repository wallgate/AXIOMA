<?php

namespace Axioma\Form;

interface AuthInterface {

    /**
     * Установка адаптера аутентификации
     * @param \Zend_Auth_Adapter_Interface $adapter
     */
    public function setAdapter(\Zend_Auth_Adapter_Interface $adapter);
}