<?php
/**
 * 
 * Zend_View_Helper_ShowNick klasa odpowiedzialana za wyswietlania Nicku.
 * Rozszerza Zend_View_Helper_Abstract
 *
 */
class Zend_View_Helper_ShowNick extends Zend_View_Helper_Abstract
{
	/**
	 * 
	 * showNick metoda odpowiedzialana za wyświetlanie Nicku.
	 * @return $username
	 */
    public function showNick()
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $username = $auth->getIdentity()->login;
            $logoutUrl = $this->view->url(array('controller'=>'auth',
                'action'=>'logout'), null, true);
            return 'Witamy Cię ' . $username .  '. <a href="'.$logoutUrl.'">Wyloguj się</a>';
        }
    }

}
?>
