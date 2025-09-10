<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;
//include ("includes/check_user_access.php");

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


if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
if (isset($_REQUEST["searchaccountname"])) { $searchaccountname = $_REQUEST["searchaccountname"]; } else { $searchaccountname = ""; }
if (isset($_REQUEST["searchaccountcode"])) { $searchaccountcode = $_REQUEST["searchaccountcode"]; } else { $searchaccountcode = ""; }
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
	
}


function funcPrintReceipt1()
{
	
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
.bali
{
text-align:right;
}
.pagination{ float:right; }
</style>
</head>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl2(document.getElementById("searchaccountname"), new StateSuggestions2());        
}
</script>
<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/autocomplete_account.js"></script>
<script type="text/javascript" src="js/autosuggestaccounteditreg.js"></script>
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
		
		
              <form name="cbform1" method="post" action="searchpatientcodeupdate.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Duplicate Patient Details </strong></td>
              </tr>
          
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patient" type="text" id="patient" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Registration No</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patientcode" type="text" id="patient" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			      <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">National ID</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="nationalid" type="text" id="nationalid" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Account</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="searchaccountname" type="text" id="searchaccountname" value="<?php echo $searchaccountname; ?>" size="50" autocomplete="off">
				<input name="searchaccountcode" type="hidden" id="searchaccountcode" value="<?php echo $searchaccountcode; ?>" size="10" autocomplete="off">
				<input type="hidden" name="searchsuppliernamehiddentextbox" id="searchsuppliernamehiddentextbox">
				<input type="hidden" name="searchfrom" id="searchfrom" value="reg">
              </span></td>
              </tr>
		
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
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
      
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
	<form name="form1" id="form1" method="post" action="stockadjustment.php">	
	  <tr>
        <td>
	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1' || isset($_REQUEST['page']))
{

	if(isset($_POST['patient'])){	$_SESSION['serpatient'] = $_POST['patient'];	}
	if(isset($_POST['patientcode'])){	$_SESSION['serpatientcode'] = $_POST['patientcode'];}
	if(isset($_POST['nationalid'])){ $_SESSION['sernationalid'] = $_POST['nationalid']; }
	
	$searchpatientcode = $_SESSION['serpatientcode'];
	$searchnationalid = $_SESSION['sernationalid'];
	$searchpatient = $_SESSION['serpatient'];
	//echo $searchpatient;
		//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];


	
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1147" 
            align="left" border="0">
          <tbody>
             <tr>
				 <td colspan="14"  bgcolor="#ecf0f5" class="bodytext31">&nbsp;
				 
				 </td>
			 </tr>
           <tr>
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
			  if($searchaccountcode == '') {
            $query26 = "select customercode, customerfullname, dateofbirth, count(customercode) as num from master_customer where customerfullname like '%$searchpatient%' and customercode like '%$searchpatientcode%' and nationalidnumber like '%$searchnationalid%' and status <> 'deleted' group by customerfullname, gender, dateofbirth having num > 1 order by auto_number";
			} else {
			$query26 = "select customercode, customerfullname, dateofbirth, count(customercode) as num from master_customer where customerfullname like '%$searchpatient%' and customercode like '%$searchpatientcode%' and nationalidnumber like '%$searchnationalid%' and status <> 'deleted' and accountname = '$searchaccountcode' group by customerfullname, gender, dateofbirth having num > 1 order by auto_number";
			}
			$exec26 = mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in Query26".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res26 = mysqli_fetch_array($exec26))
			{
				$customercode = $res26['customercode'];
				$customerfullname = $res26['customerfullname'];
				$dateofbirth = $res26['dateofbirth'];
				$num = $res26['num'];
				$nos = $nos + 1;
			
			?>
            <tr bgcolor="#ccc">
            <td colspan="14" align="left" class="bodytext31"><strong><?php echo $customerfullname.' ('.$num.') '; ?></strong></td>
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
              <tr <?php echo $colorcode; ?>>
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
			  <?php
			  }
			  ?>
              <tr>
              <td colspan="14" align="right"><a href="customercodeupdate.php?customercode=<?php echo $customercode; ?>" target="_blank"><input type="button" name="upd_code" value="<?php echo "Update"; ?>"></a></td>
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

