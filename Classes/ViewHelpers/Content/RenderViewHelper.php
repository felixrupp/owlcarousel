<?php
namespace RZ\Owlcarousel\ViewHelpers\Content;

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

/**
 * @author Raphael Zschorsch <rafu1987@gmail.com>
 * @package Owlcarousel
 * @subpackage ViewHelpers
 */
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class RenderViewHelper extends AbstractViewHelper {

    /**
     * Render content
     *
     * @param string $settings The uid
     * @return string
     */
    public function render($uid) {
        $lang = $GLOBALS['TSFE']->sys_language_uid;

        if($lang == 0) {
            $field = 'uid';
        }
        else {
            $field = 't3_origuid';
        }

        $row = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('uid', 'tt_content', $field.'='.$uid.' AND sys_language_uid='.$lang);

        if($row) {
            $conf = array(
                'tables' => 'tt_content',
                'source' => $row['uid'],
                'dontCheckPid' => 1
            );

            return $GLOBALS['TSFE']->cObj->RECORDS($conf);
        }
    }

    protected function debug($var) {
        print_r("<pre>") . print_r($var) . print_r("</pre>");
    }

}