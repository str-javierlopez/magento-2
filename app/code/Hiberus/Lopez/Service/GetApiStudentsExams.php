<?php

namespace Hiberus\Lopez\Service;

use Hiberus\Lopez\Api\GetApiStudentsExamsInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Integration\Model\Oauth\Consumer;
use Hiberus\Lopez\Helper\Api as HelperApi;

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
     * @var Consumer
     */
    private $_consumerApi;

    /**
     * @var HelperApi
     */
    private $_helperApi;

    /**
     * @var array
     */
    private $_requestParams = [];

    /**
     * GetApiStudentsExams constructor.
     * @param Http $request
     * @param JsonFactory $jsonFactory
     * @param Consumer $consumerApi
     * @param HelperApi $helper_api
     */
    public function __construct(
        Http $request,
        JsonFactory $jsonFactory,
        Consumer $consumerApi,
        HelperApi $helper_api
    ) {
        $this->_request      = $request;
        $this->_jsonFactory  = $jsonFactory;
        $this->_consumerApi  = $consumerApi;
        $this->_helperApi    = $helper_api;
    }

    /**
     * Validate if api key is valid
     * @param $apiKey
     * @return bool
     */
    private function validateCustomerApi($apiKey) : bool
    {
        $consumer = $this->_consumerApi->loadByKey($apiKey);

        return $consumer->getId() !== null;
    }

    /**
     * Validate if is posible remove an exam
     * @return bool
     */
    private function canRemoveExam()
    {
        return isset($this->_requestParams['id_exam']);
    }

    /**
     * Validate if is posible create an exam
     * @return bool
     */
    private function canCreateExam()
    {
        return isset($this->_requestParams['firstname']) && isset($this->_requestParams['lastname'])
            && isset($this->_requestParams['mark']);
    }

    /**
     * Validate the request
     * @return bool
     */
    private function validateRequest()
    {
        if (!$this->_request->isPost() && !$this->_request->isGet()) {
            return false;
        }

        $this->_requestParams = $this->_request->getParams();

        if (!isset($this->_requestParams['apiKey'])) {
            return false;
        }

        return $this->validateCustomerApi($this->_requestParams['apiKey']);
    }

    /**
     * List of Student exam Api action
     * @return Json
     * @throws LocalizedException
     */
    public function getExamsList(): string
    {
        $response = ['status' => false];
        if (!$this->validateRequest()) {
            return json_encode($response);
        }

        $studentsExams = $this->_helperApi->getStudentsExamsList();

        $response = ['status' => true, 'exams' => $studentsExams];

        return json_encode($response);
    }

    /**
     * Remove Student exam Api action
     * @return Json
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function removeExamById(): Json
    {
        $response = $this->_jsonFactory->create()->setData(['status' => false]);
        if (!$this->validateRequest()) {
            return $response;
        }
        if (!$this->canRemoveExam()) {
            $response->setData(['status' => false, 'error' => __('Parameters missing')]);
            return $response;
        }

        $idExam           = $this->_requestParams['id_exam'];
        $isDeleted        = $this->_helperApi->removeStudentExamById($idExam);
        $messageSuccess   = __('The exam with id %1 has been deleted.', $idExam);
        $message          = $isDeleted ? $messageSuccess : $this->_helperApi->_exceptionsMessages;

        $response->setData(['status' => true, 'message' => $message]);

        return $response;
    }

    /**
     * Add Student exam Api action
     * @return string
     */
    public function addStudentExam(): string
    {
        $response = ['status' => false];
        if (!$this->validateRequest()) {
            return json_encode($response);
        }
        if (!$this->canCreateExam()) {
            return json_encode($response);
        }

        $saved = $this->_helperApi->createStudentExam($this->_requestParams);

        $response['status'] = $saved;

        return json_encode($response);
    }

}
