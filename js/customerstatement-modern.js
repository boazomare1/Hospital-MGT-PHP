// Customer Statement Modern JavaScript - Based on vat.php functionality

$(document).ready(function() {
    // Initialize modern functionality
    initializeModernFeatures();
    
    // Setup autocomplete for customer name
    setupCustomerAutocomplete();
    
    // Setup form validation
    setupFormValidation();
    
    // Setup responsive sidebar
    setupResponsiveSidebar();
    
    // Setup modern alerts
    setupModernAlerts();
});

// Initialize modern features
function initializeModernFeatures() {
    // Add fade-in animation to main content
    $('.main-content').addClass('fade-in');
    
    // Setup tooltips for action buttons
    $('[title]').each(function() {
        $(this).tooltip({
            position: { my: "left+15 center", at: "right center" }
        });
    });
    
    // Add loading states to buttons
    $('.submit-btn').on('click', function() {
        $(this).addClass('loading');
        setTimeout(() => {
            $(this).removeClass('loading');
        }, 2000);
    });
}

// Setup customer autocomplete
function setupCustomerAutocomplete() {
    $('#customername').autocomplete({
        source: 'ajaxcustomernewserach.php',
        minLength: 1,
        delay: 0,
        html: true,
        select: function(event, ui) {
            var customercode = ui.item.customercode;
            $('#searchcustomercode').val(customercode);
            
            // Show success message
            showAlert('Customer selected: ' + ui.item.value, 'success');
        },
        focus: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.value);
        }
    }).on('input', function() {
        // Clear customer code when name is cleared
        if ($(this).val() === '') {
            $('#searchcustomercode').val('');
        }
    });
}

// Setup form validation
function setupFormValidation() {
    $('#customerStatementForm').on('submit', function(e) {
        var isValid = true;
        var errorMessages = [];
        
        // Validate customer name
        if ($('#customername').val().trim() === '') {
            errorMessages.push('Please select a patient name');
            $('#customername').addClass('error');
            isValid = false;
        } else {
            $('#customername').removeClass('error');
        }
        
        // Validate date range
        var dateFrom = $('#ADate1').val();
        var dateTo = $('#ADate2').val();
        
        if (dateFrom && dateTo) {
            var fromDate = new Date(dateFrom);
            var toDate = new Date(dateTo);
            
            if (fromDate > toDate) {
                errorMessages.push('Date From cannot be greater than Date To');
                $('#ADate1, #ADate2').addClass('error');
                isValid = false;
            } else {
                $('#ADate1, #ADate2').removeClass('error');
            }
        }
        
        if (!isValid) {
            e.preventDefault();
            showAlert(errorMessages.join('<br>'), 'error');
            return false;
        }
        
        // Show loading state
        showAlert('Generating customer statement...', 'info');
    });
}

// Setup responsive sidebar
function setupResponsiveSidebar() {
    // Toggle sidebar
    $('#sidebarToggle').on('click', function() {
        $('#leftSidebar').toggleClass('collapsed');
        $(this).find('i').toggleClass('fa-chevron-left fa-chevron-right');
    });
    
    // Floating menu toggle
    $('#menuToggle').on('click', function() {
        $('#leftSidebar').toggleClass('collapsed');
        $('#sidebarToggle i').toggleClass('fa-chevron-left fa-chevron-right');
    });
    
    // Close sidebar on mobile when clicking outside
    $(document).on('click', function(e) {
        if ($(window).width() <= 768) {
            if (!$(e.target).closest('#leftSidebar, #menuToggle').length) {
                $('#leftSidebar').addClass('collapsed');
            }
        }
    });
    
    // Handle window resize
    $(window).on('resize', function() {
        if ($(window).width() > 768) {
            $('#leftSidebar').removeClass('collapsed');
        }
    });
}

// Setup modern alerts
function setupModernAlerts() {
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut(500, function() {
            $(this).remove();
        });
    }, 5000);
    
    // Add close button to alerts
    $('.alert').each(function() {
        if (!$(this).find('.alert-close').length) {
            $(this).append('<button class="alert-close" onclick="$(this).parent().fadeOut()"><i class="fas fa-times"></i></button>');
        }
    });
}

// Show modern alert
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
    
    var alertHtml = `
        <div class="alert ${alertClass} fade-in">
            <i class="${iconClass} alert-icon"></i>
            <span>${message}</span>
            <button class="alert-close" onclick="$(this).parent().fadeOut()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    $('#alertContainer').html(alertHtml);
    
    // Auto-hide after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut(500, function() {
            $(this).remove();
        });
    }, 5000);
}

// Reset form
function resetForm() {
    $('#customerStatementForm')[0].reset();
    $('#searchcustomercode').val('');
    $('.form-input').removeClass('error');
    showAlert('Form has been reset', 'info');
}

// Refresh page
function refreshPage() {
    showAlert('Refreshing page...', 'info');
    setTimeout(function() {
        window.location.reload();
    }, 1000);
}

// Export to Excel
function exportToExcel() {
    var customercode = $('#searchcustomercode').val();
    var dateFrom = $('#ADate1').val();
    var dateTo = $('#ADate2').val();
    
    if (!customercode) {
        showAlert('Please select a customer first', 'error');
        return;
    }
    
    if (!dateFrom || !dateTo) {
        showAlert('Please select date range first', 'error');
        return;
    }
    
    var exportUrl = `customerstatementt_xl.php?searchcustomercode=${customercode}&ADate1=${dateFrom}&ADate2=${dateTo}`;
    
    showAlert('Preparing Excel export...', 'info');
    
    // Create temporary link and click it
    var link = document.createElement('a');
    link.href = exportUrl;
    link.download = 'customer_statement.xls';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    setTimeout(function() {
        showAlert('Excel export completed', 'success');
    }, 2000);
}

// Print statement
function printStatement() {
    var customercode = $('#searchcustomercode').val();
    var dateFrom = $('#ADate1').val();
    var dateTo = $('#ADate2').val();
    
    if (!customercode) {
        showAlert('Please select a customer first', 'error');
        return;
    }
    
    if (!dateFrom || !dateTo) {
        showAlert('Please select date range first', 'error');
        return;
    }
    
    var printUrl = `customerstatement_print.php?searchcustomercode=${customercode}&ADate1=${dateFrom}&ADate2=${dateTo}`;
    
    showAlert('Opening print view...', 'info');
    
    // Open print window
    var printWindow = window.open(printUrl, '_blank', 'width=800,height=600');
    
    if (printWindow) {
        printWindow.onload = function() {
            printWindow.print();
        };
    }
}

// Enhanced form validation function (keeping original functionality)
function funcAccount() {
    if (document.getElementById("customername").value === "") {
        showAlert("Please Select Patient Name", "error");
        return false;
    }
    return true;
}

// Setup date picker enhancements
function setupDatePickerEnhancements() {
    // Add modern styling to date inputs
    $('.date-input-group input').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        $(this).parent().removeClass('focused');
    });
}

// Setup table enhancements
function setupTableEnhancements() {
    // Add hover effects to table rows
    $('.data-table tbody tr').hover(
        function() {
            $(this).addClass('hover');
        },
        function() {
            $(this).removeClass('hover');
        }
    );
    
    // Add click effects to action buttons
    $('.action-btn').on('click', function() {
        $(this).addClass('clicked');
        setTimeout(() => {
            $(this).removeClass('clicked');
        }, 200);
    });
}

// Setup keyboard shortcuts
function setupKeyboardShortcuts() {
    $(document).on('keydown', function(e) {
        // Ctrl + R to refresh
        if (e.ctrlKey && e.keyCode === 82) {
            e.preventDefault();
            refreshPage();
        }
        
        // Ctrl + E to export
        if (e.ctrlKey && e.keyCode === 69) {
            e.preventDefault();
            exportToExcel();
        }
        
        // Ctrl + P to print
        if (e.ctrlKey && e.keyCode === 80) {
            e.preventDefault();
            printStatement();
        }
        
        // Escape to close sidebar
        if (e.keyCode === 27) {
            $('#leftSidebar').addClass('collapsed');
        }
    });
}

// Initialize all enhancements
$(document).ready(function() {
    setupDatePickerEnhancements();
    setupTableEnhancements();
    setupKeyboardShortcuts();
    
    // Add smooth scrolling
    $('a[href^="#"]').on('click', function(e) {
        e.preventDefault();
        var target = $(this.getAttribute('href'));
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 500);
        }
    });
    
    // Add loading animation to page
    $('body').addClass('loaded');
});

// Utility functions
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

// Error handling
window.addEventListener('error', function(e) {
    console.error('JavaScript Error:', e.error);
    showAlert('An error occurred. Please refresh the page.', 'error');
});

// Performance monitoring
window.addEventListener('load', function() {
    console.log('Customer Statement page loaded successfully');
});

