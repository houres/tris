<?php


/**
 * Klasa Admin_UsersController odpowiedzialna za kontrolę nad użytkownikami.
 * Rozszerza Zend_Controller_Action
 *
 *
 */
class Admin_UsersController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    /**
     * listAction metoda pozwalająca na wypisanie użytkowników
     * o danych możliwościach.
     *
     */
    public function listAction()
    {
        $query = new Admin_Model_DbTable_Users();
        $row = $query->showUsers();

        $this->view->users = $row;
    }

    public function premissionsAction()
    {
        $query = new Admin_Model_DbTable_Users();
        $select = $query->select()->where('groupId=3');
        $this->view->experts = $query->fetchAll($select);
    }


}

