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
 * Config Model
 * @package Mbiz_Reports
 */
class Mbiz_Reports_Model_Config extends Mage_Core_Model_Abstract
{

// Monsieur Biz Tag NEW_CONST

// Monsieur Biz Tag NEW_VAR

    /**
     * Retrieve the blocks
     * @return array
     */
    public function getBlocks()
    {
        // Get all the reports
        $nodes = Mage::app()->getConfig()->getNode('mbiz_reports/report');

        $models = [];
        foreach ($nodes->children() as $code => $report) {
            if ((string) $report->block) {
                $models[$code] = (string) $report->block;
            }
        }

        return $models;
    }

    /**
     * Retrieve the models
     * @return array
     */
    public function getModels()
    {
        // Get all the reports
        $nodes = Mage::app()->getConfig()->getNode('mbiz_reports/report');

        $models = [];
        foreach ($nodes->children() as $code => $report) {
            if ((string) $report->model) {
                $models[$code] = (string) $report->model;
            }
        }

        return $models;
    }

// Monsieur Biz Tag NEW_METHOD

}