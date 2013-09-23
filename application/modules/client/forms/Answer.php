<?php

class Client_Form_Answer extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */
        $this->setName('answer');

        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');
        
        $subject = new Zend_Form_Element_Text('subject');
        $subject->setLabel($this->getView()->translate('Subject'))
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty');

        $body = new Zend_Form_Element_Textarea('body');
        $body->setLabel($this->getView()->translate('Answer'))
                ->setRequired(true)
                ->addValidator('NotEmpty')
                ->setOptions(array('rows'=>'10'));

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($id, $subject, $body, $submit));
    }
}

?>