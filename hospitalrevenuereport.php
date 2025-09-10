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
$paymentreceiveddatefrom = date('Y-m-d');
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
$total = '0.00';
$refexternal = 0;
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
$rowtot1 = 0;
$rowtot2 = 0;
$rowtot3 = 0;
$holetotal1 = 0;

if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';


if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
	//$cbsuppliername = $_REQUEST['cbsuppliername'];
	//$suppliername = $_REQUEST['cbsuppliername'];
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
}
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
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
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none;
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>

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
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
    
       <td width="860">
		<form name="cbform1" method="post" action="hospitalrevenuereport.php">
          <!--TABLE FOR OP/IP REVENUE REPORT -->
           <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
             <tbody>
             <tr bgcolor="#011E6A">
                 <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Hospital Revenue </strong></td>
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
                 <td class="bodytext31" valign="center"  align="left" bgcolor="#FFFFFF"> <strong>Date From</strong> </td>
                 <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" /><img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/></td>
                 <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><strong> Date To</strong> </td>
                 <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                    <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span>
                 </td>
             </tr>
			 <tr>
  			   <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
               <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF">
               	<span class="bodytext3">
			     <select name="location" id="location"  onChange=" ajaxlocationfunction(this.value);" >
                   <option value="All">All</option>
                      	<?php
						 $query01="select locationcode,locationname from master_location where status=''  group by locationcode";
						$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
						while($res01=mysqli_fetch_array($exc01))
						{?>
							<option value="<?= $res01['locationcode'] ?>" <?php if($location==$res01['locationcode']){ echo "selected";} ?>> <?= $res01['locationname'] ?></option>		
						<?php 
						}
						?>
                      </select></span>
               </td>
			   <td width="10%" align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
			 </tr>
			 <tr>
               <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
               <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                 	<input  type="submit" value="Search" name="Submit" />
                    <input name="resetbutton" type="reset" id="resetbutton" value="Reset" />
               </td>
             </tr>
            </tbody>
           </table>
           <!--ENDS OP/IP REVENUE REPORT-->
           </form>		
        </td>
  </tr>
       
  <tr>
      <td>&nbsp;</td>
  </tr>
 
  <tr>
     <td>
        <!-- TABLE FOR OP REVENUE REPORT-->
       
       <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" align="left" border="0">
          <tbody>
		   <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
				?>
            
             
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
				}	
					?> 
                 
               
          
            
			 
          
               
              
              
              
            <!--   <tr <?php echo $colorcode= 'bgcolor="#ecf0f5"';?>>
                   <td class="bodytext31" valign="center"  align="left"><strong>External</strong></td>
                   <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res17pharmacyitemrate,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res14labitemrate,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res15radiologyitemrate,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res16servicesitemrate,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($refexternal,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($externaltotal,2,'.',','); ?></strong></div></td>
             
              </tr> -->
             
                        
		       
          </tbody>
        </table>
     </td>
  </tr>
      
   <tr>  
     <td class="bodytext31" width="30" valign="center"align="left"><strong>&nbsp;</strong></td> 
   </tr>
      
   <tr>
      <td>
         <!--TABLE FOR IP REVENUE REPORT-->
        <table width="auto" id="AutoNumber3" style="BORDER-COLLAPSE: collapse"  bordercolor="#666666" cellspacing="0" cellpadding="4"  align="left" border="0">
          <tbody>
            <tr>
             <td colspan="15" bgcolor="#ecf0f5" class="bodytext3"><strong>Hospital Revenue  &nbsp; From &nbsp;<?php echo date('d-M-Y',strtotime($ADate1)); ?> To <?php echo date('d-M-Y',strtotime($ADate2)); ?> </strong></td>
              <!--<td width="10%" bgcolor="#ecf0f5" class="bodytext31">Ip Renenue</td>-->
              <td colspan="10" bgcolor="#ecf0f5" class="bodytext31">
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
					 //$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
					if($location=='All')
					{
					$pass_location = "locationcode !=''";
					}
					else
					{
					$pass_location = "locationcode ='$location'";
					}	
					
					
					
					
					
					$transactiondatefrom = $_REQUEST['ADate1'];
					$transactiondateto = $_REQUEST['ADate2'];
					$fromdate = $_REQUEST['ADate1'];
					$todate = $_REQUEST['ADate2'];
				}	
					?>
               </td>
            </tr>
            
		    <tr <?php //echo $colorcode; ?> margin='10'>
              <td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"></td>

               <td width=""  align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Consultation</strong></td>
                   <td width="" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Referal</strong></td>
                  <td width="" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Rescue</strong></td>


              <td width=""  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Adm Fee</strong> </div></td>
                  <td width="78"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>IP&nbsp;Package</strong></div></td>
			      <td width="56"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Bed</strong></div></td>
			      <td width="68"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Nursing</strong></div></td>
			      <td width="26"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>RMO</strong></div></td>
  				    <td width="31"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Lab</strong></div></td>
  				    <td width="24"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rad</strong></div></td>
  				    <td width="42"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pharma</strong></div></td>
  				    <td width="49"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Services</strong></div></td>
  				    <td width="63"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Ambulance</strong></div></td>
                     <td width="58"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Homecare</strong></div></td>
			      <td width="43"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pvt Dr</strong></div></td>
				  <td width="78"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Misc&nbsp;Billing</strong></div></td>

				  <td width="78"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Discount</strong></div></td>
				   <td width="78"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rebate</strong></div></td>

                  <td width="78"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Others</strong></div></td>
              <td width="55" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Total</strong></td>
             </tr>
            <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
		      //  if($location!='All')
				//{
$res2consultationamount =0;
$res8pharmacyitemrate  =0;
///////////////////////////////////// FOR OP REVENUE STARTS HERE ////////////////////
					//**CONSULTATION**//
			//CASH
			// $query1 = "select sum(consultation) as billamount1 from billing_consultation where  locationcode='$location' and  billdate between '$transactiondatefrom' and '$transactiondateto'";
			$query1 = "select sum(billamount1) as billamount1 from (
				select sum(consultation) as billamount1 from billing_consultation where  $pass_location and  billdate between '$transactiondatefrom' and '$transactiondateto'  
				UNION ALL
				select sum(totalamount) as billamount1 from billing_paylaterconsultation where $pass_location and  billdate between '$transactiondatefrom' and '$transactiondateto' and accountname = 'CASH - HOSPITAL'
				) as billamount";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$res1consultationamount = $res1['billamount1'];


			
			//CREDIT
			// $query1 = "select sum(fxamount) as billamount1 from billing_paylaterconsultation where locationcode='$location' and  billdate between '$transactiondatefrom' and '$transactiondateto'";
			$query1 = "select SUM(totalamount) AS billamount1 from billing_paylaterconsultation where  $pass_location and  billdate between '$transactiondatefrom' and '$transactiondateto' and accountname != 'CASH - HOSPITAL' and visitcode in (select visitcode from master_visitentry )";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){;
			$res1billamount = $res1['billamount1'];
			$res2consultationamount = $res2consultationamount + $res1billamount;
			}
			 
			
			//REFUND
			// $query12 = "select sum(consultation) as consultation1 from refund_consultation where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			// $exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
			// $res12 = mysql_fetch_array($exec12);
			// $res12refundconsultation = $res12['consultation1'];

			$query12 = "select sum(consultation) as consultation1 from refund_consultation where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";

			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res12 = mysqli_fetch_array($exec12);

			$res12refundconsultation = $res12['consultation1'];



			$query12c = "select sum(fxamount) as consultation1 from refund_paylaterconsultation where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'  ";

			$exec12c = mysqli_query($GLOBALS["___mysqli_ston"], $query12c) or die ("Error in Query12c".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res12c = mysqli_fetch_array($exec12c);

			$res12crefundconsultation = $res12c['consultation1'];



			$query121 = "select sum(consultationfxamount) as consultation1 from billing_patientweivers where $pass_location and entrydate between '$transactiondatefrom' and '$transactiondateto' ";

			$exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die ("Error in Query121".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res121 = mysqli_fetch_array($exec121);

			$res12refundconsultation1 = $res121['consultation1'];



            $res12refundconsultation = $res12refundconsultation + $res12crefundconsultation+$res12refundconsultation1;
			
			//TOTAL CONSULTATION CALCULATION
			$tot_consult = $res1consultationamount + $res2consultationamount - $res12refundconsultation;

			//**ENDS**//
			?>
		   <?php
		  //**PHARMACY**//
		  //CASH
		  // $query9 = "select sum(fxamount) as amount1 from billing_paynowpharmacy where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto'";

		  $query9 = "select sum(amount1) as amount1 from (
		  	select sum(fxamount) as amount1 from billing_paynowpharmacy where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto' 
		  	UNION ALL
		  	select sum(amount) as amount1 from billing_paylaterpharmacy where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto' and accountname = 'CASH - HOSPITAL'

		  	) as amount1";
			$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res9 = mysqli_fetch_array($exec9);
			$res9pharmacyitemrate = $res9['amount1'];

			//CREDIT
			// $query8 = "select sum(fxamount) as amount1 from billing_paylaterpharmacy where locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$query8 = "select SUM(fxamount) AS  amount1 from billing_paylaterpharmacy where  $pass_location and  billdate between '$transactiondatefrom' and '$transactiondateto' and accountname != 'CASH - HOSPITAL' and patientvisitcode in (select visitcode from master_visitentry)";
			$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res8 = mysqli_fetch_array($exec8)){
				$res8pharmacyamount = $res8['amount1'];
				$res8pharmacyitemrate =$res8pharmacyitemrate + $res8pharmacyamount;
			}	 
			
			//EXTERNAL
			$query17 = "select sum(amount) as amount1 from billing_externalpharmacy where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query17".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			$res17pharmacyitemrate = $res17['amount1'];
			
			//REFUND
			$query21 = "select sum(amount)as amount1 from refund_paylaterpharmacy where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";

			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res21 = mysqli_fetch_array($exec21) ;

			$res21refundlabitemrate = $res21['amount1'];

			$query22 = "select sum(amount)as amount1 from refund_paynowpharmacy where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";

			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res22 = mysqli_fetch_array($exec22) ;

			$res22refundlabitemrate = $res22['amount1'];



			$query221 = "select sum(pharmacyfxamount) as amount1 from billing_patientweivers where $pass_location and entrydate between '$transactiondatefrom' and '$transactiondateto'";

			$exec221 = mysqli_query($GLOBALS["___mysqli_ston"], $query221) or die ("Error in Query221".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res221 = mysqli_fetch_array($exec221) ;

			$res22refundlabitemrate1 = $res221['amount1'];



			$query21p = "SELECT SUM(`amount`) as amount1 FROM `paylaterpharmareturns` WHERE $pass_location and billdate between  '$transactiondatefrom' and '$transactiondateto' AND ledgercode <> '' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)";

			$exec21p = mysqli_query($GLOBALS["___mysqli_ston"], $query21p) or die ("Error in Query21p".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res21p = mysqli_fetch_array($exec21p) ;

		    $res21prefundlabitemrate = $res21p['amount1'];



			$totalrefundpharmacy = $res22refundlabitemrate + $res21refundlabitemrate + $res22refundlabitemrate1 + $res21prefundlabitemrate;
			// $totalrefundpharmacy = $res22refundlabitemrate + $res21refundlabitemrate;
			
			//TOTAL PHARMACY CALCULATION
			$tot_pharmacy = $res9pharmacyitemrate + $res8pharmacyitemrate + $res17pharmacyitemrate - $totalrefundpharmacy;
			//**ENDS**//
		?>
        <?php	
			//**LABARATORY**//
			
			//CASH
			$query3 = "select sum(labitemrate1) as labitemrate1 from (

				select sum(fxamount) as labitemrate1 from billing_paynowlab where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'

				UNION ALL

				select sum(labitemrate) as labitemrate1 from billing_paylaterlab where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto' and accountname = 'CASH - HOSPITAL'

				) as labitemrate";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$res3labitemrate = $res3['labitemrate1'];
			
			//CREDIT
			$query2 = "select sum(labitemrate1) as labitemrate1 from (select sum(labitemrate) as labitemrate1 from billing_paylaterlab where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto' and accountname != 'CASH - HOSPITAL') as amount1";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_fetch_array($exec2);
			$res2labitemrate = $res2['labitemrate1'];
			
			//EXTERNAL
			$query14 = "select sum(labitemrate) as labitemrate1 from billing_externallab where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in query14".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res14 = mysqli_fetch_array($exec14);
			$res14labitemrate = $res14['labitemrate1'];
			
			//REFUND
			$query19 = "select sum(labitemrate)as labitemrate1 from refund_paylaterlab where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";

			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query19".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res19 = mysqli_fetch_array($exec19) ;

			$res19refundlabitemrate = $res19['labitemrate1'];

			$query20 = "select sum(labitemrate)as labitemrate1 from refund_paynowlab where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";

			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res20 = mysqli_fetch_array($exec20) ;

			$res20refundlabitemrate = $res20['labitemrate1'];



			$query222 = "select sum(labfxamount) as amount1 from billing_patientweivers where $pass_location and entrydate between '$transactiondatefrom' and '$transactiondateto'";

			$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res222 = mysqli_fetch_array($exec222) ;

			$res20refundlabitemrate1 = $res222['amount1'];



			$totalrefundlab = $res20refundlabitemrate + $res19refundlabitemrate+$res20refundlabitemrate1;
			
			//TOTAL LAB CALCULATION
			$tot_lab = $res3labitemrate + $res2labitemrate + $res14labitemrate - $totalrefundlab;
			
			//**ENDS**//
			?>
		   <?php
			//**RADIOLOGY**//
			
			//CASH
			$query5 = "select sum(radiologyitemrate1) as radiologyitemrate1 from (

				select sum(fxamount) as radiologyitemrate1 from billing_paynowradiology where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'

				UNION ALL

				select sum(radiologyitemrate) as radiologyitemrate1 from billing_paylaterradiology where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto' and accountname = 'CASH - HOSPITAL'

				) as radiologyitemrate";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res5 = mysqli_fetch_array($exec5);
			$res5radiologyitemrate = $res5['radiologyitemrate1'];
			
			//CREDIT
			$query4 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paylaterradiology where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto' and accountname != 'CASH - HOSPITAL'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$res4radiologyitemrate = $res4['radiologyitemrate1'];
			
			//EXTERNAL
			$query15 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_externalradiology where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res15 = mysqli_fetch_array($exec15);
			$res15radiologyitemrate = $res15['radiologyitemrate1'];
			
			//REFUND
			$query22 = "select sum(fxamount)as radiologyitemrate1 from refund_paylaterradiology where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";

			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res22 = mysqli_fetch_array($exec22) ;

			$res22refundradioitemrate = $res22['radiologyitemrate1'];

			$query23 = "select sum(radiologyitemrate)as radiologyitemrate1 from refund_paynowradiology where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";

			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res23 = mysqli_fetch_array($exec23) ;

			$res23refundradioitemrate = $res23['radiologyitemrate1'];



			$query223 = "select sum(radiologyfxamount) as amount1 from billing_patientweivers where $pass_location and entrydate between '$transactiondatefrom' and '$transactiondateto'";

			$exec223 = mysqli_query($GLOBALS["___mysqli_ston"], $query223) or die ("Error in Query223".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res223 = mysqli_fetch_array($exec223) ;

			$res23refundradioitemrate1 = $res223['amount1'];



			$totalrefundradio = $res23refundradioitemrate + $res22refundradioitemrate+$res23refundradioitemrate1;
			
			//TOTAL RADIOLOGY CALCULATION
			$tot_radiol = $res5radiologyitemrate + $res4radiologyitemrate + $res15radiologyitemrate - $totalrefundradio;
			//**ENDS**//
			?>
		   
		   <?php
			//**SERVICES**//
			
			//CASH
			$query7 = "select sum(fxamount) as servicesitemrate1 from billing_paynowservices where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res7 = mysqli_fetch_array($exec7);
			$res7servicesitemrate = $res7['servicesitemrate1'];
			
			//CREDIT
			$query6 = "select sum(fxamount) as servicesitemrate1 from billing_paylaterservices where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$res6servicesitemrate = $res6['servicesitemrate1'];
			
			//EXTERNAL
			$query16 = "select sum(servicesitemrate) as servicesitemrate1 from billing_externalservices where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res16 = mysqli_fetch_array($exec16);
			$res16servicesitemrate = $res16['servicesitemrate1'];
			
			//REFUND
			$query24 = "select sum(fxamount)as servicesitemrate1 from refund_paylaterservices where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";

			$exec24= mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res24 = mysqli_fetch_array($exec24) ;

			$res24refundserviceitemrate = $res24['servicesitemrate1'];

			$query25 = "select sum(servicetotal)as servicesitemrate1 from refund_paynowservices where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";

			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res25 = mysqli_fetch_array($exec25) ;

			$res25refundserviceitemrate = $res25['servicesitemrate1'];



			$query225 = "select sum(servicesfxamount) as amount1 from billing_patientweivers where $pass_location and entrydate between '$transactiondatefrom' and '$transactiondateto'";

			$exec225 = mysqli_query($GLOBALS["___mysqli_ston"], $query225) or die ("Error in Query225".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res225 = mysqli_fetch_array($exec225) ;

			$res25refundserviceitemrate1 = $res225['amount1'];



			$totalrefundservice = $res25refundserviceitemrate + $res24refundserviceitemrate + $res25refundserviceitemrate1;
			
			//TOT SERVICE CALCULATION
			$tot_serv = $res7servicesitemrate + $res6servicesitemrate + $res16servicesitemrate - $totalrefundservice;
			
			//**ENDS**//
			?>
            <?php
			//**REFERALS**//
			
			//CASH
			$query11 = "select sum(referalrate) as referalrate1 from billing_paynowreferal where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11 = mysqli_fetch_array($exec11);
			$res11referalitemrate = $res11['referalrate1'];
			
			//CREDIT
			$query10 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res10 = mysqli_fetch_array($exec10);
			$res10referalitemrate = $res10['referalrate1'];
		
			//REFUNDS
			$query26 = "select sum(referalrate)as referalrate1 from refund_paylaterreferal where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";

			$exec26= mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res26 = mysqli_fetch_array($exec26) ;

			$res26refundreferalitemrate = $res26['referalrate1'];

			$query27 = "select sum(referalrate)as referalrate1 from refund_paynowreferal where $pass_location and billdate between '$transactiondatefrom' and '$transactiondateto'";

			$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res27 = mysqli_fetch_array($exec27) ;

			$res27refundreferalitemrate = $res27['referalrate1'];

			$totalrefundreferal = $res27refundreferalitemrate + $res26refundreferalitemrate;
			//TOTAL REFERAL CALCULATIONS
			$tot_reffer = $res11referalitemrate + $res10referalitemrate + $total - $totalrefundreferal;
			//**ENDS**//
			?>
             <?php
			//**RESCUE**//
			//CASH
			$query30 = "select sum(amount) as amount1 from billing_opambulance where $pass_location and recorddate between '$transactiondatefrom' and '$transactiondateto'";
			$exec30= mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die ("Error in Query30".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res30 = mysqli_fetch_array($exec30) ;
			$res30rescue = $res30['amount1'];
			
			//CREDIT
			$query31 = "select sum(amount) as amount1 from billing_opambulancepaylater where $pass_location and recorddate between '$transactiondatefrom' and '$transactiondateto'";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res31 = mysqli_fetch_array($exec31) ;
			$res31rescue = $res31['amount1'];
			
			//TOTAL RESCUE CALCULATION
			$totalrescue = $res30rescue + $res31rescue;
			
			//**ENDS**//
			?>
            <?php
			//**HOME CARE**//
		    
			//CASH
		     $query28 = "select sum(amount) as amount1 from billing_homecare where $pass_location and recorddate between '$transactiondatefrom' and '$transactiondateto'";
			$exec28= mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query28".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res28 = mysqli_fetch_array($exec28) ;
			$res28homecare = $res28['amount1'];
			
			//CREDIT
			$query29 = "select sum(amount) as amount1 from billing_homecarepaylater where $pass_location and recorddate between '$transactiondatefrom' and '$transactiondateto'";
			$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res29 = mysqli_fetch_array($exec29) ;
			$res29homecare = $res29['amount1'];
			
			//TOTAL HOME CARE CALCULATION
			$totalhomecare = $res28homecare + $res29homecare;
			
			//**ENDS**//
			?>
           
			<?php
		
			
			$snocount = $snocount + 1;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				//$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				//$colorcode = 'bgcolor="#ecf0f5"';
			}
			
			//TOTAL ON REVENUE TYPE
			//for cash total
			$cashtotal = $res1consultationamount + $res9pharmacyitemrate + $res3labitemrate + $res5radiologyitemrate + $res7servicesitemrate + $res11referalitemrate + $res30rescue + $res28homecare;
			
			//for credit total
			$credittotal = $res2consultationamount + $res8pharmacyitemrate + $res2labitemrate + $res4radiologyitemrate + $res6servicesitemrate + $res10referalitemrate + $res31rescue + $res29homecare;
			
			//for external total
			$externaltotal = $res17pharmacyitemrate + $res14labitemrate + $res15radiologyitemrate + $res16servicesitemrate + $refexternal;
			
			//for refund total
			$refundtotal = $res12refundconsultation + $totalrefundpharmacy + $totalrefundlab + $totalrefundradio + $totalrefundservice + $totalrefundreferal;
			
			//grand total of totals
			$holetotal1 = $cashtotal + $credittotal + $externaltotal - $refundtotal;
 ///////////////////////////////////// FOR OP REVENUE ENDS HERE //////////////////////
 ///////////////////////////////////// FOR IP REVENUE STRATS HERE //////////////////////
				
		$admissionamount=0.00;
		$ipdiscountamount = 0.00;
		$totaladmissionamount = 0.00;
		$totallabamount = 0.00;
		$totalpharmacyamount = 0.00;
		$totalradiologyamount = 0.00;
		$totalservicesamount = 0.00;
		//$totalotamount = 0.00;
		$totalambulanceamount = 0.00;
		$totalprivatedoctoramount = 0;
		$totalipbedcharges = 0.00;
		$totalipnursingcharges = 0.00;
		$totaliprmocharges = 0.00;
		$totalipdiscountamount = 0.00;
		$totalipmiscamount = 0.00;
		$totaltransactionamount = 0.00;
		$colorcode = '';
		$transactionamount = 0.00;
		$totalhospitalrevenue = '0.00';
		$totalpackagecharge=0.00;
		$totalhomecareamount=0.00;
		$totalotamount=0.00;
		$totaliprefundamount=0.00;
		$totalnhifamount =0.00;
		
		//VARIABLES FOR -- CREDITNOTE--
		
		
		$bedchgsdiscount=0;
		$labchgsdiscount=0;
		$nursechgsdiscount=0;
		$pharmachgsdiscount=0;
		$radchgsdiscount = 0;
		$rmochgsdiscount = 0;
		$servchgsdiscount = 0;
		
		$totbedchgdisc=0;
		$totlabchgdisc=0;
		$totnursechgdisc=0;
		$totpharmachgdisc=0;
		$totradchgdisc=0;
		$totrmochgdisc=0;
		$totservchgdisc=0;
		
		$brfbedchgsdiscount = 0;
		$brflabchgsdiscount = 0;
		$brfnursechgsdiscount = 0;
		$brfpharmachgsdiscount=0;
		$brfradchgsdiscount=0;
		$brfrmochgsdiscount = 0;
		$brfservchgsdiscount  = 0;
		
		$totbrfbeddisc=0;
		$totbrflabdisc=0;
		$totbrfnursedisc=0;
		$totbrfpharmadisc=0;
		$totbrfraddisc=0;
		$totbrfrmodisc=0;
		$totbrfservdisc=0;
		
		$totcreditnotebedchgs = 0;
		$totcreditnotelabchgs = 0; 
		$totcreditnotenursechgs = 0;
		$totcreditnotepharmachgs = 0; 
		$totcreditnoteradchgs = 0;
		$totcreditnotermochgs = 0;
		$totcreditnoteservchgs = 0;

		$totaliprmocharges1=0;
$totalipdiscamount=0;
$rebate=0;
		
		$totadmn = 0;
		$totpkg = 0;
		$totbed = 0;
		$totnur = 0;
		$totrmo = 0;
		$totlab = 0;
		$totrad = 0;
		$totpha = 0;
		$totser = 0;
		$totamb = 0;
		$tothom = 0;
		$totdr = 0;
		$totmisc = 0;
		$totmisconsul = 0;
		$totothers = 0;
		$totrebate=0;
$totdiscount=0;
		
		
		//QUERY TO GET PATIENT DETAILS TO PASS
	  $query1 = "select  auto_number,patientname,patientcode,visitcode,'billing' as type  from billing_ip where $pass_location and  accountnameano = '47' and billdate between '$fromdate' and '$todate'
		UNION ALL 
	 SELECT auto_number,patientname,patientcode,visitcode,'creditapproved' as type from billing_ipcreditapproved where $pass_location and  accountnameano = '47' and billdate between '$fromdate' and '$todate' group by visitcode  order by auto_number DESC ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		$patientname=$res1['patientname'];
		$patientcode=$res1['patientcode'];
		$visitcode=$res1['visitcode'];
		
	   	
		//VENU -- CHANGE QUERY
		 //$query112 = "select  sum(packagecharge)  from master_ipvisitentry where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and consultationdate between '$fromdate' and '$todate'  ";
		
		//TO GET TOTAL IP PACKAGE CHARGES AMOUNT  
		 // if($res1['type']=='billing') {

				    $query112 = "select sum(amountuhx) as amountuhx from billing_ipbedcharges where $pass_location and  description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and  visitcode='$visitcode'  and recorddate between '$fromdate' and '$todate' 

				  UNION ALL SELECT sum(fxamount) as amountuhx FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and patientvisitcode='$visitcode'";

				// }
// 				else{

//                    $query112 = "select sum(amountuhx) as amountuhx from billing_ipbedcharges where locationcode='$locationcode1' and  description NOT IN  ('Bed Charges','Nursing Charges','Resident Doctor Charges') and  visitcode='$visitcode'  and recorddate between '$fromdate' and '$todate'

// 				   UNION ALL SELECT  sum(fxamount) as amountuhx FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description NOT IN  ('Bed Charges','Nursing Charges','Resident Doctor Charges') and patientvisitcode='$visitcode' ";
// // description NOT IN  ('Bed Charges','Nursing Charges','Resident Doctor Charges')
// 				}		
		  
		$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num112=mysqli_num_rows($exec112);
		$res112 = mysqli_fetch_array($exec112);
		 $packagecharge=$res112['amountuhx'];
		$totalpackagecharge=$totalpackagecharge + $packagecharge; 

		//TO GET TOTAL ADMIN FEE
	     // $query2 = "select  amountuhx  from billing_ipadmissioncharge where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
	      $query2 = "select  amountuhx  from billing_ipadmissioncharge where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode'   and recorddate between '$fromdate' and '$todate'  ";
		 
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num2=mysqli_num_rows($exec2);
		$res2 = mysqli_fetch_array($exec2);				
		$admissionamount=$res2['amountuhx'];
	    $totaladmissionamount=$totaladmissionamount + $admissionamount; 
		
		//TO GET TOTAL LAB AMOUNT
		  $query3 = "select sum(rateuhx) from billing_iplab where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num3=mysqli_num_rows($exec3);
	    $res3 = mysqli_fetch_array($exec3);
		$labamount=$res3['sum(rateuhx)'];
		 $totallabamount=$totallabamount + $labamount;
		
		//TO GET TOTAL RADIOLOGY CHARGES AMOUNT
		  $query4 = "select sum(radiologyitemrateuhx) from billing_ipradiology where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num4=mysqli_num_rows($exec4);
		$res4 = mysqli_fetch_array($exec4);
		$radiologyamount=$res4['sum(radiologyitemrateuhx)'];
	   $totalradiologyamount=$totalradiologyamount + $radiologyamount;

		 //TO GET TOTAL PHARMACY CHARGES AMOUNT
		 $query5 = "select sum(amountuhx) from billing_ippharmacy where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num5=mysqli_num_rows($exec5);
		$res5 = mysqli_fetch_array($exec5);
		$pharmacyamount=$res5['sum(amountuhx)'];
		 $totalpharmacyamount=$totalpharmacyamount + $pharmacyamount;
	
		//TO GET TOTAL SERVICE CHARGES AMOUNT
	    $query6 = "select sum(servicesitemrateuhx), sum(sharingamount) as sharingamount from billing_ipservices where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num6=mysqli_num_rows($exec6);
		$res6 = mysqli_fetch_array($exec6);
		$servicesamount=$res6['sum(servicesitemrateuhx)']-$res6['sharingamount'];
           $totalservicesamount=$totalservicesamount + $servicesamount;
		
		//VENU -- REMOVE OT
		/* $query7 = "select sum(amount) from billing_ipotbilling where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
		$num7=mysql_num_rows($exec7);
		$res7 = mysql_fetch_array($exec7);
		$otamount=$res7['sum(amount)'];
		 $totalotamount=$totalotamount + $otamount;*/
	     
		 //TO GET TOTAL AMBULANCE CHARGES AMOUNT
	     $query8 = "select sum(amountuhx) from billing_ipambulance where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num8=mysqli_num_rows($exec8);
		$res8 = mysqli_fetch_array($exec8);
		$ambulanceamount=$res8['sum(amountuhx)'];
		 $totalambulanceamount=$totalambulanceamount + $ambulanceamount;
		 
		 
		 //TO GET TOTAL HOME CARE CHARGES AMOUNT
		 $query81 = "select sum(amount) from billing_iphomecare where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num81=mysqli_num_rows($exec81);
		$res81 = mysqli_fetch_array($exec81);
		$homecareamount=$res81['sum(amount)'];
		 $totalhomecareamount=$totalhomecareamount + $homecareamount;
		
		//VENU -- CHANGE THE QUERY
		// $query8 = "select sum(amount) from billing_ipprivatedoctor where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		
		//TO GET TOTAL PRIVATE DOCTER CHARGES AMOUNT
		// $query8 = "select sum(amountuhx) from billing_ipprivatedoctor where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and billtype <>'' and recorddate between '$fromdate' and '$todate'  ";
		// $exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
		// $num8=mysql_num_rows($exec8);
		// $res8 = mysql_fetch_array($exec8);
		// $privatedoctoramount=$res8['sum(amountuhx)'];
		// $totalprivatedoctoramount=$totalprivatedoctoramount + $privatedoctoramount;
		$query8              = "select (transactionamount) as transactionamount, (original_amt) as original_amt, visittype, coa from billing_ipprivatedoctor where  patientcode = '$patientcode' and visitcode='$visitcode' and billtype <>'' and recorddate between '$fromdate' and '$todate'  ";
                $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die("Error in Query8" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num8                     = mysqli_num_rows($exec8);
                while($res8 = mysqli_fetch_array($exec8)){
                		if($res8['visittype'] =="IP")
							{
								if($res8['coa'] !="")
								 $privatedoctoramount = $res8['transactionamount'];
								else
								 $privatedoctoramount = $res8['original_amt'];
							}
							else
							{
								$privatedoctoramount = $res8['original_amt'];
							}
			                // $privatedoctoramount      = $res8['sum(transactionamount)'];
			                $totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;
            		}

		
		 //TO GET TOTAL BED CHARGES AMOUNT
		 $query9 = "select sum(amountuhx) from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'bed charges' and recorddate between '$fromdate' and '$todate' ";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $num9=mysqli_num_rows($exec9);
		$res9 = mysqli_fetch_array($exec9);
		$ipbedcharges=$res9['sum(amountuhx)'];
		$totalipbedcharges=$totalipbedcharges + $ipbedcharges;
		
    
		//VENU -- CHANGE THE QUERY
		
		//TO GET TOTAL IP NURSE CHARGES AMOUNT
	   if($res1['type']=='billing') {

		   $query10 = "select sum(amountuhx) as amount  from billing_ipbedcharges where $pass_location and  description='Nursing Charges' and  visitcode='$visitcode'  and recorddate between '$fromdate' and '$todate' 

		  UNION ALL SELECT sum(fxamount) as amount   FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description='Nursing Charges' and patientvisitcode='$visitcode'";

		}
		else{

			$query10 = "select sum(amountuhx) as amount  from billing_ipbedcharges where $pass_location and  description='Nursing Charges' and  visitcode='$visitcode'  and recorddate between '$fromdate' and '$todate' 

		   UNION ALL SELECT sum(fxamount) as amount  FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description='Nursing Charges' and patientvisitcode='$visitcode'  ";
		}
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num10=mysqli_num_rows($exec10);
		$res10 = mysqli_fetch_array($exec10);
		$ipnursingcharges=$res10['amount'];
		$totalipnursingcharges=$totalipnursingcharges + $ipnursingcharges;
		
		//VENU-CHANGING QUERY
		//$query11 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'RMO charges' and recorddate between '$fromdate' and '$todate' ";
		
		//TO GET TOTAL RMO CHARGES AMOUNT
		$query11 = "select sum(amount) from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'RMO Charges' and recorddate between '$fromdate' and '$todate' ";
		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num11=mysqli_num_rows($exec11);
		$res11 = mysqli_fetch_array($exec11);
		$iprmocharges=$res11['sum(amount)'];
		$totaliprmocharges=$totaliprmocharges + $iprmocharges;

		$query111 = "select sum(amount) from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Consultant Fee' and recorddate between '$fromdate' and '$todate' ";

		$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num111=mysqli_num_rows($exec111);

		$res111 = mysqli_fetch_array($exec111);

		$iprmocharges1=$res111['sum(amount)'];

		$totaliprmocharges1=$totaliprmocharges1 + $iprmocharges1;
		$res1consultationamount=$res1consultationamount+$totaliprmocharges1;

		
		//VENU-- REMOVE DEPOSIT AMOUNT
		/*$query13 = "select sum(rate) from ip_discount where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";
		$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
		$num13=mysql_num_rows($exec13);
		$res13 = mysql_fetch_array($exec13);
		$ipdiscountamount=$res13['sum(rate)'];
		
		$totalipdiscountamount=$totalipdiscountamount + $ipdiscountamount;*/
		//ENDS
		
		//VENU -- REMOVE IP REFUND
		/*$query133 = "select sum(amount) from deposit_refund where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
		$exec133 = mysql_query($query133) or die ("Error in Query133".mysql_error());
		$num133=mysql_num_rows($exec133);
		$res133 = mysql_fetch_array($exec133);
		$iprefundamount=$res133['sum(amount)'];
		
		$totaliprefundamount=$totaliprefundamount + $iprefundamount;*/
		//ENDS
		
		//VENU -- REMOVE NHIF
		/*$query1333 = "select sum(nhifclaim) from ip_nhifprocessing where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";
		$exec1333 = mysql_query($query1333) or die ("Error in Query1333".mysql_error());
		$num1333=mysql_num_rows($exec1333);
		$res1333 = mysql_fetch_array($exec1333);
		$nhifamount=$res1333['sum(nhifclaim)'];
		
		$totalnhifamount=$totalnhifamount + $nhifamount;*/
		//ENDS
		
		//TO GET TOTAL IP MISC BILL AMOUNT
		$query14 = "select sum(amount) from billing_ipmiscbilling where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
		$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num14=mysqli_num_rows($exec14);
		$res14 = mysqli_fetch_array($exec14);
		$ipmiscamount=$res14['sum(amount)'];
		$totalipmiscamount=$totalipmiscamount + $ipmiscamount;
		
		
		//TO GET PATIEN NAME, PATIENT REGISTER NUMBER, PATIEN VISIT CODE
		 $query15 = "select patientname,patientcode,visitcode from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
		$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num15=mysqli_num_rows($exec15);
		
		$res15 = mysqli_fetch_array($exec15);
		
		$res15patientname=$res1['patientname'];
		$res15patientcode=$res1['patientcode'];
		$res15visitcode=$res1['visitcode'];

		////// discount
		$query149 = "select sum(-1*rate) as amount from ip_discount where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode'  and consultationdate between '$fromdate' and '$todate' ";

		$exec149 = mysqli_query($GLOBALS["___mysqli_ston"], $query149) or die ("Error in Query149".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num149=mysqli_num_rows($exec149);

		$res149 = mysqli_fetch_array($exec149);

		$ipdiscamount=$res149['amount'];

		$totalipdiscamount=$totalipdiscamount + $ipdiscamount;
		/////////
		//GET REBATE

			
		
		
		
		
		//TO GET TOTAL TRANSACTION AMOUNT
		$query12 = "select transactionamount,docno from master_transactionipdeposit where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and transactiondate between '$fromdate' and '$todate' ";
		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num12=mysqli_num_rows($exec12);
		
		while($res12 = mysqli_fetch_array($exec12))
		{
			 $transactionamount=$res12['transactionamount'];
			 $referencenumber=$res12['docno'];
			 $totaltransactionamount=$totaltransactionamount + $transactionamount;
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
		   <?php 
		     }

		     $query16 = "SELECT sum(1*amount) as rebate FROM `billing_ipnhif` where recorddate between '$fromdate' and '$todate' and accountname = 'CASH - HOSPITAL'";
			$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num16=mysqli_num_rows($exec16);
			$res16 = mysqli_fetch_array($exec16);
			$rebateamount = $res16['rebate'];
			$rebate += $rebateamount;
			// $totrebate += $rebate;

			 $totadmn = $totadmn + $totaladmissionamount;
			$totpkg = $totpkg + $totalpackagecharge;
			$totbed = $totbed + $totalipbedcharges;
			$totnur = $totnur + $totalipnursingcharges;
			$totrmo = $totrmo + $totaliprmocharges;
			$totlab = $totlab + $totallabamount;
			$totrad = $totrad + $totalradiologyamount;
			$totpha = $totpha + $totalpharmacyamount;
			$totser = $totser + $totalservicesamount;
			$totamb = $totamb + $totalambulanceamount;
			$tothom = $tothom + $totalhomecareamount;
			$totdr = $totdr + $totalprivatedoctoramount;
			$totmisc = $totmisc + $totalipmiscamount;
			$totmisconsul = $totmisconsul + $totaliprmocharges1;
			$totrebate = $totrebate + $rebate;
			$totdiscount = $totdiscount + $totalipdiscamount;

			$tot_consult=$tot_consult+$totaliprmocharges1;

			$tot_pharmacy=$tot_pharmacy+$totpha;
			$tot_lab=$tot_lab+$totlab;
			$tot_radiol=$tot_radiol+$totrad;
			$tot_serv=$tot_serv+$totser;
			// $tot_reffer+=$tot_reffer;
			// $totalrescue+=$totalrescue;
			$totalhomecare=$totalhomecare+$tothom;
			 
			
			$rowtot1 = $totaladmissionamount+$totalpackagecharge+$totalipbedcharges+$totalipnursingcharges+$totaliprmocharges+$totallabamount+$totalradiologyamount+
						$totalpharmacyamount+$totalservicesamount+$totalambulanceamount+$totalhomecareamount+$totalprivatedoctoramount+$totalipmiscamount+$cashtotal+$totalipdiscamount+$totaliprmocharges1;

						// +$res9pharmacyitemrate+$res3labitemrate+$res5radiologyitemrate+$res7servicesitemrate+$res28homecare
			 ?>
 
                  <!-- <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php // echo number_format($cashtotal,2,'.',','); ?></strong></div></td> -->
        
			 <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"><div align="center"><strong>Cash</strong></div></td>

               <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res1consultationamount,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res11referalitemrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res30rescue,2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totaladmissionamount,2,'.',','); ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalpackagecharge,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalipbedcharges,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalipnursingcharges,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totaliprmocharges,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format(($totallabamount+$res3labitemrate),2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format(($totalradiologyamount+$res5radiologyitemrate),2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format(($totalpharmacyamount+$res9pharmacyitemrate),2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format(($totalservicesamount+$res7servicesitemrate),2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format($totalambulanceamount,2,'.',','); ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format(($totalhomecareamount+$res28homecare),2,'.',','); ?></div></td>
				   <td class="bodytext31" valign="center"  align="left">
			         <div align="right"><?php echo number_format($totalprivatedoctoramount,2,'.',','); ?></div></td>
				   <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($totalipmiscamount,2,'.',','); ?></div></td>


				   <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($totalipdiscamount,2,'.',','); ?></div></td>
				   <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($rebate,2,'.',','); ?></div></td>


                   <td  align="left" valign="center" class="bodytext31"><div align="right"> <?php echo number_format(0,2,'.',','); ?></div></td>
                   <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($rowtot1,2,'.',','); ?></strong></div></td>
                  </tr>
        <?php
        // exit();
		$admissionamount=0.00;

		$ipdiscountamount = 0.00;

		$totaladmissionamount = 0.00;
		

		$totallabamount = 0.00;

		$totalpharmacyamount = 0.00;

		$totalradiologyamount = 0.00;

		$totalservicesamount = 0.00;

		//$totalotamount = 0.00;

		$totalambulanceamount = 0.00;

		$totalprivatedoctoramount = 0.00;

		$totalipbedcharges = 0.00;

		$totalipnursingcharges = 0.00;

		$totaliprmocharges = 0.00;

		$totaliprmocharges1 = 0.00;

		$totalipdiscountamount = 0.00;

		$totalipmiscamount = 0.00;

		$totalipdiscamount= 0.00;

		$totaltransactionamount = 0.00;

		$colorcode = '';

		$transactionamount = 0.00;

		$totalhospitalrevenue = '0.00';

		$totalpackagecharge=0.00;

		$totalhomecareamount=0.00;

		$totalotamount=0.00;

		$totaliprefundamount=0.00;

		$totalnhifamount =0.00;

		

		//VARIABLES FOR -- CREDITNOTE--

		

		

		$bedchgsdiscount=0;

		$labchgsdiscount=0;

		$nursechgsdiscount=0;

		$pharmachgsdiscount=0;

		$radchgsdiscount = 0;

		$rmochgsdiscount = 0;

		$servchgsdiscount = 0;

		

		$totbedchgdisc=0;

		$totlabchgdisc=0;

		$totnursechgdisc=0;

		$totpharmachgdisc=0;

		$totradchgdisc=0;

		$totrmochgdisc=0;

		$totservchgdisc=0;

		

		$brfbedchgsdiscount = 0;

		$brflabchgsdiscount = 0;

		$brfnursechgsdiscount = 0;

		$brfpharmachgsdiscount=0;

		$brfradchgsdiscount=0;

		$brfrmochgsdiscount = 0;

		$brfservchgsdiscount  = 0;

		$rebate = 0;

		$totrmo1=0;
$totdisc=0;

		$totbrfbeddisc=0;

		$totbrflabdisc=0;

		$totbrfnursedisc=0;

		$totbrfpharmadisc=0;

		$totbrfraddisc=0;

		$totbrfrmodisc=0;

		$totbrfservdisc=0;

		

		$totcreditnotebedchgs = 0;

		$totcreditnotelabchgs = 0; 

		$totcreditnotenursechgs = 0;

		$totcreditnotepharmachgs = 0; 

		$totcreditnoteradchgs = 0;

		$totcreditnotermochgs = 0;

		$totcreditnoteservchgs = 0;

		

		 $totalbrfotherdisc = 0;


	$totaladmissionamount = 0;
$totalpackagecharge = 0;
$totalipbedcharges = 0;
$totalipnursingcharges = 0;
$totaliprmocharges = 0;
$totaliprmocharges1 = 0;
$totallabamount = 0;
$totalradiologyamount = 0;
$totalpharmacyamount = 0;
$totalservicesamount = 0;
$totalambulanceamount = 0;
$totalhomecareamount = 0;
$totalprivatedoctoramount = 0;
$totalipmiscamount = 0;
$totalipdiscamount = 0;	
		
		//QUERY TO GET PATIENT DETAILS TO PASS
	   $query186 = "select  auto_number,patientname,patientcode,visitcode,'billing' as type from billing_ip where $pass_location and billdate between '$fromdate' and '$todate'  and accountnameano != '47' 
	 UNION ALL SELECT auto_number,patientname,patientcode,visitcode,'creditapproved' as type from billing_ipcreditapproved where billdate between '$fromdate' and '$todate' and  $pass_location  and accountnameano != '47'  group by visitcode  order by auto_number DESC ";

		$exec186 = mysqli_query($GLOBALS["___mysqli_ston"], $query186) or die ("Error in Query186".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num186=mysqli_num_rows($exec186);
		while($res186 = mysqli_fetch_array($exec186))

		{ 
		$patientname=$res186['patientname'];

		$patientcode=$res186['patientcode'];

		 $visitcode=$res186['visitcode'];

		

	   	

		//VENU -- CHANGE QUERY

		 //$query112 = "select  sum(packagecharge)  from master_ipvisitentry where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and consultationdate between '$fromdate' and '$todate'  ";

		

		//TO GET TOTAL IP PACKAGE CHARGES AMOUNT  



		//TO GET TOTAL ADMIN FEE
		
	     $query2 = "select  amountuhx  from billing_ipadmissioncharge where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		 

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num2=mysqli_num_rows($exec2);

		$res2 = mysqli_fetch_array($exec2);				

		$admissionamount=$res2['amountuhx'];

	    $totaladmissionamount=$totaladmissionamount + $admissionamount; 

		

		//TO GET TOTAL LAB AMOUNT

		 // $query3 = "select sum(labitemrate) as labitemrate1 from billing_iplab where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'";
		  
		  $query3 = "SELECT SUM(rateuhx) as amountuhx FROM `billing_iplab` WHERE billdate BETWEEN '$fromdate' AND '$todate' and $pass_location and  patientvisitcode ='$visitcode'

		UNION ALL SELECT SUM(fxamount) as amountuhx FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description = 'Lab' and $pass_location and patientvisitcode='$visitcode'";

		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num3=mysqli_num_rows($exec3);

	    $res3 = mysqli_fetch_array($exec3);

		$labamount=$res3['amountuhx'];

		 $totallabamount=$totallabamount + $labamount;

		

		//TO GET TOTAL RADIOLOGY CHARGES AMOUNT

		 /* $query4 = "select sum(radiologyitemrateuhx) from billing_ipradiology where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'		 ";*/
		  
		  $query4 = "SELECT sum(radiologyitemrateuhx) as amountuhx FROM `billing_ipradiology` WHERE billdate BETWEEN '$fromdate' AND '$todate' and patientvisitcode ='$visitcode'
			UNION ALL SELECT sum(fxamount) as amountuhx FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$ADate2' and billtype = 'PAY LATER' and description = 'Radiology' and patientvisitcode='$visitcode'";

		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num4=mysqli_num_rows($exec4);

		$res4 = mysqli_fetch_array($exec4);

		$radiologyamount=$res4['amountuhx'];

	   $totalradiologyamount=$totalradiologyamount + $radiologyamount;



		 //TO GET TOTAL PHARMACY CHARGES AMOUNT

		 $query5 = "select sum(amount) from billing_ippharmacy where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";

		$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num5=mysqli_num_rows($exec5);

		$res5 = mysqli_fetch_array($exec5);

		$pharmacyamount=$res5['sum(amount)'];

		 $totalpharmacyamount=$totalpharmacyamount + $pharmacyamount;

	

		//TO GET TOTAL SERVICE CHARGES AMOUNT

	    //$query6 = "select sum(servicesitemrateuhx) from billing_ipservices where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		
		$query6 = "SELECT SUM(servicesitemrateuhx) as amountuhx,sum(sharingamount) as sharingamount  FROM `billing_ipservices` WHERE $pass_location AND billdate BETWEEN '$fromdate' AND '$todate' and patientvisitcode ='$visitcode'
		UNION ALL SELECT SUM(fxamount) as amountuhx,'' as sharingamount FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description = 'Service' and patientvisitcode='$visitcode'";

		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num6=mysqli_num_rows($exec6);

		$res6 = mysqli_fetch_array($exec6);

		$servicesamount=$res6['amountuhx']-$res6['sharingamount'];

           $totalservicesamount=$totalservicesamount + $servicesamount;

		

		//VENU -- REMOVE OT

		/* $query7 = "select sum(amount) from billing_ipotbilling where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());

		$num7=mysql_num_rows($exec7);

		$res7 = mysql_fetch_array($exec7);

		$otamount=$res7['sum(amount)'];

		 $totalotamount=$totalotamount + $otamount;*/

	     

		 //TO GET TOTAL AMBULANCE CHARGES AMOUNT

	     $query8 = "select sum(amountuhx) from billing_ipambulance where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num8=mysqli_num_rows($exec8);

		$res8 = mysqli_fetch_array($exec8);

		$ambulanceamount=$res8['sum(amountuhx)'];

		 $totalambulanceamount=$totalambulanceamount + $ambulanceamount;

		 

		 

		 //TO GET TOTAL HOME CARE CHARGES AMOUNT

		 $query81 = "select sum(amount) from billing_iphomecare where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num81=mysqli_num_rows($exec81);

		$res81 = mysqli_fetch_array($exec81);

		$homecareamount=$res81['sum(amount)'];

		 $totalhomecareamount=$totalhomecareamount + $homecareamount;

		

		//VENU -- CHANGE THE QUERY

		// $query8 = "select sum(amount) from billing_ipprivatedoctor where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		

		//TO GET TOTAL PRIVATE DOCTER CHARGES AMOUNT

		$query8 = "select (transactionamount) as transactionamount, (original_amt) as original_amt, visittype, coa from billing_ipprivatedoctor where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num8=mysqli_num_rows($exec8);

		// $res8 = mysql_fetch_array($exec8);
		while($res8 = mysqli_fetch_array($exec8)){

				if($res8['visittype'] =="IP")
							{
								if($res8['coa'] !="")
								 $privatedoctoramount = $res8['transactionamount'];
								else
								 $privatedoctoramount = $res8['original_amt'];
							}
							else
							{
								$privatedoctoramount = $res8['original_amt'];
							}
		// $privatedoctoramount=$res8['sum(transactionamount)'];

		$totalprivatedoctoramount=$totalprivatedoctoramount + $privatedoctoramount;
		}

		

		 //TO GET TOTAL BED CHARGES AMOUNT

		 //$query9 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'bed charges' and recorddate between '$fromdate' and '$todate' ";

					 $query9 = "SELECT SUM(amountuhx) AS amount FROM `billing_ipbedcharges` WHERE description = 'Bed Charges' AND recorddate BETWEEN '$fromdate' AND '$todate'   and visitcode='$visitcode'  

					UNION ALL SELECT SUM(fxamount) AS amount  FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description = 'Bed Charges' and patientvisitcode='$visitcode'

					";					
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		 $num9=mysqli_num_rows($exec9);

		$res9 = mysqli_fetch_array($exec9);

		$ipbedcharges=$res9['amount'];

		$totalipbedcharges=$totalipbedcharges + $ipbedcharges;

		

    

		//VENU -- CHANGE THE QUERY

		

		//TO GET TOTAL IP NURSE CHARGES AMOUNT

	    //$query10 = "select sum(amountuhx) as amount from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Nursing Charges' and recorddate between '$fromdate' and '$todate' ";
					if($res186['type']=='billing') {

					   $query10 = "select sum(amountuhx) as amount from billing_ipbedcharges where $pass_location and  description='Nursing Charges' and  visitcode='$visitcode'  and recorddate between '$fromdate' and '$todate' 

					  UNION ALL SELECT sum(fxamount)as amount FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description='Nursing Charges' and patientvisitcode='$visitcode'";

					}
					else{

					    $query10 = "select sum(amountuhx) as amount from billing_ipbedcharges where $pass_location and  description='Nursing Charges' and  visitcode='$visitcode'  and recorddate between '$fromdate' and '$todate' 

					   UNION ALL SELECT sum(fxamount) as amount FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description='Nursing Charges' and patientvisitcode='$visitcode'  ";

					}
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num10=mysqli_num_rows($exec10);

		$res10 = mysqli_fetch_array($exec10);

		$ipnursingcharges=$res10['amount'];

		$totalipnursingcharges=$totalipnursingcharges + $ipnursingcharges;

		

		//VENU-CHANGING QUERY

		//$query11 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'RMO charges' and recorddate between '$fromdate' and '$todate' ";

		

		//TO GET TOTAL RMO CHARGES AMOUNT



		//$query11 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and (description = 'Daily Review charge' or description = 'RMO Charges') and recorddate between '$fromdate' and '$todate' ";
	
		// if($res186['type']=='billing') {

		  $query11 = "SELECT sum(amountuhx) AS amount FROM `billing_ipbedcharges` WHERE (description = 'RMO Charges' or description ='Daily Review charge') AND recorddate BETWEEN '$ADate1' AND '$ADate2' and visitcode='$visitcode'

		  UNION ALL SELECT sum(fxamount) as amount FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description = 'RMO Charges' and patientvisitcode='$visitcode'";

		// }else{

		//    $query11 = "SELECT  sum(amountuhx) AS amount FROM `billing_ipbedcharges` WHERE (description = 'Resident Doctor Charges') AND recorddate BETWEEN '$ADate1' AND '$ADate2'    and visitcode='$visitcode' ";

		// }
		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num11=mysqli_num_rows($exec11);

		$res11 = mysqli_fetch_array($exec11);

		$iprmocharges=$res11['amount'];

		$totaliprmocharges=$totaliprmocharges + $iprmocharges;



		$query111 = "select sum(amountuhx) from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Consultant Fee' and recorddate between '$fromdate' and '$todate' ";
		
		
		

		$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num111=mysqli_num_rows($exec111);

		$res111 = mysqli_fetch_array($exec111);

		$iprmocharges1=$res111['sum(amountuhx)'];

		$totaliprmocharges1=$totaliprmocharges1 + $iprmocharges1;

		

		//VENU-- REMOVE DEPOSIT AMOUNT

		/*$query13 = "select sum(rate) from ip_discount where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";

		$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());

		$num13=mysql_num_rows($exec13);

		$res13 = mysql_fetch_array($exec13);

		$ipdiscountamount=$res13['sum(rate)'];

		

		$totalipdiscountamount=$totalipdiscountamount + $ipdiscountamount;*/

		//ENDS

		

		//VENU -- REMOVE IP REFUND

		$query133 = "select sum(amount) from deposit_refund where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
		$exec133 = mysqli_query($GLOBALS["___mysqli_ston"], $query133) or die ("Error in Query133".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num133=mysqli_num_rows($exec133);
		$res133 = mysqli_fetch_array($exec133);
		$iprefundamount=$res133['sum(amount)'];

		

		$totaliprefundamount=$totaliprefundamount + $iprefundamount;

		//ENDS

		

		//VENU -- REMOVE NHIF

		/*$query1333 = "select sum(nhifclaim) from ip_nhifprocessing where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";

		$exec1333 = mysql_query($query1333) or die ("Error in Query1333".mysql_error());

		$num1333=mysql_num_rows($exec1333);

		$res1333 = mysql_fetch_array($exec1333);

		$nhifamount=$res1333['sum(nhifclaim)'];

		

		$totalnhifamount=$totalnhifamount + $nhifamount;*/

		//ENDS

		

		//TO GET TOTAL IP MISC BILL AMOUNT

		$query14 = "select sum(amountuhx) from billing_ipmiscbilling where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";

		$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num14=mysqli_num_rows($exec14);

		$res14 = mysqli_fetch_array($exec14);

		$ipmiscamount=$res14['sum(amountuhx)'];

		$totalipmiscamount=$totalipmiscamount + $ipmiscamount;


		// ip package
		//$query112 = "select sum(amountuhx) from billing_ipbedcharges where locationcode='$locationcode1' and  description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee')and patientcode = '$patientcode' and visitcode='$visitcode'  and recorddate between '$fromdate' and '$todate' ";
		// if($res186['type']=='billing') {

		  $query112 = "select sum(amountuhx) AS amountuhx from billing_ipbedcharges where $pass_location and  description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and  visitcode='$visitcode'  and recorddate between '$fromdate' and '$todate' 

		  UNION ALL SELECT sum(fxamount)  as amountuhx FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and patientvisitcode='$visitcode'";

		// }else{

		//    $query112 = "select sum(amountuhx) AS amountuhx from billing_ipbedcharges where locationcode='$locationcode1' and  description NOT IN  ('Bed Charges','Nursing Charges','Resident Doctor Charges') and  visitcode='$visitcode'  and recorddate between '$fromdate' and '$todate'

		//    UNION ALL SELECT  sum(fxamount) as amountuhx FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description NOT IN  ('Bed Charges','Nursing Charges','Resident Doctor Charges') and patientvisitcode='$visitcode'

		//    ";

		// }
		  

		$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num112=mysqli_num_rows($exec112);

		$res112 = mysqli_fetch_array($exec112);

		 $packagecharge=$res112['amountuhx'];

		$totalpackagecharge=$totalpackagecharge + $packagecharge;

		

		

		// $query149 = "select sum(-1*rate) as amount from ip_discount where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";

		// $exec149 = mysql_query($query149) or die ("Error in Query149".mysql_error());

		// $num149=mysql_num_rows($exec149);

		// $res149 = mysql_fetch_array($exec149);

		// $ipdiscamount=$res149['amount'];

		// $totalipdiscamount=$totalipdiscamount + $ipdiscamount;

		

		

		//TO GET PATIEN NAME, PATIENT REGISTER NUMBER, PATIEN VISIT CODE

		$query15 = "select patientname,patientcode,visitcode from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";

		$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num15=mysqli_num_rows($exec15);

		

		$res15 = mysqli_fetch_array($exec15);

		

		$res15patientname=$res1['patientname'];

		$res15patientcode=$res1['patientcode'];

		$res15visitcode=$res1['visitcode'];

		

		

		//TO GET TOTAL TRANSACTION AMOUNT

		$query12 = "select transactionamount,docno from master_transactionipdeposit where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and transactiondate between '$fromdate' and '$todate' ";

		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num12=mysqli_num_rows($exec12);

		

		while($res12 = mysqli_fetch_array($exec12))

		{

			 $transactionamount=$res12['transactionamount'];

			 $referencenumber=$res12['docno'];

			 $totaltransactionamount=$totaltransactionamount + $transactionamount;

		} 	

		//GET IP DISCOUNT CREDIT

	//$query149 = "select sum(-1*ip_discount.rate) as amount, A.misreport from ip_discount JOIN (select DISTINCT(accountname), misreport from master_accountname) as A ON A.accountname = ip_discount.accountname where A.misreport != '3' and consultationdate between '$fromdate' and '$todate'";
$chk = "accountnameano != '47'";
 /*$query149 = "SELECT sum(-1*rate) as amount FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `master_transactionip` WHERE $chk and transactiondate BETWEEN '$fromdate' AND '$todate' group by billnumber) and patientvisitcode ='$visitcode'

 UNION ALL SELECT sum(-1*rate) as amount FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE $chk and billdate BETWEEN '$fromdate' AND '$todate' group by billno) and patientvisitcode ='$visitcode'";


		$exec149 = mysql_query($query149) or die ("Error in Query149".mysql_error());

		$num149=mysql_num_rows($exec149);

		$res149 = mysql_fetch_array($exec149);

		$ipdiscamount=$res149['amount'];

		$totalipdiscamount=$totalipdiscamount + $ipdiscamount;		*/
		
		
		
		
		
		
		
		}

		// DISCOUNTT

		$querysearchnew = "select visitcode from billing_ip where billdate between '$fromdate' and '$todate' and accountnameano <> '47'  and  $pass_location  UNION ALL SELECT visitcode from billing_ipcreditapproved where billdate between '$fromdate'  and '$todate' and accountnameano <> '47' and  $pass_location";

		$query12 = "SELECT sum(-1*rate) as discount FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `master_transactionip` WHERE accountnameano != '47' and transactiondate BETWEEN '$fromdate' AND '$todate' group by billnumber) and patientvisitcode IN ($querysearchnew)
			UNION ALL SELECT sum(-1*rate) as discount FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE accountnameano != '47' and billdate BETWEEN '$fromdate' AND '$todate' group by billno) and patientvisitcode IN ($querysearchnew)";
			
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num12=mysqli_num_rows($exec12);

		

		while($res12 = mysqli_fetch_array($exec12))

		{

			 $ipdiscamount=$res12['discount'];

			 

			 $totalipdiscamount=$totalipdiscamount + $ipdiscamount;

		} 	
		//GET IP PACKAGE CHARGE

		// $query112 = "select sum(billing_ipbedcharges.amountuhx) as amount, A.misreport FROM `billing_ipbedcharges` join (SELECT DISTINCT(master_accountname.accountname), master_accountname.misreport FROM master_accountname) AS A on A.accountname = billing_ipbedcharges.accountname where billing_ipbedcharges.description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and A.misreport != '3' and (billing_ipbedcharges.recorddate BETWEEN '$fromdate' and '$todate')";

		// $exec112 = mysql_query($query112) or die ("Error in Query112".mysql_error());

		// $num112=mysql_num_rows($exec112);

		// $res112 = mysql_fetch_array($exec112);

		// $packagecharge=$res112['amount'];

		// $totalpackagecharge=$totalpackagecharge + $packagecharge; 





		

		//GET REBATE

		$query16 = "SELECT sum(1*amount) as rebate FROM `billing_ipnhif` where recorddate between '$fromdate' and '$todate' and accountname != 'CASH - HOSPITAL' and $pass_location";

		$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num16=mysqli_num_rows($exec16);

		$res16 = mysqli_fetch_array($exec16);

		$rebateamount = $res16['rebate'];

		$rebate += $rebateamount;



			// $totadmn = $totadmn + $totaladmissionamount;
			// $totpkg = $totpkg + $totalpackagecharge;
			// $totbed = $totbed + $totalipbedcharges;
			// $totnur = $totnur + $totalipnursingcharges;
			// $totrmo = $totrmo + $totaliprmocharges;
			// $totrmo1 = $totrmo1 + $totaliprmocharges1;
			// $totlab = $totlab + $totallabamount;
			// $totrad = $totrad + $totalradiologyamount;
			// $totpha = $totpha + $totalpharmacyamount;
			// $totser = $totser + $totalservicesamount;
			// $totamb = $totamb + $totalambulanceamount;
			// $tothom = $tothom + $totalhomecareamount;
			// $totdr = $totdr + $totalprivatedoctoramount;
			// $totmisc = $totmisc + $totalipmiscamount;
			// $totdisc = $totdisc + $totalipdiscamount;
			// $totrebate += $rebate;

// 		res2labitemrate
// res4radiologyitemrate
// res8pharmacyitemrate
// res6servicesitemrate
// res29homecare


			$totadmn = $totadmn + $totaladmissionamount;
			$totpkg = $totpkg + $totalpackagecharge;
			$totbed = $totbed + $totalipbedcharges;
			$totnur = $totnur + $totalipnursingcharges;
			$totrmo = $totrmo + $totaliprmocharges;
			$totlab = $totlab + $totallabamount;
			$totrad = $totrad + $totalradiologyamount;
			$totpha = $totpha + $totalpharmacyamount;
			$totser = $totser + $totalservicesamount;
			$totamb = $totamb + $totalambulanceamount;
			$tothom = $tothom + $totalhomecareamount;
			$totdr = $totdr + $totalprivatedoctoramount;
			$totmisc = $totmisc + $totalipmiscamount;
			// $totmisconsul = $totmisconsul + $totaliprmocharges1;
			$totrebate = $totrebate + $rebate;
			$totdiscount = $totdiscount + $totalipdiscamount;

			$tot_consult=$tot_consult+$totaliprmocharges1;

			$tot_pharmacy=$tot_pharmacy+$totalpharmacyamount;
			$tot_lab=$tot_lab+$totallabamount;
			$tot_radiol=$tot_radiol+$totalradiologyamount;
			$tot_serv=$tot_serv+$totalservicesamount;
			// $tot_reffer+=$tot_reffer;
			// $totalrescue+=$totalrescue;
			$totalhomecare=$totalhomecare+$totalhomecareamount;
			

			$rowtot2 = $totaladmissionamount+$totalpackagecharge+$totalipbedcharges+$totalipnursingcharges+$totaliprmocharges+ $totaliprmocharges1+$totallabamount+$totalradiologyamount+

						$totalpharmacyamount+$totalservicesamount+$totalambulanceamount+$totalhomecareamount+$totalprivatedoctoramount+$totalipmiscamount+ $totalipdiscamount+$credittotal;
			
			
			// $rowtot2 = $totaladmissionamount+$totalpackagecharge+$totalipbedcharges+$totalipnursingcharges+$totaliprmocharges+$totallabamount+$totalradiologyamount+ $totalpharmacyamount+$totalservicesamount+$totalambulanceamount+$totalhomecareamount+$totalprivatedoctoramount+$totalipmiscamount+$credittotal;

						$res2consultationamount+=$totaliprmocharges1;
			
		?>


			  <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"><div align="center"><strong>Credit</strong></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res2consultationamount,2,'.',','); ?></div></td>
                    <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res10referalitemrate,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res31rescue,2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totaladmissionamount,2,'.',','); ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalpackagecharge,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalipbedcharges,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalipnursingcharges,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totaliprmocharges,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format(($totallabamount+$res2labitemrate),2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format(($totalradiologyamount+$res4radiologyitemrate),2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format(($totalpharmacyamount+$res8pharmacyitemrate),2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format(($totalservicesamount+$res6servicesitemrate),2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format($totalambulanceamount,2,'.',','); ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format(($totalhomecareamount+$res29homecare),2,'.',','); ?></div></td>
				   <td class="bodytext31" valign="center"  align="left">
			         <div align="right"><?php echo number_format($totalprivatedoctoramount,2,'.',','); ?></div></td>

				  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($totalipmiscamount,2,'.',','); ?></div></td>

				   <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($totalipdiscamount,2,'.',','); ?></div></td>
				    <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($rebate,2,'.',','); ?></div></td>


                  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format(0,2,'.',','); ?></div></td>
                  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($rowtot2,2,'.',','); ?></strong></div></td>
                  </tr>


                  <!-- /////////////// Refunds /////////////// -->
            <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"><div align="center"><strong>Refund</strong></div></td>
              <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format((-1)*$res12refundconsultation,2,'.',','); ?></div></td>
                    <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format((-1)*$totalrefundreferal,2,'.',','); ?></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31">-<?php echo '0.00'; ?></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo '0.00'; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo  '0.00';?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo  '0.00'; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo  '0.00'; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo  '0.00'; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format((-1)*$totalrefundlab,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format((-1)*$totalrefundradio,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format((-1)*$totalrefundpharmacy,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format((-1)*$totalrefundservice,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			        <div align="right">-<?php echo '0.00'; ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
			        <div align="right">-<?php echo '0.00';?></div></td>
				   <td class="bodytext31" valign="center"  align="left">
			         <div align="right">-<?php echo '0.00'; ?></div></td>

				  <td  align="left" valign="center" class="bodytext31"><div align="right">-<?php echo '0.00'; ?></div></td>

				   <td  align="left" valign="center" class="bodytext31"><div align="right">-<?php echo '0.00'; ?></div></td>
				    <td  align="left" valign="center" class="bodytext31"><div align="right">-<?php echo '0.00'; ?></div></td>


                  <td  align="left" valign="center" class="bodytext31"><div align="right">-<?php echo '0.00'; ?></div></td>
                  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format((-1)*$refundtotal,2,'.',','); ?></strong></div></td>
                  </tr>
                  <!-- /////////////// Refunds /////////////// -->
        
          <?php
          //////// Credit Note ???????????????////////////////////////
          $totbrfbeddisc = 0;
		$totbrfnursedisc = 0;
		$totbrfrmodisc = 0;
		 $totbrflabdisc = 0;
		 $totbrfraddisc = 0;
		 $totbrfpharmadisc = 0;
		 $totbrfservdisc = 0;
		 $totalbrfotherdisc = 0;
		 

         $qrycreditbrf = "select patientcode, patientvisitcode,patientname from ip_creditnotebrief where $pass_location and consultationdate between '$fromdate' and '$todate' and patientvisitcode like '%IPV%' group by patientcode ";

		$execcredibrf = mysqli_query($GLOBALS["___mysqli_ston"], $qrycreditbrf) or die ("Error in qrycreditbrf".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescreditbrf = mysqli_fetch_array($execcredibrf))

		{

   			$pcode = $rescreditbrf["patientcode"];

   			$vcode =$rescreditbrf["patientvisitcode"]; 

			$patienname = $rescreditbrf["patientname"];

		  

		  //TO GET DISCOUT FOR BED CHGS -- ip_creditnotebrief

		  $qrybrfbedchgsdisc = "select sum(rate) as brfbedchgsdisc from ip_creditnotebrief where description='Bed Charges'  AND patientcode = '$pcode' AND patientvisitcode = '$vcode'  and $pass_location and consultationdate between '$fromdate' and '$todate'";

		   $execbrfbedchgsdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrfbedchgsdisc) or die ("Error in qrybrfbedchgsdisc".mysqli_error($GLOBALS["___mysqli_ston"]));

		   $rescbrfbedchgsdisc= mysqli_fetch_array($execbrfbedchgsdisc);

		   $brfbedchgsdiscount = $rescbrfbedchgsdisc['brfbedchgsdisc'];

		   $totbrfbeddisc = $totbrfbeddisc + $brfbedchgsdiscount;

		   

		   	//TO GET DISCOUT FOR LAB CHGS -- ip_creditnotebrief

			$qrybrflabchgsdisc = "SELECT sum(rate) AS brflabchgsdisc FROM ip_creditnotebrief WHERE description='Lab'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND $pass_location AND consultationdate BETWEEN '$fromdate' and '$todate'";

			$execbrflabchgsdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrflabchgsdisc) or die ("Error in qrybrflabchgsdisc".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rescbrflabchgsdisc= mysqli_fetch_array($execbrflabchgsdisc);

			$brflabchgsdiscount = $rescbrflabchgsdisc['brflabchgsdisc'];

			$totbrflabdisc = $totbrflabdisc + $brflabchgsdiscount;

			

			//TO GET DISCOUT FOR NURSING CHGS -- ip_creditnotebrief

			$qrybrfnursechgsdisc = "SELECT sum(rate) AS brfnursechgsdisc FROM ip_creditnotebrief WHERE description='Nursing Charges'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND $pass_location AND consultationdate BETWEEN '$fromdate' and '$todate'";

			$execbrfnursechgsdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrfnursechgsdisc) or die ("Error in qrybrfnursechgsdisc".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rescbrfnursechgsdisc= mysqli_fetch_array($execbrfnursechgsdisc);

			$brfnursechgsdiscount = $rescbrfnursechgsdisc['brfnursechgsdisc'];

			$totbrfnursedisc = $totbrfnursedisc + $brfnursechgsdiscount;

			

			//TO GET DISCOUT FOR PHARMACY CHGS  -- ip_creditnotebrief

			$qrybrfpharmachgsdisc = "SELECT sum(rate) AS brfpharmachgsdisc FROM ip_creditnotebrief WHERE description='Pharmacy'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND $pass_location AND consultationdate BETWEEN '$fromdate' and '$todate'";

			$execbrfpharmachgsdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrfpharmachgsdisc) or die ("Error in qrybrfpharmachgsdisc".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rescbrfpharmachgsdisc= mysqli_fetch_array($execbrfpharmachgsdisc);

			$brfpharmachgsdiscount = $rescbrfpharmachgsdisc['brfpharmachgsdisc'];

			$totbrfpharmadisc = $totbrfpharmadisc + $brfpharmachgsdiscount ;

			

			

			//TO GET DISCOUT FOR RADIOLOGY CHGS  -- ip_creditnotebrief

			$qrybrfradchgsdisc = "SELECT sum(rate) AS brfradchgsdisc FROM ip_creditnotebrief WHERE description='Radiology'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND $pass_location AND consultationdate BETWEEN '$fromdate' and '$todate'";

			$execbrfradchgsdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrfradchgsdisc) or die ("Error in qrybrfradchgsdisc".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rescbrfradchgsdisc= mysqli_fetch_array($execbrfradchgsdisc);

			$brfradchgsdiscount = $rescbrfradchgsdisc['brfradchgsdisc'];

				

			$totbrfraddisc = $totbrfraddisc + $brfradchgsdiscount;

			

			//TO GET DISCOUT FOR RMO CHGS -- ip_creditnotebrief

			$qrybrfrmochgsdisc = "SELECT sum(rate) AS brfrmochgsdisc FROM ip_creditnotebrief WHERE description='RMO Charges'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND $pass_location AND consultationdate BETWEEN '$fromdate' and '$todate'";

			$execbrfrmochgsdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrfrmochgsdisc) or die ("Error in qrybrfrmochgsdisc".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rescbrfrmochgsdisc= mysqli_fetch_array($execbrfrmochgsdisc);

			$brfrmochgsdiscount = $rescbrfrmochgsdisc['brfrmochgsdisc'];

				

			$totbrfrmodisc = $totbrfrmodisc + $brfrmochgsdiscount;

			

			//TO GET DISCOUT FOR SERVICEE CHGS-- ip_creditnotebrief

			$qrybrfservchgsdisc = "SELECT sum(rate) AS brfservchgsdisc FROM ip_creditnotebrief WHERE description='Service'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND $pass_location AND consultationdate BETWEEN '$fromdate' and '$todate'";

			$execbrfservchgsdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrfservchgsdisc) or die ("Error in qrybrfservchgsdisc".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rescbrfservchgsdisc= mysqli_fetch_array($execbrfservchgsdisc);

			$brfservchgsdiscount = $rescbrfservchgsdisc['brfservchgsdisc'];

				

			$totbrfservdisc = $totbrfservdisc + $brfservchgsdiscount;

			

			

			//VENU - 04-06-2016

			//GET OTHERS CREDIT NOTE -- brfotherdisc

			$qrybrfotherdisc = "SELECT sum(rate) AS brfotherdisc FROM ip_creditnotebrief WHERE description='Others'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND $pass_location AND consultationdate BETWEEN '$fromdate' and '$todate'";

			$execbrfotherdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrfotherdisc) or die ("Error in qrybrfotherdisc".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rescbrfotherdisc= mysqli_fetch_array($execbrfotherdisc);

			$brfotherdisc = $rescbrfotherdisc['brfotherdisc'];

			

			$totalbrfotherdisc = $totalbrfotherdisc + $brfotherdisc;

			//ends

			

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

         <!--DISPLAY CREDITNOTE DETAILS-->

         

         <!--DISPLAY ENDS-->

				<?php

				}

				


				//$totadmn += $totaladmissionamount;

				//$totpkg += $totalpackagecharge;

				$totbed -= $totbrfbeddisc;

				$totnur -= $totbrfnursedisc;

				$totrmo -= $totbrfrmodisc;

				$totlab -= $totbrflabdisc;

				$totrad -= $totbrfraddisc;

				$totpha -= $totbrfpharmadisc;

				$totser -= $totbrfservdisc;

				//$totamb += $totalambulanceamount;

				//$tothom += $totalhomecareamount;

				//$totdr += $totalprivatedoctoramount;

				//$totmisc += $totalipmiscamount;


			$tot_pharmacy=$tot_pharmacy-$totbrfpharmadisc;
			$tot_lab=$tot_lab-$totbrflabdisc;
			$tot_radiol=$tot_radiol-$totbrfraddisc;
			$tot_serv=$tot_serv-$totbrfservdisc;
			 
			 

				$rowtot3 = $totbrfbeddisc + $totbrfnursedisc + $totbrfrmodisc + $totbrflabdisc + $totbrfraddisc + $totbrfpharmadisc + $totbrfservdisc + $totalbrfotherdisc;
				
          //////// Credit Note ???????????????////////////////////////
          // exit();
				// $totbed -= $totbrfbeddisc;
				// $totnur -= $totbrfnursedisc;
				// $totrmo -= $totbrfrmodisc;
				// $totlab -= ($totbrflabdisc+$totalrefundlab);
				// $totrad -= ($totbrfraddisc+$totalrefundradio);
				// $totpha -= ($totbrfpharmadisc+$totalrefundpharmacy);
				// $totser -= ($totbrfservdisc+$totalrefundservice);
			 
				// $rowtot3 = $totbrfbeddisc + $totbrfnursedisc + $totbrfrmodisc + $totbrflabdisc + $totbrfraddisc + $totbrfpharmadisc + $totbrfservdisc + $totalbrfotherdisc+$refundtotal;
						
				?>

				<tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"><div align="center"><strong>Credit Note</strong></div></td>
              <!-- <td class="bodytext31" valign="center"  align="left"><strong>Refund</strong></td> -->
					<td class="bodytext31"  valign="center"  align="right"><div class="bodytext31"><?php echo '-0.00'; ?></div></td>
					<td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo '-0.00';  ?></div></td>
					<td class="bodytext31" valign="center"  align="right"><div class="bodytext31">0.00</div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format($admissionamount,2,'.',','); ?>0.00</div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format($packagecharge,2,'.',','); ?>0.00</div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo "-".number_format($totbrfbeddisc,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo "-".number_format($totbrfnursedisc,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo "-".number_format($totbrfrmodisc,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo "-".number_format(($totbrflabdisc),2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo "-".number_format(($totbrfraddisc),2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo "-".number_format(($totbrfpharmadisc),2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo "-".number_format(($totbrfservdisc),2,'.',','); ?></div></td>
              
				  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo "-".number_format(0,2,'.',','); //echo number_format($ambulanceamount,2,'.',','); ?></div></td>
                    <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo "-".number_format(0,2,'.',','); //echo number_format($homecareamount,2,'.',','); ?></div></td>
				   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo "-".number_format(0,2,'.',','); //echo number_format($privatedoctoramount,2,'.',','); ?></div></td>
               
				  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format(0,2,'.',','); //echo number_format($ipmiscamount,2,'.',','); ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo "-".number_format(0,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo "-".number_format(0,2,'.',','); ?></div></td>

                   <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo "-".number_format($totalbrfotherdisc,2,'.',',');  ?></div></td>
                  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo '-'.number_format($rowtot3,2,'.',','); ?></strong></div></td>
                  </tr>
				<?php
				//}
				}
				$totothers = $totalbrfotherdisc;
			$rowtot4 = $rowtot1+$rowtot2-$rowtot3-$refundtotal;
			?>

			 
 

			<tr bgcolor="#CCC">
              <td class="bodytext31" valign="center"  align="left"><div align="center"><strong>Total</strong></div></td>
               <td class="bodytext31"  valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_consult,2,'.',','); ?></strong></div></td>
                   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_reffer,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalrescue,2,'.',','); ?></strong></div></td>

			  <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totadmn,2,'.',','); ?></strong></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totpkg,2,'.',','); ?></strong></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totbed,2,'.',','); ?></strong></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totnur,2,'.',','); ?></strong></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totrmo,2,'.',','); ?></strong></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($tot_lab,2,'.',','); ?></strong></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($tot_radiol,2,'.',','); ?></strong></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($tot_pharmacy,2,'.',','); ?></strong></div></td>
				  <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($tot_serv,2,'.',','); ?></strong></div></td>
              
				  <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totamb,2,'.',','); ?></strong></div></td>
                    <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totalhomecare,2,'.',','); ?></strong></div></td>
				   <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totdr,2,'.',','); ?></strong></div></td>
               
				  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($totmisc,2,'.',','); ?></strong></div></td>

				  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($totdiscount,2,'.',','); ?></strong></div></td>
				  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($totrebate,2,'.',','); ?></strong></div></td>


                   <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo "-".number_format($totothers,2,'.',','); ?></strong></div></td>
                  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($rowtot4,2,'.',','); ?></strong></div></td>
                  
                  </tr>
				  <tr><td>&nbsp;</td>
				  </tr>



				 
				<?php } ?>
          </tbody>
        </table>
      </td>
   </tr> 
   
   
    
</table></table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

