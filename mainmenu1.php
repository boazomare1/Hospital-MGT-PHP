<?php
session_start();
include ("db/db_connect.php");
include ("includes/loginverify.php");

$docno = $_SESSION['docno'];
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$registrationdate = date('Y-m-d');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];

$emp_locationcode1 = '';
$query2211 = "select locationcode from master_employeelocation where username = '$username' group by locationcode";
$exec2211 = mysqli_query($GLOBALS["___mysqli_ston"], $query2211) or die ("Error in Query2211".mysqli_error($GLOBALS["___mysqli_ston"]));

while($res2211 = mysqli_fetch_array($exec2211)) {
    $emp_locationcode = $res2211["locationcode"];
    if($emp_locationcode1 == '') {
        $emp_locationcode1 = "'".$emp_locationcode."'";
    } else {
        $emp_locationcode = "'".$emp_locationcode."'";
        $emp_locationcode1 = $emp_locationcode1.','.$emp_locationcode;
    }
}

// Get user information
$query341 = "select * from master_employee where username = '$username'";
$exec341 = mysqli_query($GLOBALS["___mysqli_ston"], $query341) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));
$res341 = mysqli_fetch_array($exec341);
$statistics = $res341['statistics'];
$exp_drug = $res341['exp_drug'];
$tat_details = $res341['tat_details'];

// Get location details
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$reslocationanum = $res["locationcode"];

// Get store code
$query2 = "SELECT b.storecode from master_employeelocation as a join master_store as b on a.storecode=b.auto_number where a.username='$username' and a.locationcode='$reslocationanum' and a.defaultstore='default'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$store_code = "";
$res2 = mysqli_fetch_array($exec2);
$storecode_main = $res2['storecode'];

// Get reorder level alerts
$reorderquery11 = "select reo.itemcode,reo.rol,crsk.cum_quantity from master_itemtosupplier as reo, transaction_stock as crsk where reo.recordstatus <> 'Deleted' and reo.locationcode = '$reslocationanum' and reo.rol <> '0' and crsk.itemcode=reo.itemcode and crsk.cum_quantity<=reo.rol and crsk.cum_stockstatus='1' group by reo.itemcode order by reo.itemname limit 10";
$reorderexec11 = mysqli_query($GLOBALS["___mysqli_ston"], $reorderquery11) or die ("Error in reorderQuery11".mysqli_error($GLOBALS["___mysqli_ston"]));
$reordernum11 = mysqli_num_rows($reorderexec11);

// Get expiry alerts
$ADate1 = date('Y-m-d');
$ADate2 = date('Y-m-d', strtotime('+3 month'));
$query99 = "select ts.itemcode as itemcode,pd.expirydate as expirydate,pd.suppliername as suppliername,ts.batchnumber as batchnumber,ts.itemname as itemname,ts.batch_quantity as batch_quantity,pd.categoryname as categoryname from transaction_stock as ts LEFT JOIN purchase_details as pd ON ts.fifo_code = pd.fifo_code where ts.batch_stockstatus = 1 and ts.locationcode = '$reslocationanum' and pd.expirydate BETWEEN '".$ADate1."' and '".$ADate2."' and ts.storecode='$storecode_main' group by ts.batchnumber";
$exec99 = mysqli_query($GLOBALS["___mysqli_ston"], $query99) or die ("Error in Query99".mysqli_error($GLOBALS["___mysqli_ston"]));
$row99 = mysqli_num_rows($exec99);

// Get TAT details
$query998 = "select patientcode,visitcode,patientfullname,consultationdate,accountfullname,username from master_visitentry where billtype='PAY LATER' and overallpayment='' and visitcode not in (select visitcode from billing_paylater) and consultationdate='$registrationdate' and locationcode IN ($emp_locationcode1) order by accountfullname desc";
$exec998 = mysqli_query($GLOBALS["___mysqli_ston"], $query998) or die ("Error in Query998".mysqli_error($GLOBALS["___mysqli_ston"]));
$row998 = mysqli_num_rows($exec998);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedStar Hospital Management - Main Menu</title>
    <meta name="description" content="MedStar Hospital Management - Access your healthcare modules and tools">
    <meta name="keywords" content="medstar, hospital, management, system, healthcare, modules">
    <meta name="author" content="MedStar Hospital System">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="logofiles/ico.jpg">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="css/mainmenu-modern.css">
    
    <!-- jQuery for functionality -->
    <script src="js/jquery-1.11.3.min.js"></script>
    
    <!-- Accessibility and SEO -->
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#2c5aa0">
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
            Welcome, <strong><?php echo htmlspecialchars($username); ?></strong>
        </div>
        <div class="user-details">
            <div class="user-detail-item">
                <strong>Company:</strong> <?php echo htmlspecialchars($companyname); ?>
            </div>
            <div class="user-detail-item">
                <strong>Financial Year:</strong> <?php echo htmlspecialchars($financialyear); ?>
            </div>
            <div class="user-detail-item">
                <strong>Location:</strong> <?php echo htmlspecialchars($reslocationanum); ?>
            </div>
        </div>
        <div class="user-actions">
            <a href="logout.php" class="logout-btn" title="Logout and return to login">
                <span class="logout-icon">🚪</span>
                <span class="logout-text">Logout</span>
            </a>
        </div>
    </div>

    <!-- Search Section -->
    <section class="search-section">
        <div class="search-container">
            <label for="submenu_search" class="search-label">🔍 Search Module:</label>
            <input type="text" 
                   id="submenu_search" 
                   name="submenu_search" 
                   class="search-input" 
                   placeholder="Type module name to search..." 
                   autocomplete="off"
                   aria-label="Search for hospital management modules">
            <button type="button" id="testSearch" class="test-search-btn">Test Search</button>
        </div>
    </section>

    <!-- Floating Menu Toggle Button -->
    <div class="floating-menu-toggle" id="floatingMenuToggle" title="Toggle Sidebar Menu">
        <span class="toggle-icon">☰</span>
    </div>

    <!-- Main Content Area with Side Menu -->
    <div class="main-content-wrapper" id="mainContentWrapper">
        <!-- Side Menu -->
        <aside class="side-menu" id="sideMenu">
            <div class="side-menu-header">
                <h3>📋 Module Categories</h3>
                <button class="menu-toggle" id="menuToggle" aria-label="Toggle side menu">
                    <span class="toggle-icon">☰</span>
                </button>
            </div>
            
            <nav class="side-menu-nav">
                <?php
                // Get all main menu categories - using master_menusub directly since master_menu doesn't exist
                $query_main = "SELECT DISTINCT mainmenuid FROM master_menusub WHERE status <> 'deleted' ORDER BY mainmenuid";
                $exec_main = mysqli_query($GLOBALS["___mysqli_ston"], $query_main) or die ("Error in main menu query".mysqli_error($GLOBALS["___mysqli_ston"]));
                
                while ($res_main = mysqli_fetch_array($exec_main)) {
                    $mainmenuid = $res_main["mainmenuid"];
                    
                    // Get submenus for this main menu
                    $query_sub = "SELECT * FROM master_menusub WHERE mainmenuid = '$mainmenuid' AND status <> 'deleted' ORDER BY submenuorder";
                    $exec_sub = mysqli_query($GLOBALS["___mysqli_ston"], $query_sub) or die ("Error in sub menu query".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $submenu_count = mysqli_num_rows($exec_sub);
                    
                    if ($submenu_count > 0) {
                        // Get a sample submenu to extract main menu text
                        $query_sample = "SELECT * FROM master_menusub WHERE mainmenuid = '$mainmenuid' AND status <> 'deleted' LIMIT 1";
                        $exec_sample = mysqli_query($GLOBALS["___mysqli_ston"], $query_sample) or die ("Error in sample query".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $res_sample = mysqli_fetch_array($exec_sample);
                        $mainmenutext = "Category " . $mainmenuid; // Fallback text
                ?>
                    <div class="menu-category">
                        <div class="category-header" data-category="<?php echo $mainmenuid; ?>">
                            <span class="category-icon">📁</span>
                            <span class="category-title"><?php echo htmlspecialchars($mainmenutext); ?></span>
                            <span class="category-count">(<?php echo $submenu_count; ?>)</span>
                            <span class="expand-icon">▼</span>
                        </div>
                        
                        <div class="submenu-list" id="submenu-<?php echo $mainmenuid; ?>">
                            <?php
                            while ($res_sub = mysqli_fetch_array($exec_sub)) {
                                $submenuid = $res_sub["submenuid"];
                                $submenutext = $res_sub["submenutext"];
                                $submenulink = $res_sub["submenulink"];
                                
                                // Check if this is a favorite
                                $is_favorite = false;
                                $query_fav = "SELECT COUNT(*) as fav_count FROM master_employeerights WHERE username = '$username' AND submenuid = '$submenuid' AND is_fav = '1'";
                                $exec_fav = mysqli_query($GLOBALS["___mysqli_ston"], $query_fav) or die ("Error in favorite query".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $res_fav = mysqli_fetch_array($exec_fav);
                                if ($res_fav["fav_count"] > 0) {
                                    $is_favorite = true;
                                }
                            ?>
                                <a href="<?php echo htmlspecialchars($submenulink); ?>" class="submenu-item <?php echo $is_favorite ? 'favorite' : ''; ?>">
                                    <span class="submenu-icon">🔗</span>
                                    <span class="submenu-text"><?php echo htmlspecialchars($submenutext); ?></span>
                                    <?php if ($is_favorite): ?>
                                        <span class="favorite-star" title="Favorite module">⭐</span>
                                    <?php endif; ?>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                <?php
                    }
                }
                ?>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Quick Access Section -->
            <section class="quick-access-section">
                <h2>⭐ Quick Access - Favorite Modules</h2>
                <div class="favorites-grid">
                    <?php 
                    // Get favorite modules
                    $query10 = "select * from master_employeerights where username = '$username' and is_fav = '1'";
                    $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
                    
                    while ($res10sm = mysqli_fetch_array($exec10)) {
                        $submenuid = $res10sm["submenuid"];
                        
                        $query2sm = "select * from master_menusub where submenuid = '$submenuid' and status <> 'deleted' order by submenutext";
                        $exec2sm = mysqli_query($GLOBALS["___mysqli_ston"], $query2sm) or die ("Error in Query2sm".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $res2sm = mysqli_fetch_array($exec2sm);
                        
                        $submenuorder = $res2sm["submenuorder"];
                        $submenutext = $res2sm["submenutext"];
                        $submenulink = $res2sm["submenulink"];
                    ?>
                        <a href="<?php echo htmlspecialchars($submenulink); ?>" class="favorite-card fade-in" 
                           data-category="<?php echo htmlspecialchars($res2sm['mainmenuid']); ?>"
                           aria-label="Access <?php echo htmlspecialchars($submenutext); ?> module">
                            <div class="favorite-icon">⭐</div>
                            <div class="favorite-text"><?php echo htmlspecialchars($submenutext); ?></div>
                        </a>
                    <?php } ?>
                </div>
            </section>

            <!-- All Modules Grid -->
            <section class="all-modules-section">
                <h2>🔧 All Available Modules</h2>
                <div class="modules-grid">
                    <?php
                    // Get all available modules
                    $query_all = "SELECT * FROM master_menusub WHERE status <> 'deleted' ORDER BY submenutext";
                    $exec_all = mysqli_query($GLOBALS["___mysqli_ston"], $query_all) or die ("Error in all modules query".mysqli_error($GLOBALS["___mysqli_ston"]));
                    
                    while ($res_all = mysqli_fetch_array($exec_all)) {
                        $submenuid = $res_all["submenuid"];
                        $submenutext = $res_all["submenutext"];
                        $submenulink = $res_all["submenulink"];
                        
                        // Check if this is a favorite
                        $is_favorite = false;
                        $query_fav = "SELECT COUNT(*) as fav_count FROM master_employeerights WHERE username = '$username' AND submenuid = '$submenuid' AND is_fav = '1'";
                        $exec_fav = mysqli_query($GLOBALS["___mysqli_ston"], $query_fav) or die ("Error in favorite query".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $res_fav = mysqli_fetch_array($exec_fav);
                        if ($res_fav["fav_count"] > 0) {
                            $is_favorite = true;
                        }
                    ?>
                        <a href="<?php echo htmlspecialchars($submenulink); ?>" class="module-card fade-in <?php echo $is_favorite ? 'favorite' : ''; ?>" 
                           data-category="<?php echo htmlspecialchars($res_all['mainmenuid']); ?>"
                           aria-label="Access <?php echo htmlspecialchars($submenutext); ?> module">
                            <div class="module-header">
                                <div class="module-icon">🔧</div>
                                <?php if ($is_favorite): ?>
                                    <div class="favorite-indicator">⭐</div>
                                <?php endif; ?>
                            </div>
                            <div class="module-content">
                                <h3 class="module-title"><?php echo htmlspecialchars($submenutext); ?></h3>
                                <p class="module-description">Access <?php echo htmlspecialchars($submenutext); ?> functionality</p>
                            </div>
                        </a>
                    <?php } ?>
                </div>
            </section>
        </main>
    </div>

    <!-- Dashboard Widgets -->
    <section class="dashboard-widgets">
        <!-- Reorder Level Alerts -->
        <?php if($reordernum11 > 0 && $statistics == 'on') { ?>
        <div class="widget slide-in-left">
            <div class="widget-header">
                <div class="widget-icon warning-icon">⚠️</div>
                <h3 class="widget-title">Reorder Level Alerts</h3>
            </div>
            <div class="widget-content">
                <p><strong><?php echo $reordernum11; ?></strong> items have reached reorder level.</p>
                <a href="automaticpi.php" class="menu-button" style="margin-top: 1rem; display: inline-block; text-decoration: none;">
                    View Reorder Items
                </a>
            </div>
        </div>
        <?php } ?>

        <!-- Expiry Medicine Alerts -->
        <?php if($row99 > 0 && $exp_drug == 'on') { ?>
        <div class="widget slide-in-left">
            <div class="widget-header">
                <div class="widget-icon danger-icon">💊</div>
                <h3 class="widget-title">Medicine Expiry Alerts</h3>
            </div>
            <div class="widget-content">
                <p><strong><?php echo $row99; ?></strong> medicine batches expiring within 3 months.</p>
                <div style="margin-top: 1rem;">
                    <iframe src="expiry_medicine_list.php?ADate1=<?php echo $ADate1; ?>&ADate2=<?php echo $ADate2; ?>&storecode=<?php echo $storecode_main; ?>&locationcode=<?php echo $reslocationanum; ?>" 
                            frameborder="0" 
                            scrolling="auto" 
                            width="100%" 
                            height="200"
                            title="Medicine expiry list"
                            aria-label="List of medicines expiring soon">
                    </iframe>
                </div>
            </div>
        </div>
        <?php } ?>

        <!-- TAT Details -->
        <?php if($row998 > 0 && $tat_details == 'on') { ?>
        <div class="widget slide-in-left">
            <div class="widget-header">
                <div class="widget-icon hospital-icon">⏱️</div>
                <h3 class="widget-title">TAT Details</h3>
            </div>
            <div class="widget-content">
                <p><strong><?php echo $row998; ?></strong> pending TAT cases for today.</p>
                <div style="margin-top: 1rem;">
                    <iframe src="view_tat_details.php?ADate1=<?php echo $registrationdate; ?>&ADate2=<?php echo $registrationdate; ?>&storecode=<?php echo $storecode_main; ?>&locationcode=<?php echo $emp_locationcode1; ?>" 
                            frameborder="0" 
                            scrolling="auto" 
                            width="100%" 
                            height="200"
                            title="TAT details"
                            aria-label="Turnaround time details for pending cases">
                    </iframe>
                </div>
            </div>
        </div>
        <?php } ?>
    </section>

    <!-- JavaScript for Enhanced Functionality -->
    <script>
        $(document).ready(function() {
            // Autocomplete removed - using simple search instead

            // Add loading states to menu cards
            $('.menu-card').on('click', function() {
                $(this).addClass('loading');
                const button = $(this).find('.menu-button');
                const originalText = button.text();
                button.text('Loading...');
                
                // Reset after navigation (fallback)
                setTimeout(() => {
                    $(this).removeClass('loading');
                    button.text(originalText);
                }, 3000);
            });

            // Enhanced keyboard navigation
            $('.menu-card').on('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    $(this).click();
                }
            });

            // Add focus indicators for accessibility
            $('.menu-card, .search-input').on('focus', function() {
                $(this).addClass('focused');
            }).on('blur', function() {
                $(this).removeClass('focused');
            });

            // Responsive menu adjustments
            function adjustMenuLayout() {
                const windowWidth = $(window).width();
                if (windowWidth <= 768) {
                    $('.menu-grid').css('grid-template-columns', '1fr');
                } else if (windowWidth <= 1024) {
                    $('.menu-grid').css('grid-template-columns', 'repeat(auto-fit, minmax(250px, 1fr))');
                } else {
                    $('.menu-grid').css('grid-template-columns', 'repeat(auto-fit, minmax(280px, 1fr))');
                }
            }

            // Initial adjustment
            adjustMenuLayout();

            // Adjust on window resize
            $(window).on('resize', adjustMenuLayout);

            // Add smooth scrolling for better UX
            $('html').css('scroll-behavior', 'smooth');

                    // Simple search functionality (autocomplete removed due to jQuery UI not loaded)

        // Real-time search filtering for current page content
        $('#submenu_search').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            console.log('🔍 Search triggered for:', searchTerm); // Debug log
            console.log('🔍 Input value:', $(this).val()); // Debug log - show actual input value
            console.log('🔍 Input field element:', this); // Debug log - show the input element
            console.log('🔍 Input field visible:', $(this).is(':visible')); // Debug log - check if input is visible
            
            if (searchTerm.length > 0) {
                let foundCount = 0;
                
                // Search in side menu
                $('.submenu-item').each(function() {
                    const itemText = $(this).find('.submenu-text').text().toLowerCase();
                    if (itemText.includes(searchTerm)) {
                        $(this).show();
                        $(this).closest('.menu-category').show();
                        $(this).closest('.submenu-list').addClass('expanded');
                        $(this).closest('.category-header').addClass('expanded');
                        foundCount++;
                    } else {
                        $(this).hide();
                    }
                });
                
                // Search in main content - MODULE CARDS
                console.log('🔍 Searching through module cards...'); // Debug log
                $('.module-card').each(function(index) {
                    const cardText = $(this).find('.module-title').text().toLowerCase();
                    const isVisible = cardText.includes(searchTerm);
                    console.log(`Module ${index + 1}: "${cardText}" includes "${searchTerm}"? ${isVisible}`); // Debug log
                    
                    if (isVisible) {
                        $(this).show();
                        foundCount++;
                    } else {
                        $(this).hide();
                    }
                });
                
                // Search in favorites
                $('.favorite-card').each(function() {
                    const cardText = $(this).find('.favorite-text').text().toLowerCase();
                    if (cardText.includes(searchTerm)) {
                        $(this).show();
                        foundCount++;
                    } else {
                        $(this).hide();
                    }
                });
                
                console.log('✅ Total found:', foundCount); // Debug log
                
                // Show search results indicator
                showSearchResultsIndicator(searchTerm, foundCount);
            } else {
                // Show all items when search is cleared
                $('.submenu-item').show();
                $('.menu-category').show();
                $('.module-card').show();
                $('.favorite-card').show();
                hideSearchResultsIndicator();
            }
        });
        
        // Function to show search results indicator
        function showSearchResultsIndicator(searchTerm, foundCount) {
            // Remove existing indicator
            $('.search-results-indicator').remove();
            
            // Create and show new indicator
            const indicator = $(`
                <div class="search-results-indicator">
                    <span class="search-icon">🔍</span>
                    <span class="search-text">Search results for "${searchTerm}" - Found ${foundCount} items</span>
                    <button class="clear-search-btn" onclick="clearSearch()">
                        <span class="clear-icon">✕</span>
                        Clear Search
                    </button>
                </div>
            `);
            
            $('.search-section').after(indicator);
        }
        
        // Function to hide search results indicator
        function hideSearchResultsIndicator() {
            $('.search-results-indicator').remove();
        }
        
        // Function to clear search (global scope)
        window.clearSearch = function() {
            $('#submenu_search').val('');
            $('.submenu-item').show();
            $('.menu-category').show();
            $('.module-card').show();
            $('.favorite-card').show();
            hideSearchResultsIndicator();
            
            // Reset all category headers
            $('.category-header').removeClass('expanded');
            $('.submenu-list').removeClass('expanded');
            $('.expand-icon').text('▼');
        };
        
        // Test search functionality
        $('#testSearch').on('click', function() {
            const testTerm = 'Lab';
            $('#submenu_search').val(testTerm);
            $('#submenu_search').trigger('input');
            console.log('🧪 Test search triggered for:', testTerm);
            console.log('🧪 Input field value after setting:', $('#submenu_search').val());
            console.log('🧪 Input field visible:', $('#submenu_search').is(':visible'));
            console.log('🧪 Input field CSS color:', $('#submenu_search').css('color'));
            console.log('🧪 Input field CSS background:', $('#submenu_search').css('background-color'));
            
            // Also test manual filtering
            setTimeout(() => {
                console.log('🧪 Manual filtering test...');
                $('.module-card').each(function(index) {
                    const title = $(this).find('.module-title').text();
                    const isVisible = $(this).is(':visible');
                    console.log(`Card ${index + 1}: "${title}" - Visible: ${isVisible}`);
                });
            }, 100);
        });
        
        // Debug: Check if elements exist
        $(document).ready(function() {
            console.log('🔍 Debug: Checking page elements...');
            console.log('Module cards found:', $('.module-card').length);
            console.log('Module titles found:', $('.module-title').length);
            
            // Log first few module titles
            $('.module-title').each(function(index) {
                if (index < 5) {
                    console.log(`Module ${index + 1}: "${$(this).text()}"`);
                }
            });
            
            // Test if search input exists
            console.log('Search input exists:', $('#submenu_search').length > 0);
        });
        


        // Side menu functionality
        $('.category-header').on('click', function() {
            const categoryId = $(this).data('category');
            const submenuList = $(this).next('.submenu-list');
            const expandIcon = $(this).find('.expand-icon');
            
            // Toggle expanded state
            if (submenuList.hasClass('expanded')) {
                submenuList.removeClass('expanded');
                $(this).removeClass('expanded');
                expandIcon.text('▼');
            } else {
                submenuList.addClass('expanded');
                $(this).addClass('expanded');
                expandIcon.text('▲');
            }
            
            // Filter modules by category
            filterModulesByCategory(categoryId);
        });
        
        // Function to filter modules by category
        function filterModulesByCategory(categoryId) {
            // Show all modules first
            $('.module-card').show();
            $('.favorite-card').show();
            
            if (categoryId) {
                // Hide modules that don't belong to this category
                $('.module-card').each(function() {
                    const moduleCategory = $(this).data('category');
                    if (moduleCategory !== categoryId) {
                        $(this).hide();
                    }
                });
                
                // Hide favorites that don't belong to this category
                $('.favorite-card').each(function() {
                    const favoriteCategory = $(this).data('category');
                    if (favoriteCategory !== categoryId) {
                        $(this).hide();
                    }
                });
                
                // Show category filter indicator
                showCategoryFilterIndicator(categoryId);
            } else {
                // Show all modules
                $('.module-card').show();
                $('.favorite-card').show();
                hideCategoryFilterIndicator();
            }
        }
        
        // Function to show category filter indicator
        function showCategoryFilterIndicator(categoryId) {
            // Remove existing indicator
            $('.category-filter-indicator').remove();
            
            // Create and show new indicator
            const indicator = $(`
                <div class="category-filter-indicator">
                    <span class="filter-text">Showing modules from Category ${categoryId}</span>
                    <button class="clear-filter-btn" onclick="clearCategoryFilter()">
                        <span class="clear-icon">✕</span>
                        Show All
                    </button>
                </div>
            `);
            
            $('.search-section').after(indicator);
        }
        
        // Function to hide category filter indicator
        function hideCategoryFilterIndicator() {
            $('.category-filter-indicator').remove();
        }
        
        // Function to clear category filter (global scope)
        window.clearCategoryFilter = function() {
            $('.module-card').show();
            $('.favorite-card').show();
            hideCategoryFilterIndicator();
            
            // Reset all category headers
            $('.category-header').removeClass('expanded');
            $('.submenu-list').removeClass('expanded');
            $('.expand-icon').text('▼');
        };
        
        // Initialize sidebar state
        $(document).ready(function() {
            // Ensure sidebar is visible by default
            $('.side-menu').removeClass('collapsed');
            $('.side-menu-nav').addClass('expanded');
            
            console.log('Sidebar initialized. Visible:', !$('.side-menu').hasClass('collapsed'));
        });
        
        // Enhanced menu toggle functionality
        function toggleSidebar() {
            const sideMenu = $('#sideMenu');
            const mainContentWrapper = $('#mainContentWrapper');
            const floatingToggle = $('#floatingMenuToggle');
            
            if (sideMenu.hasClass('collapsed')) {
                // Expand the sidebar
                sideMenu.removeClass('collapsed');
                mainContentWrapper.removeClass('sidebar-collapsed');
                floatingToggle.removeClass('active');
                console.log('✅ Sidebar expanded');
            } else {
                // Collapse the sidebar
                sideMenu.addClass('collapsed');
                mainContentWrapper.addClass('sidebar-collapsed');
                floatingToggle.addClass('active');
                console.log('✅ Sidebar collapsed');
            }
        }
        
        // Menu toggle from sidebar header
        $('#menuToggle').on('click', function() {
            toggleSidebar();
        });
        
        // Floating menu toggle button
        $('#floatingMenuToggle').on('click', function() {
            toggleSidebar();
        });
        
        // Keyboard shortcut for menu toggle (Ctrl+M or Cmd+M)
        $(document).on('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'm') {
                e.preventDefault();
                toggleSidebar();
                console.log('✅ Sidebar toggled via keyboard shortcut');
            }
        });
        

        
        // Add touch support for mobile devices
        if ('ontouchstart' in window) {
            $('.module-card, .favorite-card').on('touchstart', function() {
                $(this).addClass('touch-active');
            }).on('touchend', function() {
                $(this).removeClass('touch-active');
            });
        }
    });

        // Service Worker registration removed due to 404 error
    </script>

    <!-- Additional CSS for enhanced interactions -->
    <style>
        .menu-card.focused {
            outline: 3px solid var(--primary-color);
            outline-offset: 2px;
        }
        
        .menu-card.touch-active {
            transform: scale(0.98);
        }
        
        .search-input.focused {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.2);
        }
        
        /* Enhanced animations for better performance */
        .menu-card {
            will-change: transform;
        }
        
        .menu-button {
            will-change: transform, background-color;
        }
        
        /* Print optimizations */
        @media print {
            .hospital-header,
            .user-info-bar,
            .search-section {
                display: none;
            }
            
            .menu-card {
                break-inside: avoid;
                box-shadow: none;
                border: 1px solid #000;
            }
        }
    </style>
</body>
</html>
	