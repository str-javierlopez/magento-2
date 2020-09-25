<?php

namespace Hiberus\Lopez\Model;

use Hiberus\Lopez\Model\ResourceModel\HiberusExams\Collection;
use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteriaInterface;
use Hiberus\Lopez\Api\Data\HiberusExamsSearchResultInterface;
use Magento\Framework\Api\AbstractSimpleObject;

class ExamsSearchResult extends AbstractSimpleObject implements HiberusExamsSearchResultInterface
{
    const KEY_ITEMS = 'items';
    const KEY_SEARCH_CRITERIA = 'search_criteria';
    const KEY_TOTAL_COUNT = 'total_count';

    /**
     * Get items
     *
     * @return \Magento\Framework\Api\AbstractExtensibleObject[]
     */
    public function getItems()
    {
        return $this->_get(self::KEY_ITEMS) === null ? [] : $this->_get(self::KEY_ITEMS);
    }

    /**
     * Set items
     *
     * @param \Magento\Framework\Api\AbstractExtensibleObject[] $items
     * @return $this
     */
    public function setItems(array $items) : self
    {
        return $this->setData(self::KEY_ITEMS, $items);
    }

    /**
     * Get search criteria
     *
     * @return SearchCriteria
     */
    public function getSearchCriteria() : SearchCriteria
    {
        return $this->_get(self::KEY_SEARCH_CRITERIA);
    }

    /**
     * Set search criteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return $this
     */
    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria) : self
    {
        return $this->setData(self::KEY_SEARCH_CRITERIA, $searchCriteria);
    }

    /**
     * Get total count
     *
     * @return int
     */
    public function getTotalCount() : int
    {
        return $this->_get(self::KEY_TOTAL_COUNT);
    }

    /**
     * Set total count
     *
     * @param int $count
     * @return $this
     */
    public function setTotalCount(int $count) : self
    {
        return $this->setData(self::KEY_TOTAL_COUNT, $count);
    }

    public function getCollection(): Collection
    {
        return $this->_get(self::COLLECTION_KEY);
    }

    public function setCollection(Collection $collection) : self
    {
        return $this->setData(self::COLLECTION_KEY, $collection);
    }

}
