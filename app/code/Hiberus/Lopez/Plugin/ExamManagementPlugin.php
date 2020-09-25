<?php

namespace Hiberus\Lopez\Plugin;

use Hiberus\Lopez\Api\ExamManagementInterface;
use Hiberus\Lopez\Helper\Data;

/**
 * Class ExamManagementPlugin
 * @package Hiberus\Lopez\Plugin
 */
class ExamManagementPlugin
{

    /**
     * @var Data
     */
    private $_helper_data;

    /**
     * ExamManagementPlugin constructor.
     * @param Data $helper_data
     */
    public function __construct(
        Data $helper_data
    ) {
        $this->_helper_data = $helper_data;
    }

    /**
     * @param ExamManagementInterface $subject
     * @param $result
     * @return mixed
     */
    public function afterGetList(ExamManagementInterface $subject, $result)
    {
        if (!$this->_helper_data->getPluginEnabled()) {
            return $result;
        }
        $markForStudentsNotPass = $this->_helper_data->getPluginConfigMark();
        $collection = $result->getCollection();
        foreach ($collection as $key => $item) {
            $keyInData = $key - 1;
            if ($item->getMark() < 5) {
                $item->setMark($markForStudentsNotPass);
            }
            $collection->removeItemByKey($key);
            $collection->addItem($item);
            $collection->getData()[$keyInData] = $item->getData();
        }
        $result->setItems($collection->getItems());
        $result->setCollection($collection);
        return $result;
    }

}
