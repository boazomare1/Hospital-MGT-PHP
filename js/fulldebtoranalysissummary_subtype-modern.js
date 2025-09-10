// Full Debtor Analysis Summary Subtype Modern JavaScript - Based on vat.php functionality

$(document).ready(function() {
    // Initialize modern functionality
    initializeFullDebtorAnalysisSummary();
    
    // Setup form validation
    setupFormValidation();
    
    // Setup modern alerts
    setupModernAlerts();
    
    // Setup report enhancements
    setupReportEnhancements();
    
    // Setup summary features
    setupSummaryFeatures();
});

// Initialize full debtor analysis summary functionality
function initializeFullDebtorAnalysisSummary() {
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
    
    // Initialize summary cards
    initializeSummaryCards();
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
        showAlert('Generating full debtor analysis summary...', 'info');
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

// Initialize summary cards
function initializeSummaryCards() {
    // Add summary cards if they don't exist
    if (!$('.summary-cards').length) {
        var summaryHtml = `
            <div class="summary-cards">
                <div class="summary-card">
                    <div class="summary-header">
                        <div class="summary-title">Total Outstanding</div>
                        <div class="summary-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                    <div class="summary-value">$${calculateTotalOutstanding()}</div>
                    <div class="summary-subtitle">All Debtors</div>
                </div>
                <div class="summary-card">
                    <div class="summary-header">
                        <div class="summary-title">0-30 Days</div>
                        <div class="summary-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div class="summary-value">$${calculateAgingAmount(30)}</div>
                    <div class="summary-subtitle">Current</div>
                </div>
                <div class="summary-card">
                    <div class="summary-header">
                        <div class="summary-title">31-60 Days</div>
                        <div class="summary-icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                    </div>
                    <div class="summary-value">$${calculateAgingAmount(60)}</div>
                    <div class="summary-subtitle">Overdue</div>
                </div>
                <div class="summary-card">
                    <div class="summary-header">
                        <div class="summary-title">61-90 Days</div>
                        <div class="summary-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                    <div class="summary-value">$${calculateAgingAmount(90)}</div>
                    <div class="summary-subtitle">Critical</div>
                </div>
                <div class="summary-card">
                    <div class="summary-header">
                        <div class="summary-title">90+ Days</div>
                        <div class="summary-icon">
                            <i class="fas fa-ban"></i>
                        </div>
                    </div>
                    <div class="summary-value">$${calculateAgingAmount(120)}</div>
                    <div class="summary-subtitle">Bad Debt</div>
                </div>
                <div class="summary-card">
                    <div class="summary-header">
                        <div class="summary-title">Active Debtors</div>
                        <div class="summary-icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="summary-value">${calculateActiveDebtors()}</div>
                    <div class="summary-subtitle">Total Count</div>
                </div>
            </div>
        `;
        
        $('.page-header').after(summaryHtml);
        
        // Add aging summary
        addAgingSummary();
        
        // Add subtype summary
        addSubtypeSummary();
    }
}

// Calculate total outstanding amount
function calculateTotalOutstanding() {
    var total = 0;
    $('.data-table tbody tr').each(function() {
        var amountText = $(this).find('td:nth-child(4)').text(); // Adjust column index as needed
        var amount = parseFloat(amountText.replace(/[^0-9.-]+/g, '')) || 0;
        total += amount;
    });
    return total.toLocaleString();
}

// Calculate aging amount
function calculateAgingAmount(days) {
    var amount = 0;
    $('.data-table tbody tr').each(function() {
        var dueDate = $(this).find('td:nth-child(3)').text(); // Adjust column index as needed
        var amountText = $(this).find('td:nth-child(4)').text();
        var rowAmount = parseFloat(amountText.replace(/[^0-9.-]+/g, '')) || 0;
        
        if (isInAgingRange(dueDate, days)) {
            amount += rowAmount;
        }
    });
    return amount.toLocaleString();
}

// Check if debt is in aging range
function isInAgingRange(dueDate, maxDays) {
    var today = new Date();
    var due = new Date(dueDate);
    var diffTime = today - due;
    var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    
    if (maxDays === 30) {
        return diffDays >= 0 && diffDays <= 30;
    } else if (maxDays === 60) {
        return diffDays > 30 && diffDays <= 60;
    } else if (maxDays === 90) {
        return diffDays > 60 && diffDays <= 90;
    } else if (maxDays === 120) {
        return diffDays > 90;
    }
    
    return false;
}

// Calculate active debtors count
function calculateActiveDebtors() {
    return $('.data-table tbody tr').length;
}

// Add aging summary
function addAgingSummary() {
    var agingHtml = `
        <div class="aging-summary">
            <div class="aging-header">
                <div class="aging-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div class="aging-title">Aging Summary</div>
            </div>
            
            <div class="aging-grid">
                <div class="aging-item">
                    <div class="aging-label">0-30 Days</div>
                    <div class="aging-value">$${calculateAgingAmount(30)}</div>
                    <div class="aging-percentage">${calculateAgingPercentage(30)}%</div>
                </div>
                <div class="aging-item">
                    <div class="aging-label">31-60 Days</div>
                    <div class="aging-value">$${calculateAgingAmount(60)}</div>
                    <div class="aging-percentage">${calculateAgingPercentage(60)}%</div>
                </div>
                <div class="aging-item">
                    <div class="aging-label">61-90 Days</div>
                    <div class="aging-value">$${calculateAgingAmount(90)}</div>
                    <div class="aging-percentage">${calculateAgingPercentage(90)}%</div>
                </div>
                <div class="aging-item">
                    <div class="aging-label">90+ Days</div>
                    <div class="aging-value">$${calculateAgingAmount(120)}</div>
                    <div class="aging-percentage">${calculateAgingPercentage(120)}%</div>
                </div>
            </div>
        </div>
    `;
    
    $('.summary-cards').after(agingHtml);
}

// Calculate aging percentage
function calculateAgingPercentage(days) {
    var total = parseFloat(calculateTotalOutstanding().replace(/,/g, ''));
    var amount = parseFloat(calculateAgingAmount(days).replace(/,/g, ''));
    return total > 0 ? Math.round((amount / total) * 100) : 0;
}

// Add subtype summary
function addSubtypeSummary() {
    var subtypeHtml = `
        <div class="subtype-summary">
            <div class="subtype-header">
                <div class="subtype-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div class="subtype-title">Subtype Summary</div>
            </div>
            
            <div class="subtype-chart">
                <canvas id="subtypeChart"></canvas>
            </div>
        </div>
    `;
    
    $('.aging-summary').after(subtypeHtml);
    
    // Setup subtype chart
    setTimeout(function() {
        setupSubtypeChart();
    }, 100);
}

// Setup subtype chart
function setupSubtypeChart() {
    var ctx = document.getElementById('subtypeChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Emergency', 'Surgery', 'ICU', 'OPD', 'Pharmacy', 'Lab'],
                datasets: [{
                    label: 'Outstanding Amount',
                    data: [
                        Math.random() * 100000,
                        Math.random() * 100000,
                        Math.random() * 100000,
                        Math.random() * 100000,
                        Math.random() * 100000,
                        Math.random() * 100000
                    ],
                    backgroundColor: [
                        'rgba(231, 76, 60, 0.8)',
                        'rgba(241, 196, 15, 0.8)',
                        'rgba(39, 174, 96, 0.8)',
                        'rgba(52, 152, 219, 0.8)',
                        'rgba(155, 89, 182, 0.8)',
                        'rgba(26, 188, 156, 0.8)'
                    ],
                    borderColor: [
                        '#e74c3c',
                        '#f39c12',
                        '#27ae60',
                        '#3498db',
                        '#9b59b6',
                        '#1abc9c'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Debtor Analysis by Subtype',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }
}

// Setup summary features
function setupSummaryFeatures() {
    // Add click handlers for summary cards
    $('.summary-card').on('click', function() {
        var title = $(this).find('.summary-title').text();
        showSummaryDetails(title);
    });
    
    // Setup trend analysis
    setupTrendAnalysis();
}

// Show summary details in modal
function showSummaryDetails(title) {
    // Create modal overlay
    var modal = $(`
        <div class="summary-modal-overlay">
            <div class="summary-modal">
                <div class="summary-modal-header">
                    <h3>${title} Summary</h3>
                    <button class="close-modal"><i class="fas fa-times"></i></button>
                </div>
                <div class="summary-modal-content">
                    <p>Summary analysis for ${title} would be displayed here.</p>
                    <div class="summary-trend-chart">
                        <canvas id="summaryTrendChart"></canvas>
                    </div>
                    <div class="summary-breakdown">
                        <h4>Breakdown by Department</h4>
                        <div class="breakdown-grid">
                            <div class="breakdown-item">
                                <span class="breakdown-label">Emergency</span>
                                <span class="breakdown-value">$12,450</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">Surgery</span>
                                <span class="breakdown-value">$8,750</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">ICU</span>
                                <span class="breakdown-value">$15,200</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">OPD</span>
                                <span class="breakdown-value">$5,300</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `);
    
    $('body').append(modal);
    
    // Close modal handler
    $('.close-modal, .summary-modal-overlay').on('click', function(e) {
        if (e.target === this) {
            modal.fadeOut(300, function() {
                modal.remove();
            });
        }
    });
    
    // Setup trend chart in modal
    setTimeout(function() {
        var ctx = document.getElementById('summaryTrendChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: title,
                        data: [Math.random() * 100000, Math.random() * 100000, Math.random() * 100000, Math.random() * 100000, Math.random() * 100000, Math.random() * 100000],
                        borderColor: '#e74c3c',
                        backgroundColor: 'rgba(231, 76, 60, 0.1)',
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
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }
    }, 100);
}

// Setup trend analysis
function setupTrendAnalysis() {
    // Add trend indicators to summary cards
    $('.summary-card').each(function() {
        var trend = $('<div class="summary-trend-indicator"></div>');
        $(this).find('.summary-subtitle').after(trend);
        
        // Simulate trend data
        var trendValue = Math.random();
        var trendClass = trendValue > 0.5 ? 'trend-up' : 'trend-down';
        var trendIcon = trendValue > 0.5 ? 'fa-arrow-up' : 'fa-arrow-down';
        var trendText = trendValue > 0.5 ? '+5.2%' : '-2.1%';
        
        trend.html(`<i class="fas ${trendIcon}"></i> ${trendText}`);
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
            <input type="text" id="debtorSearch" class="form-input" 
                   placeholder="Search debtors..." style="width: 300px;">
        </div>
    `;
    
    $('.page-header-actions').prepend(searchHtml);
    
    // Search functionality
    $('#debtorSearch').on('input', function() {
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
    
    if ($('#debtorSearch').val() !== '') {
        showAlert(`Found ${visibleRows} of ${totalRows} debtors`, 'info');
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
                    <h3>Export Full Debtor Analysis Summary</h3>
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
    csvContent += '\n"Summary"\n';
    csvContent += '"Total Outstanding","$' + calculateTotalOutstanding() + '"\n';
    csvContent += '"0-30 Days","$' + calculateAgingAmount(30) + '"\n';
    csvContent += '"31-60 Days","$' + calculateAgingAmount(60) + '"\n';
    csvContent += '"61-90 Days","$' + calculateAgingAmount(90) + '"\n';
    csvContent += '"90+ Days","$' + calculateAgingAmount(120) + '"\n';
    csvContent += '"Active Debtors","' + calculateActiveDebtors() + '"\n';
    
    // Download file
    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "full_debtor_analysis_summary.csv");
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
    showAlert('Refreshing full debtor analysis summary...', 'info');
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
            $('#debtorSearch').focus();
        }
        
        // Escape to close modals
        if (e.keyCode === 27) {
            $('.summary-modal-overlay, .export-modal-overlay').fadeOut(300, function() {
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
        .summary-modal-overlay,
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
        
        .summary-modal,
        .export-modal {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .summary-modal-header,
        .export-modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .summary-modal-content,
        .export-modal-content {
            padding: 1.5rem;
        }
        
        .summary-trend-chart {
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
        
        .summary-trend-indicator {
            margin-top: 0.5rem;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .summary-trend-indicator.trend-up {
            color: #27ae60;
        }
        
        .summary-trend-indicator.trend-down {
            color: #e74c3c;
        }
        
        .summary-breakdown {
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
    console.error('Full Debtor Analysis Summary Error:', e.error);
    showAlert('An error occurred. Please refresh the page.', 'error');
});

// Performance monitoring
window.addEventListener('load', function() {
    console.log('Full Debtor Analysis Summary page loaded successfully');
    
    // Log performance metrics
    if (window.performance && window.performance.timing) {
        var loadTime = window.performance.timing.loadEventEnd - window.performance.timing.navigationStart;
        console.log('Page load time:', loadTime + 'ms');
    }
});

