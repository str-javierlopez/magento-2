<?php

namespace Hiberus\Lopez\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Hiberus\Lopez\Api\ExamManagementInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Data
 * @package Hiberus\Lopez\Helper
 */
class Data extends AbstractHelper
{

    /**
     * XML Path module enabled
     */
    const XML_PATH_MODULE_ENABLED                        = 'hiberus_modules_enabled_modules_section/hiberus_enabled_modules_group/hiberus_module_lopez_enabled';

    /**
     * XML Path module cron enabled
     */
    const XML_PATH_CRON_ENABLED                          = 'hiberus_modules_cron/hiberus_enabled_cron_general/hiberus_module_lopez_cron_enabled';

    /**
     * XML Path module cron update students enabled
     */
    const XML_PATH_CRON_UPDATE_STUDENTS_ENABLED          = 'hiberus_modules_cron/hiberus_module_lopez_cron_update_studients/hiberus_module_lopez_cron_update_studients_enabled';

    /**
     * XML Path cron update students csv path is absolute path
     */
    const XML_PATH_CRON_UPDATE_STUDENTS_IS_ABSOLUTE_PATH = 'hiberus_modules_cron/hiberus_module_lopez_cron_update_studients/hiberus_module_lopez_cron_update_studients_csv_is_absolute_path';

    /**
     * XML Path of csv file for cron update students
     */
    const XML_PATH_CRON_UPDATE_STUDENTS_CSV_PATH         = 'hiberus_modules_cron/hiberus_module_lopez_cron_update_studients/hiberus_module_lopez_cron_update_studients_csv_path';

    /**
     * XML Path plugin is enabled
     */
    const XML_PATH_STUDENTS_NOT_PASS_PLUGIN_ENABLED     = 'hiberus_modules_general_config_section/hiberus_enabled_modules_group/hiberus_module_lopez_plugin_enabled';

    /**
     * XML Path plugin config
     */
    const XML_PATH_STUDENTS_NOT_PASS_PLUGIN_MARK        = 'hiberus_modules_general_config_section/hiberus_enabled_modules_group/hiberus_module_lopez_plugin_mark';

    /**
     * @var ExamManagementInterface
     */
    private $_examsManagementInterface;

    /**
     * Data constructor.
     * @param Context $context
     * ExamManagementInterface $examsManagementInterface
     */
    public function __construct(
        Context $context,
        ExamManagementInterface $examsManagementInterface
    ) {
        parent::__construct($context);
        $this->_examsManagementInterface = $examsManagementInterface;
    }

    /**
     * Retrieve if module is enabled
     * @return bool
     */
    public function getModuleEnabled() : bool
    {
        return (bool) $this->scopeConfig->getValue(self::XML_PATH_MODULE_ENABLED);
    }

    /**
     * Retrieve if cron is enabled
     * @return bool
     */
    public function getModuleCronEnabled() : bool
    {
        return $this->getModuleEnabled()
            && (bool) $this->scopeConfig->getValue(self::XML_PATH_CRON_ENABLED);
    }

    /**
     * Retrieve if the cron of Students update by CSV is enabled
     * @return bool
     */
    public function getModuleUpdateStudentsCronEnabled() : bool
    {
        return $this->getModuleCronEnabled()
            && (bool) $this->scopeConfig->getValue(self::XML_PATH_CRON_UPDATE_STUDENTS_ENABLED);
    }

    /**
     * Retrieve if the path is absolute for cron of Students update by CSV
     * @return bool
     */
    public function cronUpdateStudentsIsAbsolutePath() : bool
    {
        return (bool) $this->scopeConfig->getValue(self::XML_PATH_CRON_UPDATE_STUDENTS_IS_ABSOLUTE_PATH);
    }

    /**
     * Retrieve CSV file path for cron of Students update
     * @return string
     */
    public function cronUpdateStudentsCsvPath() : string
    {
        return trim($this->scopeConfig->getValue(self::XML_PATH_CRON_UPDATE_STUDENTS_CSV_PATH));
    }

    /**
     * Retrieve if plugin is enabled
     * @return bool
     */
    public function getPluginEnabled() : bool
    {
        return $this->getModuleEnabled() && $this->scopeConfig->getValue(self::XML_PATH_STUDENTS_NOT_PASS_PLUGIN_ENABLED);
    }

    /**
     * Retrieve plugin config
     * @return float
     */
    public function getPluginConfigMark() : float
    {
        $value = (float) $this->scopeConfig->getValue(self::XML_PATH_STUDENTS_NOT_PASS_PLUGIN_MARK);
        return !isset($value) ? 4.9 : number_format($value, 2);
    }

    /**
     * Return all exams
     * @return array
     * @throws LocalizedException
     */
    public function getAllStudentsExams() : array
    {
        $searchResult = $this->_examsManagementInterface->getList();
        return $this->_examsManagementInterface->searchResultItemsToArray($searchResult);
    }
}
