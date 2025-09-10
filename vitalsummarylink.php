<?php 
session_start();
error_reporting(E_ERROR | E_PARSE);
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");

$errmsg = "";
$bgcolorcode = "";
$pagename = "";
$consultationfees1 = '';
$availablelimit = '';
$mrdno = '';
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-10 year'));
$transactiondateto = date('Y-m-d');
$sno = '';


?>
<style type="text/css">

body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.ui-menu .ui-menu-item{ zoom:1 !important; }
</style>
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
	  width: 5px;
	  height: 5px;
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

<script src="js/jquery-ui.min.js"></script>
<script src="js/Chart.js"></script> 

<script>

$(document).ready(function(){


var cntval = $('#showcnt').val();
if(cntval=='0'){
$('#rowchart').hide();
}else{
$('#rowchart').show();
}


});

</script>



<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.style1 {font-weight: bold}
.style2 {font-weight: bold}
.style3 {font-weight: bold}
.style4 {font-weight: bold}
-->

</style>
<body >
</script>

<table width="101%" border="0" cellspacing="0" cellpadding="2">
	<tr>
		<td colspan="3" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
	</tr>
	<tr>
		<td colspan="3" bgcolor="#ECF0F5"><?php include ("includes/title1.php"); ?></td>
	</tr>
	<tr>
		<td colspan="3" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); //	include ("includes/menu2.php");?></td>
	</tr>
	<tr>
		<td width="1%">&nbsp;</td>
		<td colspan="2" width="99%" valign="top">
			<?php
				$colorloopcount=0;
				$sno=0;
				

				if (isset($_REQUEST["patientcode"])) { $searchpatientcode = $_REQUEST["patientcode"]; } else { $searchpatientcode = ""; }
					//$cbfrmflag1 = $_POST['cbfrmflag1'];
					if ($searchpatientcode !="")
					{
						
						

						$searchpatientcode = $_REQUEST['patientcode'];
						$fromdate = $transactiondatefrom;
						$todate = $transactiondateto;
						$query1 = "select customerfullname from master_customer where customercode ='$searchpatientcode' and status <> 'Deleted' ";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$res1 = mysql_fetch_array($exec1);
						$searchpatient = $res1['customerfullname'];

			?>
			<table width="800" border="0" cellpadding="4" cellspacing="0" bordercolor="#666666" style="border-collapse: collapse">
                <tr>
					<td colspan="3" class="bodytext3" nowrap="nowrap">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="3" class="bodytext3" bgcolor="#ecf0f5" nowrap="nowrap">
						<div align="left">
							<strong>Vitals Summary Details &nbsp;&nbsp;( <?php echo 'From '.$fromdate.'- To '.$todate; ?> )</strong>
						</div>
					</td>
				</tr>
				<tr>
				    <td class="bodytext3" colspan="2">
						<div align="center">
							<span class="style4">
								<?php	echo $searchpatient.' - '.$searchpatientcode; ?>
							</span>					
						</div>					
					</td>
					<td width="77">&nbsp;</td>
                </tr>

				<tr>
					<td colspan="3" class="bodytext3" nowrap="nowrap" valign="middle" align="center" >
						<table width="800" border="0" cellpadding="4" cellspacing="0" bordercolor="#666666" style="border-collapse: collapse">
						<tr >
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center"> &nbsp; </td>						
							<td align="center" valign="middle" bgcolor="#FFFFF" colspan="3" class="bodytext3" >
								<strong > Blood Pressure </strong> 
							</td>
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center"> &nbsp; </td><td align="center" valign="middle" bgcolor="#FFFFF" colspan="2" class="bodytext3" >
								<strong > Pulse </strong>
							</td>
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center"> &nbsp; </td>							
							<td align="center" valign="middle" bgcolor="#FFFFF" colspan="2" class="bodytext3" >
								<strong > Temp </strong>
							</td>
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center"> &nbsp; </td>
							
							<td align="center" valign="middle" bgcolor="#FFFFF" colspan="2" class="bodytext3" >
								<strong > Weight </strong>
							</td>
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center"> &nbsp; </td>							
						</tr>
						<tr >
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center"> &nbsp; </td>						
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Date </strong>
							</td>
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Systolic </strong> 
							</td>
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Diastolic </strong>
							</td>
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center"> &nbsp; </td>
														
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Date </strong>
							</td>
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Pulse </strong>
							</td>
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center"> &nbsp; </td>
							
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Date </strong>
							</td>							
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Temp </strong>
							</td>
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center"> &nbsp; </td>							
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Date </strong>
							</td>
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Weight </strong>
							</td>
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center"> &nbsp; </td>							
						</tr>
					<?php
						$visdate=array();
						$sysar=array();
						$diaar=array();
						$pulsear=array();
						$celar =array();
						$weist = array();	
						$barbrd = array();
						$barbg = array();
												
						$visitcode = '';
						$query1 = "select * from master_visitentry where patientcode = '$searchpatientcode' and consultationdate between '$fromdate' and '$todate' order by auto_number desc";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$rescount = mysql_num_rows($exec1);
					
						if($rescount > 0){
						while ($res1 = mysql_fetch_array($exec1))
						{
							$visitcode = $res1['visitcode'];
							$visitdate = $res1['consultationdate'];				


								$query19="select * from master_triage where visitcode = '$visitcode'";
								$exec19=mysql_query($query19);
								$res19=mysql_fetch_array($exec19);
								$user = $res19['user'];
								$height = $res19['height'];
								$weight = $res19['weight'];
								$bmi = $res19['bmi'];
								$bpsystolic = $res19['bpsystolic'];
								$bpdiastolic = $res19['bpdiastolic'];
								$respiration = $res19['respiration'];
								$pulse = $res19['pulse'];
								$celsius = $res19['celsius'];
								$spo2 = $res19['spo2'];
								$intdrugs = $res19['intdrugs'];
								$dose = $res19['dose'];
								$route = $res19['route'];
								
								$colorloopcount = $colorloopcount + 1;
								$showcolor = ($colorloopcount & 1); 
								if ($showcolor == 0)
								{
									//echo "if";
									$colorcode = 'bgcolor="#FFFFFF"';
								}
								else
								{
									//echo "else";
									$colorcode = 'bgcolor="#FFFFFF"';
								}
					?>
					
						<tr >
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center"> &nbsp; </td>
							<td class="bodytext3" valign="center"  align="center">
								<?php echo $visitdate ; ?>
							</td>
							<td class="bodytext3" valign="center"  align="center">
								<?php echo $bpsystolic ; ?>
							</td>
							<td class="bodytext3" valign="center"  align="center">
								<?php echo $bpdiastolic ; ?>
							</td>
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center"> &nbsp; </td>
							<td class="bodytext3" valign="center"  align="center">
								<?php echo $visitdate ; ?>
							</td>
							<td class="bodytext3" valign="center"  align="center">
								<?php echo $pulse ; ?>
							</td>							
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center"> &nbsp; </td>
							<td class="bodytext3" valign="center"  align="center">
								<?php echo $visitdate ; ?>
							</td>
							<td class="bodytext3" valign="center"  align="center">
								<?php echo $celsius ; ?>
							</td>
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center"> &nbsp; </td>
							<td class="bodytext3" valign="middle" align="center">
								<?php echo $visitdate ; ?>
							</td>
							<td class="bodytext3" valign="middle" align="center">
								<?php echo $weight ; ?>
							</td>							
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center"> &nbsp; </td>
						</tr> 
					<?php 
					
						} 
						$query1 = "select * from master_visitentry where patientcode = '$searchpatientcode' and consultationdate between '$fromdate' and '$todate' order by consultationdate asc";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());

						while ($res1 = mysql_fetch_array($exec1))
						{
							$visitcode = $res1['visitcode'];
							$visitdate = $res1['consultationdate'];				


								$query19="select * from master_triage where visitcode = '$visitcode'";
								$exec19=mysql_query($query19);
								$res19=mysql_fetch_array($exec19);
								$user = $res19['user'];
								$height = $res19['height'];
								$weight = $res19['weight'];
								$bmi = $res19['bmi'];
								$bpsystolic = $res19['bpsystolic'];
								$bpdiastolic = $res19['bpdiastolic'];
								$respiration = $res19['respiration'];
								$pulse = $res19['pulse'];
								$celsius = $res19['celsius'];
								$spo2 = $res19['spo2'];
								$intdrugs = $res19['intdrugs'];
								$dose = $res19['dose'];
								$route = $res19['route'];

								array_push($visdate,$visitdate);
								array_push($sysar,$bpsystolic);
								array_push($diaar,$bpdiastolic);
								array_push($pulsear,$pulse);
								array_push($celar,$celsius);
								array_push($weilar,$weight);
								if($celsius > 38.00)
								{
									array_push($barbrd,'rgba(255, 0, 0,0.2)');
									array_push($barbg,'rgba(255, 0, 0,1)');
								}
								else
								{
									array_push($barbrd,'rgba(255, 129, 25,0.2)');
									array_push($barbg,'rgba(255, 129, 25,1)');
									
								}	
							} 						
						$visdtst = '"'.implode('","',$visdate).'"';
						$sysst = '"'.implode('","',$sysar).'"';
						$diast = '"'.implode('","',$diaar).'"';
						$pulsest = '"'.implode('","',$pulsear).'"';
						$celst = '"'.implode('","',$celar).'"';	
						$weist = '"'.implode('","',$weilar).'"';	
						$brdst = "'".implode("','",$barbrd)."'";
						$bgst = "'".implode("','",$barbg)."'";							
					?>
						<input type="hidden" id="showcnt" value="1">
					<?php	
						}else{
					?>
							<tr >
								<td colspan="14" align="center" valign="middle" bgcolor="#FFFFFF" class="bodytext3" >
									<font color="#f93635" ><b> ------ No Records Available ------ </b></font>
								</td>
							</tr>

						<input type="hidden" id="showcnt" value="0">
					<?php 
						}		
					?>	
						<tr>
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle" colspan="14" align="center"> &nbsp; <div class="loader" id="loading" ></div> &nbsp;</td>						
						</tr>
						</table>
					</td>
				</tr>

				<tr id="rowchart" >
					<td colspan="3" class="bodytext3" nowrap="nowrap">
						<table width="1300" border="0" cellpadding="4" cellspacing="0" bordercolor="#666666" style="border-collapse: collapse">
						<tr >
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center"> 
     <div>
		<div id="canvas-holder2">
			<canvas id="linechart" width="300" height="150" /></canvas>
			
			</div>

		<div id="canvas-holder1">
			<canvas id="barchart" height="300" width="150"></canvas>
			
		</div>
		 
	
 
	</div> 
							</td>
						</tr>
						</table>
					</td>
				</tr>								
				<tr>				
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>
			<?php
					}
			?> 
		</td>
	</tr>
</table>	

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
            backgroundColor: 'rgba(0, 0, 255, 0)',
            borderColor: 'rgba(0,0,255,1)',
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
<?php include ("includes/footer1.php"); ?>
</body>
</html>