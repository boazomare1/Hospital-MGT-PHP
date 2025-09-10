
<?php
include ("../db/db_connect.php");

 $accname=isset($_REQUEST['accname'])?$_REQUEST['accname']:'';?>
<option value="">-Select Plan Name-</option>
<?php $query10 = "select auto_number,planname from master_planname where accountname = '$accname' and planexpirydate > NOW() and planstartdate <= NOW() and recordstatus <> 'deleted' order by planname";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{
		//$loopcount = $loopcount+1;
		$res10plannameanum = $res10["auto_number"];
		$res10planname=$res10["planname"];
        ?>
        <option value="<?php echo $res10plannameanum;?>"><?php echo $res10planname;?></option>
<?php }?>