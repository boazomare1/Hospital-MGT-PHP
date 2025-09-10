<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$updatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
ob_start();

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="dispatchedbills-list.xls"');
header('Cache-Control: max-age=80');


if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }


if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
//echo $ADate2;
?>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
  
    <td  valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    
	  <tr><td  colspan="4" valign="middle"  ></td></tr>
			<?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					
				if($locationcode==''){
					$locationcodenew= "and locationcode like '%%'";
				}else{
					$locationcodenew= "and locationcode = '$locationcode'";
				}

				$query24 = "select * from completed_billingpaylater where date(updatedate) between '$ADate1' and '$ADate2' $locationcodenew order by updatedate desc";
			?>

			<tr>
               <td colspan="4" >
			     <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
						 bordercolor="#666666" cellspacing="0" cellpadding="4" width="1032" 
						 align="left" border="1">
                        <tr><td  colspan="11" valign="middle"  ><strong>Dispatched Bills From <?php echo $ADate1;?> To <?php echo $ADate2;?></strong></td></tr>
						 <tr>
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31" width="5%"><strong>Sno</strong></td>
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="5%"><strong>Batch</strong></td>
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="12%"><strong>Bill No</strong></td>
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="10%"><strong>Bill Date</strong></td>
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="25%"><strong>Patient Name</strong></td>
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="10%"><strong>Patient Code</strong></td>
						 <!-- <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="10%"><strong>Visit Code</strong></td>-->
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="15%"><strong>Subtype</strong></td>
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="15%"><strong>Account</strong></td>
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="10%"><strong>Bill Amt.</strong></td>
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="15%"><strong>Dispatched By</strong></td>
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="25%"><strong>Dispatched Date</strong></td>
						</tr>
                        
						<?php
						$colorloopcount = 0;
						$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
		                while($res24 = mysqli_fetch_array($exec24)) {
							
						$patientcode=$res24['patientcode'];
						$visitcode=$res24['visitcode'];
						
						$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_visitentry where visitcode='$visitcode' and patientcode='$patientcode'");
						$execlab1=mysqli_fetch_array($querylab1);
						$scheme_id=$execlab1['scheme_id'];
						
						$queryplan=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_planname where scheme_id='$scheme_id'");
						$execplan=mysqli_fetch_array($queryplan);
						$scheme_name=$execplan['scheme_name'];

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
			            <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
						<td class="bodytext31" valign="center"  align="left"><?php echo $res24['printno']; ?></td>
						<td class="bodytext31" valign="center"  align="left"><?php echo $res24['billno']; ?></td>
						<td class="bodytext31" valign="center"  align="left"><?php echo $res24['billdate']; ?></td>
						<td class="bodytext31" valign="center"  align="left"><?php echo $res24['patientname']; ?></td>
						<td class="bodytext31" valign="center"  align="left"><?php echo $res24['patientcode']; ?></td>
						<!--<td class="bodytext31" valign="center"  align="left"><?php echo $res24['visitcode']; ?></td>-->
						<td class="bodytext31" valign="center"  align="left"><?php echo $res24['subtype']; ?></td>
						<td class="bodytext31" valign="center"  align="left"><?php echo $scheme_name; ?></td>
						<td class="bodytext31" valign="center"  align="right"><?php echo number_format($res24['totalamount'],2,'.',','); ?></td>
						<td class="bodytext31" valign="center"  align="left"><?php echo $res24['username']; ?></td>
						<td class="bodytext31" valign="center"  align="left"><?php echo $res24['updatedate']; ?></td>

                       </tr>
					   <?php } ?>


                 </table>
			   
			   </td>
			</tr>

			<?php } ?>
        
      <tr>
        <td>&nbsp;</td>
      </tr>
       
	  
    </table>
	</td>
	</tr>
</table>

