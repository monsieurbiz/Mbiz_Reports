<?php
/**
 * This file is part of Mbiz_Reports for Magento.
 *
 * @license All rights reserved
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
            "total_credit_memo" => $this->__('Credit Memos Total Amount'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function formatValue($columnCode, $value)
    {
        return $this->formatPrice($value);
    }

// Monsieur Biz Tag NEW_METHOD

}