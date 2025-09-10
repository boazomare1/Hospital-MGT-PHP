<html>
<?php include ("db/db_connect.php"); ?>
<?php
if (isset($_REQUEST["patientcode"])) {
 $patientcode = $_REQUEST["patientcode"]; 
 $visitcode= $_REQUEST['visitcode']; 
 $visitcode1=explode('-',$visitcode);
 $visitcodenew1=$visitcode1[1];
  /*$visitnum=strlen($visitcode);
      $vvcode6=str_split($visitcode);
				  $value6=arrayHasOnlyInts($vvcode6);
				  $visitcodepre6=$visitnum-$value6;
 $visitcodenew = substr($visitcode,$visitcodepre6,$visitnum);
echo $visitcodenew1 = intval($visitcodenew);*/
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
<td width="450" align="left" valign="middle" bgcolor="#ecf0f5" >
				  <table width="400" height="30">
				  <tr >
				  <td width="16%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5" >
				  <span class="bodytext3">Date </span></td>
				  <td width="22%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">Visit.No</span></td>
				  <td width="12%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">SYS</span></td>
				   <td width="12%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">DIA</span></td>
				  <td width="12%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">PULSE</span></td>
				 <td width="12%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">TEMP</span></td>
				   <td width="15%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">Case Sheet</span></td>
				  </tr>
				  <?php 
				  $colorloopcount = '';
				 $queryglance="select * from master_consultation where patientcode='$patientcode' group by patientvisitcode order by patientvisitcode DESC limit 0,3";
				  $execglance=mysqli_query($GLOBALS["___mysqli_ston"], $queryglance) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 
				  while($resglance=mysqli_fetch_array($execglance))
				  {
				  $date=$resglance['recorddate'];
				  $vcode=$resglance['patientvisitcode'];
				  
				  $vcode1=explode('-',$vcode);
			      $vcodenew1=$vcode1[1];
			 
				 /* $vcodenum=strlen($vcode);
					$vvcode=str_split($vcode);
				  $value=arrayHasOnlyInts($vvcode);
				  $visitcodepre=$vcodenum-$value;
				  $vcodenew=substr($vcode,$visitcodepre, $vcodenum);
				  $vcodenew1 = intval($vcodenew);*/
				  if($visitcodenew1>$vcodenew1)
				  {
				  $sys=$resglance['sys'];
				   $dia=$resglance['dia'];
				   $pulse=$resglance['pulse'];
				   $temp=$resglance['temp'];
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
				   <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $date; ?></div> </td>
			    <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $vcode; ?></div></td>
			 <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $sys; ?></div></td>
			    <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $dia; ?></div></td>
				  <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $pulse; ?></div></td>
			    <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $temp; ?></div></td>
				  <td class="bodytext3" valign="center"  align="left"><div align="center">Print</div></td>
				</tr>
				  <?php
				  }
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
				  <td width="6%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">Visit.No</span></td>
				  <td width="15%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">Past Complaints</span></td>
				   
				  </tr>
				  <?php 
				  $colorloopcount = '';
				 $querycom="select * from master_consultation where patientcode='$patientcode' group by patientvisitcode order by patientvisitcode DESC limit 0,3";
				  $execcom=mysqli_query($GLOBALS["___mysqli_ston"], $querycom) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  while($rescom=mysqli_fetch_array($execcom))
				  {
				  $date1=$rescom['recorddate'];
				  $vcode1=$rescom['patientvisitcode'];
				  
				   $vcode2=explode('-',$vcode1);
			       $vcodenew2=$vcode2[1];
				  
				  /* $vcodenum1=strlen($vcode1);
				   $vvcode1=str_split($vcode1);
				  $value1=arrayHasOnlyInts($vvcode1);
				  $visitcodepre1=$vcodenum1-$value1;
				  $vcodenew1=substr($vcode1,$visitcodepre1, $vcodenum1);
				  $vcodenew2 = intval($vcodenew1);*/
				  if($visitcodenew1>$vcodenew2)
				  {
				  $comp=$rescom['complaint'];
				  
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
				   <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $date1; ?></div> </td>
			    <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $vcode1; ?></div></td>
			 <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $comp; ?></div></td>
			
			   	</tr>
				  <?php
				  }
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
				  <td width="6%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">Visit.No</span></td>
				  <td width="15%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">Past Drug Allergy</span></td>
				     </tr>
				  <?php 
				  $colorloopcount = '';
				 $querydrug="select * from master_consultation where patientcode='$patientcode' group by patientvisitcode order by patientvisitcode DESC limit 0,2";
				  $execdrug=mysqli_query($GLOBALS["___mysqli_ston"], $querydrug) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  while($resdrug=mysqli_fetch_array($execdrug))
				  {
				  $date2=$resdrug['recorddate'];
				  $vcode2=$resdrug['patientvisitcode'];
				  
				   $vcode3=explode('-',$vcode2);
			       $vcodenew3=$vcode3[1];
				  
				 /*  $vcodenum2=strlen($vcode2);
				    $vvcode2=str_split($vcode2);
				  $value2=arrayHasOnlyInts($vvcode2);
				  $visitcodepre2=$vcodenum2-$value2;
				  $vcodenew2=substr($vcode2,$visitcodepre2, $vcodenum2);
				  $vcodenew3 = intval($vcodenew2);*/
				  if($visitcodenew1>$vcodenew3)
				  {
				  $drug=$resdrug['drugallergy'];
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
				   <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $date2; ?></div> </td>
			    <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $vcode2; ?></div></td>
			 <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $drug; ?></div></td>
			   	</tr>
				  <?php
				  }
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
				  <td width="6%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">Visit.No</span></td>
				  <td width="15%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">Past Food Allergy</span></td>
					  </tr>
				  <?php 
				  $colorloopcount = '';
				  $queryfood="select * from master_consultation where patientcode='$patientcode' group by patientvisitcode order by patientvisitcode DESC limit 0,2";
				  $execfood=mysqli_query($GLOBALS["___mysqli_ston"], $queryfood) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  while($resfood=mysqli_fetch_array($execfood))
				  {
				  $date3=$resfood['recorddate'];
				  $vcode3=$resfood['patientvisitcode'];
				  
				   $vcode4=explode('-',$vcode3);
			       $vcodenew4=$vcode4[1];
				  
				  /* $vcodenum3=strlen($vcode3);
				    $vvcode3=str_split($vcode3);
				  $value3=arrayHasOnlyInts($vvcode3);
				  $visitcodepre3=$vcodenum3-$value3;
				  $vcodenew3=substr($vcode3,$visitcodepre3,$vcodenum3);
				  $vcodenew4 = intval($vcodenew3);*/
				  if($visitcodenew1>$vcodenew4)
				  {
				  $food=$resfood['foodallergy'];
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
				   <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $date3; ?></div> </td>
			    <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $vcode3; ?></div></td>
			 <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $food; ?></div></td>
			   	</tr>
				  <?php
				  }
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
				  <td width="6%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">Visit.No</span></td>
				  <td width="15%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">Previous Medication</span></td>
					  </tr>
				  <?php 
				  
				  $colorloopcount = '';
				 $querymed="select * from master_consultationpharm where patientcode='$patientcode' group by patientvisitcode order by patientvisitcode DESC limit 0,3";
				  $execmed=mysqli_query($GLOBALS["___mysqli_ston"], $querymed) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  while($resmed=mysqli_fetch_array($execmed))
				  {
				  $medname='';
				  $date4=$resmed['recorddate'];
				  $vcode4=$resmed['patientvisitcode'];
				  
				   $vcode5=explode('-',$vcode4);
			       $vcodenew5=$vcode5[1];
				  
				  /* $vcodenum4=strlen($vcode4);
				     $vvcode4=str_split($vcode4);
				  $value4=arrayHasOnlyInts($vvcode4);
				  $visitcodepre4=$vcodenum4-$value4;
				  $vcodenew4=substr($vcode4,$visitcodepre4, $vcodenum4);
				  $vcodenew5 = intval( $vcodenew4);*/
				  if($visitcodenew1>$vcodenew5)
				  {
				  $querymed1="select * from master_consultationpharm where patientcode='$patientcode' and patientvisitcode='$vcode4'";
				  $execmed1=mysqli_query($GLOBALS["___mysqli_ston"], $querymed1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  $nummed1=mysqli_num_rows($execmed1);
				  while($resmed1=mysqli_fetch_array($execmed1))
				  {
				 $med=$resmed1['medicinename'];
				 $medname=$med.','. $medname;
				
				 }
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
				   <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $date4; ?></div> </td>
			    <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $vcode4; ?></div></td>
			 <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $medname; ?></div></td>
			   	</tr>
				  <?php
				  }
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
				  <td width="7%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">Visit.No</span></td>
				  <td width="15%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">Previous Lab Test</span></td>
				   <td width="4%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">Result</span></td>
				  </tr>
				  <?php 
				  $colorloopcount = '';
				 $querylab="select * from consultation_lab where patientcode='$patientcode' group by patientvisitcode order by patientvisitcode DESC limit 0,3";
				  $execlab=mysqli_query($GLOBALS["___mysqli_ston"], $querylab) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  while($reslab=mysqli_fetch_array($execlab))
				  {
				  $labname='';
				  $date5=$reslab['consultationdate'];
				  $vcode5=$reslab['patientvisitcode'];
				  
				   $vcode6=explode('-',$vcode5);
			       $vcodenew6=$vcode6[1];
				  
				/*  $vcodenum5=strlen($vcode5);
				      $vvcode5=str_split($vcode5);
				  $value5=arrayHasOnlyInts($vvcode5);
				  $visitcodepre5=$vcodenum5-$value5;
				  $vcodenew5=substr($vcode5, $visitcodepre5,$vcodenum5);
				  $vcodenew6 = intval($vcodenew5);*/
				  if($visitcodenew1>$vcodenew6)
				  {
				   $querylab1="select * from consultation_lab where patientcode='$patientcode' and patientvisitcode='$vcode5'";
				  $execlab1=mysqli_query($GLOBALS["___mysqli_ston"], $querylab1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  $numlab1=mysqli_num_rows($execlab1);
				  while($reslab1=mysqli_fetch_array($execlab1))
				  {
				 $lab=$reslab1['labitemname'];
				 $labname=$lab.','. $labname;
				}
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
				   <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $date5; ?></div> </td>
			    <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $vcode5; ?></div></td>
			 <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $labname; ?></div></td>
			 <td class="bodytext3" valign="center"  align="left"><div align="center"><a target="_blank" href="view_emr_labresults.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $vcode5; ?>">View</a></div></td>
			 
			
			   	</tr>
				  <?php
				  }
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
				  <td width="7%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">Visit.No</span></td>
				  <td width="15%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">Previous Radiology Test</span></td>
				   <td width="4%" align="center" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				  <span class="bodytext3">Result</span></td>
				  </tr>
				  <?php 
					  $colorloopcount = '';
					  $queryrad="select * from consultation_radiology where patientcode='$patientcode' group by patientvisitcode order by patientvisitcode DESC limit 0,3";
					  $execrad=mysqli_query($GLOBALS["___mysqli_ston"], $queryrad) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						  while($resrad=mysqli_fetch_array($execrad))
							  {
								  $radname='';
								  $date6=$resrad['consultationdate'];
								  $vcode6=$resrad['patientvisitcode'];
								  $resraddocnumber=$resrad['docnumber'];
								  
								   $vcode7=explode('-',$vcode6);
							 	   $vcodenew7=$vcode7[1];
								  
/*								  $vcodenum6=strlen($vcode6);
								  $vvcode6=str_split($vcode6);
								  $value6=arrayHasOnlyInts($vvcode6);
								  $visitcodepre6=$vcodenum6-$value6;
								  $vcodenew7=substr($vcode6, $visitcodepre6,$vcodenum6);
								  $vcodenew7 = intval($vcodenew7);*/
									  if($visitcodenew1>$vcodenew7)
									  {
										   $queryrad1="select * from consultation_radiology where patientcode='$patientcode' and patientvisitcode='$vcode6' and docnumber = '$resraddocnumber' ";
										  $execrad1=mysqli_query($GLOBALS["___mysqli_ston"], $queryrad1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
										  $numrad1=mysqli_num_rows($execrad1);
											  while($resrad1=mysqli_fetch_array($execrad1))
											  {
												 $rad=$resrad1['radiologyitemname'];
												 $radname=$rad.','. $radname;
											  }
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
			    <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $vcode6; ?></div></td>
			 <td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $radname; ?></div></td>
			 <td class="bodytext3" valign="center"  align="left"><div align="center"><a target="_blank" href="radiologyresultsview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $vcode6; ?>&&docnumber=<?php echo $resraddocnumber; ?>">View<br>
			 </a></div></td>
			   	</tr>
				  <?php
				                            }
				  }
				  ?>
				  </table>
    </td>
</tr>
<tr>
<td class="bodytext3" valign="center"  align="left" style="color:#0000FF;"><div style="padding-left:30px; cursor:pointer; text-decoration:underline;"><strong><a onClick="return emrsheet('<?php echo $visitcode; ?>');">Current Visit Case Sheet</a></strong></div></td>
</tr>
</table>
</body>
</html>