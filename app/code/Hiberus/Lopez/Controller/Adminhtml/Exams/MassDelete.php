<?php

namespace Hiberus\Lopez\Controller\Adminhtml\Exams;

use Hiberus\Lopez\Controller\Adminhtml\GenericActions;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\NotFoundException;

/**
 * Class MassDelete
 * @package Hiberus\Lopez\Controller\Adminhtml\Exams
 */
class MassDelete extends GenericActions implements HttpPostActionInterface
{
    /**
     * Authorization level
     */
    const ADMIN_RESOURCE = 'Hiberus_Lopez::manage_students_exams';


    /**
     * Exams delete action
     * @return Redirect
     */
    public function execute(): Redirect
    {
        if (!$this->getRequest()->isPost()) {
            throw new NotFoundException(__('Page not found'));
        }
        $collection   = $this->_filter->getCollection($this->_collectionFactory->create());
        $examsDeleted = $this->deleteStudentsExams($collection);

        $message = null;
        if ($examsDeleted) {
            $message = __('A total of %1 record(s) have been deleted.', $examsDeleted);
        }
        return $this->setResultRedirectWithMessage('students_grid/index/index', $message, $examsDeleted);
    }
}
