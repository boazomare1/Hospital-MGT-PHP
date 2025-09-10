<?php
session_start();
include ("db/db_connect.php");
//date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = "";
$timeonly = date('H:i:s');
$colorloopcount = '';
ob_start();
 if(isset($_REQUEST['category_id'])){$category_id = $_REQUEST['category_id'];}else{$category_id='';}

$timeonly = date('H:i:s');
$dateonly=date("Y-m-d");

$docno = $_SESSION['docno'];

$patientcode=isset($_REQUEST['patientcode'])?$_REQUEST['patientcode']:'';
$patientvisitcode=isset($_REQUEST['visitcode'])?$_REQUEST['visitcode']:'';
$patientname=isset($_REQUEST['patient'])?$_REQUEST['patient']:'';
$docnum1=isset($_REQUEST['docnumber'])?$_REQUEST['docnumber']:'';

if(isset($_REQUEST['searchstatus'])){$searchstatus = $_REQUEST['searchstatus'];}else{$searchstatus='';}

//get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}
		//location get end here
		
//To populate the autocompetelist_services1.js


$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');



if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{

//$medicinecode = $_REQUEST['medicinecode'];

if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
if (isset($_REQUEST["patienttype"])) { $patienttype = $_REQUEST["patienttype"]; } else { $patienttype = ""; }
}

?>

<?php

function get_time($g_datetime){
$from=date_create(date('Y-m-d H:i:s',strtotime($g_datetime)));
$to=date_create(date('Y-m-d H:i:s'));
$diff=date_diff($to,$from);
//print_r($diff);
$y = $diff->y > 0 ? $diff->y.' Years <br>' : '';
$m = $diff->m > 0 ? $diff->m.' Months <br>' : '';
$d = $diff->d > 0 ? $diff->d.' Days <br>' : '';
$h = $diff->h > 0 ? $diff->h.' Hrs <br>' : '';
$mm = $diff->i > 0 ? $diff->i.' Mins <br>' : '';
$ss = $diff->s > 0 ? $diff->s.' Secs <br>' : '';

echo $y.' '.$m.' '.$d.' '.$h.' '.$mm.' '.$ss.' ';
}

?>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000; FONT-FAMILY: Tahoma; }
-->
      .table {
          display: table;
      }
      .tr {
          display: table-row;
      }
      .highlight {
          background-color: greenyellow;
          display: table-cell;
      }
</style>

<table width="100%" border="0" cellspacing="0" cellpadding="2" style="border-collapse:collapse">  
		 

<?php
function calculate_age($birthday)
{
 
 if($birthday=="0000-00-00")
 {
  return "0 Days";
 }
 
    $today = new DateTime();
    $diff = $today->diff(new DateTime($birthday));

    if ($diff->y)
    {
        return $diff->y . ' Years';
    }
    elseif ($diff->m)
    {
        return $diff->m . ' Months';
    }
    else
    {
        return $diff->d . ' Days';
    }
}
?>		  
				<?php
				
	if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{			
				
				if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{

$ADate1 = $_REQUEST["ADate1"];
$ADate2 = $_REQUEST["ADate2"];
}
else
{
$ADate1 = $transactiondateto;
$ADate2 = $transactiondateto;
}
$sno=0;
$total=0;

?>
<tr bgcolor="#666666" style="color:#FFFFFF;font-weight:bold" >
	<td colspan="7">Pending Requests</td>
	<td colspan="2" align="right"><?= date('d-m-Y H:i:s') ?></td>
</tr>	
<tr bgcolor="#ccc" style="color:#000;">	
	<td colspan="2" >Period</td><td colspan="3"><?= date('d/m/Y',strtotime($ADate1))." to ".date('d/m/Y',strtotime($ADate2)); ?> </td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr bgcolor="#ccc"  style="color:#000;">
	<td colspan="2" bgcolor="#ccc">Only Section </td><td colspan="3"><?php 	
	    $queryaa1 = "select * from master_categorylab where auto_number='$category_id' order by categoryname ";
			$execaa1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryaa1) or die ("Error in Queryaa1".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($resaa1 = mysqli_fetch_array($execaa1))
		{

			$data_count=0;
			echo $categoryname = $resaa1["categoryname"];
		}else{
		echo "All";
		}

	  ?></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr bgcolor="#ccc"  style="color:#000;">	
	<td colspan="2" >Patient Type</td><td colspan="3"><?= $patienttype; ?> </td>
		<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>

</tr>
<tr>
	<td><br /></td>
</tr>

<?php
			$colorloopcount = '';
			$sno = '';

	if($category_id!='')
	{
	    $queryaa1 = "select * from master_categorylab where auto_number='$category_id' order by categoryname ";
	}else{
	    $queryaa1 = "select * from master_categorylab order by categoryname ";
		}

		$execaa1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryaa1) or die ("Error in Queryaa1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($resaa1 = mysqli_fetch_array($execaa1))
		{

		$data_count=0;
		$categoryname = $resaa1["categoryname"];
		$auto_number = $resaa1["auto_number"];
?>

				 
<?php

$snovisit=0;
if($patienttype != 'IP') {
$queryvisit7 = "select a.recorddate,a.recordtime,a.itemcode,a.patientname,a.patientcode,a.patientvisitcode,a.docnumber from samplecollection_lab as a JOIN master_lab as b ON a.itemcode=b.itemcode and b.categoryname='$categoryname' where a.locationcode = '".$locationcode."' and a.patientname like '%$patientname%' and a.patientcode like '%$patientcode%' and a.patientvisitcode like '%$patientvisitcode%'  and a.acknowledge = 'completed' and a.status = 'completed' and a.resultentry = '' and a.refund <> 'refund' and a.docnumber like '%$docnum1%' and a.recorddate between '$ADate1' and '$ADate2' group by a.patientvisitcode order by a.recorddate ";
$execvisit7 = mysqli_query($GLOBALS["___mysqli_ston"], $queryvisit7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));						
while($resvisit7 = mysqli_fetch_array($execvisit7))
{
	$patientnamevisit6 = $resvisit7['patientname'];
//$patientnamevisit6 = addslashes($patientnamevisit6);
 $regnovisit = $resvisit7['patientcode'];
$visitnovisit = $resvisit7['patientvisitcode'];
$snovisit=$snovisit+1;
  $docnum = $resvisit7['docnumber'];
$billdate6 = $resvisit7['recorddate'];
$recordtime = $resvisit7['recordtime'];

			$query111 = "select gender,departmentname from master_visitentry where visitcode='$visitnovisit'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$department = $res111['departmentname'];
			$gender = $res111['gender'];
			
			$query69="select * from master_customer where customercode='$regnovisit'";
			$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res69=mysqli_fetch_array($exec69);
			 $patientdob=$res69['dateofbirth'];			


?>

			<tr>
              <td style="border:1px #000 solid" width="3%"  align="left" valign="center"  
                 class="bodytext31"><strong>Sno</strong></td>          
              <td style="border:1px #000 solid" width="8%" align="left" valign="center"  
                 class="bodytext31"><strong>Date</strong></td>
              <td style="border:1px #000 solid" width="7%" align="left" valign="center"  
                 class="bodytext31"><strong>Time</strong></td>
             <td style="border:1px #000 solid" width="10%"  align="left" valign="center" 
                 class="bodytext31"><strong>Patientcode </strong></td>
              <td style="border:1px #000 solid" width="9%"  align="left" valign="center" 
                 class="bodytext31"><strong>Visitcode</strong></td>
              <td style="border:1px #000 solid" width="20%"  align="left" valign="center" 
                 class="bodytext31"><strong>Patient</strong></td>
               <td style="border:1px #000 solid" width="6%"  align="left" valign="center" 
                 class="bodytext31"><strong>Age</strong></td>
              <td style="border:1px #000 solid" width="5%"  align="left" valign="center" 
                 class="bodytext31"><strong>Gender</strong></td>
              <td style="border:1px #000 solid" width="13%"  align="left" valign="center" 
                 class="bodytext31"><strong>Ward/Department</strong></td>
  </tr>

			  <tr>
             
              <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $sno=$sno+1; ?></td>
              <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $billdate6; ?></td>
                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $recordtime; ?></td>
                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $regnovisit; ?></td>
                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $regnovisit; ?></td>
                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $patientnamevisit6; ?></td>
                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo calculate_age($patientdob); ?></td>
                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $gender; ?></td>
					 <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $department; ?></td>
     			</tr>

<?php
$query7 = "select a.patientname,a.patientcode,a.patientvisitcode,a.recorddate,a.itemname,a.itemcode,a.sample,a.sampleid,a.docnumber,a.username,a.entrywork,a.entryworkby,a.recordtime from samplecollection_lab as a JOIN master_lab as b ON a.itemcode=b.itemcode and b.categoryname='$categoryname' where a.locationcode = '".$locationcode."' and a.patientname like '$patientnamevisit6' and a.patientcode like '$regnovisit' and a.patientvisitcode like '$visitnovisit'  and a.acknowledge = 'completed' and a.status = 'completed' and a.resultentry = '' and a.refund <> 'refund' and a.recorddate between '$ADate1' and '$ADate2' and a.externallab ='' order by a.recorddate ";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));						
while($res7 = mysqli_fetch_array($exec7))
{
$waitingtime='';
 $patientname6 = $res7['patientname'];
$patientname6 = addslashes($patientname6);
$regno = $res7['patientcode'];
$visitno = $res7['patientvisitcode'];
$billdate6 = $res7['recorddate'];
$test = $res7['itemname'];
$itemcode = $res7['itemcode'];
$sample = $res7['sample'];
$sampleid = $res7['sampleid'];
 $docnumber = $res7['docnumber'];
$collected=$res7['username'];
$entrywork = $res7['entrywork'];
$entryworkby = $res7['entryworkby'];
$recordtime = $res7['recordtime'];

$querycon="select username,accountname from consultation_lab where patientcode='$regno' and patientvisitcode='$visitno' and labitemcode='$itemcode' and docnumber='$docnumber'";
$queryconex=mysqli_query($GLOBALS["___mysqli_ston"], $querycon) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$queryconx=mysqli_fetch_array($queryconex);
$requested=$queryconx['username'];
$account = $queryconx['accountname'];


			$requestedusr=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$requested' and locationcode='$locationcode' and username <> '' and status='Active'");
			$resrequser=mysqli_fetch_array($requestedusr);
			$requesteduser=$resrequser['employeename'];
			
			$collectedusr=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$collected' and locationcode='$locationcode' and username <> '' and status='Active'");
			$rescoluser=mysqli_fetch_array($collectedusr);
			$samplecolluser=$rescoluser['employeename'];

			if($regno=='walkin')
			{
				$requesteduser="SELF";
			}
		
			
if($entrywork == '')
{
$entrywork = 'Pending';
}
				$waitingtime = (strtotime($timeonly) - strtotime($recordtime))/60;
				$waitingtime = round($waitingtime);
				
				if($entrywork == 'Pending')
				{				
					$waitingtime1 = $waitingtime;
				}
				else
				{
					$waitingtime1 = '';
				}
				
				if($regno == 'walkin')
				{
				$query43 = "select urgentstatus from consultation_lab where patientvisitcode='$visitno' and patientname='$patientname6' and labsamplecoll = 'completed' and labitemcode = '$itemcode' and (labrefund <> 'norefund' or labrefund = '') and (sampleid ='$sampleid' or sampleid = '')";
				$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				 $num43 = mysqli_num_rows($exec43);
				 $num43='1';
				}
				else
				{
			 	$query43 = "select urgentstatus from consultation_lab where patientvisitcode='$visitno' and labsamplecoll = 'completed' and labitemcode = '$itemcode' and (labrefund = 'norefund' or labrefund = '') and (sampleid ='$sampleid' or sampleid = '')";
				$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				 $num43 = mysqli_num_rows($exec43);
				}
				$res43 = mysqli_fetch_array($exec43);
				$urgentstatus=$res43['urgentstatus'];
				if($num43 > 0)
				{
				
	
				$colorloopcount = $colorloopcount + 1;
				$showcolor = ($colorloopcount & 1); 
				if ($showcolor == 0)
				{
					//echo "if";
					$colorcode = 'bgcolor="#FFF"';
				}
				else
				{
					//echo "else";
					$colorcode = 'bgcolor="#FFF"';
				}	
				if($urgentstatus==1)
				{
					$colorcode= 'bgcolor="#FFFF"';
				}
				$data_count++;
				?>
				<tr>				
              <td style="border:1px #000 solid" align="left" valign="center"  
                 class="bodytext31"><strong>Test</strong></td>
				 <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31" colspan="3" ><strong><?php echo $test; ?></strong></td>

			  <td style="border:1px #000 solid" colspan="5" align="left" valign="center"  
                 class="bodytext31"> </td>
				
             </tr>  
			

				<?php
				} 
				}

			?>
						 
			 <tr style="border-left:none;border-right:none;border:none">
			  <td style="border-left:none;border-right:none" colspan="9"> <br><br></td>
			 
			 </tr>        

			<?php	
				
 $query7 = "select patientname,patientcode,patientvisitcode,recorddate,itemname,itemcode,sample,username,sampleid,docnumber,entrywork,entryworkby,recordtime from samplecollection_lab where locationcode = '".$locationcode."' and patientname like '$patientnamevisit6' and patientcode like '$regnovisit' and patientvisitcode like '$visitnovisit'  and acknowledge = 'completed' and status = 'completed' and resultentry = '' and refund = 'norefund' and docnumber like '$docnum' and recorddate between '$ADate1' and '$ADate2' and externallab !='' and externalack ='acknowledge' order by recorddate ";

$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));						
while($res7 = mysqli_fetch_array($exec7))
{			
$waitingtime='';
 $patientname6 = $res7['patientname'];
$patientname6 = addslashes($patientname6);
$regno = $res7['patientcode'];
$visitno = $res7['patientvisitcode'];
$billdate6 = $res7['recorddate'];
$test = $res7['itemname'];
$itemcode = $res7['itemcode'];
$sample = $res7['sample'];
$collected=$res7['username'];
$sampleid = $res7['sampleid'];
$docnumber = $res7['docnumber'];
$entrywork = $res7['entrywork'];
$entryworkby = $res7['entryworkby'];
$recordtime = $res7['recordtime'];

$querycon="select username.accountname from consultation_lab where patientcode='$regno' and patientvisitcode='$visitno' and labitemcode='$itemcode' and docnumber='$docnumber'";
$queryconex=mysqli_query($GLOBALS["___mysqli_ston"], $querycon) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$queryconx=mysqli_fetch_array($queryconex);
$requested=$queryconx['username'];
$account = $queryconx['accountname'];


			$requestedusr=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$requested' and locationcode='$locationcode' and username <> '' and status='Active'");
			$resrequser=mysqli_fetch_array($requestedusr);
			$requesteduser=$resrequser['employeename'];
			
			$collectedusr=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$collected' and locationcode='$locationcode' and username <> '' and status='Active'");
			$rescoluser=mysqli_fetch_array($collectedusr);
			$samplecolluser=$rescoluser['employeename'];
			
			if($regno=='walkin')
			{
				$requesteduser="SELF";
			}
	
			$query111 = "select departmentname,gender from master_visitentry where visitcode='$visitno'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$department = $res111['departmentname'];
			$gender = $res111['gender'];

			$query69="select * from master_customer where customercode='$regno'";
			$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res69=mysqli_fetch_array($exec69);
			 $patientdob=$res69['dateofbirth'];	
			 			
if($entrywork == '')
{
$entrywork = 'Pending';
}
				$waitingtime = (strtotime($timeonly) - strtotime($recordtime))/60;
				$waitingtime = round($waitingtime);
				
				if($entrywork == 'Pending')
				{				
					$waitingtime1 = $waitingtime;
				}
				else
				{
					$waitingtime1 = '';
				}
				
				if($regno == 'walkin')
				{
				$query43 = "select urgentstatus from consultation_lab where patientvisitcode='$visitno' and patientname='$patientname6' and labsamplecoll = 'completed' and labitemcode = '$itemcode' and (labrefund = 'norefund' or labrefund = '') and (sampleid ='$sampleid' or sampleid = '')";
				}
				else
				{
				$query43 = "select urgentstatus from consultation_lab where patientvisitcode='$visitno' and labsamplecoll = 'completed' and labitemcode = '$itemcode' and (labrefund = 'norefund' or labrefund = '') and (sampleid ='$sampleid' or sampleid = '')";
				}
				$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				 $num43 = mysqli_num_rows($exec43);
				$res43 = mysqli_fetch_array($exec43);
				$urgentstatus=$res43['urgentstatus'];
				if($num43 > 0)
				{
				
	
				$colorloopcount = $colorloopcount + 1;
				$showcolor = ($colorloopcount & 1); 
				if ($showcolor == 0)
				{
					//echo "if";
					$colorcode = 'bgcolor="#FFF"';
				}
				else
				{
					//echo "else";
					$colorcode = 'bgcolor="#FFF"';
				}	
				if($urgentstatus==1)
				{
					$colorcode= 'bgcolor="#FFFF"';
				}
				$data_count++;
				?>
			<tr>
              <td style="border:1px #000 solid"  align="left" valign="center"  
                 class="bodytext31"><strong>Sno</strong></td>          
              <td style="border:1px #000 solid"  align="left" valign="center"  
                 class="bodytext31"><strong>Date</strong></td>
              <td style="border:1px #000 solid"  align="left" valign="center"  
                 class="bodytext31"><strong>Time</strong></td>
             <td style="border:1px #000 solid"  align="left" valign="center" 
                 class="bodytext31"><strong>Patientcode </strong></td>
              <td style="border:1px #000 solid"  align="left" valign="center" 
                 class="bodytext31"><strong>Visitcode</strong></td>
              <td style="border:1px #000 solid"   align="left" valign="center" 
                 class="bodytext31"><strong>Patient</strong></td>
               <td style="border:1px #000 solid" align="left" valign="center" 
                 class="bodytext31"><strong>Age</strong></td>
              <td style="border:1px #000 solid" align="left" valign="center" 
                 class="bodytext31"><strong>Gender</strong></td>
              <td style="border:1px #000 solid" align="left" valign="center" 
                 class="bodytext31"><strong>Ward/Department</strong></td>
  </tr>

				 <tr>
             
              <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $sno=$sno+1; ?></td>
             <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $billdate6; ?></td>
                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $recordtime; ?></td>
                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $regno; ?></td>
                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $visitno; ?></td>
                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $patientname6; ?></td>
                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo calculate_age($patientdob); ?></td>
                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $gender; ?></td>
			    <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $department; ?></td>
     			</tr>
				<tr>				
              <td style="border:1px #000 solid" align="left" valign="center"  
                 class="bodytext31"><strong>Test</strong></td>
				 <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><strong><?php echo $test; ?></strong></td>

			  <td style="border:1px #000 solid" colspan="7" align="left" valign="center"  
                 class="bodytext31"></td>
				
             </tr> 
			 <tr style="border-left:none;border-right:none;border:none">
			  <td style="border-left:none;border-right:none" colspan="9"> <br><br></td>
			 
			 </tr>   
				<?php
				} 
				
}
				
				}
				}
				?>
				<?php
				if($patienttype != 'OP+EXTERNAL') {
				 $queryipvisit98a = "select a.recorddate,a.recordtime,a.docnumber,a.patientname,a.patientcode,a.patientvisitcode from ipsamplecollection_lab as a JOIN master_lab as b ON a.itemcode=b.itemcode and b.categoryname='$categoryname' where a.locationcode = '".$locationcode."' and a.patientname like '%$patientname%' and a.patientcode like '%$patientcode%' and a.patientvisitcode like '%$patientvisitcode%' and a.acknowledge = 'completed' and a.resultentry = '' and a.refund = 'norefund' and a.docnumber like '%$docnum1%'  and a.recorddate between '$ADate1' and '$ADate2'  group by a.patientvisitcode order by a.recorddate ";
				$execipvisit98a = mysqli_query($GLOBALS["___mysqli_ston"], $queryipvisit98a) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
										
				while($resipvisit98a = mysqli_fetch_array($execipvisit98a))
				{
					$patientnameipvisit6 = $resipvisit98a['patientname'];				
					$regnoipvisit = $resipvisit98a['patientcode'];
					$visitnoipvisit = $resipvisit98a['patientvisitcode'];
					$snovisit=$snovisit+1;
					$docnum=$resipvisit98a['docnumber'];
				$billdate6 = $resipvisit98a['recorddate'];
				$recordtime = $resipvisit98a['recordtime'];
				
			$query111 = "select gender from master_ipvisitentry where visitcode='$visitnoipvisit'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$gender = $res111['gender'];
			
			$query69="select * from master_customer where customercode='$regnoipvisit'";
			$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res69=mysqli_fetch_array($exec69);
			 $patientdob=$res69['dateofbirth'];		

				
				$warddate="select ward from master_ward where auto_number in(select ward from ip_bedallocation where patientcode='$regnoipvisit' and visitcode='$visitnoipvisit' and recordstatus NOT IN ('discharged','transfered'))";
		
			$exeward=mysqli_query($GLOBALS["___mysqli_ston"], $warddate);
			$resward=mysqli_fetch_array($exeward);
			$ward=$resward['ward'];
			$numrow=mysqli_num_rows($exeward);
					if($numrow =='0')

{			$warddate1="select ward from master_ward where auto_number in(select ward from ip_bedtransfer where patientcode='$regnoipvisit' and visitcode='$visitnoipvisit' and recordstatus NOT IN ('discharged','transfered') )";
		
			$exeward1=mysqli_query($GLOBALS["___mysqli_ston"], $warddate1);
			$resward1=mysqli_fetch_array($exeward1);
			$ward=$resward1['ward'];
			
}
			

					?>
			<tr>
              <td style="border:1px #000 solid"  align="left" valign="center"  
                 class="bodytext31"><strong>Sno</strong></td>          
              <td style="border:1px #000 solid"  align="left" valign="center"  
                 class="bodytext31"><strong>Date</strong></td>
              <td style="border:1px #000 solid"  align="left" valign="center"  
                 class="bodytext31"><strong>Time</strong></td>
             <td style="border:1px #000 solid"  align="left" valign="center" 
                 class="bodytext31"><strong>Patientcode </strong></td>
              <td style="border:1px #000 solid"  align="left" valign="center" 
                 class="bodytext31"><strong>Visitcode</strong></td>
              <td style="border:1px #000 solid"   align="left" valign="center" 
                 class="bodytext31"><strong>Patient</strong></td>
               <td style="border:1px #000 solid" align="left" valign="center" 
                 class="bodytext31"><strong>Age</strong></td>
              <td style="border:1px #000 solid" align="left" valign="center" 
                 class="bodytext31"><strong>Gender</strong></td>
              <td style="border:1px #000 solid" align="left" valign="center" 
                 class="bodytext31"><strong>Ward/Department</strong></td>
  </tr>
				 <tr>
             
              <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $sno=$sno+1; ?></td>              
              <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $billdate6; ?></td>
                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $recordtime; ?></td>
                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $visitnoipvisit; ?></td>
                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $visitnoipvisit; ?></td>
                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $patientnameipvisit6; ?></td>
                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo calculate_age($patientdob); ?></td>
                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $gender; ?></td>
                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $ward; ?></td>
     			</tr>				
              <?php
				 $query98 = "select a.patientname,a.patientcode,a.patientvisitcode,a.recorddate,a.itemname,a.itemcode,a.sample,a.username,a.sampleid,a.docnumber,a.recordtime from ipsamplecollection_lab as a JOIN master_lab as b ON a.itemcode=b.itemcode and b.categoryname='$categoryname' where a.locationcode = '".$locationcode."' and a.patientcode like '$regnoipvisit' and a.patientvisitcode like '$visitnoipvisit'   and a.acknowledge = 'completed' and a.resultentry = '' and a.refund = 'norefund'   and a.recorddate between '$ADate1' and '$ADate2' and a.transferloccode =''  order by a.recorddate ";
				$exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die(mysqli_error($GLOBALS["___mysqli_ston"]));						
				while($res98 = mysqli_fetch_array($exec98))
				{
				$waitingtime='';
				 $patientname6 = $res98['patientname'];
				$patientname6 = addslashes($patientname6);
				$regno = $res98['patientcode'];
				$visitno = $res98['patientvisitcode'];
				$billdate6 = $res98['recorddate'];
				$test = $res98['itemname'];
				$itemcode = $res98['itemcode'];
				$sample = $res98['sample'];
				$usernameip = $res98['username'];
				$collected = '';
				$sampleid = $res98['sampleid'];
				$docnumber = $res98['docnumber'];
				$entrywork = '';
				$entryworkby = '';
				$recordtime = $res98['recordtime'];
				
				$querysample="select username,accountname from ipconsultation_lab where patientcode='$regno' and patientvisitcode='$visitno' and labitemcode='$itemcode' and docnumber='$docnumber'";
$querysamplexc=mysqli_query($GLOBALS["___mysqli_ston"], $querysample) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$samplexc=mysqli_fetch_array($querysamplexc);
$requested=$samplexc['username'];
$account = $samplexc['accountname'];

			$requestedusr=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$requested' and locationcode='$locationcode' and username <> '' and status='Active'");
			$resrequser=mysqli_fetch_array($requestedusr);
			$requesteduser=$resrequser['employeename'];
			
			$collectedusr=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$usernameip' and locationcode='$locationcode' and username <> '' and status='Active'");
			$rescoluser=mysqli_fetch_array($collectedusr);
			$samplecolluser=$rescoluser['employeename'];
				
				
		$query111 = "select gender from master_ipvisitentry where visitcode='$visitno'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$gender = $res111['gender'];
			
			$query69="select * from master_customer where customercode='$regno'";
			$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res69=mysqli_fetch_array($exec69);
			 $patientdob=$res69['dateofbirth'];		

				
				$warddate="select ward from master_ward where auto_number in(select ward from ip_bedallocation where patientcode='$regno' and visitcode='$visitno' and recordstatus NOT IN ('discharged','transfered'))";
		
			$exeward=mysqli_query($GLOBALS["___mysqli_ston"], $warddate);
			$resward=mysqli_fetch_array($exeward);
			$ward=$resward['ward'];
			$numrow=mysqli_num_rows($exeward);
					if($numrow =='0')

{			$warddate1="select ward from master_ward where auto_number in(select ward from ip_bedtransfer where patientcode='$regno' and visitcode='$visitno' and recordstatus NOT IN ('discharged','transfered') )";
		
			$exeward1=mysqli_query($GLOBALS["___mysqli_ston"], $warddate1);
			$resward1=mysqli_fetch_array($exeward1);
			$ward=$resward1['ward'];
			
}
			
				if($entrywork == '')
				{
				$entrywork = 'Pending';
				}
				$waitingtime = (strtotime($timeonly) - strtotime($recordtime))/60;
				$waitingtime = round($waitingtime);
				
				if($entrywork == 'Pending')
				{				
					$waitingtime1 = $waitingtime;
				}
				else
				{
					$waitingtime1 = '';
				}
				
				
				 $query431 = "select * from ipconsultation_lab where patientvisitcode='$visitno' and labsamplecoll = 'completed' and labitemcode = '$itemcode' and (labrefund = 'norefund' or labrefund = '') and (sampleid ='$sampleid' or sampleid = '')";
				$exec431 = mysqli_query($GLOBALS["___mysqli_ston"], $query431) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			 	$num431 = mysqli_num_rows($exec431);
				//echo "<br>";
				if($num431 > 0)
				{
				
	
				$colorloopcount = $colorloopcount + 1;
				$showcolor = ($colorloopcount & 1); 
				if ($showcolor == 0)
				{
					//echo "if";
					$colorcode = 'bgcolor="#FFF"';
				}
				else
				{
					//echo "else";
					$colorcode = 'bgcolor="#FFF"';
				}	
				$data_count++;
				?>

				<tr>				
              <td style="border:1px #000 solid" align="left" valign="center"  
                 class="bodytext31"><strong>Test</strong></td>
				 <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31" colspan="3"><strong><?php echo $test; ?></strong></td>

			  <td style="border:1px #000 solid" colspan="5" align="left" valign="center"  
                 class="bodytext31"></td>
				
             </tr> 
				<?php
				} 
				}
?>

			 <tr style="border-left:none;border-right:none;border:none">
			  <td style="border-left:none;border-right:none" colspan="9"> <br><br></td>
			 
			 </tr>   				
<?php				
				
					$query98 = "select patientname,patientcode,patientvisitcode,recorddate,itemname,itemcode,sample,username,sampleid,docnumber,recordtime from ipsamplecollection_lab where locationcode = '".$locationcode."' and patientcode like '$regnoipvisit' and patientvisitcode like '$visitnoipvisit'   and acknowledge = 'completed' and resultentry = '' and refund = 'norefund' and docnumber like '$docnum'  and recorddate between '$ADate1' and '$ADate2' and transferloccode !='' and externalack = 'acknowledge'  order by recorddate ";
				$exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die(mysqli_error($GLOBALS["___mysqli_ston"]));						
				while($res98 = mysqli_fetch_array($exec98))
				{
				$waitingtime='';
				 $patientname6 = $res98['patientname'];
				$patientname6 = addslashes($patientname6);
				$regno = $res98['patientcode'];
				$visitno = $res98['patientvisitcode'];
				$billdate6 = $res98['recorddate'];
				$test = $res98['itemname'];
				$itemcode = $res98['itemcode'];
				$sample = $res98['sample'];
				$collected = '';
				$usernameip1=$res98['username'];
				$sampleid = $res98['sampleid'];
				$docnumber = $res98['docnumber'];
				$entrywork = '';
				$entryworkby = '';
				$recordtime = $res98['recordtime'];
				
				
				$querysample="select username,accountname from ipconsultation_lab where patientcode='$regno' and patientvisitcode='$visitno' and labitemcode='$itemcode' and docnumber='$docnumber'";
$querysamplexc=mysqli_query($GLOBALS["___mysqli_ston"], $querysample) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$samplexc=mysqli_fetch_array($querysamplexc);
$requested=$samplexc['username'];
$account = $samplexc['accountname'];				
				
		$query111 = "select gender from master_ipvisitentry where visitcode='$visitno'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$gender = $res111['gender'];
			
			$query69="select * from master_customer where customercode='$regno'";
			$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res69=mysqli_fetch_array($exec69);
			 $patientdob=$res69['dateofbirth'];		

				$requestedusr=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$requested' and locationcode='$locationcode' and username <> '' and status='Active'");
			$resrequser=mysqli_fetch_array($requestedusr);
			$requesteduser=$resrequser['employeename'];
			
			$collectedusr=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$usernameip1' and locationcode='$locationcode' and username <> '' and status='Active'");
			$rescoluser=mysqli_fetch_array($collectedusr);
			$samplecolluser=$rescoluser['employeename'];
				
				$warddate="select ward from master_ward where auto_number in(select ward from ip_bedallocation where patientcode='$regno' and visitcode='$visitno' and recordstatus NOT IN ('discharged','transfered'))";
		
			$exeward=mysqli_query($GLOBALS["___mysqli_ston"], $warddate);
			$resward=mysqli_fetch_array($exeward);
			$ward=$resward['ward'];
			$numrow=mysqli_num_rows($exeward);
					if($numrow =='0')

{			$warddate1="select ward from master_ward where auto_number in(select ward from ip_bedtransfer where patientcode='$regno' and visitcode='$visitno' and recordstatus NOT IN ('discharged','transfered') )";
		
			$exeward1=mysqli_query($GLOBALS["___mysqli_ston"], $warddate1);
			$resward1=mysqli_fetch_array($exeward1);
			$ward=$resward1['ward'];
			
}
			
				if($entrywork == '')
				{
				$entrywork = 'Pending';
				}
				$waitingtime = (strtotime($timeonly) - strtotime($recordtime))/60;
				$waitingtime = round($waitingtime);
				
				if($entrywork == 'Pending')
				{				
					$waitingtime1 = $waitingtime;
				}
				else
				{
					$waitingtime1 = '';
				}
				
				
				 $query431 = "select * from ipconsultation_lab where patientvisitcode='$visitno' and labsamplecoll = 'completed' and labitemcode = '$itemcode' and (labrefund = 'norefund' or labrefund = '') and (sampleid ='$sampleid' or sampleid = '')";
				$exec431 = mysqli_query($GLOBALS["___mysqli_ston"], $query431) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			 	$num431 = mysqli_num_rows($exec431);
				//echo "<br>";
				if($num431 > 0)
				{
				
	
				$colorloopcount = $colorloopcount + 1;
				$showcolor = ($colorloopcount & 1); 
				if ($showcolor == 0)
				{
					//echo "if";
					$colorcode = 'bgcolor="#FFF"';
				}
				else
				{
					//echo "else";
					$colorcode = 'bgcolor="#FFF"';
				}	
				$data_count++;
				?>
			<tr>
              <td style="border:1px #000 solid"  align="left" valign="center"  
                 class="bodytext31"><strong>Sno</strong></td>          
              <td style="border:1px #000 solid"  align="left" valign="center"  
                 class="bodytext31"><strong>Date</strong></td>
              <td style="border:1px #000 solid"  align="left" valign="center"  
                 class="bodytext31"><strong>Time</strong></td>
             <td style="border:1px #000 solid"  align="left" valign="center" 
                 class="bodytext31"><strong>Patientcode </strong></td>
              <td style="border:1px #000 solid"  align="left" valign="center" 
                 class="bodytext31"><strong>Visitcode</strong></td>
              <td style="border:1px #000 solid"   align="left" valign="center" 
                 class="bodytext31"><strong>Patient</strong></td>
               <td style="border:1px #000 solid" align="left" valign="center" 
                 class="bodytext31"><strong>Age</strong></td>
              <td style="border:1px #000 solid" align="left" valign="center" 
                 class="bodytext31"><strong>Gender</strong></td>
              <td style="border:1px #000 solid" align="left" valign="center" 
                 class="bodytext31"><strong>Ward/Department</strong></td>
  </tr>
				 <tr>
             
              <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $sno=$sno+1; ?></td>
	              <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $billdate6; ?></td>
                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $recordtime; ?></td>
          	   <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $regno; ?></td>
                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $visitno; ?></td>
                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $patientname6; ?></td>
                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo calculate_age($patientdob); ?></td>
                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $gender; ?></td>
	                <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><?php echo $ward; ?></td>
     			</tr>
				<tr>				
              <td style="border:1px #000 solid" align="left" valign="center"  
                 class="bodytext31"><strong>Test</strong></td>
				 <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31"><strong><?php echo $test; ?></strong></td>

			  <td style="border:1px #000 solid" colspan="7" align="left" valign="center"  
                 class="bodytext31"></td>
				</tr>
			 <tr style="border-left:none;border-right:none;border:none">
			  <td style="border-left:none;border-right:none" colspan="9"> <br><br></td>
			 
			 </tr>   
			 <?php
				} 
				}
				
				}
				}
				$lastsno=$sno;
				?>

	<?php
		
	}
?>   
           </tbody>
		  </table>
		  <?php } ?>
 
 	
<?php	
require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4");
$dompdf->render();
//$canvas = $dompdf->get_canvas();
//$canvas->line(10,800,800,800,array(0,0,0),1);
//$font = Font_Metrics::get_font("times-roman", "normal");
//$canvas->page_text(272, 900, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("Bankreport.pdf", array("Attachment" => 0)); 
?>	