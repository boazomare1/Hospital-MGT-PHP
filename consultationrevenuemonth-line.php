<?php
session_start();
// What you will probably do is:
/*

if( isset( $_GET['id'] ) )
{
  $user = intval( $_GET['id'] );
  $sql = 'SELECT * FROM results WHERE fk_user='.$user;
}

*/

// I don't have any tables set up, so I
// simulate getting data from the database.
// This SQL will get the DB to produce a
// nice sin wave:
$t = array();
for( $i=0; $i<(4*3.14); $i+=0.3)
  $t[] = 'select sin('. $i .')';

$sql = implode( ' union ', $t );

//
// This opens the db connection as usual:
//
//   $db = mysql_connect("localhost", "user","***") or die("Could not connect");
//   mysql_select_db("database",$db) or die("Could not select database");
//
// Uncomment the above lines and fill in the db, user name and password, then
// delete the following two lines:
//

include ("db/db_connect.php");
$data = array();
$billingdatetime = array();
$yearfromm = $_SESSION['frommonth'];
$yeartom= $_SESSION['tomonth']; 
$yearfromy = $_SESSION['fromyear']; 
$yeartoy = $_SESSION['toyear'];

$query1 = "select SUM(`billamount`) sumforday, billingdatetime, MONTH(billingdatetime) totmonth FROM master_billing where MONTH(billingdatetime) BETWEEN '$yearfromm' and '$yeartom' and YEAR(billingdatetime) between '$yearfromy' and '$yeartoy' GROUP BY MONTH(billingdatetime) "; 
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 

while( $row = mysqli_fetch_array($exec1) )
{
  $billingdatetime[] = date('M',strtotime($row['billingdatetime']));
  //$billingdatetime[] = $row['billingdatetime'];
  $totmonth[] = $row['totmonth'];
  $data[] = floatval( $row['sumforday'] );
 //echo array_sum($data);
}
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

// use the chart class to build the chart:
include_once( 'open-flash-chart-1.9.5/php-ofc-library/open-flash-chart.php' );

$ymaxrange = ceil(max($data));
$yminrange = ceil(min($data));
$xy = $ymaxrange + $yminrange;

$g = new graph();
$g->title( 'Consultation Revenue - Month Wise', '{font-size: 20px;}' );

$g->set_data( $data );
$g->bg_colour = '0xFFFFFF';
$g->set_x_labels( $billingdatetime );
//$x_labels->set_colour( '#A2ACBA' );
$g->set_x_label_style( 12, '#000000', 2 );

$g->set_y_max( $xy );
$g->y_label_steps( $countmonth );

// display the data
echo $g->render();
?>
