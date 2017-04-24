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
        // Select all invoices with a non-zero tax rate
        $selectNonZeroTaxRate = $this->getReadAdapter()->select();
        $selectNonZeroTaxRate
            ->from(['tax' => $this->getTableName('sales/order_tax')], null)
            ->joinInner(
                ['invoice' => $this->getTableName('sales/invoice')],
                'invoice.order_id = tax.order_id',
                null
            )
            ->columns([
                "code" => "tax.code",
                "title" => "tax.title",
                "rate" => "ROUND(tax.percent, 2)",
                "nb_invoices" => "COUNT(invoice.order_id)",
                'invoices_subtotal' => "SUM(ROUND(IFNULL(invoice.base_subtotal, 0), 2))",
                'invoices_discount' => "SUM(ROUND(IFNULL(invoice.base_discount_amount, 0), 2))",
                "amount" => "SUM(ROUND(IFNULL(invoice.base_tax_amount, 0), 2))",
                'invoices_total'    => "SUM(ROUND(IFNULL(invoice.base_grand_total, 0), 2))",
            ])
            ->where("DATE(invoice.created_at) >= ?", $from->toString('y-MM-dd'))
            ->where("DATE(invoice.created_at) <= ?", $to->toString('y-MM-dd'))
            ->group("tax.code")
        ;

        $selectOrdersId = $this->getReadAdapter()->select();
        $selectOrdersId
            ->from($this->getTableName('sales/order_tax'), ['order_id'])
        ;

        // Select all invoices with a 0% tax rate
        $selectZeroTaxRate = $this->getReadAdapter()->select();
        $selectZeroTaxRate
            ->from(['invoice' => $this->getTableName('sales/invoice')], null)
            ->columns([
                "code" => new Zend_Db_Expr("'ZERO'"),
                "title" => new Zend_Db_Expr("'ZERO'"),
                "rate" => new Zend_Db_Expr("0.0"),
                "nb_invoices" => "COUNT(invoice.order_id)",
                'invoices_subtotal' => "SUM(ROUND(IFNULL(invoice.base_subtotal, 0), 2))",
                'invoices_discount' => "SUM(ROUND(IFNULL(invoice.base_discount_amount, 0), 2))",
                "amount" => new Zend_Db_Expr("0.0"),
                'invoices_total'    => "SUM(ROUND(IFNULL(invoice.base_grand_total, 0), 2))",
            ])
            ->where("DATE(invoice.created_at) >= ?", $from->toString('y-MM-dd'))
            ->where("DATE(invoice.created_at) <= ?", $to->toString('y-MM-dd'))
            ->where("invoice.order_id NOT IN ?", $selectOrdersId)
        ;

        // Unite results of both selects
        $mainSelect = $this->getReadAdapter()->select();
        $mainSelect->union([$selectNonZeroTaxRate, $selectZeroTaxRate]);

        $results = $mainSelect->query()->fetchAll();
        $taxByRate = [];
        foreach ($results as $result) {
            $taxByRate[$result['code']] = new Varien_Object($result);
        }

        return $taxByRate;
    }

// Monsieur Biz Tag NEW_METHOD

}