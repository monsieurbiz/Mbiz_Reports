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
 * Adminhtml_Reports_Sales Controller
 * @package Mbiz_Reports
 */
class Mbiz_Reports_Adminhtml_Reports_SalesController extends Mage_Adminhtml_Controller_Action
{

// Monsieur Biz Tag NEW_CONST

// Monsieur Biz Tag NEW_VAR

    /**
     * Display the Journal or ask the dates
     */
    public function journalAction()
    {
        $request = Mage::getModel('mbiz_reports/sales_journal_request')->init();
        Mage::register('current_request', $request);

        $this->loadLayout();

        // Is the request valid?
        try {
            $valid = $request->isValid();
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
            return $this->_redirectReferer();
        }

        // The menu
        $this->_setActiveMenu('report');

        if ($valid) {
            $content = $this->getLayout()->createBlock('mbiz_reports/adminhtml_sales_journal_result', 'result');
        } else { // Invalid but normal
            $content = $this->getLayout()->createBlock('mbiz_reports/adminhtml_sales_journal_form', 'form');
        }

        $this->_addContent($content);

        $this->renderLayout();
    }

// Monsieur Biz Tag NEW_METHOD

    /**
     * Is allowed?
     * @return bool
     */
    protected function _isAllowed()
    {
        return true;
    }

}