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
 * Sales_Journal_Result_Payment_Method Model
 * @package Mbiz_Reports
 */
class Mbiz_Reports_Model_Sales_Journal_Result_Payment_Method extends Mbiz_Reports_Model_Sales_Journal_Result_Abstract
{

// Monsieur Biz Tag NEW_CONST

// Monsieur Biz Tag NEW_VAR

    /**
     * Load by payment method
     */
    protected function _load(\Mbiz_Reports_Model_Sales_Journal_Request $request, \Zend_Date $from, \Zend_Date $to)
    {
        $read = $this->getReadAdapter();
        $select = $read->select();
        $select
            ->from([
                'invoice' => $this->getTableName('sales/invoice')
            ], [
                'count'    => 'COUNT(*)',
                'subtotal' => 'SUM(ROUND(IFNULL(invoice.base_subtotal, 0), 2))',
                'discount' => 'SUM(ROUND(IFNULL(invoice.base_discount_amount, 0), 2))',
                'shipping' => 'SUM(ROUND(IFNULL(invoice.shipping_amount, 0), 2))',
                'tax'      => 'SUM(ROUND(IFNULL(invoice.base_tax_amount, 0), 2))',
                'total'    => 'SUM(ROUND(IFNULL(invoice.base_grand_total, 0), 2))',
            ])
            ->where("invoice.created_at >= ?", $from->toString('y-MM-dd HH:mm:ss'))
            ->where("invoice.created_at <= ?", $to->toString('y-MM-dd HH:mm:ss'))

            // Join payment
            ->joinRight([
                'payment' => $this->getTableName('sales/order_payment')
            ], 'payment.parent_id = invoice.order_id', [
                'payment_method' => 'payment.method'
            ])

            // Group
            ->group('payment.method')
        ;

        $results = $select->query()->fetchAll();

        $methods = Mage::helper('payment')->getPaymentMethodList();
        $byPaymentMethod = [];
        foreach ($results as $result) {
            $byPaymentMethod[$result['payment_method']] = new Varien_Object($result + [
                'payment_method_name' => isset($methods[$result['payment_method']]) ? $methods[$result['payment_method']] : $result['payment_method']
            ]);
        }

        return $byPaymentMethod;
    }

// Monsieur Biz Tag NEW_METHOD

}
