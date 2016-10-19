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
                'subtotal' => 'SUM(invoice.base_subtotal) / COUNT(*)',
                'discount' => 'SUM(invoice.base_discount_amount) / COUNT(*)',
                'shipping' => 'SUM(invoice.shipping_amount) / COUNT(*)',
                'tax' => 'SUM(invoice.base_tax_amount) / COUNT(*)',
                'total' => 'SUM(invoice.grand_total) / COUNT(*)',
                'avg' => 'SUM(invoice.base_subtotal + invoice.base_discount_amount + invoice.shipping_amount) / COUNT(*)',
            ])
            ->where("DATE(invoice.created_at) >= ?", $from->toString('y-MM-dd'))
            ->where("DATE(invoice.created_at) <= ?", $to->toString('y-MM-dd'))
        ;

        $results = $select->query()->fetch();
        return [new Varien_Object($results)];
    }

// Monsieur Biz Tag NEW_METHOD

}