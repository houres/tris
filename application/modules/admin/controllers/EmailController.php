<?php

class Admin_EmailController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function preferencesAction()
    {
        $form = new Admin_Form_EmailPreferences();



        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $data = array();

                $data['emailEnable'] = $form->getValue('emailEnable');
                $data['emailSentClient'] = $form->getValue('emailSentClient');
                $data['emailSentSupport'] = $form->getValue('emailSentSupport');
                $data['emailTicketMail'] = $form->getValue('emailTicketMail');
                $data['emailTicketSubject'] = $form->getValue('emailTicketSubject');
                $data['emailTicketBody'] = $form->getValue('emailTicketBody');
                $data['emailTicketSubjectClosed'] = $form->getValue('emailTicketSubjectClosed');
                $data['emailTicketBodyClosed'] = $form->getValue('emailTicketBodyClosed');

                $db = new Admin_Model_DbTable_Preferences();
                $db->updatePreferences($data);
            }
        }



        $db = new Admin_Model_DbTable_Preferences();
        $result = $db->getPreferences('email');

        $form->populate($result);
        $this->view->form = $form;
    }


}



