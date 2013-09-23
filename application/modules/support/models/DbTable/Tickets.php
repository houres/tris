<?php

class Support_Model_DbTable_Tickets extends Zend_Db_Table_Abstract {

    protected $_name = 'tickets';

    public function showTickets() {
        $select = $this->select(Zend_Db_Table_Abstract::SELECT_WITH_FROM_PART)
                        ->setIntegrityCheck(false)
                        ->joinLeft('statuses', 'tickets.departmentId = statuses.statusId')
                        ->order('ticketId');

        return $this->$select;
    }

    public function getTicket($id) {
        $id = (int) $id;
        $select = $this->select(Zend_Db_Table_Abstract::SELECT_WITH_FROM_PART)
                        ->setIntegrityCheck(false)
                        ->joinLeft('statuses', 'tickets.statusId = statuses.statusId')
                        ->joinLeft('users', 'tickets.departmentId = users.id', array('login'))
                        ->joinLeft('tickettypes', 'tickets.ticketType = tickettypes.tickettypeId', array('priorityName' => 'name'))
                        ->joinLeft('categories', 'tickets.category = categories.categoryId', array('categoryName' => 'name'))
                        ->where('ticketId = ' . $id);

        $row = $this->fetchAll($select);

        if (count($row) != 0)
            return $row->toArray();
        else
            return 0;
    }

    public function setStatus($id, $ticketId) {
        $id = (int) $id;
        $data = array('statusId' => $id,
            'modified' => new Zend_Db_Expr('NOW()'));

        $this->update($data, 'ticketId = ' . $ticketId);
    }

    public function setPriority($id, $ticketId) {
        $id = (int) $id;
        $data = array('ticketType' => $id,
            'modified' => new Zend_Db_Expr('NOW()'));

        $this->update($data, 'ticketId = ' . $ticketId);
    }

    public function setCategory($id, $ticketId) {
        $id = (int) $id;
        $data = array('category' => $id,
            'statusId' => 1,
            'modified' => new Zend_Db_Expr('NOW()'));

        $this->update($data, 'ticketId = ' . $ticketId);
    }

    public function setResponsibility($ticketId, $userId) {
        $data = array('departmentId' => $userId,
            'modified' => new Zend_Db_Expr('NOW()'));
        $this->update($data, 'ticketId = ' . $ticketId);

        $this->setStatus('2', $ticketId);
    }

}