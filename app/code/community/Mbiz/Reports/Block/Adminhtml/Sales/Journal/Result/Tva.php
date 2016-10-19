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
 * Adminhtml_Sales_Journal_Result_Tva Block
 * @package Mbiz_Reports
 */
class Mbiz_Reports_Block_Adminhtml_Sales_Journal_Result_Tva extends Mbiz_Reports_Block_Adminhtml_Sales_Journal_Result_Abstract
{

// Monsieur Biz Tag NEW_CONST

// Monsieur Biz Tag NEW_VAR

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->__('TVA');
    }

    /**
     * {@inheritdoc}
     */
    public function getColumns()
    {
        return [
            'rate'              => $this->__("TVA"),
            'amount_discounted' => $this->__("Hors taxe correspondant"),
            'tax'               => $this->__("Montant"),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function formatValue($columnCode, $value)
    {
        switch ($columnCode) {
            case 'rate':
                return $value . ' %';
            default:
                return $this->formatPrice($value);
        }
    }

// Monsieur Biz Tag NEW_METHOD

}