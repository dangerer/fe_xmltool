<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_exabiscompetences_educationlevels'] = array (
	'ctrl' => $TCA['tx_exabiscompetences_educationlevels']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,fe_group,title'
	),
	'feInterface' => $TCA['tx_exabiscompetences_educationlevels']['feInterface'],
	'columns' => array (
		'sys_language_uid' => array (		
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l10n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_exabiscompetences_educationlevels',
				'foreign_table_where' => 'AND tx_exabiscompetences_educationlevels.pid=###CURRENT_PID### AND tx_exabiscompetences_educationlevels.sys_language_uid IN (-1,0)',
			)
		),
		'l10n_diffsource' => array (		
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'fe_group' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
			'config'  => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
					array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
					array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
				),
				'foreign_table' => 'fe_groups'
			)
		),
		'title' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_educationlevels.title',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, fe_group, title;;;;2-2-2')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);



$TCA['tx_exabiscompetences_schooltypes'] = array (
	'ctrl' => $TCA['tx_exabiscompetences_schooltypes']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,fe_group,title,elid'
	),
	'feInterface' => $TCA['tx_exabiscompetences_schooltypes']['feInterface'],
	'columns' => array (
		'sys_language_uid' => array (		
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l10n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_exabiscompetences_schooltypes',
				'foreign_table_where' => 'AND tx_exabiscompetences_schooltypes.pid=###CURRENT_PID### AND tx_exabiscompetences_schooltypes.sys_language_uid IN (-1,0)',
			)
		),
		'l10n_diffsource' => array (		
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'fe_group' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
			'config'  => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
					array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
					array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
				),
				'foreign_table' => 'fe_groups'
			)
		),
		'title' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_schooltypes.title',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'elid' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_schooltypes.elid',		
			'config' => array (
				'type' => 'select',	
				'foreign_table' => 'tx_exabiscompetences_educationlevels',	
				'foreign_table_where' => 'ORDER BY tx_exabiscompetences_educationlevels.uid',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, fe_group, title;;;;2-2-2, elid;;;;3-3-3')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);



$TCA['tx_exabiscompetences_subjects'] = array (
	'ctrl' => $TCA['tx_exabiscompetences_subjects']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,fe_group,title,stid'
	),
	'feInterface' => $TCA['tx_exabiscompetences_subjects']['feInterface'],
	'columns' => array (
		'sys_language_uid' => array (		
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l10n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_exabiscompetences_subjects',
				'foreign_table_where' => 'AND tx_exabiscompetences_subjects.pid=###CURRENT_PID### AND tx_exabiscompetences_subjects.sys_language_uid IN (-1,0)',
			)
		),
		'l10n_diffsource' => array (		
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'fe_group' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
			'config'  => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
					array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
					array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
				),
				'foreign_table' => 'fe_groups'
			)
		),
		'title' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_subjects.title',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'stid' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_subjects.stid',		
			'config' => array (
				'type' => 'select',	
				'foreign_table' => 'tx_exabiscompetences_schooltypes',	
				'foreign_table_where' => 'ORDER BY tx_exabiscompetences_schooltypes.uid',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, fe_group, title;;;;2-2-2, stid;;;;3-3-3')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);



$TCA['tx_exabiscompetences_topics'] = array (
	'ctrl' => $TCA['tx_exabiscompetences_topics']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,fe_group,title,subjid'
	),
	'feInterface' => $TCA['tx_exabiscompetences_topics']['feInterface'],
	'columns' => array (
		'sys_language_uid' => array (		
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l10n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_exabiscompetences_topics',
				'foreign_table_where' => 'AND tx_exabiscompetences_topics.pid=###CURRENT_PID### AND tx_exabiscompetences_topics.sys_language_uid IN (-1,0)',
			)
		),
		'l10n_diffsource' => array (		
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'fe_group' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
			'config'  => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
					array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
					array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
				),
				'foreign_table' => 'fe_groups'
			)
		),
		'title' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_topics.title',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'subjid' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_topics.subjid',		
			'config' => array (
				'type' => 'select',	
				'foreign_table' => 'tx_exabiscompetences_subjects',	
				'foreign_table_where' => 'ORDER BY tx_exabiscompetences_subjects.uid',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, fe_group, title;;;;2-2-2, subjid;;;;3-3-3')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);



$TCA['tx_exabiscompetences_descriptors'] = array (
	'ctrl' => $TCA['tx_exabiscompetences_descriptors']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,fe_group,title,topicid,niveauid,skillid'
	),
	'feInterface' => $TCA['tx_exabiscompetences_descriptors']['feInterface'],
	'columns' => array (
		'sys_language_uid' => array (		
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l10n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_exabiscompetences_descriptors',
				'foreign_table_where' => 'AND tx_exabiscompetences_descriptors.pid=###CURRENT_PID### AND tx_exabiscompetences_descriptors.sys_language_uid IN (-1,0)',
			)
		),
		'l10n_diffsource' => array (		
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'fe_group' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
			'config'  => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
					array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
					array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
				),
				'foreign_table' => 'fe_groups'
			)
		),
		'title' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_descriptors.title',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',	
				'rows' => '5',
			)
		),
		'topicid' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_descriptors.topicid',		
			'config' => array (
				'type' => 'select',	
				'foreign_table' => 'tx_exabiscompetences_topics',	
				'foreign_table_where' => 'ORDER BY tx_exabiscompetences_topics.uid',	
				'size' => 10,	
				'minitems' => 0,
				'maxitems' => 100,	
				"MM" => "tx_exabiscompetences_descriptors_topicid_mm",
			)
		),
		'niveauid' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_descriptors.niveauid',		
			'config' => array (
				'type' => 'select',	
				'items' => array (
					array('',0),
				),
				'foreign_table' => 'tx_exabiscompetences_niveaus',	
				'foreign_table_where' => 'ORDER BY tx_exabiscompetences_niveaus.uid',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'skillid' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_descriptors.skillid',		
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('',0),
				),	
				'foreign_table' => 'tx_exabiscompetences_skills',	
				'foreign_table_where' => 'ORDER BY tx_exabiscompetences_skills.uid',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, fe_group, title;;;;2-2-2, topicid;;;;3-3-3, niveauid, skillid')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);



$TCA['tx_exabiscompetences_examples'] = array (
	'ctrl' => $TCA['tx_exabiscompetences_examples']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,title,descrid,task,solution,attachement,completefile,description,taxid,timeframe,ressources,tips,externalurl,externalsolution,externaltask'
	),
	'feInterface' => $TCA['tx_exabiscompetences_examples']['feInterface'],
	'columns' => array (
		'sys_language_uid' => array (		
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l10n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_exabiscompetences_examples',
				'foreign_table_where' => 'AND tx_exabiscompetences_examples.pid=###CURRENT_PID### AND tx_exabiscompetences_examples.sys_language_uid IN (-1,0)',
			)
		),
		'l10n_diffsource' => array (		
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'title' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_examples.title',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'descrid' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_examples.descrid',		
			'config' => array (
				'type' => 'select',	
				'items' => array (
					array('',0),
				),	
				'foreign_table' => 'tx_exabiscompetences_descriptors',	
				'foreign_table_where' => 'ORDER BY tx_exabiscompetences_descriptors.uid',	
				'size' => 10,	
				'minitems' => 0,
				'maxitems' => 100,	
				"MM" => "tx_exabiscompetences_examples_descrid_mm",
			)
		),
		'task' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_examples.task',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => '',	
				'disallowed' => 'php,php3',	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_exabiscompetences',
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'solution' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_examples.solution',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => 'gif,png,jpeg,jpg,pdf,doc,docx,xls,xlsx,ppt,pptx,zip',	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_exabiscompetences',
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'attachement' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_examples.attachement',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => '',	
				'disallowed' => 'php,php3',	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_exabiscompetences',
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'completefile' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_examples.completefile',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => '',	
				'disallowed' => 'php,php3',	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_exabiscompetences',
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'description' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_examples.description',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',	
				'rows' => '5',
			)
		),
		'taxid' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_examples.taxid',		
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('',0),
				),		
				'foreign_table' => 'tx_exabiscompetences_taxonomies',	
				'foreign_table_where' => 'ORDER BY tx_exabiscompetences_taxonomies.uid',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'timeframe' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_examples.timeframe',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'ressources' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_examples.ressources',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'tips' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_examples.tips',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'externalurl' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_examples.externalurl',		
			'config' => array (
				'type'     => 'input',
				'size'     => '15',
				'max'      => '255',
				'checkbox' => '',
				'eval'     => 'trim',
				'wizards'  => array(
					'_PADDING' => 2,
					'link'     => array(
						'type'         => 'popup',
						'title'        => 'Link',
						'icon'         => 'link_popup.gif',
						'script'       => 'browse_links.php?mode=wizard',
						'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
					)
				)
			)
		),
		'externalsolution' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_examples.externalsolution',		
			'config' => array (
				'type'     => 'input',
				'size'     => '15',
				'max'      => '255',
				'checkbox' => '',
				'eval'     => 'trim',
				'wizards'  => array(
					'_PADDING' => 2,
					'link'     => array(
						'type'         => 'popup',
						'title'        => 'Link',
						'icon'         => 'link_popup.gif',
						'script'       => 'browse_links.php?mode=wizard',
						'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
					)
				)
			)
		),
		'externaltask' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_examples.externaltask',		
			'config' => array (
				'type'     => 'input',
				'size'     => '15',
				'max'      => '255',
				'checkbox' => '',
				'eval'     => 'trim',
				'wizards'  => array(
					'_PADDING' => 2,
					'link'     => array(
						'type'         => 'popup',
						'title'        => 'Link',
						'icon'         => 'link_popup.gif',
						'script'       => 'browse_links.php?mode=wizard',
						'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
					)
				)
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, title;;;;2-2-2, descrid;;;;3-3-3, task, solution, attachement, completefile, description, taxid, timeframe, ressources, tips, externalurl, externalsolution, externaltask')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);



$TCA['tx_exabiscompetences_taxonomies'] = array (
	'ctrl' => $TCA['tx_exabiscompetences_taxonomies']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,title,parent_tax'
	),
	'feInterface' => $TCA['tx_exabiscompetences_taxonomies']['feInterface'],
	'columns' => array (
		'sys_language_uid' => array (		
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l10n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_exabiscompetences_taxonomies',
				'foreign_table_where' => 'AND tx_exabiscompetences_taxonomies.pid=###CURRENT_PID### AND tx_exabiscompetences_taxonomies.sys_language_uid IN (-1,0)',
			)
		),
		'l10n_diffsource' => array (		
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'title' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_taxonomies.title',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'parent_tax' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_taxonomies.parent_tax',		
			'config' => array (
				'type' => 'select',	
				'items' => array (
					array('',0),
				),
				'foreign_table' => 'tx_exabiscompetences_taxonomies',	
				'foreign_table_where' => 'ORDER BY tx_exabiscompetences_taxonomies.uid',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, title;;;;2-2-2, parent_tax;;;;3-3-3')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);


$TCA['tx_exabiscompetences_niveaus'] = array (
	'ctrl' => $TCA['tx_exabiscompetences_niveaus']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,title,levelcode,skillid'
	),
	'feInterface' => $TCA['tx_exabiscompetences_niveaus']['feInterface'],
	'columns' => array (
		'sys_language_uid' => array (		
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l10n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_exabiscompetences_niveaus',
				'foreign_table_where' => 'AND tx_exabiscompetences_niveaus.pid=###CURRENT_PID### AND tx_exabiscompetences_niveaus.sys_language_uid IN (-1,0)',
			)
		),
		'l10n_diffsource' => array (		
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'title' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_niveaus.title',		
			'config' => array (
				'type' => 'input',	
				'size' => '90',
			)
		),
		'parent_niveau' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_niveaus.parent_niveau',		
			'config' => array (
				'type' => 'select',	
				'items' => array (
					array('',0),
				),
				'foreign_table' => 'tx_exabiscompetences_niveaus',	
				'foreign_table_where' => 'ORDER BY title',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, parent_niveau;;;;2-2-2, title;;;;3-3-3')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);

$TCA['tx_exabiscompetences_niveau_texte'] = array (
	'ctrl' => $TCA['tx_exabiscompetences_niveau_texte']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,title,niveauid,skillid'
	),
	'feInterface' => $TCA['tx_exabiscompetences_niveau_texte']['feInterface'],
	'columns' => array (
		'sys_language_uid' => array (		
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l10n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_exabiscompetences_niveaus',
				'foreign_table_where' => 'AND tx_exabiscompetences_niveaus.pid=###CURRENT_PID### AND tx_exabiscompetences_niveaus.sys_language_uid IN (-1,0)',
			)
		),
		'l10n_diffsource' => array (		
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'title' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_niveau_texte.title',		
			'config' => array (
				'type' => 'text',
        'cols' => '100',    
        'rows' => '10',
			)
		),
		'niveauid' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_niveau_texte.niveauid',		
			'config' => array (
				'type' => 'select',	
				'items' => array (
					array('',0),
				),
				'foreign_table' => 'tx_exabiscompetences_niveaus',	
				'foreign_table_where' => 'ORDER BY tx_exabiscompetences_niveaus.sorting',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'skillid' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_niveau_texte.skillid',		
			'config' => array (
				'type' => 'select',	
				'items' => array (
					array('',0),
				),
				'foreign_table' => 'tx_exabiscompetences_skills',	
				'foreign_table_where' => 'ORDER BY title',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, niveauid;;;;2-2-2, skillid;;;;2-2-2, title;;;;3-3-3')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);

$TCA['tx_exabiscompetences_skills'] = array (
	'ctrl' => $TCA['tx_exabiscompetences_skills']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,title'
	),
	'feInterface' => $TCA['tx_exabiscompetences_skills']['feInterface'],
	'columns' => array (
		'sys_language_uid' => array (		
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l10n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_exabiscompetences_skills',
				'foreign_table_where' => 'AND tx_exabiscompetences_skills.pid=###CURRENT_PID### AND tx_exabiscompetences_skills.sys_language_uid IN (-1,0)',
			)
		),
		'l10n_diffsource' => array (		
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'title' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_skills.title',		
			'config' => array (
				'type' => 'input',	
				'size' => '48',	
				'eval' => 'required,trim',
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, title;;;;2-2-2')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>