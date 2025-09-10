// Add Department Modern JavaScript - Based on vat.php functionality

$(document).ready(function() {
    // Initialize modern functionality
    initializeAddDepartment();
    
    // Setup form validation
    setupFormValidation();
    
    // Setup modern alerts
    setupModernAlerts();
    
    // Setup report enhancements
    setupReportEnhancements();
    
    // Setup department management features
    setupDepartmentManagementFeatures();
});

// Initialize add department functionality
function initializeAddDepartment() {
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
    
    // Initialize department cards
    initializeDepartmentCards();
}

// Setup form validation
function setupFormValidation() {
    $('form').on('submit', function(e) {
        var isValid = true;
        var errorMessages = [];
        
        // Validate department name
        var deptName = $('#departmentname').val();
        if (!deptName || deptName.trim() === '') {
            isValid = false;
            errorMessages.push('Department name is required');
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
        showAlert('Adding department...', 'info');
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

// Initialize department cards
function initializeDepartmentCards() {
    // Add department cards if they don't exist
    if (!$('.department-cards').length) {
        var departmentHtml = `
            <div class="department-cards">
                <div class="department-card">
                    <div class="department-header">
                        <div class="department-title">Total Departments</div>
                        <div class="department-icon active">
                            <i class="fas fa-building"></i>
                        </div>
                    </div>
                    <div class="department-value">${calculateTotalDepartments()}</div>
                    <div class="department-subtitle">All Departments</div>
                    <div class="department-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +2 this month
                    </div>
                </div>
                <div class="department-card">
                    <div class="department-header">
                        <div class="department-title">Active Departments</div>
                        <div class="department-icon active">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="department-value">${calculateActiveDepartments()}</div>
                    <div class="department-subtitle">Currently Active</div>
                    <div class="department-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +1 this month
                    </div>
                </div>
                <div class="department-card">
                    <div class="department-header">
                        <div class="department-title">Default Department</div>
                        <div class="department-icon default">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <div class="department-value">${calculateDefaultDepartments()}</div>
                    <div class="department-subtitle">Set as Default</div>
                    <div class="department-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +0 this month
                    </div>
                </div>
                <div class="department-card">
                    <div class="department-header">
                        <div class="department-title">Inactive Departments</div>
                        <div class="department-icon inactive">
                            <i class="fas fa-pause-circle"></i>
                        </div>
                    </div>
                    <div class="department-value">${calculateInactiveDepartments()}</div>
                    <div class="department-subtitle">Currently Inactive</div>
                    <div class="department-trend trend-down">
                        <i class="fas fa-arrow-down"></i> -1 this month
                    </div>
                </div>
            </div>
        `;
        
        $('.page-header').after(departmentHtml);
        
        // Add department management
        addDepartmentManagement();
    }
}

// Calculate total departments
function calculateTotalDepartments() {
    return $('.data-table tbody tr').length;
}

// Calculate active departments
function calculateActiveDepartments() {
    var active = 0;
    $('.data-table tbody tr').each(function() {
        var status = $(this).find('td:nth-child(4)').text().toLowerCase(); // Adjust column index as needed
        if (status.includes('active') || status.includes('enabled')) {
            active++;
        }
    });
    return active;
}

// Calculate default departments
function calculateDefaultDepartments() {
    var defaultDept = 0;
    $('.data-table tbody tr').each(function() {
        var status = $(this).find('td:nth-child(4)').text().toLowerCase(); // Adjust column index as needed
        if (status.includes('default')) {
            defaultDept++;
        }
    });
    return defaultDept;
}

// Calculate inactive departments
function calculateInactiveDepartments() {
    var inactive = 0;
    $('.data-table tbody tr').each(function() {
        var status = $(this).find('td:nth-child(4)').text().toLowerCase(); // Adjust column index as needed
        if (status.includes('inactive') || status.includes('disabled')) {
            inactive++;
        }
    });
    return inactive;
}

// Add department management
function addDepartmentManagement() {
    var managementHtml = `
        <div class="department-management">
            <div class="management-header">
                <div class="management-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div class="management-title">Department Management</div>
            </div>
            
            <div class="management-grid">
                <div class="management-item">
                    <div class="management-label">Emergency</div>
                    <div class="management-value">${calculateDepartmentCount('emergency')}</div>
                    <div class="management-percentage">${calculateDepartmentPercentage('emergency')}%</div>
                </div>
                <div class="management-item">
                    <div class="management-label">Surgery</div>
                    <div class="management-value">${calculateDepartmentCount('surgery')}</div>
                    <div class="management-percentage">${calculateDepartmentPercentage('surgery')}%</div>
                </div>
                <div class="management-item">
                    <div class="management-label">ICU</div>
                    <div class="management-value">${calculateDepartmentCount('icu')}</div>
                    <div class="management-percentage">${calculateDepartmentPercentage('icu')}%</div>
                </div>
                <div class="management-item">
                    <div class="management-label">OPD</div>
                    <div class="management-value">${calculateDepartmentCount('opd')}</div>
                    <div class="management-percentage">${calculateDepartmentPercentage('opd')}%</div>
                </div>
                <div class="management-item">
                    <div class="management-label">Pharmacy</div>
                    <div class="management-value">${calculateDepartmentCount('pharmacy')}</div>
                    <div class="management-percentage">${calculateDepartmentPercentage('pharmacy')}%</div>
                </div>
                <div class="management-item">
                    <div class="management-label">Lab</div>
                    <div class="management-value">${calculateDepartmentCount('lab')}</div>
                    <div class="management-percentage">${calculateDepartmentPercentage('lab')}%</div>
                </div>
            </div>
        </div>
    `;
    
    $('.department-cards').after(managementHtml);
}

// Calculate department count by type
function calculateDepartmentCount(type) {
    var count = 0;
    $('.data-table tbody tr').each(function() {
        var deptName = $(this).find('td:nth-child(2)').text().toLowerCase(); // Adjust column index as needed
        if (deptName.includes(type)) {
            count++;
        }
    });
    return count;
}

// Calculate department percentage by type
function calculateDepartmentPercentage(type) {
    var total = calculateTotalDepartments();
    var count = calculateDepartmentCount(type);
    return total > 0 ? Math.round((count / total) * 100) : 0;
}

// Setup department management features
function setupDepartmentManagementFeatures() {
    // Add click handlers for department cards
    $('.department-card').on('click', function() {
        var title = $(this).find('.department-title').text();
        showDepartmentDetails(title);
    });
    
    // Setup real-time updates
    setupRealTimeUpdates();
}

// Show department details in modal
function showDepartmentDetails(title) {
    // Create modal overlay
    var modal = $(`
        <div class="department-modal-overlay">
            <div class="department-modal">
                <div class="department-modal-header">
                    <h3>${title} Details</h3>
                    <button class="close-modal"><i class="fas fa-times"></i></button>
                </div>
                <div class="department-modal-content">
                    <p>Detailed analysis for ${title} would be displayed here.</p>
                    <div class="department-trend-chart">
                        <canvas id="departmentTrendChart"></canvas>
                    </div>
                    <div class="department-breakdown">
                        <h4>Breakdown by Location</h4>
                        <div class="breakdown-grid">
                            <div class="breakdown-item">
                                <span class="breakdown-label">Main Building</span>
                                <span class="breakdown-value">8 departments</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">Annex Building</span>
                                <span class="breakdown-value">4 departments</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">Emergency Wing</span>
                                <span class="breakdown-value">2 departments</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">Outpatient Wing</span>
                                <span class="breakdown-value">6 departments</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `);
    
    $('body').append(modal);
    
    // Close modal handler
    $('.close-modal, .department-modal-overlay').on('click', function(e) {
        if (e.target === this) {
            modal.fadeOut(300, function() {
                modal.remove();
            });
        }
    });
    
    // Setup trend chart in modal
    setTimeout(function() {
        var ctx = document.getElementById('departmentTrendChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: title,
                        data: [Math.random() * 20, Math.random() * 20, Math.random() * 20, Math.random() * 20, Math.random() * 20, Math.random() * 20],
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
                                stepSize: 1
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
    // Update department cards every 30 seconds
    setInterval(function() {
        updateDepartmentCards();
    }, 30000);
    
    // Add status indicators to table rows
    $('.data-table tbody tr').each(function() {
        var status = $(this).find('td:nth-child(4)').text().toLowerCase(); // Adjust column index as needed
        var statusClass = getDepartmentStatusClass(status);
        
        $(this).addClass('status-' + statusClass);
        
        // Add status indicator
        var statusIndicator = $('<td class="status-indicator"></td>');
        var statusText = getDepartmentStatusText(status);
        var statusIcon = getDepartmentStatusIcon(status);
        
        statusIndicator.html(`<i class="${statusIcon}"></i> ${statusText}`);
        statusIndicator.addClass('status-' + statusClass);
        $(this).append(statusIndicator);
    });
}

// Update department cards
function updateDepartmentCards() {
    // Simulate real-time updates
    $('.department-value').each(function() {
        var currentValue = parseInt($(this).text());
        var newValue = currentValue + Math.floor(Math.random() * 3) - 1;
        $(this).text(Math.max(0, newValue));
    });
    
    showAlert('Department data updated', 'info');
}

// Get department status class
function getDepartmentStatusClass(status) {
    if (status.includes('active') || status.includes('enabled')) {
        return 'active';
    } else if (status.includes('default')) {
        return 'default';
    } else if (status.includes('inactive') || status.includes('disabled')) {
        return 'inactive';
    } else {
        return 'inactive';
    }
}

// Get department status text
function getDepartmentStatusText(status) {
    if (status.includes('active') || status.includes('enabled')) {
        return 'Active';
    } else if (status.includes('default')) {
        return 'Default';
    } else if (status.includes('inactive') || status.includes('disabled')) {
        return 'Inactive';
    } else {
        return 'Inactive';
    }
}

// Get department status icon
function getDepartmentStatusIcon(status) {
    if (status.includes('active') || status.includes('enabled')) {
        return 'fas fa-check-circle';
    } else if (status.includes('default')) {
        return 'fas fa-star';
    } else if (status.includes('inactive') || status.includes('disabled')) {
        return 'fas fa-pause-circle';
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
            <input type="text" id="departmentSearch" class="form-input" 
                   placeholder="Search departments..." style="width: 300px;">
        </div>
    `;
    
    $('.page-header-actions').prepend(searchHtml);
    
    // Search functionality
    $('#departmentSearch').on('input', function() {
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
    
    if ($('#departmentSearch').val() !== '') {
        showAlert(`Found ${visibleRows} of ${totalRows} departments`, 'info');
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
                    <h3>Export Department Report</h3>
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
    csvContent += '\n"Department Summary"\n';
    csvContent += '"Total Departments","' + calculateTotalDepartments() + '"\n';
    csvContent += '"Active Departments","' + calculateActiveDepartments() + '"\n';
    csvContent += '"Default Departments","' + calculateDefaultDepartments() + '"\n';
    csvContent += '"Inactive Departments","' + calculateInactiveDepartments() + '"\n';
    
    // Download file
    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "department_report.csv");
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
    showAlert('Refreshing department data...', 'info');
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
            $('#departmentSearch').focus();
        }
        
        // Escape to close modals
        if (e.keyCode === 27) {
            $('.department-modal-overlay, .export-modal-overlay').fadeOut(300, function() {
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
        .department-modal-overlay,
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
        
        .department-modal,
        .export-modal {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .department-modal-header,
        .export-modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .department-modal-content,
        .export-modal-content {
            padding: 1.5rem;
        }
        
        .department-trend-chart {
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
        
        .department-trend {
            margin-top: 0.5rem;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .department-trend.trend-up {
            color: #27ae60;
        }
        
        .department-trend.trend-down {
            color: #e74c3c;
        }
        
        .department-breakdown {
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
    console.error('Add Department Error:', e.error);
    showAlert('An error occurred. Please refresh the page.', 'error');
});

// Performance monitoring
window.addEventListener('load', function() {
    console.log('Add Department page loaded successfully');
    
    // Log performance metrics
    if (window.performance && window.performance.timing) {
        var loadTime = window.performance.timing.loadEventEnd - window.performance.timing.navigationStart;
        console.log('Page load time:', loadTime + 'ms');
    }
});

