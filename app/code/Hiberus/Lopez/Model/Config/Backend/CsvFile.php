<?php

namespace Hiberus\Lopez\Model\Config\Backend;

use Magento\Config\Model\Config\Backend\File;
use Magento\Framework\Filesystem;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Config\Model\Config\Backend\File\RequestData\RequestDataInterface;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;
use Hiberus\Lopez\Cron\UpdateStudentsFromCsv;

/**
 * Class CsvFile
 * @package Hiberus\Lopez\Model\Config\Backend
 */
class CsvFile extends File
{

    /**
     *
     */
    const UPLOAD_DIR = 'hiberusCsv';

    /**
     * @var UpdateStudentsFromCsv
     */
    private $_updateStudentsFromCsv;

    /**
     * @var
     */
    private $_path;

    /**
     * CsvFile constructor.
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     * @param UploaderFactory $uploaderFactory
     * @param RequestDataInterface $requestData
     * @param Filesystem $filesystem
     * @param UpdateStudentsFromCsv $updateStudentsFromCsv
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        UploaderFactory $uploaderFactory,
        RequestDataInterface $requestData,
        Filesystem $filesystem,
        UpdateStudentsFromCsv $updateStudentsFromCsv,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $config,
            $cacheTypeList,
            $uploaderFactory,
            $requestData,
            $filesystem,
            $resource,
            $resourceCollection,
            $data
        );
        $this->_updateStudentsFromCsv = $updateStudentsFromCsv;
    }

    /**
     * Retrieve the upload path of the file
     * @return string
     */
    protected function _getUploadDir() : string
    {
        $this->_path = $this->_mediaDirectory->getAbsolutePath(self::UPLOAD_DIR);

        return $this->_path;
    }

    /**
     * @return CsvFile|void
     */
    public function afterSave() : void
    {
        $this->_updateStudentsFromCsv->_csvFilePath    = $this->_path;
        $this->_updateStudentsFromCsv->_isAbsolutePath = true;
        $this->_updateStudentsFromCsv->execute();
    }

    /**
     * @return string[]
     */
    public function getAllowedExtensions() : array
    {
        return ['text/csv'];
    }

}
