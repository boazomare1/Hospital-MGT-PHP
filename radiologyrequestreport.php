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
$docno = $_SESSION['docno'];
//get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}
		//location get end here
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$res21itemname='';
$res21itemcode='';
$docnumber1 = '';
//This include updatation takes too long to load for hunge items database.
if (isset($_REQUEST["rowcount"])) { echo $rowcount = $_REQUEST["rowcount"]; } else { $rowcount = ""; }
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
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
	$searchpatient = $_POST['patient'];
	$searchpatientcode=$_POST['patientcode'];
	
	$searchvisitcode=$_POST['visitcode'];
	$fromdate=$_POST['ADate1'];
	$todate=$_POST['ADate2'];
	$patienttype=$_POST['patienttype'];
}
else
{
	$searchpatient = '';
	$searchpatientcode='';
	
	$searchvisitcode='';
	$fromdate=date('Y-m-d');
	$todate=date('Y-m-d');
	$docnumber='';
	$patienttype='ALL';
}	
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">
function ajaxlocationfunction(val)
{ 
if (window.XMLHttpRequest)
					  {// code for IE7+, Firefox, Chrome, Opera, Safari
					  xmlhttp=new XMLHttpRequest();
					  }
					else
					  {// code for IE6, IE5
					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					  }
					xmlhttp.onreadystatechange=function()
					  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;
						}
					  }
					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
					xmlhttp.send();
}
					
//ajax to get location which is selected ends here
function cbsuppliername1()
{
	document.cbform1.submit();
}
</script>
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
.style1 {font-weight: bold}
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
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="radiologyrequestreport.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Radiology Request Report</strong></td>
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
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						//$res1locationanum = $res1["locationcode"];
						}
						?>
						
						
                  
                  </td>
              </tr>
          	 <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <select name="location" id="location" onChange=" ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
                  <?php
						
						$query1 = "select * from master_employeelocation where username='$username' group by locationname order by locationname asc";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>" <?php if($location!='')if($location==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>
						<?php
						}
						?>
                  </select>
              </span></td>
              </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patient" type="text" id="patient" style="border: 1px solid #001E6A;" value="<?php echo $searchpatient; ?>" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patientcode</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patientcode" type="text" id="patient" style="border: 1px solid #001E6A;" value="<?php echo $searchpatientcode; ?>" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="visitcode" type="text" id="patient" style="border: 1px solid #001E6A;" value="<?php echo $searchvisitcode; ?>" size="50" autocomplete="off">
              </span></td>
              </tr>
               <tr>
			   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Type</td>
			  <td colspan="3" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <strong><select name="patienttype" id="patienttype" style="border: solid 1px #001E6A;">
		  <option value="ALL" <?php if($patienttype=='ALL') echo "selected"; ?>>ALL</option>
		  <option value="IP" <?php if($patienttype=='IP') echo "selected"; ?>>IP</option>
		  <option value="OP" <?php if($patienttype=='OP') echo "selected"; ?>>OP</option>
		  </select>
		  </strong></td>
			</tr>     
            <tr>
          <td width="76" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $fromdate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="51" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="129" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $todate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
           
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
			  <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />
			  <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>
			   <td width="" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="print_radiology_request_report.php?ADate1=<?php echo $fromdate; ?>&&ADate2=<?php echo $todate; ?>&&patienttype=<?php echo $patienttype; ?>&&searchpatient=<?php echo $searchpatient; ?>&&searchpatientcode=<?php echo $searchpatientcode; ?>&&searchvisitcode=<?php echo $searchvisitcode; ?>&&locationcode=<?php echo $locationcode; ?>"><img src="images/excel-xls-icon.png" width="30" height="30" border="0"></a></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td>
	<form name="form1" id="form1" method="post" action="radiologyrequestreport.php">	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
	$searchpatient = $_POST['patient'];
	$searchpatientcode=$_POST['patientcode'];
	
	$searchvisitcode=$_POST['visitcode'];
	$fromdate=$_POST['ADate1'];
	$todate=$_POST['ADate2'];
	$labreq_count=0;
	$labresult_count=0;
	/*}
	else
	{
	$searchpatient = '';
	$searchpatientcode= '';
	$searchvisitcode='';
	$docnumber='';
	$fromdate=$transactiondatefrom;
	$todate=$transactiondateto;*/
	
	//echo $searchpatient;
		//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];
		
		//$queryn21 = "select locationcode from consultation_lab where  locationcode='".$locationcode."' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and consultationdate between '$fromdate' and '$todate' and labsamplecoll='pending'";
//		$execn21 = mysql_query($queryn21) or die ("Error in Query21".mysql_error());
//		$numn21=mysql_num_rows($execn21);
//		
//		
//		 $query27 = "select locationcode from ipconsultation_lab where locationcode='".$locationcode."' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and labsamplecoll='pending' and consultationdate between '$fromdate' and '$todate'";
//			$exec27 = mysql_query($query27) or die(mysql_error());
//			 $numexec26=mysql_num_rows($exec27);
//	     	$resnw1 = $numn21+$numexec26;
//?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="100%" 
            align="left" border="0">
          <tbody>
             <tr>
			 <td colspan="12" bgcolor="#ecf0f5" class="bodytext31" nowrap="nowrap"><div align="left"><strong>Request Report </strong></div></td>
			 </tr>
            <tr>
              <td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>No.</strong></div></td>
				<td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient </strong></div></td>
				<td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Reg No  </strong></div></td>
                
				<td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit No  </strong></div></td>
               <!-- <td width="19%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Publish DateTimg</strong></div></td>-->
			
             <td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit Date</strong></div></td>
                
                <td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Radiology Item code</strong></div></td>
                
                <td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Radiology Item Rate</strong></div></td>
                
                <td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Radiology Item Name</strong></div></td>
				<td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>External Rad</strong></div></td>
				<td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>External Rate</strong></div></td>
				<td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Supplier</strong></div></td>
				
                 <td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Request Date</strong></div></td>
                
                 <td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Sample type</strong></div></td>
                
                 <td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Request Entry</strong></div></td>
				<td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Result Entry</strong></div></td>
				
				<td width=""  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amendment</strong></div></td>
                
              </tr>
              
              
           <?php
		   
		   $grandtotal="0";
		    $total="0";
		    $amendtotal="0";
			 $exttotal="0";
		    $extcount="0";
			
			$query12 = "select auto_number from master_location where locationcode='$locationcode' order by locationname";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res12 = mysqli_fetch_array($exec12);
			$loctid = $res12["auto_number"];
			
			
			
		   if($patienttype=='ALL' || $patienttype=='OP') {
		   $queryh="select labitemname,labitemcode,visitcode from (
		   select radiologyitemname as labitemname,radiologyitemcode as labitemcode,patientvisitcode as visitcode from consultation_radiology where locationcode='".$locationcode."' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and consultationdate between '$fromdate' and '$todate' and prepstatus='completed' 
		   UNION ALL
		   select itemname as labitemname,itemcode as labitemcode,visitcode as visitcode from amendment_details where visitcode like '%-$loctid' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and amenddate between '$fromdate' and '$todate' and amendfrom='radiology' and visitcode like 'OPV-%') as a group by labitemcode";
		   $exech=mysqli_query($GLOBALS["___mysqli_ston"], $queryh) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($exeche=mysqli_fetch_array($exech))
		   {
			   $itemname=$exeche['labitemname'];
			   $itemcode21=$exeche['labitemcode'];
			  
		   ?>
           
           <tr>
              <td class="bodytext31" valign="center" colspan="10"  align="left" bgcolor="#ffffff">
			  <div class="bodytext31" align="left"><strong>Radiology Item Name:<?= $itemname; ?></strong></div></td>
               <td class="bodytext31" valign="center" colspan="10"  align="left" bgcolor="#ffffff">
			  <div class="bodytext31" align="left"></div></td>
              </tr>
               
              <?php
			 
			$query23 = "select username,patientcode,patientvisitcode,patientname,radiologyitemcode as labitemcode,radiologyitemrate as labitemrate,consultationdate,resultentry,'' as amend,exclude,externalack from consultation_radiology where locationcode='".$locationcode."' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and consultationdate between '$fromdate' and '$todate' and prepstatus='completed' and radiologyitemcode='".$itemcode21."'
			UNION ALL
			select amendby as username,patientcode,visitcode as patientvisitcode,patientname,itemcode as labitemcode,rate as labitemrate,amenddate as consultationdate,'' as resultentry,'Yes' as amend,'' as exclude,'' as externalack from amendment_details where visitcode like '%-$loctid' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and amenddate between '$fromdate' and '$todate' and amendfrom='radiology' and visitcode like 'OPV-%'  and itemcode='".$itemcode21."'
			";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$numexec23=mysqli_num_rows($exec23);
			if($numexec23>0)
			while($res23 = mysqli_fetch_array($exec23))
			{
			$resultdone='';
			$username=$res23['username'];
			$patientcode = $res23['patientcode'];
			$visitcode = $res23['patientvisitcode'];
			$patientname = $res23['patientname'];
			$itemcode = $res23['labitemcode'];
			$itemrate = $res23['labitemrate'];
			$consultationdate = $res23['consultationdate'];
			$resultentry = $res23['resultentry'];
			$externalack = $res23['externalack'];
			$exclude = $res23['exclude'];
			$amend = $res23['amend'];
			if($resultentry=='completed'){
				$resultdone='Yes';
				$labresult_count+=1;
			} else if($amend=='Yes'){
				$amendtotal+=1;
			}else{
				$labreq_count+=1;
			}
			
			$total+=$itemrate;
		
		$query24="select recorddate from master_consultation where patientcode='".$patientcode."' and patientvisitcode='".$visitcode."'";
		$exec24=mysqli_query($GLOBALS["___mysqli_ston"], $query24)or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res24=mysqli_fetch_array($exec24);
		$visitdate=$res24['recorddate'];
	
		$itemrate_ext=0.00;
		$suppliername='';
		$sample='';
		$extlab=0;
		if($exclude == 'yes'  && $externalack=='0'){
			$extcount+=1;
				$extlab=1;
		$supplierq = "select suppliercode,rate from rad_supplierlink where itemcode = '$itemcode' and fav_supplier='1'";
		$execq = mysqli_query($GLOBALS["___mysqli_ston"], $supplierq) or die("Error in SupplierQ".mysqli_error($GLOBALS["___mysqli_ston"]));
		$resq = mysqli_fetch_array($execq);
		$suppliercode = $resq['suppliercode'];
		$itemrate_ext = $resq['rate'];
		$exttotal+=$itemrate_ext;
		$query20 = "select accountname from master_accountname where id = '$suppliercode' ";
		$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die('Error in Query20'.mysqli_error($GLOBALS["___mysqli_ston"]));
		$res20 = mysqli_fetch_array($exec20);
		$suppliername = $res20['accountname'];
		
		}
		
		
		if($visitcode=='walkinvis')
		{
		$visitdate=$consultationdate;	
		}
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
          
              <td height=""  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode; ?></div></td>
			<!--	<input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitcode; ?>">
              
			  
				<input type="hidden" name="docnumber[]" value="///*<?php echo $docnumber; ?>"> -->
         
             <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitdate; ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $itemcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo number_format($itemrate,2); ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $itemname; ?></div></td>
			      <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $extlab; ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo number_format($itemrate_ext,2); ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $suppliername; ?></div></td>
                  
              <td width=""  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $consultationdate; ?> </div></td>
              <td width=""  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sample;?></div></td>
              <td width=""  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $username;?></div></td>
              <td width=""  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $resultdone;?></div></td>
              <td width=""  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $amend;?></div></td>
              
			   
           
		   <?php 
		   } 
		   ?>
		   <tr>
           <td height=""  align="left" valign="center" class="bodytext31" colspan="6"><div align="right"><strong>Sub Total</strong></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><strong><?= number_format($total,2) ?></strong></div></td>
             </tr>
             <?php
			 $grandtotal=$grandtotal+$total;
			 $total=0;
			 //$sno =0;
           }
		   }
		   ?>   
           
              
           
           <?php 
		    if($patienttype=='ALL' || $patienttype=='IP') {
		     $total1="0";
			$queryq="select labitemname,labitemcode,visitcode from (
			select radiologyitemname as labitemname,radiologyitemcode as labitemcode,patientvisitcode as visitcode from ipconsultation_radiology where locationcode='".$locationcode."' and prepstatus='completed' and consultationdate between '$fromdate' and '$todate' 
			UNION ALL
			select itemname as labitemname,itemcode as labitemcode,visitcode as visitcode from amendment_details where visitcode like '%-$loctid' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and amenddate between '$fromdate' and '$todate' and amendfrom='radiology' and visitcode like 'IPV-%') as a group by labitemcode";
			$execg=mysqli_query($GLOBALS["___mysqli_ston"], $queryq) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrow=mysqli_num_rows($execg);
			while( $exeg=mysqli_fetch_array($execg))
			{
			$itemname2=$exeg['labitemname'];
			$itemcode22=$exeg['labitemcode'];
			 
		   ?>
           
			    <tr>
              <td class="bodytext31" valign="center" colspan="10"  align="left" bgcolor="#ffffff">
			  <div class="bodytext31" align="left"><strong>Radiology Item Name:<?= $itemname2 ?></strong></div></td>
              <td class="bodytext31" valign="center" colspan="10"  align="left" bgcolor="#ffffff">
			  <div class="bodytext31" align="left"></div></td>
              </tr>
           
           <?php
		   $total1=0;
		     $query27 = "select username,patientcode,patientvisitcode,patientname,radiologyitemcode as labitemcode,radiologyitemrate as labitemrate,consultationdate,resultentry,'' as amend,exclude,externalack from ipconsultation_radiology where locationcode='".$locationcode."' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and prepstatus='completed' and consultationdate between '$fromdate' and '$todate' and radiologyitemcode='$itemcode22'
			 UNION ALL
			select amendby as username,patientcode,visitcode as patientvisitcode,patientname,itemcode as labitemcode,rate as labitemrate,amenddate as consultationdate,'' as resultentry,'Yes' as amend,'' as exclude,'' as externalack from amendment_details where visitcode like '%-$loctid' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and amenddate between '$fromdate' and '$todate' and amendfrom='radiology' and visitcode like 'IPV-%'  and itemcode='".$itemcode22."' ";
	
			$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			 $numexec26=mysqli_num_rows($exec27);
			
			while($res27 = mysqli_fetch_array($exec27))
			{
			$resultdone='';
			$username1= $res27['username'];
		    $patientcode2 = $res27['patientcode'];
			$visitcode2 = $res27['patientvisitcode'];
			$patientname2 = $res27['patientname'];
			//$itemname2 = $res27['labitemname'];
			$itemcode2 = $res27['labitemcode'];
			$itemrate2 = $res27['labitemrate'];
			$consultationdate2 = $res27['consultationdate'];
			$resultentry = $res27['resultentry'];
			$externalack = $res27['externalack'];
			$exclude = $res27['exclude'];
			$amend = $res27['amend'];
			if($resultentry=='completed'){
				$resultdone='Yes';
				$labresult_count+=1;
			}else if($amend=='Yes'){
				$amendtotal+=1;
			}else{
				$labreq_count+=1;
			}
			
	 		$total1+=$itemrate2;
		
		$query28="select registrationdate from master_ipvisitentry where patientcode='".$patientcode2."' and visitcode='".$visitcode2."' order by auto_number desc";
		$exec28=mysqli_query($GLOBALS["___mysqli_ston"], $query28)or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res28=mysqli_fetch_array($exec28);
		$visitdate2=$res28['registrationdate'];
		$itemrate_ext=0.00;
		
		
		$itemrate_ext=0.00;
		$suppliername='';
		$sample1='';
		$extlab=0;
		if($exclude == 'yes'  && $externalack=='1'){
		$extcount+=1;
			$extlab=1;	
		$supplierq = "select suppliercode,rate from rad_supplierlink where itemcode = '$itemcode22' and fav_supplier='1'";
		$execq = mysqli_query($GLOBALS["___mysqli_ston"], $supplierq) or die("Error in SupplierQ".mysqli_error($GLOBALS["___mysqli_ston"]));
		$resq = mysqli_fetch_array($execq);
		$suppliercode = $resq['suppliercode'];
		$itemrate_ext = $resq['rate'];
		$exttotal+=$itemrate_ext;
		$query20 = "select accountname from master_accountname where id = '$suppliercode' ";
		$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die('Error in Query20'.mysqli_error($GLOBALS["___mysqli_ston"]));
		$res20 = mysqli_fetch_array($exec20);
		$suppliername = $res20['accountname'];
		
		}
		
	
		
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
          
              <td height=""  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientname2; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode2; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode2; ?></div></td>
				<input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitcode; ?>">
              
			  
				<input type="hidden" name="docnumber[]" value="<?php echo $docnumber; ?>"> 
         
             <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitdate2; ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $itemcode2; ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo number_format($itemrate2,2); ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $itemname2; ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $extlab; ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo number_format($itemrate_ext,2); ?></div></td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $suppliername; ?></div></td>
                  
              <td width=""  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $consultationdate2; ?> </div></td>
              <td width=""  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sample1;?></div></td>
              <td width=""  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $username1;?></div></td>
              <td width=""  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $resultdone;?></div></td>
              <td width=""  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $amend;?></div></td>
              
			  </tr>
           
           
           
           <?php
		   }
		   ?>
		   <tr>
             <td height="45"  align="left" valign="center" class="bodytext31" colspan="6"><div align="right"><strong>Sub Total</strong></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><strong><?= number_format($total1,2) ?></strong></div></td>
             </tr>
             <?php
			 $grandtotal=$grandtotal+$total1;
		   }
		   }
		   ?>
           
           <tr>
             <td height="45"  align="left" valign="center" class="bodytext31" colspan="6"><div align="right"><strong>Grand Total</strong></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><strong><?= number_format($grandtotal,2) ?></strong></div></td>
             </tr>
			 
			 
			<tr>
			
             <td height="45"  align="left" valign="center" class="bodytext31" colspan="2"><div align="right"><strong>Radiology Request Count</strong></div></td>
			   <td class="bodytext31" valign="center"  align="left" colspan="2">
			  <div class="bodytext31" align="center"><strong><?= number_format($labreq_count+$labresult_count+$amendtotal,2) ?></strong></div></td>
			  
			  <td height="45"  align="left" valign="center" class="bodytext31" colspan="2"><div align="right"><strong>Radiology Pending Count</strong></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><strong><?= number_format($labreq_count,2) ?></strong></div></td>

			  <td height="45"  align="left" valign="center" class="bodytext31" colspan="2"><div align="right"><strong>Result Entry Count</strong></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><strong><?= number_format($labresult_count,2) ?></strong></div></td> 
			  
			  <td height="45"  align="left" valign="center" class="bodytext31" colspan="2"><div align="right"><strong>Amendment Count</strong></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><strong><?= number_format($amendtotal,2) ?></strong></div></td>  
			  
			  
             </tr>
			 
			  <tr>
			
             <td height="45"  align="left" valign="center" class="bodytext31" colspan="2"><div align="right"><strong>External Rad Count</strong></div></td>
			   <td class="bodytext31" valign="center"  align="left" colspan="2">
			  <div class="bodytext31" align="center"><strong><?= $extcount; ?></strong></div></td>
			  
			  <td height="45"  align="left" valign="center" class="bodytext31" colspan="2"><div align="right"><strong>External Rad Amount</strong></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><strong><?= number_format($exttotal,2) ?></strong></div></td>
			  
			  </tr>
           
           
           
                   
            <tr>
             
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"></td>
			             
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
             
              
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
      <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
               
			</tr>
          </tbody>
        </table>
<tr>
  <td>&nbsp;</td>
  </tr>
  
  
<tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	  </form>
      <?php }?>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>