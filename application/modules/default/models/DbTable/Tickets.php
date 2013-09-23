<?php

/**
 *
 * Model_DbTable_Statuses
 * Rozszerza Zend_Db_Table_Abstract
 *
 */
class Model_DbTable_Tickets extends Zend_Db_Table_Abstract {

    /**
     *
     * @var string
     */
    protected $_name = 'tickets';

    public function getTicketsCountPerClient($id) {

        $select = $this->select()
                        ->from('tickets')
                        ->columns(array('liczba' => 'COUNT(`ticketId`)'))
                        ->where('owner = ' . $id);

        return $this->fetchRow($select);
    }

    public function getOpenTicketsCountPerClient($id) {
        $select = $this->select()
                        ->from('tickets')
                        ->columns(array('liczba' => 'COUNT(`ticketId`)'))
                        ->where('owner = ' . $id)
                        ->where('statusId != 6');

        return $this->fetchRow($select);
    }

    public function getTicketsCount() {

        $select = $this->select()
                        ->from('tickets')
                        ->columns(array('liczba' => 'COUNT(`ticketId`)'));

        $result = $this->fetchRow($select);
        return $result['liczba'];
    }

    public function getOpenTicketsCount() {
        $select = $this->select()
                        ->from('tickets')
                        ->columns(array('liczba' => 'COUNT(`ticketId`)'))
                        ->where('statusId = 2')
                        ->orWhere('statusId = 4');

        $result = $this->fetchRow($select);
        return $result['liczba'];
    }

    public function getOpenTicketsCountPerSupporter($id) {
        $select = $this->select()
                        ->from('tickets')
                        ->columns(array('liczba' => 'COUNT(`ticketId`)'))
                        ->where('departmentId = ' . $id)
                        ->where('statusId = 2')
                        ->orWhere('statusId = 4');

        $result = $this->fetchRow($select);
        return $result['liczba'];
    }

    public function getClosedTicketsCountPerSupporter($id) {
        $select = $this->select()
                        ->from('tickets')
                        ->columns(array('liczba' => 'COUNT(`ticketId`)'))
                        ->where('departmentId = ' . $id)
                        ->where('statusId = 6')
                        ->where('MONTH(modified) = ' . date('m'))
                        ->where('YEAR(modified) = ' . date('Y'))
                        ->where('DAY(modified) = ' . date('d'));

        $result = $this->fetchRow($select);
        return $result['liczba'];
    }

}