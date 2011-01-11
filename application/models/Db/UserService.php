<?php

namespace Db;

use Axioma\Db\BaseService;

/**
 * Сервис для модели пользователя
 */
class UserService extends BaseService {
    
    const ENTITY_NAME = '\Db\Entity\User'; // имя сущности Doctrine2, с которой работает сервис

    /**
     * Достаёт из БД информацию о пользователе. Возвращает массив ассоциативных
     * массивов
     * 
     * @return array
     */
    public function all() {
        return $this->entityManager->createQueryBuilder()
            ->select('p')
            ->from(self::ENTITY_NAME, 'p')
            ->orderBy('p.lastname, p.firstname')
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    /**
     * Находит пользователя по его логину
     *
     * @param string $login логин
     * @return \Db\Entity\Person
     */
    public function getByLogin($login) {
        return $this->entityManager
            ->getRepository(self::ENTITY_NAME)
            ->findOneByLogin($login);
    }
}