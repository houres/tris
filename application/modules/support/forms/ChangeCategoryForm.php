<?php

class Support_Form_ChangeCategoryForm extends Zend_Form
{

     public function init()
    {
        $this->setName('category');

        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

        $db = new Support_Model_DbTable_Categories();
        $results = $db->getNames();

        $priority = new Zend_Form_Element_Select('category');
        $priority->setLabel($this->getView()->translate('Category'));

        foreach($results as $c)
        {
            $priority->addMultiOption($c->categoryId,$c->name);
        }

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($id,$priority,$submit));
    }


}

