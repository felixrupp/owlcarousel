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

class JsViewHelper extends AbstractViewHelper {

	/**
	 * Add JS
	 *
	 * @param string $settings The settings
	 * @param string $settings The prevNext
	 * @param string $uid The uid
     * @param string $uid The selector
	 * @return string
	 */
	public function render($settings, $prevNext, $uid, $selector) {
		// Edit settings
		$settings = $this->editSettings($settings, $prevNext);

		// Output JS
		return $this->js($settings, $uid, $selector);
	}

	protected function editSettings($settings, $prevNext) {
		// Remove settings
		unset($settings['images']);
		unset($settings['addJquery']);
        unset($settings['slideItems']);
        unset($settings['templateLayout']);
        unset($settings['pages']);

		// Add some settings
		$settings['navText'] = json_encode($prevNext);

		// Output settings
		return $settings;
	}

	protected function js($settings, $uid, $selector) {       
		$addToFooter = $settings['addToFooter'];
		unset($settings['addToFooter']);

        // Responsive
        if($settings['responsive']) {
            $itemsArr = array(
                '1200' => $settings['items'],
                '992' => $settings['items992'],
                '768' => $settings['items768'],
                '0' => $settings['items0']
            );

            unset($settings['items']);

            // Sort array
            ksort($itemsArr);

            $items = '';
            foreach($itemsArr as $itemKey => $itemVal) {
                $items .= '
                    '.$itemKey.': {
                        items: '.$itemVal.'
                    },
                ';
            }

            $responsive = '
                ,responsive: { '.$items.' }
            ';
        }

        unset($settings['responsive']);
        unset($settings['items992']);
        unset($settings['items768']);
        unset($settings['items0']); 

        if($settings['dotsEach'] == 0) {
            unset($settings['dotsEach']);
        } 

		$owlSettings = '';
        $keys = array(
            'autoplay',
            'autoplayHoverPause',
            'nav',
            'dots',
            'loop',
            'autoWidth',
            'mouseDrag',
            'touchDrag',
            'pullDrag',
            'freeDrag'
        );
		foreach($settings as $key => $val) {
			if(in_array($key, $keys)) {
				if($val == 1) $val = 'true';
				else $val = 'false';
			}

			if($key == 'animateOut') {
				if($val == 1) {
					$val = '"fadeOut"';
				}
				else {
					continue;
				}
			}

			if($key == 'startPosition') {
				if($val != 0) $val = $val - 1;
			}

			$owlSettings .= $key.':'. $val.',';
		}

		// Remove last comma
		$owlSettings = substr($owlSettings, 0, -1);

		// Build JS
		$js = '
			<script type="text/javascript">
				(function($) {
					$(document).ready(function() {
						$("'.$selector.'").owlCarousel({
							'.$owlSettings.'
                            '.$responsive.'
						});
					});
				})(jQuery);
			</script>
		';

		// Output JS to footer
		if($addToFooter) {
			$GLOBALS['TSFE']->additionalFooterData['owlcarousel_'.$uid] = $js;
		}
		else {
			$GLOBALS['TSFE']->additionalHeaderData['owlcarousel_'.$uid] = $js;
		}
	}

	protected function debug($var) {
		print_r("<pre>") . print_r($var) . print_r("</pre>");
	}

}