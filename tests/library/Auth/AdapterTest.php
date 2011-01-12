<?php

namespace Axioma\Test;

use Axioma\Auth\Adapter;

class AdapterTest extends ControllerTestCase {

    public function testAuthSuccess() {
        $stubData = array('login'=>'somename', 'password'=>'somepass');

        // пользователь, которого вернёт mock-объект
        $fakeUser = new \Db\Entity\User();
        $fakeUser->login    = $stubData['login'];
        $fakeUser->password = $stubData['password'];

        // сам mock-объект (сервис пользователя)
        $mock = $this->getMockBuilder('Db\UserService')
                     ->disableOriginalConstructor()
                     ->setMethods(array('authenticate'))
                     ->getMock();
        $mock->expects($this->once())
             ->method('authenticate')
             ->will($this->returnValue($fakeUser));

        // непосредственно тест работы адаптера
        $adapter = new Adapter($mock);
        $adapter->setLogin($stubData['login']);
        $adapter->setPassword($stubData['password']);
        
        $result = \Zend_Auth::getInstance()->authenticate($adapter);

        $this->assertEquals(\Zend_Auth_Result::SUCCESS, $result->getCode());
        $this->assertTrue(\Zend_Auth::getInstance()->hasIdentity());
        $this->assertEquals($fakeUser, \Zend_Auth::getInstance()->getIdentity());

        // очистка данных в сессии
        \Zend_Auth::getInstance()->clearIdentity();
    }

    public function testAuthFailure() {
        $stubData = array('login'=>'wrongname', 'password'=>'wrongpass');

        // mock-объект - на этот раз он вернёт NULL
        $mock = $this->getMock('Db\UserService', array('authenticate'), array(\Zend_Registry::get('em')));
        $mock->expects($this->once())
             ->method('authenticate')
             ->will($this->returnValue(NULL));

        // тест работы адаптера
        $adapter = new Adapter($mock);
        $adapter->setLogin($stubData['login']);
        $adapter->setPassword($stubData['password']);
        $result = \Zend_Auth::getInstance()->authenticate($adapter);
        $this->assertEquals(\Zend_Auth_Result::FAILURE, $result->getCode());
        $this->assertFalse(\Zend_Auth::getInstance()->hasIdentity());
    }

}