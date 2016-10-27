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

class Mridang_Blacklight_ReportController extends Mage_Core_Controller_Front_Action
{
    /**
     * Controller action which when visited finds all generated .cov files in the coverage output
     * directory and merges them to generate a humanized HTML report.
     */
    public function viewAction()
    {
        $path = Mage::getStoreConfig('mridang/settings/output_path');
        $merger = new SebastianBergmann\CodeCoverage\CodeCoverage;
        $facade = new \File_Iterator_Facade;
        $files = $facade->getFilesAsArray(BP . DS . $path, '.cov', '');
        if (!empty($files)) {
            /** @var Mridang_Blacklight_Helper_Data $helper */
            $helper = Mage::helper('blacklight');
            $reportName = $helper->getReportName();
            $reportUrl = sprintf(
                '%s%s/%s/%s',
                Mage::getBaseUrl(),
                $path,
                $reportName,
                'index.html'
            );
            foreach ($files as $file) {
                /** @noinspection PhpIncludeInspection */
                $_coverage = include($file);

                if (!($_coverage instanceof SebastianBergmann\CodeCoverage\CodeCoverage)) {
                    unset($_coverage);
                    continue;
                }
                $merger->merge($_coverage);
                echo sprintf('Merged: %s <br/>', $file);
                unset($_coverage);
                unlink($file);
            }

            $writer = new SebastianBergmann\CodeCoverage\Report\Html\Facade;
            $writer->process($merger, $path . DS . $reportName);
            echo sprintf(
                'Coverage report is generated in <a href="%s">%s</a>',
                $reportUrl,
                $reportUrl
            );

        } else {
            echo 'No files to process <br/>';
        }
        return;
    }
}
