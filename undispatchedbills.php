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
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 day'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 day'));
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



$query7 = "select * from completed_billingpaylater order by auto_number desc limit 0, 1";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
$res7 = mysqli_fetch_array($exec7);
$printno = $res7['printno'];
if($printno == '')
{
	$printnumber = '1';
}
else
{
	$printnumber = $printno + 1;
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if (isset($_REQUEST["printno"])) { $printno = $_REQUEST["printno"]; } else { $printno = ""; }
if($st == 'printsuccess')
{
?>
<script>
window.open("print_deliveryreportsubtype1.php?printno=<?php echo $printno; ?>");
window.open("print_deliveryreportsubtype_xl.php?printno=<?php echo $printno; ?>");
</script>
<?php
}
?>

<style type="text/css">
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

if(document.querySelector('input[name="types"]:checked').value==1){
window.open("print_deliverysubpdf2.php?subtype="+document.getElementById("searchsubtypeanum1").value+"&ADate1="+document.getElementById("ADate1").value+'&ADate2='+document.getElementById("ADate2").value+'',"_blank");
}
else{
window.open("print_deliverysubpdf2xl.php?subtype="+document.getElementById("searchsubtypeanum1").value+"&ADate1="+document.getElementById("ADate1").value+'&ADate2='+document.getElementById("ADate2").value+'',"_blank");
}
return false;
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
.imgloader { background-color:#FFFFFF; }
#imgloader1 {
    position: absolute;
    top: 158px;
    left: 487px;
    width: 28%;
    height: 24%;
}
</style>



<body>
<div align="center" class="imgloader" id="imgloader" style="display:none;">
	<div align="center" class="imgloader" id="imgloader1" style="display:;">
	    <p style="text-align:center;" id='claim_msg'></p>
		<p style="text-align:center;"><strong>Processing <br><br> Please be patient...</strong></p>
		<img src="images/ajaxloader.gif">
	</div>
</div>
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
    <td  valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="">
        <form name="cbform1" method="post" action="" >
		<table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Undispatched Bills</strong></td>
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
            <!--<tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Subtype</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <span class="bodytext32">
                <input name="searchsuppliername1" type="text" id="searchsuppliername1" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
                </span>
                <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
			  <input name="searchsubtypeanum1" id="searchsubtypeanum1" value="<?php echo $searchsubtypeanum1; ?>" type="hidden">
              </span></td>
           </tr> -->

			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td  align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $ADate1; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td  align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $ADate2; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
						<tr>
  			  <td  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td  align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 
				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">
                    <option value="All">All</option>
					<?php
					$query1 = "select * from master_location where status=''  order by locationname";
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
			   <td  align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
			  </tr>
			<!--<tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <span class="bodytext32">
                <input type='radio' value='1' id='types' name='types' checked> <strong>PDF </strong>&nbsp;&nbsp;
				<input type='radio' value='2' id='types' name='types' > <strong>Excel </strong>
              </span></td>
           </tr>-->	
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit"  value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
            </tr>
			  </tbody>
        </table>
	   </td>
      </tr>
	  <tr><td  align="left" colspan="4" valign="middle"  >&nbsp;</td></tr>
			<?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
                 
				if($location=='All')
				{
				$pass_location = "locationcode !=''";
				}
				else
				{
				$pass_location = "locationcode ='$location'";
				}	
				 
				 $query_acc = "SELECT * FROM finance_ledger_mapping WHERE map_anum = '20' AND record_status <> 'deleted'";
				$exec_acc = mysqli_query($GLOBALS["___mysqli_ston"], $query_acc) or die ("Error in Query_acc".mysqli_error($GLOBALS["___mysqli_ston"]));
				$ledgername = '';
				$res_acc = mysqli_fetch_array($exec_acc);

				$accountcode1 = $res_acc['ledger_id'];
				$accountname1 = trim($res_acc['ledger_name']);

				//$query24 = "select * from print_deliverysubtype where date(updatedatetime) between '$ADate1' and '$ADate2' and status <> 'deleted' order by updatedatetime desc";

				 $query24 = "select * from (select billno as billno,billdate as billdate,patientname as patientname,patientcode as patientcode,subtype as subtype,accountname as accountname,totalamount as amount,accountnameid	as	accountid from billing_paylater where  completed!= 'completed' and billdate between '$ADate1' and '$ADate2' and accountnameano!='603' and $pass_location group by billno
				Union all
				select docno as billno,recorddate as billdate,patientname as patientname,patientcode as patientcode,'' as subtype,'$accountname1' as accountname,finamount as amount,accountcode	as	accountid from billing_ipnhif where   completed != 'completed' and recorddate between '$ADate1' and '$ADate2'	and	finamount>0 and $pass_location
				Union all
				select billno as billno,billdate as billdate,patientname as patientname,patientcode as patientcode,subtype as subtype,accountname as accountname,totalamount as amount,accountnameid	as	accountid from billing_ip where completed <> 'completed' and billdate between '$ADate1' and '$ADate2' and accountnameano!='603' and $pass_location
				union all
				select billno as billno,billdate as billdate,patientname as patientname,patientcode as patientcode,subtype as subtype,accountname as accountname,totalamount as amount,accountnameid	as	accountid from billing_ipcreditapprovedtransaction where   completed <> 'completed' and billdate between '$ADate1' and '$ADate2' and accountnameano!='603' and $pass_location group by billno ) as a order by a.billdate
";
			?>

			<tr>
               <td colspan="4" >
			     <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
						 bordercolor="#666666" cellspacing="0" cellpadding="4" width="90%" 
						 align="left" border="0">
                         <tr>
						<td colspan="8" align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><a target="_blank" href="print_undispatchedbills.php?cbfrmflag1=cbfrmflag1&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&location=<?php echo $location;?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></div></td>
                </tr>
						 <tr>
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31" width=""><strong>Sno</strong></td>
						  <!--<td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="5%"><strong>Batch</strong></td>-->
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width=""><strong>Bill No</strong></td>
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width=""><strong>Bill Date</strong></td>
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width=""><strong>Patient Name</strong></td>
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width=""><strong>Patient Code</strong></td>
						 <!-- <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="10%"><strong>Visit Code</strong></td>-->
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width=""><strong>Subtype</strong></td>
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width=""><strong>Account</strong></td>
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width=""><strong>Bill Amt.</strong></td>
						  <!--<td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="15%"><strong>Delivery By</strong></td>
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="25%"><strong>Delivery Date</strong></td>-->
						</tr>
                        
						<?php
						$colorloopcount = 0;
						$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
		                while($res24 = mysqli_fetch_array($exec24)) {

						//$accountnameid=$res24['accountnameid'];
		                //$isnhif=$res24['isnhif'];
						$billno=$res24['billno'];
						$accountname=$res24['accountname'];
						 $accountid=$res24['accountid'];
						$checksql="select *	from completed_billingpaylater where billno='$billno' and accountnameid='$accountid'";
						$execs3d = mysqli_query($GLOBALS["___mysqli_ston"], $checksql) or die ("Error in checksql".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res2num = mysqli_num_rows($execs3d);	
						if($res2num>0){
							continue;
							}

						$subtype=$res24['subtype'];
                        if($subtype==''){
						$sqlmain="select subtype from master_transactionpaylater where billnumber='$billno' and accountname='$accountname'";
					    $execs3 = mysqli_query($GLOBALS["___mysqli_ston"], $sqlmain) or die ("Error in sqlmain".mysqli_error($GLOBALS["___mysqli_ston"]));
					    $ress3 = mysqli_fetch_array($execs3);
					    $subtype = $ress3['subtype'];
						}

                        
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
			            <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
						<!--<td class="bodytext31" valign="center"  align="left"><?php //echo $res24['printno']; ?></td>-->
						<td class="bodytext31" valign="center"  align="left"><?php echo $res24['billno']; ?></td>
						<td class="bodytext31" valign="center"  align="left"><?php echo $res24['billdate']; ?></td>
						<td class="bodytext31" valign="center"  align="left"><?php echo $res24['patientname']; ?></td>
						<td class="bodytext31" valign="center"  align="left"><?php echo $res24['patientcode']; ?></td>
						<!--<td class="bodytext31" valign="center"  align="left"><?php //echo $res24['visitcode']; ?></td>-->
						<td class="bodytext31" valign="center"  align="left"><?php echo $subtype; ?></td>
						<td class="bodytext31" valign="center"  align="left"><?php echo $res24['accountname']; ?></td>
						<td class="bodytext31" valign="center"  align="right"><?php echo number_format($res24['amount'],2,'.',','); ?></td>
						<!--<td class="bodytext31" valign="center"  align="left"><?php //echo $res24['username']; ?></td>
						<td class="bodytext31" valign="center"  align="left"><?php //echo $res24['updatedatetime']; ?></td>-->

                       </tr>
					   <?php } ?>


                 </table>
			   
			   </td>
			</tr>

			<?php } ?>
        
		</form>		
      <tr>
        <td>&nbsp;</td>
      </tr>
       
	  
    </table>
	</td>
	</tr>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
