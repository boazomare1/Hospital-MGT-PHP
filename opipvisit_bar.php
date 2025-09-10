<?php
session_start();
include ("db/db_connect.php");
$data = array();
$registrationdate = array();
$dateof = array();
$yearfrom = $_SESSION['datefrom'];
$yearto = $_SESSION['dateto'];

//$query2 = "select * from master_visitentry where registrationdate between '$transactiondatefrom' and '$transactiondateto' "; 
 $query2 = "SELECT COUNT(*) as total FROM master_visitentry where registrationdate between '$yearfrom' and '$yearto' "; 

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res2 = mysqli_fetch_array($exec2))
 {
 $res2total= $res2['total'];
 $dateof[] = $res2total;
}
echo $res2total;
$registrationdate[] = $yearfrom.'-'.$yearto;
  $data[] = count($dateof);

include_once( 'open-flash-chart-1.9.5/php-ofc-library/open-flash-chart.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_legend.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_axis.php' );

$ymaxrange = max($data);
$yminrange = min(array_filter($data));
$xy = $ymaxrange + $yminrange;
$xy = $ymaxrange + $yminrange;
$xy = intval($xy);
$xy = $xy + 25;
echo $xy = round($xy, -3);

$g = new graph();
$g->title( 'OP/IP Visit','{font-size: 20px;}' );

$g->bg_colour = '0xFFFFFF';
$g->bar_filled(55, '#DF013A', '#C31812',1);

//$g->title( 'Sin + 1.5', '{font-size: 12px;}' );

//$g->set_x_legend( 'Date' );
//$g->set_x_tick_size(5);
$g->set_data( $data );
//$xlabells = array('Consultation', 'Lab', 'Radiology', 'Service' , 'Pharmacy', 'Referral');
$g->set_x_labels( $registrationdate );
//$x_labels->set_colour( '#A2ACBA' );

$g->set_x_label_style( 12, '#000000', 0 );

$g->set_y_max( $xy);
$g->y_label_steps( 10 );
//$g->set_y_legend( 'Open Flash Chart', 12, '#736AFF' );
// display the data
echo $g->render();
?>
