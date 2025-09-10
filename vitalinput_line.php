<?php
session_start();
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];

$patientcode = $_SESSION["patientcode"];
$visitcode = $_SESSION["visitcode"];

$transactiondatefrom = date('Y-m-d', strtotime('-1 day'));
$transactiondateto = date('Y-m-d');
$diastolic = array();
$systolic = array();
$resp = array();
$pulse = array();
$tempc = array();
$recorddtime = array();

  $query31="select * from ip_vitalio where patientcode = '$patientcode' and visitcode = '$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
  $exec31=mysqli_query($GLOBALS["___mysqli_ston"], $query31);
  $num=mysqli_num_rows($exec31);
  while($res31=mysqli_fetch_array($exec31))
  { 
   $recorddate[]=$res31['recorddate'].' '.$res31['recordtime'];
   //$recorddtime[]=$res31['recordtime'];
   $diastolic[]=intval($res31['diastolic']);
   $systolic[]=intval($res31['systolic']);
   $resp[]=intval($res31['resp']);
   $pulse[]=intval($res31['pulse']);
   $tempc[]=intval($res31['tempc']);
 }
	//print_r($diastolic);

include_once( 'open-flash-chart-1.9.5/php-ofc-library/open-flash-chart.php' );
$g = new graph();
$g->title( 'Blood Pressure and Pulse', '{font-size: 20px; color: #736AFF}' );
$g->bg_colour = '0xFFFFFF';


$maxsystolic= max($systolic);
$maxsystolic = intval($maxsystolic);
$maxsystolic = $maxsystolic + 50;
$maxsystolic = round($maxsystolic, -2);

// we add 3 sets of data:
$g->set_data( $diastolic );
$g->set_data( $systolic );
$g->set_data( $pulse );
$g->set_data( $resp );
$g->set_data( $tempc );

// we add the 3 line types and key labels
$g->line( 2, '0xAE1939', 'Diastolic', 10 );
$g->line_hollow(2, 4, '0x2A1CC8', 'Systolic', 10);    // <-- 3px thick + dots
$g->line( 2, '0x21BBDA', 'Respiration', 10 );
$g->line_hollow( 2, 4, '0x0D1514', 'Pulse', 10 );
$g->line_dot( 2, 5, '0xDA7721', 'Temperature', 10);    // <-- 3px thick + dots


$g->set_x_labels( $recorddate );
//$g->set_x_label_style( 10, '0x000000', 0, 1 );
$g->set_x_label_style( 10, '#000000', 1 );


$g->set_y_max( $maxsystolic );
$g->y_label_steps( 10 );
//$g->set_y_legend( 'Open Flash Chart', 12, '#736AFF' );
echo $g->render();
?>