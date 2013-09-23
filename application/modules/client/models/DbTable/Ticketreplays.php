<?php

class Client_Model_DbTable_Ticketreplays extends Zend_Db_Table_Abstract {

    protected $_name = 'ticketreplays';
    
    public function addAnswer($subject, $body, $ticketId, $public, $ending, $user) {
        $data = array(
            'userId' => $user,
            'subject' => $subject,
            'body' => $body,
            'date' => new Zend_Db_Expr('NOW()'),
            'ticketId' => $ticketId,
            'public' => $public,
            'ending' => $ending
        );
        $this->insert($data);
    }
    
    public function getAnswersForTicket($ticketId) {
        $id = (int) $ticketId;
        $select = $this->select(Zend_Db_Table_Abstract::SELECT_WITH_FROM_PART)
                ->setIntegrityCheck(false)
                ->where('ticketId = '.$id.' and public = 1');

        return $row = $this->fetchAll($select);
    }

    public function getAnswersForSupport($id) {
        $select = $this->select()
                ->where('ticketId = '.$id);

        return $row = $this->fetchAll($select);
    }
    
}

?>
