<?php

class Support_Form_ChangePriorityForm extends Zend_Form
{

    public function init()
    {
        $this->setName('priority');

        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

        $db = new Support_Model_DbTable_TicketTypes();
        $results = $db->getNames();

        $priority = new Zend_Form_Element_Select('priority');
        $priority->setLabel($this->getView()->translate('Priority'));

        foreach($results as $c)
        {
            $priority->addMultiOption($c->tickettypeId,$c->name);
        }

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($id,$priority,$submit));
    }


}

