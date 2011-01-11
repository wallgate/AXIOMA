<?php

use Db\Entity\User;

$admin = new User();
$admin->login     = 'admin';
$admin->password  = 'root';
$admin->firstname = 'Игорь';
$admin->lastname  = 'Семёнов';
$entities[] = $admin;

$developer = new User();
$developer->login     = 'developer';
$developer->password  = '12345';
$developer->firstname = 'Пётр';
$developer->lastname  = 'Иванов';
$entities[] = $developer;

$manager = new User();
$manager->login     = 'manager';
$manager->password  = '67890';
$manager->firstname = 'Настя';
$manager->lastname  = 'Рыжкова';
$entities[] = $manager;