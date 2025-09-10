<?php
session_start();
ini_set('max_execution_time', 3000);
ini_set('memory_limit','-1');
error_reporting(0);
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');
$updatedate = date('Y-m-d');
$currentdate = date('Y-m-d');
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$docno=$_SESSION["docno"];
ob_start();

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
$location= $companyname;

$query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res = mysqli_fetch_array($exec);
	
 	$locationname = $res["locationname"];
	$locationcode = $res["locationcode"];
//$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
if (isset($_REQUEST["billnumber"])) { $billnumbers = $_REQUEST["billnumber"]; } else { $billnumbers = ""; }
if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

if(isset($_REQUEST['docnumber'])) { $docnumberip = $_REQUEST["docnumber"]; } else { $docnumberip = ""; }

$frompage='doctor';

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; $frompage='doctor'; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }


//echo $frompage;
$query1 = "select * from master_visitentry where visitcode = '$visitcode'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$type = 'OP';
if(mysqli_num_rows($exec1) == 0)
{
$query1 = "select * from master_ipvisitentry where visitcode = '$visitcode'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$type = 'IP';

}
$res1 = mysqli_fetch_array($exec1);
$accountcode = '';
$res12ward = '';
$Patientname = $res1['patientfullname'];
$visitdatetime = $res1['consultationdate']." ".$res1['consultationtime'];
$accountname = $res1['accountfullname'];
$query5 = "select * from master_customer where customercode = '$patientcode'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);
$area12 = $res5['area'];
$fileno5 = $res5['mrdno'];
$patientage=$res5['age'];
$patientgender=$res5['gender'];
$dob = $res5['dateofbirth'];
$patient_tel = $res5['mobilenumber'];
if($type == 'OP')
{
$res12ward = $res1['departmentname'];
}
else
{
$consultingdoctorName = $res1['consultingdoctorName'];
	
$query51 = "select b.ward as dep from ip_bedallocation as a join master_ward as b on (a.ward = b.auto_number)  where a.visitcode = '$visitcode' and a.recordstatus = '' 
			union all select b.ward as dep from ip_bedtransfer as a join master_ward as b on (a.ward = b.auto_number)  where a.visitcode = '$visitcode' and a.recorddate = ''";
$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
$res51 = mysqli_fetch_array($exec51);
$res12ward = $res51['dep'];
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
$pagedef= array();

if($frompage=='lab'){
	$subquery=" and docnumber='$docnumberip'";
	$subquery1=" and rslt.docnumber='$docnumberip'";
	foreach($_REQUEST['ack'] as $key => $value)
	{
	$pagerow= array();
	$pagerow['lab']=$_REQUEST['ack'][$key];
	$pagerow['page']=$_REQUEST['page'][$key];
	array_push($pagedef,$pagerow);
	}
}else{
	$subquery=" and docnumber='$docnumberip'";
	$subquery1=" and rslt.docnumber='$docnumberip'";
    $i=1;
	$reqdef= array();
	$ack= array();
	$page= array();
	$query115 = "select * from resultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and publishstatus = 'completed' and docnumber='$docnumberip' group by itemcode,sampleid";
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	if($type == 'IP')
    {
    echo	$query115 = "select * from ipresultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode'  and docnumber='$docnumberip' group by itemcode,sampleid";
	$exec115 = mysqli_query($GLOBALS["___mysqli_ston"], $query115) or die ("Error in Query115".mysqli_error($GLOBALS["___mysqli_ston"]));
	  }
	while($res115 = mysqli_fetch_array($exec115))
	{
	$labitemcode = $res115['itemcode'];
	$sampleid= $res115['sampleid'];
	array_push($ack,$labitemcode.'_'.$sampleid);
	array_push($page,$i);
	$i++;
	}

	$reqdef['ack']=$ack;
	$reqdef['page']=$page;
	//
	$pagedef= array();
	foreach($reqdef['ack'] as $key => $value)
	{
	$pagerow= array();
	$pagerow['lab']=$reqdef['ack'][$key];
	$pagerow['page']=$reqdef['page'][$key];
	array_push($pagedef,$pagerow);
	}

}
//print_r($pagedef);
foreach ($pagedef as $key => $row) {
    $lab[$key]  = $row['lab'];
    $page[$key] = $row['page'];
}

// Sort the data with volume descending, edition ascending
// Add $data as the last parameter, to sort by the common key
array_multisort( $page, SORT_ASC,$lab, SORT_DESC, $pagedef);
$lab1= $lab[0];
$labcode = explode('_',$lab1)[0];
$sampleid = explode('_',$lab1)[1];
$lab_item_code = $labcode;
$lab_sampleid = $sampleid;
//print_r($pagedef);
 $query11 = "select username,lab_comments from consultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and labitemcode like '$labcode' group by username";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
$res11 = mysqli_fetch_array($exec11);
$num11 =mysqli_num_rows($exec11);
$res11username = $res11['username'];
// $lab_comments = $res11['lab_comments'];
if($num11 ==0)
{
$query11 = "select username,lab_comments from ipconsultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and labitemcode like '$labcode' group by username";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
$res11 = mysqli_fetch_array($exec11);
$res11username = $res11['username'];
// $lab_comments = $res11['lab_comments'];
}

if(isset($consultingdoctorName) && $consultingdoctorName!=''){
$orderedby = $consultingdoctorName;

}
else{
$query211 = "select * from master_employee where username  = '$res11username'";
$exec211 = mysqli_query($GLOBALS["___mysqli_ston"], $query211) or die ("Error in Query211".mysqli_error($GLOBALS["___mysqli_ston"]));
$res211 = mysqli_fetch_array($exec211);
$orderedby = $res211['employeename'];
}

$query126 = "select recorddate, recordtime from samplecollection_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and itemcode like '$labcode' and sampleid ='$sampleid'";
$exec126 = mysqli_query($GLOBALS["___mysqli_ston"], $query126) or die ("Error in Query126".mysqli_error($GLOBALS["___mysqli_ston"]));
if($type == 'IP')
{
	$query126 = "select recorddate, recordtime from ipsamplecollection_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and itemcode like '$labcode' and sampleid ='$sampleid'";
$exec126 = mysqli_query($GLOBALS["___mysqli_ston"], $query126) or die ("Error in Query126".mysqli_error($GLOBALS["___mysqli_ston"]));
}
$res126 = mysqli_fetch_array($exec126);
$res12sample = $res126['recorddate'].' '.$res126['recordtime'];

$query12 = "select recorddate, recordtime,username from resultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and itemcode like '$labcode' and sampleid ='$sampleid' $subquery";
$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
if($type == 'IP')
{
	$query12 = "select recorddate, recordtime,username from ipresultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and itemcode like '$labcode' and sampleid ='$sampleid' $subquery";
$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
}
$res12 = mysqli_fetch_array($exec12);

$published_by=$res12['username'];

	if($published_by!=''){
       $querydsc = "select employeename from master_employee where username = '$published_by'";
		$execdsc = mysqli_query($GLOBALS["___mysqli_ston"], $querydsc) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$resdsc = mysqli_fetch_array($execdsc);
		$publishedname = $resdsc["employeename"];
	}else
		$publishedname ='';


$res12result = $res12['recorddate'].' '.$res12['recordtime'];




$query8="select employeename,employeecode from master_employee where username = '$username' ";
$exec8=mysqli_query($GLOBALS["___mysqli_ston"], $query8);
$num8=mysqli_num_rows($exec8);
$res8=mysqli_fetch_array($exec8);
$res8jobdescription=$res8['employeename'];
$employee_code = $res8['employeecode'];
$res123recorddate =$res12sample ;
$res38publisheddatetime=$res12result;
?>

<?php
function roundTo($number, $to){ 
    return round($number/$to, 0)* $to; 
} 


		$query2 = "select * from master_location where locationcode = '$locationcode'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		//$companyname = $res2["companyname"];
		$address1 = $res2["address1"];
		$address2 = $res2["address2"];
//		$area = $res2["area"];
//		$city = $res2["city"];
//		$pincode = $res2["pincode"];
		//$emailid1 = $res2["email"];
		$phonenumber1 = $res2["phone"];
		$locationcode = $res2["locationcode"];
//		$phonenumber2 = $res2["phonenumber2"];
//		$tinnumber1 = $res2["tinnumber"];
//		$cstnumber1 = $res2["cstnumber"];
	//	$locationname =  $res2["locationname"];
		$prefix = $res2["prefix"];
		$suffix = $res2["suffix"];
		
?>
<style type="text/css">
body {
    font-family: 'Arial'; 
	font-size:11px;
	font-weight:100; 
}
.bodytext31{ font-size:13px; }
.bodytext27{ font-size:12px; }
#footer { position: fixed; left: 0px; bottom: 110px; right: 0px; height: 30px; }
#footer .page:after { content: counter(page, upper-roman); }
.style1 {
		font-weight: 800;
}
.test  td{
border:1px solid #CCC;
}
.page_footer
{
	font-family: Arial;
	text-align:center;
	font-weight:bold;
	margin-bottom:50px;
	
}
</style>
<head>
<title>Lab Report</title>
</head>
<div pagegroup="new" backtop="12mm" backbottom="20mm" backleft="2mm" backright="3mm">

 <table align="center" width="520" cellspacing="0" cellpadding="1" border="0">
	     <tr>
		    <td valign="top" width="83" rowspan="0">
			
			  <?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3showlogo = mysqli_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
				
			<img src="logofiles/<?php echo $companyanum;?>.png" width="225" height="85" />
			
			<?php
			}
			?>
			</td> 
			
			<td align="center" width="370">
			<table align="center">
			<tr>
			<td  align="center" style="font-size:16px">
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
			<span class="style1"><?php echo $companyname.'<BR>LABORATORY REPORT'; ?></span>
			</td></tr>
	    <tr>
		  <td align="center" class="bodytext23" style="font-size:13px">
            <?php
			
			$labemail="E-mail: ".$emailid1;
			$labemobile="Mobile Number: ".$phonenumber1;
			 ?>
          </td>
  </tr>
            
            <tr>
              <td align="center" class="bodytext24" style="font-size:13px">
			
			
           
              <?php echo '<br>'. $labemobile.'<br>'.$labemail; ?>
          
            </td>
	 
        </tr>
			<tr>
			  <td align="center">&nbsp;</td>
			</tr>
			
			</table></td>
		   
        </tr>
		   <tr>
     			<td colspan="3" align="center" class="bodytext26"><span class="style1">&nbsp;</span></td>
			</tr>
	       
	 		 
</table>
    
<!--<page_footer>
  <div class="page_footer" style="width: 100%; text-align: center">
                    <?php /*$footer="Blood is FREE for all @ Nakasero Hospital. Sale of blood is illegal. Should you ever be asked to pay for blood at this facility please report IMMEDIATELY to info@nhl.co.ug"; */?>
					<br> Page [[page_cu]] of [[page_nb]]
                </div>
    </page_footer>-->
	
<table width="520" border="1" cellspacing="0" cellpadding="2" >
	       
        <tr>
			
			<td width="40" class="bodytext27"><span class="style1">Patient</span></td>
		  <td width="120" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $Patientname; ?>
		 &nbsp; <?php if($patientcode !='') { echo '('.$patientcode.')' ; } ?>
	      	      </td>
<!--		  <td width="40" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><span class="style1">Lab No</span> </td>
		  <td width="100" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $docno; ?></td>
-->		  
		  <td width="40" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><span class="style1">Visit Code </span></td>
		  <td width="87" align="left" valign="middle" class="bodytext27"><?php echo $visitcode; ?></td>
		  <td width="40" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><span class="style1">Age</span></td>
		  <td width="87" align="left" valign="middle" class="bodytext27"><?php echo $dob1; ?></td>
		</tr>
       
		<tr>
		 <td align="left" valign="top" class="bodytext27"><span class="style1">Account</span></td>                
		  <td align="left" valign="top" class="bodytext27"><?php if($accountname != ''){ echo $accountname; }else{ echo 'SELF'; } ?></td>	
			 <td align="left" valign="top" class="bodytext27"><span class="style1">Unit</span></td>                
		  <td align="left" valign="top" class="bodytext27"><?php if($res12ward != ''){ echo $res12ward; }else{ echo 'Discharged'; } ?></td>
		  <td align="left" valign="top" class="bodytext27"><span class="style1">Sex</span></td>                
		  <td align="left" valign="top" class="bodytext27"><?php echo $patientgender;?></td>
		
	  </tr>
	   <tr>
		 <td align="left" valign="top" class="bodytext27"><span class="style1">Lab No.</span></td>
		  <td align="left" valign="top" class="bodytext27"><?php echo $sampleid; ?></td>
		  <td align="left" valign="middle" class="bodytext27"><span class="style1">Doctor</span></td>
			<td align="left" valign="middle" class="bodytext27"><?php echo $orderedby; ?></td>	
			<td align="left" valign="top" class="bodytext27"><span class="style1">Tel</span></td>
		  <td align="left" valign="top" class="bodytext27"><?php //echo $patient_tel; ?></td>
			
       </tr>
	  <tr>
		<td class="bodytext27"><span class="style1">Sample Collected At</span></td>
		  <td class="bodytext27"><?php echo date('d-M-Y g:i:A',strtotime($res123recorddate)); ?></td>
		  <td class="bodytext27"><span class="style1">Reported On</span></td>
		  <td class="bodytext27" ><?php echo date('d-M-Y g:i:A',strtotime($res38publisheddatetime)); ?></td>
		  <td class="bodytext27" colspan='2' ><!--<img style="display:none" src="<?php $sampleanum = substr($sampleid,4); echo $applocation1; ?>/barcode/test.php?text=<?php echo $sampleanum; ?>" width="150" height="50" />--></td>
	   
	  </tr>	  
</table>
<table width="519" border="0" cellpadding="1" cellspacing="2">
<tr>
<td>&nbsp;</td>
</tr>
<tr>
        <td colspan="6" align="center" valign="middle" style="font-size:16px;"><span class="style1">TESTS RESULTS </span> </td>
      </tr>
	  <tr>
<td>&nbsp;</td>
</tr>

</table>
<table width="519" class="test" cellpadding="4" cellspacing="0">
	<tr>
		<td width="202" align="center" valign="middle" class="bodytext29"><span class="style1">TESTS</span></td>
        <td width="51"  align="center" valign="middle" class="bodytext29"><span class="style1">RESULTS</span></td>
		<td width="51"  align="center" valign="middle" class="bodytext29 style1">FLAG</td>
        <td width="51"  align="center" valign="middle" class="bodytext29"><span class="style1">UNIT</span></td>
		<td width="51" align="center" valign="middle" class="bodytext29"><span class="style1">R.RANGE</span></td>
        </tr>
	   

<?php
$pageid = $pagedef[0]['page'];
foreach($pagedef as $row)
{
	$labid = $row['lab'];
	$labar = explode('_',$labid);
	$labcode = $labar[0];
	$sampleid = $labar[1];
	if($row['page'] != $pageid)
	{
	$pageid = $row['page'];
	?></table>

<table border="0" align="center" width="540" height="" id="footer">
<tr >
<td colspan="2" style="border:1px solid #666666" height="25" valign="top"><span class="style1">Comments:</span> </td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>

		<tr>
	 <td width="70%"><?php echo strtoupper('Technologist'); ?>: <strong><?php echo strtoupper($publishedname); ?></strong></td>
        <td width="30%">REVIEWED :&nbsp;&nbsp;----------------------</td>
         
      </tr>
      <tr>
	  <td width="70%">Printed On: <?php echo date('d-M-Y g:i:A'); ?></td>
       	 <td width="30%"><span class="style1">Quality Manager/Laboratory Director</span></td>
		
         
      </tr>

     
	</table>
	</div><div style='page-break-before: always;'></div><br><br><div><table align="center" width="520" cellspacing="0" cellpadding="1" border="0">
	     <tr>
		    <td valign="top" width="83" rowspan="0">
			
			  <?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3showlogo = mysqli_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
				
			<img src="logofiles/<?php echo $companyanum;?>.png" width="95" height="65" />
			
			<?php
			}
			?>
			</td> 
			
			<td align="center" width="370">
			<table align="center">
			<tr>
			<td  align="center" style="font-size:16px">
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
			<span class="style1"><?php echo $companyname.'<BR>LABORATORY REPORT'; ?></span>
			</td></tr>
	    <tr>
		  <td align="center" class="bodytext23" style="font-size:13px">
            <?php
			
			$labemail="E-mail: ".$emailid1;
			$labemobile="Mobile Number: ".$phonenumber1;
		
			?>
			
          </td>
  </tr>
            
            <tr>
              <td align="center" class="bodytext24" style="font-size:13px">
			
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
           
              <?php echo '<br>'. $labemobile.'<br>'.$labemail; ?>
          
            </td>
	 
        </tr>
			<tr>
			  <td align="center">&nbsp;</td>
			</tr>
			<tr>
     			<td align="center" style="font-size:12px;"><span class="style1"><?php echo $location; ?>&nbsp;</span></td>
			</tr>
			</table></td>
		  </tr>
		   <tr>
     			<td colspan="3" align="center" class="bodytext26" ><span class="style1">&nbsp;</span></td>
			</tr>
	       
	 		 
</table>
    
<!--<page_footer>
  <div class="page_footer" style="width: 100%; text-align: center">
                    <?php /*$footer="Blood is FREE for all @ Nakasero Hospital. Sale of blood is illegal. Should you ever be asked to pay for blood at this facility please report IMMEDIATELY to info@nhl.co.ug"; */?>
					<br> Page [[page_cu]] of [[page_nb]]
                </div>
    </page_footer>-->
	
<table width="520" border="1" cellspacing="0" cellpadding="2">
	       
        <tr>
			
			<td width="40" class="bodytext27"><span class="style1">Patient</span></td>
		  <td width="120" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $Patientname; ?>
		 &nbsp; <?php if($patientcode !='') { echo '('.$patientcode.')' ; } ?>
	      	      </td>
<!--		  <td width="40" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><span class="style1">Lab No</span> </td>
		  <td width="100" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $docno; ?></td>
-->		  
		  <td width="40" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><span class="style1">Visit Code </span></td>
		  <td width="87" align="left" valign="middle" class="bodytext27"><?php echo $visitcode; ?></td>
		  <td width="40" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><span class="style1">Age</span></td>
		  <td width="87" align="left" valign="middle" class="bodytext27"><?php echo $dob1; ?></td>
		</tr>
       
		<tr>
		 <td align="left" valign="top" class="bodytext27"><span class="style1">Account</span></td>                
		  <td align="left" valign="top" class="bodytext27"><?php if($accountname != ''){ echo $accountname; }else{ echo 'SELF'; } ?></td>	
			 <td align="left" valign="top" class="bodytext27"><span class="style1">Unit</span></td>                
		  <td align="left" valign="top" class="bodytext27"><?php if($res12ward != ''){ echo $res12ward; }else{ echo 'Discharged'; } ?></td>
		  <td align="left" valign="top" class="bodytext27"><span class="style1">Sex</span></td>                
		  <td align="left" valign="top" class="bodytext27"><?php echo $patientgender;?></td>
		
	  </tr>
	   <tr>
		 <td align="left" valign="top" class="bodytext27"><span class="style1">Lab No.</span></td>
		  <td align="left" valign="top" class="bodytext27"><?php echo $sampleid; ?></td>
		  <td align="left" valign="middle" class="bodytext27"><span class="style1">Doctor</span></td>
			<td align="left" valign="middle" class="bodytext27"><?php echo $orderedby; ?></td>	
			<td align="left" valign="top" class="bodytext27"><span class="style1">Tel</span></td>
		  <td align="left" valign="top" class="bodytext27"><?php //echo $patient_tel; ?></td>
			
       </tr>
	  <tr>
		<td class="bodytext27"><span class="style1">Sample Collected At</span></td>
		  <td class="bodytext27"><?php echo date('d-M-Y g:i:A',strtotime($res123recorddate)); ?></td>
		  <td class="bodytext27"><span class="style1">Reported On</span></td>
		  <td class="bodytext27" colspan="3"><?php echo date('d-M-Y g:i:A',strtotime($res38publisheddatetime)); ?></td>
	   
	  </tr>	  
</table>
<table width="519" border="0" cellpadding="1" cellspacing="2">
<tr>
<td>&nbsp;</td>
</tr>
<tr>
        <td colspan="6" align="center" valign="middle" style="font-size:16px;"><span class="style1">TESTS RESULTS </span> </td>
      </tr>

<tr>
<td>&nbsp;</td>
</tr>
</table>
<table width="519" cellpadding="4" cellspacing="0" class='test'>
	<tr>
		<td width="202" align="center" valign="middle" class="bodytext29"><span class="style1">TESTS</span></td>
        <td width="51"  align="center" valign="middle" class="bodytext29"><span class="style1">RESULTS</span></td>
		<td width="51"  align="center" valign="middle" class="bodytext29 style1">FLAG</td>
        <td width="51"  align="center" valign="middle" class="bodytext29"><span class="style1">UNIT</span></td>
		<td width="51" align="center" valign="middle" class="bodytext29"><span class="style1">R.RANGE</span></td>
        </tr>
	 
<?php
	}
	//$query616 = "select *,count(referencename) as nors  from resultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and itemcode = '$labcode' and sampleid = '$sampleid' and resultvalue <> '' and  docnumber='$docnumberip' group by itemcode,sampleid,referencename";

	$query616 = "select rslt.*,count(rslt.referencename) as nors  from resultentry_lab as rslt join master_labreference as ref on ref.referencename=rslt.referencename and rslt.itemcode = ref.itemcode where rslt.patientcode = '$patientcode' and rslt.patientvisitcode = '$visitcode' and rslt.itemcode = '$labcode' and rslt.sampleid = '$sampleid' and rslt.resultvalue <> '' $subquery1 group by rslt.itemcode,rslt.sampleid,rslt.referencename ORDER BY reforder ";

		$exec616 = mysqli_query($GLOBALS["___mysqli_ston"], $query616) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		if($type == 'IP')
		{
			//$query616 = "select *,count(referencename) as nors  from ipresultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and itemcode = '$labcode' and sampleid = '$sampleid' and resultvalue <> '' and  docnumber='$docnumberip' group by itemcode,sampleid,referencename";

			$query616 = "select rslt.*,count(rslt.referencename) as nors  from ipresultentry_lab as rslt join master_labreference as ref on ref.referencename=rslt.referencename and rslt.itemcode = ref.itemcode where rslt.patientcode = '$patientcode' and rslt.patientvisitcode = '$visitcode' and rslt.itemcode = '$labcode'  and rslt.resultvalue <> '' and rslt.sampleid = '$sampleid' $subquery1 group by rslt.itemcode,rslt.docnumber ORDER BY reforder";

		$exec616 = mysqli_query($GLOBALS["___mysqli_ston"], $query616) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		$res616 = mysqli_fetch_array($exec616);
		$res616itemcode = $res616['itemcode'];
		$res616itemname = $res616['itemname'];
		$res616equipmentname = $res616['equipmentname'];
		$docnumber = $res616['sampleid'];
		$nors = $res616['nors'];
		$referencenumbers = 0;
		?>
		 <tr>
        <td colspan="5" align="center" valign="middle" style="font-size:6px;;">&nbsp; </td>
      </tr>
     <!--  <tr>
        <td colspan="5" align="left" valign="middle" class="bodytext27"><span class="style1"><?php // echo strtoupper($res616itemname); ?></span></td>
      </tr> -->
      <tr>
        <td colspan="2" align="left" valign="middle" class="bodytext27"><span class="style1"><?php echo strtoupper($res616itemname); ?></span></td>
        <td colspan="3" align="left" valign="middle" class="bodytext27"><span class="style1"><?php echo strtoupper($res616equipmentname); ?></span></td>
      </tr>

	<?php
	//$query32="select * from resultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and itemcode = '$res616itemcode' and sampleid = '$docnumber'  and resultvalue <> '' and  docnumber='$docnumberip' group by referencename order by auto_number";

	$query32="select rslt.* from resultentry_lab as rslt join master_labreference as ref on ref.referencename=rslt.referencename and rslt.itemcode = ref.itemcode where rslt.patientcode = '$patientcode' and rslt.patientvisitcode = '$visitcode' and rslt.itemcode = '$res616itemcode' and rslt.sampleid = '$docnumber'  and rslt.resultvalue <> '' $subquery1 and ref.status='' group by rslt.referencename order by ref.reforder asc";

	$exec32=mysqli_query($GLOBALS["___mysqli_ston"], $query32);
	if($type == 'IP')
	{
		//$query32="select * from ipresultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and itemcode = '$res616itemcode' and sampleid = '$docnumber'  and resultvalue <> '' and  docnumber='$docnumberip' group by referencename order by auto_number";

		$query32="select rslt.* from ipresultentry_lab as rslt join master_labreference as ref on ref.referencename=rslt.referencename and rslt.itemcode = ref.itemcode where rslt.patientcode = '$patientcode' and rslt.patientvisitcode = '$visitcode' and rslt.itemcode = '$res616itemcode'   and rslt.resultvalue <> '' $subquery1 group by rslt.referencename order by reforder";

	$exec32=mysqli_query($GLOBALS["___mysqli_ston"], $query32);
	}
	$num32=mysqli_num_rows($exec32);
	while($res32=mysqli_fetch_array($exec32)){
	$resultvalue=$res32['resultvalue'];
	$resultvalue = str_replace('<','&lt;',$resultvalue);
	$resultvalue = str_replace('>','&gt;',$resultvalue);
	$query99 = mysqli_query($GLOBALS["___mysqli_ston"], "select sample from samplecollection_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and itemcode = '$res616itemcode' and sampleid = '$docnumber'");
	$res99 = mysqli_fetch_array($query99);
	$sampletype = $res99['sample'];
	$referencename=$res32['referencename'];
	$query34 = "select * from master_labreference where itemcode = '$res616itemcode' and referencename = '$referencename' and status <> 'deleted'";
	$exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34);
	$res34=mysqli_fetch_array($exec34);
	$referencerange=$res32['referencerange'];
	$referenceunit=$res34['referenceunit'];
	$referenceunit = str_replace('<','&lt;',$referenceunit);
	$referenceunit = str_replace('>','&gt;',$referenceunit);
	$res12referencename = $res32['referencename'];
	$color = $res32['color'];
	if(!in_array($color,array('red','green','orange')))
	{
	$crit = $color;
	if($crit == 'H') { $color = 'red'; }
	else if($crit == 'L') { $color = 'orange'; }
	else if($crit == 'N') { $color = 'green'; }
	else { $color = ''; }
	}
	else{
		
	if($color == 'red') { $crit = 'H'; }
	else if($color == 'orange') { $crit = 'L'; }
	else if($color == 'green') { $crit = 'N'; }
	else { $crit = ''; }
	}

	$crit = ($crit=="N")?"":$crit;

	$refcomments = $res34['referencecomments'];
	$referencenumbers = $referencenumbers + 1;
	$refcomments = str_replace('border="1"','border="0"',$refcomments);		
		?>
     <tr>
	 <td align="left" valign="top" class="bodytext27"><?php echo $res12referencename; ?></td>
	 <td align="left" valign="top" class="bodytext27" width="51" ><?php echo $resultvalue; ?></td>
	 <td align="center" valign="top" class="bodytext27" style="color:<?= $color; ?>"><?php echo $crit; ?></td>
	  <td align="left" valign="top" class="bodytext27"><?php echo $referenceunit; ?></td>
	 <td align="left" valign="top" class="bodytext27"><?php echo $referencerange; ?></td>
	 </tr>
      <?php }  ?>
	  <?php
	 $query34i = "select * from master_labinterpretation where itemcode = '$res616itemcode' and status <> 'deleted'";
	 $exec34i=mysqli_query($GLOBALS["___mysqli_ston"], $query34i);
	 if(mysqli_num_rows($exec34i)>0)
	 { ?>
    
     <tr>
	 <td colspan="5" align="left" valign="top" class="bodytext27"><strong>Test Interpretation</strong></td>
     </tr>
     <?php
	 while($res34i=mysqli_fetch_array($exec34i))
	 {
		$interpret_desc = $res34i['interpret_desc']; 
		$interpret_range = $res34i['interpret_range']; 
	 ?>
     <tr>
	 <td align="left" valign="top" class="bodytext27" colspan="5"><?php echo $interpret_desc; ?></td>
     </tr>
     <?php	
	 }
	 }
	 ?>
     <?php
}
?>



	</table> 
	<?php 
	$query11 = "SELECT lab_comments from consultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and sampleid='$sampleid' ";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
$res11 = mysqli_fetch_array($exec11);
$num11 =mysqli_num_rows($exec11);
$lab_comments = $res11['lab_comments'];
if($num11 ==0)
{
$query11 = "SELECT lab_comments from ipconsultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and  sampleid='$sampleid'";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
$res11 = mysqli_fetch_array($exec11);
$lab_comments = $res11['lab_comments'];
}

	if($lab_comments!=""){  ?>
			<table>
			<tr><td colspan="5">&nbsp;</td></tr>
			<tr >
					<td colspan="5"   height="25" valign="top"><span class=""><b>Comments : </b><?php //echo ucfirst($lab_comments);
					echo str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($lab_comments))));
					?></span> </td>
			</tr>
			</table>
		<?php } ?>


<table border="0" align="center" width="540" height="" id="footer">

<tr>
<td>&nbsp;</td><td>&nbsp;</td>
</tr>

 <?php
		   if(strpos(strtoupper(strtolower($res616itemname)), 'COVID') !== false )
			{  ?>

			<tr>
			 <td width="178"><?php echo strtoupper('Lab Technologist'); ?>:<strong> <?php echo strtoupper($publishedname); ?></strong></td>
			
			<td width="178" valign="bottom"><span class="style1"></span></td>
		    <td width="150"><!--<img src="img/<?php echo 'covid_newsign';?>.png" width="200" height="90" />--></td>
				 
			  </tr>
			  <tr>
			  <!--<td width="178">Printed By: <?php echo strtoupper($res8jobdescription); ?></td>-->
			  <td width="178"><span class="style1"></span></td>
				 <td width="178"></td>
				<td width="150"><span class="style1">REVIEWED BY :  </span> </td>
				
				 
			  </tr>
			  <tr>
	   <td width="178">Printed On: <?php echo date('d-M-Y g:i:A'); ?></td>
        <td width="179"></td>
        <td width="150"></td>
       
       
      </tr>

			<?php

			}else{
		?>
		<tr>
	 <td width="70%"><?php echo strtoupper('Lab Technologist'); ?>:<strong> <?php echo strtoupper($publishedname); ?></strong>

	 		  
	 </td>
        <td width="30%" >REVIEWED BY :&nbsp;&nbsp;----------------------</td>
        
         
      </tr>
      <tr>
	  <td width="70%">Printed On: <?php echo date('d-M-Y g:i:A'); ?></td>
       	 <td width="30%"><span class="style1">Quality Manager/Laboratory Director</span></td>
        
		
         
      </tr>
      <?php } ?>
      
	</table>
</div>

<?php
//$content = ob_get_clean();
//
//     //convert in PDF
//    require_once('html2pdf/html2pdf.class.php');
//    try
//    {
//        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
//		//$html2pdf->SetFont(‘times’, ‘BI’, 20, “, ‘false’);
////      $html2pdf->setModeDebug();
//        $html2pdf->setDefaultFont('Arial');
//        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
//        $html2pdf->Output('LabResults.pdf');
//    }
//    catch(HTML2PDF_exception $e) {
//        echo $e;
//        exit;
//    }
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
//$dompdf->add_info('Tittle', 'LabResultsFull');
?>