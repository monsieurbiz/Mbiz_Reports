<?php
/**
 * This file is part of MBiz_Reports for Magento.
 *
 * @license MIT
 * @author Mina Amrouche <m.amrouche@monsieurbiz.com> <@mina_amrouche>
 * @category MBiz
 * @package MBiz_Reports
 * @copyright Copyright (c) 2017 Monsieur Biz (https://monsieurbiz.com/)
 */

/**
 * Sales_Journal_Result_CreditMemo Model
 * @package MBiz_Reports
 */
class MBiz_Reports_Model_Sales_Journal_Result_CreditMemo extends Mbiz_Reports_Model_Sales_Journal_Result_Abstract
{

// Monsieur Biz Tag NEW_CONST

// Monsieur Biz Tag NEW_VAR

    protected function _load(\Mbiz_Reports_Model_Sales_Journal_Request $request, \Zend_Date $from, \Zend_Date $to)
    {
        $read = $this->getReadAdapter();
        $select = $read->select();
        $select
            ->from([
                'memo' => $this->getTableName('sales/creditmemo')
            ], [
                'subtotal' => 'SUM(ROUND(memo.subtotal, 2))',
                'total' => 'SUM(ROUND(memo.grand_total, 2))',
            ])
            ->where("DATE(memo.created_at) >= ?", $from->toString('y-MM-dd'))
            ->where("DATE(memo.created_at) <= ?", $to->toString('y-MM-dd'))
        ;

        $results = $select->query()->fetch();
        return [new Varien_Object($results)];
    }

// Monsieur Biz Tag NEW_METHOD

}