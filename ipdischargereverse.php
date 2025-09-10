<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";



if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag1 == 'frmflag1')
{
       
		//get locationcode and locationname for inserting
		$locationcodeget=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';
		$locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
		//get ends here

		$patientname = $_REQUEST['patientname'];
		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];
		$locationcode = $_REQUEST['locationcode'];
		$accname = $_REQUEST['accname'];
		$ward1 = $_REQUEST['wardanum'];
		$bed1 = $_REQUEST['bedanum'];
		$readytoreverse = $_REQUEST['readytoreverse'];
		$frompage = $_REQUEST['frompage'];
		$dischargeanum = $_REQUEST['dischargeanum'];	
        

		if($readytoreverse == 1)
		{
			$query791 = "delete from ip_discharge where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec791 = mysqli_query($GLOBALS["___mysqli_ston"], $query791) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			
		
			$query79 = "update master_bed set recordstatus='occupied' where auto_number='$bed1' and ward='$ward1' and locationcode='".$locationcodeget."'";
			$exec79 = mysqli_query($GLOBALS["___mysqli_ston"], $query79) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$query81 = "update master_ipvisitentry set discharge='' where patientcode='$patientcode' and visitcode='$visitcode' and locationcode='".$locationcodeget."'";
			$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$query88 = "update ip_bedallocation set recordstatus='',leavingdate='' where patientcode='$patientcode' and visitcode='$visitcode' and locationcode='".$locationcodeget."' and recordstatus='request'";
			$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$query881 = "update ip_bedtransfer set recordstatus='',leavingdate='' where patientcode='$patientcode' and visitcode='$visitcode' and locationcode='".$locationcodeget."' and recordstatus='request'";
			$exec881 = mysqli_query($GLOBALS["___mysqli_ston"], $query881) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$query8811 = "update newborn_motherdetails set discharge='' where patientcode='$patientcode' and patientvisitcode='$visitcode' and locationcode='".$locationcodeget."'";
			$exec8811 = mysqli_query($GLOBALS["___mysqli_ston"], $query8811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$query8812 = "delete from discharge_icd where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec88112 = mysqli_query($GLOBALS["___mysqli_ston"], $query8812) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			
			
		}

		if($frompage == 'newborn')
		{
		header("location:newbornactivity.php");
		}
		else
		{
		header("location:ipdischargelist.php");
		}
		exit;


}



?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'DIS-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ip_discharge order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);

if ($billnumber == '')
{
	$billnumbercode =$paynowbillprefix.'1';
		$openingbalance = '0.00';

}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paynowbillprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

?>
<?php

if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if(isset($_REQUEST['patientlocation'])) { $patientlocationcode = $_REQUEST["patientlocation"]; } else { $patientlocationcode = ""; }
if(isset($_REQUEST["frompage"])){$frompage = $_REQUEST["frompage"]; }else{$frompage ='';}

	$query12 = "select * from master_location where locationcode='$patientlocationcode'";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res12 = mysqli_fetch_array($exec12);
	
	 $patientlocationname = $res12["locationname"];
	
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

<script>


function funcvalidation()
{
//alert('h');
if(document.getElementById("readytoreverse").checked == false)
{
alert("Please Click on Ready To Cancel Discharge");
return false;
}

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
.bali
{
text-align:right;
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<form name="form1" id="form1" method="post" action="ipdischargereverse.php" onSubmit="return validcheck()">	
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%">&nbsp;</td>
   
    <td colspan="5" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
	 
	
		<tr>
		<td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
           <?php
		  
		  $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
		   $query2 = "select locationcode from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec2);
		
		while($res1 = mysqli_fetch_array($exec2))
		{
		
		
		$locationcodeget = $res1['locationcode'];
		$query551 = "select * from master_location where locationcode='".$locationcodeget."'";
		$exec551 = mysqli_query($GLOBALS["___mysqli_ston"], $query551) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res551 = mysqli_fetch_array($exec551);
		$locationnameget = $res551['locationname'];
		}?>
             <tr>
			  <td width="12%" align="center" valign="center" class="bodytext31"><strong> Doc No</strong></td>
			   <td width="13%" align="center" valign="center" class="bodytext31"><input type="text" name="docno" id="docno" value="<?php echo $billnumbercode; ?>" size="10" readonly></td>
			   <td width="8%"  align="center" valign="center" class="bodytext31"><strong>Date</strong></td>
			   <td width="13%"  align="center" valign="center" class="bodytext31"> 
			   <input type="text" name="date" id="date" value="<?php echo $updatedate; ?>" size="10" readonly>
                    <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('dateofbirth')" style="cursor:pointer"/> </span></strong>               </td>
					  <td width="10%" align="center" valign="center" class="bodytext31"><strong>Time</strong></td>
                      <td colspan="2" align="left" valign="center" class="bodytext31"> <input type="text" name="time" id="time" value="<?php echo $updatetime; ?>" size="10" readonly></td>
					  <td width="10%" align="center" valign="center" class="bodytext31"><strong>Location</strong></td>
                      <td colspan="2" align="left" valign="center" class="bodytext31"><?php echo $locationnameget; ?>
                       <input type="hidden" name="locationcodeget" value="<?php echo $locationcodeget?>">
				<input type="hidden" name="locationnameget" value="<?php echo $locationnameget?>">
                       <input type="hidden" name="locationcode" id="locationcode" value="<?php echo $patientlocationcode; ?>" size="10" readonly></td>
                      
             </tr>
            <tr>
              
				 <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
           
				 <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				 <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Visit  </strong></div></td>
				 <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ward</strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bed</strong></div></td>
				<td width="21%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
              </tr>
           <?php
            $colorloopcount ='';
		
		$query1 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode' and paymentstatus ='' and locationcode='$patientlocationcode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		$patientname=$res1['patientfullname'];
		$patientcode=$res1['patientcode'];
		$accountname = $res1['accountname'];
		$gender = $res1['gender'];
		$age = $res1['age'];
		
		
		$query67 = "select * from master_accountname where auto_number='$accountname'";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
		$res67 = mysqli_fetch_array($exec67);
		$accname = $res67['accountname'];
		
		
		   $query63 = "select * from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus='request' and locationcode='$patientlocationcode'";
		   $exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res63 = mysqli_fetch_array($exec63);
		   $num63 = mysqli_num_rows($exec63);
		   if($num63 > 0)
		   {
		   $ward = $res63['ward'];
		   $bed = $res63['bed'];
		   }
		   
		   $query65 = "select * from ip_bedtransfer where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus='request' and locationcode='$patientlocationcode' order by auto_number desc";
		   $exec65 = mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res65 = mysqli_fetch_array($exec65);
		    $num65 = mysqli_num_rows($exec65);
		   if($num65 > 0)
		   {
		   $ward = $res65['ward'];
		   $bed = $res65['bed'];
		   }
		   
		   $query71 = "select * from ip_discharge where patientcode='$patientcode' and visitcode='$visitcode' and locationcode='$patientlocationcode' order by auto_number desc";
		   $exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res71 = mysqli_fetch_array($exec71);
		   $num71 = mysqli_num_rows($exec71);
		   if($num71 > 0)
		   {
		    $ward = $res71['ward'];
		    $bed = $res71['bed'];
			$dischargeanum = $res71['auto_number'];
		   }
				$query7811 = "select * from master_ward where auto_number='$ward' and recordstatus='' and locationcode='$patientlocationcode'";
						  $exec7811 = mysqli_query($GLOBALS["___mysqli_ston"], $query7811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						  $res7811 = mysqli_fetch_array($exec7811);
						  $wardname1 = $res7811['ward'];
						  
						  $query50 = "select * from master_bed where auto_number='$bed' and locationcode='$patientlocationcode'";
		                  $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						  $res50 = mysqli_fetch_array($exec50);
						  $bedname = $res50['bed'];
	

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
             
			  <td colspan="2"  align="left" valign="center" class="bodytext31">
			    <div align="center"><?php echo $patientname; ?></div></td>
				<td colspan="2"  align="center" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
				<td colspan="2"  align="center" valign="center" class="bodytext31"><?php echo $visitcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $wardname1; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $bedname; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $accname; ?></td>
				<input type="hidden" name="wardanum" id="wardanum" value="<?php echo $ward; ?>">
				<input type="hidden" name="bedanum" id="bedanum" value="<?php echo $bed; ?>">
				<input type="hidden" name="dischargeanum" id="dischargeanum" value="<?php echo $dischargeanum; ?>">
				<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname; ?>">
				 <input name="frompage" id="frompage" value="<?php echo $frompage; ?>" type="hidden">
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">
			
				<input type="hidden" name="accname" id="accname" value="<?php echo $accname; ?>">
			   </tr>
		   <?php 
		   } 
		  
		   ?>
           
            <tr>
             	<td colspan="7" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td><td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            
             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
             	</tr>
          </tbody>
        </table>		</td>
		</tr>
		
		</table>		</td>
		</tr>
	
      <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td>&nbsp;</td>
		 <td width="3%">&nbsp;</td>
		  <td width="3%">&nbsp;</td>
		<td width="26%" align="right" valign="center" class="bodytext311">Cancel Discharge</td>
		<td width="29%" align="left" valign="center" class="bodytext311"><input type="checkbox" name="readytoreverse" id="readytoreverse" value="1"></td>
      </tr>
	  <tr>
        <td>&nbsp;</td>
		 <td>&nbsp;</td>
		  <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td width="37%" align="center" valign="center" class="bodytext311">         <input type="hidden" name="frmflag1" value="frmflag1" />
        <input type="submit" name="Submit" value="Cancel" style="border: 1px solid #001E6A" onClick="return funcvalidation()"/></td>
                 
      </tr>
    </table>
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

