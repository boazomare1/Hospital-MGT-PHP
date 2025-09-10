<?php
session_start();
include ("db/db_connect.php");
$data = array();
$billingdatetime = array();

$monthdata =  $_SESSION['month'];
$yeardata = $_SESSION['year'];

//$query1 = "select * from master_billing ";

//$query1 = "SELECT MONTH(billingdatetime) = '$monthdata' AND YEAR(billingdatetime) = '$yeardata' billamount from master_billing WHERE  ";
$query1 = "SELECT MONTH(billingdatetime) month, YEAR(billingdatetime) year, SUM(`billamount`) sumforday, billingdatetime FROM master_billing where MONTH(billingdatetime) = '$monthdata' AND YEAR(billingdatetime) = '$yeardata' GROUP BY billingdatetime "; 
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 
while( $row = mysqli_fetch_array($exec1))
{
  $billingdatetime[] = $row['billingdatetime'];
  //$billingdatetime[] = $row['billingdatetime'];
  $data[] = floatval( $row['sumforday'] );
 //echo array_sum($data);
}

print_r($data);
//echo array_sum($data);
//print_r($data);
//print_r($billingdatetime);

// use the chart class to build the chart:
include_once( 'open-flash-chart-1.9.5/php-ofc-library/open-flash-chart.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_legend.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_axis.php' );

$ymaxrange = max($data);
/*$yminrange = min(array_filter($data));
$xy = $ymaxrange + $yminrange;*/
$xy = intval($ymaxrange);
echo $xy = $xy + 500;
$xy = round($xy, -3);


$g = new graph();
$g->title( 'Consultation Revenue - Day Wise ','{font-size: 20px;}' );

$g->bg_colour = '0xFFFFFF';
$g->bar_filled(55, '#D54C78', '#C31812',1);

//$g->title( 'Sin + 1.5', '{font-size: 12px;}' );

//$g->set_x_legend( 'Date' );
//$g->set_x_tick_size(5);
$g->set_data( $data );
$g->set_x_labels( $billingdatetime );
//$x_labels->set_colour( '#A2ACBA' );
$g->set_x_label_style( 10, '#000000', 3 );

$g->set_y_max( $xy );
$g->y_label_steps( 10 );
//$g->set_y_legend( 'Open Flash Chart', 12, '#736AFF' );
// display the data
echo $g->render();
?>
