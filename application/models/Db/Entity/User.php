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
    /** @Column(length=50) */
    protected $firstname;
    /** @Column(length=50) */
    protected $lastname;

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