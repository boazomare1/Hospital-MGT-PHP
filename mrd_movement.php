<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

$snocount = '';
$colorloopcount = '';

if(isset($_REQUEST['transferto'])){$transfer = $_REQUEST['transferto'];} else {$transfer = '';}

if($transfer == 'transferto'){
	if(isset($_REQUEST['code'])){$patientcode = $_REQUEST['code'];} else {$patientcode = '';}
	if(isset($_COOKIE['empcode'])){$empto = $_COOKIE['empcode'];} else {$empto = '';}
	if(isset($_COOKIE['mrdno'])){$mrdno = $_COOKIE['mrdno'];} else {$mrdno = '';}

	$query10 = "select * from master_customer where customercode = '$patientcode'";
	$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res10 = mysqli_fetch_array($exec10);
	$patientname = $res10['customerfullname'];
	if($mrdno == ''){ $mrdno = $res10['mrdno']; }

	$query46 = "select * from master_employeeinfo where employeecode = '$empto'";
	$exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die ("Error in Query46".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res46 = mysqli_fetch_array($exec46);
	$to_departmentname = $res46['departmentname'];
	$to_departmentunit = $res46['departmentunit'];
	$to_employeename = $res46['employeename'];

	$query47 = "select * FROM master_payrolldepartment where department = '$to_departmentname'";
	$exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die ("Error in Query47".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res47 = mysqli_fetch_array($exec47);
	$to_departmentcode = $res47['auto_number'];

	$query46 = "select * from master_employeeinfo where username = '$username'";
	$exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die ("Error in Query46".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res46 = mysqli_fetch_array($exec46);
	$from_departmentname = $res46['departmentname'];
	$from_departmentunit = $res46['departmentunit'];
	$from_employeename = $res46['employeename'];
	$from_employeecode = $res46['employeecode'];

	$query48 = "select * FROM master_payrolldepartment where department = '$from_departmentname'";
	$exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die ("Error in Query48".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res48 = mysqli_fetch_array($exec48);
	$from_departmentcode = $res48['auto_number'];

	$updatedatetime = date('Y-m-d H:i:s');
	$status = 'transferred';

	$querymrd = "insert into mrdmovement(patientcode, patientname, mrdno, from_code, from_name, from_departmentcode, from_departmentname, from_departmentunit, to_code, to_name, to_departmentcode, to_departmentname, to_departmentunit, username, updatedatetime, status) VALUES ('$patientcode', '$patientname', '$mrdno', '$from_employeecode', '$from_employeename', '$from_departmentcode', '$from_departmentname', '$from_departmentunit', '$empto', '$to_employeename', '$to_departmentcode', '$to_departmentname', '$to_departmentunit', '$username', '$updatedatetime', '$status')";
	$execmrd = mysqli_query($GLOBALS["___mysqli_ston"], $querymrd);

	$reportid=((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);


	unset($_COOKIE['empcode']);
	unset($_COOKIE['mrdno']);
	header("location:mrd_movement.php?printid=".$reportid);
}

if(isset($_REQUEST['receive'])){$receive = $_REQUEST['receive'];} else {$receive = '';}

if($receive == 'receive'){
	if(isset($_REQUEST['code'])){$patientcode = $_REQUEST['code'];} else {$patientcode = '';}
	$updatedatetime = date('Y-m-d H:i:s');
	$status = 'received';

	$querymrd = "update mrdmovement set status='$status', updatedatetime='$updatedatetime' where patientcode='$patientcode'";
	$execmrd = mysqli_query($GLOBALS["___mysqli_ston"], $querymrd);
}

?>
<style type="text/css">

body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}

</style>

<script language="javascript">
function cbsuppliername1()
{
	document.cbform1.submit();
}

<?php
if(isset($_REQUEST['printid'])){
	 $reportid=$_REQUEST['printid'];
?>

window.open("print_mrd_transfer.php?reportid=<?php echo $reportid; ?>","Window1","width=900,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25");

<?php
}

?>

</script>


<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">

<script type="text/javascript">
$(function() {
	$('#patientname1').autocomplete({
	source:"autosearchpatientmrd.php",
	matchContains: true,
	minLength:1,
	delay:0,
	html: true, 
		select: function(event,ui){
			var itemname=ui.item.customername;
			var itemcode=ui.item.customercode;
			$("#patientname1").val(itemname);
			$("#patientname").val(itemname);
			},
	});	
});

$(function() {
	$('#patientcode1').autocomplete({
	source:"autosearchpatientcodemrd.php",
	matchContains: true,
	minLength:1,
	delay:0,
	html: true, 
		select: function(event,ui){
			var itemname=ui.item.customername;
			var itemcode=ui.item.customercode;
			$("#patientcode1").val(itemcode);
			$("#patientcode").val(itemcode);
			},
	});	
});

$(function() {
	$('#transferto').autocomplete({
	source:"autosearchemployees.php",
	matchContains: true,
	minLength:1,
	delay:0,
	html: true, 
		select: function(event,ui){
			var employeename=ui.item.employeename;
			var employeecode=ui.item.employeecode;
			var departmentname=ui.item.departmentname;
			var departmentunit=ui.item.departmentunit;
			document.cookie = "empcode="+employeecode;
			$("#employeename").val(employeename);
			$("#employeecode").val(employeecode);
			$("#departmentname").val(departmentname);
			$("#departmentunit").val(departmentunit);
			},
	});	
});	

$(function() {
	$('#searchmrdno1').autocomplete({
	source:"autosearchmrd.php",
	matchContains: true,
	minLength:1,
	delay:0,
	html: true, 
		select: function(event,ui){
			var employeename=ui.item.employeename;
			var employeecode=ui.item.employeecode;
			var mrdno=ui.item.mrdno;
			$("#searchmrdno1").val(mrdno);
			$("#searchmrdno").val(mrdno);
			},
	});	
});

function transfercheck(){

	if($("#employeecode").val() == ''){
		alert('Transfer to cannot be empty');
		return false;
	}

	var mrdno = document.getElementById('mrdno').value;
	if(mrdno != ''){
		document.cookie = "mrdno="+mrdno;
	}
}

function clearCode(id){
	$("#"+id).val('');
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
.pagination{ float:right; }
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="mrd_movement.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>MRD Movement </strong></td>
              </tr>
          
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patientname1" id="patientname1" value="" type="text" size="50" onkeyup="clearCode('patientname')">
                <input name="patientname" id="patientname" value="" type="hidden" size="50">
              </span></td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Code</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patientcode1" type="text" id="patientcode1" value="" size="50" autocomplete="off" onkeyup="clearCode('patientcode')">
                <input name="patientcode" id="patientcode" value="" type="hidden" size="50">
              </span></td>
              </tr>
			      <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">MRD No</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="searchmrdno1" type="text" id="searchmrdno1" value="" onkeyup="clearCode('searchmrdno')" size="50" autocomplete="off">
                <input name="searchmrdno" type="hidden" id="searchmrdno" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
		
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      </tr>
	  <tr>
        <td>
	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1' || isset($_REQUEST['page']))
{

	if(isset($_POST['patient'])){	$_SESSION['serpatient'] = $_POST['patient'];	}
	if(isset($_POST['patientcode'])){	$_SESSION['serpatientcode'] = $_POST['patientcode'];}
	if(isset($_POST['nationalid'])){ $_SESSION['sernationalid'] = $_POST['nationalid']; }
	
	if(isset($_REQUEST['patientcode'])){ $patientcode = $_REQUEST['patientcode']; } else { $patientcode = ''; };
	if(isset($_REQUEST['patientname'])){ $patientname = $_REQUEST['patientname']; } else { $patientname = ''; };
	if(isset($_REQUEST['searchmrdno'])){ $searchmrdno = $_REQUEST['searchmrdno']; } else { $searchmrdno = ''; };
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" align="left" border="0">
          <tbody>
          	<tr>
          		<td align="center" colspan="7"><strong>OUTGOING</strong></td>
          	</tr>
          	<tr bgcolor="#ecf0f5">
          		<td align="left" valign="middle" class="bodytext3" width="30"><strong>Sno</strong></td>
          		<td align="left" valign="middle" class="bodytext3" width="100"><strong>Patientcode</strong></td>
          		<td align="left" valign="middle" class="bodytext3" width="200"><strong>Patientname</strong></td>
          		<td align="left" valign="middle" class="bodytext3" width="200"><strong>MRD No</strong></td>
          		<td align="left" valign="middle" class="bodytext3" width="200"><strong>Transfer To</strong></td>
          		<!-- <td align="left" valign="middle" class="bodytext3" width="200"><strong>Department</strong></td>
          		<td align="left" valign="middle" class="bodytext3" width="200"><strong>Department Unit</strong></td> -->
          		<td align="left" valign="middle" class="bodytext3" width="150"><strong>Action</strong></td>
          	</tr>
          	<?php 
          		if($searchmrdno == ''){
          			$query1 = "select * from master_customer where customerfullname = '$patientname' OR customercode = '$patientcode'";
          		} else {
          			$query1 = "select customerfullname, customercode, mrdno from master_customer where mrdno = '$searchmrdno' UNION ALL select patientname as customerfullname, patientcode as customercode, mrdno from mrdmovement where mrdno = '$searchmrdno'";
          		}
          		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
          		while($res1 = mysqli_fetch_array($exec1)){
          			$patientname = $res1['customerfullname'];
          			$patientcode = $res1['customercode'];
          			$mrdno = $res1['mrdno'];

          			$query45 = "select * from mrdmovement where patientcode = '$patientcode' ORDER BY auto_number DESC LIMIT 1";
					$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die ("Error in Query45".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res45 = mysqli_fetch_array($exec45);
					$status = $res45['status'];
					if($mrdno == ''){$mrdno = $res45['mrdno'];}

					if($status != 'transferred'){

          			$query45 = "select * from master_employeeinfo where username = '$username'";
					$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die ("Error in Query45".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res45 = mysqli_fetch_array($exec45);

					$department = $res45['departmentname'];
					$departmentunit = $res45['departmentunit'];

          			$snocount = $snocount + 1;
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
	          		<td align="left" valign="middle" class="bodytext3" ><?php echo $snocount; ?></td>
	          		<td align="left" valign="middle" class="bodytext3" ><?php echo $patientcode; ?></td>
	          		<td align="left" valign="middle" class="bodytext3" ><?php echo $patientname; ?></td>
	          		<td align="left" valign="middle" class="bodytext3" ><?php if($mrdno != ''){ echo $mrdno; ?><input type="hidden" name="mrdno" id="mrdno" value="<?php echo $mrdno; ?>"><?php } else {?><input type="text" name="mrdno" id="mrdno"><?php } ?></td>
	          		<td align="left" valign="middle" class="bodytext3" ><input type="text" name="transferto<?php echo $snocount; ?>" id="transferto"></td>
	          		<input type="hidden" name="departmentname<?php echo $snocount; ?>" id="departmentname">
	          		<input type="hidden" name="employeecode" id="employeecode">
	          		<input type="hidden" name="departmentunit<?php echo $snocount; ?>" id="departmentunit">
	          		<td align="left" valign="middle" class="bodytext3"><a href="?code=<?php echo $patientcode; ?>&transferto=transferto" onclick="return transfercheck();">TRANSFER</a></td>
	          	</tr>
          		<?php } } ?>

          	<tr><td><br></td></tr>
          	<tr><td><br></td></tr>
      		<tr>
          		<td align="center" colspan="7"><strong>INCOMING</strong></td>
          	</tr>
          	<tr bgcolor="#ecf0f5">
          		<td align="center" valign="middle" class="bodytext3" width="30"><strong>Sno</strong></td>
          		<td align="left" valign="middle" class="bodytext3" width="100"><strong>Patientcode</strong></td>
          		<td align="left" valign="middle" class="bodytext3" width="200"><strong>Patientname</strong></td>
          		<td align="left" valign="middle" class="bodytext3" width="200"><strong>MRD No</strong></td>
          		<td align="left" valign="middle" class="bodytext3" width="100"><strong>Given To</strong></td>
          		<td align="left" valign="middle" class="bodytext3" width="200"><strong>Department</strong></td>
          		<td align="left" valign="middle" class="bodytext3" width="200"><strong>Transfer Date</strong></td>
          		<td align="left" valign="middle" class="bodytext3" width="100"><strong>Days Taken</strong></td>
          		<!-- <td align="left" valign="middle" class="bodytext3" width="200"><strong>Department Unit</strong></td> -->
          		<td align="left" valign="middle" class="bodytext3" width="150"><strong>Action</strong></td>
          	</tr>
          	<?php 

          		if($patientcode != '' || $patientname != '' || $searchmrdno != ''){
          			$query45 = "select * from mrdmovement where patientcode = '$patientcode' OR patientname = '$patientname' OR mrdno = '$searchmrdno' ORDER BY auto_number DESC LIMIT 1";
          		} else {
          			$query45 = "select * from mrdmovement where status = 'transferred' ORDER BY patientcode DESC";
          		}
				$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die ("Error in Query45".mysqli_error($GLOBALS["___mysqli_ston"]));
          		while($res45 = mysqli_fetch_array($exec45)){

          			$patientcode = $res45['patientcode'];
          			$patientname = $res45['patientname'];
					$status = $res45['status'];
					$mrdno = $res45['mrdno'];
					$from_departmentname = $res45['to_departmentname'];
					$from_departmentunit = $res45['to_departmentunit'];
					$from_name = $res45['to_name'];
					$transfer_date = $res45['updatedatetime'];

					$current_date = date('Y-m-d');
					$days = intval(abs(strtotime($current_date) - strtotime(date($transfer_date)))/86400);
					if($status == 'transferred'){

          			$snocount = $snocount + 1;
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
	          		<td align="center" valign="middle" class="bodytext3" ><?php echo $snocount; ?></td>
	          		<td align="left" valign="middle" class="bodytext3" ><?php echo $patientcode; ?></td>
	          		<td align="left" valign="middle" class="bodytext3" ><?php echo $patientname; ?></td>
	          		<td align="left" valign="middle" class="bodytext3" ><?php echo $mrdno; ?></td>
	          		<td align="left" valign="middle" class="bodytext3" ><?php echo $from_name; ?></td>
	          		<!-- <td align="left" valign="middle" class="bodytext3" ><?php echo $from_departmentname; ?></td> -->
	          		<td align="left" valign="middle" class="bodytext3" ><?php echo $from_departmentunit; ?></td>
	          		<td align="left" valign="middle" class="bodytext3" ><?php echo $transfer_date; ?></td>
	          		<td align="left" valign="middle" class="bodytext3" ><?php echo $days; ?></td>
	          		<td align="left" valign="middle" class="bodytext3" ><a href="?code=<?php echo $patientcode; ?>&receive=receive">RECEIVE</a></td>
	          	</tr>
          		<?php } } ?>
          </tbody>
        </table>
<?php
}
?>	
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

