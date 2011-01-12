<?php

namespace Axioma\Form\Decorator\Strategy;

class TableMultigroup extends Table {

    public function getFormDecorators() {
        return array('FormElements', 'Form');
    }

    public function getDisplayGroupDecorators() {
        return array(
            'FormElements',
            array('HtmlTag', array('tag'=>'table', 'class'=>'displayGroup')),
        );
    }
}