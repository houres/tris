<?php
/**
 * 
 * Plugin_AccessCheck
 * Rozszerza Zend_Controller_Plugin_Abstract
 *
 */
class Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract {
	/**
	 * 
	 * @var unknown_type
	 */
    private $_acl = null;

    /**
     * 
     * @param unknown_type $acl
     */
    public function __construct(Zend_Acl $acl) {
        $this->_acl = $acl;
    }
	/**
	 * 
	 * preDispatch
	 * @param Zend_Controller_Request_Abstract $request
	 */
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
    	$module = $request->getModuleName();
        $resource = $request->getControllerName();
        $action = $request->getActionName();

        if(!$this->_acl->isAllowed(Zend_Registry::get('role'), $module.':'.$resource, $action)){
            $request->setModuleName('default')
                    ->setControllerName('authentication')
                    ->setActionName('login');
        }
    }
}
