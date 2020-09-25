<?php


namespace Hiberus\Lopez\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Students extends Template
{

    public function __construct(
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_isScopePrivate = true;
    }

    public function getStudentsListUrl() : string
    {
        return $this->getUrl('lopez/Students/Index', ['_secure' => true]);
    }
}
