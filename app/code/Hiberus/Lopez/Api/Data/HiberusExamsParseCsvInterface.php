<?php

namespace Hiberus\Lopez\Api\Data;

use Hiberus\Lopez\Api\Data\HiberusExamsInterface;

/**
 * Interface HiberusExamsParseCsvInterface
 * @package Hiberus\Lopez\Api\Data
 */
interface HiberusExamsParseCsvInterface
{
    /**
     * Parse array data
     * @param array $dataCsv
     * @return HiberusExamsInterface[]
     */
    public function parseData(array $dataCsv);
}
