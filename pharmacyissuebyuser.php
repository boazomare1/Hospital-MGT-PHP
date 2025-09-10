<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d');
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$res1suppliername = '';
$total1 = '0.00';
$total2 = '0.00';
$total3 = '0.00';
$total4 = '0.00';
$total5 = '0.00';
$total6 = '0.00';
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_customer2.php");


if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"];$paymentreceiveddatefrom = $ADate1; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"];$paymentreceiveddateto = $ADate2; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
include ("autocompletebuild_users.php");

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
..bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/autocomplete_users.js"></script>
<script type="text/javascript" src="js/autosuggestusers.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("cbcustomername"), new StateSuggestions());        
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
		
		
              <form name="cbform1" method="post" action="pharmacyissuebyuser.php">
		<table width="658" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Pharmacy Issue By User</strong></td>
              </tr>
              
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> User </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
                <input name="cbcustomername" type="text" id="cbcustomername" value="" size="50" autocomplete="off">

              </span>
                    </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        &nbsp;</td>
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
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
              <input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag2" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
                  </td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      
	   <?php if($cbfrmflag2 == 'cbfrmflag1'){?>
       
          
          <?php
		  
		  			$cbcustomername=$_REQUEST['cbcustomername'];
			$cbcustomername=trim($cbcustomername);
			if($cbcustomername == '')
			{	
			//echo 'Received';
			 $query1 = "select username from pharmacysales_details where entrydate between '$ADate1' and '$ADate2' group by username order by username";
			 $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while($res1 = mysqli_fetch_array($exec1))
			 {
			 $cbcustomername = $res1['username'];
			   $query7 = "select username from pharmacysales_details where username like '$cbcustomername' and entrydate between '$ADate1' and '$ADate2'"; 
		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $numcount=mysqli_num_rows($exec7);

		  ?>
       <tr>  <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1013" 
            align="left" border="0">
          <tbody>
	        <tr>
              <td colspan='14' bgcolor="#ecf0f5" class="bodytext31"><?php echo 'Total No of Pharmacy Issued by '.$cbcustomername?>(<?php echo $numcount;?>)</td>
            </tr>
            <tr>
              <td width="4%" height="24"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
				
              <td width="18%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>
   				  <td width="10%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg.Code</strong></div></td>
   				  <td width="8%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit.Code</strong></div></td>
   				  <td width="8%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Issued Date</strong></div></td>
				<td width="8%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doc. No</strong></div></td>
   				  <td width="19%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Item Name</strong></div></td>
   				  <td width="7%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Cost Price</strong></div></td>

   				  <td width="7%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sales Price</strong></div></td>

   				  <td width="7%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Quantity</strong></div></td>
   				  <td width="11%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Total Amount</strong></div></td>
   				  <td width="8%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Issued By</strong></div></td>
            </tr>
			
			<?php
			
		      
		
		  		  $query4 = "select * from pharmacysales_details where username like '$cbcustomername' and entrydate between '$ADate1' and '$ADate2'"; 
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $numcount=mysqli_num_rows($exec4);
		  $totalsaleamount='';
		  while($res4 = mysqli_fetch_array($exec4))
			{
				$customerfullname= $res4['patientname'];
				$patientcode= $res4['patientcode'];
				$visitcode= $res4['visitcode'];
				$itemname= $res4['itemname'];
				$rate= $res4['rate'];
				$quantity= $res4['quantity'];
				$totalamount= $res4['totalamount'];
				$registeredby= $res4['username'];
				$registrationdate= $res4['entrydate'];
				 $docnumber= $res4['docnumber'];

				   $itemcode=$res4['itemcode'];
			$querya1 = "select purchaseprice from master_medicine where itemcode='$itemcode' and status=''";
			$execa1 = mysqli_query($GLOBALS["___mysqli_ston"], $querya1) or die ("Error in Querya1".mysqli_error($GLOBALS["___mysqli_ston"]));	
			while($resa1=mysqli_fetch_array($execa1))
			{
				$costrate=$resa1['purchaseprice'];
				//$sales_rate=$resa1['rateperunit'];
			}

				
				$totalsaleamount=$totalsaleamount+$totalamount;
				
				
/*		  $query6 = "select visitcode from master_consultationlist where patientcode = '$patientcode' and registrationdate between '$ADate1' and '$ADate2' auto_number desc"; 
		  $exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		  $numcount=mysql_num_rows($exec6);
		  $res6 = mysql_fetch_array($exec6);
		  $visitcode=$res6['visitcode'];

				//$consultingdoctor= $res4['user'];
				
/*master_consultationlist		  $query5 = "select a.visitcode,a.consultationdate as consultationdate,a.username as visitby,b.visitcode,b.user as triageby,a.visitcode, c.username as pharmacyby from master_visitentry a, master_triage b,pharmacysales_details c where (a.visitcode = '$visitcode') and  (b.visitcode = '$visitcode') and  (c.visitcode = '$visitcode')"; 
	  
  $query5 = "select a.visitcode,a.consultationdate as consultationdate,a.username as visitby,b.visitcode,b.username as consultby,c.visitcode, c.username as pharmacyby,
  d.patientvisitcode, d.username as sampleby,e.patientvisitcode, e.username as serviceby,d.patientvisitcode, d.username as radiologyby from master_visitentry as a  LEFT JOIN master_consultationlist as b ON a.visitcode=b.visitcode LEFT JOIN pharmacysales_details as c  ON a.visitcode=c.visitcode LEFT JOIN samplecollection_lab as d ON a.visitcode=d.patientvisitcode LEFT JOIN consultation_services as e ON a.visitcode=e.patientvisitcode LEFT JOIN consultation_radiology as f ON a.visitcode=f.patientvisitcode where a.visitcode = '$visitcode' "; 
  
  		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
			$res5 = mysql_fetch_array($exec5);	
				$visitdate= $res5['consultationdate'];
				$visitby= $res5['visitby'];
				$consultingdoctor= $res5['consultby'];
				$pharmacyby= $res5['pharmacyby'];
				$sampleby= $res5['sampleby'];
				$serviceby= $res5['serviceby'];
				$radiologyby= $res5['radiologyby'];
*/			
						
				
			
				$snocount=$snocount+1;
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
				<tr <?php echo $colorcode; ?>>
				<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $customerfullname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $visitcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $registrationdate; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $docnumber; ?></div></td>

				<td class="bodytext31" valign="center"  align="left" style="text-transform:uppercase">
				<div class="bodytext31"><?php echo $itemname; ?></div></td>
                
				<td class="bodytext31" valign="center"  align="right">
				<div class="bodytext31"><?php echo number_format($costrate,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="right">
				<div class="bodytext31"><?php echo number_format($rate,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="right">
				<div class="bodytext31"><?php echo intval($quantity); ?></div></td>
				<td class="bodytext31" valign="center"  align="right">
				<div class="bodytext31"><?php echo number_format($totalamount,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left" style="text-transform:uppercase">
				<div class="bodytext31"><?php echo $registeredby; ?></div></td>
                
				</tr>
			<?php
			}
			?>
			
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>


              <td colspan="5" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong>Total</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo $totalsaleamount;?></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>		 
			  
			</tr>
          </tbody>
        </table></td>
		</tr>
		<?php 
			 }
			 }
			 else
			 {
			   $query7 = "select username from pharmacysales_details where username like '$cbcustomername' and entrydate between '$ADate1' and '$ADate2'"; 
		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $numcount=mysqli_num_rows($exec7);

		  ?>
       <tr>  <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1013" 
            align="left" border="0">
          <tbody>
	        <tr>
              <td colspan='14' bgcolor="#ecf0f5" class="bodytext31"><?php echo 'Total No of Pharmacy Issued by '.$cbcustomername?>(<?php echo $numcount;?>)</td>
            </tr>
            <tr>
              <td width="4%" height="24"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
				
              <td width="18%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>
   				  <td width="10%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg.Code</strong></div></td>
   				  <td width="8%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit.Code</strong></div></td>
   				  <td width="8%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Issued Date</strong></div></td>
				<td width="8%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doc. No</strong></div></td>
   				  <td width="19%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Item Name</strong></div></td>
				<td width="7%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Cost Price</strong></div></td>

   				  <td width="7%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sales Price</strong></div></td>
   				  <td width="7%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Quantity</strong></div></td>
   				  <td width="11%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Total Amount</strong></div></td>
   				  <td width="8%"  align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Issued By</strong></div></td>
            </tr>
			
			<?php
			
		      
		
		  		  $query4 = "select * from pharmacysales_details where username like '$cbcustomername' and entrydate between '$ADate1' and '$ADate2'"; 
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $numcount=mysqli_num_rows($exec4);
		  $totalsaleamount='';
		  while($res4 = mysqli_fetch_array($exec4))
			{
				$customerfullname= $res4['patientname'];
				$patientcode= $res4['patientcode'];
				$visitcode= $res4['visitcode'];
				$itemname= $res4['itemname'];
				$rate= $res4['rate'];
				$quantity= $res4['quantity'];
				$totalamount= $res4['totalamount'];
				$registeredby= $res4['username'];
				$registrationdate= $res4['entrydate'];
				$docnumber= $res4['docnumber'];
            $itemcode=$res4['itemcode'];
			$querya1 = "select purchaseprice from master_medicine where itemcode='$itemcode' and status=''";
			$execa1 = mysqli_query($GLOBALS["___mysqli_ston"], $querya1) or die ("Error in Querya1".mysqli_error($GLOBALS["___mysqli_ston"]));	
			while($resa1=mysqli_fetch_array($execa1))
			{
				$costrate=$resa1['purchaseprice'];
				//$sales_rate=$resa1['rateperunit'];
			}



						
				
				$totalsaleamount=$totalsaleamount+$totalamount;
				
				
/*		  $query6 = "select visitcode from master_consultationlist where patientcode = '$patientcode' and registrationdate between '$ADate1' and '$ADate2' auto_number desc"; 
		  $exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		  $numcount=mysql_num_rows($exec6);
		  $res6 = mysql_fetch_array($exec6);
		  $visitcode=$res6['visitcode'];

				//$consultingdoctor= $res4['user'];
				
/*master_consultationlist		  $query5 = "select a.visitcode,a.consultationdate as consultationdate,a.username as visitby,b.visitcode,b.user as triageby,a.visitcode, c.username as pharmacyby from master_visitentry a, master_triage b,pharmacysales_details c where (a.visitcode = '$visitcode') and  (b.visitcode = '$visitcode') and  (c.visitcode = '$visitcode')"; 
	  
  $query5 = "select a.visitcode,a.consultationdate as consultationdate,a.username as visitby,b.visitcode,b.username as consultby,c.visitcode, c.username as pharmacyby,
  d.patientvisitcode, d.username as sampleby,e.patientvisitcode, e.username as serviceby,d.patientvisitcode, d.username as radiologyby from master_visitentry as a  LEFT JOIN master_consultationlist as b ON a.visitcode=b.visitcode LEFT JOIN pharmacysales_details as c  ON a.visitcode=c.visitcode LEFT JOIN samplecollection_lab as d ON a.visitcode=d.patientvisitcode LEFT JOIN consultation_services as e ON a.visitcode=e.patientvisitcode LEFT JOIN consultation_radiology as f ON a.visitcode=f.patientvisitcode where a.visitcode = '$visitcode' "; 
  
  		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
			$res5 = mysql_fetch_array($exec5);	
				$visitdate= $res5['consultationdate'];
				$visitby= $res5['visitby'];
				$consultingdoctor= $res5['consultby'];
				$pharmacyby= $res5['pharmacyby'];
				$sampleby= $res5['sampleby'];
				$serviceby= $res5['serviceby'];
				$radiologyby= $res5['radiologyby'];
*/			
						
				
			
				$snocount=$snocount+1;
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
				<tr <?php echo $colorcode; ?>>
				<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $customerfullname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $visitcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $registrationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo $docnumber; ?></div></td>

				<td class="bodytext31" valign="center"  align="left" style="text-transform:uppercase">
				<div class="bodytext31"><?php echo $itemname; ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
				<div class="bodytext31"><?php echo number_format($costrate,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="right">
				<div class="bodytext31"><?php echo number_format($rate,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="right">
				<div class="bodytext31"><?php echo intval($quantity); ?></div></td>
				<td class="bodytext31" valign="center"  align="right">
				<div class="bodytext31"><?php echo number_format($totalamount,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left" style="text-transform:uppercase">
				<div class="bodytext31"><?php echo $registeredby; ?></div></td>
                
				</tr>
			<?php
			}
			?>
			
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td colspan="5" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>


              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong>Total</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><?php echo $totalsaleamount;?></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>		 
			  
			</tr>
          </tbody>
        </table></td>
		</tr>
		<?php 
			 }
		  		}?>
      
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
