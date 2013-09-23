<?php
/**
 * 
 * Form_Ticket klasa odpowiedzialna za formularz Ticketu
 * Rozszerza Zend_Form
 *
 */
class Form_Ticket extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setName('ticket');

        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

        $subject = new Zend_Form_Element_Text('subject');
        $subject->setLabel($this->getView()->translate('Topic'))
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty');

        $body = new Zend_Form_Element_Textarea('body');
        $body->setLabel($this->getView()->translate('Body'))
                ->setRequired(true)
                ->addValidator('NotEmpty');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($id,$subject,$body,$submit));

    }


}

