<?php
session_start();
include ("db/db_connect.php");
set_time_limit(0);
ini_set('memory_limit', '1024M');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="deliveryreports.xls"');
header('Cache-Control: max-age=80');

$query_acc = "SELECT * FROM finance_ledger_mapping WHERE map_anum = '20' AND record_status <> 'deleted'";
$exec_acc = mysqli_query($GLOBALS["___mysqli_ston"], $query_acc) or die ("Error in Query_acc".mysqli_error($GLOBALS["___mysqli_ston"]));
$ledgername = '';
$res_acc = mysqli_fetch_array($exec_acc);

$accountcode1 = $res_acc['ledger_id'];
$accountname1 = trim($res_acc['ledger_name']);

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$updatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$searchsubtype = "";
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
if(isset($_REQUEST["account"])) $searchsuppliername =$_REQUEST["account"]; else $searchsuppliername ='';
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
 $total = "0.00";
 $location=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
 $locationcode1=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }
//$paymenttype = $_REQUEST['paymenttype'];
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }
//$billstatus = $_REQUEST['billstatus'];
//echo $ADate2;


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

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 
            align="left" border="1">
          <tbody>
            <tr>
              <td colspan="3"  class="bodytext31"><strong><?php echo $searchsuppliername; ?></strong></td>
              <td colspan="4"  class="bodytext31"><span class="bodytext311">
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
				
				/*$applocation1 = $applocation1; //Value from db_connect.php file giving application path.
				$filename1 = "print_paymentgivenreport1.php?$urlpath";
				$fileurl = $applocation1."/".$filename1;
				$filecontent1 = @file_get_contents($fileurl);
				
				$indiatimecheck = date('d-M-Y-H-i-s');
				$foldername = "dbexcelfiles";
				$fp = fopen($foldername.'/PaymentGivenToSupplier.xls', 'w+');
				fwrite($fp, $filecontent1);
				fclose($fp);*/

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
                ><strong>No.</strong></td>
              <td width="12%" align="left" valign="center"  
                 class="bodytext31"><div align="left"><strong>Reg No</strong></div></td>
              <td width="17%" align="left" valign="center"  
                 class="bodytext31"><strong> Patient </strong></td>
              <td width="12%" align="left" valign="center"  
                 class="bodytext31"><strong> Bill No </strong></td>
              <td width="13%" align="left" valign="center"  
                 class="bodytext31"><div align="left"><strong>Bill Date </strong></div></td>
              <td width="13%" align="left" valign="center"  
                 class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
              
            </tr>
			<?php 
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
		    if ($cbfrmflag1 == 'cbfrmflag1')
			{
			if($searchsuppliername!='')
			      $query25 = "select auto_number,subtype from master_subtype where  subtype = '$searchsuppliername'";
				else
					$query25 = "select auto_number,subtype from master_subtype ";

			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res25 = mysqli_fetch_array($exec25)) {
			$searchsubtypeanum1 = $res25['auto_number'];
			$searchsubtype = $res25['subtype'];
			
			$query21 = "select auto_number,accountname,id,paymenttype,subtype from master_accountname where  subtype = '$searchsubtypeanum1'  order by subtype desc";
			// and recordstatus <> 'DELETED'
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res21 = mysqli_fetch_array($exec21))
			{
			$res21accountname =mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $res21['accountname']);
			$accno =$res21['auto_number'];
			$legid =$res21['id'];
			
			$query22 = "select accountname from billing_paylater where locationcode='$locationcode1' and  accountnameano = '$accno' and completed <> 'completed' and billdate between '$ADate1' and '$ADate2' and binary billno NOT IN (SELECT binary billno FROM print_deliverysubtype where status != 'deleted') group by accountnameano";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22);
			$res22accountname = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $res22['accountname']);
			
			$query23 = "select accountname from billing_ip where locationcode='$locationcode1' and  accountnameano = '$accno' and completed <> 'completed' and billdate between '$ADate1' and '$ADate2' and binary billno NOT IN (SELECT binary billno FROM print_deliverysubtype where status != 'deleted' and accountname!='$accountname1') group by accountnameano"; 
		    $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res23 = mysqli_fetch_array($exec23);
			$res23accountname =mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $res23['accountname']);

			if($res21accountname==$accountname1){
           		$res25accountname=$accountname1;

			}else
				$res25accountname='';
			
			$query24 = "select accountname from billing_ipcreditapprovedtransaction where locationcode='$locationcode1' and  accountnameano = '$accno' and binary billno NOT IN (SELECT binary billno FROM print_deliverysubtype where status != 'deleted' ) and completed <> 'completed' and billdate between '$ADate1' and '$ADate2' group by accountnameano"; 
		    $exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res24 = mysqli_fetch_array($exec24);
			$res24accountname =mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $res24['accountname']);
			
			if( $res22accountname != '' || $res23accountname != '' || $res24accountname != '' || $res25accountname != '')
			{
			?>

			<tr >
              <td colspan="7"  align="left" valign="center"  class="bodytext31"><strong><?php echo $res21accountname;?></strong></td>
            </tr>
			
			<?php
		  $query2 = "select * from billing_paylater where locationcode='$locationcode1' and  accountnameano = '$accno' and completed <> 'completed' and billdate between '$ADate1' and '$ADate2'  and binary billno NOT IN (SELECT binary billno FROM print_deliverysubtype where status != 'deleted') group by billno order by accountname, billdate desc"; 
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res2num = mysqli_num_rows($exec2);

		  

		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  $res2accountname = $res2['accountname'];
		  $res2patientcode = $res2['patientcode'];
		  $res2visitcode = $res2['visitcode'];
		  $res2billno = $res2['billno'];
          $res2totalamount = $res2['totalamount'];
		  $res2billdate = $res2['billdate'];
		  $res2patientname = $res2['patientname'];
		  $res2accountname = $res2['accountname'];

		  
		  $total = $total + $res2totalamount;
		  
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
           <tr >
              
			  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientcode<?php echo $snocount; ?>" id="patientcode<?php echo $snocount; ?>" value="<?php echo $res2patientcode; ?>">
				<?php echo $res2patientcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientname<?php echo $snocount; ?>" id="patientname<?php echo $snocount; ?>" value="<?php echo $res2patientname; ?>">
				<?php echo $res2patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <input type="hidden" name="billno<?php echo $snocount; ?>" id="billno<?php echo $snocount; ?>" value="<?php echo $res2billno; ?>">
			  <?php echo $res2billno; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
				<input type="hidden" name="billdate<?php echo $snocount; ?>" id="billdate<?php echo $snocount; ?>" value="<?php echo $res2billdate; ?>">
				<?php echo $res2billdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right">
			  <input type="hidden" name="accountname<?php echo $snocount; ?>" id="accountname<?php echo $snocount; ?>" value="<?php echo $res2accountname; ?>">
			  <input type="hidden" name="amount<?php echo $snocount; ?>" id="amount<?php echo $snocount; ?>" value="<?php echo $res2totalamount; ?>">
			  <?php echo number_format($res2totalamount,2,'.',','); ?></div></td>
              
           </tr>
			<?php
			}

		   if($legid==$accountcode1){
            
			 $query3 = "select * from billing_ipnhif where locationcode='$locationcode1' and  completed <> 'completed' and recorddate between '$ADate1' and '$ADate2'  and  docno NOT IN (SELECT  billno FROM print_deliverysubtype where status != 'deleted' and accountname='$accountname1') order by recorddate desc"; 
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while ($res3 = mysqli_fetch_array($exec3))
			  {

				  $res3accountname = $accountname1;
				  $res3patientcode = $res3['patientcode'];
				  $res3visitcode = $res3['visitcode'];
				  $res3billno = $res3['docno'];
				  $res3totalamount = $res3['finamount'];
				  $res3billdate = $res3['recorddate'];
				  $res3patientname = $res3['patientname'];

				  
		  $total = $total + $res3totalamount;
		  
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
           <tr >
		   
			  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientcode<?php echo $snocount; ?>" id="patientcode<?php echo $snocount; ?>" value="<?php echo $res3patientcode; ?>">
				<?php echo $res3patientcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientname<?php echo $snocount; ?>" id="patientname<?php echo $snocount; ?>" value="<?php echo $res3patientname; ?>">
				<?php echo $res3patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <input type="hidden" name="billno<?php echo $snocount; ?>" id="billno<?php echo $snocount; ?>" value="<?php echo $res3billno; ?>">
			  <?php echo $res3billno; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
				<input type="hidden" name="billdate<?php echo $snocount; ?>" id="billdate<?php echo $snocount; ?>" value="<?php echo $res3billdate; ?>">
				<?php echo $res3billdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right">
			  <input type="hidden" name="accountname<?php echo $snocount; ?>" id="accountname<?php echo $snocount; ?>" value="<?php echo $res3accountname; ?>">
			  <input type="hidden" name="amount<?php echo $snocount; ?>" id="amount<?php echo $snocount; ?>" value="<?php echo $res3totalamount; ?>">
			  <?php echo number_format($res3totalamount,2,'.',','); ?></div></td>
              
           </tr>
			<?php

			  }
      

		   }
			
		  $query3 = "select * from billing_ip where locationcode='$locationcode1' and  accountnameano = '$accno' and completed <> 'completed' and billdate between '$ADate1' and '$ADate2'  and binary billno NOT IN (SELECT binary billno FROM print_deliverysubtype where status != 'deleted') group by billno order by accountname, billdate desc"; 
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res3 = mysqli_fetch_array($exec3))
		  {
     	  $res3accountname = $res3['accountname'];
		  $res3patientcode = $res3['patientcode'];
		  $res3visitcode = $res3['visitcode'];
		  $res3billno = $res3['billno'];
          $res3totalamount = $res3['totalamount'];
		  $res3billdate = $res3['billdate'];
		  $res3patientname = $res3['patientname'];

		  
		  $total = $total + $res3totalamount;
		  
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
           <tr >
		   
			  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientcode<?php echo $snocount; ?>" id="patientcode<?php echo $snocount; ?>" value="<?php echo $res3patientcode; ?>">
				<?php echo $res3patientcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientname<?php echo $snocount; ?>" id="patientname<?php echo $snocount; ?>" value="<?php echo $res3patientname; ?>">
				<?php echo $res3patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <input type="hidden" name="billno<?php echo $snocount; ?>" id="billno<?php echo $snocount; ?>" value="<?php echo $res3billno; ?>">
			  <?php echo $res3billno; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
				<input type="hidden" name="billdate<?php echo $snocount; ?>" id="billdate<?php echo $snocount; ?>" value="<?php echo $res3billdate; ?>">
				<?php echo $res3billdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right">
			  <input type="hidden" name="accountname<?php echo $snocount; ?>" id="accountname<?php echo $snocount; ?>" value="<?php echo $res3accountname; ?>">
			  <input type="hidden" name="amount<?php echo $snocount; ?>" id="amount<?php echo $snocount; ?>" value="<?php echo $res3totalamount; ?>">
			  <?php echo number_format($res3totalamount,2,'.',','); ?></div></td>
             
           </tr>
			<?php
			}
			 $query3 = "select * from billing_ipcreditapprovedtransaction where locationcode='$locationcode1'  and completed <> 'completed' and billdate between '$ADate1' and '$ADate2' and  accountnameano = '$accno' and binary billno NOT IN (SELECT binary billno FROM print_deliverysubtype where status != 'deleted' ) group by billno order by accountname, billdate desc"; 
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res3 = mysqli_fetch_array($exec3))
		  {
     	  $res3accountname = $res3['accountname'];
		  $res3patientcode = $res3['patientcode'];
		  $res3visitcode = $res3['visitcode'];
		  $res3billno = $res3['billno'];
          $res3totalamount = $res3['totalamount'];
		  $res3billdate = $res3['billdate'];
		  $res3patientname = $res3['patientname'];

		  
		  $total = $total + $res3totalamount;
		  
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
           <tr >
		   
			  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientcode<?php echo $snocount; ?>" id="patientcode<?php echo $snocount; ?>" value="<?php echo $res3patientcode; ?>">
				<?php echo $res3patientcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientname<?php echo $snocount; ?>" id="patientname<?php echo $snocount; ?>" value="<?php echo $res3patientname; ?>">
				<?php echo $res3patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <input type="hidden" name="billno<?php echo $snocount; ?>" id="billno<?php echo $snocount; ?>" value="<?php echo $res3billno; ?>">
			  <?php echo $res3billno; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
				<input type="hidden" name="billdate<?php echo $snocount; ?>" id="billdate<?php echo $snocount; ?>" value="<?php echo $res3billdate; ?>">
				<?php echo $res3billdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right">
			  <input type="hidden" name="accountname<?php echo $snocount; ?>" id="accountname<?php echo $snocount; ?>" value="<?php echo $res3accountname; ?>">
			  <input type="hidden" name="amount<?php echo $snocount; ?>" id="amount<?php echo $snocount; ?>" value="<?php echo $res3totalamount; ?>">
			  <?php echo number_format($res3totalamount,2,'.',','); ?></div></td>
              
           </tr>
			<?php
			}
			}
			}
			}
			?>
            <tr>
              
				<td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                ><strong>Total:</strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong><?php echo number_format($total,2,'.',','); ?></strong></div></td>
              
			</tr>
			
			<?php
			}
			?>
          </tbody>
        </table>
		
</body>
</html>
