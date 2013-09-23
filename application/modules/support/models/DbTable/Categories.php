<?php

class Support_Model_DbTable_Categories extends Zend_Db_Table_Abstract
{

    protected $_name = 'categories';

    /**
     * Zwraca wszystkie typy request�w z bazy danych.
     */
    public function getNames() {
        $row = $this->fetchAll();
        return $row;
    }



}

