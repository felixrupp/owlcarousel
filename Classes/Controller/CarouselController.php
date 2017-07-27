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
 * CarouselController
 */
class CarouselController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
        // Get uid 
        $cObj = $this->configurationManager->getContentObject();
        $uid = $cObj->data['uid'];

        // Get images
        $images = $this->getFileReferences($uid);
		
		// Add JS?
        if(count($images) > 1) {
            // Add jQuery?
            $t3jqueryCheck = T3jquery::check();
            
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

    		// Add JS files
    		if($this->settings['addToFooter']) {
    			$GLOBALS['TSFE']->additionalFooterData['owlcarousel_js'] = '<script type="text/javascript" src="typo3conf/ext/owlcarousel/Resources/Public/Js/owl.carousel/owl.carousel.min.js"></script>';
    		}
    		else {
    			$GLOBALS['TSFE']->additionalHeaderData['owlcarousel_js'] = '<script type="text/javascript" src="typo3conf/ext/owlcarousel/Resources/Public/Js/owl.carousel/owl.carousel.min.js"></script>';
    		}
        }

		// Set CE uid
		$this->view->assign('uid', $uid);

        // Change items if 0
        if($this->settings['items'] == 0) {
            $this->settings['items'] = 1;
        }

		// Set template vars
        $this->view->assign('images', $images);
        $this->view->assign('imageCount', count($images));
        $this->view->assign('settings', $this->settings);
	}

	protected function getFileReferences($uid) {
		$fileRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\FileRepository');
		$fileObjects = $fileRepository->findByRelation('tt_content', 'owlcarousel.fe2.content02.images', $uid);
		
		$files = array();
		foreach ($fileObjects as $key => $value) {
		  $files[$key]['reference'] = $value->getReferenceProperties();
		  $files[$key]['original'] = $value->getOriginalFile()->getProperties();
		}
 
		return $files;
	}

    protected function debug($var) {
        print_r("<pre>") . print_r($var) . print_r("</pre>");
    }

}