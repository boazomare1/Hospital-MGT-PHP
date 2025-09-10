<?php
session_start();
include ("db/db_connect.php");
$data = array();
$both = array();
$billingdatetime = array();
$alldepartment = array();

$sumtotalamountcash = "0.00";
$sumtotalamountdirect = "0.00";
$sumtotalamountinsurance = "0.00";
$sumtotalamountstaff = "0.00";
$sumtotalamountcharity = "0.00";
$totalcreditcash = "0.00";
$totalcreditdirect = "0.00";
$totalcreditinsurance = "0.00";
$totalcreditstaff = "0.00";
$totalcreditcharity = "0.00";
$sumofcash = "0.00";
$sumofdirect = "0.00";
$sumofinsurance = "0.00"; 
$sumofstaff = "0.00";
$sumofcharity = "0.00";

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

//print_r($alldepartment);

$data = array($sumtotalamountcash,$sumtotalamountdirect,$sumtotalamountinsurance,$sumtotalamountstaff,$sumtotalamountcharity);
$data = array_diff($data,array('0.00'));
//print_r($data);
$_SESSION['totalipfinal'] = array_sum($data);

// use the chart class to build the chart:
include_once( 'open-flash-chart-1.9.5/php-ofc-library/open-flash-chart.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_legend.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_axis.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_pie.php' );


$g = new graph();
$g->bg_colour = '0xFFFFFF';

// PIE chart, 60% alpha
//.
$g->pie(180,'#505050','{font-size: 12px; color: #404040;');
$pie = new pie();

$pie->set_alpha(0.6);
$pie->set_start_angle( 35 );
// pass in two arrays, one of data, the other data labels
//$alldepartment = array('Cash:', 'Direct Credit:', 'Insurance:','Staff','Charity');

$c = array_combine($data, $alldepartment);

//print_r($c);
foreach($c as $key => $value) {
  //echo "$key $value".' ';
  $key = number_format($key,2,'.','');
  $both[] = "$value $key".' ';
}
//print_r($both);

$g->pie_values( $data, $both,'' );

//
// Colours for each slice, in this case some of the colours
// will be re-used (3 colurs for 5 slices means the last two
// slices will have colours colour[0] and colour[1]):
//
$g->pie_slice_colours( array('#FF0000','#00FF00','#0000FF','#FF00FF','#FFFF00') );

//$g->set_tool_tip( '#val# of #total# <br>#percent# of 100%' );

$g->title( 'IP Revenue', '{font-size:18px; color: #d01f3c; text-align:left}' );
echo $g->render();
?>
