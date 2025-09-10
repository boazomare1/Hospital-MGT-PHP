<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

//echo $menu_id;
include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

 $username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$docno = $_SESSION['docno'];

$updatetime = date('H:i:s');

$updatedate = date('Y-m-d H:i:s');

$colorloopcount = "";

$query1 = "select locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1location = $res1["locationcode"];	


 $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';

 

 $query233 = "select * from master_location where locationcode='$locationcode'";

$exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res233 = mysqli_fetch_array($exec233);

$location = $res233['locationname'];



 $query23 = "select * from master_employee where username='$username'";

$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res23 = mysqli_fetch_array($exec23);

 $res7locationanum = $res23['location'];

 



$res7storeanum = $res23['store'];



$query75 = "select * from master_store where auto_number='$res7storeanum'";

$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res75 = mysqli_fetch_array($exec75);

 $store = $res75['store'];





if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if ($cbfrmflag1 == 'cbfrmflag1')

{

$billnumber=$_REQUEST['docnumber'];

$serial = $_REQUEST['serialnumber'];

 $storecode=$_REQUEST['store'];
 
 $query75 = "select store from master_store where storecode='$storecode'";

$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res75 = mysqli_fetch_array($exec75);

 $store = $res75['store'];
if($storecode!='')
{
$query751 = "select * from openingstock_dataentry where store='$storecode' and locationcode='$locationcode' and recordstatus=''";

$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$num751 = mysqli_num_rows($exec751);
 if($num751<=0)
 {
$stockquery2="insert into openingstock_dataentry (docno,store,location, locationcode, username,ipaddress,storename)

values ('$billnumber','$storecode','$location','$locationcode', '$username', '$ipaddress','$store')";

$stockexecquery2=mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
 }
}
header("location:openingstockentry_master.php");

}



?>

<?php

$query3 = "select * from master_company where companystatus = 'Active'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$res3 = mysqli_fetch_array($exec3);

$paynowbillprefix = 'OPS-';

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from openingstock_dataentry order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["docno"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

	$billnumbercode ='OPE-'.'1';

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

	

	

	$billnumbercode = 'OPE-'.$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}

?>
<script src="js/jquery-1.11.1.min.js"></script>
<script>



//ajax function to get store for corrosponding location

function storefunction(loc)

{

	var username=document.getElementById("username").value;

	

var xmlhttp;



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

    document.getElementById("store").innerHTML=xmlhttp.responseText;

    }

  }

xmlhttp.open("GET","ajax/ajaxstore.php?loc="+loc+"&username="+username,true);

xmlhttp.send();



	}



function funcOnLoadBodyFunctionCall()

{





	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php

	

	 //To handle ajax dropdown list.

	funcCustomerDropDownSearch4();

	funcPopupPrintFunctionCall();

	

}

function btnDeleteClick10(delID)

{

	//alert ("Inside btnDeleteClick.");

	

	//alert(pharmamount);

	var varDeleteID = delID;

	//alert (varDeleteID);

	var fRet3; 

	fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 

	//alert(fRet); 

	if (fRet3 == false)

	{

		//alert ("Item Entry Not Deleted.");

		return false;

	}



	var child = document.getElementById('idTR'+varDeleteID);  //tr name

    var parent = document.getElementById('insertrow'); // tbody name.

	document.getElementById ('insertrow').removeChild(child);

	

	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name

    var parent = document.getElementById('insertrow'); // tbody name.

	//alert (child);

	if (child != null) 

	{

		//alert ("Row Exsits.");

		document.getElementById ('insertrow').removeChild(child);

		

		

	}

	



}



function validcheck()

{

document.getElementById("savebutton").value == true;

if(document.getElementById("codevalue").value == 0)

{

alert("Please Add an Item");

document.getElementById("savebutton").value == false;

return false;

}

	if(confirm("Are You Want To Save The Record?")==false){document.getElementById("savebutton").value == false;return false;}

}

function storechk(store){

 if(store!=''){
    var loc =document.getElementById("location").value;

	$.ajax({
	type : "get",
	url : "store_stocktaking_chk.php?storecode="+store+"&locationcode="+loc,
	catch : false,
	success : function(data){
		if(data==1){
			alert("Stock Take in process. Transactions are Frozen.");	
			$("#store").val("");
		}
	}
	});
 }

}

</script>

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



<?php include("autocompletebuild_stockmedicine.php"); ?>

<script type="text/javascript" src="js/autosuggeststockmedicine1.js"></script>

<?php include("js/dropdownlist1scriptingstockmedicine.php"); ?>

<script type="text/javascript" src="js/autocomplete_stockmedicine.js"></script>

<script type="text/javascript" src="js/insertnewitem41.js"></script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
<link rel="stylesheet" href="css/openingstock-modern.css">

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



<script src="js/datetimepicker_css.js"></script>



<body onLoad="return funcOnLoadBodyFunctionCall();">
    <!-- Modern MedStar Hospital Management Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Opening Stock Entry Management System</p>
    </header>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Dashboard</a>
        <span>›</span>
        <a href="#">Inventory</a>
        <span>›</span>
        <span>Opening Stock Entry</span>
    </nav>

    <!-- Floating Menu Toggle Button -->
    <div class="floating-menu-toggle" id="floatingMenuToggle" title="Toggle Sidebar Menu">
        <span class="toggle-icon">☰</span>
    </div>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar">
        <!-- Left Sidebar -->
        <aside class="left-sidebar" id="leftSidebar">
            <div class="sidebar-header">
                <h3>📦 Inventory Management</h3>
                <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
                    <span class="toggle-icon">☰</span>
                </button>
            </div>
            <nav class="sidebar-nav">
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="mainmenu1.php" class="nav-link">
                            <span class="nav-icon">🏠</span>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="openingstockentry_master.php" class="nav-link active">
                            <span class="nav-icon">📦</span>
                            <span class="nav-text">Opening Stock Entry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="nav-icon">📋</span>
                            <span class="nav-text">Stock Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="nav-icon">🔄</span>
                            <span class="nav-text">Stock Transactions</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="nav-icon">📊</span>
                            <span class="nav-text">Stock Reports</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <div class="main-content-area">
            <!-- Page Header -->
            <div class="page-header">
                <h2 class="page-title">
                    <span class="section-icon">📦</span>
                    Opening Stock Entry Master
                </h2>
                <p class="page-subtitle">Initialize and manage opening stock entries for different locations and stores.</p>
            </div>

            <!-- Opening Stock Entry Form -->
            <div class="form-section">
                <div class="section-header">
                    <span class="section-icon">➕</span>
                    <h3 class="section-title">Opening Stock Initiation</h3>
                </div>

                <form name="cbform1" method="post" action="openingstockentry_master.php" onSubmit="return validcheck()">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="location" class="form-label">Location *</label>
                            <select name="location" id="location" class="form-select" onChange="storefunction(this.value);" required>
                                <option value="">-Select Location-</option>
                                <?php
                                $query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
                                $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($res = mysqli_fetch_array($exec)) {
                                    $reslocation = $res["locationname"];
                                    $reslocationanum = $res["locationcode"];
                                ?>
                                    <option value="<?php echo $reslocationanum; ?>" <?php if($location!='')if($location==$reslocationanum){echo "selected";}?>><?php echo $reslocation; ?></option>
                                <?php } ?>
                            </select>
                            <input type="hidden" name="locationnamenew" value="<?php echo $locationname; ?>">
                            <input type="hidden" name="locationcodenew" value="<?php echo $res1locationanum; ?>">
                            <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
                        </div>

                        <div class="form-group">
                            <label for="store" class="form-label">Store *</label>
                            <select name="store" id="store" class="form-select" onChange="storechk(this.value);" required>
                                <option value="">-Select Store-</option>
                            </select>
                        </div>

                        <div class="form-group" style="display:none">
                            <label for="docnumber" class="form-label">Document Number</label>
                            <input name="docnumber" type="hidden" id="docnumber" class="form-input" value="<?php echo $billnumbercode; ?>" autocomplete="off">
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                        <button type="submit" name="Submit" class="btn btn-primary">
                            💾 Save Opening Stock Entry
                        </button>
                        <a href="openingstockentry_master.php" class="btn btn-secondary">
                            🔄 Reset Form
                        </a>
                    </div>
                </form>
            </div>

            <!-- Existing Opening Stock Entries -->
            <div class="data-section">
                <div class="section-header">
                    <span class="section-icon">📋</span>
                    <h3 class="section-title">Existing Opening Stock Entries</h3>
                </div>

                <!-- Search and Filter Bar -->
                <div class="search-filter-bar">
                    <div class="search-section">
                        <input type="text" id="openingStockSearch" class="search-input" placeholder="Search entries..." />
                        <button class="btn btn-secondary" id="searchBtn">🔍 Search</button>
                        <button class="btn btn-outline" id="clearSearchBtn">Clear</button>
                    </div>
                    <div class="filter-section">
                        <select id="locationFilter" class="filter-select">
                            <option value="">All Locations</option>
                            <?php
                            $query_locations = "select distinct location from openingstock_dataentry where recordstatus = '' and location != '' order by location";
                            $exec_locations = mysqli_query($GLOBALS["___mysqli_ston"], $query_locations) or die ("Error in locations query".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res_locations = mysqli_fetch_array($exec_locations)) {
                                $loc_name = $res_locations["location"];
                            ?>
                                <option value="<?php echo htmlspecialchars($loc_name); ?>"><?php echo htmlspecialchars($loc_name); ?></option>
                            <?php } ?>
                        </select>
                        <select id="storeFilter" class="filter-select">
                            <option value="">All Stores</option>
                            <?php
                            $query_stores = "select distinct storename from openingstock_dataentry where recordstatus = '' and storename != '' order by storename";
                            $exec_stores = mysqli_query($GLOBALS["___mysqli_ston"], $query_stores) or die ("Error in stores query".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res_stores = mysqli_fetch_array($exec_stores)) {
                                $store_name = $res_stores["storename"];
                            ?>
                                <option value="<?php echo htmlspecialchars($store_name); ?>"><?php echo htmlspecialchars($store_name); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!-- Data Table with Pagination -->
                <div class="table-container">
                    <table class="data-table" id="openingStockTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Document No</th>
                                <th>Store</th>
                                <th>Location</th>
                                <th>Username</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="openingStockTableBody">
                            <!-- Data will be loaded here via JavaScript -->
                        </tbody>
                    </table>
                    
                    <!-- Pagination Controls -->
                    <div class="pagination-controls">
                        <div class="pagination-info">
                            <span id="paginationInfo">Showing 0 of 0 entries</span>
                        </div>
                        <div class="pagination-buttons">
                            <button id="prevPage" class="btn btn-outline" disabled>← Previous</button>
                            <div class="page-numbers" id="pageNumbers">
                                <!-- Page numbers will be generated here -->
                            </div>
                            <button id="nextPage" class="btn btn-outline" disabled>Next →</button>
                        </div>
                        <div class="items-per-page">
                            <label for="itemsPerPage">Items per page:</label>
                            <select id="itemsPerPage" class="items-select">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

          

           

              

               <tr>

              <td width="48" align="left" valign="middle"   class="bodytext3"><strong>Location</strong></td>

              <td   class="bodytext3"   width="20"><select name="location" id="location" style="border: 1px solid #001E6A;" onChange="storefunction(this.value); ">

              <option value="">-Select Location-</option>

                  <?php

						

						$query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res = mysqli_fetch_array($exec))

						{

						$reslocation = $res["locationname"];

						$reslocationanum = $res["locationcode"];

						?>

						<option value="<?php echo $reslocationanum; ?>" <?php if($location!='')if($location==$reslocationanum){echo "selected";}?>><?php echo $reslocation; ?></option>

						<?php 

						}

						?>

                  </select></td>

                   

<?php include ("includes/footer1.php"); ?>

    <!-- JavaScript for Modern Functionality -->
    <script>
        // Opening Stock Table Management
        $(document).ready(function() {
            let currentPage = 1;
            let itemsPerPage = 5;
            let allOpeningStock = [];
            let filteredItems = [];
            
            // Initialize the table
            loadOpeningStock();
            
            // Load opening stock entries from database
            function loadOpeningStock() {
                $.ajax({
                    url: 'get_opening_stock.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        allOpeningStock = data;
                        filteredItems = [...allOpeningStock];
                        renderTable();
                        updatePagination();
                    },
                    error: function() {
                        console.error('Failed to load opening stock entries');
                        // Fallback: show sample data
                        allOpeningStock = [
                            {docno: 'OS001', storename: 'Main Store', location: 'LTC-1', username: 'admin', auto_number: 1},
                            {docno: 'OS002', storename: 'Pharmacy Store', location: 'LTC-1', username: 'pharmacist', auto_number: 2},
                            {docno: 'OS003', storename: 'Lab Store', location: 'LTC-1', username: 'labtech', auto_number: 3},
                            {docno: 'OS004', storename: 'Emergency Store', location: 'LTC-1', username: 'emergency', auto_number: 4},
                            {docno: 'OS005', storename: 'Surgical Store', location: 'LTC-1', username: 'surgeon', auto_number: 5}
                        ];
                        filteredItems = [...allOpeningStock];
                        renderTable();
                        updatePagination();
                    }
                });
            }
            
            // Render table with current page data
            function renderTable() {
                const startIndex = (currentPage - 1) * itemsPerPage;
                const endIndex = startIndex + itemsPerPage;
                const pageItems = filteredItems.slice(startIndex, endIndex);
                
                let tableHTML = '';
                pageItems.forEach((item, index) => {
                    const rowNumber = startIndex + index + 1;
                    tableHTML += `
                        <tr>
                            <td>${rowNumber}</td>
                            <td>${item.docno}</td>
                            <td>${item.storename}</td>
                            <td>${item.location}</td>
                            <td>${item.username}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="openingstockentry_view.php?st=edit&&anum=${item.docno}" class="btn btn-primary btn-sm" title="View">👁️ View</a>
                                </div>
                            </td>
                        </tr>
                    `;
                });
                
                $('#openingStockTableBody').html(tableHTML);
            }
            
            // Update pagination controls
            function updatePagination() {
                const totalPages = Math.ceil(filteredItems.length / itemsPerPage);
                const startItem = (currentPage - 1) * itemsPerPage + 1;
                const endItem = Math.min(currentPage * itemsPerPage, filteredItems.length);
                
                // Update pagination info
                $('#paginationInfo').text(`Showing ${startItem}-${endItem} of ${filteredItems.length} entries`);
                
                // Update pagination buttons
                $('#prevPage').prop('disabled', currentPage === 1);
                $('#nextPage').prop('disabled', currentPage === totalPages);
                
                // Generate page numbers
                let pageNumbersHTML = '';
                for (let i = 1; i <= totalPages; i++) {
                    const activeClass = i === currentPage ? 'active' : '';
                    pageNumbersHTML += `<button class="page-number ${activeClass}" data-page="${i}">${i}</button>`;
                }
                $('#pageNumbers').html(pageNumbersHTML);
            }
            
            // Search functionality
            $('#openingStockSearch').on('input', function() {
                const searchTerm = $(this).val().toLowerCase();
                const locationFilter = $('#locationFilter').val();
                const storeFilter = $('#storeFilter').val();
                
                filterItems(searchTerm, locationFilter, storeFilter);
            });
            
            // Location filter
            $('#locationFilter').on('change', function() {
                const searchTerm = $('#openingStockSearch').val().toLowerCase();
                const locationFilter = $(this).val();
                const storeFilter = $('#storeFilter').val();
                
                filterItems(searchTerm, locationFilter, storeFilter);
            });
            
            // Store filter
            $('#storeFilter').on('change', function() {
                const searchTerm = $('#openingStockSearch').val().toLowerCase();
                const locationFilter = $('#locationFilter').val();
                const storeFilter = $(this).val();
                
                filterItems(searchTerm, locationFilter, storeFilter);
            });
            
            // Filter items based on search and filters
            function filterItems(searchTerm, locationFilter, storeFilter) {
                filteredItems = allOpeningStock.filter(item => {
                    const matchesSearch = !searchTerm || 
                        item.docno.toLowerCase().includes(searchTerm) ||
                        item.storename.toLowerCase().includes(searchTerm) ||
                        item.location.toLowerCase().includes(searchTerm) ||
                        item.username.toLowerCase().includes(searchTerm);
                    
                    const matchesLocation = !locationFilter || item.location === locationFilter;
                    const matchesStore = !storeFilter || item.storename === storeFilter;
                    
                    return matchesSearch && matchesLocation && matchesStore;
                });
                
                currentPage = 1; // Reset to first page
                renderTable();
                updatePagination();
            }
            
            // Clear search
            $('#clearSearchBtn').on('click', function() {
                $('#openingStockSearch').val('');
                $('#locationFilter').val('');
                $('#storeFilter').val('');
                filteredItems = [...allOpeningStock];
                currentPage = 1;
                renderTable();
                updatePagination();
            });
            
            // Pagination navigation
            $(document).on('click', '.page-number', function() {
                currentPage = parseInt($(this).data('page'));
                renderTable();
                updatePagination();
            });
            
            $('#prevPage').on('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    renderTable();
                    updatePagination();
                }
            });
            
            $('#nextPage').on('click', function() {
                const totalPages = Math.ceil(filteredItems.length / itemsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderTable();
                    updatePagination();
                }
            });
            
            // Items per page change
            $('#itemsPerPage').on('change', function() {
                itemsPerPage = parseInt($(this).val());
                currentPage = 1;
                renderTable();
                updatePagination();
            });
        });

        // Sidebar functionality
        $(document).ready(function() {
            function toggleSidebar() {
                const sidebar = $('#leftSidebar');
                const mainContent = $('.main-content-area');
                const floatingToggle = $('#floatingMenuToggle');
                
                if (sidebar.hasClass('collapsed')) {
                    sidebar.removeClass('collapsed');
                    mainContent.removeClass('sidebar-collapsed');
                    floatingToggle.removeClass('active');
                } else {
                    sidebar.addClass('collapsed');
                    mainContent.addClass('sidebar-collapsed');
                    floatingToggle.addClass('active');
                }
            }
            
            // Sidebar toggle from header
            $('#sidebarToggle').on('click', function() {
                toggleSidebar();
            });
            
            // Floating menu toggle
            $('#floatingMenuToggle').on('click', function() {
                toggleSidebar();
            });
            
            // Keyboard shortcut (Ctrl+M)
            $(document).on('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'm') {
                    e.preventDefault();
                    toggleSidebar();
                }
            });
        });
    </script>

</body>
</html>



