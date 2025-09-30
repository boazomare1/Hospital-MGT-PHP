/**
 * Front Desk Dashboard - Modern JavaScript
 * Handles sidebar functionality, dashboard interactions, and modern UI features
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all functionality
    initializeSidebar();
    setupDashboardInteractions();
    setupResponsiveFeatures();
    setupKeyboardShortcuts();
    setupRealTimeUpdates();
    
    // Restore sidebar state
    restoreSidebarState();
    
    console.log('Front Desk Dashboard initialized successfully');
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
    if (window.departmentChart) {
        window.departmentChart.resize();
    }
}

/**
 * Setup dashboard interactions
 */
function setupDashboardInteractions() {
    // Add hover effects to overview cards
    const overviewCards = document.querySelectorAll('.overview-card');
    overviewCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Add click interactions to collection items
    const collectionItems = document.querySelectorAll('.collection-item');
    collectionItems.forEach(item => {
        item.addEventListener('click', function() {
            // Add visual feedback
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
            
            // Could add drill-down functionality here
            console.log('Collection item clicked:', this.querySelector('.collection-label').textContent);
        });
    });
    
    // Add interaction to billing cards
    const billingCards = document.querySelectorAll('.billing-card');
    billingCards.forEach(card => {
        card.addEventListener('click', function() {
            this.style.transform = 'scale(1.02)';
            setTimeout(() => {
                this.style.transform = '';
            }, 200);
        });
    });
    
    // Setup form validation
    const filterForm = document.querySelector('.filter-form');
    if (filterForm) {
        filterForm.addEventListener('submit', function(event) {
            const dateFrom = document.getElementById('ADate1').value;
            const dateTo = document.getElementById('ADate2').value;
            
            if (!validateDateRange(dateFrom, dateTo)) {
                event.preventDefault();
                return false;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
                submitBtn.disabled = true;
            }
        });
    }
    
    console.log('Dashboard interactions initialized');
}

/**
 * Validate date range
 */
function validateDateRange(dateFrom, dateTo) {
    const from = new Date(dateFrom);
    const to = new Date(dateTo);
    
    if (from > to) {
        showAlert('From date cannot be greater than To date', 'error');
        return false;
    }
    
    // Check if date range is not more than 1 year
    const oneYearAgo = new Date();
    oneYearAgo.setFullYear(oneYearAgo.getFullYear() - 1);
    
    if (from < oneYearAgo) {
        showAlert('Date range cannot be more than 1 year', 'warning');
    }
    
    return true;
}

/**
 * Setup responsive features
 */
function setupResponsiveFeatures() {
    // Handle table responsiveness
    const tableContainer = document.querySelector('.departmental-table-container');
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
    
    // Handle overview cards responsiveness
    const overviewContainer = document.querySelector('.dashboard-overview');
    if (overviewContainer) {
        // Add animation on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        });
        
        const cards = overviewContainer.querySelectorAll('.overview-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = `opacity 0.5s ease ${index * 0.1}s, transform 0.5s ease ${index * 0.1}s`;
            observer.observe(card);
        });
    }
    
    // Handle collection grid responsiveness
    const collectionGrid = document.querySelector('.collection-grid');
    if (collectionGrid) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        });
        
        const items = collectionGrid.querySelectorAll('.collection-item');
        items.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = `opacity 0.5s ease ${index * 0.1}s, transform 0.5s ease ${index * 0.1}s`;
            observer.observe(item);
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
        
        // Ctrl/Cmd + R: Refresh dashboard
        if ((event.ctrlKey || event.metaKey) && event.key === 'r') {
            event.preventDefault();
            document.querySelector('.filter-form').submit();
        }
        
        // Ctrl/Cmd + E: Export to Excel
        if ((event.ctrlKey || event.metaKey) && event.key === 'e') {
            event.preventDefault();
            exportToExcel();
        }
        
        // Ctrl/Cmd + P: Print dashboard
        if ((event.ctrlKey || event.metaKey) && event.key === 'p') {
            event.preventDefault();
            printDashboard();
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
 * Setup real-time updates (placeholder for future implementation)
 */
function setupRealTimeUpdates() {
    // This would typically connect to a WebSocket or use AJAX polling
    // to update dashboard data in real-time
    
    // Example: Update every 5 minutes
    setInterval(() => {
        // updateDashboardData();
    }, 300000); // 5 minutes
    
    console.log('Real-time updates initialized');
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
    // 1. Collecting dashboard data
    // 2. Converting to Excel format
    // 3. Triggering download
}

/**
 * Print dashboard
 */
function printDashboard() {
    window.print();
}

/**
 * Reset filters
 */
function resetFilters() {
    const today = new Date().toISOString().split('T')[0];
    const dateFromInput = document.getElementById('ADate1');
    const dateToInput = document.getElementById('ADate2');
    
    if (dateFromInput) dateFromInput.value = today;
    if (dateToInput) dateToInput.value = today;
    
    showAlert('Filters reset successfully', 'success');
}

/**
 * Toggle chart view for departmental statistics
 */
function toggleChartView() {
    const tableContainer = document.getElementById('departmentalTable');
    const chartSection = document.getElementById('chartSection');
    
    if (!tableContainer || !chartSection) return;
    
    const isVisible = chartSection.style.display !== 'none';
    
    if (isVisible) {
        tableContainer.style.display = 'block';
        chartSection.style.display = 'none';
    } else {
        tableContainer.style.display = 'none';
        chartSection.style.display = 'block';
        
        // Initialize chart if not already done
        if (!window.departmentChart) {
            initializeDepartmentChart();
        }
    }
    
    console.log('Chart view toggled:', isVisible ? 'hidden' : 'visible');
}

/**
 * Initialize department chart using Chart.js
 */
function initializeDepartmentChart() {
    const ctx = document.getElementById('departmentChart');
    if (!ctx) return;
    
    // Get data from the table
    const tableRows = document.querySelectorAll('.modern-data-table tbody tr');
    const departments = [];
    const visits = [];
    
    tableRows.forEach((row) => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 2) {
            const deptName = cells[0].textContent.trim();
            const visitCount = parseInt(cells[1].textContent.replace(/,/g, ''));
            
            departments.push(deptName);
            visits.push(visitCount);
        }
    });
    
    // Create chart
    window.departmentChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: departments,
            datasets: [{
                data: visits,
                backgroundColor: [
                    '#1e40af', '#3b82f6', '#10b981', '#f59e0b', 
                    '#ef4444', '#8b5cf6', '#06b6d4', '#84cc16',
                    '#f97316', '#ec4899', '#14b8a6', '#a855f7'
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Department Visits Distribution'
                },
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
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value} visits (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
    
    console.log('Department chart initialized');
}

/**
 * Update dashboard data (for real-time updates)
 */
function updateDashboardData() {
    // This would typically make an AJAX call to get updated data
    // and then update the DOM elements accordingly
    
    console.log('Dashboard data update requested');
    
    // Example implementation:
    // fetch('ajax/dashboard_data.php')
    //     .then(response => response.json())
    //     .then(data => {
    //         updateOverviewCards(data.overview);
    //         updateCollectionData(data.collections);
    //         updateBillingData(data.billing);
    //     })
    //     .catch(error => {
    //         console.error('Error updating dashboard data:', error);
    //     });
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
window.exportToExcel = exportToExcel;
window.printDashboard = printDashboard;
window.resetFilters = resetFilters;
window.toggleChartView = toggleChartView;

