<?php

class Admin_Form_ChangePassword extends Zend_Form
{

    public function init()
    {
        $this->setName('password');

        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');


        $body = new Zend_Form_Element_Password('password');
        $body->setLabel($this->getView()->translate('Password'))
                ->setRequired(true)
                ->addValidator('NotEmpty')
                ->addValidator( new Admin_Form_PasswordValidator() );


        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton')
                ->setLabel($this->getView()->translate('Change'));

        $this->addElements(array($id,$body,$submit));
    }

}

