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

class Mridang_Blacklight_Helper_Data extends Mage_Core_Helper_Abstract
{
    /* Constants used for the coverage driver configuration */
    const XDEBUG = 'xdebug';
    const HHVM = 'hhvm';
    const PHPDBG = 'phpdbg';
    const AUTO = 'auto';

    /* Constants used for the coverage mode configuration */
    const OFF = 'off';
    const HEADERS = 'headers';
    const ON = 'on';

    const XCOVER = 'X-Run-Coverage';

    public function genUID($l = 7)
    {
        /** @noinspection SpellCheckingInspection */
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $l);
    }
}