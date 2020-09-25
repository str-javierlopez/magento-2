<?php

namespace Hiberus\Lopez\Cron;

use Hiberus\Lopez\Helper\Csv as HelperCsv;
use Hiberus\Lopez\Helper\Data;
use \Hiberus\Lopez\Api\Data\HiberusExamsParseCsvInterface;
use Hiberus\Lopez\Api\HiberusExamsRepositoryInterface;

/**
 * Class UpdateStudentsFromCsv
 * @package Hiberus\Lopez\Cron
 */
class UpdateStudentsFromCsv
{
    /**
     * @var HelperCsv
     */
    private $_helperCsv;

    /**
     * @var Data
     */
    private $_helperData;

    /**
     * @var string
     */
    public $_csvFilePath;

    /**
     * @var bool
     */
    public $_isAbsolutePath;

    /**
     * @var HiberusExamsParseCsvInterface
     */
    private $_hiberusExamsParseCsv;

    /**
     * @var HiberusExamsRepositoryInterface
     */
    private $_hiberusExamsRepository;

    /**
     * UpdateStudentsFromCsv constructor.
     * @param HelperCsv $helperCsv
     * @param Data $helperData
     * @param HiberusExamsParseCsvInterface $hiberusExamsParseCsv
     * @param HiberusExamsRepositoryInterface $hiberusExamsRepository
     */
    public function __construct(
        HelperCsv $helperCsv,
        Data $helperData,
        HiberusExamsParseCsvInterface $hiberusExamsParseCsv,
        HiberusExamsRepositoryInterface $hiberusExamsRepository
    ) {
        $this->_helperCsv              = $helperCsv;
        $this->_helperData             = $helperData;
        $this->_hiberusExamsParseCsv   = $hiberusExamsParseCsv;
        $this->_hiberusExamsRepository = $hiberusExamsRepository;
        $this->_csvFilePath            = $helperData->cronUpdateStudentsCsvPath();
        $this->_isAbsolutePath         = $helperData->cronUpdateStudentsIsAbsolutePath();
    }

    /**
     *
     */
    public function execute()
    {
        if (!$this->_helperData->getModuleUpdateStudentsCronEnabled()) {
            return;
        }

        $csvData      = $this->_helperCsv->readCsvFromDirectoryFromMedia($this->_csvFilePath, $this->_isAbsolutePath);
        $hiberusExams = $this->_hiberusExamsParseCsv->parseData($csvData);

        foreach ($hiberusExams as $hiberusExam) {
            $this->_hiberusExamsRepository->save($hiberusExam);
        }
        //echo 'Students Updated!';
    }
}
