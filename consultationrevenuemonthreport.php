<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["frommonth"])) {  $frommonth = $_REQUEST["frommonth"]; } else { $frommonth = ""; }
if (isset($_REQUEST["tomonth"])) {  $tomonth = $_REQUEST["tomonth"]; } else { $tomonth = ""; }
if (isset($_REQUEST["fromyear"])) {  $fromyear = $_REQUEST["fromyear"]; } else { $fromyear = ""; }
if (isset($_REQUEST["toyear"])) {  $toyear = $_REQUEST["toyear"]; } else { $toyear = ""; }
if (isset($_REQUEST["charttype"])) {  $charttype = $_REQUEST["charttype"]; } else { $charttype = ""; }
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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

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

function selectmonth()
{
	if (document.getElementById("month").value == "")
	{
		alert ("Search Month.");
		document.getElementById("month").focus();
		return false;
	}
}
function selectcharttype()
{
	if (document.getElementById("charttype").value == "")
	{
		alert ("Search Chart.");
		document.getElementById("charttype").focus();
		return false;
	}
}

</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.number
{
padding-left:900px;
text-align:right;
font-weight:bold;
}
.bali
{
text-align:right;
}
.style1 {font-weight: bold}
.style2 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><form name="cbform1" method="post" action="consultationrevenuemonthreport.php">
          <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="12" bgcolor="#ecf0f5" class="bodytext3"><strong>Consultation Revenue - Month Wise </strong></td>
              </tr>
        
             <tr>
			 <td width="115" align="left" valign="center"  
                bgcolor="#ffffff" class="style2">From Month/Year </td>
			 <td width="52" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><select name="frommonth" id="frommonth">
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
             </select>
			 </td>
			 
			 <td width="4" align="left" valign="center"  bgcolor="#FFFFFF" class="style1">/</td>
			 <td width="85" align="left" valign="center"  bgcolor="#ffffff"><span class="style1"><span class="bodytext31">
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
			 <td width="96" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><span class="style2">To Month/Year</span></td>
			 <td width="52" align="left" valign="center"  bgcolor="#ffffff" class="style2"><span class="bodytext31">
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
               </select>
			 </span></td>
			 <td width="4" align="left" valign="center"  bgcolor="#FFFFFF" class="style1">/</td>
			 <td width="75" align="left" valign="center"  bgcolor="#ffffff"><span class="style1"><span class="bodytext31">
               <select name="toyear" id="toyear">
                 <?php
				if ($toyear != '')
				{
				?>
                 <option value="<?php echo $toyear; ?>" selected="selected"><?php echo $toyear; ?></option>
				 <?php
                   ?>
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
			 <td width="76" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Chart Type </strong></td>
          <td width="161" align="left" valign="center"  bgcolor="#ffffff"><strong>
            <select name="charttype" id="charttype" required>
			  <?php
				if ($charttype != '')
				{
				?>
                 <option value="<?php echo $charttype; ?>" selected="selected"><?php echo $charttype; ?></option>
				 <?php
				}
				?>
              <option value="Bar">Bar</option>
              <option value="Line">Line</option>
            </select>
          </strong></td>
             </tr>
           
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="11" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" onClick="return selectcharttype();" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      
      
      <tr>
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td>
	<form name="form1" id="form1" method="post" action="labresultsviewlist.php">	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if ($cbfrmflag1 == 'cbfrmflag1')
{
if (isset($_REQUEST["charttype"])) {  $charttype = $_REQUEST["charttype"]; } else { $charttype = ""; }
if (isset($_REQUEST["frommonth"])) {  $frommonth = $_REQUEST["frommonth"]; } else { $frommonth = ""; }
if (isset($_REQUEST["tomonth"])) {  $tomonth = $_REQUEST["tomonth"]; } else { $tomonth = ""; }
if (isset($_REQUEST["fromyear"])) {  $fromyear = $_REQUEST["fromyear"]; } else { $fromyear = ""; }
if (isset($_REQUEST["toyear"])) {  $toyear = $_REQUEST["toyear"]; } else { $toyear = ""; }
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#ecf0f5" cellspacing="0" cellpadding="4" width="802" 
            align="left" border="0">
          <tbody>
		  
		  <?php
		    if($charttype=='Bar') { ?>
		 	<tr>
				<td width="94" align="left" valign="center">
					<?php
                    include_once 'open-flash-chart-1.9.5/php-ofc-library/open_flash_chart_object.php';
					open_flash_chart_object( 750, 250, 'http://'. $_SERVER['SERVER_NAME'] .'/neema/consultationrevenuemonth-bar.php', false );
					
			        $_SESSION['frommonth'] = $_REQUEST["frommonth"]; 
					$_SESSION['tomonth'] = $_REQUEST["tomonth"]; 
					$_SESSION['fromyear'] = $_REQUEST["fromyear"]; 
					$_SESSION['toyear'] = $_REQUEST["toyear"]; 
					?>
				</td>
                </tr>
           <?php } ?>
		   <?php
		    if($charttype=='Line') { ?>
				<tr>
				<td>
					<?php
					include_once 'open-flash-chart-1.9.5/php-ofc-library/open_flash_chart_object.php';
					open_flash_chart_object( 750, 250, 'http://'. $_SERVER['SERVER_NAME'] .'/neema/consultationrevenuemonth-line.php', false );
					
					$_SESSION['frommonth'] = $_REQUEST["frommonth"]; 
					$_SESSION['tomonth'] = $_REQUEST["tomonth"]; 
					$_SESSION['fromyear'] = $_REQUEST["fromyear"]; 
					$_SESSION['toyear'] = $_REQUEST["toyear"]; 
					?>
				 </td>
			</tr>
			  <?php } ?>	
          </tbody>
        </table>
<?php
}
?>	
	  <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	  </form>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

