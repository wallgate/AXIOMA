<?php

namespace Axioma\Form\Decorator\Strategy;

/**
 * Интерфейс стратегии декорирования. Его реализация определяет, какие
 * декораторы будут установлены для элементов формы
 */
interface DecorationInterface {
    public function getInputDecorators();
    public function getButtonDecorators();
    public function getFileDecorators();
    public function getFormDecorators();
    public function getCheckboxDecorators();
}