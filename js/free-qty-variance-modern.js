/**
 * Free Quantity Variance Report - Modern JavaScript
 * Handles sidebar functionality, form interactions, and modern UI features
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all functionality
    initializeSidebar();
    setupFormValidation();
    setupChartToggle();
    setupResponsiveFeatures();
    setupKeyboardShortcuts();
    
    // Restore sidebar state
    restoreSidebarState();
    
    console.log('Free Quantity Variance Report initialized successfully');
});

/**
 * Initialize sidebar functionality
 */
function initializeSidebar() {
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const menuToggle = document.getElementById('menuToggle');
    
    if (!sidebar || !sidebarToggle || !menuToggle) {
        console.warn('Sidebar elements not found');
        return;
    }
    
    // Sidebar toggle button
    sidebarToggle.addEventListener('click', function() {
        toggleSidebar();
    });
    
    // Floating menu toggle
    menuToggle.addEventListener('click', function() {
        toggleSidebar();
    });
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 768) {
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnToggle = menuToggle.contains(event.target);
            
            if (!isClickInsideSidebar && !isClickOnToggle && !sidebar.classList.contains('collapsed')) {
                sidebar.classList.add('collapsed');
                saveSidebarState(true);
            }
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        handleWindowResize();
    });
    
    console.log('Sidebar functionality initialized');
}

/**
 * Toggle sidebar collapsed state
 */
function toggleSidebar() {
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (!sidebar || !sidebarToggle) return;
    
    const isCollapsed = sidebar.classList.contains('collapsed');
    
    if (isCollapsed) {
        sidebar.classList.remove('collapsed');
        sidebarToggle.querySelector('i').className = 'fas fa-chevron-left';
    } else {
        sidebar.classList.add('collapsed');
        sidebarToggle.querySelector('i').className = 'fas fa-chevron-right';
    }
    
    // Save state
    saveSidebarState(!isCollapsed);
    
    // Trigger resize event for any components that need to adjust
    setTimeout(() => {
        window.dispatchEvent(new Event('resize'));
    }, 300);
    
    console.log('Sidebar toggled:', !isCollapsed ? 'expanded' : 'collapsed');
}

/**
 * Save sidebar state to localStorage
 */
function saveSidebarState(isCollapsed) {
    try {
        localStorage.setItem('sidebarCollapsed', isCollapsed.toString());
    } catch (error) {
        console.warn('Could not save sidebar state:', error);
    }
}

/**
 * Restore sidebar state from localStorage
 */
function restoreSidebarState() {
    try {
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        const sidebar = document.getElementById('leftSidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        
        if (sidebar && sidebarToggle) {
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
                sidebarToggle.querySelector('i').className = 'fas fa-chevron-right';
            } else {
                sidebar.classList.remove('collapsed');
                sidebarToggle.querySelector('i').className = 'fas fa-chevron-left';
            }
        }
    } catch (error) {
        console.warn('Could not restore sidebar state:', error);
    }
}

/**
 * Handle window resize events
 */
function handleWindowResize() {
    const sidebar = document.getElementById('leftSidebar');
    
    if (!sidebar) return;
    
    // Auto-collapse sidebar on mobile
    if (window.innerWidth <= 768) {
        sidebar.classList.add('collapsed');
    } else {
        // Restore saved state on desktop
        restoreSidebarState();
    }
    
    // Adjust any charts or other responsive elements
    if (window.varianceChart) {
        window.varianceChart.resize();
    }
}

/**
 * Setup form validation and interactions
 */
function setupFormValidation() {
    const form = document.querySelector('form[name="cbform1"]');
    const dateFromInput = document.getElementById('ADate1');
    const dateToInput = document.getElementById('ADate2');
    
    if (!form) return;
    
    // Date validation
    function validateDates() {
        const dateFrom = new Date(dateFromInput.value);
        const dateTo = new Date(dateToInput.value);
        
        if (dateFrom > dateTo) {
            showAlert('Date From cannot be greater than Date To', 'error');
            return false;
        }
        
        // Check if date range is not more than 1 year
        const oneYearAgo = new Date();
        oneYearAgo.setFullYear(oneYearAgo.getFullYear() - 1);
        
        if (dateFrom < oneYearAgo) {
            showAlert('Date range cannot be more than 1 year', 'warning');
        }
        
        return true;
    }
    
    // Add event listeners
    if (dateFromInput) {
        dateFromInput.addEventListener('change', validateDates);
    }
    
    if (dateToInput) {
        dateToInput.addEventListener('change', validateDates);
    }
    
    // Form submission validation
    form.addEventListener('submit', function(event) {
        if (!validateDates()) {
            event.preventDefault();
            return false;
        }
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating Report...';
            submitBtn.disabled = true;
        }
    });
    
    console.log('Form validation initialized');
}

/**
 * Setup chart toggle functionality
 */
function setupChartToggle() {
    const chartToggleBtn = document.querySelector('button[onclick="toggleVarianceView()"]');
    const chartSection = document.getElementById('chartSection');
    
    if (!chartToggleBtn || !chartSection) return;
    
    // Override the onclick attribute with proper event listener
    chartToggleBtn.removeAttribute('onclick');
    chartToggleBtn.addEventListener('click', function() {
        toggleVarianceView();
    });
    
    console.log('Chart toggle initialized');
}

/**
 * Toggle variance chart view
 */
function toggleVarianceView() {
    const chartSection = document.getElementById('chartSection');
    const chartToggleBtn = document.querySelector('button[data-chart-toggle]') || 
                          document.querySelector('button:has(.fa-chart-bar)');
    
    if (!chartSection) return;
    
    const isVisible = chartSection.style.display !== 'none';
    
    if (isVisible) {
        chartSection.style.display = 'none';
        if (chartToggleBtn) {
            chartToggleBtn.innerHTML = '<i class="fas fa-chart-bar"></i> Chart View';
        }
    } else {
        chartSection.style.display = 'block';
        if (chartToggleBtn) {
            chartToggleBtn.innerHTML = '<i class="fas fa-table"></i> Table View';
        }
        
        // Initialize chart if not already done
        if (!window.varianceChart) {
            initializeVarianceChart();
        }
    }
    
    console.log('Chart view toggled:', isVisible ? 'hidden' : 'visible');
}

/**
 * Initialize variance chart using Chart.js
 */
function initializeVarianceChart() {
    const ctx = document.getElementById('varianceChart');
    if (!ctx) return;
    
    // Get data from the table
    const tableRows = document.querySelectorAll('.modern-data-table tbody tr');
    const labels = [];
    const poData = [];
    const grnData = [];
    const varianceData = [];
    
    tableRows.forEach((row, index) => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 7) {
            const poNumber = cells[1].textContent.trim();
            const poQty = parseFloat(cells[4].textContent.replace(/,/g, ''));
            const grnQty = parseFloat(cells[5].textContent.replace(/,/g, ''));
            const variance = parseFloat(cells[6].textContent.replace(/,/g, ''));
            
            labels.push(`PO-${poNumber.substring(0, 8)}...`);
            poData.push(poQty);
            grnData.push(grnQty);
            varianceData.push(variance);
        }
    });
    
    // Create chart
    window.varianceChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'PO Free Qty',
                data: poData,
                backgroundColor: 'rgba(30, 64, 175, 0.8)',
                borderColor: 'rgba(30, 64, 175, 1)',
                borderWidth: 1
            }, {
                label: 'GRN Free Qty',
                data: grnData,
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1
            }, {
                label: 'Variance',
                data: varianceData,
                backgroundColor: varianceData.map(v => 
                    v > 0 ? 'rgba(16, 185, 129, 0.8)' : 
                    v < 0 ? 'rgba(239, 68, 68, 0.8)' : 
                    'rgba(100, 116, 139, 0.8)'
                ),
                borderColor: varianceData.map(v => 
                    v > 0 ? 'rgba(16, 185, 129, 1)' : 
                    v < 0 ? 'rgba(239, 68, 68, 1)' : 
                    'rgba(100, 116, 139, 1)'
                ),
                borderWidth: 1,
                type: 'line',
                fill: false,
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Free Quantity Variance Analysis'
                },
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Quantity'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Purchase Orders'
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
    
    console.log('Variance chart initialized');
}

/**
 * Setup responsive features
 */
function setupResponsiveFeatures() {
    // Handle table responsiveness
    const tableContainer = document.querySelector('.modern-table-container');
    if (tableContainer) {
        // Add horizontal scroll indicator
        function updateScrollIndicator() {
            const hasHorizontalScroll = tableContainer.scrollWidth > tableContainer.clientWidth;
            tableContainer.classList.toggle('has-scroll', hasHorizontalScroll);
        }
        
        tableContainer.addEventListener('scroll', updateScrollIndicator);
        window.addEventListener('resize', updateScrollIndicator);
        updateScrollIndicator();
    }
    
    // Handle summary cards responsiveness
    const summaryCards = document.querySelector('.summary-cards');
    if (summaryCards) {
        // Add animation on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        });
        
        const cards = summaryCards.querySelectorAll('.summary-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = `opacity 0.5s ease ${index * 0.1}s, transform 0.5s ease ${index * 0.1}s`;
            observer.observe(card);
        });
    }
    
    console.log('Responsive features initialized');
}

/**
 * Setup keyboard shortcuts
 */
function setupKeyboardShortcuts() {
    document.addEventListener('keydown', function(event) {
        // Ctrl/Cmd + M: Toggle sidebar
        if ((event.ctrlKey || event.metaKey) && event.key === 'm') {
            event.preventDefault();
            toggleSidebar();
        }
        
        // Ctrl/Cmd + K: Focus search form
        if ((event.ctrlKey || event.metaKey) && event.key === 'k') {
            event.preventDefault();
            const firstInput = document.querySelector('.search-form input');
            if (firstInput) {
                firstInput.focus();
            }
        }
        
        // Ctrl/Cmd + P: Print report
        if ((event.ctrlKey || event.metaKey) && event.key === 'p') {
            event.preventDefault();
            printReport();
        }
        
        // Escape: Close any open modals or collapse sidebar on mobile
        if (event.key === 'Escape') {
            if (window.innerWidth <= 768) {
                const sidebar = document.getElementById('leftSidebar');
                if (sidebar && !sidebar.classList.contains('collapsed')) {
                    sidebar.classList.add('collapsed');
                    saveSidebarState(true);
                }
            }
        }
    });
    
    console.log('Keyboard shortcuts initialized');
}

/**
 * Show alert message
 */
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alertClass = `alert-${type}`;
    const alertHTML = `
        <div class="alert ${alertClass}" role="alert">
            <i class="fas fa-${type === 'error' ? 'exclamation-circle' : 
                              type === 'warning' ? 'exclamation-triangle' : 
                              type === 'success' ? 'check-circle' : 'info-circle'}"></i>
            <span>${message}</span>
            <button type="button" class="alert-close" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    alertContainer.insertAdjacentHTML('beforeend', alertHTML);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        const alert = alertContainer.querySelector('.alert:last-child');
        if (alert) {
            alert.remove();
        }
    }, 5000);
}

/**
 * Export to Excel (placeholder)
 */
function exportToExcel() {
    showAlert('Excel export functionality will be implemented soon', 'info');
    
    // TODO: Implement actual Excel export
    // This would typically involve:
    // 1. Collecting table data
    // 2. Converting to Excel format
    // 3. Triggering download
}

/**
 * Print report
 */
function printReport() {
    window.print();
}

/**
 * Reset form
 */
function resetForm() {
    const form = document.querySelector('form[name="cbform1"]');
    if (form) {
        form.reset();
        
        // Reset to default dates
        const today = new Date().toISOString().split('T')[0];
        const dateFromInput = document.getElementById('ADate1');
        const dateToInput = document.getElementById('ADate2');
        
        if (dateFromInput) dateFromInput.value = today;
        if (dateToInput) dateToInput.value = today;
        
        showAlert('Form reset successfully', 'success');
    }
}

/**
 * Utility function to format numbers
 */
function formatNumber(num) {
    return new Intl.NumberFormat().format(num);
}

/**
 * Utility function to format currency
 */
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-IN', {
        style: 'currency',
        currency: 'INR'
    }).format(amount);
}

/**
 * Utility function to format date
 */
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-IN', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

// Global functions for backward compatibility
window.toggleSidebar = toggleSidebar;
window.toggleVarianceView = toggleVarianceView;
window.exportToExcel = exportToExcel;
window.printReport = printReport;
window.resetForm = resetForm;

