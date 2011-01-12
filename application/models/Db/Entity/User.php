<?php

namespace Db\Entity;

use Axioma\Db\BaseEntity;

/**
 * Модель пользователя
 *
 * @Entity
 * @Table(name="users")
 */
class User extends BaseEntity {
    /** @Id @Column(type="integer") @GeneratedValue */
    protected $id;
    /** @Column(length=25) */
    protected $login;
    /** @Column(length=50) */
    protected $password;
    /** @Column(type="boolean") */
    protected $active;
    /** @Column(length=50) */
    protected $firstname;
    /** @Column(length=50) */
    protected $lastname;

    function __construct() {
        // значение по умолчанию для вновь созданных пользователей
        $this->active = false;
    }


    public function getLogin() {
        return $this->login;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function isActive() {
        return $this->active;
    }

    public function makeActive($active = true) {
        $this->active = $active;
    }

    public function getFirstname() {
        return $this->firstname;
    }

    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
    }
}