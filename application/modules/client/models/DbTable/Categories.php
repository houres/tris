<?php
/**
 * 
 * Client_Model_DbTable_Categories klasa używana do wykonywania
 * zapytań w bazie danych związanych z kategoriami.
 * Rozszerza Zend_Db_Table_Abstract
 *
 */
 class Client_Model_DbTable_Categories extends Zend_Db_Table_Abstract {
    /**
     * 
     * @var string
     */
 	protected $_name = 'categories';

 	/**
 	 * 
 	 * getNames metoda odpowiedzialna za pobieranie nazwy kategori.
 	 */
    public function getNames()
    {
        $row = $this->fetchAll();
        return $row;
    }
 }