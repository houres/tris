<?php

/**
 * 
 * Klasa Client_Model_DbTable_Departments klasa używana do wykonywania
 * zapytań w bazie danych związanych z departamentami.
 * Rozszerza Zend_Db_Table_Abstract
 *
 */
class Support_Model_DbTable_Departments extends Zend_Db_Table_Abstract {

    protected $_name = 'departments';

    /**
     * Zwraca wszystkie departamenty z bazy danych.
     */
    public function getNames() {
        $row = $this->fetchAll();
        return $row;
    }

}

