<?php

namespace Axioma\Db;

/**
 * Абстрактный класс сущности Doctrine2
 *
 * Облегчает доступ к свойствам модели (через магические методы), позволяет
 * импортировать данные в модель из массива и экспортировать в массив.
 *
 * Магические методы сработают, только если в классе сущности есть
 * соответствующий геттер/сеттер
 */
abstract class BaseEntity {
    
    public function &__get($name) {
        return $this->get($name);
    }

    public function __set($name, $value) {
        $this->set($name, $value);
    }

    private function get($name) {
        $method = 'get' . \ucfirst(\strtolower($name));
        if (method_exists($this, $method))
            return $this->$method();
    }

    private function set($name, $value) {
        $method = 'set' . \ucfirst(\strtolower($name));
        if (method_exists($this, $method))
            $this->$method($value);
    }

    /**
     * Импорт данных из массива
     * @param array $array
     * @return Entity
     */
    public function fromArray(array $array) {
        if (count($array))
            foreach ($array as $field=>$value)
                $this->set($field, $value);
        return $this;
    }

    /**
     * Экспорт данных модели в массив
     * @return array
     */
    public function toArray() {
        foreach (\get_object_vars($this) as $key=>$value)
            $out[$key] = $this->get($key);
        return $out;
    }
}