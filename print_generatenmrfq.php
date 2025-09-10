<?php
session_start();

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="NMRFQ.xls"');
header('Cache-Control: max-age=80');

include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('d-m-Y');
$paymentreceiveddateto1 = "2014-01-01";
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
$sno = "";
$colorloopcount1="";
$grandtotal = '';
$grandtotal1 = "0.00";
//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_account2.php");

//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

?>
<style type="text/css">
<!--
body {
	
	background-color: #FFFFFF;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
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
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
</style>
</head>
<body>
<table cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
<tr>
					<td width="168" align="left" class="bodytext3">Ruaraka Uhai Neema Hospital </td>
					<td width="256" align="left" class="bodytext3">&nbsp;</td>
					<td width="88" align="left" class="bodytext3">&nbsp;</td>
					<td width="267" align="left" class="bodytext3">&nbsp;</td>
					<td width="151" align="left" class="bodytext3"><?php echo $transactiondateto; ?></td>
                    <td width="151" align="left" class="bodytext3">&nbsp;</td>
</tr>
<tr>
					<td width="168" align="left" class="bodytext3">P.o.Box 65122-00618 </td>
					<td width="256" align="left" class="bodytext3">&nbsp;</td>
					<td width="88" align="left" class="bodytext3">&nbsp;</td>
					<td width="267" align="left" class="bodytext3">&nbsp;</td>
					<td width="151" align="left" class="bodytext3"><span class="bodytext32">Project: RUNH</span></td>
                    <td width="151" align="left" class="bodytext3"></td>
</tr>
<tr>
					<td width="168" align="left" class="bodytext3">Nairobi  </td>
					<td width="256" align="left" class="bodytext3">&nbsp;</td>
					<td width="88" align="left" class="bodytext3">&nbsp;</td>
					<td width="267" align="left" class="bodytext3">&nbsp;</td>
					<td width="151" align="left" class="bodytext3"><span class="bodytext32">Budget </span></td>
                    <td width="151" align="left" class="bodytext3"></td>
</tr>
<tr>
					<td width="168" align="left" class="bodytext3">&nbsp;</td>
					<td width="256" align="left" class="bodytext3"><span class="bodytext32">Supplier </span></td>
					<td colspan="2" align="left" class="bodytext3">&nbsp;</td>
					<td width="151" align="left" class="bodytext3"><span class="bodytext32">Code</span></td>
                    <td width="151" align="left" class="bodytext3"></td>
</tr>
					<tr>
					<td colspan="4" align="left" class="bodytext3">
      <table width="1094" border="1" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
					
<tr bgcolor="#011E6A">
                       	 
                        <td width="10%" bgcolor="#ecf0f5" class="bodytext3"><strong>No </strong></td>
                        <td width="49%" bgcolor="#ecf0f5" class="bodytext3"><strong>Description</strong></td>
                        <td width="10%" bgcolor="#ecf0f5" class="bodytext3"><strong>Quantity</strong>                          </td>
              <td width="17%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Rate</strong></div></td>
			  <td width="14%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Amount </strong></div></td>
						
                      </tr>
					   <?php
		$query1 = "select * from purchasenm_rfq where status <> 'completed' group by itemname order by auto_number desc ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		
		$itemname = $res1["itemname"];
		
		$query331 = "select sum(quantity) as totalquantity from purchasenm_rfq where itemname = '$itemname' and status='Process'";
		$exec331 = mysqli_query($GLOBALS["___mysqli_ston"], $query331) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 
		$res331 = mysqli_fetch_array($exec331);
		$quantity = $res331['totalquantity'];
		
		
		
		$sno = $sno + 1;

	
	
		?>
        <tr>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="center"><?php echo $sno; ?></div></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?></td>
					    <td align="left" valign="top"  class="bodytext3"><?php echo $quantity; ?> </td>
                        <td align="left" valign="top"  class="bodytext3">&nbsp; </td>
                        <td align="left" valign="top"  class="bodytext3">&nbsp;</td>
                        
						 </tr>
						<?php
		}
		?>
		  </tbody>
        </table></td>
      </tr>
   </tbody>      
</table>

</body>
</html>
