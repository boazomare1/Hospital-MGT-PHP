// Day to Day Flash Report Modern JavaScript - Based on vat.php functionality

$(document).ready(function() {
    // Initialize modern functionality
    initializeFlashReport();
    
    // Setup real-time updates
    setupRealTimeUpdates();
    
    // Setup flash metrics
    setupFlashMetrics();
    
    // Setup report enhancements
    setupReportEnhancements();
});

// Initialize flash report functionality
function initializeFlashReport() {
    // Add fade-in animation to main content
    $('.main-content').addClass('fade-in');
    
    // Setup tooltips for action buttons
    $('[title]').each(function() {
        $(this).tooltip({
            position: { my: "left+15 center", at: "right center" }
        });
    });
    
    // Add loading states to buttons
    $('.btn').on('click', function() {
        $(this).addClass('loading');
        setTimeout(() => {
            $(this).removeClass('loading');
        }, 2000);
    });
    
    // Initialize flash metrics with animations
    animateFlashMetrics();
}

// Setup real-time updates
function setupRealTimeUpdates() {
    // Update flash metrics every 30 seconds
    setInterval(function() {
        updateFlashMetrics();
    }, 30000);
    
    // Add real-time indicators
    addRealTimeIndicators();
    
    // Setup auto-refresh
    setupAutoRefresh();
}

// Update flash metrics with live data
function updateFlashMetrics() {
    $('.flash-metric-value').each(function() {
        var element = $(this);
        var currentValue = parseFloat(element.text().replace(/[^0-9.-]+/g, ""));
        
        // Simulate small random changes (±2%)
        var change = (Math.random() - 0.5) * 0.04 * currentValue;
        var newValue = Math.max(0, Math.round(currentValue + change));
        
        // Animate to new value
        animateValueChange(element, newValue);
    });
    
    // Update real-time indicators
    updateRealTimeIndicators();
}

// Animate value changes
function animateValueChange(element, newValue) {
    var currentValue = parseFloat(element.text().replace(/[^0-9.-]+/g, ""));
    var prefix = element.text().replace(/[0-9.-]+/g, "");
    var difference = newValue - currentValue;
    var steps = 20;
    var stepValue = difference / steps;
    var counter = 0;
    
    var timer = setInterval(function() {
        counter++;
        currentValue += stepValue;
        element.text(prefix + Math.round(currentValue).toLocaleString());
        
        if (counter >= steps) {
            element.text(prefix + newValue.toLocaleString());
            clearInterval(timer);
            
            // Add flash effect for changes
            element.addClass('value-updated');
            setTimeout(function() {
                element.removeClass('value-updated');
            }, 1000);
        }
    }, 50);
}

// Add real-time indicators
function addRealTimeIndicators() {
    $('.flash-metric-card').each(function() {
        var indicator = $('<div class="real-time-indicator"><i class="fas fa-circle"></i>LIVE</div>');
        $(this).find('.flash-metric-header').append(indicator);
    });
    
    // Animate indicators
    setInterval(function() {
        $('.real-time-indicator i').fadeOut(500).fadeIn(500);
    }, 2000);
}

// Update real-time indicators
function updateRealTimeIndicators() {
    $('.real-time-indicator').each(function() {
        $(this).addClass('updated');
        setTimeout(() => {
            $(this).removeClass('updated');
        }, 1000);
    });
}

// Setup auto-refresh
function setupAutoRefresh() {
    // Auto-refresh page every 5 minutes
    setInterval(function() {
        showAlert('Auto-refreshing flash report...', 'info');
        setTimeout(function() {
            window.location.reload();
        }, 2000);
    }, 300000); // 5 minutes
}

// Setup flash metrics
function setupFlashMetrics() {
    // Add click handlers for metric cards
    $('.flash-metric-card').on('click', function() {
        var title = $(this).find('.flash-metric-title').text();
        showMetricDetails(title);
    });
    
    // Setup metric comparisons
    setupMetricComparisons();
    
    // Setup trend indicators
    setupTrendIndicators();
}

// Show metric details in modal
function showMetricDetails(title) {
    // Create modal overlay
    var modal = $(`
        <div class="metric-modal-overlay">
            <div class="metric-modal">
                <div class="metric-modal-header">
                    <h3>${title} Details</h3>
                    <button class="close-modal"><i class="fas fa-times"></i></button>
                </div>
                <div class="metric-modal-content">
                    <p>Detailed information for ${title} would be displayed here.</p>
                    <div class="metric-trend-chart">
                        <canvas id="trendChart"></canvas>
                    </div>
                    <div class="metric-comparison">
                        <h4>Period Comparison</h4>
                        <div class="comparison-grid">
                            <div class="comparison-item">
                                <span class="comparison-label">Today</span>
                                <span class="comparison-value">125</span>
                            </div>
                            <div class="comparison-item">
                                <span class="comparison-label">Yesterday</span>
                                <span class="comparison-value">118</span>
                            </div>
                            <div class="comparison-item">
                                <span class="comparison-label">This Week</span>
                                <span class="comparison-value">856</span>
                            </div>
                            <div class="comparison-item">
                                <span class="comparison-label">Last Week</span>
                                <span class="comparison-value">792</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `);
    
    $('body').append(modal);
    
    // Close modal handler
    $('.close-modal, .metric-modal-overlay').on('click', function(e) {
        if (e.target === this) {
            modal.fadeOut(300, function() {
                modal.remove();
            });
        }
    });
    
    // Setup trend chart in modal
    setTimeout(function() {
        var ctx = document.getElementById('trendChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['6h ago', '5h ago', '4h ago', '3h ago', '2h ago', '1h ago', 'Now'],
                    datasets: [{
                        label: title,
                        data: [Math.random() * 100, Math.random() * 100, Math.random() * 100, Math.random() * 100, Math.random() * 100, Math.random() * 100, Math.random() * 100],
                        borderColor: '#3498db',
                        backgroundColor: 'rgba(52, 152, 219, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: `${title} Trend (Last 6 Hours)`,
                            font: {
                                size: 16,
                                weight: 'bold'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    }, 100);
}

// Setup metric comparisons
function setupMetricComparisons() {
    // Add comparison indicators to metric cards
    $('.flash-metric-card').each(function() {
        var comparison = $('<div class="metric-comparison-indicator"></div>');
        $(this).find('.flash-metric-subtitle').after(comparison);
        
        // Simulate comparison data
        var change = (Math.random() - 0.5) * 20; // -10% to +10%
        var changeText = change > 0 ? `+${change.toFixed(1)}%` : `${change.toFixed(1)}%`;
        var changeClass = change > 0 ? 'positive' : 'negative';
        
        comparison.html(`
            <span class="comparison-change ${changeClass}">
                <i class="fas fa-arrow-${change > 0 ? 'up' : 'down'}"></i>
                ${changeText}
            </span>
        `);
    });
}

// Setup trend indicators
function setupTrendIndicators() {
    // Add trend indicators to summary items
    $('.flash-summary-item').each(function() {
        var trend = $('<div class="trend-indicator"></div>');
        $(this).append(trend);
        
        // Simulate trend data
        var trendValue = Math.random();
        var trendClass = trendValue > 0.5 ? 'trend-up' : 'trend-down';
        var trendIcon = trendValue > 0.5 ? 'fa-arrow-up' : 'fa-arrow-down';
        
        trend.html(`<i class="fas ${trendIcon}"></i>`);
        trend.addClass(trendClass);
    });
}

// Setup report enhancements
function setupReportEnhancements() {
    // Setup table enhancements
    setupTableEnhancements();
    
    // Setup search functionality
    setupSearchFunctionality();
    
    // Setup export functionality
    setupExportFunctionality();
}

// Setup table enhancements
function setupTableEnhancements() {
    // Add hover effects to table rows
    $('.flash-report-table tbody tr').hover(
        function() {
            $(this).addClass('hover');
        },
        function() {
            $(this).removeClass('hover');
        }
    );
    
    // Add sorting functionality to table headers
    $('.flash-report-table th').each(function() {
        if ($(this).text().trim() !== '') {
            $(this).addClass('sortable');
            $(this).append(' <i class="fas fa-sort sort-icon"></i>');
        }
    });
    
    // Add click handlers for sorting
    $('.flash-report-table th.sortable').on('click', function() {
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
        $('.flash-report-table th .sort-icon').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort');
        $(this).find('.sort-icon').removeClass('fa-sort').addClass('fa-sort-up');
    });
}

// Setup search functionality
function setupSearchFunctionality() {
    // Add search input to page header
    var searchHtml = `
        <div class="search-container">
            <input type="text" id="flashSearch" class="form-input" 
                   placeholder="Search metrics..." style="width: 300px;">
        </div>
    `;
    
    $('.page-header-actions').prepend(searchHtml);
    
    // Search functionality
    $('#flashSearch').on('input', function() {
        var searchTerm = $(this).val().toLowerCase();
        
        $('.flash-metric-card').each(function() {
            var cardText = $(this).text().toLowerCase();
            if (cardText.includes(searchTerm) || searchTerm === '') {
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
    var visibleCards = $('.flash-metric-card:visible').length;
    var totalCards = $('.flash-metric-card').length;
    
    if ($('#flashSearch').val() !== '') {
        showAlert(`Found ${visibleCards} of ${totalCards} metrics`, 'info');
    }
}

// Setup export functionality
function setupExportFunctionality() {
    // Add export options
    $('.btn-outline').on('click', function() {
        if ($(this).text().includes('Export')) {
            showExportOptions();
        }
    });
}

// Show export options
function showExportOptions() {
    var exportModal = $(`
        <div class="export-modal-overlay">
            <div class="export-modal">
                <div class="export-modal-header">
                    <h3>Export Flash Report</h3>
                    <button class="close-modal"><i class="fas fa-times"></i></button>
                </div>
                <div class="export-modal-content">
                    <div class="export-options">
                        <button class="export-btn" onclick="exportToExcel()">
                            <i class="fas fa-file-excel"></i>
                            Export to Excel
                        </button>
                        <button class="export-btn" onclick="exportToPDF()">
                            <i class="fas fa-file-pdf"></i>
                            Export to PDF
                        </button>
                        <button class="export-btn" onclick="exportToCSV()">
                            <i class="fas fa-file-csv"></i>
                            Export to CSV
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `);
    
    $('body').append(exportModal);
    
    // Close modal handler
    $('.close-modal, .export-modal-overlay').on('click', function(e) {
        if (e.target === this) {
            exportModal.fadeOut(300, function() {
                exportModal.remove();
            });
        }
    });
}

// Export to Excel
function exportToExcel() {
    showAlert('Preparing Excel export...', 'info');
    
    // Create CSV content
    var csvContent = "data:text/csv;charset=utf-8,";
    
    // Add headers
    csvContent += "Metric,Value,Change,Status\n";
    
    // Add metric data
    $('.flash-metric-card').each(function() {
        var title = $(this).find('.flash-metric-title').text();
        var value = $(this).find('.flash-metric-value').text();
        var change = $(this).find('.comparison-change').text() || 'N/A';
        var status = 'Active';
        
        csvContent += `"${title}","${value}","${change}","${status}"\n`;
    });
    
    // Download file
    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "flash_report.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    setTimeout(function() {
        showAlert('Excel export completed', 'success');
    }, 2000);
}

// Export to PDF
function exportToPDF() {
    showAlert('PDF export feature coming soon', 'info');
}

// Export to CSV
function exportToCSV() {
    exportToExcel(); // Same functionality for now
}

// Refresh page
function refreshPage() {
    showAlert('Refreshing flash report...', 'info');
    setTimeout(function() {
        window.location.reload();
    }, 1000);
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

// Animate flash metrics on load
function animateFlashMetrics() {
    $('.flash-metric-card').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
        $(this).addClass('fade-in');
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
            showExportOptions();
        }
        
        // Ctrl + F to focus search
        if (e.ctrlKey && e.keyCode === 70) {
            e.preventDefault();
            $('#flashSearch').focus();
        }
        
        // Escape to close modals
        if (e.keyCode === 27) {
            $('.metric-modal-overlay, .export-modal-overlay').fadeOut(300, function() {
                $(this).remove();
            });
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

// Add custom CSS for modals and other dynamic elements
function addCustomStyles() {
    var styles = `
        <style>
        .metric-modal-overlay,
        .export-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }
        
        .metric-modal,
        .export-modal {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .metric-modal-header,
        .export-modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .metric-modal-content,
        .export-modal-content {
            padding: 1.5rem;
        }
        
        .metric-trend-chart {
            height: 300px;
            margin: 1rem 0;
        }
        
        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #999;
        }
        
        .metric-comparison-indicator {
            margin-top: 0.5rem;
        }
        
        .comparison-change {
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
        }
        
        .comparison-change.positive {
            background: rgba(46, 204, 113, 0.1);
            color: #27ae60;
        }
        
        .comparison-change.negative {
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
        }
        
        .trend-indicator {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            font-size: 1.2rem;
        }
        
        .trend-indicator.trend-up {
            color: #27ae60;
        }
        
        .trend-indicator.trend-down {
            color: #e74c3c;
        }
        
        .export-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
        }
        
        .export-btn {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }
        
        .export-btn:hover {
            background: #e9ecef;
            border-color: #3498db;
        }
        
        .value-updated {
            animation: flash 1s ease-in-out;
        }
        
        @keyframes flash {
            0%, 100% { background-color: transparent; }
            50% { background-color: rgba(52, 152, 219, 0.3); }
        }
        
        .search-container {
            position: relative;
        }
        
        .form-input {
            padding: 0.5rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }
        </style>
    `;
    
    $('head').append(styles);
}

// Initialize custom styles
$(document).ready(function() {
    addCustomStyles();
});

// Error handling
window.addEventListener('error', function(e) {
    console.error('Flash Report Error:', e.error);
    showAlert('An error occurred. Please refresh the page.', 'error');
});

// Performance monitoring
window.addEventListener('load', function() {
    console.log('Flash Report page loaded successfully');
    
    // Log performance metrics
    if (window.performance && window.performance.timing) {
        var loadTime = window.performance.timing.loadEventEnd - window.performance.timing.navigationStart;
        console.log('Page load time:', loadTime + 'ms');
    }
});

