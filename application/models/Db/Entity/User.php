<?php

namespace Db\Entity;

use Axioma\Db\BaseEntity,
    Axioma\Date;

/**
 * Модель пользователя
 *
 * @Entity
 * @Table(name="users")
 * @HasLifecycleCallbacks
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
    protected $midname;
    /** @Column(length=50) */
    protected $lastname;
    /** @Column(type="richdate", nullable=true) */
    protected $birthdate;
    /** @Column(length=30, nullable=true) */
    protected $email;
    /** @Column(length=15, nullable=true) */
    protected $homephone;
    /** @Column(length=15, nullable=true) */
    protected $cellphone;
    /** @Column(length=100, nullable=true) */
    protected $addressreg;
    /** @Column(length=100, nullable=true) */
    protected $addressfact;
    /** @Column(type="richdate", nullable=true) */
    protected $hiredate;
    /** @Column(type="richdate", nullable=true) */
    protected $retiredate;
    /** @Column(length="200", nullable=true) */
    protected $avatar;
    /** @Column(length="200", nullable=true) */
    protected $summary;
    /** @Column(type="richdate", nullable=true) */
    protected $last_login_at;
    /** @Column(type="richdate") */
    protected $created_at;

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

    public function getMidname() {
        return $this->midname;
    }

    public function setMidname($midname) {
        $this->midname = $midname;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    public function getBirthdate() {
        return $this->birthdate;
    }

    public function setBirthdate($birthdate) {
        if ($birthdate instanceof Date)
            $this->birthdate = $birthdate;
        elseif ($birthdate)
            $this->birthdate = new Date($birthdate);
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getHomephone() {
        return $this->homephone;
    }

    public function setHomephone($homephone) {
        $this->homephone = $homephone;
    }

    public function getCellphone() {
        return $this->cellphone;
    }

    public function setCellphone($cellphone) {
        $this->cellphone = $cellphone;
    }

    public function getAddressreg() {
        return $this->addressreg;
    }

    public function setAddressreg($addressreg) {
        $this->addressreg = $addressreg;
    }

    public function getAddressfact() {
        return $this->addressfact;
    }

    public function setAddressfact($addressfact) {
        $this->addressfact = $addressfact;
    }

    public function getHiredate() {
        return $this->hiredate;
    }

    public function setHiredate($hiredate) {
        if ($hiredate instanceof Date)
            $this->hiredate = $hiredate;
        elseif ($hiredate)
            $this->hiredate = new Date($hiredate);
    }

    public function getRetiredate() {
        return $this->retiredate;
    }

    public function setRetiredate($retiredate) {
        if ($retiredate instanceof Date)
            $this->retiredate = $retiredate;
        elseif ($retiredate)
            $this->retiredate = new Date($retiredate);
    }

    public function getAvatar() {
        return $this->avatar;
    }

    public function setAvatar($avatar) {
        $this->avatar = $avatar;
    }

    public function getSummary() {
        return $this->summary;
    }

    public function setSummary($summary) {
        $this->summary = $summary;
    }

    public function getCreated_at() {
        return $this->created_at;
    }

    /** @PrePersist */
    public function markCreationTime() {
        $this->created_at = new Date();
    }

    public function getLast_login_at() {
        return $this->last_login_at;
    }

    public function setLast_login_at($last_login_at) {
        if ($last_login_at instanceof \Zend_Date)
            $this->last_login_at = $last_login_at;
        else
            $this->last_login_at = new \Zend_Date($last_login_at);
    }

    public function postAuthenticate(\Doctrine\Common\EventArgs $args) {
        $this->last_login_at = new \Zend_Date();
    }
}