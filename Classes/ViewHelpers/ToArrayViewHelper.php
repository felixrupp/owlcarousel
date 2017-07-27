<?php
namespace RZ\Owlcarousel\ViewHelpers;

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

class ToArrayViewHelper extends AbstractViewHelper {

    /**
     * Return array
     *
     * @param string $string The string
     * @return string
     */
    public function render($string) {
        // Return array
        return explode(",", $string);
    }

}