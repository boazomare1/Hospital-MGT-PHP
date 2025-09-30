// Hospital Revenue Report Modern JavaScript - MedStar Hospital Management

$(document).ready(function() {
    // Initialize page
    initializePage();
    
    // Setup event listeners
    setupEventListeners();
    
    // Initialize functionality
    initializeFunctionality();
});

function initializePage() {
    // Setup sidebar toggle
    $('#menuToggle').click(function() {
        $('#leftSidebar').toggleClass('collapsed');
        $(this).find('i').toggleClass('fa-bars fa-times');
    });
    
    // Setup sidebar toggle button
    $('#sidebarToggle').click(function() {
        $('#leftSidebar').toggleClass('collapsed');
    });
    
    // Initialize date pickers
    initializeDatePickers();
    
    // Initialize form validation
    initializeFormValidation();
}

function setupEventListeners() {
    // Form submission
    $('form').on('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return false;
        }
        
        // Show loading state
        $(this).addClass('form-loading');
        $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Generating...');
    });
    
    // Location change handler
    $('#location').on('change', function() {
        ajaxlocationfunction(this.value);
    });
    
    // Date validation
    $('#ADate1, #ADate2').on('change', function() {
        validateDateRange();
    });
    
    // Print functionality
    $(document).keydown(function(e) {
        // Ctrl + P for print
        if (e.ctrlKey && e.which === 80) {
            e.preventDefault();
            printReport();
        }
        
        // Ctrl + R for refresh
        if (e.ctrlKey && e.which === 82) {
            e.preventDefault();
            refreshPage();
        }
    });
}

function initializeFunctionality() {
    // Initialize any additional functionality
    console.log('Hospital Revenue Report page initialized');
    
    // Animate revenue cards on load
    animateRevenueCards();
    
    // Setup tooltips
    setupTooltips();
}

// Original functions from the legacy code
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
    }
    
    xmlhttp.open("GET", "ajax/ajaxgetlocationname.php?loccode=" + val, true);
    xmlhttp.send();
}

function cbsuppliername1() {
    document.cbform1.submit();
}

function disableEnterKey() {
    if (event.keyCode == 8) {
        event.keyCode = 0;
        return event.keyCode;
        return false;
    }
    
    var key;
    if (window.event) {
        key = window.event.keyCode; // IE
    } else {
        key = e.which; // firefox
    }
    
    if (key == 13) { // if enter key press
        return false;
    } else {
        return true;
    }
}

// Modern utility functions
function showAlert(message, type) {
    var alertClass = 'alert-' + type;
    var iconClass = 'fas fa-info-circle';
    
    switch(type) {
        case 'success':
            iconClass = 'fas fa-check-circle';
            break;
        case 'error':
            iconClass = 'fas fa-exclamation-triangle';
            break;
        case 'warning':
            iconClass = 'fas fa-exclamation-circle';
            break;
    }
    
    var alertHtml = '<div class="alert ' + alertClass + '">' +
        '<i class="' + iconClass + ' alert-icon"></i>' +
        '<span>' + message + '</span>' +
        '</div>';
    
    // Remove existing alerts
    $('.alert').remove();
    
    // Add new alert
    $('main').prepend(alertHtml);
    
    // Auto-hide after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
}

function validateForm() {
    var isValid = true;
    var errors = [];
    
    // Check required fields
    if ($('#ADate1').val().trim() === '') {
        errors.push('Date From is required');
        $('#ADate1').addClass('error');
        isValid = false;
    } else {
        $('#ADate1').removeClass('error');
    }
    
    if ($('#ADate2').val().trim() === '') {
        errors.push('Date To is required');
        $('#ADate2').addClass('error');
        isValid = false;
    } else {
        $('#ADate2').removeClass('error');
    }
    
    // Validate date range
    if (isValid && !validateDateRange()) {
        errors.push('Date To must be after Date From');
        isValid = false;
    }
    
    // Display errors if any
    if (!isValid) {
        showAlert(errors.join('<br>'), 'error');
    }
    
    return isValid;
}

function validateDateRange() {
    var dateFrom = new Date($('#ADate1').val());
    var dateTo = new Date($('#ADate2').val());
    
    if (dateFrom && dateTo && dateTo < dateFrom) {
        $('#ADate2').addClass('error');
        return false;
    } else {
        $('#ADate2').removeClass('error');
        return true;
    }
}

function initializeDatePickers() {
    // Date picker initialization is handled by the external datetimepicker_css.js
    // This function can be used for additional date picker setup if needed
}

function initializeFormValidation() {
    // Real-time validation
    $('#ADate1, #ADate2').on('blur', function() {
        validateField($(this));
    });
}

function validateField(field) {
    var fieldName = field.attr('name');
    var fieldValue = field.val().trim();
    var isValid = true;
    var errorMessage = '';
    
    switch(fieldName) {
        case 'ADate1':
        case 'ADate2':
            if (fieldValue === '') {
                errorMessage = 'Date is required';
                isValid = false;
            } else if (!isValidDate(fieldValue)) {
                errorMessage = 'Please enter a valid date';
                isValid = false;
            }
            break;
    }
    
    if (isValid) {
        field.removeClass('error');
        field.next('.field-error').remove();
    } else {
        field.addClass('error');
        if (field.next('.field-error').length === 0) {
            field.after('<div class="field-error" style="color: #dc2626; font-size: 0.8rem; margin-top: 0.25rem;">' + errorMessage + '</div>');
        }
    }
    
    return isValid;
}

function isValidDate(dateString) {
    var regEx = /^\d{4}-\d{2}-\d{2}$/;
    if (!dateString.match(regEx)) return false;
    var d = new Date(dateString);
    var dNum = d.getTime();
    if (!dNum && dNum !== 0) return false;
    return d.toISOString().slice(0, 10) === dateString;
}

function refreshPage() {
    window.location.reload();
}

function printReport() {
    // Hide elements that shouldn't be printed
    $('.floating-menu-toggle, .left-sidebar, .user-info-bar, .nav-breadcrumb, .page-header-actions, .filter-section, .table-actions').hide();
    
    // Print the page
    window.print();
    
    // Show elements again
    $('.floating-menu-toggle, .left-sidebar, .user-info-bar, .nav-breadcrumb, .page-header-actions, .filter-section, .table-actions').show();
}

function exportToExcel() {
    // Create a simple Excel export
    var table = document.getElementById('revenueTable') || document.querySelector('.data-table');
    if (!table) {
        showAlert('No data table found for export', 'error');
        return;
    }
    
    // Convert table to CSV
    var csv = tableToCSV(table);
    
    // Download CSV file
    downloadCSV(csv, 'hospital_revenue_report.csv');
    
    showAlert('Report exported to Excel successfully', 'success');
}

function exportToPDF() {
    // Simple PDF export using browser print
    printReport();
    showAlert('Report sent to printer/PDF', 'success');
}

function tableToCSV(table) {
    var csv = [];
    var rows = table.querySelectorAll('tr');
    
    for (var i = 0; i < rows.length; i++) {
        var row = [];
        var cols = rows[i].querySelectorAll('td, th');
        
        for (var j = 0; j < cols.length; j++) {
            var cellText = cols[j].innerText.replace(/"/g, '""');
            row.push('"' + cellText + '"');
        }
        
        csv.push(row.join(','));
    }
    
    return csv.join('\n');
}

function downloadCSV(csv, filename) {
    var blob = new Blob([csv], { type: 'text/csv' });
    var link = document.createElement('a');
    
    if (link.download !== undefined) {
        var url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', filename);
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

function animateRevenueCards() {
    $('.revenue-card').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
    });
}

function setupTooltips() {
    // Add tooltips to revenue cards
    $('.revenue-card').each(function() {
        var cardType = $(this).attr('class').split(' ')[1];
        var tooltipText = getTooltipText(cardType);
        
        $(this).attr('title', tooltipText);
    });
}

function getTooltipText(cardType) {
    var tooltips = {
        'consultation': 'Revenue from patient consultations and medical examinations',
        'pharmacy': 'Revenue from medicine sales and pharmaceutical services',
        'lab': 'Revenue from laboratory tests and diagnostic services',
        'radiology': 'Revenue from X-ray, MRI, CT scan and other imaging services',
        'services': 'Revenue from various hospital services and procedures',
        'total': 'Total revenue from all hospital services combined'
    };
    
    return tooltips[cardType] || 'Hospital revenue information';
}

// Enhanced form submission with better UX
$('#cbform1').on('submit', function(e) {
    if (!validateForm()) {
        e.preventDefault();
        return false;
    }
    
    // Show loading state
    $(this).addClass('form-loading');
    $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Generating Report...');
    
    // Add loading overlay
    $('body').append('<div id="loadingOverlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; display: flex; align-items: center; justify-content: center;"><div style="background: white; padding: 2rem; border-radius: 8px; text-align: center;"><i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: #1e40af;"></i><p style="margin: 1rem 0 0 0;">Generating Revenue Report...</p></div></div>');
});

// Remove loading overlay when page loads
$(window).on('load', function() {
    $('#loadingOverlay').remove();
    $('.form-loading').removeClass('form-loading');
    $('button[type="submit"]').prop('disabled', false).html('<i class="fas fa-search"></i> Generate Report');
});

// Enhanced error handling
window.onerror = function(msg, url, lineNo, columnNo, error) {
    console.error('JavaScript Error:', {
        message: msg,
        source: url,
        line: lineNo,
        column: columnNo,
        error: error
    });
    
    showAlert('An error occurred. Please refresh the page.', 'error');
    return false;
};

// Form field focus management
$('input, select, textarea').on('focus', function() {
    $(this).closest('.form-group').addClass('focused');
}).on('blur', function() {
    $(this).closest('.form-group').removeClass('focused');
});

// Auto-format currency values
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-IN', {
        style: 'currency',
        currency: 'INR',
        minimumFractionDigits: 2
    }).format(amount);
}

// Update currency display
$(document).ready(function() {
    $('.card-amount, .amount-cell').each(function() {
        var amount = parseFloat($(this).text().replace(/,/g, ''));
        if (!isNaN(amount)) {
            $(this).text(formatCurrency(amount));
        }
    });
});

// Chart functionality (for future enhancements)
function createRevenueChart() {
    // This function can be used to create charts using Chart.js or other libraries
    console.log('Chart functionality can be implemented here');
}

// Data export functionality
function exportData(format) {
    switch(format) {
        case 'excel':
            exportToExcel();
            break;
        case 'pdf':
            exportToPDF();
            break;
        case 'csv':
            var table = document.querySelector('.data-table');
            var csv = tableToCSV(table);
            downloadCSV(csv, 'hospital_revenue_report.csv');
            break;
        default:
            console.log('Unsupported export format:', format);
    }
}

// Responsive table handling
function handleResponsiveTable() {
    var table = document.querySelector('.data-table');
    if (table) {
        var wrapper = table.parentElement;
        wrapper.style.overflowX = 'auto';
    }
}

$(document).ready(function() {
    handleResponsiveTable();
});

// Keyboard shortcuts
$(document).keydown(function(e) {
    // Escape to close any open modals or clear form
    if (e.which === 27) {
        $('.modal').hide();
        $('.alert').fadeOut();
    }
});

// Auto-refresh functionality (optional)
function enableAutoRefresh(interval) {
    setInterval(function() {
        if (confirm('Auto-refresh: Update the report with latest data?')) {
            refreshPage();
        }
    }, interval);
}

// Disable auto-refresh by default
// enableAutoRefresh(300000); // 5 minutes

// Enhanced form validation with real-time feedback
$('#cbform1 input, #cbform1 select').on('input change', function() {
    validateField($(this));
});

// Form reset functionality
$('button[type="reset"]').on('click', function() {
    setTimeout(function() {
        $('.error').removeClass('error');
        $('.field-error').remove();
        $('.alert').fadeOut();
    }, 100);
});

// Location change with visual feedback
$('#location').on('change', function() {
    var locationName = $(this).find('option:selected').text();
    showAlert('Location changed to: ' + locationName, 'info');
});

// Date range validation with visual feedback
$('#ADate1, #ADate2').on('change', function() {
    if (validateDateRange()) {
        $('.field-error').remove();
        $('#ADate1, #ADate2').removeClass('error');
    }
});

