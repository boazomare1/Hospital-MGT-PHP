<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");


$data = '';
$status = '';
$searchdoctor = '';

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
	$searchdoctor = $_REQUEST['searchdoctor'];
	$status = $_REQUEST['status'];
}

$indiatimecheck = date('d-M-Y-H-i-s');
$foldername = "dbexcelfiles";
//$checkfile = $foldername.'/SupplierList.xls';
//if(!is_file($checkfile))
//{
$tab = "\t";
$cr = "\n";

//$data = "BILL Number: " . $tab .$billnumber. $tab . $tab . $tab ."BILL PARTICULARS". $tab. $cr. $cr;

$data .= "DoctorAddress" . $tab . $cr;

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
$res2pincode1 = $res2['pincode'];
$res2state1 = $res2['state'];
$res2country1 = $res2['country'];
$res2doctorcode = $res2['doctorcode'];
$res2dummy1 = '';

$data .= $res2doctorname. $tab . $cr;		
$data .= $res2address1. $tab . $cr;		
$data .= $res2address2. $tab . $cr;		
$data .= $res2city1.' - '.$res2pincode1. $tab . $cr;		
$data .= $res2state1.' '.$res2country1. $tab . $cr;		
$data .= 'Phone: '.$res2phonenumber1. $tab . $cr;		
$data .= $res2dummy1. $tab . $cr;		

}			

$data=preg_replace( '/\r\n/', ' ', trim($data) ); //to trim line breaks and enter key strokes.

$fp = fopen($foldername.'/DoctorAddress.xls', 'w+');
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
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		<form name="form1" id="form1" method="get" action="searchdoctor2.php" onSubmit="return process1()">
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="566" align="left" 
            border="0">
            <tbody>
              <tr bgcolor="#011e6a">
                <td class="bodytext31" bgcolor="#ecf0f5" 
                  colspan="2"><strong>Doctor   List </strong></td>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="566" 
            align="left" border="0">
            <tbody>
              <tr>
                <td width="8%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                <td class="bodytext31" bgcolor="#ecf0f5">&nbsp;</td>
                </tr>
              <tr>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">				
				<script language="javascript">
				function excelexport1()
				{
					//window.location = "http://www.google.com/"
					window.location = "dbexcelfiles/DoctorAddress.xls"
				}
				</script>&nbsp;</td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">
				<input onClick="javascript:excelexport1();" type="button" value="Export To Excel" name="Submit2" class="button" style="border: 1px solid #001E6A" /></td>
                </tr>
              <tr>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
                <td width="92%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Doctor </strong></div></td>
                </tr>
			  <?php
			  $colorloopcount = '';
			  
			if ($frmflag1 == 'frmflag1')
			{
			  $searchdoctor = $_REQUEST['searchdoctor'];
			  $status = $_REQUEST['status'];
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
			  $res2pincode1 = $res2['pincode'];
			  $res2state1 = $res2['state'];
			  $res2country1 = $res2['country'];
			  $res2doctorcode = $res2['doctorcode'];
			  
			  $colorloopcount = $colorloopcount + 1;
			  $showcolor = ($colorloopcount & 1); 
			  $colorcode = '';
			  if ($showcolor == 0)
			  {
			  	$colorcode = 'bgcolor="#FFFFFF"';
			  }
			  else
			  {
			  	$colorcode = 'bgcolor="#FFFFFF"';
			  }
			  ?>
              <tr <?php echo $colorcode; ?>>
                <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
              </tr>
              <tr <?php echo $colorcode; ?>>
                <td class="bodytext31" valign="top"  align="left"><?php echo $colorloopcount; ?></td>
                <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
                  <div align="left">
				  <strong><?php echo $res2doctorname; ?></strong><br>
				  <?php echo $res2address1; ?><br>
				  <?php echo $res2address2; ?><br>
				  <?php echo $res2location; ?><br>
				  <?php echo $res2city1.' - '.$res2pincode1; ?><br>
				  <?php echo $res2state1.' '.$res2country1; ?><br>
				  <?php echo 'Phone: '.$res2phonenumber1; ?><br>
				  </div>
                </div></td>
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
                </tr>
            </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

