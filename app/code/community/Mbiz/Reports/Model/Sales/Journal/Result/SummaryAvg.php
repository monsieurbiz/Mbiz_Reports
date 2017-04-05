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
 * Sales_Journal_Result_Summary Model
 * @package Mbiz_Reports
 */
class Mbiz_Reports_Model_Sales_Journal_Result_SummaryAvg extends Mbiz_Reports_Model_Sales_Journal_Result_Abstract
{

// Monsieur Biz Tag NEW_CONST

// Monsieur Biz Tag NEW_VAR

    protected function _load(\Mbiz_Reports_Model_Sales_Journal_Request $request, \Zend_Date $from, \Zend_Date $to)
    {
        $read = $this->getReadAdapter();
        $select = $read->select();
        $select
            ->from([
                'invoice' => $this->getTableName('sales/invoice')
            ], [
                'subtotal' => 'SUM(ROUND(invoice.base_subtotal, 2)) / COUNT(*)',
                'discount' => 'SUM(ROUND(invoice.base_discount_amount, 2)) / COUNT(*)',
                'shipping' => 'SUM(ROUND(invoice.shipping_amount, 2)) / COUNT(*)',
                'tax' => 'SUM(ROUND(invoice.base_tax_amount, 2)) / COUNT(*)',
                'total' => 'SUM(ROUND(invoice.grand_total, 2)) / COUNT(*)',
                'avg' => 'SUM(ROUND(invoice.base_subtotal, 2) + ROUND(invoice.base_discount_amount, 2) + ROUND(invoice.shipping_amount, 2)) / COUNT(*)',
            ])
            ->where("DATE(invoice.created_at) >= ?", $from->toString('y-MM-dd'))
            ->where("DATE(invoice.created_at) <= ?", $to->toString('y-MM-dd'))
        ;

        $results = $select->query()->fetch();
        return [new Varien_Object($results)];
    }

// Monsieur Biz Tag NEW_METHOD

}