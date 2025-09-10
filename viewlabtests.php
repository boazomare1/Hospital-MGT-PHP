<?php
session_start();
include ("db/db_connect.php");
include ("includes/loginverify.php");

$updatedatetime = date("Y-m-d H:i:s");
$colorloopcount=0;
$sno=0;

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

if (isset($_REQUEST["ADate1"])) { $fromdate = $_REQUEST["ADate1"]; } else { $fromdate = ""; }

if (isset($_REQUEST["ADate2"])) { $todate = $_REQUEST["ADate2"]; } else { $todate = ""; }

if (isset($_REQUEST["docnumber"])) { $docnumber = $_REQUEST["docnumber"]; } else { $docnumber = ""; }

if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }


?>
<script type="text/javascript">
function viewmail(patientcode,visitcode,billdate,itemcode)
{
	var varpatientcode = patientcode;
	var varvisitcode = visitcode;
	var billdate = billdate;
	var itemcode = itemcode;
	
	
	//alert(billnumber);
NewWindow=window.open('labmail1.php?patientcode='+varpatientcode+'&&visitcode='+varvisitcode+'&&billdate='+billdate+'&&itemcode='+itemcode,'Window1','width=450,height=200,left=0,top=0,toolbar=No,location=No,scrollbars=No,status=No,resizable=Yes,fullscreen=No');
}
</script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 15px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
       <table width="442">
		    <tr>
			<td width="59" align="left" valign="center" class="bodytext3">
		    <strong>S.No.</strong></td>
			<td width="371" align="left" valign="center" class="bodytext3">
		     <strong>Test</strong></td>
			</tr>
		<?php
		$query23 = "select * from consultation_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and billnumber='$billnumber' and resultdoc <> ''";
		$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res23 = mysqli_fetch_array($exec23))
		{
		$docnumber = $res23['resultdoc'];
		
		$query7 = "select * from resultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and docnumber='$docnumber' and recorddate between '$fromdate' and '$todate' group by itemcode order by auto_number desc ";
		$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
			while($res7 = mysqli_fetch_array($exec7))
			{
			$res7patientname = $res7['patientname'];
			$res7regno = $res7['patientcode'];
			$res7visitno = $res7['patientvisitcode'];
			$res7billdate = $res7['recorddate'];
			$res7test = $res7['itemname'];
			$res7testcode = $res7['itemcode'];
			$res7collected = $res7['username'];
			$res7recordtime = $res7['recordtime'];
			
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
		
			<tr <?php echo $colorcode; ?>>
			  <td class="bodytext3" valign="center"  align="left"><?php echo $sno=$sno + 1; ?></td>
			  <td class="bodytext3" valign="center"  align="left"><?php echo $res7test; ?></td>
             
			</tr>
		
		<?php
		   } }
		?>   
		<?php
		$query24 = "select * from ipresultentry_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and recorddate between '$fromdate' and '$todate' group by patientvisitcode ";
		$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num24=mysqli_num_rows($exec24);
		while($res24 = mysqli_fetch_array($exec24))
		{
		$res24docnumber = $res24['docnumber'];
		$res24patientcode = $res24['patientcode'];
		$res24patientvisitcode= $res24['patientvisitcode'];
		
		$query8 = "select * from ipresultentry_lab where patientcode = '$res24patientcode' and patientvisitcode = '$res24patientvisitcode' and recorddate between '$fromdate' and '$todate' group by itemcode order by auto_number desc ";
		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		 $num8=mysqli_num_rows($exec8);
		
			while($res8 = mysqli_fetch_array($exec8))
			{
			$res8patientname = $res8['patientname'];
			$res8regno = $res8['patientcode'];
			$res8visitno = $res8['patientvisitcode'];
			$res8billdate = $res8['recorddate'];
			$res8test = $res8['itemname'];
			$res8testcode = $res8['itemcode'];
			$res8recordtime = $res8['recordtime'];
			
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
		
			<tr <?php echo $colorcode; ?>>
			  <td class="bodytext3" valign="center"  align="left"><?php echo $sno=$sno + 1; ?></td>
			  <td class="bodytext3" valign="center"  align="left"><?php echo $res8test; ?></td>
              
			   </td>
			</tr>
		
		<?php
		   } }
		?>   
  </table>
       