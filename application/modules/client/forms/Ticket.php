<?php
/**
 * 
 * Client_Form_Ticket jest to klasa odpowiedzialana 
 * za formularz Ticketu dla Klienta.
 * Rozszerza Zend_Form
 *
 */
class Client_Form_Ticket extends Zend_Form {

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
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
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

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($id, $subject, $body,$category,$type,$submit));
    }
}

