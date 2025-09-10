<?php
session_start();
include ("db/db_connect.php");
$data = array();
$billingdatetime = array();

$yearfrom = $_SESSION['datefrom'];
$yearto = $_SESSION['dateto'];

$yearfromm = $_SESSION['frommonth'];
$yeartom= $_SESSION['tomonth']; 
$yearfromy = $_SESSION['fromyear']; 
$yeartoy = $_SESSION['toyear'];

//$query1 = "SELECT MONTH(billingdatetime) = '$monthdata' AND YEAR(billingdatetime) = '$yeardata' billamount from master_billing WHERE  ";

$query1 = "select SUM(`billamount`) sumforday, billingdatetime, MONTH(billingdatetime) totmonth FROM master_billing where MONTH(billingdatetime) BETWEEN '$yearfromm' and '$yeartom' and YEAR(billingdatetime) between '$yearfromy' and '$yeartoy' GROUP BY MONTH(billingdatetime) "; 
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));   
while( $row = mysqli_fetch_array($exec1))
{
  $billingdatetime[] = date('M',strtotime($row['billingdatetime']));
  //$billingdatetime[] = $row['billingdatetime'];
  $totmonth[] = $row['totmonth'];
  $data[] = floatval( $row['sumforday'] );
 //echo array_sum($data);
}
//echo print_r($totmonth);
$countmonth = count($totmonth);

if(($countmonth%2) == 0) 
{
 $countmonth = $countmonth + 1;
} 
else
 {
 $countmonth= $countmonth;
}

//print_r($data);
//echo array_sum($data);
//print_r($data);
//print_r($billingdatetime);

// use the chart class to build the chart:
include_once( 'open-flash-chart-1.9.5/php-ofc-library/open-flash-chart.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_legend.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_axis.php' );

$ymaxrange = ceil(max($data));
$yminrange = ceil(min($data));
$xy = $ymaxrange + $yminrange;

$g = new graph();
$g->title( 'Consultation Revenue - Month Wise ','{font-size: 20px;}' );

$g->bg_colour = '0xFFFFFF';
$g->bar_filled(55, '#D54C78', '#C31812',1);

//$g->title( 'Sin + 1.5', '{font-size: 12px;}' );

//$g->set_x_legend( 'Date' );
//$g->set_x_tick_size(5);
$g->set_data( $data );
$g->set_x_labels( $billingdatetime );
//$x_labels->set_colour( '#A2ACBA' );
$g->set_x_label_style( 12, '#000000', 2 );

$g->set_y_max( $xy );
$g->y_label_steps( $countmonth );
//$g->set_y_legend( 'Open Flash Chart', 12, '#736AFF' );
// display the data
echo $g->render();
?>
