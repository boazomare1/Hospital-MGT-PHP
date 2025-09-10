<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddateto = date('Y-m-d');
//$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
 $paymentreceiveddatefrom = date('Y-m-01', strtotime($paymentreceiveddateto));

$snocount='';
$colorloopcount='';
$res3recorddate = array();
$countitem  = '';
$totalcount = '';
$finalcount='';
$finalconsumption='';
$query = "select * from login_locationdetails where username='$username' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

$locationname  = $res["locationname"];

$locationcode = $res["locationcode"];
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

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
}
if (isset($_REQUEST["medicinecode"])) { $medicinecode = $_REQUEST["medicinecode"]; } else { $medicinecode = ""; }
if (isset($_REQUEST["reporttype"])) { $reporttype = $_REQUEST["reporttype"]; } else { $reporttype = ""; }
if (isset($_REQUEST["bytype"])) { $bytype = $_REQUEST["bytype"]; } else { $bytype = ""; }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

if (isset($_REQUEST["medicinename"])) { $itemname = $_REQUEST["medicinename"]; } else { $itemname = ""; }
//$billstatus = $_REQUEST['billstatus'];
if ($ADate1 != '' && $ADate2 != '')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}
else
{
	//$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
	$transactiondatefrom = date('Y-m-01', strtotime($paymentreceiveddateto));
	$transactiondateto = date('Y-m-d');
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
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 


<link href="css/autocomplete.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<?php include ("js/dropdownlist1scriptingrequestmedicine.php"); ?>
<script type="text/javascript" src="js/autosuggestrequestmedicine2.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_requestmedicine.js"></script>
<script>
function funcOnLoadBodyFunctionCall()
{	
	//funcCustomerDropDownSearch4();	
}
</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
</head>
<script src="js/datetimepicker_css.js"></script>
<body onLoad="return funcOnLoadBodyFunctionCall();">
<table width="1900" border="0" cellspacing="0" cellpadding="2">
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
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
             <form name="cbform1" method="post" action="labregentlinkreport.php">
			  <input name="locationcode" type="hidden" id="locationcode" readonly size="8" value="<?php echo $locationcode;?>">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Lab Reagent Report </strong></td>
                      <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                      <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">&nbsp;</td>
                    </tr>
					<tr>
              <td align="left" class="bodytext3" bgcolor="#FFFFFF"><strong>Select Type</strong> </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
				<select name="reporttype" id="reporttype" onChange="return disabletype();">
                          <option value="1" <?php if($reporttype==1) echo 'selected'; ?>>Summary</option>
						<!--  <option value="2" <?php if($reporttype==2) echo 'selected'; ?>>Details</option>-->
				</select>
               </td>
              </tr>
			  
			  
			  <tr>
              <td align="left" class="bodytext3" bgcolor="#FFFFFF"><strong>By</strong> </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
				<select name="bytype" id="bytype">
                          <option value="1" <?php if($bytype==1) echo 'selected'; ?>>Reagent</option>
						<option value="2" <?php if($bytype==2) echo 'selected'; ?>>Test</option>
				</select>
               </td>
              </tr>
			  
					 <tr>
              <td width="20%" class="bodytext3" bgcolor="#FFFFFF"><strong> Select </strong></td>
			   <td colspan="4" class="bodytext3" bgcolor="#FFFFFF"> <input type="hidden" name="serialnumber" id="serialnumber" value="1">
					  <input type="hidden" name="medicinecode" id="medicinecode" value="">
                        <input name="medicinename" type="text" id="medicinename" size="69" autocomplete="off" onFocus="return auditypeearch()">
						  <input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">
			  <input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">
              </tr>
                    <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> <strong>Date From</strong> </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> <strong>Date To</strong> </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
                    </tr>
                  </tbody>
                </table>
              </form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      
			  
				
				
			<?php
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			
			if($reporttype=='1'){
			
			if($bytype=='1'){  ?>
			
			<tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="600" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="43%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reagent Name </strong></div></td>
				
				 <td width="13%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Count </strong></div></td>
				
              <td width="17%" align="right" valign="right"  
                bgcolor="#ffffff" class="style1">Consumption</td>
              </tr>
			
			
			<?php
						
			if($itemname!=''){	?>
			<tr bgcolor="#9999FF">
            <td colspan="7"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo  $itemname;?></strong></td>
            </tr>		
			<?php $itemname = trim($itemname);
			$totalcount='';
			$totalquanity='';
			$finalcount='';
			$finalconsumption='';
			$query3 = "select * from master_lablinking where itemname like '%$itemname%' and recordstatus <> 'deleted' "; 			
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res3 = mysqli_fetch_array($exec3))
			{
			$labname= $res3['labname'];
			$res3quantity= $res3['quantity'];
			$res3labcode= $res3['labcode'];
			
			///op
            $query1 = "select labitemname,labitemcode,labsamplecoll,consultationdate  from consultation_lab where  labsamplecoll = 'completed' and labitemcode = '$res3labcode' and consultationdate  between '$transactiondatefrom' and '$transactiondateto' group by labitemcode";
		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num1 = mysqli_num_rows($exec1);
		  //echo $num1;
		  while($res1 = mysqli_fetch_array($exec1))
		   {
        	 $res1itemname = $res1['labitemname'];
			 $countitem='';
			$totalcount='';
				$query2 = "select labitemname as item, count(labitemcode) as countitem from consultation_lab where labsamplecoll = 'completed' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and labitemname = '$res1itemname' group by labitemname";
			
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num2 = mysqli_num_rows($exec2);
			  //echo $num1;
			   while($res2 = mysqli_fetch_array($exec2))
			    {				
			   $countitem += $res2['countitem'];
			   $totalcount = $totalcount + $countitem;
                }
			
		}
        ////op
		
		///ip		
		$query10 = " select labitemname,labitemcode,labsamplecoll,consultationdate from ipconsultation_lab where  labsamplecoll = 'completed' and labitemcode = '$res3labcode' and consultationdate between '$transactiondatefrom' and '$transactiondateto' group by labitemcode ";
		  $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num10 = mysqli_num_rows($exec10);
		  //echo $num1;
		  while($res10 = mysqli_fetch_array($exec10))
		   {
        	 $res10itemname = $res10['labitemname'];
			 $query20 = " select labitemname as item, count(labitemcode) as countitem from ipconsultation_lab where labsamplecoll = 'completed' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and labitemname = '$res10itemname' group by labitemname";
				$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num20 = mysqli_num_rows($exec20);
			  //echo $num1;
			   while($res20 = mysqli_fetch_array($exec20))
			    {
			   $countitem = $res20['countitem'];
			   $totalcount = $totalcount + $countitem;
                }
			}
		//ip				
		    $totalquanity=$totalcount*$res3quantity;
		 if($totalcount>0){
			 $snocount = $snocount + 1;
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
              <td class="bodytext31" valign="center"  align="left"></td>
			  <td class="bodytext31" valign="center"  align="left">
             <?php echo $labname; ?>           </td>
               <td class="bodytext31" valign="center"  align="right">
             <?php echo $totalcount; ?>           </td>
              <td class="bodytext31" valign="center"  align="right">
               <?php echo $totalquanity; ?>           </td>
              </tr>
			<?php
			}
			
			$finalcount = $finalcount + $totalcount;
			$finalconsumption = $finalconsumption + $totalquanity;
			$totalcount=0;
			} 
			if($finalcount>0){
			?>
			
			<tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="right"  align="right" 
                bgcolor="#ecf0f5"><strong>Total</strong></td>
              <td class="bodytext31" valign="right"  align="right" 
                bgcolor="#ecf0f5"><?php echo $finalcount;?></td>
				<td class="bodytext31" valign="right"  align="right" 
                bgcolor="#ecf0f5"><?php echo $finalconsumption;?></td>
              </tr>
			<?php
			}
			}else{
			
			$itemname = trim($itemname);
			$totalcount='';
			$totalquanity='';
			
			$query38 = "select * from master_lablinking where itemname like '%$itemname%' and recordstatus <> 'deleted' group by itemcode"; 
			
			$exec38 = mysqli_query($GLOBALS["___mysqli_ston"], $query38) or die ("Error in Query38".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res38 = mysqli_fetch_array($exec38))
			{
			$labname= $res38['labname'];
			$res38quantity= $res38['quantity'];
			$res38labcode= $res38['labcode'];
			$res38itemname= $res38['itemname'];
			$res38itemcode= $res38['itemcode'];
			
			$query199 = "select labitemname,labitemcode  from((select labitemname,labitemcode from consultation_lab where  labsamplecoll = 'completed' and labitemcode = '$res38labcode' and consultationdate  between '$transactiondatefrom' and '$transactiondateto')
			UNION ALL
			(select labitemname,labitemcode  from ipconsultation_lab where  labsamplecoll = 'completed' and labitemcode = '$res38labcode' and consultationdate  between '$transactiondatefrom' and '$transactiondateto'))groupdate group by labitemcode";
		  $exec199 = mysqli_query($GLOBALS["___mysqli_ston"], $query199) or die ("Error in Query199".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num199 = mysqli_num_rows($exec199);
		  if($num199>0){
			?>
			
			<tr bgcolor="#9999FF">
              <td colspan="7"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo  $res38itemname;?></strong></td>
              </tr>
			
			<?php
			}
			$finalcount='';
			$finalconsumption='';
			$query3 = "select * from master_lablinking where itemcode = '$res38itemcode' and recordstatus <> 'deleted' "; 			
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res3 = mysqli_fetch_array($exec3))
			{
			$labname= $res3['labname'];
			$res3quantity= $res3['quantity'];
			$res3labcode= $res3['labcode'];
			
			
			
			///op
            $query1 = "select labitemname,labitemcode,labsamplecoll,consultationdate  from consultation_lab where  labsamplecoll = 'completed' and labitemcode = '$res3labcode' and consultationdate  between '$transactiondatefrom' and '$transactiondateto' group by labitemcode";
		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num1 = mysqli_num_rows($exec1);
		  //echo $num1;
		  while($res1 = mysqli_fetch_array($exec1))
		   {
        	 $res1itemname = $res1['labitemname'];
			 $countitem='';
			$totalcount='';
				$query2 = "select labitemname as item, count(labitemcode) as countitem from consultation_lab where labsamplecoll = 'completed' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and labitemname = '$res1itemname' group by labitemname";
			
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num2 = mysqli_num_rows($exec2);
			  //echo $num1;
			   while($res2 = mysqli_fetch_array($exec2))
			    {				
			   $countitem += $res2['countitem'];
			   $totalcount = $totalcount + $countitem;
                }
			
		}
		
        ////op
		
		///ip		
		$query10 = " select labitemname,labitemcode,labsamplecoll,consultationdate from ipconsultation_lab where  labsamplecoll = 'completed' and labitemcode = '$res3labcode' and consultationdate between '$transactiondatefrom' and '$transactiondateto' group by labitemcode ";
		  $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num10 = mysqli_num_rows($exec10);
		  //echo $num1;
		  while($res10 = mysqli_fetch_array($exec10))
		   {
        	 $res10itemname = $res10['labitemname'];
			 $query20 = " select labitemname as item, count(labitemcode) as countitem from ipconsultation_lab where labsamplecoll = 'completed' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and labitemname = '$res10itemname' group by labitemname";
				$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num20 = mysqli_num_rows($exec20);
			  //echo $num1;
			   while($res20 = mysqli_fetch_array($exec20))
			    {
			   $countitem = $res20['countitem'];
			   $totalcount = $totalcount + $countitem;
                }
			}
		//ip				
		    $totalquanity=$totalcount*$res3quantity;
		 if($totalcount>0){
			 $snocount = $snocount + 1;
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
              <td class="bodytext31" valign="center"  align="left"></td>
			  <td class="bodytext31" valign="center"  align="left">
             <?php echo $labname; ?>           </td>
               <td class="bodytext31" valign="center"  align="right">
             <?php echo $totalcount; ?>           </td>
              <td class="bodytext31" valign="center"  align="right">
               <?php echo $totalquanity; ?>           </td>
              </tr>
			<?php
			}
			
			$finalcount = $finalcount + $totalcount;
			$finalconsumption = $finalconsumption + $totalquanity;
			$totalcount=0;
			} 
			if($finalcount>0){
			?>
			<tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="right"  align="right" 
                bgcolor="#ecf0f5"><strong>Total</strong></td>
              <td class="bodytext31" valign="right"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo $finalcount;?></strong></td>
				<td class="bodytext31" valign="right"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo $finalconsumption;?></strong></td>
              </tr>
			<?php
			}
			}
			 }	
			 
			 }	
			 
			 if($bytype=='2'){ ?>
			 
			 
			 <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="600" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="60%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Test Name </strong></div></td>
				
				 <td width="13%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Count </strong></div></td>
				
              </tr>
			 
			<?php if($itemname!=''){	?>
			<!--<tr bgcolor="#9999FF">
            <td colspan="2"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo  $itemname;?></strong></td>
            </tr>-->	
			<?php
			$snocount =0;
			$colorloopcount=0;
			
			
			$query18 = "select labname,labcode  from master_lablinking where  recordstatus <> 'Deleted' and labcode like '%$medicinecode%'  group by labcode ";
		  $exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num18 = mysqli_num_rows($exec18);
		  //echo $num1;
		  while($res18= mysqli_fetch_array($exec18))
		   {
			 $res18itemname = $res18['labname'];
			  $res18labitemcode = $res18['labcode'];
			
			
		  ///op
            $query1 = "select labitemname,labitemcode,labsamplecoll,consultationdate  from consultation_lab where  labsamplecoll = 'completed' and labitemcode = '$res18labitemcode' and consultationdate  between '$transactiondatefrom' and '$transactiondateto' group by labitemcode";
		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num1 = mysqli_num_rows($exec1);
		  //echo $num1;
		  while($res1 = mysqli_fetch_array($exec1))
		   {
        	 $res1itemname = $res1['labitemname'];
			 $countitem='';
			$totalcount='';
				$query2 = "select labitemname as item, count(labitemcode) as countitem from consultation_lab where labsamplecoll = 'completed' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and labitemname = '$res1itemname' group by labitemname";
			
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num2 = mysqli_num_rows($exec2);
			  //echo $num1;
			   while($res2 = mysqli_fetch_array($exec2))
			    {				
			   $countitem += $res2['countitem'];
			   $totalcount = $totalcount + $countitem;
                }
			
		}
		
        ////op
		
		///ip		
		$query10 = " select labitemname,labitemcode,labsamplecoll,consultationdate from ipconsultation_lab where  labsamplecoll = 'completed' and labitemcode = '$res18labitemcode' and consultationdate between '$transactiondatefrom' and '$transactiondateto' group by labitemcode ";
		  $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num10 = mysqli_num_rows($exec10);
		  //echo $num1;
		  while($res10 = mysqli_fetch_array($exec10))
		   {
        	 $res10itemname = $res10['labitemname'];
			 $query20 = " select labitemname as item, count(labitemcode) as countitem from ipconsultation_lab where labsamplecoll = 'completed' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and labitemname = '$res10itemname' group by labitemname";
				$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num20 = mysqli_num_rows($exec20);
			  //echo $num1;
			   while($res20 = mysqli_fetch_array($exec20))
			    {
			   $countitem = $res20['countitem'];
			   $totalcount = $totalcount + $countitem;
                }
			}
		//ip				
		    //$totalquanity=$totalcount*$res3quantity;
		 
			 $snocount = $snocount + 1;
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
              <td class="bodytext31" valign="center"  align="left">  <?php echo $res18itemname; ?> </td>
              <td class="bodytext31" valign="center"  align="center"> <?php echo $totalcount; ?>  </td>
              </tr>
			  
			  <tr>
              <td width="60%" align="left" valign="left"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Reagent </strong></div></td>				
			  <td width="13%" align="left" valign="left"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="center"><strong>Consumption </strong></div></td>				
              </tr>
			<?php 
			//$snocount12 =0;
			if($totalcount>0){
			$colorloopcount12=0; 
		  	$query3 = "select * from master_lablinking where labcode = '$res18labitemcode' and recordstatus <> 'deleted' "; 			
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res3 = mysqli_fetch_array($exec3))
			{
			$res3itemname= $res3['itemname'];
			$res3quantity= $res3['quantity'];
			$res3labcode= $res3['labcode'];
			$colorloopcount12 = $colorloopcount12 + 1;
			$showcolor = ($colorloopcount12 & 1); 
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
			    $totalquanity=$totalcount*$res3quantity;
			
			?>
			  
			 <tr <?php echo $colorcode; ?>>
			  <td class="bodytext31" valign="center" colspan="" align="left"><?php echo $res3itemname; ?>           </td>
			  <td class="bodytext31" valign="center"  align="center"><?php echo $totalquanity; ?>           </td>			  
			  </tr>
			
			<?php
			}
			}
			}
			}
			
			else{
			
			$totalcount='';
		$query18 = "select labname,labcode  from master_lablinking where  recordstatus <> 'Deleted' and labcode like '%$medicinecode%'  group by labcode";
		  $exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num18 = mysqli_num_rows($exec18);
		  //echo $num1;
		  while($res18= mysqli_fetch_array($exec18))
		   {
			 $res18itemname = $res18['labname'];
			 $res18labitemcode = $res18['labcode'];
		   ?>
			<!--<tr bgcolor="#9999FF">
            <td colspan="2"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo  $res18itemname;?></strong></td>
            </tr>-->	
			<?php
			$snocount =0;
			$colorloopcount=0;

		  ///op
            $query1 = "select labitemname,labitemcode,labsamplecoll,consultationdate  from consultation_lab where  labsamplecoll = 'completed' and labitemcode = '$res18labitemcode' and consultationdate  between '$transactiondatefrom' and '$transactiondateto' group by labitemcode";
		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num1 = mysqli_num_rows($exec1);
		  //echo $num1;
		  while($res1 = mysqli_fetch_array($exec1))
		   {
        	 $res1itemname = $res1['labitemname'];
			 $countitem='';
			$totalcount='';
				$query2 = "select labitemname as item, count(labitemcode) as countitem from consultation_lab where labsamplecoll = 'completed' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and labitemname = '$res1itemname' group by labitemname";
			
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num2 = mysqli_num_rows($exec2);
			  //echo $num1;
			   while($res2 = mysqli_fetch_array($exec2))
			    {				
			   $countitem += $res2['countitem'];
			   $totalcount = $totalcount + $countitem;
                }
			
		}
		
        ////op
		
		///ip		
		$query10 = " select labitemname,labitemcode,labsamplecoll,consultationdate from ipconsultation_lab where  labsamplecoll = 'completed' and labitemcode = '$res18labitemcode' and consultationdate between '$transactiondatefrom' and '$transactiondateto' group by labitemcode ";
		  $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num10 = mysqli_num_rows($exec10);
		  //echo $num1;
		  while($res10 = mysqli_fetch_array($exec10))
		   {
		   
        	 $res10itemname = $res10['labitemname'];
			 $query20 = " select labitemname as item, count(labitemcode) as countitem from ipconsultation_lab where labsamplecoll = 'completed' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and labitemname = '$res10itemname' group by labitemname";
				$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num20 = mysqli_num_rows($exec20);
			  //echo $num1;
			   while($res20 = mysqli_fetch_array($exec20))
			    {
			   $countitem = $res20['countitem'];
			   $totalcount = $totalcount + $countitem;
                }
			}
		    //ip				
		    //$totalquanity=$totalcount*$res3quantity;
		 
			 $snocount = $snocount + 1;
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
			
			if($totalcount>0){
			?>

              <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"  bgcolor="#ffffff"><strong>  <?php echo $res18itemname; ?> </strong></td>
              <td class="bodytext31" valign="center"  align="center"  bgcolor="#ffffff"> <strong><?php echo $totalcount; ?></strong>  </td>
              </tr>
			  
			  <tr>
              <td width="60%" align="left" valign="left"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Reagent </strong></div></td>				
			  <td width="13%" align="left" valign="left"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="center"><strong>Consumption </strong></div></td>				
              </tr>
			<?php 
			//$snocount12 =0;
			$colorloopcount12=0; 
		  	$query3 = "select * from master_lablinking where labcode = '$res18labitemcode' and labname = '$res18itemname' and recordstatus <> 'deleted' "; 			
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res3 = mysqli_fetch_array($exec3))
			{
			$res3itemname= $res3['itemname'];
			$res3quantity= $res3['quantity'];
			$res3labcode= $res3['labcode'];
			$colorloopcount12 = $colorloopcount12 + 1;
			$showcolor = ($colorloopcount12 & 1); 
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
			    $totalquanity=$totalcount*$res3quantity;
			
			?>
			  
			 <tr <?php echo $colorcode; ?>>
			  <td class="bodytext31" valign="center" colspan="" align="left"><?php echo $res3itemname; ?>           </td>
			  <td class="bodytext31" valign="center"  align="center"><?php echo $totalquanity; ?>           </td>			  
			  </tr>
			
			<?php
			} 
			?>
			  
			  <tr>
              <td width="60%" align="left" valign="left"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong> </strong></div></td>				
			  <td width="13%" align="left" valign="left"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="center"><strong> </strong></div></td>				
              </tr>
			
			<?php
			$totalcount=0;
			}
			
			
			
			}
			
			}
			
			}			 
			}						
			}
			?>
            
          </tbody>
        </table></td>
      </tr>
    </table>
</table>


<script>



function auditypeearch(){
			
var pid=document.getElementById('bytype').value;
var medicinename=document.getElementById('medicinename').value;
	    // alert(medicinename);   
  $('#medicinename').autocomplete({	
  source:"ajax_labreagenttestsearch_itemsearch.php?pid="+pid+"&&term="+medicinename,
  minLength:1,
  html: true,
  select: function(event,ui)
	{
	 var mobile=ui.item.value;
		var excessnov=ui.item.mobile;
		// var cdocno=ui.item.cdocno;
		 
		$("#medicinename").val(mobile);
		$("#medicinecode").val(excessnov);
		
		
	
		
	}, 
	});
	
	}
</script>

<?php include ("includes/footer1.php"); ?>
</body>
</html>

