<?php

namespace Hiberus\Lopez\Model\ResourceModel\HiberusExams;

use Hiberus\Lopez\Model\HiberusExams;
use Hiberus\Lopez\Model\ResourceModel\HiberusExams as ResourceModelHiberusExams;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * Initialize resource
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(HiberusExams::class, ResourceModelHiberusExams::class);
    }

    /**
     * Filter collection by id exam
     *
     * @param int $idExam
     * @return $this
     */
    public function filterByIdExam($idExam)
    {
        $this->addFieldToFilter('id_exam', $idExam);
        return $this;
    }

    /**
     * Filter collection by ids exams
     *
     * @param array $idExams
     * @return $this
     */
    public function filterIdExams(array $idExams) : self
    {
        $this->addFieldToFilter('id_exam', ['in' => $idExams]);
        return $this;
    }
}
