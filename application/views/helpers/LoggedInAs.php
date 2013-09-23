<?php
/**
 * 
 * Zend_View_Helper_LoggedInAs klasa zaloguj jako.
 * Rozszerza Zend_View_Helper_Abstract
 *
 */
class Zend_View_Helper_LoggedInAs extends Zend_View_Helper_Abstract
{    
	/**
	 * 
	 * loggedInAs metoda zaloguj jako.
	 */
    public function loggedInAs ()
    {
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        if($controller == 'auth' && $action == 'index') {
            return '';
        }
        $loginUrl = $this->view->url(array('controller'=>'auth', 'action'=>'index'));
        //echo '<a href="'.$loginUrl.'">Zaloguj się</a>';
    }
}

?>
