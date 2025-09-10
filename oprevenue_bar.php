<?php
session_start();
include ("db/db_connect.php");
$data = array();
$billingdatetime = array();

$yearfrom = $_SESSION['datefrom'];
$yearto = $_SESSION['dateto'];

$query1 = "select sum(billamount) as billamount1 from master_billing where billingdatetime between '$yearfrom' and '$yearto'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1consultationamount = $res1['billamount1'];

$query2 = "select sum(labitemrate) as labitemrate1 from billing_paylaterlab where billdate between '$yearfrom' and '$yearto'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$res2labitemrate = $res2['labitemrate1'];

$query3 = "select sum(labitemrate) as labitemrate1 from billing_paynowlab where billdate between '$yearfrom' and '$yearto'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$res3labitemrate = $res3['labitemrate1'];

$query14 = "select sum(labitemrate) as labitemrate1 from billing_externallab where billdate between '$yearfrom' and '$yearto'";
$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in query14".mysqli_error($GLOBALS["___mysqli_ston"]));
$res14 = mysqli_fetch_array($exec14);
$res14labitemrate = $res14['labitemrate1'];

$totallabitemrate = $res2labitemrate + $res3labitemrate + $res14labitemrate;

$query4 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paylaterradiology where billdate between '$yearfrom' and '$yearto'";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
$res4 = mysqli_fetch_array($exec4);
$res4radiologyitemrate = $res4['radiologyitemrate1'];

$query5 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paynowradiology where billdate between '$yearfrom' and '$yearto'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);
$res5radiologyitemrate = $res5['radiologyitemrate1'];

$query15 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_externalradiology where billdate between '$yearfrom' and '$yearto'";
$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
$res15 = mysqli_fetch_array($exec15);
$res15radiologyitemrate = $res15['radiologyitemrate1'];

$totalradiologyitemrate = $res4radiologyitemrate + $res5radiologyitemrate + $res15radiologyitemrate;

$query6 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paylaterservices where billdate between '$yearfrom' and '$yearto'";
$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
$res6 = mysqli_fetch_array($exec6);
$res6servicesitemrate = $res6['servicesitemrate1'];

$query7 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paynowservices where billdate between '$yearfrom' and '$yearto'";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
$res7 = mysqli_fetch_array($exec7);
$res7servicesitemrate = $res7['servicesitemrate1'];

$query16 = "select sum(servicesitemrate) as servicesitemrate1 from billing_externalservices where billdate between '$yearfrom' and '$yearto'";
$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
$res16 = mysqli_fetch_array($exec16);
$res16servicesitemrate = $res16['servicesitemrate1'];

$totalservicesitemrate = $res6servicesitemrate + $res7servicesitemrate + $res16servicesitemrate ;

$query8 = "select sum(amount) as amount1 from billing_paylaterpharmacy where billdate between '$yearfrom' and '$yearto'";
$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
$res8 = mysqli_fetch_array($exec8);
$res8pharmacyitemrate = $res8['amount1'];

$query9 = "select sum(amount) as amount1 from billing_paynowpharmacy where billdate between '$yearfrom' and '$yearto'";
$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
$res9 = mysqli_fetch_array($exec9);
$res9pharmacyitemrate = $res9['amount1'];

$query17 = "select sum(amount) as amount1 from billing_externalpharmacy where billdate between '$yearfrom' and '$yearto'";
$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query17".mysqli_error($GLOBALS["___mysqli_ston"]));
$res17 = mysqli_fetch_array($exec17);
$res17pharmacyitemrate = $res17['amount1'];

$totalpharmacyitemrate = $res8pharmacyitemrate + $res9pharmacyitemrate + $res17pharmacyitemrate;

$query10 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where billdate between '$yearfrom' and '$yearto'";
$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
$res10 = mysqli_fetch_array($exec10);
$res10referalitemrate = $res10['referalrate1'];

$query11 = "select sum(referalrate) as referalrate1 from billing_paynowreferal where billdate between '$yearfrom' and '$yearto'";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
$res11 = mysqli_fetch_array($exec11);
$res11referalitemrate = $res11['referalrate1'];

$totalreferalitemrate = $res10referalitemrate + $res11referalitemrate;

$data = array($res1consultationamount,$totallabitemrate,$totalradiologyitemrate,$totalservicesitemrate, $totalpharmacyitemrate, $totalreferalitemrate);
$ymaxrange = max($data);
$yminrange = min(array_filter($data));
$xy = $ymaxrange + $yminrange;
$xy = intval($xy);
$xy = $xy + 500;
echo $xy = round($xy, -3);

include_once( 'open-flash-chart-1.9.5/php-ofc-library/open-flash-chart.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_legend.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_axis.php' );

//$ymaxrange = ceil(max($data));
//$yminrange = ceil(min($data));
//$xy = $ymaxrange + $yminrange;

$g = new graph();
$g->title( 'OP Revenue','{font-size: 20px;}' );

$g->bg_colour = '0xFFFFFF';
$g->bar_filled(55, '#DF013A', '#C31812',1);

//$g->title( 'Sin + 1.5', '{font-size: 12px;}' );

//$g->set_x_legend( 'Date' );
//$g->set_x_tick_size(5);
$g->set_data( $data );
$xlabells = array('Consultation', 'Lab', 'Radiology', 'Service' , 'Pharmacy', 'Referral');
$g->set_x_labels( $xlabells );
//$x_labels->set_colour( '#A2ACBA' );

$g->set_x_label_style( 12, '#000000', 0 );

$g->set_y_max( $xy);
$g->y_label_steps( 10 );
//$g->set_y_legend( 'Open Flash Chart', 12, '#736AFF' );
// display the data
echo $g->render();
?>
