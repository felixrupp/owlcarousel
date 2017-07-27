<?php
namespace RZ\Owlcarousel\Domain\Repository;


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
 * The repository for Items
 */
class ItemsRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

    /**
     *  Find by multiple uids using, seperated string and maintain the list order 
     * 
     */
    public function findByUidListOrderByList($uidList) {
        $uidArray = explode(",", $uidList);
        $lang = $GLOBALS['TSFE']->sys_language_uid;

        if($lang == 0) {
            $field = 'uid';
        }
        else {
            $field = 'l10n_parent';
        }

        $query = $this->createQuery();
        $query->getQuerySettings()
            ->setRespectStoragePage(false);
        $query->matching(
            $query->in($field, $uidArray),
            $query->logicalAnd(
                $query->equals('hidden', 0),
                $query->equals('deleted', 0),
                $query->logicalOr(
                    $query->equals('sys_language_uid', $lang),
                    $query->equals('sys_language_uid', -1)
                )
            )
        );
        $query->setOrderings($this->orderByField('uid', $uidArray));

        return $query->execute();
    }

     /**
     *  Set the order method 
     * 
     */
     protected function orderByField($field, $values) {
        $orderings = array();
        foreach ($values as $value) {
            $orderings[$field.'='.$value] = \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING;
        }

        return $orderings;
     }

}