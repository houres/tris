<?php
/**
 * 
 * Support_TicketsController
 * Rozszerza Zend_Controller_Action
 *
 */
class Support_TicketsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }
	/**
	 * 
	 * indexAction
	 */
    public function indexAction()
    {
        // action body
    }
	/**
	 * 
	 * listAction
	 */
    public function listAction()
    {
        $tickets = new Support_Model_ListTickets();


        if( $this->_getParam('filter') == 'owner')
            $container = $tickets->listTickets( true );
        else
            $container = $tickets->listTickets();




        $paginator = new Zend_Paginator( new Zend_Paginator_Adapter_DbSelect( $container ));
        $paginator->setItemCountPerPage(5000)
                  ->setCurrentPageNumber($this->_getParam('page',1));

        $this->view->paginator = $paginator;

        //$this->view->tickets = $tickets->showTickets();
    }


}



