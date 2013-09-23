<?php

class Support_TicketController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    /**
     * indexAction
     *
     *
     *
     *
     */
    public function indexAction() {
// action body
    }

    /**
     * addAction
     *
     *
     *
     *
     */
    public function addAction() {
        $form = new Support_Form_Createticket();
        $form->submit->setLabel('Add ticket');
        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $title = $form->getValue('subject');
                $body = $form->getValue('body');
                $category = $form->getValue('category');
                $ticketType = $form->getValue('type');
                $ticket = new Client_Model_DbTable_Tickets();
                $owner = $form->getValue('owner');
                $ticket->addTicket($title, $body, '1', $ticketType, $category, $owner);

                $addHistoryEvent = new Model_DbTable_History();
                $addHistoryEvent->addHistoryEvent(5);


                $dbPreferences = new Admin_Model_DbTable_Preferences();

                $mailNotification = new Model_Mail();
                $mailNotification->sendMail($owner, '1', $dbPreferences->getPreferenceByName('emailTicketSubject'), $dbPreferences->getPreferenceByName('emailTicketBody'));

                $this->_redirect('support/tickets/list');
            } else {
                $form->populate($formData);
            }
        }
    }

    /**
     * editAction
     *
     *
     *
     *
     */
    public function editAction() {
// action body
    }

    public function showAction() {

        $this->view->indexTitle = 'dupa';

        $id = $this->_getParam('id', 0);

        $request = new Support_Model_DbTable_Ticketrequest();
        $statusA = new Support_Model_DbTable_Ticketrequest();

        $result = new Support_Model_DbTable_Tickets();
        $replay = new Client_Model_DbTable_Ticketreplays();

        $data = $result->getTicket($id);

        if (count($data) == 0) {
            $this->_redirect('support/tickets/list');
        }

        $this->view->ticket = $result->getTicket($id);
        $this->view->replays = $replay->getAnswersForSupport($id);
        $this->view->supports = $request->getSupports($id);

        $url = new Zend_View_Helper_Url();
        $form = new Support_Form_AddAnswerForm();
        $form->setAction($url->url(array('module' => 'support', 'controller' => 'ticket', 'action' => 'addanswer')));
        $form->id->setValue($id);
        $this->view->answerForm = $form;

        $srForm = new Support_Form_AddSupportRequestForm();
        $srForm->setAction($url->url(array('module' => 'support', 'controller' => 'ticket', 'action' => 'addsupportrequest')));
        $srForm->id->setValue($id);
        $this->view->suprequestForm = $srForm;

        $prForm = new Support_Form_ChangePriorityForm();
        $prForm->setAction($url->url(array('module' => 'support', 'controller' => 'ticket', 'action' => 'changepriority')));
        $prForm->id->setValue($id);
        $prForm->submit->setLabel('Change priority');
        $this->view->priorityForm = $prForm;

        $catForm = new Support_Form_ChangeCategoryForm();
        $catForm->setAction($url->url(array('module' => 'support', 'controller' => 'ticket', 'action' => 'changecategory')));
        $catForm->id->setValue($id);
        $catForm->submit->setLabel('Change category');
        $this->view->categoryForm = $catForm;
    }

    public function addsupportrequestAction() {
        $form = new Support_Form_AddSupportRequestForm();

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $ticketId = $form->getValue('id');
                $groupId = $form->getValue('department');
                $ticketSubject = $form->getValue('subject');
                $ticketBody = $form->getValue('requestbody');
                $statusId = 1;
                $ownerId = Zend_Auth::getInstance()->getStorage()->read()->id;
                $responsibilityId = 0;
                $ticketTypesRequestId = $form->getValue('requesttype');

                $request = new Support_Model_DbTable_Ticketrequest();
                $request->addSupportRequest($ticketId, $groupId, $ticketSubject, $statusId,
                        $ticketBody, $ownerId, $responsibilityId,
                        $ticketTypesRequestId);

                $addHistoryEvent = new Model_DbTable_History();
                $addHistoryEvent->addHistoryEvent(10);

                $this->_redirect('support/ticket/show/id/' . $ticketId);
            } else {
                $ticketId = $form->getValue('id');
                $this->_redirect('support/ticket/show/id/' . $ticketId);
            }
        }
    }

    public function addanswerAction() {
        $form = new Support_Form_AddAnswerForm();

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $title = $form->getValue('subject');
                $body = $form->getValue('answer');
                $ticketId = $form->getValue('id');
                $public = $form->getValue('public');
                $ending = $form->getValue('ending');
                $user = Zend_Auth::getInstance()->getStorage()->read()->id;

                if ($ending == 1) {
                    $update = new Support_Model_DbTable_Tickets();
                    $update->setStatus(6, $ticketId);
                    $public = 1;
                    $addHistoryEvent = new Model_DbTable_History();
                    $addHistoryEvent->addHistoryEvent(6);
                } else {
                    $addHistoryEvent = new Model_DbTable_History();
                    $addHistoryEvent->addHistoryEvent(8);
                }

                $reply = new Client_Model_DbTable_Ticketreplays();
                $reply->addAnswer($title, $body, $ticketId, $public, $ending, $user);

                $this->_redirect('support/ticket/show/id/' . $ticketId);
            } else {
                $ticketId = $form->getValue('id');
                $this->_redirect('support/ticket/show/id/' . $ticketId);
            }
        }
    }

    public function setresponsibilityAction() {
        $id = $this->_getParam('id', 0);

//TODO: sprawdzanie czy ktos juz nie pobral zgloszenia

        $userId = Zend_Auth::getInstance()->getStorage()->read()->id;
        $set = new Support_Model_DbTable_Tickets();
        $set->setResponsibility($id, $userId);

        $addHistoryEvent = new Model_DbTable_History();
        $addHistoryEvent->addHistoryEvent(9);

        $this->_redirect('support/ticket/show/id/' . $id);
    }

    public function changepriorityAction() {
        $form = new Support_Form_ChangePriorityForm();

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {

                $priorityId = $form->getValue('priority');
                $ticketId = $form->getValue('id');

                $db = new Support_Model_DbTable_Tickets();
                $db->setPriority($priorityId, $ticketId);

                $addHistoryEvent = new Model_DbTable_History();
                $addHistoryEvent->addHistoryEvent(16);

                $this->_redirect('support/ticket/show/id/' . $ticketId);
            } else {
                $ticketId = $form->getValue('id');
                $this->_redirect('support/ticket/show/id/' . $ticketId);
            }
        }
    }

    public function changecategoryAction() {
        $form = new Support_Form_ChangeCategoryForm();

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {

                $categoryId = $form->getValue('category');
                $ticketId = $form->getValue('id');

                $db = new Support_Model_DbTable_Tickets();
                $db->setCategory($categoryId, $ticketId);

                $addHistoryEvent = new Model_DbTable_History();
                $addHistoryEvent->addHistoryEvent(17);

                $this->_redirect('support/ticket/show/id/' . $ticketId);
            } else {
                $ticketId = $form->getValue('id');
                $this->_redirect('support/ticket/show/id/' . $ticketId);
            }
        }
    }

    public function cancelAction() {
        $id = $this->_getParam('id', 0);

        $db = new Support_Model_DbTable_Tickets();
        $db->setStatus(1, $id);

        $addHistoryEvent = new Model_DbTable_History();
        $addHistoryEvent->addHistoryEvent(21);

        $this->_redirect('support/ticket/show/id/' . $id);
    }

}