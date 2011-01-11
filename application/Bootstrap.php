<?php

use \Doctrine\ORM\EntityManager,
    \Doctrine\ORM\Configuration,
    \Doctrine\Common\ClassLoader,
    \Doctrine\Common\Cache,
    \Doctrine\DBAL\Types\Type;

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initDoctrine() {
        require_once 'Doctrine/Common/ClassLoader.php';

        $zendAutoloader = Zend_Loader_Autoloader::getInstance();

        $classloader = array(new ClassLoader('Doctrine'), 'loadClass');
        $zendAutoloader->pushAutoloader($classloader, 'Doctrine\\');

        // Настройка Doctrine2
        $config = new Configuration();

        if (APPLICATION_ENV == "development") {
            $cache = new Cache\ArrayCache;
        } else {
            $cache = new Cache\ApcCache;
        }
        $config->setMetadataCacheImpl($cache);
        $driverImpl = $config->newDefaultAnnotationDriver(APPLICATION_PATH . '/models');
        $config->setMetadataDriverImpl($driverImpl);
        $config->setQueryCacheImpl($cache);
        $config->setProxyDir(APPLICATION_PATH . '/models/Db/Proxy');
        $config->setProxyNamespace('Db\Proxy');
        if (APPLICATION_ENV == "development") {
            $config->setAutoGenerateProxyClasses(true);
        } else {
            $config->setAutoGenerateProxyClasses(false);
        }

        // Соединение с БД
        $dbConfig = $this->getOption('db');
        $connectionOptions = array(
            'driver'        => 'pdo_mysql',
            'user'          => $dbConfig['username'],
            'password'      => $dbConfig['password'],
            'dbname'        => $dbConfig['dbname'],
            'charset'       => 'UTF8',
            'driverOptions' => array('charset' => 'UTF8')
        );
        $em = EntityManager::create($connectionOptions, $config);

        // EntityManager сохраняем в реестре, чтобы иметь доступ к нему в любой точке приложения
        Zend_Registry::set('em', $em);

        return $em;
    }
}