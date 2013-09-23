<?php
/**
 * 
 * Support_SrqsController
 * Rozszerza Zend_Controller_Action
 *
 */
class Support_SrqsController extends Zend_Controller_Action
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
        $requests = new Support_Model_DbTable_Ticketrequest();

        $paginator = new Zend_Paginator( new Zend_Paginator_Adapter_DbSelect( $requests->listRequests()) );
        $paginator->setItemCountPerPage(500)
                  ->setCurrentPageNumber($this->_getParam('page',1));

        $this->view->paginator = $paginator;
    }


}



