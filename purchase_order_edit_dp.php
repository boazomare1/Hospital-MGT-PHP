<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
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
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$totalop = 0;
$totalref = 0;
$dispensingfee = 0;
$totalcopay = 0;
$totalgrt = 0;
$totalgrn = 0;
$totalnet = 0;
$grandgrn = 0;
$grandgrt = 0;
$grandnet = 0;
if(isset($_REQUEST["cbfrmflag1"])){ $cbfrmflag1 = $_REQUEST["cbfrmflag1"];}else{$cbfrmflag1 = "";}
if(isset($_REQUEST["suppliername"])){ $searchsuppliername = $_REQUEST["suppliername"];}else{$searchsuppliername = "";}
if(isset($_REQUEST["suppliercode"])){ $searchsuppliercode = $_REQUEST["suppliercode"];}else{$searchsuppliercode = "";}
if(isset($_REQUEST["ponumber"])){ $searchponumber = $_REQUEST["ponumber"];}else{$searchponumber = "";}
if(isset($_REQUEST["ADate1"])){ $ADate1 = $_REQUEST["ADate1"];}else{$ADate1 = date('Y-m-d');}
if(isset($_REQUEST["ADate2"])){ $ADate2 = $_REQUEST["ADate2"];}else{$ADate2 = date('Y-m-d');}
// if(isset($_REQUEST["reporttype"])){ $reporttype = $_REQUEST["reporttype"];}else{$reporttype = "";}
// 
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
	
		$loopcount = $_POST['loopcount'];
		$pinumber = $_POST['pinumber'];
		$ponumber = $_POST['ponumber'];
		
		
		for ($p=1;$p<=$loopcount;$p++)
		{
		$itemname = $_POST['itemname'.$p];
		$itemcode = $_POST['itemcode'.$p];
		$rate_val = $_POST['rate_val'.$p];
		$qty_val = $_POST['qty_val'.$p];
		$qty_val = str_replace(',','',$qty_val);
		$autonumber = $_POST['autonumber'.$p];
		$totitemamt = $_POST['indv_amount'.$p];
		$totitemamt = str_replace(',','',$totitemamt);
	
	 	  $up1=mysqli_query($GLOBALS["___mysqli_ston"], "update manual_lpo set rate='$rate_val',quantity='$qty_val',totalamount='$totitemamt',fxpkrate='$rate_val' where auto_number = '$autonumber' ");
		//$up2=mysqli_query($GLOBALS["___mysqli_ston"], "update purchase_indent set rate='$rate_val',originalrate='$rate_val',originalqty='$qty_val',quantity='$qty_val',amount='$totitemamt',originalamt='$totitemamt' where docno = '$pinumber' and  medicinecode='$itemcode' and medicinename='$itemname'");
		 $up3=mysqli_query($GLOBALS["___mysqli_ston"], "update materialreceiptnote_details set rate='$rate_val',fxpkrate='$rate_val',quantity='$qty_val',itemtotalquantity='$qty_val',allpackagetotalquantity='$qty_val',subtotal='$totitemamt',totalamount='$totitemamt',totalfxamount='$totitemamt' where ponumber = '$ponumber' and  itemcode='$itemcode' and itemname='$itemname'");
		
		}
		header("location:purchase_order_edit_dp.php");
   exit;
  }
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order Edit DP - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    
    <!-- Date Picker Scripts -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    
    <!-- Legacy Styles -->
    <style type="text/css">
    <!--
    body {
        margin-left: 0px;
        margin-top: 0px;
        background-color: #ecf0f5;
    }
    .bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
    }
    .bodytext31 {	FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
    }
    .ui-menu .ui-menu-item{ zoom:1 !important; }
    -->
    </style>
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
<script type="text/javascript">
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
function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}
function disableEnterKey()
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
		return false;
	}
	else
	{
		return true;
	}
}
function calamount(id)
{
	
	var get_qty=$("#qty_val"+id).val();
	var get_rate=$("#rate_val"+id).val();
	var amount='0.00';
	if(get_qty>0 && get_rate>0)
	{
	var amount=parseFloat(get_qty)*parseFloat(get_rate);
	amount = parseFloat(amount).toFixed(2);
   amount = amount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	$("#indv_amount"+id).val(amount);
	}
}
</script>
   
<!--AUTO COMPLETETION CODE FOR SUPPLIER NAME-->
<link href="autocomplete.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script type="text/javascript">
$(function() {
	//AUTO COMPLETE SEARCH FOR SUPPLIER NAME
$('#suppliername').autocomplete({
		
	source:'ajaxsuppliernewserach.php', 
	//alert(source);
	minLength:1,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var supplier = this.id;
			var code = ui.item.id;
			var suppliername = supplier.split('suppliername');
			var suppliercode = suppliername[1];
			$('#suppliercode'+suppliercode).val(code);
			
			},
    });
	
	//AUTOCOMPLETE FOR PO NUMBER
/*$('#ponumber').autocomplete({
		
	source:'ajaxponumbersearch.php', 
	//alert(source);
	minLength:1,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var pobill = this.id;
			var code = ui.item.id;
			//alert(code)
			var pobillnumber = pobill.split('pobillnumber');
			var ponumber = pobillnumber[1];
			$('#hidpurchaseordercode').val(code);
			
			},
    });*/
});
</script>
<!--ENDS-->
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
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
<script src="js/datetimepicker_css.js"></script>

<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>

    <!-- User Information Bar -->
    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <strong><?php echo htmlspecialchars($username); ?></strong></span>
            <span class="location-info">📍 Company: <?php echo htmlspecialchars($companyname); ?></span>
        </div>
        <div class="user-actions">
            <a href="mainmenu1.php" class="btn btn-outline">🏠 Main Menu</a>
            <a href="logout.php" class="btn btn-outline">🚪 Logout</a>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <span>Purchase Management</span>
        <span>→</span>
        <span>Edit Purchase Order</span>
    </nav>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Alert Container -->
        <div id="alertContainer">
            <?php include ("includes/alertmessages1.php"); ?>
        </div>

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <h2>Edit Purchase Order</h2>
                <p>Search and edit purchase order details with real-time calculations and validation.</p>
            </div>
            <div class="page-header-actions">
                <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
                <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                    <i class="fas fa-download"></i> Export
                </button>
            </div>
        </div>

        <!-- Search Form Section -->
        <div class="form-section">
            <h3><i class="fas fa-search"></i> Search Purchase Order</h3>
            
            <form name="cbform1" method="post" action="purchase_order_edit_dp.php">
                <div class="form-row">
                    <div class="form-group">
                        <label for="pono">Purchase Order Number</label>
                        <input name="pono" type="text" id="pono" value="" autocomplete="off" required placeholder="Enter PO number to search">
                    </div>
                </div>
                
                <div class="form-actions">
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                    <button type="submit" class="btn btn-primary" name="Submit">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <button name="resetbutton" type="reset" id="resetbutton" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </form>
            
            <!-- Current Location Display -->
            <div class="current-location">
                <strong>Current Location: </strong>
                <span id="ajaxlocation">
                    <?php
                    if ($location!='')
                    {
                        $query12 = "select locationname from master_location where locationcode='$location' order by locationname";
                        $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $res12 = mysqli_fetch_array($exec12);
                        echo $res1location = $res12["locationname"];
                    }
                    else
                    {
                        $query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $res1 = mysqli_fetch_array($exec1);
                        echo $res1location = $res1["locationname"];
                    }
                    ?>
                </span>
            </div>
        </div>

        <!-- Results Section -->
        <div class="data-table-section">
            <div class="table-header">
                <h3><i class="fas fa-list"></i> Purchase Order Details</h3>
                <div class="search-bar">
                    <input type="text" placeholder="Search items..." id="poSearch">
                    <i class="fas fa-search"></i>
                </div>
            </div>
            
            <?php
            //AFTER SEARCH
            $colorloopcount=0;
            $sno=0;
            if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
            //$cbfrmflag1 = $_POST['cbfrmflag1'];
            if (($cbfrmflag1 == 'cbfrmflag1') || (isset($_GET['pono'])))
            {
            ?>
            
            <form name="insertvalue" method="post" action="purchase_order_edit_dp.php">
                
                <?php
                $sno_det = 0;
                $sno = 0;
                $lpototal = 0;
                $mlpototal=0;
                $grandtotal=0;
                $totamountval_det = 0;
                // $ADate1 = $_REQUEST["ADate1"];
                // $ADate2 = $_REQUEST["ADate2"];
                $docno = "";
                $ponumber = $_REQUEST["pono"];
                $type='all';
                $reporttype = "detailed";
                if(1)
                {
                
                  $qrypodetatils="SELECT 'manual_lpo' as source,entrydate as billdate,purchaseindentdocno,billnumber,suppliername,SUM(rate*quantity) AS totvalue,null as goodsstatus  from manual_lpo where recordstatus='generated'  and billnumber = '$ponumber' group by billnumber ";
                    ?>
                    
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Date</th>
                                <th>PI</th>
                                <th>PO</th>
                                <th>Supplier Name</th>
                                <th>PO Value</th>
                            </tr>
                        </thead>
                        <tbody>   
    
    <?php
	
	$execpodetatils = mysqli_query($GLOBALS["___mysqli_ston"], $qrypodetatils) or die ("Error in qrypodetatils".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($respodetatils = mysqli_fetch_array($execpodetatils))
	{
		$billdate = $respodetatils["billdate"];
		$pinumber = $respodetatils["purchaseindentdocno"];
		$ponumber = $respodetatils["billnumber"];
		$suppliername = $respodetatils["suppliername"];
		$source = $respodetatils["source"];
		$totalamount = $respodetatils["totvalue"];
		 $lpototal = $lpototal + $totalamount;
		 
		 $mrnbuild = array();
		 $grnamount = 0;
		 $grtamount = 0;
		  $query89 = "select billnumber, sum(totalfxamount) as totalfxamount from materialreceiptnote_details where ponumber = '$ponumber' group by billnumber";
		 $exec89 = mysqli_query($GLOBALS["___mysqli_ston"], $query89) or die ("Error in Query89".mysqli_error($GLOBALS["___mysqli_ston"]));
		 while($res89 = mysqli_fetch_array($exec89))
		 {
			 $mrnno = $res89['billnumber'];
			 $mrnbuild[] = $mrnno;
			 $grn = $res89['totalfxamount'];
			 $grnamount = $grnamount + $grn;
			 $totalgrn = $totalgrn + $grn;
		 }
		 if($grnamount==0){
		 	$grnstatus="PO Not Received";
			$status_colorcode = 'COLOR:blue; font-weight:bold';
		 }
		 $mrnbuildvalue = implode("','",$mrnbuild);
		 
		 $query91 = "select billnumber, sum(totalamount) as totalamount from purchasereturn_details where grnbillnumber IN ('".$mrnbuildvalue."') group by billnumber";
		 $exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die ("Error in Query91".mysqli_error($GLOBALS["___mysqli_ston"]));
		 while($res91 = mysqli_fetch_array($exec91))
		 {
			 $grtno = $res91['billnumber'];
			 $grt = $res91['totalamount'];
			 $grtamount = $grtamount + $grt;
			 $totalgrt = $totalgrt + $grt;
		 }
		 
		 $query10 = "select * from materialreceiptnote_details where ponumber='$ponumber' and grnstatus=''";
		$exec10  = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		$numb=mysqli_num_rows($exec10);	
		if($numb>0)
		{
		
		$netamount = $grnamount - $grtamount;
		$totalnet = $totalnet + $netamount;
		
		$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$colorcode = 'bgcolor="#ecf0f5"';
			
	?>
                            <tr class="table-row <?php echo ($showcolor == 0) ? 'table-row-even' : 'table-row-odd'; ?>">
                                <td><?php echo $sno = $sno + 1;?></td>
                                <td><?php echo $billdate;?></td>
                                <td><?php echo $pinumber;?></td>
                                <td>
                                    <strong><?php echo $ponumber;?></strong>
                                    <input type="hidden" id="pinumber" name="pinumber" value="<?php echo $ponumber;?>" />
                                    <input type="hidden" id="ponumber" name="ponumber" value="<?php echo $ponumber;?>" />
                                </td>
                                <td><?php echo htmlspecialchars($suppliername);?></td>
                                <td class="text-right"><?php echo number_format($totalamount, 2, '.', ',');?></td>
                            </tr>
     <?php
$cno=0;
     	if($totalamount>=0){
     		 $detailed_cnt = 1;
       // Items list for po
    	 $qrypodetailed = "SELECT auto_number,entrydate as billdate,itemcode,itemname,rate,quantity as packagequantity,username,fxtotamount,free FROM manual_lpo WHERE billnumber = '$ponumber'  AND recordstatus<>'deleted'";
	$execpodetailed = mysqli_query($GLOBALS["___mysqli_ston"], $qrypodetailed) or die ("Error in qrypodetailed".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($respodetailed = mysqli_fetch_array($execpodetailed))
	{
       $cno=$cno+1;
		$auto_number_det = $respodetailed["auto_number"];
		$billdate_det = $respodetailed["billdate"];
		
		$itemcode_det = $respodetailed["itemcode"];
		$itemname_det = $respodetailed["itemname"];
		$rate_det = $respodetailed["rate"];
		
	
		$pkgqnty_det = $respodetailed["packagequantity"];
		$username_det = $respodetailed["username"];
		$fxamount_det = $respodetailed["fxtotamount"];
		$totamountval_det = $totamountval_det + $fxamount_det;
		$po_freeqty_det = $respodetailed["free"];
		?>
                            <?php if($detailed_cnt == 1){ ?>
                                <tr class="table-subheader">
                                    <td>&nbsp;</td>
                                    <td><strong>Date</strong></td>
                                    <td><strong>Item Name</strong></td>
                                    <td><strong>Rate</strong></td>
                                    <td><strong>Order Qty</strong></td>
                                    <td><strong>Amount</strong></td>
                                </tr> 
                            <?php 
                            } 
                            $detailed_cnt = $detailed_cnt + 1;
                            ?>
                            <tr class="table-row table-row-detail">
                                <td>&nbsp;</td>
                                <td><?php echo $billdate_det;?></td>
                                <td><?php echo htmlspecialchars($itemname_det);?></td>
                                <td>
                                    <input type="text" id="rate_val<?php echo $cno;?>" name="rate_val<?php echo $cno;?>" 
                                           value="<?php echo $rate_det;?>" onKeyUp="calamount('<?php echo $cno;?>')" 
                                           class="rate-input" placeholder="0.00">
                                    <input type="hidden" id="autonumber<?php echo $cno;?>" name="autonumber<?php echo $cno;?>" value="<?php echo $auto_number_det;?>" />
                                    <input type="hidden" id="itemname<?php echo $cno;?>" name="itemname<?php echo $cno;?>" value="<?php echo $itemname_det;?>" />
                                    <input type="hidden" id="itemcode<?php echo $cno;?>" name="itemcode<?php echo $cno;?>" value="<?php echo $itemcode_det;?>" />
                                </td>
                                <td>
                                    <input type="text" id="qty_val<?php echo $cno;?>" name="qty_val<?php echo $cno;?>" 
                                           value="<?php echo number_format($pkgqnty_det, 2, '.', ',');?>" 
                                           onKeyUp="calamount('<?php echo $cno;?>')" 
                                           class="qty-input" placeholder="0.00">
                                </td>
                                <td>
                                    <input type="text" id="indv_amount<?php echo $cno;?>" name="indv_amount<?php echo $cno;?>" 
                                           value="<?php echo number_format($rate_det*$pkgqnty_det, 2, '.', ',');?>" 
                                           class="amount-input" readonly>
                                </td>
                            </tr>
	<?php
	
	}
     }
		}
	}//while--close
	?>
	
    <?php
	}
	
	?>
    
                        </tbody>
                    </table>
                    
                    <div class="form-actions">
                        <input type="hidden" name="frm1submit1" value="frm1submit1" />
                        <input type="hidden" name="loopcount" id="loopcount" value="<?php echo $cno; ?>" />
                        <input type="hidden" name="pino" id="pino" value="<?php echo $cno; ?>" />
                        <button name="Submit222" type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                </form>
            <?php
            } //CLOSE -- if ($cbfrmflag1 == 'cbfrmflag1')
            ?>
        </div>
    </div>
    
    <!-- Modern JavaScript -->
    <script src="js/purchase_order_edit_dp-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>