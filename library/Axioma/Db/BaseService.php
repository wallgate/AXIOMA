<?php

namespace Axioma\Db;

use Doctrine\ORM\EntityManager;

/**
 * Абстрактный класс сервиса. Сервисы управляют сущностями Doctrine2 и отделяют
 * их от уровня контроллеров
 */
abstract class BaseService {

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em) {
        $this->entityManager = $em;
    }
}