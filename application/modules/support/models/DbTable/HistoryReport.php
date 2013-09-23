<?php

class Support_Model_DbTable_HistoryReport extends Zend_Db_Table_Abstract
{

    protected $_name = 'historyreport';

    /**
     * Zwraca wszystkie typy request�w z bazy danych.
     */
    public function addReport($case, $userId, $dataArray) {
        
        $data = array(
            'reportCase' => $case,
            'userId' => $userId,
            'createDate' => new Zend_Db_Expr('NOW()'),
            'data' => $dataArray
        );

        $this->insert($data);

    }

    public function getAllReportsByCase($caseId) {
        
        $select = $this->select()
                ->setIntegrityCheck(false)
                ->from('historyreport', array('userId','reportId','createDate') )
                ->join('users', 'historyreport.userId = users.id', array('login'))
                ->where('historyreport.reportCase = '.$caseId);

        return $this->fetchAll($select);
    }

    public function getReportById($id) {
        $select = $this->select()
                ->from($this->_name, 'data' )
                ->where('reportId = '.$id);

        return $this->fetchRow($select);
    }


}

