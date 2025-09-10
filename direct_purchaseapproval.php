<?php
session_start();
ob_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$currentdate = date("Y-m-d");
$docno = $_SESSION['docno'];
$docno1 = $_SESSION['docno'];
$ADate1=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date('Y-m-d',strtotime('-1 month'));
$ADate2=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:date('Y-m-d');
$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

$query = "select * from login_locationdetails where username='$username' and docno='$docno1' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$locationname  = $res["locationname"];
$locationcode = $res["locationcode"];
 


if ($frm1submit1 == 'frm1submit1')
{
		
	
	foreach($_POST['select'] as $key => $value)
	{
		$docno = $_POST['select'][$key];	
		
		$query331 = "select locationcode from purchase_indent where docno='$docno' and approvalstatus='pending' and pogeneration!='completed'";
		$exec331 = mysqli_query($GLOBALS["___mysqli_ston"], $query331) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res331= mysqli_fetch_array($exec331);
		$locationcode=$res331['locationcode'];
		
		$query018="select auto_number from master_location where locationcode='$locationcode'";
		$exc018=mysqli_query($GLOBALS["___mysqli_ston"], $query018);
		$res018=mysqli_fetch_array($exc018);
		$location_auto = $res018['auto_number'];
		
		///////////////// GRN NUMBER /////////
		$query312 = "select * from bill_formats where description = 'external_mrn'";
		$exec312 = mysqli_query($GLOBALS["___mysqli_ston"], $query312) or die ("Error in Query312".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res312 = mysqli_fetch_array($exec312);
		$paynowbillprefix = $res312['prefix'];
		$paynowbillprefix13=strlen($paynowbillprefix);
		$query2233 = "select * from materialreceiptnote_details where billnumber like '%$paynowbillprefix-%' order by auto_number desc limit 0, 1";
		$exec2233 = mysqli_query($GLOBALS["___mysqli_ston"], $query2233) or die ("Error in Query2233".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2233 = mysqli_fetch_array($exec2233);
		$billnumber3 = $res2233["billnumber"];
		$billdigit3=strlen($billnumber3);
		if ($billnumber3 == '')
		{
			$billnumbercode3 =$paynowbillprefix."-".'1'."-".date('y')."-".$location_auto;
		}
		else
		{
			$billnumber3 = $res2233["billnumber"];
			$maxcount3=split("-",$billnumber3);
			$maxcount_3=$maxcount3[1];
			$maxanum = $maxcount_3+1;
			$billnumbercode3 = $paynowbillprefix ."-".$maxanum."-".date('y')."-".$location_auto;
		}
		///////////////// GRN NUMBER /////////
		///////////////// MLPO NUMBER GENERATE /////////
		$query31 = "select * from bill_formats where description = 'direct_purchase'";
		$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res31 = mysqli_fetch_array($exec31);
		$paynowbillprefix = $res31['prefix'];
        $paynowbillprefix1=strlen($paynowbillprefix);
        $query3 = "select * from manual_lpo order by auto_number desc limit 0, 1";
        $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        $num3 = mysqli_num_rows($exec3);
        $res3 = mysqli_fetch_array($exec3);
        $billnumber1 = $res3['billnumber'];
        $billdigit=strlen($billnumber1);
        if($num3 >0)
        {
				$query22 = "select * from manual_lpo order by auto_number desc limit 0, 1";
				$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num22 = mysqli_num_rows($exec22);
				$res22 = mysqli_fetch_array($exec22);
				$billnumber1 = $res222["billnumber"];        
				$billdigit=strlen($billnumber1);
				if($billnumber1 != '')
				{
				$billnumbercode1 = $billnumber1;
				$docstatus = '';          
				}
				else
				{
				$query224 = "select * from manual_lpo order by auto_number desc limit 0, 1";
				$exec224 = mysqli_query($GLOBALS["___mysqli_ston"], $query224) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res224 = mysqli_fetch_array($exec224);
				$billnumber1 = $res224['billnumber'];
				$maxcount_1=split("-",$billnumber1);
				$maxcount_2=$maxcount_1[1];
				$maxanum = $maxcount_2+1;
				$billnumbercode1 = $paynowbillprefix ."-".$maxanum."-".date('y')."-".$location_auto;
				$openingbalance = '0.00';           
				$docstatus = 'new';
				}
        }
        else
        {
          $query22 = "select * from manual_lpo order by auto_number desc limit 0, 1";
          $exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
          $res22 = mysqli_fetch_array($exec22);
          $billnumber1 = $res22["billnumber"];
          $billdigit=strlen($billnumber1);
          if ($billnumber1 == '')
          {
			$billnumbercode1 =$paynowbillprefix."-".'1'."-".date('y')."-".$location_auto;
            $openingbalance = '0.00';
            $docstatus = 'new';
          }
        } 
		
		
			$query33 = "select * from purchase_indent where docno='$docno' and approvalstatus='pending' and pogeneration!='completed'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res33 = mysqli_fetch_array($exec33))
			{
				$medicinename=$res33['medicinename'];
				$rate=$res33['rate'];
				$quantity=$res33['quantity'];
				$subtotal=$res33['amount'];
				$suppliername=$res33['suppliername'];
				$suppliercode=$res33['suppliercode'];
				$supplieranum=$res33['supplieranum'];
				$locationname=$res33['locationname'];
				$locationcode=$res33['locationcode'];
				$currency=$res33['currency'];
				$fxamount=$res33['fxamount'];
				$job_title=$res33['job_title'];
				$tax_percentage=$res33['tax_percentage'];
				$is_blanket=$res33['is_blanket'];
				
		
				if($is_blanket=='yes')
				$received_status = '';
				else
				$received_status = 'received';
				$query56="INSERT into manual_lpo(companyanum,billnumber,itemcode,itemname,rate,quantity,totalamount,username, ipaddress, entrydate,purchaseindentdocno,purchasetype,suppliername,suppliercode,supplieranum,recordstatus,docstatus,locationname,locationcode,storename,storecode,currency,fxamount,fxpkrate,fxtotamount,remarks,job_title,goodsstatus,itemtaxpercentage,itemtaxamount,is_blanket) values('$companyanum','$billnumbercode1','','$medicinename','$rate','$quantity','$subtotal','$username','$ipaddress','$currentdate','$docno','','$suppliername','$suppliercode','$supplieranum','generated','$docstatus','$locationname','$locationcode','','','$currency','$fxamount','$rate','$subtotal','','$job_title','','$tax_percentage','$tax_amount','$is_blanket')";
				$exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));    
				
				/////////////////// MLPO ///////////// goods RECIVED NOTES //////////////
				
				if($is_blanket=='no'){
				$query4 = "insert into materialreceiptnote_details (bill_autonumber, companyanum, billnumber, itemanum, itemcode, itemname, itemdescription, rate, quantity, 
				subtotal, free, discountpercentage, discountrupees, openingstock, closingstock, totalamount, discountamount, username, ipaddress, entrydate, itemtaxpercentage, itemtaxamount, unit_abbreviation, batchnumber, salesprice, expirydate, itemfreequantity, itemtotalquantity, packageanum, packagename, quantityperpackage, allpackagetotalquantity,manufactureranum,manufacturername,typeofpurchase,suppliername,suppliercode,supplieranum,ponumber,supplierbillnumber,costprice,locationcode,store,coa,categoryname,fifo_code,totalfxamount,fxpkrate,priceperpk,deliverybillno,currency,fxamount,ledgeranum,ledgercode,ledgername ,incomeledger,incomeledgercode,purchasetype,job_title,is_blanket) 
				values ('$billautonumber', '$companyanum', '$billnumbercode3', '', '', '$medicinename', '', '$rate', '$quantity', '$subtotal', '', '0', '0', '0', '0', '$subtotal', '0', '$username', '$ipaddress', '$currentdate', '$tax_percentage', '$tax_amount', '', '', '0', '$currentdate', '', '$quantity', '0', '', '0', '$quantity', '0', '', 'Process', '$suppliername', '$suppliercode', '$supplieranum', '$billnumbercode1', '', '$rate', '$locationcode', '', '', '', '', '$subtotal', '$rate', '$rate', '', '$currency', '$fxamount', '', '', '', '', '','','$job_title','$is_blanket')";
				$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				}
				
				
				$query55="update purchase_indent set approvalstatus='approved',pogeneration='completed' where docno='$docno'";
				$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	
				
			}
	}
	header("location:direct_purchaseapproval.php");
	exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direct Purchase Approval - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style type="text/css">
.ui-menu .ui-menu-item{ zoom:1 !important; }
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
}
</style>
<link href="autocomplete.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
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
        <span>Direct Purchase Approval</span>
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
                <h2>Direct Purchase Approval</h2>
                <p>Review and approve direct purchase requests from various departments.</p>
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
            <h3><i class="fas fa-search"></i> Search Purchase Requests</h3>
            
            <form name="cbform1" method="post" action="direct_purchaseapproval.php">
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
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="location">Location</label>
                        <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">
                            <option value="All">All</option>
                            <?php
                            $query1 = "select * from master_location where status=''  order by locationname";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $loccode=array();
                            while ($res1 = mysqli_fetch_array($exec1))
                            {
                                $locationname = $res1["locationname"];
                                $locationcode1 = $res1["locationcode"];
                                ?>
                                <option value="<?php echo $locationcode1; ?>" <?php if($location!='')if($location==$locationcode1){echo "selected";}?>><?php echo $locationname; ?></option>
                                <?php
                            } 
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="ADate1">Date From</label>
                        <div class="date-input-group">
                            <input name="ADate1" id="ADate1" value="<?php echo $ADate1; ?>" readonly="readonly" onKeyDown="return disableEnterKey()" class="date-picker">
                            <i class="fas fa-calendar-alt date-icon" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"></i>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="ADate2">Date To</label>
                        <div class="date-input-group">
                            <input name="ADate2" id="ADate2" value="<?php echo $ADate2; ?>" readonly="readonly" onKeyDown="return disableEnterKey()" class="date-picker">
                            <i class="fas fa-calendar-alt date-icon" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"></i>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                    <button type="submit" class="btn btn-primary" name="Submit">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <button type="reset" class="btn btn-secondary" id="resetbutton">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </form>
			</td>
			</tr>
			<script>
			$(function() {$("[id^='droupid']").hide(0);
			}
			);
			function dropdown(id,action)
			{
			if(action=='down')
			{
			$("#droupid"+id).slideDown(300); $("#down"+id).hide(0); $("#up"+id).show();
			}
			else if(action=='up')
			{
			$("#droupid"+id).slideUp(300);  $("#up"+id).hide(0); $("#down"+id).show();
			}
			}
			</script>			
			<form method="post" name="form1" action="direct_purchaseapproval.php"  onSubmit="return validcheck()">
			<tr>
			<td colspan="10" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Direct Pruchase Order</strong></label></div></td>
			</tr>
			
			<tr>
					<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
					<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Location </strong></div></td>
					<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date </strong></div></td>
					<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Doc No</strong></div></td>
					<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>user</strong></div></td>
					<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Status</strong></div></td>
					<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount</strong></div></td>
					<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Approve</strong></div></td>
            </tr>
			<?php
			if($cbfrmflag1=='cbfrmflag1'){
			if($location=='All')
			{
			$pass_location = "locationcode !=''";
			}
			else
			{
			$pass_location = "locationcode ='$location'";
			}
			$colorloopcount = '';
			$sno = '';
			$sno1 = '';
			$query34="select *,sum(amount) as transactionamount from purchase_indent where approvalstatus='pending' and pogeneration='pending' and date BETWEEN '".$ADate1."' and '".$ADate2."' and $pass_location group by docno";
			$exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res34=mysqli_fetch_array($exec34))
			{
			$locationname=$res34['locationname'];
			$docno=$res34['docno'];
			$date=$res34['date'];
			$user=$res34['username'];
			$budgetamount=$res34['transactionamount'];
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

				<td class="bodytext31" valign="center"  align="left"><?php  $sno = $sno + 1; ?>
				<a id="down<?php echo $sno; ?>" onClick="dropdown(<?php echo $sno; ?>,'down')" href="#" style="background:url(img/arrow1.png) 0px 10px;width:20px;height:10px;float:left;display:block;text-decoration:none;"></a>
				<a id="up<?php echo $sno; ?>"  onClick="dropdown(<?php echo $sno; ?>,'up')" href="#" style="background:url(img/arrow1.png) 0px 0px;width:20px;height:10px;float:left;display:block;text-decoration:none;display:none;"></a><div align="center"><?php echo $sno ; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $locationname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $user; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31" align="center"><?php echo 'pending' ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31" align="center"><?php echo number_format($budgetamount,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31" align="center"><input type="checkbox"  name="select[<?php echo $sno;?>]" id="select<?php echo $sno;?>" value="<?php echo $docno; ?>" onClick="checkboxselect('<?php echo $docno; ?>',this.id)" class="select"></div></td>
			</tr>
			
			<tr>
			<span>
			<td colspan="10"><div id="droupid<?php echo $sno; ?>" style="BORDER-COLLAPSE: collapse;">
			<table id="dr1" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" align="left" border="0">
			<tbody id="foo">
			<tr>
				<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center" width="25%"><strong>Suplier Name</strong></td>
				<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center" width="30%"><strong>Item Name</strong></td>
				<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Rate</strong></td>
				<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Qty</strong></td>
				<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Amount</strong></td>
			</tr>
			<?php
			$sno2 = 0;
			$totalamount=0;	
			$budgetamount=0;		
			$query12 = "select * from purchase_indent where docno='$docno' and approvalstatus='pending' and pogeneration!='completed'";
			$exec12= mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numb12=mysqli_num_rows($exec12);
			while($res12 = mysqli_fetch_array($exec12))
			{
			$medicinename = $res12['medicinename'];	
			$reqqty = $res12['quantity'];
			$rate = $res12['rate'];
			$suppliername = $res12['suppliername'];
			$amount = $res12['amount'];
		
			?>
			<tr>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $suppliername;?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $medicinename;?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $rate;?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $reqqty;?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $amount;?></div></td>
			</tr>
			<?php
			}
			?>
			</tbody>
			</table>
			</td>
			</span>
			</tr>
			<?php
			}
			}
			?>
			<tr>
			<td class="bodytext31" valign="center"  align="left">&nbsp;</td>
			</tr>
			<tr>
			<td colspan="7" class="bodytext31" valign="center"  align="right">
			<input type="hidden" name="frm1submit1" value="frm1submit1" />
			<input type="submit" name="submit" value="Submit" id="savepo"></td>
			</tr>			
			</form>
			</tbody>
		</table>
		</td>
        </div>
        
        <!-- Results Section -->
        <div class="data-table-section">
            <div class="table-header">
                <h3><i class="fas fa-list"></i> Purchase Requests for Approval</h3>
                <div class="search-bar">
                    <input type="text" placeholder="Search requests..." id="requestSearch">
                    <i class="fas fa-search"></i>
                </div>
            </div>
            
            <!-- Purchase approval form and table will continue here -->
        </div>
    </div>
    
    <!-- Modern JavaScript -->
    <script src="js/direct_purchaseapproval-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>