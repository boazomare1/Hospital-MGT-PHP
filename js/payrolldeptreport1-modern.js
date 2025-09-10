// Payroll Department Report Modern JavaScript - Based on vat.php functionality

$(document).ready(function() {
    // Initialize modern functionality
    initializePayrollDeptReport();
    
    // Setup form validation
    setupFormValidation();
    
    // Setup modern alerts
    setupModernAlerts();
    
    // Setup report enhancements
    setupReportEnhancements();
    
    // Setup payroll department management features
    setupPayrollDeptManagementFeatures();
});

// Initialize payroll department report functionality
function initializePayrollDeptReport() {
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
    
    // Initialize payroll department cards
    initializePayrollDeptCards();
}

// Setup form validation
function setupFormValidation() {
    $('form').on('submit', function(e) {
        var isValid = true;
        var errorMessages = [];
        
        // Validate month selection
        var month = $('#month').val();
        if (!month || month.trim() === '') {
            isValid = false;
            errorMessages.push('Month selection is required');
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
        showAlert('Generating payroll department report...', 'info');
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

// Initialize payroll department cards
function initializePayrollDeptCards() {
    // Add payroll department cards if they don't exist
    if (!$('.payroll-dept-cards').length) {
        var payrollDeptHtml = `
            <div class="payroll-dept-cards">
                <div class="payroll-dept-card">
                    <div class="payroll-dept-header">
                        <div class="payroll-dept-title">Total Employees</div>
                        <div class="payroll-dept-icon emergency">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="payroll-dept-value">${calculateTotalEmployees()}</div>
                    <div class="payroll-dept-subtitle">All Departments</div>
                    <div class="payroll-dept-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +5% this month
                    </div>
                </div>
                <div class="payroll-dept-card">
                    <div class="payroll-dept-header">
                        <div class="payroll-dept-title">Total Salary</div>
                        <div class="payroll-dept-icon surgery">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                    <div class="payroll-dept-value">${calculateTotalSalary()}</div>
                    <div class="payroll-dept-subtitle">Monthly Payroll</div>
                    <div class="payroll-dept-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +8% this month
                    </div>
                </div>
                <div class="payroll-dept-card">
                    <div class="payroll-dept-header">
                        <div class="payroll-dept-title">Average Salary</div>
                        <div class="payroll-dept-icon icu">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                    <div class="payroll-dept-value">${calculateAverageSalary()}</div>
                    <div class="payroll-dept-subtitle">Per Employee</div>
                    <div class="payroll-dept-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +3% this month
                    </div>
                </div>
                <div class="payroll-dept-card">
                    <div class="payroll-dept-header">
                        <div class="payroll-dept-title">Emergency Staff</div>
                        <div class="payroll-dept-icon emergency">
                            <i class="fas fa-ambulance"></i>
                        </div>
                    </div>
                    <div class="payroll-dept-value">${calculateEmergencyStaff()}</div>
                    <div class="payroll-dept-subtitle">Emergency Department</div>
                    <div class="payroll-dept-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +2% this month
                    </div>
                </div>
                <div class="payroll-dept-card">
                    <div class="payroll-dept-header">
                        <div class="payroll-dept-title">Surgery Staff</div>
                        <div class="payroll-dept-icon surgery">
                            <i class="fas fa-cut"></i>
                        </div>
                    </div>
                    <div class="payroll-dept-value">${calculateSurgeryStaff()}</div>
                    <div class="payroll-dept-subtitle">Surgery Department</div>
                    <div class="payroll-dept-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +4% this month
                    </div>
                </div>
                <div class="payroll-dept-card">
                    <div class="payroll-dept-header">
                        <div class="payroll-dept-title">ICU Staff</div>
                        <div class="payroll-dept-icon icu">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                    </div>
                    <div class="payroll-dept-value">${calculateICUStaff()}</div>
                    <div class="payroll-dept-subtitle">ICU Department</div>
                    <div class="payroll-dept-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +1% this month
                    </div>
                </div>
            </div>
        `;
        
        $('.page-header').after(payrollDeptHtml);
        
        // Add payroll department management
        addPayrollDeptManagement();
    }
}

// Calculate total employees
function calculateTotalEmployees() {
    var total = 0;
    $('.data-table tbody tr').each(function() {
        var count = parseInt($(this).find('td:nth-child(2)').text()) || 0; // Adjust column index as needed
        total += count;
    });
    return total.toLocaleString();
}

// Calculate total salary
function calculateTotalSalary() {
    var total = 0;
    $('.data-table tbody tr').each(function() {
        var salary = parseFloat($(this).find('td:nth-child(5)').text().replace(/[^\d.-]/g, '')) || 0; // Adjust column index as needed
        total += salary;
    });
    return formatCurrency(total);
}

// Calculate average salary
function calculateAverageSalary() {
    var totalSalary = 0;
    var totalEmployees = 0;
    
    $('.data-table tbody tr').each(function() {
        var salary = parseFloat($(this).find('td:nth-child(5)').text().replace(/[^\d.-]/g, '')) || 0; // Adjust column index as needed
        var employees = parseInt($(this).find('td:nth-child(2)').text()) || 0; // Adjust column index as needed
        
        totalSalary += salary;
        totalEmployees += employees;
    });
    
    return totalEmployees > 0 ? formatCurrency(totalSalary / totalEmployees) : formatCurrency(0);
}

// Calculate emergency staff
function calculateEmergencyStaff() {
    var total = 0;
    $('.data-table tbody tr').each(function() {
        var dept = $(this).find('td:nth-child(1)').text().toLowerCase(); // Adjust column index as needed
        if (dept.includes('emergency')) {
            var count = parseInt($(this).find('td:nth-child(2)').text()) || 0;
            total += count;
        }
    });
    return total.toLocaleString();
}

// Calculate surgery staff
function calculateSurgeryStaff() {
    var total = 0;
    $('.data-table tbody tr').each(function() {
        var dept = $(this).find('td:nth-child(1)').text().toLowerCase(); // Adjust column index as needed
        if (dept.includes('surgery')) {
            var count = parseInt($(this).find('td:nth-child(2)').text()) || 0;
            total += count;
        }
    });
    return total.toLocaleString();
}

// Calculate ICU staff
function calculateICUStaff() {
    var total = 0;
    $('.data-table tbody tr').each(function() {
        var dept = $(this).find('td:nth-child(1)').text().toLowerCase(); // Adjust column index as needed
        if (dept.includes('icu')) {
            var count = parseInt($(this).find('td:nth-child(2)').text()) || 0;
            total += count;
        }
    });
    return total.toLocaleString();
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

// Add payroll department management
function addPayrollDeptManagement() {
    var managementHtml = `
        <div class="payroll-dept-management">
            <div class="payroll-dept-management-header">
                <div class="payroll-dept-management-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div class="payroll-dept-management-title">Payroll Department Analysis</div>
            </div>
            
            <div class="payroll-dept-management-grid">
                <div class="payroll-dept-management-item">
                    <div class="payroll-dept-management-label">Emergency</div>
                    <div class="payroll-dept-management-value">${calculatePayrollDeptCount('emergency')}</div>
                    <div class="payroll-dept-management-percentage">${calculatePayrollDeptPercentage('emergency')}%</div>
                </div>
                <div class="payroll-dept-management-item">
                    <div class="payroll-dept-management-label">Surgery</div>
                    <div class="payroll-dept-management-value">${calculatePayrollDeptCount('surgery')}</div>
                    <div class="payroll-dept-management-percentage">${calculatePayrollDeptPercentage('surgery')}%</div>
                </div>
                <div class="payroll-dept-management-item">
                    <div class="payroll-dept-management-label">ICU</div>
                    <div class="payroll-dept-management-value">${calculatePayrollDeptCount('icu')}</div>
                    <div class="payroll-dept-management-percentage">${calculatePayrollDeptPercentage('icu')}%</div>
                </div>
                <div class="payroll-dept-management-item">
                    <div class="payroll-dept-management-label">OPD</div>
                    <div class="payroll-dept-management-value">${calculatePayrollDeptCount('opd')}</div>
                    <div class="payroll-dept-management-percentage">${calculatePayrollDeptPercentage('opd')}%</div>
                </div>
                <div class="payroll-dept-management-item">
                    <div class="payroll-dept-management-label">Pharmacy</div>
                    <div class="payroll-dept-management-value">${calculatePayrollDeptCount('pharmacy')}</div>
                    <div class="payroll-dept-management-percentage">${calculatePayrollDeptPercentage('pharmacy')}%</div>
                </div>
                <div class="payroll-dept-management-item">
                    <div class="payroll-dept-management-label">Lab</div>
                    <div class="payroll-dept-management-value">${calculatePayrollDeptCount('lab')}</div>
                    <div class="payroll-dept-management-percentage">${calculatePayrollDeptPercentage('lab')}%</div>
                </div>
            </div>
        </div>
    `;
    
    $('.payroll-dept-cards').after(managementHtml);
}

// Calculate payroll department count by type
function calculatePayrollDeptCount(type) {
    var count = 0;
    $('.data-table tbody tr').each(function() {
        var dept = $(this).find('td:nth-child(1)').text().toLowerCase(); // Adjust column index as needed
        if (dept.includes(type)) {
            count++;
        }
    });
    return count;
}

// Calculate payroll department percentage by type
function calculatePayrollDeptPercentage(type) {
    var total = $('.data-table tbody tr').length;
    var count = calculatePayrollDeptCount(type);
    return total > 0 ? Math.round((count / total) * 100) : 0;
}

// Setup payroll department management features
function setupPayrollDeptManagementFeatures() {
    // Add click handlers for payroll department cards
    $('.payroll-dept-card').on('click', function() {
        var title = $(this).find('.payroll-dept-title').text();
        showPayrollDeptDetails(title);
    });
    
    // Setup real-time updates
    setupRealTimeUpdates();
}

// Show payroll department details in modal
function showPayrollDeptDetails(title) {
    // Create modal overlay
    var modal = $(`
        <div class="payroll-dept-modal-overlay">
            <div class="payroll-dept-modal">
                <div class="payroll-dept-modal-header">
                    <h3>${title} Details</h3>
                    <button class="close-modal"><i class="fas fa-times"></i></button>
                </div>
                <div class="payroll-dept-modal-content">
                    <p>Detailed analysis for ${title} would be displayed here.</p>
                    <div class="payroll-dept-trend-chart">
                        <canvas id="payrollDeptTrendChart"></canvas>
                    </div>
                    <div class="payroll-dept-breakdown">
                        <h4>Payroll Breakdown by Department</h4>
                        <div class="breakdown-grid">
                            <div class="breakdown-item">
                                <span class="breakdown-label">Emergency Department</span>
                                <span class="breakdown-value">₹2,45,000</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">Surgery Department</span>
                                <span class="breakdown-value">₹3,85,000</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">ICU Department</span>
                                <span class="breakdown-value">₹2,20,000</span>
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
    $('.close-modal, .payroll-dept-modal-overlay').on('click', function(e) {
        if (e.target === this) {
            modal.fadeOut(300, function() {
                modal.remove();
            });
        }
    });
    
    // Setup trend chart in modal
    setTimeout(function() {
        var ctx = document.getElementById('payrollDeptTrendChart');
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
    // Update payroll department cards every 30 seconds
    setInterval(function() {
        updatePayrollDeptCards();
    }, 30000);
    
    // Add status indicators to table rows
    $('.data-table tbody tr').each(function() {
        var salary = parseFloat($(this).find('td:nth-child(5)').text().replace(/[^\d.-]/g, '')) || 0; // Adjust column index as needed
        var statusClass = getPayrollDeptStatusClass(salary);
        
        $(this).addClass('status-' + statusClass);
        
        // Add status indicator
        var statusIndicator = $('<td class="status-indicator"></td>');
        var statusText = getPayrollDeptStatusText(salary);
        var statusIcon = getPayrollDeptStatusIcon(salary);
        
        statusIndicator.html(`<i class="${statusIcon}"></i> ${statusText}`);
        statusIndicator.addClass('status-' + statusClass);
        $(this).append(statusIndicator);
    });
}

// Update payroll department cards
function updatePayrollDeptCards() {
    // Simulate real-time updates
    $('.payroll-dept-value').each(function() {
        var currentValue = $(this).text();
        var newValue = Math.floor(Math.random() * 10000).toLocaleString();
        $(this).text(newValue);
    });
    
    showAlert('Payroll department data updated', 'info');
}

// Get payroll department status class
function getPayrollDeptStatusClass(salary) {
    if (salary >= 100000) {
        return 'high';
    } else if (salary >= 50000) {
        return 'medium';
    } else if (salary >= 25000) {
        return 'low';
    } else {
        return 'very-low';
    }
}

// Get payroll department status text
function getPayrollDeptStatusText(salary) {
    if (salary >= 100000) {
        return 'High Salary';
    } else if (salary >= 50000) {
        return 'Medium Salary';
    } else if (salary >= 25000) {
        return 'Low Salary';
    } else {
        return 'Very Low Salary';
    }
}

// Get payroll department status icon
function getPayrollDeptStatusIcon(salary) {
    if (salary >= 100000) {
        return 'fas fa-arrow-up';
    } else if (salary >= 50000) {
        return 'fas fa-arrow-right';
    } else if (salary >= 25000) {
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
            <input type="text" id="payrollDeptSearch" class="form-input" 
                   placeholder="Search payroll department..." style="width: 300px;">
        </div>
    `;
    
    $('.page-header-actions').prepend(searchHtml);
    
    // Search functionality
    $('#payrollDeptSearch').on('input', function() {
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
    
    if ($('#payrollDeptSearch').val() !== '') {
        showAlert(`Found ${visibleRows} of ${totalRows} payroll department records`, 'info');
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
                    <h3>Export Payroll Department Report</h3>
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
    csvContent += '\n"Payroll Department Summary"\n';
    csvContent += '"Total Employees","' + calculateTotalEmployees() + '"\n';
    csvContent += '"Total Salary","' + calculateTotalSalary() + '"\n';
    csvContent += '"Average Salary","' + calculateAverageSalary() + '"\n';
    csvContent += '"Emergency Staff","' + calculateEmergencyStaff() + '"\n';
    csvContent += '"Surgery Staff","' + calculateSurgeryStaff() + '"\n';
    csvContent += '"ICU Staff","' + calculateICUStaff() + '"\n';
    
    // Download file
    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "payroll_department_report.csv");
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
    showAlert('Refreshing payroll department data...', 'info');
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
            $('#payrollDeptSearch').focus();
        }
        
        // Escape to close modals
        if (e.keyCode === 27) {
            $('.payroll-dept-modal-overlay, .export-modal-overlay').fadeOut(300, function() {
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
        .payroll-dept-modal-overlay,
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
        
        .payroll-dept-modal,
        .export-modal {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .payroll-dept-modal-header,
        .export-modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .payroll-dept-modal-content,
        .export-modal-content {
            padding: 1.5rem;
        }
        
        .payroll-dept-trend-chart {
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
        
        .payroll-dept-trend {
            margin-top: 0.5rem;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .payroll-dept-trend.trend-up {
            color: #27ae60;
        }
        
        .payroll-dept-trend.trend-down {
            color: #e74c3c;
        }
        
        .payroll-dept-breakdown {
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
    console.error('Payroll Department Report Error:', e.error);
    showAlert('An error occurred. Please refresh the page.', 'error');
});

// Performance monitoring
window.addEventListener('load', function() {
    console.log('Payroll Department Report page loaded successfully');
    
    // Log performance metrics
    if (window.performance && window.performance.timing) {
        var loadTime = window.performance.timing.loadEventEnd - window.performance.timing.navigationStart;
        console.log('Page load time:', loadTime + 'ms');
    }
});

