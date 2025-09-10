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


if(isset($_REQUEST['mpesaamt'])){ $mpesa_amount = $_REQUEST['mpesaamt']; }
$mpesa_secret_key = $mpesa_secret;

echo $mpesahash = iPayment_encrypt("$mpesa_amount","$mpesa_secret_key"); 

?>