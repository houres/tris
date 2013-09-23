<?php
/**
 * Klasa odpowiedzialna za wykonywanie zapytań w bazie danych związanych z Grupami.
 * Rozszerza klasę Zend_Db_Table_Abstract
 */
class Model_DbTable_Groups extends Zend_Db_Table_Abstract
{
	/** 
	 * @var string
	 */
    protected $_name = 'groups';

    /**
     * getGroupName jest to metoda odpowiedzialna pobieranie nazwy grupy. 
     * @param int $id
     * @return name
     */
    public function getGroupName($id) {
        $id = (int)$id;

        $row = $this->fetchRow('id = '.$id);

        $row->toArray();
        
        return $row['name'];
    }

}