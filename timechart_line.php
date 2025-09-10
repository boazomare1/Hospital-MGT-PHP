<?php
session_start();
include ("db/db_connect.php");
include ("includes/loginverify.php");
$data = array();
$avtgime = array();
$maxtime = array();
$registrationdate1 = array();

$yearfrom = $_SESSION['datefrom'];
$yearto = $_SESSION['dateto'];

$query1 = "select registrationdate FROM master_visitentry where registrationdate between '$yearfrom' and '$yearto' "; 
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res1 = mysqli_fetch_array($exec1))
		{  
		 $registrationdate[]= $res1['registrationdate'];
	    }			

function getAllDatesBetweenTwoDates($strDateFrom,$strDateTo)
{
    $aryRange=array();

    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

    if ($iDateTo>=$iDateFrom)
    {
        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
        while ($iDateFrom<$iDateTo)
        {
            $iDateFrom+=86400; // add 24 hours
            array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
    }
    return $aryRange;
}

$fromDate = min($registrationdate);
$toDate = max($registrationdate);

//$dateArray = getAllDatesBetweenTwoDates($yearfrom, $yearto);
$dateArray = getAllDatesBetweenTwoDates($fromDate, $toDate);
  //print_r($dateArray);

include ("timereportinclude.php");
for($i=0;$i<=sizeof($dateArray); $i++)
 {
 $avgtime[] = doTask($dateArray[$i]);
 }
//print_r($avtgime); 

$ymaxrange = max($avgtime);
$yminrange = min(array_filter($avgtime));
$xy = $ymaxrange + $yminrange;
$xy = intval($xy);
$xy = $xy + 5;
echo $max = $ymaxrange % 10;
if($max != 0)
{
$max = 10 - $max;
echo $ymaxrange = $ymaxrange + $max;
} 
//$xy = round($xy, -3);
 
include_once( 'open-flash-chart-1.9.5/php-ofc-library/open-flash-chart.php' );
$g = new graph();
//$g->title( 'Time Chart', '{font-size: 20px; color: #736AFF}' );
$g->bg_colour = '0xFFFFFF';

// we add 3 sets of data:
$g->set_data( $avgtime );

// we add the 3 line types and key labels
$g->line_hollow(2, 4, '0x2A1CC8', 'AWT', 10);    // <-- 3px thick + dots

$g->set_x_labels( $dateArray );
//$g->set_x_label_style( 10, '0x000000', 0, 1 );
$g->set_x_label_style( 10, '#000000', 2 );


$g->set_y_max( $ymaxrange );
$g->y_label_steps( 10 );
//$g->set_y_legend( 'Open Flash Chart', 12, '#736AFF' );
echo $g->render();
?>