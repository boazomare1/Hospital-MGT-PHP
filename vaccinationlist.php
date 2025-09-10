<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$timeonly = date('H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["fromyear"])) { $fromyear = $_REQUEST["fromyear"]; } else { $fromyear = ""; }
if (isset($_REQUEST["toyear"])) { $toyear = $_REQUEST["toyear"]; } else { $toyear = ""; }

if (isset($_REQUEST["frommonth"])) { $frommonth = $_REQUEST["frommonth"]; $monthName = date("F", mktime(null, null, null, $frommonth)); } else { $frommonth = ""; }
if (isset($_REQUEST["tomonth"])) { $tomonth = $_REQUEST["tomonth"]; $tomonthName = date("F", mktime(null, null, null, $tomonth)); } else { $frommonth = ""; }
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
.number1
{
text-align:right;
padding-left:700px;
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function cbcustomername1()
{
	document.cbform1.submit();
}

</script>
<script type="text/javascript" src="js/autocomplete_customer1.js"></script>
<script type="text/javascript" src="js/autosuggest3.js"></script>
<script type="text/javascript">
/*
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        
}
*/

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


</script>
<script src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<body>
<table width="103%" border="0" cellspacing="0" cellpadding="2">
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
    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	    <tr>
	 <td width="860">
              <form name="cbform1" method="post" action="vaccinationlist.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr>
              <td colspan="8" bgcolor="#ecf0f5" class="bodytext31">
                <div align="left"><strong>Vaccination List </strong></div></td>
			    </tr>
			 		
          <td width="300" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Month / Year </strong></td>
          <td width="53" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <select name="frommonth" id="frommonth">
            <?php
				if ($frommonth != '')
				{
				?>
            <option value="<?php echo $frommonth; ?>" selected="selected"><?php echo $frommonth; ?></option>
            <?php
				}
				else
				{
				?>
            <option value="<?php echo (date('m')-5); ?>"><?php echo (date('m')-5); ?></option>
            <?php
				}
				?>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select></td>
          <td width="6" align="left" valign="center"  bgcolor="#FFFFFF" class="style1">/</td>
          <td width="267" align="left" valign="center"  bgcolor="#ffffff"><span class="style1"><span class="bodytext31">
            <select name="fromyear" id="fromyear">
              <?php
				if ($fromyear != '')
				{
				?>
              <option value="<?php echo $fromyear; ?>" selected="selected"><?php echo $fromyear; ?></option>
              <?php
				}
				else
				{
				?>
              <option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
              <?php
				}
				?>
              <?php
				for ($i=2013; $i<=2020; $i++)
				{
				?>
              <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
              <?php
				}
				?>
            </select>
          </span></span></td>
		  <td width="300" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>To Month / Year </strong></td>
          <td width="53" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <select name="tomonth" id="tomonth">
            <?php
				if ($tomonth != '')
				{
				?>
            <option value="<?php echo $tomonth; ?>" selected="selected"><?php echo $tomonth; ?></option>
            <?php
				}
				else
				{
				?>
            <option value="<?php echo date('m'); ?>"><?php echo date('m'); ?></option>
            <?php
				}
				?>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select></td>
          <td width="6" align="left" valign="center"  bgcolor="#FFFFFF" class="style1">/</td>
          <td width="267" align="left" valign="center"  bgcolor="#ffffff"><span class="style1"><span class="bodytext31">
            <select name="toyear" id="toyear">
              <?php
				if ($toyear != '')
				{
				?>
              <option value="<?php echo $toyear; ?>" selected="selected"><?php echo $toyear; ?></option>
              <?php
				}
				else
				{
				?>
              <option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
              <?php
				}
				?>
              <?php
				for ($i=2013; $i<=2020; $i++)
				{
				?>
              <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
              <?php
				}
				?>
            </select>
          </span></span></td>
         
        </tr>
				<tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" colspan="3">&nbsp;</td>
                      <td colspan="5" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
                    </tr>
                  </tbody>
                </table>
              </form>		</td>
	 </tr>  
	  <tr><td>&nbsp;</td></tr>		        
      <tr>
	  <?php if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			if($cbfrmflag1 == 'cbfrmflag1'){ ?>

	  <tr><form action="vaccinationlist.php" name="checklist" method="post">
        <td><table width="60%" height="80" border="0" 
            align="left" cellpadding="2" cellspacing="0" 
            bordercolor="#666666" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" >
          <tbody>
            <tr>
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext31">
                <div align="left"><strong>Vaccination List </strong></div></td>
			    </tr>
	
            <tr>
			  <td width="3%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno</strong></div></td>
              <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Vaccination</strong></div></td>
				 <td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Description</strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong><?php echo $monthName." ".$fromyear; echo " to ".$tomonthName." ".$toyear;?></strong></div></td>
				
           </tr>
			<?php
			
			$colorloopcount = '';
			$sno = '';
			?>
			<tr bgcolor="#ecf0f5">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">1</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">BCG</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query1 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'BCG' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res1 =  mysqli_fetch_array($exec1);
				echo $res1['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#ecf0f5">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">ABOVE 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query2 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'BCG' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('DAYS','MONTHS')";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res2 =  mysqli_fetch_array($exec2);
				echo $res2['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">2</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">OPV 0</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">Birth Dose</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query3 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'OPV 0' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS','MONTHS') and age between '1' and '30'";
				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res3 =  mysqli_fetch_array($exec3);
				echo $res3['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#ecf0f5">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">3</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">OPV 1</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query4 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'OPV 1' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res4 =  mysqli_fetch_array($exec4);
				echo $res4['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">4</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">OPV 2</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query5 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'OPV 2' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res5 =  mysqli_fetch_array($exec5);
				echo $res5['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#ecf0f5">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">5</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">OPV 3</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query6 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'OPV 3' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res6 =  mysqli_fetch_array($exec6);
				echo $res6['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">6</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">DPT/HEP+HIB1</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query7 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'DPT/HEP+HIB1' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res7 =  mysqli_fetch_array($exec7);
				echo $res7['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#ecf0f5">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">7</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">DPT/HEP+HIB2</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query8 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'DPT/HEP+HIB2' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res8 =  mysqli_fetch_array($exec8);
				echo $res8['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">8</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">DPT/HEP+HIB3</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query9 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'DPT/HEP+HIB3' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res9 =  mysqli_fetch_array($exec9);
				echo $res9['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#ecf0f5">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">9</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">PNEUMOCCAL 1</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query10 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'PNEUMOCCAL 1' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res10 =  mysqli_fetch_array($exec10);
				echo $res10['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">10</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">PNEUMOCCAL 2</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query11 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'PNEUMOCCAL 2' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 =  mysqli_fetch_array($exec11);
				echo $res11['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#ecf0f5">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">11</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">PNEUMOCCAL 3</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query12 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'PNEUMOCCAL 3' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res12 =  mysqli_fetch_array($exec12);
				echo $res12['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">12</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">MEASLES</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query13 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'MEASLES' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res13 =  mysqli_fetch_array($exec13);
				echo $res13['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#ecf0f5">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">13</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">YELLOW FEVER</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query14 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'YELLOW FEVER' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res14 =  mysqli_fetch_array($exec14);
				echo $res14['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">14</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">FULLY IMMMUNIZED CHILDREN</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query15 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'FULLY IMMMUNIZED CHILDREN' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res15 =  mysqli_fetch_array($exec15);
				echo $res15['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#ecf0f5">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">15</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">ADVERSE EVENTS FOLLOWING IMMUNIZATION</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query16 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'ADVERSE EVENTS FOLLOWING IMMUNIZATION' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res16 =  mysqli_fetch_array($exec16);
				echo $res16['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">16</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">TETANUS TOXIOD FOR PREGNANT WOMEN</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">1st DOSE</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query17 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'TETANUS TOXIOD FOR PREGNANT WOMEN' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and `dose` = '1st dose'";
				$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query17".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res17 =  mysqli_fetch_array($exec17);
				echo $res17['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">2nd DOSE</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query18 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'TETANUS TOXIOD FOR PREGNANT WOMEN' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and `dose` = '2nd dose'";
				$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res18 =  mysqli_fetch_array($exec18);
				echo $res18['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">3rd DOSE</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query19 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'TETANUS TOXIOD FOR PREGNANT WOMEN' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and `dose` = '3rd dose'";
				$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query19".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res19 =  mysqli_fetch_array($exec19);
				echo $res19['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">4th DOSE</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query20 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'TETANUS TOXIOD FOR PREGNANT WOMEN' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and `dose` = '4th dose'";
				$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res20 =  mysqli_fetch_array($exec20);
				echo $res20['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">5th DOSE</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query21 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'TETANUS TOXIOD FOR PREGNANT WOMEN' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and `dose` = '5th dose'";
				$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res21 =  mysqli_fetch_array($exec21);
				echo $res21['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#ecf0f5">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">17</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">TETANUS TOXOID FOR TRAUMA</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">1st DOSE</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query22 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'TETANUS TOXOID FOR TRAUMA' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and `dose` = '1st dose'";
				$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res22 =  mysqli_fetch_array($exec22);
				echo $res22['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#ecf0f5">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">2nd DOSE</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query23 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'TETANUS TOXOID FOR TRAUMA' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and `dose` = '2nd dose'";
				$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res23 =  mysqli_fetch_array($exec23);
				echo $res23['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#ecf0f5">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">3rd DOSE</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query24 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'TETANUS TOXOID FOR TRAUMA' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and `dose` = '3rd dose'";
				$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res24 =  mysqli_fetch_array($exec24);
				echo $res24['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#ecf0f5">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">4th DOSE</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query25 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'TETANUS TOXOID FOR TRAUMA' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and `dose` = '4th dose'";
				$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res25 =  mysqli_fetch_array($exec25);
				echo $res25['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#ecf0f5">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">5th DOSE</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query26 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'TETANUS TOXOID FOR TRAUMA' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and `dose` = '5th dose'";
				$exec26 = mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in Query26".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res26 =  mysqli_fetch_array($exec26);
				echo $res26['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">18</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">VIT A(SUPPLEMENTAL)</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">UNDER 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query27 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'VIT A(SUPPLEMENTAL)' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('YEARS')";
				$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res27 =  mysqli_fetch_array($exec27);
				echo $res27['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">ABOVE 1</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query28 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'VIT A(SUPPLEMENTAL)' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('DAYS','MONTHS')";
				$exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query28".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res28 =  mysqli_fetch_array($exec28);
				echo $res28['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">LACTATING MOTHERS</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center">Counts</div></td>
				
           </tr>
		   <tr bgcolor="#ecf0f5">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">19</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">VIT A (THERAPUTIC)</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">2-5 Months</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query30 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'VIT A (THERAPUTIC)' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('DAYS','YEARS') and age between '2' and '5'";
				$exec30 = mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die ("Error in Query30".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res30 =  mysqli_fetch_array($exec30);
				echo $res30['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#ecf0f5">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">6-11 Months</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query31 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'VIT A (THERAPUTIC)' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('DAYS','YEARS') and age between '6' and '11'";
				$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res31 =  mysqli_fetch_array($exec31);
				echo $res31['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#ecf0f5">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">12-59 Months</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query32 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'VIT A (THERAPUTIC)' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('MONTHS','DAYS') and age between '1' and '4'";
				$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res32 =  mysqli_fetch_array($exec32);
				echo $res32['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#ecf0f5">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">ADULTS</div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query33 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'VIT A (THERAPUTIC)' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear and ageduration NOT IN('MONTHS','DAYS') and age NOT IN('1','2','3','4')";
				$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res33 =  mysqli_fetch_array($exec33);
				echo $res33['count'];
				?></div></td>
				
           </tr>
		   <tr bgcolor="#CBDBFA">
			  <td width="3%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">20</div></td>
              <td width="10%"  align="left" valign="center" 
                 class="bodytext31"><div align="left">SQUINT/WHITE EYE REFLECTION</div></td>
				 <td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="left"></div></td>
				<td width="5%"  align="left" valign="center" 
                 class="bodytext31"><div align="center"><?php 
				$query34 = "SELECT count(`auto_number`) as count FROM `vaccination` WHERE `vaccine` = 'SQUINT/WHITE EYE REFLECTION' and MONTH(`recorddate`) between $frommonth and $tomonth and YEAR(`recorddate`) between $fromyear and $toyear";
				$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res34 =  mysqli_fetch_array($exec34);
				echo $res34['count'];
				?></div></td>
				
           </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"></td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              
   	       </tr>
          </tbody>
		  
        </table>
      </td> </form>
  </tr><?php } ?>
	</table>
	  
	
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

