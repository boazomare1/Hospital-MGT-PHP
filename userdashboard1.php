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

<!--var x = document.getElementById("skin").selectedIndex;
//alert(document.getElementsByTagName("option")[x].value);-->

<script src="js/datetimepicker_css.js"></script>
<script language="JavaScript">

	function showIFrame(url)
	{
	var container = document.getElementById('container<?php echo $no = 1; ?>');
	var iframebox = document.getElementById('iframebox<?php echo $no = 1; ?>');
	iframebox.src=url;
	container.style.display = 'block';
	}
	
	function hideIFrame(url)
	{
	var container = document.getElementById('container<?php echo $no = 1; ?>');
	var iframebox = document.getElementById('iframebox<?php echo $no = 1; ?>');
	iframebox.src=url;
	container.style.display = 'none';
	}
</script>

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
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
	 <td>
	  <table>
	   <tr>
         <td valign="top">
	          <?php  $no = 1; ?>
	            <div id="container<?php echo $no = 1; ?>" style="display:none;">
				<iframe width="1000" height="150" src="" name="iframe" id="iframebox<?php echo $no = 1; ?>"></iframe>
				</div>
				<div id="container<?php echo $no = 2; ?>" style="display:none;">
				<iframe width="1000" height="150" src="" name="iframe" id="iframebox<?php echo $no = 2; ?>"></iframe>
				</div>
			  <select id="skin">
			    <option value="1">Skin</option>
			    <option value="2">Integeur</option>
			  </select>
				<input name="report" type="submit" value="Add" class="button" onClick="showIFrame('testtemplate.php'); return false"/>
				<input name="report" type="submit" value="Delete" class="button" onClick="hideIFrame('testtemplate.php'); return false"/>	      </td>
	   </tr>
	  </table>	</td>
   </tr>
	</tr>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

