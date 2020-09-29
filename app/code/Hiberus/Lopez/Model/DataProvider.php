<?php

namespace Hiberus\Lopez\Model;

use Hiberus\Lopez\Model\ResourceModel\HiberusExams\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    private $_collectionFactory;

    /**
     * @param String $name
     * @param String $primaryFieldName
     * @param String $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        String $name,
        String $primaryFieldName,
        String $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->_collectionFactory = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function addFilter(\Magento\Framework\Api\Filter $filter)
    {
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->_collectionFactory->getItems();
        $this->loadedData = [];
        foreach ($items as $exam) {
            $data = $exam->getData();
            $this->loadedData[$exam->getId()] = $data;
        }

        return $this->loadedData;
    }
}
