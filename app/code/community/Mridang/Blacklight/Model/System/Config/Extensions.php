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
class Mridang_Blacklight_Model_System_Config_Extensions
{
    /**
     * Returns the options for the selector to choose the extension to audit code coverage for.
     * There doesn't seem to be a clean way to get a list of all installed extensions so the
     * XML is queried and any extension names beginning with Mage_ are excluded as they core
     * extensions
     *
     * @return array the options for the select
     */
    public function toOptionArray()
    {
        $extensions = array();
        $modules = Mage::getConfig()->getNode('modules')->children();
        foreach ($modules as $moduleName => $moduleSettings) {
            if (substr($moduleName, 0, 5) === "Mage_") {
                continue;
            } else {
                $extensions[] = array(
                    'value' => $moduleName,
                    'label' => $moduleName,
                );
            }
        }
        return $extensions;
    }
}
