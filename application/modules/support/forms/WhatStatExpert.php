<?php

class Support_Form_WhatStatExpert extends Zend_Form {

    public function init() {

        $this->setName('report');

        ZendX_JQuery::enableForm($this);

        $datefrom = new Zend_Form_Element_Text('from');
        $datefrom->setLabel($this->getView()->translate('Date From'))
                 ->setRequired(true);

        $dateto = new Zend_Form_Element_Text('to');
        $dateto->setLabel($this->getView()->translate('Date To'))
               ->setRequired(true);


        $destGroup = new Zend_Form_Element_Select('department');
        $destGroup->setLabel($this->getView()->translate('Department'))
                  ->setRequired(true);

        $departmentsDb = new Support_Model_DbTable_Departments();
        $results = $departmentsDb->getNames();
        foreach($results as $c) {
            $destGroup->addMultiOption($c->departmentId, $c->departmentName);
        }

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton')->setLabel($this->getView()->translate('Create raport'));


        $this->addElements(array($datefrom,$dateto,$destGroup,$submit));
    }

}

