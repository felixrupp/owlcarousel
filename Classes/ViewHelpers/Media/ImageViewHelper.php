<?php
namespace RZ\Owlcarousel\ViewHelpers\Media;
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
 * ************************************************************* */
use FluidTYPO3\Vhs\ViewHelpers\Media\Image\AbstractImageViewHelper;

/**
 * Renders an image tag for the given resource including all valid
 * HTML5 attributes. Derivates of the original image are rendered
 * if the provided (optional) dimensions differ.
 *
 * @author Raphael Zschorsch <rafu1987@gmail.com>
 * @package Owlcarousel
 * @subpackage ViewHelpers\Media
 */
class ImageViewHelper extends AbstractImageViewHelper {

	/**
	 * name of the tag to be created by this view helper
	 *
	 * @var string
	 * @api
	 */
	protected $tagName = 'img';

	/**
	 * Initialize arguments.
	 *
	 * @return void
	 * @api
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerUniversalTagAttributes();
		$this->registerTagAttribute('usemap', 'string', 'A hash-name reference to a map element with which to associate the image.', FALSE);
		$this->registerTagAttribute('ismap', 'string', 'Specifies that its img element provides access to a server-side image map.', FALSE, '');
		$this->registerTagAttribute('alt', 'string', 'Equivalent content for those who cannot process images or who have image loading disabled.', TRUE);
	}

	/**
	 * Render method
	 *
	 * @return string
	 */
	public function render() {
		$this->preprocessImage();
		$src = $this->preprocessSourceUri($this->mediaSource, ['relative' => FALSE]);
		$this->tag->addAttribute('src', $src);

		/* We don't want width and height attributes */
		
		//$this->tag->addAttribute('width', $this->imageInfo[0]);
		//$this->tag->addAttribute('height', $this->imageInfo[1]);

		if ('' === $this->arguments['title']) {
			$this->tag->addAttribute('title', $this->arguments['alt']);
		}
		return $this->tag->render();
	}

}
