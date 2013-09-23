<?php

class Support_Form_SaveReport extends Zend_Form
{

    public function init()
    {
        $this->setName('ticket');

        $id = new Zend_Form_Element_Textarea('data');
        $id->setAttribs(array('style' => 'display:none;'));

        $type = new Zend_Form_Element_Hidden('type');
        

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');
        $submit->setLabel($this->getView()->translate('Save generated report'));
        $submit->setAttribs(array('style' => 'margin:0;'));

        $this->addElements(array($submit,$type,$id));
    }


}

