<?php

class Default_Form_UserDetails extends Zend_Form {

    public function init() {
        $this->setName('details');

        $name = new Zend_Form_Element_Text('name');
        $name->setLabel($this->getView()->translate('Name'));

        $surname = new Zend_Form_Element_Text('surname');
        $surname->setLabel($this->getView()->translate('Surname'));

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel($this->getView()->translate('Email'))
                ->addValidator('EmailAddress');

        $company = new Zend_Form_Element_Text('company');
        $company->setLabel($this->getView()->translate('Company'));

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $formId = new Zend_Form_Element_Hidden('formId');

        $this->addElements(array($name,$surname,$email,$company,$submit,$formId));

    }

}

