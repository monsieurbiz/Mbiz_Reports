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
 * Adminhtml_Sales_Journal_Result_Summary Block
 * @package Mbiz_Reports
 */
class Mbiz_Reports_Block_Adminhtml_Sales_Journal_Result_SummaryAvg extends Mbiz_Reports_Block_Adminhtml_Sales_Journal_Result_Summary
{

// Monsieur Biz Tag NEW_CONST

// Monsieur Biz Tag NEW_VAR

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->__('Synthèse moyenne');
    }

    /**
     * {@inheritdoc}
     */
    public function getColumns()
    {
        return parent::getColumns() + ['avg' => $this->__('Panier moyen HT')];
    }

// Monsieur Biz Tag NEW_METHOD

}