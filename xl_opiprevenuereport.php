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

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="op-ip-revenuereport.xls"');
header('Cache-Control: max-age=80');


if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';

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
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>

</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="600" 
            align="left" border="0">
          <tbody>
      	 <tr> <td colspan="6" align="center"><strong><h3>OP-IP REVENUE REPORT</h3></strong></td></tr>
		
		  <tr ><td colspan="6" align="center"><strong>Date From:    <?php echo $ADate1 ?>   To:  <?php echo $ADate2 ?></strong></td></tr>
   
     	 <tr><td></td></tr>
            <tr>
			  <td colspan="3" bgcolor="" class="bodytext31" align="center"><strong>OP Revenue</strong></td>
              <td width="10%"  class="bodytext31">&nbsp;</td>
              <td colspan="3" bgcolor="" class="bodytext31" align="center"><span class="bodytext311"><strong>IP Revenue</strong>
              
 				
              
              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />
&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->
</span></td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="20%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Description </strong></div></td>
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="style1">Amount</td>
				<td width="10%" align="left" valign="center"  
                 class="style1" bgcolor="">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="style1">No.</td>
              <td width="20%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Description</strong></div></td>  
			  <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Amount</strong></div></td>  
            </tr>
			<?php
			
			
		    if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
		  if ($cbfrmflag1 == 'cbfrmflag1')
		  {
			
			$query1 = "select sum(billamount) as billamount1 from master_billing where locationcode='$locationcode1' and billingdatetime between '$ADate1' and '$ADate2'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$res1consultationamount = $res1['billamount1'];
			
			$query2 = "select sum(amount) from billing_ipadmissioncharge where locationcode='$locationcode1' and recorddate between '$ADate1' and '$ADate2' ";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2=mysqli_num_rows($exec2);
			$res2 = mysqli_fetch_array($exec2);
			$totalipadmissionamount =$res2['sum(amount)'];
			
			$query3 = "select sum(packagecharge) as packagecharge from master_ipvisitentry where locationcode='$locationcode1' and consultationdate between '$ADate1' and '$ADate2' ";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num3=mysqli_num_rows($exec3);
			$res3 = mysqli_fetch_array($exec3);
			$totalippackageamount =$res3['packagecharge'];
			
			$query4 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and description='bed charges' and recorddate between '$ADate1' and '$ADate2' ";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num4 = mysqli_num_rows($exec4);
			$res4 = mysqli_fetch_array($exec4);
			$totalbedcharges =$res4['sum(amount)'];
			
			$query41 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and description='RMO charges' and recorddate between '$ADate1' and '$ADate2' ";
			$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num41 = mysqli_num_rows($exec41);
			$res41 = mysqli_fetch_array($exec41);
			$totalrmocharges =$res41['sum(amount)'];
			
			$query42 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and description='Nursing Charges' and recorddate between '$ADate1' and '$ADate2' ";
			$exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num42 = mysqli_num_rows($exec42);
			$res42 = mysqli_fetch_array($exec42);
			$totalnursingcharges =$res42['sum(amount)'];
			
			$totalhospitalrevenue = $totalbedcharges + $totalippackageamount + $totalipadmissionamount + $totalnursingcharges + $totalrmocharges;
			
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
           <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">Consultation</div>              </td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res1consultationamount,2,'.',','); ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left" bgcolor="">&nbsp;
			  </td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $snocount; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="left">Hospital Revenue</div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($totalhospitalrevenue,2,'.',','); ?></div></td>
           </tr>
		      <?php
		  	$query5 = "select sum(amount) as pharmamount from billing_paylaterpharmacy where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res5 = mysqli_fetch_array($exec5);
			$res5lpharmamount = $res5['pharmamount'];
			
			$query6 = "select sum(amount) as pharmamount from billing_paynowpharmacy where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$res6lpharmamount = $res6['pharmamount'];
			
			$query7 = "select sum(amount) as pharmamount from billing_externalpharmacy where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res7 = mysqli_fetch_array($exec7);
			$res7lpharmamount = $res7['pharmamount'];
			
			$totalpharmamount = $res5lpharmamount + $res6lpharmamount + $res7lpharmamount;
			
			$query8 = "select sum(amount) as pharmamount from billing_ippharmacy where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res8 = mysqli_fetch_array($exec8);
			$res8pharmamount= $res8['pharmamount'];
		   ?>
		   <tr bgcolor="">
              <td class="bodytext31" valign="center"  align="left"><?php echo ++$snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">Pharmacy</div>              </td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totalpharmamount,2,'.',','); ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left" bgcolor="">&nbsp;
			  </td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $snocount; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="left">Pharmacy</div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($res8pharmamount,2,'.',','); ?></div></td>
           </tr>
		   <?php
		   $query5 = "select sum(labitemrate) as labitemrate1 from billing_paylaterlab where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res5 = mysqli_fetch_array($exec5);
			$res5labitemrate = $res5['labitemrate1'];
			
			$query6 = "select sum(labitemrate) as labitemrate1 from billing_paynowlab where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$res6labitemrate = $res6['labitemrate1'];
			
			$query7 = "select sum(labitemrate) as labitemrate1 from billing_externallab where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res7 = mysqli_fetch_array($exec7);
			$res7labitemrate = $res7['labitemrate1'];
			 
			$totallabitemrate = $res5labitemrate + $res6labitemrate + $res7labitemrate;
			
			$query8 = "select sum(labitemrate) as labitemrate1 from billing_iplab where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res8 = mysqli_fetch_array($exec8);
			$res8labitemrate = $res8['labitemrate1'];
		   ?>
		   <tr bgcolor="">
              <td class="bodytext31" valign="center"  align="left"><?php echo ++$snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">Laboratory</div>              </td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totallabitemrate,2,'.',','); ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left" bgcolor="">&nbsp;
			  </td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $snocount; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="left">Laboratory</div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($res8labitemrate,2,'.',','); ?></div></td>
           </tr>
		   <?php 
		    $query9 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paylaterradiology  where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in query9".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res9 = mysqli_fetch_array($exec9);
			$res9radiologyitemrate = $res9['radiologyitemrate1'];
			
			$query10 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paynowradiology where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res10 = mysqli_fetch_array($exec10);
			$res10radiologyitemrate = $res10['radiologyitemrate1'];
			
			$query11 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_externalradiology where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11 = mysqli_fetch_array($exec11);
			$res11radiologyitemrate = $res11['radiologyitemrate1'];
			
			$totalradiologyitemrate = $res9radiologyitemrate + $res10radiologyitemrate + $res11radiologyitemrate;
			
			$query12 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_ipradiology where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res12 = mysqli_fetch_array($exec12);
			$res12radiologyitemrate = $res12['radiologyitemrate1'];
		   ?>
		   <tr bgcolor="">
              <td class="bodytext31" valign="center"  align="left"><?php echo ++$snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">Radiology</div>              </td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totalradiologyitemrate,2,'.',','); ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left" bgcolor="">&nbsp;
			  </td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $snocount; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="left">Radiology</div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($res12radiologyitemrate,2,'.',','); ?></div></td>
           </tr>
		   <?php 
		    $query13 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paylaterservices where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in query13".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res13 = mysqli_fetch_array($exec13);
			$res13servicesitemrate = $res13['servicesitemrate1'];
			
			$query14 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paynowservices where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res14 = mysqli_fetch_array($exec14);
			$res14servicesitemrate = $res14['servicesitemrate1'];
			
			$query15 = "select sum(servicesitemrate) as servicesitemrate1 from billing_externalservices where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res15 = mysqli_fetch_array($exec15);
			$res15servicesitemrate = $res15['servicesitemrate1'];
			
			$totalservicesitemrate = $res13servicesitemrate + $res14servicesitemrate + $res15servicesitemrate ;
			
			$query16 = "select sum(servicesitemrate) as servicesitemrate1 from billing_ipservices where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res16 = mysqli_fetch_array($exec16);
			$res16servicesitemrate = $res16['servicesitemrate1'];
		   ?>
		   <tr bgcolor="">
              <td class="bodytext31" valign="center"  align="left"><?php echo ++$snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">Services</div>              </td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totalservicesitemrate,2,'.',','); ?></div>              </td>
              <td class="bodytext31" valign="center"  align="right" bgcolor="">&nbsp;
			  </td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $snocount; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="left">Services</div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($res16servicesitemrate,2,'.',','); ?></div></td>
           </tr>
		   <?php
		
			    $query117 = "select sum(amount) as ambulanceamount from billing_opambulancepaylater where locationcode='$locationcode1' and recorddate between '$ADate1' and '$ADate2'";
			$exec117 = mysqli_query($GLOBALS["___mysqli_ston"], $query117) or die ("Error in query117".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res117 = mysqli_fetch_array($exec117);
			$oplaterambulanceamount = $res117['ambulanceamount'];
			
			$query118 = "select sum(amount) as ambulanceamount from billing_opambulance where locationcode='$locationcode1' and recorddate between '$ADate1' and '$ADate2'";
			$exec118 = mysqli_query($GLOBALS["___mysqli_ston"], $query118) or die ("Error in Query118".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res118 = mysqli_fetch_array($exec118);
			$opambulanceamount = $res118['ambulanceamount'];
			
			
			
			 $query19 = "select sum(amount) as ambulanceamount from billing_ipambulance where locationcode='$locationcode1' and recorddate between '$ADate1' and '$ADate2'";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in query19".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res19 = mysqli_fetch_array($exec19);
			$resipambulance = $res19['ambulanceamount'];
			
			$totalopambulance = $oplaterambulanceamount + $opambulanceamount;
			
			
		   ?>
		   <tr bgcolor="">
              <td class="bodytext31" valign="center"  align="left"><?php echo ++$snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">Ambulance</div>              </td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totalopambulance,2,'.',','); ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left" bgcolor="">&nbsp;
			  </td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $snocount; ?></div></td>
               <td class="bodytext31" valign="center"  align="left" >
			    <div align="left">Ambulance</div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($resipambulance,2,'.',','); ?></div></td>
           </tr>
           
              <?php
		
			    $query117 = "select sum(amount) as homecareamount from billing_homecarepaylater where locationcode='$locationcode1' and recorddate between '$ADate1' and '$ADate2'";
			$exec117 = mysqli_query($GLOBALS["___mysqli_ston"], $query117) or die ("Error in query117".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res117 = mysqli_fetch_array($exec117);
			$oplaterhomecareamount = $res117['homecareamount'];
			
			$query118 = "select sum(amount) as homecareamount from billing_homecare where locationcode='$locationcode1' and recorddate between '$ADate1' and '$ADate2'";
			$exec118 = mysqli_query($GLOBALS["___mysqli_ston"], $query118) or die ("Error in Query118".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res118 = mysqli_fetch_array($exec118);
			$ophomecareamount = $res118['homecareamount'];
			
			
			
			 $query119 = "select sum(amount) as homecareamountip from billing_iphomecare where locationcode='$locationcode1' and recorddate between '$ADate1' and '$ADate2'";
			$exec119 = mysqli_query($GLOBALS["___mysqli_ston"], $query119) or die ("Error in query119".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res119 = mysqli_fetch_array($exec119);
			 $resiphomecare = $res119['homecareamountip'];
			
			$totalophomecare = $oplaterhomecareamount + $ophomecareamount;
			
			
		   ?>
		   <tr bgcolor="">
              <td class="bodytext31" valign="center"  align="left"><?php echo ++$snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">Homecare</div>              </td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totalophomecare,2,'.',','); ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left" bgcolor="">&nbsp;
			  </td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $snocount; ?></div></td>
               <td class="bodytext31" valign="center"  align="left" >
			    <div align="left">Homecare</div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($resiphomecare,2,'.',','); ?></div></td>
           </tr>
           
            <?php
			
			    $query17 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in query17".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			$res17referalitemrate = $res17['referalrate1'];
			
			$query18 = "select sum(referalrate) as referalrate1 from billing_paynowreferal where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res18 = mysqli_fetch_array($exec18);
			$res18referalitemrate = $res18['referalrate1'];
			
			$query12 = "select sum(amount) from billing_ipprivatedoctor where recorddate between '$ADate1' and '$ADate2' and locationcode='$locationcode1' ";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num12=mysqli_num_rows($exec12);
		
	   		$res12 = mysqli_fetch_array($exec12);
		
			$totalipprivatedoctoramount=$res12['sum(amount)'];
		
			
			
	    	$totalreferalitemrate = $res17referalitemrate + $res18referalitemrate;
			
		   ?>
		   <tr bgcolor="">
              <td class="bodytext31" valign="center"  align="left"><?php echo ++$snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">Referal</div>              </td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totalreferalitemrate,2,'.',','); ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left" bgcolor="">&nbsp;
			  </td>
              <td class="bodytext31" valign="center"  align="left" >
			    <div align="left"><?php echo $snocount; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="left">Private Doctor</div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($totalipprivatedoctoramount,2,'.',','); ?></div></td>
           </tr>
            <?php
			
			 $totaloprevenue = $res1consultationamount + $totallabitemrate + $totalradiologyitemrate + $totalservicesitemrate + $totalreferalitemrate + $totalpharmamount + $totalopambulance + $totalophomecare;
		 
			
			$query122 = "select sum(amount) from billing_ipmiscbilling where recorddate between '$ADate1' and '$ADate2' and locationcode='$locationcode1' ";
			$exec122 = mysqli_query($GLOBALS["___mysqli_ston"], $query122) or die ("Error in Query122".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num122=mysqli_num_rows($exec122);
		
	   		$res122 = mysqli_fetch_array($exec122);
		
			$totalipmiscamount=$res122['sum(amount)'];
		   ?>
		   <tr bgcolor="">
        	  <td class="bodytext31" valign="center"  align="left" bgcolor="">&nbsp;</td>
               <td class="bodytext31" valign="center"  align="left" bgcolor="">
                <div class="bodytext31"><strong>Total</strong></div>              </td>
              <td class="bodytext31" valign="center"  align="right" bgcolor="">
                <div class="bodytext31"><strong><?php echo number_format($totaloprevenue,2,'.',','); ?></strong></div>   </td>
                <td class="bodytext31" valign="center"  align="left" bgcolor="">&nbsp;</td>
              <td  class="bodytext31" valign="center"  align="right" >
			    <div align="left"><?php echo  ++$snocount; ?></div></td>
               <td  class="bodytext31" valign="center"  align="right">
			    <div align="left">Misc </div></td>
				<td  class="bodytext31" valign="center"  align="right" >
			    <div align="right"><?php echo number_format($totalipmiscamount,2,'.',','); ?></div></td>
           </tr>
            <?php
			$totalotamount=0;
			$query7 = "select sum(amount) from billing_ipotbilling where locationcode='$locationcode1' and recorddate between '$ADate1' and '$ADate2'  ";
		$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num7=mysqli_num_rows($exec7);
		$res7 = mysqli_fetch_array($exec7);
		$otamount=$res7['sum(amount)'];
		 $totalotamount=$totalotamount + $otamount;
			
			
		   ?>
		   <tr bgcolor="">
         
              <td colspan="4" class="bodytext31" valign="center"  align="left" bgcolor="">
			    <div align="left"></div></td>
                   <td colspan="1" class="bodytext31" valign="center"  align="left" >
			    <div align="left"><?php echo  ++$snocount; ?></div></td>
               <td colspan="1" class="bodytext31" valign="center"  align="right" >
			    <div align="left">OT</div></td>
				<td  class="bodytext31" valign="center"  align="right" >
			    <div align="right"><?php echo number_format($totalotamount,2,'.',','); ?></div></td>
           </tr>
           
            <?php
			$totalnhifamount=0;
			$query72 = "select sum(nhifclaim) from ip_nhifprocessing where locationcode='$locationcode1' and consultationdate between '$ADate1' and '$ADate2'  ";
		$exec72 = mysqli_query($GLOBALS["___mysqli_ston"], $query72) or die ("Error in Query72".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num72=mysqli_num_rows($exec72);
		$res72 = mysqli_fetch_array($exec72);
		$nhifamount=$res72['sum(nhifclaim)'];
		 $totalnhifamount=$totalnhifamount + $nhifamount;
			
			
		   ?>
		   <tr bgcolor="">
         
              <td colspan="4" class="bodytext31" valign="center"  align="left" bgcolor="">
			    <div align="left"></div></td>
                   <td colspan="1" class="bodytext31" valign="center"  align="left" >
			    <div align="left"><?php echo  ++$snocount; ?></div></td>
               <td colspan="1" class="bodytext31" valign="center"  align="right" >
			    <div align="left">NHIF</div></td>
				<td  class="bodytext31" valign="center"  align="right" >
			    <div align="right"><?php echo number_format($totalnhifamount,2,'.',','); ?></div></td>
           </tr>
           
            <?php
			$totalrefundamount=0;
			$query73 = "select sum(amount) from deposit_refund where locationcode='$locationcode1' and recorddate between '$ADate1' and '$ADate2'  ";
		$exec73 = mysqli_query($GLOBALS["___mysqli_ston"], $query73) or die ("Error in Query73".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num73=mysqli_num_rows($exec73);
		$res73 = mysqli_fetch_array($exec73);
		$refundamount=$res73['sum(amount)'];
		 $totalrefundamount=$totalrefundamount + $refundamount;
			
			
		   ?>
		   <tr bgcolor="">
         
              <td colspan="4" class="bodytext31" valign="center"  align="left" bgcolor="">
			    <div align="left"></div></td>
                   <td colspan="1" class="bodytext31" valign="center"  align="left" >
			    <div align="left"><?php echo  ++$snocount; ?></div></td>
               <td colspan="1" class="bodytext31" valign="center"  align="right" >
			    <div align="left">IP Refund</div></td>
				<td class="bodytext31" valign="center"  align="right" >
			    <div align="right"><?php echo number_format(-$totalrefundamount,2,'.',','); ?></div></td>
           </tr>
           
            <?php
			$totaldiscountamount=0;
			$query74 = "select sum(rate) from ip_discount where locationcode='$locationcode1' and consultationdate between '$ADate1' and '$ADate2'  ";
		$exec74 = mysqli_query($GLOBALS["___mysqli_ston"], $query74) or die ("Error in Query74".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num74=mysqli_num_rows($exec74);
		$res74 = mysqli_fetch_array($exec74);
		$discountamount=$res74['sum(rate)'];
		 $totaldiscountamount=$totaldiscountamount + $discountamount;
			
			
		   ?>
		   <tr bgcolor="">
         
              <td colspan="4" class="bodytext31" valign="center"  align="left" bgcolor="">
			    <div align="left"></div></td>
                   <td colspan="1" class="bodytext31" valign="center"  align="left" >
			    <div align="left"><?php echo  ++$snocount; ?></div></td>
               <td colspan="1" class="bodytext31" valign="center"  align="right" >
			    <div align="left">IP Discount</div></td>
				<td  class="bodytext31" valign="center"  align="right" >
			    <div align="right"><?php echo number_format(-$totaldiscountamount,2,'.',','); ?></div></td>
           </tr>
           <?php
			$totaldepositamount=0;
			$query744 = "select sum(transactionamount) from master_transactionipdeposit where locationcode='$locationcode1' and transactiondate between '$ADate1' and '$ADate2'  ";
		$exec744 = mysqli_query($GLOBALS["___mysqli_ston"], $query744) or die ("Error in Query744".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num744=mysqli_num_rows($exec744);
		$res744 = mysqli_fetch_array($exec744);
		$depositamount=$res744['sum(transactionamount)'];
		 $totaldepositamount=$totaldepositamount + $depositamount;
			
			
		   ?>
		   <tr bgcolor="">
         
              <td colspan="4" class="bodytext31" valign="center"  align="left" bgcolor="">
			    <div align="left"></div></td>
                   <td colspan="1" class="bodytext31" valign="center"  align="left" >
			    <div align="left"><?php echo  ++$snocount; ?></div></td>
               <td colspan="1" class="bodytext31" valign="center"  align="right" >
			    <div align="left">Deposit</div></td>
				<td class="bodytext31" valign="center"  align="right" >
			    <div align="right"><?php echo number_format($totaldepositamount,2,'.',','); ?></div></td>
           </tr>
			
		<?php
			$totaliprevenue = $totalhospitalrevenue + $res8pharmamount + $res8labitemrate + $res12radiologyitemrate + $res16servicesitemrate +$resipambulance + $resiphomecare + $totalipprivatedoctoramount + $totalipmiscamount + $totalotamount + $totalnhifamount - $totalrefundamount - $totaldiscountamount + $totaldepositamount;
			  $totalrevenue = $totaliprevenue + $totaloprevenue;
		   if($totalrevenue!=0)
		   {
		   $oppercent = $totaloprevenue / $totalrevenue* 100;
		   $ippercent = $totaliprevenue / $totalrevenue* 100;
		   }
		   else
		   {
		  $oppercent = $totaloprevenue;
		  $ippercent = $totaliprevenue;
		   }
		   ?>
		   <tr bgcolor="">
         
              <td colspan="4" class="bodytext31" valign="center"  align="left" bgcolor="">
			    <div align="left"></div></td>
                   <td colspan="1" class="bodytext31" valign="center"  align="left" bgcolor="">
			    <div align="left"></div></td>
               <td colspan="1" class="bodytext31" valign="center"  align="right" bgcolor="">
			    <div align="left"><strong>Total</strong></div></td>
				<td class="bodytext31" valign="center"  align="right" bgcolor="">
			    <div align="right"><strong><?php echo number_format($totaliprevenue,2,'.',','); ?></strong></div></td>
           </tr>
           
		  
		   
		   <tr>
             
               <td class="bodytext31" valign="center"  align="left" colspan="2">
                <div class="bodytext31"><strong></strong></div>              </td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong>&nbsp;</strong></div>              </td>
              
           </tr>
		   
		   <tr>
             
               <td class="bodytext31" valign="center"  align="left" colspan="2">
                <div class="bodytext31"><strong>Total Revenue</strong></div>              </td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($totalrevenue,2,'.',','); ?></strong></div>              </td>
              
           </tr>
		   <tr>
             
               <td class="bodytext31" valign="center"  align="left" colspan="2">
                <div class="bodytext31"><strong>OP %</strong></div>              </td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($oppercent,2,'.',',').'%'; ?></strong></div>              </td>
              
           </tr>
		    <tr>
             
               <td class="bodytext31" valign="center"  align="left" colspan="2">
                <div class="bodytext31"><strong>IP %</strong></div>              </td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($ippercent,2,'.',',').'%'; ?></strong></div>              </td>
              
           </tr>
			<?php
			
			}
			
			?>
            
          </tbody>
        </table>
</body>
</html>

