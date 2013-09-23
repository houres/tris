<?php

/**
 * Klasa Admin_Form_CreateUser jest odpowiedzialna za formularz tworzenia nowego użytkownika.
 * Rozszerza klasę Zend_Form
 */
class Admin_Form_CreateUser extends Zend_Form {

    public function init() {
        $this->setName('user');

        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

        $validator = new Zend_Validate_Db_NoRecordExists(
                        array(
                            'table' => 'users',
                            'field' => 'login'
                        )
        );

        $subject = new Zend_Form_Element_Text('login');
        $subject->setLabel($this->getView()->translate('Username'))
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->addValidator($validator);

        $password = new Zend_Form_Element_Password('password');
        $password->setLabel($this->getView()->translate('Password'))
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->addValidator( new Admin_Form_PasswordValidator() );

        $categoryDb = new Admin_Model_DbTable_Groups();
        $results = $categoryDb->fetchAll();

        $category = new Zend_Form_Element_Select('groupId');
        $category->setLabel($this->getView()->translate('Group'));

        foreach ($results as $c) {
            $category->addMultiOption($c->groupId, $c->name);
        }

        $enabled = new Zend_Form_Element_Select('active');
        $enabled->setLabel('Enabled');
        $enabled->addMultiOptions(array('0' => 'Disabled', '1' => 'Enabled'));


        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton')
                ->setLabel($this->getView()->translate('Add user'));

        $this->addElements(array($id, $subject,$password, $category, $enabled, $submit));
    }

}

