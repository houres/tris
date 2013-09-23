<?php

/**
 * Admin_UserController klasa odpowiedzialna za kontrolę nad użytkownikiem.
 * Rozszerza klasę Zend_Controller_Action
 *
 *
 */
class Admin_UserController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
    }

    /**
     * addAction jest to metoda pozwalajaca użytkownikowi
     * na dodawanie.
     * Enter description here ...
     *
     *
     */
    public function addAction() {
        $form = new Admin_Form_CreateUser();
        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $username = $form->getValue('login');
                $password = $form->getValue('password');
                $enabled = $form->getValue('active');
                $group = $form->getValue('groupId');
                $salt = sha1(md5('ka' . time() . 'milek'));

                $ticket = new Admin_Model_DbTable_Users();
                $ticket->addUser($username, $password, $salt, $enabled, $group);

                $addHistoryEvent = new Model_DbTable_History();
                $addHistoryEvent->addHistoryEvent(13);

                $this->_redirect('admin/users/list');
            } else {
                $form->populate($formData);
            }
        }
    }

    /**
     * editAction jest to metoda pozwalająca użytkownikowi
     * na modyfikację.
     *
     *
     */
    public function editAction() {
        // action body

        $form = new Admin_Form_EditUser();
        $form->submit->setLabel('Zapisz');
        $this->view->form = $form;


        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $id = $form->getValue('id');
                $username = $form->getValue('login');
                $enabled = $form->getValue('active');
                $group = $form->getValue('groupId');

                $users = new Admin_Model_DbTable_Users();
                $users->editUser($id, $username, $enabled, $group);

                $addHistoryEvent = new Model_DbTable_History();
                $addHistoryEvent->addHistoryEvent(15);

                $this->_redirect('admin/users/list');
            } else {
                $form->populate($formData);
            }
        } else {
            $id = $this->_getParam('id', 0);
            if ($id > 0) {
                $users = new Admin_Model_DbTable_Users();
                $form->populate($users->getUser($id));
            }
        }
    }

    public function passwordAction() {
        $form = new Admin_Form_ChangePassword();
        $this->view->form = $form;


        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $id = $form->getValue('id');
                $password = $form->getValue('password');
                $salt = sha1(md5('ka' . time() . 'milek'));

                $users = new Admin_Model_DbTable_Users();
                $users->editPassword($id, $password, $salt);

                $this->_redirect('admin/users/list');
            } else {
                $form->populate($formData);
            }
        } else {
            $id = $this->_getParam('id', 0);
            if ($id > 0) {
                $users = new Admin_Model_DbTable_Users();
                $form->populate($users->getUser($id));
            }
        }
    }

    /**
     * deleteAction jest to metoda pozwalająca użytkownikowi
     * na usuwanie.
     * Enter description here ...
     *
     *
     */
    public function deleteAction() {

        $id = (int) $this->_getParam('id', 0);

        $qu = new Admin_Model_DbTable_Users();
        $qu->delUser($id);

        $addHistoryEvent = new Model_DbTable_History();
        $addHistoryEvent->addHistoryEvent(14);
        $this->_redirect('admin/users/list');
    }

    public function editpremissionsAction() {

        $id = $this->_getParam('id', 0);
        $form = new Admin_Form_SelectPremissions();
        $this->view->error = '';


        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $idU = $form->getValue('id');
                $groupId = $form->getValue('groupId');


                $blad = false;

                $db = new Support_Model_DbTable_UserInDepartments();
                $blad = $db->checkUserInDepartment($idU, $groupId);

                //echo count($blad);

                if ( count($blad) ) {
                    $this->view->error = 'You can\'t add this privilege';
                } else {
                    $add = new Admin_Model_DbTable_Premissions();
                    $add->addPremission($idU, $groupId);
                    $this->_redirect('admin/user/editpremissions/id/' . $id);
                }
            }
        }

        $query = new Admin_Model_DbTable_Premissions();
        $this->view->premissions = $query->getPremissions($id);


        $form->id->setValue($id);
        $form->submit->setLabel('Add premission');
        $this->view->form = $form;
    }

    public function deletepremissionAction() {
        $user = $this->_getParam('user', 0);
        $group = $this->_getParam('group', 0);

        $delete = new Admin_Model_DbTable_Premissions();
        $delete->deletePremission($user, $group);

        $this->_redirect('admin/user/editpremissions/id/' . $user);
    }

}