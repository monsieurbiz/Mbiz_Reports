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
 * Adminhtml_Sales_Journal_Form Block
 * @package Mbiz_Reports
 */
class Mbiz_Reports_Block_Adminhtml_Sales_Journal_Form extends Mage_Adminhtml_Block_Widget_Form_Container
{

// Monsieur Biz Tag NEW_CONST

// Monsieur Biz Tag NEW_VAR

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        parent::_construct();

        $this->_blockGroup = 'mbiz_reports';
        $this->_controller = 'adminhtml_sales_journal_form';
        $this->_mode       = 'new';

        $this->setFormActionUrl($this->getUrl('*/*/journal'));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareLayout()
    {
        if ($this->_blockGroup && $this->_controller && $this->_mode) {
            $this->setChild('form', $this->getLayout()->createBlock($this->_blockGroup . '/' . $this->_controller . '_' . $this->_mode));
        }

        // Remove buttons
        $this->removeButton('back');
        $this->removeButton('reset');

        return Mage_Adminhtml_Block_Widget_Container::_prepareLayout();
    }

    /**
     * The header
     * @return string
     */
    public function getHeaderText()
    {
        return $this->__('Sales journal');
    }

    /**
     * Retrieve the request
     * @return Gds_Agenda_Model_Event
     */
    protected function _getRequest()
    {
        return Mage::registry('current_request');
    }

// Monsieur Biz Tag NEW_METHOD

}