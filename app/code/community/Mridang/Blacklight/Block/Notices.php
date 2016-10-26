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
class Mridang_Blacklight_Block_Notices extends Mage_Core_Block_Template
{
    /**
     * Returns a boolean value indicating whether the notification banner should be shown or not
     *
     * @return bool A value indicating the notification banner visibility
     */
    public function displayCoverageNotice()
    {
        return Mage::getStoreConfig('mridang/settings/coverage_mode') != Mridang_Blacklight_Helper_Data::OFF;
    }
}
