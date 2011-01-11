<?php

namespace Axioma\Test;

use Db\UserService;

class UsersTest extends ControllerTestCase {

    /**
     * @var Db\UserService
     */
    private $userService;

    public function setUp() {
        parent::setUp();
        $this->userService = new UserService(\Zend_Registry::get('em'));
    }

    public function testGetEveryone() {
        $users = $this->userService->all();
        $this->assertType('array', $users);
        $this->assertEquals(3, \count($users));
        $this->assertLessThanOrEqual($users[0]->lastname, $users[1]->lastname);
    }

    public function testGetUserByLogin() {
        $user = $this->userService->getByLogin('admin');
        $this->assertInstanceOf('\Db\Entity\User', $user);
        $this->assertEquals('admin', $user->login);
    }
}