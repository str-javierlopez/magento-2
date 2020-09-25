<?php

namespace Hiberus\Lopez\Model;

use Hiberus\Lopez\Api\Data\HiberusExamsSearchResultInterface;
use Hiberus\Lopez\Model\ResourceModel\HiberusExams\Collection;
use Magento\Framework\Api\AbstractSimpleObject;
use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\AbstractExtensibleObject;

/**
 * Class ExamsSearchResult
 * @package Hiberus\Lopez\Model
 */
class ExamsSearchResult extends AbstractSimpleObject implements HiberusExamsSearchResultInterface
{
    /**
     * Key Items
     */
    const KEY_ITEMS = 'items';

    /**
     * Key search criteria
     */
    const KEY_SEARCH_CRITERIA = 'search_criteria';

    /**
     * Key total count
     */
    const KEY_TOTAL_COUNT = 'total_count';

    /**
     * Get items
     *
     * @return AbstractExtensibleObject[]
     */
    public function getItems() : array
    {
        return $this->_get(self::KEY_ITEMS) === null ? [] : $this->_get(self::KEY_ITEMS);
    }

    /**
     * Set items
     *
     * @param AbstractExtensibleObject[] $items
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

    /**
     * Get Collection
     * @return Collection
     */
    public function getCollection(): Collection
    {
        return $this->_get(self::COLLECTION_KEY);
    }

    /**
     * Set Collection
     * @param Collection $collection
     * @return $this
     */
    public function setCollection(Collection $collection) : self
    {
        return $this->setData(self::COLLECTION_KEY, $collection);
    }
}
