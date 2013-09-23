<?php

class Support_Form_AddSupportRequestReplyForm extends Zend_Form
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


        $statuses = new Support_Model_DbTable_RequestStatuses();
        $results = $statuses->getNames();


        $end = new Zend_Form_Element_Select('what');
        $end->setLabel($this->getView()->translate('Answer status'));

        foreach($results as $c)
        {
            $end->addMultiOption($c->statusId,$c->name);
        }

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($ticketId, $id, $body, $submit, $end));
    }


}

