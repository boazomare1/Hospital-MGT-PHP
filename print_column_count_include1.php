<?php

$query8 = "select * from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and 
settingsname = 'SHOW_COLUMN_RATE'";
$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
$res8 = mysqli_fetch_array($exec8);
$showcolumnrate = $res8["settingsvalue"];
if ($showcolumnrate == 'SHOW COLUMN RATE') $columncount = $columncount + 1;
//if ($showcolumnrate == 'HIDE COLUMN RATE') $columncount = $columncount - 1;

$query8 = "select * from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and 
settingsname = 'SHOW_COLUMN_QUANTITY'";
$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
$res8 = mysqli_fetch_array($exec8);
$showcolumnquantity = $res8["settingsvalue"];
if ($showcolumnquantity == 'SHOW COLUMN QUANTITY') $columncount = $columncount + 1;
//if ($showcolumnquantity == 'HIDE COLUMN QUANTITY') $columncount = $columncount - 1;

$query8 = "select * from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and 
settingsname = 'SHOW_COLUMN_UNIT'";
$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
$res8 = mysqli_fetch_array($exec8);
$showcolumnunit = $res8["settingsvalue"];
if ($showcolumnunit == 'SHOW COLUMN UNIT') $columncount = $columncount + 1;
//if ($showcolumnunit == 'HIDE COLUMN UNIT') $columncount = $columncount - 1;

$query8 = "select * from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and 
settingsname = 'SHOW_COLUMN_TAX'";
$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
$res8 = mysqli_fetch_array($exec8);
$showcolumntax = $res8["settingsvalue"];
if ($showcolumntax == 'SHOW COLUMN TAX') $columncount = $columncount + 1;
//if ($showcolumntax == 'HIDE COLUMN TAX') $columncount = $columncount - 1;

$query8 = "select * from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and 
settingsname = 'SHOW_COLUMN_DISCOUNT'";
$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
$res8 = mysqli_fetch_array($exec8);
$showcolumndiscount = $res8["settingsvalue"];
if ($showcolumndiscount == 'SHOW COLUMN DISCOUNT') $columncount = $columncount + 2;
//if ($showcolumndiscount == 'HIDE COLUMN DISCOUNT') $columncount = $columncount - 2;

//echo $columncount;



?>