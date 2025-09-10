<?php 
include ("../db/db_connect.php");
$timsec = date('s');
$json = array('status'=>0,'msg'=>"Update Failed");
$visitcode      =    $_POST['visitcode'];
$admdate      =    $_POST['admdate'];


$disdate      =    $_POST['disdate'];

if($admdate<>''){
$ad_dt=explode(" ",$admdate);
$addate=date('Y-m-d', strtotime($ad_dt[0]));
$adtime=$ad_dt[1].':'.$timsec;


$item_update_qry = "UPDATE `ip_bedallocation` SET `recordtime` = '".$adtime."',recorddate= '".$addate."' WHERE visitcode = '".$visitcode."'";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $item_update_qry) or die ("Error in Update Query 2".mysqli_error($GLOBALS["___mysqli_ston"]));

$json = array('status'=>1,'msg'=>"Admission Date Updated Successfully");

} else if($disdate<>''){
$dis_dt=explode(" ",$disdate);
$discdate=date('Y-m-d', strtotime($dis_dt[0]));
$disctime=$dis_dt[1].':'.$timsec;
$dischargedatetime=$discdate.''.$disctime;

$query791 = "update ip_discharge set recordtime='$disctime',recorddate='$discdate'  where req_status='discharge' and visitcode='$visitcode'";
$exec791 = mysqli_query($GLOBALS["___mysqli_ston"], $query791) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$query88 = "update ip_bedallocation set leavingdate='$discdate' where visitcode='$visitcode'  and recordstatus='discharged'";
$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die(mysql_query());

$query881 = "update ip_bedtransfer set leavingdate='$discdate' where  visitcode='$visitcode' and recordstatus='discharged'";
$exec881 = mysqli_query($GLOBALS["___mysqli_ston"], $query881) or die(mysql_query());

$json = array('status'=>1,'msg'=>"Discharge Date Updated Successfully");
} else{
$json = array('status'=>0,'msg'=>"Update Failed, Please Select DateTime");	
}

echo json_encode($json);

?>