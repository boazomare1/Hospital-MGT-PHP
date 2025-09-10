<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
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
$suplrname=isset($_REQUEST['suplrname'])?$_REQUEST['suplrname']:'';
$docnumber=isset($_REQUEST['docnumber'])?$_REQUEST['docnumber']:'';
$suppliercode=isset($_REQUEST['suppliercode'])?$_REQUEST['suppliercode']:'';

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
<style type="text/css">th {            background-color: #ffffff;            position: sticky;            top: 0;            z-index: 1;        }
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
.ui-menu .ui-menu-item{ zoom:1 !important; }
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
<script type="text/javascript" src="js/autocomplete_customer1.js"></script>
<script type="text/javascript" src="js/autosuggest3.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        
}


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






</script>

<link href="autocomplete.css" rel="stylesheet">

<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script>
$(function() {
	
$('#suplrname').autocomplete({
		
	source:'search.php', 
	//alert(source);
	minLength:2,
	delay: 0,
html: true, 
		select: function(event,ui){
			//var code = ui.item.id;
			var suppliercode = ui.item.suppliercode;
			var suppliername = ui.item.suppliername;
			$('#suppliercode').val(suppliercode);
			$('#suppliername').val(suppliername);
			
			},
    });
});
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
$query1 = "select entrydate,billnumber,suppliername,supplierbillnumber,ponumber,sum(totalamount) as amount from purchase_details where  suppliercode LIKE '%".$suppliercode."%' and entrydate between '$ADate1' and '$ADate2' and billnumber LIKE 'grn%' group by billnumber";
        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));	
			$resnw1=mysqli_num_rows($exec1);
			 $query2 = "select entrydate,billnumber,suppliername,ponumber,sum(totalamount) as amount from purchase_details where  suppliercode LIKE '%".$suppliercode."%' and entrydate between '$ADate1' and '$ADate2' and billnumber LIKE 'mgr%' group by billnumber";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resnw2=mysqli_num_rows($exec2);
			//$resnwcount=$resnw1+$resnw2;
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
  		<form name="cbform1" method="post" action="viewmrn.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>View Invoices</strong></td>
             
               <td colspan="1" bgcolor="#ecf0f5" class="bodytext3" align="right"><strong> Location: </strong>
             
            
                  <?php echo $res1location;?>
						
				
                  </td>
              </tr>
               <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Supplier Name</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="suplrname" type="text" id="suplrname" value="" size="50" autocomplete="off">
                <input type="hidden" name="suppliercode" id="suppliercode">
              </span></td>
              </tr>
              <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doument No </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="docnumber" type="text" id="docnumber" value="" size="50" autocomplete="off">
              </span></td>
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
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
				  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
				  <input  type="submit" onClick="return funcAccount();" value="Search" name="Submit" />
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="950" 
            align="left" border="0">
          <tbody>
          
            <tr>
              
              <td colspan="10" bgcolor="#ecf0f5" class="bodytext31">
            
                <div align="left"><strong>Goods Received Note</strong><label class="number"><<<?php echo $resnw1;?>>></label></div></td>
              </tr>
             <tr>
              <th class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></th>
				 <th width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date </strong></div></th>
				<th width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Document No</strong></div></th>
				<th width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Supplier Name</strong></div></th>
				<th width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Invoice No</strong></div></th>
                <th width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Store</strong></div></th>
				<th width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>PO NO</strong></div></th>
				<th width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>VAT</strong></div></th>
              <th width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Value</strong></div></th>
				<th width="20%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action</strong></div></th>
              	             
              </tr>
			<?php
			$colorloopcount = '';
			$sno = '';
			

			
			$query1 = "select *,sum(totalamount) as amount, store from materialreceiptnote_details where  suppliercode LIKE '%".$suppliercode."%' and entrydate between '$ADate1' and '$ADate2' and billnumber like '%$docnumber%' group by billnumber order by entrydate desc";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));	
			
			while($res1=mysqli_fetch_array($exec1))
			{
			$date=$res1['entrydate'];
			$grnno=$res1['billnumber'];
			$suppliername=$res1['suppliername'];
			$invoiceno=$res1['supplierbillnumber'];
			$pono=$res1['ponumber'];
			$store = $res1['store'];
			
			$query9 = "select store from master_store where storecode = '$store'";
			$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));			
			$res9=mysqli_fetch_array($exec9);
			$storename = $res9['store'];
			
			$totalamount = 0;
			$subtotal=0;
			
			$vattotal = $price = $quantity = $netamount = 0;
			$vatquery = "select fxpkrate, quantity, itemtaxpercentage from materialreceiptnote_details where billnumber = '$grnno'";
			$execvat = mysqli_query($GLOBALS["___mysqli_ston"], $vatquery) or die("Error in VAT Query".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resvat = mysqli_fetch_array($execvat)){
				$taxpercentage = $resvat['itemtaxpercentage'];
				$price = $resvat['fxpkrate'];
				$quantity = $resvat['quantity'];

				$vat = (($price * $quantity)*($taxpercentage/100));
				$vattotal += $vat;

				$netamount += ($price * $quantity) + $vat;
			}
			//$subtotal+=$totalamount;
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
			    <div align="center"><?php echo $grnno; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $suppliername; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $invoiceno; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $storename; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $pono; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($vattotal,2); ?></div></td>
		        <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31" align="right"><?php echo number_format($netamount,2); ?></div></td>
			      <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><a target="_blank" href="print_mrnview.php?billnumber=<?php echo $grnno; ?>&&locationcode=<?= $res1locationcode; ?>">Print</a> &nbsp;&nbsp;&nbsp; <a target="_blank" href="print_mrnlabel.php?billnumber=<?php echo $grnno; ?>&&locationcode=<?= $res1locationcode; ?>">Label</a> </div></td>
			 			
                </tr>
			  <?php
			}
			?>
           
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5" colspan="10">&nbsp;</td>
			 
              </tr>
              
         
            <tr>
              
              <td colspan="10" bgcolor="#ecf0f5" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong>Purchase Invoice</strong><label class="number"><<<?php echo $resnw1;?>>></label></div></td>
              </tr>
             <tr>
              <th class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></th>
				 <th width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date </strong></div></th>
				<th width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Document No</strong></div></th>
				<th width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Supplier Name</strong></div></th>
				<th width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Invoice No</strong></div></th>
                <th width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Store</strong></div></th>
				<th width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>PO NO</strong></div></th>
				<th width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>VAT</strong></div></th>
              <th width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Value</strong></div></th>
				<th width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action</strong></div></th>
              	             
              </tr>
			<?php
			$colorloopcount = '';
			$sno = '';
			

			
			$query1 = "select entrydate,mrnno,billnumber,suppliername,supplierbillnumber,ponumber,sum(totalamount) as amount, store from purchase_details where  suppliercode LIKE '%".$suppliercode."%' and entrydate between '$ADate1' and '$ADate2' and billnumber LIKE 'grn%' and billnumber like '%$docnumber%' group by billnumber";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));	
			
			while($res1=mysqli_fetch_array($exec1))
			{
			$date=$res1['entrydate'];
			$grnno=$res1['billnumber'];
			$suppliername=$res1['suppliername'];
			$invoiceno=$res1['supplierbillnumber'];
			$pono=$res1['ponumber'];		
			$mrnno=$res1['mrnno'];		
			$store = $res1['store'];
			
			$query9 = "select store from master_store where storecode = '$store'";
			$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));			
			$res9=mysqli_fetch_array($exec9);
			$storename = $res9['store'];

			if($invoiceno==""){
				$query1a = "select supplierbillnumber from materialreceiptnote_details where billnumber='$mrnno' ";
				$exec1a = mysqli_query($GLOBALS["___mysqli_ston"], $query1a) or die ("Error in Query1a".mysqli_error($GLOBALS["___mysqli_ston"]));
					if($res1a = mysqli_fetch_array($exec1a)){
						$invoiceno = $res1a["supplierbillnumber"];
					}
			}
			
			$totalamount = 0;
			$subtotal=0;

			$vattotal = 0;
			$vatquery = "select fxamount, itemtaxpercentage from purchase_details where billnumber = '$grnno'";
			$execvat = mysqli_query($GLOBALS["___mysqli_ston"], $vatquery) or die("Error in VAT Query".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resvat = mysqli_fetch_array($execvat)){
				$taxpercentage = $resvat['itemtaxpercentage'];
				$price = $resvat['fxamount'];

				$vat = ($price * ($taxpercentage/100));
				$vattotal += $vat;
			}
			

			$totalamount=$res1['amount'];
			$totalamount=number_format($totalamount,2);
			//$subtotal+=$totalamount;
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
			    <div align="center"><?php echo $grnno; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $suppliername; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $invoiceno; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $storename; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $pono; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($vattotal,2); ?></div></td>
		        <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31" align="right"><?php echo $totalamount; ?></div></td>
			      <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><a target="_blank" href="print_grnview.php?grn=<?php echo $grnno; ?>&&info=grn&&locationcode=<?= $res1locationcode; ?>">Print</a>&nbsp;&nbsp;&nbsp; <a target="_blank" href="print_grnlabel.php?billnumber=<?php echo $grnno; ?>&&locationcode=<?= $res1locationcode; ?>">Label</a></div></td>
			 			
                </tr>
			  <?php
			}
			?>
           
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5" colspan="10">&nbsp;</td>
			 
              </tr>
               
              <td colspan="10" bgcolor="#ecf0f5" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong>Non Medical</strong><label class="number"><<<?php echo $resnw2;?>>></label></div></td>
                 <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				 <td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date </strong></div></td>
				<td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Document No</strong></div></td>
				<td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Supplier Name</strong></div></td>
				<td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Invoice No</strong></div></td>
                <td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Store</strong></div></td> 
				<td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>PO NO</strong></div></td>
				<td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>VAT</strong></div></td>
              <td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Value</strong></div></td>
				<td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action</strong></div></td>
              	             
              </tr>
               <?php
			$colorloopcount = '';
			$sno = '';
	
			
			 $query2 = "select entrydate,billnumber,mrnno,suppliername,ponumber,supplierbillnumber,sum(totalfxamount) as amount,'mgr' as type, store from purchase_details where  suppliercode LIKE '%".$suppliercode."%' and entrydate between '$ADate1' and '$ADate2' and billnumber LIKE 'mgr%' and billnumber like '%$docnumber%'group by billnumber
			 union all select entrydate,billnumber,mrnno,suppliername,ponumber,supplierbillnumber,sum(totalfxamount) as amount,'grn' as type, store from purchase_details where  suppliercode LIKE '%".$suppliercode."%' and entrydate between '$ADate1' and '$ADate2' and billnumber LIKE 'NMP-%' and billnumber like '%$docnumber%'group by billnumber";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));	
			while($res2=mysqli_fetch_array($exec2))
			{
			$date1=$res2['entrydate'];
			$grnno1=$res2['billnumber'];
			$suppliername1=$res2['suppliername'];
			$invoiceno1=$res2['supplierbillnumber'];
			$pono1=$res2['ponumber'];		
			$mrnno1=$res2['mrnno'];
			$store = $res2['store'];
			
			$query9 = "select store from master_store where storecode = '$store'";
			$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));			
			$res9=mysqli_fetch_array($exec9);
			$storename = $res9['store'];		

			if($invoiceno1==""){
			$query1a = "select supplierbillnumber from materialreceiptnote_details where billnumber='$mrnno1' ";
			$exec1a = mysqli_query($GLOBALS["___mysqli_ston"], $query1a) or die ("Error in Query1a".mysqli_error($GLOBALS["___mysqli_ston"]));
				if($res1a = mysqli_fetch_array($exec1a)){
					$invoiceno1 = $res1a["supplierbillnumber"];
				}
			}
			
			$totalamount = 0;
			
			$vattotal = 0;
			$vatquery = "select priceperpk, itemtaxpercentage from purchase_details where billnumber = '$grnno'";
			$execvat = mysqli_query($GLOBALS["___mysqli_ston"], $vatquery) or die("Error in VAT Query".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resvat = mysqli_fetch_array($execvat)){
				$taxpercentage = $resvat['itemtaxpercentage'];
				$price = $resvat['fxamount'];

				$vat = ($price * ($taxpercentage/100));
				$vattotal += $vat;
			}

			$totalamount1=$res2['amount'];
			$totalamount1=number_format($totalamount1,2);
			$info=$res2['type'];
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
			    <div align="center"><?php echo $date1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $grnno1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $suppliername1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $invoiceno1; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $storename; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $pono1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($vattotal); ?></div></td>
		        <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31" align="right"><?php echo $totalamount1; ?></div></td>
			      <td class="bodytext31" valign="center"  align="left">
<div class="bodytext31" align="center"><a target="_blank" href="print_grnview.php?grn=<?php echo $grnno1; ?>&&locationcode=<?= $res1locationcode; ?>&&info=<?php echo $info; ?>">Print</a></div></td>
			 			
                </tr>
			  <?php
			}
			}
            ?>
              
              
              
         
              
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

