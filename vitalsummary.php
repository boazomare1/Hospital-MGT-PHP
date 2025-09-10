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
$transactiondatefrom = date('Y-m-d', strtotime('-1 year'));
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

<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<link href="autocomplete.css" rel="stylesheet">

<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/autocustomercodesearch2.js"></script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script> 
<script src="js/datetimepicker_css.js"></script>
    <script src="js/Chart.js"></script>


<script>

$(function() {
	
$('#customer').autocomplete({
		
	source:'ajaxcustomernewserach.php', 
	//alert(source);
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.id;
			var customercode = ui.item.customercode;
			var accountname = ui.item.accountname;
			$('#customercode').val(customercode);
			$('#accountnamename').val(accountname);
			$('#patientcode').val(customercode);
			
			//funcCustomerSearch2();
			
			},
    });
});

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
.loading-div{
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: rgba(0, 0, 0, 0.56);
	z-index: 999;
	display:none;
}
.loading-div img {
	margin-top: 20%;
	margin-left: 50%;
}
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
	
			<table width="80%" border="0" cellpadding="4" cellspacing="0" bordercolor="#666666" style="border-collapse: collapse">
			<form name="form1" id="form1" method="post" action="vitalsummary.php" onKeyDown="return disableEnterKey(event)" onSubmit="return process1()">
			<tr>
				<td width="1000">
					<table width="960" height="128" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" style="border-collapse: collapse">
					<tbody>
						<tr bgcolor="#011E6A">
							<td height="21" colspan="4" bgcolor="#ecf0f5" class="bodytext3">
								<strong> Vitals Summary </strong>
							</td>
						</tr>
						<tr bgcolor="#011E6A">     
               
							<td colspan="4" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation">
								<strong> 
									Search Sequence : First Name | Middle Name | Last Name | Date of Birth | Location | Mobile Number | National ID | Registration No   (*Use "|" symbol to skip sequence)
								</strong>
							</td>
						</tr>
						<tr>
							<td width="13%" height="32" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
								<strong> Patient Search </strong>
							</td>
							<td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
							<span class="bodytext32">
								<input name="customer" id="customer" size="60" autocomplete="off" value="<?php echo $patientname; ?>"/>
							    <input name="customerhiddentextbox" id="customerhiddentextbox" value="" type="hidden" />
								<input name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" type="hidden" />
								<input name="nationalid" id="nationalid" value = "" type = "hidden" />
								<input name="accountnames" id="accountnames" value="" type="hidden" />
								<input name = "mobilenumber111" id="mobilenumber111" value="" type="hidden" />
								<input type="hidden" name="recordstatus" id="recordstatus" />
								<input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>" readonly style="border: 1px solid #001E6A;" />
							</span>
							</td>
						</tr>
						<tr>
							<td height="32" align="left" valign="center" bgcolor="#ffffff" class="bodytext3">
								<strong> Date From </strong>
							</td>
							<td width="15%" align="left" valign="center"  bgcolor="#ffffff" class="bodytext3">
								<input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
								<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>
							</td>
							<td width="10%" align="left" valign="center"  bgcolor="#FFFFFF" class="style1">
								<span class="bodytext3"><strong> Date To </strong></span>
							</td>
							<td width="62%" align="left" valign="center"  bgcolor="#ffffff">
								<span class="bodytext3">
									<input name="ADate2" id="ADate2"  value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
									<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> 
								</span>
							</td>
						</tr>
						<tr>
							<td height="32" align="left" valign="center" bgcolor="#ffffff" class="bodytext3">&nbsp;</td>
							<td colspan="3" align="left" valign="center"  bgcolor="#ffffff" class="bodytext3">
								<input type="hidden" name="cbfrmflag1" value="cbfrmflag1" />
								<input  type="submit" value="Search" name="Submit" />
								<input name="resetbutton" type="reset" id="resetbutton" value="Reset" />
							</td>
						</tr>
					</tbody>
					</table>
				</td>
			</tr>	
			</form>		
			</table>
			
			<?php
				$colorloopcount=0;
				$sno=0;
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
					//$cbfrmflag1 = $_POST['cbfrmflag1'];
					if ($cbfrmflag1 == 'cbfrmflag1')
					{
						
						$searchpatient = $_POST['customer'];
						$searchpatientcode=$_REQUEST['patientcode'];
						$fromdate=$_POST['ADate1'];
						$todate=$_POST['ADate2'];
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
					<td colspan="3" class="bodytext3" nowrap="nowrap" align="center">
						<table width="800" border="0" cellpadding="4" cellspacing="0" bordercolor="#666666" style="border-collapse: collapse">
						<tr >
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center">&nbsp;  </td>						
							<td align="center" valign="middle" bgcolor="#FFFFF" colspan="3" class="bodytext3" >
								<strong > Blood Pressure </strong> 
							</td>
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center">&nbsp;  </td><td align="center" valign="middle" bgcolor="#FFFFF" colspan="2" class="bodytext3" >
								<strong > Pulse </strong>
							</td>
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center">&nbsp;  </td>							
							<td align="center" valign="middle" bgcolor="#FFFFF" colspan="2" class="bodytext3" >
								<strong > Temp </strong>
							</td>
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center">&nbsp;  </td>
							
							<td align="center" valign="middle" bgcolor="#FFFFF" colspan="2" class="bodytext3" >
								<strong > Weight </strong>
							</td>
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center">&nbsp;  </td>							
						</tr>
						<tr >
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center">&nbsp;  </td>						
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Date </strong>
							</td>
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Systolic </strong> 
							</td>
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Diastolic </strong>
							</td>
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center">&nbsp;  </td>
														
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Date </strong>
							</td>
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Pulse </strong>
							</td>
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center">&nbsp;  </td>
							
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Date </strong>
							</td>							
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Temp </strong>
							</td>
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center">&nbsp;  </td>							
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Date </strong>
							</td>
							<td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext3" >
								<strong > Weight </strong>
							</td>
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center">&nbsp;  </td>							
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
						//$exec1 = mysqli_query($query1) or die ("Error in Query1".mysqli_error());
						 $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1111".mysqli_error($GLOBALS["___mysqli_ston"]));

						$rescount = mysqli_num_rows($exec1);
					
						if($rescount > 0){
						while ($res1 = mysqli_fetch_array($exec1))
						{
							$visitcode = $res1['visitcode'];
							$visitdate = $res1['consultationdate'];				


								$query19="select * from master_triage where visitcode = '$visitcode'";
								 $exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1111".mysqli_error($GLOBALS["___mysqli_ston"]));

								$res19=mysqli_fetch_array($exec19);
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
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center">&nbsp;  </td>
							<td class="bodytext3" valign="center"  align="center">
								<?php echo $visitdate ; ?>
							</td>
							<td class="bodytext3" valign="center"  align="center">
								<?php echo $bpsystolic ; ?>
							</td>
							<td class="bodytext3" valign="center"  align="center">
								<?php echo $bpdiastolic ; ?>
							</td>
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center">&nbsp;  </td>
							<td class="bodytext3" valign="center"  align="center">
								<?php echo $visitdate ; ?>
							</td>
							<td class="bodytext3" valign="center"  align="center">
								<?php echo $pulse ; ?>
							</td>							
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center">&nbsp;  </td>
							<td class="bodytext3" valign="center"  align="center">
								<?php echo $visitdate ; ?>
							</td>
							<td class="bodytext3" valign="center"  align="center">
								<?php echo $celsius ; ?>
							</td>
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center">&nbsp;  </td>
							<td class="bodytext3" valign="middle" align="center">
								<?php echo $visitdate ; ?>
							</td>
							<td class="bodytext3" valign="middle" align="center">
								<?php echo $weight ; ?>
							</td>							
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle"  align="center">&nbsp;  </td>
						</tr> 
						<?php 
						} 
						$query1 = "select * from master_visitentry where patientcode = '$searchpatientcode' and consultationdate between '$fromdate' and '$todate' order by consultationdate asc";
						 $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1111".mysqli_error($GLOBALS["___mysqli_ston"]));


						while ($res1 = mysqli_fetch_array($exec1))
						{
							$visitcode = $res1['visitcode'];
							$visitdate = $res1['consultationdate'];				


								$query19="select * from master_triage where visitcode = '$visitcode'";
								$exec19=mysqlii_query($query19);
								$res19=mysqlii_fetch_array($exec19);
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
							<td class="bodytext3" bgcolor="#FFFFF" valign="middle" colspan="14" align="center"> &nbsp;  &nbsp;</td>						
						</tr>
						</table>
					</td>
				</tr>
                
				<tr >
					<td colspan="3" class="bodytext3" >
						<div class="loading-div"><img src="ajax-loader.gif" ></div>
					</td>
				</tr>
				
				<tr id="rowchart" >
					<td colspan="3" class="bodytext3" nowrap="nowrap">
						<table width="1200" border="0" cellpadding="4" cellspacing="0" bordercolor="#666666" style="border-collapse: collapse">
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