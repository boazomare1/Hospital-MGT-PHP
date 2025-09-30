// Modern JavaScript for IP Discount List - MedStar Hospital Management System

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
    
    // Initialize autocomplete
    setupAutocomplete();
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

    // Add form validation
    setupFormValidation();
}

function setupFormValidation() {
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const location = document.getElementById('location');
            const customer = document.getElementById('customer');

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

    // Enhance action selects
    const actionSelects = document.querySelectorAll('.action-select');
    actionSelects.forEach(select => {
        select.addEventListener('change', function() {
            if (this.value) {
                // Add loading state
                this.disabled = true;
                this.style.opacity = '0.6';
                
                // Open in new window
                window.open(this.value, '_blank');
                
                // Reset after a short delay
                setTimeout(() => {
                    this.disabled = false;
                    this.style.opacity = '1';
                    this.selectedIndex = 0; // Reset to default option
                }, 1000);
            }
        });
    });
}

function setupSearchFunctionality() {
    // Add search input enhancements
    const searchInput = document.getElementById('customer');
    if (searchInput) {
        // Add search icon
        const wrapper = searchInput.parentElement;
        wrapper.classList.add('search-input-wrapper');
        
        // Add debounced search
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch(this.value);
            }, 300);
        });

        // Add clear button
        const clearBtn = document.createElement('button');
        clearBtn.type = 'button';
        clearBtn.className = 'clear-btn';
        clearBtn.innerHTML = '<i class="fas fa-times"></i>';
        clearBtn.style.cssText = `
            position: absolute;
            right: 2.5rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            padding: 0.25rem;
            display: none;
        `;
        
        clearBtn.addEventListener('click', function() {
            searchInput.value = '';
            searchInput.focus();
            performSearch('');
        });
        
        wrapper.appendChild(clearBtn);
        
        // Show/hide clear button based on input
        searchInput.addEventListener('input', function() {
            if (this.value.trim()) {
                clearBtn.style.display = 'block';
            } else {
                clearBtn.style.display = 'none';
            }
        });
    }
}

function setupAutocomplete() {
    // Enhanced autocomplete functionality
    const customerInput = document.getElementById('customer');
    if (customerInput) {
        // Add autocomplete dropdown
        const dropdown = document.createElement('div');
        dropdown.className = 'autocomplete-dropdown';
        dropdown.style.cssText = `
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e2e8f0;
            border-top: none;
            border-radius: 0 0 8px 8px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        `;
        
        customerInput.parentElement.appendChild(dropdown);
        
        // Mock autocomplete data (replace with actual AJAX call)
        const mockData = [
            'John Doe - P001',
            'Jane Smith - P002',
            'Bob Johnson - P003',
            'Alice Brown - P004',
            'Charlie Wilson - P005'
        ];
        
        customerInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            if (query.length < 2) {
                dropdown.style.display = 'none';
                return;
            }
            
            const filtered = mockData.filter(item => 
                item.toLowerCase().includes(query)
            );
            
            if (filtered.length > 0) {
                dropdown.innerHTML = filtered.map(item => 
                    `<div class="autocomplete-item" data-value="${item}">${item}</div>`
                ).join('');
                dropdown.style.display = 'block';
            } else {
                dropdown.style.display = 'none';
            }
        });
        
        // Handle dropdown selection
        dropdown.addEventListener('click', function(e) {
            if (e.target.classList.contains('autocomplete-item')) {
                customerInput.value = e.target.textContent;
                dropdown.style.display = 'none';
                performSearch(customerInput.value);
            }
        });
        
        // Hide dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!customerInput.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
    }
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

function refreshData() {
    // Add loading state to refresh button
    const refreshBtn = document.querySelector('.btn-primary');
    if (refreshBtn) {
        refreshBtn.classList.add('loading');
        refreshBtn.disabled = true;
    }
    
    // Simulate refresh process
    setTimeout(() => {
        if (refreshBtn) {
            refreshBtn.classList.remove('loading');
            refreshBtn.disabled = false;
        }
        showAlert('Data refreshed successfully!', 'success');
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

// Add CSS for animations and styles
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
    
    .autocomplete-item {
        padding: 0.75rem;
        cursor: pointer;
        border-bottom: 1px solid #e2e8f0;
        transition: background-color 0.2s;
    }
    
    .autocomplete-item:hover {
        background: #f1f5f9;
    }
    
    .autocomplete-item:last-child {
        border-bottom: none;
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
    
    .clear-btn:hover {
        color: #1e40af;
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

function getStatusColor(status) {
    const colors = {
        'Active': '#10b981',
        'Discharged': '#ef4444',
        'Requested': '#3b82f6'
    };
    return colors[status] || '#64748b';
}

function getTypeColor(type) {
    const colors = {
        'H': '#3b82f6',
        'P': '#f59e0b'
    };
    return colors[type] || '#64748b';
}

// Export functions for global access
window.refreshData = refreshData;
window.showAlert = showAlert;
window.formatDate = formatDate;
window.formatTime = formatTime;
window.getStatusColor = getStatusColor;
window.getTypeColor = getTypeColor;
