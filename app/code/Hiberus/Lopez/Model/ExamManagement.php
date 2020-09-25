<?php

namespace Hiberus\Lopez\Model;

use Hiberus\Lopez\Api\Data\HiberusExamsSearchResultInterfaceFactory;
use Hiberus\Lopez\Api\ExamManagementInterface;
use Hiberus\Lopez\Model\ResourceModel\HiberusExams\CollectionFactory as HiberusExamsCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Hiberus\Lopez\Api\Data\HiberusExamsSearchResultInterface;
use Hiberus\Lopez\Model\ResourceModel\HiberusExams\Collection;
use Magento\Framework\Api\SearchResults;

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
     * Get List of Hiberus Exams filter by criteria
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResults | HiberusExamsSearchResultInterface|HiberusExamsSearchResultInterface[]
     */
    public function getListByCriteria(SearchCriteriaInterface $searchCriteria) : SearchResults
    {
        $collection = $this->_hiberusExamsCollection->create();

        $this->_collectionProcessor->process($searchCriteria, $collection);

        return $this->prepareCollection($collection);
    }

    /**
     * Get List of Hiberus Exams
     * @return SearchResults | HiberusExamsSearchResultInterface|HiberusExamsSearchResultInterface[]
     */
    public function getList() : HiberusExamsSearchResultInterface
    {
        $collection = $this->_hiberusExamsCollection->create();

        return $this->prepareCollection($collection);
    }

    /**
     * @param Collection $collection
     * @return SearchResults | HiberusExamsSearchResultInterface | HiberusExamsSearchResultInterface[]
     */
    private function prepareCollection(Collection $collection) : HiberusExamsSearchResultInterface
    {
        $searchResults = $this->_searchResultFactory->create();

        $searchResults->setItems($collection->getItems());
        $searchResults->setCollection($collection);
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * Convert search result items in array
     * @param HiberusExamsSearchResultInterface $searchResults
     * @return array
     */
    public function searchResultItemsToArray(HiberusExamsSearchResultInterface $searchResults) : array
    {
        $items = $searchResults->getItems();
        $itemsArray = [];
        foreach ($items as $item) {
            array_push($itemsArray, $item->getData());
        }
        return $itemsArray;
    }
}
