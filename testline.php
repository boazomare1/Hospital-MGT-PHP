<?php

// generate some random data
srand((double)microtime()*1000000);

//
// NOTE: how we are filling 3 arrays full of data,
//       one for each line on the graph
//
$data_1 = array();
$data_2 = array();
$data_3 = array();
$w = array();
$x = array();
$y = array();

/*for( $i=0; $i<12; $i++ )
{
  $data_1[] = rand(14,19);
  $data_2[] = rand(8,13);
  $data_3[] = rand(1,7);
}*/

/*$data_1 = array(12,15);
$data_2 = array(14,18);
$data_3= array(11,19);
*/
$w=12;
$x=15;
$y=17;

$data_1 = array($w);
$data_2 = array($x);
$data_3= array($y);
print_r($data_1);


include_once( 'open-flash-chart-1.9.5/php-ofc-library/open-flash-chart.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_legend.php' );
include_once( 'open-flash-chart-1.9.5/php-ofc-library/ofc_x_axis.php' );
$g = new graph();
$g->title( 'Many data lines', '{font-size: 20px; color: #736AFF}' );

// we add 3 sets of data:
$g->set_data( $data_1 );
$g->set_data( $data_2 );
$g->set_data( $data_3 );

// we add the 3 line types and key labels
$g->line( 2, '0x9933CC', 'Page views', 10 );
$g->line_dot( 3, 5, '0xCC3399', 'Downloads', 10);    // <-- 3px thick + dots
$g->line_hollow( 2, 4, '0x80a033', 'Bounces', 10 );

$g->set_x_labels( array( 'January','February','March','April' ) );
$g->set_x_label_style( 10, '0x000000', 0, 2 );

$g->set_y_max( 20 );
$g->y_label_steps( 4 );
$g->set_y_legend( 'Open Flash Chart', 12, '#736AFF' );
echo $g->render();
?>