<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$errmsg = "";

$bgcolorcode = "";

$colorloopcount = "";



if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')

{



	$ward = $_REQUEST["ward"];
	$deposit = $_REQUEST["deposit"];

	$ward = strtoupper($ward);

	$ward = trim($ward);

	$selectedlocationcode=$_REQUEST["location"];

	$length=strlen($ward);

	//echo $length;

	 $query31 = "select * from master_location where locationcode = '$selectedlocationcode' and status = '' " ;

	$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res31 =(mysqli_fetch_array($exec31));

	$selectedlocation = $res31["locationname"];

	

	if ($length<=100)

	{

	$query2 = "select * from master_ward where ward = '$ward'";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res2 = mysqli_num_rows($exec2);

	if ($res2 == 0)

	{

		$query1 = "INSERT into master_ward (ward, ipaddress, recorddate,locationname,locationcode, username, deposit_amount) 

		values ('$ward', '$ipaddress', '$updatedatetime','$selectedlocation','$selectedlocationcode','$username', '$deposit')";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$errmsg = "Success. New ward Updated.";

		$bgcolorcode = 'success';		

	}

	//exit();

	else

	{

		$errmsg = "Failed. ward Already Exists.";

		$bgcolorcode = 'failed';

	}

	}

	else

	{

		$errmsg = "Failed. Only 100 Characters Are Allowed.";

		$bgcolorcode = 'failed';

	}



}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'del')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "update master_ward set recordstatus = 'deleted' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'activate')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "update master_ward set recordstatus = '' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'default')

{

	$delanum = $_REQUEST["anum"];

	$query4 = "update master_ward set defaultstatus = '' where cstid='$custid' and cstname='$custname'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));



	$query5 = "update master_ward set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";

	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'removedefault')

{

	$delanum = $_REQUEST["anum"];

	$query6 = "update master_ward set defaultstatus = '' where auto_number = '$delanum'";

	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

}





if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }

if ($svccount == 'firstentry')

{

	$errmsg = "Please Add ward To Proceed For Billing.";

	$bgcolorcode = 'failed';

}





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

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

</style>

<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

-->

</style>

    <link rel="stylesheet" href="css/addward-modern.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

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

	

function addward1process1()

{

    if (document.form1.location.value == "")

	{

		alert ("Location Cannot Be Empty.");

		document.form1.location.focus();

		return false;

	}

	//alert ("Inside Funtion");

	if (document.form1.ward.value == "")

	{

		alert ("Pleae Enter ward Name.");

		document.form1.ward.focus();

		return false;

	}

}



function funcDeleteward1(varwardAutoNumber)

{



     var varwardAutoNumber = varwardAutoNumber;

	 var fRet;

	fRet = confirm('Are you sure want to delete this ward '+varwardAutoNumber+'?');

	//alert(fRet);

	if (fRet == true)

	{

		alert ("ward  Entry Delete Completed.");

		//return false;

	}

	if (fRet == false)

	{

		alert ("ward Entry Delete Not Completed.");

		return false;

	}



}


function noDecimal(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57)  )
	return false;
	else 
	return true;
}

</script>

<body>
    <!-- Modern MedStar Hospital Management Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Ward Management System</p>
    </header>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Dashboard</a>
        <span>›</span>
        <a href="#">Hospital Management</a>
        <span>›</span>
        <span>Ward Management</span>
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
                <h3>🏥 Hospital Management</h3>
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
                        <a href="addward.php" class="nav-link active">
                            <span class="nav-icon">🏥</span>
                            <span class="nav-text">Ward Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="nav-icon">🛏️</span>
                            <span class="nav-text">Bed Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="nav-icon">👥</span>
                            <span class="nav-text">Patient Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="nav-icon">📊</span>
                            <span class="nav-text">Hospital Reports</span>
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
                    <span class="section-icon">🏥</span>
                    Ward Management
                </h2>
                <p class="page-subtitle">Add new wards, manage locations, and configure deposit amounts for patient admissions.</p>
            </div>

            <!-- Form and Data Sections -->
                <!-- Modern Form Section -->
                <div class="form-section">
                  <div class="section-header">
                    <span class="section-icon">🏥</span>
                    <h3 class="section-title">Ward Master - Add New</h3>
                  </div>

                  <form name="form1" id="form1" method="post" action="addward.php" onSubmit="return addward1process1()">
                    <!-- Alert Message -->
                    <?php if ($errmsg): ?>
                      <div class="alert-message <?php echo $bgcolorcode === 'success' ? 'success' : ($bgcolorcode === 'failed' ? 'error' : 'info'); ?>">
                        <?php echo $errmsg; ?>
                      </div>
                    <?php endif; ?>

                    <div class="form-grid">
                      <div class="form-group">
                        <label for="location" class="form-label">Location <span class="required">*</span></label>
                        <select name="location" id="location" class="form-select" onChange="return ajaxlocationfunction(this.value);">
                          <option value="">Select Location</option>
                          <?php
                          $query1 = "select * from master_location where status <> 'deleted' order by locationname";
                          $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
                          while ($res1 = mysqli_fetch_array($exec1))
                          {
                            $res1location = $res1["locationname"];
                            $res1locationanum = $res1["locationcode"];
                            ?>
                            <option value="<?php echo $res1locationanum; ?>"><?php echo $res1location; ?></option>
                            <?php
                          }
                          ?>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="ward" class="form-label">Ward Name <span class="required">*</span></label>
                        <input name="ward" id="ward" type="text" class="form-input" placeholder="Enter ward name" style="text-transform: uppercase;" />
                      </div>

                      <div class="form-group">
                        <label for="deposit" class="form-label">Deposit Amount</label>
                        <input name="deposit" id="deposit" type="number" class="form-input" placeholder="Enter deposit amount" onKeyPress="return noDecimal(event)" />
                      </div>

                      <div class="form-group form-actions">
                        <input type="hidden" name="frmflag" value="addnew" />
                        <input type="hidden" name="frmflag1" value="frmflag1" />
                        <button type="submit" name="Submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                      </div>
                    </div>
                  </form>
                </div>

                <!-- Existing Wards -->
            <div class="data-section">
                <div class="section-header">
                    <span class="section-icon">📋</span>
                    <h3 class="section-title">Existing Wards</h3>
                </div>

                <!-- Search and Filter Bar -->
                <div class="search-filter-bar">
                    <div class="search-section">
                        <input type="text" id="wardSearch" class="search-input" placeholder="Search wards..." />
                        <button class="btn btn-secondary" id="searchBtn">🔍 Search</button>
                        <button class="btn btn-outline" id="clearSearchBtn">Clear</button>
                    </div>
                    <div class="filter-section">
                        <select id="locationFilter" class="filter-select">
                            <option value="">All Locations</option>
                            <?php
                            $query_locations = "select distinct locationname from master_ward where recordstatus <> 'deleted' and locationname != '' order by locationname";
                            $exec_locations = mysqli_query($GLOBALS["___mysqli_ston"], $query_locations) or die ("Error in locations query".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($res_locations = mysqli_fetch_array($exec_locations)) {
                                $loc_name = $res_locations["locationname"];
                            ?>
                                <option value="<?php echo htmlspecialchars($loc_name); ?>"><?php echo htmlspecialchars($loc_name); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!-- Data Table with Pagination -->
                <div class="table-container">
                    <table class="data-table" id="wardsTable">
                        <thead>
                            <tr>
                                <th>Ward Name</th>
                                <th>Location</th>
                                <th>Deposit Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="wardsTableBody">
                            <!-- Data will be loaded here via JavaScript -->
                        </tbody>
                    </table>
                    
                    <!-- Pagination Controls -->
                    <div class="pagination-controls">
                        <div class="pagination-info">
                            <span id="paginationInfo">Showing 0 of 0 wards</span>
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
      </div>
    </div>

    <!-- JavaScript for sidebar, pagination, search, and filtering -->
  <script>
    // Global variables
    let currentPage = 1;
    let itemsPerPage = 5;
    let allWards = [];
    let filteredWards = [];

    // Initialize when document is ready
    $(document).ready(function() {
      loadWards();
      setupEventListeners();
      setupSidebar();
    });

    // Load wards data
    function loadWards() {
      $.ajax({
        url: 'get_wards.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
          if (data.success) {
            allWards = data.wards;
            filteredWards = [...allWards];
            renderTable();
            updatePagination();
          } else {
            console.error('Error loading wards:', data.message);
          }
        },
        error: function(xhr, status, error) {
          console.error('AJAX Error:', error);
        }
      });
    }

    // Render table with current data
    function renderTable() {
      const tbody = $('#wardsTableBody');
      tbody.empty();

      const startIndex = (currentPage - 1) * itemsPerPage;
      const endIndex = startIndex + itemsPerPage;
      const pageData = filteredWards.slice(startIndex, endIndex);

      if (pageData.length === 0) {
        tbody.html('<tr><td colspan="4" class="no-data">No wards found. Add some wards using the form above.</td></tr>');
        return;
      }

      pageData.forEach((ward, index) => {
        const deleteAction = ward.recordstatus === 'deleted' ? 'activate' : 'delete';
        const deleteIcon = ward.recordstatus === 'deleted' ? '✅' : '🗑️';
        const deleteTooltip = ward.recordstatus === 'deleted' ? 'Activate Ward' : 'Delete Ward';
        
        const row = `
          <tr class="table-row ${index % 2 === 0 ? 'even' : 'odd'}">
            <td class="ward-name">${ward.ward}</td>
            <td class="location-name">${ward.locationname}</td>
            <td class="deposit-amount">${ward.deposit_amount || '0.00'}</td>
            <td class="actions-cell">
              <div class="action-buttons">
                <a href="addward.php?st=edit&&anum=${ward.auto_number}" class="action-btn edit-btn" title="Edit Ward">
                  <span class="action-icon">✏️</span>
                </a>
                <a href="addward.php?st=${deleteAction}&&anum=${ward.auto_number}" class="action-btn delete-btn" title="${deleteTooltip}">
                  <span class="action-icon">${deleteIcon}</span>
                </a>
              </div>
            </td>
          </tr>
        `;
        tbody.append(row);
      });
    }

        // Update pagination controls
    function updatePagination() {
      const totalPages = Math.ceil(filteredWards.length / itemsPerPage);
      const pagination = $('.pagination-controls');
						
      // Update pagination info
      const startIndex = (currentPage - 1) * itemsPerPage + 1;
      const endIndex = Math.min(currentPage * itemsPerPage, filteredWards.length);
      $('#paginationInfo').text(`Showing ${startIndex}-${endIndex} of ${filteredWards.length} wards`);
      
      if (totalPages <= 1) {
        pagination.hide();
        return;
      }

      pagination.show();
						
      // Update page numbers
      const pageNumbers = $('#pageNumbers');
      pageNumbers.empty();
      
      for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
          pageNumbers.append(`
            <button class="pagination-btn ${i === currentPage ? 'active' : ''}" 
                    onclick="changePage(${i})">
              ${i}
            </button>
          `);
        } else if (i === currentPage - 2 || i === currentPage + 2) {
          pageNumbers.append('<span class="pagination-ellipsis">...</span>');
        }
      }
						
      // Update prev/next buttons
      $('#prevPage').prop('disabled', currentPage === 1);
      $('#nextPage').prop('disabled', currentPage === totalPages);
    }

    // Change page
    function changePage(page) {
      const totalPages = Math.ceil(filteredWards.length / itemsPerPage);
      if (page >= 1 && page <= totalPages) {
        currentPage = page;
        renderTable();
        updatePagination();
      }
    }

    // Filter wards based on search and filters
    function filterWards() {
      const searchTerm = $('#wardSearch').val().toLowerCase();
      const locationFilter = $('#locationFilter').val();

      filteredWards = allWards.filter(ward => {
        const matchesSearch = ward.ward.toLowerCase().includes(searchTerm) ||
                            ward.locationname.toLowerCase().includes(searchTerm);
        const matchesLocation = locationFilter === '' || ward.locationname === locationFilter;
        
        return matchesSearch && matchesLocation;
      });

      currentPage = 1;
      renderTable();
      updatePagination();
    }

          // Setup event listeners
      function setupEventListeners() {
        // Search input
        $('#wardSearch').on('input', function() {
          filterWards();
        });

        // Location filter
        $('#locationFilter').on('change', function() {
          filterWards();
        });

        // Items per page
        $('#itemsPerPage').on('change', function() {
          itemsPerPage = parseInt($(this).val());
          currentPage = 1;
          renderTable();
          updatePagination();
        });

        // Previous/Next buttons
        $('#prevPage').on('click', function() {
          if (currentPage > 1) {
            changePage(currentPage - 1);
          }
        });

        $('#nextPage').on('click', function() {
          const totalPages = Math.ceil(filteredWards.length / itemsPerPage);
          if (currentPage < totalPages) {
            changePage(currentPage + 1);
          }
        });
      }

    // Setup sidebar functionality
    function setupSidebar() {
      // Toggle sidebar
      $('.menu-toggle').on('click', function() {
        $('.left-sidebar').toggleClass('collapsed');
        $('.main-content-area').toggleClass('sidebar-collapsed');
      });

      // Keyboard shortcut (Ctrl+M)
      $(document).on('keydown', function(e) {
        if (e.ctrlKey && e.key === 'm') {
          e.preventDefault();
          $('.menu-toggle').click();
        }
      });

      // Close sidebar when clicking outside
      $(document).on('click', function(e) {
        if (!$(e.target).closest('.left-sidebar, .menu-toggle').length) {
          $('.left-sidebar').removeClass('collapsed');
          $('.main-content-area').removeClass('sidebar-collapsed');
        }
      });
    }
  </script>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



