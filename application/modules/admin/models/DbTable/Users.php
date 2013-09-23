<?php

/**
 * Klasa Admin_Model_DbTable_Users
 * Rozszerza Zend_Db_Table_Abstract 
 *
 */
class Admin_Model_DbTable_Users extends Zend_Db_Table_Abstract {

    /**
     * 
     * @var string
     */
    protected $_name = 'users';

    /**
     * metoda showUsers pozwala np. na pokazanie użytkowników należacych do danej grupy.
     */
    public function showUsers() {
        $select = $this->select(Zend_Db_Table_Abstract::SELECT_WITH_FROM_PART)
                        ->setIntegrityCheck(false)
                        ->joinLeft('groups', 'users.groupId = groups.groupId');

        return $this->fetchAll($select);
    }

    /**
     *
     * Metoda addUser pozwala na dodanie użytkownika.
     * @param string $username
     * @param string $password
     * @param string $salt
     * @param boolen $enabled
     * @param id $group
     */
    public function addUser($username, $password, $salt, $enabled, $group) {
        $data = array(
            'login' => $username,
            'pass' => sha1($password . $salt),
            'salt' => $salt,
            'dataReg' => new Zend_Db_Expr('NOW()'),
            'active' => $enabled,
            'groupId' => $group
        );
        $this->insert($data);
    }

    /**
     *
     * getUser metoda pozwalająca na 'pobranie' użytkownika.
     * @param int $id
     * @throws Exception
     */
    public function getUser($id) {
        $id = (int) $id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    public function editUser($id, $username, $enabled, $groupId) {
        $data3 = array(
            'login' => $username,
            'active' => $enabled,
            'groupId' => $groupId
        );
        $this->update($data3, 'id = ' . (int) $id);
    }

    public function editPassword($id, $password, $salt) {
        $data2 = array(
            'pass' => sha1($password.$salt),
            'salt' => $salt
        );
        $this->update($data2, 'id = ' . $id);
    }

    public function delUser($id) {
        $id = (int) $id;
        $this->delete('id=' . $id);
    }

    public function updateUserLoginDetails($id,$ip)
    {
        $data = array(
            'dataLog' => new Zend_Db_Expr('NOW()'),
            'ipLog' => $ip
        );

        $where = 'id = '.$id;

        $this->update($data, $where);
    }


    public function getUsersCount($group=0) {

        $select = $this->select()
                        ->from('users')
                        ->columns(array('liczba' => 'COUNT(`id`)'));

        if ($group != 0) $select->where ('groupId ='.$group);

        $result = $this->fetchRow($select);
        return $result['liczba'];
    }
}
