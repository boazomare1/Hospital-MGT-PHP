// Day Book Report Modern JavaScript - Based on vat.php functionality

$(document).ready(function() {
    // Initialize modern functionality
    initializeModernFeatures();
    
    // Setup form validation
    setupFormValidation();
    
    // Setup responsive sidebar
    setupResponsiveSidebar();
    
    // Setup modern alerts
    setupModernAlerts();
    
    // Setup report enhancements
    setupReportEnhancements();
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

// Setup form validation
function setupFormValidation() {
    $('#dayBookForm').on('submit', function(e) {
        var isValid = true;
        var errorMessages = [];
        
        // Custom validation can be added here
        
        if (!isValid) {
            e.preventDefault();
            showAlert(errorMessages.join('<br>'), 'error');
            return false;
        }
        
        // Show loading state
        showAlert('Generating day book report...', 'info');
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

// Setup report enhancements
function setupReportEnhancements() {
    // Setup table enhancements
    setupTableEnhancements();
    
    // Setup search functionality
    setupSearchFunctionality();
    
    // Setup summary calculations
    setupSummaryCalculations();
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
    
    // Add sorting functionality to table headers
    $('.data-table th').each(function() {
        if ($(this).text().trim() !== '') {
            $(this).addClass('sortable');
            $(this).append(' <i class="fas fa-sort sort-icon"></i>');
        }
    });
    
    // Add click handlers for sorting
    $('.data-table th.sortable').on('click', function() {
        var column = $(this).index();
        var table = $(this).closest('table');
        var rows = table.find('tbody tr').toArray();
        
        // Simple sorting logic
        rows.sort(function(a, b) {
            var aVal = $(a).find('td').eq(column).text().trim();
            var bVal = $(b).find('td').eq(column).text().trim();
            
            // Try to parse as numbers first
            var aNum = parseFloat(aVal.replace(/[^\d.-]/g, ''));
            var bNum = parseFloat(bVal.replace(/[^\d.-]/g, ''));
            
            if (!isNaN(aNum) && !isNaN(bNum)) {
                return aNum - bNum;
            }
            
            return aVal.localeCompare(bVal);
        });
        
        // Reorder rows
        table.find('tbody').empty().append(rows);
        
        // Update sort icons
        $('.data-table th .sort-icon').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort');
        $(this).find('.sort-icon').removeClass('fa-sort').addClass('fa-sort-up');
    });
}

// Setup search functionality
function setupSearchFunctionality() {
    // Add search input to page header
    var searchHtml = `
        <div class="search-container">
            <input type="text" id="reportSearch" class="form-input" 
                   placeholder="Search transactions..." style="width: 300px;">
        </div>
    `;
    
    $('.page-header-actions').prepend(searchHtml);
    
    // Search functionality
    $('#reportSearch').on('input', function() {
        var searchTerm = $(this).val().toLowerCase();
        
        $('.data-table tbody tr').each(function() {
            var rowText = $(this).text().toLowerCase();
            if (rowText.includes(searchTerm) || searchTerm === '') {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        
        updateSearchResults();
    });
}

// Update search results count
function updateSearchResults() {
    var visibleRows = $('.data-table tbody tr:visible').length;
    var totalRows = $('.data-table tbody tr').length;
    
    if ($('#reportSearch').val() !== '') {
        showAlert(`Found ${visibleRows} of ${totalRows} transactions`, 'info');
    }
}

// Setup summary calculations
function setupSummaryCalculations() {
    // Calculate totals when page loads
    calculateTotals();
    
    // Add summary section
    addSummarySection();
}

// Calculate report totals
function calculateTotals() {
    var totalCash = 0;
    var totalCard = 0;
    var totalCheque = 0;
    var totalOnline = 0;
    var grandTotal = 0;
    
    $('.data-table tbody tr').each(function() {
        // Extract values from appropriate columns (adjust column indices as needed)
        var cashAmount = parseFloat($(this).find('td:nth-child(5)').text().replace(/[^\d.-]/g, '')) || 0;
        var cardAmount = parseFloat($(this).find('td:nth-child(6)').text().replace(/[^\d.-]/g, '')) || 0;
        var chequeAmount = parseFloat($(this).find('td:nth-child(7)').text().replace(/[^\d.-]/g, '')) || 0;
        var onlineAmount = parseFloat($(this).find('td:nth-child(8)').text().replace(/[^\d.-]/g, '')) || 0;
        
        totalCash += cashAmount;
        totalCard += cardAmount;
        totalCheque += chequeAmount;
        totalOnline += onlineAmount;
    });
    
    grandTotal = totalCash + totalCard + totalCheque + totalOnline;
    
    // Store totals globally
    window.reportTotals = {
        cash: totalCash,
        card: totalCard,
        cheque: totalCheque,
        online: totalOnline,
        grand: grandTotal
    };
}

// Add summary section
function addSummarySection() {
    if (!window.reportTotals) return;
    
    var summaryHtml = `
        <div class="summary-section">
            <h3 class="summary-title">
                <i class="fas fa-chart-pie"></i>
                Payment Summary
            </h3>
            <div class="summary-grid">
                <div class="summary-card">
                    <div class="summary-icon cash">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="summary-content">
                        <div class="summary-label">Cash Payments</div>
                        <div class="summary-value">$${window.reportTotals.cash.toLocaleString()}</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon card">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="summary-content">
                        <div class="summary-label">Card Payments</div>
                        <div class="summary-value">$${window.reportTotals.card.toLocaleString()}</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon cheque">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="summary-content">
                        <div class="summary-label">Cheque Payments</div>
                        <div class="summary-value">$${window.reportTotals.cheque.toLocaleString()}</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon online">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div class="summary-content">
                        <div class="summary-label">Online Payments</div>
                        <div class="summary-value">$${window.reportTotals.online.toLocaleString()}</div>
                    </div>
                </div>
                <div class="summary-card grand-total">
                    <div class="summary-icon total">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <div class="summary-content">
                        <div class="summary-label">Grand Total</div>
                        <div class="summary-value">$${window.reportTotals.grand.toLocaleString()}</div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    $('.results-section').prepend(summaryHtml);
}

// Reset form
function resetForm() {
    $('#dayBookForm')[0].reset();
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
    showAlert('Preparing Excel export...', 'info');
    
    // Create CSV content
    var csvContent = "data:text/csv;charset=utf-8,";
    
    // Add headers
    var headers = [];
    $('.data-table thead th').each(function() {
        headers.push('"' + $(this).text().replace(/"/g, '""') + '"');
    });
    csvContent += headers.join(',') + '\n';
    
    // Add data rows
    $('.data-table tbody tr:visible').each(function() {
        var row = [];
        $(this).find('td').each(function() {
            row.push('"' + $(this).text().replace(/"/g, '""') + '"');
        });
        csvContent += row.join(',') + '\n';
    });
    
    // Add summary
    if (window.reportTotals) {
        csvContent += '\n"Summary"\n';
        csvContent += '"Cash Payments","$' + window.reportTotals.cash.toLocaleString() + '"\n';
        csvContent += '"Card Payments","$' + window.reportTotals.card.toLocaleString() + '"\n';
        csvContent += '"Cheque Payments","$' + window.reportTotals.cheque.toLocaleString() + '"\n';
        csvContent += '"Online Payments","$' + window.reportTotals.online.toLocaleString() + '"\n';
        csvContent += '"Grand Total","$' + window.reportTotals.grand.toLocaleString() + '"\n';
    }
    
    // Download file
    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "daybook_report.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    setTimeout(function() {
        showAlert('Excel export completed', 'success');
    }, 2000);
}

// Original AJAX function for location (keeping legacy functionality)
function ajaxlocationfunction(val) {
    var xmlhttp;
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

// Original customer name function (keeping legacy functionality)
function cbcustomername1() {
    document.cbform1.submit();
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
        
        // Ctrl + F to focus search
        if (e.ctrlKey && e.keyCode === 70) {
            e.preventDefault();
            $('#reportSearch').focus();
        }
        
        // Escape to close sidebar
        if (e.keyCode === 27) {
            $('#leftSidebar').addClass('collapsed');
        }
    });
}

// Initialize all enhancements
$(document).ready(function() {
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

// Add custom CSS for summary section
function addSummaryStyles() {
    var styles = `
        <style>
        .summary-section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            border: 1px solid #e9ecef;
        }
        
        .summary-title {
            font-size: 1.5rem;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .summary-title i {
            color: #3498db;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        
        .summary-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
        }
        
        .summary-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .summary-card.grand-total {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
        }
        
        .summary-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .summary-icon.cash { background: rgba(46, 204, 113, 0.2); color: #27ae60; }
        .summary-icon.card { background: rgba(52, 152, 219, 0.2); color: #3498db; }
        .summary-icon.cheque { background: rgba(241, 196, 15, 0.2); color: #f39c12; }
        .summary-icon.online { background: rgba(155, 89, 182, 0.2); color: #9b59b6; }
        .summary-icon.total { background: rgba(255, 255, 255, 0.2); color: white; }
        
        .summary-label {
            font-size: 0.9rem;
            color: #7f8c8d;
            margin-bottom: 0.25rem;
        }
        
        .summary-card.grand-total .summary-label {
            color: rgba(255, 255, 255, 0.8);
        }
        
        .summary-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
        }
        
        .summary-card.grand-total .summary-value {
            color: white;
        }
        </style>
    `;
    
    $('head').append(styles);
}

// Initialize summary styles
$(document).ready(function() {
    addSummaryStyles();
});

// Error handling
window.addEventListener('error', function(e) {
    console.error('Day Book Report Error:', e.error);
    showAlert('An error occurred. Please refresh the page.', 'error');
});

// Performance monitoring
window.addEventListener('load', function() {
    console.log('Day Book Report page loaded successfully');
    
    // Log performance metrics
    if (window.performance && window.performance.timing) {
        var loadTime = window.performance.timing.loadEventEnd - window.performance.timing.navigationStart;
        console.log('Page load time:', loadTime + 'ms');
    }
});

