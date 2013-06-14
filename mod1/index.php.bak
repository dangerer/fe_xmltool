<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Dietmar Angerer <dangerer@gtn-solutions.com>
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
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */


$LANG->includeLLFile('EXT:exabis_competences/mod1/locallang.xml');
require_once(PATH_t3lib . 'class.t3lib_scbase.php');
$BE_USER->modAccess($MCONF,1);	// This checks permissions and exits if the users has no permission for entry.
	// DEFAULT initialization of a module [END]



/**
 * Module 'Competences' for the 'exabis_competences' extension.
 *
 * @author	Dietmar Angerer <dangerer@gtn-solutions.com>
 * @package	TYPO3
 * @subpackage	tx_exabiscompetences
 */
class  tx_exabiscompetences_module1 extends t3lib_SCbase {
				var $pageinfo;

				/**
				 * Initializes the Module
				 * @return	void
				 */
				function init()	{
					global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;

					parent::init();

					/*
					if (t3lib_div::_GP('clear_all_cache'))	{
						$this->include_once[] = PATH_t3lib.'class.t3lib_tcemain.php';
					}
					*/
				}

				/**
				 * Adds items to the ->MOD_MENU array. Used for the function menu selector.
				 *
				 * @return	void
				 */
				function menuConfig()	{
					global $LANG;
					$this->MOD_MENU = Array (
						'function' => Array (
							'1' => $LANG->getLL('function1'),
							'2' => $LANG->getLL('function2'),
							'3' => $LANG->getLL('function3'),
						)
					);
					parent::menuConfig();
				}

				/**
				 * Main function of the module. Write the content to $this->content
				 * If you chose "web" as main module, you will need to consider the $this->id parameter which will contain the uid-number of the page clicked in the page tree
				 *
				 * @return	[type]		...
				 */
				function main()	{
					global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;

					// Access check!
					// The page will show only if there is a valid page and if this page may be viewed by the user
					$this->pageinfo = t3lib_BEfunc::readPageAccess($this->id,$this->perms_clause);
					$access = is_array($this->pageinfo) ? 1 : 0;
				
					if (($this->id && $access) || ($BE_USER->user['admin'] && !$this->id))	{

							// Draw the header.
						$this->doc = t3lib_div::makeInstance('mediumDoc');
						$this->doc->backPath = $BACK_PATH;
						$this->doc->form='<form action="" method="post" enctype="multipart/form-data">';

							// JavaScript
						$this->doc->JScode = '
							<script language="javascript" type="text/javascript">
								script_ended = 0;
								function jumpToUrl(URL)	{
									document.location = URL;
								}
							</script>
						';
						$this->doc->postCode='
							<script language="javascript" type="text/javascript">
								script_ended = 1;
								if (top.fsMod) top.fsMod.recentIds["web"] = 0;
							</script>
						';

						//$headerSection = $this->doc->getHeader('pages',$this->pageinfo,$this->pageinfo['_thePath']).'<br />'.$LANG->sL('LLL:EXT:lang/locallang_core.xml:labels.path').': '.t3lib_div::fixed_lgd_pre($this->pageinfo['_thePath'],50);
						$headerSection = $this->doc->getHeader('pages',$this->pageinfo,$this->pageinfo['_thePath']).'<br />'.$LANG->sL('LLL:EXT:lang/locallang_core.xml:labels.path').': '.t3lib_div::fixed_lgd_cs($this->pageinfo['_thePath'], -50);


						$this->content.=$this->doc->startPage($LANG->getLL('title'));
						$this->content.=$this->doc->header($LANG->getLL('title'));
						$this->content.=$this->doc->spacer(5);
						$this->content.=$this->doc->section('',$this->doc->funcMenu($headerSection,t3lib_BEfunc::getFuncMenu($this->id,'SET[function]',$this->MOD_SETTINGS['function'],$this->MOD_MENU['function'])));
						$this->content.=$this->doc->divider(5);


						// Render content:
						$this->moduleContent();


						// ShortCut
						if ($BE_USER->mayMakeShortcut())	{
							$this->content.=$this->doc->spacer(20).$this->doc->section('',$this->doc->makeShortcutIcon('id',implode(',',array_keys($this->MOD_MENU)),$this->MCONF['name']));
						}

						$this->content.=$this->doc->spacer(10);
					} else {
							// If no access or if ID == zero

						$this->doc = t3lib_div::makeInstance('mediumDoc');
						$this->doc->backPath = $BACK_PATH;

						$this->content.=$this->doc->startPage($LANG->getLL('title'));
						$this->content.=$this->doc->header($LANG->getLL('title'));
						$this->content.=$this->doc->spacer(5);
						$this->content.=$this->doc->spacer(10);
					}
				
				}

				/**
				 * Prints out the module HTML
				 *
				 * @return	void
				 */
				function printContent()	{

					$this->content.=$this->doc->endPage();
					echo $this->content;
				}

				/**
				 * Generates the module content
				 *
				 * @return	void
				 */
				 function createXmlFile($content, $filename){
						require_once (PATH_t3lib . 'class.t3lib_basicfilefunc.php');
						/*$fileFunc = t3lib_div::makeInstance('t3lib_basicFileFunctions');
						$all_files = Array();
						$all_files['webspace']['allow'] = '*';
						$all_files['webspace']['deny'] = '';
						$fileFunc->init('', $all_files);*/
						$theDestFile = t3lib_div::getFileAbsFileName('uploads/tx_exabiscompetences/'.$filename);
						
						$fh = fopen($theDestFile, 'w');
						fwrite($fh, $content);
						fclose($fh);
						return $theDestFile;
				}
	
				 function get_sql($t3tabl,$mdltbl,$fields,$fieldsmdl,$path_uploadfolder,$WHERE="1=1",$dateien="initial"){
				 	
				 	$fieldlst=implode(",",$fields);
				 	$fieldlstmdl=implode(",",$fieldsmdl);
				 	
				 	$dateiliste=explode(",",$dateien);
				 	$fieldlstmdl=str_replace("uid,","id,",$fieldlstmdl);
				 	
				 	$sql='SELECT '.$fieldlst.' FROM '.$t3tabl.' WHERE '.$WHERE;
				 	//echo $sql."<br>";
				 
					if ($t3tabl=="tx_exabiscompetences_descriptors_topicid_mm"){
						/*echo $sql;
						echo "--".$fields[0]."--".$fields[1];
				 		echo "--".$fieldsmdl[0]."--".$fieldsmdl[1]."<br>";*/
					}
				 	$result=mysql_query($sql);
				 	$sqlstr='$q=\'DELETE FROM '.$mdltbl.'\';$db->Execute($q);<br>';
				 	
				 	while ($rs=mysql_fetch_assoc($result)){
				 		
				 		$valuelst='"'.htmlentities(implode('","',$rs)).'"';
				 		//echo $valuelst."<br>";
				 		$sqlstr.='$q=\'INSERT INTO '.$mdltbl.' ('.$fieldlstmdl.') VALUES ('.$valuelst.')\';$db->Execute($q);<br>';
				 		//echo $sqlstr."<br>";
				 		$sqlxml.='	<table name="'.$mdltbl.'">'."\n";
				 		$zae=0;
				 		foreach ($fieldsmdl as $field){
				 			$wert="";
				 			if (in_array($field,$dateiliste)){
				 				if ($rs[$field]!=""){
					 				$wert=$path_uploadfolder.$rs[$fields[$zae]];
					 			}
				 			}else{
				 				$wert=$rs[$fields[$zae]];
				 			}
					 		$sqlxml.='		<'.$field.'>'.(str_replace("&","&amp;",$wert)).'</'.$field.'>'."\n";
					 		$zae++;
					 	}
					 	$sqlxml.='	</table>'."\n";
				 	} 
				 	
				 	return $sqlxml;
				 }
				function moduleContent()	{
					$domain = $_SERVER['HTTP_HOST'];
					if ($domain=="localhost"){
						$path_uploadfolder='http://'.$domain.'/kalendarium/uploads/tx_exabiscompetences/';
					}else{
						$path_uploadfolder='http://'.$domain.'/uploads/tx_exabiscompetences/';
					}
					switch((string)$this->MOD_SETTINGS['function'])	{
						
						case 1:
						$content_pd='
						<form method="post">
						<select name="pd_subjects[]" size=10 multiple>
						<option value="0">-- ALLE ANZEIGEN --</option>
						';
						
						// damit group_concat ergebnisse nicht bei 1024 zeichen abgeschnitten werden
						mysql_query('SET @@group_concat_max_len := @@max_allowed_packet');
						
						
						$sql="SELECT * FROM tx_exabiscompetences_subjects";
						$result=mysql_query($sql);
				 	
				 		while ($rs=mysql_fetch_assoc($result)){
				 			$content_pd.='<option value="'.$rs["uid"].'"';
				 			if (in_array($rs["uid"],$_POST["pd_subjects"])) {
				 				$content_pd.=' selected="selected"';
				 				$filename_zusatz.=",".$rs["title"]."";
				 			}
				 			
				 			$content_pd.='>'.$rs["title"].'</option>';
				 		}
				 		
				 		$filename_zusatz=preg_replace('/^,/','',$filename_zusatz);
				 		$filename_zusatz="(".$filename_zusatz.")";
				 		
						$content_pd.='</select><input type="submit">
						</form>
						';
						
						if (empty($_POST["pd_subjects"]) OR $_POST["pd_subjects"]=="0") $subject_filter=0;
						elseif (is_array($_POST["pd_subjects"]) && $_POST["pd_subjects"][0]=="0") $subject_filter=0;
						else {
							$subject_filter=1;
							$subject_filter_arr=$_POST["pd_subjects"];
							$subject_filter_str=implode(",",$_POST["pd_subjects"]);
						}

						//$subject_filter=intval($_POST["pd_subjects"],0);
						$WHERE="1=1";
						
						if ($subject_filter_str=="12"){
							$tablepref="block_desp_";
						}else{
							$tablepref="block_exacomp";
						}
						$strxml.='<?xml version="1.0" encoding="utf-8"?>'."\n";
						$strxml.='<exabis_competences_tables>'."\n";
						$fields=array();
						
						//--------------------educationlevel
						$fields[]="uid";$fields[]="title";$fields[]="sorting";
						$strxml.=$this->get_sql("tx_exabiscompetences_educationlevels",$tablepref."edulevels",$fields,$fields,$path_uploadfolder,$WHERE);
						
						//---------------------schooltype
						$fields=array();
						$fields[]="uid";$fields[]="title";$fields[]="elid";$fields[]="sorting";
						$strxml.=$this->get_sql("tx_exabiscompetences_schooltypes",$tablepref."schooltypes",$fields,$fields,$path_uploadfolder,$WHERE);
						
						//----------------------subject
						$fields=array();
						$fields[]="uid";$fields[]="title";$fields[]="stid";$fields[]="sorting";
						
						if ($subject_filter>0){
							$WHERE=" uid IN (".$subject_filter_str.")";
						}
						$strxml.=$this->get_sql("tx_exabiscompetences_subjects",$tablepref."subjects",$fields,$fields,$path_uploadfolder,$WHERE);
						$WHERE="1=1";
						
						//----------------------topic
						$fields=array();
						$fields[]="uid";$fields[]="title";$fields[]="subjid";$fields[]="sorting";
						if ($subject_filter>0){
							$WHERE=" subjid IN (".$subject_filter_str.")";
							$sql="select group_concat(cast(uid_local as char)) as ids FROM tx_exabiscompetences_descriptors_topicid_mm mm INNER JOIN tx_exabiscompetences_topics topic ON  topic.uid=mm.uid_foreign WHERE topic.subjid IN (".$subject_filter_str.") ORDER BY ids";
							//echo $sql;
							$result=mysql_query($sql);
							$rs_descr=mysql_fetch_array($result);
						}
						$strxml.=$this->get_sql("tx_exabiscompetences_topics",$tablepref."topics",$fields,$fields,$path_uploadfolder,$WHERE);
						$WHERE="1=1";
						
						//----------------------descriptor
						$fields=array();
						$fields[]="uid";$fields[]="title";$fields[]="niveauid";$fields[]="sorting";$fields[]="skillid";$fields[]="parent_id";
						if ($subject_filter>0){
							$WHERE=" uid IN (".$rs_descr["ids"].")";
							//$sql="select group_concat(cast(uid_local as char)) as ids FROM tx_exabiscompetences_examples_descrid_mm mm INNER JOIN tx_exabiscompetences_examples ex ON ex.uid=mm.uid_foreign WHERE mm.uid_foreign IN (".$rs_descr["ids"].")";
							$sql="select group_concat(cast(uid_local as BINARY)) as ids FROM tx_exabiscompetences_examples_descrid_mm mm WHERE mm.uid_foreign IN (".$rs_descr["ids"].")";
							
							//echo $sql;
							$result=mysql_query($sql);
							$rs_ex=mysql_fetch_array($result);
						}
						$strxml.=$this->get_sql("tx_exabiscompetences_descriptors",$tablepref."descriptors",$fields,$fields,$path_uploadfolder,$WHERE);
						$WHERE="1=1";
						
						//----------------------examples
						$fields=array();
						$fields[]="uid";$fields[]="title";$fields[]="task";$fields[]="sorting";$fields[]="solution";
						$fields[]="attachement";$fields[]="completefile";$fields[]="description";
						$fields[]="taxid";$fields[]="timeframe";$fields[]="ressources";$fields[]="tips";
						$fields[]="externalurl";$fields[]="externalsolution";$fields[]="externaltask";
						$dateien='task,solution,attachement,completefile';
						if ($subject_filter>0){
							$WHERE=" uid IN (".$rs_ex["ids"].")";
							//$sql="select group_concat(cast(ta.uid as char)) as ids FROM tx_exabiscompetences_examples ex INNER JOIN tx_exabiscompetences_taxonomies ta ON ta.uid=ex.taxid WHERE ex.uid IN (".$rs_descr["ids"].")";
							//$result=mysql_query($sql);
							//$rs_ta=mysql_fetch_array($result);
						}
						$strxml.=$this->get_sql("tx_exabiscompetences_examples",$tablepref."examples",$fields,$fields,$path_uploadfolder,$WHERE,$dateien);
						$WHERE="1=1";
						
						//--------------------taxonomies
						$fields=array();
						$fields[]="uid";$fields[]="title";$fields[]="sorting";$fields[]="parent_tax";
						if ($subject_filter>0){
							//$WHERE=" uid IN (".$rs_ta["ids"].")";
							$sql="select group_concat(cast(sk.uid as char)) as ids FROM tx_exabiscompetences_descriptors de INNER JOIN tx_exabiscompetences_skills sk ON sk.uid=de.skillid WHERE de.uid IN (".$rs_descr["ids"].")";
							//echo $sql;
							$result=mysql_query($sql);
							$rs_sk=mysql_fetch_array($result);
						}
						$strxml.=$this->get_sql("tx_exabiscompetences_taxonomies",$tablepref."taxonomies",$fields,$fields,$path_uploadfolder,$WHERE);
						$WHERE="1=1";
						
						//----------------------skills
						$fields=array();
						$fields[]="uid";$fields[]="title";$fields[]="sorting";
						if ($subject_filter>0){
							$WHERE=" uid IN (".$rs_sk["ids"].")";
							$sql="select distinct group_concat(cast(niv.uid as char)) as ids FROM tx_exabiscompetences_descriptors de INNER JOIN tx_exabiscompetences_niveaus niv ON niv.uid=de.niveauid WHERE de.uid IN (".$rs_descr["ids"].")";
							//echo $sql;
							$result=mysql_query($sql);
							$rs_niv=mysql_fetch_array($result);
						}
						$strxml.=$this->get_sql("tx_exabiscompetences_skills",$tablepref."skills",$fields,$fields,$path_uploadfolder,$WHERE);
						$WHERE="1=1";
						
						//----------------------niveaus
						$fields=array();
						$fields[]="uid";$fields[]="title";$fields[]="parent_niveau";$fields[]="sorting";
						if ($subject_filter>0){
							//auskommentiert, alle niveaus nehmen, sonst sind parent niveaus nicht drinnen $WHERE=" uid IN (".$rs_niv["ids"].")";
							
							
							/*$sql="select group_concat(cast(sk.uid as char)) as ids FROM tx_exabiscompetences_descriptors de INNER JOIN tx_exabiscompetences_skills sk ON sk.uid=de.skillid WHERE de.uid IN (".$rs_descr["ids"].")";
							$result=mysql_query($sql);
							$rs_sk=mysql_fetch_array($result);*/
						}
						$strxml.=$this->get_sql("tx_exabiscompetences_niveaus",$tablepref."niveaus",$fields,$fields,$path_uploadfolder,$WHERE);
						$WHERE="1=1";
						
						//----------------------niveaus_text
						$fields=array();
						$fields[]="uid";$fields[]="title";$fields[]="niveauid";$fields[]="skillid";
						if ($subject_filter>0){
							//auskommentiert, alle niveaus nehmen, sonst sind parent niveaus nicht drinnen $WHERE=" uid IN (".$rs_niv["ids"].")";
							
							
							/*$sql="select group_concat(cast(sk.uid as char)) as ids FROM tx_exabiscompetences_descriptors de INNER JOIN tx_exabiscompetences_skills sk ON sk.uid=de.skillid WHERE de.uid IN (".$rs_descr["ids"].")";
							$result=mysql_query($sql);
							$rs_sk=mysql_fetch_array($result);*/
						}
						$strxml.=$this->get_sql("tx_exabiscompetences_niveau_texte",$tablepref."niveau_texte",$fields,$fields,$path_uploadfolder,$WHERE);
						$WHERE="1=1";
						
						//---------------------------- topics
						$fields=array();$fieldsmdl=array();
						$fields[]="uid_local";$fields[]="uid_foreign";
						$fieldsmdl[]="descrid";$fieldsmdl[]="topicid";
						if ($subject_filter>0){
							$WHERE=" uid_local IN (".$rs_descr["ids"].")";
						}
						$strxml.=$this->get_sql("tx_exabiscompetences_descriptors_topicid_mm",$tablepref."descrtopic_mm",$fields,$fieldsmdl,$path_uploadfolder,$WHERE);
						$WHERE="1=1";
						
						//--------------------------- examples 
						$fields=array();$fieldsmdl=array();
						$fields[]="uid_local";$fields[]="uid_foreign";
						$fieldsmdl[]="exampid";$fieldsmdl[]="descrid";
						if ($subject_filter>0){
							$WHERE=" uid_foreign IN (".$rs_descr["ids"].")";
						}
						$strxml.=$this->get_sql("tx_exabiscompetences_examples_descrid_mm",$tablepref."descrexamp_mm",$fields,$fieldsmdl,$path_uploadfolder,$WHERE);
						$WHERE="1=1";
						
						$strxml.='</exabis_competences_tables>'."\n";
						if ($subject_filter_str=="12") {$filename="desp_data.xml";}
						else if ($subject_filter>0){ $filename="exacomp_data_".str_replace(",","_",$subject_filter_str).".xml";}
						else {$filename="exacomp_data.xml";}
						
						$erg=$this->createXmlFile($strxml,$filename);
						//$link=t3lib_div::getIndpEnv('REQUEST_URI');
						//$content.=$link;
						
						//$content.=$domain;
						
						$content.='
						
						
						<p style="font-size:12px;margin-top:20px;"><b>Download XML-Datei</b>'.$filename_zusatz.': <br><a style="text-decoration:underline;line-height:30px;" target="_blank" href="'.$path_uploadfolder.$filename.'">'.$filename.'</a></p>
						<h4 style="margin-top:15px;">Exportdatei Filter</h4>
						<p>'.$content_pd.'</p>
						
						
						';
						
						
						
						
							
							$this->content.=$this->doc->section('Bildungsstandards Export:',$content,0,1);
						break;
						case 2:
							$content='<div align=center><strong>Menu item #2...</strong></div>';
							$this->content.=$this->doc->section('Message #2:',$content,0,1);
						break;
						case 3:
							$content='<div align=center><strong>Menu item #3...</strong></div>';
							$this->content.=$this->doc->section('Message #3:',$content,0,1);
						break;
					}
				}
				
		}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/exabis_competences/mod1/index.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/exabis_competences/mod1/index.php']);
}




// Make instance:
$SOBE = t3lib_div::makeInstance('tx_exabiscompetences_module1');
$SOBE->init();

// Include files?
foreach($SOBE->include_once as $INC_FILE)	include_once($INC_FILE);

$SOBE->main();
$SOBE->printContent();

?>