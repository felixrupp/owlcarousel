<?php
namespace RZ\Owlcarousel\Hooks;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;

class ItemsProcFunc {

    protected $locallangPath = 'LLL:EXT:owlcarousel/Resources/Private/Language/locallang.xlf:';

    /**
     * Itemsproc function to extend the selection of templateLayouts in the plugin
     *
     * @param array &$config configuration array
     * @return void
     */
    public function user_templateLayout(array &$config) {
        $templateLayoutsUtility = GeneralUtility::makeInstance('RZ\Owlcarousel\Utility\TemplateLayout');
        $templateLayouts = $templateLayoutsUtility->getAvailableTemplateLayouts($config['row']['pid']);
        foreach ($templateLayouts as $layout) {
            $additionalLayout = array(
                $GLOBALS['LANG']->sL($layout[0], TRUE),
                $layout[1]
            );
            array_push($config['items'], $additionalLayout);
        }
    }

    public function user_slideItems($PA, $config) {
        if ($PA['row']['pi_flexform']) {
            // Get FlexForm
            $flexform = GeneralUtility::xml2array($PA['row']['pi_flexform']);

            // Get pages
            $pages = $flexform['data']['sDEF']['lDEF']['settings.pages']['vDEF'];
            if($pages) {
                $pagesArr = explode(",", $pages);

                $pages = array();
                foreach($pagesArr as $pid) {
                    $pages[] = intval(str_replace("pages_", "", $pid));
                } 
            }

            // Get slide items
            $slideItems = (is_array($flexform)) ? $flexform['data']['sDEF']['lDEF']['settings.slideItems']['vDEF'] : '';
        }

        // Field config
        if(is_array($pages) && !empty($pages)) {
            $pids = implode(",", $pages);

            // Check if there are any slides on the defined pages
            $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid', 'tx_owlcarousel_domain_model_items', 'hidden=0 AND deleted=0 AND pid IN (' . $pids . ')', '', '', '');
            $num = $GLOBALS['TYPO3_DB']->sql_num_rows($res);

            if ($num > 0) {
                $config = array(
                    'fieldConf' => array(
                        'config' => array(
                            'type' => 'select',
                            'foreign_table' => 'tx_owlcarousel_domain_model_items',
                            'foreign_table_where' => 'AND tx_owlcarousel_domain_model_items.pid IN (' . $pids . ') AND tx_owlcarousel_domain_model_items.hidden=0 AND tx_owlcarousel_domain_model_items.deleted=0 AND tx_owlcarousel_domain_model_items.sys_language_uid IN (0,-1) ORDER BY tx_owlcarousel_domain_model_items.sorting',
                            'size' => 8,
                            'minitems' => 0,
                            'maxitems' => 100,
                            'autoSizeMax' => 25,
                            'wizards' => array(
                                'suggest' => array(
                                    'type' => 'suggest'
                                ),
                            ),
                        ),
                    ),
                    'onFocus' => '',
                    'fieldChangeFunc' => array(
                        'owlcarousel' => ''
                    ),
                    'label' => 'Plugin Options',
                    'itemFormElValue' => $slideItems,
                    'itemFormElName' => 'data[tt_content][' . $PA['row']['uid'] . '][pi_flexform][data][sDEF][lDEF][settings.slideItems][vDEF]',
                    'itemFormElName_file' => 'data_files[tt_content][' . $PA['row']['uid'] . '][pi_flexform][data][sDEF][lDEF][settings.slideItems][vDEF]',
                );

                // Create the element
                $form = GeneralUtility::makeInstance('t3lib_TCEforms');
                $form->initDefaultBEMode();
                $form->backPath = $GLOBALS['BACK_PATH'];
                $form->doSaveFieldName = 'doSave';

                $element = $form->getSingleField_typeSelect('tt_content', 'pi_flexform', $PA['row'], $config);

                return $form->printNeededJSFunctions_top() . $element . $form->printNeededJSFunctions();
            }
            // No slide items
            else {
                $message = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
                     $GLOBALS['LANG']->sL($this->locallangPath . 'warningText', TRUE),
                     $GLOBALS['LANG']->sL($this->locallangPath . 'warning', TRUE),
                     \TYPO3\CMS\Core\Messaging\FlashMessage::WARNING,
                     TRUE
                );

                return $message->render();
            }
        }
        // No storage folder
        else {
            $message = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
                 $GLOBALS['LANG']->sL($this->locallangPath . 'informationText', TRUE),
                 $GLOBALS['LANG']->sL($this->locallangPath . 'information', TRUE),
                 \TYPO3\CMS\Core\Messaging\FlashMessage::INFO,
                 TRUE
            );

            return $message->render();
        }
    }

    private function debug($var) {
        \TYPO3\CMS\Core\Utility\DebugUtility::debug($var);
    }

}