<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$location =isset( $_REQUEST['location'])?$_REQUEST['location']:'';
$dateonly = date("Y-m-d");
$colorloopcount = "";


if(isset($_REQUEST["viewflag"])){ $viewflag = $_REQUEST["viewflag"];}else{$viewflag = "viewflag";}
if(isset($_REQUEST["ponum"])){ $searchponumber = $_REQUEST["ponum"];}else{$searchponumber = "";}
if(isset($_REQUEST["suppnm"])){ $viewsupplier = $_REQUEST["suppnm"];}else{$viewsupplier = "";}

if(isset($_REQUEST["ADate1"])){ $ADate1 = $_REQUEST["ADate1"];}else{$ADate1 = date('Y-m-d');}
if(isset($_REQUEST["ADate2"])){ $ADate2 = $_REQUEST["ADate2"];}else{$ADate2 = date('Y-m-d');}

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
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />    
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

<script language="javascript">
function ajaxlocationfunction(val)
{ 
if (window.XMLHttpRequest)
					  {// code for IE7+, Firefox, Chrome, Opera, Safari
					  xmlhttp=new XMLHttpRequest();
					  }
					else
					  {// code for IE6, IE5
					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					  }
					xmlhttp.onreadystatechange=function()
					  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;
						}
					  }
					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
					xmlhttp.send();
}
</script>



<!--ENDS-->
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
.style2 {
	COLOR: #3b3b3c;
	FONT-FAMILY: Tahoma;
	text-decoration: none;
	font-size: 11px;
	font-weight: bold;
}
</style>
</head>



<script src="js/datetimepicker_css.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall()">
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
    <td width="" valign="top">
   <table width="" border="0" cellspacing="0" cellpadding="0">
   <?php
     if($viewflag == "viewflag")
	 {
		 	$sno = 0;
			$totamountval = 0;
		  if(isset($_REQUEST["ponumber"])){ $searchponumber = $_REQUEST["ponumber"];}else{$searchponumber = "";}
		  if(isset($_REQUEST["suppnm"])){ $viewsupplier = $_REQUEST["suppnm"];}else{$viewsupplier = "";}
          if(isset($_REQUEST["ADate1"])){ $ADate1 = $_REQUEST["ADate1"];}else{$ADate1 = date('Y-m-d');}
		  if(isset($_REQUEST["ADate2"])){ $ADate2 = $_REQUEST["ADate2"];}else{$ADate2 = date('Y-m-d');}
		  
		  $subpo=$searchponumber;
		  $mlpo=$subpo[0];
		    $mlpo;
   ?>
 	<tr>
     <td>
  		 <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="2" width="1000" align="left" border="0">
          <tbody>
             <tr bgcolor="#011E6A">
                <td colspan="8" bgcolor="#ecf0f5" class="bodytext31" align="left" valign="middle"><strong>GRT Detatiled Report</strong></td>
             </tr>
             <tr>
             	<td colspan="4" bgcolor="#ffffff" align="left" valign="middle" class="bodytext31">PO Number : <strong><?php echo $searchponumber;?></strong></td>
                <td colspan="4" bgcolor="#ffffff" align="right" valign="middle" class="bodytext31"></td>
             </tr>
             <tr bgcolor="#999999">
                <td width="" class="bodytext31" valign="middle"  align="center"><strong>No.</strong></td>
			    <td width=""  align="left" valign="middle"  class="bodytext31"><strong>Date</strong></td>
                <td width=""  align="left" valign="middle"  class="bodytext31"><strong>MRN No</strong></td>
				<td width=""  align="left" valign="middle" class="bodytext31"><strong>Item Code</strong></td>
                <td width=""  align="left" valign="middle" class="bodytext31"><strong>Item Name</strong></td>
				<td width=""  align="left" valign="middle" class="bodytext31"><strong>Rate</strong></td>
                <td width=""  align="center" valign="middle" class="style2">Quantity</td>
               <td width=""  align="right" valign="middle" class="bodytext31"><strong>Amount</strong></td>
		     </tr>    
    
<?php
	
	if(true)
	{
	//GET PURCHASE ORDER DETAILS
	$qrypodetailed = "SELECT entrydate,itemcode,itemname,rate,quantity,username,totalamount,billnumber, grnbillnumber FROM purchasereturn_details WHERE grnbillnumber IN ('".$searchponumber."') AND recordstatus<>'deleted'";
	$execpodetailed = mysqli_query($GLOBALS["___mysqli_ston"], $qrypodetailed) or die ("Error in qrypodetailed".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($respodetailed = mysqli_fetch_array($execpodetailed))
	{
		$billdate = $respodetailed["entrydate"];
		$itemcode = $respodetailed["itemcode"];
		$itemname = $respodetailed["itemname"];
		$rate = $respodetailed["rate"];
		$pkgqnty = $respodetailed["quantity"];
		$username = $respodetailed["username"];
		$billnumber = $respodetailed["grnbillnumber"];
		$fxamount = $respodetailed["totalamount"];
		
		$totamountval = $totamountval + $fxamount;
		
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
				$colorcode = 'bgcolor="#ecf0f5"';
			}
	?>
    <tr <?php echo $colorcode;?>>
    	<td class="bodytext31" valign="middle"  align="center"><?php echo $sno = $sno + 1;?></td>
        <td class="bodytext31" valign="middle"  align="left"><?php echo $billdate;?></td>
         <td class="bodytext31" valign="middle"  align="left"><?php echo $billnumber;?></td>
        <td class="bodytext31" valign="middle"  align="left"><?php echo $itemcode;?></td>
        <td class="bodytext31" valign="middle"  align="left"><?php echo $itemname;?></td>
        <td class="bodytext31" valign="middle"  align="left"><?php echo $rate;?></td>
        <td class="bodytext31" valign="middle"  align="center"><?php echo $pkgqnty;?></td>
        <td class="bodytext31" valign="middle"  align="right"><?php echo  number_format($fxamount, 2, '.', ',');?></td>
    </tr>
    <?php	
	}//while--close
	}
?> 
	<tr>
    	<td colspan="6" bgcolor="#999999">&nbsp;</td>
    	<td class="bodytext31" valign="middle"  align="right" bgcolor="#999999"><strong>Total</strong></td>
        <td class="bodytext31" valign="middle"  align="right" bgcolor="#999999"><strong><?php echo number_format($totamountval, 2, '.', ',');?></strong></td>
        <td class="bodytext31" valign="middle"  align="left">
        	     
        </td>
    </tr> 
         </tbody>
        </table>
       </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    
    <?php
  } //CLOSE -- if ($cbfrmflag1 == 'cbfrmflag1')
  ?>	  
  
    </table>
    </form>
    </td>
    </tr>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

