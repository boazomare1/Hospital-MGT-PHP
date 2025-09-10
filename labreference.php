<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');


if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag2 = $_POST['frmflag2'];



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
}


?>
<?php
if (isset($_REQUEST["close"])) { $close = $_REQUEST["close"]; } else { $close = ""; }
//echo $close;
?>
<?php if($close == 1) {

echo "<script language=javascript>\n".

" window.close();\n".
"</script>\n";
exit();
}
?>

<?php

if (isset($_REQUEST["callfrom"])) { $callfrom = $_REQUEST["callfrom"]; } else { $callfrom = ""; }
if(isset($_REQUEST['itemcode'])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }
if(isset($_REQUEST['reference'])) { $reference = $_REQUEST["reference"]; } else { $reference = ""; }

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

<script>

function refsearch(number,val)
{
var number = number;
var resvalue = document.getElementById("res"+val+"").value;
window.opener.document.getElementById("result"+number+"").value = resvalue;
//window.opener.document.getElementById("result"+number+"").focus();
window.close();
}
</script>


<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 15px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
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
.bali
{
text-align:right;
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript">
function Colfunc(id)
{
document.getElementById(id).style.backgroundColor = "#00FF00";
}
function ReColfunc(id)
{
document.getElementById(id).style.backgroundColor = "#FFFFFF";
}
</script>
<body>
<table width="100%" border="1" cellspacing="4" cellpadding="4">
     	
	        
           <?php
            $colorloopcount ='';
			$sno = '0';
			$i = 1;
			
			$query55="select * from labanalyzervalues where itemcode='$itemcode' and refanum = '$reference' and status <> 'deleted'"; 
			$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55);
			$num1=mysqli_num_rows($exec55);
			while($res55=mysqli_fetch_array($exec55))
			{
			$resultvalue = $res55['resultvalue'];
			$sno = $sno + 1;
			?>
       		<tr bgcolor="#FFFFFF" onClick="return refsearch('<?php echo $callfrom; ?>','<?php echo $sno; ?>')" onMouseOver="return Colfunc('<?php echo $sno; ?>')" onMouseOut="return ReColfunc('<?php echo $sno; ?>')" id="<?php echo $sno; ?>">
			 <td width="12%"  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sno; ?></div></td>
			  <td width="88%"  align="left" valign="center" class="bodytext31"><div align="center"><input type="hidden" id="res<?php echo $sno; ?>" value="<?php echo $resultvalue; ?>"><strong><?php echo $resultvalue; ?></strong></div></td>
 			 </tr>
			  
		   <?php 
		   $i = $i+1;
		  }
		   ?>   		
		  
		</table>  
</body>
</html>

