<?php

define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../../application'));

define('APPLICATION_ENV', 'testing');

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/models'),
    get_include_path(),
)));


require_once 'Zend/Application.php';
require_once 'ControllerTestCase.php';

$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap('doctrine');

$em = $application->getBootstrap()->getResource('doctrine');
$tool = new \Doctrine\ORM\Tools\SchemaTool($em);
$classes = $em->getMetadataFactory()->getAllMetadata();

$tool->dropDatabase();
$tool->createSchema($classes);
require APPLICATION_PATH . '/configs/fixtures.php';
if (is_array($entities))
    foreach ($entities as $entity)
        $em->persist($entity);

$em->flush();