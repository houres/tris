<?php
/**
 * 
 * IndexControllerTest klasa testowa.
 * Rozszerza Zend_Test_PHPUnit_ControllerTestCase
 *
 */
class IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{
	/**
	 * 
	 * setUp
	 */
    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }


}

