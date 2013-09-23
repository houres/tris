<?php

class Support_Model_DbTable_Ticketrequest extends Zend_Db_Table_Abstract
{

    protected $_name = 'ticketrequest';
    
    public function addSupportRequest($ticketId, $groupId, $ticketSubject, $statusId,
                                        $ticketBody, $ownerId, $responsibilityId,
                                        $ticketTypesRequestId) {
        $data = array(
            'ticketId' => $ticketId,
            'groupId' => $groupId,
            'ticketSubject' => $ticketSubject,
            'ticketBody' => $ticketBody,
            'startTime' => new Zend_Db_Expr('NOW()'),
            'modifiedTime' => new Zend_Db_Expr('NOW()'),
            'statusId' => $statusId,
            'ownerId' => $ownerId,
            'responsibilityID' => $responsibilityId,
            'ticketTypesRequestId' => $ticketTypesRequestId
        );
        $this->insert($data);

        $changeTicketStatus = new Support_Model_DbTable_Tickets();
        $changeTicketStatus->setStatus('4', $ticketId);
    }

    public function howManyRequestPerStatus($statusId,$ticketId)
    {

        $selectRequests = $this->select()
                ->where('statusId='.$statusId.' and ticketId='.$ticketId);

        return count($this->fetchAll($selectRequests));
    }

    public function listRequests()
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = new Zend_Db_Select($db);
        $selectRequests = $select->from('ticketrequest')
        ->joinLeft('requeststatuses', 'ticketrequest.statusId = requeststatuses.statusId')
        ->joinLeft('departments', 'ticketrequest.groupId = departments.departmentId')
        ->order('id');

        return $selectRequests;
    }

    public function getSupports($id)
    {

        $ticketId = (int)$id;
        $select = $this->select(Zend_Db_Table_Abstract::SELECT_WITH_FROM_PART)
                ->setIntegrityCheck(false)
                ->join('requeststatuses', 'ticketrequest.statusId = requeststatuses.statusId')
                ->where('ticketId = '.$ticketId);
        
            return $this->fetchAll($select);

    }

    public function getSupport($id) {
        $supportId = (int)$id;

        $select = $this->select(Zend_Db_Table_Abstract::SELECT_WITH_FROM_PART)
                ->setIntegrityCheck(false)
                ->joinLeft('requeststatuses', 'ticketrequest.statusId = requeststatuses.statusId')
                ->joinLeft('departments', 'ticketrequest.groupId =  departments.departmentId')
                ->where('id = '.$supportId);

        $row = $this->fetchAll($select);

        if ( count($row) != 0 )
            return $row->toArray();
    }

    public function setStatus($id,$supportId){
        $id = (int)$id;
        $data = array('statusId'=>$id);

        $this->update($data,'id = '.$supportId);
    }

    public function setDepartment($id, $srqId) {
        $id = (int) $id;
        $data = array('groupId' => $id);

        $this->update($data, 'id = ' . $srqId);
    }
}

