<?php

class Support_Model_DbTable_UserInDepartments extends Zend_Db_Table_Abstract
{

    protected $_name = 'userindepartments';

    public function checkUserInDepartment($user,$department) {
        
        $select = $this->select()
                ->where('userDepartmentsId = '.$department)
                ->where('usersId = '. $user);
        
        
        $result = $this->fetchAll($select);
        
        return $result;

    }

}

