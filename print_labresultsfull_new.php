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
$query1 = "select * from master_visitentry where visitcode = '$visitcode'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($exec1) == 0)
{
$query1 = "select * from master_ipvisitentry where visitcode = '$visitcode'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
}
$res1 = mysqli_fetch_array($exec1);
$accountcode = '';
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
foreach($_REQUEST['ack'] as $key => $value)
{
$pagerow= array();
$pagerow['lab']=$_REQUEST['ack'][$key];
$pagerow['page']=$_REQUEST['page'][$key];
array_push($pagedef,$pagerow);
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
//print_r($pagedef);
$query11 = "select username from consultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and labitemcode like '$labcode' group by username";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
$res11 = mysqli_fetch_array($exec11);
$num11 =mysqli_num_rows($exec11);
$res11username = $res11['username'];
if($num11 ==0)
{
$query11 = "select username from ipconsultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and labitemcode like '$labcode' group by username";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
$res11 = mysqli_fetch_array($exec11);
$res11username = $res11['username'];

}
$query211 = "select * from master_employee where username  = '$res11username'";
$exec211 = mysqli_query($GLOBALS["___mysqli_ston"], $query211) or die ("Error in Query211".mysqli_error($GLOBALS["___mysqli_ston"]));
$res211 = mysqli_fetch_array($exec211);
$orderedby = $res211['employeename'];
$query12 = "select sampledate,resultdatetime from pending_test_orders where patientcode = '$patientcode' and visitcode = '$visitcode' and testcode like '$labcode' and sample_id ='$sampleid'";
$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
$res12 = mysqli_fetch_array($exec12);
$res12sample = $res12['sampledate'];
$res12result = $res12['resultdatetime'];
$query8="select employeename from master_employee where username = '$username' ";
$exec8=mysqli_query($GLOBALS["___mysqli_ston"], $query8);
$num8=mysqli_num_rows($exec8);
$res8=mysqli_fetch_array($exec8);
$res8jobdescription=$res8['employeename'];
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
#footer { position: fixed; left: 0px; bottom: -20px; right: 0px; height: 30px; }
#footer .page:after { content: counter(page, upper-roman); }
.style1 {
	font-size: 10px;
	font-weight: bold;
}
.page_footer
{
	font-family: Arial;
	text-align:center;
	font-weight:bold;
	margin-bottom:25px;
	
}
</style>

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
				
			<img src="logofiles/<?php echo $companyanum;?>.jpg" width="65" height="65" />
			
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
			<strong><?php echo $companyname; ?></strong>
			</td></tr>
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
			$address3 = "Tel: ".$phonenumber2;
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
            <?php echo $address4; ?>
              <?php echo '<br>'. $labemobile.'<br>'.$labemail.'<br>'.$website; ?>
          
            </td>
	 
        </tr>
			<tr>
			  <td align="center">&nbsp;</td>
			</tr>
			<tr>
     			<td align="center" style="font-size:12px;"><strong><?php echo $location; ?>&nbsp;</strong></td>
			</tr>
			</table></td>
		    <td valign="top"  width="83" align="right">
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
     			<td colspan="3" align="center" class="bodytext26" style="border-top:solid 0px #000000;"><strong>&nbsp;</strong></td>
			</tr>
	       
	 		 
</table>
    
<!--<page_footer>
  <div class="page_footer" style="width: 100%; text-align: center">
                    <?php /*$footer="Blood is FREE for all @ Nakasero Hospital. Sale of blood is illegal. Should you ever be asked to pay for blood at this facility please report IMMEDIATELY to info@nhl.co.ug"; */?>
					<br> Page [[page_cu]] of [[page_nb]]
                </div>
    </page_footer>-->
	
<table width="520" border="0" cellspacing="0" cellpadding="2" style="border-top:solid 1px #000000;border-bottom:solid 1px #000000;">
	       
        <tr>
			<input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
			<input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
			<td width="40" class="bodytext27"><strong>Patient</strong></td>
		  <td width="120" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $Patientname; ?>
		 &nbsp; <?php if($patientcode !='') { echo '('.$patientcode.')' ; } ?>
	      <input name="customername" type="hidden" id="customer" value="<?php echo $Patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly="readonly"/>	      </td>
<!--		  <td width="40" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>Lab No</strong> </td>
		  <td width="100" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $docno; ?></td>
-->		  
		  <td width="40" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>Visit Code </strong></td>
		  <td width="87" align="left" valign="middle" class="bodytext27"><?php echo $visitcode; ?></td>
		  <td width="40" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>Visit Date</strong></td>
		  <td width="87" align="left" valign="middle" class="bodytext27"><?php echo date('d-M-Y g:i:A',strtotime($visitdatetime)); ?></td>
		</tr>
       
		<tr>
			<td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>Age</strong></td>
			<td align="left" valign="middle" class="bodytext27"><?php echo $dob1; ?>
		  <input name="customercode" type="hidden" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly="readonly"/>	      </td>
			<td align="left" valign="middle" class="bodytext27"><strong>Doctor</strong></td>
			<td align="left" valign="middle" class="bodytext27"><?php echo $orderedby; ?></td>
		  <td align="left" valign="top" class="bodytext27"><strong>Sex</strong></td>                
		  <td align="left" valign="top" class="bodytext27"><?php echo substr($patientgender, 0, 1);?></td>
		
	  </tr>
	   <tr>
		  <td align="left" valign="top" class="bodytext27"><strong>Account</strong></td>                
		  <td align="left" valign="top" class="bodytext27"><?php if($accountname != ''){ echo $accountname; }else{ echo 'SELF'; } ?></td>	
			<td class="bodytext27"><strong>Sample Rcvd </strong></td>
		  <td class="bodytext27"><?php echo date('d-M-Y',strtotime($res123recorddate)).' '.date('g:i:A',strtotime($res123recordtime)); ?></td>
		  <td class="bodytext27"><strong>Reported On</strong></td>
		  <td class="bodytext27"><?php echo date('d-M-Y g:i:A',strtotime($res38publisheddatetime)); ?></td>
        <input name="account" type="hidden" id="account" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly="readonly"/>
	 </tr>
	  <tr>
		  <td align="left" valign="top" class="bodytext27"><strong>Area</strong></td>	
		  <td align="left" valign="top" class="bodytext27"><?php echo $area12; ?></td>	
		  <td align="left" valign="top" class="bodytext27"><strong>File No</strong></td>
		  <td align="left" valign="top" class="bodytext27"><?php echo $fileno5; ?></td>	
	  <?php if($accountcode != '') { ?>
	   	  <td align="left" valign="top" class="bodytext27"><strong>Acc No</strong></td>
		  <td align="left" valign="top" class="bodytext27"><?php echo $accountcode; ?></td>
	  <?php }else { ?>
	  	  <td align="left" valign="top" class="bodytext27"><strong>&nbsp;</strong></td>
		  <td align="left" valign="top" class="bodytext27"><?php //echo $area; ?></td>
	  <?php } ?>	  
	  </tr>	  
</table>
<table width="519" border="0" cellpadding="1" cellspacing="2">
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
	<tr>
		<td width="142" align="left" valign="middle" class="bodytext29"><span class="style1">TESTS</span></td>
        <td width="46"  align="left" valign="middle" class="bodytext29"><span class="style1">RESULTS</span></td>
		<td width="35"  align="left" valign="middle" class="bodytext29"><span class="style1">UNIT</span></td>
		<td width="62"  align="left" valign="middle" class="bodytext29 style1">FLAG</td>
        <td width="54" align="left" valign="middle" class="bodytext29"><span class="style1">R.RANGE</span></td>
        <td width="150" align="left" valign="middle" class="bodytext29"><span class="style1">COMMENTS</span></td>
      </tr>
	  <tr>
        <td colspan="6" align="center" valign="middle" style="font-size:6px;;">&nbsp; </td>
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
	?></table><table align="center" border="0" class="bodytext27"> 
<tr>
<td>&nbsp; </td>
</tr>
<tr>
<td>&nbsp; </td>
</tr>
<tr>
<td>&nbsp; </td>
</tr>
<tr>
<td>&nbsp; </td>
</tr>
</table>
<table align="center"  border="0" class="bodytext27"> 
	 <tr>
        <td width="209">REVIEWED :&nbsp;&nbsp;-------------------------</td>
        <td width="202">SIGNATURE:&nbsp;&nbsp;--------------------------</td>
         <td width="198">DATE:&nbsp;&nbsp;----------------------</td>
      </tr>
      <tr>
       	 <td width="199"><strong>Quality Manager/Laboratory Director</strong></td>
        <td width="192"><strong>Lab Technollogist</strong> </td>
		
         <td width="198">Printed By: <?php echo strtoupper($res8jobdescription); ?></td>
      </tr>

      <tr>
        <td width="179">Reviewed By:&nbsp;<?php echo strtoupper($res4jobdescription); ?></td>
        <td width="172">Acknowledged By:&nbsp;<?php echo strtoupper($res41jobdescription); ?></td>
       
        <td width="178">Printed On: <?php echo date('d-M-Y g:i:A'); ?></td>
      </tr>
	  <tr>
        <td width="179">&nbsp;</td>
        <td width="172">&nbsp; </td>
       
        <td width="178">&nbsp;</td>
      </tr>
    </table>
<table border="0" align="center" width="540" height="" id="footer">
		<tr>
			  <td width="540" align="center" valign="top" class="bodytext31">--------End of Report--------</td>
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
				
			<img src="logofiles/<?php echo $companyanum;?>.jpg" width="65" height="65" />
			
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
			<strong><?php echo $companyname; ?></strong>
			</td></tr>
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
			$address3 = "Tel: ".$phonenumber2;
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
            <?php echo $address4; ?>
              <?php echo '<br>'. $labemobile.'<br>'.$labemail.'<br>'.$website; ?>
          
            </td>
	 
        </tr>
			<tr>
			  <td align="center">&nbsp;</td>
			</tr>
			<tr>
     			<td align="center" style="font-size:12px;"><strong><?php echo $location; ?>&nbsp;</strong></td>
			</tr>
			</table></td>
		    <td valign="top"  width="83" align="right">
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
     			<td colspan="3" align="center" class="bodytext26" style="border-top:solid 0px #000000;"><strong>&nbsp;</strong></td>
			</tr>
	       
	 		 
</table>
    
<!--<page_footer>
  <div class="page_footer" style="width: 100%; text-align: center">
                    <?php /*$footer="Blood is FREE for all @ Nakasero Hospital. Sale of blood is illegal. Should you ever be asked to pay for blood at this facility please report IMMEDIATELY to info@nhl.co.ug"; */?>
					<br> Page [[page_cu]] of [[page_nb]]
                </div>
    </page_footer>-->
	
<table width="520" border="0" cellspacing="0" cellpadding="2" style="border-top:solid 1px #000000;border-bottom:solid 1px #000000;">
	       
        <tr>
			<input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
			<input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
			<td width="40" class="bodytext27"><strong>Patient</strong></td>
		  <td width="120" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $Patientname; ?>
		 &nbsp; <?php if($patientcode !='') { echo '('.$patientcode.')' ; } ?>
	      <input name="customername" type="hidden" id="customer" value="<?php echo $Patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly="readonly"/>	      </td>
<!--		  <td width="40" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>Lab No</strong> </td>
		  <td width="100" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $docno; ?></td>
-->		  
		  <td width="40" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>Visit Code </strong></td>
		  <td width="87" align="left" valign="middle" class="bodytext27"><?php echo $visitcode; ?></td>
		  <td width="40" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>Visit Date</strong></td>
		  <td width="87" align="left" valign="middle" class="bodytext27"><?php echo date('d-M-Y g:i:A',strtotime($visitdatetime)); ?></td>
		</tr>
       
		<tr>
			<td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>Age</strong></td>
			<td align="left" valign="middle" class="bodytext27"><?php echo $dob1; ?>
		  <input name="customercode" type="hidden" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly="readonly"/>	      </td>
			<td align="left" valign="middle" class="bodytext27"><strong>Doctor</strong></td>
			<td align="left" valign="middle" class="bodytext27"><?php echo $orderedby; ?></td>
		  <td align="left" valign="top" class="bodytext27"><strong>Sex</strong></td>                
		  <td align="left" valign="top" class="bodytext27"><?php echo substr($patientgender, 0, 1);?></td>
		
	  </tr>
	   <tr>
		  <td align="left" valign="top" class="bodytext27"><strong>Account</strong></td>                
		  <td align="left" valign="top" class="bodytext27"><?php if($accountname != ''){ echo $accountname; }else{ echo 'SELF'; } ?></td>	
			<td class="bodytext27"><strong>Sample Rcvd </strong></td>
		  <td class="bodytext27"><?php echo date('d-M-Y',strtotime($res123recorddate)).' '.date('g:i:A',strtotime($res123recordtime)); ?></td>
		  <td class="bodytext27"><strong>Reported On</strong></td>
		  <td class="bodytext27"><?php echo date('d-M-Y g:i:A',strtotime($res38publisheddatetime)); ?></td>
        <input name="account" type="hidden" id="account" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly="readonly"/>
	 </tr>
	  <tr>
		  <td align="left" valign="top" class="bodytext27"><strong>Area</strong></td>	
		  <td align="left" valign="top" class="bodytext27"><?php echo $area12; ?></td>	
		  <td align="left" valign="top" class="bodytext27"><strong>File No</strong></td>
		  <td align="left" valign="top" class="bodytext27"><?php echo $fileno5; ?></td>	
	  <?php if($accountcode != '') { ?>
	   	  <td align="left" valign="top" class="bodytext27"><strong>Acc No</strong></td>
		  <td align="left" valign="top" class="bodytext27"><?php echo $accountcode; ?></td>
	  <?php }else { ?>
	  	  <td align="left" valign="top" class="bodytext27"><strong>&nbsp;</strong></td>
		  <td align="left" valign="top" class="bodytext27"><?php //echo $area; ?></td>
	  <?php } ?>	  
	  </tr>	  
</table>
<table width="519" border="0" cellpadding="1" cellspacing="2">
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
	<tr>
		<td width="142" align="left" valign="middle" class="bodytext29"><span class="style1">TESTS</span></td>
        <td width="46"  align="left" valign="middle" class="bodytext29"><span class="style1">RESULTS</span></td>
		<td width="35"  align="left" valign="middle" class="bodytext29"><span class="style1">UNIT</span></td>
		<td width="62"  align="left" valign="middle" class="bodytext29 style1">FLAG</td>
        <td width="54" align="left" valign="middle" class="bodytext29"><span class="style1">R.RANGE</span></td>
        <td width="150" align="left" valign="middle" class="bodytext29"><span class="style1">COMMENTS</span></td>
      </tr>
	  <tr>
        <td colspan="6" align="center" valign="middle" style="font-size:6px;;">&nbsp; </td>
      </tr>
<?php
	}
	$query616 = "select *,count(parametercode) as nors  from pending_test_orders where patientcode = '$patientcode' and visitcode = '$visitcode' and testcode = '$labcode' and sample_id = '$sampleid' and result <> '' group by testcode,sample_id,parametername";
		$exec616 = mysqli_query($GLOBALS["___mysqli_ston"], $query616) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res616 = mysqli_fetch_array($exec616);
		$res616itemcode = $res616['testcode'];
		$res616itemname = $res616['testname'];
		$docnumber = $res616['sample_id'];
		$nors = $res616['nors'];
		$referencenumbers = 0;
		?>
      <tr>
        <td colspan="6" align="left" valign="middle" class="bodytext27"><strong><?php echo strtoupper($res616itemname).' ('.$nors.')'; ?></strong></td>
      </tr>

	<?php
	$query32="select * from pending_test_orders where patientcode = '$patientcode' and visitcode = '$visitcode' and testcode = '$res616itemcode' and sample_id = '$docnumber'  and result <> '' group by parametername order by auto_number";
	$exec32=mysqli_query($GLOBALS["___mysqli_ston"], $query32);
	$num32=mysqli_num_rows($exec32);
	while($res32=mysqli_fetch_array($exec32)){
	$resultvalue=$res32['result'];
	$resultvalue = str_replace('<','&lt;',$resultvalue);
	$resultvalue = str_replace('>','&gt;',$resultvalue);
	$sampletype = $res32['sample_type'];
	$referencename=$res32['parametername'];
	$query34 = "select * from master_labreference where itemcode = '$res616itemcode' and referencename = '$referencename'";
	$exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34);
	$res34=mysqli_fetch_array($exec34);
	$referencerange=$res34['referencerange'];
	$referenceunit=$res34['referenceunit'];
	$referenceunit = str_replace('<','&lt;',$referenceunit);
	$referenceunit = str_replace('>','&gt;',$referenceunit);
	$res12referencename = $res32['parametername'];
	//$color = $res32['color'];
	if($color == 'red') { $crit = 'H'; }
	else if($color == 'orange') { $crit = 'L'; }
	else if($color == 'green') { $crit = 'N'; }
	else { $crit = ''; }
	$refcomments = $res34['referencecomments'];
	$referencenumbers = $referencenumbers + 1;
	$refcomments = str_replace('border="1"','border="0"',$refcomments);		
		?>
     <tr>
	 <td align="left" valign="top" class="bodytext27"><?php echo $res12referencename; ?></td>
	 <td align="left" valign="top" class="bodytext27"><?php echo $resultvalue; ?></td>
	 <td align="left" valign="top" class="bodytext27"><?php echo $referenceunit; ?></td>
	 <td align="center" valign="top" class="bodytext27" style="color:<?= $color ?>"><strong><?php echo $crit; ?></strong></td>
	 <td align="left" valign="top" class="bodytext27"><?php echo $referencerange; ?></td>
	 <td align="left" valign="top" class="bodytext27"><?php echo $refcomments; ?></td>
	</tr>
      <?php } 
}
?>
	</table>
<table align="center" border="0" class="bodytext27"> 
<tr>
<td>&nbsp; </td>
</tr>
<tr>
<td>&nbsp; </td>
</tr>
<tr>
<td>&nbsp; </td>
</tr>
<tr>
<td>&nbsp; </td>
</tr>
</table>
<table align="center"  border="0" class="bodytext27"> 
	 <tr>
        <td width="209">REVIEWED :&nbsp;&nbsp;-------------------------</td>
        <td width="202">SIGNATURE:&nbsp;&nbsp;--------------------------</td>
         <td width="198">DATE:&nbsp;&nbsp;----------------------</td>
      </tr>
      <tr>
       	 <td width="199"><strong>Quality Manager/Laboratory Director</strong></td>
        <td width="192"><strong>Lab Technollogist</strong> </td>
		
         <td width="198">Printed By: <?php echo strtoupper($res8jobdescription); ?></td>
      </tr>

      <tr>
        <td width="179">Reviewed By:&nbsp;<?php echo strtoupper($res4jobdescription); ?></td>
        <td width="172">Acknowledged By:&nbsp;<?php echo strtoupper($res41jobdescription); ?></td>
       
        <td width="178">Printed On: <?php echo date('d-M-Y g:i:A'); ?></td>
      </tr>
	  <tr>
        <td width="179">&nbsp;</td>
        <td width="172">&nbsp; </td>
       
        <td width="178">&nbsp;</td>
      </tr>
    </table>
<table border="0" align="center" width="540" height="" id="footer">
		<tr>
			  <td width="540" align="center" valign="top" class="bodytext31">--------End of Report--------</td>
	  </tr>
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
?>