<?php

namespace Hiberus\Lopez\Model;

use Hiberus\Lopez\Api\Data\HiberusExamsParseCsvInterface;
use Hiberus\Lopez\Model\HiberusExamsFactory;
use Hiberus\Lopez\Api\Data\HiberusExamsInterface;
use Hiberus\Lopez\Helper\Csv as HelperCsv;

/**
 * Class HiberusExamsParseCsv
 * @package Hiberus\Lopez\Model
 */
class HiberusExamsParseCsv implements HiberusExamsParseCsvInterface
{

    /**
     * @var \Hiberus\Lopez\Model\HiberusExamsFactory
     */
    private $_hiberusExamsFactory;

    /**
     * @var HelperCsv
     */
    private $_csvHelper;

    /**
     * HiberusExamsParseCsv constructor.
     * @param \Hiberus\Lopez\Model\HiberusExamsFactory $hiberusExamsFactory
     * @param HelperCsv $csvHelper
     */
    public function __construct(
        HiberusExamsFactory $hiberusExamsFactory,
        HelperCsv $csvHelper
    ) {
        $this->_hiberusExamsFactory = $hiberusExamsFactory;
        $this->_csvHelper           = $csvHelper;
    }

    /**
     * Parse array data into Hiberus Exams Objects
     * @param array $data
     * @return array|false|HiberusExamsInterface[]
     */
    public function parseData($data)
    {
        if (!is_array($data)) {
            return false;
        }

        $dataParsed = [];

        foreach ($data as $value) {
            $sizeData    = sizeof($value);
            $firstKey    = array_key_first($value);
            $key         = $firstKey;
            $isValid     = false;
            $hiberusExam = $this->_hiberusExamsFactory->create();
            while ($key !== $sizeData) {
                $val = $value[$key];
                if ($val === HiberusExamsInterface::FIRSTNAME
                    || $val === HiberusExamsInterface::LASTNAME
                    || $val === HiberusExamsInterface::MARK) {
                    $key++;
                    continue;
                }
                $isValid = true;
                if ($key === $firstKey) {
                    $hiberusExam->setFirstname($val);
                } else {
                    $hiberusExam->setLastname($val);
                }
                $key++;
            }
            if (!$isValid) {
                continue;
            }
            $randomMark = $this->_csvHelper->generateRandomMark();
            $hiberusExam->setMark($randomMark);
            array_push($dataParsed, $hiberusExam);
        }
        return $dataParsed;
    }
}
