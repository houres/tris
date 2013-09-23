<?php

class LanguageController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction()
    {
        // action body
    }

    public function switchAction()
    {
        $session = new Zend_Session_Namespace('trisLanguage');
        $session->language = $this->_getParam('lang');

        $this->_redirect( $_SERVER['HTTP_REFERER'] );
    }


}



