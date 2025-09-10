<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
ini_set('max_execution_time', 12000000); //120 seconds
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

if (isset($_REQUEST["customercode"])) { $customercode = $_REQUEST["customercode"]; } else { $customercode = ""; }
//$getcanum = $_GET['canum'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
if($frmflag2 == "frmflag2")
{
	$customercode = $_REQUEST['customercode'];
	$code_update = $_REQUEST['code_update'];
	foreach($_REQUEST['code_chk'] as $key)
	{
		$cust_code = $_REQUEST['cust_code'][$key];
		$patient_status = $_REQUEST['patient_status'][$key];
		
		$querysch1 = "SELECT DISTINCT TABLE_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('patientcode') AND TABLE_SCHEMA='$databasename'";
		$execsch1 = mysqli_query($GLOBALS["___mysqli_ston"], $querysch1) or die ("Error in Querysch1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($ressch1=mysqli_fetch_array($execsch1))
		{
		  $query77 = "UPDATE `$ressch1[0]` SET patientcode = '$code_update' WHERE patientcode = '$cust_code'";
		  $exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		
		  $query772 = "UPDATE `master_customer` SET status = '$patient_status' WHERE customercode = '$cust_code'";
		  $exec772 = mysqli_query($GLOBALS["___mysqli_ston"], $query772) or die ("Error in Query772".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	header("location:customercodeupdate.php?customercode=$customercode");
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

function calculate_age($birthday)
			{
				$today = new DateTime();
				$diff = $today->diff(new DateTime($birthday));
			
				if ($diff->y)
				{
					return $diff->y . ' Years';
				}
				elseif ($diff->m)
				{
					return $diff->m . ' Months';
				}
				else
				{
					return $diff->d . ' Days';
				}
			}
?>
<style type="text/css">

body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}

</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

</script>
<script src="js/jquery-1.11.1.min.js"></script>
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

function Processchk()
{
	if(document.getElementById("code_update").value == "")
	{
		alert("Select update patientcode");
		document.getElementById("code_update").focus();
		return false;
	}
	var code_chk = document.getElementsByClassName("code_chk");
	var chk = false;
	for(var i=1;i<=code_chk.length;i++)
	{	
		if(document.getElementById("code_chk"+i).checked == true)
		{
			var chk = true;
			if(document.getElementById("patient_status"+i).value == "Deleted")
			{
				if(document.getElementById("cust_code"+i).value == document.getElementById("code_update").value)
				{
					alert("Cannot disable update patientcode");
					document.getElementById("code_update").focus();
					return false;
				}
			}
		}
	}
	if(chk==false)
	{
		alert("Select patientcode");
		document.getElementsByClassName("code_chk")[1].focus();
		return false;
	}
}

function ToggleRow(id){
	$('.'+id).toggle();
	$('#up'+id).toggle();
	$('#down'+id).toggle();
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
.pagination{ float:right; }
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
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = "cbfrmflag1"; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1147" 
            align="left" border="0">
          <tbody>
             <tr>
				 <td colspan="15"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;
				 
				 </td>
			 </tr>
           <tr>
                <td width="20"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;</strong></td>
                <td width="20"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
                <td width="80" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Reg Code</strong></td>
                <td width="80" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Area</strong></div></td>
                <td width="116" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Guardian </strong></div></td>
                <td width="76"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Bill Type </strong></td>
                <td width="110"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Next Kin</strong></div></td>
                <td width="85"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Kin Tel.No</strong></div></td>
                  <td width="137"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name </strong></div></td>
                <td width="46" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Age</strong></td>
                <td width="72"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Gender</strong></div></td>
                      <td width="66"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>
                  <!--OpeningBalance-->
                  NationalID</strong> </div></td>
                  <td width="45"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Mobile</strong></div></td>
             
				   <td width="48"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>User</strong></div></td>
                <td width="54"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>EMR</strong></div></td>

				   
                 </tr>
			  <?php 
			  $nos = 0;
			  $customer_build = array();
			  $table_name = array(
			  	'billing_consultation' => 'Consultation Bill',
				'consultation_icd' => 'ICD',
				'paymentmodedebit' => 'Payments',
				'master_billing' => 'Consultation Fee',
				'approvalstatus' => 'Approval',
				'billing_paynow' => 'Paynow Bill',
				'billing_paylater' => 'Paylater Bill',
			  );
			  
			 
			  $query26 = "select customercode, customerfullname, dateofbirth from master_customer where customercode = '$customercode' and status <> 'deleted' order by auto_number";
			  $exec26 = mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in Query26".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res26 = mysqli_fetch_array($exec26))
			  {
				$customercodesearch = $res26['customercode'];
				$customerfullname = $res26['customerfullname'];
				$dateofbirth = $res26['dateofbirth'];
				$nos = $nos + 1;
			
			?>
            <tr bgcolor="#ccc">
            <td colspan="15" align="left" class="bodytext31"><strong><?php echo $customerfullname; ?></strong></td>
            </tr>
			<?php
			   $ss = 0;
			  $query2 = "select * from master_customer where customerfullname = '$customerfullname' and dateofbirth = '$dateofbirth' and status <> 'deleted'";
			  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $num2 = mysqli_num_rows($exec2);
			 // echo $num2;
			  while ($res2 = mysqli_fetch_array($exec2))
			  {
			  $res2customercode = $res2['customercode'];
			  array_push($customer_build, $res2customercode);
			  $res2customeranum = $res2['auto_number'];
			  $res2customername = $res2['customerfullname'];
			  $res2customercode = $res2['customercode'];
			  //$res2contactperson1 = $res2['contactperson1'];
			  $paymenttypeanum = $res2['paymenttype'];
			  $user = $res2['username'];
			  
			  $query3 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $res3paymenttype = $res3['paymenttype'];
			  
			  $subtypeanum = $res2['subtype'];
			  
			  $query4 = "select * from master_subtype where auto_number = '$subtypeanum'";
			  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res4 = mysqli_fetch_array($exec4);
			  $res4subtype = $res4['subtype'];
			  $res2billtype = $res2['billtype'];
			  $accountnameanum = $res2['accountname'];
	          $query5 = "select * from master_accountname where auto_number = '$accountnameanum'";
			  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res5 = mysqli_fetch_array($exec5);
			  $res5accountname = $res5['accountname'];
			  $res2accountexpirydate = $res2['accountexpirydate'];
			  $plannameanum = $res2['planname'];
			  $query6 = "select * from master_planname where auto_number = '$plannameanum'";
			  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res6 = mysqli_fetch_array($exec6);
			  $res6planname = $res6['planname'];
			  
			  $res2planexpirydate = $res2['planexpirydate'];
			  $res2visitlimit = $res2['visitlimit'];
			  $res2overalllimit = $res2['overalllimit'];
			  $res2customername	= $res2['customerfullname'];
			  $dob = $res2['dateofbirth']; 
			  
			  $res2age = calculate_age($dob);

			
			  $res2gender = $res2['gender'];
			  $res2mothername = $res2['mothername'];
			  $res2bloodgroup = $res2['bloodgroup'];
			  $res2area = $res2['area'];
			  $res2nationalidnumber = $res2['nationalidnumber'];
			  $res2pincode = $res2['pincode'];
			  $res2mobilenumber = $res2['mobilenumber'];
			  $res2phonenumber1 = $res2['phonenumber1'];
			  $res2phonenumber2 = $res2['phonenumber2'];
			  $res2emailid1 = $res2['emailid1'];
			  $res2kinname = $res2['kinname'];
			  $res2kincontact = $res2['kincontactnumber'];
			  $res2emailid2 = $res2['emailid2'];
			  $res2faxnumber1 = $res2['faxnumber'];
			  $res2faxnumber2 = '';
			  $res2anum = $res2['auto_number'];
			  $res2address1 = $res2['address1'];
			  $res2city = $res2['city'];
			  $res2openingbalance1 = $res2['openingbalance'];
			  $res2insuranceid = $res2['insuranceid'];
			  $res2registrationdate = $res2['registrationdate'];
			  if ($res2registrationdate == '0000-00-00') $res2registrationdate = '';
			  $res2registrationtime = $res2['registrationtime'];
			  $res2consultingdoctor = $res2['consultingdoctor'];
			  $query201 = "select * from master_doctor where doctorcode = '$res2consultingdoctor'";
			  $exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die ("Error in Query201".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res201 = mysqli_fetch_array($exec201);
			  $res2consultingdoctor = $res201['doctorname'];
			  
			  //$query3 = "select * from master_patientadmission where patientcode = '$res2customercode' order by auto_number desc limit 0, 1";
			  //$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			  //$res3 = mysql_fetch_array($exec3);
			  //$res3ipnumber = $res3['ipnumber'];
			  $res3ipnumber = '';
			  $ss = $ss + 1;
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
              <tr <?php echo $colorcode; ?> onClick="return ToggleRow('<?php echo $res2customercode; ?>');">
              <td class="bodytext31" valign="center"  align="left">
              <a id="down<?php echo $res2customercode; ?>" style="background:url(img/arrow1.png) 0px 10px;width:20px;height:10px;float:left;display:block;text-decoration:none;"></a>
                <a id="up<?php echo $res2customercode; ?>" style="background:url(img/arrow1.png) 0px 0px;width:20px;height:10px;float:left;display:block;text-decoration:none;display:none;"></a></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $ss; ?></td>
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $res2customercode; ?></span></div>
                </div></td>
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res2area; ?> </span> </div>
                </div></td>
                <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
                  <div align="left">
				  <span class="bodytext3">
				  <?php echo $res2mothername; ?>				  </span>				  </div>
                </div>				</td>
                <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $res2billtype; ?></div></td>
                <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $res2kinname; ?></div></td>
                <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $res2kincontact; ?></div></td>
                     <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $res2customername; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $res2age; ?></div></td>
                <td  align="left" valign="center" class="bodytext31"><div align="center">
				<?php if(($res2gender == 'MALE')||($res2gender == 'Male'))
				 {
				?>
				<img src="images/male.png" width="16" height="16" border="0" />
				<?php
				 }
				 else
				 {
				?>
				<img src="images/female.png" width="16" height="16" border="0" />
				 <?php
				 }
				 ?>

				</div></td>
                    <td class="bodytext31" valign="center"  align="left"><?php echo $res2nationalidnumber; ?></td>
					<td class="bodytext31" valign="center"  align="left"><?php echo $res2mobilenumber; ?></td>
					 <td class="bodytext31" valign="center"  align="left"><?php echo $user; ?></td>
                    <td class="bodytext31" valign="center"  align="left"><a href="emrresultsviewlist.php?cbfrmflag1=cbfrmflag1&&patientcode=<?= $res2customercode; ?>&&ADate1=2015-01-01&&ADate2=<?= date('Y-m-d'); ?>&&customer=<?= $res2customername; ?>" target="_blank"><strong><?php echo 'View'; ?></strong></a></td>
                  </tr>
                  	  
                      <tr class="<?php echo $res2customercode; ?>" style="display:none;">
                      <td colspan="5" align="left" class="bodytext31">&nbsp;</td>
                      <td align="left" class="bodytext31"><strong><?php echo 'Patientcode'; ?></strong></td>
                      <td align="left" class="bodytext31"><strong><?php echo 'Tables'; ?></strong></td>
                      <td align="left" class="bodytext31"><strong><?php echo 'Rows'; ?></strong></td>
                      </tr>
			  <?php
				  //echo $databasename;
				  $rowcount = 0;
				  $tablecount = 0;
				  $querysch = "SELECT DISTINCT TABLE_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('patientcode') AND TABLE_SCHEMA='$databasename'";
				  $execsch = mysqli_query($GLOBALS["___mysqli_ston"], $querysch) or die ("Error in Querysch".mysqli_error($GLOBALS["___mysqli_ston"]));
				  while($ressch=mysqli_fetch_array($execsch))
				  {
					  $query77 = "SELECT patientcode FROM `$ressch[0]` where patientcode = '$res2customercode'";
					  $exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
					  $row77 = mysqli_num_rows($exec77);
					  if($row77 > 0)
					  {
						  $rowcount = $rowcount + $row77;
				  		  $tablecount = $tablecount + 1;
					  ?>
					  <tr class="<?php echo $res2customercode; ?>" bgcolor="#fff" style="display:none;">
                      <td colspan="5" align="left" class="bodytext31">&nbsp;</td>
                      <td align="left" class="bodytext31"><?php echo $res2customercode; ?></td>
                      <td align="left" class="bodytext31"><?php echo isset($table_name[$ressch[0]]) ? $table_name[$ressch[0]] : ucwords(str_replace('master','',str_replace('billing','',str_replace('_',' ',$ressch[0])))); ?></td>
                      <td align="left" class="bodytext31"><?php echo $row77; ?></td>
                      <td colspan="7" align="left" class="bodytext31">&nbsp;</td>
                      </tr>
					  <?php
                      }
				  }
				  ?>
                  <tr bgcolor="#ccc">
                  <td colspan="5" align="left" class="bodytext31">&nbsp;</td>
                  <td align="left" class="bodytext31"><strong><?php echo "Total Count:"; ?></strong></td>
                  <td align="left" class="bodytext31"><strong><?php echo $tablecount; ?></strong></td>
                  <td align="left" class="bodytext31"><strong><?php echo $rowcount; ?></strong></td>
                  <td colspan="7" align="left" class="bodytext31">&nbsp;</td>
                  </tr>
                  <?php
			  }
			  ?>
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
<?php
}
?>	
		</td>
      </tr>
       <tr>
        <td>&nbsp;</td>
       </tr>
       <form name="form2" method="post" action="customercodeupdate.php" onSubmit="return Processchk()">
        <tr>
        <td>
        <table border="1" style="border-collapse:collapse" width="600" cellpadding="5" cellspacing="5">
        <tr bgcolor="#fff">
        <td colspan="5" align="left" class="bodytext31"><strong>Patient Code Update</strong></td>
        </tr>
        <tr bgcolor="#ccc">
        <td width="37" align="left" class="bodytext31"><strong>S.No</strong></td>
        <td width="53" align="left" class="bodytext31"><strong>Select</strong></td>
        <td width="252" align="left" class="bodytext31"><strong>Patientcode</strong></td>
        <td width="252" align="left" class="bodytext31"><strong>Status</strong></td>
        <td width="183" align="left" class="bodytext31"><strong>Update To</strong></td>
        </tr>
        <?php
		$colorloopcount = 0;
		foreach($customer_build as $code)
		{
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
        <td align="left" class="bodytext31"><?php echo $colorloopcount; ?></td>
        <td align="left" class="bodytext31">
        <input type="hidden" name="cust_code[<?php echo $colorloopcount; ?>]" id="cust_code<?php echo $colorloopcount; ?>" value="<?php echo $code; ?>">
        <input type="checkbox" class="code_chk" name="code_chk[<?php echo $colorloopcount; ?>]" id="code_chk<?php echo $colorloopcount; ?>" value="<?php echo $colorloopcount; ?>"></td>
        <td align="left" class="bodytext31"><?php echo $code; ?></td>
        <td align="left" class="bodytext31"><select name="patient_status[<?php echo $colorloopcount; ?>]" id="patient_status<?php echo $colorloopcount; ?>">
        <option value="">Select</option>
        <option value="Deleted">Disabled</option>
        </select></td>
        <?php if($colorloopcount == 1){ ?>
        <td rowspan="<?php echo count($customer_build); ?>">
        <select name="code_update" id="code_update">
        <option value="">Select</option>
        <?php
		foreach($customer_build as $ud_code)
		{
		?>
        <option value="<?php echo $ud_code; ?>"><?php echo $ud_code; ?></option>
        <?php
		}
		?>
        </select>
        </td>
        <?php } ?>
        </tr>
        <?php
		}
		?>
        </table>
        </td>
      </tr>
      <tr>
      <td align="left" class="bodytext31">&nbsp;</td>
      </tr>
      <tr>
      <td align="left" class="bodytext31">
      <input type="hidden" name="frmflag2" id="frmflag2" value="frmflag2">
      <input type="hidden" name="customercode" id="customercode" value="<?php echo $customercode; ?>">
      <input type="submit" name="submit" value="Submit">
      </td>
      </tr>
	  </form>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

