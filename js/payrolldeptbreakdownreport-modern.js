// Payroll Department Breakdown Report Modern JavaScript - Based on vat.php functionality

$(document).ready(function() {
    // Initialize modern functionality
    initializePayrollBreakdownReport();
    
    // Setup form validation
    setupFormValidation();
    
    // Setup modern alerts
    setupModernAlerts();
    
    // Setup report enhancements
    setupReportEnhancements();
    
    // Setup payroll breakdown management features
    setupPayrollBreakdownManagementFeatures();
});

// Initialize payroll breakdown report functionality
function initializePayrollBreakdownReport() {
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
    
    // Initialize payroll breakdown cards
    initializePayrollBreakdownCards();
}

// Setup form validation
function setupFormValidation() {
    $('form').on('submit', function(e) {
        var isValid = true;
        var errorMessages = [];
        
        // Validate month selection
        var searchmonth = $('#searchmonth').val();
        if (!searchmonth || searchmonth.trim() === '') {
            isValid = false;
            errorMessages.push('Month selection is required');
        }
        
        // Validate year selection
        var searchyear = $('#searchyear').val();
        if (!searchyear || searchyear.trim() === '') {
            isValid = false;
            errorMessages.push('Year selection is required');
        }
        
        // Validate employee search
        var searchemployee = $('#searchemployee').val();
        if (!searchemployee || searchemployee.trim() === '') {
            isValid = false;
            errorMessages.push('Employee search is required');
        }
        
        if (!isValid) {
            e.preventDefault();
            showAlert(errorMessages.join('<br>'), 'error');
            return false;
        }
        
        // Show loading state
        showAlert('Generating payroll breakdown report...', 'info');
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

// Initialize payroll breakdown cards
function initializePayrollBreakdownCards() {
    // Add payroll breakdown cards if they don't exist
    if (!$('.payroll-breakdown-cards').length) {
        var payrollBreakdownHtml = `
            <div class="payroll-breakdown-cards">
                <div class="payroll-breakdown-card">
                    <div class="payroll-breakdown-header">
                        <div class="payroll-breakdown-title">Total Breakdown</div>
                        <div class="payroll-breakdown-icon emergency">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                    </div>
                    <div class="payroll-breakdown-value">${calculateTotalBreakdown()}</div>
                    <div class="payroll-breakdown-subtitle">All Departments</div>
                    <div class="payroll-breakdown-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +7% this month
                    </div>
                </div>
                <div class="payroll-breakdown-card">
                    <div class="payroll-breakdown-header">
                        <div class="payroll-breakdown-title">Basic Salary</div>
                        <div class="payroll-breakdown-icon surgery">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                    <div class="payroll-breakdown-value">${calculateBasicSalary()}</div>
                    <div class="payroll-breakdown-subtitle">Monthly Basic</div>
                    <div class="payroll-breakdown-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +5% this month
                    </div>
                </div>
                <div class="payroll-breakdown-card">
                    <div class="payroll-breakdown-header">
                        <div class="payroll-breakdown-title">Allowances</div>
                        <div class="payroll-breakdown-icon icu">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                    </div>
                    <div class="payroll-breakdown-value">${calculateAllowances()}</div>
                    <div class="payroll-breakdown-subtitle">Total Allowances</div>
                    <div class="payroll-breakdown-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +3% this month
                    </div>
                </div>
                <div class="payroll-breakdown-card">
                    <div class="payroll-breakdown-header">
                        <div class="payroll-breakdown-title">Deductions</div>
                        <div class="payroll-breakdown-icon opd">
                            <i class="fas fa-minus-circle"></i>
                        </div>
                    </div>
                    <div class="payroll-breakdown-value">${calculateDeductions()}</div>
                    <div class="payroll-breakdown-subtitle">Total Deductions</div>
                    <div class="payroll-breakdown-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +2% this month
                    </div>
                </div>
                <div class="payroll-breakdown-card">
                    <div class="payroll-breakdown-header">
                        <div class="payroll-breakdown-title">Net Pay</div>
                        <div class="payroll-breakdown-icon pharmacy">
                            <i class="fas fa-calculator"></i>
                        </div>
                    </div>
                    <div class="payroll-breakdown-value">${calculateNetPay()}</div>
                    <div class="payroll-breakdown-subtitle">Final Amount</div>
                    <div class="payroll-breakdown-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +6% this month
                    </div>
                </div>
                <div class="payroll-breakdown-card">
                    <div class="payroll-breakdown-header">
                        <div class="payroll-breakdown-title">Tax Deduction</div>
                        <div class="payroll-breakdown-icon lab">
                            <i class="fas fa-receipt"></i>
                        </div>
                    </div>
                    <div class="payroll-breakdown-value">${calculateTaxDeduction()}</div>
                    <div class="payroll-breakdown-subtitle">Tax Amount</div>
                    <div class="payroll-breakdown-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +4% this month
                    </div>
                </div>
            </div>
        `;
        
        $('.page-header').after(payrollBreakdownHtml);
        
        // Add payroll breakdown management
        addPayrollBreakdownManagement();
    }
}

// Calculate total breakdown
function calculateTotalBreakdown() {
    var total = 0;
    $('.data-table tbody tr').each(function() {
        var amount = parseFloat($(this).find('td:nth-child(6)').text().replace(/[^\d.-]/g, '')) || 0; // Adjust column index as needed
        total += amount;
    });
    return formatCurrency(total);
}

// Calculate basic salary
function calculateBasicSalary() {
    var total = 0;
    $('.data-table tbody tr').each(function() {
        var amount = parseFloat($(this).find('td:nth-child(3)').text().replace(/[^\d.-]/g, '')) || 0; // Adjust column index as needed
        total += amount;
    });
    return formatCurrency(total);
}

// Calculate allowances
function calculateAllowances() {
    var total = 0;
    $('.data-table tbody tr').each(function() {
        var amount = parseFloat($(this).find('td:nth-child(4)').text().replace(/[^\d.-]/g, '')) || 0; // Adjust column index as needed
        total += amount;
    });
    return formatCurrency(total);
}

// Calculate deductions
function calculateDeductions() {
    var total = 0;
    $('.data-table tbody tr').each(function() {
        var amount = parseFloat($(this).find('td:nth-child(5)').text().replace(/[^\d.-]/g, '')) || 0; // Adjust column index as needed
        total += amount;
    });
    return formatCurrency(total);
}

// Calculate net pay
function calculateNetPay() {
    var total = 0;
    $('.data-table tbody tr').each(function() {
        var amount = parseFloat($(this).find('td:nth-child(6)').text().replace(/[^\d.-]/g, '')) || 0; // Adjust column index as needed
        total += amount;
    });
    return formatCurrency(total);
}

// Calculate tax deduction
function calculateTaxDeduction() {
    var total = 0;
    $('.data-table tbody tr').each(function() {
        var amount = parseFloat($(this).find('td:nth-child(7)').text().replace(/[^\d.-]/g, '')) || 0; // Adjust column index as needed
        total += amount;
    });
    return formatCurrency(total);
}

// Format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-IN', {
        style: 'currency',
        currency: 'INR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(amount);
}

// Add payroll breakdown management
function addPayrollBreakdownManagement() {
    var managementHtml = `
        <div class="payroll-breakdown-management">
            <div class="payroll-breakdown-management-header">
                <div class="payroll-breakdown-management-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div class="payroll-breakdown-management-title">Payroll Breakdown Analysis</div>
            </div>
            
            <div class="payroll-breakdown-management-grid">
                <div class="payroll-breakdown-management-item">
                    <div class="payroll-breakdown-management-label">Basic Salary</div>
                    <div class="payroll-breakdown-management-value">${calculatePayrollBreakdownCount('basic')}</div>
                    <div class="payroll-breakdown-management-percentage">${calculatePayrollBreakdownPercentage('basic')}%</div>
                </div>
                <div class="payroll-breakdown-management-item">
                    <div class="payroll-breakdown-management-label">Allowances</div>
                    <div class="payroll-breakdown-management-value">${calculatePayrollBreakdownCount('allowance')}</div>
                    <div class="payroll-breakdown-management-percentage">${calculatePayrollBreakdownPercentage('allowance')}%</div>
                </div>
                <div class="payroll-breakdown-management-item">
                    <div class="payroll-breakdown-management-label">Deductions</div>
                    <div class="payroll-breakdown-management-value">${calculatePayrollBreakdownCount('deduction')}</div>
                    <div class="payroll-breakdown-management-percentage">${calculatePayrollBreakdownPercentage('deduction')}%</div>
                </div>
                <div class="payroll-breakdown-management-item">
                    <div class="payroll-breakdown-management-label">Net Pay</div>
                    <div class="payroll-breakdown-management-value">${calculatePayrollBreakdownCount('net')}</div>
                    <div class="payroll-breakdown-management-percentage">${calculatePayrollBreakdownPercentage('net')}%</div>
                </div>
                <div class="payroll-breakdown-management-item">
                    <div class="payroll-breakdown-management-label">Tax</div>
                    <div class="payroll-breakdown-management-value">${calculatePayrollBreakdownCount('tax')}</div>
                    <div class="payroll-breakdown-management-percentage">${calculatePayrollBreakdownPercentage('tax')}%</div>
                </div>
                <div class="payroll-breakdown-management-item">
                    <div class="payroll-breakdown-management-label">Total</div>
                    <div class="payroll-breakdown-management-value">${calculatePayrollBreakdownCount('total')}</div>
                    <div class="payroll-breakdown-management-percentage">${calculatePayrollBreakdownPercentage('total')}%</div>
                </div>
            </div>
        </div>
    `;
    
    $('.payroll-breakdown-cards').after(managementHtml);
}

// Calculate payroll breakdown count by type
function calculatePayrollBreakdownCount(type) {
    var count = 0;
    $('.data-table tbody tr').each(function() {
        var dept = $(this).find('td:nth-child(1)').text().toLowerCase(); // Adjust column index as needed
        if (dept.includes(type)) {
            count++;
        }
    });
    return count;
}

// Calculate payroll breakdown percentage by type
function calculatePayrollBreakdownPercentage(type) {
    var total = $('.data-table tbody tr').length;
    var count = calculatePayrollBreakdownCount(type);
    return total > 0 ? Math.round((count / total) * 100) : 0;
}

// Setup payroll breakdown management features
function setupPayrollBreakdownManagementFeatures() {
    // Add click handlers for payroll breakdown cards
    $('.payroll-breakdown-card').on('click', function() {
        var title = $(this).find('.payroll-breakdown-title').text();
        showPayrollBreakdownDetails(title);
    });
    
    // Setup real-time updates
    setupRealTimeUpdates();
}

// Show payroll breakdown details in modal
function showPayrollBreakdownDetails(title) {
    // Create modal overlay
    var modal = $(`
        <div class="payroll-breakdown-modal-overlay">
            <div class="payroll-breakdown-modal">
                <div class="payroll-breakdown-modal-header">
                    <h3>${title} Details</h3>
                    <button class="close-modal"><i class="fas fa-times"></i></button>
                </div>
                <div class="payroll-breakdown-modal-content">
                    <p>Detailed analysis for ${title} would be displayed here.</p>
                    <div class="payroll-breakdown-trend-chart">
                        <canvas id="payrollBreakdownTrendChart"></canvas>
                    </div>
                    <div class="payroll-breakdown-breakdown">
                        <h4>Breakdown by Department</h4>
                        <div class="breakdown-grid">
                            <div class="breakdown-item">
                                <span class="breakdown-label">Emergency Department</span>
                                <span class="breakdown-value">₹1,45,000</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">Surgery Department</span>
                                <span class="breakdown-value">₹2,85,000</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">ICU Department</span>
                                <span class="breakdown-value">₹1,20,000</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">OPD Department</span>
                                <span class="breakdown-value">₹1,95,000</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `);
    
    $('body').append(modal);
    
    // Close modal handler
    $('.close-modal, .payroll-breakdown-modal-overlay').on('click', function(e) {
        if (e.target === this) {
            modal.fadeOut(300, function() {
                modal.remove();
            });
        }
    });
    
    // Setup trend chart in modal
    setTimeout(function() {
        var ctx = document.getElementById('payrollBreakdownTrendChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: title,
                        data: [Math.random() * 1000000, Math.random() * 1000000, Math.random() * 1000000, Math.random() * 1000000, Math.random() * 1000000, Math.random() * 1000000],
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
                                callback: function(value) {
                                    return '₹' + value.toLocaleString();
                                }
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
    // Update payroll breakdown cards every 30 seconds
    setInterval(function() {
        updatePayrollBreakdownCards();
    }, 30000);
    
    // Add status indicators to table rows
    $('.data-table tbody tr').each(function() {
        var amount = parseFloat($(this).find('td:nth-child(6)').text().replace(/[^\d.-]/g, '')) || 0; // Adjust column index as needed
        var statusClass = getPayrollBreakdownStatusClass(amount);
        
        $(this).addClass('status-' + statusClass);
        
        // Add status indicator
        var statusIndicator = $('<td class="status-indicator"></td>');
        var statusText = getPayrollBreakdownStatusText(amount);
        var statusIcon = getPayrollBreakdownStatusIcon(amount);
        
        statusIndicator.html(`<i class="${statusIcon}"></i> ${statusText}`);
        statusIndicator.addClass('status-' + statusClass);
        $(this).append(statusIndicator);
    });
}

// Update payroll breakdown cards
function updatePayrollBreakdownCards() {
    // Simulate real-time updates
    $('.payroll-breakdown-value').each(function() {
        var currentValue = $(this).text();
        var newValue = formatCurrency(Math.random() * 1000000);
        $(this).text(newValue);
    });
    
    showAlert('Payroll breakdown data updated', 'info');
}

// Get payroll breakdown status class
function getPayrollBreakdownStatusClass(amount) {
    if (amount >= 100000) {
        return 'high';
    } else if (amount >= 50000) {
        return 'medium';
    } else if (amount >= 25000) {
        return 'low';
    } else {
        return 'very-low';
    }
}

// Get payroll breakdown status text
function getPayrollBreakdownStatusText(amount) {
    if (amount >= 100000) {
        return 'High Pay';
    } else if (amount >= 50000) {
        return 'Medium Pay';
    } else if (amount >= 25000) {
        return 'Low Pay';
    } else {
        return 'Very Low Pay';
    }
}

// Get payroll breakdown status icon
function getPayrollBreakdownStatusIcon(amount) {
    if (amount >= 100000) {
        return 'fas fa-arrow-up';
    } else if (amount >= 50000) {
        return 'fas fa-arrow-right';
    } else if (amount >= 25000) {
        return 'fas fa-arrow-down';
    } else {
        return 'fas fa-minus';
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
            <input type="text" id="payrollBreakdownSearch" class="form-input" 
                   placeholder="Search payroll breakdown..." style="width: 300px;">
        </div>
    `;
    
    $('.page-header-actions').prepend(searchHtml);
    
    // Search functionality
    $('#payrollBreakdownSearch').on('input', function() {
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
    
    if ($('#payrollBreakdownSearch').val() !== '') {
        showAlert(`Found ${visibleRows} of ${totalRows} payroll breakdown records`, 'info');
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
                    <h3>Export Payroll Breakdown Report</h3>
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
    csvContent += '\n"Payroll Breakdown Summary"\n';
    csvContent += '"Total Breakdown","' + calculateTotalBreakdown() + '"\n';
    csvContent += '"Basic Salary","' + calculateBasicSalary() + '"\n';
    csvContent += '"Allowances","' + calculateAllowances() + '"\n';
    csvContent += '"Deductions","' + calculateDeductions() + '"\n';
    csvContent += '"Net Pay","' + calculateNetPay() + '"\n';
    csvContent += '"Tax Deduction","' + calculateTaxDeduction() + '"\n';
    
    // Download file
    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "payroll_breakdown_report.csv");
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
    showAlert('Refreshing payroll breakdown data...', 'info');
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
            $('#payrollBreakdownSearch').focus();
        }
        
        // Escape to close modals
        if (e.keyCode === 27) {
            $('.payroll-breakdown-modal-overlay, .export-modal-overlay').fadeOut(300, function() {
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
        .payroll-breakdown-modal-overlay,
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
        
        .payroll-breakdown-modal,
        .export-modal {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .payroll-breakdown-modal-header,
        .export-modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .payroll-breakdown-modal-content,
        .export-modal-content {
            padding: 1.5rem;
        }
        
        .payroll-breakdown-trend-chart {
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
        
        .payroll-breakdown-trend {
            margin-top: 0.5rem;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .payroll-breakdown-trend.trend-up {
            color: #27ae60;
        }
        
        .payroll-breakdown-trend.trend-down {
            color: #e74c3c;
        }
        
        .payroll-breakdown-breakdown {
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
    console.error('Payroll Breakdown Report Error:', e.error);
    showAlert('An error occurred. Please refresh the page.', 'error');
});

// Performance monitoring
window.addEventListener('load', function() {
    console.log('Payroll Breakdown Report page loaded successfully');
    
    // Log performance metrics
    if (window.performance && window.performance.timing) {
        var loadTime = window.performance.timing.loadEventEnd - window.performance.timing.navigationStart;
        console.log('Page load time:', loadTime + 'ms');
    }
});

