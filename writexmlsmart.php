<?php

$hostname = '41.191.225.122:3307';

$hostlogin = 'integ_user';

$hostpassword = 'integ123';

$databasenamesmart = 'smartlink';

//Folder Name Change Only Necessary

$appfoldername = 'premier';



$fileData1 = '';

$InOut_Type = isset($InOut_Type) ? $InOut_Type : '1';



date_default_timezone_set('Africa/Nairobi'); 



$link = ($GLOBALS["___mysqli_ston_smart"] = mysqli_connect($hostname, $hostlogin, $hostpassword)) or die('Could not connect Table : ' . mysqli_error($GLOBALS["___mysqli_ston_smart"]));

mysqli_select_db($GLOBALS["___mysqli_ston_smart"], $databasenamesmart) or die('Could not select database'. mysqli_error($GLOBALS["___mysqli_ston_smart"]));




$sno = 0;

$claimdate = date('Y-m-d');

$claimtime = date('H:i:s');  


$updatedate = date('Y-m-d H:i:s');




$sql = "UPDATE exchange_files SET Exchange_File = '$importData', Exchange_Date = '$updatedate', Progress_Flag = '2' WHERE Member_Nr = '$patientcode' and (Progress_Flag='1' or Progress_Flag='3') and InOut_Type = '$InOut_Type' order by ID desc limit 1";

$current_id = mysqli_query($GLOBALS["___mysqli_ston_smart"], $sql) or die("<b>Error:</b> Problem on File Insert<br/>" . mysqli_error($GLOBALS["___mysqli_ston_smart"]));



if($InOut_Type==1){

	if($slade=='yes')
   {
	   
	  /* 	echo "the patienttype-->".$InOut_Type;

echo 'the salde inside-->'.$slade;
exit;*/
	   
   //$slade_claim_id=$_REQUEST['claim'];
  // header("location:slade-invoicepost.php?billno=$billautonumber&&visitcode=$visitcode&claim=$slade_claim_id");
  if($offpatient!='')
  {
	  header("location:slade-claim.php?billno=$billautonumber&&st=success&&printbill=$printbill&&frmflag1=frmflag1&&patientcode=$patientcode&&visitcode=$visitcode&slade=yes&claim=$claim&authorization_id=$authorization_id&amount=$amount&type=op&source_from=$offpatient");
   exit;
  }
  else
  {
 
    header("location:slade-claim.php?billautonumber=$billautonumber&&st=success&&printbill=$printbill&&frmflag1=frmflag1&&patientcode=$patientcode&&visitcode=$visitcode&slade=yes&claim=$claim&authorization_id=$authorization_id&amount=$amount&type=op");
   exit;
  }
  
}else{
   
  header("location:print_paylater_detailed.php?billautonumber=$billautonumber&&locationcode=$locationcode");
  exit;

}
}
if($InOut_Type==2){

if($slade=='yes')
   {
	   
	   if($split_status=='yes')
  {
	  header("location:slade-claim.php?billno=$billautonumber&&st=success&&printbill=$printbill&&frmflag1=frmflag1&&patientcode=$patientcode&&visitcode=$visitcode&slade=yes&claim=$claim&authorization_id=$authorization_id&amount=$amount&type=ip&split_status=yes&frmtype=ip");
	 
	   exit;
  }
  else
  { 
   //header("location:slade-invoiceippost.php?billno=$billautonumber&&visitcode=$visitcode&claim=$slade_claim_id");
   if($offpatient=='offslade')
   {
   header("location:slade-claim.php?billno=$billautonumber&&st=success&&printbill=$printbill&&frmflag1=frmflag1&&patientcode=$patientcode&&visitcode=$visitcode&slade=yes&claim=$claim&authorization_id=$authorization_id&amount=$amount&type=ip&frmtype=ip&source_from=$offpatient");
   exit;
   }
   else
   {
	    header("location:slade-claim.php?billno=$billautonumber&&st=success&&printbill=$printbill&&frmflag1=frmflag1&&patientcode=$patientcode&&visitcode=$visitcode&slade=yes&claim=$claim&authorization_id=$authorization_id&amount=$amount&type=ip&frmtype=ip");
   exit;
   }
  }
}else{


$result = substr($billautonumber, 0, 4);
if ($result=='IPFC'){ 

   		header("location:approvedcreditlist.php?patientcode=$patientcode&&visitcode=$visitcode&&billnumber=$billautonumber&&locationcode=$locationcode&&st=success");
}else
{
	header("location:print_ipfinalinvoice1.php?patientcode=$patientcode&&visitcode=$visitcode&&billnumber=$billautonumber&&locationcode=$locationcode");
}


exit;

}

}


?>

