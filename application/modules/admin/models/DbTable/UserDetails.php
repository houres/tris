<?php

/**
 * Klasa Admin_Model_DbTable_Users
 * Rozszerza Zend_Db_Table_Abstract
 *
 */
class Admin_Model_DbTable_UserDetails extends Zend_Db_Table_Abstract {

    /**
     *
     * @var string
     */
    protected $_name = 'userdet';

    public function getUserDetails($id) {
        $id = (int) $id;
        $row = $this->fetchRow('userId = ' . $id);
        return $row->toArray();
    }

    public function getUserDetailsCount($id) {
        $id = (int) $id;
        $row = $this->fetchRow('userId = ' . $id);
        return count($row);
    }

    public function addDetails($userId, $name, $surname, $email, $company) {

        $data = array(
            'userId' => $userId,
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'company' => $company
        );

        $this->insert($data);
    }

    public function updateDetails($userId, $name, $surname, $email, $company) {
        $data = array(
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'company' => $company
        );
        $this->update($data, 'userId = ' . $userId);
    }

}