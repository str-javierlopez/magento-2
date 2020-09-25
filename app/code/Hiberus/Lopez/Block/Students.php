<?php


namespace Hiberus\Lopez\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Students
 * @package Hiberus\Lopez\Block
 */
class Students extends Template
{

    /**
     * Students constructor.
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getStudentsListUrl() : string
    {
        return $this->getUrl('lopez/Students/Index', ['_secure' => true]);
    }
}
