<?php

use \Doctrine\ORM\EntityManager,
    \Doctrine\ORM\Configuration,
    \Doctrine\Common\ClassLoader,
    \Doctrine\Common\Cache,
    \Doctrine\DBAL\Types\Type;

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    /**
     * Настройка представления
     * @return \Zend_View
     */
    protected function _initView() {
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');

        $options = $this->getOptions();

        $view = $layout->getView();
        $viewOptions = $options['resources']['view'];
        $view->doctype($viewOptions['doctype']);
        $view->headTitle($viewOptions['title']);
        $view->headMeta()->setHttpEquiv('Content-Type', $viewOptions['contentType'] . '; charset=' . $viewOptions['encoding']);
        // основная таблица стилей
        $view->headLink()->appendStylesheet('/public/css/main.css');
        // помощники представления - путь и пространство имён
        $view->addHelperPath('Axioma/View/Helper', 'Axioma\View\Helper\\');

        return $view;
    }

    /**
     * Настройка взаимодействия с Doctrine
     * @return EntityManager
     */
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

    /**
     * Настройка маршрутизатора
     */
    protected function _initRouter() {
        $router = Zend_Controller_Front::getInstance()->getRouter();

        // маршрут на логаут
        $router->addRoute('logout',
            new Zend_Controller_Router_Route('/logout', array('controller'=>'login', 'action'=>'logout'))
        );
    }

    /**
     * Регистрация плагинов фронт-контроллера
     */
    protected function _initPlugins() {
        $front = Zend_Controller_Front::getInstance();

        // плагин, закрывающий систему неаутентифицированному пользователю
        $aclPlugin = new Axioma\Controller\Plugin\Acl();
        $aclPlugin->setExceptions(array('login')); // должен работать везде, кроме контроллера LoginController
        $front->registerPlugin($aclPlugin);
    }
}