<?php

namespace Db;

use Axioma\Db\BaseService,
    Axioma\Db\AuthServiceInterface;

/**
 * Сервис для модели пользователя
 */
class UserService extends BaseService implements AuthServiceInterface {

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
    
    /**
     * Аутентификация пользователя по логину и паролю
     *
     * @param string $login логин
     * @param string $password пароль
     * @return User
     */
    public function authenticate($login, $password) {
        $user = $this->getByLogin($login);
        if ($user instanceof Entity\User)
            if ($user->password == $password && $user->isActive()) /** @todo шифровать пароль */
                return $user;
    }
}