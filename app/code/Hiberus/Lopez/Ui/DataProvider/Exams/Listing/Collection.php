<?php

namespace Hiberus\Lopez\Ui\DataProvider\Exams\Listing;


use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class Collection extends SearchResult
{
    /**
     * Override _initSelect to add custom columns
     *
     * @return void
     */
    protected function _initSelect()
    {
        $this->addFilterToMap('id_exam', 'main_table.id_exam');
        $this->addFilterToMap('firstname', 'studentsgridfirstname.value');
        parent::_initSelect();
    }
}
