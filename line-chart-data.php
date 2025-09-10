<?php

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
$monthdata =  $_SESSION['month'];
$yeardata = '2014';

$query1 = "SELECT * FROM master_billing WHERE MONTH(billingdatetime) = '$monthdata' AND YEAR(billingdatetime) = '2014'";$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 

while( $row = mysqli_fetch_array($exec1) )
{
  $billingdatetime[] = $row['billingdatetime' ];
  $data[] = floatval( $row['billamount'] );
}


// use the chart class to build the chart:
include_once( 'open-flash-chart-1.9.5/php-ofc-library/open-flash-chart.php' );
$g = new graph();
$g->title( 'Sin + 1.5', '{font-size: 12px;}' );

$g->set_data( $data );
$g->set_x_labels( $billingdatetime );
//$x_labels->set_colour( '#A2ACBA' );
$g->set_x_label_style( 10, '#000000', 2 );

$g->set_y_max( 1000 );
$g->y_label_steps( 2 );

// display the data
echo $g->render();
?>
