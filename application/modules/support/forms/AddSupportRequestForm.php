<?php

class Support_Form_AddSupportRequestForm extends Zend_Form
{

    public function init()
    {
        $this->setName('supportrequest');

        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

        $subject = new Zend_Form_Element_Text('subject');
        $subject->setLabel($this->getView()->translate('Subject'))
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty');

        $body = new Zend_Form_Element_Textarea('requestbody');
        $body->setLabel($this->getView()->translate('Body'))
                ->setRequired(true)
                ->addValidator('NotEmpty')
                ->setOptions(array('rows'=>'10'));
                
        $destGroup = new Zend_Form_Element_Select('department');
        $destGroup->setLabel($this->getView()->translate('Department'));
        
        $departmentsDb = new Support_Model_DbTable_Departments();
        $results = $departmentsDb->getNames();
        foreach($results as $c) {
            $destGroup->addMultiOption($c->departmentId, $c->departmentName);
        }
        
        $reqType = new Zend_Form_Element_Select('requesttype');
        $reqType->setLabel($this->getView()->translate('Request type'));
        
        $reqtypeDb = new Support_Model_DbTable_Tickettypesrequest();
        $results = $reqtypeDb->getNames();
        foreach($results as $c) {
            $reqType->addMultiOption($c->id, $c->name);
        }

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($id, $subject, $body, $destGroup, $reqType, $submit));

    }


}

