<?php
session_start();
ini_set('MAX_EXECUTION_TIME', -1);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Employeerightsdetails_submenu.xls"');
header('Cache-Control: max-age=80');

//include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = '';
$companyanum = '';
$companyname = '';
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$searchsuppliername1 = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$totalamount = "0.00";
$totalamount30 = "0.00";
$total60 = "0.00";
$total90 = "0.00";
$total120 = "0.00";
$total180 = "0.00";
$total210 = "0.00";
$totalamount1 = "0.00";
$totalamount301 = "0.00";
$totalamount601 = "0.00";
$totalamount901 = "0.00";
$totalamount1201 = "0.00";
$totalamount1801 = "0.00";
$totalamount2101 = "0.00";
$totalamount2401 = "0.00";
//This include updatation takes too long to load for hunge items database.
//include("autocompletebuild_subtype.php");

//include ("autocompletebuild_account3.php");
// for Excel Export
if (isset($_REQUEST["username"])) { $username = $_REQUEST["username"]; } else { $username = ""; }
if (isset($_REQUEST["companyanum"])) { $companyanum = $_REQUEST["companyanum"]; } else { $companyanum = ""; }
if (isset($_REQUEST["companyname"])) { $companyname = $_REQUEST["companyname"]; } else { $companyname = ""; }
//$sno = $sno + 2;
//echo $companyname;
// for print page
if (isset($_SESSION["username"])) { $username = $_SESSION["username"]; } else { $username = ""; }
if (isset($_SESSION["companyanum"])) { $companyanum = $_SESSION["companyanum"]; } else { $companyanum = ""; }
if (isset($_SESSION["companyname"])) { $companyname = $_SESSION["companyname"]; } else { $companyname = ""; }


if (isset($_REQUEST["searchsuppliername1"])) { $searchsuppliername1 = $_REQUEST["searchsuppliername1"]; } else { $searchsuppliername1 = ""; }

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["searchemployeecode"])) {  $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }
if (isset($_REQUEST["mainmenu"])) {  $mainmenu = $_REQUEST["mainmenu"]; } else { $mainmenu = ""; }

if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

?>
<style type="text/css">
<!--
body {
	
	background-color: #FFFFFF;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
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
.bali
{
text-align:right;
}
</style>
</head>

<body>

<table width="103%" border="0" cellspacing="0" cellpadding="2">
<?php

?>
<tr>
	<td class="bodytext3"  ><strong>Sno.</strong></td>
    <td class="bodytext3"  ><strong>Emp. No.</strong></td>
    <td class="bodytext3"  ><strong>User Name</strong></td>
<?php

$query1mm = "select submenutext from master_menusub where status <> 'deleted' and mainmenuid = '$mainmenu' order by submenuorder";
$exec1mm = mysqli_query($GLOBALS["___mysqli_ston"], $query1mm) or die ("Error in Query1mm".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1mm = mysqli_fetch_array($exec1mm))
{
$mainmenutext = $res1mm["submenutext"];
?>
    <td class="bodytext3" ><strong><?=$mainmenutext;?></strong></td>
  
  <?php
}
?>
		  
  </tr>
   <?php
   
    
  $selec='';
  $colorloopcount=0;
  if($searchemployeecode <>'')
  {
  $query02="select employeename,employeecode from master_employee where employeecode='$searchemployeecode' and status='Active' and is_user like 'yes'";
  }
  else
  {
	   $query02="select employeename,employeecode from master_employee where employeecode<>'' and employeename <>'' and employeecode in (select employeecode from master_employeerights where mainmenuid = '$mainmenu') and  status='Active' and is_user like 'yes'";
  }
  $exe02=mysqli_query($GLOBALS["___mysqli_ston"], $query02);
  while($res02=mysqli_fetch_array($exe02))
  {
	  $employeename=$res02['employeename'];
	  $employeecode=$res02['employeecode'];
	  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				
				$colorcode = 'bgcolor="#FFFFFF"';
				//$colorcode = 'bgcolor="#ecf0f5"';
			}
			
			
			?>
			
            <tr <?php //echo $colorcode; ?>>
  <td class="bodytext3"><?=$colorloopcount;?></td>          
  <td class="bodytext3"><?=$employeecode;?></td>
  <td class="bodytext3"><?=$employeename;?></td>
 
      <?php
  $query1mm = "select submenuid from master_menusub where status <> 'deleted' and mainmenuid = '$mainmenu' order by submenuorder";
$exec1mm = mysqli_query($GLOBALS["___mysqli_ston"], $query1mm) or die ("Error in Query1mm".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1mm = mysqli_fetch_array($exec1mm))
{
$submenuid = $res1mm["submenuid"];

 $query9 = "select employeecode from master_employeerights where employeecode = '$employeecode' and submenuid = '$submenuid'";
$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in query9".mysqli_error($GLOBALS["___mysqli_ston"]));
 $rowcount9 = mysqli_num_rows($exec9);
if ($rowcount9 != 0)
{
	//$selec='src="images/select.png"';
	$selec='Yes';
}
else
{
	//$selec='src="images/deselect.png"';
	$selec='No';
}
?>
    <td class="bodytext3" align="center"><?=$selec;?></td>
  
  <?php

}
?>
</tr>
<?php

}
?>
</table>

</body>

</html>
