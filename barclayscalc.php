<?php 
session_start();
error_reporting(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");

function iPayment_encrypt($data, $key) {
    //$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $secret_iv = 'ivkey';
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    $encrypted =openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);return base64_encode($encrypted . '::' . $iv);
}


if(isset($_REQUEST['barclaysamt'])){ $barclays_amount = $_REQUEST['barclaysamt']; }
$barclays_secret_key = $barclays_secret;

echo $barclayshash = iPayment_encrypt("$barclays_amount","$barclays_secret_key"); 

?>