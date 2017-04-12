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
            'title' => $this->__("Title"),
            'rate' => $this->__("TVA"),
            'nb_orders' => $this->__("Number of orders"),
            'amount' => $this->__("Montant"),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function formatValue($columnCode, $value)
    {
        switch ($columnCode) {
            case 'amount':
                return $this->formatPrice($value);
            case 'rate':
                return $value . ' %';
            default:
                return $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getItems()
    {
        $total = new Varien_Object([
            'title' => '<strong>TOTAL</strong>',
            'rate' => null,
            'nb_orders' => 0,
            'amount' => 0,
        ]);
        $items = parent::getItems();

        foreach ($items as $item) {
            $total
                ->setNbOrders($total->getNbOrders() + $item->getNbOrders())
                ->setAmount($total->getAmount() + $item->getAmount())
            ;
        }
        $items['total'] = $total;

        return $items;
    }

// Monsieur Biz Tag NEW_METHOD

}