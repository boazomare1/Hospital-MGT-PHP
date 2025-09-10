<?php 
header("Content-Type: image/png");
include_once("./includes/tcpdf/tcpdf_barcodes_2d.php"); 

$code = isset($_REQUEST['id'])?$_REQUEST['id']:'123';
$type = "PDF417";

$barcodeobj = new TCPDF2DBarcode($code, $type);
$barcodeobj->getBarcodePNG(2, 0.5, array(0,0,0));

?>
