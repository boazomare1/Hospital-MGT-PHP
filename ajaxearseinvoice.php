<?php
session_start();
if (!isset($_SESSION["username"])) header("location:index.php");
include "db/db_connect.php";
$updatedate = date('Y-m-d');
$ipaddress = $_SERVER['REMOTE_ADDR'];
$username = $_SESSION['username'];
$docsession = $_SESSION['docno'];
$billnumber = $_REQUEST["billnumber"]; 
$visitcode = $_REQUEST["visitcode"]; 
$fromtype = $_REQUEST["fromtype"]; 
if($fromtype=='billing_ip' || $fromtype=='billing_ipcreditapproved' ){
$billtb=mysqli_query($GLOBALS["___mysqli_ston"], "delete from tb where doc_number='$billnumber'");
$biiip=mysqli_query($GLOBALS["___mysqli_ston"], "delete from billing_ip where billno='$billnumber' and visitcode='$visitcode'");
$paymentmode=mysqli_query($GLOBALS["___mysqli_ston"], "delete from paymentmodedebit where billnumber='$billnumber' and patientvisitcode='$visitcode'");
$biiipbed=mysqli_query($GLOBALS["___mysqli_ston"], "delete from billing_ipbedcharges where docno='$billnumber' and visitcode='$visitcode'");
$biiipphar=mysqli_query($GLOBALS["___mysqli_ston"], "delete from billing_ippharmacy where billnumber='$billnumber' and patientvisitcode='$visitcode'");
$biiiplab=mysqli_query($GLOBALS["___mysqli_ston"], "delete from billing_iplab where billnumber='$billnumber' and patientvisitcode='$visitcode'");
$biiiprad=mysqli_query($GLOBALS["___mysqli_ston"], "delete from billing_ipradiology where billnumber='$billnumber' and patientvisitcode='$visitcode'");
$biiipser=mysqli_query($GLOBALS["___mysqli_ston"], "delete from billing_ipservices where billnumber='$billnumber' and patientvisitcode='$visitcode'");
$biiipdoct=mysqli_query($GLOBALS["___mysqli_ston"], "delete from billing_ipprivatedoctor where docno='$billnumber' and visitcode='$visitcode'");
$biiipamb=mysqli_query($GLOBALS["___mysqli_ston"], "delete from billing_ipambulance where docno='$billnumber' and visitcode='$visitcode'");
$biiipnhif=mysqli_query($GLOBALS["___mysqli_ston"], "delete from billing_ipnhif where docno='$billnumber' and visitcode='$visitcode'");
$biiipotc=mysqli_query($GLOBALS["___mysqli_ston"], "delete from billing_ipotbilling where docno='$billnumber' and visitcode='$visitcode'");
$biiipmisc=mysqli_query($GLOBALS["___mysqli_ston"], "delete from billing_ipmiscbilling where docno='$billnumber' and visitcode='$visitcode'");
$biiipadmi=mysqli_query($GLOBALS["___mysqli_ston"], "delete from billing_ipadmissioncharge where docno='$billnumber' and visitcode='$visitcode'");
$biiiptrip=mysqli_query($GLOBALS["___mysqli_ston"], "delete from master_transactionip where billnumber='$billnumber' and visitcode='$visitcode' and transactiontype='finalize'");
$biiiptrlater=mysqli_query($GLOBALS["___mysqli_ston"], "delete from master_transactionpaylater where billnumber='$billnumber' and visitcode='$visitcode' and transactiontype='finalize'");
$query64 = "update ip_bedallocation set paymentstatus='' where  visitcode='$visitcode'";
$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$query691 = "update master_ipvisitentry set paymentstatus='',finalbillno='',nhif_clearence='0' where  visitcode='$visitcode'";
$exec691 = mysqli_query($GLOBALS["___mysqli_ston"], $query691) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$query6412 = "update ip_discharge set paymentstatus='' where  visitcode='$visitcode'";
$exec6412 = mysqli_query($GLOBALS["___mysqli_ston"], $query6412) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$query6412c = "update newborn_motherdetails set ipbill='' where patientvisitcode='$visitcode'";
$exec6412c = mysqli_query($GLOBALS["___mysqli_ston"], $query6412c) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);


if($fromtype=='billing_ipcreditapproved'){
$billipcredireq=mysqli_query($GLOBALS["___mysqli_ston"], "delete from ip_creditapproval where visitcode='$visitcode'");
$billipcrediapp=mysqli_query($GLOBALS["___mysqli_ston"], "delete from ip_creditapprovalformdata where visitcode='$visitcode'");

$billipcrediapp=mysqli_query($GLOBALS["___mysqli_ston"], "delete from master_transactionipcreditapproved where visitcode='$visitcode' and billnumber='$billnumber'");
$billipcrediapp=mysqli_query($GLOBALS["___mysqli_ston"], "delete from billing_ipcreditapprovedtransaction where visitcode='$visitcode' and billnumber='$billnumber'");
$billipcrediapp=mysqli_query($GLOBALS["___mysqli_ston"], "delete from billing_ipcreditapproved where visitcode='$visitcode' and billno='$billnumber'");

$query88 = "update ip_bedallocation set creditapprovalstatus='' where visitcode='$visitcode'";
$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$query881 = "update ip_discharge set creditapprovalstatus='' where visitcode='$visitcode'";
$exec881 = mysqli_query($GLOBALS["___mysqli_ston"], $query881) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}

}else{
$billtb=mysqli_query($GLOBALS["___mysqli_ston"], "delete from tb where doc_number='$billnumber'");
$biiip=mysqli_query($GLOBALS["___mysqli_ston"], "delete from master_transactionipdeposit where docno='$billnumber' and visitcode='$visitcode'");
	
}
echo 1;
?>

