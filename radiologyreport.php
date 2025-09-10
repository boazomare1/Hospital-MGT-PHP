<?php
if (isset($_REQUEST["dst"])) { $dst = $_REQUEST["dst"]; } else { $dst = ""; }
$fileinfo = pathinfo($dst);
if($fileinfo['extension']=='doc'||$fileinfo['extension']=='docx')
{
header("Content-type:application/ms-word");
$directname = gethostbyaddr('192.168.100.26');
//$dst='UPPER EXTREMITIES -Wrist AP_LAT-7_3_2015-8_53_46 AM-484.jpeg';

 $dstfile='\\\\192.168.100.26\\Public\\RadiologyImages\\'.$dst;
//$dstfile='radiologyimages//'.$dst;
//echo "<a href='$dstfile' >as111as</a>";
//exit;
header("Content-Disposition:inline;filename='".$dst."'");

// The Word source is in original.pdf
readfile($dstfile);
}
elseif($fileinfo['extension']=='pdf')
{
header("Content-type:application/pdf");
 $dstfile='\\\\192.168.100.26\\Public\\RadiologyImages\\'.$dst;
header("Content-Disposition:inline;filename='".$dst."'");
// The PDF source is in original.pdf
readfile($dstfile);
}
?>