<html>
<?php include ("db/db_connect.php"); ?>
<?php




if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; 
$ADate1 = date('Y-m-d',strtotime('-1 month'));
$ADate2 = date('Y-m-d');
$name2=$_REQUEST['name'];
$visitcode= $_REQUEST['visitcode'];
$patientcode1=$_REQUEST['patientcode'];
$visitnum=strlen($visitcode);
      $vvcode6=str_split($visitcode);
				  $value6=arrayHasOnlyInts($vvcode6);
				  $visitcodepre6=$visitnum-$value6;
$visitcodenew = substr($visitcode,$visitcodepre6,$visitnum);
$visitcodenew1 = intval($visitcodenew);
$query2="select priliminarysis from master_consultationlist where patientcode='$patientcode1'";
$exe2=mysqli_query($GLOBALS["___mysqli_ston"], $query2);
$res0=mysqli_fetch_array($exe2);
$priliminary=$res0["priliminarysis"];

} 
else { $patientcode = "";
 $visitcode=""; }
 
	function arrayHasOnlyInts($array)
{
$count=0;
$count1=0;
    foreach ($array as $key => $value)
    {
        if (is_numeric($value)) // there are several ways to do this
        {
		$count1++;    
		
        }
		else
		{
		$count=$count+1;
		
		}
    }
    return $count1; 
}				
?>
<style>
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
</style>
<script>
function emrsheet(visitcode)
{
	window.open("emrcasesheet_popup.php?visitcode="+visitcode+"", "NewWindow", "height="+window.outerHeight+", width="+window.outerWidth+"");	
}
</script>
<body>
<table>


<tr>
<td align="center" valign="middle" class="bodytext3"><strong>Completed Results</strong></td>
</tr>


<tr>
<td width="400" align="left" valign="middle" bgcolor="#ecf0f5" >
				  <table width="400" height="30">
				  <tr>
				  <td width="5%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">Date </span></td>
				  				  <td width="15%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">Lab Test</span></td>
				   <td width="4%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">Result</span></td>
				  </tr>
				  <?php 
				  $colorloopcount = '';
				  $sno = 0;
				  $result_countno=0;
		 $query1 = "select itemcode,itemname,recorddate,docnumber from resultentry_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and  resultstatus='completed' and publishstatus = 'completed' group by docnumber order by auto_number desc";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		$itemcode = $res1['itemcode'];
		$itemname = $res1['itemname'];
		$date5 = $res1['recorddate'];
		$docnumber = $res1['docnumber'];

				 	  $colorloopcount = $colorloopcount + 1;
					  $sno = $sno + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFFFFF"';
			}

				  $result_countno=1;
				  ?>
				  <tr <?php echo $colorcode; ?>>
				   <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $date5; ?></div> </td>
			   
			 <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $itemname; ?></div></td>
			 <td class="bodytext3" valign="center"  align="left"><div align="center"><a target="_blank" href="labresultsview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $docnumber; ?>">View</a></div></td>
			 
			
			   	</tr>
				  <?php
				 
				  }
				  
		$query101 = "select labitemcode,labitemname,consultationdate from consultation_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and  resultentry='pending' order by auto_number desc";
		$exec101 = mysqli_query($GLOBALS["___mysqli_ston"], $query101) or die ("Error in Query101".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num101=mysqli_num_rows($exec101);
		
		while($res101 = mysqli_fetch_array($exec101))
		{
		$labitemcode = $res101['labitemcode'];
		$labitemname = $res101['labitemname'];
		$consultationdate = $res101['consultationdate'];
		//$docnumber = $res101['docnumber'];

				 	  $colorloopcount = $colorloopcount + 1;
					  $sno = $sno + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
				  ?>
				  <tr <?php echo $colorcode; ?>>
				   <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div> </td>
			   
			 <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $labitemname; ?></div></td>
<!--			 <td class="bodytext3" valign="center"  align="left"><div align="center"><a target="_blank" href="labresultsview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Pending</a></div></td>
-->	
 <td class="bodytext3" valign="center"  align="left"><div align="center">Pending</div></td>			
			   	</tr>
				  
				  
				  
				  
				 <?php
		}
				  if($result_countno > 0)
				  {
				  ?>
				  <tr>
				  <td class="bodytext3" valign="center"  align="left"><a target="_blank" href="print_labresultsfull1.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>">View All</a></td>
				  </tr>
				  <?php
				  }
				  ?>
				  </table>
				  </td>
</tr>
<tr>
<td width="400" align="left" valign="middle" bgcolor="#ecf0f5" >
				  <table width="400" height="30">
				  <tr >
				  <td width="5%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">Date </span></td>
								  <td width="15%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3"> Radiology Test</span></td>
				   <td width="4%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">Result</span></td>
				  </tr>
				  <?php 
					  $colorloopcount = '';
		$query11 = "select * from resultentry_radiology where patientcode='$patientcode' and patientvisitcode='$visitcode' order by auto_number desc";
		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num11=mysqli_num_rows($exec11);
		
		while($res11 = mysqli_fetch_array($exec11))
		{
		$itemname = $res11['itemname'];
		$itemcode = $res11['itemcode'];
		$date6 = $res11['recorddate'];
		$resraddocnumber = $res11['docnumber'];
		
/*		$query32 = "select * from consultation_radiology where radiologyitemcode='$itemcode' and patientvisitcode='$visitcode'";
			$exec32 = mysql_query($query32) or die(mysql_error());
			$res32 = mysql_fetch_array($exec32);
			$result = $res32['resultentry'];
			
			if($result == 'completed')
			
			{
*/	
		    $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
				  ?>
				  <tr <?php echo $colorcode; ?>>
				   <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $date6; ?></div> </td>
			   
			 <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $itemname; ?></div></td>
			 <td class="bodytext3" valign="center"  align="left"><div align="center"><a target="_blank" href="radiologyresultsview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $resraddocnumber; ?>">View<br>
			 </a></div></td>
			   	</tr>
				  <?php
			//}	                          
				  }
				  
		 $query321 = "select * from consultation_radiology where  patientcode='$patientcode' and patientvisitcode='$visitcode' and resultentry='pending'";
			$exec321 = mysqli_query($GLOBALS["___mysqli_ston"], $query321) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res321 = mysqli_fetch_array($exec321))
			{
		$radiologyitemname = $res321['radiologyitemname'];
		$radiologyitemcode = $res321['radiologyitemcode'];
		$consultationdate = $res321['consultationdate'];
		$resraddocnumber='';
		    $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
				  ?>
				  <tr <?php echo $colorcode; ?>>
				   <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div> </td>
			   
			 <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $radiologyitemname; ?></div></td>
				 <td class="bodytext3" valign="center"  align="left"><div align="center">Pending</div></td>      
			   	</tr>
				  <?php
				  }
				  ?>
				  
				  
				  </table>
    </td>
</tr>
<tr>
<td class="bodytext3" valign="center"  align="left" style="color:#0000FF;"><input type="checkbox" name="testview" id="testview"> &nbsp; <strong>Check to Complete Review</strong></td>
</tr>
<tr>
<td class="bodytext3" valign="center"  align="left" style="color:#0000FF;"><div style="padding-left:30px; cursor:pointer; text-decoration:underline;"><strong><a onClick="return emrsheet('<?php echo $visitcode; ?>');">Current Visit Case Sheet</a></strong></div></td>
</tr>
<tr>
<td class="bodytext3" valign="center"  align="left"></td>
</tr>
<tr>
<td class="bodytext3" valign="center"  align="left">

<strong>Doctor:&nbsp;</strong>
<?php echo $name2;?>
</td>
</tr>
<tr>
<td class="bodytext3" valign="center"  align="left">
<strong>Priliminary:&nbsp;</strong><?php echo $priliminary;?>
</td>

</tr>
</table>
</body>
</html>