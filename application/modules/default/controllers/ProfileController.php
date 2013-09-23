<?php

class ProfileController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
 
        $this->view->title = "View profile";
        
        $userId = Zend_Auth::getInstance()->getStorage()->read()->id;

        $this->view->name = '';
        $this->view->role = Zend_Auth::getInstance()->getStorage()->read()->role;
        $this->view->dataReg = Zend_Auth::getInstance()->getStorage()->read()->dataReg;
        $this->view->login = Zend_Auth::getInstance()->getStorage()->read()->login;
        $this->view->id = $userId;
        $this->view->logDate = Zend_Auth::getInstance()->getStorage()->read()->dataLog;
        $this->view->ipLog = Zend_Auth::getInstance()->getStorage()->read()->ipLog;


        $acl = Zend_Registry::get('acl');

        $this->view->clientAccess = false;
        $this->view->supportAccess = false;
        $this->view->adminAccess = false;

        if ($acl->isAllowed(Zend_Registry::get('role'), 'stat', 'client')) {
            $this->view->clientAccess = true;

            $totalTickets = 0;
            $totalOpenTickets = 0;

            $dbTotal = new Model_DbTable_Tickets();
            $result = $dbTotal->getTicketsCountPerClient($userId);

            $totalTickets = (int) $result['liczba'];

            $result = $dbTotal->getOpenTicketsCountPerClient($userId);

            $totalOpenTickets = (int) $result['liczba'];

            $this->view->totalTickets = $totalTickets;
            $this->view->totalOpenTickets = $totalOpenTickets;
        }

        if ($acl->isAllowed(Zend_Registry::get('role'), 'stat', 'support')) {
            $this->view->supportAccess = true;

            $this->view->totalTickets = 0;
            $this->view->totalOpenTickets = 0;
            $this->view->totalOpenTicketsForSupporter = 0;
            $this->view->totalClosed = 0;

            $db = new Model_DbTable_Tickets();


            $this->view->totalTickets = (int) $db->getTicketsCount();
            $this->view->totalOpenTickets = (int) $db->getOpenTicketsCount();
            $this->view->totalOpenTicketsForSupporter = (int) $db->getOpenTicketsCountPerSupporter($userId);
            $this->view->totalClosed = (int) $db->getClosedTicketsCountPerSupporter($userId);
        }

        if ($acl->isAllowed(Zend_Registry::get('role'), 'stat', 'admin')) {
            $this->view->adminAccess = true;

            $db = new Admin_Model_DbTable_Users();

            $this->view->totalUsers = (int) $db->getUsersCount();
            $this->view->clientsCount = (int) $db->getUsersCount(5);
            $this->view->supportersCount = (int) $db->getUsersCount(2);
            $this->view->expertsCount = (int) $db->getUsersCount(3);
            $this->view->adminsCount = (int) $db->getUsersCount(1);
        }

        $profileDetails = new Admin_Model_DbTable_UserDetails();

        $detailsForm = new Default_Form_UserDetails();
        $translate = Zend_Registry::get('Zend_Translate');

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($detailsForm->isValid($formData)) {

                $formId = $detailsForm->getValue('formId');
                $name = $detailsForm->getValue('name');
                $surname = $detailsForm->getValue('surname');
                $company = $detailsForm->getValue('company');
                $email = $detailsForm->getValue('email');



                if ( $formId == 2 )
                    $profileDetails->addDetails ($userId, $name, $surname, $email, $company);
                else
                    $profileDetails->updateDetails ($userId, $name, $surname, $email, $company);

                $this->_redirect('default/profile');

            }
        }


        if( $profileDetails->getUserDetailsCount($userId) == 1)
        {
            $detailsForm->submit->setLabel($translate->_('Edit details'));
            $detailsForm->formId->setValue('1');
            $detailsForm->populate($profileDetails->getUserDetails($userId));
        }
        else
        {
            $detailsForm->submit->setLabel($translate->_('Create new details profile'));
            $detailsForm->formId->setValue('2');
        }

        $this->view->profileDetailsForm = $detailsForm;
    }

    public function changepasswordAction() {
        $form = new Admin_Form_ChangePassword();
        $form->submit->setLabel('Zmien');
        $this->view->form = $form;


        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $id = Zend_Auth::getInstance()->getStorage()->read()->id;
                $password = $form->getValue('password');
                $salt = sha1(md5('ka' . time() . 'milek'));

                $users = new Admin_Model_DbTable_Users();
                $users->editPassword($id, $password, $salt);

                $this->_redirect('default/profile');
            } else {
                $form->populate($formData);
            }
        } $id = $this->_getParam('id', 0);
        if ($id > 0) {
            $users = new Admin_Model_DbTable_Users();
            $form->populate($users->getUser($id));
        }
    }

}

