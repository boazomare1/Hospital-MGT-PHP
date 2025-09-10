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
$currentdate = date("Y-m-d");

$grandtotal = '0.00';
$totaldr = '0.00';
$totalcr = '0.00';			

$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');  

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Journalreport.xls"');
header('Cache-Control: max-age=80');

ob_start();

 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
 $locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
//$getcanum = $_GET['canum'];

if ($getcanum != '')
{
	$query4 = "select * from master_customer where locationcode='$locationcode1' and auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbcustomername = $res4['customername'];
	$customername = $res4['customername'];
}

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
	if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
	//$cbbillnumber = $_REQUEST['cbbillnumber'];
	if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
	//$cbbillstatus = $_REQUEST['cbbillstatus'];
	
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
	
	if (isset($_REQUEST["paymenttype"])) { $paymenttype = $_REQUEST["paymenttype"]; } else { $paymenttype = ""; }
	//$paymenttype = $_REQUEST['paymenttype'];
	if (isset($_REQUEST["billstatus"])) { $billstatus = $_REQUEST["billstatus"]; } else { $billstatus = ""; }
	//$billstatus = $_REQUEST['billstatus'];

}
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #FFF;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<body>
    <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1127" 
            align="left" border="1">
          <tbody>
          
				<?php
			 
			 if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
				 
			?>
           <tr>
		   <td colspan="9" align="left" class="bodytext3"><strong>Journal Report</strong></td>
		   </tr>
			<tr>
              <td width="3%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
				<td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Entry Date </strong></td>
				<td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Doc No </strong></td>
				<td width="14%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>User Name</strong></td>
              <td width="20%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Dr Account </strong></td>
                <td width="9%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Dr Amount </strong></td>
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Cr Account </strong></td>
              <td width="10%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Cr Amount</strong></td>
                <td width="12%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Narration/Comments</strong></td>
             
			</tr>
			
			  
			  <?php 
			$totaldr = '0.00';
			$totalcr = '0.00';
			$sno=0;
			
			$query2 = "select * from master_journalentries where locationcode='$locationcode1' and entrydate between '$transactiondatefrom' and '$transactiondateto' AND docno NOT LIKE 'PCA-%' group by docno order by auto_number";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	        while($res2 = mysqli_fetch_array($exec2))
			{
			$res2billnumber = $res2['docno'];
			$res2transactiondate = $res2['entrydate'];
			
			$query3 = "select * from master_journalentries where locationcode='$locationcode1' and docno = '$res2billnumber' and docno like 'EN%' order by selecttype desc";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3" .mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res3 = mysqli_fetch_array($exec3))
			{
			$ledgerid = $res3['ledgerid'];
			$ledgername = $res3['ledgername'];
			$res3transactionamount = $res3['transactionamount'];
			$username = $res3['username'];
			$updatetime = $res3['updatedatetime'];
			$narration = $res3['narration'];
			$selecttype = $res3['selecttype'];
			 $sno = $sno + 1;
			if($selecttype == 'Dr')
			{
				$totaldr = $totaldr + $res3transactionamount;
			}
			else
			{
				$totalcr = $totalcr + $res3transactionamount;
			}
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno; ?></td>
			   <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $username; ?></td>
               <td class="bodytext31" valign="center"  align="left"> <?php if($selecttype == 'Dr'){ echo $ledgername; }?></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php if($selecttype == 'Dr'){ echo number_format($res3transactionamount,2,'.',','); } ?></div></td>
                
                <td class="bodytext31" valign="center"  align="left"> <?php if($selecttype == 'Cr'){ echo $ledgername; }?></td>
                <td class="bodytext31" valign="center"  align="right"><?php if($selecttype == 'Cr'){ echo number_format($res3transactionamount,2,'.',','); } ?></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo $narration; ?></div></td>
				</tr>
			<?php
			}
			}
			
			  ?>
			  
			  <tr bgcolor="#FFF">
	    <td colspan="5" class="bodytext31" valign="center"  align="right"><strong>Grand Total :</strong> </td>
		<td class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($totaldr,2,'.',','); ?></strong></td>
    
		<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
		<td class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($totalcr,2,'.',','); ?></strong></td>
		<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
	  </tr>	 
	  <?php 
	  }
	  ?>
          </tbody>
        </table>
</body>
</html>

