<?php
/**
 * This file is part of Mbiz_Reports for Magento.
 *
 * @license All rights reserved
 * @author Jacques Bodin-Hullin <@jacquesbh> <j.bodinhullin@monsieurbiz.com>
 * @category Mbiz
 * @package Mbiz_Reports
 * @copyright Copyright (c) 2015 Monsieur Biz (http://monsieurbiz.com/)
 */

/**
 * Sales_Journal_Result Model
 * @package Mbiz_Reports
 *
 * @method Varien_Object getSummary() Retrieve the totals summary
 */
class Mbiz_Reports_Model_Sales_Journal_Result extends Varien_Object
{

// Monsieur Biz Tag NEW_CONST

// Monsieur Biz Tag NEW_VAR

    /**
     * {@inheritdoc}
     */
    public function load(Mbiz_Reports_Model_Sales_Journal_Request $request)
    {
        // Load the models
        $models = Mage::getSingleton('mbiz_reports/config')->getModels();

        foreach ($models as $code => $model) {
            $lines = Mage::getSingleton($model)
                ->setCode($code)
                ->setResult($this)
                ->load($request)
            ;
            $this->setData($code, $lines);
        }

        return $this;
    }

// Monsieur Biz Tag NEW_METHOD

}