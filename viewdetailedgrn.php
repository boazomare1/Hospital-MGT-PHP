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
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $currentdate; }
		
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $currentdate; }
$suplrname=isset($_REQUEST['suplrname'])?$_REQUEST['suplrname']:'';
$suppliercode=isset($_REQUEST['suppliercode'])?$_REQUEST['suppliercode']:'';

$docnumber=isset($_REQUEST['docnumber'])?$_REQUEST['docnumber']:'';
 $itemcode=isset($_REQUEST['itemcode'])?$_REQUEST['itemcode']:'';
  $itemsearch=isset($_REQUEST['itemsearch'])?$_REQUEST['itemsearch']:'';

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
.ui-menu .ui-menu-item{ zoom:1.5 !important; }
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/autocomplete.css" />  
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />   

<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>



<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/autocomplete_customer1.js"></script>
<script type="text/javascript" src="js/autosuggest3.js"></script>

<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function cbcustomername1()
{
	document.cbform1.submit();
}

</script>

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


$("#itemsearch").keydown(function(){
	//alert();
   $("#itemcode").val('');


	var genericcode='';
	//alert(genericcode);
$('#itemsearch').autocomplete({
		
	source:'ajaxmedicinesearch.php?genericcode='+genericcode+'&&itemsearch=yes', 
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

    
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<body>

<?php 
$query1 = "select entrydate,billnumber,suppliername,supplierbillnumber,ponumber,sum(totalamount) as amount from purchase_details where  suppliername LIKE '%".$suplrname."%' and entrydate between '$ADate1' and '$ADate2' and billnumber LIKE 'grn%' group by billnumber";
        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));	
			$resnw1=mysqli_num_rows($exec1);
			 $query2 = "select entrydate,billnumber,suppliername,ponumber,sum(totalamount) as amount from purchase_details where  suppliername LIKE '%".$suplrname."%' and entrydate between '$ADate1' and '$ADate2' and billnumber LIKE 'mgr%' group by billnumber";
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
  		<form name="cbform1" method="post" action="viewdetailedgrn.php">
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
                <input name="suplrname" type="text" id="suplrname"  size="50" autocomplete="off" value="<?php echo $suplrname;?>">
                <input type="hidden" name="suppliercode" id="suppliercode"  value="<?php echo $suppliercode;?>">
              </span></td>
              </tr>
			 <tr>
					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Item Search</td>
					  <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
						<input name="itemsearch" type="text" id="itemsearch"  value="<?php echo $itemsearch;?>" size="50" autocomplete="off">
                        <input type="hidden" name="itemcode"  value="<?php echo $itemcode;?>" id="itemcode"/>
					  </span></td>
  </tr>
              <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doument No </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="docnumber" type="text" id="docnumber"  value="<?php echo $docnumber;?>" size="50" autocomplete="off">
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1320" 
            align="left" border="0">
          <tbody>
          
          
              
         
            <tr>
              
              <td colspan="10" bgcolor="#ecf0f5" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong>Purchase Invoice</strong><label class="number"></label></div></td>
              </tr>
   
	        <tr>
              <th class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></th>
				 <th width="84" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>GRN No</strong></div></th>
				<th width="216" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Supplier Name</strong></div></th>
				<th width="246" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Item</strong></div></th>
				<th width="112" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Item Code</strong></div></th>
				<th width="112" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Quantity (In Units)</strong></th>
				<th width="112" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Batch No</strong></div></th>
                <th width="112" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>EXP Dt</strong></div></th> 
				<th width="112" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Username</strong></div></th>
              <th width="112" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Entry Date</strong></div></th>
				 
              </tr>
			<?php
			$colorloopcount = '';
			$sno = '';
			

			
			$query1 = "select a.entrydate,a.mrnno,a.billnumber,a.suppliername,a.supplierbillnumber,a.ponumber,b.username,sum(a.totalamount) as amount, a.store from purchase_details a JOIN materialreceiptnote_details b ON (a.mrnno=b.billnumber) where  a.suppliername LIKE '%".$suplrname."%' and a.entrydate between '$ADate1' and '$ADate2' and a.billnumber LIKE 'grn%' and a.billnumber like '%$docnumber%' group by a.billnumber ";
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
			$res1username = $res1['username'];
			
	
	
			
		 	$query11 = "select * from purchase_details where billnumber = '$grnno' and itemcode LIKE '%$itemcode%' ";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			mysqli_num_rows($exec11);
			while($res11 = mysqli_fetch_array($exec11))
			 {
			$res11itemname= $res11['itemname'];
			$res11quantity = $res11['quantity'];
			//$res11itemquantity = $res11['itemquantity'];
			$res11itemfreequantity = $res11['itemfreequantity'];
			$res11batchnumber = $res11['batchnumber'];
			$res11expirydate = $res11['expirydate'];
			$res11packagename= $res11['packagename'];
			$res11itemcode= $res11['itemcode'];
			$res11itemtotalquantity= $res11['itemtotalquantity'];
			$res11allpackagetotalquantity= $res11['allpackagetotalquantity'];
			$res11quantityperpackage= $res11['quantityperpackage'];
			$res11rate= $res11['rate'];
			$res11totalamount= $res11['totalfxamount'];
			$res11discountpercentage= $res11['discountpercentage'];
			$res11itemtaxpercentage= $res11['itemtaxpercentage'];
			$res11subtotal= $res11['subtotal'];
			$res11costprice= $res11['costprice'];
			$entrydate= $res11['entrydate'];
			$username= $res11['username'];
			//$amount = $res11costprice * $res11itemtotalquantity;
		
			//$balanceqty = $orderedquantity - $res11quantity;
			
		    /*$query76 = "select * from materialreceiptnote_details where billnumber='$res11ponumber' and itemstatus=''";
			$exec76 = mysql_query($query76) or die(mysql_error());
			$number = mysql_num_rows($exec76);
		    $res76 = mysql_fetch_array($exec76);
			$itemname = $res76['itemname'];*/
			
			/*$query761 = "select * from master_rfq where suppliercode='$suppliercode' and medicinecode='$itemcode' and status = 'generated' order by auto_number desc";
			$exec761 = mysql_query($query761) or die(mysql_error());
			$res761 = mysql_fetch_array($exec761);
			$orderedquantity = $res761['packagequantity'];*/
			
	
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

                   <td class="bodytext31" valign="center"  width="22"   align="center"><?php echo $sno = $sno + 1; ?></td>

        <td class="bodytext3 border" width="84"  align="left"><?php echo $grnno; ?></td>
				        <td class="bodytext3 border" width="216"  align="left"><?php echo $suppliername; ?></td>

		        <td class="bodytext3 border" width="246"  align="left"><?php echo $res11itemname; ?></td>
        <td class="bodytext3 border" width="112"  align="left"><?php echo $res11itemcode; ?></td>
        <td class="bodytext3 border" width="112" align="center"><?php echo number_format($res11allpackagetotalquantity,2,'.',','); ?></td>

        <td class="bodytext3 border" width="112" align="right"><?php echo $res11batchnumber; ?></td>
        <td class="bodytext3 border" width="112" align="center"><?php echo date('m/y',strtotime($res11expirydate)); ?></td>
        <td class="bodytext3 border" width="112" align="center" ><?php echo $res1username; ?></td>
        <td class="bodytext3 border" width="112" align="center"><?php echo $entrydate; ?></td>
       
    </tr>
    <?php 
	
	}
			}
			?>
		
			 <tr>
 <td align="left" colspan="8"> <a target="_blank" href="print_viewdetailedgrnxl.php?docnumber=<?=$docnumber;?>&&cbfrmflag1=<?=$cbfrmflag1;?>&&suplrname=<?=$suplrname;?>&&itemcode=<?= $itemcode;?>&&ADate1=<?=$ADate1;?>&&ADate2=<?=$ADate2;?>"> <img src="images/excel-xls-icon.png" width="30" height="30"></a> </td>
 </tr>
			<?php
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

