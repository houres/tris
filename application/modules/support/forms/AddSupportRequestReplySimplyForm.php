<?php

class Support_Form_AddSupportRequestReplySimplyForm extends Zend_Form
{

    public function init()
    {
        $this->setName('answer');

        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

        $ticketId = new Zend_Form_Element_Hidden('ticketId');
        $ticketId->addFilter('Int');

        $body = new Zend_Form_Element_Textarea('answer');
        $body->setLabel($this->getView()->translate('Answer'))
                ->setRequired(true)
                ->addValidator('NotEmpty')
                ->setOptions(array('rows'=>'10'));


        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($ticketId, $id, $body, $submit));
    }


}

