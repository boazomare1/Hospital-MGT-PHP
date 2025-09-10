<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$colorloopcount = '';
$sno = '';
$snocount = '';

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
  $resp = $_REQUEST['resp'];
  $cardio = $_REQUEST['cardio'];
  $abdomen = $_REQUEST['abdomen'];
  $muscle = $_REQUEST['muscle'];
  $skin = $_REQUEST['skin'];
  $head = $_REQUEST['head'];
  $ent = $_REQUEST['ent'];
  $eyes = $_REQUEST['eyes'];
  $nerve = $_REQUEST['nerve'];
  $other = $_REQUEST['other'];
  
$query66 ="insert into radiologyform(resp,cardio,abdomen,muscle,skin,head,ent,eyes,nerve,other)values('$resp','$cardio','$abdomen','$muscle','$skin','$head','$ent','$eyes','$nerve','$other')";
$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	//header("location:ipbilling.php");
	//exit;
}
?>
</script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style3 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
</head>

<BODY LANG="en-US" TEXT="#000000" DIR="LTR">
<form action="testtemplate.php" method="post" name="cbform1">
<TABLE WIDTH=592 CELLPADDING=7 CELLSPACING=0 STYLE="page-break-before: always">
	<COL WIDTH=281>
	<COL WIDTH=281>
	<TR VALIGN=TOP>
	  <TD STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0in">&nbsp;</TD>
	  <TD STYLE="border: 1px solid #000000; padding: 0in 0.08in">&nbsp;</TD>
    </TR>
	<TR VALIGN=TOP>
		<TD WIDTH=281 STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0in">
			<P CLASS="western"><FONT FACE="Tahoma, sans-serif"><B>Respiratory
			System:</B></FONT></P>		</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">
			<P CLASS="western">
			  <input type="text" name="resp" id="resp" size="30">
			  <BR>
			</P>	  </TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=281 STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0in">
			<P CLASS="western"><FONT FACE="Tahoma, sans-serif"><B>Cardiovasular
			System:</B></FONT></P>		</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">
			<P CLASS="western">
			  <input type="text" name="cardio" id="cardio">
			  <BR>
	  </P>		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=281 STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0in">
			<P CLASS="western"><FONT FACE="Tahoma, sans-serif"><B>Per Abdomen:</B></FONT></P>		</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">
			<P CLASS="western">
			  <input type="hidden" name="abdomen" id="abdomen" value="0" />
			  <input type="checkbox" name="abdomen" id="abdomen" value="1">
			  <BR>
		</P>		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=281 STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0in">
			<P CLASS="western" ALIGN=JUSTIFY><FONT FACE="Tahoma, sans-serif"><B>Musculo-Skeletal
			System:</B></FONT></P>		</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">
			<P CLASS="western" ALIGN=JUSTIFY>
			  <input name="muscle" type="hidden" value="No">
			  <input name="muscle" type="radio" value="Yes">
			  <BR>
		</P>		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=281 STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0in">
			<P CLASS="western" ALIGN=JUSTIFY><FONT FACE="Tahoma, sans-serif"><B>Skin
			Integumentary System:</B></FONT></P>		</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">
			<P CLASS="western" ALIGN=JUSTIFY>
			  <select name="skin">
			    <option value="1">Skin</option>
			    <option value="2">Integeur</option>
			  </select>
			  <BR>
		</P>		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=281 STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0in">
			<P CLASS="western" ALIGN=JUSTIFY><FONT FACE="Tahoma, sans-serif"><B>Head
			&amp; Neck:</B></FONT></P>		</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">
			<P CLASS="western" ALIGN=JUSTIFY>
			  <input type="text" name="head" id="head" size="30">
			  <BR>
			</P>		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=281 STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0in">
			<P CLASS="western" ALIGN=JUSTIFY><FONT FACE="Tahoma, sans-serif"><B>ENT:</B></FONT></P>		</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">
			<P CLASS="western" ALIGN=JUSTIFY>
			  <input type="text" name="ent" id="ent" size="30">
			  <BR>
			</P>		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=281 STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0in">
			<P CLASS="western" ALIGN=JUSTIFY><FONT FACE="Tahoma, sans-serif"><B>Eyes:</B></FONT></P>		</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">
			<P CLASS="western" ALIGN=JUSTIFY>
			  <input type="text" name="eyes" id="eyes" size="30">
			  <BR>
			</P>		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=281 STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0in">
			<P CLASS="western" ALIGN=JUSTIFY><FONT FACE="Tahoma, sans-serif"><B>Central
			Nervous System:</B></FONT></P>		</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">
			<P CLASS="western" ALIGN=JUSTIFY>
			  <input type="text" name="nerve" id="nerve" size="30">
			  <BR>
			</P>		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=281 STYLE="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0in">
			<P CLASS="western" ALIGN=JUSTIFY><FONT FACE="Tahoma, sans-serif"><B>Other
			Notes:</B></FONT></P>		</TD>
		<TD WIDTH=281 STYLE="border: 1px solid #000000; padding: 0in 0.08in">
			<P CLASS="western" ALIGN=JUSTIFY>
			  <input type="text" name="other" id="other" size="30">
			  <BR>
			</P>		</TD>
	</TR>
	
               <tr>
	  <td colspan="7" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
	   <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
	    <input name="Submit2223" type="submit" value="Save" accesskey="b" class="button"/>		</td>
	  </tr>
</TABLE>
</form>
<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
</P>
<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
</P>
</BODY>
</HTML>