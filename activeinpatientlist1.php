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
 
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";


$query1 = "select employeecode from master_employee where  status = 'Active' AND username like '%$username%'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1employeename  = $res1["employeecode"];



$location =isset( $_REQUEST['location'])?$_REQUEST['location']:'';
if (isset($_REQUEST["searchpatient"])) { $searchpatient = $_REQUEST["searchpatient"]; } else { $searchpatient = ""; }
if (isset($_REQUEST["searchpatientcode"])) { $searchpatientcode = $_REQUEST["searchpatientcode"]; } else { $searchpatientcode = ""; }
if (isset($_REQUEST["searchvisitcode"])) { $searchvisitcode = $_REQUEST["searchvisitcode"]; } else { $searchvisitcode = ""; }
if (isset($_REQUEST["ward"])) { $ward12 = $_REQUEST["ward"]; } else { $ward12 = ""; }

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum' and locationcode='$locationcode'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag2 == 'frmflag2')
{

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active Inpatient List - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
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
    .bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
    }
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
					
//ajax to get location which is selected ends here


function funcwardChange1()
{
	<?php 
	$query12 = "select * from master_location";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res12 = mysqli_fetch_array($exec12))
	{
	 $res12subtypeanum = $res12["auto_number"];
	$res12locationname = $res12["locationname"];
	$res12locationcode = $res12["locationcode"];
	?>

	if(document.getElementById("location").value=="<?php echo $res12locationcode; ?>")
	{

		document.getElementById("ward").options.length=null; 
		var combo = document.getElementById('ward'); 	
		<?php 
		$loopcount=0; 
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Ward", ""); 
		<?php
		$query10 = "select * from master_ward where locationname = '$res12locationname' and recordstatus = '' order by ward";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10accountnameanum = $res10["auto_number"];
		$ward = $res10["ward"];
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $ward;?>", "<?php echo $res10accountnameanum;?>"); 
		<?php 
		}
		?>
	}
	<?php
	}
	?>	
}


function cbsuppliername1()
{
	document.cbform1.submit();
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


function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
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
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
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
        <span>Patient Management</span>
        <span>→</span>
        <span>Active Inpatient List</span>
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
                <h2>Active Inpatient List</h2>
                <p>View and manage all active inpatients across different wards and locations.</p>
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

        <!-- Quick Links -->
        <div class="quick-links">
            <a href="inpatientactivity.php">
                <i class="fas fa-chart-line"></i> View IP Activity List
            </a>
        </div>

        <!-- Search Form Section -->
        <div class="form-section">
            <h3><i class="fas fa-search"></i> Search Active Inpatients</h3>
		
            
            <form name="cbform1" method="post" action="activeinpatientlist1.php">
                <div class="form-row">
                    <div class="form-group">
                        <label for="searchpatient">Patient Name</label>
                        <input name="searchpatient" type="text" id="searchpatient" value="" autocomplete="off" placeholder="Enter patient name">
                    </div>
                    
                    <div class="form-group">
                        <label for="searchpatientcode">Patient Code</label>
                        <input name="searchpatientcode" type="text" id="searchpatientcode" value="" autocomplete="off" placeholder="Enter patient code">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="searchvisitcode">Visit Code</label>
                        <input name="searchvisitcode" type="text" id="searchvisitcode" value="" autocomplete="off" placeholder="Enter visit code">
                    </div>
                    
                    <div class="form-group">
                        <label for="location">Location</label>
                        <select name="location" id="location" onChange="funcwardChange1(); ajaxlocationfunction(this.value);">
                            <option value="">Select Location</option>
                            <?php
                            $query1 = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
                            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $loccode=array();
                            while ($res1 = mysqli_fetch_array($exec1))
                            {
                                $locationname = $res1["locationname"];
                                $locationcode = $res1["locationcode"];
                                ?>
                                <option value="<?php echo $locationcode; ?>" <?php if($location!=''){if($location == $locationcode){echo "selected";}}?>><?php echo $locationname; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="ward">Ward</label>
                        <select name="ward" id="ward">
                            <option value="">Select Ward</option>
                            <?php
                            $query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname"; 
                            $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $res = mysqli_fetch_array($exec);
                            
                            $locationname  = $res["locationname"]; 
                            $locationcode2 = $res["locationcode"];
                            
                            $query78 = "select B.auto_number,B.ward,A.wardcode from nurse_ward as A join master_ward as B on (B.auto_number=A.wardcode) where  A.locationcode='$locationcode2' and B.recordstatus=''  and A.employeecode='$res1employeename'  order by A.defaultward desc";
                            $exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($res78 = mysqli_fetch_array($exec78))
                            {
                                $wardanum = $res78['auto_number'];
                                $wardname = $res78['ward'];
                                ?>
                                <option value="<?php echo $wardanum; ?>"<?php if($wardanum == $ward12) { echo "selected"; }?>><?php echo $wardname; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-actions">
                    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                    <button type="submit" class="btn btn-primary" name="Submit" onClick="return funcvalidcheck();">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <button type="reset" class="btn btn-secondary" id="resetbutton">
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
                <h3><i class="fas fa-list"></i> Active Inpatient List</h3>
                <div class="search-bar">
                    <input type="text" placeholder="Search patients..." id="patientSearch">
                    <i class="fas fa-search"></i>
                </div>
            </div>
            
            <?php
            $colorloopcount=0;
            $sno=0;
            
            if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
            //$cbfrmflag1 = $_POST['cbfrmflag1'];
            if ($cbfrmflag1 == 'cbfrmflag1')
            {
                
                //if (isset($_REQUEST["ward"])) { $searchward = $_REQUEST["ward"]; } else { $searchward = ""; }
                //$searchward = $_POST['ward'];
                //echo $nn=((isset($_POST['ward']))?"True":"False");
                $searchward=((isset($_POST['ward']))?$_POST['ward']:"");
                
                $searchlocation = $_POST['location'];
                
                $query781 = "select * from master_ward where auto_number='$searchward'  and locationcode='$searchlocation' and recordstatus=''";
                $exec781 = mysqli_query($GLOBALS["___mysqli_ston"], $query781) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $res781 = mysqli_fetch_array($exec781);
                $wardname = $res781['ward'];
                
                //echo $searchpatient;
                //$transactiondatefrom = $_REQUEST['ADate1'];
                //$transactiondateto = $_REQUEST['ADate2'];
                
                ?>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>PKG</th>
                            <th>Patient Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Reg No</th>
                            <th>DOA</th>
                            <th>IP Visit</th>
                            <th>Ward</th>
                            <th>Bed No</th>
                            <th>Account</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
           <?php
             $query34 = "select * from master_ward where ward = '$wardname'  and locationcode='$searchlocation'";
			$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res34 = mysqli_fetch_array($exec34))
			{
			 $wardnum = $res34['auto_number'];
			 $wardname5 = $res34['ward'];
			?>
                            <tr class="ward-header">
                                <td colspan="12">
                                    <i class="fas fa-hospital"></i> <?php echo $wardname5; ?>
                                </td>
                            </tr>
			<?php
			
	     $query50 = "select * from master_bed where ward='$wardnum' and locationcode='$searchlocation'"; 
		$exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res50 = mysqli_fetch_array($exec50))
		{
		 $bedname = $res50['bed'];
		 $bedanum = $res50['auto_number'];
		 $bed = '';
		 $ward = '';
		 $patientcode = '';
		 $visitcode = ''; 
		
		
		$query69 = "select * from master_bed where auto_number='$bedanum' and ward='$wardnum' and locationcode='$searchlocation' and recordstatus='occupied' order by auto_number desc limit 0, 1";
		$exec69 = mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num69 = mysqli_num_rows($exec69);
		//$num69=1;
	
	    $query59 = "select * from ip_bedallocation where ward='$wardnum' and bed='$bedanum' and locationcode='$searchlocation' and patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and recordstatus NOT IN ('discharged','transfered') order by auto_number desc limit 0, 1";
		$exec59 = mysqli_query($GLOBALS["___mysqli_ston"], $query59) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res59 = mysqli_fetch_array($exec59);
		$num59 = mysqli_num_rows($exec59);
		if($num59 > 0)
		{
	
		$ward = $res59['ward'];
		$bed = $res59['bed'];
		$patientname = $res59['patientname'];
		$patientcode = $res59['patientcode'];
		$visitcode = $res59['visitcode'];
	
		
	    $query49 = "select * from master_ipvisitentry where patientcode='$patientcode'  and locationcode='$searchlocation' and visitcode='$visitcode' and discharge not in ('discharged','completed') order by auto_number desc limit 0, 1" ;
		$exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res49 = mysqli_fetch_array($exec49);
		$date = $res49['consultationdate'];
		$accoutname = $res49['accountfullname'];
		$subtypeid = $res49['subtype'];

		$query493 = "select * from master_subtype where auto_number = '$subtypeid'";
		$exec493 = mysqli_query($GLOBALS["___mysqli_ston"], $query493) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res493 = mysqli_fetch_array($exec493);
		$subtypename = $res493['subtype'];
		
		
		$query10 = "select * from master_ipvisitentry where patientcode='$patientcode'  and locationcode='$searchlocation' and discharge not in ('discharged','completed') ";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res10 = mysqli_fetch_array($exec10);
		$res10age = $res10['age'];
		$res10gender = $res10['gender'];
	
		$query67 = "select * from ip_bedtransfer where ward='$wardnum' and bed='$bedanum'  and locationcode='$searchlocation' and recordstatus NOT IN ('discharged','transfered') order by auto_number desc limit 0, 1";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res67 = mysqli_fetch_array($exec67);
		$num67 = mysqli_num_rows($exec67);
		if($num67 > 0)
		{
		/*$ward = $res67['ward'];
		$bed = $res67['bed'];
	    $patientname = $res67['patientname'];
		$patientcode = $res67['patientcode'];
		$visitcode = $res67['visitcode'];
		
		
		$query49 = "select * from master_ipvisitentry where patientcode='$patientcode'  and locationcode='$searchlocation' and visitcode='$visitcode' and discharge<>'discharge' order by auto_number desc limit 0, 1" ;
		$exec49 = mysql_query($query49) or die(mysql_error());
		$res49 = mysql_fetch_array($exec49);
		$date = $res49['consultationdate'];
		$accoutname = $res49['accountfullname'];
		*/
		}
		}
		else
		{
		$query592 = "select * from ip_bedtransfer where ward='$wardnum' and bed='$bedanum'  and locationcode='$searchlocation' and patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and recordstatus NOT IN ('discharged','transfered') order by auto_number desc limit 0, 1";
		$exec592 = mysqli_query($GLOBALS["___mysqli_ston"], $query592) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res592 = mysqli_fetch_array($exec592);
		$num592 = mysqli_num_rows($exec592);
		if($num592 > 0)
		{
		$ward = $res592['ward'];
		$bed = $res592['bed'];
		$patientname = $res592['patientname'];
		$patientcode = $res592['patientcode'];
		$visitcode = $res592['visitcode'];
		$query10 = "select * from master_ipvisitentry where patientcode='$patientcode'  and locationcode='$searchlocation' and discharge not in ('discharged','completed')";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res10 = mysqli_fetch_array($exec10);
		$res10age = $res10['age'];
		$res10gender = $res10['gender'];
		$paymenttype = trim($res10['paymenttype']);
		
		
		$query492 = "select * from master_ipvisitentry where patientcode='$patientcode'  and locationcode='$searchlocation' and visitcode='$visitcode' and patientfullname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and discharge<>'discharge' order by auto_number desc limit 0, 1" ;
		$exec492 = mysqli_query($GLOBALS["___mysqli_ston"], $query492) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res492 = mysqli_fetch_array($exec492);
		$date = $res492['consultationdate'];
		$accoutname = $res492['accountfullname'];
		$subtypeid = $res492['subtype'];

		$query493 = "select * from master_subtype where auto_number = '$subtypeid'";
		$exec493 = mysqli_query($GLOBALS["___mysqli_ston"], $query493) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res493 = mysqli_fetch_array($exec493);
		$subtypename = $res493['subtype'];

		}
		}
		   
		   $query51 = "select * from master_bed where auto_number='$bed'  and locationcode='$searchlocation' ";
		   $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res51 = mysqli_fetch_array($exec51);
		   $bedname = $res51['bed'];
		
			$query7811 = "select * from master_ward where auto_number='$ward'  and locationcode='$searchlocation' 	";
			$exec7811 = mysqli_query($GLOBALS["___mysqli_ston"], $query7811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res7811 = mysqli_fetch_array($exec7811);
			$wardname1 = $res7811['ward'];
			if($num69 > 0)
		{
		
		   $query82 = "select * from master_ipvisitentry where patientcode='$patientcode'  and locationcode='$searchlocation' and visitcode='$visitcode' and discharge not in ('discharged','completed')";
		   $exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $num82 = mysqli_num_rows($exec82);
		   if($num82 > 0)
		   {
		   	$respkg = mysqli_fetch_array($exec82);
		   	$packageid = trim($respkg['package']);
		   	$pkg_label = "";
	
			if($packageid > 0)
			{
				$pkg_label = "PKG";
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
			
                            <tr class="table-row patient-row <?php echo ($showcolor == 0) ? 'table-row-even' : 'table-row-odd'; ?>" 
                                data-patient-code="<?php echo $patientcode; ?>" 
                                data-visit-code="<?php echo $visitcode; ?>">
                                <td><?php echo $sno = $sno + 1;?></td>
                                <td>
                                    <?php if($pkg_label): ?>
                                        <span class="package-label"><?php echo $pkg_label; ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="patient-name"><?php echo htmlspecialchars($patientname); ?></div>
                                </td>
                                <td><?php echo $res10age; ?></td>
                                <td><?php echo $res10gender; ?></td>
                                <td>
                                    <div class="patient-code"><?php echo $patientcode; ?></div>
                                </td>
                                <td><?php echo $date; ?></td>
                                <td><?php echo $visitcode; ?></td>
                                <td><?php echo $wardname1; ?></td>
                                <td><?php echo $bedname; ?></td>
                                <td><?php echo htmlspecialchars($subtypename); ?></td>
                                <td>
                                    <select name="order" id="order" class="action-dropdown" onChange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                        <option>Select Action</option>
                                        <option value="ipmedicinedirectissue.php?patientcode=<?php echo $patientcode; ?>&visitcode=<?php echo $visitcode;?>&searchlocation=<?php echo $searchlocation;?>&menuid=<?php echo $menu_id; ?>">Medicine Issue</option>
                                        <!--<option value="medicinereturnrequest.php?patientcode=<?php echo $patientcode; ?>&visitcode=<?php echo $visitcode;?>&searchlocation=<?php echo $searchlocation;?>">Medicine Return</option>-->
                                        <!--<option value="iptests.php?patientcode=<?php echo $patientcode; ?>&visitcode=<?php echo $visitcode; ?>&searchlocation=<?php echo $searchlocation;?>">Tests and Procedures</option>
                                        <?php /*?><option value="ipotbilling.php?patientcode=<?php echo $patientcode; ?>&visitcode=<?php echo $visitcode; ?>&searchlocation=<?php echo $searchlocation;?>">OT Billing</option><?php */?>
                                        <option value="ipotrequest.php?patientcode=<?php echo $patientcode; ?>&visitcode=<?php echo $visitcode; ?>&locationcode=<?php echo $patientlocationcode;?>">OT Request</option>
                                        <option value="ipprivatedoctor.php?patientcode=<?php echo $patientcode; ?>&visitcode=<?php echo $visitcode; ?>&searchlocation=<?php echo $searchlocation;?>">Private Doctor</option>-->
                                    </select>
                                </td>
                            </tr>
		   <?php 
		   }
		}
		}
		}
		   ?>
                    </tbody>
                </table>
            <?php
            }
            ?>
        </div>
    </div>
    
    <!-- Modern JavaScript -->
    <script src="js/activeinpatientlist1-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>

