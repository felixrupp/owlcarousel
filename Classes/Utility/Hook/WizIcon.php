<?php
namespace RZ\Owlcarousel\Utility\Hook;

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Raphael Zschorsch <rafu1987@gmail.com>
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
 * Plugin 'Owlcarousel' for the 'owlcarousel' extension.
 *
 * @author 2015 Raphael Zschorsch
 * @package TYPO3
 * @subpackage tx_owlcarousel
 */
class WizIcon {

    /**
     * Path to locallang file (with : as postfix)
     *
     * @var string
     */
    protected $locallangPath = 'LLL:EXT:owlcarousel/Resources/Private/Language/locallang_mod.xlf:';

    protected $plugins = array(
        'owlcarousel_carousel',
        'owlcarousel_content'
    );

    /**
     * Processing the wizard items array
     *
     * @param array $wizardItems
     * @return array
     */
    public function proc($wizardItems = array())
    {
        foreach($this->plugins as $plugin)
            $wizardItems['plugins_tx_'.$plugin] = $this->createWizardItem($plugin);

        return $wizardItems;
    }

    protected function createWizardItem($plugin)
    {
        return array(
            'icon'          => ExtensionManagementUtility::extRelPath('owlcarousel') . 'Resources/Public/Icons/ExtIcons/'.$plugin.'.png',
            'title'         => $GLOBALS['LANG']->sL($this->locallangPath . $plugin . '_pluginWizardTitle', TRUE),
            'description'   => $GLOBALS['LANG']->sL($this->locallangPath . $plugin . '_pluginWizardDescription', TRUE),
            'params'        => '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=' . $plugin,
            'tt_content_defValues' => array(
                'CType' => 'list',
            ),
        );
    }
}