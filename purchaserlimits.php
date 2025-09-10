<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$upqrystatus=1;
if(isset($_REQUEST['submitform']))
{
$count= $_REQUEST['count'];
foreach($_REQUEST['limitamount'] as $key => $value)
{
 $qryupdt=mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `master_purchaselimit` SET `limit_amount`='".$_REQUEST['limitamount'][$key]."', from_date = '".$_REQUEST['fromdate'][$key]."', to_date = '".$_REQUEST['todate'][$key]."', username = '".$username."' WHERE `auto_number` = '$key'");
}

header('Location:menupage1.php?mainmenuid=MM001');

}
?>
<!--<script src="jquery/jquery-1.11.3.min.js" type="text/javascript"></script>
--><script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
</style>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">
$(function(){
//alert();
$('.numberonly').focusin(function(){
//alert();
$(this).select();
});
$('.numberonly').keyup(function(){
$(this).val($(this).val().replace(/[^\d.]/g,''));
});
$('.numberonly').blur(function(){
$(this).val(parseFloat($(this).val()).toFixed(2));
});
});
</script>
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
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="85%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td bgcolor="#ecf0f5">
			  Purchase Approval Limit
                </td>
            </tr>
            <tr>
              <td >&nbsp;</td>
            </tr>
			<tr>
			<td>
			<form action="" method="post" onSubmit="document.getElementById('savebutton').disabled=true;">
 			<table align="center" >
			<tr bgcolor="#011E6A">
			<th width="200" bgcolor="#ecf0f5" class="bodytext3"><strong>Purchase Type</strong></th>
			<th width="200" bgcolor="#ecf0f5" class="bodytext3"><strong>Limit Amount</strong></th>
			<th width="200" bgcolor="#ecf0f5" class="bodytext3"><strong>From Date</strong></th>
            <th width="200" bgcolor="#ecf0f5" class="bodytext3"><strong>To Date</strong></th>
            <th width="200" bgcolor="#ecf0f5" class="bodytext3"><strong>Updated At</strong></th>
			</tr>
			<?php
			$qrypur1 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM master_purchaselimit ORDER BY purchasetype ASC");
			$purchasecount = mysqli_num_rows($qrypur1);
			while($respur1=mysqli_fetch_assoc($qrypur1)){
			$autonumber = $respur1['auto_number'];
			$purchasetype = $respur1['purchasetype'];
			$limitamount = $respur1['limit_amount'];
			$from_date = $respur1['from_date'];
			if($from_date == '0000-00-00') { $from_date = ''; }
			$to_date = $respur1['to_date'];
			if($to_date == '0000-00-00') { $to_date = ''; }
			 ?>
			<tr>
			<td><input style="text-transform:uppercase; background:#ccc; color:#f00" type="text" readonly id="purchasetype<?php echo $autonumber;?>" name="purchasetype[<?php echo $autonumber;?>]" value="<?php echo $purchasetype;?>"></td>
			<td><input class="numberonly" type="text" id="limitamount<?php echo $autonumber;?>" name="limitamount[<?php echo $autonumber;?>]" value="<?php echo $limitamount;?>"></td>
            <td><input type="text" readonly id="fromdate<?php echo $autonumber;?>" name="fromdate[<?php echo $autonumber;?>]" value="<?php echo $from_date;?>" size="10">
            <img src="images2/cal.gif" onClick="javascript:NewCssCal('fromdate<?php echo $autonumber;?>')" style="cursor:pointer"/></td>
            <td><input type="text" readonly id="todate<?php echo $autonumber;?>" name="todate[<?php echo $autonumber;?>]" value="<?php echo $to_date;?>" size="10">
            <img src="images2/cal.gif" onClick="javascript:NewCssCal('todate<?php echo $autonumber;?>')" style="cursor:pointer"/></td>
			<td>
			<?php echo $updated = $respur1['updateat']; ?>
			</td>
			</tr>
			<?php
			}
			?>
			
			<tr>
			<td colspan="3" align="right"><input type="submit" value="save" id="savebutton">
			<input type="hidden" name="submitform" value="submit">
			<input type="hidden" name="count" value="<?php echo $purchasecount; ?>">
			</td>
			</tr>
			</tbody>
			</table>
			</form>
			</td>
			</tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

