<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cost Center Report</title>
<!-- Modern CSS -->
<link href="css/costcenterreport-modern.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<link href="css/three.css" rel="stylesheet" type="text/css">
<!-- Modern JavaScript -->
<script type="text/javascript" src="js/costcenterreport-modern.js?v=<?php echo time(); ?>"></script>
</head>

<body>

<header>
  <?php include ("includes/alertmessages1.php"); ?>
  <?php include ("includes/title1.php"); ?>
  <?php include ("includes/menu1.php"); ?>
</header>

<main class="main-container">
<?php



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');

$totalnetprofit=0;

$searchsuppliername = "";

$res1username = '';

$res2username = '';

$res3username = '';

$res4username = '';

$res5username = '';

$res6username = '';

$res7username = '';


$transactiondatefrom = date('Y-m-01');
$transactiondateto = date('Y-m-d');


ini_set('max_execution_time', 300);

if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('m'); }
if (isset($_REQUEST["searchquarter"])) { $searchquarter = $_REQUEST["searchquarter"]; } else { $searchquarter = ""; }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = ""; }
if (isset($_REQUEST["searchyear1"])) { $searchyear1 = $_REQUEST["searchyear1"]; } else { $searchyear1 = ""; }
if (isset($_REQUEST["fromyear"])) { $fromyear = $_REQUEST["fromyear"]; } else { $fromyear = ""; }
if (isset($_REQUEST["toyear"])) { $toyear = $_REQUEST["toyear"]; } else { $toyear = ""; }
if (isset($_REQUEST["period"])) { $period = $_REQUEST["period"]; } else { $period = ""; }
	if (isset($_REQUEST["cc_name"])) { $cc_name = $_REQUEST["cc_name"]; } else { $cc_name = ""; }
	if (isset($_REQUEST["searchmonthto"])) { $searchmonthto = $_REQUEST["searchmonthto"]; } else { $searchmonthto = date('m'); }
	if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; $transactiondatefrom = $_REQUEST["ADate1"];  } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; $transactiondateto = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }



?>

<style type="text/css">
.bodytext31:hover { font-size:14px; }

.btn {
    background-color: rgba(0, 255, 0, 0.4);
    display: inline-block;
    zoom: 1;
    line-height: normal;
    white-space: nowrap;
    vertical-align: baseline;
    text-align: center;
    cursor: pointer;
    FONT-WEIGHT: normal;
    font-family: Tahoma;
    font-size: 11px;
    padding: .5em .9em .5em 1em;
    text-decoration: none;
    border-radius: 4px;
    text-shadow: 0 1px 1px rgba(0, 0, 0, .2);
}

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

-->




</style>

<!-- Modern CSS -->
<link href="costcenterreport.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link href="css/autocomplete.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>

<script type="text/javascript">

function disableEnterKey(varPassed)
{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

	

	var key;

	if(window.event)

	{

		key = window.event.keyCode;     //IE

	}

	else

	{

		key = e.which;     //firefox

	}



	if(key == 13) // if enter key press

	{

		//alert ("Enter Key Press2");

		return false;

	}

	else

	{

		return true;

	}

}

function process1backkeypress1()
{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

}

function disableEnterKey()
{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

	

	var key;

	if(window.event)

	{

		key = window.event.keyCode;     //IE

	}

	else

	{

		key = e.which;     //firefox

	}

	

	if(key == 13) // if enter key press

	{

		return false; 

	}

	else

	{

		return true;

	}



}

function valid()
{
	if(document.getElementById('cc_name').value =='')
	{
		alert("Please Select Cost Center");
		return false;
	}
	if(document.getElementById('period1').value =='monthly')
	{
	
		if(document.getElementById('searchyear').value =='')
	    {
	
		alert("Please Select  Year");
		return false;
		}
	}
	
	if(document.getElementById('period1').value =='quarterly')
	{
	
		if(document.getElementById('searchquarter').value =='')
	    {
	
		alert("Please Select Quarter Range");
		return false;
		}
		if(document.getElementById('searchyear1').value =='')
	    {
	
		alert("Please Select Year");
		return false;
		}
	}
	
	
}

function funchangeperiod(id)
{
document.getElementById('dates range').style.display = 'none';
document.getElementById('monthly').style.display = 'none';
document.getElementById('monthly12').style.display = 'none';
document.getElementById('quarterly').style.display = 'none';
document.getElementById('yearly').style.display = 'none';
if(id != '' )
{
document.getElementById(id).style.display = '';
if(id=='monthly'){
document.getElementById('monthly12').style.display = '';
}
}
}


function exportExcel() {
  //alert('clicked custom button 1!');
  //var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#calendar').html()) 
  //location.href=url
  //return false
  var a = document.createElement('a');
    var a1 = document.getElementById('ADate1').value;
	  var a2 = document.getElementById('ADate2').value;
	  var cc_name1 = document.getElementById('costname').value;
	
  //getting data from our div that contains the HTML table
  var data_type = 'data:application/vnd.ms-excel';
  a.href = data_type + ', ' + encodeURIComponent($('#data').html());
  //setting the file name
 // ..a.download ='costcenter_.'a1'.xls';
 //alert(a1);
 //return false;
  a.download ='Cost Center'+'_'+'Cost Center'+'_'+cc_name1+'_'+a1+'_To_'+a2+'.xls';
  //triggering the function
  a.click();
  //just in case, prevent default behaviour
  e.preventDefault();
  return (a);
  /* end of excel function */
}

</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<script src="js/datetimepicker_css.js"></script>
<!-- Modern JavaScript -->
<script type="text/javascript" src="costcenterreport.js"></script>

</head>

<body>

<div class="report-header">
  <h1 class="report-title">Cost Center Financial Report</h1>
  <p class="report-subtitle">Comprehensive financial analysis and reporting by cost center</p>
</div>

<table width="101%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="10" class="alert-container"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" class="title-container"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" class="menu-container"><?php include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>

      &nbsp;</td>

    <td width="97%" valign="top">
    
    <div class="filter-container">
    <form name="frmsales" id="frmsales" method="post" action="costcenterreport.php" class="modern-form">
    <table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td>
        <!-- Form moved to parent level -->

          <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="4"  class="bodytext3"><strong>Cost Center</strong></td>

              </tr>

          

			   <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext31"><strong>Cost Cente</strong>r</td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

              <select id="cc_name" name="cc_name" >                           
                          <option value="" selected="selected" >Select Cost Center</option>                         
                          <?php
						$query1 = "select * from master_costcenter where recordstatus <> 'deleted' order by name";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1categoryname = $res1["name"];
						$res1categoryname = strtoupper($res1categoryname);
						$res1auto_number= $res1["auto_number"];
						
						?>
                          <option value="<?php echo $res1auto_number; ?>"<?php if($res1auto_number==$cc_name) echo 'selected'; ?>><?php echo $res1categoryname; ?></option>
                          <?php
						}
						?>
                        </select> 
	         </td>

              </tr>

				<tr id="period">
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Period </td>
                      <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><select name="period" id="period1" onChange="funchangeperiod(this.value);">
					  <?php  if($period != '') {  ?>
					<option value="<?php echo $period; ?>"><?php echo ucwords($period); ?></option>
					<?php  } else { ?>
					<option value="">Select Period</option>
					<?php } ?>
					<option value="dates range">Date range</option>
					  <option value="monthly">Monthly</option>
					  <option value="quarterly">Quarterly</option>
					   <option value="yearly">Yearly</option>
					  </select> </td>
                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> </td>
                    </tr>
					
					<tr id="monthly" style="display:none">
				
					<td width="131" class="bodytext31" valign="center"  align="left" bgcolor="#FFFFFF">From Month </td>
                      <td width="136" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
                        <select name="searchmonth" id="searchmonth">
                          <option <?php if($searchmonth == '1') { ?> selected = 'selected' <?php } ?> value="1">January</option>
                          <option <?php if($searchmonth == '2') { ?> selected = 'selected' <?php } ?> value="2">February</option>
                          <option <?php if($searchmonth == '3') { ?> selected = 'selected' <?php } ?> value="3">March</option>
                          <option <?php if($searchmonth == '4') { ?> selected = 'selected' <?php } ?> value="4">April</option>
                          <option <?php if($searchmonth == '5') { ?> selected = 'selected' <?php } ?> value="5">May</option>
                          <option <?php if($searchmonth == '6') { ?> selected = 'selected' <?php } ?> value="6">June</option>
                          <option <?php if($searchmonth == '7') { ?> selected = 'selected' <?php } ?> value="7">July</option>
                          <option <?php if($searchmonth == '8') { ?> selected = 'selected' <?php } ?> value="8">August</option>
                          <option <?php if($searchmonth == '9') { ?> selected = 'selected' <?php } ?> value="9">September</option>
                          <option <?php if($searchmonth == '10'){ ?> selected = 'selected' <?php } ?> value="10">October</option>
                          <option <?php if($searchmonth == '11'){ ?> selected = 'selected' <?php } ?> value="11">November</option>
                          <option <?php if($searchmonth == '12'){ ?> selected = 'selected' <?php } ?> value="12">December</option>
                        </select>
                      </td>		
					  <td width="76" class="bodytext31" valign="center"  align="left" bgcolor="#FFFFFF">To Month </td>
                      <td width="425" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
                        <select name="searchmonthto" id="searchmonthto">
                          <option <?php if($searchmonthto == '1') { ?> selected = 'selected' <?php } ?> value="1">January</option>
                          <option <?php if($searchmonthto == '2') { ?> selected = 'selected' <?php } ?> value="2">February</option>
                          <option <?php if($searchmonthto == '3') { ?> selected = 'selected' <?php } ?> value="3">March</option>
                          <option <?php if($searchmonthto == '4') { ?> selected = 'selected' <?php } ?> value="4">April</option>
                          <option <?php if($searchmonthto == '5') { ?> selected = 'selected' <?php } ?> value="5">May</option>
                          <option <?php if($searchmonthto == '6') { ?> selected = 'selected' <?php } ?> value="6">June</option>
                          <option <?php if($searchmonthto == '7') { ?> selected = 'selected' <?php } ?> value="7">July</option>
                          <option <?php if($searchmonthto == '8') { ?> selected = 'selected' <?php } ?> value="8">August</option>
                          <option <?php if($searchmonthto == '9') { ?> selected = 'selected' <?php } ?> value="9">September</option>
                          <option <?php if($searchmonthto == '10'){ ?> selected = 'selected' <?php } ?> value="10">October</option>
                          <option <?php if($searchmonthto == '11'){ ?> selected = 'selected' <?php } ?> value="11">November</option>
                          <option <?php if($searchmonthto == '12'){ ?> selected = 'selected' <?php } ?> value="12">December</option>
                        </select>
                      </td>
					  
					</tr>
					
					<tr id="monthly12" style="display:none">
                      <td  width="131" class="bodytext31" valign="center"  align="left"  bgcolor="#FFFFFF">Select Year </td>
                  <?php $years = range(2018, strftime("2025", time())); ?>
                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
                        <select name="searchyear" id="searchyear">
                          <?php if($searchyear != ''){ ?>
                              <option value="<?php echo $searchyear; ?>"><?php echo $searchyear; ?></option>
                          <?php } ?>
                          <option value="">Select Year</option>
                          <?php foreach($years as $year1) : ?>
                              <option value="<?php echo $year1; ?>"><?php echo $year1; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </td>
						
                  </tr>
					
					
					
					<tr id="quarterly" style="display:none">
					<td  width="136" align="left" bgcolor="#FFFFFF" class="bodytext3">Search Quarter</td>
                    <td width="131" align="left" bgcolor="#FFFFFF" class="bodytext3"><select name="searchquarter" id="searchquarter">
					<option value="">Quarter</option>

					<?php 
					$arrayquarter = ["Jan-Mar","Apr-Jun","Jul-Sep","Oct-Dec"];
					$quartercount = count($arrayquarter);
					for($i=0;$i<$quartercount;$i++)
					{
					 ?>
					<option value="<?php echo $i; ?>" <?php  if($searchquarter == $i && $searchquarter !='' ) { echo "selected"; }?>><?php echo $arrayquarter[$i]; ?></option>
					<?php 
					}
					 ?>
					</select></td>
					<td width="76" align="left" bgcolor="#FFFFFF" class="bodytext3">Search Year</td>
					<td width="425" align="left" bgcolor="#FFFFFF" class="bodytext3">
					
					 <select name="searchyear1" id="searchyear1">
                          <?php if($searchyear1 != ''){ ?>
                              <option value="<?php echo $searchyear1; ?>"><?php echo $searchyear1; ?></option>
                          <?php } ?>
                          <option value="">Select Year</option>
                          <?php foreach($years as $year1) : ?>
                              <option value="<?php echo $year1; ?>"><?php echo $year1; ?></option>
                          <?php endforeach; ?>
                        </select>
					
					
					
					
					</td>
                    </tr>
					
					<tr id="yearly" style="display:none">
					<td width="136" align="left" bgcolor="#FFFFFF" class="bodytext3">From Year</td>
                    <td width="131" align="left" bgcolor="#FFFFFF" class="bodytext3">				
					<select name="fromyear" id="fromyear">
                          <?php if($fromyear != ''){ ?>
                              <option value="<?php echo $fromyear; ?>"><?php echo $fromyear; ?></option>
                          <?php } ?>
                          <option value="">Select Year</option>
                          <?php foreach($years as $year1) : ?>
                              <option value="<?php echo $year1; ?>"><?php echo $year1; ?></option>
                          <?php endforeach; ?>
                        </select>				
					</td>
					<td width="76" align="left" bgcolor="#FFFFFF" class="bodytext3">To Year</td>
					<td width="425" align="left" bgcolor="#FFFFFF" class="bodytext3">					
					<select name="toyear" id="toyear">
                          <?php if($toyear != ''){ ?>
                              <option value="<?php echo $toyear; ?>"><?php echo $toyear; ?></option>
                          <?php } ?>
                          <option value="">Select Year</option>
                          <?php foreach($years as $year1) : ?>
                              <option value="<?php echo $year1; ?>"><?php echo $year1; ?></option>
                          <?php endforeach; ?>
                        </select>							
					</td>
                    </tr>
			
			        <tr id="dates range" style="display:none">

          <td width="136" align="left" valign="center"  

 class="bodytext31"><strong> Date From </strong></td>

          <td width="131" align="left" valign="center"   class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>

          <td width="76" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><strong> Date To </strong></td>

          <td width="425" align="left" valign="center"  >

            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>		  </td>

          </tr>

			   <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input  type="submit" value="Search" name="Submit" />

                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>

            </tr>

          </tbody>

        </table>

		</form></td>

        </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

	  <tr>
	  

        <td>

<?php

	$colorloopcount=0;

	$sno=0;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{
	$cc_name = $_POST['cc_name'];		
				/*if($period == 'monthly')
				{
				$month = $searchmonth;
				$month12 = $searchmonth;
				$year = $searchyear;
				$fromdate = date('Y-m-d',strtotime('01-'.$month.'-'.$year));
				$todate = date('Y-m-t',strtotime('last day of'.$searchmonthto.'-'.$year));
				}*/
				if($period == 'quarterly')
				{
				
				$stmonth = ($searchquarter*3)+1;
				$enmonth = ($searchquarter+1)*3;
				$fromdate = date('Y-m-d',strtotime('01-'.$stmonth.'-'.$searchyear1));
				$todate = date('Y-m-t',strtotime('01-'.$enmonth.'-'.$searchyear1));
				}
				/*elseif($period == 'yearly')
				{
				$fromdate = date('Y-m-d',strtotime('01-01-'.$fromyear));
				$todate = date('Y-m-t',strtotime('01-12-'.$toyear));
				}*/
				elseif($period == 'dates range')
				{
				$fromdate = $ADate1;
				$todate = $ADate2;
				}	
				
	$query612 = "select * from master_costcenter where auto_number = '$cc_name' and recordstatus <> 'deleted'";
		$exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res612 = mysqli_fetch_array($exec612);
		$res612cost_center = $res612['name'];
?>

<tr>             			  
<td  class="bodytext31" colspan="4" > <a href="costcenterreport_excel.php?period=<?=$period?>&&searchmonth=<?=$searchmonth?>&&searchmonthto=<?=$searchmonthto?>&&searchyear=<?=$searchyear?>&&searchyear1=<?=$searchyear1?>&&fromyear=<?=$fromyear?>&&toyear=<?=$toyear?>&&searchquarter=<?=$searchquarter?>&&cc_name=<?=$cc_name?>&&ADate1=<?=$ADate1?>&&ADate2=<?=$ADate2?>"><img  width="30" height="30" src="images/excel-xls-icon.png" style="cursor:pointer;"></a></td>
</tr>

 
<tr id="data">
		<td>
<form name="form1" id="form1" method="post" action="agentreport.php">	
<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse"  bordercolor="#666666" cellspacing="0" cellpadding="4" width="65%" align="left" border="0">
 <tbody>

<tr>
 
 <?php

			 if($period == 'monthly'){
	$months = array("","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    for($i = $searchmonth; $i <= $searchmonthto; $i++){
	$monthlystartdate= date($searchyear.'-'.$searchmonth.'-01');
	$monthlyenddate= date($searchyear.'-'.$searchmonthto.'-t');
	$month = $months[$i];
	}
			  ?>
			 <tr>
		<td width="25%"  align="left" valign="center"  class="bodytext31" style="text-transform:uppercase;"><strong><?php echo $period; ?>&nbsp;_<?php echo $monthlystartdate; ?>_TO_<?php echo $monthlyenddate; ?></strong>
		<?php  for($i = $searchmonth; $i <= $searchmonthto; $i++){ ?>
		 
		  <td width=""  align="left" valign="center"    class="bodytext31">&nbsp;</td>		 
		<?php }?>
		</tr>
			 <tr>
			  <td width="20%"  align="left" valign="center"  class="bodytext31"><strong><?php echo $res612cost_center; ?></strong>
 <input id="costname" name="costname" type="hidden" value="<?php echo $res612cost_center; ?>" ></td>
		<?php  for($i = $searchmonth; $i <= $searchmonthto; $i++){ ?>
		 
		  <td width=""  align="left" valign="center"    class="bodytext31">&nbsp;</td>		 
		<?php }?>
		</tr>
		<?php }else if($period == 'quarterly'){ ?>
		<tr>
		
		<td width="69%"  align="left" valign="center"  class="bodytext31" style="text-transform:uppercase;"><strong><?php echo $period; ?>&nbsp;<?php echo $fromdate;?>_TO_<?php echo $todate; ?></strong>
		</tr>
		<tr>
		<td width="69%"  align="left" valign="center"  class="bodytext31"><strong><?php echo $res612cost_center; ?></strong>
 <input id="costname" name="costname" type="hidden" value="<?php echo $res612cost_center; ?>" ></td>
		   <td width=""  align="left" valign="center"   bgcolor="" class="bodytext31">&nbsp;</td>
		 	</tr> 
		<?php }else if($period == 'dates range'){ ?>
		<tr>
		<td width="69%"  align="left" valign="center"  class="bodytext31" style="text-transform:uppercase;"><strong><?php echo $period; ?>&nbsp;_<?php echo $fromdate; ?>_&nbsp;To&nbsp;_<?php echo $todate; ?> </strong>
		</tr>
		<tr>
		<td width="69%"  align="left" valign="center"  class="bodytext31"><strong><?php echo $res612cost_center; ?></strong>
 <input id="costname" name="costname" type="hidden" value="<?php echo $res612cost_center; ?>" ></td>		
		 <td width=""  align="left" valign="center"   bgcolor="" class="bodytext31">&nbsp;</td>	
		 </tr>
		 <?php }else if($period == 'yearly'){ ?>
		 
		 <tr>
		 
		 
		<td width=""  align="left" valign="center"  class="bodytext31" style="text-transform:uppercase;"><strong><?php echo $period; ?>&nbsp;<?php echo $fromyear; ?>_TO_<?php echo $toyear; ?></strong>
		
		
		
		<?php for($year = $fromyear;$year <= $toyear;$year++) // Show Years
					{ ?>
					<td width=""  align="left" valign="center"  class="bodytext31">&nbsp;</td>	
					  <?php } ?>
		</tr>
		 
		 <tr>
		<td width=""  align="left" valign="center"  class="bodytext31"><strong><?php echo $res612cost_center; ?></strong>
 <input id="costname" name="costname" type="hidden" value="<?php echo $res612cost_center; ?>" ></td>		
		  <?php for($year = $fromyear;$year <= $toyear;$year++) // Show Years
					{ ?>
					<td width=""  align="left" valign="center"  class="bodytext31">&nbsp;</td>	
					  <?php } ?>	
					  </tr>
		 <?php }?>

              </tr>
			 <?php 
			 if($period == 'dates range'){ ?>
			  <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse"  bordercolor="#666666" cellspacing="0" cellpadding="4" width="45%" align="left" border="0">
 <tbody>
 
<tr>
			  
			  <?php
            $gorsstotalamount=0;
			$gorsstotalamount1=0;
			 $query12 = "
			
			select master_costcenter.name as name,B.id,B.accountsmain,A.auto_number from master_costcenter JOIN master_accountname AS B ON B.cost_center = master_costcenter.auto_number join tb AS A on A.ledger_id = B.id where master_costcenter.auto_number = '$cc_name' and (A.transaction_date BETWEEN '$fromdate' and '$todate') and B.accountsmain IN ('4','5') GROUP BY
   A.ledger_id ";
//sum(A.transaction_amount) as amount,
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num12 = mysqli_num_rows($exec12);
			while ($res12 = mysqli_fetch_array($exec12))
			{
			
			$res12name= $res12['name'];
			
		 	$res12id = $res12['id'];
			
			$res12accountsmain = $res12['accountsmain'];
			
			$res12auto_number = $res12['auto_number'];
			
		    if($res12accountsmain=='4'){
	  	$query2 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'C' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
	
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res2 = mysqli_fetch_array($exec2))
		{
		$amount = $res2['trn_amount'];
			
		$gorsstotalamount+=$amount;
		}	
		}
		
		if($res12accountsmain=='5'){
		 $query21 = " Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
		
		$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res21 = mysqli_fetch_array($exec21))
		{
		$res21amount = $res21['trn_amount'];
			
		$gorsstotalamount1+=$res21amount;
		}	
		}
			
			 } 
			 ?>
			 <tr>
<td width="40%"  align="left" valign="center"   class="bodytext31"><strong>Total Revenue</strong></td>
<td width="20%"  align="right" valign="center"   class="bodytext31"><?php echo number_format($gorsstotalamount,2); ?></td>
  </tr>
		   <tr>
<td width="40%"  align="left" valign="center"  class="bodytext31"><strong>Less: Supplies Cost</strong></td>
<td width="20%"  align="right" valign="center"    class="bodytext31"><?php echo number_format($gorsstotalamount1,2); ?></td>
 </tr>
			<?php
			$grosscc=$gorsstotalamount-$gorsstotalamount1;			
			?>
			  <tr>
                <td width="40%"  align="left" valign="center"    class="bodytext31"><strong>Gross Profit</strong></td>
				<td width="20%"  align="right" valign="center"  class="bodytext31"><strong><?php echo number_format($grosscc,2); ?></strong></td>
</tr>
		   <tr> <td>&nbsp;</td></tr>
 <tr >
<td colspan="2"  align="left" valign="center"  class="bodytext31"><strong>Expenses</strong></td>
 </tr>	   
		   <?php
		   $totres201amount=0;
		   $query20 = "select ledger_id,transaction_type,B.accountname from tb JOIN master_accountname AS B ON B.id = tb.ledger_id where cost_center_code = '$cc_name' and transaction_date BETWEEN '$fromdate' and '$todate' and B.accountsmain='6' GROUP BY
    ledger_id  ";
		$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res20 = mysqli_fetch_array($exec20))
		{
		
		 $res20ledger_id= $res20['ledger_id'];
		 $res20transaction_type = $res20['transaction_type'];
		 $res20accountname = ucwords(strtolower($res20['accountname']));
			
		$query201 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res20ledger_id') and cost_center_code='$cc_name'
GROUP BY
    transaction_type) as result";	
		$exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die ("Error in Query201".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res201 = mysqli_fetch_array($exec201);
		$res201amount = $res201['trn_amount'];
		$totres201amount+=$res201amount;
		if($res201amount>0){
		?>
		<tr>
                <td width="40%"  align="left" valign="center"   class="bodytext31"><?php echo $res20accountname; ?></td>
				<td width="20%"  align="right" valign="center"  class="bodytext31"><?php echo number_format($res201amount,2); ?></td>
        </tr>
		<?php
		}
		}	
		?>	
		<tr>
                <td width="40%"  align="left" valign="center"   class="bodytext31"><strong>Total Expenses</strong></td>
				<td width="20%"  align="right" valign="center"  class="bodytext31"><strong><?php echo number_format($totres201amount,2); ?></strong></td>
        </tr>		
		<tr> <td>&nbsp;</td> </tr>
		<?php
		$totalnetprofit=$grosscc-$totres201amount;
		 ?>
		<tr>
                <td width="40%"  align="left" valign="center"   class="bodytext31"><strong>Net Profit Before Tax</strong></td>
				<td width="20%"  align="right" valign="center"  class="bodytext31"><strong><?php echo number_format($totalnetprofit,2); ?></strong></td>
        </tr>
		   <tr>
				<td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
				<td  align="left" valign="center"  class="bodytext31">&nbsp;</td>
			</tr>
			</tr>
			</tbody>
			</table>
			
			<?php } 
			 ?>
			 <?php 
			 if($period == 'monthly'){
			 ?>
			 <tr>
			 <td width="20%"  align="left" valign="center"  class="bodytext31">&nbsp;</td>
			 <?php
        $months = array("","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        for($i = $searchmonth; $i <= $searchmonthto; $i++){
	$monthlystartdate= date($searchyear.'-'.'0'.$i.'-01');
	$monthlyenddate= date($searchyear.'-'.'0'.$i.'-t');
	$month = $months[$i];
			 
      ?>
	  
        <td  class="bodytext31" align="right"><strong><?php echo $month; ?></strong></td>
		<?php
		}
		?>
		</tr>
		<tr>
		  <td width="20%"  align="left" valign="center"    class="bodytext31"><strong>Total Revenue</strong></td>
		
		  <?php
		
        $months = array("","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        for($i = $searchmonth; $i <= $searchmonthto; $i++){
	$monthlystartdate= date($searchyear.'-'.'0'.$i.'-01');
	$monthlyenddate= date($searchyear.'-'.'0'.$i.'-t');
	$month = $months[$i];
	 
            $gorsstotalamount=0;
			$gorsstotalamount1=0;
		 $query12 = "select master_costcenter.name as name,B.id,B.accountsmain,A.auto_number from master_costcenter JOIN master_accountname AS B ON B.cost_center = master_costcenter.auto_number join tb AS A on A.ledger_id = B.id where master_costcenter.auto_number = '$cc_name' and (A.transaction_date BETWEEN '$monthlystartdate' and '$monthlyenddate') and B.accountsmain IN ('4','5') GROUP BY
   A.ledger_id   ";
//sum(A.transaction_amount) as amount,
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num12 = mysqli_num_rows($exec12);
			while ($res12 = mysqli_fetch_array($exec12))
			{
			
			$res12name= $res12['name'];
			
		 	$res12id = $res12['id'];
			
			$res12accountsmain = $res12['accountsmain'];
			
			$res12auto_number = $res12['auto_number'];
			
		    if($res12accountsmain=='4'){
	  	$query2 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'C' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$monthlystartdate' AND '$monthlyenddate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
	
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res2 = mysqli_fetch_array($exec2))
		{
		$amount = $res2['trn_amount'];
			
		$gorsstotalamount+=$amount;
		}	
		}
		
		if($res12accountsmain=='5'){
		 $query21 = " Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$monthlystartdate' AND '$monthlyenddate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
		
		$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res21 = mysqli_fetch_array($exec21))
		{
		$res21amount = $res21['trn_amount'];
			
		$gorsstotalamount1+=$res21amount;
		}	
		}
			
			 } 
			 ?>
			 
<td width=""  align="right" valign="center"   class="bodytext31"><?php echo number_format($gorsstotalamount,2); ?></td>
			<?php 	  
	   } ?>
	   
	   </tr>
	   
	   
	   <tr>
		  <td width="20%"  align="left" valign="center"    class="bodytext31"><strong>Less: Supplies Cost</strong></td>
		<?php
		
        $months = array("","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        for($i = $searchmonth; $i <= $searchmonthto; $i++){
	$monthlystartdate= date($searchyear.'-'.'0'.$i.'-01');
	$monthlyenddate= date($searchyear.'-'.'0'.$i.'-t');
	$month = $months[$i];
	 
            $gorsstotalamount=0;
			$gorsstotalamount1=0;
		 $query12 = "select master_costcenter.name as name,B.id,B.accountsmain,A.auto_number from master_costcenter JOIN master_accountname AS B ON B.cost_center = master_costcenter.auto_number join tb AS A on A.ledger_id = B.id where master_costcenter.auto_number = '$cc_name' and (A.transaction_date BETWEEN '$monthlystartdate' and '$monthlyenddate') and B.accountsmain IN ('4','5') GROUP BY
   A.ledger_id   ";
//sum(A.transaction_amount) as amount,
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num12 = mysqli_num_rows($exec12);
			while ($res12 = mysqli_fetch_array($exec12))
			{
			
			$res12name= $res12['name'];
			
		 	$res12id = $res12['id'];
			
			$res12accountsmain = $res12['accountsmain'];
			
			$res12auto_number = $res12['auto_number'];
			
		    if($res12accountsmain=='4'){
	  	$query2 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'C' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$monthlystartdate' AND '$monthlyenddate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
	
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res2 = mysqli_fetch_array($exec2))
		{
		$amount = $res2['trn_amount'];
			
		$gorsstotalamount+=$amount;
		}	
		}
		
		if($res12accountsmain=='5'){
		 $query21 = " Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$monthlystartdate' AND '$monthlyenddate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
		
		$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res21 = mysqli_fetch_array($exec21))
		{
		$res21amount = $res21['trn_amount'];
			
		$gorsstotalamount1+=$res21amount;
		}	
		}
			
			 } 
			 ?>
			 
<td width=""  align="right" valign="center"   class="bodytext31"><?php echo number_format($gorsstotalamount1,2); ?></td>
			<?php 	  
	   } ?>
	   
	   </tr>
	   
	    <tr>
		  <td width="20%"  align="left" valign="center"    class="bodytext31"><strong>Gross Profit</strong></td>
		<?php
		
        $months = array("","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        for($i = $searchmonth; $i <= $searchmonthto; $i++){
	$monthlystartdate= date($searchyear.'-'.'0'.$i.'-01');
	$monthlyenddate= date($searchyear.'-'.'0'.$i.'-t');
	$month = $months[$i];
	 
            $gorsstotalamount=0;
			$gorsstotalamount1=0;
		 $query12 = "select master_costcenter.name as name,B.id,B.accountsmain,A.auto_number from master_costcenter JOIN master_accountname AS B ON B.cost_center = master_costcenter.auto_number join tb AS A on A.ledger_id = B.id where master_costcenter.auto_number = '$cc_name' and (A.transaction_date BETWEEN '$monthlystartdate' and '$monthlyenddate') and B.accountsmain IN ('4','5') GROUP BY
   A.ledger_id   ";
//sum(A.transaction_amount) as amount,
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num12 = mysqli_num_rows($exec12);
			while ($res12 = mysqli_fetch_array($exec12))
			{
			
			$res12name= $res12['name'];
			
		 	$res12id = $res12['id'];
			
			$res12accountsmain = $res12['accountsmain'];
			
			$res12auto_number = $res12['auto_number'];
			
		    if($res12accountsmain=='4'){
	  	$query2 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'C' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$monthlystartdate' AND '$monthlyenddate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
	
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res2 = mysqli_fetch_array($exec2))
		{
		$amount = $res2['trn_amount'];
			
		$gorsstotalamount+=$amount;
		}	
		}
		
		if($res12accountsmain=='5'){
		 $query21 = " Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$monthlystartdate' AND '$monthlyenddate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
		
		$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res21 = mysqli_fetch_array($exec21))
		{
		$res21amount = $res21['trn_amount'];
			
		$gorsstotalamount1+=$res21amount;
		}	
		}
			
			 } 
			 
			 $grosscc=$gorsstotalamount-$gorsstotalamount1;
			 
			 ?>
			 
<td width=""  align="right" valign="center"   class="bodytext31"><?php echo number_format($grosscc,2); ?></td>
			<?php 	  
	   } ?>
	   
	   </tr>
			
			
		  <tr>

        <td>&nbsp;</td>

      </tr>

		   
		   <tr >
              <td colspan=""  align="left" valign="center"  class="bodytext31"><strong>Expenses</strong></td>
			   <?php
		  for($i = $searchmonth; $i <= $searchmonthto; $i++){ ?>
		  <td width=""  align="left" valign="center"    class="bodytext31">&nbsp;</td>
		 
		<?php }?>

              </tr>
			  
		<?php
		$totres2012amount=0;
        $months = array("","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

        $searchmonth_prefix = "";
        $searchmonthto_prefix="";
        if($searchmonth >0 && $searchmonth <10)
        {
        	$searchmonth_prefix = '0';
        }
        if($searchmonthto >0 && $searchmonthto <10)
        {
        	$searchmonthto_prefix = '0';
        }
        $start_date= date($searchyear.'-'.$searchmonth_prefix.$searchmonth.'-01');
        $end_date = date($searchyear.'-'.$searchmonthto_prefix.$searchmonthto.'-t');
       

        $query20 = "select ledger_id,transaction_type,B.accountname from tb JOIN master_accountname AS B ON B.id = tb.ledger_id where cost_center_code = '$cc_name' and transaction_date BETWEEN '$start_date' and '$end_date' and B.accountsmain='6' GROUP BY
    ledger_id  ";

    $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res20 = mysqli_fetch_array($exec20))
		{

			$res20ledger_id= $res20['ledger_id'];
		 $res20transaction_type = $res20['transaction_type'];
		 $res20accountname = ucwords(strtolower($res20['accountname']));

		 ?>

		 <tr><td width="20%"  align="left" valign="center"   class="bodytext31"><?php echo $res20accountname; ?></td>
		<?php  for($i = $searchmonth; $i <= $searchmonthto; $i++){

		  
		  	$prefix = "";
	        
	        if($i >0 && $i <10)
	        {
	        	$prefix = '0';
	        }
	        
		  	$monthlystartdate= date($searchyear.'-'.$prefix.$i.'-01');
			$monthlyenddate= date($searchyear.'-'.$prefix.$i.'-t');
			$totres2012amount = 0;
					$query201 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$monthlystartdate' AND '$monthlyenddate' AND `ledger_id` IN('$res20ledger_id') and cost_center_code='$cc_name'
GROUP BY
    transaction_type) as result";	
	
	
		$exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die ("Error in Query201".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res201 = mysqli_fetch_array($exec201);
		$res201amount = $res201['trn_amount'];
		$totres2012amount = $res201amount;
			?>

				<td width=""  align="right" valign="center"  class="bodytext31"><?php  echo number_format($totres2012amount,2);   ?></td>

		<?php  }

		}

    ?>
			
		
			<tr>
                <td width="20%"  align="left" valign="center"   class="bodytext31"><strong>Total Expenses</strong></td>
				<?php
        $months = array("","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        for($i = $searchmonth; $i <= $searchmonthto; $i++){
		$monthlystartdate= date($searchyear.'-'.'0'.$i.'-01');
	$monthlyenddate= date($searchyear.'-'.'0'.$i.'-t');

			$totres201amount=0;
		    $query20 = "select ledger_id,transaction_type,B.accountname from tb JOIN master_accountname AS B ON B.id = tb.ledger_id where cost_center_code = '$cc_name' and transaction_date BETWEEN '$monthlystartdate' and '$monthlyenddate' and B.accountsmain='6' GROUP BY
    ledger_id  ";
	
		$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res20 = mysqli_fetch_array($exec20))
		{
		
		 $res20ledger_id= $res20['ledger_id'];
		 $res20transaction_type = $res20['transaction_type'];
		 $res20accountname = $res20['accountname'];
			
	 	$query201 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$monthlystartdate' AND '$monthlyenddate' AND `ledger_id` IN('$res20ledger_id') and cost_center_code='$cc_name'
GROUP BY
    transaction_type) as result";	
	
	
		$exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die ("Error in Query201".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res201 = mysqli_fetch_array($exec201);
		$res201amount = $res201['trn_amount'];
		$totres201amount+=$res201amount;
		}
			?>
			
				<td width=""  align="right" valign="center"  class="bodytext31"><strong><?php echo number_format($totres201amount,2); ?></strong></td>
				
				<?php }?>
        </tr>
		
		<tr>
        <td>&nbsp;</td>
			
			
		<tr>
                <td width="20%"  align="left" valign="center"   class="bodytext31"><strong>Net Profit Before Tax</strong></td>
			<?php
			$totalnetprofit=0;
		$months = array("","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        for($i = $searchmonth; $i <= $searchmonthto; $i++){
		
		
	$monthlystartdate= date($searchyear.'-'.'0'.$i.'-01');
	$monthlyenddate= date($searchyear.'-'.'0'.$i.'-t');
	$month = $months[$i];
	 
            $gorsstotalamount=0;
			$gorsstotalamount1=0;
		 $query12 = "select master_costcenter.name as name,B.id,B.accountsmain,A.auto_number from master_costcenter JOIN master_accountname AS B ON B.cost_center = master_costcenter.auto_number join tb AS A on A.ledger_id = B.id where master_costcenter.auto_number = '$cc_name' and (A.transaction_date BETWEEN '$monthlystartdate' and '$monthlyenddate') and B.accountsmain IN ('4','5') GROUP BY
   A.ledger_id   ";
//sum(A.transaction_amount) as amount,
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num12 = mysqli_num_rows($exec12);
			while ($res12 = mysqli_fetch_array($exec12))
			{
			
			$res12name= $res12['name'];
			
		 	$res12id = $res12['id'];
			
			$res12accountsmain = $res12['accountsmain'];
			
			$res12auto_number = $res12['auto_number'];
			
		    if($res12accountsmain=='4'){
	  	$query2 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'C' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$monthlystartdate' AND '$monthlyenddate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
	
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res2 = mysqli_fetch_array($exec2))
		{
		$amount = $res2['trn_amount'];
			
		$gorsstotalamount+=$amount;
		}	
		}
		
		if($res12accountsmain=='5'){
		 $query21 = " Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$monthlystartdate' AND '$monthlyenddate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
		
		$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res21 = mysqli_fetch_array($exec21))
		{
		$res21amount = $res21['trn_amount'];
			
		$gorsstotalamount1+=$res21amount;
		}	
		}
		/*echo $gorsstotalamount;
		echo $gorsstotalamount1;
		echo "</br>";*/
				
			
			 } 
			
			  $grosscc=$gorsstotalamount-$gorsstotalamount1;
			 
			$totres201amount=0;
		   $query20 = "select ledger_id,transaction_type,B.accountname from tb JOIN master_accountname AS B ON B.id = tb.ledger_id where cost_center_code = '$cc_name' and transaction_date BETWEEN '$monthlystartdate' and '$monthlyenddate' and B.accountsmain='6' GROUP BY
    ledger_id  ";
	
		$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res20 = mysqli_fetch_array($exec20))
		{
		
		 $res20ledger_id= $res20['ledger_id'];
		 $res20transaction_type = $res20['transaction_type'];
		 $res20accountname = $res20['accountname'];
			
		$query201 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$monthlystartdate' AND '$monthlyenddate' AND `ledger_id` IN('$res20ledger_id') and cost_center_code='$cc_name'
GROUP BY
    transaction_type) as result";	
		$exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die ("Error in Query201".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res201 = mysqli_fetch_array($exec201);
		$res201amount = $res201['trn_amount'];
		$totres201amount+=$res201amount;
		
		}
	
			$totalnetprofit=$grosscc-$totres201amount; 
	   
	   
		 ?>
		<td width=""  align="right" valign="center"  class="bodytext31"><strong><?php echo number_format($totalnetprofit,2); ?></strong></td>
        
		<?php
		}
		?>
		</tr>
		  
	   <?php
			}			
			 ?>
			<?php 
			 if($period == 'quarterly'){ ?>
	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse"  bordercolor="#666666" cellspacing="0" cellpadding="4" width="45%" align="left" border="0">
 <tbody>
 
<tr>
			  
			  <?php
            $gorsstotalamount=0;
			$gorsstotalamount1=0;
			 $query12 = "
			
			select master_costcenter.name as name,B.id,B.accountsmain,A.auto_number from master_costcenter JOIN master_accountname AS B ON B.cost_center = master_costcenter.auto_number join tb AS A on A.ledger_id = B.id where master_costcenter.auto_number = '$cc_name' and (A.transaction_date BETWEEN '$fromdate' and '$todate') and B.accountsmain IN ('4','5') GROUP BY
   A.ledger_id ";
//sum(A.transaction_amount) as amount,
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num12 = mysqli_num_rows($exec12);
			while ($res12 = mysqli_fetch_array($exec12))
			{
			
			$res12name= $res12['name'];
			
		 	$res12id = $res12['id'];
			
			$res12accountsmain = $res12['accountsmain'];
			
			$res12auto_number = $res12['auto_number'];
			
		    if($res12accountsmain=='4'){
	  	$query2 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'C' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
	
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res2 = mysqli_fetch_array($exec2))
		{
		$amount = $res2['trn_amount'];
			
		$gorsstotalamount+=$amount;
		}	
		}
		
		if($res12accountsmain=='5'){
		 $query21 = " Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
		
		$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res21 = mysqli_fetch_array($exec21))
		{
		$res21amount = $res21['trn_amount'];
			
		$gorsstotalamount1+=$res21amount;
		}	
		}
			
			 } 
			 ?>
			 <tr>
<td width="40%"  align="left" valign="center"   class="bodytext31"><strong>Total Revenue</strong></td>
<td width="20%"  align="right" valign="center"   class="bodytext31"><?php echo number_format($gorsstotalamount,2); ?></td>
  </tr>
		   <tr>
<td width="40%"  align="left" valign="center"  class="bodytext31"><strong>Less: Supplies Cost</strong></td>
<td width="20%"  align="right" valign="center"    class="bodytext31"><?php echo number_format($gorsstotalamount1,2); ?></td>
 </tr>
			<?php
			$grosscc=$gorsstotalamount-$gorsstotalamount1;			
			?>
			  <tr>
                <td width="40%"  align="left" valign="center"    class="bodytext31"><strong>Gross Profit</strong></td>
				<td width="20%"  align="right" valign="center"  class="bodytext31"><strong><?php echo number_format($grosscc,2); ?></strong></td>
</tr>
		   <tr> <td>&nbsp;</td></tr>
 <tr >
<td colspan="2"  align="left" valign="center"  class="bodytext31"><strong>Expenses</strong></td>
 </tr>	   
		   <?php
		   $totres201amount=0;
		   $query20 = "select ledger_id,transaction_type,B.accountname from tb JOIN master_accountname AS B ON B.id = tb.ledger_id where cost_center_code = '$cc_name' and transaction_date BETWEEN '$fromdate' and '$todate' and B.accountsmain='6' GROUP BY
    ledger_id  ";
		$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res20 = mysqli_fetch_array($exec20))
		{
		
		 $res20ledger_id= $res20['ledger_id'];
		 $res20transaction_type = $res20['transaction_type'];
		 
		 $res20accountname = ucwords(strtolower($res20['accountname']));
			
		$query201 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res20ledger_id') and cost_center_code='$cc_name'
GROUP BY
    transaction_type) as result";	
		$exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die ("Error in Query201".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res201 = mysqli_fetch_array($exec201);
		$res201amount = $res201['trn_amount'];
		$totres201amount+=$res201amount;
		if($res201amount>0){
		?>
		<tr>
                <td width="40%"  align="left" valign="center"   class="bodytext31"><?php echo $res20accountname; ?></td>
				<td width="20%"  align="right" valign="center"  class="bodytext31"><?php echo number_format($res201amount,2); ?></td>
        </tr>
		<?php
		}
		}	
		?>	
		<tr>
                <td width="40%"  align="left" valign="center"   class="bodytext31"><strong>Total Expenses</strong></td>
				<td width="20%"  align="right" valign="center"  class="bodytext31"><strong><?php echo number_format($totres201amount,2); ?></strong></td>
        </tr>		
		<tr> <td>&nbsp;</td> </tr>
		<?php
		$totalnetprofit=$grosscc-$totres201amount;
		 ?>
		<tr>
                <td width="40%"  align="left" valign="center"   class="bodytext31"><strong>Net Profit Before Tax</strong></td>
				<td width="20%"  align="right" valign="center"  class="bodytext31"><strong><?php echo number_format($totalnetprofit,2); ?></strong></td>
        </tr>
		   <tr>
				<td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
				<td  align="left" valign="center"  class="bodytext31">&nbsp;</td>
			</tr>
			</tr>
			</tbody>
			</table>
			
			<?php 
			 }			 
			 ?>			
			<?php 
			 if($period == 'yearly') { ?>
			 <tr>
			 <td  >&nbsp;</td>
			  <?php
			for($year = $fromyear;$year <= $toyear;$year++) // Show Years
					{
					$date = $year; 
					?>
			 <td width="auto" align="right" valign="middle" class="bodytext3" style=""  >
						<strong><?= $date; ?></strong>
					</td>
					<?php }?>
					</tr>
					
					<tr>
					<td width="20%"  align="left" valign="center"   class="bodytext31"><strong>Total Revenue</strong></td>
					
			 <?php
			for($year = $fromyear;$year <= $toyear;$year++) // Show Years
					{
					$date = $year;
					$fromdate = date('Y-m-d',strtotime('01-01-'.$date));
				$todate = date('Y-m-t',strtotime('01-12-'.$date));
            $gorsstotalamount=0;
			$gorsstotalamount1=0;
			  $query12 = "
			
			select master_costcenter.name as name,B.id,B.accountsmain,A.auto_number from master_costcenter JOIN master_accountname AS B ON B.cost_center = master_costcenter.auto_number join tb AS A on A.ledger_id = B.id where master_costcenter.auto_number = '$cc_name' and (A.transaction_date BETWEEN '$fromdate' and '$todate') and B.accountsmain IN ('4','5') GROUP BY
   A.ledger_id ";
   
//sum(A.transaction_amount) as amount,
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num12 = mysqli_num_rows($exec12);
			while ($res12 = mysqli_fetch_array($exec12))
			{
			
			$res12name= $res12['name'];
			
		 	$res12id = $res12['id'];
			
			$res12accountsmain = $res12['accountsmain'];
			
			$res12auto_number = $res12['auto_number'];
			
		    if($res12accountsmain=='4'){
	  	$query2 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'C' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
	
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res2 = mysqli_fetch_array($exec2))
		{
		$amount = $res2['trn_amount'];
			
		$gorsstotalamount+=$amount;
		}	
		}
		
		if($res12accountsmain=='5'){
		 $query21 = " Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
		
		$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res21 = mysqli_fetch_array($exec21))
		{
		$res21amount = $res21['trn_amount'];
			
		$gorsstotalamount1+=$res21amount;
		}	
		}
			
			 } 
			 ?>
<td width="20%"  align="right" valign="center"   class="bodytext31"><?php echo number_format($gorsstotalamount,2); ?></td>
			<?php }	?>			
				</tr>
				
				<tr>
					<td width="20%"  align="left" valign="center"   class="bodytext31"><strong>Less: Supplies Cost</strong></td>
			 <?php
			for($year = $fromyear;$year <= $toyear;$year++) // Show Years
					{
					$date = $year;
					$fromdate = date('Y-m-d',strtotime('01-01-'.$date));
				$todate = date('Y-m-t',strtotime('01-12-'.$date));
            $gorsstotalamount=0;
			$gorsstotalamount1=0;
			  $query12 = "
			
			select master_costcenter.name as name,B.id,B.accountsmain,A.auto_number from master_costcenter JOIN master_accountname AS B ON B.cost_center = master_costcenter.auto_number join tb AS A on A.ledger_id = B.id where master_costcenter.auto_number = '$cc_name' and (A.transaction_date BETWEEN '$fromdate' and '$todate') and B.accountsmain IN ('4','5') GROUP BY
   A.ledger_id ";
   
//sum(A.transaction_amount) as amount,
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num12 = mysqli_num_rows($exec12);
			while ($res12 = mysqli_fetch_array($exec12))
			{
			
			$res12name= $res12['name'];
			
		 	$res12id = $res12['id'];
			
			$res12accountsmain = $res12['accountsmain'];
			
			$res12auto_number = $res12['auto_number'];
			
		    if($res12accountsmain=='4'){
	  	$query2 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'C' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
	
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res2 = mysqli_fetch_array($exec2))
		{
		$amount = $res2['trn_amount'];
			
		$gorsstotalamount+=$amount;
		}	
		}
		
		if($res12accountsmain=='5'){
		 $query21 = " Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
		
		$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res21 = mysqli_fetch_array($exec21))
		{
		$res21amount = $res21['trn_amount'];
			
		$gorsstotalamount1+=$res21amount;
		}	
		}
			
			 } 
			 ?>
<td width="20%"  align="right" valign="center"   class="bodytext31"><?php echo number_format($gorsstotalamount1,2); ?></td>
			<?php }	?>			
				</tr>
				
				<td width="20%"  align="left" valign="center"   class="bodytext31"><strong>Gross Profit</strong></td>
			 <?php
			for($year = $fromyear;$year <= $toyear;$year++) // Show Years
					{
					$date = $year;
					$fromdate = date('Y-m-d',strtotime('01-01-'.$date));
				$todate = date('Y-m-t',strtotime('01-12-'.$date));
            $gorsstotalamount=0;
			$gorsstotalamount1=0;
			  $query12 = "
			
			select master_costcenter.name as name,B.id,B.accountsmain,A.auto_number from master_costcenter JOIN master_accountname AS B ON B.cost_center = master_costcenter.auto_number join tb AS A on A.ledger_id = B.id where master_costcenter.auto_number = '$cc_name' and (A.transaction_date BETWEEN '$fromdate' and '$todate') and B.accountsmain IN ('4','5') GROUP BY
   A.ledger_id ";
   
//sum(A.transaction_amount) as amount,
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num12 = mysqli_num_rows($exec12);
			while ($res12 = mysqli_fetch_array($exec12))
			{
			
			$res12name= $res12['name'];
			
		 	$res12id = $res12['id'];
			
			$res12accountsmain = $res12['accountsmain'];
			
			$res12auto_number = $res12['auto_number'];
			
		    if($res12accountsmain=='4'){
	  	$query2 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'C' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
	
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res2 = mysqli_fetch_array($exec2))
		{
		$amount = $res2['trn_amount'];
			
		$gorsstotalamount+=$amount;
		}	
		}
		
		if($res12accountsmain=='5'){
		 $query21 = " Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
		
		$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res21 = mysqli_fetch_array($exec21))
		{
		$res21amount = $res21['trn_amount'];
			
		$gorsstotalamount1+=$res21amount;
		}	
		}
			
			 } 
			 $grosscc=$gorsstotalamount-$gorsstotalamount1;
			 ?>
			 
<td width="20%"  align="right" valign="center"   class="bodytext31"><strong><?php echo number_format($grosscc,2); ?></strong></td>
			<?php }	?>			
				</tr>
				
			 
		   <tr>

        <td>&nbsp;</td>

      </tr>
	  
	   <tr >
         <td width="20%"  align="left" valign="center"  class="bodytext31"><strong>Expenses</strong></td>
		 <?php for($year = $fromyear;$year <= $toyear;$year++) // Show Years
					{ ?>
					<td width=""  align="left" valign="center"  class="bodytext31">&nbsp;</td>	
					  <?php } ?>
				
       </tr>  
	  <?php
	  $totres2012amount=0;
      for($year = $fromyear;$year <= $toyear;$year++) // Show Years
	  {
	   $date = $year;
	   $fromdate = date('Y-m-d',strtotime('01-01-'.$date));
	   $todate = date('Y-m-t',strtotime('01-12-'.$date));

			$totres201amount=0;
		    $query20 = "select ledger_id,transaction_type,B.accountname from tb JOIN master_accountname AS B ON B.id = tb.ledger_id where cost_center_code = '$cc_name' and transaction_date BETWEEN '$fromdate' and '$todate' and B.accountsmain='6' GROUP BY
    ledger_id  ";
	
		$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res20 = mysqli_fetch_array($exec20))
		{
		
		 $res20ledger_id= $res20['ledger_id'];
		 $res20transaction_type = $res20['transaction_type'];
		 
		 $res20accountname = ucwords(strtolower($res20['accountname']));
		 ?>
		 <tr>
		 <?php
			$query201 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res20ledger_id') and cost_center_code='$cc_name'
GROUP BY
    transaction_type) as result";	
	
	
		$exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die ("Error in Query201".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res201 = mysqli_fetch_array($exec201);
		$res201amount = $res201['trn_amount'];
		$totres2012amount+=$res201amount;
		if($res201amount>0){
	 	
		?>
		
                <td width="20%"  align="left" valign="center"   class="bodytext31"><?php echo $res20accountname; ?></td>
				
				<?php  
			
        for($o = $fromyear; $o <= $toyear; $o++){ 
		
		?>
				<td width=""  align="right" valign="center"  class="bodytext31"><?php if($o==$year){ echo number_format($totres2012amount,2); } else { echo number_format(0,2); }  ?></td>
				<?php } 
				$totres2012amount=0;
				?>
			
      </tr>
		<?php
		}
		}
			
			}?>
			
			<tr >
         <td   align="left" valign="center"  class="bodytext31"><strong>Total Expenses</strong></td>     
			<?php
	   for($year = $fromyear;$year <= $toyear;$year++) // Show Years
	   {
	   $date = $year;
	   $fromdate = date('Y-m-d',strtotime('01-01-'.$date));
	   $todate = date('Y-m-t',strtotime('01-12-'.$date));
			
			$totres201amount=0;
		    $query20 = "select ledger_id,transaction_type,B.accountname from tb JOIN master_accountname AS B ON B.id = tb.ledger_id where cost_center_code = '$cc_name' and transaction_date BETWEEN '$fromdate' and '$todate' and B.accountsmain='6' GROUP BY
    ledger_id  ";
	
		$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res20 = mysqli_fetch_array($exec20))
		{
		
		 $res20ledger_id= $res20['ledger_id'];
		 $res20transaction_type = $res20['transaction_type'];
		 $res20accountname = $res20['accountname'];
			
	 	$query201 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res20ledger_id') and cost_center_code='$cc_name'
GROUP BY
    transaction_type) as result";	
	
	
		$exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die ("Error in Query201".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res201 = mysqli_fetch_array($exec201);
		$res201amount = $res201['trn_amount'];
		$totres201amount+=$res201amount;
		}
			?>
			
				<td width=""  align="right" valign="center"  class="bodytext31"><strong><?php echo number_format($totres201amount,2); ?></strong></td>
				
				<?php } ?>
        </tr>
			<tr> <td>&nbsp;</td> </tr>
		<tr >
         <td   align="left" valign="center"  class="bodytext31"><strong>Net Profit Before Tax</strong></td> 
		 
		 
		 
		 
		 <?php
		 for($year = $fromyear;$year <= $toyear;$year++) // Show Years
	   {
	   $date = $year;
	   $fromdate = date('Y-m-d',strtotime('01-01-'.$date));
	   $todate = date('Y-m-t',strtotime('01-12-'.$date));
		
	 
            $gorsstotalamount=0;
			$gorsstotalamount1=0;
		 $query12 = "select master_costcenter.name as name,B.id,B.accountsmain,A.auto_number from master_costcenter JOIN master_accountname AS B ON B.cost_center = master_costcenter.auto_number join tb AS A on A.ledger_id = B.id where master_costcenter.auto_number = '$cc_name' and (A.transaction_date BETWEEN '$fromdate' and '$todate') and B.accountsmain IN ('4','5') GROUP BY
   A.ledger_id   ";
//sum(A.transaction_amount) as amount,
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num12 = mysqli_num_rows($exec12);
			while ($res12 = mysqli_fetch_array($exec12))
			{
			
			$res12name= $res12['name'];
			
		 	$res12id = $res12['id'];
			
			$res12accountsmain = $res12['accountsmain'];
			
			$res12auto_number = $res12['auto_number'];
			
		    if($res12accountsmain=='4'){
	  	$query2 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'C' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
	
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res2 = mysqli_fetch_array($exec2))
		{
		$amount = $res2['trn_amount'];
			
		$gorsstotalamount+=$amount;
		}	
		}
		
		if($res12accountsmain=='5'){
		 $query21 = " Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
		
		$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res21 = mysqli_fetch_array($exec21))
		{
		$res21amount = $res21['trn_amount'];
			
		$gorsstotalamount1+=$res21amount;
		}	
		}
		/*echo $gorsstotalamount;
		echo $gorsstotalamount1;
		echo "</br>";*/
				
			
			 } 
			
			  $grosscc=$gorsstotalamount-$gorsstotalamount1;
			 
			$totres201amount=0;
		   $query20 = "select ledger_id,transaction_type,B.accountname from tb JOIN master_accountname AS B ON B.id = tb.ledger_id where cost_center_code = '$cc_name' and transaction_date BETWEEN '$fromdate' and '$todate' and B.accountsmain='6' GROUP BY
    ledger_id  ";
	
		$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res20 = mysqli_fetch_array($exec20))
		{
		
		 $res20ledger_id= $res20['ledger_id'];
		 $res20transaction_type = $res20['transaction_type'];
		 $res20accountname = $res20['accountname'];
			
		$query201 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res20ledger_id') and cost_center_code='$cc_name'
GROUP BY
    transaction_type) as result";	
		$exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die ("Error in Query201".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res201 = mysqli_fetch_array($exec201);
		$res201amount = $res201['trn_amount'];
		$totres201amount+=$res201amount;
		
		}
	
			$totalnetprofit=$grosscc-$totres201amount; 
	   
	   
		 ?>
		<td width=""  align="right" valign="center"  class="bodytext31"><strong><?php echo number_format($totalnetprofit,2); ?></strong></td>
     
		 
		 <?php } ?>
		 
		 
		 
		 </tr>
			<?php
	  }
	  ?>

          </tbody>

        </table>

		 </form>
</td>
</tr>
		 

		 <?php

		 
}
		 ?></td>

      </tr>

    </table>

  </table>

<footer>
  <?php include ("includes/footer1.php"); ?>
</footer>
</main>

</body>

</html>
<?php 
if($period != '')
		{
		echo "<script>funchangeperiod('".$period."');</script>";
		}
		?>



