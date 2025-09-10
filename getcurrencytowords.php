<?php 

include ("db/db_connect.php");

include('convert_currency_to_words.php');

$convertedwords ="";
$json = array('status'=>0,'msg'=>"");
$amount   =    trim($_POST['amount']);

if($amount !='')
{
	$convertedwords = covert_currency_to_words($amount); 
	$json = array('status'=>1,'msg'=>$convertedwords);
}
echo json_encode($json);

?>