<?php

namespace Axioma\Form\Decorator\Strategy;

/**
 * Пресеты декораторов для формы авторизации
 */
class Login extends Table {

    public function getInputDecorators() {
        return array(
            'ViewHelper',
            array(array('tdTag'=>'HtmlTag'), array('tag'=>'td', 'valign'=>'top')),
            array('Label', array('tag'=>'td', 'placement'=>'prepend')),
            array(array('trTag'=>'HtmlTag'), array('tag'=>'tr', 'valign'=>'top'))
        );
    }

    public function getFormDecorators() {
        return array(
            'FormElements',
            array('HtmlTag', array('tag'=>'table')),
            array('Form', array('class'=>'loginForm'))
        );
    }
}