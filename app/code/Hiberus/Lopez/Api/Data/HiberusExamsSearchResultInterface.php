<?php


namespace Hiberus\Lopez\Api\Data;

use Hiberus\Lopez\Api\Data\HiberusExamsInterface;

/**
 * Interface HiberusExamsSearchResultInterface
 * @package Hiberus\Lopez\Api\Data
 */
interface HiberusExamsSearchResultInterface
{

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
    public function getTotalCount();

    /**
     * Set Total Count
     * @param int $size
     * @return mixed
     */
    public function setTotalCount($size);

}
