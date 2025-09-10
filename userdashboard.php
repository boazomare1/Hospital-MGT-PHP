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
$res27submenulink = '';
$errmsg = '';
$res27status = '';

if(isset($_POST['save']))
   {
   $reportlink = $_POST['skin'];
   $query27="select * from userselected_report where submenulink = '$reportlink' and username = '$username' ";
   $exec27=mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   	while ($res27 = mysqli_fetch_array($exec27))
	 {
   $res27submenulink = $res27['submenulink'];
   $res27status = $res27['status'];
     }
       if($res27status != '')
	    {
		   $query30="update userselected_report set status  = 'active' where submenulink = '$res27submenulink' ";
		   $exec30=mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	    } 		 
       if($res27submenulink != $reportlink || $res27submenulink == '')
	    {
	   $query26="insert into userselected_report(submenulink,username ) values ('$reportlink', '$username')";
	   $exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        }
    }
	
if(isset($_POST['delete']))
   {
   $reportlinks = $_POST['skin'];
   $query29="update userselected_report set status  = 'deleted' where submenulink = '$reportlinks' and username = '$username'  ";
   $exec29=mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   } 
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

<script language="JavaScript" type="text/javascript"> 
function makeFrame() { 
	url = document.getElementById('skin').value;
	//alert(url);
	
	if(!document.getElementById(url))
	 {
	   ifrm = document.createElement("IFRAME"); 
	   ifrm.id = url;
	   ifrm.setAttribute("src",url); 
	   ifrm.style.width = 1120+"px"; 
	   ifrm.style.height = 150+"px"; 
	   document.body.appendChild(ifrm); 
      }
	  else
	  {
	  var iframebox = document.getElementById(url).style.display = 'block';
	  }
} 
function hideIFrame()
	{
		url = document.getElementById('skin').value;
		var iframebox = document.getElementById(url).style.display = 'none';   
	}
</script> 

 <script type="text/javascript" language="javascript">
        function fun() {
            var div1 = document.getElementById("ifrOne");
			//alert(div1);
            if (div1.style.width != "100px") {
                w = div1.style.width;
                h = div1.style.height;
                div1.style.width = "1000px";
                div1.style.height = "1000px";
            }
            else
             {
                div1.style.width = w;
                div1.style.height = h;
                }
            return false;
        }
</script>
<script>
function viewReport()
 {
 var x = document.getElementById("skin").selectedIndex;
window.open((document.getElementsByTagName("option")[x].value),"OriginalWindowA4",'width=922,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
  }
</script>
<style>
.btnClick {position:absolute; margin-left:520px; float:left;  };
</style>

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
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td><?php echo $errmsg; ?></td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
      <form name="frmsales" id="frmsales" method="post" action="userdashboard.php" onKeyDown="return disableEnterKey(event)">
	 <td>
	  <table>
	   <tr> <div style="float:left; width:1500px;" id="idiv">
	    <?php 
			$query22 = "select * from userselected_report where status <> 'deleted' and username = '$username' ";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res22 = mysqli_fetch_array($exec22))
			{
   			 $no = 1;
			   $res22submenulink = $res22['submenulink']; 
		  ?>
			  <div id="<?php echo $res22submenulink; ?>">
			  <iframe width="600" height="250" src= "<?php echo $res22submenulink; ?>" id="ifrOne" name="ifrOne" style="float:left"></iframe>
		  </div>
		  <?php 
		  $no++;
		  }
		  ?>
		  </div>
	   </tr>
	   
	   <tr>
         <td valign="top">
	          <select id="skin" name="skin">
<!--			  <option value="" selected="selected">Select Report</option>
-->                 <?php 
				  $query21 = "select * from master_employeerights where username= '$username' group by submenuid";
				   $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($res21 = mysqli_fetch_array($exec21))
					{						$res21submenuid = $res21['submenuid'];
						$query2 = "select * from master_menusub where mainmenuid IN ('MM006', 'MM010', 'MM002', 'MM030') and submenuid= '$res21submenuid' and status <> 'deleted' ";
						$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res2 = mysqli_fetch_array($exec2))
						 {
						$res2submenutext= $res2['submenutext'];
						$res2submenulink = $res2['submenulink'];
						$newsubmenulink = substr($res2submenulink, 0, strpos($res2submenulink, '.'));
						$newsubmenulink = $newsubmenulink.'user'.'.php';
				   ?>
				      <option value="<?php echo $newsubmenulink; ?>"><?php echo $res2submenutext; ?></option>

                   <?php
				         }
				    }
				    ?>		
			  </select>
			    <input type="submit" name='save' value="Save"/>   
  			    <input type="submit" name='delete' value="Delete"/>   
  			    <input type="button" name='click' value="View" onClick="viewReport();"/>   

				<!--<input name="report" type="submit" value="Add" class="button" onClick="makeFrame(); return false"/>
				<input name="report" type="submit" value="Delete" class="button" onClick="hideIFrame(); return false"/>	-->		</td>
	   </tr>
	  </table>	</td>
	  </form>
  </tr>
	</tr>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

