// New Dashboard Modern JavaScript - Based on vat.php functionality

$(document).ready(function() {
    // Initialize modern functionality
    initializeDashboard();
    
    // Setup animations
    setupAnimations();
    
    // Setup charts
    setupCharts();
    
    // Setup real-time updates
    setupRealTimeUpdates();
    
    // Setup interactions
    setupInteractions();
});

// Initialize dashboard functionality
function initializeDashboard() {
    // Add fade-in animations to KPI cards
    $('.kpi-card').each(function(index) {
        $(this).addClass('fade-in-up');
        $(this).css('animation-delay', (index * 0.1) + 's');
    });
    
    // Add hover effects to charts
    $('.chart-container').hover(
        function() {
            $(this).addClass('chart-hover');
        },
        function() {
            $(this).removeClass('chart-hover');
        }
    );
    
    // Initialize tooltips
    $('[title]').each(function() {
        $(this).tooltip({
            position: { my: "left+15 center", at: "right center" }
        });
    });
}

// Setup animations
function setupAnimations() {
    // Animate KPI values on scroll
    $(window).on('scroll', function() {
        $('.kpi-value').each(function() {
            var element = $(this);
            var elementTop = element.offset().top;
            var elementBottom = elementTop + element.outerHeight();
            var viewportTop = $(window).scrollTop();
            var viewportBottom = viewportTop + $(window).height();
            
            if (elementBottom > viewportTop && elementTop < viewportBottom) {
                if (!element.hasClass('animated')) {
                    animateValue(element);
                    element.addClass('animated');
                }
            }
        });
    });
    
    // Trigger initial animation for visible elements
    $(window).trigger('scroll');
}

// Animate numerical values
function animateValue(element) {
    var value = element.text();
    var numericValue = parseFloat(value.replace(/[^0-9.-]+/g, ""));
    var prefix = value.replace(/[0-9.-]+/g, "");
    
    if (!isNaN(numericValue)) {
        element.text('0');
        var counter = 0;
        var increment = numericValue / 100;
        var timer = setInterval(function() {
            counter += increment;
            if (counter >= numericValue) {
                counter = numericValue;
                clearInterval(timer);
            }
            element.text(prefix + Math.floor(counter).toLocaleString());
        }, 20);
    }
}

// Setup charts using Chart.js
function setupCharts() {
    // Department Chart
    setupDepartmentChart();
    
    // Revenue Chart
    setupRevenueChart();
    
    // Patient Flow Chart
    setupPatientFlowChart();
    
    // Service Utilization Chart
    setupServiceUtilizationChart();
}

// Department Performance Chart
function setupDepartmentChart() {
    var ctx = document.getElementById('departmentChart');
    if (!ctx) return;
    
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['OPD', 'IPD', 'Emergency', 'Surgery', 'ICU'],
            datasets: [{
                data: [30, 25, 15, 20, 10],
                backgroundColor: [
                    '#3498db',
                    '#e74c3c',
                    '#f39c12',
                    '#27ae60',
                    '#9b59b6'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Department Patient Distribution',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                },
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

// Revenue Chart
function setupRevenueChart() {
    var ctx = document.getElementById('revenueChart');
    if (!ctx) return;
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Revenue ($)',
                data: [12000, 15000, 13000, 17000, 16000, 19000],
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
                    text: 'Monthly Revenue Trend',
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

// Patient Flow Chart
function setupPatientFlowChart() {
    var ctx = document.getElementById('patientFlowChart');
    if (!ctx) return;
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [
                {
                    label: 'New Patients',
                    data: [45, 52, 48, 61, 55, 67, 43],
                    backgroundColor: '#27ae60',
                    borderRadius: 4
                },
                {
                    label: 'Follow-ups',
                    data: [32, 38, 35, 42, 39, 45, 31],
                    backgroundColor: '#3498db',
                    borderRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Weekly Patient Flow',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                }
            },
            scales: {
                x: {
                    stacked: false
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// Service Utilization Chart
function setupServiceUtilizationChart() {
    var ctx = document.getElementById('serviceUtilizationChart');
    if (!ctx) return;
    
    new Chart(ctx, {
        type: 'radar',
        data: {
            labels: ['Lab', 'Radiology', 'Pharmacy', 'Surgery', 'Consultation', 'Emergency'],
            datasets: [{
                label: 'Utilization %',
                data: [85, 72, 90, 65, 95, 78],
                borderColor: '#e74c3c',
                backgroundColor: 'rgba(231, 76, 60, 0.2)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Service Utilization',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                }
            },
            scales: {
                r: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            }
        }
    });
}

// Setup real-time updates
function setupRealTimeUpdates() {
    // Update KPI values every 30 seconds
    setInterval(function() {
        updateKPIValues();
    }, 30000);
    
    // Add real-time indicators
    addRealTimeIndicators();
}

// Update KPI values with animation
function updateKPIValues() {
    $('.kpi-value').each(function() {
        var element = $(this);
        var currentValue = parseFloat(element.text().replace(/[^0-9.-]+/g, ""));
        
        // Simulate small random changes (±5%)
        var change = (Math.random() - 0.5) * 0.1 * currentValue;
        var newValue = Math.max(0, Math.round(currentValue + change));
        
        // Animate to new value
        animateValueChange(element, newValue);
    });
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
    $('.kpi-card').each(function() {
        var indicator = $('<div class="real-time-indicator"><i class="fas fa-circle"></i></div>');
        $(this).append(indicator);
    });
    
    // Animate indicators
    setInterval(function() {
        $('.real-time-indicator i').fadeOut(500).fadeIn(500);
    }, 2000);
}

// Setup interactions
function setupInteractions() {
    // Add click handlers for KPI cards
    $('.kpi-card').on('click', function() {
        var title = $(this).find('.kpi-title').text();
        showKPIDetails(title);
    });
    
    // Add keyboard shortcuts
    setupKeyboardShortcuts();
    
    // Add search functionality
    setupSearch();
}

// Show KPI details in modal
function showKPIDetails(title) {
    // Create modal overlay
    var modal = $(`
        <div class="kpi-modal-overlay">
            <div class="kpi-modal">
                <div class="kpi-modal-header">
                    <h3>${title} Details</h3>
                    <button class="close-modal"><i class="fas fa-times"></i></button>
                </div>
                <div class="kpi-modal-content">
                    <p>Detailed information for ${title} would be displayed here.</p>
                    <div class="kpi-trend-chart">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    `);
    
    $('body').append(modal);
    
    // Close modal handler
    $('.close-modal, .kpi-modal-overlay').on('click', function(e) {
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
                    labels: ['1h ago', '45m ago', '30m ago', '15m ago', 'Now'],
                    datasets: [{
                        label: title,
                        data: [Math.random() * 100, Math.random() * 100, Math.random() * 100, Math.random() * 100, Math.random() * 100],
                        borderColor: '#3498db',
                        backgroundColor: 'rgba(52, 152, 219, 0.1)',
                        borderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }
    }, 100);
}

// Setup keyboard shortcuts
function setupKeyboardShortcuts() {
    $(document).on('keydown', function(e) {
        // R key to refresh dashboard
        if (e.key === 'r' || e.key === 'R') {
            e.preventDefault();
            refreshDashboard();
        }
        
        // F key for fullscreen
        if (e.key === 'f' || e.key === 'F') {
            e.preventDefault();
            toggleFullscreen();
        }
        
        // Escape to close modals
        if (e.key === 'Escape') {
            $('.kpi-modal-overlay').fadeOut(300, function() {
                $(this).remove();
            });
        }
    });
}

// Setup search functionality
function setupSearch() {
    // Add search input to header
    var searchInput = $(`
        <div class="dashboard-search">
            <input type="text" placeholder="Search dashboard..." class="search-input">
            <i class="fas fa-search search-icon"></i>
        </div>
    `);
    
    $('.user-actions').prepend(searchInput);
    
    // Search functionality
    $('.search-input').on('input', function() {
        var searchTerm = $(this).val().toLowerCase();
        
        $('.kpi-card').each(function() {
            var title = $(this).find('.kpi-title').text().toLowerCase();
            if (title.includes(searchTerm) || searchTerm === '') {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
}

// Refresh dashboard
function refreshDashboard() {
    // Show loading spinner
    $('body').append('<div class="loading-overlay"><div class="loading-spinner"></div></div>');
    
    // Simulate refresh
    setTimeout(function() {
        window.location.reload();
    }, 1000);
}

// Toggle fullscreen
function toggleFullscreen() {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        }
    }
}

// Export dashboard data
function exportDashboard() {
    var data = [];
    
    $('.kpi-card').each(function() {
        var title = $(this).find('.kpi-title').text();
        var value = $(this).find('.kpi-value').text();
        var subtitle = $(this).find('.kpi-subtitle').text();
        
        data.push({
            'KPI': title,
            'Value': value,
            'Period': subtitle
        });
    });
    
    // Convert to CSV
    var csv = 'KPI,Value,Period\n';
    data.forEach(function(row) {
        csv += `"${row.KPI}","${row.Value}","${row.Period}"\n`;
    });
    
    // Download CSV
    var blob = new Blob([csv], { type: 'text/csv' });
    var url = window.URL.createObjectURL(blob);
    var link = document.createElement('a');
    link.href = url;
    link.download = 'dashboard_data.csv';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Add custom CSS for modal and other dynamic elements
function addCustomStyles() {
    var styles = `
        <style>
        .kpi-modal-overlay {
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
        
        .kpi-modal {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .kpi-modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .kpi-modal-content {
            padding: 1.5rem;
        }
        
        .kpi-trend-chart {
            height: 300px;
            margin-top: 1rem;
        }
        
        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #999;
        }
        
        .real-time-indicator {
            position: absolute;
            top: 1rem;
            right: 1rem;
            color: #27ae60;
            font-size: 0.8rem;
        }
        
        .value-updated {
            animation: flash 1s ease-in-out;
        }
        
        @keyframes flash {
            0%, 100% { background-color: transparent; }
            50% { background-color: rgba(52, 152, 219, 0.3); }
        }
        
        .dashboard-search {
            position: relative;
        }
        
        .search-input {
            padding: 0.5rem 2.5rem 0.5rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            font-size: 0.9rem;
            width: 200px;
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            outline: none;
            border-color: #3498db;
            width: 250px;
        }
        
        .search-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }
        
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
        }
        </style>
    `;
    
    $('head').append(styles);
}

// Initialize everything when document is ready
$(document).ready(function() {
    addCustomStyles();
});

// Error handling
window.addEventListener('error', function(e) {
    console.error('Dashboard Error:', e.error);
});

// Performance monitoring
window.addEventListener('load', function() {
    console.log('Dashboard loaded successfully');
    
    // Log performance metrics
    if (window.performance && window.performance.timing) {
        var loadTime = window.performance.timing.loadEventEnd - window.performance.timing.navigationStart;
        console.log('Dashboard load time:', loadTime + 'ms');
    }
});

