<?php
namespace RZ\Owlcarousel\Tests\Unit\Controller;
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
 * Test case for class RZ\Owlcarousel\Controller\CarouselController.
 *
 * @author Raphael Zschorsch <rafu1987@gmail.com>
 */
class CarouselControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \RZ\Owlcarousel\Controller\CarouselController
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = $this->getMock('RZ\\Owlcarousel\\Controller\\CarouselController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllCarouselsFromRepositoryAndAssignsThemToView() {

		$allCarousels = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$carouselRepository = $this->getMock('RZ\\Owlcarousel\\Domain\\Repository\\CarouselRepository', array('findAll'), array(), '', FALSE);
		$carouselRepository->expects($this->once())->method('findAll')->will($this->returnValue($allCarousels));
		$this->inject($this->subject, 'carouselRepository', $carouselRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('carousels', $allCarousels);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}
}
