<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");


$data = '';
$status = '';
$searchdoctor = '';

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST[frmflag1];
if ($frmflag1 == 'frmflag1')
{
	$searchdoctor = $_REQUEST['searchdoctor'];
	$status = $_REQUEST['status'];
}

$indiatimecheck = date('d-M-Y-H-i-s');
$foldername = "dbexcelfiles";
//$checkfile = $foldername.'/DoctorList.xls';
//if(!is_file($checkfile))
//{
$tab = "\t";
$cr = "\n";

//$data = "BILL Number: " . $tab .$billnumber. $tab . $tab . $tab ."BILL PARTICULARS". $tab. $cr. $cr;

$data .= "Doctor".$tab."Location" . $tab . "City" . $tab . "Phone1" . $tab . "Phone2" . $tab."Email1". $tab . "Email2" . $tab . "Fax1" . $tab . "Fax2" . $tab . "Address1". $tab . "Address2". $tab . $cr;

$i=0;


$query2 = "select * from master_doctor where status like '%$status%'  order by doctorname";// desc limit 0, 100";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
$res2doctoranum = $res2['auto_number'];
$res2doctorname = $res2['doctorname'];
//$res2contactperson1 = $res2['contactperson1'];
$res2location = $res2['area'];
$res2phonenumber1 = $res2['phonenumber1'];
$res2phonenumber2 = $res2['phonenumber2'];
$res2emailid1 = $res2['emailid1'];
$res2emailid2 = $res2['emailid2'];
$res2faxnumber1 = $res2['faxnumber'];
$res2faxnumber2 = '';
$res2anum = $res2['auto_number'];
$res2address1 = $res2['address1'];
$res2address2 = $res2['address2'];
$res2city1 = $res2['city'];
$res2doctorcode = $res2['doctorcode'];

$data .= $res2doctorname. $tab . $res2location . $tab . $res2city1 . $tab . $res2phonenumber1 . $tab . $res2phonenumber2 . $tab . $res2emailid1 . $tab . $res2emailid2 . $tab . $res2faxnumber1 . $tab . $res2faxnumber2 . $tab . $res2address1 . $tab . $res2address2 . $tab. $cr;		

}			

$data=preg_replace( '/\r\n/', ' ', trim($data) ); //to trim line breaks and enter key strokes.

$fp = fopen($foldername.'/DoctorList.xls', 'w+');
fwrite($fp, $data);
fclose($fp);


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
<script language="javascript">

function process1()
{
	if (document.form1.searchdoctor.value == "")
	{
		//alert("Please Enter Any Starting Letter Or Search Key Words In Doctor Name To Search.");
		//document.form1.searchdoctor.focus();
		//return false;
	}
}

function loadprintpage1(canum)
{
	var varcanum = canum;
	//alert (varqanum);
	window.open("print_renewal1.php?canum="+varcanum+"","Window"+varcanum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}

</script>
<script>
function viewReport()
 {
window.open("<?php echo basename($_SERVER['PHP_SELF']); ?>","OriginalWindowA4",'width=922,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
  }
</script>
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
</head>

<body>
<table width="1500" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		<form name="form1" id="form1" method="get" action="searchdoctor1user.php" onSubmit="return process1()">
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="566" align="left" 
            border="0">
            <tbody>
              <tr bgcolor="#011e6a">
                <td class="bodytext31" bgcolor="#ecf0f5" 
                  colspan="2"><strong>Doctor   List </strong>&nbsp;&nbsp;&nbsp;<a href="#" onClick="viewReport();"><strong>W</strong></a></td>
              </tr>
              <tr>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">Search Doctor </td>
                <td width="79%" align="left" valign="center"  bgcolor="#FFFFFF">
				<input name="searchdoctor" value="<?php echo $searchdoctor; ?>" type="text" size="50" style="border: 1px solid #001E6A" /></td>
              </tr>
              <tr>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">Status</td>
                <td align="left" valign="center"  bgcolor="#FFFFFF">
				<select name="status" id="status" style="width: 130px;">
                  <option value="">Search All</option>
                  <option value="" selected="selected">Active</option>
                  <option value="Deleted">Deleted</option>
                </select></td>
              </tr>
              <tr>
                <td class="bodytext31" valign="center"  align="left" 
                width="21%" bgcolor="#FFFFFF">&nbsp;</td>
                <td valign="center"  align="left" bgcolor="#FFFFFF"><div align="right">
                    <input type="hidden" name="frmflag1" value="frmflag1">
					<input type="submit" value="Search" name="Submit" class="button" style="border: 1px solid #001E6A" />
                    <input type="reset" value="Reset" name="Submit" class="button" style="border: 1px solid #001E6A" />
                </div></td>
              </tr>
            </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1451" 
            align="left" border="0">
            <tbody>
              <tr>
                <td width="2%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                <td class="bodytext31" bgcolor="#ecf0f5"><a 
                  href="#"></a></td>
                <td class="bodytext31" bgcolor="#ecf0f5">&nbsp;</td>
                <td width="12%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                <td width="12%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                <td width="12%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                <td class="bodytext31" bgcolor="#ecf0f5">&nbsp;</td>
                <td width="7%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                <td width="7%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                <td width="9%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                <td width="8%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                <td width="8%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                <td width="8%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                </tr>
              <tr>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">
				<script language="javascript">
				function excelexport1()
				{
					//window.location = "http://www.google.com/"
					window.location = "dbexcelfiles/DoctorList.xls"
				}
				</script>&nbsp;</td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><input onClick="javascript:excelexport1();" type="button" value="Export To Excel" name="Submit2" class="button" style="border: 1px solid #001E6A" /></td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                </tr>
              <tr>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
                <td width="3%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Edit</strong></div></td>
                <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Doctor </strong></div></td>
                <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doctor ID </strong></div></td>
                <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Department </strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Address</strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong> Location </strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>City</strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Mobile</strong></div></td>
                <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Phone1</strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Email 1 </strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Email 2 </strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                </tr>
			  <?php
			  $colorloopcount = '';
			  $loopcount = '';
			  
			if ($frmflag1 == 'frmflag1')
			{
				if (isset($_REQUEST["searchdoctor"])) { $searchdoctor = $_REQUEST["searchdoctor"]; } else { $searchdoctor = ""; }
				if (isset($_REQUEST["status"])) { $status = $_REQUEST["status"]; } else { $status = ""; }

			  $query2 = "select * from master_doctor where doctorname like '%$searchdoctor%' and status like '%$status%'";
			}
			else
			{
			  $query2 = "select * from master_doctor where status like '%$status%' order by doctorname";// desc limit 0, 100";
			}
			  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while ($res2 = mysqli_fetch_array($exec2))
			  {
			  $res2doctoranum = $res2['auto_number'];
			  $res2doctorname = $res2['doctorname'];
			  //$res2contactperson1 = $res2['contactperson1'];
			  $res2location = $res2['area'];
			  $res2mobilenumber1 = $res2['mobilenumber'];
			  $res2phonenumber1 = $res2['phonenumber1'];
			  $res2phonenumber2 = $res2['phonenumber2'];
			  $res2emailid1 = $res2['emailid1'];
			  $res2emailid2 = $res2['emailid2'];
			  $res2faxnumber1 = $res2['faxnumber'];
			  $res2faxnumber2 = '';
			  $res2anum = $res2['auto_number'];
			  $res2address1 = $res2['address1'];
			  $res2city1 = $res2['city'];
			  $res2openingbalance1 = $res2['openingbalance'];
			  $res2doctorcode = $res2['doctorcode'];
			  $department = $res2['department'];
			  
			  $query22 = "select * from master_department where auto_number = '$department'";
	$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res22 = mysqli_fetch_array($exec22);
	
	$res2department=$res22['department'];

			  $colorloopcount = $colorloopcount + 1;
			  $showcolor = ($colorloopcount & 1); 
			  $colorcode = '';
			  if ($showcolor == 0)
			  {
			  	//$colorcode = 'bgcolor="#66CCFF"';
			  }
			  else
			  {
			  	$colorcode = 'bgcolor="#cbdbfa"';
			  }
			  ?>
              <tr <?php echo $colorcode; ?>>
                <td class="bodytext31" valign="center"  align="left"><?php echo $loopcount; ?></td>
                <td class="bodytext31" valign="center"  align="left">
				<div align="center"><a href="editdoctor1.php?doctorcode=<?php echo $res2doctorcode; ?>" class="bodytext3"><span class="bodytext3">Edit</span></a></div></td>
                <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
                  <div align="left"><a href="editdoctor1.php?anum=<?php echo $res2anum; ?>" class="bodytext3"><span class="bodytext3">
				  <?php echo $res2doctorname; //.' ('.$res2doctorcode.')'; ?></span></a></div>
                </div></td>
                <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $res2doctorcode; ?></div></td>
                <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $res2department; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="left">
				<?php echo $res2address1; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31">
				  <div align="left"><?php echo $res2location; ?></div>
				</div></td>
                <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $res2city1; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $res2mobilenumber1; ?></div></td>
                <td  align="left" valign="center" class="bodytext31"><div align="left"><?php echo $res2phonenumber1; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $res2emailid1; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $res2emailid2; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
                </tr>
			  <?php
			  }
			  //}
			  ?>
              <tr>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                </tr>
            </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

