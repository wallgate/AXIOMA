<?php

namespace Axioma\Test;

class AclTest extends ControllerTestCase {

    public function testRedirectIfUnauthorized() {
        $this->dispatch('/');
        $this->assertRedirectTo('/login');
    }

    public function testShowLoginFormIfUnauthorized() {
        $this->dispatch('/login');
        $this->assertResponseCode(200);
    }
}