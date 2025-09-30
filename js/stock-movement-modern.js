/**
 * MedStar Stock Movement Modern JavaScript
 * Handles sidebar functionality, charts, and modern UI interactions
 */

// Global variables
let stockMovementChart = null;
let isSidebarCollapsed = false;

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeSidebar();
    initializeCharts();
    setupEventListeners();
    restoreSidebarState();
    updateDateTime();
    
    // Update datetime every minute
    setInterval(updateDateTime, 60000);
});

/**
 * Initialize sidebar functionality
 */
function initializeSidebar() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }
    
    if (menuToggle) {
        menuToggle.addEventListener('click', toggleSidebar);
    }
    
    // Handle window resize
    window.addEventListener('resize', handleWindowResize);
}

/**
 * Toggle sidebar visibility
 */
function toggleSidebar() {
    const sidebar = document.getElementById('leftSidebar');
    const toggleButton = document.getElementById('sidebarToggle');
    const menuToggle = document.getElementById('menuToggle');
    
    if (!sidebar) return;
    
    // Check if we're on mobile
    const isMobile = window.innerWidth <= 768;
    
    if (isMobile) {
        // On mobile, toggle show/hide
        sidebar.classList.toggle('show');
    } else {
        // On desktop, toggle collapsed/expanded
        isSidebarCollapsed = !isSidebarCollapsed;
        
        if (isSidebarCollapsed) {
            sidebar.classList.add('collapsed');
            if (toggleButton) {
                toggleButton.innerHTML = '<i class="fas fa-chevron-right"></i>';
            }
            if (menuToggle) {
                menuToggle.innerHTML = '<i class="fas fa-chevron-right"></i>';
            }
        } else {
            sidebar.classList.remove('collapsed');
            if (toggleButton) {
                toggleButton.innerHTML = '<i class="fas fa-chevron-left"></i>';
            }
            if (menuToggle) {
                menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
            }
        }
        
        // Save state to localStorage
        localStorage.setItem('sidebarCollapsed', isSidebarCollapsed);
    }
}

/**
 * Restore sidebar state from localStorage
 */
function restoreSidebarState() {
    const savedState = localStorage.getItem('sidebarCollapsed');
    const isMobile = window.innerWidth <= 768;
    
    if (!isMobile && savedState === 'true') {
        isSidebarCollapsed = true;
        const sidebar = document.getElementById('leftSidebar');
        const toggleButton = document.getElementById('sidebarToggle');
        const menuToggle = document.getElementById('menuToggle');
        
        if (sidebar) {
            sidebar.classList.add('collapsed');
        }
        if (toggleButton) {
            toggleButton.innerHTML = '<i class="fas fa-chevron-right"></i>';
        }
        if (menuToggle) {
            menuToggle.innerHTML = '<i class="fas fa-chevron-right"></i>';
        }
    }
}

/**
 * Handle window resize events
 */
function handleWindowResize() {
    const sidebar = document.getElementById('leftSidebar');
    const menuToggle = document.getElementById('menuToggle');
    
    if (window.innerWidth <= 768) {
        // Mobile view
        if (sidebar) {
            sidebar.classList.add('mobile');
            sidebar.classList.remove('collapsed');
            sidebar.classList.remove('show');
        }
        if (menuToggle) {
            menuToggle.style.display = 'block';
        }
    } else {
        // Desktop view
        if (sidebar) {
            sidebar.classList.remove('mobile');
            sidebar.classList.remove('show');
        }
        if (menuToggle) {
            menuToggle.style.display = 'block';
        }
        
        // Restore collapsed state on desktop
        restoreSidebarState();
    }
}

/**
 * Update current date and time
 */
function updateDateTime() {
    const now = new Date();
    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    
    const dateTimeString = now.toLocaleDateString('en-US', options);
    const dateTimeElement = document.getElementById('currentDateTime');
    
    if (dateTimeElement) {
        dateTimeElement.textContent = dateTimeString;
    }
}

/**
 * Setup event listeners for various UI interactions
 */
function setupEventListeners() {
    // Form validation
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', validateForm);
    }
    
    // Chart toggle
    const chartToggleBtn = document.querySelector('[onclick="toggleChartView()"]');
    if (chartToggleBtn) {
        chartToggleBtn.addEventListener('click', toggleChartView);
    }
    
    // Export functionality
    const exportBtn = document.querySelector('[onclick="exportToExcel()"]');
    if (exportBtn) {
        exportBtn.addEventListener('click', exportToExcel);
    }
    
    // Print functionality
    const printBtn = document.querySelector('[onclick="printReport()"]');
    if (printBtn) {
        printBtn.addEventListener('click', printReport);
    }
    
    // Reset functionality
    const resetBtn = document.querySelector('[onclick="resetForm()"]');
    if (resetBtn) {
        resetBtn.addEventListener('click', resetForm);
    }
    
    // Report type change
    const mainSearchSelect = document.getElementById('mainsearch');
    if (mainSearchSelect) {
        mainSearchSelect.addEventListener('change', handleReportTypeChange);
    }
    
    // Location change
    const locationSelect = document.getElementById('location');
    if (locationSelect) {
        locationSelect.addEventListener('change', handleLocationChange);
    }
}

/**
 * Handle report type change
 */
function handleReportTypeChange() {
    const mainSearchSelect = document.getElementById('mainsearch');
    const trcat = document.getElementById('trcat');
    const trsearch = document.getElementById('trsearch');
    
    if (!mainSearchSelect || !trcat || !trsearch) return;
    
    const selectedValue = mainSearchSelect.value;
    
    if (selectedValue === '1') {
        // Summary - hide category and search
        trcat.style.display = 'none';
        trsearch.style.display = 'none';
    } else {
        // Detail or Detail with Batch - show category and search
        trcat.style.display = '';
        trsearch.style.display = '';
    }
}

/**
 * Handle location change
 */
function handleLocationChange() {
    const locationSelect = document.getElementById('location');
    const storeSelect = document.getElementById('store');
    
    if (!locationSelect || !storeSelect) return;
    
    const selectedLocation = locationSelect.value;
    
    if (selectedLocation) {
        // Show loading state
        storeSelect.innerHTML = '<option value="">Loading stores...</option>';
        
        // Call store function (legacy compatibility)
        if (typeof storefunction === 'function') {
            storefunction(selectedLocation);
        }
    } else {
        storeSelect.innerHTML = '<option value="">Select Store</option>';
    }
}

/**
 * Validate form before submission
 */
function validateForm(event) {
    const locationSelect = document.getElementById('location');
    const mainSearchSelect = document.getElementById('mainsearch');
    const dateFrom = document.getElementById('ADate1');
    const dateTo = document.getElementById('ADate2');
    
    if (!locationSelect.value) {
        event.preventDefault();
        showAlert('Please select a location.', 'error');
        locationSelect.focus();
        return false;
    }
    
    if (!mainSearchSelect.value) {
        event.preventDefault();
        showAlert('Please select a report type.', 'error');
        mainSearchSelect.focus();
        return false;
    }
    
    if (!dateFrom.value || !dateTo.value) {
        event.preventDefault();
        showAlert('Please select both date range fields.', 'error');
        return false;
    }
    
    if (new Date(dateFrom.value) > new Date(dateTo.value)) {
        event.preventDefault();
        showAlert('Date From cannot be greater than Date To.', 'error');
        return false;
    }
    
    // Show loading state
    const submitBtn = event.target.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;
    }
    
    return true;
}

/**
 * Initialize charts if data is available
 */
function initializeCharts() {
    // Check if Chart.js is available and we have data
    if (typeof Chart !== 'undefined' && window.stockMovementData) {
        createStockMovementChart();
    }
}

/**
 * Create stock movement chart
 */
function createStockMovementChart() {
    const ctx = document.getElementById('stockMovementChart');
    if (!ctx) return;
    
    // Destroy existing chart
    if (stockMovementChart) {
        stockMovementChart.destroy();
    }
    
    // Get data from global variable or calculate from page data
    const chartData = getStockMovementDataFromPage();
    
    stockMovementChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Opening Stock', 'Purchase', 'Purchase Returns', 'Receipts', 'Issued To Dept', 'Sales', 'Refunds', 'Own Usage', 'Physical Excess', 'Physical Short', 'Closing Stock'],
            datasets: [{
                label: 'Stock Movement',
                data: [
                    chartData.opening,
                    chartData.purchase,
                    chartData.preturn,
                    chartData.receipts,
                    chartData.transferout,
                    chartData.sales,
                    chartData.refunds,
                    chartData.ownusage,
                    chartData.excess,
                    chartData.short,
                    chartData.closing
                ],
                backgroundColor: [
                    '#3b82f6', // Opening - Blue
                    '#f59e0b', // Purchase - Orange
                    '#ef4444', // Purchase Returns - Red
                    '#10b981', // Receipts - Green
                    '#8b5cf6', // Transfer Out - Purple
                    '#dc2626', // Sales - Dark Red
                    '#059669', // Refunds - Dark Green
                    '#d97706', // Own Usage - Dark Orange
                    '#0891b2', // Excess - Cyan
                    '#be123c', // Short - Rose
                    '#7c3aed'  // Closing - Violet
                ],
                borderWidth: 1,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed.y || 0;
                            return label + ': ' + formatNumber(value);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return formatNumber(value);
                        }
                    }
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 0
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutQuart'
            }
        }
    });
}

/**
 * Get stock movement data from the page summary cards
 */
function getStockMovementDataFromPage() {
    const cards = document.querySelectorAll('.summary-card');
    const data = {
        opening: 0,
        purchase: 0,
        preturn: 0,
        receipts: 0,
        transferout: 0,
        sales: 0,
        refunds: 0,
        ownusage: 0,
        excess: 0,
        short: 0,
        closing: 0
    };
    
    cards.forEach(card => {
        const amount = card.querySelector('h3');
        if (amount) {
            const value = parseFloat(amount.textContent.replace(/[^\d.-]/g, ''));
            
            if (card.classList.contains('total-opening')) {
                data.opening = value;
            } else if (card.classList.contains('total-purchase')) {
                data.purchase = value;
            } else if (card.classList.contains('total-sales')) {
                data.sales = value;
            } else if (card.classList.contains('total-closing')) {
                data.closing = value;
            }
        }
    });
    
    // Get additional data from totals row if available
    const totalsRow = document.querySelector('.totals-row');
    if (totalsRow) {
        const cells = totalsRow.querySelectorAll('td');
        if (cells.length >= 12) {
            data.opening = parseFloat(cells[1]?.textContent.replace(/[^\d.-]/g, '') || 0);
            data.purchase = parseFloat(cells[2]?.textContent.replace(/[^\d.-]/g, '') || 0);
            data.preturn = parseFloat(cells[3]?.textContent.replace(/[^\d.-]/g, '') || 0);
            data.receipts = parseFloat(cells[4]?.textContent.replace(/[^\d.-]/g, '') || 0);
            data.transferout = parseFloat(cells[5]?.textContent.replace(/[^\d.-]/g, '') || 0);
            data.sales = parseFloat(cells[6]?.textContent.replace(/[^\d.-]/g, '') || 0);
            data.refunds = parseFloat(cells[7]?.textContent.replace(/[^\d.-]/g, '') || 0);
            data.ownusage = parseFloat(cells[8]?.textContent.replace(/[^\d.-]/g, '') || 0);
            data.excess = parseFloat(cells[9]?.textContent.replace(/[^\d.-]/g, '') || 0);
            data.short = parseFloat(cells[10]?.textContent.replace(/[^\d.-]/g, '') || 0);
            data.closing = parseFloat(cells[11]?.textContent.replace(/[^\d.-]/g, '') || 0);
        }
    }
    
    return data;
}

/**
 * Toggle chart view visibility
 */
function toggleChartView() {
    const chartSection = document.getElementById('chartSection');
    const chartToggleBtn = document.querySelector('[onclick="toggleChartView()"]');
    
    if (!chartSection) return;
    
    if (chartSection.style.display === 'none' || !chartSection.style.display) {
        chartSection.style.display = 'block';
        if (chartToggleBtn) {
            chartToggleBtn.innerHTML = '<i class="fas fa-table"></i> Table View';
        }
        
        // Initialize chart if not already created
        if (!stockMovementChart) {
            createStockMovementChart();
        }
        
        // Scroll to chart
        chartSection.scrollIntoView({ behavior: 'smooth' });
    } else {
        chartSection.style.display = 'none';
        if (chartToggleBtn) {
            chartToggleBtn.innerHTML = '<i class="fas fa-chart-bar"></i> Chart View';
        }
    }
}

/**
 * Export data to Excel
 */
function exportToExcel() {
    // Get current URL parameters
    const formData = new FormData(document.querySelector('.search-form'));
    
    // Build export URL
    let exportUrl = 'xl_fullstockmovement.php?';
    exportUrl += 'mainsearch=' + encodeURIComponent(formData.get('mainsearch') || '');
    exportUrl += '&frmflag1=' + encodeURIComponent(formData.get('frmflag1') || '');
    exportUrl += '&searchitemcode=' + encodeURIComponent(formData.get('searchitemcode') || '');
    exportUrl += '&categoryname=' + encodeURIComponent(formData.get('categoryname') || '');
    exportUrl += '&location=' + encodeURIComponent(formData.get('location') || '');
    exportUrl += '&store=' + encodeURIComponent(formData.get('store') || '');
    exportUrl += '&ADate1=' + encodeURIComponent(formData.get('ADate1') || '');
    exportUrl += '&ADate2=' + encodeURIComponent(formData.get('ADate2') || '');
    
    // Open export in new window
    window.open(exportUrl, '_blank');
    
    showAlert('Export initiated successfully!', 'success');
}

/**
 * Print the report
 */
function printReport() {
    // Hide sidebar and other non-printable elements
    const sidebar = document.getElementById('leftSidebar');
    const floatingToggle = document.querySelector('.floating-menu-toggle');
    const cardActions = document.querySelectorAll('.card-actions');
    const formActions = document.querySelectorAll('.form-actions');
    
    if (sidebar) sidebar.style.display = 'none';
    if (floatingToggle) floatingToggle.style.display = 'none';
    cardActions.forEach(action => action.style.display = 'none');
    formActions.forEach(action => action.style.display = 'none');
    
    // Print
    window.print();
    
    // Restore elements
    if (sidebar) sidebar.style.display = '';
    if (floatingToggle) floatingToggle.style.display = '';
    cardActions.forEach(action => action.style.display = '');
    formActions.forEach(action => action.style.display = '');
    
    showAlert('Print dialog opened.', 'info');
}

/**
 * Reset form to default values
 */
function resetForm() {
    const form = document.querySelector('.search-form');
    if (form) {
        form.reset();
        
        // Set default dates
        const today = new Date();
        const lastWeek = new Date();
        lastWeek.setDate(today.getDate() - 7);
        
        const dateFrom = document.getElementById('ADate1');
        const dateTo = document.getElementById('ADate2');
        
        if (dateFrom) {
            dateFrom.value = lastWeek.toISOString().split('T')[0];
        }
        if (dateTo) {
            dateTo.value = today.toISOString().split('T')[0];
        }
        
        // Reset report type visibility
        handleReportTypeChange();
        
        showAlert('Form reset successfully!', 'info');
    }
}

/**
 * Show alert message
 */
function showAlert(message, type = 'info') {
    // Remove existing alerts
    const existingAlerts = document.querySelectorAll('.alert-message');
    existingAlerts.forEach(alert => alert.remove());
    
    // Create new alert
    const alert = document.createElement('div');
    alert.className = `alert-message alert-${type}`;
    alert.innerHTML = `
        <div class="alert-content">
            <i class="fas fa-${getAlertIcon(type)}"></i>
            <span>${message}</span>
            <button class="alert-close" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    // Add styles
    alert.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
        background: ${getAlertColor(type)};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        animation: slideIn 0.3s ease;
        max-width: 400px;
    `;
    
    // Add to page
    document.body.appendChild(alert);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (alert.parentElement) {
            alert.remove();
        }
    }, 5000);
}

/**
 * Get alert icon based on type
 */
function getAlertIcon(type) {
    const icons = {
        'success': 'check-circle',
        'error': 'exclamation-circle',
        'warning': 'exclamation-triangle',
        'info': 'info-circle'
    };
    return icons[type] || 'info-circle';
}

/**
 * Get alert color based on type
 */
function getAlertColor(type) {
    const colors = {
        'success': '#10b981',
        'error': '#ef4444',
        'warning': '#f59e0b',
        'info': '#3b82f6'
    };
    return colors[type] || '#3b82f6';
}

/**
 * Format number with commas
 */
function formatNumber(num) {
    return new Intl.NumberFormat('en-US').format(num);
}

/**
 * Debounce function for performance
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Throttle function for scroll events
 */
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    }
}

/**
 * Add loading state to element
 */
function addLoadingState(element) {
    element.classList.add('loading');
    element.disabled = true;
}

/**
 * Remove loading state from element
 */
function removeLoadingState(element) {
    element.classList.remove('loading');
    element.disabled = false;
}

/**
 * Smooth scroll to element
 */
function smoothScrollTo(element) {
    element.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}

/**
 * Check if element is in viewport
 */
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

/**
 * Animate counter numbers
 */
function animateCounter(element, start, end, duration) {
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        const current = Math.floor(progress * (end - start) + start);
        element.textContent = formatNumber(current);
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}

// Add CSS animation for alerts
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    .alert-content {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .alert-close {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        margin-left: auto;
        padding: 0.25rem;
        border-radius: 4px;
        opacity: 0.8;
    }
    
    .alert-close:hover {
        opacity: 1;
        background: rgba(255, 255, 255, 0.2);
    }
`;
document.head.appendChild(style);
