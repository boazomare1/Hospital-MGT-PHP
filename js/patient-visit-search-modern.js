// Patient Visit Search Modern JavaScript

$(document).ready(function() {
    // Initialize components
    initializeSidebar();
    initializeSearchForm();
    initializeTable();
    initializeActions();
    initializeDatePickers();
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
    const locationSelect = $('#location');
    
    // Handle form submission
    if (searchForm.length) {
        searchForm.on('submit', function(e) {
            e.preventDefault();
            
            if (validateSearchForm()) {
                showAlert('Searching patient visits...', 'info', 2000);
                this.submit();
            }
        });
    }
    
    // Handle location change
    if (locationSelect.length) {
        locationSelect.on('change', function() {
            const locationCode = $(this).val();
            if (locationCode) {
                updateLocationInfo(locationCode);
            }
        });
    }
    
    // Auto-fill date ranges
    setDefaultDateRange();
}

function validateSearchForm() {
    const patientName = $('#patient').val().trim();
    const patientCode = $('#patientcode').val().trim();
    const visitCode = $('#visitcode').val().trim();
    const fromDate = $('#ADate1').val().trim();
    const toDate = $('#ADate2').val().trim();
    const location = $('#location').val();
    
    // At least one search criteria must be provided
    if (!patientName && !patientCode && !visitCode && !fromDate && !toDate && !location) {
        showAlert('Please provide at least one search criteria', 'warning');
        $('#patient').focus();
        return false;
    }
    
    // Validate date range
    if (fromDate && toDate) {
        const fromDateObj = new Date(fromDate);
        const toDateObj = new Date(toDate);
        
        if (fromDateObj > toDateObj) {
            showAlert('From date cannot be greater than To date', 'warning');
            $('#ADate1').focus();
            return false;
        }
    }
    
    return true;
}

function setDefaultDateRange() {
    const today = new Date();
    const oneMonthAgo = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
    
    $('#ADate1').val(formatDate(oneMonthAgo));
    $('#ADate2').val(formatDate(today));
}

function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

function updateLocationInfo(locationCode) {
    // This would typically make an AJAX call to get location info
    // For now, we'll just show a loading state
    showAlert('Updating location information...', 'info', 1000);
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
    
    // Print button handlers
    $('.action-btn.print').on('click', function(e) {
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

// Date Picker Functionality
function initializeDatePickers() {
    // Initialize date pickers if they exist
    if (typeof NewCssCal !== 'undefined') {
        // Legacy date picker integration
        window.NewCssCal = NewCssCal;
    }
    
    // Modern date picker fallback
    $('.date-input').on('focus', function() {
        $(this).attr('type', 'date');
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
    setDefaultDateRange();
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
function searchPatientVisits(searchTerm) {
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
function printPatientVisit(patientcode) {
    const printUrl = `print_opvisit_label.php?patientcode=${patientcode}`;
    
    // Show loading state
    showAlert('Opening print preview...', 'info', 2000);
    
    // Open print window
    const printWindow = window.open(printUrl, '_blank', 'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
    
    // Check if window was blocked
    if (!printWindow) {
        showAlert('Popup blocked. Please allow popups for this site.', 'warning');
    }
}

// Edit Functionality
function editPatientVisit(patientcode, visitcode) {
    const editUrl = `editpatientvisit.php?patientcode=${patientcode}&visitcode=${visitcode}`;
    
    // Show loading state
    showAlert('Loading edit form...', 'info', 2000);
    
    // Navigate to edit page
    window.location.href = editUrl;
}

// Data Refresh
function refreshPatientData() {
    showAlert('Refreshing patient visit data...', 'info', 2000);
    
    // Reload the page to get fresh data
    setTimeout(function() {
        window.location.reload();
    }, 1500);
}

// Keyboard Shortcuts
$(document).on('keydown', function(e) {
    // Ctrl + F for search focus
    if (e.ctrlKey && e.keyCode === 70) {
        e.preventDefault();
        $('#patient').focus();
    }
    
    // Escape to reset form
    if (e.keyCode === 27) {
        resetSearchForm();
    }
    
    // Enter in form to submit
    if (e.keyCode === 13 && $('#searchForm input:focus, #searchForm select:focus').length) {
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
            refreshPatientData();
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
                      button.hasClass('print') ? 'Print' : 'Action';
        
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

function cbsuppliername1() {
    document.cbform1.submit();
}

function Process23() {
    // Legacy validation function
    return true;
}

// Export functions for global access
window.refreshPage = refreshPage;
window.exportToExcel = exportToExcel;
window.resetSearchForm = resetSearchForm;
window.printPatientVisit = printPatientVisit;
window.editPatientVisit = editPatientVisit;
window.refreshPatientData = refreshPatientData;
window.ajaxlocationfunction = ajaxlocationfunction;
window.cbsuppliername1 = cbsuppliername1;
window.Process23 = Process23;

