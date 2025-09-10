<?php
session_start();
include ("db/db_connect.php");
$data = array();
$billingdatetime = array();

$monthdata =  $_SESSION['month'];
$yeardata = '2014';

//$query1 = "select * from master_billing ";

$query1 = "SELECT * FROM master_billing WHERE MONTH(billingdatetime) = '$monthdata' AND YEAR(billingdatetime) = '2014'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 
while( $row = mysqli_fetch_array($exec1))
{
  $billingdatetime[] = $row['billingdatetime'];
  $data[] = floatval( $row['billamount'] );
}

//print_r($data);
//print_r($billingdatetime);

// use the chart class to build the chart:
include_once( 'open-flash-chart-1.9.5/php-ofc-library/open-flash-chart.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_legend.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_axis.php' );

$g = new graph();
$g->title( 'Consultation Revenue ','{font-size: 20px;}' );

$g->bg_colour = '0xFFFFFF';
$g->bar_glass(55, '#D54C78', '#C31812',1);

//$g->title( 'Sin + 1.5', '{font-size: 12px;}' );

$g->set_x_legend( 'Date' );
//$g->set_x_tick_size(5);
$g->set_data( $data );
$g->set_x_labels( $billingdatetime );
//$x_labels->set_colour( '#A2ACBA' );
$g->set_x_label_style( 10, '#000000', 2 );

$g->set_y_max( 1000 );
$g->y_label_steps( 2 );
//$g->set_y_legend( 'Open Flash Chart', 12, '#736AFF' );
// display the data
echo $g->render();
?>
