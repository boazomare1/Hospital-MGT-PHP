<?php 
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");
?>
<html>

<head>
    <title>Vital Summary Graph</title>
    <script src="js/Chart.js"></script>
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
			<div align="center"><table> <tr> <td > <strong>Systolic  </strong></td><td class="square sys"> </td><td > <strong>Diastolic  </strong></td><td class="square dias"> </td> <td > <strong> Pulse </strong> </td><td class="square pulse"> </td> </tr></table> <strong>Bloodpressure , Pulse Graph </strong> </div>
			<div>	
			</div>
		</div>

		<div id="canvas-holder1">
			<canvas id="barchart" height="300" width="150"></canvas>
			<div align="center"> <strong>Temp Graph </strong> </div> 
		</div>
		 
		<div id="chartjs-tooltip"></div>
 
	</div>
<?php
$visdate=array();
$sysar=array();
$diaar=array();
$pulsear=array();
$celar =array();
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
						}
						$visdtst = '"'.implode('","',$visdate).'"';
						$sysst = '"'.implode('","',$sysar).'"';
						$diast = '"'.implode('","',$diaar).'"';
						$pulsest = '"'.implode('","',$pulsear).'"';
						$celst = '"'.implode('","',$celar).'"';
								?>
    <script>

    Chart.defaults.global.pointHitDetectionRadius = 1;
    Chart.defaults.global.customTooltips = function(tooltip) {

        var tooltipEl = $('#chartjs-tooltip');

        if (!tooltip) {
            tooltipEl.css({
                opacity: 0
            });
            return;
        }

        tooltipEl.removeClass('above below');
        tooltipEl.addClass(tooltip.yAlign);

        var innerHtml = '';
        for (var i = tooltip.labels.length - 1; i >= 0; i--) {
        	innerHtml += [
        		'<div class="chartjs-tooltip-section">',
        		'	<span class="chartjs-tooltip-key" style="background-color:' + tooltip.legendColors[i].fill + '"></span>',
        		'	<span class="chartjs-tooltip-value">' + tooltip.labels[i] + '</span>',
        		'</div>'
        	].join('');
        }
        tooltipEl.html(innerHtml);

        tooltipEl.css({
            opacity: 1,
            left: tooltip.chart.canvas.offsetLeft + tooltip.x + 'px',
            top: tooltip.chart.canvas.offsetTop + tooltip.y + 'px',
            fontFamily: tooltip.fontFamily,
            fontSize: tooltip.fontSize,
            fontStyle: tooltip.fontStyle,
        });
    };
    var lineChartData = {
        labels: [<?=$visdtst?>],
        datasets: [{
            label: "Systolic",
            fillColor: "rgba(255, 129, 25,0)",
            strokeColor: "rgba(255, 129, 25,1)",
            pointColor: "rgba(255, 129, 25,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: [<?=$sysst?>]
        }, {
            label: "Diastolic",
            fillColor: "rgba(255,185,0,0)",
            strokeColor: "rgba(255,185,0,1)",
            pointColor: "rgba(255,185,0,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: [<?=$diast?>]
        }, {
            label: "Pulse",
            fillColor: "rgba(0,255,0,0)",
            strokeColor: "rgba(36,173,24,1)",
            pointColor: "rgba(36,173,24,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: [<?=$pulsest?>]
        }]
    };
	var barChartData = {
		labels : [<?=$visdtst?>],
		datasets : [
			{
				fillColor : "rgba(255, 129, 25,0.5)",
				strokeColor : "rgba(255, 129, 25,0.8)",
				highlightFill: "rgba(255, 129, 25,0.75)",
				highlightStroke: "rgba(255, 129, 25,1)",
				data : [<?=$celst?>]
			},
			{
				fillColor : "rgba(255, 129, 25,0.5)",
				strokeColor : "rgba(255, 129, 25,0.8)",
				highlightFill: "rgba(255, 129, 25,0.75)",
				highlightStroke: "rgba(255, 129, 25,1)",
				data : []
			}
		]

	};
    window.onload = function() {
                var ctx2 = document.getElementById("linechart").getContext("2d");
        window.myLine = new Chart(ctx2).Line(lineChartData, {
			 responsive: true,
			  scaleOverride : true,
          scaleSteps : 10,
          scaleStepWidth :20,
          scaleStartValue : 0,

        });
		var ctx = document.getElementById("barchart").getContext("2d");
		window.myBar = new Chart(ctx).Bar(barChartData, {
			responsive : true,
			maintainAspectRatio: false,
			scaleOverride : true,
          scaleSteps : 14,
          scaleStepWidth :.5,
          scaleStartValue : 34,
		});
    };
    </script>
</body>

</html>
