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

class Mridang_Blacklight_Model_System_Config_Driver
{
    /**
     * Returns the options for the selector to choose the coverage driver. XDebug is solid driver
     * for most use cases, unless you are running PHP7 in which case, PHPDebug might be required.
     * Leaving this option to auto works in most use cases and leaves the driver selection to the
     * underlying code coverage library which chooses the appropriate one based on the PHP runtime
     *
     * @return array the options for the select
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => Mridang_Blacklight_Helper_Data::XDEBUG,
                'label' => 'XDebug',
            ),
            array(
                'value' => Mridang_Blacklight_Helper_Data::HHVM,
                'label' => 'HHVM',
            ),
            array(
                'value' => Mridang_Blacklight_Helper_Data::PHPDBG,
                'label' => 'PHPDBG',
            ),
            array(
                'value' => Mridang_Blacklight_Helper_Data::AUTO,
                'label' => 'Auto',
            )
        );
    }
}
