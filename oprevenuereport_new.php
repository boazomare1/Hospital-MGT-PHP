<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');

$searchsuppliername = '';
$suppliername = '';
$cbsuppliername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$colorloopcount = '';
$sno = '';
$snocount = '';
$visitcode1 = '';
$total = '';
$nettotal = '0.00';
$looptotalpaidamount = '0.00';
$looptotalpendingamount = '0.00';
$looptotalwriteoffamount = '0.00';
$looptotalcashamount = '0.00';
$looptotalcreditamount = '0.00';
$looptotalcardamount = '0.00';
$looptotalonlineamount = '0.00';
$looptotalchequeamount = '0.00';
$looptotaltdsamount = '0.00';
$looptotalwriteoffamount = '0.00';
$pendingamount = '0.00';
$accountname = '';
$total = '0.00';
$totalpharmacysalesreturn='0';
$totalamount1 = '0.00';
$totalamount2 = '0.00';
$totalamount3 = '0.00';
$totalamount4 = '0.00';
$totalamount5 = '0.00';
$totalamount6 = '0.00';
$totalamount7 = '0.00';
$totalamount8 = '0.00';
$overaltotalrefund='0.00';

$grand_total='0';
$grand_total1='0';

$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
$department=isset($_REQUEST['department'])?$_REQUEST['department']:'';
if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }

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

	//$cbsuppliername = $_REQUEST['cbsuppliername'];
	//$suppliername = $_REQUEST['cbsuppliername'];
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
	$visitcode1 = 10;

}

if (isset($_REQUEST["task"])) { $task = $_REQUEST["task"]; } else { $task = ""; }
//$task = $_REQUEST['task'];
if ($task == 'deleted')
{
	$errmsg = 'Payment Entry Delete Completed.';
}

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
if ($ADate1 != '' && $ADate2 != '')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}
else
{
	$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
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
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style3 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
<script language="javascript">

function funcPrintReceipt1(varRecAnum)
{
	var varRecAnum = varRecAnum
	//alert (varRecAnum);
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php //echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php?receiptanum="+varRecAnum+"","OriginalWindow<?php //echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

function funcDeletePayment1(varPaymentSerialNumber)
{
	var varPaymentSerialNumber = varPaymentSerialNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete this payment entry serial number '+varPaymentSerialNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Payment Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Payment Entry Delete Not Completed.");
		return false;
	}
	//return false;
}

</script>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
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
    <td width="99%" valign="top">
      <table width="116%" border="0" cellspacing="0" cellpadding="0">
      	<tr>
        <td width="860">
		     <form name="cbform1" method="post" action="oprevenuereport_new.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>OP Revenue Report </strong></td>
                      <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php //echo $errmgs; ?>&nbsp;</td>-->
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
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
				    <tr>
             			<td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              			<td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
				 <select name="location" id="location">
                 <option value="All">All</option>
                    <?php
						
						$query1 = "select * from master_location where status='' order by locationname";
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
			         
             			<td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Department</td>
              			<td width="10%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
				 <select name="department" id="department">
                 <option value="All">All</option>
                    <?php
						
						$query1 = "select * from master_department where recordstatus <> 'deleted' order by department";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$loccode=array();
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$departmentname = $res1["department"];
						$departmentcode = $res1["auto_number"];
						
						?>
						 <option value="<?php echo $departmentcode; ?>" <?php if($department!='')if($department==$departmentcode){echo "selected";}?>><?php echo $departmentname; ?></option>
						<?php
						} 
						?>
						
                      </select>
		      </span></td>
			      </tr>
				  <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
                  </tr>
                  </tbody>
                </table>
              </form>		
        </td>
        </tr>
        
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>
          <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" align="left" border="0">
          <tbody>
            <tr>
			<?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
				?>
             <td colspan="13" bgcolor="#ecf0f5" class="bodytext3"><strong>OP Revenue &nbsp; From &nbsp;<?php echo date('d-M-Y',strtotime($ADate1)); ?> To <?php echo date('d-M-Y',strtotime($ADate2)); ?></strong></td>
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext31">
              <?php
			
					if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					$transactiondatefrom = $_REQUEST['ADate1'];
					$transactiondateto = $_REQUEST['ADate2'];
					if($department == 'All')
					{
					$department = '%%';
					}
					
					?> 			
               </td>
              </tr>
              
              <!--VENU CHANGING DESIGN -->
              <?php 
			   if($location!='All')
			   {
			  ?>
              <tr>
              	  <td width="10%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Consultation</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Pharmacy</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Laboratory</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Radiology</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Service</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Referral</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Rescue</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Home Care </strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Total</strong></td>
              </tr>
              <?php
			   }
			  ?>
              <!--ENDS-->
             
            <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					$tot_consult1 = 0.00;
					$tot_pharmacy1 = 0.00;
					$tot_lab1 = 0.00;
					$tot_radiol1 = 0.00;
					$tot_serv1 = 0.00;
					$tot_reffer1 = 0.00;
					$tot_rescue1 = 0.00;
					$tot_homecare1 = 0.00;
					 
					//VENU -- CODE FOR ALL SELECT FOR LOCATION
					if($location == 'All')
					{
						
		
				$query01="select locationcode,locationname from master_employeelocation where username ='$username' group by locationcode order by locationname ";		
				$exec01 = mysqli_query($GLOBALS["___mysqli_ston"], $query01) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			//	$loccode=array();
				while ($res01 = mysqli_fetch_array($exec01))
				{
						$locationname = $res01["locationname"];
						$locationcode = $res01["locationcode"];
		?>
           <tr <?php //echo $colorcode; ?>>
            <!--  <td colspan="3" class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong><?php //echo $locationname; ?></strong></td>-->
               <td  colspan="10" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo $locationname; ?></strong></td>
		   </tr>
        
            <!--TABLE HEADINGS TO DISLAY-->
            <tr>
              	  <td width="10%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Consultation</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Pharmacy</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Laboratory</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Radiology</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Service</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Referral</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Rescue</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Home Care </strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Total</strong></td>
              </tr>
              
              <?php
			  //Get consultancy,pharmacy,lab,radiolgy,ser,refferal records for all locations
			  
			  //this query for consultation
			
			$query1 = "select sum(consultation) as billamount1 from billing_consultation where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$res1consultationamount = $res1['billamount1'];
			$query1 = "select sum(fxamount) as billamount1 from billing_paylaterconsultation where locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' and visitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$res2consultationamount = $res1['billamount1'];
			
			// this query for pharmacy
		    $query8 = "select sum(fxamount) as amount1 from billing_paylaterpharmacy where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
		 	$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res8 = mysqli_fetch_array($exec8);
			$res8pharmacyitemrate = $res8['amount1'];
			
			$query9 = "select sum(fxamount) as amount1 from billing_paynowpharmacy where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
		    $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res9 = mysqli_fetch_array($exec9);
			$res9pharmacyitemrate = $res9['amount1'];
			
			$query17 = "select sum(amount) as amount1 from billing_externalpharmacy where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'  and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query17".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			$res17pharmacyitemrate = $res17['amount1'];
			  
			//this query for laboratry
			$query2 = "select sum(fxamount) as labitemrate1 from billing_paylaterlab where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'  and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_fetch_array($exec2);
			$res2labitemrate = $res2['labitemrate1'];
			
			$query3 = "select sum(fxamount) as labitemrate1 from billing_paynowlab where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'  and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$res3labitemrate = $res3['labitemrate1'];
			
			$query14 = "select sum(labitemrate) as labitemrate1 from billing_externallab where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'  and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in query14".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res14 = mysqli_fetch_array($exec14);
			$res14labitemrate = $res14['labitemrate1'];
			
			$totallabitemrate = $res2labitemrate + $res3labitemrate + $res14labitemrate;
			
			
			//this query for radiology
			$query4 = "select sum(fxamount) as radiologyitemrate1 from billing_paylaterradiology where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'  and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$res4radiologyitemrate = $res4['radiologyitemrate1'];
			
			$query5 = "select sum(fxamount) as radiologyitemrate1 from billing_paynowradiology where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res5 = mysqli_fetch_array($exec5);
			$res5radiologyitemrate = $res5['radiologyitemrate1'];
			
			$query15 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_externalradiology where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'  and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res15 = mysqli_fetch_array($exec15);
			$res15radiologyitemrate = $res15['radiologyitemrate1'];
			
			$totalradiologyitemrate = $res4radiologyitemrate + $res5radiologyitemrate + $res15radiologyitemrate; 
			
			//this query for service
			$query6 = "select sum(fxamount) as servicesitemrate1 from billing_paylaterservices where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$res6servicesitemrate = $res6['servicesitemrate1'];
			
			$query7 = "select sum(fxamount) as servicesitemrate2 from billing_paynowservices where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'  and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res7 = mysqli_fetch_array($exec7);
			$res7servicesitemrate = $res7['servicesitemrate2'];
			
			$query16 = "select sum(servicesitemrate) as servicesitemrate3 from billing_externalservices where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res16 = mysqli_fetch_array($exec16);
			$res16servicesitemrate = $res16['servicesitemrate3'];
			
			$totalservicesitemrate = $res6servicesitemrate + $res7servicesitemrate + $res16servicesitemrate ;
			
			$query10 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res10 = mysqli_fetch_array($exec10);
			$res10referalitemrate = $res10['referalrate1'];
			
			$query11 = "select sum(referalrate) as referalrate1 from billing_paynowreferal where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11 = mysqli_fetch_array($exec11);
			$res11referalitemrate = $res11['referalrate1']; 
			
			//this query for refund consultation
			
			$query12 = "select sum(consultation) as consultation1 from refund_consultation where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'  and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res12 = mysqli_fetch_array($exec12);
			$res12refundconsultation = $res12['consultation1'];
			
			//this query for refund pharmacy
			
			$query21 = "select sum(amount)as amount1 from refund_paylaterpharmacy where locationcode='$locationcode' and billdate between  '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res21 = mysqli_fetch_array($exec21) ;
			$res21refundlabitemrate = $res21['amount1'];
			$query22 = "select sum(amount)as amount1 from refund_paynowpharmacy where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22) ;
			$res22refundlabitemrate = $res22['amount1'];
			$totalrefundpharmacy = $res22refundlabitemrate + $res21refundlabitemrate;
			
			//this query for refund laboratory
			
			$query19 = "select sum(labitemrate)as labitemrate1 from refund_paylaterlab where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query19".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res19 = mysqli_fetch_array($exec19) ;
			$res19refundlabitemrate = $res19['labitemrate1'];
			$query20 = "select sum(labitemrate)as labitemrate1 from refund_paynowlab where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res20 = mysqli_fetch_array($exec20) ;
			$res20refundlabitemrate = $res20['labitemrate1'];
			$totalrefundlab = $res20refundlabitemrate + $res19refundlabitemrate;
			
			//this query for refund radiology
			
			$query22 = "select sum(radiologyitemrate)as radiologyitemrate1 from refund_paylaterradiology where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22) ;
			$res22refundradioitemrate = $res22['radiologyitemrate1'];
			$query23 = "select sum(radiologyitemrate)as radiologyitemrate1 from refund_paynowradiology where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res23 = mysqli_fetch_array($exec23) ;
			$res23refundradioitemrate = $res23['radiologyitemrate1'];
			$totalrefundradio = $res23refundradioitemrate + $res22refundradioitemrate;
			
			//this query for refund service
			
			$query24 = "select sum(amount)as servicesitemrate1 from refund_paylaterservices where locationcode='$locationcode' and billdate between             '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec24= mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res24 = mysqli_fetch_array($exec24) ;
			$res24refundserviceitemrate = $res24['servicesitemrate1'];
			$query25 = "select sum(servicetotal)as servicesitemrate1 from refund_paynowservices where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res25 = mysqli_fetch_array($exec25) ;
			$res25refundserviceitemrate = $res25['servicesitemrate1'];
			$totalrefundservice = $res25refundserviceitemrate + $res24refundserviceitemrate;
			
			//this query for refund referal
			
			$query26 = "select sum(referalrate)as referalrate1 from refund_paylaterreferal where locationcode='$locationcode' and billdate between  '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec26= mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res26 = mysqli_fetch_array($exec26) ;
			$res26refundreferalitemrate = $res26['referalrate1'];
			$query27 = "select sum(referalrate)as referalrate1 from refund_paynowreferal where locationcode='$locationcode' and billdate between  '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res27 = mysqli_fetch_array($exec27) ;
			$res27refundreferalitemrate = $res27['referalrate1'];
			$totalrefundreferal = $res27refundreferalitemrate + $res26refundreferalitemrate;
			
			//this query for home care
			$query28 = "select sum(amount) as amount1 from billing_homecare where locationcode='$locationcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' and visitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec28= mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query28".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res28 = mysqli_fetch_array($exec28) ;
			$res28homecare = $res28['amount1'];
			
			$query29 = "select sum(amount) as amount1 from billing_homecarepaylater where locationcode='$locationcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' and visitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res29 = mysqli_fetch_array($exec29) ;
			$res29homecare = $res29['amount1'];
			$totalhomecare = $res28homecare + $res29homecare;
			
			//this query for rescue
			$query30 = "select sum(amount) as amount1 from billing_opambulance where locationcode='$locationcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' and visitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec30= mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die ("Error in Query30".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res30 = mysqli_fetch_array($exec30) ;
			$res30rescue = $res30['amount1'];
			
			$query31 = "select sum(amount) as amount1 from billing_opambulancepaylater where locationcode='$locationcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' and visitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res31 = mysqli_fetch_array($exec31) ;
			$res31rescue = $res31['amount1'];
			$totalrescue = $res30rescue + $res31rescue;
			
			
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
			  
			  //ENDS
			  //for cash total
			  $cashtotal1=$res1consultationamount+$res9pharmacyitemrate+$res3labitemrate+$res5radiologyitemrate+$res7servicesitemrate+$res11referalitemrate+$res30rescue+$res28homecare;
			  
			  //for credit total
			  $credittotal1=$res2consultationamount+$res8pharmacyitemrate+$res2labitemrate+$res4radiologyitemrate+$res6servicesitemrate+$res10referalitemrate+$res31rescue+$res29homecare;
			  //for external total
			  $extval = 0;
			   $externaltotal1=$extval+$res17pharmacyitemrate+$res14labitemrate+$res15radiologyitemrate+$res16servicesitemrate+$total;
			   
			  //for refund total
			  $refundtotal1=$res12refundconsultation+$totalrefundpharmacy+$totalrefundlab+$totalrefundradio+$totalrefundservice+$totalrefundreferal;
			  $holetotal=$cashtotal1+$credittotal1+$externaltotal1-$refundtotal1;
			  ?>
              
              <!--DISPLAY OUT PUT RECORDS FROM DB-->
              
            	<!--VENU cash VALUE DISPLAY-->
                <tr <?php echo $colorcode; ?>>
              	  <td class="bodytext31" valign="center"  align="left"><strong>Cash</strong></td>	
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res1consultationamount,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res9pharmacyitemrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res3labitemrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res5radiologyitemrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res7servicesitemrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res11referalitemrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res30rescue,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res28homecare,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($cashtotal1,2,'.',','); ?></strong></div></td>
               </tr>
               <!--ENDS-->
             
              <!--VENU -- Credit VALUES DISPLAY-->
              
              <tr <?php echo $colorcode; ?>>
                   <td class="bodytext31" valign="center"  align="left"><strong>Credit</strong></td>	
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res2consultationamount,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res8pharmacyitemrate,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res2labitemrate,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res4radiologyitemrate,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res6servicesitemrate,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res10referalitemrate,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res31rescue,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res29homecare,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($credittotal1,2,'.',','); ?></strong></div></td>
              </tr>
              <!--ENDS-->
             
              <!--VENU External VALUES DISPLAY-->
               <!-- <tr <?php echo $colorcode; ?>>
                   <td class="bodytext31" valign="center"  align="left"><strong>External</strong></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $extval; ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res17pharmacyitemrate,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res14labitemrate,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res15radiologyitemrate,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res16servicesitemrate,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($total,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($externaltotal1,2,'.',','); ?></strong></div></td>
              </tr>-->
              <!--ENDS-->
             
               <!--VENU Refund VALUES DISPLAY-->
               <tr <?php echo $colorcode; ?>>
            	  <td class="bodytext31" valign="center"  align="left"><strong>Refund</strong></td>
                 <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo "-".number_format($res12refundconsultation,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo "-".number_format($totalrefundpharmacy,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo "-".number_format($totalrefundlab,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo "-".number_format($totalrefundradio,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo "-".number_format($totalrefundservice,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo "-".number_format($totalrefundreferal,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
				  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo "-".number_format($refundtotal1,2,'.',','); ?></strong></div></td>
                </tr>
                <!--ENDS-->
                
                <!--VENU TOTAL CALCULATION-->
                <?php
					$tot_consult = $res1consultationamount+$res2consultationamount-$res12refundconsultation;
					$tot_pharmacy = $res9pharmacyitemrate+$res8pharmacyitemrate+$res17pharmacyitemrate-$totalrefundpharmacy;
					$tot_lab = $res3labitemrate+$res2labitemrate+$res14labitemrate-$totalrefundlab;
					$tot_radiol = $res5radiologyitemrate+$res4radiologyitemrate+$res15radiologyitemrate-$totalrefundradio;
					$tot_serv = $res7servicesitemrate+$res6servicesitemrate+$res16servicesitemrate-$totalrefundservice;
					$tot_reffer = $res11referalitemrate+$res10referalitemrate+$total-$totalrefundreferal;
					$grand_total=$tot_consult+$tot_pharmacy+$tot_lab+$tot_radiol+$tot_serv+$tot_reffer;
					
					$tot_consult1 = $tot_consult1 + $tot_consult;
					$tot_pharmacy1 = $tot_pharmacy1 + $tot_pharmacy;
					$tot_lab1 = $tot_lab1 + $tot_lab;
					$tot_radiol1 = $tot_radiol1 + $tot_radiol;
					$tot_serv1 = $tot_serv1 + $tot_serv;
					$tot_reffer1 = $tot_reffer1 + $tot_reffer;
					$tot_rescue1 = $tot_rescue1 + $totalrescue;
					$tot_homecare1 = $tot_homecare1 + $totalhomecare;
					$grand_total1 = $grand_total1 + $grand_total;
					
					
				?>
                <tr <?php echo $colorcode; ?>>
                  <td class="bodytext31" valign="center"  align="left"><strong>Total</strong></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_consult,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_pharmacy,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_lab,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_radiol,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_serv,2,'.',','); ?></strong></div></td>
				  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_reffer,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalrescue,2,'.',','); ?></strong></div></td>
				  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalhomecare,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($holetotal,2,'.',',');  ?></strong></div></td>
                </tr>
               <tr>
               	<td colspan="7"></td>
               </tr>
			  <!--ENDS-->
            
       	    <?php
				}
				?>
				<tr bgcolor="#ecf0f5">
                  <td class="bodytext31" valign="center"  align="left"><strong>Grand Total</strong></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_consult1,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_pharmacy1,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_lab1,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_radiol1,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_serv1,2,'.',','); ?></strong></div></td>
				  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_reffer1,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_rescue1,2,'.',','); ?></strong></div></td>
				  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_homecare1,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($grand_total1,2,'.',','); ?></strong></div></td>
                  
                </tr>
				<?php
					}
					//VENU -- ALL SELECTION ENDS
					
					
					
		        if($location!='All')
				{
			//this query for consultation
			$query1 = "select sum(consultation) as billamount1 from billing_consultation where  locationcode='$location' and  billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$res1consultationamount = $res1['billamount1'];
			
			$query1 = "select sum(fxamount) as billamount1 from billing_paylaterconsultation where locationcode='$location' and  billdate between '$transactiondatefrom' and '$transactiondateto' and visitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$res2consultationamount = $res1['billamount1'];
			
			/*$query1 = "select sum(billamount) as billamount1 from master_billing where billtype = 'PAY NOW' and locationcode='$location' and  billingdatetime between '$transactiondatefrom' and '$transactiondateto'";
			$exec1 = mysql_query($query1) or die ("Error in query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$res1consultationamount = $res1['billamount1'];
			$query1 = "select sum(billamount) as billamount1 from master_billing where billtype = 'PAY LATER' and locationcode='$location' and  billingdatetime between '$transactiondatefrom' and '$transactiondateto'";
			$exec1 = mysql_query($query1) or die ("Error in query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$res2consultationamount = $res1['billamount1'];*/
		
			?>
		   <?php
		   // this query for pharmacy
		  	  $query8 = "select sum(fxamount) as amount1 from billing_paylaterpharmacy where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res8 = mysqli_fetch_array($exec8);
			$res8pharmacyitemrate = $res8['amount1'];
			
			$query9 = "select sum(fxamount) as amount1 from billing_paynowpharmacy where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res9 = mysqli_fetch_array($exec9);
			$res9pharmacyitemrate = $res9['amount1'];
			
			$query17 = "select sum(amount) as amount1 from billing_externalpharmacy where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query17".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			$res17pharmacyitemrate = $res17['amount1'];
			
			//this query for laboratry
			$query2 = "select sum(fxamount) as labitemrate1 from billing_paylaterlab where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_fetch_array($exec2);
			$res2labitemrate = $res2['labitemrate1'];
			
			$query3 = "select sum(fxamount) as labitemrate1 from billing_paynowlab where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$res3labitemrate = $res3['labitemrate1'];
			
			$query14 = "select sum(labitemrate) as labitemrate1 from billing_externallab where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in query14".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res14 = mysqli_fetch_array($exec14);
			$res14labitemrate = $res14['labitemrate1'];
			
			$totallabitemrate = $res2labitemrate + $res3labitemrate + $res14labitemrate;
			
			?>
		   <?php
			//this query for radiology
			$query4 = "select sum(fxamount) as radiologyitemrate1 from billing_paylaterradiology where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$res4radiologyitemrate = $res4['radiologyitemrate1'];
			
			$query5 = "select sum(fxamount) as radiologyitemrate1 from billing_paynowradiology where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res5 = mysqli_fetch_array($exec5);
			$res5radiologyitemrate = $res5['radiologyitemrate1'];
			
			$query15 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_externalradiology where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res15 = mysqli_fetch_array($exec15);
			$res15radiologyitemrate = $res15['radiologyitemrate1'];
			
			$totalradiologyitemrate = $res4radiologyitemrate + $res5radiologyitemrate + $res15radiologyitemrate;
			
			
			?>
		   
		   <?php
			//this query for service
			$query6 = "select sum(fxamount) as servicesitemrate1 from billing_paylaterservices where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$res6servicesitemrate = $res6['servicesitemrate1'];
			
			$query7 = "select sum(fxamount) as servicesitemrate1 from billing_paynowservices where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res7 = mysqli_fetch_array($exec7);
			$res7servicesitemrate = $res7['servicesitemrate1'];
			
			$query16 = "select sum(servicesitemrate) as servicesitemrate1 from billing_externalservices where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res16 = mysqli_fetch_array($exec16);
			$res16servicesitemrate = $res16['servicesitemrate1'];
			
			$totalservicesitemrate = $res6servicesitemrate + $res7servicesitemrate + $res16servicesitemrate ;
			
			$query10 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res10 = mysqli_fetch_array($exec10);
			$res10referalitemrate = $res10['referalrate1'];
			
			$query11 = "select sum(referalrate) as referalrate1 from billing_paynowreferal where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11 = mysqli_fetch_array($exec11);
			$res11referalitemrate = $res11['referalrate1'];
			
			
			//this query for refund consultation
			
			$query12 = "select sum(consultation) as consultation1 from refund_consultation where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res12 = mysqli_fetch_array($exec12);
			$res12refundconsultation = $res12['consultation1'];
			
			//this query for refund pharmacy
			
			$query21 = "select sum(amount)as amount1 from refund_paylaterpharmacy where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res21 = mysqli_fetch_array($exec21) ;
			$res21refundlabitemrate = $res21['amount1'];
			$query22 = "select sum(amount)as amount1 from refund_paynowpharmacy where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22) ;
			$res22refundlabitemrate = $res22['amount1'];
			$totalrefundpharmacy = $res22refundlabitemrate + $res21refundlabitemrate;
			
			//this query for refund laboratory
			
			$query19 = "select sum(labitemrate)as labitemrate1 from refund_paylaterlab where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query19".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res19 = mysqli_fetch_array($exec19) ;
			$res19refundlabitemrate = $res19['labitemrate1'];
			$query20 = "select sum(labitemrate)as labitemrate1 from refund_paynowlab where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res20 = mysqli_fetch_array($exec20) ;
			$res20refundlabitemrate = $res20['labitemrate1'];
			$totalrefundlab = $res20refundlabitemrate + $res19refundlabitemrate;
			
			//this query for refund radiology
			
			$query22 = "select sum(radiologyitemrate)as radiologyitemrate1 from refund_paylaterradiology where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22) ;
			$res22refundradioitemrate = $res22['radiologyitemrate1'];
			$query23 = "select sum(radiologyitemrate)as radiologyitemrate1 from refund_paynowradiology where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res23 = mysqli_fetch_array($exec23) ;
			$res23refundradioitemrate = $res23['radiologyitemrate1'];
			$totalrefundradio = $res23refundradioitemrate + $res22refundradioitemrate;
			
			//this query for refund service
			
			$query24 = "select sum(amount)as servicesitemrate1 from refund_paylaterservices where locationcode='$location' and billdate between             '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec24= mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res24 = mysqli_fetch_array($exec24) ;
			$res24refundserviceitemrate = $res24['servicesitemrate1'];
			$query25 = "select sum(servicetotal)as servicesitemrate1 from refund_paynowservices where locationcode='$location' and billdate between             '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res25 = mysqli_fetch_array($exec25) ;
			$res25refundserviceitemrate = $res25['servicesitemrate1'];
			$totalrefundservice = $res25refundserviceitemrate + $res24refundserviceitemrate;
			
			//this query for refund referal
			
			$query26 = "select sum(referalrate)as referalrate1 from refund_paylaterreferal where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec26= mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res26 = mysqli_fetch_array($exec26) ;
			$res26refundreferalitemrate = $res26['referalrate1'];
			$query27 = "select sum(referalrate)as referalrate1 from refund_paynowreferal where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res27 = mysqli_fetch_array($exec27) ;
			$res27refundreferalitemrate = $res27['referalrate1'];
			$totalrefundreferal = $res27refundreferalitemrate + $res26refundreferalitemrate;
			
			//this query for home care
		$query28 = "select sum(amount) as amount1 from billing_homecare where locationcode='$location' and recorddate between '$transactiondatefrom' and '$transactiondateto' and visitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec28= mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query28".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res28 = mysqli_fetch_array($exec28) ;
			$res28homecare = $res28['amount1'];
			
			$query29 = "select sum(amount) as amount1 from billing_homecarepaylater where locationcode='$location' and recorddate between '$transactiondatefrom' and '$transactiondateto' and visitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res29 = mysqli_fetch_array($exec29) ;
			$res29homecare = $res29['amount1'];
			$totalhomecare = $res28homecare + $res29homecare;
			
			//this query for rescue
			$query30 = "select sum(amount) as amount1 from billing_opambulance where locationcode='$location' and recorddate between '$transactiondatefrom' and '$transactiondateto' and visitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec30= mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die ("Error in Query30".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res30 = mysqli_fetch_array($exec30) ;
			$res30rescue = $res30['amount1'];
			
			$query31 = "select sum(amount) as amount1 from billing_opambulancepaylater where locationcode='$location' and recorddate between '$transactiondatefrom' and '$transactiondateto' and visitcode in (select visitcode from master_visitentry where department like '$department')";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res31 = mysqli_fetch_array($exec31) ;
			$res31rescue = $res31['amount1'];
			$totalrescue = $res30rescue + $res31rescue;
			
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


			//for case total
			
			$casetotal=$res1consultationamount+$res9pharmacyitemrate+$res3labitemrate+$res5radiologyitemrate+$res7servicesitemrate+$res11referalitemrate+$res30rescue+$res28homecare;
			//for credit total
			$credittotal=$res2consultationamount+$res8pharmacyitemrate+$res2labitemrate+$res4radiologyitemrate+$res6servicesitemrate+$res10referalitemrate+$res31rescue+$res29homecare;
			//for external total
			
			 $externaltotal=$res17pharmacyitemrate+$res14labitemrate+$res15radiologyitemrate+$res16servicesitemrate+$total;
			
			//for refund total
			$refundtotal=$res12refundconsultation+$totalrefundpharmacy+$totalrefundlab+$totalrefundradio+$totalrefundservice+$totalrefundreferal;
			
			$holetotal1=$casetotal+$credittotal+$externaltotal-$refundtotal;
			?>
            
            	<!--VENU cash VALUE DISPLAY-->
                <tr <?php echo $colorcode; ?>>
              	  <td class="bodytext31" valign="center"  align="left"><strong>Cash</strong></td>	
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_cash_consultation.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo number_format($res1consultationamount,2,'.',','); ?></a></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_cash_pharmacy.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo  number_format($res9pharmacyitemrate,2,'.',','); ?></a></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_cash_laboratory.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo number_format($res3labitemrate,2,'.',','); ?></a></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_cash_radiology.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo number_format($res5radiologyitemrate,2,'.',','); ?></a></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_cash_service.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo number_format($res7servicesitemrate,2,'.',','); ?></a></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_cash_referral.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo number_format($res11referalitemrate,2,'.',','); ?></a></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_cash_rescue.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo number_format($res30rescue,2,'.',','); ?></a></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_cash_homecare.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo number_format($res28homecare,2,'.',','); ?></a></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($casetotal,2,'.',','); ?></strong></div></td>
               </tr>
               <!--ENDS-->
             
              <!--VENU -- Credit VALUES DISPLAY-->
              <tr <?php echo $colorcode; ?>>
                   <td class="bodytext31" valign="center"  align="left"><strong>Credit</strong></td>	
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_credit_consultation.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo number_format($res2consultationamount,2,'.',','); ?></a></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_credit_pharmacy.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo number_format($res8pharmacyitemrate,2,'.',','); ?></a></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_credit_laboratory.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo number_format($res2labitemrate,2,'.',','); ?></a></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_credit_radiology.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo number_format($res4radiologyitemrate,2,'.',','); ?></a></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_credit_service.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo number_format($res6servicesitemrate,2,'.',','); ?></a></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_credit_referral.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo number_format($res10referalitemrate,2,'.',','); ?></a></div></td>
                    <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_credit_rescue.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo number_format($res31rescue,2,'.',','); ?></a></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_credit_homecare.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo number_format($res29homecare,2,'.',','); ?></a></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($credittotal,2,'.',','); ?></strong></div></td>
              </tr>
              <!--ENDS-->
             
              <!--VENU External VALUES DISPLAY-->
              
                <!--<tr <?php echo $colorcode; ?>>
                   <td class="bodytext31" valign="center"  align="left"><strong>External</strong></td>
                   <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_external_pharmacy.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>"><?php echo number_format($res17pharmacyitemrate,2,'.',','); ?></a></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_external_laboratory.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>"><?php echo number_format($res14labitemrate,2,'.',','); ?></a></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_external_radiology.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>"><?php echo number_format($res15radiologyitemrate,2,'.',','); ?></a></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_external_service.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>"><?php echo number_format($res16servicesitemrate,2,'.',','); ?></a></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_external_referral.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>"><?php echo number_format($total,2,'.',','); ?></a></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php //echo number_format($totalservicesitemrate,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php //echo number_format($total,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($externaltotal,2,'.',','); ?></strong></div></td>
              </tr>-->
              <!--ENDS-->
             
               <!--VENU Refund VALUES DISPLAY-->
               <tr <?php echo $colorcode; ?>>
            	  <td class="bodytext31" valign="center"  align="left"><strong>Refund</strong></td>
                 <td class="bodytext31" width="30" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_refund_consultation.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo '-'.number_format($res12refundconsultation,2,'.',','); ?></a></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_refund_pharmacy.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo '-'.number_format($totalrefundpharmacy,2,'.',','); ?></a></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_refund_laboratory.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo '-'.number_format($totalrefundlab,2,'.',','); ?></a></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_refund_radiology.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo '-'.number_format($totalrefundradio,2,'.',','); ?></a></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_refund_service.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo '-'.number_format($totalrefundservice,2,'.',','); ?></a></div></td>
				  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_refund_referral.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo '-'.number_format($totalrefundreferal,2,'.',','); ?></a></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php //echo '-'.number_format($totalrefundservice,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php //echo '-'.number_format($totalrefundreferal,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo '-'.number_format($refundtotal,2,'.',','); ?></strong></div></td>
                 </tr>          
               <!--ENDS-->
               
				 <!--VENU TOTAL CALCULATION-->
                <?php
					$tot_consult = $res1consultationamount+$res2consultationamount-$res12refundconsultation;
					$tot_pharmacy = $res9pharmacyitemrate+$res8pharmacyitemrate+$res17pharmacyitemrate-$totalrefundpharmacy;
					$tot_lab = $res3labitemrate+$res2labitemrate+$res14labitemrate-$totalrefundlab;
					$tot_radiol = $res5radiologyitemrate+$res4radiologyitemrate+$res15radiologyitemrate-$totalrefundradio;
					$tot_serv = $res7servicesitemrate+$res6servicesitemrate+$res16servicesitemrate-$totalrefundservice;
					$tot_reffer = $res11referalitemrate+$res10referalitemrate+$total-$totalrefundreferal;
				?>
                <tr <?php echo $colorcode; ?>>
                  <td class="bodytext31" valign="center"  align="left"><strong>Total</strong></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_consult,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_pharmacy,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_lab,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_radiol,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_serv,2,'.',','); ?></strong></div></td>
				  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_reffer,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalrescue,2,'.',','); ?></strong></div></td>
				  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalhomecare,2,'.',','); ?></strong></div></td><td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($holetotal1,2,'.',','); ?></strong></div></td>
                </tr>
		  
    	   <?php
				//$total = $res1consultationamount + $totallabitemrate + $totalradiologyitemrate + $totalservicesitemrate + $totalpharmacyitemrate + $totalreferalitemrate;
		        $nettotal = $nettotal+$total;
		   ?>
				 
			    <?php
				}
				}
			
			?>
		  
          <tr>
				<td colspan="15" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td rowspan="7" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="xl_oprevenuereport_new.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>

              
            </tr>
      
				<?php if($nettotal != 0.00) { ?>
				
			    <?php } ?>
	
          </tbody>
        </table>
       </td>
      </tr>
	  <tr>
	  <td>
	  
	  <!--unfinal-->
	  
	  
	   <tr>
               	<td colspan="7" style="border-color: light-grey;"><br></td>
               </tr>
	  
	  <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" align="left" border="0">
          <tbody>
		  
            <tr>
             <td colspan="13" bgcolor="#ecf0f5" class="bodytext3"><strong>OP unfinalized Revenue &nbsp; From &nbsp;<?php echo date('d-M-Y',strtotime($ADate1)); ?> To <?php echo date('d-M-Y',strtotime($ADate2)); ?></strong></td>
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext31">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					$transactiondatefrom = $_REQUEST['ADate1'];
					$transactiondateto = $_REQUEST['ADate2'];
					if($department == 'All')
					{
					$department = '%%';
					}
				}	
					?> 			
               </td>
              </tr>
              
              <!--VENU CHANGING DESIGN -->
              <?php 
			   if($location!='All')
			   {
			  ?>
              <tr>
              	  <td width="10%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Consultation</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Pharmacy</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Laboratory</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Radiology</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Service</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Referral</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Rescue</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Home Care </strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Total</strong></td>
              </tr>
              <?php
			   }
			  ?>
              <!--ENDS-->
             
            <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					$tot_consult1 = 0.00;
					$tot_pharmacy1 = 0.00;
					$tot_lab1 = 0.00;
					$tot_radiol1 = 0.00;
					$tot_serv1 = 0.00;
					$tot_reffer1 = 0.00;
					$tot_rescue1 = 0.00;
					$tot_homecare1 = 0.00;
					 
					//VENU -- CODE FOR ALL SELECT FOR LOCATION
					if($location == 'All')
					{
						
		
				$query01="select locationcode,locationname from master_employeelocation where username ='$username' group by locationcode order by locationname ";		
				$exec01 = mysqli_query($GLOBALS["___mysqli_ston"], $query01) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			//	$loccode=array();
				while ($res01 = mysqli_fetch_array($exec01))
				{
						$locationname = $res01["locationname"];
						$locationcode = $res01["locationcode"];
		?>
           <tr <?php //echo $colorcode; ?>>
            <!--  <td colspan="3" class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong><?php //echo $locationname; ?></strong></td>-->
               <td  colspan="10" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo $locationname; ?></strong></td>
		   </tr>
        
            <!--TABLE HEADINGS TO DISLAY-->
            <tr>
              	  <td width="10%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Consultation</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Pharmacy</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Laboratory</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Radiology</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Service</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Referral</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Rescue</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Home Care </strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Total</strong></td>
              </tr>
              
              <?php
			  //Get consultancy,pharmacy,lab,radiolgy,ser,refferal records for all locations
			  
			  //this query for consultation
				if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
			$searchsuppliername='';
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				?>
			<?php
			
			//tb opunfinal
	$totalamount1 = '0.00';
$totalamount2 = '0.00';
$totalamount3 = '0.00';
$totalamount4 = '0.00';
$totalamount5 = '0.00';
$totalamount6 = '0.00';
$totalamount7 = '0.00';
$totalamount8 = '0.00';
$totalpharmacysalesreturn  = '0.00';
$overaltotalrefund  = '0.00';
$searchsuppliername='';
$query21 = "select * from master_visitentry where billtype='PAY LATER' and accountfullname like '%$searchsuppliername%' and consultationdate between '$ADate1' and '$ADate2' AND visitcode NOT IN (SELECT visitcode FROM billing_paylater) group by accountfullname order by accountfullname desc";
$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res21 = mysqli_fetch_array($exec21))
{
$res21accountnameano = $res21['accountname'];

$query22 = "select * from master_accountname where auto_number = '$res21accountnameano' and recordstatus <>'DELETED' ";
$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
$res22 = mysqli_fetch_array($exec22);
$res22accountname = $res22['accountname'];
$res21accountname = $res22['accountname'];

if( $res21accountname != '')
{
$res3labitemrate = "0.00";

$query2 = "select * from master_visitentry where billtype='PAY LATER' and accountname = '$res21accountnameano' and consultationdate between '$ADate1' and '$ADate2' AND visitcode NOT IN (SELECT visitcode FROM billing_paylater)  and department like '$department' and locationcode='$locationcode' order by accountfullname desc ";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
$res2patientcode = $res2['patientcode'];
$res2visitcode = $res2['visitcode'];
$res2patientfullname = $res2['patientfullname'];
$res2registrationdate = $res2['consultationdate'];
$res2accountname = $res2['accountfullname'];
$subtype = $res2['subtype'];
$plannumber = $res2['planname'];

$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));
$resplanname = mysqli_fetch_array($execplanname);
$planforall = $resplanname['forall'];
$planpercentage=$res2['planpercentage'];
//$copay=($consultationfee/100)*$planpercentage;


$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$res2patientcode'");
$execlab=mysqli_fetch_array($Querylab);
$patientsubtype=$execlab['subtype'];
$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
$execsubtype=mysqli_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];
$patientsubtypeano=$execsubtype['auto_number'];
$patientplan=$execlab['planname'];
$currency=$execsubtype['currency'];
$fxrate=$execsubtype['fxrate'];
if($currency=='')
{
$currency='UGX';
}
$labtemplate = $execsubtype['labtemplate'];
if($labtemplate == '') { $labtemplate = 'master_lab'; }
$radtemplate = $execsubtype['radtemplate'];
if($radtemplate == '') { $radtemplate = 'master_radiology'; }
$sertemplate = $execsubtype['sertemplate'];
if($sertemplate == '') { $sertemplate = 'master_services'; }

$res3labitemrate = 0;
$query3 = "select labitemcode from consultation_lab where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in query3".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res3 = mysqli_fetch_array($exec3))
{
$labcode = $res3['labitemcode']; 
$queryfx = "select rateperunit from $labtemplate where itemcode = '$labcode'";
$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
$resfx = mysqli_fetch_array($execfx);
$labrate=$resfx['rateperunit'] * $fxrate;
if(($planpercentage!=0.00)&&($planforall=='yes'))
{ 
$labrate = $labrate - ($labrate/100)*$planpercentage;
}
$res3labitemrate = $res3labitemrate + $labrate;
}

$res4servicesitemrate = 0;
$query4 = "select servicesitemcode,serviceqty,refundquantity from consultation_services where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2' ";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res4 = mysqli_fetch_array($exec4))
{
$sercode=$res4['servicesitemcode'];
$serqty=$res4['serviceqty'];
$serrefqty=$res4['refundquantity'];

$serqty = $serqty-$serrefqty;

$queryfx = "select rateperunit from $sertemplate where itemcode = '$sercode'";
$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
$resfx = mysqli_fetch_array($execfx);
$serrate=$resfx['rateperunit'] * $fxrate;
$serrate = $serrate * $serqty;
if(($planpercentage!=0.00)&&($planforall=='yes'))
{ 
$serrate = $serrate - ($serrate/100)*$planpercentage;
}
$res4servicesitemrate = $res4servicesitemrate + $serrate;
}

$res5radiologyitemrate = 0;
$query5 = "select radiologyitemcode from consultation_radiology where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2' ";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res5 = mysqli_fetch_array($exec5))
{
$radcode=$res5['radiologyitemcode'];

$queryfx = "select rateperunit from $radtemplate where itemcode = '$radcode'";
$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
$resfx = mysqli_fetch_array($execfx);
$radrate=$resfx['rateperunit'] * $fxrate;
if(($planpercentage!=0.00)&&($planforall=='yes'))
{ 
$radrate = $radrate - ($radrate/100)*$planpercentage;
}
$res5radiologyitemrate = $res5radiologyitemrate + $radrate;
}

$query6 = "select sum(referalrate) as referalrate1 from consultation_referal where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2' ";
$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
$res6 = mysqli_fetch_array($exec6);
$res6referalrate = $res6['referalrate1'];
if ($res6referalrate =='')
{
$res6referalrate = '0.00';
}
else 
{
$res6referalrate = $res6['referalrate1'] * $fxrate;
}
if(($planpercentage!=0.00)&&($planforall=='yes'))
{ 
$res6referalrate=$res6referalrate - ($res6referalrate/100)*$planpercentage;
}

$query7 = "select sum(consultationfees) as consultationfees1 from master_visitentry where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2'";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
$res7 = mysqli_fetch_array($exec7);
$res7consultationfees = $res7['consultationfees1'] * $fxrate;
if(($planpercentage!=0.00)&&($planforall=='yes'))
{ 
$copay=($res7consultationfees/100)*$planpercentage;
}
else
{
$copay = 0;
}
$res7consultationfees = $res7consultationfees - $copay;

$query8 = "select sum(copayfixedamount) as copayfixedamount1 from master_billing where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2'";
$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
$res8 = mysqli_fetch_array($exec8);
$res8copayfixedamount = $res8['copayfixedamount1'];
$res8copayfixedamount = 0;

$consultation = $res7consultationfees - $res8copayfixedamount;

$query9 = "select sum(totalamount) as totalamount1 from pharmacysales_details where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and entrydate between '$ADate1' and '$ADate2' ";
$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in query9".mysqli_error($GLOBALS["___mysqli_ston"]));
$res9 = mysqli_fetch_array($exec9);
$res9pharmacyrate = $res9['totalamount1'];

if ($res9pharmacyrate == '')
{
$res9pharmacyrate = '0.00';
}
else 
{
$res9pharmacyrate = $res9['totalamount1'];
}

if(($planpercentage!=0.00)&&($planforall=='yes'))
{
$res9pharmacyrate = $res9pharmacyrate - ($res9pharmacyrate/100)*$planpercentage;
}

$query321 = "select sum(totalamount) as totalamount2 from pharmacysalesreturn_details where visitcode='$res2visitcode' and entrydate between '$ADate1' and '$ADate2'";// and ipdocno = '$refno'";//group by itemcode";
$exec321 = mysqli_query($GLOBALS["___mysqli_ston"], $query321) or die ("Error in Query321".mysqli_error($GLOBALS["___mysqli_ston"]));
$numpharmacysalereturn=mysqli_num_rows($exec321);
$totalpharmacysalesreturn=$totalpharmacysalesreturn+$numpharmacysalereturn;
//echo '<br>Total Pharmacy Return '.mysql_num_rows($exec321);
$res321 = mysqli_fetch_array($exec321);

$res9pharmacyreturnrate = $res321['totalamount2'];
if(($planpercentage!=0.00)&&($planforall=='yes'))
{
$res9pharmacyreturnrate = $res9pharmacyreturnrate - ($res9pharmacyreturnrate/100)*$planpercentage;
}
$res9pharmacyrate=$res9pharmacyrate- $res9pharmacyreturnrate;

$query322 = "select sum(totalamount) as totalrefund from refund_paylater where visitcode='$res2visitcode'";// and entrydate between '$ADate1' and '$ADate2'";// and ipdocno = '$refno'";//group by itemcode";
$exec322 = mysqli_query($GLOBALS["___mysqli_ston"], $query322) or die ("Error in Query321".mysqli_error($GLOBALS["___mysqli_ston"]));
$res322 = mysqli_fetch_array($exec322);
$totalrefund = $res322['totalrefund'];

$overaltotalrefund=$overaltotalrefund+$totalrefund;



$totalamount = $res3labitemrate + $res4servicesitemrate + $res5radiologyitemrate + $res6referalrate + $consultation + $res9pharmacyrate + $overaltotalrefund;
$totalamount1 = $totalamount1 + $totalamount;
$totalamount2 = $totalamount2 + $res3labitemrate;
$totalamount3 = $totalamount3 + $res4servicesitemrate;
$totalamount4 = $totalamount4 + $res9pharmacyrate;
$totalamount5 = $totalamount5 + $res5radiologyitemrate;
$totalamount6 = $totalamount6 + $consultation;
$totalamount7 = $totalamount7 + $res6referalrate;
		 // $snocount = $snocount + 1;
		
			
			//echo $cashamount;
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
	
			}
			}
			
			}
			//tb opunfinal end
			
			
			
		
			?>
           
			
             
              <!--VENU -- Credit VALUES DISPLAY-->
              
           <tr <?php echo $colorcode; ?>>
                  <td class="bodytext31" valign="center"  align="left"><strong>Total</strong></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalamount6,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalamount4,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalamount2,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalamount5,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalamount3,2,'.',','); ?></strong></div></td>
				  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalamount7,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalrescue,2,'.',','); ?></strong></div></td>
				  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalhomecare,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalamount1,2,'.',',');  ?></strong></div></td>
                </tr>
    
             
       	    <?php
				}
				?>
		
				<?php
					}
					//VENU -- ALL SELECTION ENDS
					
					
					
		        if($location!='All')
				{
				
				
						
		
			
			  //Get consultancy,pharmacy,lab,radiolgy,ser,refferal records for all locations
			  
			  //this query for consultation
				if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
			$searchsuppliername='';
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				?>
			<?php
				$totalamount1 = '0.00';
$totalamount2 = '0.00';
$totalamount3 = '0.00';
$totalamount4 = '0.00';
$totalamount5 = '0.00';
$totalamount6 = '0.00';
$totalamount7 = '0.00';
$totalamount8 = '0.00';
$totalamount9 = '0.00';

$totalpharmacysalesreturn  = '0.00';
$overaltotalrefund  = '0.00';
$searchsuppliername='';
$query21 = "select * from master_visitentry where billtype='PAY LATER' and accountfullname like '%$searchsuppliername%' and consultationdate between '$ADate1' and '$ADate2' AND visitcode NOT IN (SELECT visitcode FROM billing_paylater) group by accountfullname order by accountfullname desc";
$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res21 = mysqli_fetch_array($exec21))
{
$res21accountnameano = $res21['accountname'];

$query22 = "select * from master_accountname where auto_number = '$res21accountnameano' and recordstatus <>'DELETED' ";
$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
$res22 = mysqli_fetch_array($exec22);
$res22accountname = $res22['accountname'];
$res21accountname = $res22['accountname'];

if( $res21accountname != '')
{
$res3labitemrate = "0.00";

$query2 = "select * from master_visitentry where billtype='PAY LATER' and accountname = '$res21accountnameano' and consultationdate between '$ADate1' and '$ADate2' AND visitcode NOT IN (SELECT visitcode FROM billing_paylater)  and department like '$department' and locationcode='$locationcode' order by accountfullname desc ";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
$res2patientcode = $res2['patientcode'];
$res2visitcode = $res2['visitcode'];
$res2patientfullname = $res2['patientfullname'];
$res2registrationdate = $res2['consultationdate'];
$res2accountname = $res2['accountfullname'];
$subtype = $res2['subtype'];
$plannumber = $res2['planname'];

$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));
$resplanname = mysqli_fetch_array($execplanname);
$planforall = $resplanname['forall'];
$planpercentage=$res2['planpercentage'];
//$copay=($consultationfee/100)*$planpercentage;


$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$res2patientcode'");
$execlab=mysqli_fetch_array($Querylab);
$patientsubtype=$execlab['subtype'];
$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
$execsubtype=mysqli_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];
$patientsubtypeano=$execsubtype['auto_number'];
$patientplan=$execlab['planname'];
$currency=$execsubtype['currency'];
$fxrate=$execsubtype['fxrate'];
if($currency=='')
{
$currency='UGX';
}
$labtemplate = $execsubtype['labtemplate'];
if($labtemplate == '') { $labtemplate = 'master_lab'; }
$radtemplate = $execsubtype['radtemplate'];
if($radtemplate == '') { $radtemplate = 'master_radiology'; }
$sertemplate = $execsubtype['sertemplate'];
if($sertemplate == '') { $sertemplate = 'master_services'; }

$res3labitemrate = 0;
$query3 = "select labitemcode from consultation_lab where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in query3".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res3 = mysqli_fetch_array($exec3))
{
$labcode = $res3['labitemcode']; 
$queryfx = "select rateperunit from $labtemplate where itemcode = '$labcode'";
$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
$resfx = mysqli_fetch_array($execfx);
$labrate=$resfx['rateperunit'] * $fxrate;
if(($planpercentage!=0.00)&&($planforall=='yes'))
{ 
$labrate = $labrate - ($labrate/100)*$planpercentage;
}
$res3labitemrate = $res3labitemrate + $labrate;
}

$res4servicesitemrate = 0;
$query4 = "select servicesitemcode,serviceqty,refundquantity from consultation_services where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2' ";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res4 = mysqli_fetch_array($exec4))
{
$sercode=$res4['servicesitemcode'];
$serqty=$res4['serviceqty'];
$serrefqty=$res4['refundquantity'];

$serqty = $serqty-$serrefqty;

$queryfx = "select rateperunit from $sertemplate where itemcode = '$sercode'";
$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
$resfx = mysqli_fetch_array($execfx);
$serrate=$resfx['rateperunit'] * $fxrate;
$serrate = $serrate * $serqty;
if(($planpercentage!=0.00)&&($planforall=='yes'))
{ 
$serrate = $serrate - ($serrate/100)*$planpercentage;
}
$res4servicesitemrate = $res4servicesitemrate + $serrate;
}

$res5radiologyitemrate = 0;
$query5 = "select radiologyitemcode from consultation_radiology where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2' ";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res5 = mysqli_fetch_array($exec5))
{
$radcode=$res5['radiologyitemcode'];

$queryfx = "select rateperunit from $radtemplate where itemcode = '$radcode'";
$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
$resfx = mysqli_fetch_array($execfx);
$radrate=$resfx['rateperunit'] * $fxrate;
if(($planpercentage!=0.00)&&($planforall=='yes'))
{ 
$radrate = $radrate - ($radrate/100)*$planpercentage;
}
$res5radiologyitemrate = $res5radiologyitemrate + $radrate;
}

$query6 = "select sum(referalrate) as referalrate1 from consultation_referal where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2' ";
$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
$res6 = mysqli_fetch_array($exec6);
$res6referalrate = $res6['referalrate1'];
if ($res6referalrate =='')
{
$res6referalrate = '0.00';
}
else 
{
$res6referalrate = $res6['referalrate1'] * $fxrate;
}
if(($planpercentage!=0.00)&&($planforall=='yes'))
{ 
$res6referalrate=$res6referalrate - ($res6referalrate/100)*$planpercentage;
}

$query7 = "select sum(consultationfees) as consultationfees1 from master_visitentry where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2'";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
$res7 = mysqli_fetch_array($exec7);
$res7consultationfees = $res7['consultationfees1'] * $fxrate;
if(($planpercentage!=0.00)&&($planforall=='yes'))
{ 
$copay=($res7consultationfees/100)*$planpercentage;
}
else
{
$copay = 0;
}
$res7consultationfees = $res7consultationfees - $copay;

$query8 = "select sum(copayfixedamount) as copayfixedamount1 from master_billing where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2'";
$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
$res8 = mysqli_fetch_array($exec8);
$res8copayfixedamount = $res8['copayfixedamount1'];
$res8copayfixedamount = 0;

$consultation = $res7consultationfees - $res8copayfixedamount;

$query9 = "select sum(totalamount) as totalamount1 from pharmacysales_details where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and entrydate between '$ADate1' and '$ADate2' ";
$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in query9".mysqli_error($GLOBALS["___mysqli_ston"]));
$res9 = mysqli_fetch_array($exec9);
$res9pharmacyrate = $res9['totalamount1'];

if ($res9pharmacyrate == '')
{
$res9pharmacyrate = '0.00';
}
else 
{
$res9pharmacyrate = $res9['totalamount1'];
}

if(($planpercentage!=0.00)&&($planforall=='yes'))
{
$res9pharmacyrate = $res9pharmacyrate - ($res9pharmacyrate/100)*$planpercentage;
}

$query321 = "select sum(totalamount) as totalamount2 from pharmacysalesreturn_details where visitcode='$res2visitcode' and entrydate between '$ADate1' and '$ADate2'";// and ipdocno = '$refno'";//group by itemcode";
$exec321 = mysqli_query($GLOBALS["___mysqli_ston"], $query321) or die ("Error in Query321".mysqli_error($GLOBALS["___mysqli_ston"]));
$numpharmacysalereturn=mysqli_num_rows($exec321);
$totalpharmacysalesreturn=$totalpharmacysalesreturn+$numpharmacysalereturn;
//echo '<br>Total Pharmacy Return '.mysql_num_rows($exec321);
$res321 = mysqli_fetch_array($exec321);

$res9pharmacyreturnrate = $res321['totalamount2'];
if(($planpercentage!=0.00)&&($planforall=='yes'))
{
$res9pharmacyreturnrate = $res9pharmacyreturnrate - ($res9pharmacyreturnrate/100)*$planpercentage;
}
$res9pharmacyrate=$res9pharmacyrate- $res9pharmacyreturnrate;

$query322 = "select sum(totalamount) as totalrefund from refund_paylater where visitcode='$res2visitcode'";// and entrydate between '$ADate1' and '$ADate2'";// and ipdocno = '$refno'";//group by itemcode";
$exec322 = mysqli_query($GLOBALS["___mysqli_ston"], $query322) or die ("Error in Query321".mysqli_error($GLOBALS["___mysqli_ston"]));
$res322 = mysqli_fetch_array($exec322);
$totalrefund = $res322['totalrefund'];

$overaltotalrefund=$overaltotalrefund+$totalrefund;



$totalamount = $res3labitemrate + $res4servicesitemrate + $res5radiologyitemrate + $res6referalrate + $consultation + $res9pharmacyrate + $overaltotalrefund;
$totalamount1 = $totalamount1 + $totalamount;
$totalamount2 = $totalamount2 + $res3labitemrate;
$totalamount3 = $totalamount3 + $res4servicesitemrate;
$totalamount4 = $totalamount4 + $res9pharmacyrate;
$totalamount5 = $totalamount5 + $res5radiologyitemrate;
$totalamount6 = $totalamount6 + $consultation;
$totalamount7 = $totalamount7 + $res6referalrate;
		 // $snocount = $snocount + 1;
			
			//echo $cashamount;
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
      
			<?php
			}
			}
			}
			?>
           
			
             
              <!--VENU -- Credit VALUES DISPLAY-->
              
           <tr <?php echo $colorcode; ?>>
                  <td class="bodytext31" valign="center"  align="left"><strong>OP Unfinalized</strong></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_unfinal_consultation.php?cbfrmflag1=cbfrmflag1&&location=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo number_format($totalamount6,2,'.',','); ?></a></div></td>
				    <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_unfinal_pharma.php?cbfrmflag1=cbfrmflag1&&location=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo number_format($totalamount4,2,'.',','); ?></a></div></td>
					  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_unfinal_lab.php?cbfrmflag1=cbfrmflag1&&location=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo number_format($totalamount2,2,'.',','); ?></a></div></td>
					    <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_unfinal_radiology.php?cbfrmflag1=cbfrmflag1&&location=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo number_format($totalamount5,2,'.',','); ?></a></div></td>
						  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_unfinal_services.php?cbfrmflag1=cbfrmflag1&&location=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo number_format($totalamount3,2,'.',','); ?></a></div></td>
						    <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_unfinal_referral.php?cbfrmflag1=cbfrmflag1&&location=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo number_format($totalamount7,2,'.',','); ?></a></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_unfinal_rescue.php?cbfrmflag1=cbfrmflag1&&location=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo number_format($totalamount9,2,'.',','); ?></a></div></td>
				   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><a target="_blank" href="oprevenuereport_unfinal_home.php?cbfrmflag1=cbfrmflag1&&location=<?php echo $location; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&department=<?=$department?>"><?php echo number_format($totalamount8,2,'.',','); ?></a></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalamount1,2,'.',',');  ?></strong></div></td>
                </tr>
    
             
       	  
		
				<?php
					
				
				
				}
				}
				}
			
			?>
		  
        
      
				<?php if($nettotal != 0.00) { ?>
				
			    <?php } ?>
	
          </tbody>
        </table>
		<!--unfinal-->
	  </td>
	  </tr>
    </table>
   </td>
  </tr> 
</table>

<?php include ("includes/footer1.php"); ?>
</body>
</html>

