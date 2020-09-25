<?php

namespace Hiberus\Lopez\Block\Students;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class StudentsList
 * @package Hiberus\Lopez\Block\Students
 */
class StudentsList extends Template
{

    /**
     * StudentsList constructor.
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $data
        );
    }
}
