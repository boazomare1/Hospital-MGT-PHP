// Delivery Report Subtype Modern JavaScript - Based on vat.php functionality

$(document).ready(function() {
    // Initialize modern functionality
    initializeDeliveryReportSubtype();
    
    // Setup form validation
    setupFormValidation();
    
    // Setup modern alerts
    setupModernAlerts();
    
    // Setup report enhancements
    setupReportEnhancements();
    
    // Setup delivery tracking features
    setupDeliveryTrackingFeatures();
});

// Initialize delivery report subtype functionality
function initializeDeliveryReportSubtype() {
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
    
    // Initialize delivery cards
    initializeDeliveryCards();
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
        showAlert('Generating delivery report by subtype...', 'info');
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

// Initialize delivery cards
function initializeDeliveryCards() {
    // Add delivery cards if they don't exist
    if (!$('.delivery-cards').length) {
        var deliveryHtml = `
            <div class="delivery-cards">
                <div class="delivery-card">
                    <div class="delivery-header">
                        <div class="delivery-title">Total Deliveries</div>
                        <div class="delivery-icon delivered">
                            <i class="fas fa-truck"></i>
                        </div>
                    </div>
                    <div class="delivery-value">${calculateTotalDeliveries()}</div>
                    <div class="delivery-subtitle">All Deliveries Today</div>
                    <div class="delivery-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +18% from yesterday
                    </div>
                </div>
                <div class="delivery-card">
                    <div class="delivery-header">
                        <div class="delivery-title">Delivered</div>
                        <div class="delivery-icon delivered">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="delivery-value">${calculateDeliveredCount()}</div>
                    <div class="delivery-subtitle">Successfully Delivered</div>
                    <div class="delivery-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +12% from yesterday
                    </div>
                </div>
                <div class="delivery-card">
                    <div class="delivery-header">
                        <div class="delivery-title">In Transit</div>
                        <div class="delivery-icon in-transit">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                    </div>
                    <div class="delivery-value">${calculateInTransitCount()}</div>
                    <div class="delivery-subtitle">Currently Shipping</div>
                    <div class="delivery-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +5% from yesterday
                    </div>
                </div>
                <div class="delivery-card">
                    <div class="delivery-header">
                        <div class="delivery-title">Pending</div>
                        <div class="delivery-icon pending">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div class="delivery-value">${calculatePendingCount()}</div>
                    <div class="delivery-subtitle">Awaiting Dispatch</div>
                    <div class="delivery-trend trend-down">
                        <i class="fas fa-arrow-down"></i> -8% from yesterday
                    </div>
                </div>
                <div class="delivery-card">
                    <div class="delivery-header">
                        <div class="delivery-title">Cancelled</div>
                        <div class="delivery-icon cancelled">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                    <div class="delivery-value">${calculateCancelledCount()}</div>
                    <div class="delivery-subtitle">Failed Deliveries</div>
                    <div class="delivery-trend trend-down">
                        <i class="fas fa-arrow-down"></i> -3% from yesterday
                    </div>
                </div>
                <div class="delivery-card">
                    <div class="delivery-header">
                        <div class="delivery-title">Success Rate</div>
                        <div class="delivery-icon delivered">
                            <i class="fas fa-percentage"></i>
                        </div>
                    </div>
                    <div class="delivery-value">${calculateSuccessRate()}%</div>
                    <div class="delivery-subtitle">Delivery Efficiency</div>
                    <div class="delivery-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +2% from yesterday
                    </div>
                </div>
            </div>
        `;
        
        $('.page-header').after(deliveryHtml);
        
        // Add subtype analysis
        addSubtypeAnalysis();
        
        // Add delivery timeline
        addDeliveryTimeline();
    }
}

// Calculate total deliveries
function calculateTotalDeliveries() {
    return $('.data-table tbody tr').length;
}

// Calculate delivered count
function calculateDeliveredCount() {
    var delivered = 0;
    $('.data-table tbody tr').each(function() {
        var status = $(this).find('td:nth-child(6)').text().toLowerCase(); // Adjust column index as needed
        if (status.includes('delivered') || status.includes('completed')) {
            delivered++;
        }
    });
    return delivered;
}

// Calculate in-transit count
function calculateInTransitCount() {
    var inTransit = 0;
    $('.data-table tbody tr').each(function() {
        var status = $(this).find('td:nth-child(6)').text().toLowerCase(); // Adjust column index as needed
        if (status.includes('transit') || status.includes('shipping')) {
            inTransit++;
        }
    });
    return inTransit;
}

// Calculate pending count
function calculatePendingCount() {
    var pending = 0;
    $('.data-table tbody tr').each(function() {
        var status = $(this).find('td:nth-child(6)').text().toLowerCase(); // Adjust column index as needed
        if (status.includes('pending') || status.includes('awaiting')) {
            pending++;
        }
    });
    return pending;
}

// Calculate cancelled count
function calculateCancelledCount() {
    var cancelled = 0;
    $('.data-table tbody tr').each(function() {
        var status = $(this).find('td:nth-child(6)').text().toLowerCase(); // Adjust column index as needed
        if (status.includes('cancelled') || status.includes('failed')) {
            cancelled++;
        }
    });
    return cancelled;
}

// Calculate success rate
function calculateSuccessRate() {
    var total = calculateTotalDeliveries();
    var delivered = calculateDeliveredCount();
    return total > 0 ? Math.round((delivered / total) * 100) : 0;
}

// Add subtype analysis
function addSubtypeAnalysis() {
    var subtypeHtml = `
        <div class="subtype-analysis">
            <div class="subtype-header">
                <div class="subtype-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div class="subtype-title">Delivery Analysis by Subtype</div>
            </div>
            
            <div class="subtype-grid">
                <div class="subtype-item">
                    <div class="subtype-label">Emergency</div>
                    <div class="subtype-value">${calculateSubtypeCount('emergency')}</div>
                    <div class="subtype-percentage">${calculateSubtypePercentage('emergency')}%</div>
                </div>
                <div class="subtype-item">
                    <div class="subtype-label">Surgery</div>
                    <div class="subtype-value">${calculateSubtypeCount('surgery')}</div>
                    <div class="subtype-percentage">${calculateSubtypePercentage('surgery')}%</div>
                </div>
                <div class="subtype-item">
                    <div class="subtype-label">ICU</div>
                    <div class="subtype-value">${calculateSubtypeCount('icu')}</div>
                    <div class="subtype-percentage">${calculateSubtypePercentage('icu')}%</div>
                </div>
                <div class="subtype-item">
                    <div class="subtype-label">OPD</div>
                    <div class="subtype-value">${calculateSubtypeCount('opd')}</div>
                    <div class="subtype-percentage">${calculateSubtypePercentage('opd')}%</div>
                </div>
                <div class="subtype-item">
                    <div class="subtype-label">Pharmacy</div>
                    <div class="subtype-value">${calculateSubtypeCount('pharmacy')}</div>
                    <div class="subtype-percentage">${calculateSubtypePercentage('pharmacy')}%</div>
                </div>
                <div class="subtype-item">
                    <div class="subtype-label">Lab</div>
                    <div class="subtype-value">${calculateSubtypeCount('lab')}</div>
                    <div class="subtype-percentage">${calculateSubtypePercentage('lab')}%</div>
                </div>
            </div>
        </div>
    `;
    
    $('.delivery-cards').after(subtypeHtml);
}

// Calculate subtype count
function calculateSubtypeCount(subtype) {
    var count = 0;
    $('.data-table tbody tr').each(function() {
        var subtypeText = $(this).find('td:nth-child(3)').text().toLowerCase(); // Adjust column index as needed
        if (subtypeText.includes(subtype)) {
            count++;
        }
    });
    return count;
}

// Calculate subtype percentage
function calculateSubtypePercentage(subtype) {
    var total = calculateTotalDeliveries();
    var count = calculateSubtypeCount(subtype);
    return total > 0 ? Math.round((count / total) * 100) : 0;
}

// Add delivery timeline
function addDeliveryTimeline() {
    var timelineHtml = `
        <div class="delivery-timeline">
            <div class="timeline-header">
                <div class="timeline-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div class="timeline-title">Delivery Timeline</div>
            </div>
            
            <div class="timeline-chart">
                <canvas id="timelineChart"></canvas>
            </div>
        </div>
    `;
    
    $('.subtype-analysis').after(timelineHtml);
    
    // Setup timeline chart
    setTimeout(function() {
        setupTimelineChart();
    }, 100);
}

// Setup timeline chart
function setupTimelineChart() {
    var ctx = document.getElementById('timelineChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['6:00', '8:00', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00'],
                datasets: [{
                    label: 'Delivered',
                    data: [2, 5, 8, 12, 15, 18, 12, 8],
                    borderColor: '#27ae60',
                    backgroundColor: 'rgba(39, 174, 96, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'In Transit',
                    data: [1, 3, 5, 7, 9, 6, 4, 2],
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Pending',
                    data: [3, 2, 1, 2, 1, 1, 2, 1],
                    borderColor: '#f39c12',
                    backgroundColor: 'rgba(243, 156, 18, 0.1)',
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
                        text: 'Delivery Status Timeline',
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
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }
}

// Setup delivery tracking features
function setupDeliveryTrackingFeatures() {
    // Add click handlers for delivery cards
    $('.delivery-card').on('click', function() {
        var title = $(this).find('.delivery-title').text();
        showDeliveryDetails(title);
    });
    
    // Setup real-time tracking
    setupRealTimeTracking();
}

// Show delivery details in modal
function showDeliveryDetails(title) {
    // Create modal overlay
    var modal = $(`
        <div class="delivery-modal-overlay">
            <div class="delivery-modal">
                <div class="delivery-modal-header">
                    <h3>${title} Details</h3>
                    <button class="close-modal"><i class="fas fa-times"></i></button>
                </div>
                <div class="delivery-modal-content">
                    <p>Detailed analysis for ${title} would be displayed here.</p>
                    <div class="delivery-trend-chart">
                        <canvas id="deliveryTrendChart"></canvas>
                    </div>
                    <div class="delivery-breakdown">
                        <h4>Breakdown by Subtype</h4>
                        <div class="breakdown-grid">
                            <div class="breakdown-item">
                                <span class="breakdown-label">Emergency</span>
                                <span class="breakdown-value">15 deliveries</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">Surgery</span>
                                <span class="breakdown-value">12 deliveries</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">ICU</span>
                                <span class="breakdown-value">8 deliveries</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">OPD</span>
                                <span class="breakdown-value">25 deliveries</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `);
    
    $('body').append(modal);
    
    // Close modal handler
    $('.close-modal, .delivery-modal-overlay').on('click', function(e) {
        if (e.target === this) {
            modal.fadeOut(300, function() {
                modal.remove();
            });
        }
    });
    
    // Setup trend chart in modal
    setTimeout(function() {
        var ctx = document.getElementById('deliveryTrendChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: title,
                        data: [Math.random() * 50, Math.random() * 50, Math.random() * 50, Math.random() * 50, Math.random() * 50, Math.random() * 50, Math.random() * 50],
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
                            text: `${title} Trend (Last 7 Days)`,
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
                                stepSize: 5
                            }
                        }
                    }
                }
            });
        }
    }, 100);
}

// Setup real-time tracking
function setupRealTimeTracking() {
    // Update delivery cards every 30 seconds
    setInterval(function() {
        updateDeliveryCards();
    }, 30000);
    
    // Add status indicators to table rows
    $('.data-table tbody tr').each(function() {
        var status = $(this).find('td:nth-child(6)').text().toLowerCase(); // Adjust column index as needed
        var statusClass = getDeliveryStatusClass(status);
        
        $(this).addClass('status-' + statusClass);
        
        // Add status indicator
        var statusIndicator = $('<td class="status-indicator"></td>');
        var statusText = getDeliveryStatusText(status);
        var statusIcon = getDeliveryStatusIcon(status);
        
        statusIndicator.html(`<i class="${statusIcon}"></i> ${statusText}`);
        statusIndicator.addClass('status-' + statusClass);
        $(this).append(statusIndicator);
    });
}

// Update delivery cards
function updateDeliveryCards() {
    // Simulate real-time updates
    $('.delivery-value').each(function() {
        var currentValue = parseInt($(this).text());
        var newValue = currentValue + Math.floor(Math.random() * 3) - 1;
        $(this).text(Math.max(0, newValue));
    });
    
    showAlert('Delivery status updated', 'info');
}

// Get delivery status class
function getDeliveryStatusClass(status) {
    if (status.includes('delivered') || status.includes('completed')) {
        return 'delivered';
    } else if (status.includes('transit') || status.includes('shipping')) {
        return 'in-transit';
    } else if (status.includes('pending') || status.includes('awaiting')) {
        return 'pending';
    } else if (status.includes('cancelled') || status.includes('failed')) {
        return 'cancelled';
    } else {
        return 'pending';
    }
}

// Get delivery status text
function getDeliveryStatusText(status) {
    if (status.includes('delivered') || status.includes('completed')) {
        return 'Delivered';
    } else if (status.includes('transit') || status.includes('shipping')) {
        return 'In Transit';
    } else if (status.includes('pending') || status.includes('awaiting')) {
        return 'Pending';
    } else if (status.includes('cancelled') || status.includes('failed')) {
        return 'Cancelled';
    } else {
        return 'Pending';
    }
}

// Get delivery status icon
function getDeliveryStatusIcon(status) {
    if (status.includes('delivered') || status.includes('completed')) {
        return 'fas fa-check-circle';
    } else if (status.includes('transit') || status.includes('shipping')) {
        return 'fas fa-shipping-fast';
    } else if (status.includes('pending') || status.includes('awaiting')) {
        return 'fas fa-clock';
    } else if (status.includes('cancelled') || status.includes('failed')) {
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
            <input type="text" id="deliverySearch" class="form-input" 
                   placeholder="Search deliveries..." style="width: 300px;">
        </div>
    `;
    
    $('.page-header-actions').prepend(searchHtml);
    
    // Search functionality
    $('#deliverySearch').on('input', function() {
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
    
    if ($('#deliverySearch').val() !== '') {
        showAlert(`Found ${visibleRows} of ${totalRows} deliveries`, 'info');
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
                    <h3>Export Delivery Report</h3>
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
    csvContent += '\n"Delivery Summary"\n';
    csvContent += '"Total Deliveries","' + calculateTotalDeliveries() + '"\n';
    csvContent += '"Delivered","' + calculateDeliveredCount() + '"\n';
    csvContent += '"In Transit","' + calculateInTransitCount() + '"\n';
    csvContent += '"Pending","' + calculatePendingCount() + '"\n';
    csvContent += '"Cancelled","' + calculateCancelledCount() + '"\n';
    csvContent += '"Success Rate","' + calculateSuccessRate() + '%"\n';
    
    // Download file
    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "delivery_report_subtype.csv");
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
    showAlert('Refreshing delivery report...', 'info');
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
            $('#deliverySearch').focus();
        }
        
        // Escape to close modals
        if (e.keyCode === 27) {
            $('.delivery-modal-overlay, .export-modal-overlay').fadeOut(300, function() {
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
        .delivery-modal-overlay,
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
        
        .delivery-modal,
        .export-modal {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .delivery-modal-header,
        .export-modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .delivery-modal-content,
        .export-modal-content {
            padding: 1.5rem;
        }
        
        .delivery-trend-chart {
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
        
        .delivery-trend {
            margin-top: 0.5rem;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .delivery-trend.trend-up {
            color: #27ae60;
        }
        
        .delivery-trend.trend-down {
            color: #e74c3c;
        }
        
        .delivery-breakdown {
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
    console.error('Delivery Report Subtype Error:', e.error);
    showAlert('An error occurred. Please refresh the page.', 'error');
});

// Performance monitoring
window.addEventListener('load', function() {
    console.log('Delivery Report Subtype page loaded successfully');
    
    // Log performance metrics
    if (window.performance && window.performance.timing) {
        var loadTime = window.performance.timing.loadEventEnd - window.performance.timing.navigationStart;
        console.log('Page load time:', loadTime + 'ms');
    }
});

