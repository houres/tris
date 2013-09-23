<?php

/**
 * Klasa Admin_Form_CreateUser jest odpowiedzialna za formularz tworzenia nowego użytkownika.
 * Rozszerza klasę Zend_Form
 */
class Admin_Form_EditUser extends Zend_Form {

    public function init() {
        $this->setName('user');

        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

        $subject = new Zend_Form_Element_Text('login');
        $subject->setLabel($this->getView()->translate('Username'))
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty');

        $categoryDb = new Admin_Model_DbTable_Groups();
        $results = $categoryDb->fetchAll();

        $category = new Zend_Form_Element_Select('groupId');
        $category->setLabel($this->getView()->translate('Group'));

        foreach ($results as $c) {
            $category->addMultiOption($c->groupId, $c->name);
        }

        $enabled = new Zend_Form_Element_Select('active');
        $enabled->setLabel('Enabled');
        $enabled->addMultiOptions(array('0' => $this->getView()->translate('Disabled'), '1' => $this->getView()->translate('Enabled')));


        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($id, $subject, $category, $enabled, $submit));
    }

}

