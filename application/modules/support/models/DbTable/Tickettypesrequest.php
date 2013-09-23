<?php

class Support_Model_DbTable_Tickettypesrequest extends Zend_Db_Table_Abstract
{

    protected $_name = 'tickettypesrequest';
    
    /**
     * Zwraca wszystkie typy requestów z bazy danych.
     */
    public function getNames() {
        $row = $this->fetchAll();
        return $row;
    }



}

