<?php

namespace Hiberus\Lopez\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DB\Select;

/**
 * Class HiberusExams
 * @package Hiberus\Lopez\Model\ResourceModel
 */
class HiberusExams extends AbstractDb
{

    /**
     * @var string
     */
    private $_table           = 'hiberus_exam';

    /**
     * @var string
     */
    private $_primaryKeyField = 'id_exam';

    /**
     * Construct
     */
    protected function _construct() : void
    {
        $this->_init($this->_table, $this->_primaryKeyField);
    }

    /**
     * Prepare hiberus exams load select query
     *
     * @param string $field
     * @param mixed $value
     * @param AbstractModel $object
     * @return Select
     */
    protected function _getLoadSelect($field, $value, $object) : Select
    {
        $select = parent::_getLoadSelect($field, $value, $object);
        if ($field == $this->_primaryKeyField) {
            $select->order($this->_primaryKeyField . ' ' . Select::SQL_ASC)->limit(1);
        }
        return $select;
    }

    /**
     * Getter for ID exam field name
     *
     * @return string
     */
    public function getIdExamFieldName() : string
    {
        return $this->_primaryKeyField;
    }

    /**
     * Setter for ID exam field name
     *
     * @param string $fieldName
     * @return $this
     */
    public function setIdExamFieldName(string $fieldName) : self
    {
        $this->_primaryKeyField = $fieldName;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function save(AbstractModel $object) : self
    {
        $object->setHasDataChanges(true);
        return parent::save($object);
    }
}
