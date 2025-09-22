// Purchase Order Edit Modern JavaScript

$(document).ready(function() {
    // Initialize components
    initializeSidebar();
    initializeSearchForm();
    initializeTable();
    initializeActions();
});

// Sidebar Management
function initializeSidebar() {
    const menuToggle = $('#menuToggle');
    const sidebar = $('#leftSidebar');
    const sidebarToggle = $('#sidebarToggle');
    
    // Toggle sidebar from floating button
    menuToggle.on('click', function() {
        sidebar.toggleClass('open');
        updateMenuIcon();
    });
    
    // Toggle sidebar from sidebar button
    sidebarToggle.on('click', function() {
        sidebar.toggleClass('open');
        updateMenuIcon();
    });
    
    // Close sidebar when clicking outside
    $(document).on('click', function(e) {
        if (!sidebar.is(e.target) && sidebar.has(e.target).length === 0 && 
            !menuToggle.is(e.target) && menuToggle.has(e.target).length === 0) {
            sidebar.removeClass('open');
            updateMenuIcon();
        }
    });
    
    // Handle window resize
    $(window).on('resize', function() {
        if ($(window).width() > 768) {
            sidebar.removeClass('open');
            updateMenuIcon();
        }
    });
}

function updateMenuIcon() {
    const sidebar = $('#leftSidebar');
    const menuIcon = $('#menuToggle i');
    
    if (sidebar.hasClass('open')) {
        menuIcon.removeClass('fa-bars').addClass('fa-times');
    } else {
        menuIcon.removeClass('fa-times').addClass('fa-bars');
    }
}

// Search Form Functionality
function initializeSearchForm() {
    const searchForm = $('#searchForm');
    
    // Handle form submission
    if (searchForm.length) {
        searchForm.on('submit', function(e) {
            e.preventDefault();
            
            if (validateSearchForm()) {
                showAlert('Searching purchase orders...', 'info', 2000);
                this.submit();
            }
        });
    }
}

function validateSearchForm() {
    const poNumber = $('#pono').val().trim();
    
    if (!poNumber) {
        showAlert('Please enter a Purchase Order number to search', 'warning');
        $('#pono').focus();
        return false;
    }
    
    return true;
}

// Table Management
function initializeTable() {
    // Add hover effects
    $('.data-table tbody tr').hover(
        function() {
            $(this).addClass('table-row-hover');
        },
        function() {
            $(this).removeClass('table-row-hover');
        }
    );
    
    // Initialize row count
    updateRowCount();
    
    // Add click handlers for expandable rows
    initializeExpandableRows();
}

function initializeExpandableRows() {
    // Add click handlers for rows with item details
    $('.data-table tbody tr').on('click', function() {
        const nextRow = $(this).next('.item-details-row');
        if (nextRow.length) {
            nextRow.toggleClass('hidden');
            $(this).toggleClass('expanded');
        }
    });
}

// Action Handlers
function initializeActions() {
    // Edit button handlers
    $('.action-btn.edit').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        if (href) {
            showLoadingState($(this));
            window.location.href = href;
        }
    });
    
    // View button handlers
    $('.action-btn.view').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        if (href) {
            showLoadingState($(this));
            window.open(href, '_blank');
        }
    });
    
    // Refresh button
    $('.btn-secondary').on('click', function() {
        if ($(this).text().includes('Refresh')) {
            refreshPage();
        }
    });
    
    // Reset button
    $('#resetBtn').on('click', function() {
        resetSearchForm();
    });
}

// Utility Functions
function showLoadingState(element) {
    const originalText = element.html();
    element.html('<i class="fas fa-spinner fa-spin"></i> Loading...');
    element.prop('disabled', true);
    
    // Reset after 2 seconds
    setTimeout(function() {
        element.html(originalText);
        element.prop('disabled', false);
    }, 2000);
}

function refreshPage() {
    showAlert('Refreshing page...', 'info');
    setTimeout(function() {
        window.location.reload();
    }, 1000);
}

function resetSearchForm() {
    $('#searchForm')[0].reset();
    showAlert('Search form has been reset', 'info', 2000);
}

function exportToExcel() {
    showAlert('Export functionality would be implemented here', 'info');
}

function clearSearch() {
    $('#searchInput').val('');
    $('.data-table tbody tr').show();
    updateRowCount();
}

// Search functionality for results table
function searchPurchaseOrders(searchTerm) {
    const tableRows = $('.data-table tbody tr');
    
    tableRows.each(function() {
        const row = $(this);
        const text = row.text().toLowerCase();
        
        if (text.includes(searchTerm.toLowerCase())) {
            row.show();
        } else {
            row.hide();
        }
    });
    
    updateRowCount();
}

function updateRowCount() {
    const visibleRows = $('.data-table tbody tr:visible').length;
    const totalRows = $('.data-table tbody tr').length;
    
    // Update count display if it exists
    const countDisplay = $('.row-count-display');
    if (countDisplay.length) {
        countDisplay.text(`${visibleRows} of ${totalRows} records`);
    }
}

// Alert System
function showAlert(message, type = 'info', duration = 5000) {
    const alertContainer = $('#alertContainer');
    
    const alertClass = `alert-${type}`;
    const iconClass = getAlertIcon(type);
    
    const alertHtml = `
        <div class="alert ${alertClass} fade-in">
            <i class="fas ${iconClass} alert-icon"></i>
            <span>${message}</span>
            <button type="button" class="alert-close" onclick="closeAlert(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    alertContainer.append(alertHtml);
    
    // Auto-remove after duration
    if (duration > 0) {
        setTimeout(function() {
            alertContainer.find('.alert').last().fadeOut(300, function() {
                $(this).remove();
            });
        }, duration);
    }
}

function getAlertIcon(type) {
    const icons = {
        'success': 'fa-check-circle',
        'error': 'fa-exclamation-triangle',
        'warning': 'fa-exclamation-circle',
        'info': 'fa-info-circle'
    };
    return icons[type] || 'fa-info-circle';
}

function closeAlert(button) {
    $(button).closest('.alert').fadeOut(300, function() {
        $(this).remove();
    });
}

// Print Functionality
function printPurchaseOrder(ponumber) {
    const printUrl = `print_po.php?ponumber=${ponumber}`;
    
    // Show loading state
    showAlert('Opening print preview...', 'info', 2000);
    
    // Open print window
    const printWindow = window.open(printUrl, '_blank', 'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
    
    // Check if window was blocked
    if (!printWindow) {
        showAlert('Popup blocked. Please allow popups for this site.', 'warning');
    }
}

// Edit Functionality
function editPurchaseOrder(autoNumber, ponumber) {
    const editUrl = `editpo.php?anum=${autoNumber}&pono=${ponumber}`;
    
    // Show loading state
    showAlert('Loading edit form...', 'info', 2000);
    
    // Navigate to edit page
    window.location.href = editUrl;
}

// View Functionality
function viewPurchaseOrder(ponumber) {
    const viewUrl = `view_po.php?ponumber=${ponumber}`;
    
    // Show loading state
    showAlert('Opening purchase order view...', 'info', 2000);
    
    // Open view window
    window.open(viewUrl, '_blank');
}

// Data Refresh
function refreshPurchaseOrderData() {
    showAlert('Refreshing purchase order data...', 'info', 2000);
    
    // Reload the page to get fresh data
    setTimeout(function() {
        window.location.reload();
    }, 1500);
}

// Status Management
function getStatusClass(status) {
    const statusMap = {
        'PO Not Received': 'status-not-received',
        'PO Partially Received': 'status-partially-received',
        'PO Fully Received': 'status-fully-received',
        'PO Fully Received (Not Editable)': 'status-fully-received',
        'PO Partially Received (Not Editable)': 'status-partially-received'
    };
    
    return statusMap[status] || 'status-not-received';
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(amount);
}

// Keyboard Shortcuts
$(document).on('keydown', function(e) {
    // Ctrl + F for search focus
    if (e.ctrlKey && e.keyCode === 70) {
        e.preventDefault();
        $('#pono').focus();
    }
    
    // Escape to reset form
    if (e.keyCode === 27) {
        resetSearchForm();
    }
    
    // Enter in form to submit
    if (e.keyCode === 13 && $('#searchForm input:focus').length) {
        e.preventDefault();
        if (validateSearchForm()) {
            $('#searchForm').submit();
        }
    }
});

// Auto-refresh functionality (optional)
function enableAutoRefresh(intervalMinutes = 5) {
    setInterval(function() {
        // Only auto-refresh if user is active
        if (!document.hidden) {
            refreshPurchaseOrderData();
        }
    }, intervalMinutes * 60 * 1000);
}

// Initialize auto-refresh (uncomment to enable)
// enableAutoRefresh(5);

// Error Handling
window.addEventListener('error', function(e) {
    console.error('JavaScript Error:', e.error);
    showAlert('An error occurred. Please refresh the page.', 'error');
});

// Performance Monitoring
function logPerformance() {
    if (window.performance && window.performance.timing) {
        const timing = window.performance.timing;
        const loadTime = timing.loadEventEnd - timing.navigationStart;
        console.log(`Page load time: ${loadTime}ms`);
    }
}

// Initialize performance monitoring
$(window).on('load', logPerformance);

// Accessibility Improvements
function initializeAccessibility() {
    // Add ARIA labels
    $('.action-btn').each(function() {
        const button = $(this);
        const action = button.hasClass('edit') ? 'Edit' : 
                      button.hasClass('view') ? 'View' : 'Action';
        
        if (!button.attr('aria-label')) {
            button.attr('aria-label', `${action} this record`);
        }
    });
    
    // Add keyboard navigation for table rows
    $('.data-table tbody tr').attr('tabindex', '0').on('keydown', function(e) {
        if (e.keyCode === 13 || e.keyCode === 32) { // Enter or Space
            const editLink = $(this).find('.action-btn.edit');
            if (editLink.length) {
                editLink[0].click();
            }
        }
    });
}

// Initialize accessibility features
$(document).ready(initializeAccessibility);

// Legacy function compatibility
function ajaxlocationfunction(val) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("ajaxlocation").innerHTML = xmlhttp.responseText;
        }
    };
    
    xmlhttp.open("GET", "ajax/ajaxgetlocationname.php?loccode=" + val, true);
    xmlhttp.send();
}

function disableEnterKey(varPassed) {
    if (event.keyCode == 8) {
        event.keyCode = 0; 
        return event.keyCode;
        return false;
    }
    
    var key;
    if(window.event) {
        key = window.event.keyCode;     //IE
    } else {
        key = e.which;     //firefox
    }
    
    if(key == 13) { // if enter key press
        return false;
    } else {
        return true;
    }
}

function process1backkeypress1() {
    if (event.keyCode == 8) {
        event.keyCode = 0; 
        return event.keyCode;
        return false;
    }
}

// Export functions for global access
window.refreshPage = refreshPage;
window.exportToExcel = exportToExcel;
window.resetSearchForm = resetSearchForm;
window.printPurchaseOrder = printPurchaseOrder;
window.editPurchaseOrder = editPurchaseOrder;
window.viewPurchaseOrder = viewPurchaseOrder;
window.refreshPurchaseOrderData = refreshPurchaseOrderData;
window.ajaxlocationfunction = ajaxlocationfunction;
window.disableEnterKey = disableEnterKey;
window.process1backkeypress1 = process1backkeypress1;

