<?php
/**
 * 
 * Klasa Client_TicketsController
 * Rozszerza Zend_Controller_Action
 *
 */
class Client_TicketsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function listAction()
    {
        $tickets = new Client_Model_DbTable_Tickets();
        $this->view->tickets = $tickets->showOwnerTickets(Zend_Auth::getInstance()->getStorage()->read()->id);
    }


}



