<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$updatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
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
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
 $total = "0.00";


		if (isset($_REQUEST["searchaccoutname"])) { $searchaccoutname = $_REQUEST["searchaccoutname"]; } else { $searchaccoutname = ""; }
		if (isset($_REQUEST["searchaccoutnameanum"])) { $searchaccoutnameanum = $_REQUEST["searchaccoutnameanum"]; } else { $searchaccoutnameanum = ""; }
 

//		//$visitcode = $REQUEST['visitcode'.$key];
//		$billno = $_REQUEST['billno'.$key];
//		$billdate = $_REQUEST['billdate'.$key];
//		$amount = $_REQUEST['amount'.$key];
//		$accountname = $_REQUEST['accountname'.$key];
//		//$completed = $REQUEST['comcheck'.$key];

 
 
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_accounts.php");
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 $locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 	$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res12 = mysqli_fetch_array($exec12);
						
						 $locationname1 = $res12["locationname"];

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];



if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["searchsuppliername1"])) { $searchsuppliername = $_REQUEST["searchsuppliername1"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchsubtypeanum1"])) { $searchsubtypeanum1 = $_REQUEST["searchsubtypeanum1"]; } else { $searchsubtypeanum1 = ""; }
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }


if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }
//$paymenttype = $_REQUEST['paymenttype'];
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }
//$billstatus = $_REQUEST['billstatus'];
//echo $ADate2;



?>

<style type="text/css">
th {
            background-color: #ffffff;
            position: sticky;
            top: 0;
            z-index: 1;
        }

<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma;}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<link href="autocomplete.css" rel="stylesheet">

<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/datetimepicker_css.js"></script>

<script>

$(function() {
	
$('#searchaccoutname').autocomplete({
		
	source:'ajaxaccountnewsearching.php?data_from=account', 
	minLength:1,
	delay: 0,
	html: true, 
		select: function(event,ui){
			
			var searchaccoutname = ui.item.auto_number;
			var accountname = ui.item.accountname;
			$('#searchaccoutname').val(accountname);
			$('#searchaccoutnameanum').val(searchaccoutname);
			
			},
		open: function(event,ui){
			$('#searchaccoutnameanum').val('');
			
			},
    });


$('#searchsuppliername1').autocomplete({
		
	source:'ajaxaccountnewsearching.php?data_from=subtype', 
	minLength:1,
	delay: 0,
	html: true, 
		select: function(event,ui){
			
			var searchaccoutname = ui.item.auto_number;
			var accountname = ui.item.accountname;
			$('#searchsuppliername1').val(accountname);
			$('#searchsubtypeanum1').val(searchaccoutname);
			
			},
		open: function(event,ui){
			
			$('#searchsubtypeanum1').val('');
			
			},
    });

	
});
</script>

<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

<script type="text/javascript">
function clickcheck(cat,val)
{
	//alert(cat);
	//alert(val);
	if(cat=='com')
	{
		document.getElementById("misscheck"+val).checked=false;
		document.getElementById("incomcheck"+val).checked=false;
		}
	else if(cat=='incom')
	{
		document.getElementById("comcheck"+val).checked=false;
		document.getElementById("misscheck"+val).checked=false;
		}
	else 
	{
		document.getElementById("comcheck"+val).checked=false;
		document.getElementById("incomcheck"+val).checked=false;
		}
	}

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
					
//ajax to get location which is selected ends here


window.onload = function () 
{
	//var oTextbox = new AutoSuggestControl1(document.getElementById("searchsuppliername1"), new StateSuggestions1());
	
}
</script>
<script>
function funcAccount1()
{
if((document.getElementById("searchsuppliername").value == "")||(document.getElementById("searchsuppliername").value == " "))
{
alert ('Please Select Account Name');
return false;
}
}
function calprint(){

if((document.getElementById("searchsubtypeanum1").value == ""))
{
alert ('Please Select Sub Type.');
document.getElementById("searchsuppliername1").focus();
return false;
}

return true;
}
</script>
<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
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
.bali
{
text-align:right;
}
.ui-menu .ui-menu-item{ zoom:1 !important; }

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma;}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
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
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="deliveryvsdispatch.php" >
              <!-- <form name="cbform1" method="post" action="" > -->
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Dispatch Claim Invoices </strong></td>
              <td colspan="2" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
						if ($location!='')
						{
						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res12 = mysqli_fetch_array($exec12);
						
						echo $res1location = $res12["locationname"];
						//echo $location;
						}
						else
						{
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						//$res1locationanum = $res1["locationcode"];
						}
						
						

						?>
						
						
                  
                  </td> 
              </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Subtype</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <span class="bodytext32">
                <input name="searchsuppliername1" type="text" id="searchsuppliername1" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
                </span>
                <input name="searchaccoutnameanum" id="searchaccoutnameanum" value="<?php echo $searchaccoutnameanum; ?>" type="hidden">
              </span></td>
           </tr>

            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Account </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <span class="bodytext32">
                <input name="searchaccoutname" type="text" id="searchaccoutname" value="<?php echo $searchaccoutname; ?>" size="50" autocomplete="off" >
                </span>
                <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
			  <input name="searchsubtypeanum1" id="searchsubtypeanum1" value="<?php echo $searchsubtypeanum1; ?>" type="hidden">
              </span></td>
           </tr>
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $ADate1; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $ADate2; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
						<tr>
  			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 
				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">
                    <?php
						
						$query1 = "select * from login_locationdetails where   username='$username' and docno='$docno' order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$loccode=array();
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$locationname = $res1["locationname"];
						$locationcode = $res1["locationcode"];
						
						?>
						 <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
						<?php
						} 
						?>
                      </select>
					 
              </span></td>
			   <td width="10%" align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
			  </tr>
					
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit"  value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" align="left" border="0">
		<tr><td colspan="8">&nbsp;</td></tr>

		<tr bgcolor="#FFFFFF">
		<td class="bodytext31" valign="center"  align="center" width="50px"><strong>S.No</strong></th>
		<th class="bodytext31" valign="center"  align="center" width="300px"><strong>Account</strong></th>
		<th class="bodytext31" valign="center"  align="center" width="50px"><strong>Inv.Delivered(OP)</strong></th>
		<th class="bodytext31" valign="center"  align="center" width="50px"><strong>Inv.Delivered(IP)</strong></th>
		<th class="bodytext31" valign="center"  align="center" width="50px"><strong>Total</strong></th>
		<th class="bodytext31" valign="center"  align="center" width="50px"><strong>Inv.Dispatched(OP)</strong></th>
		<th class="bodytext31" valign="center"  align="center" width="50px"><strong>Inv.Dispatched(IP)</strong></th>
		<th class="bodytext31" valign="center"  align="center" width="50px"><strong>Total</strong></th>
		</tr>
	  <?php
		if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
		if($cbfrmflag1 == 'cbfrmflag1')
		{ 
			$dispatch_tot=0;
		 $delivery_tot=0;
		 $colorloopcount =0;

			$searchsubtypeanum1 = $_REQUEST["searchsubtypeanum1"];
			$searchaccoutnameanum = $_REQUEST["searchaccoutnameanum"];
            if($searchsubtypeanum1!='') {
		      $query25 = "select auto_number,subtype from master_subtype where auto_number = '$searchsubtypeanum1'";
			
			}
			else{
				$query25 = "select auto_number,subtype from master_subtype  order by subtype asc";
             // $query25 = "select subtype,auto_number from print_deliverysubtype where date(updatedatetime) between '$ADate1' and '$ADate2' and status != 'deleted' group by subtype";
			} 
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res25 = mysqli_fetch_array($exec25)){

			$searchsuppliername = $res25['subtype'];
			$auto_numbersuppliername = $res25['auto_number'];


			// $query255a = "select accountname,accountnameid,count(auto_number) as delivery from print_deliverysubtype where   status != 'deleted'  and date(updatedatetime) between '$ADate1' and '$ADate2' and accountnameid like '$accnameid' group by accountnameid ";
			//  $exec255a = mysql_query($query255a) or die ("Error in query255a".mysql_error());
			//  $res2numa = mysql_num_rows($exec255a);

			?>
		<tr>
		<td colspan="8" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $searchsuppliername; ?></strong></td>
        </tr>
		
		<?php

			if($searchaccoutnameanum!='') {
				$query1 = "select * from master_accountname where subtype = '$searchaccoutnameanum' ";
				 // and recordstatus <> 'DELETED'
				}else{
					$query1 = "SELECT * from master_accountname where subtype = '$auto_numbersuppliername' order by accountname ";
				}
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res1 = mysqli_fetch_array($exec1))
				{
					$accname = $res1['accountname'];
					$accnameid = $res1['id'];
			
			// else
			// 	$accname = '';
			// 	$accnameid = '';
		
		 
         $query255 = "select accountname,accountnameid,count(auto_number) as delivery from print_deliverysubtype where   status != 'deleted'  and date(updatedatetime) between '$ADate1' and '$ADate2'";
		 if($accname!=''){
          $query255 .= " and accountnameid like '$accnameid'";
		 }
         $query255 .= " group by accountnameid";

		 $exec255 = mysqli_query($GLOBALS["___mysqli_ston"], $query255) or die ("Error in Query255".mysqli_error($GLOBALS["___mysqli_ston"]));
		 while ($res2 = mysqli_fetch_array($exec255))
		 {
		 	// res2['accountname']
            $query24 = "select count(auto_number) as delivery_ip from print_deliverysubtype where   date(updatedatetime) between '$ADate1' and '$ADate2' and accountnameid like '".$res2['accountnameid']."' and (billno like 'IPF%' ) and status != 'deleted' group by accountnameid";
			$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in query24".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res24 = mysqli_fetch_array($exec24);

			$query26 = "select count(auto_number) as delivery_op from print_deliverysubtype where   date(updatedatetime) between '$ADate1' and '$ADate2' and accountnameid like '".$res2['accountnameid']."' and billno like 'CB-%' and status != 'deleted' group by accountnameid";
			$exec26 = mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in query26".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res26 = mysqli_fetch_array($exec26);


			$query21 = "select count(auto_number) as dispatch_ip from completed_billingpaylater where   accountnameid like '".$res2['accountnameid']."'  and billno like 'IPF%' and billno in (select billno from print_deliverysubtype where   date(updatedatetime) between '$ADate1' and '$ADate2' and accountnameid like '".$res2['accountnameid']."' and billno like 'IPF%' and status != 'deleted') group by accountnameid";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res21 = mysqli_fetch_array($exec21);

			 $query2 = "select count(auto_number) as dispatch_op from completed_billingpaylater where   accountnameid like '".$res2['accountnameid']."' and billno like 'CB-%' and billno in (select billno from print_deliverysubtype where   date(updatedatetime) between '$ADate1' and '$ADate2' and accountnameid like '".$res2['accountnameid']."' and billno like 'CB-%' and status != 'deleted') group by accountnameid";

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec2);

			
			

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

			$dispatch_tot=$dispatch_tot+$res21['dispatch_ip']+$res22['dispatch_op'];
			$delivery_tot=$delivery_tot+$res24['delivery_ip']+$res26['delivery_op'];

			$query_accn = "select auto_number,accountname,id,subtype from master_accountname where  id = '".$res2['accountnameid']."' ";
			// and recordstatus <> 'DELETED' 
			$exec_accn = mysqli_query($GLOBALS["___mysqli_ston"], $query_accn) or die ("Error in Query_accn".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res_accn = mysqli_fetch_array($exec_accn);
			$res_accountname =mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $res_accn['accountname']);

			?>
			<tr <?php echo $colorcode; ?>>
			<td class="bodytext31" valign="center"  align="left" width="50px"><?php echo $colorloopcount; ?></td>
			<td class="bodytext31" valign="center"  align="left" width="300px"><?php echo $res_accountname; ?></td>
			<!-- <td class="bodytext31" valign="center"  align="left" width="300px"><?php  // echo $res2['accountname']; ?></td> -->
			<td class="bodytext31" valign="center"  align="right" width="50px"><?php if($res26['delivery_op']>0) echo $res26['delivery_op']; else echo '0'; ?></td>
			<td class="bodytext31" valign="center"  align="right" width="50px"><?php if($res24['delivery_ip']>0) echo $res24['delivery_ip']; else echo '0'; ?></td>
            <td class="bodytext31" valign="center"  align="right" width="50px"><?php echo $res24['delivery_ip']+$res26['delivery_op']; ?></td>
			<td class="bodytext31" valign="center"  align="right" width="50px"><?php if($res22['dispatch_op']>0) echo $res22['dispatch_op']; else echo '0'; ?></td>
			<td class="bodytext31" valign="center"  align="right" width="50px"><?php if($res21['dispatch_ip']>0) echo $res21['dispatch_ip']; else echo '0'; ?></td>
			<td class="bodytext31" valign="center"  align="right" width="50px"><?php echo $res21['dispatch_ip']+$res22['dispatch_op']; ?></td>
			</tr>
			<?php
		   }
		  }
		}
		 ?>
		<tr >
		<td class="bodytext31" valign="center"  align="left" width="50px"></td>
		<td class="bodytext31" valign="center"  align="right" width="300px"><strong>Grand Total:</strong></td>
		<td class="bodytext31" valign="center"  align="left" width="50px"></td>
		<td class="bodytext31" valign="center"  align="left" width="50px"></td>
		<td class="bodytext31" valign="center"  align="right" width="50px"><strong><?php echo number_format($delivery_tot);?></strong></td>
		<td class="bodytext31" valign="center"  align="left" width="50px"></td>
		<td class="bodytext31" valign="center"  align="left" width="50px"></td>
		<td class="bodytext31" valign="center"  align="right" width="50px"><strong><?php echo number_format($dispatch_tot);?></strong></td>
		</tr>
		 <?php

		}
	  ?>
	    <tr><td colspan="8">&nbsp;</td></tr>
	   </table>
       </td>
      </tr>
       
	  
    </table>
	</td>
	</tr>
</table>
<?php include ("includes/footer1.php"); ?>
    <!-- Modern JavaScript -->
    <script src="js/deliveryvsdispatch-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
