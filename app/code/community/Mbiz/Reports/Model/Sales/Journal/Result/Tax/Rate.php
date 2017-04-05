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
        $select = $this->getReadAdapter()->select();
        $select
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
                "nb_orders" => "COUNT(DISTINCT tax.order_id)",
                "amount" => "SUM(ROUND(IFNULL(tax.base_amount, 0), 2))",
            ])
            ->where("DATE(invoice.created_at) >= ?", $from->toString('y-MM-dd'))
            ->where("DATE(invoice.created_at) <= ?", $to->toString('y-MM-dd'))
            ->where("ROUND(IFNULL(invoice.base_tax_amount, 0), 2) = ROUND(IFNULL(tax.base_amount, 0), 2)")
            ->group("tax.code")
        ;

        $results = $select->query()->fetchAll();
        $taxByRate = [];
        foreach ($results as $result) {
            $taxByRate[$result['code']] = new Varien_Object($result);
        }

        return $taxByRate;
    }

// Monsieur Biz Tag NEW_METHOD

}