// Modern JavaScript for Inpatient Discharge TAT - MedStar Hospital Management System

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initializeComponents();
    setupEventListeners();
    updateCurrentTime();
    
    // Update time every minute
    setInterval(updateCurrentTime, 60000);
});

function initializeComponents() {
    // Initialize sidebar toggle
    setupSidebarToggle();
    
    // Initialize form enhancements
    setupFormEnhancements();
    
    // Initialize table enhancements
    setupTableEnhancements();
    
    // Initialize search functionality
    setupSearchFunctionality();
}

function setupSidebarToggle() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainContainer = document.querySelector('.main-container-with-sidebar');

    if (menuToggle) {
        menuToggle.addEventListener('click', () => {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }
}

function setupFormEnhancements() {
    // Add loading states to forms
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
                
                // Re-enable after 3 seconds as fallback
                setTimeout(() => {
                    submitBtn.classList.remove('loading');
                    submitBtn.disabled = false;
                }, 3000);
            }
        });
    });

    // Enhance date inputs
    const dateInputs = document.querySelectorAll('.date-input');
    dateInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });

    // Add form validation
    setupFormValidation();
}

function setupFormValidation() {
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const location = document.getElementById('location');
            const dateFrom = document.getElementById('ADate1');
            const dateTo = document.getElementById('ADate2');

            let isValid = true;
            let errorMessage = '';

            // Validate location
            if (!location.value) {
                isValid = false;
                errorMessage += 'Please select a location.\n';
                location.classList.add('error');
            } else {
                location.classList.remove('error');
            }

            // Validate date range
            if (dateFrom.value && dateTo.value) {
                const fromDate = new Date(dateFrom.value);
                const toDate = new Date(dateTo.value);
                
                if (fromDate > toDate) {
                    isValid = false;
                    errorMessage += 'Date From cannot be later than Date To.\n';
                    dateFrom.classList.add('error');
                    dateTo.classList.add('error');
                } else {
                    dateFrom.classList.remove('error');
                    dateTo.classList.remove('error');
                }
            }

            if (!isValid) {
                e.preventDefault();
                showAlert(errorMessage, 'error');
                return false;
            }

            return true;
        });
    }
}

function setupTableEnhancements() {
    // Add hover effects to table rows
    const tableRows = document.querySelectorAll('.data-table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });

    // Add click effects to table rows
    tableRows.forEach(row => {
        row.addEventListener('click', function() {
            // Remove active class from all rows
            tableRows.forEach(r => r.classList.remove('active'));
            // Add active class to clicked row
            this.classList.add('active');
        });
    });
}

function setupSearchFunctionality() {
    // Add search input enhancements
    const searchInputs = document.querySelectorAll('input[type="text"]');
    searchInputs.forEach(input => {
        // Add search icon
        const wrapper = document.createElement('div');
        wrapper.className = 'search-input-wrapper';
        input.parentNode.insertBefore(wrapper, input);
        wrapper.appendChild(input);
        
        const searchIcon = document.createElement('i');
        searchIcon.className = 'fas fa-search search-icon';
        wrapper.appendChild(searchIcon);
    });

    // Add debounced search
    let searchTimeout;
    searchInputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch(this.value);
            }, 300);
        });
    });
}

function performSearch(query) {
    if (!query.trim()) return;
    
    // Add loading state
    const tableContainer = document.querySelector('.data-table-container');
    if (tableContainer) {
        tableContainer.classList.add('loading');
    }
    
    // Simulate search delay
    setTimeout(() => {
        if (tableContainer) {
            tableContainer.classList.remove('loading');
        }
    }, 500);
}

function setupEventListeners() {
    // Add keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl + S to search
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            const searchForm = document.querySelector('.search-form');
            if (searchForm) {
                searchForm.scrollIntoView({ behavior: 'smooth' });
                const firstInput = searchForm.querySelector('input, select');
                if (firstInput) {
                    firstInput.focus();
                }
            }
        }
        
        // Escape to close sidebar
        if (e.key === 'Escape') {
            const mainContainer = document.querySelector('.main-container-with-sidebar');
            if (mainContainer) {
                mainContainer.classList.add('sidebar-collapsed');
            }
        }
    });

    // Add window resize handler
    window.addEventListener('resize', function() {
        const mainContainer = document.querySelector('.main-container-with-sidebar');
        if (window.innerWidth <= 768) {
            mainContainer.classList.add('sidebar-collapsed');
        }
    });

    // Add scroll effects
    window.addEventListener('scroll', function() {
        const header = document.querySelector('.hospital-header');
        if (window.scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
}

function updateCurrentTime() {
    const timeElement = document.getElementById('currentTime');
    if (timeElement) {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', {
            hour12: true,
            hour: '2-digit',
            minute: '2-digit'
        });
        timeElement.textContent = timeString;
    }
}

function exportToExcel() {
    // Add loading state to export button
    const exportBtn = document.querySelector('.btn-success');
    if (exportBtn) {
        exportBtn.classList.add('loading');
        exportBtn.disabled = true;
    }
    
    // Simulate export process
    setTimeout(() => {
        if (exportBtn) {
            exportBtn.classList.remove('loading');
            exportBtn.disabled = false;
        }
        showAlert('Export completed successfully!', 'success');
    }, 2000);
}

function showAlert(message, type = 'info') {
    // Remove existing alerts
    const existingAlerts = document.querySelectorAll('.alert-message');
    existingAlerts.forEach(alert => alert.remove());
    
    // Create new alert
    const alert = document.createElement('div');
    alert.className = `alert-message alert-${type}`;
    alert.innerHTML = `
        <div class="alert-content">
            <i class="fas fa-${type === 'error' ? 'exclamation-circle' : type === 'success' ? 'check-circle' : 'info-circle'}"></i>
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
        z-index: 1000;
        background: ${type === 'error' ? '#fee2e2' : type === 'success' ? '#d1fae5' : '#dbeafe'};
        color: ${type === 'error' ? '#991b1b' : type === 'success' ? '#065f46' : '#1e40af'};
        padding: 1rem;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        animation: slideInRight 0.3s ease-out;
    `;
    
    document.body.appendChild(alert);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (alert.parentElement) {
            alert.remove();
        }
    }, 5000);
}

// Add CSS for animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
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
        gap: 0.75rem;
    }
    
    .alert-close {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0.25rem;
        margin-left: auto;
    }
    
    .search-input-wrapper {
        position: relative;
    }
    
    .search-icon {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        pointer-events: none;
    }
    
    .form-control.error {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
    
    .data-table tbody tr.active {
        background: #dbeafe !important;
        border-left: 4px solid #1e40af;
    }
    
    .hospital-header.scrolled {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
`;
document.head.appendChild(style);

// Utility functions
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

function formatTime(timeString) {
    const time = new Date(`2000-01-01 ${timeString}`);
    return time.toLocaleTimeString('en-US', {
        hour12: true,
        hour: '2-digit',
        minute: '2-digit'
    });
}

function calculateTAT(startDate, startTime, endDate, endTime) {
    const start = new Date(`${startDate} ${startTime}`);
    const end = new Date(`${endDate} ${endTime}`);
    const diff = end - start;
    
    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    
    if (days > 0) {
        return `${days} Days ${hours}:${minutes.toString().padStart(2, '0')}`;
    } else {
        return `${hours}:${minutes.toString().padStart(2, '0')}`;
    }
}

// Export functions for global access
window.exportToExcel = exportToExcel;
window.showAlert = showAlert;
window.formatDate = formatDate;
window.formatTime = formatTime;
window.calculateTAT = calculateTAT;
