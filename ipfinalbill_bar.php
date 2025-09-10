<?php
session_start();
include ("db/db_connect.php");
$data = array();
$both = array();
$billingdatetime = array();

$transactiondatefrom  = $_SESSION['datefrom'];
$transactiondateto = $_SESSION['dateto'];

$sumtotalamountcash = "0.00";
$sumtotalamountdirect = "0.00";
$sumtotalamountinsurance = "0.00";
$sumtotalamountstaff = "0.00";
$sumtotalamountcharity = "0.00";

$transactiondatefrom  = $_SESSION['datefrom'];
$transactiondateto = $_SESSION['dateto'];

$query1 = "select * from billing_ip where paymenttype = 'CASH' and billdate between '$transactiondatefrom' and '$transactiondateto' ";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res1 = mysqli_fetch_array($exec1))
 {
	   $res1amount = $res1['totalrevenue'];
	   $sumtotalamountcash = $sumtotalamountcash + $res1amount;
 }
 if($sumtotalamountcash != 0)
		{
$alldepartment[] = 'CASH:';	
        } 

$query1 = "select * from billing_ip where paymenttype = 'DIRECT CREDIT' and billdate between '$transactiondatefrom' and '$transactiondateto' ";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res1 = mysqli_fetch_array($exec1))
 {
	   $res1amount = $res1['totalrevenue'];
	   $sumtotalamountdirect= $sumtotalamountdirect + $res1amount;
}
if($sumtotalamountdirect != 0)
		{
$alldepartment[] = 'DIRECT CREDIT:';	
        } 

$query1 = "select * from billing_ip where paymenttype = 'INSURANCE' and billdate between '$transactiondatefrom' and '$transactiondateto' ";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res1 = mysqli_fetch_array($exec1))
 {
	   $res1amount = $res1['totalrevenue'];
	   $sumtotalamountinsurance= $sumtotalamountinsurance + $res1amount;
}
if($sumtotalamountinsurance != 0)
		{
$alldepartment[] = 'INSURANCE:';	
        } 
	 
$query1 = "select * from billing_ip where paymenttype = 'STAFF' and billdate between '$transactiondatefrom' and '$transactiondateto' ";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res1 = mysqli_fetch_array($exec1))
 {
	   $res1amount = $res1['totalrevenue'];
	   $sumtotalamountstaff = $sumtotalamountstaff + $res1amount;
 }
if($sumtotalamountstaff != 0)
		{
$alldepartment[] = 'STAFF:';	
        } 
		 
$query1 = "select * from billing_ip where paymenttype = 'CHARITY' and billdate between '$transactiondatefrom' and '$transactiondateto' ";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res1 = mysqli_fetch_array($exec1))
 {
	   $res1amount = $res1['totalrevenue'];
	   $sumtotalamountcharity = $sumtotalamountcharity + $res1amount;
 }
 if($sumtotalamountcharity != 0)
		{
$alldepartment[] = 'CHARITY:';	
        } 

$data = array($sumtotalamountcash,$sumtotalamountdirect,$sumtotalamountinsurance,$sumtotalamountstaff,$sumtotalamountcharity);
//print_r($alldepartment);

//print_r($data);
//echo array_sum($data);
//print_r($data);
//print_r($billingdatetime);
$ymaxrange = max($data);
$yminrange = min(array_filter($data));
$xy = $ymaxrange + $yminrange;
$xy = intval($xy);
$xy = $xy + 500;
echo $xy = round($xy, -3);

// use the chart class to build the chart:
include_once( 'open-flash-chart-1.9.5/php-ofc-library/open-flash-chart.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_legend.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_axis.php' );

$g = new graph();
$g->title( 'IP Revenue  ','{font-size: 20px;}' );

$g->bg_colour = '0xFFFFFF';
$g->bar_filled(55, '#D54C78', '#C31812',1);
//$g->bar('', '#D54C78', 'Laboratory',12); //color index 

//$g->title( 'Sin + 1.5', '{font-size: 12px;}' );

//$g->set_x_legend( 'Date' );
//$g->set_x_tick_size(5);
$g->set_data( $data );
//$g->set_x_labels( 'Laboratory','Radiology','Services' );
//$x_labels->set_colour( '#A2ACBA' );
$xlabells = array('Cash', 'Direct Credit', 'Insurance','Staff','Charity');
$g->set_x_labels( $xlabells );
$g->set_x_label_style( 12, '#000000', 0 );

$g->set_y_max( $xy );
$g->y_label_steps( 10 );
//$g->set_y_legend( 'Open Flash Chart', 12, '#736AFF' );
// display the data
echo $g->render();
?>
