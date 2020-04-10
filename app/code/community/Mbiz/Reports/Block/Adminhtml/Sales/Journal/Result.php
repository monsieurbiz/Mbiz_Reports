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
 * Adminhtml_Sales_Journal_Result Block
 * @package Mbiz_Reports
 *
 * @method Mbiz_Reports_Model_Sales_Journal_Result getResult() Retrieve the current loaded result
 */
class Mbiz_Reports_Block_Adminhtml_Sales_Journal_Result extends Mage_Adminhtml_Block_Template
{

    /**
     * Template filename for this block
     * @const TEMPLATE string
     */
    const TEMPLATE = 'mbiz_reports/sales/journal/result.phtml';

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
     * {@inheritdoc}
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        // Page's title
        if ($head = $this->getLayout()->getBlock('head')) {
            $titles = [
                $this->getTitle(),
                $this->__("Sales journal"),
            ];
            $head->setTitle(implode(' / ', $titles));
        }

        // Add blocks
        $blocks = Mage::getSingleton('mbiz_reports/config')->getBlocks();
        foreach ($blocks as $code => $type) {
            $block = $this->getLayout()->createBlock($type);
            $block->setCode($code);
            $this->append($block);
        }

        return $this;
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
     * Retrieve the title of the results
     * @return string
     */
    public function getTitle()
    {
        if ($day = $this->getRequest()->getDayDate()) {
            if ($day->compareDay(Mage::app()->getLocale()->date()) === 0) {
                $title = Mage::helper('mbiz_reports')->__("%s (Today)", $day->toString(Zend_Date::DATE_LONG));
            } else {
                $title = $day->toString(Zend_Date::DATE_LONG);
            }
        } else {
            $title = Mage::helper('mbiz_reports')->__(
                "From %s to %s",
                $this->getRequest()->getFromDate()->toString(Zend_Date::DATE_LONG),
                $this->getRequest()->getToDate()->toString(Zend_Date::DATE_LONG)
            );
        }
        return $title;
    }

    /**
     * Load the result
     * @return Mbiz_Reports_Block_Adminhtml_Sales_Journal_Result
     */
    protected function _loadResult()
    {
        $result = Mage::getModel('mbiz_reports/sales_journal_result');
        $result->load($this->getRequest());
        $this->setResult($result);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function _toHtml()
    {
        $this->_loadResult();

        foreach ($this->getChild() as $child) {
            $child->setResult($this->getResult());
        }

        return parent::_toHtml();
    }

// Monsieur Biz Tag NEW_METHOD

}
