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
header('Content-Disposition: attachment;filename="dispatch_subtype_detailed_report-list.xls"');
header('Cache-Control: max-age=80');


if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }


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
  
    <td  valign="top">
	<table width="100%" border="1" cellspacing="0" cellpadding="0">
    <tbody>
		  
		    <tr><td  colspan="10" valign="middle"  ><strong>Dispatched Bills From <?php echo $ADate1;?> To <?php echo $ADate2;?></strong></td></tr>
	  
	  
			<tr>
				  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31" width="5%"><strong>Sno</strong></td>
				  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="5%"><strong>DoC No</strong></td>
				  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="12%"><strong>Bill No</strong></td>
				  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="10%"><strong>Bill Date</strong></td>
				  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="25%"><strong>Patient Name</strong></td>
				  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="10%"><strong>Patient Code</strong></td>
				 <!-- <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="10%"><strong>Visit Code</strong></td>-->
				  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="15%"><strong>Provider</strong></td>
				  <!--<td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="15%"><strong>Account</strong></td>-->
				  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="10%"><strong>Bill Amt.</strong></td>
				  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="15%"><strong>Dispatched By</strong></td>
				  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="25%"><strong>Dispatched Date</strong></td>
			</tr>
          
           
	  
	  
	  
			<?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
				$grandtot='0.00';
				if($searchsuppliername!='')
			    $query25 = "select auto_number,subtype from master_subtype where  subtype = '$searchsuppliername'";
				else
				$query25 = "select auto_number,subtype from master_subtype ";	
				$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res25 = mysqli_fetch_array($exec25)) {
				$searchsubtypeanum1 = $res25['auto_number'];
				$searchsubtype = $res25['subtype'];
				
				if($location!=''){
				$loct="and locationcode='$location'";
				}else{
				$loct="and locationcode like '%%'";
				}
				
				$query241 = "select sum(totalamount) as subtype_amount from completed_billingpaylater where date(updatedate) between '$ADate1' and '$ADate2' and subtype='$searchsubtype' $loct  order by updatedate desc";
				$exec241 = mysqli_query($GLOBALS["___mysqli_ston"], $query241) or die ("Error in Query241".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res241 = mysqli_fetch_array($exec241);
				if($res241['subtype_amount']>0){
			?>
			
						
			<tr bgcolor="#cbdbfa" >
              <th colspan="7"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $searchsubtype;?></strong></th>
			  <th colspan="1"  align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($res241['subtype_amount'],2,'.',',');?></strong></th>
				<th colspan="2"  align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</th>
            </tr>
			<tbody >
			<?php
						$indtot='0.00';
						$query24 = "select * from completed_billingpaylater where date(updatedate) between '$ADate1' and '$ADate2' and subtype='$searchsubtype' $loct  and totalamount>'0'  order by updatedate desc";
			
						$colorloopcount = 0;
						$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
		                while($res24 = mysqli_fetch_array($exec24)) {
						$grandtot+=$res24['totalamount'];
						$indtot+=$res24['totalamount'];
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
						<td class="bodytext31" valign="center"  align="left"><?php echo $res24['batch']; ?></td>
						<td class="bodytext31" valign="center"  align="left"><?php echo $res24['billno']; ?></td>
						<td class="bodytext31" valign="center"  align="left"><?php echo date("d/m/Y", strtotime($res24['billdate'])); ?></td>
						<td class="bodytext31" valign="center"  align="left"><?php echo $res24['patientname']; ?></td>
						<td class="bodytext31" valign="center"  align="left"><?php echo $res24['patientcode']; ?></td>
						<!--<td class="bodytext31" valign="center"  align="left"><?php echo $res24['visitcode']; ?></td>-->
						<td class="bodytext31" valign="center"  align="left"><?php echo $res24['subtype']; ?></td>
						<!--<td class="bodytext31" valign="center"  align="left"><?php //echo $res24['accountname']; ?></td>-->
						<td class="bodytext31" valign="center"  align="right"><?php echo number_format($res24['totalamount'],2,'.',','); ?></td>
						<td class="bodytext31" valign="center"  align="left"><?php echo $res24['username']; ?></td>
						<td class="bodytext31" valign="center"  align="left"><?php echo date("d/m/Y H:i:s", strtotime($res24['updatedate'])); ?></td>

                       </tr>
					   <?php } ?>
						<tr >
						<td class="bodytext31" valign="center" colspan="7" align="right"><strong>Total:</strong></td>
						<td class="bodytext31" valign="center"  align="right" colspan="1"><strong><?php echo number_format($indtot,2,'.',','); ?><strong></td>
						<td class="bodytext31" valign="center"  align="left" colspan="2">&nbsp;</td>
                </tr>
				</tbody>
                 <tr><td colspan="10">&nbsp;</td></tr>

				<?php }  } ?>
				<tr >
						<td class="bodytext31" valign="center" colspan="7" align="right"><strong>Grand Total:</strong></td>
						<td class="bodytext31" valign="center"  align="right" colspan="1"><strong><?php echo number_format($grandtot,2,'.',','); ?><strong></td>
						<td class="bodytext31" valign="center"  align="left" colspan="2">&nbsp;</td>
                </tr>
				<?php } ?>
        
      <tr>
        <td colspan="10">&nbsp;</td>
      </tr>
       
	  </tbody>
    </table>
	</td>
	</tr>
</table>

