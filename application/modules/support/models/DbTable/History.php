<?php

/**
 *
 * Klasa Client_Model_DbTable_Departments klasa używana do wykonywania
 * zapytań w bazie danych związanych z departamentami.
 * Rozszerza Zend_Db_Table_Abstract
 *
 */
class Support_Model_DbTable_History extends Zend_Db_Table_Abstract {

    protected $_name = 'history';

    /**
     * Zwraca wszystkie departamenty z bazy danych.
     */

    public function getResultsForExperts($ids,$from,$to)
    {
        $select = $this->select()
                ->setIntegrityCheck(false)
                ->from('history',array('ol'=>'userId',
                                       'solved' => ' (SELECT COUNT(whatId) FROM `history` WHERE `whatId` = 11 and `userId` = ol)  ',
                                       'move' => ' (SELECT COUNT(whatId) FROM `history` WHERE `whatId` = 18 and `userId` = ol)  ',
                                       'unsolved' => ' (SELECT COUNT(whatId) FROM `history` WHERE `whatId` = 19 and `userId` = ol)  ',
                                       'comment' => ' (SELECT COUNT(whatId) FROM `history` WHERE `whatId` = 20 and `userId` = ol)  ')
                      )
                ->joinLeft('users', 'history.userId = users.id', array('login'))
                ->where('userId IN ('.$ids.')')
                ->where('date > \''.date( 'Y-m-d H:i:s',  strtotime($from)).'\'')
                ->where('date < \''.date( 'Y-m-d H:i:s', strtotime($to.' 23:59:59')).'\'')
                ->group('ol');
        
        return $this->fetchAll($select);
    }

    public function getResultsForUsers($groups,$from,$to)
    {
        $select = $this->select()
                ->setIntegrityCheck(false)
                ->from('history',array('ol'=>'userId',
                                       'createClient' => '(SELECT COUNT(whatId) FROM `history` WHERE `whatId` = 4 and `userId` = ol)',
                                       'commentClient' => '(SELECT COUNT(whatId) FROM `history` WHERE `whatId` = 7 and `userId` = ol)',
                                       'create' => '(SELECT COUNT(whatId) FROM `history` WHERE `whatId` = 5 and `userId` = ol)',
                                       'close' => '(SELECT COUNT(whatId) FROM `history` WHERE `whatId` = 6 and `userId` = ol)',
                                       'comment' => '(SELECT COUNT(whatId) FROM `history` WHERE `whatId` = 8 and `userId` = ol)',
                                       'get' => '(SELECT COUNT(whatId) FROM `history` WHERE `whatId` = 9 and `userId` = ol)',
                                       'createSRQ' => '(SELECT COUNT(whatId) FROM `history` WHERE `whatId` = 10 and `userId` = ol)',
                                       'priority' => '(SELECT COUNT(whatId) FROM `history` WHERE `whatId` = 16 and `userId` = ol)',
                                       'category' => '(SELECT COUNT(whatId) FROM `history` WHERE `whatId` = 17 and `userId` = ol)'
                    )
                      )
                ->joinLeft('users', 'history.userId = users.id', array('login'))
                ->where('userId IN ('.$groups.')')
                ->where('date > \''.date( 'Y-m-d H:i:s',  strtotime($from)).'\'')
                ->where('date < \''.date( 'Y-m-d H:i:s', strtotime($to.' 23:59:59')).'\'')
                ->group('ol');

        return $this->fetchAll($select);
    }

}

