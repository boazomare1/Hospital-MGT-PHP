<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");


$data = '';
$patientcode = '';
$searchpatient = '';

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST[frmflag1];
if ($frmflag1 == 'frmflag1')
{
	$searchpatient = $_REQUEST['searchpatient'];
	$patientcode = $_REQUEST['patientcode'];
}

$indiatimecheck = date('d-M-Y-H-i-s');
$foldername = "dbexcelfiles";
//$checkfile = $foldername.'/PatientList.xls';
//if(!is_file($checkfile))
//{
$tab = "\t";
$cr = "\n";

//$data = "BILL Number: " . $tab .$billnumber. $tab . $tab . $tab ."BILL PARTICULARS". $tab. $cr. $cr;

$data .= "Patient".$tab."Location" . $tab . "City" . $tab . "Phone1" . $tab . "Phone2" . $tab."Email1". $tab . "Email2" . $tab . "Fax1" . $tab . "Fax2" . $tab . "Address1". $tab . "Address2". $tab . $cr;

$i=0;

$query2 = "select * from master_billing where patientcode like '%$patientcode%'  order by billnumber";// desc limit 0, 100";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$res2patientcode = $res2['patientcode'];
	$res2paientfirstname = $res2['patientfirstname']; 
	$res2billnumber = $res2['billnumber'];
	$res2paymenttype = $res2['paymenttype'];
	$res2subtype = $res2['subtype'];
	$res2billtype = $res2['billtype'];
	$res2accountname = $res2['accountname'];
	$res2accountexpirydate = $res2['accountexpirydate'];
	$res2planname = $res2['planname'];
	$res2planexpirydate = $res2['planexpirydate'];
	$res2visitlimit = $res2['visitlimit'];
	$res2overalllimit = $res2['overalllimit'];
	$res2department = $res2['department'];
	$res2consultationtime = $res2['consultationtime'];
	$res2consultationdate = $res2['consultationdate'];
	$res2consultationtype = $res2['consultationtype'];
	$res2consultationtime = $res2['consultationtime'];
	$res2consultationdate = $res2['consultationdate'];
	$res2referredby = $res2['referredby'];
	$res2paymentmode = $res2['paymentmode'];
	$res2billamount = $res2['billamount'];
	$res2billentryby = $res2['billentryby'];
	$res2billingdatetime = $res2['billingdatetime'];
	$consultationtype = $res2['consultationtype'];
	$res2faxnumber2 = '';
	$res2anum = $res2['auto_number'];
	$res2address1 = $res2['address1'];
	$res2city = $res2['city'];
	$res2openingbalance1 = $res2['openingbalance'];
	$res2insuranceid = $res2['insuranceid'];
	$res2registrationdate = $res2['registrationdate'];			
	$res2consultingdoctor = $res2['consultingdoctor'];
	

$data .= $res2patientcode. $tab . $res2paientfirstname . $tab .$res2billnumber. $tab . $res2paymenttype . $tab . $res2subtype . $tab . $res2billtype . $tab . $res2accountname. $tab . $res2accountexpirydate . $tab . $res2planname . $tab . $res2planexpirydate . $tab . $res2visitlimit . $tab. $cr;		

}			

$data=preg_replace( '/\r\n/', ' ', trim($data) ); //to trim line breaks and enter key strokes.


$fp = fopen($foldername.'/PatientList.xls', 'w+');
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



function loadprintpage1(banum)
{
	var banum = banum;
	window.open("print_bill1_op1.php?billautonumber="+banum+"","Window"+banum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}


</script>
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
</head>

<body>
<table width="1800" border="0" cellspacing="0" cellpadding="2">
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
    <td width="99%" valign="top"><table width="1887" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		<form name="form1" id="form1" method="get" action="billingreport1.php" onSubmit="return process1()">
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="566" align="left" 
            border="0">
            <tbody>
              <tr bgcolor="#011e6a">
                <td class="bodytext31" bgcolor="#ecf0f5" 
                  colspan="2"><strong>Billing Report </strong></td>
              </tr>
              <tr>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">Search Patient ID </td>
                <td align="left" valign="center"  bgcolor="#FFFFFF"><input name="patientcode" type="text" id="patientcode"  value="<?php echo $patientcode;?> "style="border: 1px solid #001E6A"></td>
              </tr>
              <tr>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">Search Patient Name </td>
                <td width="79%" align="left" valign="center"  bgcolor="#FFFFFF"><input name="searchpatient" value="<?php echo $searchpatient; ?>" type="text" size="50" style="border: 1px solid #001E6A" /></td>
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
      <tr>
        <td><table width="1700" height="154" border="0" 
            align="left" cellpadding="4" cellspacing="0" 
            bordercolor="#666666" id="AutoNumber3" style="BORDER-COLLAPSE: collapse">
            <tbody>
              <tr>
                <td width="2%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                <td class="bodytext31" bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" bgcolor="#ecf0f5"><a 
                  href="#"></a></td>
                <td class="bodytext31" bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" bgcolor="#ecf0f5">&nbsp;</td>
                <td width="6%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                <td class="bodytext31" bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" bgcolor="#ecf0f5">&nbsp;</td>
                <td width="5%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                <td width="6%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                </tr>
              <tr>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">
				<script language="javascript">
				function excelexport1()
				{
					//window.location = "http://www.google.com/"
					window.location = "dbexcelfiles/PatientList.xls"
				}
				</script>&nbsp;</td>
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
                <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                </tr>
              <tr>
                <td height="47"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
                <td width="2%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Print</strong></div></td>
                <td width="2%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Edit</strong></div></td>
                <td width="3%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><p><strong>PaientID</strong><strong> </strong></p>                  </td>
                <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>PatientName </strong></div></td>
                <td width="4%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>BillNumber</strong></td>
                <td width="3%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>SubTotal</strong></div></td>
                <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>FixedAmount</strong></div></td>
                <td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>PercentageAmount</strong></div></td>
                <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>DiscountAmount</strong></div></td>
                <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>TotalAmount</strong></div></td>
                <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>PaymentMode</strong></div></td>
                <td width="2%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Type</strong></div></td>
                <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>BillType</strong></td>
                <td  align="left" valign="center" 
                bgcolor="#ffffff" class="style1">ConsultingDoctor</td>
                <td  align="left" valign="center" 
                bgcolor="#ffffff" class="style1">Department</td>
                <td  align="left" valign="center" 
                bgcolor="#ffffff" class="style1">ConsultationTime</td>
                <td  align="left" valign="center" 
                bgcolor="#ffffff" class="style1">ConsultationDate</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>OverallLimit</strong></div></td>
                <td  align="left" valign="center" 
                bgcolor="#ffffff" class="style1"> EntryBy </td>
                <td  align="left" valign="center" 
                bgcolor="#ffffff" class="style1">BillDate </td>
                </tr>
			  <?php
			  $colorloopcount = '';
			  $loopcount = '';
				if ($frmflag1 == 'frmflag1')
				{
					if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
					if (isset($_REQUEST["searchpatient"])) { $searchpatient = $_REQUEST["searchpatient"]; } else { $searchpatient = ""; }
					
					$query2 = "select * from master_billing where patientfirstname like '%$searchpatient%' and patientcode like '%$patientcode%' order by billnumber desc";
				}
				else
				{
					$query2 = "select * from master_billing where  patientfirstname like '%$patientfirstname%'  or patientcode like '%$patientcode%' order by billnumber desc";
				}
			  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while ($res2 = mysqli_fetch_array($exec2))
			  {
			  $res2patientcode = $res2['patientcode'];
		      $res2paientfirstname = $res2['patientfirstname']; 
			  $res2billanum = $res2['auto_number'];
			  $res2billnumber = $res2['billnumber'];
			  //$res2contactperson1 = $res2['contactperson1'];
			  $res2paymenttype = $res2['paymenttype'];
			  $res2subtype = $res2['subtype'];
			  $res2billtype = $res2['billtype'];
			  $res2accountname = $res2['accountname'];
			  $res2accountexpirydate = $res2['accountexpirydate'];
			  $res2planname = $res2['planname'];
			  $res2planexpirydate = $res2['planexpirydate'];
			  $res2visitlimit = $res2['visitlimit'];
			  $res2overalllimit = $res2['overalllimit'];
		      $res2department = $res2['department'];
			  
			  $res2consultationtime = $res2['consultationtime'];
			  $res2consultationdate = $res2['consultationdate'];
			  $consultationtypeanum = $res2['consultationtype'];
			  
			  $query21 = "select * from master_consultationtype where auto_number = '$consultationtypeanum'";
			  $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res21 = mysqli_fetch_array($exec21);
			  $res2consultationtype = $res21['consultationtype'];
			  
			  $res2referredby = $res2['referredby'];
			  $res2paymentmode = $res2['paymentmode'];
			  $res2billamount = $res2['billamount'];
			  $res2billentryby = $res2['billentryby'];
			  $res2billingdatetime = $res2['billingdatetime'];
			  $consultationtype = $res2['consultationtype'];
			  $res2faxnumber2 = '';
			  $res2anum = $res2['auto_number'];
			  $res2address1 = $res2['address1'];
			  $res2city = $res2['city'];
			  $res2openingbalance1 = $res2['openingbalance'];
			  $res2insuranceid = $res2['insuranceid'];
			  $res2registrationdate = $res2['registrationdate'];			
			  $res2consultingdoctor = $res2['consultingdoctor'];
	
				$res2subtotalamount = $res2['subtotalamount'];
				$res2fixedamount = $res2['copayfixedamount'];
				$res2percentageamount = $res2['copaypercentageamount'];
				$res2totalamountbeforediscount = $res2['totalamountbeforediscount'];
				$res2discountamount = $res2['discountamount'];
				$res2totalamount = $res2['totalamount'];
				$res2paymentmode = $res2['patientpaymentmode'];

			  //$query3 = "select * from master_patientadmission where patientcode = '$res2customercode' order by auto_number desc limit 0, 1";
			  //$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			  //$res3 = mysql_fetch_array($exec3);
			  //$res3ipnumber = $res3['ipnumber'];
			  $res3ipnumber = '';
			  
			  $colorloopcount = $colorloopcount + 1;
			  $showcolor = ($colorloopcount & 1); 
			  $colorcode = '';
				if ($showcolor == 0)
				{
					//echo "if";
					$colorcode = 'bgcolor="#CBDBFA"';
				}
				else
				{
					//echo "else";
					$colorcode = 'bgcolor="#ecf0f5"';
				}
			  ?>
              <tr <?php echo $colorcode; ?>>
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
                <td  align="left" valign="center" class="bodytext31">
				<div align="center">
				<a href="javascript:loadprintpage1('<?php echo $res2billanum; ?>')" class="bodytext3">
				<span class="bodytext3">
				Print				</span>				</a>				</div>				</td>
                <td class="bodytext31" valign="center"  align="left">
				<div align="center">
				<!--<a href="editpatient1.php?customercode=<?php; ?>" class="bodytext3">-->
				<a href="#" class="bodytext3">
				<span class="bodytext3">Edit</span>				</a>				</div>				</td>
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $res2patientcode;?></span></div>
                </div></td>
                <td  align="left" valign="center" class="bodytext31"><?php echo $res2paientfirstname;?></td>
                <td  align="left" valign="center" class="bodytext31"><?php echo $res2billnumber;?></td>
                <td  align="left" valign="center" class="bodytext31"><?php echo $res2subtotalamount;?></td>
                <td  align="left" valign="center" class="bodytext31"><?php echo $res2fixedamount;?></td>
                <td  align="left" valign="center" class="bodytext31"><?php echo $res2percentageamount;?></td>
                <td  align="left" valign="center" class="bodytext31"><?php echo $res2discountamount;?></td>
                <td  align="left" valign="center" class="bodytext31"><?php echo $res2totalamount;?></td>
                <td  align="left" valign="center" class="bodytext31"><?php echo $res2paymentmode;?></td>
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res2paymenttype; ?> </span> </div>
                </div></td>
                <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $res2billtype; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $res2consultingdoctor;?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $res2department;?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $res2consultationtime;?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $res2consultationdate;?></td>
                <td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31">
				  <div align="left"><?php echo $res2overalllimit; ?></div>
				</div></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $res2billentryby;?></td>
                <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $res2billingdatetime;?></div></td>
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

