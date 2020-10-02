<?php

namespace Hiberus\Lopez\Helper;

use Hiberus\Lopez\Api\Data\HiberusExamsInterface;
use Hiberus\Lopez\Api\ExamManagementInterface;
use Hiberus\Lopez\Api\HiberusExamsRepositoryInterface;
use Hiberus\Lopez\Model\HiberusExamsFactory;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Setup\Exception;
use Hiberus\Lopez\Helper\Csv as HelperCsv;
use Hiberus\Lopez\Exception\StudentExamCouldNotAddedException;
use PHPStan\DependencyInjection\ParameterNotFoundException;
use Hiberus\Lopez\Exception\StudentExamCouldNotDeletedException;

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

    private $_helperCsv;

    /**
     * @var array
     */
    public $_requestParams = [];

    /**
     * Api constructor.
     * @param Context $context
     * @param ExamManagementInterface $examManagement
     * @param HiberusExamsRepositoryInterface $hiberusExamsRepository
     * @param HiberusExamsFactory $hiberusExamsFactory
     * @param HelperCsv $helperCsv
     */
    public function __construct(
        Context $context,
        ExamManagementInterface $examManagement,
        HiberusExamsRepositoryInterface $hiberusExamsRepository,
        HiberusExamsFactory $hiberusExamsFactory,
        HelperCsv $helperCsv
    ) {
        $this->_examManager            = $examManagement;
        $this->_hiberusExamsRepository = $hiberusExamsRepository;
        $this->_hiberusExamsFactory    = $hiberusExamsFactory;
        $this->_helperCsv              = $helperCsv;
        parent::__construct($context);
    }

    /**
     * Validate if is posible remove an exam
     */
    public function canRemoveExam()
    {
        if (!isset($this->_requestParams['id_exam'])) {
            throw new ParameterNotFoundException(__('Missing parameters.'));
        }
    }

    /**
     * Validate if is posible create an exam
     */
    public function canCreateExam()
    {
        if (!isset($this->_requestParams['firstname']) || !isset($this->_requestParams['lastname'])) {
            throw new ParameterNotFoundException(__('Missing parameters.'));
        }
    }

    /**
     * Validate the request
     */
    public function validateRequest()
    {
        if (!$this->_request->isPost() && !$this->_request->isGet() && !$this->_request->isDelete()) {
            throw new \HttpRequestMethodException(__('The request method is not valid.'));
        }

        $this->_requestParams = $this->_request->getParams();
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
     * @throws StudentExamCouldNotDeletedException
     */
    public function removeStudentExamById($idExam) : bool
    {
        try {
            $this->_hiberusExamsRepository->deleteByIdExam($idExam);
        } catch (StudentExamCouldNotDeletedException $exception) {
            throw new StudentExamCouldNotDeletedException(__('The student exam could not be deleted.'));
        }
        return true;
    }

    /**
     * Create a student exam
     * @return bool
     * @throws Exception
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function createStudentExam() : bool
    {
        $hiberusExam = $this->createHiberusStudentExam($this->_requestParams);
        return $this->saveHiberusStudentExam($hiberusExam);
    }

    /**
     * Save an student exam
     * @param HiberusExamsInterface $hiberusExams
     * @return bool | Exception
     * @throws LocalizedException
     * @throws LocalizedException
     * @throws Exception
     */
    private function saveHiberusStudentExam(HiberusExamsInterface $hiberusExams)
    {
        try {
            $this->_hiberusExamsRepository->save($hiberusExams);
        } catch (Exception $exception) {
            throw new Exception(__('The Student Exam could not be delete.'));
        }
        return true;
    }

    /**
     * Create a hiberus student exam object
     * @param $params
     * @return HiberusExamsInterface
     * @throws Exception
     */
    private function createHiberusStudentExam($params) : HiberusExamsInterface
    {
        $hiberusExam = $this->_hiberusExamsFactory->create();
        $hiberusExam->setFirstname($params['firstname']);
        $hiberusExam->setLastname($params['lastname']);
        $mark = !isset($params['mark']) ? $this->_helperCsv->generateRandomMark() : $params['mark'];
        $mark = floatval($mark);
        if ($mark < 0 || $mark > 10) {
            throw new Exception(__('The mark must be between 0 and 10.'));
        }
        $hiberusExam->setMark($mark);
        return $hiberusExam;
    }
}
