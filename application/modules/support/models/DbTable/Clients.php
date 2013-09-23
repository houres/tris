<?php
/**
 * Klasa Admin_Model_DbTable_Users
 * Rozszerza Zend_Db_Table_Abstract
 *
 */
class Support_Model_DbTable_Clients extends Zend_Db_Table_Abstract {
    /**
     *
     * @var string
     */
	protected $_name = 'users';

	/**
	 * metoda showUsers pozwala np. na pokazanie użytkowników należacych do danej grupy.
	 */
    public function showUsersByGroupId($id)
    {
        $select = $this->select()
                ->where('groupId = '.$id);

        return $this->fetchAll($select);
    }
}
