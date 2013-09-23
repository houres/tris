<?php

class Support_Form_Createticket extends Zend_Form
{

    public function init() {
        /* Form Elements & Other Definitions Here ... */
        $this->setName('ticket');

        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

        $subject = new Zend_Form_Element_Text('subject');
        $subject->setLabel($this->getView()->translate('Subject'))
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty');

        $body = new Zend_Form_Element_Textarea('body');
        $body->setLabel($this->getView()->translate('Body'))
                ->setRequired(true)
                ->addValidator('NotEmpty')
                ->setOptions(array('rows'=>'10'));

        $categoryDb = new Client_Model_DbTable_Categories();
        $results = $categoryDb->getNames();

        $category = new Zend_Form_Element_Select('category');
        $category->setLabel($this->getView()->translate('Category'));

        foreach($results as $c)
        {
            $category->addMultiOption($c->categoryId,$c->name);
        }

        $type = new Zend_Form_Element_Select('type');
        $type->setLabel($this->getView()->translate('Type'));

        $typeDb = new Client_Model_DbTable_Tickettypes();
        $results = $typeDb->getNames();

        foreach($results as $c) {
            $type->addMultiOption($c->tickettypeId,$c->name);
        }

        $owner = new Zend_Form_Element_Select('owner');
        $owner->setLabel($this->getView()->translate('Client'));

        $typeDb = new Support_Model_DbTable_Clients();
        $results = $typeDb->showUsersByGroupId(5);

        foreach($results as $c) {
            $owner->addMultiOption($c->id,$c->login);
        }

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($id, $subject, $body,$category,$type,$owner,$submit));
    }

}

