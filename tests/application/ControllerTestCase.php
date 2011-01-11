<?php

namespace Axioma\Test;

require_once 'Zend/Test/PHPUnit/ControllerTestCase.php';

abstract class ControllerTestCase extends \Zend_Test_PHPUnit_ControllerTestCase {
    protected $application;

    public function  __construct($name = NULL, array $data = array(), $dataName = '') {
        parent::__construct($name, $data, $dataName);
        $this->backupGlobals = false;
        $this->backupStaticAttributes = false;
    }

    public function setUp() {
        $this->bootstrap = array('Axioma\Test\ControllerTestCase', 'appBootstrap');
        parent::setUp();
    }

    public function appBootstrap() {
        $this->application = new \Zend_Application(
            APPLICATION_ENV,
            APPLICATION_PATH . '/configs/application.ini'
        );
        $this->application->bootstrap();
    }
}