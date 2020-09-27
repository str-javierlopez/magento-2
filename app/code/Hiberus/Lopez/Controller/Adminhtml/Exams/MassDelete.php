<?php

namespace Hiberus\Lopez\Controller\Adminhtml\Exams;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Hiberus\Lopez\Model\ResourceModel\HiberusExams\CollectionFactory;
use Hiberus\Lopez\Api\HiberusExamsRepositoryInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NotFoundException;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class MassDelete
 * @package Hiberus\Lopez\Controller\Adminhtml\Exams
 */
class MassDelete extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level
     */
    const ADMIN_RESOURCE = 'Hiberus_Lopez::manage_students_exams';

    /**
     * @var CollectionFactory
     */
    private $_collectionFactory;

    /**
     * @var HiberusExamsRepositoryInterface
     */
    private $_examsRepository;

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * Constructor
     *
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param HiberusExamsRepositoryInterface $examsRepository
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        HiberusExamsRepositoryInterface $examsRepository
    ) {
        $this->filter             = $filter;
        $this->_collectionFactory = $collectionFactory;
        $this->_examsRepository   = $examsRepository;
        parent::__construct($context);
    }

    /**
     * Category delete action
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        if (!$this->getRequest()->isPost()) {
            throw new NotFoundException(__('Page not found'));
        }
        $collection = $this->filter->getCollection($this->_collectionFactory->create());
        $examsDeleted = 0;
        foreach ($collection->getItems() as $hiberusExam) {
            $this->_examsRepository->delete($hiberusExam);
            $examsDeleted++;
        }

        if ($examsDeleted) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $examsDeleted)
            );
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('students_grid/index/index');
    }
}
