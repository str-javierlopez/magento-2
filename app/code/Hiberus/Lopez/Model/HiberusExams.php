<?php

namespace Hiberus\Lopez\Model;

use Hiberus\Lopez\Api\Data\HiberusExamsInterface;
use Hiberus\Lopez\Model\ResourceModel\HiberusExams as HiberusExamsResourceModel;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class HiberusExams
 * @package Hiberus\Lopez\Model
 */
class HiberusExams extends AbstractModel implements HiberusExamsInterface, IdentityInterface
{
    /**
     * Cache Tag
     */
    const CACHE_TAG = 'hiberus_exams';

    /**
     * @var string
     */
    protected $_eventPrefix = self::CACHE_TAG;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct() : void
    {
        $this->_init(HiberusExamsResourceModel::class);
    }

    /**
     * Get Identities
     * @return array|string[]
     */
    public function getIdentities() : array
    {
        $identities = [];
        if ($this->getIdExam()) {
            $identities = [self::CACHE_TAG . '_' . $this->getIdExam()];
        }
        return $identities;
    }

    /**
     * Get ID exam
     * @return array|int|mixed|null
     */
    public function getIdExam() : int
    {
        return $this->getData(self::ID_EXAM);
    }

    /**
     * Set ID exam
     * @param int $id
     * @return HiberusExams
     */
    public function setIdExam($id) : self
    {
        return $this->setData(self::ID_EXAM, $id);
    }

    /**
     * Get Firstname
     * @return array|mixed|string|null
     */
    public function getFirstname() : string
    {
        return $this->getData(self::FIRSTNAME);
    }

    /**
     * Set Firstname
     * @param string $firstname
     * @return HiberusExams
     */
    public function setFirstname($firstname) : self
    {
        return $this->setData(self::FIRSTNAME, $firstname);
    }

    /**
     * Get Lastname
     * @return array|mixed|string|null
     */
    public function getLastname() : string
    {
        return $this->getData(self::LASTNAME);
    }

    /**
     * Set Lastname
     * @param string $lastname
     * @return HiberusExams
     */
    public function setLastname($lastname) : self
    {
        return $this->setData(self::LASTNAME, $lastname);
    }

    /**
     * Get Mark
     * @return array|float|mixed|null
     */
    public function getMark() : float
    {
        return $this->getData(self::MARK);
    }

    /**
     * Set Mark
     * @param float $mark
     * @return HiberusExams
     */
    public function setMark($mark) : self
    {
        return $this->setData(self::MARK, $mark);
    }
}
