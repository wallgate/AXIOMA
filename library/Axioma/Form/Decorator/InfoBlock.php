<?php

namespace Axioma\Form\Decorator;

/**
 * Декоратор, объединяющий в себе декораторы Label и Description.
 * Позволяет назначить класс обрамляющему тегу (опция "wrapperClass").
 * К меткам полей, помеченных как необходимые, добавляет символ *.
 */
class InfoBlock extends \Zend_Form_Decorator_Abstract {

    public function render($content) {

        // формирование тега label
        $infoBlock = sprintf('<label for="%s"%s>%s%s</label>',
            $this->getElement()->getName(),
            $this->getElement()->isRequired() ? ' class="required"' : '',
            $this->getElement()->getLabel(),
            $this->getElement()->isRequired() ? ' <span class="asterisk">*</span>' : ''
        );

        // добавление описания
        if ($this->getElement()->getDescription())
            $infoBlock .= '<br/><small class="description">'.$this->getElement()->getDescription().'</small>';

        // объёртывание в указанный тег и добавление CSS-класса
        $htmlTag   = $this->getOption('tag');
        $tagClass  = $this->getOption('wrapperClass');
        if (!empty($htmlTag)) {
            if (!empty($tagClass)) $class = ' class="' . $tagClass . '"';
            $infoBlock = sprintf('<%s%s>%s</%s>', $htmlTag, $class, $infoBlock, $htmlTag);
        }

        return $this->getPlacement() == 'append'
            ? $content . $infoBlock
            : $infoBlock . $content;
    }
}