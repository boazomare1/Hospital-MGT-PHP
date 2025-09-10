<?php
session_start();
include ("db/db_connect.php");
$data = array();
$billingdatetime = array();

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
  
  foreach($dateArray as $date){
	
	  $query2 = "select registrationdate,count(*) as dd FROM master_ipvisitentry where registrationdate = '$date' "; 
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res2 = mysqli_fetch_array($exec2))
		{  
		 $registrationdate1[]= $res2['dd'];
	    }
   }
print_r($registrationdate1);  

// use the chart class to build the chart:
include_once( 'open-flash-chart-1.9.5/php-ofc-library/open-flash-chart.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_legend.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_axis.php' );

//$ymaxrange = ceil(max($data));
//$yminrange = ceil(min($data));
//$xy = $ymaxrange + $yminrange;

$g = new graph();
$g->title( 'IP Visit','{font-size: 20px;}' );

$g->bg_colour = '0xFFFFFF';
$g->bar_filled(55, '#D54C78', '#C31812',1);

//$g->title( 'Sin + 1.5', '{font-size: 12px;}' );

//$g->set_x_legend( 'Date' );
//$g->set_x_tick_size(5);
$g->set_data( $registrationdate1 );
$g->set_x_labels( $dateArray );
//$x_labels->set_colour( '#A2ACBA' );

$g->set_x_label_style( 12, '#000000', 2 );

$g->set_y_max( 30 );
$g->y_label_steps( 10 );
//$g->set_y_legend( 'Open Flash Chart', 12, '#736AFF' );
// display the data
echo $g->render();
?>
