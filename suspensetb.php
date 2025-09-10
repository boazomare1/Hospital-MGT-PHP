<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
set_time_limit(0);
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d'); 
$username = $_SESSION['username'];
$GLOBALS['eal'] = 0;
$GLOBALS['ieledgers'] = 0;
$GLOBALS['revenue'] = 0;

//echo $amount;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
//$frmflag2 = $_POST['frmflag2'];


?>

<script type="text/javascript">

function FuncPopup()
{
	window.scrollTo(0,0);
	document.getElementById("imgloader").style.display = "";
}
</script>
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
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />   
<link rel="stylesheet" type="text/css" href="css/simple-grid.min.css" />   
<link rel="stylesheet" href="css/jquery-simple-tree-table.css">


<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext44 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none; font-weight:bold
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
/* collpase table*/

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
</table>	

<form name="cbform1" method="post" action="">
	<div class="container-full">
		<div class="row">
			<div class="col-8">
				<table width="100%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse;">
					<tbody>
				    <tr bgcolor="#011E6A">
				      <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Suspense Balance</strong></td>
				      </tr>
					<tr>
						<td width="15%"  align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31"> Location </td>
						<td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF">
						<select name="location" id="location" >
						<option value="">All</option>
						<?php
						
						$query = "select * from master_employeelocation where username='$username' group by locationcode order by locationname";
						$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res = mysqli_fetch_array($exec))
						{
						$reslocation = $res["locationname"];
						$reslocationanum = $res["locationcode"];
						?>
						<option value="<?php echo $reslocationanum; ?>" <?php if($location!='')if($location==$reslocationanum){echo "selected";}?>><?php echo $reslocation; ?></option>
						<?php 
						}
						?>
						</select>
						</td>
					</tr>
				    <tr>
						<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
						<td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
						<input  style="border: 1px solid #001E6A" type="submit" value="Submit" name="Submit" />
						<input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>
				    </tr>
				  </tbody>
				</table>
			</div>
			<div class="col-4">
				
			</div>
	     </div>
	 </div>

	<?php
	 if(isset($_REQUEST["cbfrmflag1"])){
		 
		 if($location==''){
			$locationwise="and locationcode like '%%'";
		 } else{
		 $locationwise="and locationcode = '$location'";
		 }
		
	?>

  <?php
	
	$sql="SELECT doc_number,remarks, ledger_id, transaction_date,transaction_amount FROM `tb` where (ledger_id is null or ledger_id='') and transaction_amount!=0 $locationwise";
	$exec_error = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die ("Error in sql".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num21 = mysqli_num_rows($exec_error);
	if($num21>0){
        ?>
       <div class="row">
		<div class="col-12">
			<table border='0' align="" style='width: 50%; font-size: initial;border:0px;' cellpadding='4' cellspacing='0' border="0">
				<tr>
					<td>Empty Ledgers</td>
				</tr>
		<?php
		while($res = mysqli_fetch_array($exec_error))
		{ ?>
		<tr style='font-weight:bold;background: #fff;'> 
					<td align='left'>Doc No: <?php echo $res['doc_number'];?></td> 
					<td align='left'>Remarks: <?php echo $res['remarks'];?> </td> 
					<td align='left'>Amount: <?php echo $res['transaction_amount'];?> </td>
	    </tr>
		<?php	
		} ?>
        </div>
        </div>
		<?php
	}
	?>
	
    <?php
	$sql="SELECT doc_number,sum(IF(transaction_type='C',-1*transaction_amount,transaction_amount)) as amount, ledger_id, transaction_date FROM `tb` WHERE transaction_date >= '2021-01-01' $locationwise group by doc_number HAVING amount!=0 and (amount>1 or amount<-1) ";
	$exec_error = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die ("Error in sql".mysqli_error($GLOBALS["___mysqli_ston"]));

	$num21 = mysqli_num_rows($exec_error);
	if($num21>0){
        ?>
        <div class="row">
		<div class="col-12">
			<table border='0' align="" style='width: 50%; font-size: initial;border:0px;' cellpadding='4' cellspacing='0' border="0">
				<tr>
					<td>Mismatch Bills</td>
				</tr>
		<?php
		while($res = mysqli_fetch_array($exec_error))
		{ ?>
		<tr style='font-weight:bold;background: #fff;'> 
					<td  align='left'>Doc No: <?php echo $res['doc_number'];?></td> 
					<td align='left'> </td> 
					<td   align='left'>Amount <?php echo $res['amount'];?> </td> 
	    </tr>
		<?php	
		} ?>
        </div>
        </div>
		<?php
	}

	} // end form
	?>
</div>
</form>


<?php include ("includes/footer1.php"); ?>


</body>
</html>
