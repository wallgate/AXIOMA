<?php

namespace Axioma\Form;

/**
 * Базовый класс формы, от которого следует наследовать конкретные формы
 * в приложении
 */
abstract class Base extends \Zend_Form {

    /**
     * Стратегия, возвращающая наборы декораторов
     * @var Decorator\Strategy\DecorationInterface
     */
    protected $decorationStrategy;

    /**
     *
     * @param Decorator\Strategy\DecorationInterface $decorationStrategy
     * @param array $data параметры запроса
     */
    function __construct(Decorator\Strategy\DecorationInterface $decorationStrategy, $data = array()) {
        $this->decorationStrategy = $decorationStrategy;
        $this->build($data);
    }

    /**
     * Построение формы - создание элементов, добавление валидаторов,
     * декораторов и т.д.
     *
     * @param array $data параметры запроса
     * @return Base
     */
    abstract protected function build($data = array());

    /**
     * Обработка формы - проверка входных данных на валидность и их обработка
     *
     * @throws Axioma\Exception
     */
    abstract public function process();
}