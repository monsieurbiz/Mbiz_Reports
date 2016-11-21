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
 * Sales_Journal_Result_Tax_Rate Model
 * @package Mbiz_Reports
 */
class Mbiz_Reports_Model_Sales_Journal_Result_Tax_Rate extends Mbiz_Reports_Model_Sales_Journal_Result_Abstract
{

// Monsieur Biz Tag NEW_CONST

// Monsieur Biz Tag NEW_VAR

    /**
     * Load the taxes by rates
     */
    protected function _load(\Mbiz_Reports_Model_Sales_Journal_Request $request, \Zend_Date $from, \Zend_Date $to)
    {
        // The first select calculates the products taxes
        $firstSelect = $this->getReadAdapter()->select();
        $amount      = "ROUND(IFNULL(item.base_row_total, 0), 2)";
        $discount    = "ROUND(IFNULL(item.base_discount_amount, 0), 2)";
        $tax         = "ROUND(IFNULL(item.base_tax_amount, 0), 2)";
        $firstSelect
            ->from([
                'invoice' => $this->getTableName('sales/invoice'),
            ], null)
            ->joinLeft([
                'item' => $this->getTableName('sales/invoice_item'),
            ], 'invoice.entity_id = item.parent_id', null)
            ->columns([
                'invoice_id'        => "invoice.entity_id",
                'amount'            => "$amount",
                'discount'          => "-$discount",
                'amount_discounted' => "$amount - $discount",
                'tax'               => "$tax",
                'total'             => "$amount - $discount + $tax",
                'rate'              => "IFNULL(ROUND(100 * $tax / ($amount - $discount), 2), 0)",
            ])
            ->group('item.entity_id')
            ->where("DATE(invoice.created_at) >= ?", $from->toString('y-MM-dd'))
            ->where("DATE(invoice.created_at) <= ?", $to->toString('y-MM-dd'))
        ;

        // The second select calculates the taxes on the shipping (which is a little bit more complicated)
        $secondSelect = $this->getReadAdapter()->select();
        $amount       = "ROUND(IFNULL(invoice.base_shipping_amount, 0), 2)";
        $discount     = "(ROUND(IFNULL(invoice.base_discount_amount, 0), 2) + SUM(ROUND(IFNULL(item.base_discount_amount, 0), 2)))";
        $tax          = "ROUND(IFNULL(invoice.base_tax_amount, 0), 2) - SUM(ROUND(IFNULL(item.base_tax_amount, 0), 2))";
        $secondSelect
            ->from([
                'invoice' => $this->getTableName('sales/invoice'),
            ], null)
            ->joinLeft([
                'item' => $this->getTableName('sales/invoice_item'),
            ], 'invoice.entity_id = item.parent_id', null)
            ->columns($cols = [
                'invoice_id'        => "invoice.entity_id",
                'amount'            => $amount,
                'discount'          => $discount,
                'amount_discounted' => "$amount + $discount",
                'tax'               => $tax,
                'total'             => "$amount + $discount + $tax",
                'rate'              => "IFNULL(ROUND(100 * ($tax) / ($amount + $discount), 2), 0)",
            ])
            ->group('invoice.entity_id')
            ->where("DATE(invoice.created_at) >= ?", $from->toString('y-MM-dd'))
            ->where("DATE(invoice.created_at) <= ?", $to->toString('y-MM-dd'))
        ;

        $mainSelect = $this->getReadAdapter()->select();
        $mainSelect
            ->from([
                'results' => new Zend_Db_Expr("($firstSelect UNION ALL $secondSelect)"),
            ], null)
            ->columns([
                'amount'            => 'SUM(ROUND(amount, 2))',
                'discount'          => 'SUM(ROUND(discount, 2))',
                'amount_discounted' => 'SUM(ROUND(amount_discounted, 2))',
                'tax'               => 'SUM(ROUND(tax, 2))',
                'total'             => 'SUM(ROUND(total, 2))',
                'rate'              => 'rate',
            ])
            ->group('rate')
        ;

        $results = $mainSelect->query()->fetchAll();
        $taxByRate = [];
        foreach ($results as $result) {
            $taxByRate[$result['rate']] = new Varien_Object($result);
        }

        return $taxByRate;
    }

// Monsieur Biz Tag NEW_METHOD

}