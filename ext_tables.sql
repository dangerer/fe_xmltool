#
# Table structure for table 'tx_exabiscompetences_educationlevels'
#
CREATE TABLE tx_exabiscompetences_educationlevels (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumtext,
	sorting int(10) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	title tinytext,
	fe_owner int(11) DEFAULT '0' NULL,
	fe_creator int(11) DEFAULT '0' NULL,
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_exabiscompetences_schooltypes'
#
CREATE TABLE tx_exabiscompetences_schooltypes (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumtext,
	sorting int(10) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	title tinytext,
	elid int(11) DEFAULT '0' NOT NULL,
	fe_owner int(11) DEFAULT '0' NULL,
	fe_creator int(11) DEFAULT '0' NULL,
	isoez int(1) DEFAULT '0' NULL,
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_exabiscompetences_subjects'
#
CREATE TABLE tx_exabiscompetences_subjects (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumtext,
	sorting int(10) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	title tinytext,
	stid int(11) DEFAULT '0' NOT NULL,
	fe_owner int(11) DEFAULT '0' NULL,
	fe_creator int(11) DEFAULT '0' NULL,
	titleshort varchar(200) DEFAULT '' NOT NULL,
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_exabiscompetences_topics'
#
CREATE TABLE tx_exabiscompetences_topics (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumtext,
	sorting int(10) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	title tinytext,
	subjid int(11) DEFAULT '0' NOT NULL,
	fe_owner int(11) DEFAULT '0' NULL,
	fe_creator int(11) DEFAULT '0' NULL,
	description mediumtext,
	titleshort varchar(200) DEFAULT '' NOT NULL,
	PRIMARY KEY (uid),
	KEY parent (pid)
);




#
# Table structure for table 'tx_exabiscompetences_descriptors_topicid_mm'
# 
#
CREATE TABLE tx_exabiscompetences_descriptors_topicid_mm (
  uid_local int(11) DEFAULT '0' NOT NULL,
  uid_foreign int(11) DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting int(11) DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_exabiscompetences_descriptors'
#
CREATE TABLE tx_exabiscompetences_descriptors (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumtext,
	sorting int(10) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	title text,
	topicid int(11) DEFAULT '0' NOT NULL,
	exampleid int(11) DEFAULT '0' NOT NULL,
	parent_id int(11) DEFAULT '0' NOT NULL,
	niveauid int(11) DEFAULT '0' NOT NULL,
	skillid int(11) DEFAULT '0' NOT NULL,
	fe_owner int(11) DEFAULT '0' NULL,
	fe_creator int(11) DEFAULT '0' NULL,
	PRIMARY KEY (uid),
	KEY parent (pid)
);




#
# Table structure for table 'tx_exabiscompetences_examples_descrid_mm'
# 
#
CREATE TABLE tx_exabiscompetences_examples_descrid_mm (
  uid_local int(11) DEFAULT '0' NOT NULL,
  uid_foreign int(11) DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting int(11) DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_exabiscompetences_examples'
#
CREATE TABLE tx_exabiscompetences_examples (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumtext,
	sorting int(10) DEFAULT '0' NOT NULL,
	title tinytext,
	descrid int(11) DEFAULT '0' NOT NULL,
	task text,
	solution text,
	attachement text,
	completefile text,
	description text,
	taxid int(11) DEFAULT '0' NOT NULL,
	timeframe tinytext,
	ressources tinytext,
	tips tinytext,
	externalurl tinytext,
	externalsolution tinytext,
	externaltask tinytext,
	fe_owner int(11) DEFAULT '0' NULL,
	fe_creator int(11) DEFAULT '0' NULL,
	lang int(11) DEFAULT '0' NOT NULL,
	titleshort varchar(200) DEFAULT '' NOT NULL,
	iseditable int(1) DEFAULT '0' NULL,
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_exabiscompetences_taxonomies'
#
CREATE TABLE tx_exabiscompetences_taxonomies (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumtext,
	sorting int(10) DEFAULT '0' NOT NULL,
	title text,
	parent_tax int(11) DEFAULT '0' NOT NULL,
	fe_owner int(11) DEFAULT '0' NULL,
	fe_creator int(11) DEFAULT '0' NULL,
	PRIMARY KEY (uid),
	KEY parent (pid)
);



CREATE TABLE tx_exabiscompetences_niveaus (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumtext,
	title varchar(20) DEFAULT '' NOT NULL,
	parent_niveau int(11) DEFAULT '0' NOT NULL,
	sorting int(10) DEFAULT '0' NOT NULL,
		fe_owner int(11) DEFAULT '0' NULL,
	fe_creator int(11) DEFAULT '0' NULL,
	PRIMARY KEY (uid),
	KEY parent (pid)
	
);



CREATE TABLE tx_exabiscompetences_niveau_texte (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumtext,
	sorting int(10) DEFAULT '0' NOT NULL,
	niveauid varchar(3) DEFAULT '' NOT NULL,
	skillid int(11) DEFAULT '0' NOT NULL,
	title text,
		fe_owner int(11) DEFAULT '0' NULL,
	fe_creator int(11) DEFAULT '0' NULL,
	PRIMARY KEY (uid),
	KEY parent (pid)
);

#
# Table structure for table 'tx_exabiscompetences_skills'
#
CREATE TABLE tx_exabiscompetences_skills (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumtext,
	sorting int(10) DEFAULT '0' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	title_en varchar(255) DEFAULT '' NOT NULL,
	fe_owner int(11) DEFAULT '0' NULL,
	fe_creator int(11) DEFAULT '0' NULL,
	PRIMARY KEY (uid),
	KEY parent (pid)
);

CREATE TABLE tx_exabiscompetences_desp_lang (
	uid int(11) NOT NULL auto_increment,
	name text NOT NULL,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumtext,
	sorting int(10) DEFAULT '0' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	fe_owner int(11) DEFAULT '0' NULL,
	fe_creator int(11) DEFAULT '0' NULL,
	PRIMARY KEY (uid),
	KEY parent (pid)
);

CREATE TABLE tx_exabiscompetences_settings (
	uid int(11) NOT NULL auto_increment,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	showall int(1) DEFAULT '1' NOT NULL,
	fe_user int(11) DEFAULT '0' NULL,
	fe_creator int(11) DEFAULT '0' NULL,
	PRIMARY KEY (uid),
	KEY parent (fe_user)
);