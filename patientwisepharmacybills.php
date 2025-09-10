<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$numip='0';
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$patientcount='';
$num55='0';
$num44='0';
$num31='0';
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
if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }
if (isset($_REQUEST["searchvisitcode"])) { $searchvisitcode = $_REQUEST["searchvisitcode"]; } else { $searchvisitcode = ""; }
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
$patienttype=isset($_REQUEST['patienttype'])?$_REQUEST['patienttype']:'';
//echo $amount;
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
<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/autocomplete_patientstatus.js"></script>
<script type="text/javascript" src="js/autosuggestpatientstatus1.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
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
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>
<script>
function check()
{
var paymenttype=document.getElementById("patienttype").value;
if(paymenttype =='')
{
	alert("Please Select The Patient Type");
	return false;
}
}
</script>
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
		
		
              <form name="cbform1" method="post" action="patientwisepharmacybills.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Patient Wise Pharmacy Bills</strong></td>
              </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Patient</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
			  <input name="searchsuppliercode" id="searchsuppliercode" value="<?php echo $searchsuppliercode; ?>" type="hidden">
			  <input name="searchvisitcode" id="searchvisitcode" value="<?php echo $searchvisitcode; ?>" type="hidden">
			  <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
			  </td>
           </tr>
           <tr>
             <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Type</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <select name="patienttype" id="patienttype">
              <option value="">--Select--</option>
              <option value="cash">CASH</option>
              <option value="credit">CREDIT</option>
              </select>
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
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input type="submit" value="Search" name="Submit" onClick="return check()" />
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
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="700" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="16%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="7" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">
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
					
					//$transactiondatefrom = $_REQUEST['ADate1'];
					//$transactiondateto = $_REQUEST['ADate2'];
					
					//$paymenttype = $_REQUEST['paymenttype'];
					//$billstatus = $_REQUEST['billstatus'];
					
					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				else
				{
					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				?>
 				<?php
				//For excel file creation.
				
				$applocation1 = $applocation1; //Value from db_connect.php file giving application path.
				$filename1 = "print_paymentgivenreport1.php?$urlpath";
				$fileurl = $applocation1."/".$filename1;
				$filecontent1 = @file_get_contents($fileurl);
				
				$indiatimecheck = date('d-M-Y-H-i-s');
				$foldername = "dbexcelfiles";
				$fp = fopen($foldername.'/PaymentGivenToSupplier.xls', 'w+');
				fwrite($fp, $filecontent1);
				fclose($fp);

				?>
              <script language="javascript">
				function printbillreport1()
				{
					window.open("print_paymentgivenreport1.php?<?php echo $urlpath; ?>","Window1",'width=900,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
					//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
				}
				function printbillreport2()
				{
					window.location = "dbexcelfiles/PaymentGivenToSupplier.xls"
				}
				</script>
              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />
&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->
</span></td>  
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="36%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Test Name </strong></div></td>
              <td width="23%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Payment Type</strong></div></td>
                <td width="23%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sub Type</strong></div></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="style1"><div align="left"><strong>Qty</strong></div></td>
              <td width="23%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
            </tr>
			<?php
			 
			 if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
				
			
		  $query21 = "select * from master_visitentry where patientfullname like '%$searchsuppliername%' and consultationdate between '$ADate1' and '$ADate2' order by patientfullname";
		  $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res21 = mysqli_fetch_array($exec21))
		  {
     	  $res21patientfullname = $res21['patientfullname'];
		  $res21patientcode = $res21['patientcode'];
		  $res21visitcode = $res21['visitcode'];
		  $res21billtype = $res21['billtype'];
		  
		  
		
		    
		  if( $patienttype == 'credit')
		  { 

		  $query31 = "select * from billing_paylaterpharmacy where patientname = '$res21patientfullname' and patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode'";
		   $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31". mysqli_error($GLOBALS["___mysqli_ston"]));
		   
		  
		   		   
		    $query44 = "select * from billing_paylaterpharmacy where patientname = '$res21patientfullname' and patientvisitcode = '$res21visitcode'";
		   $exec44 =mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	   $num44 = mysqli_num_rows($exec44);
	   
	   	$ipquery="select * from master_ipvisitentry where billtype='PAY LATER' and registrationdate between '$ADate1' and '$ADate2' order by auto_number desc";
			$ipexe=mysqli_query($GLOBALS["___mysqli_ston"], $ipquery);
			
			$numip=mysqli_num_rows($ipexe);
	   
	   
		  }
		  else if( $patienttype == 'cash')
		  {
			 
		  $query31 = "select * from billing_paynowpharmacy where patientname = '$res21patientfullname' and patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode'";
		   $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31". mysqli_error($GLOBALS["___mysqli_ston"]));
		   
		    $query44 = "select * from billing_paynowpharmacy where patientname = '$res21patientfullname' and patientvisitcode = '$res21visitcode'";
	   $exec44 =mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	   $num44 = mysqli_num_rows($exec44);
	   
	   	$ipquery="select * from master_ipvisitentry where billtype='PAY NOW' and registrationdate between '$ADate1' and '$ADate2'  order by auto_number desc";
		$ipexe=mysqli_query($GLOBALS["___mysqli_ston"], $ipquery);
	
	$numip=mysqli_num_rows($ipexe);
		   // $num44 = mysql_num_rows($exec31);
		  }
		 
		  
		 
		  
		  
		  if($num44 !=0)
		  {
			  $patientcount=$patientcount+1;
		  ?>
		  
		  <tr bgcolor="#9999FF">
              <td colspan="8"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo strtoupper($res21patientfullname); ?> (<?php echo $res21patientcode;?>, <?php echo $res21visitcode; ?> )</strong></td>
              
              </tr>
			  
			  <?php
			  }
			
		  while ($res31= mysqli_fetch_array($exec31))
		  {
		  $res31medicinename = $res31['medicinename'];
		  $res31quantity = $res31['quantity'];
		  $res31amount = $res31['amount'];
		  $res31patientcode= $res31['patientcode'];
		  $paymentdetail="select paymenttype,subtype from master_visitentry where patientcode='$res31patientcode'";
		  $exepayment=mysqli_query($GLOBALS["___mysqli_ston"], $paymentdetail);
		  $respayment=mysqli_fetch_array($exepayment);
		  $payment=$respayment['paymenttype'];
		  $subtype=$respayment['subtype'];
		  
$payment01="select paymenttype from  master_paymenttype where auto_number ='$payment'";
$exepayment01=mysqli_query($GLOBALS["___mysqli_ston"], $payment01);
$respayment01=mysqli_fetch_array($exepayment01);

$subtype01="select subtype from master_subtype where auto_number='$subtype'";
$exesubtype=mysqli_query($GLOBALS["___mysqli_ston"], $subtype01);
$ressubtype=mysqli_fetch_array($exesubtype);

		  $total = $total + $res31amount;
		 
		  
		  $snocount = $snocount + 1;
			
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
               <td  align="left" valign="center" class="bodytext31">
                <div class="bodytext31"><?php echo $res31medicinename; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $respayment01['paymenttype']; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $ressubtype['subtype']; ?></div></td>
               <td  align="center" valign="center" class="bodytext31"><?php echo $res31quantity; ?></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($res31amount,2,'.',','); ?></div></td>
           </tr>
			
			
			
			<?php
			}
			  }?>
			
		
			<?php 
		
			if($numip <> 0)
			{
				while($resip=mysqli_fetch_array($ipexe))
				{
				$patientfullname=$resip['patientfullname'];
				$patientcode1=$resip['patientcode'];
				$patientvisitcode=$resip['visitcode'];
				$ipmedicine="select * from ipmedicine_issue where patientname='$patientfullname' and patientcode='$patientcode1' and visitcode='$patientvisitcode'";
				$exeip=mysqli_query($GLOBALS["___mysqli_ston"], $ipmedicine);
				$numrow=mysqli_num_rows($exeip);
				
				
				?>
                <?php if($numrow <> 0){ 
				$patientcount=$patientcount+1; ?>
             <tr bgcolor="#9999FF">
              <td colspan="8"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo strtoupper($resip['patientfullname']); ?> (<?php
			   echo  $resip['patientcode']; ?>, <?php echo $resip['visitcode']; ?> )</strong></td> <?php } ?>
            <?php
			
			
			while($resip01=mysqli_fetch_array($exeip))
			{
				
				$patientcode2=$resip01['patientcode'];
				$visitcode2=$resip01['visitcode'];
				
					$ipquery01="select * from master_ipvisitentry where patientcode='$patientcode2' and visitcode='$visitcode2' order by auto_number desc";
		$ipexe01=mysqli_query($GLOBALS["___mysqli_ston"], $ipquery01);
		$resip001=mysqli_fetch_array($ipexe01);
		
				$ippayment=$resip001['paymenttype'];
				$ipsubtype=$resip001['subtype'];
				
				$payment001="select paymenttype from  master_paymenttype where auto_number ='$ippayment'";
$exepayment001=mysqli_query($GLOBALS["___mysqli_ston"], $payment001);
$respayment001=mysqli_fetch_array($exepayment001);

$subtype001="select subtype from master_subtype where auto_number='$ipsubtype'";
$exesubtype01=mysqli_query($GLOBALS["___mysqli_ston"], $subtype001);
$ressubtype01=mysqli_fetch_array($exesubtype01);
 
 $total = $total + $resip01['totalrate'];
		 
		  
		  $snocount = $snocount + 1;
			
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
               <td  align="left" valign="center" class="bodytext31">
                <div class="bodytext31"><?php echo $resip01['itemname'] ; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $respayment001['paymenttype']; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $ressubtype01['subtype']; ?></div></td>
               <td  align="center" valign="center" class="bodytext31"><?php echo $resip01['quantity']; ?></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($resip01['totalrate'],2,'.',','); ?></div></td>
           </tr>
				
	<?php	
			}}
				}
			
			
			}
			
			?>
            
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong>Total Patients:</strong></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong><?= $patientcount?></strong></td>
              <td colspan="2"  align="left" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"> <strong> Total:</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($total,2,'.',','); ?></strong></td>
            </tr>
          </tbody>
        </table></td>
      </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
