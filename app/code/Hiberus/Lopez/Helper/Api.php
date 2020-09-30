<?php


namespace Hiberus\Lopez\Helper;

use Hiberus\Lopez\Api\Data\HiberusExamsInterface;
use Hiberus\Lopez\Api\ExamManagementInterface;
use Hiberus\Lopez\Api\HiberusExamsRepositoryInterface;
use Hiberus\Lopez\Model\HiberusExamsFactory;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Api
 * @package Hiberus\Lopez\Helper
 */
class Api extends AbstractHelper
{

    /**
     * @var ExamManagementInterface
     */
    private $_examManager;

    /**
     * @var HiberusExamsRepositoryInterface
     */
    private $_hiberusExamsRepository;

    /**
     * @var HiberusExamsFactory
     */
    private $_hiberusExamsFactory;

    /**
     * @var string
     */
    public $_exceptionsMessages;

    /**
     * Api constructor.
     * @param Context $context
     * @param ExamManagementInterface $examManagement
     * @param HiberusExamsRepositoryInterface $hiberusExamsRepository
     * @param HiberusExamsFactory $hiberusExamsFactory
     */
    public function __construct(
        Context $context,
        ExamManagementInterface $examManagement,
        HiberusExamsRepositoryInterface $hiberusExamsRepository,
        HiberusExamsFactory $hiberusExamsFactory
    ) {
        $this->_examManager            = $examManagement;
        $this->_hiberusExamsRepository = $hiberusExamsRepository;
        $this->_hiberusExamsFactory    = $hiberusExamsFactory;
        parent::__construct($context);
    }

    /**
     * Retrieve a list of all students exams
     * @return array
     * @throws LocalizedException
     */
    public function getStudentsExamsList() : array
    {
        $searchResult = $this->_examManager->getList();

        return $searchResult->getCollection()->getData();
    }

    /**
     * Remove exam by id
     * @param $idExam
     * @return bool
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function removeStudentExamById($idExam) : bool
    {
        try {
            $this->_hiberusExamsRepository->deleteByIdExam($idExam);
        } catch (CouldNotDeleteException $exception) {
            $this->_exceptionsMessages = $exception->getMessage();
            return false;
        }
        return true;
    }

    /**
     * Create a student exam
     * @param $params
     * @return bool
     */
    public function createStudentExam($params) : bool
    {
        $hiberusExam = $this->createHiberusStudentExam($params);
        return $this->saveHiberusStudentExam($hiberusExam);
    }

    /**
     * Save an student exam
     * @param HiberusExamsInterface $hiberusExams
     * @return bool
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    private function saveHiberusStudentExam(HiberusExamsInterface $hiberusExams) : bool
    {
        try {
            $this->_hiberusExamsRepository->save($hiberusExams);
        } catch (CouldNotSaveException $exception) {
            $this->_exceptionsMessages = $exception->getMessage();
            return false;
        }
        return true;
    }

    /**
     * Create a hiberus student exam object
     * @param $params
     * @return HiberusExamsInterface
     */
    private function createHiberusStudentExam($params) : HiberusExamsInterface
    {
        $hiberusExam = $this->_hiberusExamsFactory->create();
        $hiberusExam->setFirstname($params['firstname']);
        $hiberusExam->setLastname($params['lastname']);
        $hiberusExam->setMark($params['mark']);
        return $hiberusExam;
    }
}
