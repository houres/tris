<?php

class Support_Form_ChangeDepartmentForm extends Zend_Form {

    public function init() {
        $this->setName('department');

        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

        $db = new Support_Model_DbTable_Departments();
        $results = $db->getNames();

        $department = new Zend_Form_Element_Select('department');
        $department->setLabel($this->getView()->translate('Department'));

        foreach ($results as $c) {
            $department->addMultiOption($c->departmentId, $c->departmentName);
        }

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($id, $department, $submit));
    }

}

