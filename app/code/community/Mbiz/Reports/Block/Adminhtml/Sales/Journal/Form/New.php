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
 * Adminhtml_Sales_Journal_Form_New Block
 * @package Mbiz_Reports
 */
class Mbiz_Reports_Block_Adminhtml_Sales_Journal_Form_New extends Mage_Adminhtml_Block_Widget_Form
{

// Monsieur Biz Tag NEW_CONST

// Monsieur Biz Tag NEW_VAR

    /**
     * Prepare form before rendering HTML
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getData('action'),
            'method'    => 'get',
            'enctype'   => 'multipart/form-data'
        ));

        $fieldset = $form->addFieldset('day_report', array(
            'legend' => Mage::helper('mbiz_reports')->__('Day report')
        ));

        $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);

        // specific date
        $fieldset->addField('day', 'date', array(
            'name' => 'day',
            'label' => Mage::helper('mbiz_reports')->__('Specific day'),
            'title' => Mage::helper('mbiz_reports')->__('Specific day'),
            'image'    => $this->getSkinUrl('images/grid-cal.gif'),
            'format'   => $dateFormatIso,
            'required' => false
        ));

        $fieldset = $form->addFieldset('range_report', array(
            'legend' => Mage::helper('mbiz_reports')->__('OR Period report')
        ));

        // from
        $fieldset->addField('from', 'date', array(
            'name' => 'from',
            'label' => Mage::helper('mbiz_reports')->__('From'),
            'title' => Mage::helper('mbiz_reports')->__('From'),
            'image'    => $this->getSkinUrl('images/grid-cal.gif'),
            'format'   => $dateFormatIso,
            'required' => false
        ));

        // to
        $fieldset->addField('to', 'date', array(
            'name' => 'to',
            'label' => Mage::helper('mbiz_reports')->__('To'),
            'title' => Mage::helper('mbiz_reports')->__('To'),
            'image'    => $this->getSkinUrl('images/grid-cal.gif'),
            'format'   => $dateFormatIso,
            'required' => false
        ));

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

// Monsieur Biz Tag NEW_METHOD

}