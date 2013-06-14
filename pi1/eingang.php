<?
page_open(array("sess" => "SID", "auth" => "BU_Auth_User", "perm" => "BU_Perm"));

include "eshop.inc";

page_close();

include "eshop_head.inc";
?>

<BODY BGCOLOR="#FFFFFF" MARGINWIDTH="0" MARGINHEIGHT="0" leftMargin="0" topMargin="0">&nbsp;

<P>

<table>
<tr>
<td><img src=pix/00.gif width=50 height=1></td>

<TD>
<TABLE width=350 cellspacing=0>
	<TR bgcolor=white>
		<TD><? font(4, "darkblue"); ?><b><? est("herzlich_willkommen"); ?></b></FONT></TD>
<? if(!IS_BW){ ?>
    <TR bgcolor="white">
		<TD>
		<TABLE width=100%>
			<TR>
			<TD width=80><? font(2, "darkblue"); ?><? est("aktuelle_maschine"); ?>:</TD>
			<TD><? font(2, "darkblue"); ?><B><? echo $masch_num." ($machinetype) "; ?></B></FONT></TD>
			</TR>
		</TABLE>
		</TD>
	</TR>
<?} ?>
	<TR bgcolor=white><TD>&nbsp;</TD></TR>
	<TR bgcolor=white><TD><? font(2); ?><B><?
	if(IS_BW) $est = "anfang_anleitung_bw2";
	else $est = "anfang_anleitung";

	est($est, array(
		"</B></TD></TR><TR bgcolor=white><TD><BR>".getfont(2),
		"<B>",
		"</B>",
		"<br><a href=\"".$sess->url(ID_TOOL."?lang=$sprache&wkid=$warenkorb")."\" target=\"hauptframe\"><img src=\"pix/link_icon2.gif\" border=\"0\" valign=\"top\">".st("button_ident")."</a><br><br></TD></TR><TR bgcolor=white><TD>".getfont(2),
		"<br><a href=\"".$sess->url("warenkorb.php")."\" target=\"hauptframe\"><img src=\"pix/link_icon2.gif\" border=\"0\" valign=\"top\">".st("button_dbest")."</a><br><br></TD></TR><TR bgcolor=white><TD>".getfont(2),
		"<br><a href=\"http://www.mytrumpf.com/biegen\" target=\"_blank\"><img src=\"pix/link_icon2.gif\" border=\"0\" valign=\"top\">".st("button_lexikon")."</a><br><br></TD></TR><TR bgcolor=white><TD>".getfont(2)
	));
   ?>
	<br><br></TD></TR>
	<TR bgcolor=white><TD>&nbsp;</TD></TR>
</TABLE>
</TD>
</tr>
</table>

<BR>
</FORM></BODY>
</HTML>
