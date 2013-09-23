<?php

class Support_StatController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $form = new Support_Form_WhatStat();
        $this->view->form = $form;
    }

    public function usersAction()
    {
        $url = new Zend_View_Helper_Url();
        $form = new Support_Form_WhatStat();
        $this->view->form = $form;
        $form->setAction($url->url(array('module' => 'support', 'controller' => 'stat', 'action' => 'users'),'default', 'true'));

        $dbReport = new Support_Model_DbTable_HistoryReport();
        $row = $dbReport->getAllReportsByCase(1);
        
        $this->view->reportList = $row;

        $reportId = $this->_getParam('report');

        if ( $reportId != 0 ) {

            $dbRep2 = new Support_Model_DbTable_HistoryReport();
            $resultFromDb = $dbRep2->getReportById($reportId);

            $this->view->report = true;
            $this->view->results = unserialize(gzuncompress(base64_decode($resultFromDb['data'])));

        }

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {

                $departmentId = $form->getValue('group');
                $dateFrom = $form->getValue('from');
                $dateTo = $form->getValue('to');

                $dbUsers = new Admin_Model_DbTable_Users();
                $select = $dbUsers->select()->where('groupId = ' . $departmentId);

                $result = $dbUsers->fetchAll($select);

                $ids = '';

                foreach ($result as $group) {

                    $ids .= $group->id . ',';
                }

                $ids = substr($ids, '0', strlen($ids) - 1);

                $dbExperts = new Support_Model_DbTable_History();

                $resultFromDb = $dbExperts->getResultsForUsers($ids, $dateFrom, $dateTo);

                $this->view->report = true;
                $this->view->results = $resultFromDb;

                $formReport = new Support_Form_SaveReport();
                $url = new Zend_View_Helper_Url();

                $formReport->setAction($url->url(array('module' => 'support', 'controller' => 'stat', 'action' => 'save')));

                $formReport->data->setValue(base64_encode(gzcompress(serialize($resultFromDb))));
                $formReport->type->setValue(1);

                $this->view->formRaport = $formReport;
            }
        
    }

    }

    public function expertsAction()
    {
        // action body
        $url = new Zend_View_Helper_Url();
        $form = new Support_Form_WhatStatExpert();
        $this->view->form = $form;
        $form->setAction($url->url(array('module' => 'support', 'controller' => 'stat', 'action' => 'experts'),'default', 'true'));

        $dbReport = new Support_Model_DbTable_HistoryReport();
        $row = $dbReport->getAllReportsByCase(2);

        $this->view->reportList = $row;

        $reportId = $this->_getParam('report');

        if ( $reportId != 0 ) {

            $dbRep2 = new Support_Model_DbTable_HistoryReport();
            $resultFromDb = $dbRep2->getReportById($reportId);

            $this->view->report = true;
            $this->view->results = unserialize(gzuncompress(base64_decode($resultFromDb['data'])));

        }

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {

                $departmentId = $form->getValue('department');
                $dateFrom = $form->getValue('from');
                $dateTo = $form->getValue('to');

                $dbUsers = new Support_Model_DbTable_UserInDepartments();
                $select = $dbUsers->select()->where('userDepartmentsId = ' . $departmentId);

                $result = $dbUsers->fetchAll($select);

                $ids = '';

                foreach ($result as $group) {

                    $ids .= $group->usersId . ',';
                }

                $ids = substr($ids, '0', strlen($ids) - 1);

                $dbExperts = new Support_Model_DbTable_History();

                $resultFromDb = $dbExperts->getResultsForExperts($ids, $dateFrom, $dateTo);
                $this->view->report = true;
                $this->view->results = $resultFromDb;


                $formReport = new Support_Form_SaveReport();
                $url = new Zend_View_Helper_Url();

                $formReport->setAction($url->url(array('module' => 'support', 'controller' => 'stat', 'action' => 'save')));

                $formReport->data->setValue(base64_encode(gzcompress(serialize($resultFromDb))));
                $formReport->type->setValue(2);

                $this->view->formRaport = $formReport;
            }
        
    }}

    public function saveAction()
    {
        $form = new Support_Form_SaveReport();

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {

                $type = $form->getValue('type');
                $data = $form->getValue('data');
                $userId = Zend_Auth::getInstance()->getStorage()->read()->id;

                $db = new Support_Model_DbTable_HistoryReport();
                $db->addReport($type, $userId, $data);
                
            }
        }

        $this->_redirect('profile');
    }


}



