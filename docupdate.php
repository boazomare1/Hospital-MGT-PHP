<?php 
include ("db/db_connect.php");
$sno=1;
$query19="SELECT * FROM `materialreceiptnote_details` where billnumber in(SELECT mrnno FROM `purchase_details` WHERE `billnumber` LIKE '%GRN%' AND `supplierbillnumber` = ' ') and grnstatus='completed'";
$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$row19 = mysqli_num_rows($exec19);
while($res19 = mysqli_fetch_array($exec19))
{
  
 $billnumber=$res19["billnumber"];
	 $itemname=$res19["itemname"];
	
    $query20="SELECT * FROM `purchase_details` where mrnno='$billnumber' and itemname='$itemname' and `supplierbillnumber` = ''";
    $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
    $row20 = mysqli_num_rows($exec20);
    if($row20>0)
    {
     echo $sno++;
	echo $billnumber=$res19["billnumber"];
	echo   $itemname=$res19["itemname"];
	echo '<br/>'; 
	
	 $query77 = "update materialreceiptnote_details set grnstatus=' ' where billnumber='$billnumber' and itemname='$itemname' ";
		$exec77= mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
	
    }
}


?>