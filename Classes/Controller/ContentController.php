<?php
namespace RZ\Owlcarousel\Controller;

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

use RZ\Owlcarousel\Utility\T3jquery;

/**
 * ContentController
 */
class ContentController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
    
    /**
     * itemsRepository
     *
     * @var \RZ\Owlcarousel\Domain\Repository\ItemsRepository
     * @inject
     */
    protected $itemsRepository = NULL;

    /**
     * action list
     *
     * @return void
     */
    public function listAction() {
        // t3jquery
        $t3jqueryCheck = T3jquery::check();

        // Add jQuery
        if($t3jqueryCheck === false) {
            if($this->settings['addJquery']) {
                if($this->settings['addToFooter']) {
                    $GLOBALS['TSFE']->additionalFooterData['owlcarousel_jquery'] = '<script type="text/javascript" src="typo3conf/ext/owlcarousel/Resources/Public/Js/jquery-1.11.2.min.js"></script>';
                }
                else {
                    $GLOBALS['TSFE']->additionalHeaderData['owlcarousel_jquery'] = '<script type="text/javascript" src="typo3conf/ext/owlcarousel/Resources/Public/Js/jquery-1.11.2.min.js"></script>';
                }   
            }
        }

        // Add JS
        if($this->settings['addToFooter']) {
            $GLOBALS['TSFE']->additionalFooterData['owlcarousel_js'] = '<script type="text/javascript" src="typo3conf/ext/owlcarousel/Resources/Public/Js/owl.carousel/owl.carousel.min.js"></script>';
        }
        else {
            $GLOBALS['TSFE']->additionalHeaderData['owlcarousel_js'] = '<script type="text/javascript" src="typo3conf/ext/owlcarousel/Resources/Public/Js/owl.carousel/owl.carousel.min.js"></script>';
        }

        // Get uid 
        $cObj = $this->configurationManager->getContentObject();
        $uid = $cObj->data['uid'];

        // Get offers from settings
        $slider = $this->settings['slideItems'];

        if($slider) {
            $items = $this->itemsRepository->findByUidListOrderByList($slider);

            $this->view->assign('items', $items);        

            // Set CE uid
            $this->view->assign('uid', $uid);

            // Pages
            $pages = $this->settings['pages'];

            if($pages != '') {
                // Check if there are any slides on the defined pages
                $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid', 'tx_owlcarousel_domain_model_items', 'hidden=0 AND deleted=0 AND pid IN (' . $pages . ')', '', '', '');
                $num = $GLOBALS['TYPO3_DB']->sql_num_rows($res);

                if(!$num) {
                    $this->addFlashMessage(
                        $this->__('warningText'),
                        $messageTitle = $this->__('warning'),
                        $severity = \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING,
                        $storeInSession = TRUE
                    );
                }
            }
            else {
                $this->addFlashMessage(
                    $this->__('informationText'),
                    $messageTitle = $this->__('information'),
                    $severity = \TYPO3\CMS\Core\Messaging\AbstractMessage::INFO,
                    $storeInSession = TRUE
                );
            }
        }
    }

    protected function __($key, $vars = array()) {
        if(empty($vars)) {
            return \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($key, $this->extensionName);
        } else {
            return vsprintf(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($key, $this->extensionName), (array)$vars);
        }
    }

    protected function debug($var) {
        print_r("<pre>") . print_r($var) . print_r("</pre>");
    }

}