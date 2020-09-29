<?php

namespace Hiberus\Lopez\Controller\Adminhtml\Edit;

use Hiberus\Lopez\Controller\Adminhtml\GenericActions;
use Magento\Framework\Controller\ResultInterface;

class Index extends GenericActions
{

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->_pageFactory->create();
        $params     = $this->getRequest()->getParams();
        $idExam     = $params['id_exam'];
        $firstname  = $params['firstname'];
        $lastname   = $params['lastname'];
        $mark       = $params['mark'];
        if (!isset($params['is_edit'])) {
            $resultPage->setActiveMenu('Hiberus_Lopez::menu');
            $resultPage->getConfig()->getTitle()->prepend(__('Edit Exam'));
            return $resultPage;
        }

        $hiberusExam = $this->createHiberusExam($idExam, $firstname, $lastname, $mark);

        $saved       = $this->saveStudentExam($hiberusExam);

        $message     = __('The Exam with id %1 has been updated.', $idExam);

        return $this->setResultRedirectWithMessage('students_grid/index/index', $message, $saved);
    }


}
