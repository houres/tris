<?php

class Model_Mail {

    public function sendMail($userId,$whatUserType, $topic, $body) {

        $db = new Admin_Model_DbTable_Preferences();

        // global checkings
        if (!$db->getPreferenceByName('emailEnable')) {
            return;
        }


        // send mail for client
        if ($whatUserType == 1 and $db->getPreferenceByName('emailSentClient')) {

            $userDetailsDb = new Admin_Model_DbTable_UserDetails();
            $result = $userDetailsDb->getUserDetails($userId);

            if ($result['email'] == '')
                return;

            $email = $result['email'];

            $mail = new Zend_Mail('UTF-8');
            $mail->setSubject( $topic )
                    ->addTo($email)
                    ->setBodyHtml( $body )
                    ->setFrom( $db->getPreferenceByName('emailTicketMail') );

            $mail->send();
        }

        // send mail for support
        if ($whatUserType == 2 and $db->getPreferenceByName('emailSentSupport')) {
            
        }
    }

}