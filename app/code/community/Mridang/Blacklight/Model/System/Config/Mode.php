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

class Mridang_Blacklight_Model_System_Config_Mode
{
    /**
     * Returns the options for the selector to choose the coverage mode. In the "OFF" mode, coverage
     * is disabled entirely. In the "ON" mode, every requires triggers the coverage. In the
     * "HEADERS" mode, a X-Run-Coverage mode header must be sent along with the request e.g. for
     * use in automated acceptance testing
     *
     * @return array the options for the select
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => Mridang_Blacklight_Helper_Data::OFF,
                'label' => 'Disabled',
            ),
            array(
                'value' => Mridang_Blacklight_Helper_Data::HEADERS,
                'label' => 'Using Headers',
            ),
            array(
                'value' => Mridang_Blacklight_Helper_Data::COOKIE,
                'label' => 'Using Cookies',
            ),
            array(
                'value' => Mridang_Blacklight_Helper_Data::ON,
                'label' => 'Always On',
            )
        );
    }
}
