<?php

namespace Axioma\Test\Stub;

/**
 * @Entity
 */
class Entity extends \Axioma\Db\BaseEntity {
    /** @Id @GeneratedValue @Column(type="integer") */
    protected $idField;
    /** @Column(length=15) */
    protected $dataField;

    public function getDataField() {
        return $this->dataField;
    }

    public function setDataField($dataField) {
        $this->dataField = $dataField;
    }
}