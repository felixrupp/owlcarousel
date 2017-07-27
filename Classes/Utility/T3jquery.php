<?php
namespace RZ\Owlcarousel\Utility;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Raphael Zschorsch <rafu1987@gmail.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * T3jquery
 */
class T3jquery {

    /**
     * check
     *
     * @return void
     */
    public static function check() { 
        if (ExtensionManagementUtility::isLoaded('t3jquery')) {
            require_once(ExtensionManagementUtility::extPath('t3jquery').'class.tx_t3jquery.php');

            return true;
        }

        if (T3JQUERY === true) {
            tx_t3jquery::addJqJS();

            return true;
        }
        else {
            return false;
        }
    }

}
