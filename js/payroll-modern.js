/**
 * Payroll Report Modern JavaScript
 * Based on VAT Master functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initializeSidebar();
    initializeFormValidation();
    initializeTableFeatures();
    initializeResponsiveFeatures();
    initializeAnimations();
});

/**
 * Sidebar Management
 */
function initializeSidebar() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const menuToggle = document.getElementById('menuToggle');
    const leftSidebar = document.getElementById('leftSidebar');
    
    if (sidebarToggle && leftSidebar) {
        sidebarToggle.addEventListener('click', function() {
            leftSidebar.classList.toggle('collapsed');
            const icon = sidebarToggle.querySelector('i');
            if (leftSidebar.classList.contains('collapsed')) {
                icon.className = 'fas fa-chevron-right';
            } else {
                icon.className = 'fas fa-chevron-left';
            }
        });
    }
    
    if (menuToggle && leftSidebar) {
        menuToggle.addEventListener('click', function() {
            leftSidebar.classList.toggle('open');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            if (!leftSidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                leftSidebar.classList.remove('open');
            }
        }
    });
}

/**
 * Form Validation and Enhancement
 */
function initializeFormValidation() {
    const form = document.getElementById('form1');
    const submitBtn = form?.querySelector('button[type="submit"]');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }
            
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating Report...';
            submitBtn.disabled = true;
            form.classList.add('loading');
        });
    }
    
    // Auto-format inputs
    const inputs = document.querySelectorAll('.form-input');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });
}

/**
 * Form Validation Logic
 */
function validateForm() {
    const searchemployee = document.getElementById('searchemployee')?.value.trim();
    const searchbank = document.getElementById('searchbank')?.value.trim();
    const searchmonth = document.getElementById('searchmonth')?.value;
    const searchyear = document.getElementById('searchyear')?.value;
    
    let isValid = true;
    let errorMessage = '';
    
    // Check if at least one search criteria is provided
    if (!searchemployee && !searchbank) {
        errorMessage = 'Please enter either employee name or bank name to search.';
        isValid = false;
    }
    
    // Validate month and year
    if (!searchmonth || !searchyear) {
        errorMessage = 'Please select both month and year.';
        isValid = false;
    }
    
    if (!isValid) {
        showAlert(errorMessage, 'error');
    }
    
    return isValid;
}

/**
 * Table Features
 */
function initializeTableFeatures() {
    // Add sorting functionality to table headers
    const tableHeaders = document.querySelectorAll('.payroll-table th');
    tableHeaders.forEach(header => {
        if (header.textContent.trim() !== 'Actions') {
            header.style.cursor = 'pointer';
            header.addEventListener('click', function() {
                sortTable(this);
            });
        }
    });
    
    // Add row highlighting
    const tableRows = document.querySelectorAll('.payroll-table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'rgba(52, 152, 219, 0.1)';
        });
        
        row.addEventListener('mouseleave', function() {
            if (this.classList.contains('even')) {
                this.style.backgroundColor = '#f8f9fa';
            } else {
                this.style.backgroundColor = 'white';
            }
        });
    });
}

/**
 * Table Sorting Function
 */
function sortTable(header) {
    const table = header.closest('table');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const columnIndex = Array.from(header.parentNode.children).indexOf(header);
    
    // Skip bank header rows
    const dataRows = rows.filter(row => !row.classList.contains('bank-header-row'));
    
    const isAscending = header.classList.contains('sort-asc');
    
    // Clear previous sort classes
    header.parentNode.querySelectorAll('th').forEach(th => {
        th.classList.remove('sort-asc', 'sort-desc');
    });
    
    // Sort rows
    dataRows.sort((a, b) => {
        const aText = a.children[columnIndex]?.textContent.trim() || '';
        const bText = b.children[columnIndex]?.textContent.trim() || '';
        
        // Try to parse as numbers first
        const aNum = parseFloat(aText.replace(/[^\d.-]/g, ''));
        const bNum = parseFloat(bText.replace(/[^\d.-]/g, ''));
        
        if (!isNaN(aNum) && !isNaN(bNum)) {
            return isAscending ? aNum - bNum : bNum - aNum;
        } else {
            return isAscending ? 
                aText.localeCompare(bText) : 
                bText.localeCompare(aText);
        }
    });
    
    // Re-insert sorted rows
    dataRows.forEach(row => tbody.appendChild(row));
    
    // Add sort class
    header.classList.add(isAscending ? 'sort-desc' : 'sort-asc');
}

/**
 * Responsive Features
 */
function initializeResponsiveFeatures() {
    // Handle window resize
    window.addEventListener('resize', function() {
        handleResponsiveLayout();
    });
    
    // Initial call
    handleResponsiveLayout();
}

/**
 * Handle Responsive Layout
 */
function handleResponsiveLayout() {
    const leftSidebar = document.getElementById('leftSidebar');
    const mainContent = document.querySelector('.main-content');
    
    if (window.innerWidth <= 768) {
        if (leftSidebar) {
            leftSidebar.classList.add('mobile');
        }
        if (mainContent) {
            mainContent.classList.add('mobile');
        }
    } else {
        if (leftSidebar) {
            leftSidebar.classList.remove('mobile', 'open');
        }
        if (mainContent) {
            mainContent.classList.remove('mobile');
        }
    }
}

/**
 * Animations
 */
function initializeAnimations() {
    // Add fade-in animation to main content
    const mainContent = document.querySelector('.main-content');
    if (mainContent) {
        mainContent.classList.add('fade-in');
    }
    
    // Animate table rows
    const tableRows = document.querySelectorAll('.payroll-table tbody tr');
    tableRows.forEach((row, index) => {
        row.style.animationDelay = `${index * 0.05}s`;
        row.classList.add('fade-in');
    });
}

/**
 * Utility Functions
 */
function refreshPage() {
    window.location.reload();
}

function exportToExcel() {
    const url = new URL(window.location);
    url.searchParams.set('export', 'excel');
    window.open(url.toString(), '_blank');
}

/**
 * Alert System
 */
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    
    const icon = type === 'success' ? 'check-circle' : 
                 type === 'error' ? 'exclamation-triangle' : 'info-circle';
    
    alertDiv.innerHTML = `
        <i class="fas fa-${icon} alert-icon"></i>
        <span>${message}</span>
    `;
    
    alertContainer.innerHTML = '';
    alertContainer.appendChild(alertDiv);
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.parentNode.removeChild(alertDiv);
        }
    }, 5000);
    
    // Scroll to alert
    alertContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

/**
 * Search Enhancement
 */
function initializeSearchEnhancement() {
    const searchInputs = document.querySelectorAll('input[type="text"]');
    
    searchInputs.forEach(input => {
        let timeout;
        
        input.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                // Add search suggestions or auto-complete here
                handleSearchInput(this);
            }, 300);
        });
    });
}

/**
 * Handle Search Input
 */
function handleSearchInput(input) {
    const value = input.value.trim();
    
    if (value.length > 2) {
        // Add loading indicator
        input.style.backgroundImage = 'url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Cpath fill=\'%23999\' d=\'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z\'/%3E%3C/svg%3E")';
        input.style.backgroundRepeat = 'no-repeat';
        input.style.backgroundPosition = 'right 10px center';
        input.style.backgroundSize = '16px';
        
        // Simulate search suggestions (replace with actual implementation)
        setTimeout(() => {
            input.style.backgroundImage = '';
        }, 1000);
    }
}

/**
 * Keyboard Shortcuts
 */
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + K to focus search
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        const searchInput = document.getElementById('searchemployee');
        if (searchInput) {
            searchInput.focus();
        }
    }
    
    // Escape to close sidebar on mobile
    if (e.key === 'Escape') {
        const leftSidebar = document.getElementById('leftSidebar');
        if (leftSidebar && window.innerWidth <= 768) {
            leftSidebar.classList.remove('open');
        }
    }
});

/**
 * Performance Optimization
 */
function initializePerformanceOptimizations() {
    // Lazy load images
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
    
    // Debounce scroll events
    let scrollTimeout;
    window.addEventListener('scroll', function() {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => {
            // Handle scroll events here
        }, 100);
    });
}

/**
 * Error Handling
 */
window.addEventListener('error', function(e) {
    console.error('JavaScript Error:', e.error);
    showAlert('An unexpected error occurred. Please refresh the page.', 'error');
});

/**
 * Initialize everything when DOM is ready
 */
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeAll);
} else {
    initializeAll();
}

function initializeAll() {
    try {
        initializeSidebar();
        initializeFormValidation();
        initializeTableFeatures();
        initializeResponsiveFeatures();
        initializeAnimations();
        initializeSearchEnhancement();
        initializePerformanceOptimizations();
    } catch (error) {
        console.error('Initialization Error:', error);
        showAlert('Failed to initialize some features. Please refresh the page.', 'error');
    }
}





