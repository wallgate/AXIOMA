<?php

namespace Axioma;

/**
 * Класс для хранения даты и преобразования её из одного формата в другой
 */
class Date extends \Zend_Date {

    const DATE_STANDARD     = 'd MMMM y';       //формат вида "1 января 2011"
    const DATETIME_STANDARD = 'd MMMM y, H:m';  //формат вида "1 января 2011, 12:30"

    public function __toString() {
        return $this->toString(self::DATE_STANDARD, $this->_locale);
    }
}