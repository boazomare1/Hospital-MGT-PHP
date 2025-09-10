<?php
if (isset($_REQUEST["dst"])) { $dst = $_REQUEST["dst"]; } else { $dst = ""; }
$dstfile='\\\\192.168.100.26\\RadiologyImages';
$found_files = glob("$dstfile/*/".$dst."");
$username ="192.168.100.26\imaging";
$username = addslashes($username);
$password ="Rad.2016";
if(!isset($found_files[0]))
{
$dstfile = '\\\\192.168.100.26\\RadiologyImages\\'.$dst;
}
else
{
$dstfile = str_replace("/", "\\", $found_files[0]);
}
$context = stream_context_create(array (
    'ftp' => array (
	        'header' => 'Authorization: Basic ' . base64_encode('192.168.100.26\imaging:Rad.2016')
    )
));
header('Content-Type: image/jpeg');

//$data = file_get_contents($dstfile, false, $context);
$dstfile1= str_replace("\\\\","", $dstfile);
$dstfile1= str_replace("\\", "/", $dstfile1);
//$dstfile1 =  '192.168.100.26/RadiologyImages/'.$dst;
echo file_get_contents("ftp://imaging:Rad.2016@".$dstfile1);
?>
