<?php

/**
 * 
 * Bootstrap klasa
 * Rozszerza Zend_Application_Bootstrap_Bootstrap 
 *
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    /**
     *
     * Access Control List
     * @var unknown_type
     */
    private $_acl = null;

    /**
     * 
     * _initAutoload
     */
    protected function _initAutoload() {
        $modelLoader = new Zend_Application_Module_Autoloader(array(
                    'namespace' => '',
                    'basePath' => APPLICATION_PATH . '/modules/default'));


        if (Zend_Auth::getInstance()->hasIdentity()) {
            Zend_Registry::set('role', Zend_Auth::getInstance()->getStorage()->read()->role);
        } else {
            Zend_Registry::set('role', 'guests');
        }

        $this->_acl = new Model_LibraryAcl;
        $this->_auth = Zend_Auth::getInstance();


        $fc = Zend_Controller_Front::getInstance();
        $fc->registerPlugin(new Plugin_AccessCheck($this->_acl));

        Zend_Registry::set('acl', $this->_acl);
        return $modelLoader;
    }

    /**
     * 
     * _initViewHelpers
     */
    function _initViewHelpers() {

        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();

        $view->setHelperPath(APPLICATION_PATH . '/helpers', '');
        //$view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");

        ZendX_JQuery::enableView($view);

        $navContainerConfig = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'nav');
        $navContainer = new Zend_Navigation($navContainerConfig);

        $view->navigation($navContainer)->setAcl($this->_acl)->setRole(Zend_Registry::get('role'));
    }

    function _initSetTranslations() {


        $translate = new Zend_Translate('gettext',
                        APPLICATION_PATH . '/languages',
                        null,
                        array('scan' => Zend_Translate::LOCALE_FILENAME));

        $session = new Zend_Session_Namespace('trisLanguage');
        $locale = new Zend_Locale();

        if (isset($session->language)) {
            $requestedLanguage = $session->language;
            $locale->setLocale($requestedLanguage);
        } else {
            $locale->setLocale(Zend_Locale::BROWSER);
            $requestedLanguage = key($locale->getBrowser());
        }
        
        if (in_array($requestedLanguage, $translate->getList())) {
            $language = $requestedLanguage;
        } else {
            $language = 'en';
        }

        Zend_Registry::set('locale', $locale);
        Zend_Registry::set('Zend_Translate', $translate);
        $translate->setLocale($language);
    }

}
