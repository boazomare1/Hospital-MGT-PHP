<?php
session_start();
set_time_limit(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

if (isset($_REQUEST["upload"])) { $upload = $_REQUEST["upload"]; } else { $upload = ""; }
//$upload = $_REQUEST['upload'];
if ($upload == 'success')
{

	$importstarted = date("d-M-Y H:i:s");

	$skipcountservice = 0;
	$skipcounttax = 0;
	$skipcountcategory = 0;
	$skipcountunit = 0;
	$successcount = 0;
	$forloopcount = 0;
	$foldername = "tab_file_dump\\";
	$filename = $username."_tabdump.txt";
	$filepath = $foldername.$filename;
	$fd = fopen ($filepath, "r");
	$fullcontents = fread ($fd,filesize ($filepath));
	fclose ($fd); 
	
	$linebreak = "\n"; //for line breaks
	$linecounter = 0;
	$splitcontents = explode($linebreak, $fullcontents);
	//print_r($splitcontents);
	$totallinecount = count($splitcontents);
	//echo "<br>";
	
	foreach ( $splitcontents as $linecontent )
	{
		$forloopcount = $forloopcount + 1;
		//echo "<br>";
		if ($forloopcount > 1 && $forloopcount < $totallinecount) // to skip header row. to skip last empty row to avoid empty array error.
		{
			//echo "<br><br>";
			$linecounter = $linecounter + 1;
			$linecontent; //contains the text of each line.
			
			$delimiter = "\t"; // for tab delimit breaks
			$delimitercount = 0;
			$splitdelimiter = explode($delimiter, $linecontent);
			$disease = $splitdelimiter[0];
			$disease = strtoupper($disease);
			$description = $splitdelimiter[1];
			$description = strtoupper($description);
			$icdcode = $splitdelimiter[2];
			$icdcode = strtoupper($icdcode);
			$chapter = $splitdelimiter[3];
			$chapter = strtoupper($chapter);
			preg_match ('/[!,^,+,=,[,],;,,,{,},|,\,<,>,?,~]/', $description);
			
			if ($disease != '')
			{
			$query2 = "insert into master_icd (disease,description,icdcode,chapter) values ('$disease','$description','$icdcode','$chapter')";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $successcount = $successcount + 1;
		    }
			else
			{
			$skipcountunit = $skipcountunit + 1;
			}
		}
	}
}
?>
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
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">


</script>
<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td>
                  <table width="83%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Item / Services Data Import From TAB Delimited File </strong></td>
                      </tr>
                      <tr>
                        <td colspan="2" align="left" valign="middle"   bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF"  class="bodytext3"><?php //echo $importstarted; ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF" ><?php //echo $totallinecount = $totallinecount - 1; ?><span class="bodytext3"> </span></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF" ><?php //echo $skipcountcategory; ?> <span class="bodytext3"> </span></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF" ><?php //echo $skipcountservice; ?> <span class="bodytext3"></span></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> </td>
                        <td align="left" valign="top" bgcolor="#FFFFFF" ><?php //echo $skipcountunit; ?> <span class="bodytext3"> </span></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF" ><?php //echo $skipcounttax; ?> <span class="bodytext3"> </span></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF" ><?php //echo $totalerrorcount = $skipcountcategory + $skipcountservice + $skipcountunit + $skipcounttax; ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF" ><?php //echo $successcount; ?> <span class="bodytext3"> </span></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF"  class="bodytext3"><?php //echo $importfinished; ?></td>
                      </tr>
                      <tr>
                        <td width="28%" align="left" valign="top"  class="bodytext3">&nbsp;</td>
                        <td valign="top" align="left" width="72%" >&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
				  <br>
				  <br>
                 </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
