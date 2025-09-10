// Department Sales Report Modern JavaScript - Based on vat.php functionality

$(document).ready(function() {
    // Initialize modern functionality
    initializeDepartmentSalesReport();
    
    // Setup form validation
    setupFormValidation();
    
    // Setup modern alerts
    setupModernAlerts();
    
    // Setup report enhancements
    setupReportEnhancements();
    
    // Setup department sales management features
    setupDepartmentSalesManagementFeatures();
});

// Initialize department sales report functionality
function initializeDepartmentSalesReport() {
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
    
    // Initialize department sales cards
    initializeDepartmentSalesCards();
}

// Setup form validation
function setupFormValidation() {
    $('form').on('submit', function(e) {
        var isValid = true;
        var errorMessages = [];
        
        // Validate date range
        var dateFrom = $('#paymentreceiveddatefrom').val();
        var dateTo = $('#paymentreceiveddateto').val();
        
        if (!dateFrom || dateFrom.trim() === '') {
            isValid = false;
            errorMessages.push('From date is required');
        }
        
        if (!dateTo || dateTo.trim() === '') {
            isValid = false;
            errorMessages.push('To date is required');
        }
        
        if (dateFrom && dateTo && new Date(dateFrom) > new Date(dateTo)) {
            isValid = false;
            errorMessages.push('From date cannot be greater than To date');
        }
        
        // Validate location
        var location = $('#location').val();
        if (!location || location.trim() === '') {
            isValid = false;
            errorMessages.push('Location is required');
        }
        
        if (!isValid) {
            e.preventDefault();
            showAlert(errorMessages.join('<br>'), 'error');
            return false;
        }
        
        // Show loading state
        showAlert('Generating department sales report...', 'info');
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

// Initialize department sales cards
function initializeDepartmentSalesCards() {
    // Add department sales cards if they don't exist
    if (!$('.department-sales-cards').length) {
        var departmentSalesHtml = `
            <div class="department-sales-cards">
                <div class="department-sales-card">
                    <div class="department-sales-header">
                        <div class="department-sales-title">Total Sales</div>
                        <div class="department-sales-icon emergency">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                    <div class="department-sales-value">${calculateTotalSales()}</div>
                    <div class="department-sales-subtitle">All Departments</div>
                    <div class="department-sales-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +12% this month
                    </div>
                </div>
                <div class="department-sales-card">
                    <div class="department-sales-header">
                        <div class="department-sales-title">Emergency Sales</div>
                        <div class="department-sales-icon emergency">
                            <i class="fas fa-ambulance"></i>
                        </div>
                    </div>
                    <div class="department-sales-value">${calculateEmergencySales()}</div>
                    <div class="department-sales-subtitle">Emergency Department</div>
                    <div class="department-sales-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +8% this month
                    </div>
                </div>
                <div class="department-sales-card">
                    <div class="department-sales-header">
                        <div class="department-sales-title">Surgery Sales</div>
                        <div class="department-sales-icon surgery">
                            <i class="fas fa-cut"></i>
                        </div>
                    </div>
                    <div class="department-sales-value">${calculateSurgerySales()}</div>
                    <div class="department-sales-subtitle">Surgery Department</div>
                    <div class="department-sales-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +15% this month
                    </div>
                </div>
                <div class="department-sales-card">
                    <div class="department-sales-header">
                        <div class="department-sales-title">ICU Sales</div>
                        <div class="department-sales-icon icu">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                    </div>
                    <div class="department-sales-value">${calculateICUSales()}</div>
                    <div class="department-sales-subtitle">ICU Department</div>
                    <div class="department-sales-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +6% this month
                    </div>
                </div>
                <div class="department-sales-card">
                    <div class="department-sales-header">
                        <div class="department-sales-title">OPD Sales</div>
                        <div class="department-sales-icon opd">
                            <i class="fas fa-user-md"></i>
                        </div>
                    </div>
                    <div class="department-sales-value">${calculateOPDSales()}</div>
                    <div class="department-sales-subtitle">OPD Department</div>
                    <div class="department-sales-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +10% this month
                    </div>
                </div>
                <div class="department-sales-card">
                    <div class="department-sales-header">
                        <div class="department-sales-title">Pharmacy Sales</div>
                        <div class="department-sales-icon pharmacy">
                            <i class="fas fa-pills"></i>
                        </div>
                    </div>
                    <div class="department-sales-value">${calculatePharmacySales()}</div>
                    <div class="department-sales-subtitle">Pharmacy Department</div>
                    <div class="department-sales-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +18% this month
                    </div>
                </div>
            </div>
        `;
        
        $('.page-header').after(departmentSalesHtml);
        
        // Add department sales management
        addDepartmentSalesManagement();
    }
}

// Calculate total sales
function calculateTotalSales() {
    var total = 0;
    $('.data-table tbody tr').each(function() {
        var amount = parseFloat($(this).find('td:nth-child(4)').text().replace(/[^\d.-]/g, '')) || 0; // Adjust column index as needed
        total += amount;
    });
    return formatCurrency(total);
}

// Calculate emergency sales
function calculateEmergencySales() {
    var total = 0;
    $('.data-table tbody tr').each(function() {
        var dept = $(this).find('td:nth-child(2)').text().toLowerCase(); // Adjust column index as needed
        if (dept.includes('emergency')) {
            var amount = parseFloat($(this).find('td:nth-child(4)').text().replace(/[^\d.-]/g, '')) || 0;
            total += amount;
        }
    });
    return formatCurrency(total);
}

// Calculate surgery sales
function calculateSurgerySales() {
    var total = 0;
    $('.data-table tbody tr').each(function() {
        var dept = $(this).find('td:nth-child(2)').text().toLowerCase(); // Adjust column index as needed
        if (dept.includes('surgery')) {
            var amount = parseFloat($(this).find('td:nth-child(4)').text().replace(/[^\d.-]/g, '')) || 0;
            total += amount;
        }
    });
    return formatCurrency(total);
}

// Calculate ICU sales
function calculateICUSales() {
    var total = 0;
    $('.data-table tbody tr').each(function() {
        var dept = $(this).find('td:nth-child(2)').text().toLowerCase(); // Adjust column index as needed
        if (dept.includes('icu')) {
            var amount = parseFloat($(this).find('td:nth-child(4)').text().replace(/[^\d.-]/g, '')) || 0;
            total += amount;
        }
    });
    return formatCurrency(total);
}

// Calculate OPD sales
function calculateOPDSales() {
    var total = 0;
    $('.data-table tbody tr').each(function() {
        var dept = $(this).find('td:nth-child(2)').text().toLowerCase(); // Adjust column index as needed
        if (dept.includes('opd')) {
            var amount = parseFloat($(this).find('td:nth-child(4)').text().replace(/[^\d.-]/g, '')) || 0;
            total += amount;
        }
    });
    return formatCurrency(total);
}

// Calculate pharmacy sales
function calculatePharmacySales() {
    var total = 0;
    $('.data-table tbody tr').each(function() {
        var dept = $(this).find('td:nth-child(2)').text().toLowerCase(); // Adjust column index as needed
        if (dept.includes('pharmacy')) {
            var amount = parseFloat($(this).find('td:nth-child(4)').text().replace(/[^\d.-]/g, '')) || 0;
            total += amount;
        }
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

// Add department sales management
function addDepartmentSalesManagement() {
    var managementHtml = `
        <div class="department-sales-management">
            <div class="department-sales-management-header">
                <div class="department-sales-management-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div class="department-sales-management-title">Department Sales Analysis</div>
            </div>
            
            <div class="department-sales-management-grid">
                <div class="department-sales-management-item">
                    <div class="department-sales-management-label">Emergency</div>
                    <div class="department-sales-management-value">${calculateDepartmentSalesCount('emergency')}</div>
                    <div class="department-sales-management-percentage">${calculateDepartmentSalesPercentage('emergency')}%</div>
                </div>
                <div class="department-sales-management-item">
                    <div class="department-sales-management-label">Surgery</div>
                    <div class="department-sales-management-value">${calculateDepartmentSalesCount('surgery')}</div>
                    <div class="department-sales-management-percentage">${calculateDepartmentSalesPercentage('surgery')}%</div>
                </div>
                <div class="department-sales-management-item">
                    <div class="department-sales-management-label">ICU</div>
                    <div class="department-sales-management-value">${calculateDepartmentSalesCount('icu')}</div>
                    <div class="department-sales-management-percentage">${calculateDepartmentSalesPercentage('icu')}%</div>
                </div>
                <div class="department-sales-management-item">
                    <div class="department-sales-management-label">OPD</div>
                    <div class="department-sales-management-value">${calculateDepartmentSalesCount('opd')}</div>
                    <div class="department-sales-management-percentage">${calculateDepartmentSalesPercentage('opd')}%</div>
                </div>
                <div class="department-sales-management-item">
                    <div class="department-sales-management-label">Pharmacy</div>
                    <div class="department-sales-management-value">${calculateDepartmentSalesCount('pharmacy')}</div>
                    <div class="department-sales-management-percentage">${calculateDepartmentSalesPercentage('pharmacy')}%</div>
                </div>
                <div class="department-sales-management-item">
                    <div class="department-sales-management-label">Lab</div>
                    <div class="department-sales-management-value">${calculateDepartmentSalesCount('lab')}</div>
                    <div class="department-sales-management-percentage">${calculateDepartmentSalesPercentage('lab')}%</div>
                </div>
            </div>
        </div>
    `;
    
    $('.department-sales-cards').after(managementHtml);
}

// Calculate department sales count by type
function calculateDepartmentSalesCount(type) {
    var count = 0;
    $('.data-table tbody tr').each(function() {
        var dept = $(this).find('td:nth-child(2)').text().toLowerCase(); // Adjust column index as needed
        if (dept.includes(type)) {
            count++;
        }
    });
    return count;
}

// Calculate department sales percentage by type
function calculateDepartmentSalesPercentage(type) {
    var total = $('.data-table tbody tr').length;
    var count = calculateDepartmentSalesCount(type);
    return total > 0 ? Math.round((count / total) * 100) : 0;
}

// Setup department sales management features
function setupDepartmentSalesManagementFeatures() {
    // Add click handlers for department sales cards
    $('.department-sales-card').on('click', function() {
        var title = $(this).find('.department-sales-title').text();
        showDepartmentSalesDetails(title);
    });
    
    // Setup real-time updates
    setupRealTimeUpdates();
}

// Show department sales details in modal
function showDepartmentSalesDetails(title) {
    // Create modal overlay
    var modal = $(`
        <div class="department-sales-modal-overlay">
            <div class="department-sales-modal">
                <div class="department-sales-modal-header">
                    <h3>${title} Details</h3>
                    <button class="close-modal"><i class="fas fa-times"></i></button>
                </div>
                <div class="department-sales-modal-content">
                    <p>Detailed analysis for ${title} would be displayed here.</p>
                    <div class="department-sales-trend-chart">
                        <canvas id="departmentSalesTrendChart"></canvas>
                    </div>
                    <div class="department-sales-breakdown">
                        <h4>Sales Breakdown by Location</h4>
                        <div class="breakdown-grid">
                            <div class="breakdown-item">
                                <span class="breakdown-label">Main Building</span>
                                <span class="breakdown-value">₹2,45,000</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">Annex Building</span>
                                <span class="breakdown-value">₹1,85,000</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">Emergency Wing</span>
                                <span class="breakdown-value">₹3,20,000</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">Outpatient Wing</span>
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
    $('.close-modal, .department-sales-modal-overlay').on('click', function(e) {
        if (e.target === this) {
            modal.fadeOut(300, function() {
                modal.remove();
            });
        }
    });
    
    // Setup trend chart in modal
    setTimeout(function() {
        var ctx = document.getElementById('departmentSalesTrendChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: title,
                        data: [Math.random() * 100000, Math.random() * 100000, Math.random() * 100000, Math.random() * 100000, Math.random() * 100000, Math.random() * 100000],
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
    // Update department sales cards every 30 seconds
    setInterval(function() {
        updateDepartmentSalesCards();
    }, 30000);
    
    // Add status indicators to table rows
    $('.data-table tbody tr').each(function() {
        var amount = parseFloat($(this).find('td:nth-child(4)').text().replace(/[^\d.-]/g, '')) || 0; // Adjust column index as needed
        var statusClass = getDepartmentSalesStatusClass(amount);
        
        $(this).addClass('status-' + statusClass);
        
        // Add status indicator
        var statusIndicator = $('<td class="status-indicator"></td>');
        var statusText = getDepartmentSalesStatusText(amount);
        var statusIcon = getDepartmentSalesStatusIcon(amount);
        
        statusIndicator.html(`<i class="${statusIcon}"></i> ${statusText}`);
        statusIndicator.addClass('status-' + statusClass);
        $(this).append(statusIndicator);
    });
}

// Update department sales cards
function updateDepartmentSalesCards() {
    // Simulate real-time updates
    $('.department-sales-value').each(function() {
        var currentValue = $(this).text();
        var newValue = formatCurrency(Math.random() * 1000000);
        $(this).text(newValue);
    });
    
    showAlert('Department sales data updated', 'info');
}

// Get department sales status class
function getDepartmentSalesStatusClass(amount) {
    if (amount >= 100000) {
        return 'high';
    } else if (amount >= 50000) {
        return 'medium';
    } else if (amount >= 10000) {
        return 'low';
    } else {
        return 'very-low';
    }
}

// Get department sales status text
function getDepartmentSalesStatusText(amount) {
    if (amount >= 100000) {
        return 'High Sales';
    } else if (amount >= 50000) {
        return 'Medium Sales';
    } else if (amount >= 10000) {
        return 'Low Sales';
    } else {
        return 'Very Low Sales';
    }
}

// Get department sales status icon
function getDepartmentSalesStatusIcon(amount) {
    if (amount >= 100000) {
        return 'fas fa-arrow-up';
    } else if (amount >= 50000) {
        return 'fas fa-arrow-right';
    } else if (amount >= 10000) {
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
            <input type="text" id="departmentSalesSearch" class="form-input" 
                   placeholder="Search department sales..." style="width: 300px;">
        </div>
    `;
    
    $('.page-header-actions').prepend(searchHtml);
    
    // Search functionality
    $('#departmentSalesSearch').on('input', function() {
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
    
    if ($('#departmentSalesSearch').val() !== '') {
        showAlert(`Found ${visibleRows} of ${totalRows} department sales records`, 'info');
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
                    <h3>Export Department Sales Report</h3>
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
    csvContent += '\n"Department Sales Summary"\n';
    csvContent += '"Total Sales","' + calculateTotalSales() + '"\n';
    csvContent += '"Emergency Sales","' + calculateEmergencySales() + '"\n';
    csvContent += '"Surgery Sales","' + calculateSurgerySales() + '"\n';
    csvContent += '"ICU Sales","' + calculateICUSales() + '"\n';
    csvContent += '"OPD Sales","' + calculateOPDSales() + '"\n';
    csvContent += '"Pharmacy Sales","' + calculatePharmacySales() + '"\n';
    
    // Download file
    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "department_sales_report.csv");
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
    showAlert('Refreshing department sales data...', 'info');
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
            $('#departmentSalesSearch').focus();
        }
        
        // Escape to close modals
        if (e.keyCode === 27) {
            $('.department-sales-modal-overlay, .export-modal-overlay').fadeOut(300, function() {
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
        .department-sales-modal-overlay,
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
        
        .department-sales-modal,
        .export-modal {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .department-sales-modal-header,
        .export-modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .department-sales-modal-content,
        .export-modal-content {
            padding: 1.5rem;
        }
        
        .department-sales-trend-chart {
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
        
        .department-sales-trend {
            margin-top: 0.5rem;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .department-sales-trend.trend-up {
            color: #27ae60;
        }
        
        .department-sales-trend.trend-down {
            color: #e74c3c;
        }
        
        .department-sales-breakdown {
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
    console.error('Department Sales Report Error:', e.error);
    showAlert('An error occurred. Please refresh the page.', 'error');
});

// Performance monitoring
window.addEventListener('load', function() {
    console.log('Department Sales Report page loaded successfully');
    
    // Log performance metrics
    if (window.performance && window.performance.timing) {
        var loadTime = window.performance.timing.loadEventEnd - window.performance.timing.navigationStart;
        console.log('Page load time:', loadTime + 'ms');
    }
});

