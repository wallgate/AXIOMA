<?php

use Db\Entity\User;

$admin = new User();
$admin->login      = 'admin';
$admin->password   = 'root';
$admin->firstname  = 'Игорь';
$admin->midname    = 'Иванович';
$admin->lastname   = 'Семёнов';
$admin->birthdate  = '06.08.1981';
$admin->hiredate   = '11.01.2010';
$admin->makeActive();
$entities[] = $admin;

$developer = new User();
$developer->login      = 'developer';
$developer->password   = '12345';
$developer->firstname  = 'Пётр';
$developer->midname    = 'Алексеевич';
$developer->lastname   = 'Иванов';
$developer->birthdate  = '14.02.1985';
$developer->hiredate   = '03.03.2008';
$developer->retiredate = '10.12.2010';
$entities[] = $developer;

$manager = new User();
$manager->login     = 'manager';
$manager->password  = '67890';
$manager->firstname = 'Настя';
$manager->midname   = 'Петровна';
$manager->lastname  = 'Рыжкова';
$manager->birthdate = '03.11.1978';
$entities[] = $manager;