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
$searchsubtype = "";
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
//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_accounts.php");
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 $locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where locationcode='$locationcode1' and auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}

$query_acc = "SELECT * FROM finance_ledger_mapping WHERE map_anum = '20' AND record_status <> 'deleted'";
$exec_acc = mysqli_query($GLOBALS["___mysqli_ston"], $query_acc) or die ("Error in Query_acc".mysqli_error($GLOBALS["___mysqli_ston"]));
$ledgername = '';
$res_acc = mysqli_fetch_array($exec_acc);

$accountcode1 = $res_acc['ledger_id'];
$accountname1 = trim($res_acc['ledger_name']);

if (isset($_REQUEST["searchsuppliername1"])) { $searchsuppliername = $_REQUEST["searchsuppliername1"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchsubtypeanum1"])) { $searchsubtypeanum1 = $_REQUEST["searchsubtypeanum1"]; } else { $searchsubtypeanum1 = ""; }
if (isset($_REQUEST["searchaccountcode"])) { $searchaccountcode = $_REQUEST["searchaccountcode"]; } else { $searchaccountcode = ""; }
if (isset($_REQUEST["searchaccount"])) { $searchaccount = $_REQUEST["searchaccount"]; } else { $searchaccount = ""; }
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
if($frmflag2 == 'frmflag2')
{
	visitcreate:
	$locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
		$locationcodeget=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';
	$arrayrecno = $_REQUEST['recno'];

	
	$query7 = "select * from print_deliveryreport_billno order by id desc limit 0, 1";
	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res7 = mysqli_fetch_array($exec7);
	$printno1 = $res7['billno'];
	if($printno1 == '')
	{
		$printno = '1';
	}
	else
	{
		$printno = $printno1 + 1;
	}
    
	$query56="insert into print_deliveryreport_billno(billno)values('$printno')"; 
	$exec56=mysqli_query($GLOBALS["___mysqli_ston"], $query56) ;
	if( mysqli_errno($GLOBALS["___mysqli_ston"]) == 1062) {
	   goto visitcreate;
	}
	else if(mysqli_errno($GLOBALS["___mysqli_ston"]) > 0){
	   die ("Error in query56".mysqli_error($GLOBALS["___mysqli_ston"]));
	}

	//$printno = $_REQUEST['printno'];
	
	
	foreach ($arrayrecno as $recno)
	{
		$patientcode = $_REQUEST['patientcode'.$recno];
		$patientname = $_REQUEST['patientname'.$recno];
		$billno = $_REQUEST['billno'.$recno];
		$billdate = $_REQUEST['billdate'.$recno];
		$amount = $_REQUEST['amount'.$recno];
		$accountname = $_REQUEST['accountname'.$recno];
		$accountnameano_fet = $_REQUEST['accountnameano'.$recno];
		$accountnameid_fet = $_REQUEST['accountnameid'.$recno];



		$subtype = $_REQUEST['subtype'.$recno];
		if(isset($_REQUEST['isnhif'.$recno]))
			$fromnhif=1;
		else
           $fromnhif=0;

       $query_check = "SELECT * from print_deliverysubtype where billno='$billno' and accountnameid='$accountnameid_fet' and amount='$amount' and status != 'deleted'";
		$exec_check = mysqli_query($GLOBALS["___mysqli_ston"], $query_check) or die ("Error in Query_check".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res_check = mysqli_fetch_array($exec_check);
		 $num_check = mysqli_num_rows($exec_check);

		 if($num_check==0){
				$query5 = "insert into print_deliverysubtype(printno, patientcode, patientname, billno, billdate, amount, ipaddress, username, updatedatetime, subtype, accountname,accountnameid, locationname,locationcode,isnhif)
				values('$printno', '$patientcode', '$patientname', '$billno', '$billdate', '$amount', '$ipaddress', '$username', '$updatetime', '$subtype', '$accountname','$accountnameid_fet','".$locationnameget."','".$locationcodeget."','$fromnhif')";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			} 
	}
	
	header("location:deliveryreportsubtype.php?st=printsuccess&&printno=$printno");

}

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }




if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if (isset($_REQUEST["printno"])) { $printno = $_REQUEST["printno"]; } else { $printno = ""; }
if($st == 'printsuccess')
{
?>
<script>
window.open("print_deliverysubpdf2.php?printno=<?php echo $printno; ?>");
</script>
<?php
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Report Subtype - MedStar Hospital</title>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/deliveryreportsubtype-modern.css?v=<?php echo time(); ?>">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Existing CSS and JS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script type="text/javascript" src="js/autocomplete_subtype.js"></script>
    <script type="text/javascript" src="js/autosuggestsubtype.js"></script>
</head>

<script type="text/javascript">


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
	var oTextbox = new AutoSuggestControl1(document.getElementById("searchsuppliername1"), new StateSuggestions1());
	
}
</script>

<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
}

function funcAccount1()
{

if((document.getElementById("searchsubtypeanum1").value == "" || document.getElementById("searchsuppliername1").value == ""))
{
alert ('Please Select Sub type ');
document.getElementById("searchsuppliername1").focus();
return false;
}
}

function validcheck()
{

if(confirm("Do You Want To Save The Record?")==false){
	return false;
}	
return true;

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
.ui-menu .ui-menu-item{ zoom:1 !important; }
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

/*input[type="file"] {*/
 /*  content: 'Select some files';
  display: inline-block;
  background: linear-gradient(top, #f9f9f9, #e3e3e3);
  border: 1px solid #999;
  border-radius: 3px;
  padding: 5px 8px;
  outline: none;
  white-space: nowrap;
  -webkit-user-select: none;
  cursor: pointer;
  text-shadow: 1px 1px #fff;
  font-weight: 700;
  font-size: 10pt;*/
 /*width:80px;*/
/*}*/
 
</style>

<script src="js/jquery-1.11.1.min.js"></script>
 <script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link href="autocomplete.css" rel="stylesheet">
<script type="text/javascript">
function funcservice(){
$('#searchaccountcode').val('');
$('#searchaccount').autocomplete({
		
	source:'getaccountschemesearch.php?searchsubtypeanum='+$('#searchsubtypeanum1').val(), 
	//alert(source);
	minLength:1,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.saccountid;
			$('#searchaccountcode').val(code);
			},
    });
}
// $('input[type=file]').change(function () {
//     console.log(this.files[0].mozFullPath);
// });

function upload_claim_new(autono,billno,maintype){
	FuncPopup();
	var autono_final = autono;
	var billno = billno;
	var maintype = maintype;
	// alert(billno);
var property = document.getElementById('claimpdfa'+autono_final).files[0];
        var image_name = property.name;
        // alert(image_name);
        var image_extension = image_name.split('.').pop().toLowerCase();

        if(jQuery.inArray(image_extension,['pdf']) == -1){
          alert("Please Upload only the PDF files!");
          $("#imgloader").hide();
          $('#claimpdfa'+autono_final).val('');
          return false;
        }

        var check = confirm("Are you sure you want to Upload the "+image_name+"?");
        if (check != true) {
        	$("#imgloader").hide();
        	$('#claimpdfa'+autono_final).val('');
            return false;
        }

        var form_data = new FormData();
        form_data.append("file",property);
        // alert(form_data);
        $.ajax({
          url:'upload_files.php?auto='+autono_final+'&&uploadtype=claim&&billno='+billno+'&&uploadfrom=delivery&&maintype='+maintype,
          method:'POST',
          data:form_data,
          contentType:false,
          cache:false,
          processData:false,
          success:function(data){
            // alert(data);
             $('#claimpdfa'+autono_final).val('');
             $("#imgloader").hide();
             $("#showcalimpdf"+autono_final).show();
             return checkbox_hide(autono_final,maintype);
          }
        });
				// $('#claimpdfa'+autono_final).val('');
             	// $("#imgloader").hide();
}


function upload_invoice(autono,billno,maintype){
	FuncPopup();
	var autono_final = autono;
	var billno = billno;
	var maintype = maintype;
	var property = document.getElementById('invoicepdf'+autono_final).files[0];
        var image_name = property.name;
        var image_extension = image_name.split('.').pop().toLowerCase();
        if(jQuery.inArray(image_extension,['pdf']) == -1){
          alert("Please Upload only the PDF files!");
          $("#imgloader").hide();
          $('#invoicepdf'+autono_final).val('');
          return false;
        }

        var check = confirm("Are you sure you want to Upload the "+image_name+"?");
         if (check != true) {
         	$("#imgloader").hide();
         	$('#invoicepdf'+autono_final).val('');
            return false;
        	}

        var form_data = new FormData();
        form_data.append("file",property);
        // alert(form_data);
        $.ajax({
          url:'upload_files.php?auto='+autono_final+'&&uploadtype=invoice&&uploadfrom=delivery&&billno='+billno+'&&maintype='+maintype,
          method:'POST',
          data:form_data,
          contentType:false,
          cache:false,
          processData:false,
          // 
          success:function(data){
            // alert(data);
             $('#invoicepdf'+autono_final).val('');
             $("#imgloader").hide();
             $("#invoicepdfview"+autono_final).show();
             return checkbox_hide(autono_final,maintype);
          }
        });
        	 // $('#invoicepdf'+autono_final).val('');
             // $("#imgloader").hide();
}

function checkbox_hide(auto,maintype){
	
	var auotnumber2=auto;
	var maintype=maintype;
	// alert(auotnumber2);
	$.ajax({
          url:'upload_files.php?auto='+auotnumber2+'&&uploadtype=checkboxcheck&&maintype='+maintype,
          method:'POST',
          success:function(response){
            // alert(data);
					var result = $.trim(response);
					if(result==="success"){
					 		$(".checkbox"+auotnumber2).show();
							return false;
					}
          }
        });
}
 
function FuncPopup()
{
	window.scrollTo(0,0);
	document.getElementById("imgloader").style.display = "";
}
</script>
<style type="text/css">
.imgloader { background-color:#FFFFFF; }
#imgloader1 {
    position: absolute;
    /*margin: auto;*/
    top: 200px;
    left: 487px;
    width: 28%;
    height: 24%;
}
</style>
 
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
    <!-- Loading Overlay -->
    <div align="center" class="imgloader" id="imgloader" style="display:none;">
        <div align="center" class="imgloader" id="imgloader1" style="display:;">
            <p style="text-align:center;"><strong>Upload in Progress <br><br> Please be patience...</strong></p>
            <img src="images/ajaxloader.gif">
        </div>
    </div>

    <!-- Hospital Header -->
    <div class="hospital-header">
        <h1 class="hospital-title">MedStar Hospital</h1>
        <p class="hospital-subtitle">Delivery Report Subtype Management</p>
    </div>

    <!-- User Info Bar -->
    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <?php echo $username; ?></span>
            <span class="location-info">Location: <?php echo $companyname; ?></span>
        </div>
        <div class="user-actions">
            <a href="logout.php" class="btn btn-outline btn-sm">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <div class="nav-breadcrumb">
        <a href="dashboard.php">Dashboard</a>
        <span>/</span>
        <a href="reports.php">Reports</a>
        <span>/</span>
        <span>Delivery Report Subtype</span>
    </div>

    <!-- Floating Menu Toggle -->
    <button class="floating-menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>

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
                        <a href="deliveryreportsubtype.php" class="nav-link">
                            <i class="fas fa-file-medical"></i>
                            Delivery Report Subtype
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
                    <h2>Delivery Report Subtype</h2>
                    <p>Search and manage delivery reports by subtype</p>
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
                <form name="cbform1" method="post" action="deliveryreportsubtype.php" class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchsuppliername1" class="form-label">Search Subtype</label>
                            <input name="searchsuppliername1" type="text" id="searchsuppliername1" 
                                   value="<?php echo $searchsuppliername; ?>" 
                                   class="form-control" autocomplete="off" placeholder="Enter subtype name">
                            <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
                            <input name="searchsubtypeanum1" id="searchsubtypeanum1" value="<?php echo $searchsubtypeanum1; ?>" type="hidden">
                        </div>
                        
                        <div class="form-group">
                            <label for="searchaccount" class="form-label">Search Account</label>
                            <input name="searchaccount" type="text" id="searchaccount" 
                                   value="<?php echo $searchaccount; ?>" 
                                   onkeyup="return funcservice();" 
                                   class="form-control" placeholder="Enter account name">
                            <input type="hidden" name="searchaccountcode" onBlur="return suppliercodesearch1()" 
                                   id="searchaccountcode" style="text-transform:uppercase" 
                                   value="<?php echo $searchaccountcode; ?>" />
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
                                    $res1location = $res12["locationname"];
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
                        
                        <button type="submit" onClick="return funcAccount1()" class="btn btn-primary">
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
            </div>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td>
            <!-- Data Table Container -->
            <div class="data-table-container">
                <form method="post" name="form4" action="deliveryreportsubtype.php">
                    <input type="hidden" name="locationnameget" value="<?php echo $locationname;?>" >
                    <input type="hidden" name="locationcodeget" value="<?php echo $locationcode;?>" >
                    
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>No.</th>
                                <th>Reg No</th>
                                <th>Patient</th>
                                <th>Bill No</th>
                                <th>Account</th>
                                <th>Scheme</th>
                                <th>Bill Date</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
			<?php 
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
		    if ($cbfrmflag1 == 'cbfrmflag1')
			{
				
			if($searchaccountcode!=''){
				$schemetype="and b.scheme_id='$searchaccountcode'";
			}else{
				$schemetype="and b.scheme_id like '%%'";
			}
				
				
				
				if($searchsuppliername!='')
			      $query25 = "select auto_number,subtype from master_subtype where  subtype = '$searchsuppliername'";
				else
					$query25 = "select auto_number,subtype from master_subtype ";

			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res25 = mysqli_fetch_array($exec25)) {
			$searchsubtypeanum1 = $res25['auto_number'];
			$searchsubtype = $res25['subtype'];
			
			$query21 = "select auto_number,accountname,id,paymenttype,subtype from master_accountname where  subtype = '$searchsubtypeanum1' order by subtype desc";
			// and recordstatus <> 'DELETED' 
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res21 = mysqli_fetch_array($exec21))
			{
			$res21accountname =mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $res21['accountname']);
			$accno =$res21['auto_number'];
			$legid =$res21['id'];
			
			$query22 = "select accountname from billing_paylater where locationcode='$locationcode1' and  accountnameano = '$accno' and completed <> 'completed' and billdate between '$ADate1' and '$ADate2' and  billno NOT IN (SELECT  billno FROM print_deliverysubtype where status != 'deleted') group by accountnameano";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22);
			$res22accountname = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $res22['accountname']);
			
			$query23 = "select accountname from billing_ip where locationcode='$locationcode1' and  accountnameano = '$accno' and completed <> 'completed' and billdate between '$ADate1' and '$ADate2' and  billno NOT IN (SELECT  billno FROM print_deliverysubtype where status != 'deleted' and accountname!='$accountname1') group by accountnameano"; 
		    $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res23 = mysqli_fetch_array($exec23);
			$res23accountname =mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $res23['accountname']);

			if($res21accountname==$accountname1){
           		$res25accountname=$accountname1;

			}else
				$res25accountname='';
			
			$query24 = "select accountname from billing_ipcreditapprovedtransaction where locationcode='$locationcode1' and  accountnameano = '$accno' and  billno NOT IN (SELECT  billno FROM print_deliverysubtype where status != 'deleted' and accountnameid = '$legid' ) and completed <> 'completed' and billdate between '$ADate1' and '$ADate2' group by accountnameano"; 
		    $exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res24 = mysqli_fetch_array($exec24);
			$res24accountname =mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $res24['accountname']);
			
			if( $res22accountname != '' || $res23accountname != '' || $res24accountname != '' || $res25accountname!='')
			{
			?>

			<tr bgcolor="#ecf0f5">
              <th colspan="9"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $res21accountname;?></strong></th>
            </tr>
			
			<?php
		  $query2 = "select a.* from billing_paylater as a join master_visitentry as b on a.visitcode=b.visitcode where a.locationcode='$locationcode1' and  a.accountnameano = '$accno' and a.completed <> 'completed' and a.billdate between '$ADate1' and '$ADate2'  and  a.billno NOT IN (SELECT  billno FROM print_deliverysubtype where status != 'deleted') $schemetype  group by a.billno order by a.accountname, a.billdate desc"; 
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res2num = mysqli_num_rows($exec2);

		  

		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  $auto_numbernew = $res2['auto_number'];
     	  $res2accountname = $res2['accountname'];
     	  $res2accountnameano = $res2['accountnameano'];
     	  $res2accountnameid = $res2['accountnameid'];

		  $res2patientcode = $res2['patientcode'];
		  $res2visitcode = $res2['visitcode'];
		  $res2billno = $res2['billno'];
          $res2totalamount = $res2['totalamount'];
		  $res2billdate = $res2['billdate'];
		  $res2patientname = $res2['patientname'];
		  $res3subtype = $res2['subtype'];
			

			
			$query3 = "select scheme_id,subtype from master_visitentry where visitcode = '$res2visitcode'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$scheme_id = $res3['scheme_id'];	
			$subtype = $res3['subtype'];	

			$query4 = "select subtype from master_subtype where  auto_number = '$subtype'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$res4subtype = $res4['subtype'];

			$query_sc = "select scheme_name from master_planname where scheme_id = '$scheme_id'";
			$exec_sc = mysqli_query($GLOBALS["___mysqli_ston"], $query_sc) or die ("Error in query_sc".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res_sc = mysqli_fetch_array($exec_sc);
			$scheme_name = $res_sc['scheme_name'];


		  $slade_status = $res2['slade_status'];
		  $slade_claim_id = $res2['slade_claim_id'];
		  $claim_file = $res2['upload_claim'];
		  $invoice_file = $res2['upload_invoice'];

		  
		  $total = $total + $res2totalamount;
		  $snocount = $snocount + 1;

			//echo $cashamount;
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

			<!-- checkbox_hide -->


           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left">

              	 <input type="checkbox"  name="recno[]" id="recno[]" value="<?php  echo $snocount; ?>" class='checkbox<?=$auto_numbernew;?>'>


              	   <?php 
              	  // echo '<script type="text/javascript"> checkbox_hide('.$auto_numbernew.',"OP")</script>';
              	   // if(($slade_status=='completed' && $slade_claim_id!='') || ($slade_claim_id=='' )  ||  ($claim_file!='' && $invoice_file!='') ){

              	   	
              	   	// echo "<script type='text/javascript'>return checkbox_hide(".$auto_numbernew.")</script>";
              	 ?> 
			  		<!--<input type="checkbox"  name="recno[]" id="recno[]" value="<?php echo $snocount; ?>">  -->
			  	<?php // }else{ 	?>
			  		<!-- &nbsp; -->
			  <?php  // } ?> 
			  </td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientcode<?php echo $snocount; ?>" id="patientcode<?php echo $snocount; ?>" value="<?php echo $res2patientcode; ?>">
				<?php echo $res2patientcode; ?> </div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">

				<input type="hidden" name="patientname<?php echo $snocount; ?>" id="patientname<?php echo $snocount; ?>" value="<?php echo $res2patientname; ?>">
				<?php echo $res2patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <input type="hidden" name="billno<?php echo $snocount; ?>" id="billno<?php echo $snocount; ?>" value="<?php echo $res2billno; ?>">
			  <?php echo $res2billno; ?></td>
<td class="bodytext31" valign="center"  align="left"><?php echo $res4subtype; ?></td>
<td class="bodytext31" valign="center"  align="left"><?php echo $scheme_name; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
				<input type="hidden" name="billdate<?php echo $snocount; ?>" id="billdate<?php echo $snocount; ?>" value="<?php echo $res2billdate; ?>">
				<?php echo $res2billdate; ?></div></td>





              <td class="bodytext31" valign="center"  align="left"><div align="right">
			  <input type="hidden" name="accountname<?php echo $snocount; ?>" id="accountname<?php echo $snocount; ?>" value="<?php echo $res2accountname; ?>">


			  <input type="hidden" name="accountnameano<?php echo $snocount; ?>" id="accountnameano<?php echo $snocount; ?>" value="<?php echo $accno; ?>">
			  <input type="hidden" name="accountnameid<?php echo $snocount; ?>" id="accountnameid<?php echo $snocount; ?>" value="<?php echo $legid; ?>">

			  

			  <input type="hidden" name="amount<?php echo $snocount; ?>" id="amount<?php echo $snocount; ?>" value="<?php echo $res2totalamount; ?>">
			  <input type="hidden" name="subtype<?php echo $snocount; ?>" id="subtype<?php echo $snocount; ?>" value="<?php echo $res3subtype; ?>">
			  <?php echo number_format($res2totalamount,2,'.',',');  ?></div></td>
			  	
              <td bgcolor="#ecf0f5"class="bodytext31" valign="center"  align="left">&nbsp;</td>
              <td bgcolor="#ecf0f5"class="bodytext31" valign="center"  align="left">&nbsp;</td>
           </tr>
			<?php
		   }
		   if($legid==$accountcode1){
            
			 $query3 = "select a.* from billing_ipnhif as a join master_ipvisitentry as b on a.visitcode=b.visitcode where a.locationcode='$locationcode1' and  a.completed <> 'completed' and a.recorddate between '$ADate1' and '$ADate2'  and  a.docno NOT IN (SELECT  billno FROM print_deliverysubtype where status != 'deleted' and accountname='$accountname1' and isnhif='1') $schemetype order by a.recorddate desc"; 
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while ($res3 = mysqli_fetch_array($exec3))
			  {

				  $res3accountname = $accountname1;
				  $accountcode = $res3['accountcode'];

				  $res3patientcode = $res3['patientcode'];
				  $res3visitcode = $res3['visitcode'];
				  $res3billno = $res3['docno'];
				  $res3totalamount = $res3['finamount'];
				  $res3billdate = $res3['recorddate'];
				  $res3patientname = $res3['patientname'];
				  
                    $sqlmain="select subtype from master_transactionpaylater where billnumber='$res3billno' and accountname='$res3accountname'";
					$execs3 = mysqli_query($GLOBALS["___mysqli_ston"], $sqlmain) or die ("Error in sqlmain".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ress3 = mysqli_fetch_array($execs3);
					$res3subtype = $ress3['subtype'];



				$query3 = "select scheme_id,subtype from master_ipvisitentry where visitcode = '$res3visitcode'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$scheme_id = $res3['scheme_id'];	
			$subtype = $res3['subtype'];	

			$query4 = "select subtype from master_subtype where  auto_number = '$subtype'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$res4subtype = $res4['subtype'];
			
			$query_sc = "select scheme_name from master_planname where scheme_id = '$scheme_id'";
			$exec_sc = mysqli_query($GLOBALS["___mysqli_ston"], $query_sc) or die ("Error in query_sc".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res_sc = mysqli_fetch_array($exec_sc);
			$scheme_name = $res_sc['scheme_name'];
				  

				  
		  $total = $total + $res3totalamount;
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
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
		   <td class="bodytext31" valign="center"  align="left">
			  <input type="checkbox" name="recno[]" id="recno[]" value="<?php echo $snocount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientcode<?php echo $snocount; ?>" id="patientcode<?php echo $snocount; ?>" value="<?php echo $res3patientcode; ?>">
				<?php echo $res3patientcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientname<?php echo $snocount; ?>" id="patientname<?php echo $snocount; ?>" value="<?php echo $res3patientname; ?>">
				<?php echo $res3patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <input type="hidden" name="billno<?php echo $snocount; ?>" id="billno<?php echo $snocount; ?>" value="<?php echo $res3billno; ?>">
			  <?php echo $res3billno; ?></td>
<td class="bodytext31" valign="center"  align="left"><?php echo $res4subtype; ?></td>
<td class="bodytext31" valign="center"  align="left"><?php echo $scheme_name; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
				<input type="hidden" name="billdate<?php echo $snocount; ?>" id="billdate<?php echo $snocount; ?>" value="<?php echo $res3billdate; ?>">
				<?php echo $res3billdate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left"><div align="right">
			  <input type="hidden" name="accountname<?php echo $snocount; ?>" id="accountname<?php echo $snocount; ?>" value="<?php echo $res3accountname; ?>">

			  <input type="hidden" name="accountnameano<?php echo $snocount; ?>" id="accountnameano<?php echo $snocount; ?>" value="<?php echo $accno; ?>">
			  <input type="hidden" name="accountnameid<?php echo $snocount; ?>" id="accountnameid<?php echo $snocount; ?>" value="<?php echo $legid; ?>">

			  <input type="hidden" name="amount<?php echo $snocount; ?>" id="amount<?php echo $snocount; ?>" value="<?php echo $res3totalamount; ?>">
			  <input type="hidden" name="subtype<?php echo $snocount; ?>" id="subtype<?php echo $snocount; ?>" value="<?php echo $res3subtype; ?>">
			  <?php echo number_format($res3totalamount,2,'.',','); ?></div></td>
			  <input type="hidden" name="isnhif<?php echo $snocount; ?>" id="isnhif<?php echo $snocount; ?>" value="1">
              <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
              
           </tr>
			<?php

			  }
      

		   }
		
		
		  //// ip
		   $query31 = "select a.* from billing_ip as a join master_ipvisitentry as b on a.visitcode=b.visitcode where a.locationcode='$locationcode1' and  a.accountnameano = '$accno' and a.completed <> 'completed' and a.billdate between '$ADate1' and '$ADate2'  and  a.billno NOT IN (SELECT  billno FROM print_deliverysubtype where status != 'deleted' and isnhif='0') $schemetype group by a.billno order by a.accountname, a.billdate desc"; 
		  $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res3 = mysqli_fetch_array($exec31))
		  {
     	  $res3accountname = $res3['accountname'];
		  $res3patientcode = $res3['patientcode'];
		  $res3visitcode = $res3['visitcode'];
		  $res3billno = $res3['billno'];
          $res3totalamount = $res3['totalamount'];
		  $res3billdate = $res3['billdate'];
		  $res3patientname = $res3['patientname'];
          $res3subtype = $res3['subtype'];


          $auto_numbernew = $res3['auto_number'];
          $slade_status = $res3['slade_status'];
		  $slade_claim_id = $res3['slade_claim_id'];
		  $claim_file = $res3['upload_claim'];
		  $invoice_file = $res3['upload_invoice'];
		  

	$query3 = "select scheme_id,subtype from master_ipvisitentry where visitcode = '$res3visitcode'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$scheme_id = $res3['scheme_id'];	
			$subtype = $res3['subtype'];	
			

			$query4 = "select subtype from master_subtype where  auto_number = '$subtype'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$res4subtype = $res4['subtype'];

			$query_sc = "select scheme_name from master_planname where scheme_id = '$scheme_id'";
			$exec_sc = mysqli_query($GLOBALS["___mysqli_ston"], $query_sc) or die ("Error in query_sc".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res_sc = mysqli_fetch_array($exec_sc);
			$scheme_name = $res_sc['scheme_name'];

		  
		  $total = $total + $res3totalamount;
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
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
		   <td class="bodytext31" valign="center"  align="left">
			  <!-- <input type="checkbox" name="recno[]" id="recno[]" value="<?php echo $snocount; ?>"> -->
			  <input type="checkbox"  name="recno[]" id="recno[]" value="<?php  echo $snocount; ?>" class='checkbox<?=$auto_numbernew;?>'>
              	   <?php 
              	   //echo '<script type="text/javascript"> checkbox_hide('.$auto_numbernew.',"IP")</script>';
              	   ?>
              	   </td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientcode<?php echo $snocount; ?>" id="patientcode<?php echo $snocount; ?>" value="<?php echo $res3patientcode; ?>">
				<?php echo $res3patientcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientname<?php echo $snocount; ?>" id="patientname<?php echo $snocount; ?>" value="<?php echo $res3patientname; ?>">
				<?php echo $res3patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <input type="hidden" name="billno<?php echo $snocount; ?>" id="billno<?php echo $snocount; ?>" value="<?php echo $res3billno; ?>">
			  <?php echo $res3billno; ?></td>
<td class="bodytext31" valign="center"  align="left"><?php echo $res4subtype; ?></td>
<td class="bodytext31" valign="center"  align="left"><?php echo $scheme_name; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
				<input type="hidden" name="billdate<?php echo $snocount; ?>" id="billdate<?php echo $snocount; ?>" value="<?php echo $res3billdate; ?>">
				<?php echo $res3billdate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left"><div align="right">
			  <input type="hidden" name="accountname<?php echo $snocount; ?>" id="accountname<?php echo $snocount; ?>" value="<?php echo $res3accountname; ?>">

			  <input type="hidden" name="accountnameano<?php echo $snocount; ?>" id="accountnameano<?php echo $snocount; ?>" value="<?php echo $accno; ?>">
			  <input type="hidden" name="accountnameid<?php echo $snocount; ?>" id="accountnameid<?php echo $snocount; ?>" value="<?php echo $legid; ?>">

			  <input type="hidden" name="amount<?php echo $snocount; ?>" id="amount<?php echo $snocount; ?>" value="<?php echo $res3totalamount; ?>">
			  <input type="hidden" name="subtype<?php echo $snocount; ?>" id="subtype<?php echo $snocount; ?>" value="<?php echo $res3subtype; ?>">
			  <?php echo number_format($res3totalamount,2,'.',','); ?></div></td>



              <td bgcolor="#ecf0f5"class="bodytext31" valign="center"  align="left">&nbsp;</td>
              <td bgcolor="#ecf0f5"class="bodytext31" valign="center"  align="left">&nbsp;</td>
           </tr>
			<?php
			}
			 $query32 = "select a.* from billing_ipcreditapprovedtransaction as a join master_ipvisitentry as b on a.visitcode=b.visitcode where a.locationcode='$locationcode1'  and a.completed <> 'completed' and a.billdate between '$ADate1' and '$ADate2' and a.accountnameano = '$accno' and  a.billno NOT IN (SELECT  billno FROM print_deliverysubtype where status != 'deleted' and accountnameid = '$legid') $schemetype group by a.billno order by a.accountname, a.billdate desc"; 
		  $exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res3 = mysqli_fetch_array($exec32))
		  {
     	  $res3accountname = $res3['accountname'];
		  $res3patientcode = $res3['patientcode'];
		  $res3visitcode = $res3['visitcode'];
		  $res3billno = $res3['billno'];
          $res3totalamount = $res3['totalamount'];
		  $res3billdate = $res3['billdate'];
		  $res3patientname = $res3['patientname'];
          $res3subtype = $res3['subtype'];


	$query3 = "select scheme_id,subtype from master_ipvisitentry where visitcode = '$res3visitcode'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$scheme_id = $res3['scheme_id'];	
			$subtype = $res3['subtype'];

			$query4 = "select subtype from master_subtype where  auto_number = '$subtype'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$res4subtype = $res4['subtype'];

			$query_sc = "select scheme_name from master_planname where scheme_id = '$scheme_id'";
			$exec_sc = mysqli_query($GLOBALS["___mysqli_ston"], $query_sc) or die ("Error in query_sc".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res_sc = mysqli_fetch_array($exec_sc);
			$scheme_name = $res_sc['scheme_name'];
		  
		  $total = $total + $res3totalamount;
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
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
		   <td class="bodytext31" valign="center"  align="left">
			  <input type="checkbox" name="recno[]" id="recno[]" value="<?php echo $snocount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientcode<?php echo $snocount; ?>" id="patientcode<?php echo $snocount; ?>" value="<?php echo $res3patientcode; ?>">
				<?php echo $res3patientcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientname<?php echo $snocount; ?>" id="patientname<?php echo $snocount; ?>" value="<?php echo $res3patientname; ?>">
				<?php echo $res3patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <input type="hidden" name="billno<?php echo $snocount; ?>" id="billno<?php echo $snocount; ?>" value="<?php echo $res3billno; ?>">
			  <?php echo $res3billno; ?></td>

<td class="bodytext31" valign="center"  align="left"><?php echo $res4subtype; ?></td>
<td class="bodytext31" valign="center"  align="left"><?php echo $scheme_name; ?></td>

              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
				<input type="hidden" name="billdate<?php echo $snocount; ?>" id="billdate<?php echo $snocount; ?>" value="<?php echo $res3billdate; ?>">
				<?php echo $res3billdate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left"><div align="right">
			  <input type="hidden" name="accountname<?php echo $snocount; ?>" id="accountname<?php echo $snocount; ?>" value="<?php echo $res3accountname; ?>">

			  <input type="hidden" name="accountnameano<?php echo $snocount; ?>" id="accountnameano<?php echo $snocount; ?>" value="<?php echo $accno; ?>">
			  <input type="hidden" name="accountnameid<?php echo $snocount; ?>" id="accountnameid<?php echo $snocount; ?>" value="<?php echo $legid; ?>">


			  <input type="hidden" name="amount<?php echo $snocount; ?>" id="amount<?php echo $snocount; ?>" value="<?php echo $res3totalamount; ?>">
			  <input type="hidden" name="subtype<?php echo $snocount; ?>" id="subtype<?php echo $snocount; ?>" value="<?php echo $res3subtype; ?>">
			  <?php echo number_format($res3totalamount,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
              <td bgcolor="#ecf0f5" class="bodytext31" valign="center"  align="left">&nbsp;</td>
              <td bgcolor="#ecf0f5" class="bodytext31" valign="center"  align="left">&nbsp;</td>
           </tr>
			<?php
			}
			}
			}
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
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong>Total:</strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($total,2,'.',','); ?></strong></div></td>

                 <td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>
                 <td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>

              <td rowspan="2" align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
			  <?php if($total != 0.00) { ?>	
              <td rowspan="2" align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><a target="_blank" href="xl_deliveryreport.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $locationcode1; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&account=<?php echo $searchsuppliername; ?>&&searchaccountcode=<?php echo $searchaccountcode; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></div></td>
              <?php } ?>
			</tr>
			<tr>
                                <td colspan="9" style="text-align: center; padding: 1.5rem;">
                                    <input type="hidden" name="frmflag2" id="frmflag2" value="frmflag2">
                                    <button type="submit" name="Submit1" class="btn btn-primary" onClick="return validcheck()">
                                        <i class="fas fa-paper-plane"></i> Submit Selected Records
                                    </button>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </main>
    </div>
    <!-- Modern JavaScript -->
    <script src="js/deliveryreportsubtype-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
