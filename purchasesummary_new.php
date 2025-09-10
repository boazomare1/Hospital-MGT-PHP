<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$docno = $_SESSION['docno'];
$query1 = "select locationname, locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						 $res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
$res2billnumber="";
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$colorloopcount=0;



//This include updatation takes too long to load for hunge items database.
//include("autocompletebuild_subtype.php");

//include ("autocompletebuild_account3.php");


if (isset($_REQUEST["searchsuppliername1"])) { $searchsuppliername1 = $_REQUEST["searchsuppliername1"]; } else { $searchsuppliername1 = ""; }

if (isset($_REQUEST["searchsubtypeanum1"])) {  $searchsubtypeanum1 = $_REQUEST["searchsubtypeanum1"]; } else { $searchsubtypeanum1 = ""; }


if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; $paymentreceiveddatefrom= $_REQUEST["ADate1"];} else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; $paymentreceiveddateto= $_REQUEST["ADate2"];} else { $ADate2 = ""; }
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
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<!--<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />-->
<!--<script type="text/javascript" src="js/adddate.js"></script>-->
<!--<script type="text/javascript" src="js/adddate2.js"></script>-->
<script type="text/javascript" src="js/autocomplete_subtype.js"></script>
<script type="text/javascript" src="js/autosuggestsubtype.js"></script>

<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl1(document.getElementById("searchsuppliername1"), new StateSuggestions1());
	//var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions()); 

}
function funcOnLoadBodyFunctionCall()
{

	funcCustomerDropDownSearch4();
	
	
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
</style>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<?php include ("js/dropdownlist1scriptingrequestmedicine.php"); ?>
<script type="text/javascript" src="js/autosuggestrequestmedicine12_new.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_requestmedicine.js"></script>
<script src="js/datetimepicker_css.js"></script>
<script language="javascript">
function checkfun()
{
if(document.getElementById("type").value=='')
{
alert("Please Select a Type");
return false;
}
return true;
}
function showsub(subtypeano)
{
if(document.getElementById(subtypeano) != null)
{
if(document.getElementById(subtypeano).style.display == 'none')
{
document.getElementById(subtypeano).style.display = '';
}
else
{
document.getElementById(subtypeano).style.display = 'none';
}
}
}
</script>

<body onLoad="return funcOnLoadBodyFunctionCall();">
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
		
		
              <form name="cbform1" method="post" action="purchasesummary_new.php" >
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Purchase Summary</strong></td>
              </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
			
		  <tr>
		                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Item</td>
						<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $res1locationanum; ?>">

					  <input type="hidden" name="serialnumber" id="serialnumber" value="1">
					  <input type="hidden" name="medicinecode" id="medicinecode" value="">
                        <td colspan="4" bgcolor="#FFFFFF"><input name="medicinename" type="text" id="medicinename" size="35" autocomplete="off" onKeyDown="return StateSuggestionspharm4()" onKeyUp="return funcCustomerDropDownSearch4()"></td>
								   <input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">
			  <input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">
			
				
					   </tr>
            
		   
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                    <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                  </tr>	
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input type="submit" value="Search" name="Submit" onClick="return checkfun();"/>
                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="7%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="14" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					if (isset($_REQUEST["searchmedicineanum1"])) { $searchmedicineanum1 = $_REQUEST["searchmedicineanum1"]; } else { $searchmedicineanum1 = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					//$transactiondatefrom = $_REQUEST['ADate1'];
					//$transactiondateto = $_REQUEST['ADate2'];
					
					//$paymenttype = $_REQUEST['paymenttype'];
					//$billstatus = $_REQUEST['billstatus'];
					
					//$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&username=$username&&companyanum=$companyanum&&searchmedicineanum1=$searchmedicineanum1";//&&companyname=$companyname";
				}
				else
				{
					//$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1ADate1=$ADate1&&ADate2=$ADate2&&username=$username&&companyanum=$companyanum&&searchmedicineanum1=$searchmedicineanum1";//&&companyname=$companyname";
				}
				?>
 				
              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />
&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->
</span></td>  
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Supplier Name</strong></div></td>
				<td width="10%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>  Rate </strong></td>
				<td width="12%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> GRN Date </strong></td>
				<td width="10%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> GRN Quantity </strong></td>
				<td width="12%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> PO Date </strong></td>
				<td width="10%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> PO Quantity </strong></td>
              <td width="10%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>GRN Amount </strong></td>
            
            </tr>
			
			<?php
			
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
				$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&username=$username&&companyanum=$companyanum&&searchmedicineanum1=$searchmedicineanum1";
			
			
			if($searchmedicineanum1=='')
			{
				 $query2212 = "select * from master_medicine where   status <>'DELETED' and itemcode IN (select itemcode from purchase_details where suppliername <> 'OPENINGSTOCK' and entrydate between '$ADate1' and '$ADate2' and suppliercode <> billnumber)";
			}
			else if($searchmedicineanum1!='')
			{
				 $query2212 = "select * from master_medicine where  itemcode='$searchmedicineanum1' and status <>'DELETED' and itemcode IN (select itemcode from purchase_details where entrydate between '$ADate1' and '$ADate2' and suppliername <> 'OPENINGSTOCK' and suppliercode <> billnumber)";
			}
			//echo $query2212;
			$exec2212 = mysqli_query($GLOBALS["___mysqli_ston"], $query2212) or die ("Error in Query2212".mysqli_error($GLOBALS["___mysqli_ston"]));
 			$resnum=mysqli_num_rows($exec2212); 
			while($res2212 = mysqli_fetch_array($exec2212))
			{
			$itemname = $res2212['itemname'];
			$itemcode = $res2212['itemcode'];
			$auto_number = $res2212['auto_number'];

			$sno=1;
			$totalamount = 0;
			$totalquantity = 0;
			$totalpoquantity = 0;	
			$totalrate = 0;	

			/* $query9 = mysql_query("select subtype from master_subtype where auto_number = '$subtypeanum'");
			$res9 = mysql_fetch_array($query9);
			//$itemname = $res9['subtype']; */
			?>
			<tr bgcolor="#cbdbfa">
            <td colspan="9"  align="left" valign="center" bgcolor="#FFF" class="bodytext31" onClick="showsub(<?=$auto_number?>)"><strong><?php echo $itemname; ?> </strong></td>
            </tr> 
			<tbody id="<?=$auto_number?>" style="display:none">
			<?php
		
				 $query221 = "select * from purchase_details where itemcode='$itemcode' and entrydate between '$ADate1' and '$ADate2' and suppliername <> 'OPENINGSTOCK' and suppliercode <> billnumber order by rate ASC";
		
			//echo $query221;  purchaseorder_details
			$exec221 = mysqli_query($GLOBALS["___mysqli_ston"], $query221) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
 			$resnum=mysqli_num_rows($exec221); 
			while($res221 = mysqli_fetch_array($exec221))
			{
			$billnumber = $res221['billnumber'];
			$res21accountnameano=$res221['auto_number'];
			$quantity = $res221['quantity'];
			$suppliername = $res221['suppliername'];
			$rate = $res221['rate'];	
						$grndate = $res221['entrydate'];	
						$ponumber = $res221['ponumber'];
            $query2213 = "select * from purchaseorder_details where itemcode='$itemcode' and billnumber='$ponumber' ";
			$exec2213 = mysqli_query($GLOBALS["___mysqli_ston"], $query2213) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
 			$resnum2=mysqli_num_rows($exec2212); 
			$res2213 = mysqli_fetch_array($exec2213);
			$poquantity = $res2213['quantity'];
			$podate = $res2213['billdate'];	
									

			$amount = $res221['subtotal'];	
			$totalquantity = $totalquantity + $quantity;
			$totalpoquantity = $totalpoquantity + $poquantity;	
			
			$totalrate = $totalrate + $rate;	

			$totalamount = $totalamount + $amount;	
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
		   <td class="bodytext31" valign="center"  align="left"><?=$sno++;?></td>
                <td class="bodytext31" valign="center"  align="left" 
                ><?php echo $suppliername.'-('.$billnumber.')'; ?></td>
                <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($rate,2,'.',','); ?></td>
				  <td class="bodytext31" valign="center"  align="right" 
                ><?php echo $grndate; ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($quantity,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                ><?php echo $podate; ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($poquantity,2,'.',','); ?></td>
				  <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($amount,2,'.',','); ?></td>
				</tr>
				
				<?php
			}
			if($totalquantity > 0.00)
			{
			$avgrate = $totalamount/$totalquantity;
			}
			else{
				$avgrate = 0.00;
			}
				?>
           
			</tbody>
           <tr bgcolor="#CCC">
		   <td class="bodytext31" valign="center"  align="left"></td>
                <td class="bodytext31" valign="center"  align="left" 
                >Total</td>
                <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($avgrate,2,'.',','); ?></td>
				 <td class="bodytext31" valign="center"  align="left"></td>
				  <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($totalquantity,2,'.',','); ?></td>
				 <td class="bodytext31" valign="center"  align="left"></td>
				<td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($totalpoquantity,2,'.',','); ?></td>
				  <td class="bodytext31" valign="center"  align="right" 
                ><?php echo number_format($totalamount,2,'.',','); ?></td>
				</tr>
				
        
		
			   <?php
			   }?>
			 <tr>
			  <td class="bodytext31" valign="center"  align="right"><a href="print_purchasesummary_new.php?<?php echo $urlpath; ?>"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a></td>
			 </tr>
			 <?php
			   }
			   ?>
          </tbody>
        </table></td>
			
      </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
