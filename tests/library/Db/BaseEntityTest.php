<?php

namespace Axioma\Test;

require_once 'stubs/Entity.php';

class BaseEntityTest extends ControllerTestCase {
    
    protected $entity;

    public function setUp() {
        parent::setUp();
        $this->entity = new Stub\Entity();
    }

    public function testMagicGettersSetters() {
        $this->assertInstanceOf('Axioma\Db\BaseEntity', $this->entity);

        $this->entity->dataField = 'test_value';
        $checkValue = $this->entity->dataField;
        $this->assertEquals('test_value', $checkValue);

        $this->entity->noField = 'test_value';
        $checkValue = $this->entity->noField;
        $this->assertNull($checkValue);

        $this->assertNull($this->entity->idField);
    }

    /**
     * @depends testMagicGettersSetters
     */
    public function testArrayImportExport() {
        $checkArray = $this->entity->toArray();
        $this->assertType('array', $checkArray);
        $this->assertArrayHasKey('dataField', $checkArray);
        $this->assertArrayNotHasKey('noField', $checkArray);

        $checkArray['dataField'] = 'new_value';
        $this->entity->fromArray($checkArray);
        $this->assertEquals('new_value', $this->entity->dataField);
    }
}