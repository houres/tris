<?php

class Client_TicketController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
    }

    /**
     * addAction metoda pozwalająca dodać Ticket
     */
    public function addAction() {

        $form = new Client_Form_Ticket();
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
                $owner = Zend_Auth::getInstance()->getStorage()->read()->id;
                $ticket->addTicket($title, $body, '1', $ticketType, $category, $owner);

                $addHistoryEvent = new Model_DbTable_History();
                $addHistoryEvent->addHistoryEvent(4);

                $this->_redirect('client/tickets/list');
            } else {
                $form->populate($formData);
            }
        }
    }

    /**
     * 
     * answerAction
     */
    public function answerAction() {


        $form = new Client_Form_Answer();
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $title = $form->getValue('subject');
                $body = $form->getValue('body');
                $ticketId = $form->getValue('id'); //; //TODO: nie wiem jak wyciągnąć id ticketa editGoku:tak ;)
                //ten drugi średnik tu chyba nie jest potrzebny :P
                $owner = Zend_Auth::getInstance()->getStorage()->read()->id;

                $reply = new Client_Model_DbTable_Ticketreplays();
                $reply->addAnswer($title, $body, $ticketId, 1, 0, $owner);

                $addHistoryEvent = new Model_DbTable_History();
                $addHistoryEvent->addHistoryEvent(7);

                $this->_redirect('client/ticket/show/id/' . $ticketId);
            } else {
                $form->populate($formData);
            }
        }
    }

    /**
     * 
     * editAction
     */
    public function editAction() {
        // action body
    }

    /**
     * 
     * showAction
     */
    public function showAction() {
        $id = $this->_getParam('id', 0);

        $result = new Client_Model_DbTable_Tickets();
        $reply = new Client_Model_DbTable_Ticketreplays();

        $data = $result->getTicket($id);

        if (count($data) == 0 OR $data[0]['owner'] != Zend_Auth::getInstance()->getStorage()->read()->id) {
            $this->_redirect('client/tickets/list');
        }

        $url = new Zend_View_Helper_Url();

        $form = new Client_Form_Answer();
        $form->id->setValue($data[0]['ticketId']);
        $form->submit->setLabel('Answer');
        $form->setAction($url->url(array('module' => 'client', 'controller' => 'ticket', 'action' => 'answer')));
        $this->view->form = $form;

        $this->view->replies = $reply->getAnswersForTicket($id);

        $this->view->ticket = $result->getTicket($id);
        $this->view->form = $form;
    }

}

