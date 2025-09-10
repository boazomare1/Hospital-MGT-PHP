<?php
session_start();
//include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$username = '';
$companyanum = '';
$companyname = '';
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

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Servicetemplate.xls"');
header('Cache-Control: max-age=80');

$temp=isset($_REQUEST['servicetemp'])?$_REQUEST['servicetemp']:'';

$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
?>
<style>
.text{
  mso-number-format:"\@";/*force text*/
}
.bodytext3
{
	font-size:11px;
}
</style>

          <table width="55%" height="103" border="0" cellpadding="0" cellspacing="0">
          <tbody>
              <tr >
                     
                        <td width="10%"  class="bodytext3"><strong>ID / Code </strong></td>
                        <td width="10%"  class="bodytext3"><strong>Category</strong></td>
                        <td width="28%"  class="bodytext3"><strong>services Item</strong></td>
                        <td width="6%"  class="bodytext3"><strong>Unit</strong></td>
                       
                        <td width="9%"  class="bodytext3"><div align="center"><strong>Charges</strong></div></td>
						 <td width="10%"  class="bodytext3"><div align="center"><strong>Rate2</strong></div></td>
						  <td width="10%"  class="bodytext3"><div align="center"><strong>Rate3</strong></div></td>
						  <td width="9%"  class="bodytext3"><div><strong>IP Markup</strong></div></td>
						<td width="10%"  class="bodytext3"><div><strong>Location</strong></div></td>
                  <td width="10%"  class="bodytext3"><div><strong>Incremental Rate</strong></div></td>
                       
                      </tr>
	<?php
	$query1 = "select * from $temp where status <> 'deleted' order by auto_number desc ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$itemcode = $res1["itemcode"];
		$itemname = $res1["itemname"];
		$categoryname = $res1["categoryname"];
		$purchaseprice = $res1["purchaseprice"];
		$rateperunit = $res1["rateperunit"];
		$expiryperiod = $res1["expiryperiod"];
		$auto_number = $res1["auto_number"];
		$itemname_abbreviation = $res1["itemname_abbreviation"];
		$taxname = $res1["taxname"];
		$taxanum = $res1["taxanum"];
		$ipmarkup = $res1["ipmarkup"];
		$location = $res1["locationcode"];
		$incrementalrate = @$res1["incrementalrate"];
		$rate2 = $res1['rate2'];
		$rate3 = $res1['rate3'];
		if ($expiryperiod != '0') 
		{ 
			$expiryperiod = $expiryperiod.' Months'; 
		}
		else
		{
			$expiryperiod = ''; 
		}
		
		 /*?>$query6 = "select * from master_tax where auto_number = '$taxanum'";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		$res6 = mysql_fetch_array($exec6);
		$res6taxpercent = $res6["taxpercent"];<?php */
		
		$colorloopcount = $colorloopcount + 1;
		$showcolor = ($colorloopcount & 1); 
		if ($showcolor == 0)
		{
			$colorcode = 'bgcolor="#CBDBFA"';
		}
		else
		{
			$colorcode = 'bgcolor="#ecf0f5"';
		}
		  
		?>
        <tr >
                      
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?> </td>
                       
                       
                        <td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rateperunit; ?></div></td>
							<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate2; ?></div></td>
							<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate3; ?></div></td>
						 <td align="center" valign="top"  class="bodytext3"><?php echo $ipmarkup; ?></td>
						 <td align="left" valign="top"  class="bodytext3"><?php echo $location; ?></td>
                  <td align="left" valign="top"  class="bodytext3"><?php echo $incrementalrate; ?></td>
                       
                      </tr>
                      <?php
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
                >&nbsp;</td>

              <td class="bodytext31" valign="center"  align="right" 
                >&nbsp;</td>
			
			</tr>
          </tbody>
</table>
