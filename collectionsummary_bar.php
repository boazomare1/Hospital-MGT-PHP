<?php
session_start();
include ("db/db_connect.php");
$data = array();
$billingdatetime = array();

$yearfrom = $_SESSION['datefrom'];
$yearto = $_SESSION['dateto'];

 $query2 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionpaynow where transactiondate between '$yearfrom' and '$yearto'"; 
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);

$res2cashamount1 = $res2['cashamount1'];
$res2onlineamount1 = $res2['onlineamount1'];
$res2creditamount1 = $res2['creditamount1'];
$res2chequeamount1 = $res2['chequeamount1'];
$res2cardamount1 = $res2['cardamount1'];


$query3 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionexternal where transactiondate between '$yearfrom' and '$yearto'"; 
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);

$res3cashamount1 = $res3['cashamount1'];
$res3onlineamount1 = $res3['onlineamount1'];
$res3creditamount1 = $res3['creditamount1'];
$res3chequeamount1 = $res3['chequeamount1'];
$res3cardamount1 = $res3['cardamount1'];


$query4 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_billing where billingdatetime between '$yearfrom' and '$yearto'"; 
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
$res4 = mysqli_fetch_array($exec4);

$res4cashamount1 = $res4['cashamount1'];
$res4onlineamount1 = $res4['onlineamount1'];
$res4creditamount1 = $res4['creditamount1'];
$res4chequeamount1 = $res4['chequeamount1'];
$res4cardamount1 = $res4['cardamount1'];

$query5 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from refund_paynow where transactiondate between '$yearfrom' and '$yearto'"; 
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);

$res5cashamount1 = $res5['cashamount1'];
$res5onlineamount1 = $res5['onlineamount1'];
$res5creditamount1 = $res5['creditamount1'];
$res5chequeamount1 = $res5['chequeamount1'];
$res5cardamount1 = $res5['cardamount1'];

$query6 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionadvancedeposit where transactiondate between '$yearfrom' and '$yearto'"; 
$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
$res6 = mysqli_fetch_array($exec6);

$res6cashamount1 = $res6['cashamount1'];
$res6onlineamount1 = $res6['onlineamount1'];
$res6creditamount1 = $res6['creditamount1'];
$res6chequeamount1 = $res6['chequeamount1'];
$res6cardamount1 = $res6['cardamount1'];

$query7 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipdeposit where transactiondate between '$yearfrom' and '$yearto'"; 
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
$res7 = mysqli_fetch_array($exec7);

$res7cashamount1 = $res7['cashamount1'];
$res7onlineamount1 = $res7['onlineamount1'];
$res7creditamount1 = $res7['creditamount1'];
$res7chequeamount1 = $res7['chequeamount1'];
$res7cardamount1 = $res7['cardamount1'];

$query8 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionip where transactiondate between '$yearfrom' and '$yearto'"; 
$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
$res8 = mysqli_fetch_array($exec8);

$res8cashamount1 = $res8['cashamount1'];
$res8onlineamount1 = $res8['onlineamount1'];
$res8creditamount1 = $res8['creditamount1'];
$res8chequeamount1 = $res8['chequeamount1'];
$res8cardamount1 = $res8['cardamount1'];

$query9 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipcreditapproved where transactiondate between '$yearfrom' and '$yearto'"; 
$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
$res9 = mysqli_fetch_array($exec9);

$res9cashamount1 = $res9['cashamount1'];
$res9onlineamount1 = $res9['onlineamount1'];
$res9creditamount1 = $res9['creditamount1'];
$res9chequeamount1 = $res9['chequeamount1'];
$res9cardamount1 = $res9['cardamount1'];

$cashamount = $res2cashamount1 + $res3cashamount1 + $res4cashamount1 + $res6cashamount1 + $res7cashamount1 + $res8cashamount1 + $res9cashamount1;
$cardamount = $res2cardamount1 + $res3cardamount1 + $res4cardamount1 + $res6cardamount1 + $res7cardamount1 + $res8cardamount1 + $res9cardamount1;
$chequeamount = $res2chequeamount1 + $res3chequeamount1 + $res4chequeamount1 + $res6chequeamount1 + $res7chequeamount1 + $res8chequeamount1 + $res9chequeamount1;
$onlineamount = $res2onlineamount1 + $res3onlineamount1 + $res4onlineamount1 + $res6onlineamount1 + $res7onlineamount1 + $res8onlineamount1 + $res9onlineamount1;

$cashamount1 = $cashamount - $res5cashamount1;
$cardamount1 = $cardamount - $res5cardamount1;
$chequeamount1 = $chequeamount - $res5chequeamount1;
$onlineamount1 = $onlineamount - $res5onlineamount1;

$total = $cashamount1 + $onlineamount1 + $chequeamount1 + $cardamount1;

$data = array($cashamount1,$onlineamount1,$chequeamount1, $cardamount1);
$ymaxrange = max($data);
$yminrange = min(array_filter($data));
$xy = $ymaxrange + $yminrange;
$xy = intval($xy);
$xy = $xy + 500;
echo $xy = round($xy, -3);

//print_r($data);

// use the chart class to build the chart:
include_once( 'open-flash-chart-1.9.5/php-ofc-library/open-flash-chart.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_legend.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_axis.php' );

//$ymaxrange = ceil(max($data));
//$yminrange = ceil(min($data));
//$xy = $ymaxrange + $yminrange;

$g = new graph();
$g->title( 'Collection Summary','{font-size: 20px;}' );

$g->bg_colour = '0xFFFFFF';
$g->bar_filled(55, '#D54C78', '#C31812',1);

//$g->title( 'Sin + 1.5', '{font-size: 12px;}' );

//$g->set_x_legend( 'Date' );
//$g->set_x_tick_size(5);
$g->set_data( $data );
$xlabells = array('Cash', 'Online', 'Cheque', 'Card');
$g->set_x_labels( $xlabells );
//$x_labels->set_colour( '#A2ACBA' );

$g->set_x_label_style( 12, '#000000', 0 );

$g->set_y_max( $xy );
$g->y_label_steps( 10 );
//$g->set_y_legend( 'Open Flash Chart', 12, '#736AFF' );
// display the data
echo $g->render();
?>
