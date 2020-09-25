<?php

namespace Hiberus\Lopez\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\File\Csv as FileCsv;
use Magento\Framework\Filesystem\Driver\File;

/**
 * Class Csv
 * @package Hiberus\Lopez\Helper
 */
class Csv extends AbstractHelper
{

    /**
     * XML Path minimal mark
     */
    const XML_PATH_MIN_MARK      = 'hiberus_modules_general_config_section/hiberus_enabled_modules_group/hiberus_module_lopez_marks_min';

    /**
     * XML Path max mark
     */
    const XML_PATH_MAX_MARK      = 'hiberus_modules_general_config_section/hiberus_enabled_modules_group/hiberus_module_lopez_marks_max';

    /**
     * XML Path precision of mark
     */
    const XML_PATH_DECIMALS_MARK = 'hiberus_modules_general_config_section/hiberus_enabled_modules_group/hiberus_module_lopez_marks_decimals';

    /**
     * @var DirectoryList
     */
    private $_directoryList;

    /**
     * @var FileCsv
     */
    private $_fileCsv;

    /**
     * @var File
     */
    private $_file;

    /**
     * @var
     */
    private $_filename;

    /**
     * Csv constructor.
     * @param Context $context
     * @param DirectoryList $directoryList
     * @param FileCsv $fileCsv
     * @param File $file
     */
    public function __construct(
        Context $context,
        DirectoryList $directoryList,
        FileCsv $fileCsv,
        File $file
    ) {
        parent::__construct($context);
        $this->_directoryList = $directoryList;
        $this->_fileCsv       = $fileCsv;
        $this->_file          = $file;
    }

    /**
     * Retrieve minimal mark
     * @return int
     */
    private function getMinMark() : int
    {
        return (int) $this->scopeConfig->getValue(self::XML_PATH_MIN_MARK);
    }

    /**
     * Retrieve max mark
     * @return int|mixed
     */
    private function getMaxMark() : int
    {
        $value = $this->scopeConfig->getValue(self::XML_PATH_MAX_MARK);
        return isset($value) ? intval($value) : 10;
    }

    /**
     * Retrieve precision of mark
     * @return int|mixed
     */
    private function getDecimalsMark() : int
    {
        $value = $this->scopeConfig->getValue(self::XML_PATH_DECIMALS_MARK);
        return isset($value) ? intval($value) : 2;
    }

    /**
     * Retrieve data from file
     * @param $filename
     * @param $isAbsolute
     * @return array|false
     * @throws FileSystemException
     */
    public function readCsvFromDirectoryFromMedia($filename, $isAbsolute)
    {
        $mediaPath = $filename;

        if (!$isAbsolute) {
            $mediaPath = $this->concatPathWithMediaPath($filename);
            $filename  = $this->_filename;
        }

        if (!is_dir($mediaPath) && !$isAbsolute) {
            throw new FileSystemException(__("The directory doesn't exits."));
        }

        $files     = array_flip(array_diff(scandir($mediaPath), ['.', '..']));

        if (!isset($files[$filename])) {
            throw new FileSystemException(__("The File doesn't exits."));
        }

        $filePath = $mediaPath . '/' . $filename;

        $dataFile = $this->_fileCsv->getData($filePath);

        $this->removeFile($filePath);

        return $dataFile;
    }

    /**
     * Remove a file by path
     * @param $filepath
     * @throws FileSystemException
     */
    private function removeFile($filepath) : void
    {
        try {
            $this->_file->deleteFile($filepath);
        } catch (FileSystemException $exception) {
            $this->_file->changePermissions($filepath, 777);
            $this->removeFile($filepath);
        }
    }

    /**
     * Retrieve last filename processed
     * @return mixed
     */
    public function getLastFilenameProcessed() : string
    {
        return $this->_filename;
    }

    /**
     * Concat Filename with the media path
     * @param $filename
     * @return string
     * @throws FileSystemException
     */
    private function concatPathWithMediaPath($filename) : string
    {
        $filenameArray = explode('/', $filename);
        $mediaPath     = $this->_directoryList->getPath(DirectoryList::MEDIA);
        $fileNameSize  = sizeof($filenameArray);
        if ($fileNameSize) {
            $this->_filename = array_last($filenameArray);
        }

        unset($filenameArray[array_key_last($filenameArray)]);

        if ($fileNameSize) {
            $path = implode('/', $filenameArray);
            $mediaPath .= '/' . $path;
        }

        return $mediaPath;
    }

    /**
     * Retrieve a random mark
     * @return string
     */
    public function generateRandomMark() : string
    {
        $min        = $this->getMinMark();
        $max        = $this->getMaxMark();
        $fixed      = $this->getDecimalsMark();
        $randomMark = mt_rand($min * 10, $max * 10) / 10;
        return number_format($randomMark, $fixed);
    }
}
