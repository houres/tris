<?php

class Admin_Model_DbTable_Preferences extends Zend_Db_Table_Abstract {

    /**
     *
     * @var string
     */
    protected $_name = 'preferences';
    protected $_primary = 'name';


    public function getPreferences($what) {
        $select = $this->select()
                ->where('name LIKE \''.$what.'%\'');

        $result = array();
        $resultDb = $this->fetchAll($select)->toArray();

        foreach ( $resultDb as $value ) {
            $result[$value['name']] = $value['value'];
        }

        return $result;
    }

    public function getPreferenceByName($name) {
        $select = $this->select()->where('name = \''.$name.'\'');

        $result = $this->fetchRow($select);

        return $result['value'];
    }

    public function updatePreferences($array) {

        foreach ($array as $value => $name) {

            $where  = $this->getAdapter()->quoteInto('name = ?', $value);
            $this->update( array( 'value' => $name ), $where );
        }
       //$this->update($array, '');
        
    }


}