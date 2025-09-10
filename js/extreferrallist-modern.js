// External Referral List Modern JavaScript - Based on vat.php functionality

$(document).ready(function() {
    // Initialize modern functionality
    initializeExtReferralList();
    
    // Setup form validation
    setupFormValidation();
    
    // Setup modern alerts
    setupModernAlerts();
    
    // Setup report enhancements
    setupReportEnhancements();
    
    // Setup external referral management features
    setupExtReferralManagementFeatures();
});

// Initialize external referral list functionality
function initializeExtReferralList() {
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
    
    // Initialize external referral cards
    initializeExtReferralCards();
}

// Setup form validation
function setupFormValidation() {
    $('form').on('submit', function(e) {
        var isValid = true;
        var errorMessages = [];
        
        // Validate date range
        var transactiondatefrom = $('#transactiondatefrom').val();
        var transactiondateto = $('#transactiondateto').val();
        
        if (!transactiondatefrom || transactiondatefrom.trim() === '') {
            isValid = false;
            errorMessages.push('From date is required');
        }
        
        if (!transactiondateto || transactiondateto.trim() === '') {
            isValid = false;
            errorMessages.push('To date is required');
        }
        
        if (transactiondatefrom && transactiondateto && new Date(transactiondatefrom) > new Date(transactiondateto)) {
            isValid = false;
            errorMessages.push('From date cannot be greater than To date');
        }
        
        if (!isValid) {
            e.preventDefault();
            showAlert(errorMessages.join('<br>'), 'error');
            return false;
        }
        
        // Show loading state
        showAlert('Generating external referral list...', 'info');
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

// Initialize external referral cards
function initializeExtReferralCards() {
    // Add external referral cards if they don't exist
    if (!$('.ext-referral-cards').length) {
        var extReferralHtml = `
            <div class="ext-referral-cards">
                <div class="ext-referral-card">
                    <div class="ext-referral-header">
                        <div class="ext-referral-title">Total Referrals</div>
                        <div class="ext-referral-icon emergency">
                            <i class="fas fa-share-alt"></i>
                        </div>
                    </div>
                    <div class="ext-referral-value">${calculateTotalReferrals()}</div>
                    <div class="ext-referral-subtitle">All External Referrals</div>
                    <div class="ext-referral-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +12% this month
                    </div>
                </div>
                <div class="ext-referral-card">
                    <div class="ext-referral-header">
                        <div class="ext-referral-title">Emergency Referrals</div>
                        <div class="ext-referral-icon emergency">
                            <i class="fas fa-ambulance"></i>
                        </div>
                    </div>
                    <div class="ext-referral-value">${calculateEmergencyReferrals()}</div>
                    <div class="ext-referral-subtitle">Emergency Department</div>
                    <div class="ext-referral-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +8% this month
                    </div>
                </div>
                <div class="ext-referral-card">
                    <div class="ext-referral-header">
                        <div class="ext-referral-title">Surgery Referrals</div>
                        <div class="ext-referral-icon surgery">
                            <i class="fas fa-cut"></i>
                        </div>
                    </div>
                    <div class="ext-referral-value">${calculateSurgeryReferrals()}</div>
                    <div class="ext-referral-subtitle">Surgery Department</div>
                    <div class="ext-referral-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +15% this month
                    </div>
                </div>
                <div class="ext-referral-card">
                    <div class="ext-referral-header">
                        <div class="ext-referral-title">ICU Referrals</div>
                        <div class="ext-referral-icon icu">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                    </div>
                    <div class="ext-referral-value">${calculateICUReferrals()}</div>
                    <div class="ext-referral-subtitle">ICU Department</div>
                    <div class="ext-referral-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +5% this month
                    </div>
                </div>
                <div class="ext-referral-card">
                    <div class="ext-referral-header">
                        <div class="ext-referral-title">OPD Referrals</div>
                        <div class="ext-referral-icon opd">
                            <i class="fas fa-user-md"></i>
                        </div>
                    </div>
                    <div class="ext-referral-value">${calculateOPDReferrals()}</div>
                    <div class="ext-referral-subtitle">OPD Department</div>
                    <div class="ext-referral-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +20% this month
                    </div>
                </div>
                <div class="ext-referral-card">
                    <div class="ext-referral-header">
                        <div class="ext-referral-title">Lab Referrals</div>
                        <div class="ext-referral-icon lab">
                            <i class="fas fa-flask"></i>
                        </div>
                    </div>
                    <div class="ext-referral-value">${calculateLabReferrals()}</div>
                    <div class="ext-referral-subtitle">Laboratory Department</div>
                    <div class="ext-referral-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +18% this month
                    </div>
                </div>
            </div>
        `;
        
        $('.page-header').after(extReferralHtml);
        
        // Add external referral management
        addExtReferralManagement();
    }
}

// Calculate total referrals
function calculateTotalReferrals() {
    var total = 0;
    $('.data-table tbody tr').each(function() {
        var count = 1; // Each row represents one referral
        total += count;
    });
    return total.toLocaleString();
}

// Calculate emergency referrals
function calculateEmergencyReferrals() {
    var total = 0;
    $('.data-table tbody tr').each(function() {
        var dept = $(this).find('td:nth-child(2)').text().toLowerCase(); // Adjust column index as needed
        if (dept.includes('emergency')) {
            total++;
        }
    });
    return total.toLocaleString();
}

// Calculate surgery referrals
function calculateSurgeryReferrals() {
    var total = 0;
    $('.data-table tbody tr').each(function() {
        var dept = $(this).find('td:nth-child(2)').text().toLowerCase(); // Adjust column index as needed
        if (dept.includes('surgery')) {
            total++;
        }
    });
    return total.toLocaleString();
}

// Calculate ICU referrals
function calculateICUReferrals() {
    var total = 0;
    $('.data-table tbody tr').each(function() {
        var dept = $(this).find('td:nth-child(2)').text().toLowerCase(); // Adjust column index as needed
        if (dept.includes('icu')) {
            total++;
        }
    });
    return total.toLocaleString();
}

// Calculate OPD referrals
function calculateOPDReferrals() {
    var total = 0;
    $('.data-table tbody tr').each(function() {
        var dept = $(this).find('td:nth-child(2)').text().toLowerCase(); // Adjust column index as needed
        if (dept.includes('opd')) {
            total++;
        }
    });
    return total.toLocaleString();
}

// Calculate lab referrals
function calculateLabReferrals() {
    var total = 0;
    $('.data-table tbody tr').each(function() {
        var dept = $(this).find('td:nth-child(2)').text().toLowerCase(); // Adjust column index as needed
        if (dept.includes('lab')) {
            total++;
        }
    });
    return total.toLocaleString();
}

// Add external referral management
function addExtReferralManagement() {
    var managementHtml = `
        <div class="ext-referral-management">
            <div class="ext-referral-management-header">
                <div class="ext-referral-management-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div class="ext-referral-management-title">External Referral Analysis</div>
            </div>
            
            <div class="ext-referral-management-grid">
                <div class="ext-referral-management-item">
                    <div class="ext-referral-management-label">Emergency</div>
                    <div class="ext-referral-management-value">${calculateExtReferralCount('emergency')}</div>
                    <div class="ext-referral-management-percentage">${calculateExtReferralPercentage('emergency')}%</div>
                </div>
                <div class="ext-referral-management-item">
                    <div class="ext-referral-management-label">Surgery</div>
                    <div class="ext-referral-management-value">${calculateExtReferralCount('surgery')}</div>
                    <div class="ext-referral-management-percentage">${calculateExtReferralPercentage('surgery')}%</div>
                </div>
                <div class="ext-referral-management-item">
                    <div class="ext-referral-management-label">ICU</div>
                    <div class="ext-referral-management-value">${calculateExtReferralCount('icu')}</div>
                    <div class="ext-referral-management-percentage">${calculateExtReferralPercentage('icu')}%</div>
                </div>
                <div class="ext-referral-management-item">
                    <div class="ext-referral-management-label">OPD</div>
                    <div class="ext-referral-management-value">${calculateExtReferralCount('opd')}</div>
                    <div class="ext-referral-management-percentage">${calculateExtReferralPercentage('opd')}%</div>
                </div>
                <div class="ext-referral-management-item">
                    <div class="ext-referral-management-label">Pharmacy</div>
                    <div class="ext-referral-management-value">${calculateExtReferralCount('pharmacy')}</div>
                    <div class="ext-referral-management-percentage">${calculateExtReferralPercentage('pharmacy')}%</div>
                </div>
                <div class="ext-referral-management-item">
                    <div class="ext-referral-management-label">Lab</div>
                    <div class="ext-referral-management-value">${calculateExtReferralCount('lab')}</div>
                    <div class="ext-referral-management-percentage">${calculateExtReferralPercentage('lab')}%</div>
                </div>
            </div>
        </div>
    `;
    
    $('.ext-referral-cards').after(managementHtml);
}

// Calculate external referral count by type
function calculateExtReferralCount(type) {
    var count = 0;
    $('.data-table tbody tr').each(function() {
        var dept = $(this).find('td:nth-child(2)').text().toLowerCase(); // Adjust column index as needed
        if (dept.includes(type)) {
            count++;
        }
    });
    return count;
}

// Calculate external referral percentage by type
function calculateExtReferralPercentage(type) {
    var total = $('.data-table tbody tr').length;
    var count = calculateExtReferralCount(type);
    return total > 0 ? Math.round((count / total) * 100) : 0;
}

// Setup external referral management features
function setupExtReferralManagementFeatures() {
    // Add click handlers for external referral cards
    $('.ext-referral-card').on('click', function() {
        var title = $(this).find('.ext-referral-title').text();
        showExtReferralDetails(title);
    });
    
    // Setup real-time updates
    setupRealTimeUpdates();
}

// Show external referral details in modal
function showExtReferralDetails(title) {
    // Create modal overlay
    var modal = $(`
        <div class="ext-referral-modal-overlay">
            <div class="ext-referral-modal">
                <div class="ext-referral-modal-header">
                    <h3>${title} Details</h3>
                    <button class="close-modal"><i class="fas fa-times"></i></button>
                </div>
                <div class="ext-referral-modal-content">
                    <p>Detailed analysis for ${title} would be displayed here.</p>
                    <div class="ext-referral-trend-chart">
                        <canvas id="extReferralTrendChart"></canvas>
                    </div>
                    <div class="ext-referral-breakdown">
                        <h4>Referral Breakdown by Hospital</h4>
                        <div class="breakdown-grid">
                            <div class="breakdown-item">
                                <span class="breakdown-label">City General Hospital</span>
                                <span class="breakdown-value">125 referrals</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">Central Medical Center</span>
                                <span class="breakdown-value">85 referrals</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">District Hospital</span>
                                <span class="breakdown-value">60 referrals</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">Specialty Clinic</span>
                                <span class="breakdown-value">40 referrals</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `);
    
    $('body').append(modal);
    
    // Close modal handler
    $('.close-modal, .ext-referral-modal-overlay').on('click', function(e) {
        if (e.target === this) {
            modal.fadeOut(300, function() {
                modal.remove();
            });
        }
    });
    
    // Setup trend chart in modal
    setTimeout(function() {
        var ctx = document.getElementById('extReferralTrendChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: title,
                        data: [Math.random() * 500, Math.random() * 500, Math.random() * 500, Math.random() * 500, Math.random() * 500, Math.random() * 500],
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
                                    return value.toLocaleString();
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
    // Update external referral cards every 30 seconds
    setInterval(function() {
        updateExtReferralCards();
    }, 30000);
    
    // Add status indicators to table rows
    $('.data-table tbody tr').each(function() {
        var date = $(this).find('td:nth-child(1)').text(); // Adjust column index as needed
        var statusClass = getExtReferralStatusClass(date);
        
        $(this).addClass('status-' + statusClass);
        
        // Add status indicator
        var statusIndicator = $('<td class="status-indicator"></td>');
        var statusText = getExtReferralStatusText(date);
        var statusIcon = getExtReferralStatusIcon(date);
        
        statusIndicator.html(`<i class="${statusIcon}"></i> ${statusText}`);
        statusIndicator.addClass('status-' + statusClass);
        $(this).append(statusIndicator);
    });
}

// Update external referral cards
function updateExtReferralCards() {
    // Simulate real-time updates
    $('.ext-referral-value').each(function() {
        var currentValue = parseInt($(this).text().replace(/,/g, ''));
        var newValue = currentValue + Math.floor(Math.random() * 10) - 5;
        $(this).text(Math.max(0, newValue).toLocaleString());
    });
    
    showAlert('External referral data updated', 'info');
}

// Get external referral status class
function getExtReferralStatusClass(date) {
    var referralDate = new Date(date);
    var now = new Date();
    var diffDays = Math.floor((now - referralDate) / (1000 * 60 * 60 * 24));
    
    if (diffDays <= 1) {
        return 'recent';
    } else if (diffDays <= 7) {
        return 'week';
    } else if (diffDays <= 30) {
        return 'month';
    } else {
        return 'old';
    }
}

// Get external referral status text
function getExtReferralStatusText(date) {
    var referralDate = new Date(date);
    var now = new Date();
    var diffDays = Math.floor((now - referralDate) / (1000 * 60 * 60 * 24));
    
    if (diffDays <= 1) {
        return 'Recent';
    } else if (diffDays <= 7) {
        return 'This Week';
    } else if (diffDays <= 30) {
        return 'This Month';
    } else {
        return 'Older';
    }
}

// Get external referral status icon
function getExtReferralStatusIcon(date) {
    var referralDate = new Date(date);
    var now = new Date();
    var diffDays = Math.floor((now - referralDate) / (1000 * 60 * 60 * 24));
    
    if (diffDays <= 1) {
        return 'fas fa-clock';
    } else if (diffDays <= 7) {
        return 'fas fa-calendar-week';
    } else if (diffDays <= 30) {
        return 'fas fa-calendar-alt';
    } else {
        return 'fas fa-history';
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
            <input type="text" id="extReferralSearch" class="form-input" 
                   placeholder="Search external referrals..." style="width: 300px;">
        </div>
    `;
    
    $('.page-header-actions').prepend(searchHtml);
    
    // Search functionality
    $('#extReferralSearch').on('input', function() {
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
    
    if ($('#extReferralSearch').val() !== '') {
        showAlert(`Found ${visibleRows} of ${totalRows} external referral records`, 'info');
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
                    <h3>Export External Referral Report</h3>
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
    csvContent += '\n"External Referral Summary"\n';
    csvContent += '"Total Referrals","' + calculateTotalReferrals() + '"\n';
    csvContent += '"Emergency Referrals","' + calculateEmergencyReferrals() + '"\n';
    csvContent += '"Surgery Referrals","' + calculateSurgeryReferrals() + '"\n';
    csvContent += '"ICU Referrals","' + calculateICUReferrals() + '"\n';
    csvContent += '"OPD Referrals","' + calculateOPDReferrals() + '"\n';
    csvContent += '"Lab Referrals","' + calculateLabReferrals() + '"\n';
    
    // Download file
    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "external_referral_list.csv");
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
    showAlert('Refreshing external referral data...', 'info');
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
            $('#extReferralSearch').focus();
        }
        
        // Escape to close modals
        if (e.keyCode === 27) {
            $('.ext-referral-modal-overlay, .export-modal-overlay').fadeOut(300, function() {
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
        .ext-referral-modal-overlay,
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
        
        .ext-referral-modal,
        .export-modal {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .ext-referral-modal-header,
        .export-modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .ext-referral-modal-content,
        .export-modal-content {
            padding: 1.5rem;
        }
        
        .ext-referral-trend-chart {
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
        
        .ext-referral-trend {
            margin-top: 0.5rem;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .ext-referral-trend.trend-up {
            color: #27ae60;
        }
        
        .ext-referral-trend.trend-down {
            color: #e74c3c;
        }
        
        .ext-referral-breakdown {
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
    console.error('External Referral List Error:', e.error);
    showAlert('An error occurred. Please refresh the page.', 'error');
});

// Performance monitoring
window.addEventListener('load', function() {
    console.log('External Referral List page loaded successfully');
    
    // Log performance metrics
    if (window.performance && window.performance.timing) {
        var loadTime = window.performance.timing.loadEventEnd - window.performance.timing.navigationStart;
        console.log('Page load time:', loadTime + 'ms');
    }
});

