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
header('Content-Disposition: attachment;filename="Labtemplate.xls"');
header('Cache-Control: max-age=80');

$temp=isset($_REQUEST['labtemp'])?$_REQUEST['labtemp']:'';

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
                        
                        <td width="7%"  class="bodytext3"><strong>ID / Code </strong></td>
                        <td width="14%"  class="bodytext3"><strong>Category</strong></td>
                        <td width="27%"  class="bodytext3"><strong>lab Item</strong></td>
                        <td width="4%"  class="bodytext3"><strong>Unit</strong></td>
                        <td width="9%"  class="bodytext3"><strong>Sample Type</strong></td>
						 <td width="9%"  class="bodytext3"><strong>Reference</strong></td>
						  <td width="9%"  class="bodytext3"><strong>Ref.Unit</strong></td>
						   <td width="9%"  class="bodytext3"><strong>Range</strong></td>
                        <td width="9%"  class="bodytext3"><div align="center"><strong>Tax%</strong></div></td>
						 <td width="9%"  class="bodytext3"><div align="center"><strong>IP Markup</strong></div></td>
                        <td width="10%"  class="bodytext3"><div align="center"><strong>Charges</strong></div></td>
						 <td width="10%"  class="bodytext3"><div align="center"><strong>Rate2</strong></div></td>
						  <td width="10%"  class="bodytext3"><div align="center"><strong>Rate3</strong></div></td>
						 <td width="10%"  class="bodytext3"><div align="center"><strong>Location</strong></div></td>
                       
                      </tr>
			
			<?php
			
		$query1 = "select * from $temp where status <> 'deleted' group by itemcode order by auto_number desc";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$itemcode = $res1["itemcode"];
		$itemname = $res1["itemname"];
		$categoryname = $res1["categoryname"];
		$purchaseprice = $res1["purchaseprice"];
		$sampletype= isset($res1["sampletype"])?$res1["sampletype"]:'' ;
		$rateperunit = $res1["rateperunit"];
		$expiryperiod = $res1["expiryperiod"];
		$auto_number = $res1["auto_number"];
		$itemname_abbreviation = $res1["itemname_abbreviation"];
		$taxname = $res1["taxname"];
		$taxanum = $res1["taxanum"];
		$ipmarkup = $res1["ipmarkup"];
		$location = $res1["location"];
		$referencename = isset($res1['referencename'])?$res1['referencename']:''; 
		$referenceunit = isset($res1['referenceunit'])?$res1['referenceunit']:'';
		$referencerange = isset($res1['referencerange'])?$res1['referencerange']:'';
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
		
		 $query6 = "select * from master_tax where auto_number = '$taxanum'";
		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res6 = mysqli_fetch_array($exec6);
		$res6taxpercent = $res6["taxpercent"];
		
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
        <tr>
                  
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $sampletype; ?> </td>
						  <td align="left" valign="top"  class="bodytext3"><?php echo $referencename; ?> </td>
						   <td align="left" valign="top"  class="bodytext3"><?php echo $referenceunit; ?> </td>
						    <td align="left" valign="top"  class="bodytext3"><?php echo $referencerange; ?> </td>
                     
						 <td align="left" valign="top"  class="bodytext3"><?php echo $res6taxpercent; ?> </td>
					   <td align="left" valign="top"  class="bodytext3"><?php echo $ipmarkup; ?> </td>
                   
                        
                        <td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rateperunit; ?></div></td>
						<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate2; ?></div></td>
						<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate3; ?></div></td>
						<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $location; ?></div></td>
                        <td align="left" valign="top"  class="bodytext3">
						 
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
