<?php
require_once(PATH_tslib.'class.tslib_pibase.php');
require_once(PATH_t3lib."class.t3lib_basicfilefunc.php");

/*
leere daten löschen loeschen titel leer
SELECT group_concat(cast(el.uid as ids)) from tx_exabiscompetences_educationlevels el LEFT JOIN 
tx_exabiscompetences_schooltypes st ON el.uid=st.elid
where el.title="" and isnull(st.uid)

SELECT group_concat(cast(el.uid as char)) as ids from tx_exabiscompetences_educationlevels el LEFT JOIN 
tx_exabiscompetences_schooltypes st ON el.uid=st.elid
where el.title="" and isnull(st.uid)

SELECT group_concat(cast(top.uid as binary)) as ids from tx_exabiscompetences_topics top LEFT JOIN 
tx_exabiscompetences_descriptors_topicid_mm mm ON top.uid=mm.uid_foreign
where top.title="" and isnull(mm.uid_foreign)

SELECT group_concat(cast(descr.uid as binary)) as ids from tx_exabiscompetences_descriptors descr LEFT JOIN 
tx_exabiscompetences_examples_descrid_mm mm ON descr.uid=mm.uid_foreign
where descr.title="" and isnull(mm.uid_foreign)

SELECT group_concat(cast(ex.uid as binary)) as ids from tx_exabiscompetences_examples ex LEFT JOIN 
tx_exabiscompetences_examples_descrid_mm mm ON ex.uid=mm.uid_local
where ex.title="" and isnull(mm.uid_local)

*/
/**
 * Plugin 'Competencies' for the 'exabis_competences' extension.
 *
 * @author	Dietmar Angerer <dangerer@gtn-solutions.com>
 * @package	TYPO3
 * @subpackage	tx_exabiscompetences
 */
class tx_exabiscompetences_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_exabiscompetences_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_exabiscompetences_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'exabis_competences';	// The extension key.
	var $f,$f2;
	var $lastsort=0;
	var $bildpfad;
	var $languageid=0;
	var $langcode="";
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		//t3lib_div::debug($this->piVars);
		$this->f="";
		$this->f2="";
		$this->bildpfad="uploads/tx_exabiscompetences";
		if (intval(t3lib_div::_GP("L"))>0) $this->languageid=intval(t3lib_div::_GP("L"));
		if ($_GET["L"]==1) $this->langcode="_en";
		$showallwhere="";$showallwhere2="";
		$sql5="SET @@group_concat_max_len = 5012";
						mysql_query ($sql5);
		/*if (intval(t3lib_div::_GP("conv"))>0){
			$tbl1="tx_exabiscompetences_topics";
			$sql="SELECT * FROM ".$tbl1;
			$result=mysql_query($sql);
			while ($rs=mysql_fetch_array($result)){
				$conv_str = mb_convert_encoding($rs["description"], 'windows-1252', 'utf-8');
				
				$sql="UPDATE ".$tbl1." SET description='".$conv_str."' WHERE uid=".$rs["uid"];
				mysql_query($sql);
			}		
			echo "fertig";die;
		}*/
		if (intval(t3lib_div::_GP("f"))>0) $this->f=intval(t3lib_div::_GP("f"));if (intval(t3lib_div::_GP("f2"))>0) $this->f2=intval(t3lib_div::_GP("f2"));
		if ($this->piVars["pd_flt"]!="") {$this->f=intval($this->piVars["pd_flt"]);}
		else if ($this->piVars["f"]!="") {$this->f=intval($this->piVars["f"]);}
		if ($this->piVars["pd_flt2"]!="") {$this->f2=intval($this->piVars["pd_flt2"]);}
		else if ($this->piVars["f2"]!="") {$this->f2=intval($this->piVars["f2"]);}
		
		$this->pi_USER_INT_obj = 1;	// Configuring so caching is not expected. This value means that no cHash params are ever set. We do this, because it's a USER_INT object!
		if ($GLOBALS["TSFE"]->fe_user->user["uid"]=="") return "bitte anmelden";
		$inhalt='
		<div class="top"><h1>'.$this->pi_getLL("bs_erfassungstool").'</h1></div>
		<div class="gtnlogo">
<a id="gtnlogoa" target="_blank" href="http://www.gtn-solutions.com"></a>
</div>
		<div class="navidiv">
		<ul class="nav">';
		
			if ($this->conf["HideTabEdulevelForUser"]==1 && !$this->has_capability("admin")){ }
			else{
				$inhalt.='<li id="tx_exacomp_tab_edulevel"><a href="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>"edulev")).'">'.$this->pi_getLL("Schulstufen","schulstufen").'</a></li>';
			}
			$inhalt.='<li id="tx_exacomp_tab_schoolt"><a href="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>"schoolt")).'">'.$this->pi_getLL("Schultypen").'</a></li>
			<li id="tx_exacomp_tab_subj"><a href="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>"subj")).'">'.$this->pi_getLL("Gegenstaende").'</a></li>
			<li id="tx_exacomp_tab_topic"><a href="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>"topic","f"=>$this->f)).'">'.$this->pi_getLL("Themen").'</a></li>
			<li id="tx_exacomp_tab_descr"><a href="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>"descr","f"=>$this->f,"f2"=>$this->f2)).'">'.$this->pi_getLL("Deskriptoren").'</a></li>
			<li id="tx_exacomp_tab_examp"><a href="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>"examp","f"=>$this->f,"f2"=>$this->f2)).'">'.$this->pi_getLL("Beispiele").'</a></li>
			<li id="tx_exacomp_tab_export"><a href="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>"export")).'">'.$this->pi_getLL("Export").'</a></li>';
		if ($GLOBALS["TSFE"]->fe_user->user["uid"]==1){
				$inhalt.='<li><a href="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>"dataerrors")).'">Dateninkonsistenzen</a></li>';
		}
		if ($this->conf["HideTabSettingsForUser"]==1 && !$this->has_capability("admin")){ }
		else{
			$inhalt.='<li><a href="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>"set")).'">'.$this->pi_getLL("Einstellungen").'</a></li>';
		}
		$inhalt.='
		</ul></div><div class="contentdiv">';
		$art=0;
		/*
		update `tx_exabiscompetences_educationlevels` set fe_owner=1;
		update `tx_exabiscompetences_educationlevels` set fe_creator=1;
		
		update `tx_exabiscompetences_schooltypes` set fe_owner=1;
		update `tx_exabiscompetences_schooltypes` set fe_creator=1;
		
		update `tx_exabiscompetences_subjects` set fe_owner=1;
		update `tx_exabiscompetences_subjects` set fe_creator=1;
		
		update `tx_exabiscompetences_educationlevels` set fe_owner=1;
		update `tx_exabiscompetences_educationlevels` set fe_creator=1;
		
		update `tx_exabiscompetences_topics` set fe_owner=1;
		update `tx_exabiscompetences_topics` set fe_creator=1;
		
		update `tx_exabiscompetences_descriptors` set fe_owner=1;
		update `tx_exabiscompetences_descriptors` set fe_creator=1;
		
			update `tx_exabiscompetences_examples` set fe_owner=1;
		update `tx_exabiscompetences_examples` set fe_creator=1;
		*/
		
		
		
		if (t3lib_div::_GP("b")=="edulev" || t3lib_div::_GP("b")=="") {
			$art=1;$tablename="tx_exabiscompetences_educationlevels";$header=$this->pi_getLL("Schulstufen").' '.$this->pi_getLL("editieren");$fegruppe="educationlevel";$desp_edit_title2="desp_edit_title";
		}else if(t3lib_div::_GP("b")=="schoolt"){
			$art=1;$tablename="tx_exabiscompetences_schooltypes";$header=$this->pi_getLL("Schultypen").' '.$this->pi_getLL("editieren");$fegruppe="schooltype";$tablename_pd="tx_exabiscompetences_educationlevels";$desp_edit_title2="desp_edit_title";
		}else if(t3lib_div::_GP("b")=="subj"){
			$art=1;$tablename="tx_exabiscompetences_subjects";$header=$this->pi_getLL("Gegenstaende").' '.$this->pi_getLL("editieren");$fegruppe="subject";$tablename_pd="tx_exabiscompetences_schooltypes";$desp_edit_title2="desp_edit_title";
		}else if(t3lib_div::_GP("b")=="topic"){
			$art=1;$tablename="tx_exabiscompetences_topics";$header=$this->pi_getLL("Themen").' '.$this->pi_getLL("editieren");$fegruppe="topic";$tablename_pd="tx_exabiscompetences_subjects";$desp_edit_title2="desp_edit_title";$desp_edit_title2="desp_edit_topic";
		}else if(t3lib_div::_GP("b")=="descr"){
			$art=1;$tablename="tx_exabiscompetences_descriptors";$header=$this->pi_getLL("Deskriptoren").' '.$this->pi_getLL("editieren");$fegruppe="descriptor";$tablename_pd="tx_exabiscompetences_topics";$desp_edit_title2="desp_edit_descr";
		}else if(t3lib_div::_GP("b")=="examp"){
			$art=1;$tablename="tx_exabiscompetences_examples";$header=$this->pi_getLL("Beispiele").' '.$this->pi_getLL("editieren");$fegruppe="examples";$tablename_pd="tx_exabiscompetences_descriptors";$desp_edit_title2="desp_edit_examp";
		}
		
		if(!empty($this->piVars["getowner"])){
			foreach($this->piVars["getowner"] as $key=>$value){
				$this->getownership($tablename,intval($key));
			}
		}
		$inhalt.='<div class="contentwrapper">';
		if ($art>0){
			
			$inhalt.='<h1 class="headerb">'.$header.'</h1>';
			$inhalt.=$this->showhilfe(t3lib_div::_GP("b"),1);
			/*if (t3lib_div::_GP("b")=="schoolt"){
				if ($this->piVars["pd_edulevel"]!="") $wert=intval($this->piVars["pd_edulevel"]);
				else $wert="";
				$inhalt.='<form action="" method="post" name="formular">';
				$inhalt.=$this->create_pulldown($tablename,"pd_edulevel","title",$wert,true,"","uid","","uid",'onchange="formular.submit();"',$ka_wert=$this->pi_getLL("bitte_Auswahl_treffen"),$joint="",$sqlu="");
				$inhalt.='</form>';
			}*/
			$datenok=true;
			if (t3lib_div::_GP("a")=="s"){
				if ($this->piVars["title"]=="") $datenok=false;
				if ($this->piVars["pd_edulevel"]=="0" && t3lib_div::_GP("b")=="schoolt") {$datenok=false;}
				else if ($this->piVars["pd_subject"]=="0" && t3lib_div::_GP("b")=="subj") {$datenok=false;}
				else if ($this->piVars["pd_topic"]=="0" && t3lib_div::_GP("b")=="topic") {$datenok=false;}
				else if (t3lib_div::_GP("b")=="descr") {
					if (empty($this->piVars["pd_topic"]))$datenok=false;
					else if(is_array($this->piVars["pd_topic"]) && count($this->piVars["pd_topic"])==1 && $this->piVars["pd_topic"][0]==0) $datenok=false;
				}
			}
			if (!$this->checked_show_all()) {
					$showallwhere=" WHERE fe_creator=".$GLOBALS["TSFE"]->fe_user->user["uid"]; 
					$showallwhere2=" AND fe_creator=".$GLOBALS["TSFE"]->fe_user->user["uid"];
				}else{
					$showallwhere=" WHERE (fe_creator=".$GLOBALS["TSFE"]->fe_user->user["uid"]." OR fe_owner=1)"; 
					$showallwhere2=" AND (fe_creator=".$GLOBALS["TSFE"]->fe_user->user["uid"]." OR fe_owner=1)";
				}
				
			if (t3lib_div::_GP("a")=="c"){
				$id=intval(t3lib_div::_GP("recid"));
				$tdata=$this->get_table_data($tablename,$id);
				if ($this->piVars["abbrechen"]!=""){
					$inhalt.=$this->makelist($tablename,$fegruppe);
				}else{
					$inhalt.='<form name="formular" enctype="multipart/form-data" method="post" action="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>t3lib_div::_GP("b"),"a" => "c","recid" => $id)).'">';
					if ($this->piVars["kopieren"]!=""){
						$destinationstid=intval($this->piVars["subj2copy"]);
						$sourcedata=$this->get_table_data("tx_exabiscompetences_subjects",$id);
						
						$idnew=$this->new_rec($tablename,array("title" => $sourcedata["title"]." ".$this->pi_getLL("Kopie"),"stid" => $destinationstid,"fe_owner"=>$GLOBALS["TSFE"]->fe_user->user["uid"],"fe_creator"=>$GLOBALS["TSFE"]->fe_user->user["uid"],"crdate"=>time(),"tstamp"=>time(),"sorting"=>$sourcedata["sorting"],"pid"=>$this->conf["pid_data"]));
						$idnew;
						$topics=$this->get_related_topic_ids($sourcedata["uid"]);
						
						if (!empty($topics)){
							$newtopics=$this->copytopic($topics,$idnew);
							$newtopicsstr=implode(",",$newtopics);
							$descriptors=$this->get_related_descr_ids($topics);
							if (!empty($descriptors)){
								$newdescrs=$this->copydescr($descriptors);
								$this->copy_topicdescrmm($newtopics,$newdescrs);
								$this->update_parentid($newdescrs);
								$examples=$this->get_related_examples_ids($descriptors);
								$newexamples=$this->copyexamples($examples);
								$this->copy_exampdescrmm($newdescrs,$newexamples);
							}
							
						}
						
						$inhalt.='<p class="copyok">'.$this->pi_getLL("wurde_kopiert").'<p>'.$this->makelist($tablename,$fegruppe);
					}else{ 
						$inhalt.=$this->pi_getLL("wirklich_gegenstand")."".$tdata["title"]." ".$this->pi_getLL("wirklich_gegenstand2");
						$inhalt.='<br><select name="'.$this->prefixId.'[subj2copy]">';
						if (!$this->checked_show_all()) {
							$showallwhere=" WHERE st.fe_creator=".$GLOBALS["TSFE"]->fe_user->user["uid"]; 
						}else{
							$showallwhere=" WHERE (st.fe_creator=".$GLOBALS["TSFE"]->fe_user->user["uid"]." OR st.fe_owner=1)"; 
						}
						$showallwhere.=" AND st.uid<>".$tdata["stid"];
						$sqls="SELECT st.title as stname,st.uid,el.title as eltitle  FROM tx_exabiscompetences_educationlevels el INNER JOIN tx_exabiscompetences_schooltypes st ON el.uid=st.elid ".$showallwhere." ORDER BY el.title,st.SORTING";
						
						$results=mysql_query($sqls);
						while ($rss=mysql_fetch_array($results)){
							$inhalt.='<option value="'.$rss["uid"].'">'.$rss["eltitle"].'->'.$rss["stname"].'</option>';
						}
						$inhalt.='</select><br>';
					}
					$inhalt.='<input type="hidden" name="'.$this->prefixId.'[subjsource]" value="'.intval(t3lib_div::_GP("recid")).'">';
					$inhalt.='<input type="submit" value="'.$this->pi_getLL("kopieren").'" name="'.$this->prefixId.'[kopieren]"><input type="submit" value="'.$this->pi_getLL("abbrechen").'" name="'.$this->prefixId.'[abbrechen]">';
					$inhalt.='</form>';
				}
			}else if (t3lib_div::_GP("a")=="n" || t3lib_div::_GP("a")=="e" || $datenok==false){
				if (t3lib_div::_GP("a")=="n"){
					if ($this->lastsort==0) $this->lastsort=$this->get_last_sortoftable($tablename);
					$id=$this->new_rec($tablename,array("title"=>"","fe_owner"=>$GLOBALS["TSFE"]->fe_user->user["uid"],"fe_creator"=>$GLOBALS["TSFE"]->fe_user->user["uid"],"crdate"=>time(),"tstamp"=>time(),"sorting"=>$this->lastsort,"pid"=>$this->conf["pid_data"]));
				}else if($datenok==false){
					$id=intval($this->piVars["uid"]);
				}else{$id=intval(t3lib_div::_GP("recid"));}
				
				if($datenok==false){
					$inhalt.='<div class="error">'.$this->pi_getLL("Pflichtfelder").'</div>';
					$ttitle=$this->clean_text($this->piVars["title"]);
				}else{
					$rs=$this->get_table_data($tablename,$id);
					$ttitle=$rs["title"];
				}
				
				$inhalt.='<form name="formular" enctype="multipart/form-data" method="post" action="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>t3lib_div::_GP("b"),"a"=>"s","f"=>$this->f,"f2"=>$this->f2,"no_cache"=>"1")).'">';
				$inhalt.='<span class="fldheader">'.$this->pi_getLL("Bezeichnung").': *</span><span class="fldinput"><textarea class="'.$desp_edit_title2.'" name="'.$this->prefixId.'[title]">'.$ttitle.'</textarea></span><br>';
				$inhalt.='<input type="hidden" value="'.$id.'" name="'.$this->prefixId.'[uid]">';
				
				
				if (t3lib_div::_GP("b")=="schoolt"){
					if($datenok==false){$telid=intval($this->piVars["pd_edulevel"]);
					}else{$telid=$rs["elid"];}
					$showallwheret=$showallwhere." OR uid=".$telid;
					$inhalt.='<span class="fldheader">'.$this->pi_getLL("Schulstufe").' *:</span><span class="fldinput">'.$this->create_pulldown($tablename_pd,"pd_edulevel","title",$telid,true,"","uid",$showallwheret." ORDER BY sorting","uid",'',$ka_wert=$this->pi_getLL("bitte_Auswahl_treffen"),$joint="",$sqlu="").'</span>';
				}
				if (t3lib_div::_GP("b")=="subj"){
					if($datenok==false){$tstid=intval($this->piVars["pd_subject"]);
					}else{$tstid=$rs["stid"];}
					$showallwheret=$showallwhere." OR uid=".$tstid;
					$inhalt.='<span class="fldheader">'.$this->pi_getLL("titleshort").': </span><span class="fldinput"><input type="text" class="exacomp_input_long"  value="'.$rs["titleshort"].'" name="'.$this->prefixId.'[titleshort]"></span>';
					$inhalt.='<span class="fldheader">'.$this->pi_getLL("Schultype").': *</span><span class="fldinput">'.$this->create_pulldown($tablename_pd,"pd_subject","title",$tstid,true,"","uid",$showallwheret." ORDER BY sorting","uid",'',$ka_wert=$this->pi_getLL("bitte_Auswahl_treffen"),$joint="",$sqlu="").'</span>';
					
				}
				if (t3lib_div::_GP("b")=="topic"){
					//$inhalt.=$this->makefilter($rs["subjid"],'Gegenstand',$tablename_pd,'pd_topic');
					if($datenok==false){$pwert=intval($this->piVars["pd_topic"]);
					}else{$pwert=$rs["subjid"];}
						
					if (($pwert=="" || $pwert==0) && $this->f!="") $pwert=$this->f;

					$showallwheret=$showallwhere." OR uid=".$pwert;
					$inhalt.='<span class="fldheader">'.$this->pi_getLL("titleshort").': </span><span class="fldinput"><input type="text" class="exacomp_input_long"  value="'.$rs["titleshort"].'" name="'.$this->prefixId.'[titleshort]"></span>';
					$inhalt.='<span class="fldheader">'.$this->pi_getLL("Gegenstand").': *</span><span class="fldinput">'.$this->create_pulldown($tablename_pd,"pd_topic","title",$pwert,true,"","uid",$showallwheret." ORDER BY sorting","uid",'',$ka_wert=$this->pi_getLL("bitte_Auswahl_treffen"),$joint="",$sqlu="").'</span>';
					$inhalt.='<span class="fldheader">'.$this->pi_getLL("Beschreibung").':</span><br><span class="fldinput">
					<textarea name="'.$this->prefixId.'[description]">'.$rs["description"].'</textarea></span><br>';
					
				}
				if (t3lib_div::_GP("b")=="descr"){
					$sql="SELECT uid_foreign FROM tx_exabiscompetences_descriptors_topicid_mm WHERE uid_local=".$id;
					//echo $sql;
					$result=mysql_query($sql);
					$werte=Array();
					while ($rs2=mysql_fetch_array($result)){
						$werte[]=$rs2["uid_foreign"];
					}
					if ($datenok==false){
						$werte=Array();
						foreach ($this->piVars["pd_topic"] as $key=>$value){
							$werte[]=$value;
						}
					}
					$wertelist=implode(",",$werte);
					if ($wertelist=="") $wertelist=0;
					$whereanh="";$zusatzt=":";
					if ($this->f!="") {
						$whereanh=' WHERE (subjid='.$this->f.' OR uid IN ('.$wertelist.')) '.$showallwhere2;
						$zusatzt=' ('.$this->pi_getLL("titleshort").' '.$this->getsubjectname($this->f).'):';
					

						$sqls='SELECT group_concat(cast(descr.uid as char(10))) as ids FROM tx_exabiscompetences_descriptors descr INNER JOIN tx_exabiscompetences_descriptors_topicid_mm mm ON descr.uid=mm.uid_local INNER JOIN tx_exabiscompetences_topics top on top.uid=mm.uid_foreign INNER JOIN tx_exabiscompetences_subjects sub ON sub.uid=top.subjid';
						$sqls.=' WHERE sub.uid='.$this->f.'';
						if ($this->f2!=""){
							$sqls.=' AND descr.skillid='.$this->f2;
						}
						$result=mysql_query($sqls);
						//echo $sqls;
						$rs3=mysql_fetch_array($result);
						$wherein=$rs3["ids"];
						if ($wherein=="") $wherein="0";
						$whereanhang=" WHERE uid IN (".$wherein.") ".$showallwhere2;
					}else{
						
							$whereanh=$showallwhere.' OR uid IN ('.$wertelist.')';
							$whereanhang=$showallwhere.' OR uid='.$rs["parent_id"];
						
						
						//echo $whereanhang;
					}
					//echo $whereanh;
					$inhalt.='<span class="fldinput_single">'.$this->pi_getLL("Thema").' '.$zusatzt.'</span><br><span class="fldheader">&nbsp;</span><span class="fldinput">'.$this->create_pulldown($tablename_pd,"pd_topic","title",$werte,true,"multiple","uid",$whereanh." ORDER BY sorting","uid",'',$ka_wert=$this->pi_getLL("bitte_Auswahl_treffen"),$joint="",$sqlu="").'</span>';
					$inhalt.='<div style="clear:both;"></div>';
					$inhalt.='<span class="fldheader">'.$this->pi_getLL("Uebergeordneter_Deskriptor").':</span><span class="fldinput">'.$this->create_pulldown("tx_exabiscompetences_descriptors","pd_parent_id","title",$rs["parent_id"],true,"","uid",$whereanhang." ORDER BY sorting","uid",'',$this->pi_getLL("bitte_Auswahl_treffen"),"","").'</span>';
					//nur pichler=6 für desp und admin;
					//if ($GLOBALS["TSFE"]->fe_user->user["uid"]==6 OR $GLOBALS["TSFE"]->fe_user->user["uid"]==1){
					if ($this->has_capability("niveaus")){
						$inhalt.='<b>'.$this->pi_getLL("fuer_sprachen").':</b><br /><span class="fldheader">'.$this->pi_getLL("Niveau").':</span><span class="fldinput">'.$this->create_pulldown("tx_exabiscompetences_niveaus","pd_niveau","title",$rs["niveauid"],true,"","uid","ORDER BY title","uid",'',$this->pi_getLL("bitte_Auswahl_treffen"),"","").'</span>';
						//$inhalt.='<br><span class="fldheader">'.$this->pi_getLL("Skill").':</span><span class="fldinput">'.$this->create_pulldown("tx_exabiscompetences_skills","pd_skill","title".$this->langcode,$rs["skillid"],true,"","uid","WHERE sys_language_uid=".$this->languageid,"uid",'',$this->pi_getLL("bitte_Auswahl_treffen"),"","").'</span><br />';
						$inhalt.='<br><span class="fldheader">'.$this->pi_getLL("Skill").':</span><span class="fldinput">'.$this->create_pulldown("tx_exabiscompetences_skills","pd_skill","title".$this->langcode,$rs["skillid"],true,"","uid","ORDER BY title","uid",'',$this->pi_getLL("bitte_Auswahl_treffen"),"","").'</span><br />';
					}
					if($GLOBALS["TSFE"]->fe_user->user["uid"]==1){
							$inhalt.='
							<p>
								<b>Doku für Administrator:</b><br /><ul style="list-style-type:square;">
								<li>Skill und Niveau sind nur editierbar, wenn User fegroup "niveau" zugeordnet hat.</li>
								</ul>
								</p>
						';	
					}
				}
				if (t3lib_div::_GP("b")=="examp"){
					if (t3lib_div::_GP("del")!="") {
						$this->deleteExampleFile($rs,t3lib_div::_GP("del"),$tablename,$id);
						$rs=$this->get_table_data($tablename,$id);//daten wurden eventuell geändert
					}
					$sql="SELECT uid_foreign FROM tx_exabiscompetences_examples_descrid_mm WHERE uid_local=".$id;
					//echo $sql;
					$result=mysql_query($sql);
					$werte=Array();
					while ($rs2=mysql_fetch_array($result)){
						$werte[]=$rs2["uid_foreign"];
					}
					$wertelist=implode(",",$werte);
					if ($wertelist=="") $wertelist=0;
					
					$whereanh="";$zusatzt=": ";
					
					

					if ($this->f!="") {
							
						$sqls='SELECT group_concat(cast(descr.uid as char(10))) as ids FROM tx_exabiscompetences_descriptors descr INNER JOIN tx_exabiscompetences_descriptors_topicid_mm mm ON descr.uid=mm.uid_local INNER JOIN tx_exabiscompetences_topics top on top.uid=mm.uid_foreign INNER JOIN tx_exabiscompetences_subjects sub ON sub.uid=top.subjid';
						$sqls.=' WHERE sub.uid='.$this->f.'';
						if ($this->f2!="") {
							$sqls.=" AND descr.skillid=".$this->f2;
							$zusatzt.=",".$this->getskillname($this->f);
						}
						$result=mysql_query($sqls);
						//echo $sqls;
						$rs3=mysql_fetch_array($result);
						$wherein=$rs3["ids"];
						if ($wherein=="") $wherein="0";
						//echo "####".$rs["ids"];
						
						$whereanh=' WHERE uid IN ('.$wherein.') OR uid IN ('.$wertelist.') '.$showallwhere2.' ORDER BY sorting';$zusatzt=' ('.$this->pi_getLL("gefiltert nach").' '.$this->getsubjectname($this->f).'):';
					}else if($this->f2!=""){
						$sqls='SELECT group_concat(cast(descr.uid as char(10))) as ids FROM tx_exabiscompetences_descriptors descr';
						$sqls.=' WHERE descr.skillid='.$this->f2;
						$result=mysql_query($sqls);
						//echo $sqls;
						$rs3=mysql_fetch_array($result);
						$wherein=$rs3["ids"];
						if ($wherein=="") $wherein="0";
						//echo "####".$rs["ids"];
						
						$whereanh=' WHERE uid IN ('.$wherein.') OR uid IN ('.$wertelist.') ORDER BY sorting';$zusatzt=' (gefiltert nach '.$this->getskillname($this->f2).'):';
					
					}else{
						
							$whereanh=$showallwhere.' OR uid IN ('.$wertelist.') ORDER BY sorting';
						
						
					}
					//echo $whereanh;
					$inhalt.='<span class="fldheader titleshort">'.$this->pi_getLL("titleshort").': </span><span class="fldinput"><input type="text" class="exacomp_input_long"  value="'.$rs["titleshort"].'" name="'.$this->prefixId.'[titleshort]"></span>';
					$inhalt.='<div class="examples_descr">'.$this->create_pulldown($tablename_pd,"pd_descr","title",$werte,true,"multiple","uid",$whereanh,"uid",'',$ka_wert=$this->pi_getLL("bitte_Auswahl_treffen"),$joint="",$sqlu="").'</div>';
					//$inhalt.=$this->create_pulldown("tx_exabiscompetences_niveaus","pd_niveau","title",$rs["niveauid"],true,"","uid","","uid",'',$ka_wert=$this->pi_getLL("bitte_Auswahl_treffen"),$joint="",$sqlu="");
					//$inhalt.=$this->create_pulldown("tx_exabiscompetences_skills","pd_skill","title",$rs["skillid"],true,"","uid","","uid",'',$ka_wert=$this->pi_getLL("bitte_Auswahl_treffen"),$joint="",$sqlu="");
					$inhalt.='<table class="exacomp_files">';
					$inhalt.='<tr><td class="exacomp_files1">'.$this->pi_getLL("Task").'</td><td class="exacomp_files2"><input class="examp_file" type="file" name="'.$this->prefixId.'[task]"></td><td class="exacomp_files3">'.$this->hidepath($rs["task"]).'</td><td><a href="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>t3lib_div::_GP("b"),"a"=>"e","recid"=>$rs["uid"],"del"=>"task")).'"><img border="0" src="typo3conf/ext/exabis_competences/pi1/ed_delete.gif"></a></td></tr>';
					$inhalt.='<tr><td class="exacomp_files1">'.$this->pi_getLL("Loesung").'</td><td class="exacomp_files2"><input class="examp_file"  type="file" name="'.$this->prefixId.'[solution]"></td><td class="exacomp_files3">'.$this->hidepath($rs["solution"]).'</td><td><a href="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>t3lib_div::_GP("b"),"a"=>"e","recid"=>$rs["uid"],"del"=>"sol")).'"><img border="0" src="typo3conf/ext/exabis_competences/pi1/ed_delete.gif"></a></td></tr>';
					$inhalt.='<tr><td class="exacomp_files1">'.$this->pi_getLL("Anhang").'</td><td class="exacomp_files2"><input class="examp_file" type="file" name="'.$this->prefixId.'[attachement]"></td><td class="exacomp_files3">'.$this->hidepath($rs["attachement"]).'</td><td><a href="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>t3lib_div::_GP("b"),"a"=>"e","recid"=>$rs["uid"],"del"=>"att")).'"><img border="0" src="typo3conf/ext/exabis_competences/pi1/ed_delete.gif"></a></td></tr>';
					$inhalt.='<tr><td class="exacomp_files1">'.$this->pi_getLL("Completefiles").'</td><td class="exacomp_files2"><input class="examp_file" type="file" name="'.$this->prefixId.'[completefile]"></td><td class="exacomp_files3">'.$this->hidepath($rs["completefile"]).'</td><td><a href="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>t3lib_div::_GP("b"),"a"=>"e","recid"=>$rs["uid"],"del"=>"compl")).'"><img border="0" src="typo3conf/ext/exabis_competences/pi1/ed_delete.gif"></a></td></tr>';
					$inhalt.='</table>';
					$inhalt.='<span class="fldheader">'.$this->pi_getLL("Beschreibung").':</span><br><span class="fldinput">
					<textarea name="'.$this->prefixId.'[description]">'.$rs["description"].'</textarea></span><br>';
					$inhalt.='<br><span class="fldheader2">'.$this->pi_getLL("Taxonomie").':</span><span class="fldinput">'.$this->create_pulldown("tx_exabiscompetences_taxonomies","pd_tax","title",$rs["taxid"],true,"","uid","WHERE sys_language_uid=".$this->languageid,"uid",'',$ka_wert=$this->pi_getLL("bitte_Auswahl_treffen"),"","").'</span>';
					//t3lib_div::debug($GLOBALS['TSFE']);
				  $inhalt.='<br><span class="fldheader2">'.$this->pi_getLL("Timeframe").':</span><span class="fldinput"><input type="text" class="exacomp_input_long" value="'.$rs["timeframe"].'" name="'.$this->prefixId.'[timeframe]"></span><br>';
					$inhalt.='<span class="fldheader2">'.$this->pi_getLL("Additional_Ressources").':</span><span class="fldinput"><input type="text" value="'.$rs["ressources"].'" class="exacomp_input_long" name="'.$this->prefixId.'[ressources]"></span><br>';
					$inhalt.='<span class="fldheader2">'.$this->pi_getLL("Didactical_Tips").':</span><span class="fldinput"><input type="text" class="exacomp_input_long" value="'.$rs["tips"].'" name="'.$this->prefixId.'[tips]"></span><br>';
					$inhalt.='<span class="fldheader2">'.$this->pi_getLL("External_Url").':</span><span class="fldinput"><input type="text" class="exacomp_input_long" value="'.$rs["externalurl"].'" name="'.$this->prefixId.'[externalurl]"></span><br>';
					$inhalt.='<span class="fldheader2">'.$this->pi_getLL("external_link_solution").':</span><span class="fldinput"><input type="text" class="exacomp_input_long"  value="'.$rs["externalsolution"].'" name="'.$this->prefixId.'[externalsolution]"></span><br>';	
					if ($rs["iseditable"]=="1") {$editablechecked='checked="checked"';}
					$inhalt.='<span class="fldheader2">'.$this->pi_getLL("external_link_task").':</span><span class="fldinput"><input type="text" class="exacomp_input_long"  value="'.$rs["externaltask"].'" name="'.$this->prefixId.'[externaltask]"></span><br>';
					$inhalt.='<span class="fldheader2">'.$this->pi_getLL("editable_example").':</span><span class="fldinput"><input title="'.$this->pi_getLL("editable_example_long").'" type="checkbox" name="'.$this->prefixId.'[iseditable]['.$rs["uid"].']" value="on" '.$editablechecked.'></span><br>';
					$inhalt.='<br><span class="fldheader2">'.$this->pi_getLL("desp_sprache").':</span><span class="fldinput">'.$this->create_pulldown("tx_exabiscompetences_desp_lang","pd_lang","title",$rs["lang"],true,"","uid","WHERE sys_language_uid=".$this->languageid,"uid",'',$ka_wert=$this->pi_getLL("bitte_Auswahl_treffen"),"","").'</span>';
				}
				if ($this->f!=""){
					$inhalt.='<input type="hidden" name="'.$this->prefixId.'[pd_flt]" value="'.$this->f.'">';
				}
				if ($this->f2!=""){
					$inhalt.='<input type="hidden" name="'.$this->prefixId.'[pd_flt2]" value="'.$this->f2.'">';
				}
				$inhalt.='<input type="submit" value="'.$this->pi_getLL("save").'">';
				$inhalt.='</form>';
				if (t3lib_div::_GP("b")=="subj"){
					$inhalt.='<a href="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>t3lib_div::_GP("b"),"a"=>"c","recid"=>$rs["uid"])).'">'.$this->pi_getLL("kopieren").'</a>';
				}
			}else if (t3lib_div::_GP("a")=="d" || $this->piVars["CAction"]==1){
				$recids=array();
				$inhalt.='<h1>'.$this->pi_getLL("Loeschvorgang").'</h1>';
				$delids="";
				if (t3lib_div::_GP("a")=="d") $recids[]=intval(t3lib_div::_GP("recid"));
				
				if(!empty($this->piVars["cbaction"])){
					foreach($this->piVars["cbaction"] as $key=>$value){
						$recids[]=intval($key);
					}
				}

				foreach ($recids as $id){
					$erg=$this->delete_record_possible(t3lib_div::_GP("b"),$id,$this->piVars["title"][$id]);
					if ($erg=="") {
						$delids.=",".$id;
						$inhalt.='<p class="delmessage">'.$this->add_str($this->piVars["title"][$id],":").' '.$this->pi_getLL("delete_realy").'</p>';
					}else{
						$inhalt.=$erg; //fehlermeldung
					}
				}
				$delids=preg_replace("/^,/","",$delids);
				$inhalt.='<table><tr>';
				if (!empty($delids)){
					$inhalt.='<td><form action="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>t3lib_div::_GP("b"),"a"=>"dok","f"=>$this->f,"f2"=>$this->f2)).'"  method="post" name="delidsdelok"><input type="text" name="'.$this->prefixId.'[recids]" value="'.$delids.'"> <input type="submit" value="'.$this->pi_getLL("loeschen").'"></td></form>';
				}
				$inhalt.='<td><form action="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>t3lib_div::_GP("b"),"f"=>$this->f,"f2"=>$this->f2)).'" method="post" name="delcancel"><input type="submit" value="'.$this->pi_getLL("abbrechen").'"></td> ';
				$inhalt.='</tr></table>';
			}
			else{
				if (t3lib_div::_GP("a")=="dok"){
					$id=intval(t3lib_div::_GP("recid")); 
					$ids=$this->piVars["recids"];
					$idsa=explode(",",$ids);
					foreach($idsa as $id){
						if ($this->is_owner($id,$GLOBALS["TSFE"]->fe_user->user["uid"],$tablename)) $this->delete_record($id,$tablename);
					}
				} elseif (t3lib_div::_GP("a")=="s"){
					$id=intval($this->piVars["uid"]);
					$sql="SELECT * FROM ".$tablename." WHERE uid=".$id;
					//echo $sql;
					$result=mysql_query($sql);
					$rs=mysql_fetch_array($result);
					if ($this->is_owner($id,$GLOBALS["TSFE"]->fe_user->user["uid"],$tablename) || ($this->is_creator($id,$GLOBALS["TSFE"]->fe_user->user["uid"],$tablename))){
						$data=array();
						$data["title"]=$this->clean_text($this->piVars["title"]);
						$date["tstamp"]=time();
						if (t3lib_div::_GP("b")=="schoolt"){
							$data["elid"]=intval($this->piVars["pd_edulevel"]);
						}
						if (t3lib_div::_GP("b")=="subj"){
							$data["stid"]=intval($this->piVars["pd_subject"]);
							$data["titleshort"]=$this->clean_text($this->piVars["titleshort"]);
						}
						if (t3lib_div::_GP("b")=="topic"){
							$data["titleshort"]=$this->clean_text($this->piVars["titleshort"]);
							$data["subjid"]=intval($this->piVars["pd_topic"]);
							$data["description"]=$this->clean_text($this->piVars["description"]);
						}
						if (t3lib_div::_GP("b")=="descr"){
							
							$sql="DELETE FROM tx_exabiscompetences_descriptors_topicid_mm WHERE uid_local=".$id;
							mysql_query($sql);
							foreach($this->piVars['pd_topic'] as $topic){
								$sql='INSERT INTO tx_exabiscompetences_descriptors_topicid_mm (uid_local,uid_foreign) VALUES ('.$id.','.$topic.')';
								mysql_query($sql);
							}
							$data["topicid"]=intval($this->piVars["pd_topic"]);
							$data["skillid"]=intval($this->piVars["pd_skill"]);
							$data["niveauid"]=intval($this->piVars["pd_niveau"]);
							$data["parent_id"]=intval($this->piVars["pd_parent_id"]);
						}
						if (t3lib_div::_GP("b")=="examp"){
							
							$sql="DELETE FROM tx_exabiscompetences_examples_descrid_mm WHERE uid_local=".$id;
							mysql_query($sql);
							foreach($this->piVars['pd_descr'] as $descr){
								$sql='INSERT INTO tx_exabiscompetences_examples_descrid_mm (uid_local,uid_foreign) VALUES ('.$id.','.$descr.')';
								mysql_query($sql);
							}
							$data["titleshort"]=$this->clean_text($this->piVars["titleshort"]);
							$this->fileFunc = t3lib_div::makeInstance("t3lib_basicFileFunctions");
							$data["task"]=$this->hidepath($this->storeImage("task",$this->bildpfad,$rs["task"]));
							$data["solution"]=$this->hidepath($this->storeImage("solution",$this->bildpfad,$rs["solution"]));
							$data["attachement"]=$this->hidepath($this->storeImage("attachement",$this->bildpfad,$rs["attachement"]));
							$data["completefile"]=$this->hidepath($this->storeImage("completefile",$this->bildpfad,$rs["completefile"]));
							$data["description"]=$this->clean_text($this->piVars["description"]);
							$data["taxid"]=$this->clean_text($this->piVars["pd_tax"]);
							$data["timeframe"]=$this->clean_text($this->piVars["timeframe"]);
							$data["ressources"]=$this->clean_text($this->piVars["ressources"]);
							$data["tips"]=$this->clean_text($this->piVars["tips"]);
							$data["externalurl"]=$this->clean_text($this->piVars["externalurl"]);
							$data["externalsolution"]=$this->clean_text($this->piVars["externalsolution"]);
							$data["externaltask"]=$this->clean_text($this->piVars["externaltask"]);
							$data["iseditable"]=intval($this->piVars["iseditable"]);
							$data["lang"]=$this->clean_text($this->piVars["pd_lang"]);
							//t3lib_div::debug($data);
							/*$data["topicid"]=intval($this->piVars["pd_topic"]);
							$data["skillid"]=intval($this->piVars["pd_skill"]);
							$data["niveauid"]=intval($this->piVars["pd_niveau"]);*/
						}
						
						$GLOBALS['TYPO3_DB']->exec_UPDATEquery($tablename,"uid=".$id,$data);
					}
				}
				if ($art==1){
					$inhalt.=$this->makelist($tablename,$fegruppe);
					
				}
			}
		
		}elseif (t3lib_div::_GP("b")=="export") {
			$domain=$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			$domain = substr_replace($domain, "", $pos=strrpos($domain,"/"));
			$path_uploadfolder='http://'.$domain.'/uploads/tx_exabiscompetences/';
					if ($this->piVars["meine"]=="on") {$meinechecked='checked="checked"';$nurmeine=true;}
					else $nurmeine=false;
					if ($this->piVars["exportdesp"]=="on") {$exportdespchecked='checked="checked"';$exportdesp=true;}
					else $exportdesp=false;
					// damit group_concat ergebnisse nicht bei 1024 zeichen abgeschnitten werden
					mysql_query('SET @@group_concat_max_len := @@max_allowed_packet');
			$content_pd='
						<form method="post">
						<select name="pd_subjects[]" size=10 multiple>';
						$pdtemp=$this->getSubjectFilerOptions(1);
						$content_pd.=$pdtemp->content_pd;
				 		
				 		$pdtemp->filename_zusatz=preg_replace('/^,/','',$pdtemp->filename_zusatz);
				 		$pdtemp->filename_zusatz="(".$pdtemp->filename_zusatz.")";
				 		
						$content_pd.='</select>
						<br><input type="checkbox" name="'.$this->prefixId.'[meine]" value="on" '.$meinechecked.'>&nbsp;'.$this->pi_getLL("nur_meine_exportieren").' 
						<br><input type="checkbox" name="'.$this->prefixId.'[exportdesp]" value="on" '.$exportdespchecked.'>&nbsp;'.$this->pi_getLL("desp_exportieren").' 						
						<br><input type="submit" value="'.$this->pi_getLL("abschicken").'">
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
						$WHERE=" (fe_owner=1 OR fe_owner=".$GLOBALS["TSFE"]->fe_user->user["uid"].")";
						if ($nurmeine==true) $WHERE="fe_owner=".$GLOBALS["TSFE"]->fe_user->user["uid"];
						
						if ($exportdesp==true){
							$tablepref="block_desp_";
						}else{
							$tablepref="block_exacomp";
						}
						$strxml.='<?xml version="1.0" encoding="utf-8"?>'."\n";
						$strxml.='<exabis_competences_tables>'."\n";
						$fields=array();
						
						
						//--------------------educationlevel
						$fields[0]="uid";$fields[1]="title";$fields[2]="sorting";
						$cdatarr=array();$cdatarr[1]="cdata";
						if (!$exportdesp) $strxml.=$this->get_sql("tx_exabiscompetences_educationlevels",$tablepref."edulevels",$fields,$fields,$path_uploadfolder,$WHERE,"initial",$cdatarr);
						
						//---------------------schooltype
						$fields=array();
						$fields[0]="uid";$fields[1]="title";$fields[2]="elid";$fields[3]="sorting";$fields[4]="isoez";
						$cdatarr=array();$cdatarr[1]="cdata";
						if (!$exportdesp) $strxml.=$this->get_sql("tx_exabiscompetences_schooltypes",$tablepref."schooltypes",$fields,$fields,$path_uploadfolder,$WHERE,"initial",$cdatarr);
						
						//----------------------subject
						$fields=array();
						$fields[0]="uid";$fields[1]="title";$fields[2]="titleshort";$fields[3]="stid";$fields[4]="sorting";
						$cdatarr=array();$cdatarr[1]="cdata";$cdatarr[2]="cdata";
						$WHERES=$WHERE;
						if ($subject_filter>0){
							$WHERES.=" AND uid IN (".$subject_filter_str.")";
						}
						if (!$exportdesp) $strxml.=$this->get_sql("tx_exabiscompetences_subjects",$tablepref."subjects",$fields,$fields,$path_uploadfolder,$WHERES,"initial",$cdatarr);
						
						//----------------------topic
						$fields=array();
						$fields[0]="uid";$fields[1]="title";$fields[2]="titleshort";$fields[3]="subjid";$fields[4]="sorting";$fields[5]="description";
						$cdatarr=array();$cdatarr[1]="cdata";$cdatarr[2]="cdata";$cdatarr[5]="cdata";
						$WHERES=$WHERE;

						if ($subject_filter>0){
							
							$WHERES.=" AND subjid IN (".$subject_filter_str.")";
							$sql="select group_concat(cast(uid_local as char(10))) as ids FROM tx_exabiscompetences_descriptors_topicid_mm mm INNER JOIN tx_exabiscompetences_topics topic ON  topic.uid=mm.uid_foreign WHERE topic.subjid IN (".$subject_filter_str.") AND ".$WHERE." ORDER BY ids";

							$result=mysql_query($sql);
							$rs_descr=mysql_fetch_array($result);
							
						}else{
							$sql="select group_concat(cast(uid_local as char(10))) as ids FROM tx_exabiscompetences_descriptors_topicid_mm mm INNER JOIN tx_exabiscompetences_topics topic ON  topic.uid=mm.uid_foreign WHERE ".$WHERE." ORDER BY ids";
							//echo $sql;
							$result=mysql_query($sql);
							$rs_descr=mysql_fetch_array($result);
						}
						if (!$exportdesp) $strxml.=$this->get_sql("tx_exabiscompetences_topics",$tablepref."topics",$fields,$fields,$path_uploadfolder,$WHERES,"initial",$cdatarr);
						
						//----------------------descriptor
						$fields=array();
						$fields[0]="uid";$fields[1]="title";$fields[2]="niveauid";$fields[3]="sorting";$fields[4]="skillid";$fields[5]="parent_id";
						$cdatarr=array();$cdatarr[1]="cdata";
						$WHERES=$WHERE;
						if ($subject_filter>0){
							$WHERES=$WHERE." AND uid IN (".$rs_descr["ids"].")";
							//$sql="select group_concat(cast(uid_local as char)) as ids FROM tx_exabiscompetences_examples_descrid_mm mm INNER JOIN tx_exabiscompetences_examples ex ON ex.uid=mm.uid_foreign WHERE mm.uid_foreign IN (".$rs_descr["ids"].")";
							$sql="select group_concat(cast(uid_local as BINARY)) as ids FROM tx_exabiscompetences_examples_descrid_mm mm WHERE mm.uid_foreign IN (".$rs_descr["ids"].")";
							
							//echo $sql;
							$result=mysql_query($sql);
							$rs_ex=mysql_fetch_array($result);
						}
						$strxml.=$this->get_sql("tx_exabiscompetences_descriptors",$tablepref."descriptors",$fields,$fields,$path_uploadfolder,$WHERES,"initial",$cdatarr);
						
						//----------------------examples
						$fields=array();
						$fields[0]="uid";$fields[1]="title";$fields[2]="titleshort";$fields[3]="task";$fields[4]="sorting";$fields[5]="solution";
						$fields[6]="attachement";$fields[7]="completefile";$fields[8]="description";
						$fields[9]="taxid";$fields[10]="timeframe";$fields[11]="ressources";$fields[12]="tips";
						$fields[13]="externalurl";$fields[14]="externalsolution";$fields[15]="externaltask";$fields[16]="lang";$fields[17]="iseditable";
						$cdatarr=array();$cdatarr[1]="cdata";$cdatarr[2]="cdata";$cdatarr[3]="cdata";$cdatarr[5]="cdata";$cdatarr[8]="cdata";$cdatarr[12]="cdata";
						$dateien='task,solution,attachement,completefile';
						if ($subject_filter>0){
							$WHERES=$WHERE." AND uid IN (".$rs_ex["ids"].")";
							//$sql="select group_concat(cast(ta.uid as char)) as ids FROM tx_exabiscompetences_examples ex INNER JOIN tx_exabiscompetences_taxonomies ta ON ta.uid=ex.taxid WHERE ex.uid IN (".$rs_descr["ids"].")";
							//$result=mysql_query($sql);
							//$rs_ta=mysql_fetch_array($result);
						}
						//echo $WHERES;
						$strxml.=$this->get_sql("tx_exabiscompetences_examples",$tablepref."examples",$fields,$fields,$path_uploadfolder,$WHERES,$dateien,$cdatarr);
						$WHERE="1=1";
						
						//--------------------taxonomies
						$fields=array();
						$fields[0]="uid";$fields[1]="title";$fields[2]="sorting";$fields[3]="parent_tax";
						$cdatarr=array();$cdatarr[1]="cdata";
						//if ($subject_filter>0){
							//$WHERE=" uid IN (".$rs_ta["ids"].")";
							$sql="select group_concat(cast(sk.uid as char(10))) as ids FROM tx_exabiscompetences_descriptors de INNER JOIN tx_exabiscompetences_skills sk ON sk.uid=de.skillid WHERE de.uid IN (".$rs_descr["ids"].")";
							//echo $sql;
							$result=mysql_query($sql);
							$rs_sk=mysql_fetch_array($result);
						//}
						$WHERE=" sys_language_uid=".$this->languageid;
						$strxml.=$this->get_sql("tx_exabiscompetences_taxonomies",$tablepref."taxonomies",$fields,$fields,$path_uploadfolder,$WHERE,"initial",$cdatarr);
						$WHERE="1=1";
						
						//----------------------skills
						$fields=array();
						$fields[0]="uid";$fields[1]="title".$this->langcode;$fields[2]="sorting";
						$fields_moodle[0]="uid";$fields_moodle[1]="title";$fields_moodle[2]="sorting";
						$cdatarr=array();$cdatarr[1]="cdata";
						//if ($subject_filter>0){
							$WHERE=" uid IN (".$rs_sk["ids"].")";
							if ($exportdesp==true) {$WHERE.=" AND uid<6";}
							$sql="select distinct group_concat(cast(niv.uid as char(10))) as ids FROM tx_exabiscompetences_descriptors de INNER JOIN tx_exabiscompetences_niveaus niv ON niv.uid=de.niveauid WHERE de.uid IN (".$rs_descr["ids"].")";
							//echo $sql;
							$result=mysql_query($sql);
							$rs_niv=mysql_fetch_array($result);
						//}
						$strxml.=$this->get_sql("tx_exabiscompetences_skills",$tablepref."skills",$fields,$fields_moodle,$path_uploadfolder,$WHERE,"initial",$cdatarr);
						$WHERE="1=1";
						
						//----------------------niveaus
						$fields=array();
						$fields[0]="uid";$fields[1]="title";$fields[2]="parent_niveau";$fields[3]="sorting";
						
						$cdatarr=array();$cdatarr[1]="cdata";
						if ($subject_filter>0){
							//auskommentiert, alle niveaus nehmen, sonst sind parent niveaus nicht drinnen $WHERE=" uid IN (".$rs_niv["ids"].")";
							
							
							/*$sql="select group_concat(cast(sk.uid as char)) as ids FROM tx_exabiscompetences_descriptors de INNER JOIN tx_exabiscompetences_skills sk ON sk.uid=de.skillid WHERE de.uid IN (".$rs_descr["ids"].")";
							$result=mysql_query($sql);
							$rs_sk=mysql_fetch_array($result);*/
						}
						// niveaus in deutsch und englisch gleich $WHERE=" sys_language_uid=".$this->languageid;
						$strxml.=$this->get_sql("tx_exabiscompetences_niveaus",$tablepref."niveaus",$fields,$fields,$path_uploadfolder,$WHERE,"initial",$cdatarr);
						$WHERE="1=1";
						
						//----------------------niveaus_text
						$fields=array();
						$fields[0]="uid";$fields[1]="title";$fields[2]="niveauid";$fields[3]="skillid";
						$cdatarr=array();$cdatarr[1]="cdata";
						if ($subject_filter>0){
							//auskommentiert, alle niveaus nehmen, sonst sind parent niveaus nicht drinnen $WHERE=" uid IN (".$rs_niv["ids"].")";
							
							
							/*$sql="select group_concat(cast(sk.uid as char)) as ids FROM tx_exabiscompetences_descriptors de INNER JOIN tx_exabiscompetences_skills sk ON sk.uid=de.skillid WHERE de.uid IN (".$rs_descr["ids"].")";
							$result=mysql_query($sql);
							$rs_sk=mysql_fetch_array($result);*/
						}
						$WHERE=" sys_language_uid=".$this->languageid;
						$strxml.=$this->get_sql("tx_exabiscompetences_niveau_texte",$tablepref."niveau_texte",$fields,$fields,$path_uploadfolder,$WHERE,"initial",$cdatarr);
						$WHERE="1=1";
						
						//---------------------------- topics
						$fields=array();$fieldsmdl=array();
						$fields[]="uid_local";$fields[]="uid_foreign";
						$fieldsmdl[]="descrid";$fieldsmdl[]="topicid";
						//if ($subject_filter>0){
							$WHERE=" uid_local IN (".$rs_descr["ids"].")";
						//}
						if (!$exportdesp) $strxml.=$this->get_sql("tx_exabiscompetences_descriptors_topicid_mm",$tablepref."descrtopic_mm",$fields,$fieldsmdl,$path_uploadfolder,$WHERE);
						$WHERE="1=1";
						
						//--------------------------- examples 
						$fields=array();$fieldsmdl=array();
						$fields[]="uid_local";$fields[]="uid_foreign";
						$fieldsmdl[]="exampid";$fieldsmdl[]="descrid";
						//if ($subject_filter>0){
							$WHERE=" uid_foreign IN (".$rs_descr["ids"].")";
						//}
						
						$strxml.=$this->get_sql("tx_exabiscompetences_examples_descrid_mm",$tablepref."descrexamp_mm",$fields,$fieldsmdl,$path_uploadfolder,$WHERE);
						$WHERE="1=1";
						
						$strxml.='</exabis_competences_tables>'."\n";
						if (empty($this->conf["desp"])) $this->conf["desp"]='-1';
						//if ($subject_filter_str==$this->conf["desp"]) {$filename="desp_data.xml";}
						if ($exportdesp==true){$filename="desp_data.xml";}
						//else if ($subject_filter>0){ $filename="exacomp_data_".str_replace(",","_",$subject_filter_str).".xml";}
						else {$filename="exacomp_data.xml";}
						
						$erg=$this->createXmlFile($strxml,$filename);
						//echo $filename;
						//$link=t3lib_div::getIndpEnv('REQUEST_URI');
						//$content.=$link;
						
						//$content.=$domain;
						
							$content.='
							
							
							<p style="font-size:12px;margin-top:20px;"><b>'.$this->pi_getLL("download_xml").'</b>'.$pdtemp->filename_zusatz.': <br><a style="text-decoration:underline;line-height:30px;" target="_blank" href="'.$path_uploadfolder.$filename.'">'.$filename.'</a></p>
							<h4 style="margin-top:15px;">'.$this->pi_getLL("Exportdatei_Filter").'</h4>
							<p>'.$content_pd.'</p>';
							
						if($GLOBALS["TSFE"]->fe_user->user["uid"]==1){
							$content.='
							<p>
							<b>Doku für Administrator:</b><br /><ul style="list-style-type:square;">
							<li>Wenn das Häkchen "nur meine Datensätze exportieren" ausgewählt ist, werden nur die eigenen Datensätze exportiert. <br>Wenn eine Zuordnung zu einem Systemdatensatz erfolgt (zb Sekundarstufe I), ist dieser Systemdatensatz <b>nicht</b> im XML enthalten.</li>
							<li>Wenn das Häkchen "Systemdatensätze anzeigen" gesetzt ist, hat dies keinen Einfluss auf den Export. <br> Wenn das Häkchen nicht gesetzt ist, sieht der Benutzer die Systemdatensätze nicht, sie werden aber trotzdem exportiert.</li>
							
							</ul>
							</p>
							
							';
						}
						$inhalt.=$content;
						
		}elseif (t3lib_div::_GP("b")=="set") {
			$inhalt.='<h1>'.$this->pi_getLL("Einstellungen").'</h1>';
			$sql="SELECT * FROM tx_exabiscompetences_settings WHERE fe_user=".$GLOBALS["TSFE"]->fe_user->user["uid"];

			$result=mysql_query($sql);
			$gew='';
			if (!empty($this->piVars["datasent"]) && $this->piVars["datasent"]=="1"){
				if (!empty($this->piVars["showall"]) && $this->piVars["showall"]=="on"){$dataarr["showall"]=1;$gew='checked="checked"';}
				else{$dataarr["showall"]=0;}
				if (mysql_num_rows($result)>0) {$res=$GLOBALS['TYPO3_DB']->exec_UPDATEquery("tx_exabiscompetences_settings","fe_user=".$GLOBALS["TSFE"]->fe_user->user["uid"],$dataarr);}
				else{$dataarr["fe_user"]=$GLOBALS["TSFE"]->fe_user->user["uid"];$res=$GLOBALS['TYPO3_DB']->exec_INSERTquery("tx_exabiscompetences_settings",$dataarr);}
			}
			if ($this->checked_show_all()) $gew='checked="checked"';
			
			$inhalt.='<form method="post" action="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>t3lib_div::_GP("b"),"f"=>$this->f,"f2"=>$this->f2)).'">';
			$inhalt.=$this->pi_getLL("systemds");
			$inhalt.='<input type="checkbox" name="'.$this->prefixId.'[showall]" value="on" '.$gew.'><input type="hidden" name="'.$this->prefixId.'[datasent]" value="1">';
			$inhalt.='<br /><input type="submit" value="'.$this->pi_getLL("speichern").'">';
			$inhalt.='</form>';
		}elseif (t3lib_div::_GP("b")=="deluser") {
			$inhalt.="<h1>Daten von FE-Benutzern löschen</h1>"; 
			if ($this->piVars["submitdeluser"]!=""){
		
				foreach($this->piVars["feuser"] as $k=>$v){
					$inhalt.=$this->deleteuserdata($v);
				}
			}else{
				$inhalt.='<form method="post" action="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>"deluser")).'">';
				$inhalt.='<select name="'.$this->prefixId.'[feuser][]" multiple style="height:300px;">';
				$sql="Select * FROM fe_users";
				$result=mysql_query($sql);
				while($rs=mysql_fetch_array($result)){
					$sql="Select group_concat(cast(title as char)) as titles FROM tx_exabiscompetences_educationlevels where fe_owner=".$rs["uid"];
					$titles="";
					$resultt=mysql_query($sql);
					if (mysql_num_rows($resultt)>0){
						$rst=mysql_fetch_array($resultt);
						$titles=" (".substr($rst["titles"],0,20).")";
					}
					$sql="Select group_concat(cast(title as char)) as titles FROM tx_exabiscompetences_schooltypes where fe_owner=".$rs["uid"];
					$st="";
					$results=mysql_query($sql);
				
					if (mysql_num_rows($results)>0){
						$rss=mysql_fetch_array($results);
						$st=" (".substr($rss["titles"],0,20).")";
					}
					
					$sql="Select group_concat(cast(title as char)) as titles FROM tx_exabiscompetences_subjects where fe_owner=".$rs["uid"];
					$su="";
					$resultsu=mysql_query($sql);
					if (mysql_num_rows($resultsu)>0){
						$rsu=mysql_fetch_array($resultsu);
						$su=" (".substr($rsu["titles"],0,20).")";
					}
					
					$sql="Select group_concat(cast(title as char)) as titles FROM tx_exabiscompetences_topics where fe_owner=".$rs["uid"];
					$top="";
					$resulttop=mysql_query($sql);
					if (mysql_num_rows($resulttop)>0){
						$rstop=mysql_fetch_array($resulttop);
						$top=" (".substr($rstop["titles"],0,20).")";
					}
					$sql="Select group_concat(cast(title as char)) as titles FROM tx_exabiscompetences_descriptors where fe_owner=".$rs["uid"];
					$des="";
					$resultdes=mysql_query($sql);
					if (mysql_num_rows($resultdes)>0){
						$rsdes=mysql_fetch_array($resultdes);
						$des=" ".$rsdes["titles"]."";
					}
					
					$sql="Select group_concat(cast(title as char)) as titles FROM tx_exabiscompetences_examples where fe_owner=".$rs["uid"];
					$ex="";
					$resultex=mysql_query($sql);
					if (mysql_num_rows($resultex)>0){
						$rsex=mysql_fetch_array($resultex);
						$ex=" ".$rsex["titles"]."";
					}
					$inhalt.='<option title="'.$des.'" value="'.$rs["uid"].'">'.$rs["username"].' '.$rs["name"].$titles.$st.$su.$top.'('.substr($des,0,20).') (ex:'.substr($ex,0,20).'</option>';
				}
				$inhalt.='</select>';
				$inhalt.='<input type="submit" name="'.$this->prefixId.'[submitdeluser]">';
				$inhalt.="</form>";
			}
		}elseif (t3lib_div::_GP("b")=="dataerrors") {
			/*block_exacomp_deleteIfNoSubcategories("block_exacompsubjects","block_exacomptopics","subjid",$source);
				block_exacomp_deleteIfNoSubcategories("block_exacompschooltypes","block_exacompsubjects","stid",$source);
				block_exacomp_deleteIfNoSubcategories("block_exacompedulevels","block_exacompschooltypes","elid",$source);
			*/
			$inhalt.='<a href="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>"deluser")).'">Benutzerdaten löschen</a>';
			$inhalt.="<h1>mögliche inkonsistenzen</h1>";
			$tempi=$this->listIfNoSubcategories("tx_exabiscompetences_educationlevels","tx_exabiscompetences_schooltypes","elid");
			$inhalt.="<h3>Schultypen ohne Schulstufen</h3>".$tempi;
			$tempi=$this->listIfNoSubcategories("tx_exabiscompetences_schooltypes","tx_exabiscompetences_subjects","stid");
			$inhalt.="<h3>Gegenstände ohne Schultypen</h3>".$tempi;
			$tempi=$this->listIfNoSubcategories("tx_exabiscompetences_subjects","tx_exabiscompetences_topics","subjid");
			$inhalt.="<h3>Topics ohne Subjects</h3>".$tempi;
			$tempi=$this->listIfNoSubcategoriesDescr();
			$inhalt.="<h3>Descriptoren ohne Topics</h3>".$tempi;
			
		}
		
		$inhalt.='</div>';
		$inhalt.=$this->showhilfe(t3lib_div::_GP("b"),0);
		
		$inhalt.='</div>';
		return $this->pi_wrapInBaseClass($inhalt);
	}
	function showhilfe($b,$top){
		$inhalt="";
		if (!empty($b)){
			if(($this->conf["hilfe_onTop"]==1 && $top==1) || ($this->conf["hilfe_onTop"]!=1 && $top==0)){
				$inhalt.='<div class="hilfetext contentwrapper">'.$this->pi_getLL("hilfe_".$b).'</div>';
			}
		}
		return $inhalt;
	}
	function listIfNoSubcategories($parenttable,$subtable,$subforeignfield) {
		$inhalt="";
		$sql='SELECT * FROM '.$subtable.' st 
		WHERE fe_owner="'.$GLOBALS["TSFE"]->fe_user->user["uid"].'" 
		AND '.$subforeignfield.' NOT IN(Select uid FROM '.$parenttable.' WHERE  uid=st.'.$subforeignfield.')';
		$result = mysql_query($sql);
		if (mysql_num_rows($result)>0){
			while ($rs=mysql_fetch_array($result)) {
				$inhalt.=$rs["uid"]." ".$rs["title"]."<br>";
			}
		}
		return $inhalt;
	}
	function listIfNoSubcategoriesDescr() {
		$inhalt="";
		$sql='SELECT * FROM tx_exabiscompetences_descriptors st 
		WHERE fe_owner="'.$GLOBALS["TSFE"]->fe_user->user["uid"].'" 
		AND uid NOT IN(Select uid_local FROM tx_exabiscompetences_descriptors_topicid_mm mm INNER JOIN tx_exabiscompetences_topics top ON top.uid=mm.uid_foreign WHERE uid_local=st.uid)';
		
		$result = mysql_query($sql);
		if (mysql_num_rows($result)>0){
			while ($rs=mysql_fetch_array($result)) {
				$inhalt.=$rs["uid"]." ".$rs["title"]."<br>";
			}
		}
		return $inhalt;
	}
	function checked_show_all(){
		$sql="SELECT * FROM tx_exabiscompetences_settings WHERE fe_user=".$GLOBALS["TSFE"]->fe_user->user["uid"];
			$result=mysql_query($sql);
			if (mysql_num_rows($result)>0) {
				$rs=mysql_fetch_array($result);
				if ($rs["showall"]==1) return true;
			}
			return false;
	}
	function hidepath($wert){
		//für die anzeige, nur den dateinamen anzeigen, nicht den pfad dazu
		$wert=str_replace("uploads/tx_exabiscompetences/","",$wert);
		return $wert;
	}
	function storeImage($datei,$bildpfad,$dbwert)	{
		
		//t3lib_div::debug($_FILES[$this->prefixId]);
		if($_FILES[$this->prefixId][tmp_name][$datei]){
			$sauber = $this->fileFunc->cleanFileName($_FILES[$this->prefixId]["name"][$datei]);
			$sauber = $this->clean2($sauber);
			//echo "sauber:".$sauber."<br>";
			$uniquename=$this->fileFunc->getUniqueName($sauber,$bildpfad);
			//echo "unique:".$uniquename."<br>";
			move_uploaded_file($_FILES[$this->prefixId]["tmp_name"][$datei],$uniquename);
			if (file_exists($bildpfad."/".$dbwert)){
				unlink($bildpfad."/".$dbwert);
			}
			return $uniquename;
		}else{
			return $dbwert;
		}
		
	}
	
	function clean2($filename){
		$umlaute = Array("/ä/","/ö/","/ü/","/Ä/","/Ö/","/Ü/","/ß/","/JPG/");
    $replace = Array("ae","oe","ue","Ae","Oe","Ue","ss","jpg");
    $filename = preg_replace($umlaute,$replace,$filename);
		return $filename;
	}
	function get_related_examples_ids($id,$art=1){
		$sql="select group_concat(cast(uid_local as BINARY)) as ids FROM tx_exabiscompetences_examples_descrid_mm mm WHERE mm.uid_foreign IN (".$id.")";
		$result=mysql_query($sql);
		$rs_ex=mysql_fetch_array($result);
		return $rs_ex["ids"];
	}
	function get_related_descr_ids($id,$art=1){
		$sql="select group_concat(cast(uid_local as BINARY)) as ids FROM tx_exabiscompetences_descriptors_topicid_mm mm WHERE mm.uid_foreign IN (".$id.")";
		$result=mysql_query($sql);
		$rs_ex=mysql_fetch_array($result);
		return $rs_ex["ids"];
	}
	function get_related_topic_ids($id,$art=1){
		$sql="select group_concat(cast(uid as BINARY)) as ids FROM tx_exabiscompetences_topics WHERE subjid = ".$id;
		$result=mysql_query($sql);
		$rs_ex=mysql_fetch_array($result);
		return $rs_ex["ids"];
	}
	function copytopic($ids,$subjid){
		$returnids=array();
		$sql="SELECT uid,pid,tstamp,crdate,sorting,title,subjid,fe_owner,fe_creator FROM tx_exabiscompetences_topics WHERE uid IN (".$ids.")";
		$result=mysql_query($sql);
		while($rs=mysql_fetch_array($result)){
			$returnids[$rs["uid"]]=$this->new_rec("tx_exabiscompetences_topics",Array("tstamp"=>time(),"crdate"=>time(),"pid"=>$this->conf["pid_data"],"sorting"=>$rs["sorting"],"title"=>$rs["title"]." Kopie","subjid"=>$subjid,"fe_owner"=>$GLOBALS["TSFE"]->fe_user->user["uid"],"fe_creator"=>$GLOBALS["TSFE"]->fe_user->user["uid"]));
		}
		return $returnids;
	}
	function add_str($wert,$str,$vorne=0,$voraussetzung=1){
		if (!empty($wert) && !empty($voraussetzung)){
			if ($vorne==1) $wert=$str.$wert;
			else $wert.=$str;
		} else $wert="";
		return $wert;
	}
	function copydescr($ids){
		$returnids=array();
		$sql="SELECT uid,pid,tstamp,crdate,sorting,title,niveauid,skillid,parent_id,fe_owner,fe_creator FROM tx_exabiscompetences_descriptors WHERE uid IN (".$ids.")";
		$result=mysql_query($sql);
		while($rs=mysql_fetch_array($result)){
			$returnids[$rs["uid"]]=$this->new_rec("tx_exabiscompetences_descriptors",Array("tstamp"=>time(),"crdate"=>time(),"pid"=>$this->conf["pid_data"],"sorting"=>$rs["sorting"],"title"=>$rs["title"]." Kopie","niveauid"=>$rs["niveauid"],"skillid"=>$rs["skillid"],"parent_id"=>$rs["parent_id"],"topicid"=>"1","fe_owner"=>$GLOBALS["TSFE"]->fe_user->user["uid"],"fe_creator"=>$GLOBALS["TSFE"]->fe_user->user["uid"]));
		}
		return $returnids;
	}
	function copyexamples($ids){
		$returnids=array();
		$sql="SELECT uid,pid,tstamp,crdate,sorting,title,task,solution,attachement,completefile,externalurl,taxid,timeframe,ressources,tips,externalsolution,externaltask,descrid,description,fe_owner,fe_creator,lang FROM tx_exabiscompetences_examples WHERE uid IN (".$ids.")";
		$result=mysql_query($sql);
		while($rs=mysql_fetch_array($result)){
			$returnids[$rs["uid"]]=$this->new_rec("tx_exabiscompetences_examples",Array("tstamp"=>time(),"crdate"=>time(),"pid"=>$this->conf["pid_data"],"sorting"=>$rs["sorting"],"title"=>$rs["title"]." Kopie","task"=>$rs["task"],"solution"=>$rs["solution"],"attachement"=>$rs["attachement"],"externaltask"=>$rs["externaltask"],"lang"=>$rs["lang"],"completefile"=>$rs["completefile"],"externalurl"=>$rs["externalurl"],"taxid"=>$rs["taxid"],"timeframe"=>$rs["timeframe"],"ressources"=>$rs["ressources"],"tips"=>$rs["tips"],"externalsolution"=>$rs["externalsolution"],"descrid"=>"1","description"=>$rs["description"],"fe_owner"=>$GLOBALS["TSFE"]->fe_user->user["uid"],"fe_creator"=>$GLOBALS["TSFE"]->fe_user->user["uid"]));
		}
		return $returnids;
	}
	function update_parentid($newdescrs){
		//nach kopieren der descriptoren die parentid austauschen auf die uid des neu kopierten descriptors
		foreach ($newdescrs as $k=>$v){
			$sql="SELECT parent_id FROM tx_exabiscompetences_descriptors WHERE uid=".$v;
			$result=mysql_query($sql);
			$rs=mysql_fetch_array($result);
			
			$sql="UPDATE tx_exabiscompetences_descriptors SET parent_id=".$newdescrs[$rs["parent_id"]]." WHERE uid=".$v;
			$result=mysql_query($sql);
		}
	}
	function get_related_subj_ids($id,$art=1){
		$sql="select group_concat(cast(uid as BINARY)) as ids FROM tx_exabiscompetences_subjects WHERE stid = ".$id;
		$result=mysql_query($sql);
		$rs_ex=mysql_fetch_array($result);
		return $rs_ex["ids"];
	}
	function get_related_st_ids($id,$art=1){
		$sql="select group_concat(cast(uid as BINARY)) as ids FROM tx_exabiscompetences_schooltypes WHERE elid = ".$id;
		$result=mysql_query($sql);
		$rs_ex=mysql_fetch_array($result);
		return $rs_ex["ids"];
	}
	
	
	function copy_topicdescrmm($newtopics,$newdescrs){
		foreach($newtopics as $k=>$v){
			$sql="SELECT * FROM tx_exabiscompetences_descriptors_topicid_mm WHERE uid_foreign=".$k;
			$result=mysql_query($sql);
			while ($rs=mysql_fetch_array($result)){
				$sql="INSERT INTO tx_exabiscompetences_descriptors_topicid_mm (uid_local,uid_foreign) VALUES (".$newdescrs[$rs["uid_local"]].",".$v.")";

				mysql_query($sql);
			}
		}
	}
	function copy_exampdescrmm($newdescrs,$newexamples){
		foreach($newdescrs as $k=>$v){
			$sql="SELECT * FROM tx_exabiscompetences_examples_descrid_mm WHERE uid_foreign=".$k;
			$result=mysql_query($sql);
			while ($rs=mysql_fetch_array($result)){
				$sql="INSERT INTO tx_exabiscompetences_examples_descrid_mm (uid_local,uid_foreign) VALUES (".$newexamples[$rs["uid_local"]].",".$v.")";
				mysql_query($sql);
			}
		}
	}
	function get_related_examples_fremd_ids($ids){
		$sql="select group_concat(cast(examp.uid as BINARY)) as ids FROM tx_exabiscompetences_examples examp WHERE uid IN (".$ids.") AND (fe_owner<>".$GLOBALS["TSFE"]->fe_user->user["uid"].")";
		$result=mysql_query($sql);
		$rs_ex=mysql_fetch_array($result);
		return $rs_ex["ids"];
	}
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
				
	function get_sql($t3tabl,$mdltbl,$fields,$fieldsmdl,$path_uploadfolder,$WHERE="",$dateien="initial",$cdatarr=array()){
				 	
				 	$fieldlst=implode(",",$fields);
				 	$fieldlstmdl=implode(",",$fieldsmdl);
				 	if ($WHERE=="") $WHERE="1=1";
				 	$dateiliste=explode(",",$dateien);
				 	$fieldlstmdl=str_replace("uid,","id,",$fieldlstmdl);
				 	
				 	$sql='SELECT '.$fieldlst.' FROM '.$t3tabl.' WHERE '.$WHERE;
				 	if ($t3tabl=="tx_exabiscompetences_descriptors_topicid_mm") {
				 		//echo "---".$WHERE;
				 		//echo $sql."<br>";
				 }
					/*if ($t3tabl=="tx_exabiscompetences_descriptors_topicid_mm"){
						echo $sql;
						echo "--".$fields[0]."--".$fields[1];
				 		echo "--".$fieldsmdl[0]."--".$fieldsmdl[1]."<br>";
					}*/
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
				 				if (!empty($cdatarr[$zae])) {$wert=$this->cdatawrap($wert);}
				 			}
					 		$sqlxml.='		<'.$field.'>'.(str_replace("&","&amp;",$wert)).'</'.$field.'>'."\n";
					 		$zae++;
					 	}
					 	if ($t3tabl=="tx_exabiscompetences_examples_descrid_mm"){
					 		if ($GLOBALS["TSFE"]->fe_user->user["uid"]!=1 && $this->is_owner($rs["uid_foreign"],$GLOBALS["TSFE"]->fe_user->user["uid"],"tx_exabiscompetences_descriptors")) $srct=0;
					 		else $srct=1;
					 		$sqlxml.='		<source>'.$srct.'</source>'."\n";
					 	}
					 	$sqlxml.='	</table>'."\n";
				 	} 
				 	
				 	return $sqlxml;
	}
	function get_table_data($tablename,$id){
		$sql="SELECT * FROM ".$tablename." WHERE uid=".$id;
		
		$result=mysql_query($sql);
		$rs=mysql_fetch_array($result);
		return $rs;
	}
	function get_last_sortoftable($tablename){
		$sql="SELECT sorting FROM ".$tablename." ORDER BY sorting DESC LIMIT 0,1";
		$result=mysql_query($sql);
		$rs=mysql_fetch_array($result);
		return ($rs["sorting"]+1);
	}
	function getownership($tablename,$uid){
		
		if ($GLOBALS["TSFE"]->fe_user->user["uid"]==1){
			//$sql="Update  set fe_owner=1 WHERE uid=".$descid
		
			$res=$GLOBALS['TYPO3_DB']->exec_UPDATEquery($tablename,"uid=".$uid,array("fe_owner"=>"1"));
			//echo $res;
		}
	}
	function is_owner($id,$user,$tablename){
		$sql="Select * FROM ".$tablename." WHERE uid=".$id." AND fe_owner=".$user;
		$result=mysql_query($sql);
		if (mysql_num_rows($result)>0) return true;
		else return false;
	}
	function is_creator($id,$user,$tablename){
		$sql="Select * FROM ".$tablename." WHERE uid=".$id." AND fe_creator=".$user;
		$result=mysql_query($sql);
		if (mysql_num_rows($result)>0) return true;
		else return false;
	}
	function delete_record($id,$tablename){
		
		if ($tablename=="tx_exabiscompetences_examples"){
			$sql="SELECT * FROM tx_exabiscompetences_examples WHERE uid=".$id;
			//echo $sql;
			
			$result=mysql_query($sql);
			$rs=mysql_fetch_array($result);
			if (!empty($rs)){
				$this->delfile($this->bildpfad."/".$rs["task"]);
				$this->delfile($this->bildpfad."/".$rs["solution"]);
				$this->delfile($this->bildpfad."/".$rs["completefile"]);
				$this->delfile($this->bildpfad."/".$rs["attachement"]);
			}
			$sql="DELETE FROM tx_exabiscompetences_examples_descrid_mm WHERE uid_local=".$id;
			$result=mysql_query($sql);
		}
		if ($tablename=="tx_exabiscompetences_descriptors"){
			$sql="DELETE FROM tx_exabiscompetences_descriptors_topicid_mm WHERE uid_local=".$id;
			$result=mysql_query($sql);
		}
		$sql="DELETE FROM ".$tablename." WHERE uid=".$id;
		mysql_query($sql);
	}
	function deleteExampleFile($rs,$filea,$tablename,$id){
		if ($GLOBALS["TSFE"]->fe_user->user["uid"]==$rs["fe_crator"] || $GLOBALS["TSFE"]->fe_user->user["uid"]==$rs["fe_owner"]){
			if ($filea=="task") {
				$this->delfile($this->bildpfad."/".$rs["task"]);
				$data["task"]="";
			};
			if ($filea=="sol") {
				$this->delfile($this->bildpfad."/".$rs["solution"]);
				$data["solution"]="";
			}
			if ($filea=="compl") {
				$this->delfile($this->bildpfad."/".$rs["completefile"]);
				$data["completefile"]="";
			}
			if ($filea=="att"){
				 $this->delfile($this->bildpfad."/".$rs["attachement"]);
				 $data["attachement"]="";
			}
			$GLOBALS['TYPO3_DB']->exec_UPDATEquery($tablename,"uid=".$id,$data);
		}
	}
	function delfile($filen){
		if (file_exists($filen)) unlink($filen);
	}
	
	function makefilter(){
		$inhalt='<td class="filterhead">'.$this->pi_getLL("Filtern_nach").':</td>';
		$inhalt.='<td class="filterpd"><form enctype="multipart/form-data" name="formularflt" method="post" action="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>t3lib_div::_GP("b"),"f"=>$this->f,"f2"=>$this->f2)).'">';
	/*$whereanh='';
	if ($GLOBALS["TSFE"]->fe_user->user["uid"]==1){}
	else if (!$this->checked_show_all()) $whereanh=' WHERE fe_creator='.$GLOBALS["TSFE"]->fe_user->user["uid"];
	else $whereanh=' WHERE (fe_owner=1 OR fe_creator='.$GLOBALS["TSFE"]->fe_user->user["uid"].')';
	$sql="SELECT * FROM tx_exabiscompetences_subjects ".$whereanh;
	echo $sql;*/
	$inhalt.='<select onchange="document.formularflt.submit();" name="tx_exabiscompetences_pi1[pd_flt]">';
	$inhalt.=$this->getSubjectFilerOptions(0,$this->f)->content_pd;
	//$inhalt.=$this->create_pulldown("tx_exabiscompetences_subjects","pd_flt","title",$this->f,true,"","uid",$whereanh,"uid",'onchange="document.formularflt.submit();"',$ka_wert=$this->pi_getLL("bitte_Auswahl_treffen"),$joint="",$sqlu="");
	$inhalt.='</select>';
	$inhalt.='</form></td>';
	return $inhalt;
	}
	function makefilter2(){
		if ($this->conf["hide_filter_skills"]==1){$inhalt="";}
		else{
			$inhalt.='<td class="filterpd2"><form enctype="multipart/form-data" name="formularflt2" method="post" action="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>t3lib_div::_GP("b"),"f"=>$this->f,"f2"=>$this->f2)).'">';
			$inhalt.=$this->create_pulldown("tx_exabiscompetences_skills","pd_flt2","title",$this->f2,true,"","uid","WHERE sys_language_uid=".$this->languageid." ORDER BY title","uid",'onchange="document.formularflt2.submit();"',$ka_wert=$this->pi_getLL("bitte_Auswahl_treffen"),$joint="",$sqlu="");
			$inhalt.='</form></td>';
		}
		return $inhalt;
	}
	function change_sorting($uid1,$uid2,$tablename){
		$arr=array();
		$sql="SELECT * FROM ".$tablename." WHERE uid=".$uid1." OR uid=".$uid2;
		//echo $sql;
		$result=mysql_query($sql);
		$i=0;
		while($rs=mysql_fetch_array($result)){
			$arr[$i]=$rs["uid"];$arr[$i+1]=$rs["sorting"];
			$i=($i+2);
		}

		$sql="UPDATE ".$tablename." SET sorting=".$arr[3]." WHERE uid=".$arr[0];
		mysql_query($sql);
		$sql="UPDATE ".$tablename." SET sorting=".$arr[1]." WHERE uid=".$arr[2];
		mysql_query($sql);
	}
	

	function makelist($tablename,$fegruppe){
		$GLOBALS['TSFE']->additionalHeaderData[$this->extKey] .= '<script src="'.t3lib_extMgm::siteRelPath($this->extKey).'pi1/JS/jquery-1.9.1.min.js" type="text/javascript"></script>';	
		$GLOBALS['TSFE']->additionalHeaderData[$this->extKey] .= '<script src="'.t3lib_extMgm::siteRelPath($this->extKey).'pi1/JS/jquery-ui.min.js" type="text/javascript"></script>';	
		$GLOBALS['TSFE']->additionalHeaderData[$this->extKey] .= '<script src="'.t3lib_extMgm::siteRelPath($this->extKey).'pi1/JS/competencies_funcs.js" type="text/javascript"></script>';	

		$filter=false;
		$inhalt.="<table><tr>";
		$whereanh=' (fe_creator='.$GLOBALS["TSFE"]->fe_user->user["uid"].' OR fe_owner=1)';
		if (!$this->checked_show_all()) $whereanh=' fe_creator='.$GLOBALS["TSFE"]->fe_user->user["uid"];
		if ($GLOBALS["TSFE"]->fe_user->user["uid"]==1) $whereanh=' 1=1';
		
		if (t3lib_div::_GP("b")=="topic"){
					$inhalt.=$this->makefilter();
					if($this->f!="" AND $this->f!="-1") $whereanh.=' AND subjid='.$this->f.' ';
		}
		if (t3lib_div::_GP("a")=="srtu" OR t3lib_div::_GP("a")=="srtd"){
					$this->change_sorting(intval(t3lib_div::_GP("srt1")),intval(t3lib_div::_GP("srt2")),$tablename);
		}
		if (t3lib_div::_GP("b")=="subj"){
			if ($GLOBALS["TSFE"]->fe_user->user["uid"]==1) $whereanh=' 1=1';
			else if (!$this->checked_show_all()) $whereanh=' sub.fe_creator='.$GLOBALS["TSFE"]->fe_user->user["uid"];
			else $whereanh=' (sub.fe_creator='.$GLOBALS["TSFE"]->fe_user->user["uid"].' OR sub.fe_owner=1)';
			
			//$sql="SELECT sub.*, st.title as stname FROM ".$tablename." sub INNER JOIN tx_exabiscompetences_schooltypes st ON st.uid=sub.stid WHERE ".$whereanh."(sub.fe_creator=".$GLOBALS["TSFE"]->fe_user->user["uid"]." OR sub.fe_owner=1) ORDER BY st.title,sub.SORTING";
			$sql="SELECT sub.*, st.title as stname FROM ".$tablename." sub INNER JOIN tx_exabiscompetences_schooltypes st ON st.uid=sub.stid WHERE ".$whereanh." ORDER BY st.title,sub.SORTING";
		}else if (t3lib_div::_GP("b")=="schoolt"){
			if ($GLOBALS["TSFE"]->fe_user->user["uid"]==1) $whereanh=' 1=1';
			else if (!$this->checked_show_all()) $whereanh=' st.fe_creator='.$GLOBALS["TSFE"]->fe_user->user["uid"];
			else $whereanh=' (st.fe_creator='.$GLOBALS["TSFE"]->fe_user->user["uid"].' OR st.fe_owner=1)';
			
			//$sql="SELECT sub.*, st.title as stname FROM ".$tablename." sub INNER JOIN tx_exabiscompetences_schooltypes st ON st.uid=sub.stid WHERE ".$whereanh."(sub.fe_creator=".$GLOBALS["TSFE"]->fe_user->user["uid"]." OR sub.fe_owner=1) ORDER BY st.title,sub.SORTING";
			$sql="SELECT st.*, el.title as elname FROM ".$tablename." st INNER JOIN tx_exabiscompetences_educationlevels el ON el.uid=st.elid WHERE ".$whereanh." ORDER BY el.title,st.SORTING";
	
		}else if (t3lib_div::_GP("b")=="descr"){
					
					
					$inhalt.=$this->makefilter();
					$inhalt.=$this->makefilter2();
					if($this->f2!="" AND $this->f2!="-1") {
						$wheref2=' AND skillid='.$this->f2;$filter=true;
					}else{
						$wheref2='';
					}
					if($this->f!="" AND $this->f!="-1") {
						$filter=true;
						if ($GLOBALS["TSFE"]->fe_user->user["uid"]==1) $whereanh2=' AND 1=1';
						else if (!$this->checked_show_all()) $whereanh2=' AND sub.fe_creator='.$GLOBALS["TSFE"]->fe_user->user["uid"];
						else $whereanh2=' AND (sub.fe_creator='.$GLOBALS["TSFE"]->fe_user->user["uid"].' OR sub.fe_owner=1)';
						
						$sql='SELECT descr.sorting as sorting, descr.title,descr.uid,descr.fe_owner,descr.fe_creator FROM tx_exabiscompetences_descriptors descr INNER JOIN tx_exabiscompetences_descriptors_topicid_mm mm ON descr.uid=mm.uid_local INNER JOIN tx_exabiscompetences_topics top on top.uid=mm.uid_foreign INNER JOIN tx_exabiscompetences_subjects sub ON sub.uid=top.subjid';
						$sql.=' WHERE sub.uid='.$this->f;
						$sql.=$wheref2;
						//$sql.=' AND (descr.fe_creator='.$GLOBALS["TSFE"]->fe_user->user["uid"].' OR descr.fe_owner=1) GROUP BY descr.title,descr.uid ORDER BY descr.sorting';
						$sql.=$whereanh2.' GROUP BY descr.title,descr.uid ORDER BY descr.sorting';
					}else{
						//$sql="SELECT * FROM ".$tablename." WHERE ".$whereanh." (fe_creator=".$GLOBALS["TSFE"]->fe_user->user["uid"]." OR fe_owner=1)".$wheref2." ORDER BY SORTING";
						$sql="SELECT * FROM ".$tablename." WHERE ".$whereanh." ".$wheref2." ORDER BY SORTING";
					};
		}else	if (t3lib_div::_GP("b")=="examp"){
					$inhalt.=$this->makefilter();
					$inhalt.=$this->makefilter2();
					if($this->f>0) {
						if ($GLOBALS["TSFE"]->fe_user->user["uid"]==1) $whereanh=' 1=1';
						else if (!$this->checked_show_all()) $whereanh=' examp.fe_creator='.$GLOBALS["TSFE"]->fe_user->user["uid"];
						else $whereanh=' (examp.fe_creator='.$GLOBALS["TSFE"]->fe_user->user["uid"].' OR examp.fe_owner=1)';
						$sql='SELECT examp.sorting as sorting, examp.title,examp.uid,examp.fe_owner,examp.fe_creator,examp.task,examp.solution,examp.attachement,examp.externaltask,examp.completefile,examp.externalurl,examp.lang FROM tx_exabiscompetences_examples examp INNER JOIN tx_exabiscompetences_examples_descrid_mm emm ON examp.uid=emm.uid_local INNER JOIN tx_exabiscompetences_descriptors descr ON descr.uid=emm.uid_foreign INNER JOIN tx_exabiscompetences_descriptors_topicid_mm mm ON descr.uid=mm.uid_local INNER JOIN tx_exabiscompetences_topics top on top.uid=mm.uid_foreign INNER JOIN tx_exabiscompetences_subjects sub ON sub.uid=top.subjid';
						//$sql.=' WHERE sub.uid='.$this->f.' AND (examp.fe_creator='.$GLOBALS["TSFE"]->fe_user->user["uid"].' OR examp.fe_owner=1) GROUP BY examp.title,examp.uid  ORDER BY examp.sorting';
						$sql.=' WHERE sub.uid='.$this->f.' AND '.$whereanh.' GROUP BY examp.title,examp.uid  ORDER BY examp.sorting';
					}else{
						//$sql="SELECT * FROM ".$tablename." WHERE ".$whereanh."(fe_creator=".$GLOBALS["TSFE"]->fe_user->user["uid"]." OR fe_owner=1)  ORDER BY SORTING";
						$sql="SELECT * FROM ".$tablename." WHERE ".$whereanh." ORDER BY SORTING";
					}
		}else{
			//$sql="SELECT * FROM ".$tablename." WHERE ".$whereanh."(fe_creator=".$GLOBALS["TSFE"]->fe_user->user["uid"]." OR fe_owner=1) ORDER BY SORTING";
			
			$sql="SELECT * FROM ".$tablename." WHERE ".$whereanh." ORDER BY SORTING";
			
		}
		//echo $sql;

		$inhalt.="<td>".$this->makenewbutton($fegruppe)."</td>";
		$inhalt.='<td>###FORMTAG###<select name="'.$this->prefixId.'[CAction]"><option value=0>-- ausgewählte Datensätze --</option><option value=1>löschen</option></select></td>';
		$inhalt.='<td><input type="submit" value="ausführen!"></td>';
		$inhalt.="</tr></table>";
			$result=mysql_query($sql);
			$paramsd=array("b"=>t3lib_div::_GP("b"),"a"=>"g");
			$paramsd["f"]=$this->f;
			$paramsd["f2"]=$this->f2;
			$inhalt.='<script type="text/javascript">var target="'.$tablename.'";</script>';	
			$formt='<form enctype="multipart/form-data" name="formularlist" method="post" action="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',$paramsd).'">';
			$inhalt=str_replace("###FORMTAG###",$formt,$inhalt);
			$inhalt.='<table class="sort tx_exacomp_tedit '.$tablename.'">';
			$inhalt.='<thead><th>'.$this->pi_getLL("Bezeichnung").'</th><th></th><th></th><th></th><th><img src="typo3conf/ext/exabis_competences/pi1/edit2.gif" border="0"></th><th><img src="typo3conf/ext/exabis_competences/pi1/delete_record.gif" border="0"></th><th></th><th>';
			if ($GLOBALS["TSFE"]->fe_user->user["uid"]==1){
				$inhalt.="Admin zuordnen";
			}
			$inhalt.="</th></thead>";
			$inhalt.="<tbody>";
			$svebtn=false;
			$subheadr="init";
			$stheadr="init";
			$getowner=false;
			$i=1;$uidbefore="";
			$anz=mysql_num_rows($result);
			if ((t3lib_div::_GP("b")=="descr" || t3lib_div::_GP("b")=="examp" || t3lib_div::_GP("b")=="topic") && ($anz > 30) && ($filter==false)){
				$inhalt.="<tr><td colspan='7' style='color:#8B0000'><h2>".$this->pi_getLL("Filter_waehlen")."</h2></td></tr>";
			}else{
				while($rs=mysql_fetch_array($result)){
					$showrec=true;
					if ($rs["title"]==""){//leere einträge löschen, können entstehen wenn auf neu geklickt und dann keine weiteren daten eingeben
						$erg=$this->delete_record_possible(t3lib_div::_GP("b"),$rs["uid"],"kein Titel");
						if ($erg=="") {
							$this->delete_record($rs["uid"],$tablename);
							$showrec=false;
						}
					}
					if ($showrec==true){
						if (t3lib_div::_GP("b")=="schoolt"){
							if ($stheadr!=$rs["elname"]) $inhalt.='<tr><td class="tx_exacomp_header"><b>'.$rs["elname"].'</b></td></tr>';
							$stheadr=$rs["elname"];
						}else	if (t3lib_div::_GP("b")=="subj"){
							if ($subheadr!=$rs["stname"]) $inhalt.='<tr><td class="tx_exacomp_header"><b>'.$rs["stname"].'</b></td></tr>';
							$subheadr=$rs["stname"];
						}
						
						$inhalt.='<tr id="recordsArray['.$rs["uid"].']_'.$rs["sorting"].'"><td class="tx_exacomp_title">'.$rs["title"].'<input type="hidden" name="'.$this->prefixId.'[title]['.$rs["uid"].']" value="'.$rs["title"].'"></td><td class="beispiele_icons"><nobr>';
						if (t3lib_div::_GP("b")=="examp"){
							
							if ($rs["task"]!="") $inhalt.='<a href="'.$this->bildpfad.'/'.$rs["task"].'"><img src="typo3conf/ext/exabis_competences/pi1/pdf.gif" title="Aufgabe: '.$rs["task"].'"></a>';
							if ($rs["solution"]!="") $inhalt.='<a href="'.$this->bildpfad.'/'.$rs["solution"].'"><img src="typo3conf/ext/exabis_competences/pi1/pdf_solution.gif" title="Lösung: '.$rs["solution"].'"></a>';
							if ($rs["attachement"]!="") $inhalt.='<a href="'.$this->bildpfad.'/'.$rs["attachement"].'"><img src="typo3conf/ext/exabis_competences/pi1/attach_2.png" title="Anhang: '.$rs["attachement"].'"></a>';
							if ($rs["externaltask"]!="") $inhalt.='<a href="'.$this->bildpfad.'/'.$rs["externaltask"].'"><img src="typo3conf/ext/exabis_competences/pi1/link.png" title="'.$rs["externaltask"].'"></a>';
							if ($rs["completefile"]!="") $inhalt.='<a href="'.$this->bildpfad.'/'.$rs["completefile"].'"><img src="typo3conf/ext/exabis_competences/pi1/folder.png" title="Complete File:'.$rs["completefile"].'"></a>';
							if ($rs["externalurl"]!="") $inhalt.='<a href="'.$rs["externalurl"].'"><img src="typo3conf/ext/exabis_competences/pi1/link.gif" title="External link:'.$rs["externalurl"].'"></a>';
						
						}
						$inhalt.='</nobr></td>';
						//echo $rs["fe_creator"]."####".$GLOBALS["TSFE"]->fe_user->user["uid"]."<br>";
						
						
						$inhalt.='<td>';
						$inhalt=str_replace("xxx",$rs["uid"],$inhalt);
						if ($uidbefore!=""){
							$paramsd["a"]="srtu";$paramsd["srt1"]=$rs["uid"];$paramsd["srt2"]=$uidbefore;
							$inhalt.='<a href="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',$paramsd).'"><img src="typo3/sysext/t3skin/icons/gfx/button_up.gif"></a>';
						}
					
						$inhalt.='</td>';
						$paramsd["a"]="srtd";$paramsd["srt1"]=$rs["uid"];$paramsd["srt2"]="xxx";
						$inhalt.='<td>';
						if ($anz>$i){
							$inhalt.='<a href="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',$paramsd).'"><img src="typo3/sysext/t3skin/icons/gfx/button_down.gif">';
						}
						$inhalt.='</td>';
						if ($rs["fe_creator"]==$GLOBALS["TSFE"]->fe_user->user["uid"] || $rs["fe_owner"]==$GLOBALS["TSFE"]->fe_user->user["uid"]){
							$inhalt.='<td class="tx_exacomp_edit"><a href="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>t3lib_div::_GP("b"),"a"=>"e","recid"=>$rs["uid"],"f"=>$this->f,"f2"=>$this->f2)).'"><img src="typo3conf/ext/exabis_competences/pi1/edit2.gif" border="0"></a></td>';
						}else{
							$inhalt.='<td></td>';
						}
						if ($rs["fe_owner"]==$GLOBALS["TSFE"]->fe_user->user["uid"]){
							$inhalt.='<td class="tx_exacomp_delete"><a href="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array("b"=>t3lib_div::_GP("b"),"a"=>"d","recid"=>$rs["uid"],"f"=>$this->f,"f2"=>$this->f2)).'"><img src="typo3conf/ext/exabis_competences/pi1/delete_record.gif" border="0"></a></td>';
						}else{
							$inhalt.="<td></td>";
						}
						
						if ($GLOBALS["TSFE"]->fe_user->user["uid"]==$rs["fe_owner"]){
							$inhalt.='<td><input title="Datensatz Aktion" type="checkbox" name="'.$this->prefixId.'[cbaction]['.$rs["uid"].']" value="on"></td>';
						}else{
							$inhalt.="<td></td>";
						}
					
						if ($this->conf["HideCheckboxGetOwnership"]!=1 && $GLOBALS["TSFE"]->fe_user->user["uid"]==1 AND $rs["fe_owner"]!=1){
							$inhalt.='<td><input title="Diesen Datensatz dem Administrator zuordnen" type="checkbox" name="'.$this->prefixId.'[getowner]['.$rs["uid"].']" value="on"></td>';
							$getowner=true;
						}else{
							$inhalt.="<td></td>";
						}
						
						
						
						$inhalt.='</tr>';
						$this->lastsort=$rs["sorting"];
							//$inhalt.='<tr><td><input type="text" class="tx_exacomp_ititle"></td>';
						$i++;
						$uidbefore=$rs["uid"];
					}
				}//while
			}
			$inhalt.="</tbody></table>";
			if ($getowner && $GLOBALS["TSFE"]->fe_user->user["uid"]==1){
				$inhalt.='<input type="submit" value="Deskr Admin zuordnen">';
			}
			$inhalt.='</form>';
			
			return $inhalt;
		}
		function getSubjectFilerOptions($multiple,$fv=""){
							$vergl=array();$ret=new stdClass();$ret->filename_zusatz="";
							if ($multiple==1) {
								if(!empty($_POST["pd_subjects"])) $vergl=$_POST["pd_subjects"];
							}else{
								if(!empty($fv)) $vergl[]=$fv;
							}
							$content_pd='<option value="0">'.$this->pi_getLL("ALLE_ANZEIGEN").'</option>';
							if ($GLOBALS["TSFE"]->fe_user->user["uid"]==1) $whre=" WHERE 1=1";
							else if (!$this->checked_show_all()) {
								$whre=" WHERE subj.fe_creator=".$GLOBALS["TSFE"]->fe_user->user["uid"]; 
							}else{
								$whre=" WHERE (subj.fe_creator=".$GLOBALS["TSFE"]->fe_user->user["uid"]." OR subj.fe_owner=1)"; 
							}
							$sql="SELECT subj.title,subj.uid,st.title as st_title FROM tx_exabiscompetences_subjects subj INNER JOIN tx_exabiscompetences_schooltypes st ON st.uid=subj.stid ".$whre." ORDER BY st.sorting,subj.sorting";
							$result=mysql_query($sql);
					 		$hdr="initialisiert";
					 		while ($rs=mysql_fetch_assoc($result)){
					 			if ($hdr!=$rs["st_title"]){
					 				$content_pd.='<option value="" disabled style="font-style:italic;color:	#0088cc;"><i>&nbsp;&nbsp;&nbsp;'.$rs["st_title"].'</i></option>';
					 				$hdr=$rs["st_title"];
					 			}
					 			$content_pd.='<option value="'.$rs["uid"].'"';
					 			if (in_array($rs["uid"],$vergl)) {
					 				$content_pd.=' selected="selected"';
					 				$ret->filename_zusatz.=",".$rs["title"]."";
					 			}
					 			
					 			$content_pd.='>'.$rs["title"].'</option>';
					 		}
					 		$ret->content_pd=$content_pd;
					 		return $ret;
		}
		function deleteuserdata($uid){
			$sql="SELECT * FROM tx_exabiscompetences_examples WHERE fe_owner=".$uid;
			$result=mysql_query($sql);
			while ($rs=mysql_fetch_array($result)){
				$sql="Delete * FROM tx_exabiscompetences_examples_descrid_mm WHERE uid_local=".$rs["uid"];
				$inhalt.=$sql."<br>";
				mysql_query($sql);
			}
			$sql="DELETE FROM tx_exabiscompetences_examples WHERE fe_owner=".$uid;
			$inhalt.=$sql."<br>";
				mysql_query($sql);
			
			$sql="SELECT * FROM tx_exabiscompetences_descriptors WHERE fe_owner=".$uid;
			$result=mysql_query($sql);
			while ($rs=mysql_fetch_array($result)){
				$sql="Delete * FROM tx_exabiscompetences_descriptors_topicid_mm WHERE uid_local=".$rs["uid"];
				$inhalt.=$sql."<br>";
				mysql_query($sql);
			}
			$sql="DELETE FROM tx_exabiscompetences_descriptors WHERE fe_owner=".$uid;
			$inhalt.=$sql."<br>";
				mysql_query($sql);
			$sql="DELETE FROM tx_exabiscompetences_topics WHERE fe_owner=".$uid;
			$inhalt.=$sql."<br>";
				mysql_query($sql);
			$sql="DELETE FROM tx_exabiscompetences_subjects WHERE fe_owner=".$uid;
			$inhalt.=$sql."<br>";
				mysql_query($sql);
			$sql="DELETE FROM tx_exabiscompetences_schooltypes WHERE fe_owner=".$uid;
			$inhalt.=$sql."<br>";
				mysql_query($sql);
			$sql="DELETE FROM tx_exabiscompetences_educationlevels WHERE fe_owner=".$uid;
			$inhalt.=$sql."<br>";
				mysql_query($sql);
			$inhalt.="<br>Die Daten von ID=".$uid." wurden gelöscht<br>";
			
			$sql="DELETE FROM fe_users WHERE uid=".$uid;
			$inhalt.=$sql."<br>";
				mysql_query($sql);
				
			return $inhalt;
		}
		function makenewbutton($gruppe){
			$wert=intval($this->piVars["pd_flt"]);
			if ($this->has_capability($gruppe)){
				$params=array("b"=>t3lib_div::_GP("b"),"a"=>"n");
				
				
					
					$params["f"]=$this->f;
					$params["f2"]=$this->f2;
				
				$inhalt='<form enctype="multipart/form-data" name="formular" method="post" action="'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',$params).'">';
				$inhalt.='<input type="hidden" value="'.$this->lastsort.'" name="'.$this->prefixId.'[lastsort]">';
				$inhalt.='<input type="submit" value="'.$this->pi_getLL("neu").'">';
				$inhalt.='</form>';
				return $inhalt;
			}
		}
	function has_capability($gruppe){
		if ($GLOBALS["TSFE"]->fe_user->user["usergroup"]=="") return 0;
		else{
			$querygroup="SELECT title FROM fe_groups";
			$querygroup.=" WHERE (uid=".str_replace(","," OR uid=",$GLOBALS["TSFE"]->fe_user->user["usergroup"]).")";
			$querygroup.=" AND (title='".$gruppe."' OR title='alle')";
			
			$result = mysql_query($querygroup);
			if (mysql_num_rows($result)>0) return true; //feld hidden bekommt wert 0	
			else return false; //feld hidden bekommt wert1
		}
	}
	function new_rec($tablename,$felder){
		$res = $GLOBALS['TYPO3_DB']->exec_INSERTquery($tablename,$felder);
		return mysql_insert_id();
	}
	function clean_text($text) {

    if (empty($text) or is_numeric($text)) {
       return (string)$text;
    }
    $text = $this->fix_non_standard_entities($text);
    $text = strip_tags($text,"<br><b><p><i><h1><h2>");

		$text = str_replace('"',"'",$text);

    // Remove potential script events - some extra protection for undiscovered bugs in our code
    $text = preg_replace("~([^a-z])language([[:space:]]*)=~i", "$1Xlanguage=", $text);
    $text = preg_replace("~([^a-z])on([a-z]+)([[:space:]]*)=~i", "$1Xon$2=", $text);

    return $text;
	}
	function fix_non_standard_entities($string) {
    $text = preg_replace('/&#0*([0-9]+);?/', '&#$1;', $string);
    $text = preg_replace('/&#x0*([0-9a-fA-F]+);?/', '&#x$1;', $text);
    $text = preg_replace('[\x00-\x08\x0b-\x0c\x0e-\x1f]', '', $text);
    return $text;
	}
	function getsubjectname($id){
		$query="SELECT title FROM tx_exabiscompetences_subjects WHERE uid=".$id;
		$result = mysql_query($query);
			if (mysql_num_rows($result)>0){
				$rs=mysql_fetch_array($result);
				return $rs["title"];
			}else return ""; 
			
	}
	function delete_record_possible($b,$id,$tname){
		$inhalt="";
					if ($b=="descr"){
						$ex_ids=$this->get_related_examples_ids($id,1);
						if (!empty($ex_ids)){
							$inhalt.='<p class="delmessage">'.$this->add_str($tname,":").' '.$this->pi_getLL("zu_diesem").' '.$this->pi_getLL("Deskriptor").' '.$this->pi_getLL('sind').' '.$this->pi_getLL('Beispiele').' '.$this->pi_getLL('zugeordnet').'.'.$ex_ids.'</p>';
						}
					}
					if ($b=="topic"){
						$desc_ids=$this->get_related_descr_ids($id,1);
						//echo "###".$desc_ids."@@";
						if (!empty($desc_ids)){
							$inhalt.='<p class="delmessage">'.$this->add_str($tname,":").' '.$this->pi_getLL("zu_diesem").' '.$this->pi_getLL("Thema").' '.$this->pi_getLL('sind').' '.$this->pi_getLL('Deskriptoren').' '.$this->pi_getLL('zugeordnet').'</p>';
						}
					}
					if ($b=="subj"){
						$topic_ids=$this->get_related_topic_ids($id,1);
						if (!empty($topic_ids)){
							$inhalt.='<p class="delmessage">'.$this->add_str($tname,":").' '.$this->pi_getLL("zu_diesem").' '.$this->pi_getLL("Gegenstand").' '.$this->pi_getLL('sind').' '.$this->pi_getLL('Themen').' '.$this->pi_getLL('zugeordnet').'</p>';
						}
					}
					if ($b=="schoolt"){
						$subj_ids=$this->get_related_subj_ids($id,1);
						if (!empty($subj_ids)){
							$inhalt.='<p class="delmessage">'.$this->add_str($tname,":").' '.$this->pi_getLL("zu_diesem").' '.$this->pi_getLL("Schultype").' '.$this->pi_getLL('sind').' '.$this->pi_getLL('Gegenstaende').' '.$this->pi_getLL('zugeordnet').'</p>';
						}
					}
					if ($b=="edulev"){
						$st_ids=$this->get_related_st_ids($id,1);
						if (!empty($st_ids)){
							$inhalt.='<p class="delmessage">'.$this->add_str($tname,":").' '.$this->pi_getLL("zu_dieser").' '.$this->pi_getLL("Schulstufe").' '.$this->pi_getLL('sind').' '.$this->pi_getLL('Schultypen').' '.$this->pi_getLL('zugeordnet').'</p>';
						}
					}
			return $inhalt;
	}
	function getskillname($id){
		$query="SELECT title FROM tx_exabiscompetences_skills WHERE uid=".$id;
		$result = mysql_query($query);
			if (mysql_num_rows($result)>0){
				$rs=mysql_fetch_array($result);
				return $rs["title"];
			}else return ""; 
			
	}
	function cdatawrap($wert){
		if (!empty($wert) && $wert!=" ") $wert='<![CDATA['.$wert.']]>';
		return $wert;
	}
	function create_pulldown($tabellenname,$selectname,$anzeigefeld,$wert,$ka,$multiple,$optionvalue,$query_anhang,$vergleichsfeld="uid",$onchange="",$ka_wert="keine Auswahl",$joint="",$sqlu=""){
		$query="Select ".$tabellenname.".uid, ".$tabellenname.".".$anzeigefeld.",".$tabellenname.".".$optionvalue." from ".$tabellenname." ".$joint." ".$query_anhang;
		//$wert=preg_replace("/^,/","",$wert);
		//$wert=preg_replace("/,$/","",$wert);
		//if ($tabellenname=="tx_exabiscompetences_niveaus") echo $query;
		if ($sqlu!="") $query=$sqlu;	
		$res = mysql_query($query);
		//echo $query.mysql_error()."<br>";
		if (mysql_errno()>0) echo $query;
		if (mysql_num_rows($res)>0)
		{
			if ($multiple=="multiple"){
				$inhalt='<select name="'.$this->prefixId.'['.$selectname.'][]" '.$multiple.' '.$onchange.'>';
			}
			elseif ($selectname=="via")
				$inhalt='<select name="'.$this->prefixId.'['.$selectname.'][]" '.$multiple.' '.$onchange.'>';
			else
				$inhalt='<select name="'.$this->prefixId.'['.$selectname.']" '.$multiple.' '.$onchange.'>';
				
			
			if ($ka)
			$inhalt.='<option value="0">'.$ka_wert.'</option>';
			$wertvorher="";
			$arranz=explode(",",$anzeigefeld);
			while ($rs=mysql_fetch_array($res)){
					$wertf="";
					for ($i=0;$i<sizeof($arranz);$i++)
					{
						$wertf.=$rs[$arranz[$i]].' ';
					}
					
				if ($wertf!=$wertvorher){//keine doppelten werte anzeigen
					$wertvorher=$wertf;
					$optionwert=$rs[$optionvalue];
					
					$inhalt.='<option alt="alt" title="'.$wertf.'" value="'.$optionwert.'"';
					
					if ($multiple=="multiple")
					{
						
						if(in_array($rs[$vergleichsfeld],$wert)){

							$inhalt.=' selected="selected"';
							
						}
					}
					else{
						if ($wert==$rs[$vergleichsfeld]) {
							$inhalt.=' selected="selected"'; 
						}
					}
					$inhalt.='>';
					if (strlen($wertf)>110) $wertf=substr($wertf,0,109)."...";
					$inhalt.=($wertf);
		
					$inhalt.='</option>';	
				}
					
				
			}
			$inhalt.='</select>';
			return($inhalt);
		}
	}//create pulldown
	
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/exabis_competences/pi1/class.tx_exabiscompetences_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/exabis_competences/pi1/class.tx_exabiscompetences_pi1.php']);
}

?>