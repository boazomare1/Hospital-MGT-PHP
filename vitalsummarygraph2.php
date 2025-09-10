<?php 
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");
?>
<html>

<head>
    <title>Vital Summary Graph</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <style>
    #canvas-holder1 {
		float:right;
        width: 48%;
        margin: 20px 10px;
    }
    #canvas-holder2 {
		float:left;
        width: 48%;
        margin: 20px 10px;
    }
    #chartjs-tooltip {
        opacity: 1;
        position: absolute;
        background: rgba(0, 0, 0, .7);
        color: white;
        padding: 3px;
        border-radius: 3px;
        -webkit-transition: all .1s ease;
        transition: all .1s ease;
        pointer-events: none;
        -webkit-transform: translate(-50%, 0);
        transform: translate(-50%, 0);
    }
   	.chartjs-tooltip-key{
   		display:inline-block;
   		width:10px;
   		height:10px;
   	}
	.square {
	  float: left;
	  width: 10px;
	  height: 10px;
	  margin: 5px;
	  border: 1px solid rgba(0, 0, 0, .2);
	}
	.pulse {
	  background: #24ad18;
	}

	.sys {
	  background: #ff8119;
	}

	.dias {
	  background: #ffb900;
	}	
    </style>
   
</head>

<body>
     <div>
		<div id="canvas-holder2">
			<canvas id="linechart" width="300" height="150" /></canvas>
			
			</div>

		<div id="canvas-holder1">
			<canvas id="barchart" height="300" width="150"></canvas>
			
		</div>
		 
	
 
	</div>   

<?php
$visdate=array();
$sysar=array();
$diaar=array();
$pulsear=array();
$celar =array();
$barbrd = array();
$barbg = array();
$searchpatientcode = $_REQUEST['patientcode'];
$fromdate = $_REQUEST['fromdate'];
$todate = $_REQUEST['todate'];
$query1 = "select * from master_visitentry where patientcode = '$searchpatientcode' and consultationdate between '$fromdate' and '$todate' order by auto_number desc";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
							$visitcode = $res1['visitcode'];
							$visitdate = $res1['consultationdate'];				


								$query19="select bpsystolic,bpdiastolic,pulse,celsius from master_triage where visitcode = '$visitcode'";
								$exec19=mysql_query($query19);
								$res19=mysql_fetch_array($exec19);
								$bpsystolic = $res19['bpsystolic'];
								$bpdiastolic = $res19['bpdiastolic'];
								$pulse = $res19['pulse'];
								$celsius = $res19['celsius'];
								array_push($visdate,$visitdate);
								array_push($sysar,$bpsystolic);
								array_push($diaar,$bpdiastolic);
								array_push($pulsear,$pulse);
								array_push($celar,$celsius);
								if($celsius > 38.00)
								{
									array_push($barbrd,'rgba(255, 0, 0,0.3)');
									array_push($barbg,'rgba(255, 0, 0,1)');
								}
								else
								{
									array_push($barbrd,'rgba(255, 129, 25,0.3)');
									array_push($barbg,'rgba(255, 129, 25,1)');
									
								}
								
						}
						$visdtst = '"'.implode('","',$visdate).'"';
						$sysst = '"'.implode('","',$sysar).'"';
						$diast = '"'.implode('","',$diaar).'"';
						$pulsest = '"'.implode('","',$pulsear).'"';
						$celst = '"'.implode('","',$celar).'"';
						$brdst = "'".implode("','",$barbrd)."'";
						$bgst = "'".implode("','",$barbg)."'";
								?>
<script>
var ctx = document.getElementById("barchart");
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?=$visdtst?>],
        datasets: [{
            label: 'Temp',
            data: [<?=$celst?>],
            backgroundColor: [<?=$bgst?>],
                
            borderColor: [<?=$brdst?>],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
					suggestedMin: 32,
					steps: 20,
                    stepValue: .5,
                    max: 42,
                    beginAtZero:false
                }
            }]
        },
		responsive : true,
			maintainAspectRatio: false,
		title:{
                    display:true,
                    text:'Temp Graph'
                },
			
	},
});
var ctx = document.getElementById("linechart");
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [<?=$visdtst?>],
        datasets: [{
            label: 'Systolic',
            data: [<?=$sysst?>],
            backgroundColor: 'rgba(255, 99, 132, 0)',
            borderColor:'rgba(255, 129, 25,1)' ,
            borderWidth: 2
        },{
            label: 'Diastolic',
            data: [<?=$diast?>],
            backgroundColor: 'rgba(255, 99, 132, 0)',
            borderColor: 'rgba(255,185,0,1)',
            borderWidth: 2
        },{
            label: 'Pulse',
			backgroundColor: "rgba(0,255,0,0)",
            borderColor: "rgba(36,173,24,1)",
            pointColor: "rgba(36,173,24,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: [<?=$pulsest?>],
            borderWidth: 2
        },
		]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
					suggestedMin: 0,
					stepValue: 20,
					steps: 10,
                    beginAtZero:true,
					max: 200
                }
            }]
        },
		tooltips: {
                    mode: 'index',
                    intersect: false,
                },
		responsive: true,
                title:{
                    display:true,
                    text:'Bloodpressure , Pulse Graph'
                },
    }
});
</script>
</body>

</html>
