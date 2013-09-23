<?php

class Support_Form_WhatStat extends Zend_Form {

    public function init() {

        $this->setName('report');

        ZendX_JQuery::enableForm($this);

        $datefrom = new Zend_Form_Element_Text('from');
        $datefrom->setLabel($this->getView()->translate('Date From'))
                ->setRequired(true);

        $dateto = new Zend_Form_Element_Text('to');
        $dateto->setLabel($this->getView()->translate('Date To'))
                ->setRequired(true);

        $destGroup = new Zend_Form_Element_Select('group');
        $destGroup->setLabel($this->getView()->translate('Select group'))
                  ->setRequired(true);

        $departmentsDb = new Admin_Model_DbTable_Groups();
        $results = $departmentsDb->fetchAll();
        foreach($results as $c) {
            $destGroup->addMultiOption($c->groupId, $c->name);
        }


        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton')->setLabel($this->getView()->translate('Create raport'));


        $this->addElements(array($datefrom,$dateto,$destGroup,$submit));
    }

}

