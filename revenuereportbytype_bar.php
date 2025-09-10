<?php
session_start();
include ("db/db_connect.php");
$data = array();
$both = array();
$billingdatetime = array();

$transactiondatefrom  = $_SESSION['datefrom'];
$transactiondateto = $_SESSION['dateto'];

$query2 = "select * from master_paymenttype where recordstatus <> 'deleted'"; 
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
			  $res2auto_number = $res2['auto_number'];
			  $res2paymenttype = $res2['paymenttype'];
			  
			  $query3 = "select sum(transactionamount) as transactionamount1, count(billnumber) as billnumber1 from master_transactionpaynow where paymenttype = '$res2paymenttype' and transactionamount <>'0.00' and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $res3transactionamount= $res3['transactionamount1'];
			  $res3billnumber = $res3['billnumber1'];
			  
			  $query4 = "select sum(totalamount) as totalamount1, count(billnumber) as billnumber1 from master_billing where paymenttype = '$res2paymenttype'and totalamount <> '0.00' and billingdatetime between '$transactiondatefrom' and '$transactiondateto'"; 
			  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res4 = mysqli_fetch_array($exec4);
			  $res4totalamount= $res4['totalamount1'];
			  $res4billnumber = $res4['billnumber1'];
			  
			  $query5 = "select sum(transactionamount) as transactionamount1, count(billnumber) as billnumber1 from master_transactionpaylater where paymenttype = '$res2paymenttype' and transactiontype = 'finalize' and transactionamount <>'0.00' and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
			  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res5 = mysqli_fetch_array($exec5);
			  $res5totalamount= $res5['transactionamount1'];
			  $res5billnumber = $res5['billnumber1'];
			  
			  $revenueamount = $res3transactionamount + $res4totalamount + $res5totalamount;
			  $data[] = $revenueamount;
			}

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
$g->title( 'Revenue Report By Type  ','{font-size: 20px;}' );

$g->bg_colour = '0xFFFFFF';
$g->bar_filled(55, '#D54C78', '#C31812',1);
//$g->bar('', '#D54C78', 'Laboratory',12); //color index 

//$g->title( 'Sin + 1.5', '{font-size: 12px;}' );

//$g->set_x_legend( 'Date' );
//$g->set_x_tick_size(5);
$g->set_data( $data );
//$g->set_x_labels( 'Laboratory','Radiology','Services' );
//$x_labels->set_colour( '#A2ACBA' );
$xlabells = array('Cash', 'Direct Credit', 'Insurance', 'Staff', 'Charity');
$g->set_x_labels( $xlabells );
$g->set_x_label_style( 12, '#000000', 0 );

$g->set_y_max( $xy );
$g->y_label_steps( 10 );
//$g->set_y_legend( 'Open Flash Chart', 12, '#736AFF' );
// display the data
echo $g->render();
?>
