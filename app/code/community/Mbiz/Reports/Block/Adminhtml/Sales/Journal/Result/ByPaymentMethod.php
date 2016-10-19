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
 * Adminhtml_Sales_Journal_Result_ByPaymentMethod Block
 * @package Mbiz_Reports
 */
class Mbiz_Reports_Block_Adminhtml_Sales_Journal_Result_ByPaymentMethod extends Mbiz_Reports_Block_Adminhtml_Sales_Journal_Result_Abstract
{

// Monsieur Biz Tag NEW_CONST

// Monsieur Biz Tag NEW_VAR

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->__('Par mode de paiement');
    }

    /**
     * {@inheritdoc}
     */
    public function getColumns()
    {
        return [
            'payment_method' => $this->__("Méthode de paiement"),
            'count'          => $this->__("Nombre de factures"),
            'subtotal'       => $this->__("Montant HT"),
            'discount'       => $this->__("Montant Promo HT"),
            'shipping'       => $this->__("Montant Livraison HT"),
            'tax'            => $this->__("Montant TVA"),
            'total'          => $this->__("Montant TTC"),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function formatValue($columnCode, $value)
    {
        switch ($columnCode) {
            case 'payment_method':
            case 'count':
                return $value;
            default:
                return $this->formatPrice($value);
        }
    }
    
    public function getItems()
    {
        $total = new Varien_Object([
            'count' => 0,
            'subtotal' => 0,
            'discount' => 0,
            'shipping' => 0,
            'tax' => 0,
            'total' => 0,
            'payment_method' => '<strong>TOTAL</strong>',
        ]);
        $items = parent::getItems();

        foreach ($items as $item) {
            $total
                ->setCount($total->getCount() + $item->getCount())
                ->setSubtotal($total->getSubtotal() + $item->getSubtotal())
                ->setDiscount($total->getDiscount() + $item->getDiscount())
                ->setShipping($total->getShipping() + $item->getShipping())
                ->setTax($total->getTax() + $item->getTax())
                ->setTotal($total->getTotal() + $item->getTotal())
            ;
        }

        $items['total'] = $total;

        return $items;
    }

// Monsieur Biz Tag NEW_METHOD

}