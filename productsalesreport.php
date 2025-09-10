<?php
session_start();
//echo session_id();
include ("db/db_connect.php");
include ("includes/loginverify.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username=$_SESSION["username"];
$registrationdate = date('Y-m-d');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$docno = $_SESSION['docno'];
$todaydate=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date("Y-m-d");
$time=strtotime($todaydate);
 $month=date("m",$time);
$year=date("Y",$time);
$date=date('Y-m-d');
$cbfrmflag1=isset($_REQUEST['cbfrmflag1'])?$_REQUEST['cbfrmflag1']:'';
$storecode1=isset($_REQUEST['storecode1'])?$_REQUEST['storecode1']:'';
$colorloopcount = '';
$transactiondatefrom = date('Y-m-d', strtotime('-1 week'));
$transactiondateto = date('Y-m-d');
$curryear = date('Y');
 $sno=0;
 
 $totaldiffday='';


	
if (isset($_REQUEST["cbfrmflag1"])) { $frmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];

if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }
if (isset($_REQUEST["genericname"])) { $genericname = $_REQUEST["genericname"]; } else { $genericname = ""; }

//$medicinecode = $_REQUEST['medicinecode'];
if (isset($_REQUEST["itemsearch"])) { $searchmedicinename = $_REQUEST["itemsearch"]; } else { $searchmedicinename = ""; }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }



$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	 $res12locationanum = $res["auto_number"];
	 
  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
?>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css" />  
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script>
$(document).ready(function($){

$("#genericsearch").keydown(function(){
//	alert();
    var genericname=$("#genericsearch").val();
	$('#genericsearch').autocomplete({
		
		
	source:'ajaxmedicinesearch1.php?genericname='+genericname+'&&genericsearch=yes', 
	//alert(source);
	minLength:1,
	delay: 0,
html: true, 
		select: function(event,ui){
			var genericname = ui.item.genericname;
			$('#genericname').val(genericname);
			var itemcode = ui.item.itemcode;
			$('#genericcode').val(genericcode);
			
			},
    });
});



//item search
$("#itemsearch").keydown(function(){
	//alert();
   $("#itemcode").val('');


	var itemsearch=$("#itemsearch").val();
	//alert(genericcode);
$('#itemsearch').autocomplete({
		
	source:'ajaxmedicinesearch1.php?itemsearch='+itemsearch+'&&itemsearch=yes', 
	//alert(source);
	minLength:1,
	delay: 0,
html: true, 
		select: function(event,ui){
			
			var itemcode = ui.item.itemcode;
			$('#itemcode').val(itemcode);
			},
    });


});


});

</script>

<style type="text/css">th {            background-color: #ffffff;            position: sticky;            top: 0;            z-index: 1;        }.bodytext31:hover { font-size:14px; }
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
#position
{
position: absolute;
    left: 830px;
    top: 420;
}
.ui-menu .ui-menu-item{ zoom:2 !important; }

-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>
<script src="datetimepicker1_css.js"></script>
<script src="js/datetimepicker_css.js"></script>

<style>
.hideClass
{display:none;}
</style>

<script language="javascript">

function process1login1()
{
	if (document.form1.username.value == "")
	{
		alert ("Pleae Enter Your Login.");
		document.form1.username.focus();
		return false;
	}
	else if (document.form1.password.value == "")
	{	
		alert ("Pleae Enter Your Password.");
		document.form1.password.focus();
		return false;
	}
}

</script>
<script type="text/javascript">
function validatecheck()
{
var storename=document.getElementById("storesearch").value;
var storecode=document.getElementById("storecode1").value;
if(storename=='' || storecode=='')
{
	alert("Please select the store");
	document.getElementById("storesearch").focus();
	return false;
}
}
</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="99" colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  <td>
  <form name="cbform1" method="post" action="productsalesreport.php" onSubmit="return validatecheck()">
<table width="645" border="0" cellspacing="0" cellpadding="2">

  <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3" cellpadding="4" cellspacing="0"><strong>Product Sales Report</strong></td>
  <tr>
					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Item Search</strong></td>
					  <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
						<input name="itemsearch" type="text" id="itemsearch" value="<?php  if($searchmedicinename!=''){echo $searchmedicinename;  }  ?>" size="50" autocomplete="off">
                        <input type="hidden" name="itemcode" value="<?php if($itemcode!=''){echo $itemcode;  } ?>" id="itemcode"/>
					  </span></td>
  </tr>  <tr>
					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Generic Search</strong></td>
					  <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
						<input name="genericsearch" type="text" id="genericsearch" value="<?php if($genericname!=''){echo $genericname;  } ?>" size="50" autocomplete="off">
                        <input type="hidden" name="genericname" value="<?php if($genericname!=''){echo $genericname;  } ?>" id="genericname"/>
						 <input type="hidden" name="genericcode" value="" id="genericcode"/>

					  </span></td>
  </tr>
  
   <tr>
          <td width="76" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php if($ADate1!=''){echo $ADate1;  } else{ echo $transactiondatefrom; }?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="51" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td colspan="2" width="129" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php if($ADate2!=''){echo $ADate2;  } else {echo $transactiondateto; }?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
		  </tr>

   <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" id="search" />
                          <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
  </tr>
                    
</table>
</form>
<table width="1200" cellpadding="2" cellspacing="0">
  <tr>
            <th align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno</strong></div></th>
				  <th align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Entry Date</strong></div></th>    
              <th align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Doc Number</strong></th>
      <th align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Batch Number</strong></th>
              <th align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></th>
				 <th align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Code</strong></div></th>
				 <th align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Code</strong></div></th>
				<th align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Name</strong></div></th>
              <th align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rate</strong></div></th>
				<th align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Cost Price</strong></div></th>
				<th align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Mark Up</strong></div></th>
				 <th align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Quantity</strong></div></th>
              <th align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Sold By</strong></div></th>
           
				</tr>
 <?php
 if($cbfrmflag1=='cbfrmflag1')
 {
 

 if($itemcode!='' )
 {
 
  $query81 = "select * from master_medicine where itemcode ='$itemcode' and status <> 'deleted' ";
					$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res81 = mysqli_fetch_array($exec81))
					{
					$itemcode = $res81['itemcode'];
										$searchmedicinename = $res81['itemname'];

 $sno=1;
 $colorloopcount=0;
 	?>
				<tr bgcolor="#ecf0f5">
				<td colspan="13" class="bodytext31"><strong><?php echo $searchmedicinename;?></strong></td>
				</tr>
				<?php
 $query8 = "select * from pharmacysales_details where itemcode = '$itemcode' and entrydate BETWEEN '$ADate1' and '$ADate2' ORDER BY entrydate ASC";
					$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res8 = mysqli_fetch_array($exec8))
					{
					$markup=0;
					$docnumber = $res8['docnumber'];
					$ipdocno = $res8['ipdocno'];
					$patientcode = $res8['patientcode'];
					$patientname = $res8['patientname'];
					$visitcode = $res8['visitcode'];
					$rate = $res8['rate'];
					$costprice = $res8['costprice'];
					$batchnumber = $res8['batchnumber'];
					$accountname = $res8['accountname'];
					if($costprice!=0){$markup = (($rate-$costprice)/$costprice)*100;}
				
					
					$quantity = $res8['quantity'];

					$entrydate = $res8['entrydate'];
					$username = $res8['username'];
						
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
				 <tr <?php echo $colorcode; ?>>
    <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $sno++; ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $entrydate; ?></div></td>
					       <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php if($docnumber=='') { echo $ipdocno;} else { echo $docnumber; } ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $batchnumber; ?></div></td>
				     <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $patientname; ?></div></td>
				 <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $patientcode; ?></div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $visitcode; ?></div></td>
                <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $accountname; ?></div></td>  
            <td align="right" valign="center"  
                class="bodytext31"><div align="right"><?php echo number_format($rate,2); ?></div></td>
				 <td align="right" valign="center"  
                class="bodytext31"><div align="right"><?php echo number_format($costprice,2); ?></div></td>
				 <td align="right" valign="center"  
                class="bodytext31"><div align="right"><?php echo number_format($markup,2); ?></div></td>
				<td align="right" valign="center"  
                class="bodytext31"><div align="right"><?php echo intval($quantity); ?></div></td>
				
              <td align="right" valign="center"  
                class="bodytext31"><div align="right"><?php echo $username; ?></div></td>
              
				</tr>

<?php
					}
					
					
					
					?>
					
					<tr bgcolor="#ffffff">
				<td colspan="13" class="bodytext31">&nbsp;</td>
				</tr
					
					><?php
 
 }
 
 
 }
 else
 {
 if($itemcode=='' && $genericname!='')
 
 {
 
  $query81 = "select * from master_medicine where genericname LIKE '$genericname' and status <> 'deleted' ";
					$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res81 = mysqli_fetch_array($exec81))
					{
					$itemcode = $res81['itemcode'];
										$searchmedicinename = $res81['itemname'];

 $sno=1;
 $colorloopcount=0;
 	?>
				<tr bgcolor="#ecf0f5">
				<td colspan="13" class="bodytext31"><strong><?php echo $searchmedicinename;?></strong></td>
				</tr>
				<?php
 $query8 = "select * from pharmacysales_details where itemcode = '$itemcode' and entrydate BETWEEN '$ADate1' and '$ADate2' ORDER BY entrydate ASC";
					$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res8 = mysqli_fetch_array($exec8))
					{
						$markup=0;
					$docnumber = $res8['docnumber'];
					$ipdocno = $res8['ipdocno'];
					$patientcode = $res8['patientcode'];
					$patientname = $res8['patientname'];
					$visitcode = $res8['visitcode'];
					$accountname = $res8['accountname'];
					$rate = $res8['rate'];
					$costprice = $res8['costprice'];
					$batchnumber = $res8['batchnumber'];

					if($costprice!=0){$markup = (($rate-$costprice)/$costprice)*100;}
					
					$quantity = $res8['quantity'];

					$entrydate = $res8['entrydate'];
					$username = $res8['username'];
						
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
			 <tr <?php echo $colorcode; ?>>
    <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $sno++; ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $entrydate; ?></div></td>
					       <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php if($docnumber=='') { echo $ipdocno;} else { echo $docnumber; } ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $batchnumber; ?></div></td>
				     <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $patientname; ?></div></td>
				 <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $patientcode; ?></div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $visitcode; ?></div></td>
				  <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $accountname; ?></div></td>
              <td align="left" valign="center"  
                class="bodytext31"><div align="right"><?php echo number_format($rate,2); ?></div></td>
				 <td align="right" valign="center"  
                class="bodytext31"><div align="right"><?php echo number_format($costprice,2); ?></div></td>
				 <td align="right" valign="center"  
                class="bodytext31"><div align="right"><?php echo number_format($markup,2); ?></div></td>
				<td align="right" valign="center"  
                class="bodytext31"><div align="right"><?php echo intval($quantity); ?></div></td>
				
              <td align="left" valign="center"  
                class="bodytext31"><div align="right"><?php echo $username; ?></div></td>
              
				</tr>

<?php
					}
					
					
					
					?>
					
					<tr bgcolor="#ffffff">
				<td colspan="13" class="bodytext31">&nbsp;</td>
				</tr
					
					><?php
 
 }
 
 
 }
 
 else
 {
  $query81 = "select * from master_medicine where status <> 'deleted' ";
					$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res81 = mysqli_fetch_array($exec81))
					{
					$itemcode = $res81['itemcode'];
										$searchmedicinename = $res81['itemname'];

 $sno=1;
 $colorloopcount=0;
 	?>
				<tr bgcolor="#ecf0f5">
				<td colspan="13" class="bodytext31"><strong><?php echo $searchmedicinename;?></strong></td>
				</tr>
				<?php
 $query8 = "select * from pharmacysales_details where itemcode = '$itemcode' and entrydate BETWEEN '$ADate1' and '$ADate2' ORDER BY entrydate ASC";
					$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res8 = mysqli_fetch_array($exec8))
					{
						$markup=0;
					$docnumber = $res8['docnumber'];
					$ipdocno = $res8['ipdocno'];
					$patientcode = $res8['patientcode'];
					$patientname = $res8['patientname'];
					$visitcode = $res8['visitcode'];
					$rate = $res8['rate'];
					$costprice = $res8['costprice'];
					$batchnumber = $res8['batchnumber'];
					$accountname = $res8['accountname'];
					if($costprice!=0){$markup = (($rate-$costprice)/$costprice)*100;}
					
					$quantity = $res8['quantity'];

					$entrydate = $res8['entrydate'];
					$username = $res8['username'];
						
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
				 <tr <?php echo $colorcode; ?>>
    <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $sno++; ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $entrydate; ?></div></td>
					       <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php if($docnumber=='') { echo $ipdocno;} else { echo $docnumber; } ?></div></td>
				 <td align="left" valign="center"  
                class="bodytext31"><div align="left"><?php echo $batchnumber; ?></div></td>
				     <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $patientname; ?></div></td>
				 <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $patientcode; ?></div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $visitcode; ?></div></td>
               <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><?php echo $accountname; ?></div></td>  
            <td align="right" valign="center"  
                class="bodytext31"><div align="right"><?php echo number_format($rate,2); ?></div></td>
				 <td align="right" valign="center"  
                class="bodytext31"><div align="right"><?php echo number_format($costprice,2); ?></div></td>
				 <td align="right" valign="center"  
                class="bodytext31"><div align="right"><?php echo number_format($markup,2); ?></div></td>
				<td align="right" valign="center"  
                class="bodytext31"><div align="right"><?php echo intval($quantity); ?></div></td>
				
              <td align="left" valign="center"  
                class="bodytext31"><div align="right"><?php echo $username; ?></div></td>
              
				</tr>

<?php
					}
					
					
					
					?>
					
					<tr bgcolor="#ffffff">
				<td colspan="13" class="bodytext31">&nbsp;</td>
				</tr
					
					><?php
 
 }
 }
 }
 }				
 ?>
 </table>
</table>
  </td>
  </tr>
      </table>

      