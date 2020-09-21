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

class CsvFile extends File
{

    const UPLOAD_DIR = 'hiberusCsv';

    private $_updateStudentsFromCsv;

    private $_path;

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

    protected function _getUploadDir()
    {
        $this->_path = $this->_mediaDirectory->getAbsolutePath(self::UPLOAD_DIR);

        return $this->_path;
    }

    public function afterSave()
    {
        $this->_updateStudentsFromCsv->_csvFilePath    = $this->_path;
        $this->_updateStudentsFromCsv->_isAbsolutePath = true;
        $this->_updateStudentsFromCsv->execute();
    }

    public function getAllowedExtensions()
    {
        return ['text/csv'];
    }

}
