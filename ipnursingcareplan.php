<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('Y-m-d H:i:s');

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
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
while ($res1 = mysql_fetch_array($exec1))
{
	$locationname = $res1["locationname"];

}




if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if(isset($_REQUEST["frompage"])){$frompage = $_REQUEST["frompage"]; }else{$frompage ='';}
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1'){
	$patientname = $_REQUEST['patientname'];
	$patientcode = $_REQUEST['patientcode'];
	$visitcode = $_REQUEST['visitcode'];
	$age = $_REQUEST['age'];
	$gender = $_REQUEST['gender'];
	$locationname = $_REQUEST['locationname'];
	$locationcode = $_REQUEST['locationcode'];
	$ward = $_REQUEST['ward'];
	$bed = $_REQUEST['bed'];
	$diagnosis = $_REQUEST['diagnosis'];
	$username;
	$recorddatetime = $updatetime;

	foreach ($_POST['sno'] as $row=>$db) { 
		$sno = $_POST['sno'][$row];
		$ndiagnosis = $_POST['ndiagnosis'][$row];
		$outcome = $_POST['outcome'][$row];
		$planning = $_POST['planning'][$row];
		$intervention = $_POST['intervention'][$row];
		$rationale = $_POST['rationale'][$row];
		$evaluation = $_POST['evaluation'][$row];

		$query30 = "insert into ip_nursingcareplan(patientname, patientcode, visitcode, age, gender, locationname, locationcode, ward, bed, diagnosis, nursingdiagnosis, outcome, planning, intervention, rationale, evaluation, username, recorddatetime) values ('$patientname', '$patientcode', '$visitcode', '$age', '$gender', '$locationname', '$locationcode', '$ward', '$bed', '$diagnosis', '$ndiagnosis', '$outcome', '$planning', '$intervention', '$rationale', '$evaluation', '$username', '$recorddatetime');";
		$exec30 = mysql_query($query30) or die("Error in Query30".mysql_error());
	}			

	header("location:inpatientactivity.php");
	exit;	
}

$query10 = "select * from master_customer where customercode = '$patientcode'";
$exec10 = mysql_query($query10) or die("Error in Query10".mysql_error());
$res10 = mysql_fetch_array($exec10);
$patientname = $res10['customerfullname'];
$patientage = $res10['age'];
$patientgender = $res10['gender'];
$dob = $res10['dateofbirth'];

$query19=mysql_query("select * from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode' ");
$exec19=mysql_fetch_array($query19) ;
$res19ward=$exec19['ward'];
$res19bed=$exec19['bed'];

$query30=mysql_query("select * from master_ward where auto_number='$res19ward' ");
$exec30=mysql_fetch_array($query30);
$res30ward=$exec30['ward'];
//$res30location = $exec30["locationname"];

$query31 = mysql_query("select * from master_bed where auto_number='$res19bed' ");
$exec31=mysql_fetch_array($query31) ;
$res31bed=$exec31['bed'];

$query32 = mysql_query("select * from consultation_ipadmission where patientcode='$patientcode' ");
$exec32=mysql_fetch_array($query32) ;
$res32docname = $exec32['username'];
$id = @explode('.', $res32docname);
$doctor = @$id[0].' '.@$id[1];

$query33 = mysql_query("select * from consultation_icd where patientcode='$patientcode'");
$exec33 = mysql_fetch_array($query33);
$res33 = $exec33['primarydiag'];
if($res33 != ''){
    $diagnosis = $res33;
} else {
    $diagnosis = '';
}
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>



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
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>
</head>

<script src="js/datetimepicker_css.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
	function add() {
    var num = document.getElementById("AutoNumber2").rows.length;
    console.log(num);
    var x = document.createElement("tr");

    var a = document.createElement("td");
     anode = document.createElement("input");
    var b = document.createAttribute("type");
    b.value = "number";
    anode.setAttributeNode(b);
    anode.setAttribute('value', num);    
    anode.setAttribute('name', 'sno[]');    
    anode.setAttribute('readonly', 'true');    
    a.appendChild(anode);
    x.appendChild(a);

    a = document.createElement("td");
    anode = document.createElement("input");
    var b = document.createAttribute("type");
    b.value = "text";
    anode.setAttributeNode(b);
    anode.setAttribute('name','ndiagnosis[]');
    anode.setAttribute('onkeyup','this.value = this.value.toUpperCase();');
    a.appendChild(anode);
    x.appendChild(a);
  
     a = document.createElement("td");
    anode = document.createElement("input");
    var b = document.createAttribute("type");
    b.value = "text";
    anode.setAttributeNode(b);
    anode.setAttribute('name','outcome[]');
    anode.setAttribute('onkeyup','this.value = this.value.toUpperCase();');
    a.appendChild(anode);
    x.appendChild(a);
    
     a = document.createElement("td");
    anode = document.createElement("input");
    var b = document.createAttribute("type");
    b.value = "text";
    anode.setAttributeNode(b);
    anode.setAttribute('name','planning[]');
    anode.setAttribute('onkeyup','this.value = this.value.toUpperCase();');
    a.appendChild(anode);
    x.appendChild(a);

     a = document.createElement("td");
    anode = document.createElement("input");
    var b = document.createAttribute("type");
    b.value = "text";
    anode.setAttributeNode(b);
    anode.setAttribute('name','intervention[]');
    anode.setAttribute('onkeyup','this.value = this.value.toUpperCase();');
    a.appendChild(anode);
    x.appendChild(a);

     a = document.createElement("td");
    anode = document.createElement("input");
    var b = document.createAttribute("type");
    b.value = "text";
    anode.setAttributeNode(b);
    anode.setAttribute('name','rationale[]');
    anode.setAttribute('onkeyup','this.value = this.value.toUpperCase();');
    a.appendChild(anode);
    x.appendChild(a);

     a = document.createElement("td");
    anode = document.createElement("input");
    var b = document.createAttribute("type");
    b.value = "text";
    anode.setAttributeNode(b);
    anode.setAttribute('name','evaluation[]');
    anode.setAttribute('onkeyup','this.value = this.value.toUpperCase();');
    a.appendChild(anode);
    x.appendChild(a);

    a = document.createElement("td");
    anode = document.createElement('input');
    anode.setAttribute('type','button');
    anode.setAttribute('value','Delete');
    anode.setAttribute('onclick','deleteRow(this)');
    a.appendChild(anode);
    x.appendChild(a);
    document.getElementById("AutoNumber2").appendChild(x);
}

	function deleteRow(e,v) {
	  var tr = e.parentElement.parentElement;
	  var tbl = e.parentElement.parentElement.parentElement;
	  tbl.removeChild(tr);

	}
</script>
<body>
	<form name="form1" id="form1" method="post" action="ipnursingcareplan.php">	
		<table width="101%" border="0" cellspacing="0" cellpadding="2">
			<tr>
				<td colspan="15" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
			</tr>
			<tr>
				<td colspan="15" bgcolor="#ECF0F5"><?php include ("includes/title1.php"); ?></td>
			</tr>
			<tr>
				<td colspan="15" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
			</tr>
			<tr>
				<td colspan="15">&nbsp;</td>
			</tr>
			<tr>
				<td width="0%">&nbsp;</td>
			</tr>

			<tr>
				<td width="1%">&nbsp;</td>
				<td width="99%" valign="top"><table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="1286"><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
							<tbody>
								<tr bgcolor="#011E6A">
									<td colspan="11" bgcolor="#ecf0f5" class="bodytext32"><strong>NURSING CARE PLAN</strong></td>
								</tr>
								<tr>
									<td colspan="15" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
								</tr>
								<tr>
									<td colspan="11" class="bodytext32"><strong>&nbsp;</strong></td>
								</tr>

								<tr>
									<td width="11%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32"> <strong>Patient Name</strong></span></td>
									<td width="26%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
									<input name="patientname" id="patientname" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden"><?php echo $patientname; ?>
									<td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Patientcode</strong></td>
									<td width="17%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden"><?php echo $patientcode; ?><a target="_blank" href="addiptriage.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $billnumber; ?>"></a></td>
									<td width="7%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Visitcode</strong></td>
									<td width="15%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" /><?php echo $visitcode; ?></td>
								</tr>       

								<tr>
									<td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Age</strong></td>
									<td align="left" valign="middle" class="bodytext3">
										<?php echo $patientage; ?></td>
										<input type="hidden" name="age" id="age" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;" size="45">
									<td align="left" valign="middle" class="bodytext3"><span class="style1">Gender</span></td>
									<td align="left" valign="middle" class="bodytext3"><?php echo $patientgender; ?></td>
									<input type="hidden" name="gender" id="gender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;" size="45"></td>

									<td align="left" valign="middle" class="bodytext3"><strong>DOB</strong></td>
									<td align="left" valign="middle" class="bodytext3"><?php echo $dob; ?></td>
									<input type="hidden" name="dob" id="dob" value="<?php echo $dob; ?>" style="border: 1px solid #001E6A;" size="45"></td>
								</tr>

								<tr>
									<td align="left" valign="middle" class="bodytext3"><strong>Ward/Bed</strong></td>
									<td class="bodytext3"><?php echo $res30ward; ?>/<?php echo $res31bed; ?></td>
									<input type="hidden" name="ward" id="ward" value="<?php echo $res30ward; ?>" style="border: 1px solid #001E6A;" size="45">
									<input type="hidden" name="bed" id="bed" value="<?php echo $res31bed; ?>" style="border: 1px solid #001E6A;" size="45">	

									<td align="left" valign="middle" class="bodytext3"><strong>Admitting Doctor</strong></td>
									<td align="left" valign="middle" class="bodytext3"><?php echo $doctor; ?></td>
									<input type="hidden" name="doctor" id="doctor" value="<?php echo $doctor; ?>" style="border: 1px solid #001E6A;" size="45"></td>

									<td align="left" valign="middle" class="bodytext3"><strong>Location</strong></td>
									<td align="left" valign="middle" class="bodytext3"><?php echo $locationname; ?></td>
									<input type="hidden" name="locationname" id="locationnname" value="<?php echo $locationname; ?>" style="border: 1px solid #001E6A;" size="45"></td>
									<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode; ?>" style="border: 1px solid #001E6A;" size="45"></td>
								</tr>
								<tr>
									<td align="left" valign="middle" class="bodytext3"><strong>Clinical Diagnosis</strong></td>
									<td class="bodytext3"><?php echo strtoupper($diagnosis); ?><input type="hidden" name="diagnosis" id="diagnosis" value="<?php echo $diagnosis; ?>" style="border: 1px solid #001E6A;" size="45"></td>
									<
								</tr>
								<tr>
									<td colspan="1" align="left" valign="center" class="bodytext31">&nbsp;</td>
									<td colspan="1" valign="top">&nbsp;<table align="right">
								</tr>
								<tr><td><br><br><br></td></tr>
							</tbody>
						</table></td>
					</tr>
				</table></td>
			</tr>
		
			<tr>
				<td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber2" style="border-collapse: collapse">
					<tbody>
						<tr bgcolor="#FFFFFF">
							<th width="4%" align="center" valign="middle" class="bodytext3"><strong>No.</strong></th>
							<th width="16%" align="center" valign="middle" class="bodytext3"><strong>Nursing Diagnosis</strong></th>
							<th width="16%" align="center" valign="middle" class="bodytext3"><strong>Outcome Criteria</strong></th>
							<th width="16%" align="center" valign="middle" class="bodytext3"><strong>Planning</strong></th>
							<th width="16%" align="center" valign="middle" class="bodytext3"><strong>Intervention</strong></th>
							<th width="16%" align="center" valign="middle" class="bodytext3"><strong>Rationale</strong></th>
							<th width="16%" align="center" valign="middle" class="bodytext3"><strong>Evaluation</strong></th>
							<th align="center" valign="middle" class="bodytext3">
								<input type="button" name="Add" value="Add" onclick="add()" style="border: 1px solid #001E6A">
							</th>
						</tr>
						<tr>
							<td align="left" valign="middle" class="bodytext3">
								<input type="number" name="sno[]" value="1" readonly="true">
							</td>
							<td align="left" valign="middle" class="bodytext3" style="white-space: nowrap;">
								<input type='text' name="ndiagnosis[]" onkeyup="this.value = this.value.toUpperCase();"/>
							</td>
							<td align="left" valign="middle" class="bodytext3" style="white-space: nowrap;">
								<input type='text' name="outcome[]" onkeyup="this.value = this.value.toUpperCase();"/>
							</td>
							<td align="center" valign="middle" class="bodytext3">
								<input type='text' name="planning[]" onkeyup="this.value = this.value.toUpperCase();"/>
							</td>
							<td align="center" valign="middle" class="bodytext3">
								<input type='text' name="intervention[]" onkeyup="this.value = this.value.toUpperCase();"/>
							</td>
							<td align="center" valign="middle" class="bodytext3">
								<input type='text' name="rationale[]" onkeyup="this.value = this.value.toUpperCase();"/>
							</td>
							<td align="center" valign="middle" class="bodytext3">
								<input type='text' name="evaluation[]" onkeyup="this.value = this.value.toUpperCase();"/>
							</td>
							<td align="center" valign="middle" class="bodytext3">
								<input type="button" name="Delete" id="Delete" value="Delete" onclick="deleteRow(th)" style="border: 1px solid #001E6A">
							</td>
						</tr>
					</tbody>
				</table></td>
				<tr><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
					<tr><td><br></td></tr>
					<tr>
						<td colspan="3" width="30">&nbsp;</td>
						<td align="left" valign="middle" class="bodytext3"><input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
						<input name="submit" type="submit" value="Save" accesskey="b" class="button" style="border: 1px solid #001E6A"/></td>
					</tr>
				</table></tr>
			</tr>
		</table>
</form>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

