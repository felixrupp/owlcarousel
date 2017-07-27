<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'RZ.' . $_EXTKEY,
    'Carousel',
    array(
        'Carousel' => 'list',
        
    ),
    // non-cacheable actions
    array(
        'Carousel' => '',
        
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'RZ.' . $_EXTKEY,
    'Content',
    array(
        'Content' => 'list',
        
    ),
    // non-cacheable actions
    array(
        'Content' => '',
        
    )
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['RZ.' . $_EXTKEY] = 'RZ\Owlcarousel\Hooks\Save';