<?php
namespace RZ\Owlcarousel\Hooks;

/***************************************************************
*  Copyright notice
*
*  (c) 2015 Raphael Zschorsch <rafu1987@gmail.com>
*
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools;

class Save {

    public function processDatamap_afterDatabaseOperations($status, $table, $id, array $fieldArray, \TYPO3\CMS\Core\DataHandling\DataHandler &$pObj) {
        // ID
        if(!is_numeric($id)) {
            $id = $pObj->substNEWwithIDs[$id];
        }

        if ($table === 'tt_content' && $status == 'update') {
            $list_type = $pObj->datamap['tt_content'][$id]['list_type'];

            if($list_type == 'owlcarousel_content') {
                // Get flexform
                $row = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('pi_flexform', 'tt_content', 'uid='.intval($id));
                $flexform = $row['pi_flexform'];

                // XML
                $xml = new \DOMDocument();
                $xml->loadXML($flexform);
                
                $xpath = new \DOMXpath($xml);

                // Get FlexForm values
                $pages = $xpath->query("/T3FlexForms/data/sheet[@index='sDEF']/language/field[@index='settings.pages']/value")->item(0);
                $slideItems = $xpath->query("/T3FlexForms/data/sheet[@index='sDEF']/language/field[@index='settings.slideItems']/value")->item(0);
                $slideItemsArr = explode(",", $slideItems->nodeValue);

                // Get pages
                $pids = $pages->nodeValue;

                // Get uids
                $uidArr = array();
                $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid', 'tx_owlcarousel_domain_model_items', 'hidden=0 AND deleted=0 AND pid IN (' . $pids . ')', '', '', '');
                while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
                    $uidArr[] = $row['uid'];
                }

                // Filter uids
                foreach($slideItemsArr as $key => $item) {
                    if(!in_array($item, $uidArr)) {
                        unset($slideItemsArr[$key]);
                    }
                }

                // Change values
                $slideItems->nodeValue = implode(",", $slideItemsArr);

                // Save new flexform
                $flexformNew = $xml->saveXML();

                // Update flexform
                $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tt_content', 'uid='.intval($id), array('pi_flexform' => $flexformNew));
            }
        }
    }

    private function debug($var) {
        \TYPO3\CMS\Core\Utility\DebugUtility::debug($var);
    }
}