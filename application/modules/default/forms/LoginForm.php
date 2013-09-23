<?php
/**
 * 
 * Form_LoginForm klasa odpowiedzialna za formularz logowania.
 * Rozszerza Zend_Form
 *
 */
class Form_LoginForm extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
               $this->setName("login");
        $this->setMethod('post');

        $this->addElement('text', 'username', array(
            'filters'    => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required'   => true,
            'label'      => $this->getView()->translate('Username'),
        ));

        $this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required'   => true,
            'label'      => $this->getView()->translate('Password'),
        ));

        $this->addElement('submit', 'login', array(
            'required' => false,
            'ignore'   => true,
            'label'    => $this->getView()->translate('Login'),
        ));        
    }


}

