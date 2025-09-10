// Daily KPI Report Modern JavaScript - Based on vat.php functionality

$(document).ready(function() {
    // Initialize modern functionality
    initializeModernFeatures();
    
    // Setup form validation
    setupFormValidation();
    
    // Setup responsive sidebar
    setupResponsiveSidebar();
    
    // Setup modern alerts
    setupModernAlerts();
    
    // Setup KPI enhancements
    setupKPIEnhancements();
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
    $('#kpiReportForm').on('submit', function(e) {
        var isValid = true;
        var errorMessages = [];
        
        // Validate location
        if ($('#locationcode').val() === '') {
            errorMessages.push('Please select a location');
            $('#locationcode').addClass('error');
            isValid = false;
        } else {
            $('#locationcode').removeClass('error');
        }
        
        // Validate date
        if ($('#ADate1').val() === '') {
            errorMessages.push('Please select a report date');
            $('#ADate1').addClass('error');
            isValid = false;
        } else {
            $('#ADate1').removeClass('error');
        }
        
        if (!isValid) {
            e.preventDefault();
            showAlert(errorMessages.join('<br>'), 'error');
            return false;
        }
        
        // Show loading state
        showAlert('Generating KPI report...', 'info');
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

// Setup KPI enhancements
function setupKPIEnhancements() {
    // Add performance indicators to KPI values
    addPerformanceIndicators();
    
    // Setup table enhancements
    setupTableEnhancements();
    
    // Setup chart enhancements if charts are present
    setupChartEnhancements();
}

// Add performance indicators
function addPerformanceIndicators() {
    $('table td').each(function() {
        var text = $(this).text().trim();
        var value = parseFloat(text.replace(/[^\d.-]/g, ''));
        
        if (!isNaN(value) && value > 0) {
            var indicator = getPerformanceIndicator(value, text);
            if (indicator) {
                $(this).append(' <span class="performance-indicator ' + indicator.class + '">' + indicator.text + '</span>');
            }
        }
    });
}

// Get performance indicator based on value
function getPerformanceIndicator(value, text) {
    // This is a simplified example - you would customize based on your KPI metrics
    if (text.includes('%')) {
        if (value >= 90) return { class: 'performance-excellent', text: 'Excellent' };
        if (value >= 75) return { class: 'performance-good', text: 'Good' };
        if (value >= 50) return { class: 'performance-average', text: 'Average' };
        return { class: 'performance-poor', text: 'Poor' };
    }
    
    if (text.includes('$') || text.includes('Revenue')) {
        if (value >= 100000) return { class: 'performance-excellent', text: 'High' };
        if (value >= 50000) return { class: 'performance-good', text: 'Good' };
        if (value >= 10000) return { class: 'performance-average', text: 'Average' };
        return { class: 'performance-poor', text: 'Low' };
    }
    
    return null;
}

// Setup table enhancements
function setupTableEnhancements() {
    // Add hover effects to table rows
    $('table tbody tr').hover(
        function() {
            $(this).addClass('hover');
        },
        function() {
            $(this).removeClass('hover');
        }
    );
    
    // Add sorting functionality to table headers
    $('table th').each(function() {
        if ($(this).text().trim() !== '') {
            $(this).addClass('sortable');
            $(this).append(' <i class="fas fa-sort sort-icon"></i>');
        }
    });
    
    // Add click handlers for sorting
    $('table th.sortable').on('click', function() {
        var column = $(this).index();
        var table = $(this).closest('table');
        var rows = table.find('tbody tr').toArray();
        
        // Simple sorting logic (you might want to use a more sophisticated sorting library)
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
        $('table th .sort-icon').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort');
        $(this).find('.sort-icon').removeClass('fa-sort').addClass('fa-sort-up');
    });
}

// Setup chart enhancements
function setupChartEnhancements() {
    // If you have charts, you can add enhancements here
    // For example, adding tooltips, animations, etc.
    
    // Example: Add click handlers to chart elements
    $('.chart-container').on('click', function() {
        $(this).addClass('chart-selected');
        setTimeout(() => {
            $(this).removeClass('chart-selected');
        }, 2000);
    });
}

// Reset form
function resetForm() {
    $('#kpiReportForm')[0].reset();
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
    var locationcode = $('#locationcode').val();
    var date = $('#ADate1').val();
    
    if (!locationcode) {
        showAlert('Please select a location first', 'error');
        return;
    }
    
    if (!date) {
        showAlert('Please select a date first', 'error');
        return;
    }
    
    var exportUrl = `xl_dailykpireport.php?ADate1=${date}&locationcode=${locationcode}`;
    
    showAlert('Preparing Excel export...', 'info');
    
    // Create temporary link and click it
    var link = document.createElement('a');
    link.href = exportUrl;
    link.download = 'daily_kpi_report.xls';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    setTimeout(function() {
        showAlert('Excel export completed', 'success');
    }, 2000);
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
        
        // Escape to close sidebar
        if (e.keyCode === 27) {
            $('#leftSidebar').addClass('collapsed');
        }
    });
}

// Initialize all enhancements
$(document).ready(function() {
    setupDatePickerEnhancements();
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

function formatNumber(number) {
    return new Intl.NumberFormat('en-US').format(number);
}

function formatPercentage(value) {
    return new Intl.NumberFormat('en-US', {
        style: 'percent',
        minimumFractionDigits: 1,
        maximumFractionDigits: 1
    }).format(value / 100);
}

// KPI calculation helpers
function calculateGrowthRate(current, previous) {
    if (previous === 0) return 0;
    return ((current - previous) / previous) * 100;
}

function getGrowthIndicator(growthRate) {
    if (growthRate > 10) return { class: 'performance-excellent', text: 'Strong Growth' };
    if (growthRate > 0) return { class: 'performance-good', text: 'Growth' };
    if (growthRate > -10) return { class: 'performance-average', text: 'Stable' };
    return { class: 'performance-poor', text: 'Decline' };
}

// Error handling
window.addEventListener('error', function(e) {
    console.error('JavaScript Error:', e.error);
    showAlert('An error occurred. Please refresh the page.', 'error');
});

// Performance monitoring
window.addEventListener('load', function() {
    console.log('Daily KPI Report page loaded successfully');
    
    // Log performance metrics
    if (window.performance && window.performance.timing) {
        var loadTime = window.performance.timing.loadEventEnd - window.performance.timing.navigationStart;
        console.log('Page load time:', loadTime + 'ms');
    }
});

