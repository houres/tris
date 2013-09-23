<?php
/**
 * 
 * Klasa Client_Model_DbTable_Tickets klasa używana do wykonywania
 * zapytań w bazie danych związanych z ticketami.
 * Rozszerza Zend_Db_Table_Abstract
 *
 */
class Client_Model_DbTable_Tickets extends Zend_Db_Table_Abstract
{

    protected $_name = 'tickets';

    public function getTicket($id)
    {
        $id = (int)$id;
        $select = $this->select(Zend_Db_Table_Abstract::SELECT_WITH_FROM_PART)
                ->setIntegrityCheck(false)
                ->join('statuses', 'tickets.statusId = statuses.statusId')
                ->where('ticketId = '.$id);

        $row = $this->fetchAll($select);

        if ( count($row) != 0 )
            return $row->toArray();
        else
            return 0;
    }

    public function showOwnerTickets($id)
    {
        $id = (int)$id;
        $select = $this->select()
                ->where('owner = '.$id);

        return $row = $this->fetchAll($select);
    }

    public function addTicket($subject,$body,$statusId,$ticketType,$category,$owner)
    {
        $data = array(
            'subject' => $subject,
            'body' => $body,
            'created' => new Zend_Db_Expr('NOW()'),
            'statusId' => $statusId,
            'ticketType' => $ticketType,
            'owner' => $owner,
            'category' => $category
        );
        $this->insert($data);
    }

    public function updateTicket($id, $subject, $body)
    {
        $data = array(
            'modified' => new Zend_Db_Expr('NOW()'),
            'subject' => $subject,
            'body' => $body
        );
        $this->update($data, 'ticketId = '.(int)$id);
    }

}

