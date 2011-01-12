<?php

namespace Axioma\Test;

use Form\Login,
    Axioma\Form\Decorator\Strategy\Login as LoginStrategy;

class LoginTest extends ControllerTestCase {

    protected $form;

    public function setUp() {
        parent::setUp();
        
        $this->form = new Login(new LoginStrategy());
    }

    public function testCreateForm() {
        // проверяем, правильно ли сформировалась форма
        $this->assertInstanceOf('Axioma\Form\Base', $this->form);
        $this->assertInstanceOf('Zend_Form_Element_Text', $this->form->getElement('login'));
        $this->assertInstanceOf('Zend_Form_Element_Password', $this->form->getElement('password'));
        $this->assertInstanceOf('Zend_Form_Element_Submit', $this->form->getElement('submit'));
    }

    public function testProcessSuccess() {
        $stubData = array('login'=>'somename', 'password'=>'somepass');

        // пользователь-заглушка, которого вернёт mock-объект
        $fakeUser = new \Db\Entity\User();
        $fakeUser->login    = $stubData['username'];
        $fakeUser->password = $stubData['password'];

        // замещающий объект (адаптер аутентификации)
        $mock = $this->getMockBuilder('Axioma\Auth\Adapter')        // класс, которым прикидывается mock-объект
            ->disableOriginalConstructor()                          // отключаем конструктор адаптера
            ->setMethods(array('authenticate'))                     // замещаемые методы
            ->getMock();
        $mock->expects($this->once())
             ->method('authenticate')
             ->will($this->returnValue(new \Zend_Auth_Result(\Zend_Auth_Result::SUCCESS, $fakeUser)));
        $this->form->setAdapter($mock);
        $this->form->populate($stubData);
        $this->form->process();

        \Zend_Auth::getInstance()->clearIdentity();
    }

    /**
     * @expectedException \Axioma\Exception
     */
    public function testProcessFailure() {
        $stubData = array('login'=>'wrongname', 'password'=>'wrongpass');

        // замещающий объект (адаптер аутентификации)
        $mock = $this->getMockBuilder('Axioma\Auth\Adapter')        // класс, которым прикидывается mock-объект
            ->disableOriginalConstructor()                          // отключаем конструктор адаптера
            ->setMethods(array('authenticate'))                     // замещаемые методы
            ->getMock();
        $mock->expects($this->once())
             ->method('authenticate')
             ->will($this->returnValue(new \Zend_Auth_Result(\Zend_Auth_Result::FAILURE, null)));
        $this->form->setAdapter($mock);
        $this->form->populate($stubData);
        $this->form->process();
        
        $this->fail('Валидация формы не сработала');
    }

    public function testProcessInvalid() {
        try {
            $this->form->process();
            $this->fail('Валидация формы не сработала');
        } catch (\Axioma\Exception $e) {
            $this->assertEquals(Login::ERROR_INVALID, $e->getMessage());
        }
    }
}