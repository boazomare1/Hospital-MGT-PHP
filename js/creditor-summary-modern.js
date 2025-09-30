/**
 * MedStar Creditor Summary Modern JavaScript
 * Handles sidebar functionality, charts, and modern UI interactions
 */

// Global variables
let agingChart = null;
let isSidebarCollapsed = false;

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeSidebar();
    initializeCharts();
    setupEventListeners();
    restoreSidebarState();
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

/**
 * Restore sidebar state from localStorage
 */
function restoreSidebarState() {
    const savedState = localStorage.getItem('sidebarCollapsed');
    if (savedState === 'true') {
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
        }
        if (menuToggle) {
            menuToggle.style.display = 'block';
        }
    } else {
        // Desktop view
        if (sidebar) {
            sidebar.classList.remove('mobile');
        }
        if (menuToggle) {
            menuToggle.style.display = 'block';
        }
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
}

/**
 * Validate form before submission
 */
function validateForm(event) {
    const dateFrom = document.getElementById('ADate1');
    const dateTo = document.getElementById('ADate2');
    
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
    
    return true;
}

/**
 * Initialize charts if data is available
 */
function initializeCharts() {
    // Check if Chart.js is available and we have data
    if (typeof Chart !== 'undefined' && window.agingData) {
        createAgingChart();
    }
}

/**
 * Create aging analysis chart
 */
function createAgingChart() {
    const ctx = document.getElementById('agingChart');
    if (!ctx) return;
    
    // Destroy existing chart
    if (agingChart) {
        agingChart.destroy();
    }
    
    // Get data from global variable or calculate from page data
    const agingData = getAgingDataFromPage();
    
    agingChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['0-30 Days', '31-60 Days', '61-90 Days', '91-120 Days', '121-180 Days', '180+ Days'],
            datasets: [{
                data: [
                    agingData.total30,
                    agingData.total60,
                    agingData.total90,
                    agingData.total120,
                    agingData.total180,
                    agingData.total210
                ],
                backgroundColor: [
                    '#3b82f6', // Blue
                    '#f59e0b', // Orange
                    '#ef4444', // Red
                    '#dc2626', // Dark Red
                    '#991b1b', // Darker Red
                    '#7f1d1d'  // Darkest Red
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            return label + ': ' + formatCurrency(value);
                        }
                    }
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 2000
            }
        }
    });
}

/**
 * Get aging data from the page summary cards
 */
function getAgingDataFromPage() {
    const cards = document.querySelectorAll('.summary-card');
    const data = {
        total30: 0,
        total60: 0,
        total90: 0,
        total120: 0,
        total180: 0,
        total210: 0
    };
    
    cards.forEach(card => {
        const amount = card.querySelector('h3');
        if (amount) {
            const value = parseFloat(amount.textContent.replace(/[^\d.-]/g, ''));
            
            if (card.classList.contains('aging-30')) {
                data.total30 = value;
            } else if (card.classList.contains('aging-60')) {
                data.total60 = value;
            } else if (card.classList.contains('aging-90')) {
                data.total90 = value;
            } else if (card.classList.contains('aging-120')) {
                data.total120 = value;
            } else if (card.classList.contains('aging-180')) {
                data.total180 = value;
            } else if (card.classList.contains('aging-210')) {
                data.total210 = value;
            }
        }
    });
    
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
        if (!agingChart) {
            createAgingChart();
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
 * Export data to Excel (placeholder)
 */
function exportToExcel() {
    // Get current URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const formData = new FormData(document.querySelector('.search-form'));
    
    // Build export URL
    let exportUrl = 'print_fullcredittoranalysissummary.php?';
    exportUrl += 'cbfrmflag1=cbfrmflag1';
    exportUrl += '&ADate1=' + encodeURIComponent(formData.get('ADate1') || '');
    exportUrl += '&ADate2=' + encodeURIComponent(formData.get('ADate2') || '');
    exportUrl += '&searchsuppliercode=' + encodeURIComponent(formData.get('searchsuppliercode') || '');
    
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
    
    if (sidebar) sidebar.style.display = 'none';
    if (floatingToggle) floatingToggle.style.display = 'none';
    
    // Print
    window.print();
    
    // Restore elements
    if (sidebar) sidebar.style.display = '';
    if (floatingToggle) floatingToggle.style.display = '';
    
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
        const lastMonth = new Date();
        lastMonth.setMonth(today.getMonth() - 1);
        
        const dateFrom = document.getElementById('ADate1');
        const dateTo = document.getElementById('ADate2');
        
        if (dateFrom) {
            dateFrom.value = lastMonth.toISOString().split('T')[0];
        }
        if (dateTo) {
            dateTo.value = today.toISOString().split('T')[0];
        }
        
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
 * Format currency values
 */
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2
    }).format(amount);
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

