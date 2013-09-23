<?php

/**
 * Support_SrqController
 * Rozszerza Zend_Controller_Action
 *
 *
 *
 *
 *
 */
class Support_SrqController extends Zend_Controller_Action {

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
        // action body
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
        $id = $this->_getParam('id', 0);
        $support = new Support_Model_DbTable_Ticketrequest();
        $supportReplies = new Support_Model_DbTable_RequestReplies();

        $answer = $support->getSupport($id);

        $this->view->support = $answer;
        $this->view->supportReplies = $supportReplies->getSupportReplies($id);

        $url = new Zend_View_Helper_Url();

        $form = new Support_Form_AddSupportRequestReplyForm();
        $form->setAction($url->url(array('module' => 'support', 'controller' => 'srq', 'action' => 'solve'), 'default', 'true'));
        $form->id->setValue($id);
        $form->ticketId->setValue($answer[0]['ticketId']);

        $form2 = new Support_Form_AddSupportRequestReplySimplyForm();
        $form2->setAction($url->url(array('module' => 'support', 'controller' => 'srq', 'action' => 'simplysolve'), 'default', 'true'));
        $form2->id->setValue($id);
        $form2->ticketId->setValue($answer[0]['ticketId']);

        $form3 = new Support_Form_ChangeDepartmentForm();
        $form3->setAction($url->url(array('module' => 'support', 'controller' => 'srq', 'action' => 'changedepartment'), 'default', 'true'));
        $form3->id->setValue($id);
        $form3->submit->setLabel('Change department');

        $this->view->form = $form;
        $this->view->simplyform = $form2;
        $this->view->departmentForm = $form3;

        $check = new Admin_Model_DbTable_Premissions();
        $this->view->checkGroup = $check->checkPremission(Zend_Auth::getInstance()->getStorage()->read()->id, $answer[0]['groupId']);
    }

    public function solveAction() {
        $form = new Support_Form_AddSupportRequestReplyForm();

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $id = $form->getValue('id');
                $ticketId = $form->getValue('ticketId');
                $body = $form->getValue('answer');
                $ticketType = $form->getValue('what');
                $user = Zend_Auth::getInstance()->getStorage()->read()->id;

                $ticket = new Support_Model_DbTable_RequestReplies();
                $ticket->addAnswer($body, $id, $user);

                $setSupportStatus = new Support_Model_DbTable_Ticketrequest();
                $setSupportStatus->setStatus($ticketType, $id);

                $setTicketStatus = new Support_Model_DbTable_Tickets();

                $howMany = new Support_Model_DbTable_Ticketrequest();

                if ($ticketType == 1) {
                        $addHistoryEvent = new Model_DbTable_History();
                        $addHistoryEvent->addHistoryEvent(20);
                    }

                if ($howMany->howManyRequestPerStatus('1', $ticketId) == 0) {

                    if ($ticketType == 2) {
                        $addHistoryEvent = new Model_DbTable_History();
                        $addHistoryEvent->addHistoryEvent(11);

                        $setTicketStatus->setStatus('5', $ticketId);
                    }
                    if ($ticketType > 2) {
                        $addHistoryEvent = new Model_DbTable_History();
                        $addHistoryEvent->addHistoryEvent(19);

                        $setTicketStatus->setStatus('1', $ticketId);
                    }
                }



                $this->_redirect('support/srq/show/id/' . $id);
            } else {
                $id = $form->getValue('id');
                $this->_redirect('support/srq/show/id/' . $id);
            }
        }
    }

    public function simplysolveAction() {
        $form = new Support_Form_AddSupportRequestReplySimplyForm();

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $id = $form->getValue('id');
                $ticketId = $form->getValue('ticketId');
                $body = $form->getValue('answer');

                $user = Zend_Auth::getInstance()->getStorage()->read()->id;

                $ticket = new Support_Model_DbTable_RequestReplies();
                $ticket->addAnswer($body, $id, $user);

                $setSupportStatus = new Support_Model_DbTable_Ticketrequest();
                $setSupportStatus->setStatus('1', $id);

                $setTicketStatus = new Support_Model_DbTable_Tickets();
                $setTicketStatus->setStatus('4', $ticketId);


                $this->_redirect('support/srq/show/id/' . $id);
            } else {
                $id = $form->getValue('id');
                $this->_redirect('support/srq/show/id/' . $id);
            }
        }
    }

    public function changedepartmentAction() {

        $form = new Support_Form_ChangeDepartmentForm();

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {

                $departmentId = $form->getValue('department');
                $srqId = $form->getValue('id');

                $db = new Support_Model_DbTable_Ticketrequest();
                $db->setDepartment($departmentId, $srqId);

                $addHistoryEvent = new Model_DbTable_History();
                $addHistoryEvent->addHistoryEvent(18);

                $this->_redirect('support/srq/show/id/' . $srqId);
            } else {
                $ticketId = $form->getValue('id');
                $this->_redirect('support/srq/show/id/' . $srqId);
            }
        }
    }

}