<?php

namespace Axioma\Test;

class LoginControllerTest extends ControllerTestCase {

    public function testIndexAction() {
        $this->dispatch('/login');
        $this->assertController('login');
        $this->assertAction('index');
        $this->assertResponseCode(200);
        $this->assertQuery('form.loginForm');
    }

    public function testLoginFormPostbackFail() {
        $this->getRequest()->setMethod('post');
        $this->getRequest()->setPost(array('login'=>'nouser', 'password'=>'wrongpassword'));
        $this->dispatch('/login');
        $this->assertFalse(\Zend_Auth::getInstance()->hasIdentity());
        $this->assertNotRedirect();
    }

    public function testLoginFormPostbackSuccess() {
        $this->getRequest()->setMethod('post');
        $this->getRequest()->setPost(array('login'=>'admin', 'password'=>'root'));
        $this->dispatch('/login');

        $this->assertTrue(\Zend_Auth::getInstance()->hasIdentity());
        $this->assertEquals('admin', \Zend_Auth::getInstance()->getIdentity()->login);
        $this->assertRedirect('/');

        $this->dispatch('/login');
        $this->assertRedirect('/');
    }

    /**
     * @depends testLoginFormPostbackSuccess
     */
    public function testLogout() {
        $this->dispatch('/login/logout');
        $this->assertFalse(\Zend_Auth::getInstance()->hasIdentity());
        $this->assertRedirect('/login');
    }
}