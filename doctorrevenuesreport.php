<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

$colorloopcount=0;
$sno=0;
$description = '';

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if ($ADate1 != '' && $ADate2 != '')
{
	$datefrom = $_REQUEST['ADate1'];
	$dateto = $_REQUEST['ADate2'];
}
else
{
	$datefrom = date('Y-m-d', strtotime('-1 month'));
	$dateto = date('Y-m-d');
}



if(isset($_REQUEST['description']))
{
 $description = $_REQUEST['description'];
}
?>
<style type="text/css">.bodytext31:hover { font-size:14px; }
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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script type="text/javascript">
function disableEnterKey(varPassed)
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}

	if(key == 13) // if enter key press
	{
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
}


function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

function disableEnterKey()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}
	
	if(key == 13) // if enter key press
	{
		return false;
	}
	else
	{
		return true;
	}

}

function paymententry1process2()
{
	if (document.getElementById("cbfrmflag1").value == "")
	{
		alert ("Search Bill Number Cannot Be Empty.");
		document.getElementById("cbfrmflag1").focus();
		document.getElementById("cbfrmflag1").value = "<?php echo $cbfrmflag1; ?>";
		return false;
	}
}


function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.number
{
padding-left:900px;
text-align:right;
font-weight:bold;
}
.bali
{
text-align:right;
}
.style2 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

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
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="10">
	
              <form name="cbform1" method="post" action="doctorrevenuesreport.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>OP Doctors Revenue Report</strong></td>
              <td colspan="2" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
						if ($location!='')
						{
						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res12 = mysqli_fetch_array($exec12);
						
						echo $res1location = $res12["locationname"];
						//echo $location;
						}
						else
						{
						$query12 = "select locationname from master_location order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						//$res1locationanum = $res1["locationcode"];
						}
						?>
						
						
                  
                  </td> 
              </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->           
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $datefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $dateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                  </tr>
				<tr>
			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 
				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">
                    <?php
						
						$query1 = "select locationname,locationcode from master_location order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$loccode=array();
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$locationname = $res1["locationname"];
						$locationcode = $res1["locationcode"];
						
						?>
						 <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
						<?php
						} 
						?>
                      </select>
					 
              </span></td>
			   <td width="10%" align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
			  </tr>	
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>
        </td>
  </tr>
   <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	  
      
      <tr><td><a target="_blank" href="print_doctorsrevenuesreport.php?ADate1=<?php echo $datefrom; ?>&ADate2=<?php echo $dateto; ?>&location=<?php echo $location; ?>"><img src="images/excel-xls-icon.png" width="30" height="30" border="0"></a></td></tr>
	  <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1103" 
            align="left" border="0">
          <tbody>
             <tr>
			 <td colspan="17" bgcolor="#ecf0f5" class="bodytext31" align="left" valign="middle"><strong>Doctors Revenues Report </strong></td>
			 </tr>
			  <tr>
				  <td width="67" class="bodytext31" valign="center"  align="left" 
					bgcolor="#ffffff"><div align="center"><strong>S.No.</strong></div></td>
				  	<td width="262"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>Doctor's Name </strong></td>	
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>Pharmacy Count </strong></td>
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>Pharmacy </strong></td>
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>APR </strong></td>
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>Lab Count </strong></td>
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>Lab </strong></td>
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>APR </strong></td>
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>Radiology Count </strong></td>
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>Radiology </strong></td>
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>APR </strong></td>
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>Service Count </strong></td>
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>Service </strong></td>
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>APR </strong></td>
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>Total Count </strong></td>
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>Total </strong></td>
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>APR </strong></td>
			  </tr>					
           <?php
		   
		$total_pharmacy = 0; $total_lab = 0; $total_radiology = 0; $total_service = 0; $_total = 0; $_number=0;$_number1=0;$_number2=0;$_number3=0;$_number4=0;
	    $description=trim($description);
		if($datefrom!="" && $dateto!="" &&$location!="" ){
		$query1 = "SELECT `employeename`, `username` FROM `master_employee` WHERE `username` != ''"; 

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		$res1employeename =$res1['employeename'];
		$res1username =$res1['username'];

		$queryc = "SELECT COUNT(patientcode) AS number FROM `consultation_lab` where `resultentry`='completed' AND `username`='".$res1username."'"; 
		if($datefrom!=""){$queryc .= " AND consultationdate >= '".$datefrom."'";}
		if($dateto!=""){$queryc .= " AND consultationdate <= '".$dateto."'";}
		if($location!=""){$queryc .= " AND locationcode <= '".$location."'";}
		
		$number = 0;
		$execc = mysqli_query($GLOBALS["___mysqli_ston"], $queryc) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$numc=mysqli_num_rows($execc);
		while($resc = mysqli_fetch_array($execc))
		{
		$number =$resc['number'];
		}

		$querylab = "SELECT SUM(`consultation_lab`.`labitemrate`) AS labrate  FROM `consultation_lab` where `resultentry`='completed' AND `username`='".$res1username."'"; 
		if($datefrom!=""){$querylab .= " AND consultationdate >= '".$datefrom."'";}
		if($dateto!=""){$querylab .= " AND consultationdate <= '".$dateto."'";}
		if($location!=""){$querylab .= " AND locationcode <= '".$location."'";}

		$execlab = mysqli_query($GLOBALS["___mysqli_ston"], $querylab) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$numlab=mysqli_num_rows($execlab);
		while($reslab = mysqli_fetch_array($execlab))
		{
		$res1labrate =$reslab['labrate'];
		}

		$queryc = "SELECT COUNT(patientcode) AS number FROM `consultation_radiology` where `paymentstatus`='completed' AND `username`='".$res1username."'"; 
		if($datefrom!=""){$queryc .= " AND consultationdate >= '".$datefrom."'";}
		if($dateto!=""){$queryc .= " AND consultationdate <= '".$dateto."'";}
		if($location!=""){$queryc .= " AND locationcode <= '".$location."'";}
		
		$number1 = 0;
		$execc = mysqli_query($GLOBALS["___mysqli_ston"], $queryc) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$numc=mysqli_num_rows($execc);
		while($resc = mysqli_fetch_array($execc))
		{
		$number1 =$resc['number'];
		}

		$queryrad = "SELECT SUM(`consultation_radiology`.`radiologyitemrate`) AS amount FROM `consultation_radiology` where `consultation_radiology`.`paymentstatus`='completed' AND `consultation_radiology`.`username`='".$res1username."'"; 
		if($datefrom!=""){$queryrad .= " AND consultationdate >= '".$datefrom."'";}
		if($dateto!=""){$queryrad .= " AND consultationdate <= '".$dateto."'";}
		if($location!=""){$queryrad .= " AND locationcode <= '".$location."'";}

		$execrad = mysqli_query($GLOBALS["___mysqli_ston"], $queryrad) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$numrad=mysqli_num_rows($execrad);
		while($resrad = mysqli_fetch_array($execrad))
		{
		$consultation_radiology =$resrad['amount'];
		}

		$queryc = "SELECT COUNT(patientcode) AS number FROM `consultation_services` where `paymentstatus`='completed' AND `username`='".$res1username."'"; 
		if($datefrom!=""){$queryc .= " AND consultationdate >= '".$datefrom."'";}
		if($dateto!=""){$queryc .= " AND consultationdate <= '".$dateto."'";}
		if($location!=""){$queryc .= " AND locationcode <= '".$location."'";}
		
		$number2 = 0;
		$execc = mysqli_query($GLOBALS["___mysqli_ston"], $queryc) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$numc=mysqli_num_rows($execc);
		while($resc = mysqli_fetch_array($execc))
		{
		$number2 =$resc['number'];
		}
		$queryser = "SELECT SUM(`consultation_services`.`amount`) AS amount FROM `consultation_services` where `consultation_services`.`paymentstatus`='completed' AND `consultation_services`.`username`='".$res1username."'"; 
		if($datefrom!=""){$queryser .= " AND consultationdate >= '".$datefrom."'";}
		if($dateto!=""){$queryser .= " AND consultationdate <= '".$dateto."'";}
		if($location!=""){$queryser .= " AND locationcode <= '".$location."'";}

		$execser = mysqli_query($GLOBALS["___mysqli_ston"], $queryser) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$numlab=mysqli_num_rows($execser);
		while($resser = mysqli_fetch_array($execser))
		{
		$consultation_service =$resser['amount'];
		}
		
		$queryc = "SELECT COUNT(patientcode) AS number FROM `master_consultationpharm` where `recordstatus`='completed' AND `consultingdoctor`='".$res1username."'"; 
		if($datefrom!=""){$queryc .= " AND recorddate >= '".$datefrom."'";}
		if($dateto!=""){$queryc .= " AND recorddate <= '".$dateto."'";}
		if($location!=""){$queryc .= " AND locationcode <= '".$location."'";}
		
		$number3 = 0;
		$execc = mysqli_query($GLOBALS["___mysqli_ston"], $queryc) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$numc=mysqli_num_rows($execc);
		while($resc = mysqli_fetch_array($execc))
		{
		$number3 =$resc['number'];
		}
		$querypharm= "SELECT SUM(quantity*rate) AS amount FROM `master_consultationpharm` where `recordstatus`='completed' AND `consultingdoctor`='".$res1username."'"; 
		if($datefrom!=""){$querypharm .= " AND recorddate >= '".$datefrom."'";}
		if($dateto!=""){$querypharm .= " AND recorddate <= '".$dateto."'";}
		if($location!=""){$querypharm .= " AND locationcode <= '".$location."'";}

		$execpharm = mysqli_query($GLOBALS["___mysqli_ston"], $querypharm) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$numpharm=mysqli_num_rows($execpharm);
		while($respharm = mysqli_fetch_array($execpharm))
		{
		$consultation_pharmacy =$respharm['amount'];
		}
		
		if($consultation_pharmacy==0 && $res1labrate == 0 && $consultation_radiology == 0 && $consultation_service==0){ continue;}
		$colorloopcount = $colorloopcount + 1;
		$showcolor = ($colorloopcount & 1); 
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
				<td width="67" align="center" valign="center" class="bodytext31"><?php echo $sno=$sno + 1; ?></td>
				<td width="262"  align="left" valign="center" class="bodytext31"><?php echo $res1employeename;  ?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php echo number_format($number3,2,'.',','); $_number3+=$number3; ?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php echo number_format($consultation_pharmacy,2,'.',','); $total_pharmacy += $consultation_pharmacy; ?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php 
				$consultation_pharmacy_apr = 0;
				if($consultation_pharmacy!=0 && $number3!=0){
				$consultation_pharmacy_apr = $consultation_pharmacy/$number3;}
				echo number_format($consultation_pharmacy_apr,2,'.',','); ?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php echo number_format($number,2,'.',','); $_number+=$number; ?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php echo number_format($res1labrate,2,'.',','); $total_lab += $res1labrate;?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php 
				$res1labrate_apr = 0;
				if($res1labrate!=0 && $number!=0){
				$res1labrate_apr = $res1labrate/$number;}
				echo number_format($res1labrate_apr,2,'.',',');?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php echo number_format($number1,2,'.',','); $_number1+=$number1; ?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php echo number_format($consultation_radiology,2,'.',','); $total_radiology += $consultation_radiology;?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php 
				$consultation_radiology_apr = 0;
				if($consultation_radiology!=0 && $number1!=0){
				$consultation_radiology_apr = $consultation_radiology/$number1;}
				echo number_format($consultation_radiology_apr,2,'.',','); ?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php echo number_format($number2,2,'.',','); $_number2+=$number2; ?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php echo number_format($consultation_service,2,'.',',');  $total_service += $consultation_service;?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php 
				$consultation_service_apr = 0;
				if($consultation_service!=0 && $number!=0){
				$consultation_service_apr = $consultation_service/$number;}
				echo number_format($consultation_service_apr,2,'.',',');?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php 
				$number4 =$number+$number1+$number2+$number3;
				echo number_format($number4,2,'.',','); $_number4+=$number4; ?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php
				$total = $res1labrate+$consultation_pharmacy+$consultation_radiology+$consultation_service;
				 echo number_format($total,2,'.',',');  $_total += $total;?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php
				$total_apr = 0;
				if($total!=0 && $number4!=0){
				$total_apr = $total/$number4;}
				 echo number_format($total_apr,2,'.',','); ?></td>
			</tr>	
		<?php
		}	 }
		?>	
        
            <tr>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong>Total:</strong></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($_number3,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($total_pharmacy,2,'.',','); ?></strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($_number,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($total_lab,2,'.',','); ?></strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
 				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($_number1,2,'.',','); ?></strong></div></td>
             <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($total_radiology,2,'.',','); ?></strong></div></td>
 				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($_number2,2,'.',','); ?></strong></div></td>
             <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($total_service,2,'.',','); ?></strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($_number4,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($_total,2,'.',','); ?></strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			</tr>
            </tbody>
        </table>
  
	  </form>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

