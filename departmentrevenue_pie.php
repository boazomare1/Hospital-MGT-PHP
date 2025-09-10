<?php
session_start();
include ("db/db_connect.php");
$data = array();
$both = array();
$billingdatetime = array();

$transactiondatefrom  = $_SESSION['datefrom'];
$transactiondateto = $_SESSION['dateto'];

include("labrevenuecalculation.php");
include("radiologyrevenuecalculation.php");
include("servicerevenuecalculation.php");


$query661 = "select sum(costofsales) as labcogs from cogsentry where coa='02-2003' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
$exec661 = mysqli_query($GLOBALS["___mysqli_ston"], $query661) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res661 = mysqli_fetch_array($exec661);
$labcogs = $res661['labcogs'];

$query6611 = "select sum(costofsales) as labcogs from cogsentry where coa='02-2004' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
$exec6611 = mysqli_query($GLOBALS["___mysqli_ston"], $query6611) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res6611 = mysqli_fetch_array($exec6611);
$labcogs1 = $res6611['labcogs'];

$totallabcogs = $labcogs + $labcogs1;

$query663 = "select sum(costofsales) as radiologycogs from cogsentry where coa='02-2007' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
$exec663 = mysqli_query($GLOBALS["___mysqli_ston"], $query663) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res663 = mysqli_fetch_array($exec663);
$radiologycogs = $res663['radiologycogs'];

$query6631 = "select sum(costofsales) as radiologycogs from cogsentry where coa='02-2008' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
$exec6631 = mysqli_query($GLOBALS["___mysqli_ston"], $query6631) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res6631 = mysqli_fetch_array($exec6631);
$radiologycogs1 = $res6631['radiologycogs'];

$totalradiologycogs = $radiologycogs + $radiologycogs1;

$query664 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2009' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
$exec664 = mysqli_query($GLOBALS["___mysqli_ston"], $query664) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res664 = mysqli_fetch_array($exec664);
$servicecogs = $res664['servicecogs'];

$query6641 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2002' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
$exec6641 = mysqli_query($GLOBALS["___mysqli_ston"], $query6641) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res6641 = mysqli_fetch_array($exec6641);
$servicecogs1 = $res6641['servicecogs'];

$query6642 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2006' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
$exec6642 = mysqli_query($GLOBALS["___mysqli_ston"], $query6642) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res6642 = mysqli_fetch_array($exec6642);
$servicecogs2 = $res6642['servicecogs'];

$query6643 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2008' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
$exec6643 = mysqli_query($GLOBALS["___mysqli_ston"], $query6643) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res6643 = mysqli_fetch_array($exec6643);
$servicecogs3 = $res6643['servicecogs'];

$query6644 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2010' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
$exec6644 = mysqli_query($GLOBALS["___mysqli_ston"], $query6644) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res6644 = mysqli_fetch_array($exec6644);
$servicecogs4 = $res6644['servicecogs'];

$query6645 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2011' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
$exec6645 = mysqli_query($GLOBALS["___mysqli_ston"], $query6645) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res6645 = mysqli_fetch_array($exec6645);
$servicecogs5 = $res6645['servicecogs'];

$query6646 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2012' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
$exec6646 = mysqli_query($GLOBALS["___mysqli_ston"], $query6646) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res6646 = mysqli_fetch_array($exec6646);
$servicecogs6 = $res6646['servicecogs'];

$query6647 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2013' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
$exec6647 = mysqli_query($GLOBALS["___mysqli_ston"], $query6647) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res6647 = mysqli_fetch_array($exec6647);
$servicecogs7 = $res6647['servicecogs'];

$query6648 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2014' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
$exec6648 = mysqli_query($GLOBALS["___mysqli_ston"], $query6648) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res6648 = mysqli_fetch_array($exec6648);
$servicecogs8 = $res6648['servicecogs'];

$totalservicecogs = $servicecogs1 + $servicecogs2 + $servicecogs3 + $servicecogs4 + $servicecogs5 + $servicecogs6 + $servicecogs7 + $servicecogs8;

$nettlab = $total - $totallabcogs;
$nettradiology = $totalradiology - $totalradiologycogs;
$nettservice = $totalservice - $totalservicecogs;

if($nettlab != 0)
{
$data1[] = $nettlab;
$alldepartment1[] = "Laboratory:";
}

if($nettradiology != 0)
{
$data1[] = $nettradiology;
$alldepartment1[] = "Radiology:";
}

if($nettservice != 0)
{
$data1[] = $nettservice;
$alldepartment1[] = "Services:";
}
//$data = array($nettlab,$nettradiology,$nettservice);
//print_r($data);

// use the chart class to build the chart:
include_once( 'open-flash-chart-1.9.5/php-ofc-library/open-flash-chart.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_legend.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_axis.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_pie.php' );
//$ymaxrange = ceil(max($data));
//$yminrange = ceil(min($data));
//$xy = $ymaxrange + $yminrange;

$g = new graph();
$g->bg_colour = '0xFFFFFF';

// PIE chart, 60% alpha
//.
$g->pie(180,'#505050','{font-size: 12px; color: #404040;');
$pie = new pie();

$pie->set_alpha(0.6);
$pie->set_start_angle( 35 );
// pass in two arrays, one of data, the other data labels
//$alldepartment = array('Laboratory:', 'Radiology:', 'Services:');

$c = array_combine($data1, $alldepartment1);

//print_r($c);
foreach($c as $key => $value) {
  $key = number_format($key,2,'.','');
  $both[] = "$value $key".' ';
}
//print_r($both);

$g->pie_values( $data1, $both,'' );

//
// Colours for each slice, in this case some of the colours
// will be re-used (3 colurs for 5 slices means the last two
// slices will have colours colour[0] and colour[1]):
//
$g->pie_slice_colours( array('#FF0000','#00FF00','#0000FF') );
//$g->set_y_legend( 'Open Flash Chart', 12, '#736AFF' );


//$g->set_tool_tip( '#val# of #total# <br>#percent# of 100%' );

$g->title( 'Department Revenue', '{font-size:18px; color: #d01f3c; text-align:left}' );
echo $g->render();
?>
