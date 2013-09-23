<?php
/**
 * 
 * IndexController
 * Rozszerza Zend_Controller_Action
 *
 */
class IndexController extends Zend_Controller_Action
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
        
    }
	/**
	 * 
	 * addAction
	 */
    public function addAction()
    {
        // action body
    }
	/**
	 * 
	 * editAction
	 */
    public function editAction()
    {
        // action body
        $form = new Form_Ticket();
        $form->submit->setLabel('Zapisz');
        $this->view->form = $form;

        if($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $id = (int)$form->getValue('id');
                $subject = $form->getValue('subject');
                $body = $form->getValue('body');

                $tickets = new Model_DbTable_Tickets();
                $tickets->updateTicket($id, $subject, $body);

                $this->_helper->redirector('index');
            }
            else {
                $form->populate($formData);
            }
        }
        else {
            $id = $this->_getParam('id',0);
            if($id > 0) {
                $tickets = new Model_DbTable_Tickets();
                $form->populate($tickets->getTicket($id));
            }
        }
    }
	/**
	 * 
	 * deleteAction
	 */
    public function deleteAction()
    {
        // action body
    }


}







