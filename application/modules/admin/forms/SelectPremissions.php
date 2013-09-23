<?php

class Admin_Form_SelectPremissions extends Zend_Form {

    public function init() {
        $this->setName('premission');

        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

        $categoryDb = new Admin_Model_DbTable_Departments();
        $results = $categoryDb->fetchAll();

        $category = new Zend_Form_Element_Select('groupId');
        $category->setLabel($this->getView()->translate('Department'));

        foreach ($results as $c) {
            $category->addMultiOption($c->departmentId, $c->departmentName);
        }


        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($id, $category, $submit));
    }

}

