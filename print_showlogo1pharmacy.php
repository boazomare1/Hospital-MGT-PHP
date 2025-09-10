<?php
$query2showlogo = "select * from settings_billpharmacy where companyanum = '$companyanum'";
$exec2showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query2showlogo) or die ("Error in Query2showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2showlogo = mysqli_fetch_array($exec2showlogo);
$showlogo = $res2showlogo['showlogo'];
if ($showlogo == 'SHOW LOGO')
{
?>	
<td width="14%"><img src="logofiles/<?php echo $companyanum;?>.jpg" width="75" height="75" /></td>
<?php
}
?>