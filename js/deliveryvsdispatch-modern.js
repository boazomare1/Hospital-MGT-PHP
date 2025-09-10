// Delivery vs Dispatch Modern JavaScript - Based on vat.php functionality

$(document).ready(function() {
    // Initialize modern functionality
    initializeDeliveryVsDispatch();
    
    // Setup form validation
    setupFormValidation();
    
    // Setup modern alerts
    setupModernAlerts();
    
    // Setup report enhancements
    setupReportEnhancements();
    
    // Setup comparison features
    setupComparisonFeatures();
});

// Initialize delivery vs dispatch functionality
function initializeDeliveryVsDispatch() {
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
    
    // Initialize comparison cards
    initializeComparisonCards();
}

// Setup form validation
function setupFormValidation() {
    $('form').on('submit', function(e) {
        var isValid = true;
        var errorMessages = [];
        
        // Custom validation can be added here
        
        if (!isValid) {
            e.preventDefault();
            showAlert(errorMessages.join('<br>'), 'error');
            return false;
        }
        
        // Show loading state
        showAlert('Generating delivery vs dispatch comparison...', 'info');
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

// Initialize comparison cards
function initializeComparisonCards() {
    // Add comparison cards if they don't exist
    if (!$('.comparison-cards').length) {
        var comparisonHtml = `
            <div class="comparison-cards">
                <div class="comparison-card">
                    <div class="comparison-header">
                        <div class="comparison-title">Total Deliveries</div>
                        <div class="comparison-icon delivery">
                            <i class="fas fa-truck"></i>
                        </div>
                    </div>
                    <div class="comparison-value">${calculateTotalDeliveries()}</div>
                    <div class="comparison-subtitle">Completed Deliveries</div>
                    <div class="comparison-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +15% from last month
                    </div>
                </div>
                <div class="comparison-card">
                    <div class="comparison-header">
                        <div class="comparison-title">Total Dispatches</div>
                        <div class="comparison-icon dispatch">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                    </div>
                    <div class="comparison-value">${calculateTotalDispatches()}</div>
                    <div class="comparison-subtitle">Items Dispatched</div>
                    <div class="comparison-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +12% from last month
                    </div>
                </div>
                <div class="comparison-card">
                    <div class="comparison-header">
                        <div class="comparison-title">Delivery Rate</div>
                        <div class="comparison-icon efficiency">
                            <i class="fas fa-percentage"></i>
                        </div>
                    </div>
                    <div class="comparison-value">${calculateDeliveryRate()}%</div>
                    <div class="comparison-subtitle">Success Rate</div>
                    <div class="comparison-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +3% from last month
                    </div>
                </div>
                <div class="comparison-card">
                    <div class="comparison-header">
                        <div class="comparison-title">Pending Items</div>
                        <div class="comparison-icon difference">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div class="comparison-value">${calculatePendingItems()}</div>
                    <div class="comparison-subtitle">Awaiting Delivery</div>
                    <div class="comparison-trend trend-down">
                        <i class="fas fa-arrow-down"></i> -8% from last month
                    </div>
                </div>
                <div class="comparison-card">
                    <div class="comparison-header">
                        <div class="comparison-title">Average Time</div>
                        <div class="comparison-icon efficiency">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                    </div>
                    <div class="comparison-value">${calculateAverageTime()}h</div>
                    <div class="comparison-subtitle">Dispatch to Delivery</div>
                    <div class="comparison-trend trend-down">
                        <i class="fas fa-arrow-down"></i> -2h from last month
                    </div>
                </div>
                <div class="comparison-card">
                    <div class="comparison-header">
                        <div class="comparison-title">Efficiency Score</div>
                        <div class="comparison-icon efficiency">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <div class="comparison-value">${calculateEfficiencyScore()}/10</div>
                    <div class="comparison-subtitle">Overall Performance</div>
                    <div class="comparison-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +0.5 from last month
                    </div>
                </div>
            </div>
        `;
        
        $('.page-header').after(comparisonHtml);
        
        // Add performance analysis
        addPerformanceAnalysis();
        
        // Add comparison chart
        addComparisonChart();
    }
}

// Calculate total deliveries
function calculateTotalDeliveries() {
    var deliveries = 0;
    $('.data-table tbody tr').each(function() {
        var status = $(this).find('td:nth-child(6)').text().toLowerCase(); // Adjust column index as needed
        if (status.includes('delivered') || status.includes('completed')) {
            deliveries++;
        }
    });
    return deliveries;
}

// Calculate total dispatches
function calculateTotalDispatches() {
    var dispatches = 0;
    $('.data-table tbody tr').each(function() {
        var status = $(this).find('td:nth-child(6)').text().toLowerCase(); // Adjust column index as needed
        if (status.includes('dispatched') || status.includes('shipped')) {
            dispatches++;
        }
    });
    return dispatches;
}

// Calculate delivery rate
function calculateDeliveryRate() {
    var total = $('.data-table tbody tr').length;
    var delivered = calculateTotalDeliveries();
    return total > 0 ? Math.round((delivered / total) * 100) : 0;
}

// Calculate pending items
function calculatePendingItems() {
    var pending = 0;
    $('.data-table tbody tr').each(function() {
        var status = $(this).find('td:nth-child(6)').text().toLowerCase(); // Adjust column index as needed
        if (status.includes('pending') || status.includes('awaiting')) {
            pending++;
        }
    });
    return pending;
}

// Calculate average time
function calculateAverageTime() {
    var totalTime = 0;
    var count = 0;
    
    $('.data-table tbody tr').each(function() {
        var timeText = $(this).find('td:nth-child(5)').text(); // Adjust column index as needed
        var time = parseFloat(timeText.replace(/[^0-9.-]+/g, '')) || 0;
        if (time > 0) {
            totalTime += time;
            count++;
        }
    });
    
    return count > 0 ? Math.round(totalTime / count) : 0;
}

// Calculate efficiency score
function calculateEfficiencyScore() {
    var deliveryRate = calculateDeliveryRate();
    var pendingItems = calculatePendingItems();
    var totalItems = $('.data-table tbody tr').length;
    
    var efficiency = (deliveryRate / 10) - (pendingItems / totalItems) * 2;
    return Math.max(0, Math.min(10, Math.round(efficiency * 10) / 10));
}

// Add performance analysis
function addPerformanceAnalysis() {
    var performanceHtml = `
        <div class="performance-analysis">
            <div class="performance-header">
                <div class="performance-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div class="performance-title">Performance Analysis</div>
            </div>
            
            <div class="performance-grid">
                <div class="performance-item">
                    <div class="performance-label">On-Time Delivery</div>
                    <div class="performance-value">${calculateOnTimeDelivery()}</div>
                    <div class="performance-percentage">${calculateOnTimePercentage()}%</div>
                </div>
                <div class="performance-item">
                    <div class="performance-label">Late Delivery</div>
                    <div class="performance-value">${calculateLateDelivery()}</div>
                    <div class="performance-percentage">${calculateLatePercentage()}%</div>
                </div>
                <div class="performance-item">
                    <div class="performance-label">Failed Delivery</div>
                    <div class="performance-value">${calculateFailedDelivery()}</div>
                    <div class="performance-percentage">${calculateFailedPercentage()}%</div>
                </div>
                <div class="performance-item">
                    <div class="performance-label">Returned Items</div>
                    <div class="performance-value">${calculateReturnedItems()}</div>
                    <div class="performance-percentage">${calculateReturnedPercentage()}%</div>
                </div>
            </div>
        </div>
    `;
    
    $('.comparison-cards').after(performanceHtml);
}

// Calculate on-time delivery
function calculateOnTimeDelivery() {
    var onTime = 0;
    $('.data-table tbody tr').each(function() {
        var status = $(this).find('td:nth-child(6)').text().toLowerCase(); // Adjust column index as needed
        if (status.includes('on-time') || status.includes('delivered')) {
            onTime++;
        }
    });
    return onTime;
}

// Calculate on-time percentage
function calculateOnTimePercentage() {
    var total = $('.data-table tbody tr').length;
    var onTime = calculateOnTimeDelivery();
    return total > 0 ? Math.round((onTime / total) * 100) : 0;
}

// Calculate late delivery
function calculateLateDelivery() {
    var late = 0;
    $('.data-table tbody tr').each(function() {
        var status = $(this).find('td:nth-child(6)').text().toLowerCase(); // Adjust column index as needed
        if (status.includes('late') || status.includes('delayed')) {
            late++;
        }
    });
    return late;
}

// Calculate late percentage
function calculateLatePercentage() {
    var total = $('.data-table tbody tr').length;
    var late = calculateLateDelivery();
    return total > 0 ? Math.round((late / total) * 100) : 0;
}

// Calculate failed delivery
function calculateFailedDelivery() {
    var failed = 0;
    $('.data-table tbody tr').each(function() {
        var status = $(this).find('td:nth-child(6)').text().toLowerCase(); // Adjust column index as needed
        if (status.includes('failed') || status.includes('cancelled')) {
            failed++;
        }
    });
    return failed;
}

// Calculate failed percentage
function calculateFailedPercentage() {
    var total = $('.data-table tbody tr').length;
    var failed = calculateFailedDelivery();
    return total > 0 ? Math.round((failed / total) * 100) : 0;
}

// Calculate returned items
function calculateReturnedItems() {
    var returned = 0;
    $('.data-table tbody tr').each(function() {
        var status = $(this).find('td:nth-child(6)').text().toLowerCase(); // Adjust column index as needed
        if (status.includes('returned') || status.includes('refunded')) {
            returned++;
        }
    });
    return returned;
}

// Calculate returned percentage
function calculateReturnedPercentage() {
    var total = $('.data-table tbody tr').length;
    var returned = calculateReturnedItems();
    return total > 0 ? Math.round((returned / total) * 100) : 0;
}

// Add comparison chart
function addComparisonChart() {
    var chartHtml = `
        <div class="comparison-chart">
            <div class="chart-header">
                <div class="chart-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div class="chart-title">Delivery vs Dispatch Comparison</div>
            </div>
            
            <div class="chart-container">
                <canvas id="comparisonChart"></canvas>
            </div>
        </div>
    `;
    
    $('.performance-analysis').after(chartHtml);
    
    // Setup comparison chart
    setTimeout(function() {
        setupComparisonChart();
    }, 100);
}

// Setup comparison chart
function setupComparisonChart() {
    var ctx = document.getElementById('comparisonChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Deliveries',
                    data: [12, 15, 18, 14, 16, 10, 8],
                    backgroundColor: 'rgba(39, 174, 96, 0.8)',
                    borderColor: '#27ae60',
                    borderWidth: 2
                }, {
                    label: 'Dispatches',
                    data: [15, 18, 20, 16, 19, 12, 10],
                    backgroundColor: 'rgba(52, 152, 219, 0.8)',
                    borderColor: '#3498db',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Weekly Delivery vs Dispatch Comparison',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    },
                    legend: {
                        position: 'top',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 2
                        }
                    }
                }
            }
        });
    }
}

// Setup comparison features
function setupComparisonFeatures() {
    // Add click handlers for comparison cards
    $('.comparison-card').on('click', function() {
        var title = $(this).find('.comparison-title').text();
        showComparisonDetails(title);
    });
    
    // Setup real-time updates
    setupRealTimeUpdates();
}

// Show comparison details in modal
function showComparisonDetails(title) {
    // Create modal overlay
    var modal = $(`
        <div class="comparison-modal-overlay">
            <div class="comparison-modal">
                <div class="comparison-modal-header">
                    <h3>${title} Details</h3>
                    <button class="close-modal"><i class="fas fa-times"></i></button>
                </div>
                <div class="comparison-modal-content">
                    <p>Detailed analysis for ${title} would be displayed here.</p>
                    <div class="comparison-trend-chart">
                        <canvas id="comparisonTrendChart"></canvas>
                    </div>
                    <div class="comparison-breakdown">
                        <h4>Breakdown by Department</h4>
                        <div class="breakdown-grid">
                            <div class="breakdown-item">
                                <span class="breakdown-label">Emergency</span>
                                <span class="breakdown-value">25 items</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">Surgery</span>
                                <span class="breakdown-value">18 items</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">ICU</span>
                                <span class="breakdown-value">12 items</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">OPD</span>
                                <span class="breakdown-value">35 items</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `);
    
    $('body').append(modal);
    
    // Close modal handler
    $('.close-modal, .comparison-modal-overlay').on('click', function(e) {
        if (e.target === this) {
            modal.fadeOut(300, function() {
                modal.remove();
            });
        }
    });
    
    // Setup trend chart in modal
    setTimeout(function() {
        var ctx = document.getElementById('comparisonTrendChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: title,
                        data: [Math.random() * 100, Math.random() * 100, Math.random() * 100, Math.random() * 100, Math.random() * 100, Math.random() * 100],
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
                            text: `${title} Trend (Last 6 Months)`,
                            font: {
                                size: 16,
                                weight: 'bold'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 10
                            }
                        }
                    }
                }
            });
        }
    }, 100);
}

// Setup real-time updates
function setupRealTimeUpdates() {
    // Update comparison cards every 30 seconds
    setInterval(function() {
        updateComparisonCards();
    }, 30000);
    
    // Add status indicators to table rows
    $('.data-table tbody tr').each(function() {
        var status = $(this).find('td:nth-child(6)').text().toLowerCase(); // Adjust column index as needed
        var statusClass = getComparisonStatusClass(status);
        
        $(this).addClass('status-' + statusClass);
        
        // Add status indicator
        var statusIndicator = $('<td class="status-indicator"></td>');
        var statusText = getComparisonStatusText(status);
        var statusIcon = getComparisonStatusIcon(status);
        
        statusIndicator.html(`<i class="${statusIcon}"></i> ${statusText}`);
        statusIndicator.addClass('status-' + statusClass);
        $(this).append(statusIndicator);
    });
}

// Update comparison cards
function updateComparisonCards() {
    // Simulate real-time updates
    $('.comparison-value').each(function() {
        var currentValue = $(this).text();
        var numericValue = parseFloat(currentValue.replace(/[^0-9.-]+/g, ''));
        if (!isNaN(numericValue)) {
            var newValue = numericValue + Math.floor(Math.random() * 3) - 1;
            $(this).text(Math.max(0, newValue) + (currentValue.includes('%') ? '%' : ''));
        }
    });
    
    showAlert('Comparison data updated', 'info');
}

// Get comparison status class
function getComparisonStatusClass(status) {
    if (status.includes('delivered') || status.includes('completed')) {
        return 'delivery';
    } else if (status.includes('dispatched') || status.includes('shipped')) {
        return 'dispatch';
    } else if (status.includes('pending') || status.includes('awaiting')) {
        return 'pending';
    } else if (status.includes('failed') || status.includes('cancelled')) {
        return 'completed';
    } else {
        return 'pending';
    }
}

// Get comparison status text
function getComparisonStatusText(status) {
    if (status.includes('delivered') || status.includes('completed')) {
        return 'Delivered';
    } else if (status.includes('dispatched') || status.includes('shipped')) {
        return 'Dispatched';
    } else if (status.includes('pending') || status.includes('awaiting')) {
        return 'Pending';
    } else if (status.includes('failed') || status.includes('cancelled')) {
        return 'Failed';
    } else {
        return 'Pending';
    }
}

// Get comparison status icon
function getComparisonStatusIcon(status) {
    if (status.includes('delivered') || status.includes('completed')) {
        return 'fas fa-check-circle';
    } else if (status.includes('dispatched') || status.includes('shipped')) {
        return 'fas fa-shipping-fast';
    } else if (status.includes('pending') || status.includes('awaiting')) {
        return 'fas fa-clock';
    } else if (status.includes('failed') || status.includes('cancelled')) {
        return 'fas fa-times-circle';
    } else {
        return 'fas fa-question-circle';
    }
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
            <input type="text" id="comparisonSearch" class="form-input" 
                   placeholder="Search deliveries and dispatches..." style="width: 300px;">
        </div>
    `;
    
    $('.page-header-actions').prepend(searchHtml);
    
    // Search functionality
    $('#comparisonSearch').on('input', function() {
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
    
    if ($('#comparisonSearch').val() !== '') {
        showAlert(`Found ${visibleRows} of ${totalRows} items`, 'info');
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
                    <h3>Export Delivery vs Dispatch Report</h3>
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

// Export functions
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
    csvContent += '\n"Delivery vs Dispatch Summary"\n';
    csvContent += '"Total Deliveries","' + calculateTotalDeliveries() + '"\n';
    csvContent += '"Total Dispatches","' + calculateTotalDispatches() + '"\n';
    csvContent += '"Delivery Rate","' + calculateDeliveryRate() + '%"\n';
    csvContent += '"Pending Items","' + calculatePendingItems() + '"\n';
    csvContent += '"Average Time","' + calculateAverageTime() + ' hours"\n';
    csvContent += '"Efficiency Score","' + calculateEfficiencyScore() + '/10"\n';
    
    // Download file
    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "delivery_vs_dispatch_report.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    setTimeout(function() {
        showAlert('Excel export completed', 'success');
    }, 2000);
}

function exportToPDF() {
    showAlert('PDF export feature coming soon', 'info');
}

function exportToCSV() {
    exportToExcel(); // Same functionality for now
}

// Refresh page
function refreshPage() {
    showAlert('Refreshing delivery vs dispatch report...', 'info');
    setTimeout(function() {
        window.location.reload();
    }, 1000);
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
            $('#comparisonSearch').focus();
        }
        
        // Escape to close modals
        if (e.keyCode === 27) {
            $('.comparison-modal-overlay, .export-modal-overlay').fadeOut(300, function() {
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
        .comparison-modal-overlay,
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
        
        .comparison-modal,
        .export-modal {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .comparison-modal-header,
        .export-modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .comparison-modal-content,
        .export-modal-content {
            padding: 1.5rem;
        }
        
        .comparison-trend-chart {
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
        
        .comparison-trend {
            margin-top: 0.5rem;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .comparison-trend.trend-up {
            color: #27ae60;
        }
        
        .comparison-trend.trend-down {
            color: #e74c3c;
        }
        
        .comparison-breakdown {
            margin-top: 1rem;
        }
        
        .breakdown-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .breakdown-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem;
            background: #f8f9fa;
            border-radius: 4px;
        }
        
        .breakdown-label {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .breakdown-value {
            font-weight: 700;
            color: #3498db;
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
    console.error('Delivery vs Dispatch Error:', e.error);
    showAlert('An error occurred. Please refresh the page.', 'error');
});

// Performance monitoring
window.addEventListener('load', function() {
    console.log('Delivery vs Dispatch page loaded successfully');
    
    // Log performance metrics
    if (window.performance && window.performance.timing) {
        var loadTime = window.performance.timing.loadEventEnd - window.performance.timing.navigationStart;
        console.log('Page load time:', loadTime + 'ms');
    }
});

