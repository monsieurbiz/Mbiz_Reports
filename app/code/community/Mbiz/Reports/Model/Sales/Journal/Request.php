<?php
/**
 * This file is part of Mbiz_Reports for Magento.
 *
 * @license MIT
 * @author Jacques Bodin-Hullin <@jacquesbh> <j.bodinhullin@monsieurbiz.com>
 * @category Mbiz
 * @package Mbiz_Reports
 * @copyright Copyright (c) 2015 Monsieur Biz (http://monsieurbiz.com/)
 */

/**
 * Sales_Journal_Request Model
 * @package Mbiz_Reports
 *
 * @method string getDay()
 * @method string getFrom()
 * @method string getTo()
 */
class Mbiz_Reports_Model_Sales_Journal_Request extends Mage_Core_Model_Abstract
{

// Monsieur Biz Tag NEW_CONST

    /**
     * Is init
     * @var bool
     */
    protected $_init = false;

// Monsieur Biz Tag NEW_VAR

    /**
     * Init the request
     * @return Mbiz_Reports_Model_Sales_Journal_Request
     */
    public function init()
    {
        if (!$this->_init) {
            $params = Mage::app()->getRequest()->getParams();
            $this->setData($this->filterDates($params, ['day', 'from', 'to']));

            Mage::dispatchEvent('mbiz_reports_sales_journal_request_init', [
                'request' => $this,
                'params' => $params,
            ]);

            $this->_init = true;
        }
        return $this;
    }

    /**
     * Is valid?
     * @return bool
     */
    public function isValid()
    {
        $this->init();

        // 4. We have not "day" and ("from" and "to"): TRUE
        if (!$this->getDay() && ($this->getFrom() && $this->getTo())) {
            // 5. From is before To
            $from = $this->getDate('from');
            $to   = $this->getDate('to');
            if ($from->compare($to) !== -1) {
                Mage::throwException(Mage::helper('mbiz_reports')->__("Please set a valid period."));
            }
        }

        // 2. We have "day" and ("from" or "to"): FALSE
        if ($this->getDay() && ($this->getFrom() || $this->getTo())) {
            Mage::throwException(Mage::helper('mbiz_reports')->__("Please set a date or a period."));
        }

        // 1. We have nothing: FALSE
        if ((!$this->getDay() && !$this->getFrom() && !$this->getTo())) {
            return false;
        }

        $transport = new Varien_Object(['is_valid' => true]);
        Mage::dispatchEvent('mbiz_reports_sales_journal_request_is_valid', [
            'transport' => $transport
        ]);

        return $transport->getIsValid();
    }

    /**
     * Retrieve Zend_Date object
     * @return Zend_Date|false
     */
    public function getDate($field)
    {
        if (!$this->getData($field)) {
            return false;
        }
        return Mage::app()->getLocale()->date(
            Varien_Date::toTimestamp($this->getData($field)),
            null,
            null,
            true
        )->setTimezone('UTC');
    }

    /**
     * Convert dates in array from localized to internal format
     *
     * @param   array $array
     * @param   array $dateFields
     * @return  array
     */
    public function filterDates($array, $dateFields)
    {
        if (empty($dateFields)) {
            return $array;
        }
        $filterInput = new Zend_Filter_LocalizedToNormalized(array(
            'date_format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT)
        ));
        $filterInternal = new Zend_Filter_NormalizedToLocalized(array(
            'date_format' => Varien_Date::DATE_INTERNAL_FORMAT
        ));

        foreach ($dateFields as $dateField) {
            if (array_key_exists($dateField, $array) && !empty($dateField)) {
                $array[$dateField] = $filterInput->filter($array[$dateField]);
                $array[$dateField] = $filterInternal->filter($array[$dateField]);
            }
        }
        return $array;
    }

    /**
     * Retrieve the from date
     * @return Zend_Date
     */
    public function getFromDate()
    {
        return $this->getDate('from');
    }

    /**
     * Retrieve the to date
     * @return Zend_Date
     */
    public function getToDate()
    {
        return $this->getDate('to');
    }

    /**
     * Retrieve the day date
     * @return Zend_Date
     */
    public function getDayDate()
    {
        return $this->getDate('day');
    }

    /**
     * Retrieve a period
     * @return array [from, to]
     */
    public function getPeriod()
    {
        if ($this->getDay()) {
            return [
                $this->getDayDate(), // from
                $this->getDayDate(), // to
            ];
        }
        return [
            $this->getFromDate(), // from
            $this->getToDate(), // to
        ];
    }

// Monsieur Biz Tag NEW_METHOD

}