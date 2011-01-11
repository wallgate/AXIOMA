<?php

/**
 * Cкрипт, задача которого - удалить БД, затем построить её заново на основе
 * определённых в приложении моделей и заполнить вновь созданные таблицы данными
 * из файла фикстур
 */

define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

define('APPLICATION_ENV', 'development');

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/models'),
    get_include_path(),
)));


require_once 'Zend/Application.php';

$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap('doctrine');

// получаем EntityManager
$em = $application->getBootstrap()->getResource('doctrine');
$tool = new \Doctrine\ORM\Tools\SchemaTool($em);
$classes = $em->getMetadataFactory()->getAllMetadata();

// удаляем БД
$tool->dropDatabase();
fwrite(STDOUT, "database dropped" . PHP_EOL);

// строим заново
$tool->createSchema($classes);
fwrite(STDOUT, "schema created" . PHP_EOL);

// заполняем данными
require APPLICATION_PATH . '/configs/fixtures.php';
if (is_array($entities))
    foreach ($entities as $entity)
        $em->persist($entity);
fwrite(STDOUT, "fixtures loaded" . PHP_EOL);

// применяем изменения
$em->flush();