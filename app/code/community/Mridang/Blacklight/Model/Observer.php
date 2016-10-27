<?php

/**
 *  Copyright (c) 2016 [Mridang Agarwalla]
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is
 *  furnished to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in
 *  all copies or substantial portions of the Software.
 */

// Include the autoloader for composer
require_once(Mage::getBaseDir('lib') . DS . 'blacklight' . DS . 'autoload.php');

class Mridang_Blacklight_Model_Observer
{
    /** @var $coverage \SebastianBergmann\CodeCoverage\CodeCoverage */
    private $coverage;

    /**
     * Observer method that is triggered at the start of a request-response lifecycle. This method
     * checks adds the path of the selected extension (assuming that is a community extension).
     *
     * @param Varien_Event_Observer $observer The observer event that is dispatched
     */
    public function hookToControllerActionPreDispatch(/** @noinspection PhpUnusedParameterInspection */
        Varien_Event_Observer $observer)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $route = $observer->getControllerAction()->getRequest()->getPathInfo();
        if (strpos($route, 'blacklight/report/view') !== false) {
            return;
        }

        $extension = Mage::getStoreConfig('mridang/settings/extension_name');
        $mode = Mage::getStoreConfig('mridang/settings/coverage_mode');
        // If the selected extension was empty or the coverage is disabled we skip the coverage
        // parsing.
        if (empty($extension) || $mode == Mridang_Blacklight_Helper_Data::OFF) {
            return;
        } else {
            //If the coverage mode is set to headers, the we expect a specific header that toggles
            // coverage. If that header is omitted, then the coverage is skipped.
            $header = Mage::app()->getRequest()->getHeader(Mridang_Blacklight_Helper_Data::XCOVER);
            if ($mode == Mridang_Blacklight_Helper_Data::HEADERS && empty($header)) {
                return;
            }
            //If the coverage mode is set to cookies, the we expect a specific cookie that toggles
            // coverage. If that cookie is omitted, then the coverage is skipped.
            /** @var Mage_Core_Model_Cookie $cookie */
            $cookie = Mage::getModel('core/cookie');
            $cookieContent = $cookie->get(Mridang_Blacklight_Helper_Data::XCOOKIE);
            if ($mode == Mridang_Blacklight_Helper_Data::COOKIE && empty($cookieContent)) {
                return;
            }
        }

        // Only files from the selected extension are added to the whitelist filter. We assume that
        // the extension is a community extension
        $community = str_replace('_', DS, $extension);
        $community = implode(DS, array(BP, 'app', 'code', 'community', $community));

        $filter = new \SebastianBergmann\CodeCoverage\Filter();
        $filter->addDirectoryToWhitelist($community);

        // The user can select the driver if needed. Currently XDebug isn't supported on PHP7.
        $driver = Mage::getStoreConfig('mridang/settings/coverage_driver');
        switch ($driver) {
            case Mridang_Blacklight_Helper_Data::PHPDBG:
                $driver = new SebastianBergmann\CodeCoverage\Driver\PHPDBG;
                break;
            case Mridang_Blacklight_Helper_Data::HHVM:
                $driver = new SebastianBergmann\CodeCoverage\Driver\HHVM;
                break;
            case Mridang_Blacklight_Helper_Data::XDEBUG:
                $driver = new SebastianBergmann\CodeCoverage\Driver\Xdebug;
                break;
            default:
                $driver = null;
                break;
        }

        // Start the code coverage tracking for the given extension using the specified driver,
        // the whitelist and the name of the extension.
        $this->coverage = new \SebastianBergmann\CodeCoverage\CodeCoverage($driver, $filter);
        $this->coverage->start($extension);
    }

    /**
     * Observer method that is triggered at the end of a request-response lifecycle. This method
     * checks for an running coverage instance and saves the coverage report
     *
     * @param Varien_Event_Observer $observer The observer event that is dispatched
     */
    public function hookToControllerActionPostDispatch(/** @noinspection PhpUnusedParameterInspection */
        Varien_Event_Observer $observer)
    {
        if (empty($this->coverage)) {
            return;
        }

        $this->coverage->stop();
        // Each request is it's own coverage report in the PHP format, identified by a short unique
        // identifier. The PHP code coverage report is chosen since it is easy to merge multiple
        // coverage reports into a single report. The actual coverage object isn't unserializable
        // and leads to errors and therefore a PHP report is created.
        /** @var Mridang_Blacklight_Helper_Data $helper */
        $helper = Mage::helper('blacklight');
        $fname = 'var' . DS . 'coverage' . DS . $helper->genUID() . '.cov';
        $writer = new \SebastianBergmann\CodeCoverage\Report\PHP;
        $writer->process($this->coverage, $fname);
    }
}