<?php
/**
 * 
 * Model_DbTable_Groups
 * Rozszerza Zend_Db_Table_Abstract
 *
 */
class Model_DbTable_Groups extends Zend_Db_Table_Abstract
{
	/**
	 * 
	 * @var string
	 */
    protected $_name = 'groups';

    /**
     * 
     * getGroupName odpowiedzialna za pobieranie nazwy grupy.
     * @param int $id
     */
    public function getGroupName($id) {
        $id = (int)$id;

        $row = $this->fetchRow('groupId = '.$id);

        $row->toArray();
        
        return $row['name'];
    }

}