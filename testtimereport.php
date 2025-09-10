<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");


$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
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
$tot1 = "00";
$tot2 = "00";
//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_account2.php");

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
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

<script type="text/javascript" src="js/autocomplete_accounts2.js"></script>
<script type="text/javascript" src="js/autosuggest4accounts.js"></script>
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
		
		
              <form name="cbform1" method="post" action="testtimereport.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Time Report</strong></td>
              </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Account </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
              </span></td>
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
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
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
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="3%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="14" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">
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
              <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
				<td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account</strong></div></td>
              <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Visit Date </strong></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Visit No </strong></td>
              <td width="6%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>OP Visit </strong></div></td>
				<td width="7%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Cons. Bill </strong></div></td>
				<td width="9%" align="right" valign="center"  
                bgcolor="#ffffff" class="style1">Consultation</td>
				<td width="5%" align="right" valign="center"  
                bgcolor="#ffffff" class="style1">Triage</td>
				<td width="7%" align="right" valign="center"  
                bgcolor="#ffffff" class="style1">Med Issue </td>
				<td width="6%" align="right" valign="center"  
                bgcolor="#ffffff" class="style1">Service</td>
				<td width="7%" align="right" valign="center"  
                bgcolor="#ffffff" class="style1">Radiology</td>
				<td width="8%" align="right" valign="center"  
                bgcolor="#ffffff" class="style1">Lab</td>
				<td width="8%" align="right" valign="right"  
                bgcolor="#ffffff" class="style1">Total Time </td>
            </tr>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
            //$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
            if ($cbfrmflag1 == 'cbfrmflag1')
            {
				$yearfrom = $_SESSION['datefrom'];
				$yearto = $_SESSION['dateto'];

  		  $fromDate = '2014-07-23';
		    
		  $query2 = "select * from master_visitentry where consultationdate ='$fromDate' order by consultationdate ";
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  
		  
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  $res2patientfullname = $res2['patientfirstname'];
		  $res2consultationdate = $res2['consultationdate'];
		  $datearray = explode("-",$res2consultationdate);
		  $res2visitcode = $res2['visitcode'];
		  $res2consultationtime = $res2['consultationtime'];
		  $res2accountfullname = $res2['accountfullname'];
		  $res2patientcode = $res2['patientcode'];
		  if($res2consultationtime == '')
		  {
		  $res2consultationtime = "00:00:00";
		  }
		  else
		  {
		  $res2consultationtime = $res2['consultationtime'];
		  }
		  $res2consultationtime1 = strtotime($res2consultationtime);
		  
		  $query3 = "select * from master_billing where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and billingdatetime  ='$fromDate'";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res3 = mysqli_fetch_array($exec3);
		  $res3billnumber = $res3['billnumber'];
		  $res3consultationtime = $res3['consultationtime'];
		  if($res3consultationtime == '')
		  {
		  $res3consultationtime = "00:00:00";
		  }
		  else
		  {
		  $res3consultationtime = $res3['consultationtime'];
		  }
		  $res3consultationtime1 = strtotime($res3consultationtime);
		  
		  $query4 = "select * from master_triage where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and registrationdate ='$fromDate'";
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in quey4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res4 = mysqli_fetch_array($exec4);
		  $res4consultationtime = $res4['consultationtime'];
		  if($res4consultationtime == '')
		  {
		  $res4consultationtime = "00:00:00";
		  }
		  else
		  {
		  $res4consultationtime = $res4['consultationtime'];
		  }
		  $res4consultationtime1 = strtotime($res4consultationtime);
		  
		  $query5 = "select * from pharmacysales_details where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and entrydate  ='$fromDate'";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5". mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res5 = mysqli_fetch_array($exec5);
		  $res5entrytime = $res5['entrytime'];
		  if($res5entrytime == '')
		  {
		  $res5entrytime = "00:00:00";
		  }
		  else
		  {
		  $res5entrytime = $res5['entrytime'];
		  }
		  $res5entrytime1 = strtotime($res5entrytime);
		  
		  $query6 = "select * from process_service where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and recorddate ='$fromDate'";
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6 = mysqli_fetch_array($exec6);
		  $res6recordtime = $res6['recordtime'];
		  if($res6recordtime == '')
		  {
		  $res6recordtime = "00:00:00";
		  }
		  else
		  {
		  $res6recordtime = $res6['recordtime'];
		  }
		  $res6recordtime1 = strtotime($res6recordtime);
		  
		  $query7 = "select * from resultentry_radiology where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and recorddate  ='$fromDate'";
		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res7 = mysqli_fetch_array($exec7);
		  $res7recordtime = $res7['recordtime'];
		  if($res7recordtime=='')
		  {
		  $res7recordtime = "00:00:00";
		  }
		  else
		  {
		  $res7recordtime = $res7['recordtime'];
		  }
		  $res7recordtime1 = strtotime($res7recordtime);
		  
		  $query8 = "select * from samplecollection_lab where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and recorddate ='$fromDate'";
		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res8 = mysqli_fetch_array($exec8);
		  $res8recordtime = $res8['recordtime'];
		  //echo $splittedstring=explode(":",$res8recordtime,2);
          if ($res8recordtime == '')
		  {
		  $res8recordtime = "00:00:00";
		  }
		  else
		  {
		  $res8recordtime = $res8['recordtime'];
		  }
		  $res8recordtime1 = strtotime($res8recordtime);
		  
		  $query9 = "select * from master_consultation where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and recorddate  ='$fromDate'";
		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res9 = mysqli_fetch_array($exec9);
		  $res9consultationtime = $res9['consultationtime'];
		  //echo $splittedstring=explode(":",$res8recordtime,2);
          if ($res9consultationtime == '')
		  {
		  $res9consultationtime = "00:00:00";
		  }
		  else
		  {
		  $res9consultationtime = $res9['consultationtime'];
		  }
		  $res9consultationtime1 = strtotime($res9consultationtime);
		  
		   $highest_time = max($res9consultationtime, $res4consultationtime1, $res5entrytime1, $res6recordtime1, $res7recordtime1 , $res8recordtime1);
		   //$lowest_time = min($res2consultationtime1,$res3consultationtime1, $res4consultationtime1, $res5entrytime1, $res6recordtime1, $res7recordtime1 , $res8recordtime1);
		  
		  $highest_time1 = date("H:i:s", $highest_time); 
		  $lowest_time1 = date("H:i:s", $res2consultationtime1);
		 //echo $t = date("H:i",120);
		 //$tot =  $highest_time1 - $lowest_time1;
		 $exe = explode(":",$highest_time1);
		 $exe1 = explode(":",$lowest_time1);
		 $exe2 = $exe[0] - $exe1[0];
		 $exe3 = $exe[1] - $exe1[1];
		 $exe4 = $exe[2] - $exe1[2];
		 $length = strlen($exe2);
		 $length1 = strlen($exe3);
		 
		 
		 if($length == '1')
		 {
		  $exe2 = '0'. $exe2;
		 }
		 
		 if($length1 == '1')
		 {
		 $exe3 = '0'.$exe3;
		 }
		 
		 if($exe2 < 0)
		 {
		 $exe2 = '00';
		 }
		 
		 if($exe3 < 0)
		 {
		 $exe3 = '00';
		 }
		 
		 $tot1 = $tot1 + $exe2;
		 $tot2 = $tot2 + $exe3;
		 
		 $length2 = strlen($tot1);
		 $length3 = strlen($tot2);
		 
		 if($length2 == '1')
		 {
		 $tot1 = '0'. $tot1;
		 }
		 
		 if($length3 == '1')
		 {
		 $tot2 = '0'. $tot2;
		 }
		 
		 $exe5 = $exe2 * 3600;
		 $exe6 = $exe3 * 60;
		 $exe7 = $exe5 + $exe6;
		 
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
			
	       $exe8 = $exe7 / $snocount;
			?>
           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2patientfullname; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2accountfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $datearray[2]; ?>-<?php echo $datearray[1]; ?>-<?php echo $datearray[0]; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2visitcode; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo date("H:i",(strtotime($res2consultationtime))); ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo date("H:i",(strtotime($res3consultationtime))); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo date("H:i",(strtotime($res9consultationtime))); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo date("H:i",(strtotime($res4consultationtime))); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo date("H:i",(strtotime($res5entrytime))); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo date("H:i",(strtotime($res6recordtime))); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo date("H:i",(strtotime($res7recordtime))); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo date("H:i",(strtotime($res8recordtime))); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="center"><?php echo $exe3; ?></div></td>

           </tr>
			<?php
			}
	//	}	
			//$tot3 = $tot1/$snocount;
			//$tot4 = $tot2/$snocount;
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Total Time:</strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong><?php echo $tot2; ?></strong></div></td>
            </tr>
			<?php
			 $awt = $tot2/$snocount;
			
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
                bgcolor="#ecf0f5"><div align="right"></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>A W T:</strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="center"><strong><?php echo number_format($awt,1,'.',''); ?></strong></div></td>
            </tr>
			 
		<?php
		}
		?>
          </tbody>
        </table></td>
      </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
