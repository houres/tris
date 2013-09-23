<?php

class Support_Model_DbTable_TicketTypes extends Zend_Db_Table_Abstract
{

    protected $_name = 'tickettypes';

    /**
     * Zwraca wszystkie typy request�w z bazy danych.
     */
    public function getNames() {
        $row = $this->fetchAll();
        return $row;
    }



}

