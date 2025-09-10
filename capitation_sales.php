<?php
session_start();
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetitme = date ("d-m-Y H:i:s");
$dateonly=date("Y-m-d");
$suppdateonly = date("Y-m-d");   
$username = $_SESSION['username'];
$ipaddress = $_SERVER['REMOTE_ADDR'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$docno = $_SESSION['docno'];
$financialyear = $_SESSION["financialyear"];
$pagename = 'SALES BILL ENTRY';

$titlestr = 'SALES BILL';

$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	 $res12locationanum = $res["auto_number"];
	 
  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
//to redirect if there is no entry in masters category or item or customer or settings
$query91 = "select count(auto_number) as masterscount from settings_purchase where companyanum = '$companyanum'";
$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die ("Error in Query91".mysqli_error($GLOBALS["___mysqli_ston"]));
$res91 = mysqli_fetch_array($exec91);
$res91count = $res91["masterscount"];
if ($res91count == 0)
{
	header ("location:settingspurchase1.php?svccount=firstentry");
	exit;
}


//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.
if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }
//$defaulttax = $_REQUEST["defaulttax"];
if ($defaulttax == '')
{
	$_SESSION['defaulttax'] = '';
}
else
{
	$_SESSION['defaulttax'] = $defaulttax;
}

//To Edit Bill
if (isset($_REQUEST["delbillst"])) { $delbillst = $_REQUEST["delbillst"]; } else { $delbillst = ""; }
//$delbillst = $_REQUEST["delbillst"];
if (isset($_REQUEST["delbillautonumber"])) { $delbillautonumber = $_REQUEST["delbillautonumber"]; } else { $delbillautonumber = ""; }
//$delbillautonumber = $_REQUEST["delbillautonumber"];
if (isset($_REQUEST["delbillnumber"])) { $delbillnumber = $_REQUEST["delbillnumber"]; } else { $delbillnumber = ""; }
//$delbillnumber = $_REQUEST["delbillnumber"];
if (isset($_REQUEST["delsupplierbillnumber"])) { $delsupplierbillnumber = $_REQUEST["delsupplierbillnumber"]; } else { $delsupplierbillnumber = ""; }



if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
$billnumber = $_REQUEST['billnumber'];
//$store = $_REQUEST['store1'];
$billdate = $_REQUEST['ADate'];
$accountname = $_REQUEST['account'];
$accountcode = $_REQUEST['accountcode'];
//$ponumber = $_REQUEST['pono'];
//$accountssubid = $_REQUEST['accountssubid'];
$amount = $_REQUEST['subtotal'];
$locationcode = $_REQUEST['location'];
$query23 = "select * from master_employee where username='$username'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$res7locationanum = $res23['location'];
$currency1 = explode(',',$_REQUEST['currency']);
$currency=$currency1[1];
$fxrate = $_REQUEST['fxrate'];
$query55 = "select * from master_location where locationcode='$locationcode'";
$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55 = mysqli_fetch_array($exec55);
$locationname = $res55['locationname'];
$coa = $_REQUEST['accountcode'];

	$query1 = "select * from master_accountname where id='$accountcode'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_num_rows());
	$res1 = mysqli_fetch_array($exec1);
	$subtypeanum = $res1['subtype'];
	$paymentanum = $res1['paymenttype'];
	$accountnameano = $res1['auto_number'];
	$query11 = "select * from master_subtype where auto_number='$subtypeanum'";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res11 = mysqli_fetch_array($exec11);
	$subtype = $res11['subtype'];
	$query11 = "select * from master_paymenttype where auto_number='$paymentanum'";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res11 = mysqli_fetch_array($exec11);
	$paymenttype = $res11['paymenttype'];
	$totalquantity = '0';
$billautonumber=0;
$totalbillamount =0;
$totalbillfxamount =0;
for ($i=1;$i<=1000;$i++)
{
//$itemname = $_POST['itemname1'][$key];
if(isset($_REQUEST['itemname'.$i]))
{
$itemname = $_REQUEST['itemname'.$i]?$_REQUEST['itemname'.$i]:'';
$rate = $_REQUEST['rateperunit'.$i]?$_REQUEST['rateperunit'.$i]:'';
$quantity = $_REQUEST['itemquantitys'.$i]?$_REQUEST['itemquantitys'.$i]:'';
$totalamount = $_REQUEST['totalamount'.$i];
$totalquantity = $totalquantity + $quantity;

$fxpkrate = $rate/$fxrate;
$fxtotamount = $totalamount/$fxrate;
$totalbillfxamount = $totalbillfxamount + $fxtotamount;
$totalbillamount = $totalbillamount + $totalamount;
	$remarks=isset($_REQUEST['remarks'])?$_REQUEST['remarks']:'';
			
	if($itemname !='')
	{


		$query4 = "insert into debtors_invoice (companyanum, billnumber, itemname, rate, quantity, subtotal,  totalamount, username, ipaddress, entrydate,accountname,accountcode, locationcode, locationname, remarks, currency, fxrate, fxamount, fxpkrate, fxtotamount) 
			values ('$companyanum', '$billnumber', '$itemname', '$rate', '$quantity', '$totalamount', '$totalamount', '$username', '$ipaddress', '$billdate', '$accountname','$accountcode',  '$locationcode', '$locationname','$remarks','$currency','$fxrate','$fxrate','$fxpkrate','$fxtotamount')";
		
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
			
}

}
 $query43="insert into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,financialyear,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,locationname,locationcode,accountnameano,accountnameid,subtypeano,billbalanceamount,billamount,currency,fxrate,fxamount)values('Debtor Invoice',
	          '','','$billdate','$accountname','$billnumber','$ipaddress','$companyanum','$companyname','$financialyear','finalize','$paymenttype','$subtype','$totalbillamount','$username','$updatedatetime','".$locationname."','".$locationcode."','$accountnameano','$accountcode','$subtypeanum','$totalbillamount','$totalbillamount','$currency','$fxrate','$totalbillfxamount')";
	$exec43=mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die("error in query43".mysqli_error($GLOBALS["___mysqli_ston"]));
	

header("location:capitation_sales.php?otcbillnumber=$billnumber");
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST["st"];
if (isset($_REQUEST["banum"])) { $banum = $_REQUEST["banum"]; } else { $banum = ""; }
//$banum = $_REQUEST["banum"];
if ($st == '1')
{
	$errmsg = "Success. New Bill Updated. You May Continue To Add Another Bill.";
	$bgcolorcode = 'success';
}
if ($st == '2')
{
	$errmsg = "Failed. New Bill Cannot Be Completed.";
	$bgcolorcode = 'failed';
}
if ($st == '1' && $banum != '')
{
	$loadprintpage = 'onLoad="javascript:loadprintpage1()"';
}

if ($delbillst == "" && $delbillnumber == "")
{
	$res41suppliername = "";
	$res41suppliercode = "";
	$res41tinnumber = "";
	$res41cstnumber = "";
	$res41address1 = "";
	$res41deliveryaddress = "";
	$res41area = "";
	$res41city = "";
	$res41pincode = "";
	$res41billdate = "";
	$billnumberprefix = "";
	$billnumberpostfix = "";
	$res41suppdateonly ="";
}



$paynowbillprefix = 'DBI-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from debtors_invoice where companyanum = '$companyanum' order by auto_number desc";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$res2billnumber = $res2["billnumber"];
$billdigit=strlen($res2billnumber);
if ($res2billnumber == '')
{
	$billnumber ='DBI-'.'1';
	$openingbalance = '0.00';
}
else
{
	$res2billnumber = $res2["billnumber"];
	$billnumbercode = substr($res2billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumber = 'DBI-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
<?php include ("includes/pagetitle1.php"); ?>
<style type="text/css">

body {
	background-color: #ecf0f5;
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}


</style>
<script src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />      
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css"> 

<script type="text/javascript" src="js/cppurchaseinsertitem_new.js"></script>
<script>

$(function() {
	
$('#account').autocomplete({
		
	source:'ajaxaccountssearchcapitation.php', 
	//alert(source);
	minLength:1,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var accountcode = ui.item.id;
			var accountname = ui.item.accountname;
			$('#accountcode').val(accountcode);
			$('#account').val(accountname);
			
			},
    });
});



</script>
<script>
<?php 
if (isset($_REQUEST["otcbillnumber"])) { $otcbillnumbers = $_REQUEST["otcbillnumber"]; } else { $otcbillnumbers = ""; }
?>
	var otcbillnumberr;
	var otcbillnumberr = "<?php echo $otcbillnumbers; ?>";
	//alert(refundbillnumber);
	if(otcbillnumberr != "") 
	{
		window.open("print_capitationsales.php?billnumber="+otcbillnumberr,"OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}	
</script>
<script language="javascript">

function functioncurrencyfx(val)
{	

	var myarr = val.split(",");
	var currate=myarr[0];
	var currency=myarr[1];
	//alert(currate);
	//alert(currency);
	document.getElementById("fxrate").value=  currate;
	//document.getElementById("amounttot").value='';
	//document.getElementById("currencyamt").value='';
	
	
}

function btnDeleteClick(delID){
	var newtotal3;
	var varDeleteID1 = delID;
	var vrate1 =  $("#totalamount"+delID).val();
	var fRet4; 
	fRet4 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet4); 
 	if (fRet4 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	
	var child1 = document.getElementById('idTR'+varDeleteID1); //tr name
    var parent1 = document.getElementById('tblrowinsert'); // tbody name.
//	document.getElementById ('insertrow1').removeChild(child1);
	
	if (child1 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('tblrowinsert').removeChild(child1);

	}
	
	var current=document.getElementById('subtotal').value;
	//var current=Number(currenttotal3.replace(/[^0-9\.]+/g,""));
	//alert(current+"-"+vrate1);
	//alert();
	newtotal3= parseFloat(current) - parseFloat(vrate1);
	//newtotal3=newtotal3	//alert(newtotal3);
	
	document.getElementById('subtotal').value=newtotal3.toFixed(2); 
 

}
function itemtotalamountupdate1()
{
var itemrate=document.getElementById('itemmrp').value;
var itemqty=document.getElementById('itemquantity').value;
newtotal= parseFloat(itemrate) * parseFloat(itemqty);
document.getElementById('itemtotalamount').value=newtotal.toFixed(2);
}

function validate()
{
if(document.getElementById('accountcode').value == '')
{
alert("Please Enter Proper Accountname");
document.getElementById('account').focus();
return false;
}
if(parseInt(document.getElementById('subtotal').value) < 1)
{
alert("Amount can not be Zero");
document.getElementById('itemname').focus();
return false;
}
}
</script>

</head>


<body>
<form name="frmpurchase" id="frmpurchase" method="post" action="capitation_sales.php">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top">
	<table width="1008" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100%"><table width="101%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
		  <tr bgcolor="#011E6A">
		  <td bgcolor="#ecf0f5" class="bodytext3" colspan="7"><strong>Capitation Sales  </strong></td>
          <td colspan="3" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
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
            <tr>
              <td class="bodytext3"><strong>Doc  No. </strong></td>
              <td class="bodytext3"><strong>
                <input type="hidden" name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" size="5" />
                
                
                <input name="billnumber" id="billnumber" value="<?php echo $billnumber; ?>" style="text-align:right" size="8" readonly />
                <input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5">
                
                <input type="hidden" name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" size="5" />
              </strong></td>
              
              <td width="10%" align="left" valign="middle"  bgcolor="" class="bodytext3"><strong>Location</strong></td>
              <td  bgcolor="" class="bodytext3"  colspan="5" ><select name="location" id="location" style="border: 1px solid #001E6A;" onChange="ajaxlocationfunction(this.value);">
              
                  <?php
						
						$query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res = mysqli_fetch_array($exec))
						{
						$reslocation = $res["locationname"];
						$reslocationanum = $res["locationcode"];
						?>
						<option value="<?php echo $reslocationanum; ?>" <?php if($location!='')if($location==$reslocationanum){echo "selected";}?>><?php echo $reslocation;  ?></option>
						<?php 
						}
						?>
                  </select></td>
                   
                  <input type="hidden" name="locationnamenew" value="<?php echo $locationname; ?>">
                <input type="hidden" name="locationcodenew" value="<?php echo $res1locationanum; ?>">
                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
              
              
              <td width="6%" class="bodytext3"><strong>Bill Date </strong></td>
              <td width="15%" class="bodytext3"><span class="bodytext312">
                <input name="ADate" id="ADate" value="<?php echo $dateonly; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate')" style="cursor:pointer"/> </span> </td>
              <td width="0%" class="bodytext3"><div align="right"><strong><!--Tax--></strong></div></td>
              
            </tr>
           
            <tr>
              <td width="5%" align="left" valign="middle" class="bodytext3"><strong>Account   </strong></td>
              <td width="26%" align="left" >
			  <input name="account" id="account" value="<?php echo $res41suppliername; ?>" size="40" autocomplete="off"/></td>
              <td align="left" valign="middle" ><div align="left"><span class="style4">Code</span></div></td>
              <td width="6%" align="left" valign="top" ><span class="bodytext3">
                <input name="accountcode" id="accountcode" value="<?php echo $res41suppliercode; ?>" readonly size="10" rsize="20" />
              </span></td>
              <td width="6%" align="left" valign="middle" class="bodytext3"><strong>Currency</strong></td>
              <td width="13%" align="left" valign="top" ><span class="bodytext311">
              <select  name="currency" id="currency" onChange="return functioncurrencyfx(this.value)" >
                   <option value="">Select Currency</option>
                                    
                    <?php
					$query1currency = "select currency,rate,defaultcurr	 from master_currency where recordstatus = '' ";
					$exec1currency = mysqli_query($GLOBALS["___mysqli_ston"], $query1currency) or die ("Error in Query1currency".mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($res1currency = mysqli_fetch_array($exec1currency))
					{
					$currency = $res1currency["currency"];
					$rate = $res1currency["rate"];
					$defaultcurr = $res1currency["defaultcurr"];
					?>
                  <option value="<?php echo $rate.','.$currency; ?>" <?php if($defaultcurr=='yes') { echo 'selected'; } ?> ><?php echo $currency; ?></option>
                  <?php
					}
					?>
                    
                  
                   </select>
                  <?php
				  if ($delsupplierbillnumber != '')
				  {
				  	$supplierbillnumber = $delsupplierbillnumber; 
				  }
				  else
				  {
				  $supplierbillnumber = '';
				  }
				  ?>
                
				
                  </span></td>
              <td width="8%" align="left" valign="middle" class="bodytext3" ><strong>Fxrate</strong></td>
             <td width="5%" ><span class="bodytext312">
             <input name="fxrate" id="fxrate" value="<?php echo '1'; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" type="text"/>
                <input name="ADate2" id="ADate2" value="<?php echo $suppdateonly; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" type="hidden"/>
                 </span> </td>
            </tr>
			
          </tbody>
        </table></td>
      </tr>
      <tr>
        <td>
		<table id="newtable" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="70%" 
            align="left" border="0">
            <tbody >
              <tr>
                <td width="4%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><strong>No.</strong></td>
				<td width="38%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><strong>Item Name </strong></td>
                <td width="7%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><strong>Price</strong></td>
                <td width="2%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><strong>Qty </strong></td>
               <td width="12%" align="center" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><strong>Total </strong></td>
                <td width="7%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              </tr>

				<tr > <td id="tblrowinsert" colspan="6"> </td> </tr>
            </tbody>
        </table></td>
      </tr>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="70%" 
            align="left" border="0">
          <tbody id="foo">

          
            <tr>
				<td width="2%" align="left" valign="middle"  bgcolor="#CBDBFA" class="bodytext31">
					<input type="hidden" name="dummy1" id="dummy1" style="border: 0px solid #001E6A; background-color:#CBDBFA; text-align:right" value="" size="1" readonly />
					<input type="test" value="1" name="itemserialnumber" id="itemserialnumber" style="text-align:right" size="1" readonly />
				</td>
            
				<td width="26%" align="left" valign="middle"  bgcolor="#CBDBFA" class="bodytext31">
					<input name="itemname" id="itemname" autocomplete="off" style="text-align:left" value="" size="35" />
				</td>
				
				<td width="3%" align="left" valign="middle"  bgcolor="#CBDBFA" class="bodytext31">
					<input onKeyUp="return itemtotalamountupdate1()" name="itemmrp" value="0.00" id="itemmrp" style="text-align:right" size="4" />
				</td>
				
				<td width="7%" align="left" valign="middle"  bgcolor="#CBDBFA" class="bodytext31">
					<input onKeyUp="return itemtotalamountupdate1()" name="itemquantity" value="1" id="itemquantity" style="text-align:right" size="2" />
				</td>
             
				<td width="4%" align="left" valign="middle"  bgcolor="#CBDBFA" class="bodytext31">
					<input name="itemtotalamount" value="0.00" id="itemtotalamount" readonly style="text-align:right" size="4" />
				</td>
				
				<td width="11%" align="left" valign="middle"  bgcolor="#CBDBFA" class="bodytext31">
					<span class="bodytext311">
						<strong>
							<input name="Submit22222" type="button" value="Add" onClick="return insertitem1()" class="button" />
						</strong>
					</span>
				</td>
            </tr>
           
          </tbody>
        </table></td>
      </tr>
      <tr>
        <td class="bodytext31" valign="middle">
		<strong><div align="left">&nbsp;</div>
		</strong></td>
      </tr>
       <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="70%" 
            align="left" border="0">
          <tbody id="foo">
		  <tr>
                   <td colspan="5" align="right" valign="center"  
                bgcolor="#F3F3F3" class="style1" id="tdShowTotalAmount1"></td>
                <td  align="left" valign="center"  colspan="2"
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Total Amount</strong></div></td>
                <td align="left" valign="top" ><span class="bodytext311">
                  <input name="subtotal" id="subtotal" value="0.00" style="text-align:right" size="8"  readonly="readonly" />
                </span></td>
              </tr>

              <tr>
                <td colspan="7" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><span class="bodytext32"><strong><?php //echo $f21;?></strong></span>
                  <input type="hidden" name="footerline3" id="footerline3" size="10" />
                  <span class="bodytext32"><strong><?php //echo $f22;?></strong></span><span class="bodytext311">
                  <input type="hidden" name="footerline4" id="footerline4" size="10" />
                  </span><strong>&nbsp;</strong><span class="bodytext311">
                 <!-- <input type="hidden" name="remarks" id="remarks" style="text-transform:uppercase" size="30" />-->
                  </span></div>                  <div align="left"></div></td>
                <td width="16%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
                   <input name="Submit2223" id="Submit2223" type="submit" onClick="return validate();" value="Save Bill" accesskey="b" class="button" />
                </font></font></font></font></font></div></td>
              </tr>
            </tbody>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      
    </table>
	</td>
	</tr>
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>