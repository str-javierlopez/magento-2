<?php

namespace Hiberus\Lopez\Service;

use Hiberus\Lopez\Api\GetApiStudentsExamsInterface;
use Hiberus\Lopez\Helper\Api as HelperApi;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GetApiStudentsExams
 * @package Hiberus\Lopez\Service
 */
class GetApiStudentsExams implements GetApiStudentsExamsInterface
{

    /**
     * @var Http
     */
    private $_request;

    /**
     * @var JsonFactory
     */
    private $_jsonFactory;

    /**
     * @var HelperApi
     */
    private $_helperApi;

    /**
     * GetApiStudentsExams constructor.
     * @param Http $request
     * @param JsonFactory $jsonFactory
     * @param HelperApi $helper_api
     */
    public function __construct(
        Http $request,
        JsonFactory $jsonFactory,
        HelperApi $helper_api
    ) {
        $this->_request      = $request;
        $this->_jsonFactory  = $jsonFactory;
        $this->_helperApi    = $helper_api;
    }

    /**
     * List of Student exam Api action
     * @api
     * @return Json
     * @throws LocalizedException
     */
    public function getExamsList(): string
    {
        $response = ['status' => false];
        $this->_helperApi->validateRequest();

        $studentsExams = $this->_helperApi->getStudentsExamsList();

        $response = ['status' => true, 'exams' => $studentsExams];

        return json_encode($response);
    }

    /**
     * Remove Student exam Api action
     * @api
     * @return Json
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function removeExamById() : string
    {
        $response = ['status' => false];
        $this->_helperApi->validateRequest();
        $this->_helperApi->canRemoveExam();

        $idExam           = $this->_helperApi->_requestParams['id_exam'];
        $isDeleted        = $this->_helperApi->removeStudentExamById($idExam);
        $messageSuccess   = __('The exam with id %1 has been deleted.', $idExam);
        $message          = $isDeleted ? $messageSuccess : $this->_helperApi->_exceptionsMessages;

        $response = ['status' => $isDeleted, 'message' => $message];

        return json_encode($response);
    }

    /**
     * Add Student exam Api action
     * @api
     * @return string
     */
    public function addStudentExam()
    {
        $response = ['status' => false];
        $this->_helperApi->validateRequest();
        $this->_helperApi->canCreateExam();

        $saved = $this->_helperApi->createStudentExam();

        $response['status'] = $saved;

        return json_encode($response);
    }
}
