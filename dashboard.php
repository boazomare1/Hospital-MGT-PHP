<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');

$colorloopcount = '';
$snocount = '';


?>


<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>


<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>

<style>
	canvas {
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
	.chart-container {
		width: 500px;
		margin-left: 10px;
		margin-right: 40px;
		margin-bottom: 40px;
	}
	#loadingMessage{
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }
	.container {
		display: flex;
		flex-direction: row;
		flex-wrap: wrap;
		justify-content: center;
		MARGIN: -12PX -50PX 0PX 0PX;
	}
	</style>
<script type="text/javascript" src="js/jquery-1.4.2.js"></script>
<script src="js/Chart.min.js"></script>
</head>



<body>
<table width="1365" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="99%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="bodytext32" align='center'> <h2>Dashboard</h2>
		</td>
	  </tr>
      <tr>
        <td>
      
    <div class="container">
	 <div id="loadingMessage"></div> 

     <div id="chart-container" style="width:40%;">
        <canvas id="graphCanvas"></canvas>
    </div>
	<div id="chart-container-opcash" style="width:40%;margin-left: 20px;">
        <canvas id="graphCanvas-opcash"></canvas>
    </div>
	<div id="chart-container-ipadmission" style="width:40%;margin-top: 15px;">
        <canvas id="graphCanvas-ipadmission"></canvas>
    </div>
	<div id="chart-container-beddoc" style="width:40%;margin-left: 20px;margin-top: 15px;">
        <canvas id="graphCanvas-bedocc"></canvas>
    </div>
	<div id="chart-container-radiology" style="width:40%;margin-top: 15px;">
        <canvas id="graphCanvas-radiology"></canvas>
    </div>
	<div id="chart-container-lab" style="width:40%;margin-left: 20px;margin-top: 15px;">
        <canvas id="graphCanvas-lab"></canvas>
    </div>
	<div id="chart-container-pharma" style="width:40%;margin-top: 15px;">
        <canvas id="graphCanvas-pharma"></canvas>
    </div>
   </div>

   <script>
        $(document).ready(function () {
            showGraph();
        });


        function showGraph()
        {
			    $("#loadingMessage").html('<img src="images/load.gif" alt="" srcset="" width="100px">');
                
                $.post("chartdata.php?from=opvisit",
                function (data)
                {
					$("#loadingMessage").html("");
                    var opdate = [];
                    var cnt = [];

                    for (var i in data) {
                        opdate.push(data[i].billdate);
                        cnt.push(data[i].count);
                    }
                   
                    var chartdata = {
                        labels: opdate,
						
                        datasets: [
                            {
                                label: 'OP Visits',
                                backgroundColor: '#6e6e05',
                                borderColor: '#c7c728',
                                hoverBackgroundColor: '#ecf0f5',
                                hoverBorderColor: '#666666',
                                data: cnt,
								fill: false,
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'line',
                        data: chartdata,
						options: {
							responsive: true
							
						}
                    });
                });

				$.post("chartdata.php?from=opcash",
                function (data)
                {
                    var opdate = [];
                    var cnt = [];
					var ipdate = [];
                    var ipcnt = [];

                    for (var i in data['op']) {
                        opdate.push(data['op'][i].billdate);
						var tot=parseFloat(data['op'][i].count);
						tot=tot.toFixed(2);
                        cnt.push(tot);
                    }

					for (var i in data['ip']) {
                        ipdate.push(data['ip'][i].billdate);
						var tot=parseFloat(data['ip'][i].count);
						tot=tot.toFixed(2)
                        ipcnt.push(tot);
                    }
                    var chartdata = {
                        labels: opdate,
						
                        datasets: [
                            {
                                label: 'OP Cash',
                                backgroundColor: '#7a0d1c',
                                borderColor: '#f07586',
                                hoverBackgroundColor: '#ecf0f5',
                                hoverBorderColor: '#666666',
                                data: cnt,
								fill: false,
                            },
							 {
                                label: 'IP Cash',
                                backgroundColor: '#280569',
                                borderColor: '#a075f0',
                                hoverBackgroundColor: '#ecf0f5',
                                hoverBorderColor: '#666666',
                                data: ipcnt,
								fill: false,
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas-opcash");

                    var barGraph = new Chart(graphTarget, {
                        type: 'line',
                        data: chartdata,
						options: {
							responsive: true
							
						}
                    });
                });


			 $.post("chartdata.php?from=ipvisit",
                function (data)
                {
                    var opdate = [];
                    var cnt = [];

                    for (var i in data) {
                        opdate.push(data[i].billdate);
                        cnt.push(data[i].count);
                    }
                   
                    var chartdata = {
                        labels: opdate,
						
                        datasets: [
                            {
                                label: 'IP Admissions',
                                backgroundColor: '#096929',
                                borderColor: '#03fc56',
                                hoverBackgroundColor: '#ecf0f5',
                                hoverBorderColor: '#666666',
                                data: cnt,
								fill: false,
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas-ipadmission");

                    var barGraph = new Chart(graphTarget, {
                        type: 'line',
                        data: chartdata,
						options: {
							responsive: true
							
						}
                    });
                });

			$.post("chartdata.php?from=bedocc",
                function (data)
                {
				    
                    var opdate = [];
                    var cnt = [];

                    for (var i in data) {
                        opdate.push(data[i].billdate);
                        cnt.push(data[i].count);
                    }
                   
                    var chartdata = {
                        labels: opdate,
						
                        datasets: [
                            {
                                label: 'Bed Occupancy',
                                backgroundColor: '#bdaeac',
                                borderColor: '#524c4b',
                                hoverBackgroundColor: '#ecf0f5',
                                hoverBorderColor: '#666666',
                                data: cnt,
								fill: false,
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas-bedocc");

                    var barGraph = new Chart(graphTarget, {
                        type: 'line',
                        data: chartdata,
						options: {
							responsive: true
							
						}
                    });
                });

			 $.post("chartdata.php?from=radiology",
                function (data)
                {
				    
                    var opdate = [];
                    var cnt = [];

                    for (var i in data) {
                        opdate.push(data[i].billdate);
                        cnt.push(data[i].count);
                    }
                   
                    var chartdata = {
                        labels: opdate,
						
                        datasets: [
                            {
                                label: 'Radiology',
                                backgroundColor: '#96e1f2',
                                borderColor: '#4d7f8a',
                                hoverBackgroundColor: '#ecf0f5',
                                hoverBorderColor: '#666666',
                                data: cnt,
								fill: false,
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas-radiology");

                    var barGraph = new Chart(graphTarget, {
                        type: 'line',
                        data: chartdata,
						options: {
							responsive: true
							
						}
                    });
                });

			$.post("chartdata.php?from=lab",
                function (data)
                {
				    
                    var opdate = [];
                    var cnt = [];

                    for (var i in data) {
                        opdate.push(data[i].billdate);
                        cnt.push(data[i].count);
                    }
                   
                    var chartdata = {
                        labels: opdate,
						
                        datasets: [
                            {
                                label: 'Lab',
                                backgroundColor: '#f272d6',
                                borderColor: '#8c5b82',
                                hoverBackgroundColor: '#ecf0f5',
                                hoverBorderColor: '#666666',
                                data: cnt,
								fill: false,
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas-lab");

                    var barGraph = new Chart(graphTarget, {
                        type: 'line',
                        data: chartdata,
						options: {
							responsive: true
							
						}
                    });
                });

				$.post("chartdata.php?from=pharma",
                function (data)
                {
				    
                    var opdate = [];
                    var cnt = [];

                    for (var i in data) {
                        opdate.push(data[i].billdate);
                        cnt.push(data[i].count);
                    }
                   
                    var chartdata = {
                        labels: opdate,
						
                        datasets: [
                            {
                                label: 'Pharmacy',
                                backgroundColor: '#edf505',
                                borderColor: '#afb505',
                                hoverBackgroundColor: '#ecf0f5',
                                hoverBorderColor: '#666666',
                                data: cnt,
								fill: false,
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas-pharma");

                    var barGraph = new Chart(graphTarget, {
                        type: 'line',
                        data: chartdata,
						options: {
							responsive: true
							
						}
                    });
                });
        }
        </script>
	  </td>
    </tr>
	</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

