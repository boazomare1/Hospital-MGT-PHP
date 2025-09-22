// Lab Audit Modern JavaScript

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
    
    // Handle form submission
    if (searchForm.length) {
        searchForm.on('submit', function(e) {
            e.preventDefault();
            
            if (validateSearchForm()) {
                showAlert('Searching lab audit records...', 'info', 2000);
                this.submit();
            }
        });
    }
    
    // Real-time search as user types
    $('#patient, #patientcode, #visitcode, #docnumber').on('input', function() {
        debounceSearch();
    });
}

function validateSearchForm() {
    const patient = $('#patient').val().trim();
    const patientcode = $('#patientcode').val().trim();
    const visitcode = $('#visitcode').val().trim();
    const docnumber = $('#docnumber').val().trim();
    const fromDate = $('#ADate1').val().trim();
    const toDate = $('#ADate2').val().trim();
    
    // At least one search field should be filled
    if (!patient && !patientcode && !visitcode && !docnumber) {
        showAlert('Please enter at least one search criteria', 'warning');
        $('#patient').focus();
        return false;
    }
    
    // Validate date range
    if (fromDate && toDate) {
        const from = new Date(fromDate);
        const to = new Date(toDate);
        
        if (from > to) {
            showAlert('From date cannot be greater than To date', 'error');
            $('#ADate1').focus();
            return false;
        }
    }
    
    return true;
}

// Debounced search function
let searchTimeout;
function debounceSearch() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(function() {
        // Optional: Implement real-time search here
        // For now, we'll just validate the form
        validateSearchForm();
    }, 500);
}

// Date Picker Functionality
function initializeDatePickers() {
    // Initialize date pickers if they exist
    if (typeof NewCssCal !== 'undefined') {
        // Legacy date picker integration
        console.log('Date pickers initialized');
    }
    
    // Modern date input enhancement
    $('input[type="date"]').on('change', function() {
        const dateValue = $(this).val();
        if (dateValue) {
            $(this).addClass('has-value');
        } else {
            $(this).removeClass('has-value');
        }
    });
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
    
    // Add click handlers for audit rows
    $('.data-table tbody tr').on('click', function() {
        const viewLink = $(this).find('.action-btn.view');
        if (viewLink.length) {
            viewLink[0].click();
        }
    });
}

// Action Handlers
function initializeActions() {
    // View button handlers
    $('.action-btn.view').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        if (href) {
            showLoadingState($(this));
            window.open(href, '_blank');
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
    // Reset date fields to today
    const today = new Date().toISOString().split('T')[0];
    $('#ADate1').val(today);
    $('#ADate2').val(today);
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
function searchLabAudit(searchTerm) {
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
        countDisplay.text(`${visibleRows} of ${totalRows} audit records`);
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

// Lab Audit Specific Functions
function viewLabAudit(patientcode, visitcode, fromdate, todate, docnumber) {
    const viewUrl = `lab_audit_view.php?patientcode=${patientcode}&visitcode=${visitcode}&fromdate=${fromdate}&todate=${todate}&docnumber=${docnumber}`;
    
    // Show loading state
    showAlert('Opening lab audit view...', 'info', 2000);
    
    // Open view window
    window.open(viewUrl, '_blank');
}

function printLabMaster(patientcode, visitcode, date1, date2, docno, itemcode) {
    const printUrl = `print_labmaster.php?patientcode=${patientcode}&visitcode=${visitcode}&docnumber=${docno}&ADate1=${date1}&ADate2=${date2}&itemcode=${itemcode}`;
    
    // Show loading state
    showAlert('Opening print preview...', 'info', 2000);
    
    // Open print window
    const printWindow = window.open(printUrl, '_blank', 'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
    
    // Check if window was blocked
    if (!printWindow) {
        showAlert('Popup blocked. Please allow popups for this site.', 'warning');
    }
}

function viewLabTests(patientcode, visitcode, billno, date1, date2) {
    const viewUrl = `viewlabtests.php?patientcode=${patientcode}&visitcode=${visitcode}&ADate1=${date1}&ADate2=${date2}&billnumber=${billno}`;
    
    // Show loading state
    showAlert('Opening lab tests view...', 'info', 2000);
    
    // Open view window
    const newWindow = window.open(viewUrl, 'Window1', 'width=450,height=200,left=0,top=0,toolbar=No,location=No,scrollbars=No,status=No,resizable=Yes,fullscreen=No');
    
    // Check if window was blocked
    if (!newWindow) {
        showAlert('Popup blocked. Please allow popups for this site.', 'warning');
    }
}

// Data Refresh
function refreshLabAuditData() {
    showAlert('Refreshing lab audit data...', 'info', 2000);
    
    // Reload the page to get fresh data
    setTimeout(function() {
        window.location.reload();
    }, 1500);
}

// Format Functions
function formatDate(dateString) {
    if (!dateString) return '';
    
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    });
}

function formatPatientCode(code) {
    if (!code) return '';
    return `<span class="patient-code">${code}</span>`;
}

function formatVisitCode(code) {
    if (!code) return '';
    return `<span class="visit-code">${code}</span>`;
}

function formatDocNumber(docNumber) {
    if (!docNumber) return '';
    return `<span class="doc-number">${docNumber}</span>`;
}

function formatSampleId(sampleId) {
    if (!sampleId) return '';
    return `<span class="sample-id">${sampleId}</span>`;
}

function formatTestName(testName) {
    if (!testName) return '';
    return `<span class="test-name">${testName}</span>`;
}

function formatSampleBy(sampleBy) {
    if (!sampleBy) return '';
    return `<span class="sample-by">${sampleBy}</span>`;
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
    if (e.keyCode === 13 && $('#searchForm input:focus').length) {
        e.preventDefault();
        if (validateSearchForm()) {
            $('#searchForm').submit();
        }
    }
});

// Auto-refresh functionality (optional)
function enableAutoRefresh(intervalMinutes = 15) {
    setInterval(function() {
        // Only auto-refresh if user is active
        if (!document.hidden) {
            refreshLabAuditData();
        }
    }, intervalMinutes * 60 * 1000);
}

// Initialize auto-refresh (uncomment to enable)
// enableAutoRefresh(15);

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
        const action = button.hasClass('view') ? 'View' : 
                      button.hasClass('print') ? 'Print' : 'Action';
        
        if (!button.attr('aria-label')) {
            button.attr('aria-label', `${action} lab audit record`);
        }
    });
    
    // Add keyboard navigation for table rows
    $('.data-table tbody tr').attr('tabindex', '0').on('keydown', function(e) {
        if (e.keyCode === 13 || e.keyCode === 32) { // Enter or Space
            const viewLink = $(this).find('.action-btn.view');
            if (viewLink.length) {
                viewLink[0].click();
            }
        }
    });
    
    // Add form labels
    $('input[type="text"], input[type="date"]').each(function() {
        const input = $(this);
        const id = input.attr('id');
        const label = $(`label[for="${id}"]`);
        
        if (label.length === 0) {
            // Create a label if none exists
            const labelText = input.prev('td').text().trim();
            if (labelText) {
                input.attr('aria-label', labelText);
            }
        }
    });
}

// Initialize accessibility features
$(document).ready(initializeAccessibility);

// Legacy function compatibility
function loadprintpagepdf1(patientcodes, visitcodes, date1, date2, docno, itemcode) {
    printLabMaster(patientcodes, visitcodes, date1, date2, docno, itemcode);
}

function viewtests(patientcodes, visitcodes, billno, date1, date2) {
    viewLabTests(patientcodes, visitcodes, billno, date1, date2);
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

function paymententry1process2() {
    if (document.getElementById("cbfrmflag1").value == "") {
        alert("Search Bill Number Cannot Be Empty.");
        document.getElementById("cbfrmflag1").focus();
        document.getElementById("cbfrmflag1").value = "<?php echo $cbfrmflag1; ?>";
        return false;
    }
}

// Export functions for global access
window.refreshPage = refreshPage;
window.exportToExcel = exportToExcel;
window.resetSearchForm = resetSearchForm;
window.viewLabAudit = viewLabAudit;
window.printLabMaster = printLabMaster;
window.viewLabTests = viewLabTests;
window.refreshLabAuditData = refreshLabAuditData;
window.loadprintpagepdf1 = loadprintpagepdf1;
window.viewtests = viewtests;
window.disableEnterKey = disableEnterKey;
window.process1backkeypress1 = process1backkeypress1;
window.paymententry1process2 = paymententry1process2;

