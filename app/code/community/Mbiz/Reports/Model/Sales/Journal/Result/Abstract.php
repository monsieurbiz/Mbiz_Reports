<?php
/**
 * This file is part of Mbiz_Reports for Magento.
 *
 * @license MIT
 * @author Jacques Bodin-Hullin <@jacquesbh> <j.bodinhullin@monsieurbiz.com> <@jacquesbh>
 * @category Mbiz
 * @package Mbiz_Reports
 * @copyright Copyright (c) 2015 Monsieur Biz (http://monsieurbiz.com/)
 */

/**
 * Sales_Journal_Result_Abstract Model
 * @package Mbiz_Reports
 *
 * @method string getCode()
 * @method Mbiz_Reports_Model_Sales_Journal_Result_Abstract setCode(string $code)
 */
abstract class Mbiz_Reports_Model_Sales_Journal_Result_Abstract extends Varien_Object
{

// Monsieur Biz Tag NEW_CONST

// Monsieur Biz Tag NEW_VAR

    /**
     * Load the results
     * @param Mbiz_Reports_Model_Sales_Journal_Request $request
     * @return Mbiz_Reports_Model_Sales_Journal_Result_Abstract
     */
    public function load(Mbiz_Reports_Model_Sales_Journal_Request $request)
    {
        // The period
        list($from, $to) = $request->getPeriod();

        $from = $this->convertToGmt($from->toString('y-MM-dd') . '00:00:00');
        $to = $this->convertToGmt($to->toString('y-MM-dd') . '23:59:59');

        return $this->_load($request, $from, $to);
    }

    /**
     * Retrieve the read adapter
     * @return Magento_Db_Adapter_Pdo_Mysql
     */
    public function getReadAdapter()
    {
        return Mage::getSingleton('core/resource')->getConnection('core_read');
    }

    /**
     * Retrieve table name
     * @param string $alias
     * @return string
     */
    public function getTableName($alias)
    {
        /* @var $res Mage_Core_Model_Resource */
        $res = Mage::getSingleton('core/resource');
        return $res->getTableName($alias);
    }

    /**
     * Convert the given string in format `Y-m-d H:i:s` to a date in GMT
     *
     * @param string $datetime
     * @return Zend_Date
     * @throws Zend_Date_Exception
     */
    public function convertToGmt($datetime)
    {
        return Mage::app()->getLocale()->date(
            Varien_Date::toTimestamp(Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s', $datetime)),
            null,
            null,
            true
        )->setTimezone('UTC');
    }

    /**
     * Override of the load
     * @return Mbiz_Reports_Model_Sales_Journal_Result_Abstract
     */
    abstract protected function _load(Mbiz_Reports_Model_Sales_Journal_Request $request, Zend_Date $from, Zend_Date $to);

// Monsieur Biz Tag NEW_METHOD

}
