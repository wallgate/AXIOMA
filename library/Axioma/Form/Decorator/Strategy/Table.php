<?php

namespace Axioma\Form\Decorator\Strategy;

class Table implements DecorationInterface {

    public function getFormDecorators() {
        return array(
            'FormElements',
            array('HtmlTag', array('tag'=>'table')),
            'Form'
        );
    }

    public function getInputDecorators() {
        return array(
            'ViewHelper',
            'Errors',
            array(array('tdTag'=>'HtmlTag'), array('tag'=>'td', 'valign'=>'top')),
            array('InfoBlock', array('tag'=>'td', 'placement'=>'prepend', 'wrapperClass'=>'col1')),
            array(array('trTag'=>'HtmlTag'), array('tag'=>'tr', 'valign'=>'top'))
        );
    }

    public function getButtonDecorators() {
        return array(
            'ViewHelper',
            array(array('tdTag'=>'HtmlTag'), array('tag'=>'td', 'colspan'=>2, 'align'=>'center')),
            array(array('trTag'=>'HtmlTag'), array('tag'=>'tr'))
        );
    }

    public function getFileDecorators() {
        return array(
            'File',
            'Errors',
            array(array('tdTag'=>'HtmlTag'), array('tag'=>'td', 'valign'=>'top')),
            array('InfoBlock', array('tag'=>'td', 'placement'=>'prepend', 'wrapperClass'=>'col1')),
            array(array('trTag'=>'HtmlTag'), array('tag'=>'tr', 'valign'=>'top'))
        );
    }

    public function getCheckboxDecorators() {
        return array(
            'ViewHelper',
            array('Label', array('placement'=>'append')),
            array(array('tdTag'=>'HtmlTag'), array('tag'=>'td', 'valign'=>'top')),
            array(array('emptyCell'=>'HtmlTag'), array('tag'=>'td', 'placement'=>'prepend')),
            array(array('trTag'=>'HtmlTag'), array('tag'=>'tr', 'valign'=>'top'))
        );
    }
}