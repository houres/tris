<?php

class Support_Model_ListTickets {

    public function listTickets($own = false) {

        $db = Zend_Db_Table::getDefaultAdapter();
        $select = new Zend_Db_Select($db);
        $selectTickets = $select->from('tickets')
        ->join('statuses', 'tickets.statusId = statuses.statusId')
        ->joinLeft('tickettypes', 'tickets.ticketType = tickettypes.tickettypeId', array('priorityName' => 'name'))
        ->order('ticketId');

        if($own == true)
            $selectTickets->where('departmentId = '.Zend_Auth::getInstance()->getStorage()->read()->id)
                    ->where('tickets.statusId = 2')
                    ->orWhere('tickets.statusId = 4');

        return $selectTickets;
    }
}