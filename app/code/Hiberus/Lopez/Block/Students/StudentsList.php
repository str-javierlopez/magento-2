<?php

namespace Hiberus\Lopez\Block\Students;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class StudentsList extends Template
{

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
