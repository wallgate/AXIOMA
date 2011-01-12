<?php

namespace Axioma\Db;

/**
 * Интерфейс сервиса, добавляюший к базовому метод аутентификации по логину и паролю
 */
interface AuthServiceInterface {
    public function authenticate($login, $password);
}