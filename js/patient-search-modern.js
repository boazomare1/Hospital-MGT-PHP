// Patient Search Modern JavaScript

$(document).ready(function() {
    // Initialize components
    initializeSidebar();
    initializeSearchForm();
    initializeTable();
    initializeActions();
    initializeAutocomplete();
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
                showAlert('Searching patients...', 'info', 2000);
                this.submit();
            }
        });
    }
    
    // Real-time search as user types
    $('#patient, #patientcode, #nationalid, #phonenumber').on('input', function() {
        debounceSearch();
    });
}

function validateSearchForm() {
    const patient = $('#patient').val().trim();
    const patientcode = $('#patientcode').val().trim();
    const nationalid = $('#nationalid').val().trim();
    const phonenumber = $('#phonenumber').val().trim();
    const subtype = $('#searchsuppliername1').val().trim();
    const account = $('#searchsuppliername').val().trim();
    
    // At least one search field should be filled
    if (!patient && !patientcode && !nationalid && !phonenumber && !subtype && !account) {
        showAlert('Please enter at least one search criteria', 'warning');
        $('#patient').focus();
        return false;
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
    
    // Add click handlers for patient rows
    $('.data-table tbody tr').on('click', function() {
        const editLink = $(this).find('.action-btn.edit');
        if (editLink.length) {
            editLink[0].click();
        }
    });
}

// Action Handlers
function initializeActions() {
    // Print button handlers
    $('.action-btn.print').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        if (href) {
            showLoadingState($(this));
            window.open(href, '_blank');
        }
    });
    
    // Edit button handlers
    $('.action-btn.edit').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        if (href) {
            showLoadingState($(this));
            window.location.href = href;
        }
    });
    
    // Visit button handlers
    $('.action-btn.visit').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        if (href) {
            showLoadingState($(this));
            window.location.href = href;
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

// Autocomplete Functionality
function initializeAutocomplete() {
    // Patient name autocomplete
    $('#patient').autocomplete({
        source: 'ajax/patient_search.php',
        minLength: 2,
        delay: 300,
        select: function(event, ui) {
            $('#patient').val(ui.item.value);
            $('#patientcode').val(ui.item.code);
            $('#nationalid').val(ui.item.nationalid);
            $('#phonenumber').val(ui.item.phone);
        }
    });
    
    // Registration number autocomplete
    $('#patientcode').autocomplete({
        source: 'ajax/patient_code_search.php',
        minLength: 1,
        delay: 300,
        select: function(event, ui) {
            $('#patientcode').val(ui.item.code);
            $('#patient').val(ui.item.name);
            $('#nationalid').val(ui.item.nationalid);
            $('#phonenumber').val(ui.item.phone);
        }
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
function searchPatients(searchTerm) {
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
        countDisplay.text(`${visibleRows} of ${totalRows} patients`);
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
function printPatientLabel(patientcode) {
    const printUrl = `print_registration_label.php?previouspatientcode=${patientcode}`;
    
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
function editPatient(patientcode) {
    const editUrl = `editpatient_new.php?patientcode=${patientcode}`;
    
    // Show loading state
    showAlert('Loading patient edit form...', 'info', 2000);
    
    // Navigate to edit page
    window.location.href = editUrl;
}

// Visit Functionality
function createOPVisit(patientcode) {
    const visitUrl = `visitentry_op_new.php?patientcode=${patientcode}`;
    
    // Show loading state
    showAlert('Creating new OP visit...', 'info', 2000);
    
    // Navigate to visit entry page
    window.location.href = visitUrl;
}

// Data Refresh
function refreshPatientData() {
    showAlert('Refreshing patient data...', 'info', 2000);
    
    // Reload the page to get fresh data
    setTimeout(function() {
        window.location.reload();
    }, 1500);
}

// Gender Icon Management
function getGenderIcon(gender) {
    const genderLower = gender.toLowerCase();
    if (genderLower === 'male' || genderLower === 'm') {
        return '<i class="fas fa-mars gender-icon" style="color: #3498db;"></i>';
    } else if (genderLower === 'female' || genderLower === 'f') {
        return '<i class="fas fa-venus gender-icon" style="color: #e91e63;"></i>';
    } else {
        return '<i class="fas fa-question gender-icon" style="color: #6c757d;"></i>';
    }
}

// Payment Type Styling
function getPaymentTypeClass(paymentType) {
    const typeLower = paymentType.toLowerCase();
    if (typeLower.includes('cash')) {
        return 'payment-type cash';
    } else if (typeLower.includes('insurance') || typeLower.includes('plan')) {
        return 'payment-type insurance';
    } else if (typeLower.includes('credit')) {
        return 'payment-type credit';
    } else {
        return 'payment-type';
    }
}

// Age Calculation
function calculateAge(birthDate) {
    const today = new Date();
    const birth = new Date(birthDate);
    let age = today.getFullYear() - birth.getFullYear();
    const monthDiff = today.getMonth() - birth.getMonth();
    
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
        age--;
    }
    
    return age;
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
function enableAutoRefresh(intervalMinutes = 10) {
    setInterval(function() {
        // Only auto-refresh if user is active
        if (!document.hidden) {
            refreshPatientData();
        }
    }, intervalMinutes * 60 * 1000);
}

// Initialize auto-refresh (uncomment to enable)
// enableAutoRefresh(10);

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
        const action = button.hasClass('print') ? 'Print' : 
                      button.hasClass('edit') ? 'Edit' : 
                      button.hasClass('visit') ? 'Create Visit' : 'Action';
        
        if (!button.attr('aria-label')) {
            button.attr('aria-label', `${action} patient record`);
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
    
    // Add form labels
    $('input[type="text"]').each(function() {
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
function cbsuppliername1() {
    document.cbform1.submit();
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

function funcPrintReceipt1() {
    window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

function funcAccount() {
    if((document.getElementById("searchsuppliername").value == "")||(document.getElementById("searchsuppliername").value == " ")) {
        alert('Please Select Account Name.');
        return false;
    } else {
        if((document.getElementById("searchsuppliercode").value == "")||(document.getElementById("searchsuppliercode").value == " ")) {
            alert('Please Select Account Name.');
            return false;
        }
    } 
}

function funcAccount1() {
    if((document.getElementById("searchsuppliername").value == "")||(document.getElementById("searchsuppliername").value == " ")) {
        alert('Please Select Account Name');
        return false;
    }
}

// Export functions for global access
window.refreshPage = refreshPage;
window.exportToExcel = exportToExcel;
window.resetSearchForm = resetSearchForm;
window.printPatientLabel = printPatientLabel;
window.editPatient = editPatient;
window.createOPVisit = createOPVisit;
window.refreshPatientData = refreshPatientData;
window.cbsuppliername1 = cbsuppliername1;
window.disableEnterKey = disableEnterKey;
window.process1backkeypress1 = process1backkeypress1;
window.paymententry1process2 = paymententry1process2;
window.funcPrintReceipt1 = funcPrintReceipt1;
window.funcAccount = funcAccount;
window.funcAccount1 = funcAccount1;

