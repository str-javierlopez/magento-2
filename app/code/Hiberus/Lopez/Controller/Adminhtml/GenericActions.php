<?php

namespace Hiberus\Lopez\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Hiberus\Lopez\Api\Data\HiberusExamsInterface;
use Hiberus\Lopez\Api\HiberusExamsRepositoryInterface;
use Hiberus\Lopez\Model\HiberusExamsFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;
use Hiberus\Lopez\Model\ResourceModel\HiberusExams\CollectionFactory;
use Hiberus\Lopez\Model\ResourceModel\HiberusExams\Collection;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class GenericActions
 * @package Hiberus\Lopez\Controller\Adminhtml
 */
class GenericActions extends Action
{

    /**
     * @var HiberusExamsFactory
     */
    private $_hiberusExamsFactory;

    /**
     * @var HiberusExamsRepositoryInterface
     */
    protected $_hiberusExamsRepository;

    /**
     * @var PageFactory
     */
    protected $_pageFactory;

    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var Filter
     */
    protected $_filter;

    /**
     * GenericActions constructor.
     * @param Context $context
     * @param HiberusExamsFactory $hiberusExamsFactory
     * @param HiberusExamsRepositoryInterface $hiberusExamsRepository
     * @param PageFactory $pageFactory
     * @param CollectionFactory $collectionFactory
     * @param Filter $filter
     */
    public function __construct(
        Context $context,
        HiberusExamsFactory $hiberusExamsFactory,
        HiberusExamsRepositoryInterface $hiberusExamsRepository,
        PageFactory $pageFactory,
        CollectionFactory $collectionFactory,
        Filter $filter
    ) {
        $this->_hiberusExamsFactory    = $hiberusExamsFactory;
        $this->_hiberusExamsRepository = $hiberusExamsRepository;
        $this->_pageFactory            = $pageFactory;
        $this->_collectionFactory      = $collectionFactory;
        $this->_filter                 = $filter;
        parent::__construct($context);
    }

    /**
     * Set Result with redirect and message
     * @param $urlRedirect
     * @param $message
     * @param $success
     * @return mixed
     */
    protected function setResultRedirectWithMessage($urlRedirect, $message, $success)
    {
        if ($success) {
            $this->messageManager->addSuccessMessage($message);
        } else {
            $this->messageManager->addErrorMessage($message);
        }
        $indexPage = $this->_url->getUrl($urlRedirect, ['_secure' => true]);
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath($indexPage);
    }

    /**
     * @param $idExam
     * @param $firstname
     * @param $lastname
     * @param $mark
     * @return HiberusExamsInterface
     */
    protected function createHiberusExam($idExam, $firstname, $lastname, $mark) : HiberusExamsInterface
    {
        $hiberusExam = $this->_hiberusExamsFactory->create();

        $hiberusExam->setIdExam($idExam);
        $hiberusExam->setFirstname($firstname);
        $hiberusExam->setLastname($lastname);
        $hiberusExam->setMark($mark);

        return $hiberusExam;
    }

    /**
     * @param HiberusExamsInterface $hiberusExams
     * @return bool
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    protected function saveStudentExam(HiberusExamsInterface $hiberusExams) : bool
    {
        try {
            $this->_hiberusExamsRepository->save($hiberusExams);
        } catch (CouldNotSaveException $exception) {
            return false;
        }
        return true;
    }

    protected function deleteStudentsExams(Collection $collection) : int
    {
        $examsDeleted = 0;
        foreach ($collection->getItems() as $hiberusExam) {
            $this->_hiberusExamsRepository->delete($hiberusExam);
            $examsDeleted++;
        }

        return $examsDeleted;
    }

    /**
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        // TODO: Implement execute() method.
    }
}
