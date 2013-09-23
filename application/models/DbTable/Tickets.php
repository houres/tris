<?php

class Model_DbTable_Tickets extends Zend_Db_Table_Abstract
/**
 * Klasa odpowiedzialna za wykonywanie zapytań w bazie danych związanych z Ticketami.
 * Rozszerza klasę Zend_Db_Table_Abstract
 */
{
	/** 
	 * @var string
	 */
    protected $_name = 'tickets';
	
    /**
     * getTicket jest to metoda odpowiedzialna za pobieranie Ticketu z bazy danych
     * @param id $id
     * @throws Exception 
     */
    public function getTicket($id)
    
    {
        $id = (int)$id;
        $row = $this->fetchRow('id = '. $id);
        if (!$row) {
            throw new Exception("Nie mozna znalezc podanego rekordu");
        }
        return $row->toArray();
    }
	/**
	 * 
	 * addTicket jest to metoda odpowiedzialan za dodawanie Ticketu (wpisu) do bazy danych.
	 * @param string $subject
	 * @param string $body
	 * @param int $statusId
	 * @param int $ticketType
	 * @param int $ownerType
	 * @param int $departmentId
	 */
    public function addTicket($subject,$body,$statusId,$ticketType,$ownerType,$departmentId)
    {
        $data = array(
            'subject' => $subject,
            'body' => $body,
            'created' => new Zend_Db_Expr('NOW()'),
            'statusId' => $statusId,
            'ticketType' => $ticketType,
            'ownerType' => $ownerType,
            'departmentId' => $departmentId
        );
        $this->insert($data);
    }
	/**
	 * 
	 * updateTicket jest to metoda odpowiedziala za aktualizacje Ticketu.
	 * @param int $id
	 * @param string $subject
	 * @param string $body
	 */
    public function updateTicket($id, $subject, $body)
    {
        $data = array(
            'modified' => new Zend_Db_Expr('NOW()'),
            'subject' => $subject,
            'body' => $body
        );
        $this->update($data, 'id = '.(int)$id);
    }

}

