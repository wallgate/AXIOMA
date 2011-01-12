<?php

namespace Axioma\Test;

class InfoBlockTest extends ControllerTestCase {

    const DESCRIPTION = 'Testing InfoBlock decorator';

    protected $form;

    public function setUp() {
        parent::setUp();

        $this->form = new \Zend_Form();
        $this->form = $this->form->addPrefixPath('Axioma\Form\Decorator\\', 'Axioma/Form/Decorator', 'decorator');

        $e = new \Zend_Form_Element_Text('test');
        $e->setLabel('Element')
          ->setDescription(self::DESCRIPTION)
          ->setRequired()
          ->setDecorators(array(
              'ViewHelper',
              array('InfoBlock', array('tag'=>'p', 'wrapperClass'=>'wClass'))
          ));

        $this->form = $this->form->addElement($e)
                                 ->setDecorators(array('FormElements', 'Form'))
                                 ->render(new \Zend_View);
    }

    public function testRenderDecorator() {
        echo $this->form;
        $this->assertSelectRegExp('p.wClass', '/Element/is', true, $this->form);
        $this->assertSelectCount('span.asterisk', true, $this->form);
        $this->assertTag(array(
            'tag'        => 'small',
            'attributes' => array('class' => 'description'),
            'content'    => self::DESCRIPTION
        ), $this->form);
    }
}