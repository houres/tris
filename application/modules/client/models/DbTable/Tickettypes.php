<?php
/**
 * 
 * Client_Model_DbTable_Tickettypes Klasa
 * Rozszerza Zend_Db_Table_Abstract
 *
 */
 class Client_Model_DbTable_Tickettypes extends Zend_Db_Table_Abstract {
    /**
     *
     * @var string 
     */
 	protected $_name = 'tickettypes';

 	/**
 	 * 
 	 * getNames metoda...
 	 */
    public function getNames()
    {
        $row = $this->fetchAll();
        return $row;
    }

 }
