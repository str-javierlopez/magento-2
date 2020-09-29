<?php

namespace Hiberus\Lopez\Controller\Adminhtml\Add;

use Hiberus\Lopez\Controller\Adminhtml\GenericActions;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class Index
 * @package Hiberus\Lopez\Controller\Adminhtml\Add
 */
class Index extends GenericActions
{

    /**
     * Dispatch request
     * @return ResultInterface|ResponseInterface
     */
    public function execute()
    {
        $resultPage = $this->_pageFactory->create();

        $resultPage->getConfig()->getTitle()->prepend((__('New Exam')));

        $params = $this->getRequest()->getParams();

        $actionSave = isset($params['firstname']) && isset($params['lastname']) && isset($params['mark']);

        if (!$actionSave) {
            return $resultPage;
        }

        $hiberusExam = $this->createHiberusExam(null, $params['firstname'], $params['lastname'], $params['mark']);

        $isSaved = $this->saveStudentExam($hiberusExam);
        $messageError   = __('The exam could not be saved.');
        $messageSuccess = __('The exam of %1 has been saved.', $hiberusExam->getFirstname());
        $message = $isSaved ? $messageSuccess : $messageError;
        return $this->setResultRedirectWithMessage('students_grid/index/index', $message, $isSaved);
    }
}
