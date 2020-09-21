<?php

namespace Hiberus\Lopez\Api;

use Hiberus\Lopez\Api\Data\HiberusExamsInterface;
use Hiberus\Lopez\Api\Data\HiberusExamsSearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Interface HiberusExamsRepositoryInterface
 * @package Hiberus\Lopez\Api
 */
interface HiberusExamsRepositoryInterface
{

    /**
     * Save Exam
     * @param $hiberusExam
     * @return bool
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function save($hiberusExam);

    /**
     * Retrieve exam by id
     * @param $idExam
     * @return HiberusExamsInterface
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function getByIdExam($idExam);

    /**
     * Delete Exam
     * @param HiberusExamsInterface $hiberusExam
     * @return bool
     * @throws LocalizedException
     */
    public function delete(HiberusExamsInterface $hiberusExam);

    /**
     * Delete exam by Id
     * @param $idExam
     * @return bool
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteByIdExam($idExam);
}
