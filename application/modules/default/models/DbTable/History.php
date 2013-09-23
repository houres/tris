<?php

class Model_DbTable_History extends Zend_Db_Table_Abstract
{
	/**
	 *
	 * @var string
	 */
    protected $_name = 'history';

    /**
     *
     * getGroupName odpowiedzialna za pobieranie nazwy grupy.
     * @param int $id
     */

    public function addHistoryEvent($whatHappendId = 0,$userId = 0)
    {
        if( isset( Zend_Auth::getInstance()->getStorage()->read()->id ) and Zend_Auth::getInstance()->getStorage()->read()->id != null )
        {
            $userId = Zend_Auth::getInstance()->getStorage()->read()->id;
        }


        $ip = $_SERVER['REMOTE_ADDR'];

        $data = array(
            'userId' => $userId,
            'whatId' => $whatHappendId,
            'date' => new Zend_Db_Expr('NOW()'),
            'ip' => $ip
        );
        $this->insert($data);
    }

}
?>
