<?php
session_start();
//include ("includes/loginverify.php");
include ("db/db_connect.php");

$updatedatetime = date("Y-m-d H:i:s");
$username = $_SESSION["username"];
if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
$sql="SELECT * FROM `master_store` where auto_number='$store'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die ("Error in sql".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$storename=$res1["store"];
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />  
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">


<body >
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
    <tr bgcolor="#011E6A">
		<td bgcolor="#ecf0f5" class="bodytext3" colspan='6'>
		  <strong>"<?php echo $storename;?>" - Last 10 actions</strong>
		</td>
	</tr>

<?php
$query2 = "SELECT * FROM `audit_store_freeze` where store='$store' order by id desc limit 0,10";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$numLab1 = mysqli_num_rows($exec2);
if($numLab1>0){ 
?>

	<tr bgcolor="#011E6A">
		<td width="4%" bgcolor="#ecf0f5" class="bodytext3"><div><strong>Sno</strong></div></td>
		<td width="10%" bgcolor="#ecf0f5" class="bodytext3"><strong>Date</strong></td>
		<td width="14%" bgcolor="#ecf0f5" class="bodytext3"><strong>User</strong></td>
		<td width="24%" bgcolor="#ecf0f5" class="bodytext3"><strong>Action</strong></td>
	  </tr>
	  <?php
	 $colorloopcount = 0;
	 while ($res2 = mysqli_fetch_array($exec2))
	{
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
	<tr <?php echo $colorcode; ?> >
		<td align="left" valign="top"   class="bodytext3"><div align="center">
		<?php echo $colorloopcount; ?> 
		</div></td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $res2['datetime']; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $res2['user']; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php if($res2['freeze_status']==1) echo "Freeze"; else echo "Unfreeze"; ?> </td>

	 </tr>
	 <?php
	}
      ?>


<?php
}
}
?>
	 
 </tbody>
</table>

</body>
