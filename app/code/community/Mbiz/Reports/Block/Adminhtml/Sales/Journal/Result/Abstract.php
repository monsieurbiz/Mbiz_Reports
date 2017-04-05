<?php
/**
 * This file is part of Mbiz_Reports for Magento.
 *
 * @license All rights reserved
 * @author Jacques Bodin-Hullin <@jacquesbh> <j.bodinhullin@monsieurbiz.com> <@jacquesbh>
 * @category Mbiz
 * @package Mbiz_Reports
 * @copyright Copyright (c) 2015 Monsieur Biz (http://monsieurbiz.com/)
 */

/**
 * Adminhtml_Sales_Journal_Result_Abstract Block
 * @package Mbiz_Reports
 *
 * @method string getCode()
 * @method Mbiz_Reports_Block_Adminhtml_Sales_Journal_Result_Abstract setCode(string $code)
 */
abstract class Mbiz_Reports_Block_Adminhtml_Sales_Journal_Result_Abstract extends Mage_Adminhtml_Block_Template
{

    /**
     * Template filename for this block
     * @const TEMPLATE string
     */
    const TEMPLATE = 'mbiz_reports/sales/journal/result/grid.phtml';

// Monsieur Biz Tag NEW_CONST

// Monsieur Biz Tag NEW_VAR

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->setTemplate(self::TEMPLATE);
        return parent::_construct();
    }

    /**
     * Retrieve the current request
     * @return Mbiz_Reports_Model_Sales_Journal_Request
     */
    public function getRequest()
    {
        if (!$request = $this->getData('request')) {
            return Mage::registry('current_request');
        }
        return $request;
    }

    /**
     * Format a price
     * @param float $price
     * @return string
     */
    public function formatPrice($price)
    {
        return Mage::helper('core')->formatPrice($price);
    }

    /**
     * Format a value
     * @param string $columnCode
     * @param string $value
     * @return string The value formatted
     */
    public function formatValue($columnCode, $value)
    {
        return $value;
    }

    /**
     * Retrieve the items
     * @return array|Varien_Data_Collection
     */
    public function getItems()
    {
        return $this->getResult()->getData($this->getCode());
    }

    /**
     * Retrieve the block's title
     * @return string
     */
    abstract public function getTitle();

    /**
     * Retrieve the columns (code => name)
     * @return array
     */
    abstract public function getColumns();

// Monsieur Biz Tag NEW_METHOD

}