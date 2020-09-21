<?php


namespace Hiberus\Lopez\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

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
     * Data constructor.
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * Retrieve if module is enabled
     * @return bool
     */
    public function getModuleEnabled()
    {
        return (bool) $this->scopeConfig->getValue(self::XML_PATH_MODULE_ENABLED);
    }

    /**
     * Retrieve if cron is enabled
     * @return bool
     */
    public function getModuleCronEnabled()
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
    public function cronUpdateStudentsCsvPath()
    {
        return trim($this->scopeConfig->getValue(self::XML_PATH_CRON_UPDATE_STUDENTS_CSV_PATH));
    }

}
