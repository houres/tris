<?php

class Support_Form_AddAnswerForm extends Zend_Form
{

    public function init()
    {
        $this->setName('answer');

        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

        $subject = new Zend_Form_Element_Text('subject');
        $subject->setLabel($this->getView()->translate('Subject'))
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty');

        $body = new Zend_Form_Element_Textarea('answer');
        $body->setLabel($this->getView()->translate('Answer'))
                ->setRequired(true)
                ->addValidator('NotEmpty')
                ->setOptions(array('rows'=>'10'));

        $visible = new Zend_Form_Element_Select('public');
        $visible->setLabel($this->getView()->translate('Visible for user'));
        $visible->addMultiOptions(array('0'=>'No','1'=>'Yes'));

        $end = new Zend_Form_Element_Select('ending');
        $end->setLabel($this->getView()->translate('Is that end answer'));
        $end->addMultiOptions(array('0'=>'No','1'=>'Yes'));


        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($id, $subject, $body, $submit,$visible,$end));

    }


}

