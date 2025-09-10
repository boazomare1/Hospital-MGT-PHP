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
header('Content-Disposition: attachment;filename="Pharmacyitems.xls"');
header('Cache-Control: max-age=80');

if (isset($_REQUEST["user"])) { $searchsuppliername = $_REQUEST["user"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) {  $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) {  $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
?>
<style>
.text{
  mso-number-format:"\@";/*force text*/
}
</style>

          <table width="55%" height="103" border="0" cellpadding="0" cellspacing="0">
          <tbody>
            <tr>
               <td width="7%" class="bodytext3"><strong>No</strong></td>
              <td width="7%"  class="bodytext3"><strong>ID / Code </strong></td>
                        <td width="14%"  class="bodytext3"><strong>Category</strong></td>
                        <td width="27%"  class="bodytext3"><strong>Itemname</strong></td>
                       <!-- <td width="4%"  class="bodytext3"><strong>Unit</strong></td>-->
                        <td width="9%"  class="bodytext3"><strong>Purchase Price</strong></td>
						 <!--<td width="9%"  class="bodytext3"><strong>Reference</strong></td>
						  <td width="9%"  class="bodytext3"><strong>Ref.Unit</strong></td>
						   <td width="9%"  class="bodytext3"><strong>Range</strong></td>-->
                       <!-- <td width="9%"  class="bodytext3"><div align="center"><strong>Tax%</strong></div></td>-->
					
                         <td width="9%"  class="bodytext3"><strong>Selling Price</strong></td>
                         <td width="9%"  class="bodytext3"><strong>ROL</strong></td>
              
            
			</tr>
			
			<?php
			$sno=0;
			$query1 = "select * from master_medicine where   status <> 'deleted' group by itemcode order by auto_number desc ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$labcount = mysqli_num_rows($exec1);
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$itemcode = $res1["itemcode"];
		$itemname = $res1["itemname"];
		$categoryname = $res1["categoryname"];
		$purchaseprice = $res1["purchaseprice"];
		
		$rateperunitloc= $locationcode.'_rateperunit';
		 $rateperunit = $res1[$rateperunitloc];
		$expiryperiod = $res1["expiryperiod"];
		$auto_number = $res1["auto_number"];
		
		$taxname = $res1["taxname"];
		$taxanum = $res1["taxanum"];
		$ipmarkup = $res1["ipmarkup"];
		
			$rolquery="select rol from master_itemtosupplier where itemcode='$itemcode'";
		$exerol=mysqli_query($GLOBALS["___mysqli_ston"], $rolquery);
		$resrol=mysqli_fetch_array($exerol);
		
		$rol=$resrol['rol'];
		
		if ($expiryperiod != '0') 
		{ 
			$expiryperiod = $expiryperiod.' Months'; 
		}
		else
		{
			$expiryperiod = ''; 
		}
		
	
		
		$colorloopcount = $colorloopcount + 1;
		$showcolor = ($colorloopcount & 1); 
		if ($showcolor == 0)
		{
		//	$colorcode = 'bgcolor="#CBDBFA"';
		}
		else
		{
		//	$colorcode = 'bgcolor="#ecf0f5"';
		}
		  
		?>
        <tr >
                      <td align="left" valign="top"  class="bodytext3"><?php echo $sno=$sno+1; ?> </td>
<td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?> </td>
		<?php /*?><!--<td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?> </td>--><?php */?>
		<?php /*?><!--<td align="left" valign="top"  class="bodytext3"><?php echo $referencename; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $referenceunit; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $referencerange; ?> </td>--><?php */?>
		<?php /*?><!--<td align="left" valign="top"  class="bodytext3"><?php echo $res6taxpercent; ?> </td>--><?php */?>
		<td align="left" valign="top"  class="bodytext3"><?php echo $purchaseprice; ?> </td>
                               
                       <td align="left" valign="top"  class="bodytext3"><div align="center"><?php echo $rateperunit; ?></div></td>
                       <td align="left" valign="top"  class="bodytext3"><div align="center"><?php echo $rol; ?></div></td>
						<?php /*?><!--<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate2; ?></div></td>
						<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate3; ?></div></td>
						<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $location; ?></div></td>--><?php */?>
						<?php /*?><!--<td align="left" valign="top"  class="bodytext3"><div align="center"><?php echo $externallab; ?></div></td>
						<td align="left" valign="top"  class="bodytext3"><div align="center"><?php echo $externalrate; ?></div></td>--><?php */?>
                       
                      </tr>
                      <?php
		}
		
		
		
		
		
		
		
		
		/*	
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
		      
		
		  $query4 = "select * from master_billing where locationcode='$locationcode' and billingdatetime between '$ADate1' and '$ADate2'"; 
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  $num4=mysql_num_rows($exec4);
		  while($res4 = mysql_fetch_array($exec4))
{

			 $patientname = $res4['patientfullname'];
			$patientcode = $res4['patientcode'];
			$visitcode = $res4['visitcode'];
			$date = $res4['billingdatetime'];
			 $amount = $res4['cashamount'];
			$billnumber = $res4['billnumber'];
			$total6 = $total6 + $amount;
			$snocount = $snocount + 1;
            ?>
           <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $date; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $patientcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>
             			  <td  align="left" valign="center" class="text"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
           </tr>
			<?php
			}*/
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
