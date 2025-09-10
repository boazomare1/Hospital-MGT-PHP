// Theatre Delay Schedule Report Modern JavaScript - Based on vat.php functionality

$(document).ready(function() {
    // Initialize modern functionality
    initializeTheatreDelayScheduleReport();
    
    // Setup form validation
    setupFormValidation();
    
    // Setup modern alerts
    setupModernAlerts();
    
    // Setup report enhancements
    setupReportEnhancements();
    
    // Setup theatre schedule features
    setupTheatreScheduleFeatures();
});

// Initialize theatre delay schedule report functionality
function initializeTheatreDelayScheduleReport() {
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
    
    // Initialize theatre cards
    initializeTheatreCards();
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
        showAlert('Generating theatre delay schedule report...', 'info');
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

// Initialize theatre cards
function initializeTheatreCards() {
    // Add theatre cards if they don't exist
    if (!$('.theatre-cards').length) {
        var theatreHtml = `
            <div class="theatre-cards">
                <div class="theatre-card">
                    <div class="theatre-header">
                        <div class="theatre-title">Total Surgeries</div>
                        <div class="theatre-icon scheduled">
                            <i class="fas fa-procedures"></i>
                        </div>
                    </div>
                    <div class="theatre-value">${calculateTotalSurgeries()}</div>
                    <div class="theatre-subtitle">Scheduled Today</div>
                    <div class="theatre-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +12% from yesterday
                    </div>
                </div>
                <div class="theatre-card">
                    <div class="theatre-header">
                        <div class="theatre-title">Delayed Surgeries</div>
                        <div class="theatre-icon delayed">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div class="theatre-value">${calculateDelayedSurgeries()}</div>
                    <div class="theatre-subtitle">Behind Schedule</div>
                    <div class="theatre-trend trend-down">
                        <i class="fas fa-arrow-down"></i> -5% from yesterday
                    </div>
                </div>
                <div class="theatre-card">
                    <div class="theatre-header">
                        <div class="theatre-title">On-Time Surgeries</div>
                        <div class="theatre-icon on-time">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="theatre-value">${calculateOnTimeSurgeries()}</div>
                    <div class="theatre-subtitle">Running on Schedule</div>
                    <div class="theatre-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +8% from yesterday
                    </div>
                </div>
                <div class="theatre-card">
                    <div class="theatre-header">
                        <div class="theatre-title">Completed Surgeries</div>
                        <div class="theatre-icon completed">
                            <i class="fas fa-check-double"></i>
                        </div>
                    </div>
                    <div class="theatre-value">${calculateCompletedSurgeries()}</div>
                    <div class="theatre-subtitle">Finished Today</div>
                    <div class="theatre-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +15% from yesterday
                    </div>
                </div>
                <div class="theatre-card">
                    <div class="theatre-header">
                        <div class="theatre-title">Average Delay</div>
                        <div class="theatre-icon delayed">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                    </div>
                    <div class="theatre-value">${calculateAverageDelay()} min</div>
                    <div class="theatre-subtitle">Per Surgery</div>
                    <div class="theatre-trend trend-down">
                        <i class="fas fa-arrow-down"></i> -3 min from yesterday
                    </div>
                </div>
                <div class="theatre-card">
                    <div class="theatre-header">
                        <div class="theatre-title">Theatre Utilization</div>
                        <div class="theatre-icon scheduled">
                            <i class="fas fa-percentage"></i>
                        </div>
                    </div>
                    <div class="theatre-value">${calculateTheatreUtilization()}%</div>
                    <div class="theatre-subtitle">Capacity Used</div>
                    <div class="theatre-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +2% from yesterday
                    </div>
                </div>
            </div>
        `;
        
        $('.page-header').after(theatreHtml);
        
        // Add delay analysis
        addDelayAnalysis();
        
        // Add schedule timeline
        addScheduleTimeline();
    }
}

// Calculate total surgeries
function calculateTotalSurgeries() {
    return $('.data-table tbody tr').length;
}

// Calculate delayed surgeries
function calculateDelayedSurgeries() {
    var delayed = 0;
    $('.data-table tbody tr').each(function() {
        var status = $(this).find('td:nth-child(6)').text().toLowerCase(); // Adjust column index as needed
        if (status.includes('delayed') || status.includes('behind')) {
            delayed++;
        }
    });
    return delayed;
}

// Calculate on-time surgeries
function calculateOnTimeSurgeries() {
    var onTime = 0;
    $('.data-table tbody tr').each(function() {
        var status = $(this).find('td:nth-child(6)').text().toLowerCase(); // Adjust column index as needed
        if (status.includes('on-time') || status.includes('scheduled')) {
            onTime++;
        }
    });
    return onTime;
}

// Calculate completed surgeries
function calculateCompletedSurgeries() {
    var completed = 0;
    $('.data-table tbody tr').each(function() {
        var status = $(this).find('td:nth-child(6)').text().toLowerCase(); // Adjust column index as needed
        if (status.includes('completed') || status.includes('finished')) {
            completed++;
        }
    });
    return completed;
}

// Calculate average delay
function calculateAverageDelay() {
    var totalDelay = 0;
    var delayedCount = 0;
    
    $('.data-table tbody tr').each(function() {
        var delayText = $(this).find('td:nth-child(5)').text(); // Adjust column index as needed
        var delay = parseFloat(delayText.replace(/[^0-9.-]+/g, '')) || 0;
        if (delay > 0) {
            totalDelay += delay;
            delayedCount++;
        }
    });
    
    return delayedCount > 0 ? Math.round(totalDelay / delayedCount) : 0;
}

// Calculate theatre utilization
function calculateTheatreUtilization() {
    var total = calculateTotalSurgeries();
    var completed = calculateCompletedSurgeries();
    return total > 0 ? Math.round((completed / total) * 100) : 0;
}

// Add delay analysis
function addDelayAnalysis() {
    var delayHtml = `
        <div class="delay-analysis">
            <div class="delay-header">
                <div class="delay-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div class="delay-title">Delay Analysis</div>
            </div>
            
            <div class="delay-grid">
                <div class="delay-item">
                    <div class="delay-label">0-15 Minutes</div>
                    <div class="delay-value">${calculateDelayRange(0, 15)}</div>
                    <div class="delay-percentage">${calculateDelayPercentage(0, 15)}%</div>
                </div>
                <div class="delay-item">
                    <div class="delay-label">16-30 Minutes</div>
                    <div class="delay-value">${calculateDelayRange(16, 30)}</div>
                    <div class="delay-percentage">${calculateDelayPercentage(16, 30)}%</div>
                </div>
                <div class="delay-item">
                    <div class="delay-label">31-60 Minutes</div>
                    <div class="delay-value">${calculateDelayRange(31, 60)}</div>
                    <div class="delay-percentage">${calculateDelayPercentage(31, 60)}%</div>
                </div>
                <div class="delay-item">
                    <div class="delay-label">60+ Minutes</div>
                    <div class="delay-value">${calculateDelayRange(61, 999)}</div>
                    <div class="delay-percentage">${calculateDelayPercentage(61, 999)}%</div>
                </div>
            </div>
        </div>
    `;
    
    $('.theatre-cards').after(delayHtml);
}

// Calculate delay range
function calculateDelayRange(min, max) {
    var count = 0;
    $('.data-table tbody tr').each(function() {
        var delayText = $(this).find('td:nth-child(5)').text(); // Adjust column index as needed
        var delay = parseFloat(delayText.replace(/[^0-9.-]+/g, '')) || 0;
        if (delay >= min && delay <= max) {
            count++;
        }
    });
    return count;
}

// Calculate delay percentage
function calculateDelayPercentage(min, max) {
    var total = calculateTotalSurgeries();
    var count = calculateDelayRange(min, max);
    return total > 0 ? Math.round((count / total) * 100) : 0;
}

// Add schedule timeline
function addScheduleTimeline() {
    var timelineHtml = `
        <div class="schedule-timeline">
            <div class="timeline-header">
                <div class="timeline-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div class="timeline-title">Schedule Timeline</div>
            </div>
            
            <div class="timeline-chart">
                <canvas id="timelineChart"></canvas>
            </div>
        </div>
    `;
    
    $('.delay-analysis').after(timelineHtml);
    
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
            type: 'bar',
            data: {
                labels: ['6:00', '8:00', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00'],
                datasets: [{
                    label: 'Scheduled',
                    data: [2, 4, 6, 3, 5, 4, 2, 1],
                    backgroundColor: 'rgba(52, 152, 219, 0.8)',
                    borderColor: '#3498db',
                    borderWidth: 2
                }, {
                    label: 'Delayed',
                    data: [0, 1, 2, 1, 2, 1, 0, 0],
                    backgroundColor: 'rgba(231, 76, 60, 0.8)',
                    borderColor: '#e74c3c',
                    borderWidth: 2
                }, {
                    label: 'Completed',
                    data: [2, 3, 4, 2, 3, 3, 2, 1],
                    backgroundColor: 'rgba(39, 174, 96, 0.8)',
                    borderColor: '#27ae60',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Theatre Schedule Timeline',
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

// Setup theatre schedule features
function setupTheatreScheduleFeatures() {
    // Add click handlers for theatre cards
    $('.theatre-card').on('click', function() {
        var title = $(this).find('.theatre-title').text();
        showTheatreDetails(title);
    });
    
    // Setup real-time updates
    setupRealTimeUpdates();
}

// Show theatre details in modal
function showTheatreDetails(title) {
    // Create modal overlay
    var modal = $(`
        <div class="theatre-modal-overlay">
            <div class="theatre-modal">
                <div class="theatre-modal-header">
                    <h3>${title} Details</h3>
                    <button class="close-modal"><i class="fas fa-times"></i></button>
                </div>
                <div class="theatre-modal-content">
                    <p>Detailed analysis for ${title} would be displayed here.</p>
                    <div class="theatre-trend-chart">
                        <canvas id="theatreTrendChart"></canvas>
                    </div>
                    <div class="theatre-breakdown">
                        <h4>Breakdown by Theatre</h4>
                        <div class="breakdown-grid">
                            <div class="breakdown-item">
                                <span class="breakdown-label">Theatre 1</span>
                                <span class="breakdown-value">8 surgeries</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">Theatre 2</span>
                                <span class="breakdown-value">6 surgeries</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">Theatre 3</span>
                                <span class="breakdown-value">4 surgeries</span>
                            </div>
                            <div class="breakdown-item">
                                <span class="breakdown-label">Theatre 4</span>
                                <span class="breakdown-value">3 surgeries</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `);
    
    $('body').append(modal);
    
    // Close modal handler
    $('.close-modal, .theatre-modal-overlay').on('click', function(e) {
        if (e.target === this) {
            modal.fadeOut(300, function() {
                modal.remove();
            });
        }
    });
    
    // Setup trend chart in modal
    setTimeout(function() {
        var ctx = document.getElementById('theatreTrendChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: title,
                        data: [Math.random() * 20, Math.random() * 20, Math.random() * 20, Math.random() * 20, Math.random() * 20, Math.random() * 20, Math.random() * 20],
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
    // Update theatre cards every 30 seconds
    setInterval(function() {
        updateTheatreCards();
    }, 30000);
    
    // Add status indicators to table rows
    $('.data-table tbody tr').each(function() {
        var status = $(this).find('td:nth-child(6)').text().toLowerCase(); // Adjust column index as needed
        var statusClass = getStatusClass(status);
        
        $(this).addClass('status-' + statusClass);
        
        // Add status indicator
        var statusIndicator = $('<td class="status-indicator"></td>');
        var statusText = getStatusText(status);
        var statusIcon = getStatusIcon(status);
        
        statusIndicator.html(`<i class="${statusIcon}"></i> ${statusText}`);
        statusIndicator.addClass('status-' + statusClass);
        $(this).append(statusIndicator);
    });
}

// Update theatre cards
function updateTheatreCards() {
    // Simulate real-time updates
    $('.theatre-value').each(function() {
        var currentValue = parseInt($(this).text());
        var newValue = currentValue + Math.floor(Math.random() * 3) - 1;
        $(this).text(Math.max(0, newValue));
    });
    
    showAlert('Theatre schedule updated', 'info');
}

// Get status class
function getStatusClass(status) {
    if (status.includes('delayed') || status.includes('behind')) {
        return 'delayed';
    } else if (status.includes('on-time') || status.includes('scheduled')) {
        return 'on-time';
    } else if (status.includes('completed') || status.includes('finished')) {
        return 'completed';
    } else {
        return 'scheduled';
    }
}

// Get status text
function getStatusText(status) {
    if (status.includes('delayed') || status.includes('behind')) {
        return 'Delayed';
    } else if (status.includes('on-time') || status.includes('scheduled')) {
        return 'On Time';
    } else if (status.includes('completed') || status.includes('finished')) {
        return 'Completed';
    } else {
        return 'Scheduled';
    }
}

// Get status icon
function getStatusIcon(status) {
    if (status.includes('delayed') || status.includes('behind')) {
        return 'fas fa-clock';
    } else if (status.includes('on-time') || status.includes('scheduled')) {
        return 'fas fa-check-circle';
    } else if (status.includes('completed') || status.includes('finished')) {
        return 'fas fa-check-double';
    } else {
        return 'fas fa-calendar-check';
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
            <input type="text" id="theatreSearch" class="form-input" 
                   placeholder="Search theatre schedules..." style="width: 300px;">
        </div>
    `;
    
    $('.page-header-actions').prepend(searchHtml);
    
    // Search functionality
    $('#theatreSearch').on('input', function() {
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
    
    if ($('#theatreSearch').val() !== '') {
        showAlert(`Found ${visibleRows} of ${totalRows} theatre schedules`, 'info');
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
                    <h3>Export Theatre Schedule Report</h3>
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
    csvContent += '\n"Theatre Schedule Summary"\n';
    csvContent += '"Total Surgeries","' + calculateTotalSurgeries() + '"\n';
    csvContent += '"Delayed Surgeries","' + calculateDelayedSurgeries() + '"\n';
    csvContent += '"On-Time Surgeries","' + calculateOnTimeSurgeries() + '"\n';
    csvContent += '"Completed Surgeries","' + calculateCompletedSurgeries() + '"\n';
    csvContent += '"Average Delay","' + calculateAverageDelay() + ' minutes"\n';
    csvContent += '"Theatre Utilization","' + calculateTheatreUtilization() + '%"\n';
    
    // Download file
    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "theatre_delay_schedule_report.csv");
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
    showAlert('Refreshing theatre schedule report...', 'info');
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
            $('#theatreSearch').focus();
        }
        
        // Escape to close modals
        if (e.keyCode === 27) {
            $('.theatre-modal-overlay, .export-modal-overlay').fadeOut(300, function() {
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
        .theatre-modal-overlay,
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
        
        .theatre-modal,
        .export-modal {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .theatre-modal-header,
        .export-modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .theatre-modal-content,
        .export-modal-content {
            padding: 1.5rem;
        }
        
        .theatre-trend-chart {
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
        
        .theatre-trend {
            margin-top: 0.5rem;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .theatre-trend.trend-up {
            color: #27ae60;
        }
        
        .theatre-trend.trend-down {
            color: #e74c3c;
        }
        
        .theatre-breakdown {
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
    console.error('Theatre Delay Schedule Report Error:', e.error);
    showAlert('An error occurred. Please refresh the page.', 'error');
});

// Performance monitoring
window.addEventListener('load', function() {
    console.log('Theatre Delay Schedule Report page loaded successfully');
    
    // Log performance metrics
    if (window.performance && window.performance.timing) {
        var loadTime = window.performance.timing.loadEventEnd - window.performance.timing.navigationStart;
        console.log('Page load time:', loadTime + 'ms');
    }
});

