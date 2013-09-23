<?php
/**
 * 
 * AuthenticationController klasa odpowiedzialne za kontrolę nad uprawnieniami.
 * Rozszerza Zend_Controller_Action
 *
 */
class AuthenticationController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
    }
	/**
	 * loginAction metoda odpowiedzialna za akacje logowania.
	 */
    public function loginAction() {
        $this->view->indexTitle = 'Login';

        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('index');
        }

        $request = $this->getRequest();
        $form = new Form_LoginForm();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $authAdapter = $this->getAuthAdapter();

                $username = $form->getValue('username');
                $password = $form->getValue('password');

                $authAdapter->setIdentity($username)
                        ->setCredential($password)
                        ->getDbSelect()->where('active = 1');

                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);


                $addHistoryEvent = new Model_DbTable_History();

                if ($result->isValid()) {

                    $identity = $authAdapter->getResultRowObject();
                    $authStorage = $auth->getStorage();

                    $role = new stdClass();
                    $identity->role = $this->getGroupName( $identity->groupId );

                    $authStorage->write($identity);
                    $addHistoryEvent->addHistoryEvent(1);

                    $updateUserDetails = new Admin_Model_DbTable_Users();
                    $updateUserDetails->updateUserLoginDetails($identity->id, $_SERVER['REMOTE_ADDR']);

                    $this->_redirect('profile');
                } else {
                    $addHistoryEvent->addHistoryEvent(2,0);
                    $this->view->errorMessage = "Username or password are incorect!";
                }
            }
        }

        $this->view->form = $form;
    }
	/**
	 * 
	 * getAuthAdapter
	 */
    protected function getAuthAdapter() {
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

        $authAdapter->setTableName('users')
                ->setIdentityColumn('login')
                ->setCredentialColumn('pass')
                ->setCredentialTreatment('SHA1(CONCAT(?,salt))');


        return $authAdapter;
    }
	/**
	 * 
	 * getGroupName jest odpowiedzialna
	 * za pobieranie nazwy grupy
	 * @param int $id
	 */
    protected function getGroupName($id)
    {
        $groupName = new Model_DbTable_Groups();
        return  $groupName->getGroupName($id);

    }
	/**
	 * logoutAction metoda odpowiedzialna za wylogowanie.
	 */
    public function logoutAction() {
        $addHistoryEvent = new Model_DbTable_History();
        $addHistoryEvent->addHistoryEvent(3);

        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('index');
    }

}

