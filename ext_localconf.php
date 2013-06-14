<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_exabiscompetences_educationlevels=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_exabiscompetences_schooltypes=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_exabiscompetences_subjects=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_exabiscompetences_topics=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_exabiscompetences_descriptors=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_exabiscompetences_examples=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_exabiscompetences_taxonomies=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_exabiscompetences_skills=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_exabiscompetences_desp_lang=1
');
t3lib_extMgm::addPItoST43($_EXTKEY, 'pi1/class.tx_exabiscompetences_pi1.php', '_pi1', 'list_type', 0);

$TYPO3_CONF_VARS['FE']['eID_include']['sortupdate'] = 'EXT:exabis_competences/pi1/updatesorting.php';
?>