<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

//This include updatation takes too long to load for hunge items database.



 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];


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
<?php include ("js/dropdownlistipbilling.php"); ?>
<script type="text/javascript" src="js/autosuggestipbilling1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_customeripbilling.js"></script>

<script>

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

</script>
<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
}

function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
}

function funcvalidcheck()
{
if(document.cbform1.customer.value == '')
{
alert("Please Enter the Patient Name");
return false;
}
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

<body onLoad="funcOnLoadBodyFunctionCall();">
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
		
		
              <form name="cbform1" method="post" action="ipbillingdetails1.php">
		<table width="800" border="0" align="left" cellpadding="8" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="1" bgcolor="#ecf0f5" class="bodytext3"><strong>IP Billing Details</strong></td>
              <td colspan="1" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
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
				  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Search </td>
				  <td colspan="1" align="left" valign="middle"  bgcolor="#FFFFFF">
				  <input name="customer" id="customer" size="60" autocomplete="off">
				  <input name="customercode" id="customercode" value="" type="hidden">
				  <input name="visitcode" id="visitcode" value="" type="hidden">
				<input type="hidden" name="recordstatus" id="recordstatus">
				  <input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>" readonly style="border: 1px solid #001E6A;"></td>
				  </tr>
				<tr>
  			  <td width="10%" align="left" colspan="0" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 
				 <select name="location" id="location"  onChange=" ajaxlocationfunction(this.value);" >
                    <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
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
			  
			  </tr>
             <tr>
              <td width="20%" align="center" colspan="2" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input   type="submit" value="Search" name="Submit" onClick="return funcvalidcheck();"/>
            </td>
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
      
	  <form name="form11" id="form11" method="post" action="ipbilling.php">	
	  <tr>
        <td>
	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

echo	$searchpatient = $_POST['visitcode'];
	
	
		
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1150" 
            align="left" border="0">
          <tbody>
             <table id="AutoNumber4" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1150" 
            align="left" border="0">
            <tr>
              <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
					 <td width="22%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Patient Name</strong></div></td>
				 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Reg No</strong></div></td>
				  <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>IP Visit</strong></div></td>
				 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Current Bed</strong></div></td>
					
			
              </tr>
           <?php
		  
		  if($searchpatient != '')
		  { 
           $query34 = "select * from master_ipvisitentry where locationcode='$locationcode1' and visitcode like '%$searchpatient%' and discharge=''";
		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res34 = mysqli_fetch_array($exec34))
		   {
		   $patientname = $res34['patientfullname'];
		   $patientcode = $res34['patientcode'];
		   $visitcode = $res34['visitcode'];
		   $package = $res34['package'];
		   $date = $res34['registrationdate'];
		   $packageamount = $res34['packagecharge'];
		   //$paymentstatus = $res34['paymentstatus'];
		   //$creditapprovalstatus = $res34['creditapprovalstatus'];
		   
		   $query36 = "select * from ip_bedallocation where locationcode='$locationcode1' and visitcode='$visitcode'";
		   $exec36 = mysqli_query($GLOBALS["___mysqli_ston"], $query36) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res36 = mysqli_fetch_array($exec36);
		   $bedac = $res36['bed'];
		  
		  
		   $query35 = "select bed from master_bed where locationcode='$locationcode1' and auto_number = '$bedac'";
		   $exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res35 = mysqli_fetch_array($exec35);
		   $bedac = $res35['bed'];
		   
		 
		 
		  /* if($paymentstatus == '')
		   {
		   if($creditapprovalstatus == '')
		   {*/
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
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
		
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientname; ?></div></td>
				
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
					  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $visitcode; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $bedac; ?></div></td>
					 
			     </tr></table>
				 <table id="AutoNumber5" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1150" 
            align="left" border="0">
				<tr><td colspan="5">&nbsp;</td></tr>
				<tr>
				<tr><td colspan="5" bgcolor="#ecf0f5" class="bodytext3"><strong>IP Package</strong></td></tr>
				<tr>
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
					 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Date</strong></div></td>
				 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Ref No</strong></div></td>
				  <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>IP Package</strong></div></td>
				 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Amount</strong></div></td>
					
			
              </tr>
			  <?php $query40 = "select packagename from master_ippackage where locationcode='$locationcode1' and auto_number = '$package'";
		   $exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res40 = mysqli_fetch_array($exec40);
		   $packagename = $res40['packagename']; ?>
		   
		   <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno; ?></div></td>
		
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $date; ?></div></td>
				
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode; ?></div></td>
					  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $packagename; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($packageamount,2,'.',','); ?></div></td>
					  
			         </tr></table>
					 <table id="AutoNumber6" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1150" 
            align="left" border="0">
				 <?php $query41 = "select * from pharmacysales_details where locationcode='$locationcode1' and visitcode = '$visitcode'";
				   $exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				   $rows41 = mysqli_num_rows($exec41);
				   $sno=0;
				   
				   if($rows41 !=0){
				?>
					 <tr><td colspan="5">&nbsp;</td></tr>
				<tr>
				<tr><td colspan="9" bgcolor="#ecf0f5" class="bodytext3"><strong>IP Pharmacy</strong></td></tr>
				<tr>
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
					 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Date</strong></div></td>
				 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Ref No</strong></div></td>
				  <td width="20%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Medicine</strong></div></td>
				 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Quantity</strong></div></td>
				<td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Return</strong></div></td>
				<td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Rate</strong></div></td>
				<td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Free</strong></div></td>
				<td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Amount</strong></div></td>
					
			
              </tr>
			  <?php
			  while($res41 = mysqli_fetch_array($exec41)){
				   $ritemname = $res41['itemname'];
				   $pquantity = $res41['quantity'];
				   $prate = $res41['rate'];
			  ?>
		   
		   <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno+1; ?></div></td>
		
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $res41['entrydate']; ?></div></td>
				
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $res41['ipdocno']; ?></div></td>
					  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res41['itemname']; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo intval($pquantity); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<?php 
				$query45 = "select * from pharmacysalesreturn_details where locationcode='$locationcode1' and visitcode = '$visitcode' and itemname = '$ritemname'";
		   		$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res45 = mysqli_fetch_array($exec45);
				$rquantity =$res45['quantity'];
				$tquantity = $pquantity-$rquantity;
				$amount = $tquantity * $prate;
				?>
			    <div align="center"><?php echo intval($res45['quantity']); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($prate,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $res41['freestatus']; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($amount,2,'.',','); ?></div></td>
					  
			         </tr><?php }
					 }?>
					  </tr></table>
					  <table id="AutoNumber7" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1150" 
            align="left" border="0">
					  <?php
					  $query42 = "select * from ipconsultation_lab where locationcode='$locationcode1' and patientvisitcode = '$visitcode'";
		   $exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $rows42 = mysqli_num_rows($exec42);
		   if($rows42 !=0){
		   ?>
					 <tr><td colspan="5">&nbsp;</td></tr>
				<tr>
				<tr><td colspan="7" bgcolor="#ecf0f5" class="bodytext3"><strong>IP LAB</strong></td></tr>
				<tr>
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
					 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Date</strong></div></td>
				 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Ref No</strong></div></td>
				  <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Lab Test</strong></div></td>
				 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Rate</strong></div></td>
				<td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Free</strong></div></td>
				<td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Amount</strong></div></td>
				
					
			
              </tr>
			  <?php 
		   $sno=0;
		   while($res42 = mysqli_fetch_array($exec42)){
		    ?>
		   
		   <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno+1; ?></div></td>
		
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $res42['consultationdate']; ?></div></td>
				
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $res42['iptestdocno']; ?></div></td>
					  
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $res42['labitemname']; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($res42['labitemrate'],2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $res42['freestatus']; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($res42['labitemrate'],2,'.',','); ?></div></td>
				
					  
			         </tr><?php }
					 }?></table>
					 <table id="AutoNumber8" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1150" 
            align="left" border="0">
					 <?php 
					 $query43 = "select * from ipconsultation_radiology where locationcode='$locationcode1' and patientvisitcode = '$visitcode'";
		  			 $exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					 $rows43 = mysqli_num_rows($exec43);
		   				if($rows43 !=0){
					 ?>
					 
					 	 <tr><td colspan="5">&nbsp;</td></tr>
				<tr>
				<tr><td colspan="7" bgcolor="#ecf0f5" class="bodytext3"><strong>IP Radiology</strong></td></tr>
				<tr>
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
					 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Date</strong></div></td>
				 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Ref</strong></div></td>
				  <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Radiology Test</strong></div></td>
				 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Rate</strong></div></td>
				<td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Free</strong></div></td>
				<td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Amount</strong></div></td>
				
					
			
              </tr>
			  <?php 
		   $sno=0;
		   while($res43 = mysqli_fetch_array($exec43)){
		    ?>
		   
		   <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno+1; ?></div></td>
		
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $res43['consultationdate']; ?></div></td>
				
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $res43['iptestdocno']; ?></div></td>
					  
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $res43['radiologyitemname']; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($res43['radiologyitemrate'],2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $res43['freestatus']; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($res43['radiologyitemrate'],2,'.',','); ?></div></td>
				
					  
			         </tr><?php }
					 }?></tr></table>
					 <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1150" 
            align="left" border="0">
					 <?php 
					 $query44 = "select * from ipconsultation_services where locationcode='$locationcode1' and patientvisitcode = '$visitcode'";
		   $exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		    $rows44 = mysqli_num_rows($exec44);
		   				if($rows44 !=0){
		   
					 ?>
					 
					  <tr><td colspan="5">&nbsp;</td></tr>
				<tr>
				<tr><td colspan="7" bgcolor="#ecf0f5" class="bodytext3"><strong>IP Service</strong></td></tr>
				<tr>
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
					 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Date</strong></div></td>
				 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Ref No</strong></div></td>
				  <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Service Test</strong></div></td>
				 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Rate</strong></div></td>
				<td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Free</strong></div></td>
				<td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Amount</strong></div></td>
				
					
			
              </tr>
			  <?php 
		   $sno=0;
		   while($res44 = mysqli_fetch_array($exec44)){
		    ?>
		   
		   <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno+1; ?></div></td>
		
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $res44['consultationdate']; ?></div></td>
				
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $res44['iptestdocno']; ?></div></td>
					  
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $res44['servicesitemname']; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($res44['servicesitemrate'],2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $res44['freestatus']; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($res44['servicesitemrate'],2,'.',','); ?></div></td>
				
					  
			         </tr><?php }
					 }?></tr>
			<tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5" colspan="6">&nbsp;</td>
			
				
				   
			
			</tr>
			</table>
					 
					
		  <?php
		  //}
		  //}
		 }
		  }
		          ?>
            
			
          </tbody>
        </table>
		
<?php
}
?>	
		</td>
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
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>