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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery vs Dispatch - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/deliveryvsdispatch-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Existing CSS -->
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
</head>



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
            <a href="logout.php" class="btn btn-outline btn-sm">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <span>Delivery vs Dispatch</span>
    </nav>

    <!-- Floating Menu Toggle -->
    <div id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </div>

    <!-- Alert Container -->
    <div id="alertContainer"></div>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar">
        <!-- Left Sidebar -->
        <div class="left-sidebar" id="leftSidebar">
            <div class="sidebar-header">
                <h3>Navigation</h3>
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reports.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            Reports
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="deliveryvsdispatch.php" class="nav-link">
                            <i class="fas fa-truck"></i>
                            Delivery vs Dispatch
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="patientlist.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            Patients
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billing.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            Billing
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Delivery vs Dispatch</h2>
                    <p>Compare delivery and dispatch statistics for invoices</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-outline" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>

            <!-- Search Form Container -->
            <div class="search-form-container">
                <form name="cbform1" method="post" action="deliveryvsdispatch.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchsuppliername1" class="form-label">Search Subtype</label>
                            <input name="searchsuppliername1" type="text" id="searchsuppliername1" 
                                   value="<?php echo $searchsuppliername; ?>" 
                                   class="form-control" autocomplete="off" placeholder="Enter subtype name">
                            <input name="searchaccoutnameanum" id="searchaccoutnameanum" value="<?php echo $searchaccoutnameanum; ?>" type="hidden">
                        </div>
                        
                        <div class="form-group">
                            <label for="searchaccoutname" class="form-label">Search Account</label>
                            <input name="searchaccoutname" type="text" id="searchaccoutname" 
                                   value="<?php echo $searchaccoutname; ?>" 
                                   class="form-control" autocomplete="off" placeholder="Enter account name">
                            <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
                            <input name="searchsubtypeanum1" id="searchsubtypeanum1" value="<?php echo $searchsubtypeanum1; ?>" type="hidden">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <input name="ADate1" id="ADate1" value="<?php echo $ADate1; ?>" 
                                   class="form-control" readonly="readonly" 
                                   onKeyDown="return disableEnterKey()" />
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" 
                                 style="cursor:pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);"/>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <input name="ADate2" id="ADate2" value="<?php echo $ADate2; ?>" 
                                   class="form-control" readonly="readonly" 
                                   onKeyDown="return disableEnterKey()" />
                            <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" 
                                 style="cursor:pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);"/>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <select name="location" id="location" onChange="ajaxlocationfunction(this.value);" class="form-control">
                                <?php
                                $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
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
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Current Location</label>
                            <div class="form-control" style="background: var(--background-accent);" id="ajaxlocation">
                                <strong>
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
                                </strong>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" 
                               onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" 
                               style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" />
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <button name="resetbutton" type="reset" id="resetbutton" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                        <button type="button" class="btn btn-outline" onclick="clearForm()">
                            <i class="fas fa-times"></i> Clear
                        </button>
                    </div>
                </form>
            </div>            <!-- Data Table Container -->
            <div class="data-table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Account</th>
                            <th>Inv.Delivered(OP)</th>
                            <th>Inv.Delivered(IP)</th>
                            <th>Total</th>
                            <th>Inv.Dispatched(OP)</th>
                            <th>Inv.Dispatched(IP)</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
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
                            <tr style="background: var(--background-accent);">
                                <td colspan="8" style="font-weight: bold; padding: 1rem;">
                                    <?php echo $searchsuppliername; ?>
                                </td>
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
                            <tr>
                                <td><?php echo $colorloopcount; ?></td>
                                <td><?php echo $res_accountname; ?></td>
                                <td style="text-align: right;"><?php if($res26['delivery_op']>0) echo $res26['delivery_op']; else echo '0'; ?></td>
                                <td style="text-align: right;"><?php if($res24['delivery_ip']>0) echo $res24['delivery_ip']; else echo '0'; ?></td>
                                <td style="text-align: right;"><?php echo $res24['delivery_ip']+$res26['delivery_op']; ?></td>
                                <td style="text-align: right;"><?php if($res22['dispatch_op']>0) echo $res22['dispatch_op']; else echo '0'; ?></td>
                                <td style="text-align: right;"><?php if($res21['dispatch_ip']>0) echo $res21['dispatch_ip']; else echo '0'; ?></td>
                                <td style="text-align: right;"><?php echo $res21['dispatch_ip']+$res22['dispatch_op']; ?></td>
                            </tr>
			<?php
		   }
		  }
		}
		 ?>
                            <tr style="background: var(--background-accent); font-weight: bold;">
                                <td></td>
                                <td style="text-align: right;">Grand Total:</td>
                                <td></td>
                                <td></td>
                                <td style="text-align: right;"><?php echo number_format($delivery_tot);?></td>
                                <td></td>
                                <td></td>
                                <td style="text-align: right;"><?php echo number_format($dispatch_tot);?></td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    <!-- Modern JavaScript -->
    <script src="js/deliveryvsdispatch-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
