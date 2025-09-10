<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

//$financialyear = $_SESSION["financialyear"];

	$query6 = "select * from master_company where auto_number = '$companyanum'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);
	$res6companycode = $res6["companycode"];
	
	$query7 = "select * from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and 
	settingsname = 'CURRENT_FINANCIAL_YEAR'";
	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res7 = mysqli_fetch_array($exec7);
	$financialyear = $res7["settingsvalue"];
	$_SESSION["financialyear"] = $financialyear;
	//echo $_SESSION['financialyear'];


if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//echo $billautonumber;
if (isset($_REQUEST["printsource"])) { $printsource = $_REQUEST["printsource"]; } else { $printsource = ""; }

$query1 = "select * from master_company where auto_number = '$companyanum'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1companyname = $res1['companyname'];
$res1address1 = $res1['address1'];
$res1area = $res1['area'];
$res1city = $res1['city'];
$res1state = $res1['state'];
$res1country = $res1['country'];
$res1pincode = $res1['pincode'];
$res1phonenumber1 = $res1['phonenumber1'];


$query2 = "select * from master_transactionpaynow where billnumber = '$billautonumber'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$res2patientname = $res2['patientname'];
$res2patientcode = $res2['patientcode'];
$res2visitcode = $res2['visitcode'];
$res2billnumber = $res2['billnumber'];
$res2transactionamount = $res2['transactionamount'];
$res2transactiondate = $res2['transactiondate'];
$res2transactionmode = $res2['transactionmode'];
$res2cashgiventocustomer = $res2['cashgiventocustomer'];
$res2cashgivenbycustomer = $res2['cashgivenbycustomer'];
$res2username = $res2['username'];
$res2username = strtoupper($res2username);
$res2transactiondate = $res2['transactiondate'];
$res2transactiontime = $res2['transactiontime'];
$res2transactiontime = explode(":",$res2transactiontime);

if($res2username == 'ADMIN')
{
$res2username = 'AMINISTRATOR';
}
?>
<script language="javascript">

function escapekeypressed()
{
	//alert(event.keyCode);
	if(event.keyCode=='27'){ window.close(); }
}

</script>
<body onkeydown="escapekeypressed()">
<table width="660" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<div align="left">&nbsp;
	<?php
			$query2showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec2showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query2showlogo) or die ("Error in Query2showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2showlogo = mysqli_fetch_array($exec2showlogo);
			$showlogo = $res2showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
				
			<img src="logofiles/<?php echo $companyanum;?>.jpg" width="75" height="75" />
			
			<?php
			}
			?>	
	</div></td>
	<td>
	<div align="right">&nbsp;
	<?php
	echo '<strong>'.$res1companyname.'</strong>';
	echo '<br>'.$res1address1.' '.$res1area;
	echo '<br>Phone : '.$res1phonenumber1;
	?>
	</div></td>
  </tr>
  
  <tr>
  <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>
	  <div align="left">
	<strong><?php
	echo 'Name : '.$res2patientname.'&nbsp;';
	echo '<br>Reg No. : '.$res2patientcode;
	echo '<br>Visit No.  : '.$res2visitcode;
	?></strong>&nbsp;
    </div>
	</td>
	
	<td>
	<div align="right">
	<strong><?php
	echo 'Bill Number : '.$res2billnumber.'&nbsp;';
	echo '<br>Bill Date : '.$res2transactiondate;
	?></strong>&nbsp;
    </div>
	</td>
  </tr>
  
  <tr>
  <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
 
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table  
             cellspacing="0" cellpadding="4" width="660" 
            align="left" border="0">
          <tbody>
           
            <tr>
              <td class="bodytext31" width="13%" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				 <td width="44%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Description </strong></div></td>
				<td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Quantity  </strong></div></td>
				<td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rate  </strong></div></td>
              <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong> Amount </strong></div></td>
                
              </tr>
			
            
			<?php
			$colorloopcount = '';
			$sno = '';
			
			$query1 = "select * from consultation_lab where patientvisitcode = '$res2visitcode' and patientcode = '$res2patientcode' and paymentstatus = 'completed'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
		    $res1labitemname = $res1['labitemname'];
			$res1labitemrate = $res1['labitemrate'];
			
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
			  <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res1labitemname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($res1labitemrate,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($res1labitemrate,2,'.',','); ?></div></td>
              </tr>
			  <?php
			}
			?>
			
			<?php
			$colorloopcount = '';
			
			
			$query2 = "select * from consultation_radiology where patientvisitcode = '$res2visitcode' and patientcode = '$res2patientcode' and paymentstatus = 'completed'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
		    $res2radiologyitemname = $res2['radiologyitemname'];
			$res2radiologyitemrate = $res2['radiologyitemrate'];
			
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
			  <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2radiologyitemname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($res2radiologyitemrate,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($res2radiologyitemrate,2,'.',','); ?></div></td>
              </tr>
			  <?php
			}
			?>
			
			<?php
			$colorloopcount = '';
			
			
			$query3 = "select * from consultation_services where patientvisitcode = '$res2visitcode' and patientcode = '$res2patientcode' and paymentstatus = 'completed'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res3 = mysqli_fetch_array($exec3))
			{
		    $res3servicesitemname = $res3['servicesitemname'];
			$res3servicesitemrate = $res3['servicesitemrate'];
			
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
			  <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res3servicesitemname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($res3servicesitemrate,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($res3servicesitemrate,2,'.',','); ?></div></td>
              </tr>
			  <?php
			}
			?>
			
			<?php
			$colorloopcount = '';
			
			
			$query4 = "select * from master_consultationpharmissue where patientvisitcode = '$res2visitcode' and patientcode = '$res2patientcode' and recordstatus = 'completed'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res4 = mysqli_fetch_array($exec4))
			{
		    $res4medicinename = $res4['medicinename'];
			$res4amount = $res4['amount'];
			$res4prescribed_quantity = $res4['prescribed_quantity'];
			$res4rate = $res4['rate'];
			
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
			  <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res4medicinename; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $res4prescribed_quantity; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($res4rate,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($res4amount,2,'.',','); ?></div></td>
              </tr>
			  <?php
			}
			
			?>
<tr>
<td>&nbsp;
</td>
</tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong> Payment Mode: <?php echo $res2transactionmode; ?></strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>Total:</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong><?php echo number_format($res2transactionamount,2,'.',','); ?></strong></td>
                  </tr>
				  <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>Cash Given:</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong><?php echo number_format($res2cashgivenbycustomer,2,'.',','); ?></strong></td>
                  </tr>
				  <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>Change Returned:</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong><?php echo number_format($res2cashgiventocustomer,2,'.',','); ?></strong></td>
				</tr>	
				  
          </tbody>
        </table></td>
      </tr>
    </table>
</table>
  
	<tr>
	 <td>&nbsp;</td>
	</tr>
	<tr>
	 <td>&nbsp;</td>
	</tr>
	<tr>
	 <td>&nbsp;</td>
	</tr>
				  
	<?php
	include ('convert_currency_to_words.php');
	$convertedwords = covert_currency_to_words($res2transactionamount); ?>
<table>
	<tr>
	<td><strong>Amount In Word:</strong> <?php echo $convertedwords; ?></td>
	</tr>
</table>

<tr>
	 <td>&nbsp;</td>
	</tr>
	<tr>
	 <td>&nbsp;</td>
	</tr>
	<tr>
	 <td>&nbsp;</td>
	</tr>
	
<table cellspacing="0" cellpadding="4" width="660" align="left" border="0">
 <tr>
	<td>
	<div align="right">
	<?php
	echo "<strong>".'Served By : '."</strong>".$res2username.'&nbsp;';
	echo '<br> '.$res2transactiondate.'&nbsp;'.$res2transactiontime[0]. ':' .$res2transactiontime[1];
	?>&nbsp;
    </div>
	</td>
  </tr>
</table>	
</body>