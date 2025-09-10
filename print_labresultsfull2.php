<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
//include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly1 = date("Y-m-d");
$timeonly= date("H:i:s");
$titlestr = 'SALES BILL';
$colorloopcount = '';
$sno = '';
$pagebreak = '';

ob_start();

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode= $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["ADate1"])) { $fromdate = $_REQUEST["ADate1"]; } else { $fromdate = ""; }
if (isset($_REQUEST["ADate2"])) { $todate = $_REQUEST["ADate2"]; } else { $todate = ""; }
if (isset($_REQUEST["docnumber"])) { $docnumber = $_REQUEST["docnumber"]; } else { $docnumber = ""; }

$query612 = "select * from consultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and resultdoc = '$docnumber' order by auto_number desc";
$exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res612 = mysqli_fetch_array($exec612);
$orderedby = $res612['username'];
$Patientname=$res612['patientname'];
$accountname=$res612['accountname'];
$accountcode=$res612['accountcode'];
$doctor=$res612['doctor'];
$locationname=$res612['locationname'];
//$docno=$res612['resultdoc'];
$samplecollectedon=$res612['consultationdate'];
//$dob = $res612['dateofbirth'];
$billdatetime = $res612['sampledatetime'];
$sampleid = $res612['sampleid'];
$res38publisheddatetime = $res612['publishdatetime'];

$query613 = "select * from resultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number desc";
$exec613 = mysqli_query($GLOBALS["___mysqli_ston"], $query613) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res613 = mysqli_fetch_array($exec613);
$docno = $res613['docnumber'];


$query123 = "select * from samplecollection_lab where patientcode = '$patientcode' and sampleid = '$sampleid' order by auto_number desc";
$exec123 = mysqli_query($GLOBALS["___mysqli_ston"], $query123) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res123 = mysqli_fetch_array($exec123);
$res123recordtime=$res123['recordtime'];
$res123recorddate=$res123['recorddate'];

?>
<?php 
$query2 = "select * from master_company where auto_number = '$companyanum'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$companyname = $res2["companyname"];
$address1 = $res2["address1"];
$address2 = $res2["address2"];
$area = $res2["area"];
$city = $res2["city"];
$pincode = $res2["pincode"];
$emailid1 = $res2["emailid1"];
$phonenumber1 = $res2["phonenumber1"];
$phonenumber2 = $res2["phonenumber2"];
$faxnumber1 = $res2["faxnumber1"];
$cstnumber1 = $res2["cstnumber"];
$website = $res2["emailid2"];

$location= $locationname;

$query8="select * from master_employee where username = '$username' ";
$exec8=mysqli_query($GLOBALS["___mysqli_ston"], $query8);
$num8=mysqli_num_rows($exec8);
$res8=mysqli_fetch_array($exec8);
$res8jobdescription=$res8['jobdescription'];

if($patientcode != 'walkin')
{
$query5 = "select * from master_customer where customercode = '$patientcode'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);
$area12 = $res5['area'];
$fileno5 = $res5['fileno'];
$patientage=$res5['age'];
$patientgender=$res5['gender'];
$dob = $res5['dateofbirth'];
}
else
{
$query77 = "select * from consultation_lab where resultdoc = '$docnumber'";
  $exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res77=mysqli_fetch_array($exec77);
$billnumber=$res77['billnumber'];
  $locationcode=$res78['locationcode'];
  
  $query771 = "select * from billing_external where billno = '$billnumber'";
  $exec771=mysqli_query($GLOBALS["___mysqli_ston"], $query771) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res771=mysqli_fetch_array($exec771);
$patientage=$res771['age'];
 $patientgender=$res771['gender'];
 $dob = '0000-00-00';
}

if($dob != '0000-00-00')
{
	$today = new DateTime();
    $diff = $today->diff(new DateTime($dob));
	$diff1 = $diff->format('%y||%m||%d');
	$dayssplit = explode('||',$diff1);
	$year = $dayssplit[0];
	if($year > 1){ $yearname = 'Years'; } else { $yearname = 'Year'; }
	$month = $dayssplit[1];
	if($month > 1){ $monthname = 'Months'; } else { $monthname = 'Month'; }
	$day = $dayssplit[2];
	if($day > 1){ $dayname = 'Days'; } else { $dayname = 'Day'; }
	if($year == 0 && $month != 0)
	{
		$dob1 = $month.' '.$monthname.' '.$day.' '.$dayname;
	}
	else if($year == 0 && $month == 0)
	{
		$dob1 = $day.' '.$dayname;
	}	
	else if($year != 0 && $month != 0)
	{
		$dob1 = $year.' '.$yearname.' '.$month.' '.$monthname;
	}
	else
	{
		$dob1 = $year.' '.$yearname;
	}
}
else
{
$dob1 = $patientage;
}	
?>
<style>
body {
    font-family: 'Arial'; font-size:11px;	 
}
.bodytext31{ font-size:13px; }
.bodytext27{ font-size:12px; }
#footer { position: fixed; left: 0px; bottom: -20px; right: 0px; height: 30px; }
#footer .page:after { content: counter(page, upper-roman); }
.style1 {
	font-size: 10px;
	font-weight: bold;
}
</style>
<?php //include('a4pdfheader.php'); ?>
  <table width="520" cellspacing="0" cellpadding="1" border="0">
	     <tr>
		    <td valign="top" rowspan="6" width="83" rowspan="0">
			  <?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3showlogo = mysqli_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
				
			<img src="logofiles/<?php echo $companyanum;?>.jpg" width="65" height="65" />
			
			<?php
			}
			?></td> 
			<td align="center" style="font-size:16px" class="bodytext21">
	        <?php
			$strlen3 = strlen($address1);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address1 = ' '.$address1.' ';
			}
			?>
			<strong><?php echo $companyname; ?></strong></td>
		    <td valign="top" rowspan="6" width="83" align="right">
			  <?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3showlogo = mysqli_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
				
			<img src="logofiles/2.jpg" width="65" height="65" />
			
			<?php
			}
			?></td> 
        </tr>
		   <tr>
	  </tr>
	    <tr>
		  <td align="center" class="bodytext23" style="font-size:13px">
            <?php
			$address2 = $area.''.$pincode.' '.$city;
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = ' '.$address2.' ';
			}
			?>
			<?php
			$address3 = "Tel: ".$phonenumber1.', '.$phonenumber2;
			$strlen3 = strlen($address3);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address3 = ' '.$address3.' ';
			}
			
			$labemail="Lab E-mail: laboratory@nhl.co.ug";
			$labemobile="Lab Mobile Number: 0706 34 62 42";
			$website="Website : www.nakaserohospital.com";
			?>
			<?php echo $address2.''.$address3; ?>
          </td>
  </tr>
            
            <tr>
              <td align="center" class="bodytext24" style="font-size:13px">
			<?php
			//$address5 = "Fax: ".$faxnumber1;
			$strlen3 = strlen($address5);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address5 = ' '.$address5;
			}
			?>
			<?php
			$address4 = " E-Mail: ".$emailid1;
			$strlen3 = strlen($address4);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address4 = ' '.$address4.' ';
			}
			?>
            <?php echo $address5.', '.$address4; ?>
              <?php echo '<br>'. $labemobile.'<br>'.$labemail.'<br>'.$website; ?>
          
            </td>
	 
        </tr>
			<tr>
			  <td align="center">&nbsp;</td>
			</tr>
			<tr>
     			<td align="center" style="font-size:12px;"><strong><?php echo $location; ?>&nbsp;</strong></td>
			</tr>
	       
	 		 <tr>
     			<td colspan="3" align="center" class="bodytext26" style="border-top:solid 0px #000000;"><strong>&nbsp;</strong></td>
			</tr>
</table>	

	<table width="520" border="0" cellspacing="0" cellpadding="2" style="border-top:solid 1px #000000;border-bottom:solid 1px #000000;">
	       
        <tr>
			<input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
			<input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
			<td width="40" class="bodytext27"><strong>Patient</strong></td>
		  <td width="120" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $Patientname; ?>
		 &nbsp; <?php if($patientcode !='') { echo '('.$patientcode.')' ; } ?>
	      <input name="customername" type="hidden" id="customer" value="<?php echo $Patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly="readonly"/>	      </td>
		  <td width="40" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>Lab No</strong> </td>
		  <td width="100" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $docno; ?></td>
		  <td width="40" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>Collected On</strong></td>
		  <td width="87" align="left" valign="top" class="bodytext27"><?php echo date('Y-M-d g:i:A',strtotime($samplecollectedon)); ?></td>
		</tr>
       
		<tr>
			<td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>Age</strong></td>
			<td align="left" valign="top" class="bodytext27"><?php echo $dob1; ?>
		  <input name="customercode" type="hidden" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly="readonly"/>	      </td>
			<td align="left" valign="top" class="bodytext27"><strong>Doctor</strong></td>
			<td align="left" valign="top" class="bodytext27"><?php echo $orderedby; ?></td>
			<td class="bodytext27"><strong>Sample Rcvd </strong></td>
		  <td class="bodytext27"><?php echo date('Y-M-d g:i:A',strtotime($billdatetime)); ?></td>
	  </tr>
	   <tr>
		  <td align="left" valign="top" class="bodytext27"><strong>Sex</strong></td>                
		  <td align="left" valign="top" class="bodytext27"><?php echo substr($patientgender, 0, 1);?></td>
		  <td align="left" valign="top" class="bodytext27"><strong>Account</strong></td>                
		  <td align="left" valign="top" class="bodytext27"><?php if($accountname != ''){ echo $accountname; }else{ echo 'SELF'; } ?></td>	
		  <td class="bodytext27"><strong>Reported On</strong></td>
		  <td class="bodytext27"><?php echo date('Y-M-d',strtotime($res123recorddate)).' '.date('g:i:A',strtotime($res123recordtime)); ?></td>
	  </tr>
	  <tr>
	  <?php if($accountcode != '') { ?>
	   	  <td align="left" valign="top" class="bodytext27"><strong>Acc No</strong></td>
		  <td align="left" valign="top" class="bodytext27"><?php echo $accountcode; ?></td>
	  <?php }else { ?>
	  	  <td align="left" valign="top" class="bodytext27"><strong>&nbsp;</strong></td>
		  <td align="left" valign="top" class="bodytext27"><?php //echo $area; ?></td>
	  <?php } ?>	  
        <input name="account" type="hidden" id="account" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly="readonly"/>
		  <td align="left" valign="top" class="bodytext27"><strong>Area</strong></td>	
		  <td align="left" valign="top" class="bodytext27"><?php echo $area12; ?></td>	
		  <td align="left" valign="top" class="bodytext27"><strong>File No</strong></td>
		  <td align="left" valign="top" class="bodytext27"><?php echo $fileno5; ?></td>	
	  </tr>	  
</table>
    <table width="519" border="0" cellpadding="1" cellspacing="2">
      <tr>
        <td colspan="6" align="left" valign="middle">&nbsp;</td>
      </tr>
	  <tr>
        <td colspan="6" align="left" valign="middle" class="bodytext31"><strong>Pending Tests :</strong></td>
      </tr>
	  <?php
	  $pendingtest = '';
	  $query68 = "select * from consultation_lab where patientcode = '$patientcode' and patientcode <> 'walkin' and patientvisitcode = '$visitcode' and resultentry <> 'completed' order by labitemname";
		$exec68 = mysqli_query($GLOBALS["___mysqli_ston"], $query68) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res68 = mysqli_fetch_array($exec68))
		{
		$labitemnamepending = $res68['labitemname'];
		if($pendingtest == '')
		{
			$pendingtest = $labitemnamepending;
		}
		else
		{
			$pendingtest = $pendingtest.', '.$labitemnamepending;
		}
		}	
		?>
		<tr>
        <td colspan="6" align="left" valign="middle"><strong><?php echo $pendingtest; ?></strong></td>
      </tr>
	
      <tr>
        <td colspan="6" align="center" valign="middle" style="font-size:16px; text-decoration:underline;"><strong>Laboratory Report</strong> </td>
      </tr>
      <tr>
        <td  align="left" valign="middle">&nbsp;</td>
	    <td  align="left" valign="middle">&nbsp;</td>
        <td  align="left" valign="middle">&nbsp;</td>
		<td  align="left" valign="middle">&nbsp;</td>
        <td align="left" valign="middle">&nbsp;</td>
		<td align="left" valign="middle">&nbsp;</td>
      </tr>
	  <?php
		$pagecount='';
		$itemnumbers=0;
	
	  $referencenumbers=0;
	  
	    $query616 = "select * from consultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and resultdoc = '$docnumber' order by auto_number desc";
		$exec616 = mysqli_query($GLOBALS["___mysqli_ston"], $query616) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res616 = mysqli_fetch_array($exec616);
		$res616itemcode = $res616['labitemcode'];
		$res616itemname = $res616['labitemname'];
		?>

      <tr>
        <td colspan="6" align="left" valign="middle" class="bodytext29"><strong><?php echo $res616itemname; ?></strong></td>
      </tr>
      <tr>
		<td width="132" align="left" valign="middle" class="bodytext29"><span class="style1">TESTS</span></td>
        <td width="46"  align="left" valign="middle" class="bodytext29"><span class="style1">RESULTS</span></td>
		<td width="35"  align="left" valign="middle" class="bodytext29"><span class="style1">UNIT</span></td>
		<td width="62"  align="left" valign="middle" class="bodytext29 style1">FLAG</td>
        <td width="54" align="left" valign="middle" class="bodytext29"><span class="style1">R.RANGE</span></td>
        <td width="150" align="left" valign="middle" class="bodytext29"><span class="style1">COMMENTS</span></td>
      </tr>
	<tr>
		<td colspan="6" align="left" valign="middle" class="bodytext31"><strong>&nbsp;</strong></td>
	</tr>
	<?php	
    $query34="select * from master_labreference where itemcode = '$res616itemcode' and status <> 'deleted' and (gender = '$patientgender' or gender='') and '$patientage' >= agefrom and '$patientage' < ageto group by subheader";
	$exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34);
	$num34=mysqli_num_rows($exec34);
	while($res34=mysqli_fetch_array($exec34))
	{
	$subheader = $res34['subheader'];
	?>
	<tr>
		<td colspan="6" align="left" valign="middle" class="bodytext31"><strong><?php echo $subheader; ?></strong></td>
	</tr>
	<?php
	$query38="select * from master_labreference where itemcode = '$res616itemcode' and subheader = '$subheader' and status <> 'deleted' and (gender = '$patientgender' or gender='') and '$patientage' >= agefrom and '$patientage' < ageto  order by reforder "; //and (gender = '$patientgender' or gender='') and '$patientage' >= agefrom and '$patientage' < ageto 
	$exec38=mysqli_query($GLOBALS["___mysqli_ston"], $query38);
	$num38=mysqli_num_rows($exec38);
	while($res38=mysqli_fetch_array($exec38))
	{
	$referencename1=$res38['referencename'];
	
	$query32="select * from resultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and referencename = '$referencename1' and docnumber = '$docnumber'  order by auto_number ";
	$exec32=mysqli_query($GLOBALS["___mysqli_ston"], $query32);
	$num32=mysqli_num_rows($exec32);
	$res32=mysqli_fetch_array($exec32);
	$resultvalue=$res32['resultvalue'];
	$resultvalue = str_replace('<','&lt;',$resultvalue);
	$resultvalue = str_replace('>','&gt;',$resultvalue);
	
	$sampletype = $res32['sampletype'];
	$referencename=$res32['referencename'];
	$referencerange=$res32['referencerange'];
	$referenceunit=$res32['referenceunit'];
	$referenceunit = str_replace('<','&lt;',$referenceunit);
	$referenceunit = str_replace('>','&gt;',$referenceunit);
	$res12referencename = $res32['referencename'];
	$color = $res32['color'];
	if($color == 'red') { $crit = 'H'; }
	else if($color == 'orange') { $crit = 'L'; }
	else if($color == 'green') { $crit = 'N'; }
	else { $crit = ''; }
	$refcomments = $res32['referencecomments'];
	$referencenumbers = $referencenumbers + 1;
	$refcomments = str_replace('border="1"','border="0"',$refcomments);		
		?>
	  
     <tr>
	 <td align="left" valign="top" class="bodytext31"><?php echo $res12referencename; ?></td>
	 <td align="left" valign="top" class="bodytext31"><?php echo $resultvalue; ?></td>
	 <td align="left" valign="top" class="bodytext31"><?php echo $referenceunit; ?></td>
	 <td align="center" valign="top" class="bodytext31" style="color:<?= $color ?>"><strong><?php echo $crit; ?></strong></td>
	 <td align="left" valign="top" class="bodytext31"><?php echo $referencerange; ?></td>
	 <td align="left" valign="top" class="bodytext31"><?php echo $refcomments; ?></td>
	</tr>
      <?php } 
	  $res38comment = '';
	  ?>
	  <?php if($res38comment !='') { ?>

			
	  <?php
		 }
		 }
	  ?>
	  <tr>
			  <td align="left" valign="middle" class="bodytext31">&nbsp;</td>
			  <td colspan="5" align="left" valign="middle" class="bodytext31">&nbsp;</td>
	  </tr>
	
     
	   <tr>
			  <td align="left" valign="middle" class="bodytext31">&nbsp;</td>
			  <td colspan="5" align="left" valign="middle" class="bodytext31">&nbsp;</td>
	  </tr>
	   <tr>
			  <td align="left" valign="middle" class="bodytext31">&nbsp;</td>
			  <td colspan="5" align="left" valign="middle" class="bodytext31">&nbsp;</td>
	  </tr>
	  <tr>
			  <td align="left" valign="middle" class="bodytext31">&nbsp;</td>
			  <td colspan="5" align="left" valign="middle" class="bodytext31">&nbsp;</td>
	  </tr>
	  <tr>
			  <td align="left" valign="middle" class="bodytext31">&nbsp;</td>
			  <td colspan="5" align="left" valign="middle" class="bodytext31">&nbsp;</td>
	  </tr>
  </table>
    
	 <table width="543" height="108" border="0" class="bodytext31">
	 
	 <tr>
        <td width="179">REVIEWED :&nbsp;&nbsp;------------------------------</td>
        <td width="172">SIGNATURE:&nbsp;&nbsp;------------------------------</td>
       
         <td width="178" colspan="2">DATE:&nbsp;&nbsp;------------------------------</td>
      </tr>
      <tr>
       	 <td width="179"><strong>Quality Manager/Laboratory Director</strong></td>
        <td width="172"><strong>LAB TECHNOLOGIST</strong> </td>
		
         <td width="178" colspan="2">Printed By: <?php echo strtoupper($res8jobdescription); ?></td>
      </tr>

      <tr>
        <td width="179">Reviewed By:&nbsp;<?php echo strtoupper($res4jobdescription); ?></td>
        <td width="172">Acknowledged By:&nbsp;<?php echo strtoupper($res41jobdescription); ?></td>
       
        <td width="178" colspan="2">Printed On: <?php echo date('Y-M-d g:i:A',strtotime($updatedatetime)); ?></td>
      </tr>
	  <tr>
        <td width="179">&nbsp;</td>
        <td width="172">&nbsp; </td>
       
        <td width="178" colspan="2">&nbsp;</td>
      </tr>
    </table>
	<table border="0" width="540" height="" id="footer">
		<tr>
			  <td colspan="4" align="center" valign="top" class="bodytext31">--------End of Report--------</td>
	  </tr>
	</table>
<?php	
require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4");
$dompdf->render();
$canvas = $dompdf->get_canvas();
//$canvas->line(10,800,800,800,array(0,0,0),1);
$font = Font_Metrics::get_font("times-roman", "normal");
$canvas->page_text(272, 814, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("LabResultsFull.pdf", array("Attachment" => 0)); 
?>
