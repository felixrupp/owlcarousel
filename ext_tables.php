<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY,
    'Carousel',
    'LLL:EXT:owlcarousel/Resources/Private/Language/locallang_db.xlf:plugin_desc1'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY,
    'Content',
    'LLL:EXT:owlcarousel/Resources/Private/Language/locallang_db.xlf:plugin_desc2'
);

$pluginSignature = str_replace('_','',$_EXTKEY) . '_carousel';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_carousel.xml');

$pluginSignature = str_replace('_','',$_EXTKEY) . '_content';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_content.xml');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Owl Carousel');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_owlcarousel_domain_model_items', 'EXT:owlcarousel/Resources/Private/Language/locallang_csh_tx_owlcarousel_domain_model_items.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_owlcarousel_domain_model_items');
$GLOBALS['TCA']['tx_owlcarousel_domain_model_items'] = array(
    'ctrl' => array(
        'title' => 'LLL:EXT:owlcarousel/Resources/Private/Language/locallang_db.xlf:tx_owlcarousel_domain_model_items',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => TRUE,
        'sortby' => 'sorting',
        'prependAtCopy' => 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',

        'versioningWS' => 2,
        'versioning_followPages' => TRUE,

        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ),
        'searchFields' => 'title,description,image,link,',
        'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Items.php',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_owlcarousel_domain_model_items.png'
    ),
);

if (TYPO3_MODE == 'BE') {
    $extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY);

    // WizIcon
    $TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['RZ\Owlcarousel\Utility\Hook\WizIcon'] =
        $extPath . 'Classes/Utility/Hook/WizIcon.php';
}

// Show tables in page module
$tables = array(
    'tx_owlcarousel_domain_model_items' => 'title',
);

// Traverse tables
foreach($tables as $table => $fields) {
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['cms']['db_layout']['addTables'][$table][] = array(
        'fList' => $fields,
        'icon' => true,
    );
}