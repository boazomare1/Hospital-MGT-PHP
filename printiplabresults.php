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
$sno = '';

ob_start();

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode= $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["ADate1"])) { $fromdate = $_REQUEST["ADate1"]; } else { $fromdate = ""; }
if (isset($_REQUEST["ADate2"])) { $todate = $_REQUEST["ADate2"]; } else { $todate = ""; }
if (isset($_REQUEST["docnumber"])) { $docnumber = $_REQUEST["docnumber"]; } else { $docnumber = ""; }
?>

<style>
body {
    font-family: 'Arial'; font-size:11px;	 
}
.bodytext31{ font-size:13px; }
.bodytext27{ font-size:12px; }
#footer { position: fixed; left: 0px; bottom: -20px; right: 0px; height: 60px; }
#footer .page:after { content: counter(page, upper-roman); }
.style1 {
	font-size: 10px;
	font-weight: bold;
}
</style>

<?php 
 $query341 = "select * from ipresultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and docnumber = '$docnumber' group by itemcode order by auto_number";
$exec341 = mysqli_query($GLOBALS["___mysqli_ston"], $query341) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res341 = mysqli_fetch_array($exec341))
{
$labitemcode34 = $res341['itemcode'];
$res341recordtime=$res341['recordtime'];
$res341recorddate=$res341['recorddate'];
$query610="select registrationdate,consultationtime from master_ipvisitentry where patientcode = '$patientcode' and visitcode = '$visitcode'";
$exe610=mysqli_query($GLOBALS["___mysqli_ston"], $query610)or die("Error in Query610".mysqli_error($GLOBALS["___mysqli_ston"]));
$res610=mysqli_fetch_array($exe610);
$collectedon=$res610['registrationdate'];
$collectedtime=$res610['consultationtime'];

 $query612 = "select * from ipconsultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode'  and labitemcode='$labitemcode34'";
$exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res612 = mysqli_fetch_array($exec612);
$orderedby = $res612['username'];
$patientname=$res612['patientname'];
$accountname=$res612['accountname'];
$accountcode=$res612['accountcode'];
$doctor=$res612['doctor'];
$locationcode=$res612['locationcode'];
$locationname=$res612['locationname'];
//$docnumber=$res612['resultdoc'];
$samplecollectedon=$res612['consultationdate'];
$samplecollectedtime=$res612['consultationtime'];
//$dob = $res612['dateofbirth'];
$billdatetime = $res612['sampledatetime'];
$sampleid = $res612['sampleid'];
$res38publisheddatetime = $res612['sampledatetime'];
if($sampleid == '')
{
$query6130 = "select sampleid from ipresultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and itemcode='$labitemcode34' order by auto_number desc";
$exec6130 = mysqli_query($GLOBALS["___mysqli_ston"], $query6130) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res6130 = mysqli_fetch_array($exec6130);
$sampleid=$res6130['sampleid'];
	
}
$query613 = "select docnumber from ipresultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number desc";
$exec613 = mysqli_query($GLOBALS["___mysqli_ston"], $query613) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res613 = mysqli_fetch_array($exec613);
$docno = $docnumber;


 $query123 = "select * from ipsamplecollection_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and sampleid = '$sampleid'  and itemcode='$labitemcode34' order by auto_number desc";
$exec123 = mysqli_query($GLOBALS["___mysqli_ston"], $query123) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res123 = mysqli_fetch_array($exec123);
$res123recordtime=$res123['recordtime'];
$res123recorddate=$res123['recorddate'];
 
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

$location= $locationname;

$query8="select * from master_employee where username = '$username' ";
$exec8=mysqli_query($GLOBALS["___mysqli_ston"], $query8);
$num8=mysqli_num_rows($exec8);
$res8=mysqli_fetch_array($exec8);
$res8jobdescription=$res8['employeename'];

$query771 = "select * from master_ipvisitentry where patientcode = '$patientcode' and visitcode = '$visitcode'";
$exec771=mysqli_query($GLOBALS["___mysqli_ston"], $query771) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res771=mysqli_fetch_array($exec771);
$patientage=$res771['age'];
$patientgender=$res771['gender'];
$department=$res771['department'];
$dob = '0000-00-00';


 $warddate="select ward from master_ward where auto_number in(select ward from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus NOT IN ('discharged','transfered') )";
			
			$exeward=mysqli_query($GLOBALS["___mysqli_ston"], $warddate) or die("Error in Warddate".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$resward=mysqli_fetch_array($exeward);
		 	$ward=$resward['ward'];
			$bed=$resward['bed'];
			$numrow=mysqli_num_rows($exeward);
			if($numrow =='0')

{ 			$warddate1="select ward from master_ward where auto_number in(select ward from ip_bedtransfer where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus NOT IN ('discharged','transfered') )";
		
			$exeward1=mysqli_query($GLOBALS["___mysqli_ston"], $warddate1)or die("Error in Warddate".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resward1=mysqli_fetch_array($exeward1);
			$ward=$resward1['ward'];
			
			
}

 $beddate="select bed from master_bed where auto_number in(select bed from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus NOT IN ('discharged','transfered') )";
			
			$exebed=mysqli_query($GLOBALS["___mysqli_ston"], $beddate)or die("Error in Beddate".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$resbed=mysqli_fetch_array($exebed);
			$bed=$resbed['bed'];
			
			$numrow=mysqli_num_rows($exebed);
			if($numrow =='0')

{			$beddate="select bed from master_bed where auto_number in(select bed from ip_bedtransfer where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus NOT IN ('discharged','transfered') )";
		
			$exebed=mysqli_query($GLOBALS["___mysqli_ston"], $beddate)or die("Error in Beddate".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resbed=mysqli_fetch_array($exebed);
			$bed=$resbed['bed'];
			
			
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

  <!--  <page pagegroup="new" backtop="8mm" backbottom="7mm" backleft="5mm"  backright="3mm"> -->
	<table width="535"   cellspacing="0" cellpadding="1" border="0" align="" >
   
	 <tr>
	  <td width="116" valign="top" rowspan="6">
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
	  <td width="303" align="center" class="bodytext21" style="font-size:16px">
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
	  <td width="102" valign="top" rowspan="6" align="right">
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
	 <td width="303" align="center" class="printbodytext22" style="font-size:15px"><strong>ISO 15189 ACCREDITED</strong></td>
	</tr>
	<tr>
	 <td width="303" align="center" class="bodytext23" style="font-size:13px">
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
	 ?>
	 <?php echo $address2.','.$address3; ?></td>
   </tr>
   <tr>
	 <td width="303" align="center" class="bodytext24" style="font-size:13px">
	 <?php
	 $address5 = "Fax: ".$faxnumber1;
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
	 <?php echo $address5.', '.$address4; ?></td>
   </tr>
   <tr>
	<td colspan="6" align="center">&nbsp;</td>
   </tr>
   <tr>
	<td colspan="6" align="center" style="font-size:12px;"><strong><?php echo $location; ?>&nbsp;</strong></td>
   </tr>
   <tr>
	<td height="23" colspan="6" align="center" class="bodytext26"><strong>&nbsp;</strong></td>
   </tr>
  </table>
	<table width="525" cellspacing="0" cellpadding="1" border="0" style="border-top:solid 1px #000000;border-bottom:solid 1px #000000;">
    <tr>
    <td width="38" align="left" valign="top" class="bodytext27"><strong>&nbsp;</strong></td>
	    <td width="121" align="left" valign="top" class="bodytext27">&nbsp;
	     </td>
	    <td width="32" align="left" valign="top" class="bodytext27"><strong>&nbsp;</strong></td>
	    <td width="82" align="left" valign="top" class="bodytext27">&nbsp;</td>
	    <td width="64" align="left" valign="top" class="bodytext27"><strong> &nbsp;</strong></td>
	    <td width="37" align="left" valign="top" class="bodytext27">&nbsp;</td>
    </tr>
	  <tr>
	    <td width="38" align="left" valign="top" class="bodytext27"><strong>Patient</strong></td>
	    <td width="121" align="left" valign="top" class="bodytext27"><?php echo $patientname; ?>&nbsp;
	      <?php if($patientcode !='') { echo '('.$patientcode.')' ; } ?></td>
	    <td width="32" align="left" valign="top" class="bodytext27"><strong>Lab No</strong></td>
	    <td width="82" align="left" valign="top" class="bodytext27"><?php echo $docnumber; ?></td>
	    <td width="64" align="left" valign="top" class="bodytext27"><strong>Visit Date</strong></td>
	    <td width="37" align="left" valign="top" class="bodytext27"><?php echo date('Y-M-d',strtotime($collectedon)).' '.date('g:i:A',strtotime($collectedtime)); ?></td>
      </tr>
	  <tr>
	    <td width="38" align="left" valign="top" class="bodytext27"><strong>Age</strong></td>
	    <td width="121" align="left" valign="top" class="bodytext27"><?php echo $dob1; ?></td>
	    <td width="32" align="left" valign="top" class="bodytext27"><strong>Doctor</strong></td>
	    <td width="82" align="left" valign="top" class="bodytext27"><?php echo $doctor; ?></td>
	    <td width="64" align="left" valign="top" class="bodytext27"><strong>Requested On</strong></td>
	    <td width="37" align="left" valign="top" class="bodytext27"><?php echo date('Y-M-d',strtotime($samplecollectedon)).' '.date('g:i:A',strtotime($samplecollectedtime)); ?></td>
      </tr>
	  <tr>
	    <td width="38" align="left" valign="top" class="bodytext27"><strong>Sex</strong></td>
	    <td width="121" align="left" valign="top" class="bodytext27"><?php echo substr($patientgender, 0, 1);?></td>
	    <td width="32" align="left" valign="top" class="bodytext27"><strong>Account</strong></td>
	    <td width="82" align="left" valign="top" class="bodytext27"><?php if($accountname != ''){ echo $accountname; }else{ echo 'SELF'; } ?></td>
	    <td width="64" align="left" valign="top" class="bodytext27"><strong>Sample Rcvd </strong></td>
	    <td width="37" align="left" valign="top" class="bodytext27"><?php echo date('Y-M-d',strtotime($res123recorddate)).' '.date('g:i:A',strtotime($res123recordtime)); ?></td>
      </tr>
	  <tr>
	    <?php if($accountcode != '') { ?>
	    <td width="38" align="left" valign="top" class="bodytext27"><strong>Acc No</strong></td>
	    <td width="121" align="left" valign="top" class="bodytext27"><?php echo $accountcode; ?></td>
	    <?php }else { ?>
	    <td width="32" align="left" valign="top" class="bodytext27"><strong>&nbsp;</strong></td>
	    <td width="82" align="left" valign="top" class="bodytext27"><?php //echo $area; ?></td>
	    <?php } ?>
	    <td width="64" align="left" valign="top" class="bodytext27"><strong>Area</strong></td>
	    <td width="37" align="left" valign="top" class="bodytext27"><?php echo $area12; ?></td>
	    <td width="70" align="left" valign="top" class="bodytext27"><strong>Reported On</strong></td>
	    <td width="79" align="left" valign="top" class="bodytext27"><?php echo date('Y-M-d',strtotime($res341recorddate)).' '.date('g:i:A',strtotime($res341recordtime)); ?></td>
      </tr>
	  <tr>
	    <td width="38" align="left" valign="top" class="bodytext27"><strong>File No</strong></td>
	    <td width="121" align="left" valign="top" class="bodytext27"><?php echo $fileno5; ?></td>
	    <td width="32" align="left" valign="top" class="bodytext27"><strong>Ward</strong></td>
	    <td width="82" align="left" valign="top" class="bodytext27"><?php echo $ward; ?></td>
	    <td width="64" align="left" valign="top" class="bodytext27"><strong>Bed</strong></td>
	    <td width="37" align="left" valign="top" class="bodytext27"><?php echo $bed; ?></td>
      </tr>
        <tr>
    <td width="38" align="left" valign="top" class="bodytext27"><strong>&nbsp;</strong></td>
	    <td width="121" align="left" valign="top" class="bodytext27">&nbsp;
	     </td>
	    <td width="32" align="left" valign="top" class="bodytext27"><strong>&nbsp;</strong></td>
	    <td width="82" align="left" valign="top" class="bodytext27">&nbsp;</td>
	    <td width="64" align="left" valign="top" class="bodytext27"><strong> &nbsp;</strong></td>
	    <td width="37" align="left" valign="top" class="bodytext27">&nbsp;</td>
    </tr>
    </table>
	<table border="0" width="540" align="center" cellspacing="0" cellpadding="1">
	<tr>
	 <td colspan="6" align="left" >&nbsp;</td>
	</tr>
	<tr>
	 <td colspan="5" align="left" valign="top" class=""><strong>Pending Tests :</strong></td>
	</tr>
	<?php
	$labpending = '';
	$query68 = "select * from ipconsultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and resultentry <> 'completed' order by labitemname";
	$exec68 = mysqli_query($GLOBALS["___mysqli_ston"], $query68) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res68 = mysqli_fetch_array($exec68))
	{
	$labitemnamepending = $res68['labitemname'];
	if($labpending == '')
	{
		$labpending = $labitemnamepending;
	}
	else
	{
		$labpending = $labpending.', '.$labitemnamepending;
	}
	}
	?>
	<tr>
	 <td colspan="6" align="left"  class="" ><strong><?php echo $labpending; ?></strong></td>
	</tr>
	<tr>
	 <td colspan="6" align="center" valign="top" style="font-size:16px; text-decoration:underline;" class="bodytext31"><strong>Laboratory Report</strong> </td>
	</tr>
	<tr>
	 <td width="125" align="left" valign="top" class="bodytext29">&nbsp;</td>
	 <td width="71"  align="left" valign="top" class="bodytext29">&nbsp;</td>
	 <td width="51"  align="left" valign="top" class="bodytext29">&nbsp;</td>
	 <td width="60"  align="left" valign="top" class="bodytext29">&nbsp;</td>
	 <td width="100" align="left" valign="top" class="bodytext29">&nbsp;</td>
	 <td width="110" align="left" valign="top" class="bodytext29">&nbsp;</td>
	</tr>
	<tr>
	 <td width="125" align="left" valign="top" class="bodytext29"><strong>TESTS</strong></td>
	 <td width="71"  align="left" valign="top" class="bodytext29"><strong>RESULTS</strong></td>
	 <td width="60"  align="left" valign="top" class="bodytext29"><strong>UNIT</strong></td>
	 <td width="55"  align="left" valign="top" class="bodytext29"><strong>CRITICAL</strong></td>
	 <td width="100" align="left" valign="top" class="bodytext29"><strong>REFERANCE RANGE</strong></td>
	 <td width="110" align="left" valign="top" class="bodytext29"><strong>COMMENTS</strong></td>
	</tr>
	<?php
	$pagecount='';
	$itemnumbers=0;
	$referencenumbers=0;
	
	$query616 = "select * from ipresultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and itemcode = '$labitemcode34' and docnumber = '$docnumber' order by auto_number desc";
	$exec616 = mysqli_query($GLOBALS["___mysqli_ston"], $query616) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res616 = mysqli_fetch_array($exec616);
	
	$res616itemcode = $res616['itemcode'];
	$res616itemname = $res616['itemname'];
	?>
	<tr>
		<td colspan="6" align="left" valign="top" class=""><strong><?php echo $res616itemname; ?></strong></td>
	</tr>
	<tr>
		<td colspan="6" align="left" valign="top" class="bodytext31"><strong>&nbsp;</strong></td>
	</tr>
	<?php	
	 $query34="select * from master_labreference where itemcode = '$labitemcode34' and status <> 'deleted' and (gender = '$patientgender' or gender='') and '$patientage' >= agefrom and '$patientage' < ageto group by subheader";
	$exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34);
	$num34=mysqli_num_rows($exec34);
	while($res34=mysqli_fetch_array($exec34))
	{
	$subheader = $res34['subheader'];
	?>
	<tr>
		<td colspan="5" align="left" valign="top" class="bodytext31"><strong><?php echo $subheader; ?></strong></td>
	</tr>
	<?php
	$query38="select * from master_labreference where itemcode = '$labitemcode34' and subheader = '$subheader' and status <> 'deleted' and (gender = '$patientgender' or gender='') and '$patientage' >= agefrom and '$patientage' < ageto order by reforder ";
	$exec38=mysqli_query($GLOBALS["___mysqli_ston"], $query38);
	$num38=mysqli_num_rows($exec38);
	while($res38=mysqli_fetch_array($exec38))
	{
	$referencename1=$res38['referencename'];
	
	$query32="select * from ipresultentry_lab where patientname = '$patientname' and patientcode = '$patientcode' and patientvisitcode = '$visitcode' and referencename = '$referencename1' and itemcode = '$res616itemcode'  order by auto_number ";
	$exec32=mysqli_query($GLOBALS["___mysqli_ston"], $query32);
	$num32=mysqli_num_rows($exec32);
	$res32=mysqli_fetch_array($exec32);
	$resultvalue=$res32['resultvalue'];
	//$resultvalue = str_replace('<','&lt;',$resultvalue);
	//$resultvalue = str_replace('>','&gt;',$resultvalue);
	
	$sampletype = $res32['sampletype'];
	$referencename=$res32['referencename'];
	$referencerange=$res32['referencerange'];
	$referenceunit=$res32['referenceunit'];
	//$referenceunit='';
	//$referenceunit = str_replace('\n','',$referenceunit);
	//$referenceunit = str_replace('>','&gt;',$referenceunit);
	$res12referencename = $res32['referencename'];
	$color = $res32['color'];
	if($color == 'red') { $crit = 'H'; }
	else if($color == 'orange') { $crit = 'L'; }
	else if($color == 'green') { $crit = 'N'; }
	else { $crit = ''; }
	$refcomments = $res32['referencecomment'];
	$referencenumbers = $referencenumbers + 1;
	?>
	<tr>
	 <td width="125" align="left" valign="top" class="bodytext31"><?php echo $res12referencename; ?></td>
	 <td width="71" align="left" valign="top" class="bodytext31"><?php echo $resultvalue; ?></td>
	 <td width="60" align="left" valign="top" class="bodytext31"><?php echo $referenceunit; ?></td>
	 <td width="55" align="center" valign="top" class="bodytext31"><strong><?php echo $crit; ?></strong></td>
	 <td width="100" align="left" valign="top" class="bodytext31"><?php echo $referencerange; ?></td>
	 <td width="110" align="left" valign="top" class="bodytext31"><?php echo $refcomments; ?></td>
	</tr>
	<?php 
	  } 
	$res38comment = '';
	?>	
	<?php
	 }
	?>
	<tr>
	 <td colspan="6" align="left" valign="top" class="bodytext31">&nbsp;</td>
	</tr>
	<tr>
	 <td colspan="6" align="left" valign="top" class="bodytext31">&nbsp;</td>
	</tr>
	<tr>
	 <td colspan="6" align="left" valign="top" class="bodytext31">&nbsp;</td>
	</tr>
	<tr>
	 <td colspan="6" align="left" valign="top" class="bodytext31">&nbsp;</td>
	</tr>
	<tr>
	 <td colspan="6" align="left" valign="top" class="bodytext31">&nbsp;</td>
	</tr>
</table>  
<table border="0"  width="520" align=""  class="bodytext31">
 <tr>
    <td colspan="5" align="center" valign="top" class="bodytext31">&nbsp;</td>
  </tr>
   <tr>
     <td width="179">REVIEWED :&nbsp;&nbsp;------------------------------</td>
     <td width="172">SIGNATURE:&nbsp;&nbsp;------------------------------</td>
     <td width="178">DATE:&nbsp;&nbsp;------------------------------</td>
   </tr>
   <tr>
     <td width="179"><strong>Quality Manager/Laboratory Director</strong></td>
     <td width="172"><strong>LAB TECHNOLOGIST</strong> </td>
     <td width="178">Printed By: <?php echo strtoupper($res8jobdescription); ?></td>
   </tr>
   <tr>
     <td width="179">Reviewed By:&nbsp;<?php echo strtoupper($res4jobdescription); ?></td>
     <td width="172">Acknowledged By:&nbsp;<?php echo strtoupper($res41jobdescription); ?></td>
     <td width="178">Printed On: <?php echo date('Y-M-d g:i:A',strtotime($updatedatetime)); ?></td>
   </tr>
   <tr>
     <td width="179">&nbsp;</td>
     <td width="172">&nbsp; </td>
     <td width="178">&nbsp;</td>
   </tr>
    <tr>
    <td colspan="5" align="center" valign="top" class="bodytext31">&nbsp;</td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" cellpadding="2" id="footer">
  <tr>
    <td colspan="5" align="center" valign="top" class="bodytext31">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="center" valign="top" class="bodytext31">--------End of Report--------</td>
  </tr>
</table>
  
<!--</page> -->
<?php
}
?>
  <?php
   /*$content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {	
        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('Labresults.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }*/
  ?>
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
