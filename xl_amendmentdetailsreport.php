<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];	
$companyname = $_SESSION['companyname'];

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
if (isset($_REQUEST["locationcode"])) { $locationcode  = $_REQUEST["locationcode"]; } else { $locationcode  = ""; }
if (isset($_REQUEST["auditype"])) { $auditype = $_REQUEST["auditype"]; } else { $auditype = ''; }
if (isset($_REQUEST["visittype"])) { $visittype = $_REQUEST["visittype"]; } else { $visittype = ''; }

$query1112 = "select * from master_location where locationcode = '$locationcode' and status<>'delete'";
$exec1112 = mysqli_query($GLOBALS["___mysqli_ston"], $query1112) or die ("Error in Query1112".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1112 = mysqli_fetch_array($exec1112))
{
 $locationname = $res1112["locationname"];    
 $locationcode = $res1112["locationcode"];
}
/*header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Amend Detail"'.$ADate1.'"_To_"'.$ADate1.'"Location"'.$locationname.'".xls');
header('Cache-Control: max-age=80');

*/
?>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.number
{
padding-left:690px;
text-align:right;
font-weight:bold;

}
-->
</style>
<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="" align="left" border="1">
     <tbody>
        <tr> <td colspan="6" align="center"><strong><u><h3>Amend Detail Report</h3></u></strong></td></tr> 
        <tr ><td colspan="6" align="center"><strong>Date From:    <?php echo date('d/m/Y',strtotime($ADate1));?>   To:  <?php echo date('d/m/Y',strtotime($ADate2));?></strong></td></tr>
        <tbody>
		
		<tr>
		<td colspan="6">
		<table width="" cellspacing="0" cellpadding="4" border="1" style="font-size:medium;">
		<tr>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
			<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code</strong></div></td>
			<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit Code</strong></div></td>
			<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Name</strong></div></td>
			<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Item Name</strong></div></td>
            <td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate</strong></div></td>
			
            <td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Service</strong></div></td>
			<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>            
			<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>User</strong></div></td>
			<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Remarks</strong></div></td>
			<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Address</strong></div></td>
			<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit Type</strong></div></td>
		</tr>
		<?php
			  

					$colorloopcount = '';
			        $sno = '';
					
					if($locationcode==''){
					$locationwise="and visitcode like '%%'";
					} else{
					$locationwise="and visitcode like '%-$locationcode'";
					}

					if($visittype=='all')
						$subqry ='';
					else
						$subqry =" and type='$visittype'";

                    if($auditype=='all')
					 $query1 = "select * from amendment_details where  amenddate between '$ADate1' and '$ADate2' $subqry $locationwise order by auto_number ";
					else
						$query1 = "select * from amendment_details where  amenddate between '$ADate1' and '$ADate2' and amendfrom='$auditype' $subqry $locationwise order by auto_number ";
			
					$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($res1 = mysqli_fetch_array($exec1))
					{
						$patientcode = $res1['patientcode'];
			            $visitcode = $res1['visitcode'];
						$patientname = $res1['patientname'];
						$itemname = $res1['itemname'];
						$amenddate = $res1['amenddate']." ".$res1['amendtime'];
						$amendfrom = $res1['amendfrom'];
						$amendby = $res1['amendby'];
						$ipaddress = $res1['ipaddress'];
						$type = $res1['type'];
						$remarks = $res1['remarks'];
						$rate = $res1['rate'];

						$colorloopcount = $colorloopcount + 1;
						
						?>
						<tr >
						  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
						  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $patientcode; ?></div></td>
						  <td class="bodytext31" valign="center"  align="left"><div align="center" ><?php echo $visitcode; ?></div></td>
						  <td class="bodytext31" valign="center"  align="left"><div align="center" ><?php echo $patientname; ?></div></td>
						  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $itemname; ?></div></td>
                            <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $rate; ?></div></td>
						   <td class="bodytext31" valign="center"  align="left"><div align="center" ><?php echo ucfirst(strtolower($amendfrom)); ?></div></td>
						  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo  $amenddate; ?></div></td>
						  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $amendby; ?></div></td>
						  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo  $remarks; ?></div></td>
						  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ipaddress; ?></div></td>
						  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $type; ?></div></td>
						</tr>
                   <?php
					}
					
			  	
			
			?>
		</table>
		</td>
		</tr>
		</tbody>
	 </tbody>
</table>
		
