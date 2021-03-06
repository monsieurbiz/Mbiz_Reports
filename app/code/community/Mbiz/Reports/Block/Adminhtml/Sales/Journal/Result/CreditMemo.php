<?php
/**
 * This file is part of Mbiz_Reports for Magento.
 *
 * @license MIT
 * @author Mina Amrouche <m.amrouche@monsieurbiz.com> <@mina_amrouche>
 * @category Mbiz
 * @package Mbiz_Reports
 * @copyright Copyright (c) 2017 Monsieur Biz (https://monsieurbiz.com/)
 */

/**
 * Adminhtml_Sales_Journal_Result_CreditMemo Block
 * @package Mbiz_Reports
 */
class Mbiz_Reports_Block_Adminhtml_Sales_Journal_Result_CreditMemo extends Mbiz_Reports_Block_Adminhtml_Sales_Journal_Result_Abstract
{

// Monsieur Biz Tag NEW_CONST

// Monsieur Biz Tag NEW_VAR

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->__('Credit Memos');
    }

    /**
     * {@inheritdoc}
     */
    public function getColumns()
    {
        return [
            "count" => $this->__('Number of Credit Memos'),
            "subtotal" => $this->__('Credit Memos Total Amount Excluding Tax'),
            "total" => $this->__('Credit Memos Total Amount'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function formatValue($columnCode, $value)
    {
        switch ($columnCode) {
            case 'count':
                return $value;
            default:
                return $this->formatPrice($value);
        }
    }

// Monsieur Biz Tag NEW_METHOD

}