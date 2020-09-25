<?php


namespace Hiberus\Lopez\Api\Data;

use Hiberus\Lopez\Api\Data\HiberusExamsInterface;
use Hiberus\Lopez\Model\ResourceModel\HiberusExams\Collection;

/**
 * Interface HiberusExamsSearchResultInterface
 * @package Hiberus\Lopez\Api\Data
 */
interface HiberusExamsSearchResultInterface
{

    const COLLECTION_KEY = 'collection';

    const DATA_KEY       = 'data';

    /**
     * Get List of exams
     * @return array
     */
    public function getItems();

    /**
     * Set List of exams
     * @api
     * @param array $items
     * @return $this
     */
    public function setItems(array $items);

    /**
     * Get total count
     * @return int
     */
    public function getTotalCount() : int;

    /**
     * Set Total Count
     * @param int $size
     * @return mixed
     */
    public function setTotalCount(int $size);

    public function getCollection() : Collection;

    public function setCollection(Collection $collection);

}
