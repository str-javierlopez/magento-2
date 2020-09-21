<?php

namespace Hiberus\Lopez\Model;

use Hiberus\Lopez\Api\Data\HiberusExamsSearchResultInterfaceFactory;
use Hiberus\Lopez\Api\ExamManagementInterface;
use Hiberus\Lopez\Model\ResourceModel\HiberusExams\CollectionFactory as HiberusExamsCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Hiberus\Lopez\Api\Data\HiberusExamsSearchResultInterface;

/**
 * Class ExamManagement
 * @package Hiberus\Lopez\Model
 */
class ExamManagement implements ExamManagementInterface
{
    /**
     * @var HiberusExamsCollectionFactory
     */
    private $_hiberusExamsCollection;

    /**
     * @var CollectionProcessorInterface
     */
    private $_collectionProcessor;

    /**
     * @var HiberusExamsSearchResultInterfaceFactory
     */
    private $_searchResultFactory;

    /**
     * ExamManagement constructor.
     * @param HiberusExamsCollectionFactory $hiberusExamsCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param HiberusExamsSearchResultInterfaceFactory $searchResultInterfaceFactory
     */
    public function __construct(
        HiberusExamsCollectionFactory $hiberusExamsCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        HiberusExamsSearchResultInterfaceFactory $searchResultInterfaceFactory
    ) {
        $this->_hiberusExamsCollection = $hiberusExamsCollectionFactory;
        $this->_collectionProcessor    = $collectionProcessor;
        $this->_searchResultFactory    = $searchResultInterfaceFactory;
    }

    /**
     * Get List of Hiberus Exams
     * @param SearchCriteriaInterface $searchCriteria
     * @return HiberusExamsSearchResultInterface|HiberusExamsSearchResultInterface[]
     */
    public function getList(SearchCriteriaInterface $searchCriteria) : HiberusExamsSearchResultInterface
    {
        $collection = $this->_hiberusExamsCollection->create();

        if (isset($searchCriteria)) {
            $this->_collectionProcessor->process($searchCriteria, $collection);
        }

        $searchResults = $this->_searchResultFactory->create();

        $searchResults->setItems($collection->getItems());

        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
