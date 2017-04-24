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
            'nb_invoices' => $this->__("Number of Invoices"),
            'invoices_subtotal' => $this->__("Invoices Amount Excluding Tax"),
            'invoices_discount' => $this->__("Invoices Discount Amount Excluding Tax"),
            'amount' => $this->__("TVA Amount"),
            'invoices_total' => $this->__("Invoices Amount Including Tax"),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function formatValue($columnCode, $value)
    {
        switch ($columnCode) {
            case 'title':
            case 'nb_invoices':
                return $value;
            case 'rate':
                return $value . ' %';
            default:
                return $this->formatPrice($value);
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
            'nb_invoices' => 0,
            'invoices_subtotal' => 0,
            'invoices_discount' => 0,
            'amount' => 0,
            'invoices_total' => 0,
        ]);
        $items = parent::getItems();

        foreach ($items as $item) {
            $total
                ->setNbInvoices($total->getNbInvoices() + $item->getNbInvoices())
                ->setInvoicesSubtotal($total->getInvoicesSubtotal() + $item->getInvoicesSubtotal())
                ->setInvoicesDiscount($total->getInvoicesDiscount() + $item->getInvoicesDiscount())
                ->setAmount($total->getAmount() + $item->getAmount())
                ->setInvoicesTotal($total->getInvoicesTotal() + $item->getInvoicesTotal())
            ;
        }
        $items['total'] = $total;

        return $items;
    }

// Monsieur Biz Tag NEW_METHOD

}