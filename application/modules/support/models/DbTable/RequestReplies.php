<?php

class Support_Model_DbTable_RequestReplies extends Zend_Db_Table_Abstract {

    protected $_name = 'ticketrequestreplies';

    public function addAnswer($body, $supportId, $user) {
        $data = array(
            'userId' => $user,
            'supportId' => $supportId,
            'body' => $body,
            'date' => new Zend_Db_Expr('NOW()')
        );
        $this->insert($data);
    }

    public function getSupportReplies($id) {
        $select = $this->select(Zend_Db_Table_Abstract::SELECT_WITH_FROM_PART)
                ->setIntegrityCheck(false)
                ->joinLeft('users', 'ticketrequestreplies.userId = users.id', array('login'))
                ->where('supportId = '.$id);

        return $row = $this->fetchAll($select);
    }

}

?>
