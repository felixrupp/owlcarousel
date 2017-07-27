<?php
namespace RZ\Owlcarousel\Domain\Model;


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

/**
 * Items
 */
class Items extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * title
     *
     * @var string
     */
    protected $title = '';

    /**
     * description
     *
     * @var string
     */
    protected $description = '';

    /**
     * image
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $image = NULL;

    /**
     * width
     *
     * @var string
     */
    protected $width = '';

    /**
     * autowidth
     *
     * @var string
     */
    protected $autowidth = '';

    /**
     * height
     *
     * @var string
     */
    protected $height = '';

    /**
     * crop
     * 
     * @var boolean
     */
     protected $crop;

    /**
     * link
     *
     * @var string
     */
    protected $link = '';

    /**
     * content
     *
     * @var string
     */
    protected $content = '';

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * Returns the image
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Sets the image
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function setImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image) {
        $this->image = $image;
    }

    /**
     * Returns the width
     *
     * @return string $width
     */
    public function getWidth() {
        return $this->width;
    }

    /**
     * Sets the width
     *
     * @param string $width
     * @return void
     */
    public function setWidth($width) {
        $this->width = $width;
    }

    /**
     * Returns the autowidth
     *
     * @return string $autowidth
     */
    public function getAutowidth() {
        return $this->autowidth;
    }

    /**
     * Sets the autowidth
     *
     * @param string $autowidth
     * @return void
     */
    public function setAutowidth($autowidth) {
        $this->autowidth = $autowidth;
    }

    /**
     * Returns the height
     *
     * @return string $height
     */
    public function getHeight() {
        return $this->height;
    }

    /**
     * Sets the height
     *
     * @param string $height
     * @return void
     */
    public function setHeight($height) {
        $this->height = $height;
    }

    /**
     * Returns the crop
     *
     * @return string $crop
     */
    public function getCrop() {
        return $this->crop;
    }

    /**
     * Sets the crop
     *
     * @param string $crop
     * @return void
     */
    public function setCrop($crop) {
        $this->crop = $crop;
    }

    /**
     * Returns the link
     *
     * @return string $link
     */
    public function getLink() {
        return $this->link;
    }

    /**
     * Sets the link
     *
     * @param string $link
     * @return void
     */
    public function setLink($link) {
        $this->link = $link;
    }

    /**
     * Returns the content
     *
     * @return string $content
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Sets the content
     *
     * @param string $content
     * @return void
     */
    public function setContent($content) {
        $this->content = $content;
    }

}