<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_extMgm::allowTableOnStandardPages('tx_exabiscompetences_educationlevels');


t3lib_extMgm::addToInsertRecords('tx_exabiscompetences_educationlevels');

$TCA['tx_exabiscompetences_educationlevels'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_educationlevels',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l10n_parent',	
		'transOrigDiffSourceField' => 'l10n_diffsource',	
		'sortby' => 'sorting',	
		'enablecolumns' => array (		
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_exabiscompetences_educationlevels.gif',
	),
);


t3lib_extMgm::allowTableOnStandardPages('tx_exabiscompetences_schooltypes');


t3lib_extMgm::addToInsertRecords('tx_exabiscompetences_schooltypes');

$TCA['tx_exabiscompetences_schooltypes'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_schooltypes',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l10n_parent',	
		'transOrigDiffSourceField' => 'l10n_diffsource',	
		'sortby' => 'sorting',	
		'enablecolumns' => array (		
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_exabiscompetences_schooltypes.gif',
	),
);


t3lib_extMgm::allowTableOnStandardPages('tx_exabiscompetences_subjects');


t3lib_extMgm::addToInsertRecords('tx_exabiscompetences_subjects');

$TCA['tx_exabiscompetences_subjects'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_subjects',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l10n_parent',	
		'transOrigDiffSourceField' => 'l10n_diffsource',	
		'sortby' => 'sorting',	
		'enablecolumns' => array (		
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_exabiscompetences_subjects.gif',
	),
);


t3lib_extMgm::allowTableOnStandardPages('tx_exabiscompetences_topics');


t3lib_extMgm::addToInsertRecords('tx_exabiscompetences_topics');

$TCA['tx_exabiscompetences_topics'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_topics',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l10n_parent',	
		'transOrigDiffSourceField' => 'l10n_diffsource',	
		'sortby' => 'sorting',	
		'enablecolumns' => array (		
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_exabiscompetences_topics.gif',
	),
);


t3lib_extMgm::allowTableOnStandardPages('tx_exabiscompetences_descriptors');


t3lib_extMgm::addToInsertRecords('tx_exabiscompetences_descriptors');

$TCA['tx_exabiscompetences_descriptors'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_descriptors',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l10n_parent',	
		'transOrigDiffSourceField' => 'l10n_diffsource',	
		'sortby' => 'sorting',	
		'enablecolumns' => array (		
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_exabiscompetences_descriptors.gif',
	),
);


t3lib_extMgm::allowTableOnStandardPages('tx_exabiscompetences_examples');


t3lib_extMgm::addToInsertRecords('tx_exabiscompetences_examples');

$TCA['tx_exabiscompetences_examples'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_examples',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l10n_parent',	
		'transOrigDiffSourceField' => 'l10n_diffsource',	
		'sortby' => 'sorting',	
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_exabiscompetences_examples.gif',
	),
);


t3lib_extMgm::allowTableOnStandardPages('tx_exabiscompetences_taxonomies');


t3lib_extMgm::addToInsertRecords('tx_exabiscompetences_taxonomies');

$TCA['tx_exabiscompetences_taxonomies'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_taxonomies',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l10n_parent',	
		'transOrigDiffSourceField' => 'l10n_diffsource',	
		'sortby' => 'sorting',	
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_exabiscompetences_taxonomies.gif',
	),
);

t3lib_extMgm::allowTableOnStandardPages('tx_exabiscompetences_niveaus');


t3lib_extMgm::addToInsertRecords('tx_exabiscompetences_niveaus');

$TCA['tx_exabiscompetences_niveaus'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_niveaus',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l10n_parent',	
		'transOrigDiffSourceField' => 'l10n_diffsource',	
		'sortby' => 'sorting',	
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_exabiscompetences_niveaus.gif',
	),
);


t3lib_extMgm::allowTableOnStandardPages('tx_exabiscompetences_skills');

$TCA['tx_exabiscompetences_skills'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:exabis_competences/locallang_db.xml:tx_exabiscompetences_skills',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l10n_parent',	
		'transOrigDiffSourceField' => 'l10n_diffsource',	
		'sortby' => 'sorting',	
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_exabiscompetences_skills.gif',
	),
);


if (TYPO3_MODE == 'BE') {
	t3lib_extMgm::addModulePath('web_txexabiscompetencesM1', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');
		
	t3lib_extMgm::addModule('web', 'txexabiscompetencesM1', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');
}
?>