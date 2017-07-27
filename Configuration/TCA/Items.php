<?php
if (!defined ('TYPO3_MODE')) {
    die ('Access denied.');
}

$GLOBALS['TCA']['tx_owlcarousel_domain_model_items'] = array(
    'ctrl' => $GLOBALS['TCA']['tx_owlcarousel_domain_model_items']['ctrl'],
    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, description, image, width, height, crop, link, content, autowidth',
    ),
    'types' => array(
        '1' => array('showitem' => '
            --div--;LLL:EXT:owlcarousel/Resources/Private/Language/locallang_db.xlf:tx_owlcarousel_domain_model_items.tabs.general, sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, description;;;richtext:rte_transform[mode=ts_links], link,
            --div--;LLL:EXT:owlcarousel/Resources/Private/Language/locallang_db.xlf:tx_owlcarousel_domain_model_items.tabs.image, image, width, height, crop,
            --div--;LLL:EXT:owlcarousel/Resources/Private/Language/locallang_db.xlf:tx_owlcarousel_domain_model_items.tabs.content, content,
            --div--;LLL:EXT:owlcarousel/Resources/Private/Language/locallang_db.xlf:tx_owlcarousel_domain_model_items.tabs.options, autowidth,
            --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
    ),
    'palettes' => array(
        '1' => array('showitem' => ''),
    ),
    'columns' => array(
    
        'sys_language_uid' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => array(
                    array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
                    array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
                ),
            ),
        ),
        'l10n_parent' => array(
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('', 0),
                ),
                'foreign_table' => 'tx_owlcarousel_domain_model_items',
                'foreign_table_where' => 'AND tx_owlcarousel_domain_model_items.pid=###CURRENT_PID### AND tx_owlcarousel_domain_model_items.sys_language_uid IN (-1,0)',
            ),
        ),
        'l10n_diffsource' => array(
            'config' => array(
                'type' => 'passthrough',
            ),
        ),

        't3ver_label' => array(
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            )
        ),
    
        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => array(
                'type' => 'check',
            ),
        ),
        'starttime' => array(
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => array(
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => array(
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ),
            ),
        ),
        'endtime' => array(
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => array(
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => array(
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ),
            ),
        ),

        'title' => array(
            'exclude' => 1,
            'l10n_mode' => 'prefixLangTitle',
            'label' => 'LLL:EXT:owlcarousel/Resources/Private/Language/locallang_db.xlf:tx_owlcarousel_domain_model_items.title',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
        ),
        'description' => array(
            'exclude' => 1,
            'l10n_mode' => 'prefixLangTitle',
            'label' => 'LLL:EXT:owlcarousel/Resources/Private/Language/locallang_db.xlf:tx_owlcarousel_domain_model_items.description',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'wizards' => array(
                    'RTE' => array(
                        'icon' => 'wizard_rte2.gif',
                        'notNewRecords'=> 1,
                        'RTEonly' => 1,
                        'script' => 'wizard_rte.php',
                        'title' => 'LLL:EXT:cms/locallang_ttc.xlf:bodytext.W.RTE',
                        'type' => 'script'
                    )
                )
            ),
        ),
        'image' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:owlcarousel/Resources/Private/Language/locallang_db.xlf:tx_owlcarousel_domain_model_items.image',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                array(
                    'maxitems' => 1,
                    'appearance' => array(
                        'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference'
                    )
                ),
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ),
        'width' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:owlcarousel/Resources/Private/Language/locallang_db.xlf:tx_owlcarousel_domain_model_items.width',
            'config' => array(
                'type' => 'input',
                'size' => 5,
                'eval' => 'int,trim'
            ),
        ),
        'height' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:owlcarousel/Resources/Private/Language/locallang_db.xlf:tx_owlcarousel_domain_model_items.height',
            'config' => array(
                'type' => 'input',
                'size' => 5,
                'eval' => 'int,trim'
            ),
        ),
        'crop' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:owlcarousel/Resources/Private/Language/locallang_db.xlf:tx_owlcarousel_domain_model_items.crop',
            'config' => array(
                'type' => 'check'
            ),
        ),
        'link' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:owlcarousel/Resources/Private/Language/locallang_db.xlf:tx_owlcarousel_domain_model_items.link',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'wizards' => array(
                    '_PADDING' => 2,
                    'link' => array(
                        'type' => 'popup',
                        'title' => 'LLL:EXT:cms/locallang_ttc.xml:header_link_formlabel',
                        'icon' => 'link_popup.gif',
                        'script' => 'browse_links.php?mode=wizard',
                        'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1',
                    ),
                ),
                'softref' => 'typolink',
            ),
        ),
        'content' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:owlcarousel/Resources/Private/Language/locallang_db.xlf:tx_owlcarousel_domain_model_items.content',
            'config' => array(
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tt_content',
                'show_thumbs' => 1,
                'size' => 5,
                'autosizemax' => 10,
                'maxitems' => 100,
                'minitems' => 0
            ),
        ),
        'autowidth' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:owlcarousel/Resources/Private/Language/locallang_db.xlf:tx_owlcarousel_domain_model_items.autowidth',
            'config' => array(
                'type' => 'input',
                'size' => 5,
                'eval' => 'int,trim'
            ),
        ),
        
    ),
);