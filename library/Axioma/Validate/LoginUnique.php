<?php

namespace Axioma\Validate;

class LoginUnique extends \Zend_Validate_Db_Abstract {

    /** @todo переписать, чтоб не требовал имя таблицы и поля */
    public function isValid($value) {
        $valid = true;
        $this->_setValue($value);

        $excluded = \array_shift($this->getExclude());
        if ($valid == $excluded) return $valid;

        $userMapper = new \Db\Users();
        $result = $userMapper->getByLogin($value);
        if ($result) {
            $valid = false;
            $this->_error(self::ERROR_RECORD_FOUND);
        }

        return $valid;
    }
}