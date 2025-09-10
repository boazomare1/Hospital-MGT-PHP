<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo 'menu'.$menu_id;

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
  
$query1111 = "select * from master_employee where username = '$username'";
$exec1111 = mysqli_query($GLOBALS["___mysqli_ston"], $query1111) or die ("Error in Query1111".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1111 = mysqli_fetch_array($exec1111))
{
$locationnumber = $res1111["location"];
$query1112 = "select * from master_location where auto_number = '$locationnumber' and status<>'delete'";
$exec1112 = mysqli_query($GLOBALS["___mysqli_ston"], $query1112) or die ("Error in Query1112".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1112 = mysqli_fetch_array($exec1112))
{
 $locationname = $res1112["locationname"];    
 $locationcode = $res1112["locationcode"];
}
 }
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
<script>
<?php 
if (isset($_REQUEST["refundbillnumber"])) { $refundbillnumbers = $_REQUEST["refundbillnumber"]; } else { $refundbillnumbers = ""; }
if (isset($_REQUEST["patientcode"])) { $refundpatientcode = $_REQUEST["patientcode"]; } else { $refundpatientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $refundvisitcode= $_REQUEST["visitcode"]; } else { $refundvisitcode = ""; }
if (isset($_REQUEST["locationcode"])) { $refundlocationode= $_REQUEST["locationcode"]; } else { $refundlocationode = ""; }
?>
	var refundbillnumber;
	var refundbillnumber = "<?php echo $refundbillnumbers; ?>";
	var refundpatientcodes;
	var refundpatientcodes = "<?php echo $refundpatientcode; ?>";
	var refundvisitcodes;
	var refundvisitcodes = "<?php echo $refundvisitcode; ?>";
	var refloccode;
	var refloccode = "<?php echo $refundlocationode; ?>";
	//alert(refundbillnumber);
	if(refundbillnumber != "") 
	{
		window.open("print_paynow_refund.php?billnumber="+refundbillnumber+"&&patientcode="+refundpatientcodes+"&&visitcode="+refundvisitcodes+"&&locationcode="+refloccode,"OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}	
</script>
<script>
<?php 
if (isset($_REQUEST["otcbillnumber"])) { $otcbillnumbers = $_REQUEST["otcbillnumber"]; } else { $otcbillnumbers = ""; }
?>
	var otcbillnumberr;
	var otcbillnumberr = "<?php echo $otcbillnumbers; ?>";
	//alert(refundbillnumber);
	if(otcbillnumberr != "") 
	{
		window.open("print_otcbilling_dmp4inch1.php?billnumber="+otcbillnumberr,"OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}	
</script>
<script>
<?php 
if (isset($_REQUEST["paynowpatientcode"])) { $paynowpatientcoder = $_REQUEST["paynowpatientcode"]; } else { $paynowpatientcoder = ""; }
if (isset($_REQUEST["paynowbillnumber"])) { $paynowbillnumbers = $_REQUEST["paynowbillnumber"]; } else { $paynowbillnumbers = ""; }
if (isset($_REQUEST["paynowpatientcode1"])) { $paynowpatientcoder1 = $_REQUEST["paynowpatientcode1"]; } else { $paynowpatientcoder1 = ""; }
if (isset($_REQUEST["patientcode"])) { $paynowpatientcoder2 = $_REQUEST["patientcode"]; } else { $paynowpatientcoder2 = ""; }
?>
	var paynowpatientcoderr;
	var paynowpatientcoderr = "<?php echo $paynowpatientcoder; ?>";
	
	
	
	var paynowbillnumberr;
	var paynowbillnumberr = "<?php echo $paynowbillnumbers; ?>";
	//copay
	var paynowpatientcoderr1;
	var paynowpatientcoderr1 = "<?php echo $paynowpatientcoder1; ?>";
	var paynowpatientcoderr2 = "<?php echo $paynowpatientcoder2; ?>";
	//alert(refundbillnumber);
	if(paynowpatientcoderr1 != "") 
	{
		window.open("print_billpaynowbill_dmp4inch_copay.php?billautonumber="+paynowbillnumberr+"&&patientcode="+paynowpatientcoderr1+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}	
	else if(paynowpatientcoderr != "") 
	{
		window.open("print_billpaynowbill_dmp4inch1.php?billautonumber="+paynowbillnumberr+"&&patientcode="+paynowpatientcoderr+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}	
	
</script>
<script>	
<?php 
if (isset($_REQUEST["consbillautonumber"])) { $consbillautonumbers = $_REQUEST["consbillautonumber"]; } else { $paynowpatientcoder = ""; }
?>
	var consbillautonumberr;
	var consbillautonumberr = "<?php echo $consbillautonumbers; ?>";
	//alert(refundbillnumber);
	if(consbillautonumberr != "") 
	{
		window.open("print_consultationbill_dmp4inch1.php?billautonumber="+consbillautonumberr+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}				
</script>
<script>	
<?php 
if (isset($_REQUEST["ipbillnumber"])) { $ipbillnumbers = $_REQUEST["ipbillnumber"]; } else { $ipbillnumbers = ""; }
if (isset($_REQUEST["ippatientcode"])) { $ippatientcodes = $_REQUEST["ippatientcode"]; } else { $ipbillnumbers = ""; }
?>
	var ipbillnumberr;
	var ipbillnumberr = "<?php echo $ipbillnumbers; ?>";
	var ippatientcoder;
	var ippatientcoder = "<?php echo $ippatientcodes; ?>";
	//alert(refundbillnumber);
	if(ipbillnumberr != "") 
	{
		window.open("print_depositcollection_dmp4inch1.php?billnumbercode="+ipbillnumberr+"&&patientcode="+ippatientcoder+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
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
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
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
        <td width="800" rowspan="9"><form name="cbform1" method="post" action="patientbillingstatus_bills.php">
          <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
		  <!--<tr bgcolor="red">
              <td colspan="4" bgcolor="red" class="bodytext3"><strong> PLEASE REFRESH PAGE BEFORE MAKING BILL </strong></td>
              </tr>-->
            <tr bgcolor="#011E6A">
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong> Search Patient to Bill </strong></td>
              <td colspan="1" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
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
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
               <select name="location" id="location" onChange="ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
                  <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
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
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patient" type="text" id="patient" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Registration No</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patientcode" type="text" id="patient" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="visitcode" type="text" id="visitcode" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			  <tr>
          <td width="136" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="131" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="76" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="425" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
        <td width="481" class="bodytext3" style="font-size: 14px">&nbsp;</td>
      </tr>
      <!--<tr>
        <td class="bodytext3" style="font-size: 14px"><span class="bodytext32" style="font-size: 14px"><strong><a href="externalbilling.php" target="_blank" style="text-decoration:none;">Self Requests (Lab, Rad, Procedures) </a></strong></span></td>
      </tr>-->
     <!-- <tr>
        <td class="bodytext3" style="font-size: 14px"><span class="bodytext32" style="font-size: 14px"><strong><a href="billing_pending_op2.php" target="_blank" style="text-decoration:none;">Credit Patient Billing</a></strong></span></td>
      </tr>-->
      <tr>
         <td class="bodytext3" style="font-size: 14px"><span class="bodytext32" style="font-size: 14px"><strong></strong></span></td>
      </tr>
      <tr>
        <td><span class="bodytext32" style="font-size: 14px"><strong></strong></span></td>
      </tr>
      <tr>
         <td><span class="bodytext32" style="font-size: 14px"><strong></strong></span></td>
      </tr>
     <!-- <tr>
        <td><span class="bodytext32" style="font-size: 14px"><strong><a href="consultationrefundlist.php" target="_blank" style="text-decoration:none;">Consultation Refund </a></strong></span></td>
      </tr> -->
      <tr>
     <td><span class="bodytext32" style="font-size: 14px"><strong></strong></span></td>
      </tr>
      <!--<tr>
        <td><span class="bodytext32" style="font-size: 14px"><strong><a href="refundreferrallist.php" target="_blank" style="text-decoration:none;">Referral Refund Request </a></strong></span></td>
      </tr>-->
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
	  <tr>
        <td colspan="2">
	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchpatient = $_REQUEST['patient'];
	$searchpatientcode=$_REQUEST['patientcode'];
	$searchvisitcode = $_REQUEST['visitcode'];
	$fromdate=$_REQUEST['ADate1'];
	$todate=$_REQUEST['ADate2'];



	//echo $searchpatient;
		//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];


	
?>
<form name="form1" id="form1" method="post" action="patientbillingstatus_bills.php">	
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 
            align="left" border="0">
          <tbody>
             
           <tr>
                <td width="44"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
                               <td width="96" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Reg Code</strong></td>
				  <td width="100" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Visit Code</strong></td>
					  <td width="93" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>OP Date</strong></td>
			
			        <td width="208"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name </strong></div></td>
               <td width="75" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Type</strong></div></td>
                           <td width="225"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Name</strong></div></td>
                 <td width="103" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Awaiting</strong></td>
                 </tr>
			  <?php 
						//location code get
						$locationcode= isset($_REQUEST['location'])?$_REQUEST['location']:'';	  
           $query1 = "select * from master_visitentry where patientfullname like '%$searchpatient%' and locationcode='$locationcode' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and  paymentstatus = '' and consultationdate between '$fromdate' and '$todate'  order by auto_number desc";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['visitcode'];
			$patientfullname = $res1['patientfullname'];
			$accountname=$res1['accountname'];
				$patientaccountname=$res1['accountfullname'];
			$consultationdate = $res1['consultationdate'];
			  //$res2contactperson1 = $res2['contactperson1'];
			  $paymenttypeanum = $res1['paymenttype'];
			  
			  $query3 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $res3paymenttype = $res3['paymenttype'];
			  
			  
						  
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
                       <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
                </div></td>
				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $visitcode; ?></span></div>
                </div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
                </div></td>
           
                   <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $patientfullname; ?></div></td>
           
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>
                               <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $patientaccountname; ?></div></td>
                  <td  align="left" valign="center" class="bodytext31">
				  <div align="left"><a href="consultationbillingfx.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>"><strong>Consultation Bill</strong></a></div></td>
                    </tr>
			  <?php
			  
			  }
			  //}
			  ?>
			  <?php
			  $paynowvisitcode=array();
			  $query31=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_visitentry where doctorconsultation='completed' and billtype='PAY NOW' and overallpayment='' and patientfullname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and consultationdate between '$fromdate' and '$todate' and locationcode='$locationcode' order by consultationdate desc") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($exec31=mysqli_fetch_array($query31))
			{
			 $patientcode = $exec31['patientcode'];
			$query39=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res39=mysqli_fetch_array($query39);
		    $accname=$res39['accountname'];
			
			$query40=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$accname'");
			$res40=mysqli_fetch_array($query40);
			$accountname=$res40['accountname'];
			$patientvisitcode=$exec31['visitcode'];
			$patientname=$exec31['patientfullname'];
			$consultationdate=$exec31['consultationdate'];
			
			$paymenttypeanum = $exec31['paymenttype'];
			  
			  $query3 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $res3paymenttype = $res3['paymenttype'];
			  
			  $query61 = "select * from master_consultation where patientvisitcode='$patientvisitcode' and request = '' order by auto_number desc limit 0, 1";
			  $exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  $num61 = mysqli_num_rows($exec61);
			  $res61 = mysqli_fetch_array($exec61);
			  $req = $res61['request'];
			$querymch1 = "select * from consultation_lab where paymentstatus='pending' and labsamplecoll='pending' and billtype='PAY NOW' and freestatus<>'Yes' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch1) or die ("Error in Querymch1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numsmch1 = mysqli_num_rows($execmch1);			 
			$querymch2 = "select * from master_consultationpharm where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' and consultation_id NOT LIKE 'EB-%' group by patientvisitcode order by recorddate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch2 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch2) or die ("Error in Querymch2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numsmch2 = mysqli_num_rows($execmch2);	
			$querymch3 = "select * from consultation_radiology where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch3 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch3) or die ("Error in Querymch3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numsmch3 = mysqli_num_rows($execmch3); 
			$querymch4 = "select * from consultation_services where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch4 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch4) or die ("Error in Querymch4".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $numsmch4 = mysqli_num_rows($execmch4);	
			$querymch5 = "select * from consultation_departmentreferal where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch5 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch5) or die ("Error in Querymch4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numsmch5 = mysqli_num_rows($execmch5);	
			$querymch6 = "select * from consultation_referal where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch6 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch6) or die ("Error in Querymch4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numsmch6 = mysqli_num_rows($execmch6);	

			$numsrows = $numsmch1 + $numsmch2 + $numsmch3 + $numsmch4 + $numsmch5 + $numsmch6;
			if($numsrows!=0)
			{
				if($num61 > 0)
				{
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
				$paynowvisitcode[]=$patientvisitcode;
				  ?>
					<tr <?php echo $colorcode; ?>>
					<td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
						   <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
					</div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"><span class="bodytext32"><?php echo $patientvisitcode; ?></span></div>
					</div></td>
						  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
					</div></td>
			   
					   <td class="bodytext31" valign="center"  align="left">
					  <div align="left"><?php echo $patientname; ?></div></td>
			   
					<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
					</div></td>
								   <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $accountname; ?></div></td>
								  
					  <td  align="left" valign="center" class="bodytext31">
					  <div align="left"><a href="billing_paynow.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>&&menuid=<?php echo $menu_id; ?>"><strong>Pay-Now Bill</strong></a></div></td>
						</tr>
				  <?php
				  }
			  }
			  }
			  ?>
              
              
              
              
              <!--this is for copay for all-->
              
               <?php
			  $query31=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_visitentry where doctorconsultation='completed' and billtype='PAY LATER' and overallpayment='' and patientfullname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and consultationdate between '$fromdate' and '$todate' and locationcode='$locationcode' and planpercentage <> '0.00' order by consultationdate desc") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($exec31=mysqli_fetch_array($query31))
			{
			$patientcode = $exec31['patientcode'];
			$planpercent = $exec31['planpercentage'];
			$query39=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res39=mysqli_fetch_array($query39);
		    $accname=$res39['accountname'];
			$plannumber = $res39['planname'];
			
			$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resplanname = mysqli_fetch_array($execplanname);
		 	$planforall = $resplanname['forall'];
			
			if($planforall=='yes' && $planpercent>0.00)
			{
			$query40=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$accname'");
			$res40=mysqli_fetch_array($query40);
			$accountname=$res40['accountname'];
			$patientvisitcode=$exec31['visitcode'];
			$patientname=$exec31['patientfullname'];
			$consultationdate=$exec31['consultationdate'];
			
			 $paymenttypeanum = $exec31['paymenttype'];
			  
			  $query3 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $res3paymenttype = $res3['paymenttype'];
			  
			  $query61 = "select * from master_consultation where patientvisitcode='$patientvisitcode' and request = '' order by auto_number desc limit 0, 1";
			  $exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  $num61 = mysqli_num_rows($exec61);
			  $res61 = mysqli_fetch_array($exec61);
			  $req = $res61['request'];
			/*$querymch1 = "select * from consultation_lab where paymentstatus='completed' and copay <> 'completed' and labsamplecoll='pending' and billtype='PAY LATER' and freestatus<>'Yes' and patientvisitcode='$patientvisitcode' and approvalstatus='2' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//*/
			$querymch1 = "select * from consultation_lab where paymentstatus='pending' and copay <> 'completed' and labsamplecoll='pending' and billtype='PAY LATER' and freestatus<>'Yes'  and patientvisitcode='$patientvisitcode' and  approvalstatus='1' group by patientvisitcode order by consultationdate desc";
			$execmch1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch1) or die ("Error in Querymch1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numsmch1 = mysqli_num_rows($execmch1);			
			// $querymch2 = "select * from master_consultationpharm where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by recorddate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$querymch2 = "select * from master_consultationpharm where paymentstatus='pending' and billing <> 'completed' and billtype='PAY LATER' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by recorddate desc";
			$execmch2 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch2) or die ("Error in Querymch2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numsmch2 = mysqli_num_rows($execmch2);	
			//$querymch3 = "select * from consultation_radiology where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$querymch3 = "select * from consultation_radiology where paymentstatus='pending' and billtype='PAY LATER' and patientvisitcode='$patientvisitcode'  and approvalstatus='1' group by patientvisitcode order by consultationdate desc";
			$execmch3 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch3) or die ("Error in Querymch3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$apres=mysqli_fetch_array($execmch3);
			$numsmch3 = mysqli_num_rows($execmch3); 
			//$statusap=$apres['approvalstatus'];
			
			$querymch4 = "select * from consultation_services where paymentstatus='pending'  and billtype='PAY LATER' and patientvisitcode='$patientvisitcode' and approvalstatus='1' group by patientvisitcode order by consultationdate desc";
			$execmch4 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch4) or die ("Error in Querymch4".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $numsmch4 = mysqli_num_rows($execmch4);
			 
			 $querymch5 = "select * from consultation_departmentreferal where paymentstatus='pending' and billtype='PAY LATER' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";
			 $execmch5 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch5) or die ("Error in Querymch4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numsmch5 = mysqli_num_rows($execmch5);
				
			$querymch6 = "select * from consultation_referal where paymentstatus='pending' and billtype='PAY LATER' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch6 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch6) or die ("Error in Querymch4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numsmch6 = mysqli_num_rows($execmch6);
			
			
			/*$querymch4 = "select * from consultation_services where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//*/
			$querymch4 = "select * from consultation_services where paymentstatus='pending' and billtype='PAY LATER' and patientvisitcode='$patientvisitcode' and approvalstatus='1' group by patientvisitcode order by consultationdate desc";
			$execmch4 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch4) or die ("Error in Querymch4".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $numsmch4 = mysqli_num_rows($execmch4);	
			/*$querymch5 = "select * from consultation_departmentreferal where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch5 = mysql_query($querymch5) or die ("Error in Querymch4".mysql_error());
			$numsmch5 = mysql_num_rows($execmch5);	
			$querymch6 = "select * from consultation_referal where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch6 = mysql_query($querymch6) or die ("Error in Querymch4".mysql_error());
			$numsmch6 = mysql_num_rows($execmch6);	*/
			
				
		$querymch7 = "select * from op_ambulance where paymentstatus='pending' and billtype='PAY LATER' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch7 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch7) or die ("Error in Querymch7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numsmch7 = mysqli_num_rows($execmch7);	
			
			$querymch8 = "select * from homecare where paymentstatus='pending' and billtype='PAY LATER' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch8 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch8) or die ("Error in Querymch8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numsmch8 = mysqli_num_rows($execmch8); 
			
			 $numsrows = $numsmch1 + $numsmch2 + $numsmch3 + $numsmch4 + $numsmch5 + $numsmch6 + $numsmch7 + $numsmch8;
			if($numsrows!=0)
			{
				if($num61 > 0)
				{
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
					<td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
						   <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
					</div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"><span class="bodytext32"><?php echo $patientvisitcode; ?></span></div>
					</div></td>
						  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
					</div></td>
			   
					   <td class="bodytext31" valign="center"  align="left">
					  <div align="left"><?php echo $patientname; ?></div></td>
			   
					<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
					</div></td>
								   <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $accountname; ?></div></td>
								  
					  <td  align="left" valign="center" class="bodytext31">
					  <div align="left"><a href="billing_paynow-copay.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>&&menuid=<?php echo $menu_id; ?>"><strong>Pay-Now Bill </strong></a></div></td>
						</tr>
				  <?php
				  }
			  }
			  }}
			  ?>
              
               <!--this is for copay for all-->
              
               <?php
			  $query31=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_visitentry where doctorconsultation='completed' and billtype='PAY LATER' and overallpayment='' and patientfullname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and consultationdate between '$fromdate' and '$todate' and locationcode='$locationcode' and planpercentage <> '0.00' order by consultationdate desc") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($exec31=mysqli_fetch_array($query31))
			{
			$patientcode = $exec31['patientcode'];
			$planpercent = $exec31['planpercentage'];
			$query39=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res39=mysqli_fetch_array($query39);
		    $accname=$res39['accountname'];
			$plannumber = $res39['planname'];
			
			$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resplanname = mysqli_fetch_array($execplanname);
		 	$planforall = $resplanname['forall'];
			
			if($planforall=='yes' && $planpercent>0.00)
			{
			$query40=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$accname'");
			$res40=mysqli_fetch_array($query40);
			$accountname=$res40['accountname'];
			$patientvisitcode=$exec31['visitcode'];
			$patientname=$exec31['patientfullname'];
			$consultationdate=$exec31['consultationdate'];
			
			 $paymenttypeanum = $exec31['paymenttype'];
			  
			  $query3 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $res3paymenttype = $res3['paymenttype'];
			  
			  $query61 = "select * from master_consultation where patientvisitcode='$patientvisitcode' and request = '' order by auto_number desc limit 0, 1";
			  $exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  $num61 = mysqli_num_rows($exec61);
			  $res61 = mysqli_fetch_array($exec61);
			  $req = $res61['request'];
			/*$querymch1 = "select * from consultation_lab where paymentstatus='completed' and copay <> 'completed' and labsamplecoll='pending' and billtype='PAY LATER' and freestatus<>'Yes' and patientvisitcode='$patientvisitcode' and approvalstatus='2' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//*/
			$querymch1 = "select * from consultation_lab where paymentstatus='pending' and copay <> 'completed' and labsamplecoll='pending' and billtype='PAY LATER' and freestatus<>'Yes'  and patientvisitcode='$patientvisitcode' and approvalstatus='2' group by patientvisitcode order by consultationdate desc";
			$execmch1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch1) or die ("Error in Querymch1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numsmch1 = mysqli_num_rows($execmch1);			
			 $querymch2 = "select * from master_consultationpharm where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by recorddate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			 
			$querymch2 = "select * from master_consultationpharm where paymentstatus='pending' and approvalstatus='2' and billtype='PAY LATER' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by recorddate desc";
			$execmch2 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch2) or die ("Error in Querymch2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numsmch2 = mysqli_num_rows($execmch2);	
			$querymch3 = "select * from consultation_radiology where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$querymch3 = "select * from consultation_radiology where paymentstatus='pending' and approvalstatus='2' and billtype='PAY LATER' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";
			$execmch3 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch3) or die ("Error in Querymch3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$apres=mysqli_fetch_array($execmch3);
			$numsmch3 = mysqli_num_rows($execmch3); 
			//$statusap=$apres['approvalstatus'];
			
			$querymch4 = "select * from consultation_services where paymentstatus='pending'  and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";
			$execmch4 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch4) or die ("Error in Querymch4".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $numsmch4 = mysqli_num_rows($execmch4);
			 
			 $querymch5 = "select * from consultation_departmentreferal where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";
			 $execmch5 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch5) or die ("Error in Querymch4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numsmch5 = mysqli_num_rows($execmch5);
				
			$querymch6 = "select * from consultation_referal where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch6 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch6) or die ("Error in Querymch4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numsmch6 = mysqli_num_rows($execmch6);
			
			
			
			
			/*$querymch4 = "select * from consultation_services where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//*/
			$querymch4 = "select * from consultation_services where paymentstatus='pending' and approvalstatus='2' and billtype='PAY LATER' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";
			$execmch4 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch4) or die ("Error in Querymch4".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $numsmch4 = mysqli_num_rows($execmch4);	
			/*$querymch5 = "select * from consultation_departmentreferal where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch5 = mysql_query($querymch5) or die ("Error in Querymch4".mysql_error());
			$numsmch5 = mysql_num_rows($execmch5);	
			$querymch6 = "select * from consultation_referal where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch6 = mysql_query($querymch6) or die ("Error in Querymch4".mysql_error());
			$numsmch6 = mysql_num_rows($execmch6);	*/
			
				
		$querymch7 = "select * from op_ambulance where paymentstatus='pending' and billtype='PAY LATER' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch7 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch7) or die ("Error in Querymch7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numsmch7 = mysqli_num_rows($execmch7);	
			
			$querymch8 = "select * from homecare where paymentstatus='pending' and billtype='PAY LATER' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch8 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch8) or die ("Error in Querymch8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numsmch8 = mysqli_num_rows($execmch8); 
			
			 $numsrows = $numsmch1 + $numsmch2 + $numsmch3 + $numsmch4 + $numsmch5 + $numsmch6 + $numsmch7 + $numsmch8;
			if($numsrows!=0)
			{
				if($num61 > 0)
				{
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
					<td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
						   <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
					</div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"><span class="bodytext32"><?php echo $patientvisitcode; ?></span></div>
					</div></td>
						  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
					</div></td>
			   
					   <td class="bodytext31" valign="center"  align="left">
					  <div align="left"><?php echo $patientname; ?></div></td>
			   
					<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
					</div></td>
								   <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $accountname; ?></div></td>
								  
					  <td  align="left" valign="center" class="bodytext31">
					  <div align="left"><a href="billing_paynow.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>&&menuid=<?php echo $menu_id; ?>"><strong>Pay-Now Bill </strong></a></div></td>
						</tr>
				  <?php
				  }
			  }
			  }}
			  ?>
              
              
              
              
              <?php /*?> <?php
			  $query31=mysql_query("select * from master_visitentry where doctorconsultation='completed' and billtype='PAY LATER' and overallpayment='' and patientfullname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and consultationdate between '$fromdate' and '$todate' and locationcode='$locationcode' and planpercentage <> '0.00' order by consultationdate desc") or die(mysql_error());
			while($exec31=mysql_fetch_array($query31))
			{
			$patientcode = $exec31['patientcode'];
			$query39=mysql_query("select * from master_customer where customercode='$patientcode'") or die(mysql_error());
			$res39=mysql_fetch_array($query39);
		    $accname=$res39['accountname'];
			$plannumber = $res39['planname'];
			
			$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysql_query($queryplanname) or die ("Error in Queryplanname".mysql_error());
			$resplanname = mysql_fetch_array($execplanname);
		 	$planforall = $resplanname['forall'];
			
			$query40=mysql_query("select * from master_accountname where auto_number='$accname'");
			$res40=mysql_fetch_array($query40);
			$accountname=$res40['accountname'];
			$patientvisitcode=$exec31['visitcode'];
			$patientname=$exec31['patientfullname'];
			$consultationdate=$exec31['consultationdate'];
			
			 $paymenttypeanum = $exec31['paymenttype'];
			  
			  $query3 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
			  $exec3 = mysql_query($query3) or die ("Error in Query5".mysql_error());
			  $res3 = mysql_fetch_array($exec3);
			  $res3paymenttype = $res3['paymenttype'];
			  
			  $query61 = "select * from master_consultation where patientvisitcode='$patientvisitcode' and request = '' order by auto_number desc limit 0, 1";
			  $exec61 = mysql_query($query61) or die(mysql_error());
			  $num61 = mysql_num_rows($exec61);
			  $res61 = mysql_fetch_array($exec61);
			  $req = $res61['request'];
			$querymch1 = "select * from consultation_lab where paymentstatus='completed' and copay <> 'completed' and labsamplecoll='pending' and billtype='PAY LATER' and freestatus<>'Yes' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$querymch1 = "select * from consultation_lab where paymentstatus='pending' and copay <> 'completed' and labsamplecoll='pending' and billtype='PAY LATER' and freestatus<>'Yes' and '".$planforall."'='' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";
			$execmch1 = mysql_query($querymch1) or die ("Error in Querymch1".mysql_error());
			$numsmch1 = mysql_num_rows($execmch1);			
			$querymch2 = "select * from master_consultationpharm where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by recorddate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch2 = mysql_query($querymch2) or die ("Error in Querymch2".mysql_error());
			$numsmch2 = mysql_num_rows($execmch2);	
			$querymch3 = "select * from consultation_radiology where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch3 = mysql_query($querymch3) or die ("Error in Querymch3".mysql_error());
			$numsmch3 = mysql_num_rows($execmch3); 
			$querymch4 = "select * from consultation_services where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch4 = mysql_query($querymch4) or die ("Error in Querymch4".mysql_error());
			 $numsmch4 = mysql_num_rows($execmch4);	
			$querymch5 = "select * from consultation_departmentreferal where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch5 = mysql_query($querymch5) or die ("Error in Querymch4".mysql_error());
			$numsmch5 = mysql_num_rows($execmch5);	
			$querymch6 = "select * from consultation_referal where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch6 = mysql_query($querymch6) or die ("Error in Querymch4".mysql_error());
			$numsmch6 = mysql_num_rows($execmch6);	

			$numsrows = $numsmch1 + $numsmch2 + $numsmch3 + $numsmch4 + $numsmch5 + $numsmch6;
			if($numsrows!=0)
			{
				if($num61 > 0)
				{
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
					<td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
						   <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
					</div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"><span class="bodytext32"><?php echo $patientvisitcode; ?></span></div>
					</div></td>
						  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
					</div></td>
			   
					   <td class="bodytext31" valign="center"  align="left">
					  <div align="left"><?php echo $patientname; ?></div></td>
			   
					<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
					</div></td>
								   <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $accountname; ?></div></td>
								  
					  <td  align="left" valign="center" class="bodytext31">
					  <div align="left"><a href="billing_paynow-copay.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>"><strong>Pay-Now Bill</strong></a></div></td>
						</tr>
				  <?php
				  }
			  }
			  }
			  ?>
              <?php */?>
              
              
              
              
			  	  <?php
			  $query311=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_visitentry where triageconsultation='completed' and doctorconsultation='' and billtype='PAY NOW' and overallpayment='' and patientfullname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and consultationdate between '$fromdate' and '$todate' and locationcode='$locationcode' order by consultationdate desc") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($exec311=mysqli_fetch_array($query311))
			{
			$patientcode = $exec311['patientcode'];
			$query391=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res391=mysqli_fetch_array($query391);
		    $accname=$res391['accountname'];
			
			$query401=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$accname'");
			$res401=mysqli_fetch_array($query401);
			$accountname=$res401['accountname'];
			$patientvisitcode=$exec311['visitcode'];
			$patientname=$exec311['patientfullname'];
			$consultationdate=$exec311['consultationdate'];
			
			$paymenttypeanum = $exec311['paymenttype'];
			$querymch1 = "select * from consultation_lab where paymentstatus='pending' and labsamplecoll='pending' and billtype='PAY NOW' and freestatus<>'Yes' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch1) or die ("Error in Querymch1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numsmch1 = mysqli_num_rows($execmch1);			
			$querymch2 = "select * from master_consultationpharm where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by recorddate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch2 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch2) or die ("Error in Querymch2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numsmch2 = mysqli_num_rows($execmch2);	
			$querymch3 = "select * from consultation_radiology where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch3 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch3) or die ("Error in Querymch3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numsmch3 = mysqli_num_rows($execmch3);	
			$querymch4 = "select * from consultation_services where paymentstatus='pending' and billtype='PAY NOW' and patientvisitcode='$patientvisitcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch4 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch4) or die ("Error in Querymch4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numsmch4 = mysqli_num_rows($execmch4);	
			$numsrows = $numsmch1 + $numsmch2 + $numsmch3 + $numsmch4;
			if($numsrows != 0)
			{			  
			  $query3 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $res3paymenttype = $res3['paymenttype'];
		
			
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
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
                       <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
                </div></td>
				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientvisitcode; ?></span></div>
                </div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
                </div></td>
           
                   <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $patientname; ?></div></td>
           
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>
                               <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $accountname; ?></div></td>
							  
                  <td  align="left" valign="center" class="bodytext31">
				  <div align="left"><a href="billing_paynow.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>&&menuid=<?php echo $menu_id; ?>"><strong>Pay-Now Bill</strong></a></div></td>
                    </tr>
			  <?php
			  }
			  }
			  ?>
			  <?php
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			$query1 = "select * from master_consultationpharm where medicineissue='pending' and billtype='PAY LATER' and pharmacybill='completed' and excludestatus = 'excluded' and excludebill = '' and patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and recorddate between '$fromdate' and '$todate' and approvalstatus='1' and locationcode='$locationcode' group by patientvisitcode order by recorddate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			
			$query77 = "select * from master_customer where customercode = '$patientcode'";
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res77 = mysqli_fetch_array($exec77);
			$maintypeanum = $res77['maintype'];
			
			  $query3 = "select * from master_paymenttype where auto_number = '$maintypeanum'";
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $res3paymenttype = $res3['paymenttype'];

			//$query2 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";
			//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			//$res2 = mysql_fetch_array($exec2);
			//$consultingdoctorname  = $res2['doctorname'];
			
			$consultationdate = $res1['recorddate'];	
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
			$query39=mysqli_query($GLOBALS["___mysqli_ston"], "select planpercentage from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res39=mysqli_fetch_array($query39);
		    $planpercentage1=$res39['planpercentage'];
			if($planpercentage1==0.00)
			{ 
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
                           <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
				 <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>

              <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="billing_paynow.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>"><strong>Pay-Now Bill</strong></a></div></td>
              </tr>
			<?php
			}   
			}
			?>
			<?php
			$cashvisitcode = "'"."'";
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			$query1 = "select * from master_consultationpharm where medicineissue='pending' and billtype='PAY LATER' and pharmacybill='pending' and patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and recorddate between '$fromdate' and '$todate' and approvalstatus='2' and locationcode='$locationcode' group by patientvisitcode order by recorddate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			if($cashvisitcode=='')
			{
			$cashvisitcode = "'".$visitcode."'";
			}
			else
			{
			$cashvisitcode = $cashvisitcode.",'".$visitcode."'";
			}
			$query77 = "select * from master_customer where customercode = '$patientcode'";
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res77 = mysqli_fetch_array($exec77);
			$maintypeanum = $res77['maintype'];
			
			  $query3 = "select * from master_paymenttype where auto_number = '$maintypeanum'";
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $res3paymenttype = $res3['paymenttype'];

			//$query2 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";
			//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			//$res2 = mysql_fetch_array($exec2);
			//$consultingdoctorname  = $res2['doctorname'];
			
			$consultationdate = $res1['recorddate'];	
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
			$query39=mysqli_query($GLOBALS["___mysqli_ston"], "select planpercentage from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res39=mysqli_fetch_array($query39);
		    $planpercentage1=$res39['planpercentage'];
			if($planpercentage1==0.00)
			{ 
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
                           <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
				 <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>

              <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="billing_paynow.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>"><strong>Pay-Now Bill</strong></a></div></td>
              </tr>
			<?php
			} 
			}
			?>
			<?php
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";			
			$query1 = "select * from consultation_lab where consultationid not like 'EB-%' and billtype='PAY LATER' and paymentstatus='pending' and patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and consultationdate between '$fromdate' and '$todate' and approvalstatus='2' and patientvisitcode not in($cashvisitcode) and locationcode='$locationcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			$sql15 = "select auto_number from master_transactionpaylater where  patientcode = '".$patientcode."' and visitcode = '".$visitcode."' and transactiontype like 'finalize'";
			$result5 = mysqli_query($GLOBALS["___mysqli_ston"], $sql15);
			$row5 = mysqli_num_rows($result5);
			if($row5==0)
			{
			if($cashvisitcode=='')
			{
			$cashvisitcode = "'".$visitcode."'";
			}
			else
			{
			$cashvisitcode = $cashvisitcode.",'".$visitcode."'";
			}
			$query77 = "select * from master_customer where customercode = '$patientcode'";
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res77 = mysqli_fetch_array($exec77);
			$maintypeanum = $res77['maintype'];
			
			  $query3 = "select * from master_paymenttype where auto_number = '$maintypeanum'";
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $res3paymenttype = $res3['paymenttype'];

			//$query2 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";
			//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			//$res2 = mysql_fetch_array($exec2);
			//$consultingdoctorname  = $res2['doctorname'];
			
			$consultationdate = $res1['consultationdate'];	
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
			
			$query39=mysqli_query($GLOBALS["___mysqli_ston"], "select planpercentage from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res39=mysqli_fetch_array($query39);
		    $planpercentage1=$res39['planpercentage'];
			if($planpercentage1==0.00)
			{ 
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
                           <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>


              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
				 <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>

              <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="billing_paynow.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>"><strong>Pay-Now Bill</strong></a></div></td>
              </tr>
			<?php
			}
			}
			}
			?>
			<?php
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";			
			$query1 = "select * from consultation_radiology where billtype='PAY LATER' and paymentstatus='pending' and patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and consultationdate between '$fromdate' and '$todate' and approvalstatus='2' and patientvisitcode not in($cashvisitcode) and locationcode='$locationcode' and consultationid not like 'EB-%' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];

			$sql15 = "select auto_number from master_transactionpaylater where  patientcode = '".$patientcode."' and visitcode = '".$visitcode."' and transactiontype like 'finalize'";
			$result5 = mysqli_query($GLOBALS["___mysqli_ston"], $sql15);
			$row5 = mysqli_num_rows($result5);
			if($row5==0)
			{

			if($cashvisitcode=='')
			{
			$cashvisitcode = "'".$visitcode."'";
			}
			else
			{
			$cashvisitcode = $cashvisitcode.",'".$visitcode."'";
			}
			$query77 = "select * from master_customer where customercode = '$patientcode'";
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res77 = mysqli_fetch_array($exec77);
			$maintypeanum = $res77['maintype'];
			
			  $query3 = "select * from master_paymenttype where auto_number = '$maintypeanum'";
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $res3paymenttype = $res3['paymenttype'];

			//$query2 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";
			//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			//$res2 = mysql_fetch_array($exec2);
			//$consultingdoctorname  = $res2['doctorname'];
			
			$consultationdate = $res1['consultationdate'];	
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
			$query39=mysqli_query($GLOBALS["___mysqli_ston"], "select planpercentage from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res39=mysqli_fetch_array($query39);
		    $planpercentage1=$res39['planpercentage'];
			if($planpercentage1==0.00)
			{ 
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
                           <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
				 <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>

              <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="billing_paynow.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>"><strong>Pay-Now Bill</strong></a></div></td>
              </tr>
			<?php
			}   
			}
			}
			?>
			<?php
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";			
			$query1 = "select * from consultation_services where process='pending' and billtype='PAY LATER' and paymentstatus='pending' and patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and consultationdate between '$fromdate' and '$todate' and approvalstatus='2' and patientvisitcode not in($cashvisitcode) and locationcode='$locationcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			

			$sql15 = "select auto_number from master_transactionpaylater where  patientcode = '".$patientcode."' and visitcode = '".$visitcode."' and transactiontype like 'finalize'";
			$result5 = mysqli_query($GLOBALS["___mysqli_ston"], $sql15);
			$row5 = mysqli_num_rows($result5);
			if($row5==0)
			{


				if($cashvisitcode=='')
				{
				$cashvisitcode = "'".$visitcode."'";
				}
				else
				{
				$cashvisitcode = $cashvisitcode.",'".$visitcode."'";
				}


			$query77 = "select * from master_customer where customercode = '$patientcode'";
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res77 = mysqli_fetch_array($exec77);
			$maintypeanum = $res77['maintype'];
			
			  $query3 = "select * from master_paymenttype where auto_number = '$maintypeanum'";
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $res3paymenttype = $res3['paymenttype'];

			//$query2 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";
			//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			//$res2 = mysql_fetch_array($exec2);
			//$consultingdoctorname  = $res2['doctorname'];
			
			$consultationdate = $res1['consultationdate'];	
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
			$query39=mysqli_query($GLOBALS["___mysqli_ston"], "select planpercentage from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res39=mysqli_fetch_array($query39);
		    $planpercentage1=$res39['planpercentage'];
			if($planpercentage1==0.00)
			{ 
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
                           <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
				 <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>

              <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="billing_paynow.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>"><strong>Pay-Now Bill</strong></a></div></td>
              </tr>
			<?php
			}  
			}
			}
			?>
            
            
            
            
            
            
            <?php
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";			
			$query1 = "select * from op_ambulance where billtype='PAY NOW' and paymentstatus='pending' and patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and consultationdate between '$fromdate' and '$todate' and patientvisitcode not in($cashvisitcode) and locationcode='$locationcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			if($cashvisitcode=='')
			{
			$cashvisitcode = "'".$visitcode."'";
			}
			else
			{
			$cashvisitcode = $cashvisitcode.",'".$visitcode."'";
			}
			$query77 = "select * from master_customer where customercode = '$patientcode'";
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res77 = mysqli_fetch_array($exec77);
			$maintypeanum = $res77['maintype'];
			
			  $query3 = "select * from master_paymenttype where auto_number = '$maintypeanum'";
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $res3paymenttype = $res3['paymenttype'];

			//$query2 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";
			//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			//$res2 = mysql_fetch_array($exec2);
			//$consultingdoctorname  = $res2['doctorname'];
			
			$consultationdate = $res1['consultationdate'];	
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
			$query39=mysqli_query($GLOBALS["___mysqli_ston"], "select planpercentage from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res39=mysqli_fetch_array($query39);
		    $planpercentage1=$res39['planpercentage'];
			if($planpercentage1==0.00)
			{ 
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
                           <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
				 <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>

              <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="billing_paynow.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>"><strong>Pay-Now Bill</strong></a></div></td>
              </tr>
			<?php
			}  
			}
			?>
             <?php
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";			
			$query1 = "select * from homecare where billtype='PAY NOW' and paymentstatus='pending' and patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and consultationdate between '$fromdate' and '$todate' and patientvisitcode not in($cashvisitcode) and locationcode='$locationcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			if($cashvisitcode=='')
			{
			$cashvisitcode = "'".$visitcode."'";
			}
			else
			{
			$cashvisitcode = $cashvisitcode.",'".$visitcode."'";
			}
			$query77 = "select * from master_customer where customercode = '$patientcode'";
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res77 = mysqli_fetch_array($exec77);
			$maintypeanum = $res77['maintype'];
			
			  $query3 = "select * from master_paymenttype where auto_number = '$maintypeanum'";
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $res3paymenttype = $res3['paymenttype'];

			//$query2 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";
			//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			//$res2 = mysql_fetch_array($exec2);
			//$consultingdoctorname  = $res2['doctorname'];
			
			$consultationdate = $res1['consultationdate'];	
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
			$query39=mysqli_query($GLOBALS["___mysqli_ston"], "select planpercentage from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res39=mysqli_fetch_array($query39);
		    $planpercentage1=$res39['planpercentage'];
			if($planpercentage1==0.00)
			{ 
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
                           <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
				 <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>

              <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="billing_paynow.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>"><strong>Pay-Now Bill</strong></a></div></td>
              </tr>
			<?php
			} 
			}
			?>
             <?php 
		//location code get
		   $locationcode= isset($_REQUEST['location'])?$_REQUEST['location']:'';
		 	$query1 = "select patientcode,patientvisitcode,patientname,consultationdate,accountname from (select patientcode,patientvisitcode,patientname,consultationdate,accountname from consultation_lab where patientname like '%$searchpatient%' and locationcode='$locationcode' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%'  and paymentstatus <> 'completed' and  patientvisitcode <> 'walkinvis' and consultationid like 'EB-%' and labitemrate <> '' and consultationdate between '$fromdate' and '$todate' 
		   union  select patientcode,patientvisitcode,patientname,consultationdate,accountname from consultation_radiology where patientname like '%$searchpatient%' and locationcode='$locationcode' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%'  and paymentstatus <> 'completed' and  patientvisitcode <> 'walkinvis' and consultationid like 'EB-%' and radiologyitemrate <> '' and consultationdate between '$fromdate' and '$todate' 
		   union select patientcode,patientvisitcode,patientname,consultationdate,accountname from consultation_services where patientname like '%$searchpatient%' and locationcode='$locationcode' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%'  and paymentstatus <> 'completed' and  patientvisitcode <> 'walkinvis' and consultationid like 'EB-%' and amount <> '' and consultationdate between '$fromdate' and '$todate'
		   union select patientcode,patientvisitcode,patientname,recorddate as consultationdate,accountname from master_consultationpharm where patientname like '%$searchpatient%' and locationcode='$locationcode' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%'  and paymentstatus <> 'completed' and billing <> 'completed' and  patientvisitcode <> 'walkinvis' and consultation_id like 'EB-%' and amount <> '' and amendstatus = 2 and recorddate between '$fromdate' and '$todate') as otc_reqpay  group by patientvisitcode ";

		   //where patientvisitcode not in(select patientvisitcode from master_consultation where approval = '1'   and recorddate between '$fromdate' and '$todate' and locationcode='$locationcode' GROUP BY patientvisitcode)

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			if($patientcode != '' && !in_array($visitcode, $paynowvisitcode))
			{
			$accountname=$res1['accountname'];
			$consultationdate = $res1['consultationdate'];
			  //$res2contactperson1 = $res2['contactperson1'];
			   $sql15 = "select auto_number from master_transactionpaylater where  patientcode = '".$res1['patientcode']."' and visitcode = '".$res1['patientvisitcode']."' and transactiontype like 'finalize'";
			$result5 = mysqli_query($GLOBALS["___mysqli_ston"], $sql15);
			$row5 = mysqli_num_rows($result5);
			if($row5==0)
			{
			  $qrypaytyp="select paymenttype from master_paymenttype where auto_number in (select paymenttype from master_visitentry where visitcode='$visitcode')";
			  $exepaytyp= mysqli_query($GLOBALS["___mysqli_ston"], $qrypaytyp) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			 if( $respaytyp=mysqli_fetch_assoc($exepaytyp))
			 {
			 $res3paymenttype = $respaytyp['paymenttype'];
			 }
			 /* $qryact="select accountname from master_accountname where auto_number in (select accountname from master_visitentry where visitcode='$visitcode')";
			  $exeact= mysql_query($qryact) or die ("Error in Query1".mysql_error());
			 if( $resact=mysql_fetch_assoc($exeact))
			 {
			$accountname=$resact['accountname'];
			 }*/
			$patientaccountname=$accountname;
			  //$accountname=$res1['accountname'];
			  		
			 // $transactionamount = $res1['totalamount'];		
			  
			/*  $queryamountsum=mysql_query("select sum(transactionamount) as total from bank_refrencenumber where visitcode='$visitcode' and patientcode='$patientcode' and  payment_status='0'") or die(mysql_error()); 
			  $execamountsum=mysql_fetch_array($queryamountsum);
			  	$transactionamount=$execamountsum['total'];
				  
			  $bankrefno = $res1['bankrefno'];	*/	
			  $query39=mysqli_query($GLOBALS["___mysqli_ston"], "select planpercentage from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res39=mysqli_fetch_array($query39);
		    $planpercentage1=$res39['planpercentage'];
			  
			  // $enteredfrom = trim($res1['enteredfrom']);
			//if($res3paymenttype=='CASH')
			//{
						   $enteredfrom='billing_paynow';
			//}
			if ($planpercentage1>0)
			{
				$enteredfrom='billing_paynow-copay';
			}
			 // $res3paymenttype = $paymenttypeanum;
			  
			 
						  
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
				if(isset($enteredfrom))
				{
			  ?>
              <tr <?php echo $colorcode; ?>>
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
 	<!--			  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32" style="font-size:14px;font-weight:bold">
					
					
                    </span></div>
                </div></td> -->
                      <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
                </div></td>
				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $visitcode; ?></span></div>
                </div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
                </div></td>
           
                   <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $patientfullname; ?></div></td>
           
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>
                               <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $patientaccountname; ?></div></td>
                              <!-- <td  align="right" valign="center" class="bodytext31"><div align="right"> <?php echo $transactionamount; ?></div></td>
                 -->
                 
                 
                  <td  align="center" valign="center" class="bodytext31">
				  <div align="left">
                  
                  <a href="<?= $enteredfrom ?>.php?patientcode=<?= $patientcode; ?>&&visitcode=<?= $visitcode; ?>&&menuid=<?php echo $menu_id; ?>"><strong>Pay-Now Bill</strong></a>
                                  
                  </div></td>
                 
                 
                 
                    </tr>
			  <?php
			  }
			  }
			}
			  }
			  ?>
            
            
            
            
            
            

			  <?php
			$query21="select * from master_visitentry where itemrefund='refund' and billtype='PAY NOW' and overallpayment='completed' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientfullname like '%$searchpatient%' and consultationdate between '$fromdate' and '$todate' and locationcode='$locationcode' order by consultationdate desc";
			$res21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($exec21=mysqli_fetch_array($res21))
			{
			$patientcode = $exec21['patientcode'];
			$query39=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res39=mysqli_fetch_array($query39);
		    $accname=$res39['accountname'];
			
			$query40=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$accname'");
			$res40=mysqli_fetch_array($query40);
			$accountname=$res40['accountname'];
			$patientvisitcode=$exec21['visitcode'];
			$patientname=$exec21['patientfullname'];
			$query34=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_consultation where patientvisitcode='$patientvisitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$exec34=mysqli_fetch_array($query34);
			$accname=$exec34['accountname'];
			$consultationdate=$exec21['consultationdate'];
			
			$paymenttypeanum = $exec21['paymenttype'];
			  
			  $query3 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $res3paymenttype = $res3['paymenttype'];
			//$colorloopcount = $colorloopcount + 1;
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
			$query39=mysqli_query($GLOBALS["___mysqli_ston"], "select planpercentage from master_visitentry where patientcode='$patientcode' and visitcode='$patientvisitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res39=mysqli_fetch_array($query39);
		    $planpercentage1=$res39['planpercentage'];
			if($planpercentage1==0.00)
			{ 
			?>
			 <!-- by vasu on 09 Sep 2016 -->
			  <!--<tr <?php echo $colorcode; ?>>
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
                       <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
                </div></td>
				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientvisitcode; ?></span></div>
                </div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
                </div></td>
           
                   <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $patientname; ?></div></td>
           
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>
                <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $accountname; ?></div></td>
							  
                     
                    <td class="bodytext31" valign="center"  align="left">
					<a href="refund_paynow.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>"><strong>Refund</strong></a>	</td>
                    </tr>-->
			  <?php
			  }
			  }
			  ?>
			  <?php
			  $query41 = "select * from master_consultationpharm where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and medicineissue='pending' and pharmacybill='pending' and billnumber <> '' and recorddate between '$fromdate' and '$todate' and locationcode='$locationcode' group by billnumber order by recorddate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res41 = mysqli_fetch_array($exec41))
			{
			$patientfullname = $res41['patientname'];
			$billnumber=$res41['billnumber'];
		
			
			//$query2 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";
			//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			//$res2 = mysql_fetch_array($exec2);
			//$consultingdoctorname  = $res2['doctorname'];
			
			$consultationdate = $res41['recorddate'];
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
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
                       <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32">DIRECT</span></div>
                </div></td>
				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32">DIRECT</span></div>
                </div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
                </div></td>
           
                   <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $patientfullname; ?></div></td>
           
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3">EXTERNAL	</span> </div>
                </div></td>
                               <td  align="left" valign="center" class="bodytext31"><div align="left"> CASH</div></td>
							  
                     
                    <td class="bodytext31" valign="center"  align="left">
					<a href="otcbilling.php?billnumber=<?php echo $billnumber; ?>&&menuid=<?php echo $menu_id; ?>"><strong>OTC Billing</strong></a>	</td>
                    </tr>
			  <?php
			  }
			  //}
			  ?>
			  <?php
			  $query41 = "select * from consultation_lab where patientname like '%$searchpatient%' and patientcode = 'walkin' and patientvisitcode = 'walkinvis' and billtype = 'PAY NOW' and paymentstatus = 'pending' and consultationdate between '$fromdate' and '$todate' and locationcode='$locationcode' group by billnumber order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res41 = mysqli_fetch_array($exec41))
			{
			$patientfullname = $res41['patientname'];
			$billnumber=$res41['billnumber'];
		
			
			//$query2 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";
			//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			//$res2 = mysql_fetch_array($exec2);
			//$consultingdoctorname  = $res2['doctorname'];
			
			$consultationdate = $res41['consultationdate'];
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
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
                       <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32">DIRECT</span></div>
                </div></td>
				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32">DIRECT</span></div>
                </div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
                </div></td>
           
                   <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $patientfullname; ?></div></td>
           
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3">EXTERNAL	</span> </div>
                </div></td>
                               <td  align="left" valign="center" class="bodytext31"><div align="left"> CASH</div></td>
							  
                     
                    <td class="bodytext31" valign="center"  align="left">
					<a href="externallabbilling.php?billnumber=<?php echo $billnumber; ?>&&menuid=<?php echo $menu_id; ?>"><strong>External Lab</strong></a>	</td>
                    </tr>
			  <?php
			  }
			  //}
			  ?>
			  <?php
			 $query123 = "select * from external_request where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and billstatus = '' and billdate between '$fromdate' and '$todate' and locationcode='$locationcode'";
			 $exec123 = mysqli_query($GLOBALS["___mysqli_ston"], $query123) or die ("Error in Query123".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while($res123 = mysqli_fetch_array($exec123))
			 {
			 $res123patientname = $res123['patientname'];
			 $res123billdate = $res123['billdate'];
			 $res123billnumber = $res123['billno'];
			 
			if($res123billnumber != '')
			{			
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
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
                       <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32">DIRECT</span></div>
                </div></td>
				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32">DIRECT</span></div>
                </div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $res123billdate; ?></span></div>
                </div></td>
           
                   <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $res123patientname; ?></div></td>
           
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3">EXTERNAL	</span> </div>
                </div></td>
                               <td  align="left" valign="center" class="bodytext31"><div align="left"> CASH</div></td>
							  
                     
                    <td class="bodytext31" valign="center"  align="left">
					<a href="externalrequestbilling.php?billnumber=<?php echo $res123billnumber; ?>&&menuid=<?php echo $menu_id; ?>"><strong>External Billing</strong></a>	</td>
                    </tr>
				<?php	
			}
			}
			?>
			  <?php
			  $query51 = "select * from master_ipvisitentry where deposit='' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientfullname like '%$searchpatient%' and billtype='PAY NOW' and consultationdate between '$fromdate' and '$todate' and locationcode='$locationcode' group by visitcode order by auto_number desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res51 = mysqli_fetch_array($exec51))
			{
			$patientcode = $res51['patientcode'];
			$visitcode = $res51['visitcode'];
			$patientfullname = $res51['patientfullname'];
			$account = $res51['accountname'];
			$consultationdate = $res51['consultationdate'];
			
			$querys = "SELECT * FROM `master_customer` where customercode = '$patientcode'";
			$execs = mysqli_query($GLOBALS["___mysqli_ston"], $querys) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$ress = mysqli_fetch_array($execs);
			$dob = $ress['dateofbirth'];
			$days = (strtotime($consultationdate) - strtotime($dob))/86400;
			$days = 2;
			if($days > 1)
			{
				$query4 = "select * from master_accountname where auto_number = '$account'";
				$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res4 = mysqli_fetch_array($exec4);
				$accountnameanum = $res4['auto_number'];
				$accountname = $res4['accountname'];
				
				
				$paymenttypeanum = $res51['paymenttype'];
				  
				  $query3 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
				  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				  $res3 = mysqli_fetch_array($exec3);
				  $res3paymenttype = $res3['paymenttype'];
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
				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $colorloopcount; ?></div></td>
				   <td class="bodytext31" valign="center"  align="left">
					<div align="left">
					  <?php echo $patientcode;?>			      </div></td>
				  <td class="bodytext31" valign="center"  align="left">
					<div align="left"><?php echo $visitcode; ?></div></td>
					 <td class="bodytext31" valign="center"  align="left">
					<div align="left"><?php echo $consultationdate; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
					<div align="left"><?php echo $patientfullname; ?></div></td>
					  <td class="bodytext31" valign="center"  align="left"><?php echo $res3paymenttype; ?></td>
				  <td class="bodytext31" valign="center"  align="left"><?php echo $accountname; ?></td>
				  <td class="bodytext31" valign="center" align="left">
					<div align="left"><a href="depositform.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menu_id; ?>&&rfkey=dr"><strong>IP Deposit</strong></a></div></td>
				  </tr>
				<?php
			} 
			}   
			?>
			<?php
			 $query21=mysqli_query($GLOBALS["___mysqli_ston"], "select * from pharmacysalesreturn_details where billstatus<>'completed' and patientcode = 'walkin' and entrydate between '$fromdate' and '$todate' and locationcode='$locationcode' order by entrydate desc") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($exec21=mysqli_fetch_array($query21))
			{
			$billno = $exec21['billnumber'];
			$visitcode = $exec21['visitcode'];
			$searchpatient1 = trim($searchpatient);
			$query39=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_consultationpharm where patientname like '%$searchpatient%' and patientvisitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res39=mysqli_fetch_array($query39);
		    $patientname=$res39['patientname'];
			$patientcode=$exec21['patientcode'];
			if($patientcode=='walkin')
			{
				$billno = $exec21['billnumber'];
				$patientvisitcode='walkinvis';
				}
			else
			{
				$billno = $exec21['docnumber'];
				$patientvisitcode=$exec21['visitcode'];
				}
			
			
			//$patientname=$exec39['patientname'];
			$query34=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_consultation where patientvisitcode='$patientvisitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$exec34=mysqli_fetch_array($query34);
			$accname=$exec34['accountname'];
			$consultationdate=$exec21['entrydate'];
			$res3paymenttype='CASH';			  
			$accountname='CASH'; 
			if($patientname!='')
			{
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
				  <!--<tr <?php echo $colorcode; ?>>
					<td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
						   <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
					</div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"><span class="bodytext32"><?php echo $patientvisitcode; ?></span></div>
					</div></td>
						  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
					</div></td>
			   
					   <td class="bodytext31" valign="center"  align="left">
					  <div align="left"><?php echo $patientname; ?></div></td>
			   
					<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
					</div></td>
								   <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $accountname; ?></div></td>
								  
						 
						<td class="bodytext31" valign="center"  align="left">
						<a href="refund_external.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>&&billno=<?php echo $billno ?>&&rfkey=prm"><strong>Refund</strong></a>	</td>
						</tr>-->
				  <?php
				  }
			  }
			  ?>
              <?php
			$query21=mysqli_query($GLOBALS["___mysqli_ston"], "select * from pharmacysalesreturn_details where billstatus<>'completed' and  patientcode <> 'walkin' and visitcode NOT LIKE '%IPV' and visitcode like '%$searchvisitcode%' and entrydate between '$fromdate' and '$todate' and locationcode='$locationcode' and refundapprove='approved' group by docnumber order by entrydate desc") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($exec21=mysqli_fetch_array($query21))
			{
			$billno1 = $exec21['billnumber'];
			$billno = $exec21['docnumber'];
			$visitcode1 = $exec21['visitcode'];
			$searchpatient1 = trim($searchpatient);
			$query39=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_consultationpharm where patientname like '%$searchpatient%' and patientvisitcode='$visitcode1'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res39=mysqli_fetch_array($query39);
		    $patientname=$res39['patientname'];
			$patientcode=$exec21['patientcode'];
			if($patientcode=='walkin')
			{
				$billno = $exec21['billnumber'];
				$patientvisitcode='walkinvis';
				}
			else
			{
				$billno = $exec21['docnumber'];
				$patientvisitcode=$exec21['visitcode'];
				}
			
			//$patientname=$exec39['patientname'];
			$query34=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_consultation where patientvisitcode='$patientvisitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$exec34=mysqli_fetch_array($query34);
			$accname=$exec34['accountname'];
			$consultationdate=$exec21['entrydate'];
			$res3paymenttype='CASH';			  
			$accountname='CASH'; 
			
			$queryplan=mysqli_query($GLOBALS["___mysqli_ston"], "select planpercentage from master_visitentry where  visitcode='".$patientvisitcode."'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$execplan=mysqli_fetch_array($queryplan);
			$planpercentage=$execplan['planpercentage'];
			
			if(($patientname!='')&&($planpercentage==0.00))
			{
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
				  <!--<tr <?php echo $colorcode; ?>>
					<td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
						   <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
					</div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"><span class="bodytext32"><?php echo $patientvisitcode; ?></span></div>
					</div></td>
						  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
					</div></td>
			   
					   <td class="bodytext31" valign="center"  align="left">
					  <div align="left"><?php echo $patientname; ?></div></td>
			   
					<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
					</div></td>
								   <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $accountname; ?></div></td>
								  
						 
						<td class="bodytext31" valign="center"  align="left">
						<a href="refund_paynow.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>&&billno=<?php echo $billno ?>&&rfkey=prm"><strong>Refund</strong></a>	</td>
						</tr>-->
				  <?php
				  }
			  }
			  ?>


			    <?php
			    $qry = "select * from pharmacysalesreturn_details where billstatus<>'completed' and  patientcode <> 'walkin' and visitcode LIKE '%IPV' and visitcode like '%$searchvisitcode%' and entrydate between '$fromdate' and '$todate' and locationcode='$locationcode' and refundapprove='approved' group by docnumber order by entrydate desc";
			    //echo $qry;
			$query21=mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($exec21=mysqli_fetch_array($query21))
			{
			$billno1 = $exec21['billnumber'];
			$billno = $exec21['docnumber'];
			$visitcode1 = $exec21['visitcode'];
			$searchpatient1 = trim($searchpatient);
			$qry2 = "select patientfullname,patientcode from master_ipvisitentry where patientfullname like '%$searchpatient%' and visitcode='$visitcode1'";
			$query39=mysqli_query($GLOBALS["___mysqli_ston"], $qry2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res39=mysqli_fetch_array($query39);
		    $patientname=$res39['patientfullname'];
			$patientcode=$exec21['patientcode'];
			$patientvisitcode=$exec21['visitcode'];
		
			$consultationdate=$exec21['entrydate'];
			$res3paymenttype='CASH';			  
			$accountname='CASH'; 
			
			$queryplan=mysqli_query($GLOBALS["___mysqli_ston"], "select planpercentage from master_ipvisitentry where  visitcode='".$patientvisitcode."'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$execplan=mysqli_fetch_array($queryplan);
			$planpercentage=$execplan['planpercentage'];
			
			if(($patientname!='')&&($planpercentage==0.00))
			{
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
				  <!--<tr <?php echo $colorcode; ?>>
					<td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
						   <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
					</div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"><span class="bodytext32"><?php echo $patientvisitcode; ?></span></div>
					</div></td>
						  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
					</div></td>
			   
					   <td class="bodytext31" valign="center"  align="left">
					  <div align="left"><?php echo $patientname; ?></div></td>
			   
					<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
					</div></td>
								   <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $accountname; ?></div></td>
								  
						 
						<td class="bodytext31" valign="center"  align="left">
						<a href="refund_paynow.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>&&billno=<?php echo $billno ?>&&rfkey=prm"><strong>Refund</strong></a>	</td>
						</tr>-->
				  <?php
				  }
			  }
			  ?>

              <?php
			$query21=mysqli_query($GLOBALS["___mysqli_ston"], "select * from pharmacysalesreturn_details where billstatus<>'completed' and  patientcode <> 'walkin' and visitcode NOT LIKE '%IPV' and visitcode like '%$searchvisitcode%' and entrydate between '$fromdate' and '$todate' and refundapprove='approved' and locationcode='$locationcode' group by docnumber order by entrydate desc") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($exec21=mysqli_fetch_array($query21))
			{
			$billno1 = $exec21['billnumber'];
			$billno = $exec21['docnumber'];
			$visitcode = $exec21['visitcode'];
			$searchpatient1 = trim($searchpatient);
			$query39=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_consultationpharm where patientname like '%$searchpatient%' and patientvisitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res39=mysqli_fetch_array($query39);
		    $patientname=$res39['patientname'];
			$patientcode=$exec21['patientcode'];
			if($patientcode=='walkin')
			{
				$billno = $exec21['billnumber'];
				$patientvisitcode='walkinvis';
				}
			else
			{
				$billno = $exec21['docnumber'];
				$patientvisitcode=$exec21['visitcode'];
				}
			
			//$patientname=$exec39['patientname'];
			$query34=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_consultation where patientvisitcode='$patientvisitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$exec34=mysqli_fetch_array($query34);
			$accname=$exec34['accountname'];
			$consultationdate=$exec21['entrydate'];
			$res3paymenttype='CASH';			  
			$accountname='CASH'; 
			
			$queryplan=mysqli_query($GLOBALS["___mysqli_ston"], "select planpercentage from master_visitentry where  visitcode='".$patientvisitcode."'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$execplan=mysqli_fetch_array($queryplan);
			$planpercentage=$execplan['planpercentage'];
			
			if(($patientname!='')&&($planpercentage!=0.00))
			{
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
				  <!--<tr <?php echo $colorcode; ?>>
					<td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
						   <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
					</div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"><span class="bodytext32"><?php echo $patientvisitcode; ?></span></div>
					</div></td>
						  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
					</div></td>
			   
					   <td class="bodytext31" valign="center"  align="left">
					  <div align="left"><?php echo $patientname; ?></div></td>
			   
					<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
						<div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
					</div></td>
								   <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $accountname; ?></div></td>
								  
						 
						<td class="bodytext31" valign="center"  align="left">
						<a href="refund_copay.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>&&billno=<?php echo $billno ?>&&rfkey=cp"><strong>Refund</strong></a>	</td>
						</tr>-->
				  <?php
				  }
			  }
			  ?>
			  <?php
			  $billnos="'".''."'";
			
			$query21=mysqli_query($GLOBALS["___mysqli_ston"], "select * from consultation_radiology where patientname like '%$searchpatient%' and  radiologyrefund='refund' and refundapprove = 'approved' and patientcode = 'walkin' and patientvisitcode like '%$searchvisitcode%' and consultationdate between '$fromdate' and '$todate' and locationcode='$locationcode' group by patientvisitcode order by consultationdate desc") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($exec21=mysqli_fetch_array($query21))
			{
			 $billno = $exec21['billnumber'];
			
		    $patientname=$exec21['patientname'];
			$patientcode=$exec21['patientcode'];
			if($patientcode=='walkin')
			{
				$billno = $exec21['billnumber'];
				$patientvisitcode='walkinvis';
				}
			else
			{
				$billno = $exec21['docnumber'];
				$patientvisitcode=$exec21['patientvisitcode'];
				}
			
			
			if($billnos=='')
			{
			$billnos = "'".$billno."'";
			}
			else
			{
			$billnos = $billnos.",'".$billno."'";
			}
			//$patientname=$exec39['patientname'];
			$query34=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_consultation where patientvisitcode='$patientvisitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$exec34=mysqli_fetch_array($query34);
			$accname=$exec34['accountname'];
			$consultationdate=$exec21['consultationdate'];
			$res3paymenttype='CASH';
			  
			$accountname='CASH'; 
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
			<!--  <tr <?php echo $colorcode; ?>>
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
                       <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
                </div></td>
				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientvisitcode; ?></span></div>
                </div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
                </div></td>
           
                   <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $patientname; ?></div></td>
           
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>
                               <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $accountname; ?></div></td>
							  
                     
                    <td class="bodytext31" valign="center"  align="left">
					<a href="refund_external.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>&&billno=<?php echo $billno ?>&&rfkey=cr"><strong>Refund</strong></a>	</td>
                    </tr>-->
			  <?php
			  }
			  //}
			  ?>

			   <?php
			  $billnos="'".''."'";
			
			$query21=mysqli_query($GLOBALS["___mysqli_ston"], "select * from consultation_referal where patientname like '%$searchpatient%' and  referalrefund='refund' and refundapprove = 'approved' and patientvisitcode like '%$searchvisitcode%' and consultationdate between '$fromdate' and '$todate' and locationcode='$locationcode' group by patientvisitcode order by consultationdate asc") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($exec21=mysqli_fetch_array($query21))
			{ 
			$billno = $exec21['refno'];
		    $patientname=$exec21['patientname'];
			$patientcode=$exec21['patientcode'];
			$patientvisitcode = $exec21['patientvisitcode'];

			//$patientname=$exec39['patientname'];
			$query34=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_consultation where patientvisitcode='$patientvisitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$exec34=mysqli_fetch_array($query34);
			$accname=$exec34['accountname'];
			$consultationdate=$exec21['consultationdate'];
			$res3paymenttype='CASH';
			  
			$accountname='CASH'; 
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
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
                       <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
                </div></td>
				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientvisitcode; ?></span></div>
                </div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
                </div></td>
           
                   <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $patientname; ?></div></td>
           
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>
                               <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $accountname; ?></div></td>
							  
                     
                    <td class="bodytext31" valign="center"  align="left">
					<a href="refund_paynow.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>&&billno=<?php echo $billno ?>&&menuid=<?php echo $menu_id; ?>&&rfkey=rref"><strong>Referral Refund</strong></a>	</td>
                    </tr>
			  <?php
			  }
			  //}
			  ?>


                <?php
			  $billnos="'".''."'";
			$query21=mysqli_query($GLOBALS["___mysqli_ston"], "select * from consultation_radiology where patientname like '%$searchpatient%' and  radiologyrefund='refund' and refundapprove = 'approved' and billtype='PAY NOW' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and consultationdate between '$fromdate' and '$todate' and locationcode='$locationcode' group by patientvisitcode order by consultationdate desc") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($exec21=mysqli_fetch_array($query21))
			{
			 $billno = $exec21['billnumber'];
			
		    $patientname=$exec21['patientname'];
			$patientcode=$exec21['patientcode'];
			if($patientcode=='walkin')
			{
				$billno = $exec21['billnumber'];
				$patientvisitcode='walkinvis';
				}
			else
			{
				$billno = $exec21['docnumber'];
				$patientvisitcode=$exec21['patientvisitcode'];
				}
			
			
			if($billnos=='')
			{
			$billnos = "'".$billno."'";
			}
			else
			{
			$billnos = $billnos.",'".$billno."'";
			}
			//$patientname=$exec39['patientname'];
			$query34=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_consultation where patientvisitcode='$patientvisitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$exec34=mysqli_fetch_array($query34);
			$accname=$exec34['accountname'];
			$consultationdate=$exec21['consultationdate'];
			$res3paymenttype='CASH';
			  
			$accountname='CASH'; 
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
			  <!--<tr <?php echo $colorcode; ?>>
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
                       <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
                </div></td>
				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientvisitcode; ?></span></div>
                </div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
                </div></td>
           
                   <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $patientname; ?></div></td>
           
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>
                               <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $accountname; ?></div></td>
							  
                     
                    <td class="bodytext31" valign="center"  align="left">
					<a href="refund_paynow.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>&&billno=<?php echo $billno ?>&&rfkey=cr"><strong>Refund</strong></a>	</td>
                    </tr>-->
			  <?php
			  }
			  //}
			  ?>
                <?php
			  $billnos="'".''."'";
			$query21=mysqli_query($GLOBALS["___mysqli_ston"], "select * from consultation_radiology where patientname like '%$searchpatient%' and  radiologyrefund='refund' and refundapprove = 'approved' and billtype='PAY LATER' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and consultationdate between '$fromdate' and '$todate' and locationcode='$locationcode' group by patientvisitcode order by consultationdate desc") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($exec21=mysqli_fetch_array($query21))
			{
			 $billno = $exec21['billnumber'];
			
		    $patientname=$exec21['patientname'];
			$patientcode=$exec21['patientcode'];
			$locationcode22=$exec21['locationcode'];
			
			if($patientcode=='walkin')
			{
				$billno = $exec21['billnumber'];
				$patientvisitcode='walkinvis';
				}
			else
			{
				$billno = $exec21['docnumber'];
				$patientvisitcode=$exec21['patientvisitcode'];
				}
			
			
			if($billnos=='')
			{
			$billnos = "'".$billno."'";
			}
			else
			{
			$billnos = $billnos.",'".$billno."'";
			}
			//$patientname=$exec39['patientname'];
			$query34=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_consultation where patientvisitcode='$patientvisitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$exec34=mysqli_fetch_array($query34);
			$accname=$exec34['accountname'];
			$consultationdate=$exec21['consultationdate'];
			$res3paymenttype='CASH';
			  
			$accountname='CASH'; 
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			$querye1 = "select planpercentage from master_visitentry where locationcode='$locationcode22' and patientcode like '".$patientcode."' and visitcode like '".$patientvisitcode."' ";
			$exece1 = mysqli_query($GLOBALS["___mysqli_ston"], $querye1) or die ("Error in Querye1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rese1 = mysqli_fetch_array($exece1);
			
			$planpercentage = $rese1['planpercentage'];
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
			if($planpercentage>0.00)
			{
			?>
			  <!--<tr <?php echo $colorcode; ?>>
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
                       <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
                </div></td>
				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientvisitcode; ?></span></div>
                </div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
                </div></td>
           
                   <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $patientname; ?></div></td>
           
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>
                               <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $accountname; ?></div></td>
							  
                     
                    <td class="bodytext31" valign="center"  align="left">
					<a href="refund_copay.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>&&billno=<?php echo $billno ?>&&rfkey=cr"><strong>Refund</strong></a>	</td>
                    </tr>-->
			  <?php
			  }}
			  //}
			  ?>
			  <?php
			  
			$query21=mysqli_query($GLOBALS["___mysqli_ston"], "select * from consultation_services where patientname like '%$searchpatient%' and  servicerefund='refund' and refundapprove = 'approved' and patientcode = 'walkin' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' AND consultationdate between '$fromdate' and '$todate' and  locationcode='$locationcode' group by patientvisitcode order by consultationdate desc") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($exec21=mysqli_fetch_array($query21))
			{
			$billno = $exec21['billnumber'];
			
		    $patientname=$exec21['patientname'];
			$patientcode=$exec21['patientcode'];
			
			if($patientcode=='walkin')
			{
				$billno = $exec21['billnumber'];
				$patientvisitcode='walkinvis';
				}
			else
			{
				$billno = $exec21['docnumber'];
				$patientvisitcode=$exec21['patientvisitcode'];
				}
			//$patientname=$exec39['patientname'];
			$query34=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_consultation where patientvisitcode='$patientvisitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$exec34=mysqli_fetch_array($query34);
			$accname=$exec34['accountname'];
			$consultationdate=$exec21['consultationdate'];
			$res3paymenttype='CASH';
			  
			  
			$accountname='CASH'; 
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
			  <!--<tr <?php echo $colorcode; ?>>
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
                       <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
                </div></td>
				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientvisitcode; ?></span></div>
                </div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
                </div></td>
           
                   <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $patientname; ?></div></td>
           
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>
                               <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $accountname; ?></div></td>
							  
                     
                    <td class="bodytext31" valign="center"  align="left">
					<a href="refund_external.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>&&billno=<?php echo $billno ?>&&rfkey=cs"><strong>Refund</strong></a>	</td>
                    </tr>-->
			  <?php
			  }
			  //}
			  ?>
               <?php
			  
			$query21=mysqli_query($GLOBALS["___mysqli_ston"], "select * from consultation_services where patientname like '%$searchpatient%' and  servicerefund='refund' and refundapprove = 'approved' and billtype='PAY NOW' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%'  AND consultationdate between '$fromdate' and '$todate' and  locationcode='$locationcode' group by patientvisitcode order by consultationdate desc") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($exec21=mysqli_fetch_array($query21))
			{
			$billno = $exec21['billnumber'];
			
		    $patientname=$exec21['patientname'];
			$patientcode=$exec21['patientcode'];
			if($patientcode=='walkin')
			{
				$billno = $exec21['billnumber'];
				$patientvisitcode='walkinvis';
				}
			else
			{
				$billno = $exec21['docnumber'];
				$patientvisitcode=$exec21['patientvisitcode'];
				}
			//$patientname=$exec39['patientname'];
			$query34=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_consultation where patientvisitcode='$patientvisitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$exec34=mysqli_fetch_array($query34);
			$accname=$exec34['accountname'];
			$consultationdate=$exec21['consultationdate'];
			$res3paymenttype='CASH';
			  
			$accountname='CASH'; 
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
			  <!--<tr <?php echo $colorcode; ?>>
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
                       <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
                </div></td>
				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientvisitcode; ?></span></div>
                </div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
                </div></td>
           
                   <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $patientname; ?></div></td>
           
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>
                               <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $accountname; ?></div></td>
							  
                     
                    <td class="bodytext31" valign="center"  align="left">
					<a href="refund_paynow.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>&&billno=<?php echo $billno ?>&&rfkey=cs"><strong>Refund</strong></a>	</td>
                    </tr>-->
			  <?php
			  }
			  //}
			  ?>
              <?php
			  
			$query21=mysqli_query($GLOBALS["___mysqli_ston"], "select * from consultation_services where patientname like '%$searchpatient%' and  servicerefund='refund' and refundapprove = 'approved' and billtype='PAY LATER' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%'  AND consultationdate between '$fromdate' and '$todate' and  locationcode='$locationcode' group by patientvisitcode order by consultationdate desc") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($exec21=mysqli_fetch_array($query21))
			{
			$billno = $exec21['billnumber'];
			
		    $patientname=$exec21['patientname'];
			$patientcode=$exec21['patientcode'];
			$locationcode22=$exec21['locationcode'];
			if($patientcode=='walkin')
			{
				$billno = $exec21['billnumber'];
				$patientvisitcode='walkinvis';
				}
			else
			{
				$billno = $exec21['docnumber'];
				$patientvisitcode=$exec21['patientvisitcode'];
				}
			//$patientname=$exec39['patientname'];
			$query34=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_consultation where patientvisitcode='$patientvisitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$exec34=mysqli_fetch_array($query34);
			$accname=$exec34['accountname'];
			$consultationdate=$exec21['consultationdate'];
			$res3paymenttype='CASH';
			  
			$accountname='CASH'; 
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			$querye1 = "select planpercentage from master_visitentry where locationcode='$locationcode22' and patientcode like '".$patientcode."' and visitcode like '".$patientvisitcode."' ";
			$exece1 = mysqli_query($GLOBALS["___mysqli_ston"], $querye1) or die ("Error in Querye1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rese1 = mysqli_fetch_array($exece1);
			
			 $planpercentage = $rese1['planpercentage'];
			
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
			if($planpercentage>0.00)
			{
			?>
			  <!--<tr <?php echo $colorcode; ?>>
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
                       <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
                </div></td>
				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientvisitcode; ?></span></div>
                </div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
                </div></td>
           
                   <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $patientname; ?></div></td>
           
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>
                               <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $accountname; ?></div></td>
							  
                     
                    <td class="bodytext31" valign="center"  align="left">
					<a href="refund_copay.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>&&billno=<?php echo $billno ?>&&rfkey=cs"><strong>Refund</strong></a>	</td>
                    </tr>-->
			  <?php
			  }}
			  //}
			  ?>
			  <?php 
			$query21=mysqli_query($GLOBALS["___mysqli_ston"], "select * from consultation_lab where patientname like '%$searchpatient%' and  labrefund='refund' and refundapproval = 'approved' and
	 patientcode = 'walkin'  and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and consultationdate between '$fromdate' and '$todate' and  locationcode='$locationcode'  GROUP BY billnumber order by consultationdate desc") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($exec21=mysqli_fetch_array($query21))
			{
			$billno = $exec21['billnumber'];
			
		    $patientname=$exec21['patientname'];
			$patientcode=$exec21['patientcode'];
			if($patientcode=='walkin')
			{
				$billno = $exec21['billnumber'];
				$patientvisitcode='walkinvis';
				}
			else
			{
				$billno = $exec21['docnumber'];
				$patientvisitcode=$exec21['patientvisitcode'];
				}
			//$patientname=$exec39['patientname'];
			$query34=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_consultation where patientvisitcode='$patientvisitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$exec34=mysqli_fetch_array($query34);
			$accname=$exec34['accountname'];
			$consultationdate=$exec21['consultationdate'];
			$res3paymenttype='CASH';
			  
			$accountname='CASH'; 
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
			  <!--<tr <?php echo $colorcode; ?>>
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
                       <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
                </div></td>
				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientvisitcode; ?></span></div>
                </div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
                </div></td>
           
                   <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $patientname; ?></div></td>
           
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>
                               <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $accountname; ?></div></td>
							  
                     
                    <td class="bodytext31" valign="center"  align="left">
					<a href="refund_external.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>&&billno=<?php echo $billno ?>&&rfkey=cl"><strong>Refund</strong></a>	</td>
                    </tr>-->
			  <?php
			  }
			  //}
			  ?>
              <?php
			 
			$query21=mysqli_query($GLOBALS["___mysqli_ston"], "select * from consultation_lab where patientname like '%$searchpatient%' and  labrefund='refund' and refundapproval = 'approved' and
	 billtype = 'PAY NOW' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%'   and consultationdate between '$fromdate' and '$todate' and  locationcode='$locationcode' GROUP BY patientvisitcode order by consultationdate desc") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($exec21=mysqli_fetch_array($query21))
			{
			$billno = $exec21['billnumber'];
			
		    $patientname=$exec21['patientname'];
			$patientcode=$exec21['patientcode'];
			if($patientcode=='walkin')
			{
				$billno = $exec21['billnumber'];
				$patientvisitcode='walkinvis';
				}
			else
			{
				$billno = $exec21['docnumber'];
				$patientvisitcode=$exec21['patientvisitcode'];
				}
			//$patientname=$exec39['patientname'];
			$query34=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_consultation where patientvisitcode='$patientvisitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$exec34=mysqli_fetch_array($query34);
			$accname=$exec34['accountname'];
			$consultationdate=$exec21['consultationdate'];
			$res3paymenttype='CASH';
			  
			$accountname='CASH'; 
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
			  <!--<tr <?php echo $colorcode; ?>>
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
                       <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
                </div></td>
				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientvisitcode; ?></span></div>
                </div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
                </div></td>
           
                   <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $patientname; ?></div></td>
           
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>
                               <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $accountname; ?></div></td>
							  
                     
                    <td class="bodytext31" valign="center"  align="left">
					<a href="refund_paynow.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>&&billno=<?php echo $billno ?>&&rfkey=cl"><strong>Refund</strong></a>	</td>
                    </tr>-->
			  <?php
			  }
			  //}
			  ?>
              
              <?php
			 
			$query21=mysqli_query($GLOBALS["___mysqli_ston"], "select * from consultation_lab where patientname like '%$searchpatient%' and  labrefund='refund' and refundapproval = 'approved' and
	 billtype = 'PAY LATER'  and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%'  and consultationdate between '$fromdate' and '$todate' and  locationcode='$locationcode' GROUP BY patientvisitcode order by consultationdate desc") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($exec21=mysqli_fetch_array($query21))
			{
			$billno = $exec21['billnumber'];
			
		    $patientname=$exec21['patientname'];
			$patientcode=$exec21['patientcode'];
			if($patientcode=='walkin')
			{
				$billno = $exec21['billnumber'];
				$patientvisitcode='walkinvis';
				}
			else
			{
				$billno = $exec21['docnumber'];
				$patientvisitcode=$exec21['patientvisitcode'];
				}
			//$patientname=$exec39['patientname'];
			$query34=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_consultation where patientvisitcode='$patientvisitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$exec34=mysqli_fetch_array($query34);
			$accname=$exec34['accountname'];
			$consultationdate=$exec21['consultationdate'];
			$locationcode22=$exec21['locationcode'];
			$res3paymenttype='CASH';
			  
			$accountname='CASH'; 
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			$querye1 = "select planpercentage from master_visitentry where locationcode='$locationcode22' and patientcode like '".$patientcode."' and visitcode like '".$patientvisitcode."' ";
			$exece1 = mysqli_query($GLOBALS["___mysqli_ston"], $querye1) or die ("Error in Querye1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rese1 = mysqli_fetch_array($exece1);
			
			$planpercentage = $rese1['planpercentage'];
			
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
			if($planpercentage>0.00)
			{
			?>
			  <!--<tr <?php echo $colorcode; ?>>
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
                       <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
                </div></td>
				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientvisitcode; ?></span></div>
                </div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
                </div></td>
           
                   <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $patientname; ?></div></td>
           
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>
                               <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $accountname; ?></div></td>
							  
                     
                    <td class="bodytext31" valign="center"  align="left">
					<a href="refund_copay.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>&&billno=<?php echo $billno ?>&&rfkey=cl"><strong>Refund</strong></a>	</td>
                    </tr>-->
			  <?php
			  }}
			  //}
			  ?>
			  
			   <?php
			 
			$query221="select * from master_visitentry where patientfullname like '%$searchpatient%' and  doctorfeesstatus = 'torefund' and doctorfeesrefund <> '0.00' and consultationdate between '$fromdate' and '$todate' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%'  and  locationcode='$locationcode' GROUP BY visitcode order by consultationdate desc";
			$res221 = mysqli_query($GLOBALS["___mysqli_ston"], $query221) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($exec221=mysqli_fetch_array($res221))
			{
			
		    $patientname=$exec221['patientfullname'];
			$patientcode=$exec221['patientcode'];
			
			$res3paymenttype = $exec221['billtype'];
			$accountname1 = $exec221['accountname'];
			$consultationdate = $exec221['consultationdate'];
			$patientvisitcode=$exec221['visitcode'];
			
			$query34=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$accountname1'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$exec34=mysqli_fetch_array($query34);
			$accountname=$exec34['accountname'];	
			 
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
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
                       <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
                </div></td>
				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientvisitcode; ?></span></div>
                </div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
                </div></td>
           
                   <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $patientname; ?></div></td>
           
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>
                               <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $accountname; ?></div></td>
							  
                     
                    <td class="bodytext31" valign="center"  align="left">
					<a href="refundconsultreferralamt.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $patientvisitcode; ?>&&menuid=<?php echo $menu_id; ?>"><strong>Doctor Fees Refund</strong></a>	</td>
                    </tr>
			  <?php
			 }
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
           	</tr>
          </tbody>
        </table>

		 </form>
		 <?php
		 }
		 ?>		</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
	  
	 
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

