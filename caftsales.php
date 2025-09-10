<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
date_default_timezone_set('Asia/Calcutta');
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$updatedate = date('Y-m-d');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

// Initialize variables
if (isset($_POST["frmflag1"])) { 
    $frmflag1 = $_POST["frmflag1"]; 
} else { 
    $frmflag1 = ""; 
}

// Handle form submission
if ($frmflag1 == 'frmflag1') {
    // Generate order number
    $query2 = "select * from caftorder order by auto_number desc limit 0, 1";
    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res2 = mysqli_fetch_array($exec2);
    $res2kotordernumber = $res2["ordernumber"];
    
    if ($res2kotordernumber == '') {
        $kotordernumber = 'ORD00000001';
    } else {
        $res2kotordernumber = $res2["ordernumber"];
        $kotordernumber = substr($res2kotordernumber, 3, 8);
        $kotordernumber = intval($kotordernumber);
        $kotordernumber = $kotordernumber + 1;
        $maxanum = $kotordernumber;
        
        if (strlen($maxanum) == 1) {
            $maxanum1 = '0000000'.$maxanum;
        } elseif (strlen($maxanum) == 2) {
            $maxanum1 = '000000'.$maxanum;
        } elseif (strlen($maxanum) == 3) {
            $maxanum1 = '00000'.$maxanum;
        } elseif (strlen($maxanum) == 4) {
            $maxanum1 = '0000'.$maxanum;
        } elseif (strlen($maxanum) == 5) {
            $maxanum1 = '000'.$maxanum;
        } elseif (strlen($maxanum) == 6) {
            $maxanum1 = '00'.$maxanum;
        } elseif (strlen($maxanum) == 7) {
            $maxanum1 = '0'.$maxanum;
        } else {
            $maxanum1 = $maxanum;
        }
        
        $kotordernumber = 'ORD'.$maxanum1;
    }
    
    $errmsg = "CAFT sales order created successfully. Order Number: " . $kotordernumber;
    $bgcolorcode = 'success';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAFT Sales - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            <a href="mainmenu1.php" class="btn btn-outline">🏠 Main Menu</a>
            <a href="logout.php" class="btn btn-outline">🚪 Logout</a>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <span>CAFT Sales</span>
    </nav>

    <!-- Floating Menu Toggle -->
    <div id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </div>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar">
        <!-- Left Sidebar -->
        <aside id="leftSidebar" class="left-sidebar">
            <div class="sidebar-header">
                <h3>Quick Navigation</h3>
                <button id="sidebarToggle" class="sidebar-toggle">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="mainmenu1.php" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="admissionlist.php" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Admission List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="ipbeddiscountlist.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>Bed Discount</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbed.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Add Bed</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bedoccupancysummary.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Bed Occupancy</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bedoccupancy2.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Bed Occupancy 2</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bedtransferlist.php" class="nav-link">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Bed Transfer</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="otc_walkin_services.php" class="nav-link">
                            <i class="fas fa-walking"></i>
                            <span>OTC Walk-in</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billenquiry.php" class="nav-link">
                            <i class="fas fa-search"></i>
                            <span>Bill Enquiry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billestimate.php" class="nav-link">
                            <i class="fas fa-calculator"></i>
                            <span>Bill Estimate</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billtxnidedit.php" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Transaction Edit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="patientbillingstatus.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Patient Billing Status</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="billing_pending_op2.php" class="nav-link">
                            <i class="fas fa-clock"></i>
                            <span>Billing Pending OP2</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="medicalgoodsreceivednote.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Medical Goods Received</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fixedasset_detailed_report.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Fixed Asset Detailed</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fixedasset_summary_report.php" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            <span>Fixed Asset Summary</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="theatrebookinglist.php" class="nav-link">
                            <i class="fas fa-theater-masks"></i>
                            <span>Theatre Booking List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="branch_git.php" class="nav-link">
                            <i class="fas fa-truck"></i>
                            <span>Branch GIT</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="branchincome.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Branch Income</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="brstocktransferreport.php" class="nav-link">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Stock Transfer Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="branchstockrequest.php" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Stock Request</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="budgetentrycc.php" class="nav-link">
                            <i class="fas fa-calculator"></i>
                            <span>Budget Entry CC</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="budgetentrycclist.php" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>Budget Entry List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="costcenterbudgetreport.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Cost Center Budget Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="bulkbedratesupdate.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Bulk Bed Rates Update</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="viewpurchaseindent1.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>View Purchase Indent</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="caftsales.php" class="nav-link">
                            <i class="fas fa-utensils"></i>
                            <span>CAFT Sales</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>VAT Master</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php if (!empty($errmsg)): ?>
                    <div class="alert alert-<?php echo $bgcolorcode === 'success' ? 'success' : ($bgcolorcode === 'failed' ? 'error' : 'info'); ?>">
                        <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : ($bgcolorcode === 'failed' ? 'exclamation-triangle' : 'info-circle'); ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>CAFT Sales</h2>
                    <p>Manage cafeteria sales orders with comprehensive menu management and billing system.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="printOrder()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>

            <!-- CAFT Sales Form -->
            <div class="add-form-section">
                <div class="add-form-header">
                    <i class="fas fa-utensils add-form-icon"></i>
                    <h3 class="add-form-title">Cafeteria Sales Order</h3>
                </div>
                
                <form id="caftSalesForm" name="form1" method="post" action="caftsales.php" class="add-form" onsubmit="return funcFormValidation1()">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ordernumber" class="form-label">Order Number</label>
                            <input type="text" name="ordernumber" id="ordernumber" class="form-input" value="<?php echo isset($kotordernumber) ? $kotordernumber : 'AUTO'; ?>" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="orderdate" class="form-label">Order Date</label>
                            <input type="datetime-local" name="orderdate" id="orderdate" class="form-input" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="billtype" class="form-label">Bill Type</label>
                            <select name="billtype" id="billtype" class="form-input" onchange="billtypefunction(this.value)" required>
                                <option value="">Select Bill Type</option>
                                <option value="CASH">Cash</option>
                                <option value="CREDIT">Credit</option>
                                <option value="COMPLIMENTARY">Complimentary</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="customername" class="form-label">Customer Name</label>
                            <input type="text" name="customername" id="customername" class="form-input" placeholder="Enter customer name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="customerphone" class="form-label">Phone Number</label>
                            <input type="tel" name="customerphone" id="customerphone" class="form-input" placeholder="Enter phone number">
                        </div>
                        
                        <div class="form-group">
                            <label for="tablenumber" class="form-label">Table Number</label>
                            <select name="tablenumber" id="tablenumber" class="form-input">
                                <option value="">Select Table</option>
                                <?php
                                for ($i = 1; $i <= 20; $i++) {
                                    echo '<option value="Table ' . $i . '">Table ' . $i . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Menu Items Section -->
                    <div class="form-section">
                        <div class="form-section-header">
                            <h4>Menu Items</h4>
                            <button type="button" class="btn btn-outline" onclick="addMenuItem()">
                                <i class="fas fa-plus"></i> Add Item
                            </button>
                        </div>
                        
                        <div id="menuItemsContainer">
                            <!-- Menu items will be added dynamically here -->
                        </div>
                    </div>
                    
                    <!-- Payment Section -->
                    <div class="form-section">
                        <div class="form-section-header">
                            <h4>Payment Details</h4>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="subtotal" class="form-label">Subtotal</label>
                                <input type="number" name="subtotal" id="subtotal" class="form-input" value="0.00" readonly>
                            </div>
                            
                            <div class="form-group">
                                <label for="taxamount" class="form-label">Tax Amount</label>
                                <input type="number" name="taxamount" id="taxamount" class="form-input" value="0.00" readonly>
                            </div>
                            
                            <div class="form-group">
                                <label for="totalamount" class="form-label">Total Amount</label>
                                <input type="number" name="totalamount" id="totalamount" class="form-input" value="0.00" readonly>
                            </div>
                        </div>
                        
                        <!-- Cash Payment Section -->
                        <div id="cashPaymentSection" class="form-section" style="display: none;">
                            <div class="form-section-header">
                                <h4>Cash Payment</h4>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="cashamount" class="form-label">Cash Received</label>
                                    <input type="number" name="cashamount" id="cashamount" class="form-input" placeholder="0.00" min="0" step="0.01">
                                </div>
                                <div class="form-group">
                                    <label for="changeamount" class="form-label">Change</label>
                                    <input type="number" name="changeamount" id="changeamount" class="form-input" value="0.00" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Order
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                    
                    <input type="hidden" name="frmflag1" value="frmflag1">
                </form>
            </div>

            <!-- Summary Section -->
            <div class="data-section">
                <div class="data-section-header">
                    <h3>Order Summary</h3>
                    <p>Current order details and pricing breakdown.</p>
                </div>
                
                <div class="summary-cards">
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <div class="summary-content">
                            <h4>Menu Items</h4>
                            <p id="itemCount">0</p>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <div class="summary-content">
                            <h4>Subtotal</h4>
                            <p id="subtotalDisplay">₹ 0.00</p>
                        </div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div class="summary-content">
                            <h4>Total</h4>
                            <p id="totalDisplay">₹ 0.00</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="js/vat-modern.js?v=<?php echo time(); ?>"></script>
    <script>
        // Additional JavaScript for CAFT sales
        let menuItemCounter = 1;
        
        function refreshPage() {
            window.location.reload();
        }
        
        function printOrder() {
            window.print();
        }
        
        function billtypefunction(val) {
            const cashSection = document.getElementById('cashPaymentSection');
            
            if (val === 'CASH') {
                cashSection.style.display = 'block';
            } else {
                cashSection.style.display = 'none';
                document.getElementById('cashamount').value = '';
                document.getElementById('changeamount').value = '0.00';
            }
        }
        
        function addMenuItem() {
            const container = document.getElementById('menuItemsContainer');
            const itemDiv = document.createElement('div');
            itemDiv.className = 'menu-item-row';
            itemDiv.innerHTML = `
                <div class="menu-item-header">
                    <h5>Item ${menuItemCounter}</h5>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeMenuItem(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Item Name</label>
                        <select name="itemname${menuItemCounter}" class="form-input" onchange="updateItemPrice(this)">
                            <option value="">Select Item</option>
                            <option value="Tea" data-price="15">Tea - ₹15</option>
                            <option value="Coffee" data-price="20">Coffee - ₹20</option>
                            <option value="Sandwich" data-price="50">Sandwich - ₹50</option>
                            <option value="Burger" data-price="80">Burger - ₹80</option>
                            <option value="Pizza" data-price="120">Pizza - ₹120</option>
                            <option value="Rice Plate" data-price="60">Rice Plate - ₹60</option>
                            <option value="Noodles" data-price="70">Noodles - ₹70</option>
                            <option value="Soft Drink" data-price="25">Soft Drink - ₹25</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity${menuItemCounter}" class="form-input" value="1" min="1" onchange="calculateItemTotal(this)">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Unit Price</label>
                        <input type="number" name="unitprice${menuItemCounter}" class="form-input" value="0" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Total</label>
                        <input type="number" name="itemtotal${menuItemCounter}" class="form-input" value="0" readonly>
                    </div>
                </div>
            `;
            
            container.appendChild(itemDiv);
            menuItemCounter++;
        }
        
        function removeMenuItem(button) {
            const itemRow = button.closest('.menu-item-row');
            itemRow.remove();
            calculateOrderTotal();
        }
        
        function updateItemPrice(select) {
            const price = select.options[select.selectedIndex].getAttribute('data-price');
            const row = select.closest('.menu-item-row');
            const unitPriceInput = row.querySelector('input[name^="unitprice"]');
            const quantityInput = row.querySelector('input[name^="quantity"]');
            
            if (price) {
                unitPriceInput.value = price;
                calculateItemTotal(quantityInput);
            } else {
                unitPriceInput.value = '0';
                row.querySelector('input[name^="itemtotal"]').value = '0';
            }
            
            calculateOrderTotal();
        }
        
        function calculateItemTotal(input) {
            const row = input.closest('.menu-item-row');
            const quantity = parseFloat(input.value) || 0;
            const unitPrice = parseFloat(row.querySelector('input[name^="unitprice"]').value) || 0;
            const total = quantity * unitPrice;
            
            row.querySelector('input[name^="itemtotal"]').value = total.toFixed(2);
            calculateOrderTotal();
        }
        
        function calculateOrderTotal() {
            let subtotal = 0;
            const itemTotals = document.querySelectorAll('input[name^="itemtotal"]');
            
            itemTotals.forEach(input => {
                subtotal += parseFloat(input.value) || 0;
            });
            
            const taxRate = 0.18; // 18% tax
            const taxAmount = subtotal * taxRate;
            const totalAmount = subtotal + taxAmount;
            
            document.getElementById('subtotal').value = subtotal.toFixed(2);
            document.getElementById('taxamount').value = taxAmount.toFixed(2);
            document.getElementById('totalamount').value = totalAmount.toFixed(2);
            
            // Update display
            document.getElementById('itemCount').textContent = itemTotals.length;
            document.getElementById('subtotalDisplay').textContent = '₹ ' + subtotal.toFixed(2);
            document.getElementById('totalDisplay').textContent = '₹ ' + totalAmount.toFixed(2);
        }
        
        function funcFormValidation1() {
            const billType = document.getElementById('billtype').value;
            const customerName = document.getElementById('customername').value;
            const totalAmount = parseFloat(document.getElementById('totalamount').value) || 0;
            
            if (!billType) {
                alert('Please select a bill type.');
                document.getElementById('billtype').focus();
                return false;
            }
            
            if (!customerName) {
                alert('Please enter customer name.');
                document.getElementById('customername').focus();
                return false;
            }
            
            if (totalAmount <= 0) {
                alert('Please add at least one menu item.');
                return false;
            }
            
            if (billType === 'CASH') {
                const cashAmount = parseFloat(document.getElementById('cashamount').value) || 0;
                if (cashAmount < totalAmount) {
                    alert('Cash amount must be greater than or equal to total amount.');
                    document.getElementById('cashamount').focus();
                    return false;
                }
                
                const change = cashAmount - totalAmount;
                document.getElementById('changeamount').value = change.toFixed(2);
            }
            
            return true;
        }
        
        // Auto-calculate change for cash payments
        document.getElementById('cashamount').addEventListener('input', function() {
            const cashAmount = parseFloat(this.value) || 0;
            const totalAmount = parseFloat(document.getElementById('totalamount').value) || 0;
            const change = Math.max(0, cashAmount - totalAmount);
            document.getElementById('changeamount').value = change.toFixed(2);
        });
        
        // Initialize with one menu item
        document.addEventListener('DOMContentLoaded', function() {
            addMenuItem();
        });
    </script>
</body>
</html>
