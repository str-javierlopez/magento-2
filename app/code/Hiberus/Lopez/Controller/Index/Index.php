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

class Index extends Action implements HttpGetActionInterface
{
    private $_csv;

    private $_hiberusExamsParseCsv;

    private $_examManagement;

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
