<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$docno = $_SESSION['docno'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$currentdate = date("Y-m-d");

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
		
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
if (isset($_REQUEST["grnno"])) { $grnno = $_REQUEST["grnno"]; } else { $grnno = ""; }


if (isset($_REQUEST["searchsupplier"])) { $searchsupplier = $_REQUEST["searchsupplier"]; } else { $searchsupplier = ""; }
if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }

	$query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	
	$res1location = $res1["locationname"];
	$res1locationcode= $res1["locationcode"];

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'PO-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from purchase_ordergeneration order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='PO-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'PO-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
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
.number
{
padding-left:690px;
text-align:right;
font-weight:bold;
float:right;
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function cbcustomername1()
{
	document.cbform1.submit();
}

</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
<link rel="stylesheet" type="text/css" href="css/autocomplete.css" />  

<!--<script type="text/javascript" src="js/autocomplete_supplier3.js"></script>
<script src="js/autosuggest1suppliersearch1.js"></script>-->
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/jquery.min-autocomplete.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript">
$(function() {
$('#searchsupplier').autocomplete({
	source:'ajaxsuppliernewserach.php', 
	select: function(event,ui){
			var code = ui.item.id;
			var anum = ui.item.anum;
			$('#searchsuppliercode').val(code);
			$('#searchsupplieranum').val(anum);
			},
	html: true
    });
})
</script>	
<script type="text/javascript">

//window.onload = function () 
//{
	//var oTextbox = new AutoSuggestControl(document.getElementById("searchsupplier"), new StateSuggestions());        
//}

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


function loadprintpage1(banum)
{
	var banum = banum;
	window.open("print_bill1_op1.php?billautonumber="+banum+"","Window"+banum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}

function Frmsubmit()
{
	if(document.getElementById("searchsuppliercode").value == "")
	{
		alert("Select Supplier Name");
		document.getElementById("searchsupplier").focus();
		return false;
	}
}
</script>
<script src="js/datetimepicker_css.js"></script>


<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<body>

<?php 
$query1 = "select * from purchasereturn_details where suppliercode='$searchsuppliercode'  and typeofreturn='Process' group by billnumber";
        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));	
					$resnw1=mysqli_num_rows($exec1);
?>
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr><td colspan="1"></td>
  <td colspan="9">
  		<form name="cbform1" method="post" action="viewgrt.php" onSubmit="return Frmsubmit()">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>View GRT</strong></td>
                 <td colspan="1" bgcolor="#ecf0f5" class="bodytext3" align="right"><strong> Location: </strong>
             
            
                  <?php echo $res1location;?>
						
				
                  </td>
              </tr>
              <tr>
              	<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">Supliername </td>
                <td colspan="4" width="19%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
                     	  <input type="hidden" name="autobuildsupplier" id="autobuildsupplier">
						<input type="hidden" name="searchsuppliercode" id="searchsuppliercode" value="<?php echo $searchsuppliercode; ?>">
						<input type="hidden" name="searchsupplieranum" id="searchsupplieranum">
						<input type="text" name="searchsupplier" id="searchsupplier" autocomplete="off" value="<?php echo $searchsupplier; ?>" size="50" >
                           </td>
                    
                        </tr>
                         <tr>
              	<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">GRN No </td>
                <td colspan="4" width="19%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
                     	
						<input type="text" name="grnno" id="grnno" autocomplete="off" value="" size="20" >
                           </td>
                    
                        </tr>
                        <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $currentdate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $currentdate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                 </tr>	
                        
                        <tr>
             
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
				  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
				  <input  type="submit" value="Search" name="Submit" />
		      </td>
            </tr>
          </tbody>
        </table>
</form></td>
  </tr>
  <tr><td colspan="9">&nbsp;</td></tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
	  <?php if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			if ($cbfrmflag1 == 'cbfrmflag1')
			{?>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 
            align="left" border="0">
          <tbody>
             <tr>
              <td width="5%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="9" bgcolor="#ecf0f5" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong>View GRT Details</strong>
                  <label class="number"><<<?php echo $resnw1;?>>></label></div></td>
              </tr>
             <tr>
              
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				 <td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date </strong></div></td>
				<td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>GRN No</strong></div></td>
				<td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>GRT No</strong></div></td>
				<td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Supplier Name</strong></div></td>
				
				<td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action</strong></div></td>
               <td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Print</strong></div></td>
              </tr>
			<?php
			$colorloopcount = '';
			$sno = '';
			
			$query1 = "select * from purchasereturn_details where suppliercode='$searchsuppliercode' and entrydate between '$ADate1' and '$ADate2' and typeofreturn='Process' and grnbillnumber like '%$grnno%' group by billnumber";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));	
			while($res1=mysqli_fetch_array($exec1))
			{
			$date=$res1['entrydate'];
			$grtno=$res1['billnumber'];
			$grnno=$res1['grnbillnumber'];
			$suppliername=$res1['suppliername'];
		//	$invoiceno=$res1['supplierbillnumber'];
		//	$pono=$res1['ponumber'];
			
		//	 $string = substr($pono,0,2);
			/* if($string == 'MR')
			 {
			 $query23 = "select * from materialreceiptnote_details where billnumber='$pono'";
			 $exec23 = mysql_query($query23) or die(mysql_error());
			 $res23 = mysql_fetch_array($exec23);
			 $pono = $res23['ponumber'];
			 }*/
			
			$totalamount = 0;
			
			/*$query36="select * from purchase_details where typeofpurchase='Process' and billnumber='$grnno'";
			$exec36=mysql_query($query36) or die(mysql_error());
			while($res36=mysql_fetch_array($exec36))
			{
			$amount=$res36['totalamount'];
			$totalamount=$totalamount+$amount;
			}
			$totalamount=number_format($totalamount,2);*/
			
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
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $date; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><a href="grnno_grn.php?grn=<?php echo $grnno; ?>" target="_blank"><?php echo $grnno; ?></a></div></td>
                	<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $grtno; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $suppliername; ?></div></td>
				
			       
			      <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><a target="_blank" href="viewgrt_made.php?grt=<?php echo $grtno; ?>">View</a></div> </td>
             <td>  <div class="bodytext31" align="center"><a target="_blank" href="printgrt.php?grt=<?php echo $grtno; ?>">Print</a></div> </td>
             
			 	   </tr>
			  <?php
			}
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			  
			 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              </tr><?php }?>
          </tbody>
        </table></td>
      </tr>
	  <tr>
	   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
	  </tr>
	  <tr>
	  <td class="bodytext31" valign="center"  align="center">
	  
	   <input type="hidden" name="doccno" value="<?php echo $billnumbercode; ?>">
	   </td>
	  </tr>
    </table>
</table>

<?php include ("includes/footer1.php"); ?>

</body>
</html>

