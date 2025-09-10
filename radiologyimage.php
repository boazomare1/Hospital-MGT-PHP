<?php
if (isset($_REQUEST["dst"])) { $dst = $_REQUEST["dst"]; } else { $dst = ""; }
$dstfile='\\\\192.168.100.26\\Public\\RadiologyImages';
$found_files = glob("$dstfile/*/".$dst."");
if(!isset($found_files[0]))
{
$dstfile = '\\\\192.168.100.26\\Public\\RadiologyImages\\'.$dst;
}
else
{
$dstfile = str_replace("/", "\\", $found_files[0]);
}
header('Content-Type: image/jpeg');
readfile($dstfile);
?>