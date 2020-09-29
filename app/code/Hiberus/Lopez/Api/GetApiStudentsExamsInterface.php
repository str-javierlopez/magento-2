<?php

namespace Hiberus\Lopez\Api;

use Magento\Framework\Controller\Result\Json;

/**
 * Interface GetApiStudentsExamsInterface
 * @package Hiberus\Lopez\Api
 */
interface GetApiStudentsExamsInterface
{

    /**
     * Retrieve all students exams
     * @return Json
     */
    public function getExamsList() : string;

    /**
     * Delete student exam by id
     * @return Json
     */
    public function removeExamById() : Json;

    /**
     * Create a new student exam
     * @return Json
     */
    public function addStudentExam() : Json;
}
