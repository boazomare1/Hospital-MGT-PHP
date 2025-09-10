<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }
	
$query1 = "select * from master_location where locationcode='$locationcode' ";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
						 $locationname = $res1["locationname"];
						 $locationcode = $res1["locationcode"];
			}




if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag1 == 'frmflag1')
{
       
		$paynowbillprefix7 = 'PN-';
$paynowbillprefix17=strlen($paynowbillprefix7);
$query27 = "select * from ip_progressnotes order by auto_number desc limit 0, 1";
$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));
$res27 = mysqli_fetch_array($exec27);
$billnumber7 = $res27["docno"];
$billdigit7=strlen($billnumber7);

if ($billnumber7 == '')
{
	$billnumbercode7 =$paynowbillprefix7.'1';
		$openingbalance = '0.00';

}
else
{
	$billnumber7 = $res27["docno"];
	$billnumbercode7 = substr($billnumber7,$paynowbillprefix17, $billdigit7);
	//echo $billnumbercode;
	$billnumbercode7 = intval($billnumbercode7);
	$billnumbercode7 = $billnumbercode7 + 1;

	$maxanum7 = $billnumbercode7;
	
	
	$billnumbercode7 = $paynowbillprefix7 .$maxanum7;
		}
		$patientname = $_REQUEST['patientname'];
		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];
		$accname = $_REQUEST['accname'];
		$ward1 = $_REQUEST['wardanum'];
		$bed1 = $_REQUEST['bedanum'];
		$notes = $_REQUEST['notes'];
		$notes=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $notes);
			
		$query33 = "select * from ip_progressnotes where docno='$billnumbercode7'";
		$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num33 = mysqli_num_rows($exec33);
		if($num33 == 0)
		{
		if($notes != '')
		{
			$query67 = "insert into ip_progressnotes(docno,patientname,patientcode,visitcode,accountname,ward,bed,recordtime,recorddate,ipaddress,username,notes,locationcode)values('$billnumbercode7','$patientname','$patientcode','$visitcode','$accname','$ward1','$bed1','$updatetime','$updatedate','$ipaddress','$username','$notes', '$locationcode')";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
			}
		header("location:inpatientactivity.php");
		exit;

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
}


?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'PN-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ip_progressnotes order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);

if ($billnumber == '')
{
	$billnumbercode =$paynowbillprefix.'1';
		$openingbalance = '0.00';

}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paynowbillprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

?>
<?php

if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }


?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>

<script>


function validcheck()
{
if(document.getElementById("notes").value == '')
{
alert("Please Enter Notes");
document.getElementById("notes").focus();
return false;
}

}



function funcwardChange1()
{
	/*if(document.getElementById("ward").value == "1")
	{
		alert("You Cannot Add Account For CASH Type");
		document.getElementById("ward").focus();
		return false;
	}*/
	<?php 
	$query12 = "select * from master_ward where recordstatus=''";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res12 = mysqli_fetch_array($exec12))
	{
	$res12wardanum = $res12["auto_number"];
	$res12ward = $res12["ward"];
	$res12location = $res12["locationname"];
	$res12locationcode = $res12["locationcode"];
	?>
	if(document.getElementById("ward").value=="<?php echo $res12wardanum; ?>")
	{
		document.getElementById("bed").options.length=null; 
		var combo = document.getElementById('bed'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 
		<?php
		$query10 = "select * from master_bed where ward = '$res12wardanum' and recordstatus = ''";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10bedanum = $res10['auto_number'];
		$res10bed = $res10["bed"];
		//$res10location = $res10["locationname"];
		
		
		
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10bed;?>", "<?php echo $res10bedanum;?>"); 
		<?php 
		
		}
		?>
	}
	<?php
	}
	?>	
}

function funcdrugadmin(patientcode,visitcode,itemcode,i,docno)
{
var varpatientcode = patientcode;
var varvisitcode = visitcode;
var varitemcode = itemcode;
var varserial= i;
var vardocno = docno;
window.open("ipdrugadmin.php?patientcode="+varpatientcode+"&&visitcode="+varvisitcode+"&&itemcode="+varitemcode+"&&varserial="+varserial+"&&vardocno="+vardocno+"","OriginalWindowA5",'width=500,height=400,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}
</script>


<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
	<?php
	$query2 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode' and paymentstatus =''";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num2=mysqli_num_rows($exec2);
		
		while($res2 = mysqli_fetch_array($exec2))
		{
	    $patientlocation=$res2['locationname'];
	    $patientlocationcode=$res2['locationcode'];
		}
		
		?>

<form name="form1" id="form1" method="post" action="ipdrugchart.php" onSubmit="return validcheck()">	
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
  <td></td>
    <td colspan="13" class="bodytext31"><a href="inpatientactivity.php">Click to See IP Activity List</a></td>
  </tr>
  <tr>
    <td width="2%">&nbsp;</td>
   
    <td colspan="5" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
	 
	
		<tr>
		<td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
            <tr>
             
			    <td align="left" colspan="1" valign="middle" class="bodytext3"><strong>Doc No</strong></td>
				
				<td align="left" valign="middle" class="bodytext3">  <?php echo $billnumbercode; ?></td>
				
			    <td align="left" colspan="2" valign="middle" class="bodytext3"><strong>Date</strong></td>
				<td align="left"  colspan="2" valign="middle" class="bodytext3">  <?php echo $updatedate; ?></td>
			    <td align="right" colspan="" valign="middle" class="bodytext3"><strong>Time</strong>
				 <?php echo $updatetime; ?></td>
			   
			    <td align="right"  valign="middle" class="bodytext3"><strong>Location</strong>
				<?php
		  $query131 = "select * from master_location where locationcode = '$locationcode'";
          $exec131 = mysqli_query($GLOBALS["___mysqli_ston"], $query131) or die ("Error in Query131".mysqli_error($GLOBALS["___mysqli_ston"]));
          $res131 = mysqli_fetch_array($exec131);
          $locationname = $res131['locationname'];
	     ?>
				  <?php echo $locationname; ?></td>
			 <!--  <td width="10%" align="center" valign="center" class="bodytext31"><strong>Location No</strong></td> -->
			   <td colspan="1" align="left" valign="center" class="bodytext31"><input type="hidden" name="locationno" id="locationno" value="<?php echo $locationcode; ?>" ></td>
              <td colspan="1" valign="top">&nbsp;<table align="right">
                  <tr>
                    <td>&nbsp;</td>
                    <td width="41">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="middel" width="35" height="3"bgcolor="#ecf0f5"></td>
                    <td class="bodytext31">Pending</td>
                  
                    <td align="left" valign="middel" width="35" bgcolor="#33FF99"></td>
                    <td class="bodytext31">Complete</td>
                  
                    <td align="left" valign="middel" width="35" bgcolor="#FF0066"></td>
                    <td class="bodytext31"> Incomplete</td>
                  </tr>
              </table></td>
			  </tr>
            <tr>
              <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
              <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code </strong></div></td>
              <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Visit </strong></div></td>
              <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ward</strong></div></td>
              <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bed</strong></div></td>
              <td width="21%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
            </tr>
            <?php
            $colorloopcount ='';
		
		$query1 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode' and paymentstatus =''";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		$patientname=$res1['patientfullname'];
		$patientcode=$res1['patientcode'];
		$accountname = $res1['accountname'];
	    $gender = $res1['gender'];
		$age = $res1['age'];
		
		
		$query67 = "select * from master_accountname where auto_number='$accountname'";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
		$res67 = mysqli_fetch_array($exec67);
		$accname = $res67['accountname'];
		
		
		   $query63 = "select * from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus=''";
		   $exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res63 = mysqli_fetch_array($exec63);
		   $num63 = mysqli_num_rows($exec63);
		   if($num63 > 0)
		   {
		   $ward = $res63['ward'];
		   $bed = $res63['bed'];
		   }
		   
		   $query65 = "select * from ip_bedtransfer where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus=''";
		   $exec65 = mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res65 = mysqli_fetch_array($exec65);
		    $num65 = mysqli_num_rows($exec65);
		   if($num65 > 0)
		   {
		   $ward = $res65['ward'];
		   $bed = $res65['bed'];
		   }
		   
		   $query71 = "select * from ip_discharge where patientcode='$patientcode' and visitcode='$visitcode' order by auto_number desc";
		   $exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res71 = mysqli_fetch_array($exec71);
		   $num71 = mysqli_num_rows($exec71);
		   if($num71 > 0)
		   {
		    $ward = $res71['ward'];
		    $bed = $res71['bed'];
		   }
		
		$query7811 = "select * from master_ward where auto_number='$ward' and recordstatus=''";
						  $exec7811 = mysqli_query($GLOBALS["___mysqli_ston"], $query7811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						  $res7811 = mysqli_fetch_array($exec7811);
						  $wardname1 = $res7811['ward'];
						  
						  $query50 = "select * from master_bed where auto_number='$bed'";
		                  $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						  $res50 = mysqli_fetch_array($exec50);
						  $bedname = $res50['bed'];
	

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
              <td colspan="2"  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $patientname; ?></div></td>
              <td colspan="2"  align="center" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
              <td colspan="2"  align="center" valign="center" class="bodytext31"><?php echo $visitcode; ?></td>
              <td  align="center" valign="center" class="bodytext31"><?php echo $wardname1; ?></td>
              <td  align="center" valign="center" class="bodytext31"><?php echo $bedname; ?></td>
              <td  align="center" valign="center" class="bodytext31"><?php echo $accname; ?></td>
              <input type="hidden" name="wardanum" id="wardanum" value="<?php echo $ward; ?>">
              <input type="hidden" name="bedanum" id="bedanum" value="<?php echo $bed; ?>">
              <input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname; ?>">
              <input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
              <input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">
              <input type="hidden" name="accname" id="accname" value="<?php echo $accname; ?>">
            </tr>
            <?php 
		   } 
		  
		   ?>
            <tr>
              <td colspan="7" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            </tr>
          </tbody>
        </table></td>
		<td>&nbsp;</td>
		</tr>
		
		</table>		</td>
		</tr>
	
      <tr>
        <td>&nbsp;</td>
      </tr>
       
	    <tr>
        <td>&nbsp;</td>
	</tr>
	  <tr>
        <td>&nbsp;</td>
		 <td width="3%">&nbsp;</td>
		  <td width="6%" align="center" valign="center" class="bodytext311"><strong></strong></td>
		<td width="23%" align="right" valign="bottom" class="bodytext311">
		<table width="1000" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      
                      <?php
		
	    $query14 = "select * from ipmedicine_issue where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus = '' order by auto_number desc ";
		$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res14 = mysqli_fetch_array($exec14))
		{
		$i = 1;
		
		$nexttime = 'incomplete';
		$itemcode = $res14['itemcode'];
		$itemname = $res14['itemname'];
		$frequency = $res14['frequency'];
		$date = $res14['date'];
		$docnumber = $res14['docno'];
		
		if($frequency=='OD')
	{
		$frequencyvalue=1;
	}else if($frequency=='BD')
	{
		$frequencyvalue=2;
	}else if($frequency=='TID')
	{
		$frequencyvalue=3;
	}else if($frequency=='QID')
	{
		$frequencyvalue=4;
	}else if($frequency=='NOCTE')
	{
		$frequencyvalue=5;
	}
	$timegap = 24/$frequencyvalue;
	
		$dose = $res14['dose'];
		$starttime = $res14['starttime'];
		$session = $res14['session'];
		if($session == 'pm')
		{
		$starttimestr1 = strtotime($starttime);
		$starttime = $starttimestr1 + (12*60*60);
		$starttime = date("H:i:s", $starttime);
		}
		$days = $res14['days'];
		$instructions = $res14['instructions'];
		$totalcount = $days * $frequencyvalue;
		
		$colorloopcount = $colorloopcount + 1;
		$showcolor = ($colorloopcount & 1); 
		if ($showcolor == 0)
		{
			$colorcode = 'bgcolor="#CBDBFA"';
		}
		else
		{
			$colorcode = 'bgcolor="#ecf0f5"';
		}
		?>
        <tr <?php echo $colorcode; ?>>
		<td align="left" valign="bottom"  class="bodytext3">
		<table width="400" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
     <tr>
                        <td width="30%" align="left" valign="middle"  class="bodytext3">
						
                          <div align="center" class="bodytext3"><?php echo $itemname; ?>(Dsg <?php echo $dose; ?>,<?php echo $frequency; ?>,Days <?php echo $days; ?>,<?php echo $instructions; ?>,<?php echo $date; ?>)</div>
                        </td>
						</tr>
						</tbody>
						</table>
						</td>
						<?php
						$query11 = "select * from ip_drugadmin where patientcode='$patientcode' and visitcode='$visitcode' and serialnumber='$i' and itemcode='$itemcode' and medicineissuedocno='$docnumber'";
						$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$num11 = mysqli_num_rows($exec11);
						$res11 = mysqli_fetch_array($exec11);
						$status = $res11['drugstatus'];
						?>
						 <td align="center" valign="middle" <?php if($status == ''){ ?>bgcolor="#ecf0f5"<?php } ?><?php if($status == 'complete'){ ?> bgcolor="#33FF99" <?php } ?><?php if($status == 'incomplete'){ ?> bgcolor="#FF0066" <?php } ?>class="bodytext3" <?php if($status == ''){ ?>onClick="return funcdrugadmin('<?php echo $patientcode; ?>','<?php echo $visitcode; ?>','<?php echo $itemcode; ?>','<?php echo $i; ?>','<?php echo $docnumber; ?>')"<?php } ?> style="border:2px solid grey;"><strong><?php echo $starttime; ?></strong></td>
						<?php 
						while($i < $totalcount)
						{
						$i++;
						$starttimestr2 = strtotime($starttime);
						$nexttime1 = $starttimestr2 + ($timegap*60*60);
						$nexttime2 = date("H:i:s", $nexttime1);
										
						$query111 = "select * from ip_drugadmin where patientcode='$patientcode' and visitcode='$visitcode' and serialnumber='$i' and itemcode='$itemcode' and medicineissuedocno='$docnumber'";
						$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$num111 = mysqli_num_rows($exec111);
						$res111 = mysqli_fetch_array($exec111);
						$status = $res111['drugstatus'];	
							
						?>
                        <td align="center" valign="middle" <?php if($status == ''){ ?>bgcolor="#ecf0f5"<?php } ?><?php if($status == 'complete'){ ?> bgcolor="33FF99" <?php } ?><?php if($status == 'incomplete'){ ?> bgcolor="FF0066" <?php } ?>class="bodytext3" <?php if($status == ''){ ?>onClick="return funcdrugadmin('<?php echo $patientcode; ?>','<?php echo $visitcode; ?>','<?php echo $itemcode; ?>','<?php echo $i; ?>','<?php echo $docnumber; ?>')"<?php } ?> style="border:2px solid grey;"><strong><?php echo $nexttime2; ?></strong></td>
						<?php
						$starttime = $nexttime2;
						$num111 = '';
						}
						?>
                        </tr>
                      <?php
		}
		?>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
		</td>
		<td width="29%" align="left" valign="center" class="bodytext311"></td>
      </tr>
	  <tr>
        <td>&nbsp;</td>
		 <td>&nbsp;</td>
		  <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td width="37%" align="center" valign="center" class="bodytext311">         </td>
                 
      </tr>
    </table>
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

