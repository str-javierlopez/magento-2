<?php

namespace Hiberus\Lopez\Controller\Index;

use Hiberus\Lopez\Api\Data\HiberusExamsParseCsvInterface;
use Hiberus\Lopez\Helper\Csv;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Hiberus\Lopez\Api\ExamManagementInterface;
use Magento\Framework\App\ObjectManager;
use Hiberus\Lopez\Api\HiberusExamsRepositoryInterface;

/**
 * Class Index
 * @package Hiberus\Lopez\Controller\Index
 */
class Index extends Action implements HttpGetActionInterface
{
    /**
     * @var Csv
     */
    private $_csv;

    /**
     * @var HiberusExamsParseCsvInterface
     */
    private $_hiberusExamsParseCsv;

    /**
     * @var ExamManagementInterface
     */
    private $_examManagement;

    /**
     * Index constructor.
     * @param Context $context
     * @param Csv $helper_csv_data
     * @param HiberusExamsParseCsvInterface $hiberusExamsParseCsv
     * @param ExamManagementInterface $examManagement
     */
    public function __construct(
        Context $context,
        Csv $helper_csv_data,
        HiberusExamsParseCsvInterface $hiberusExamsParseCsv,
        ExamManagementInterface $examManagement
    ) {
        parent::__construct($context);
        $this->_csv                  = $helper_csv_data;
        $this->_hiberusExamsParseCsv = $hiberusExamsParseCsv;
        $this->_examManagement       = $examManagement;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {

        $repo = ObjectManager::getInstance()->get(HiberusExamsRepositoryInterface::class);
        $searchCriteria = ObjectManager::getInstance()->get(SearchCriteriaInterface::class);
        /*$data = $this->_csv->readCsvFromDirectoryFromMedia('CSV/Students.csv', false);
        $data = $this->_hiberusExamsParseCsv->parseData($data);


        foreach ($data as $d) {
            $repo->save($d);
        }*/

        $c = $this->_examManagement->getList($searchCriteria);

        $a=0;

    }
}
