<?php

class Admin_Form_EmailPreferences extends Zend_Form
{

    public function init()
    {
        $this->setName('preferences');

        $enableEmail = new Zend_Form_Element_Checkbox('emailEnable');
        $enableEmail->setLabel($this->getView()->translate('Enable module mail'));

        $enableSentToClient = new Zend_Form_Element_Checkbox('emailSentClient');
        $enableSentToClient->setLabel($this->getView()->translate('Enable send mail to client'));


        $enableSentToSupport = new Zend_Form_Element_Checkbox('emailSentSupport');
        $enableSentToSupport->setLabel($this->getView()->translate('Enable send mail to support'));

        $emailTicketMail = new Zend_Form_Element_Text('emailTicketMail');
        $emailTicketMail->setLabel($this->getView()->translate('From Mail Adress'));

        $emailTicketSubject = new Zend_Form_Element_Text('emailTicketSubject');
        $emailTicketSubject->setLabel($this->getView()->translate('New ticket subject'));
        
        $emailTicketBody = new Zend_Form_Element_Textarea('emailTicketBody');
        $emailTicketBody->setLabel($this->getView()->translate('New ticket body'))
                ->setOptions(array('rows'=>'10'));
        
        $emailTicketSubjectClosed = new Zend_Form_Element_Text('emailTicketSubjectClosed');
        $emailTicketSubjectClosed->setLabel($this->getView()->translate('Closed ticket subject'));

        $emailTicketBodyClosed = new Zend_Form_Element_Textarea('emailTicketBodyClosed');
        $emailTicketBodyClosed->setLabel($this->getView()->translate('Closed ticket body'))
                ->setOptions(array('rows'=>'10'));

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton')
                ->setLabel($this->getView()->translate('Save premissions'));


        $this->addElements(array($enableEmail,
                $enableSentToClient,
                $enableSentToSupport,
                $emailTicketMail,
                $emailTicketSubject,
                $emailTicketBody,
                $emailTicketSubjectClosed,
                $emailTicketBodyClosed,$submit));
    }


}

