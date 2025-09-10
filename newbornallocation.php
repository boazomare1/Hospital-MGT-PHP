<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
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

$query1111 = "select * from master_employee where username = '$username'";
    $exec1111 = mysqli_query($GLOBALS["___mysqli_ston"], $query1111) or die ("Error in Query1111".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res1111 = mysqli_fetch_array($exec1111))
	{
	$locationnumber = $res1111["location"];
	$query1112 = "select * from master_location where auto_number = '$locationnumber'";
    $exec1112 = mysqli_query($GLOBALS["___mysqli_ston"], $query1112) or die ("Error in Query1112".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res1112 = mysqli_fetch_array($exec1112))
	{
		 $locationname = $res1112["locationname"];		  
		 $locationcode = $res1112["locationcode"];
		
	}
	}



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag1 == 'frmflag1')
{
       
		$paynowbillprefix7 = 'BA-';
$paynowbillprefix17=strlen($paynowbillprefix7);
$query27 = "select * from ip_bedallocation order by auto_number desc limit 0, 1";
$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));
$res27 = mysqli_fetch_array($exec27);
$billnumber7 = $res27["docno"];
$billdigit7=strlen($billnumber7);

if ($billnumber7 == '')
{
	$billnumbercode7 =$paynowbillprefix7.'1';
		$openingbalance = '0.00';

}
else
{
	$billnumber7 = $res27["docno"];
	$billnumbercode7 = substr($billnumber7,$paynowbillprefix17, $billdigit7);
	//echo $billnumbercode;
	$billnumbercode7 = intval($billnumbercode7);
	$billnumbercode7 = $billnumbercode7 + 1;

	$maxanum7 = $billnumbercode7;
	
	
	$billnumbercode7 = $paynowbillprefix7 .$maxanum7;
}
		$patientname = $_REQUEST['patientname1'];
		$patientcode = $_REQUEST['patientcode1'];
		$visitcode = $_REQUEST['visitcode1'];
		$accname = $_REQUEST['accname1'];
		$mothername = $_REQUEST['searchsuppliername1'];
		$mothercode = $_REQUEST['varSupplierCode1'];
		$mothervisitcode = $_REQUEST['varSuppliervisitCode1'];
		$motheraccountname = $_REQUEST['accountname1'];
		
		$query67 = "select * from master_accountname where auto_number='$accname'";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
		$res67 = mysqli_fetch_array($exec67);
		$accname = $res67['accountname'];
		$ward = '';
		$bed = '';
		$standbybed = '';
		
		$query33 = "select * from ip_bedallocation where visitcode='$visitcode'";
		$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num33 = mysqli_num_rows($exec33);
		if($num33 == 0)
		{
		$query67 = "insert into ip_bedallocation(docno,patientname,patientcode,visitcode,accountname,ward,bed,standbybedstatus,recordtime,recorddate,ipaddress,username,locationname,locationcode)values('$billnumbercode7','$patientname','$patientcode','$visitcode','$accname','$ward','$bed','$standbybed','$updatetime','$updatedate','$ipaddress','$username','$locationname','$locationcode')";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query677 = "insert into newborn_motherdetails(patientname,patientcode,patientvisitcode,patientaccountname,mothername,mothercode,mothervisitcode,motheraccountname,ipaddress,companyanum,companyname,username,entrydate,entrytime,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accname','$mothername','$mothercode','$mothervisitcode','$motheraccountname','$ipaddress','$companyanum','$companyname','$username','$transactiondateto','$updatetime','$locationname','$locationcode')";
		$exec677 = mysqli_query($GLOBALS["___mysqli_ston"], $query677) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			
		$query64 = "update master_ipvisitentry set bedallocation='completed' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		
		}
		header("location:newbornadmission.php");
		exit;

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

include ("autocompletebuild_customer1.php");
?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'BA-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ip_bedallocation order by auto_number desc limit 0, 1";
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
include ("autocompletebuild_customer2newborn.php");
?>
<?php

if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

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
<script type="text/javascript" src="js/autocomplete_customer2newborn.js"></script>
<script type="text/javascript" src="js/autosuggestcustomer2newborn.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}
function validcheck()
{
 	if(document.getElementById("searchsuppliername").value == '')
	{
		alert("Please Enter Patient Name");
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
		<form name="form1" id="form1" method="post" action="newbornallocation.php" onSubmit="return validcheck()">
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
		  <tr bgcolor="#ecf0f5" class="bodytext31"><td colspan="4"><strong>New Born Admission</strong></td></tr>
             <tr>
			 <?php 
			 $querys = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
			 $execs = mysqli_query($GLOBALS["___mysqli_ston"], $querys) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $nums=mysqli_num_rows($execs);
			 $ress = mysqli_fetch_array($execs);
			 ?>
			  <td width="13%" align="left" valign="center" class="bodytext31"><strong>Doc No</strong></td>
			   <td width="19%" align="left" valign="center" class="bodytext31"><?php echo $billnumbercode; ?><input type="hidden" name="docno" id="docno" value="<?php echo $billnumbercode; ?>" size="10" readonly></td>
			   <td width="10%"  align="left" valign="center" class="bodytext31"><strong>Name</strong></td>
			   <td width="12%"  align="left" valign="center" class="bodytext31"><?php echo $ress['patientfullname']; ?>
			   </td>
             </tr>
			 <tr>
			  <td width="13%" align="left" valign="center" class="bodytext31"><strong>Patient Code</strong></td>
			   <td width="19%" align="left" valign="center" class="bodytext31"><?php echo $ress['patientcode']; ?></td>
			   <td width="10%"  align="left" valign="center" class="bodytext31"><strong>Visit Code</strong></td>
			   <td width="12%"  align="left" valign="center" class="bodytext31"><?php echo $ress['visitcode']; ?>
			   <input type="hidden" name="patientname" id="patientname" value="<?php echo $ress['patientfullname']; ?>">				 
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $ress['patientcode']; ?>">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $ress['visitcode']; ?>">			
				<input type="hidden" name="accname" id="accname" value="<?php echo $ress['accountname']; ?>">
			   </td>
             </tr>
            
          <tr>
		  <td class="bodytext31"><strong>Mother Patient Search</strong></td>
		  <td><input type="text" name="searchsuppliername" id="searchsuppliername" size="35" value = "<?php echo $searchsuppliername; ?>">
		  
		  <input type="hidden" name="varSupplierCode" id="varSupplierCode" size="5" readonly  value = "<?php echo $varSupplierCode; ?>">
		  
		  <input type="hidden" name="varSuppliervisitCode" id="varSuppliervisitCode" size="5" readonly  value = "<?php echo $varSuppliervisitCode; ?>">
		 		  
		   <input type="hidden" name="accountname" id="accountname" size="35" readonly value = "<?php echo $accountname; ?>">
		    <input type="hidden" name="frmflag2" value="frmflag2" />
		  
           <input type="submit" name="search" value="Search">
		   
             </tr>
		  
           
           
          </tbody>
        </table></form>		</td>
		</tr>
		
		</table>		</td>
		</tr>
	
      <tr>
        <td>&nbsp;</td>
      </tr>
	  <?php 
	  if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
	  if($frmflag2 =='frmflag2'){
	  $mothername = $_REQUEST['searchsuppliername'];
	  $mothercode = $_REQUEST['varSupplierCode'];
	  $mothervisitcode = $_REQUEST['varSuppliervisitCode'];
	  $motheraccountname = $_REQUEST['accountname'];
	  $patientname = $_REQUEST['patientname'];
	  $patientcode = $_REQUEST['patientcode'];
	  $visitcode = $_REQUEST['visitcode'];
	  $accname = $_REQUEST['accname'];
	  ?>
     <tr>
        <td>&nbsp;</td>
		 <td>
		 <form name="form2" id="form2" method="post" action="newbornallocation.php" >
		 <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
          <tbody>
             <tr bgcolor="#fff">
			 <?php 
			 $querys = "select * from master_ipvisitentry where patientcode='$mothercode' and visitcode='$mothervisitcode'";
			 $execs = mysqli_query($GLOBALS["___mysqli_ston"], $querys) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $nums=mysqli_num_rows($execs);
			 $ress = mysqli_fetch_array($execs);
			 
			 $querys1 = "select * from ip_bedallocation where patientcode='$mothercode' and visitcode='$mothervisitcode'";
			 $execs1 = mysqli_query($GLOBALS["___mysqli_ston"], $querys1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $nums1 =mysqli_num_rows($execs1);
			 $ress1 = mysqli_fetch_array($execs1);
			 $ward = $ress1['ward'];
			 $bed = $ress1['bed']; 
			 
			 $querys12 = "select * from master_ward where auto_number='$ward'";
			 $execs12 = mysqli_query($GLOBALS["___mysqli_ston"], $querys12) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $nums12 =mysqli_num_rows($execs12);
			 $ress12 = mysqli_fetch_array($execs12);
			 
			 $querys11 = "select * from master_bed where auto_number='$bed'";
			 $execs11 = mysqli_query($GLOBALS["___mysqli_ston"], $querys11) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $nums11 =mysqli_num_rows($execs11);
			 $ress11 = mysqli_fetch_array($execs11);
			 
			 ?>
			  <td width="13%" align="left" valign="center" class="bodytext31"><strong>Patient Code</strong></td>
			   <td width="10%" align="left" valign="center" class="bodytext31"><strong>Patient Visit Code</strong></td>
			   <td width="20%"  align="left" valign="center" class="bodytext31"><strong>Patient Name</strong></td>
			   <td width="12%"  align="left" valign="center" class="bodytext31"><strong>Patient Ward</strong>
			   </td>
			   <td width="12%"  align="left" valign="center" class="bodytext31"><strong>Patient Bed</strong>
			   </td>
             </tr>
			 
            <tr bgcolor="#CBDBFA">
			<td width="13%" align="left" valign="center" class="bodytext31"><?php echo $ress['patientcode']; ?>
			<input type="hidden" name="searchsuppliername1" id="searchsuppliername1" size="35" value = "<?php echo $ress['patientfullname']; ?>">
		  
		  <input type="hidden" name="varSupplierCode1" id="varSupplierCode1" size="5" readonly  value = "<?php echo $ress['patientcode']; ?>">
		  
		  <input type="hidden" name="varSuppliervisitCode1" id="varSuppliervisitCode1" size="5" readonly  value = "<?php echo $ress['visitcode']; ?>">
		 		  
		   <input type="hidden" name="accountname1" id="accountname1" size="35" readonly value = "<?php echo $ress['accountname']; ?>">
		   <input type="hidden" name="patientname1" id="patientname1" value="<?php echo $patientname; ?>">				 
				<input type="hidden" name="patientcode1" id="patientcode1" value="<?php echo $patientcode; ?>">
				<input type="hidden" name="visitcode1" id="visitcode1" value="<?php echo $visitcode; ?>">			
				<input type="hidden" name="accname1" id="accname1" value="<?php echo $accname; ?>">
			</td>
			   <td width="19%" align="left" valign="center" class="bodytext31"><?php echo $ress['visitcode']; ?></td>
			   <td width="10%"  align="left" valign="center" class="bodytext31"><?php echo $ress['patientfullname']; ?></td>
			   <td width="12%"  align="left" valign="center" class="bodytext31"><?php echo $ress12['ward']; ?>
			   </td>
			   <td width="12%"  align="left" valign="center" class="bodytext31"><?php echo $ress11['bed']; ?>
			   </td>
			</tr>
         <tr>
		 <td colspan="5" align="right"><input type="hidden" name="frmflag1" value="frmflag1" /> <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>
		 </tr>
		  
           
           
          </tbody>
        </table></form>
                 
      </tr>
      <?php } ?>
	  
     		
     
	  <tr>
        <td>&nbsp;</td>
		 <td>&nbsp;</td>
		  <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="center" valign="center" class="bodytext311">         </td>
                 
      </tr>
    </table>
  </table>

<?php include ("includes/footer1.php"); ?>
</body>
</html>

