<?php

class Admin_Model_DbTable_Premissions extends Zend_Db_Table_Abstract {

    /**
     *
     * @var string
     */
    protected $_name = 'userindepartments';

    public function getPremissions($id) {
        $select = $this->select(Zend_Db_Table_Abstract::SELECT_WITH_FROM_PART)
                 ->setIntegrityCheck(false)
                ->where('usersId = '.$id)
                ->joinLeft('departments', 'userindepartments.userDepartmentsId = departments.departmentId');

        return $this->fetchAll($select);
    }

    public function addPremission($userId,$departmentId) {
         $data = array(
            'userDepartmentsId' => $departmentId,
            'usersId' => $userId
        );
        $this->insert($data);
    }

    public function deletePremission($user,$group) {

        $this->delete('usersId = ' . $user.' and userDepartmentsId = '.$group);
    }

    public function checkPremission( $user, $group  ) {

        if( Zend_Registry::get('role') == 'admins' )
            return true;

        $select = $this->select()
                ->where('usersId='.$user.' and userDepartmentsId='.$group);

        if ( count($this->fetchAll($select)) == 1)
                return true;
        else
                return false;
    }
}
