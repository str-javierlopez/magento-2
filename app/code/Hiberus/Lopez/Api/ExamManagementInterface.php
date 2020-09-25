<?php


namespace Hiberus\Lopez\Api;

use Hiberus\Lopez\Api\Data\HiberusExamsSearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;

interface ExamManagementInterface
{

    /**
     * Retrieve exams by a criteria
     * @param bool|SearchCriteriaInterface $searchCriteria
     * @return HiberusExamsSearchResultInterface[]
     * @throws LocalizedException
     */
    public function getListByCriteria(SearchCriteriaInterface $searchCriteria);

    /**
     * Retrieve all exams
     * @return HiberusExamsSearchResultInterface[]
     * @throws LocalizedException
     */
    public function getList();

}
