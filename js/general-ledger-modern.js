// General Ledger Modern JavaScript

// Global variables
let isSidebarCollapsed = false;
let isParametersCollapsed = false;

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeEventListeners();
    restoreSidebarState();
    handleWindowResize();
    
    // Initialize parameters section
    initializeParameters();
    
    // Initialize form interactions
    initializeFormInteractions();
});

// Initialize event listeners
function initializeEventListeners() {
    // Sidebar toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const menuToggle = document.getElementById('menuToggle');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }
    
    if (menuToggle) {
        menuToggle.addEventListener('click', toggleSidebar);
    }
    
    // Window resize
    window.addEventListener('resize', handleWindowResize);
    
    // Parameters toggle
    const toggleParameters = document.getElementById('toggleParameters');
    if (toggleParameters) {
        toggleParameters.addEventListener('click', toggleParameters);
    }
}

// Toggle sidebar
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

// Restore sidebar state from localStorage
function restoreSidebarState() {
    const sidebar = document.getElementById('leftSidebar');
    const toggleButton = document.getElementById('sidebarToggle');
    const menuToggle = document.getElementById('menuToggle');
    
    if (!sidebar) return;
    
    // Only restore on desktop
    if (window.innerWidth > 768) {
        const savedState = localStorage.getItem('sidebarCollapsed');
        if (savedState === 'true') {
            isSidebarCollapsed = true;
            sidebar.classList.add('collapsed');
            if (toggleButton) {
                toggleButton.innerHTML = '<i class="fas fa-chevron-right"></i>';
            }
            if (menuToggle) {
                menuToggle.innerHTML = '<i class="fas fa-chevron-right"></i>';
            }
        }
    }
}

// Handle window resize
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

// Initialize parameters section
function initializeParameters() {
    const toggleButton = document.getElementById('toggleParameters');
    const parametersContent = document.getElementById('parametersContent');
    
    if (toggleButton && parametersContent) {
        // Check if parameters should be collapsed by default
        const shouldCollapse = localStorage.getItem('parametersCollapsed') === 'true';
        
        if (shouldCollapse) {
            parametersContent.classList.add('collapsed');
            toggleButton.innerHTML = '<i class="fas fa-chevron-right"></i>';
            isParametersCollapsed = true;
        }
    }
}

// Toggle parameters section
function toggleParameters() {
    const toggleButton = document.getElementById('toggleParameters');
    const parametersContent = document.getElementById('parametersContent');
    
    if (!toggleButton || !parametersContent) return;
    
    isParametersCollapsed = !isParametersCollapsed;
    
    if (isParametersCollapsed) {
        parametersContent.classList.add('collapsed');
        toggleButton.innerHTML = '<i class="fas fa-chevron-right"></i>';
    } else {
        parametersContent.classList.remove('collapsed');
        toggleButton.innerHTML = '<i class="fas fa-chevron-down"></i>';
    }
    
    // Save state to localStorage
    localStorage.setItem('parametersCollapsed', isParametersCollapsed);
}

// Initialize form interactions
function initializeFormInteractions() {
    // Radio button interactions
    const radioButtons = document.querySelectorAll('input[name="searchpaymenttype"]');
    radioButtons.forEach(radio => {
        radio.addEventListener('change', handleSearchTypeChange);
    });
    
    // Form validation
    const form = document.querySelector('form[name="cbform1"]');
    if (form) {
        form.addEventListener('submit', handleFormSubmit);
    }
    
    // Input focus effects
    const inputs = document.querySelectorAll('.form-input, .form-select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });
}

// Handle search type change
function handleSearchTypeChange(event) {
    const value = event.target.value;
    const searchCodeInput = document.getElementById('searchpaymentcode');
    const ledgerSearch = document.getElementById('ledgersearch');
    const groupSearch = document.getElementById('groupsearch');
    
    if (searchCodeInput) {
        searchCodeInput.value = value;
    }
    
    if (value === '2') {
        // Group search
        if (ledgerSearch) ledgerSearch.style.display = 'none';
        if (groupSearch) groupSearch.style.display = 'block';
    } else {
        // Ledger search
        if (ledgerSearch) ledgerSearch.style.display = 'block';
        if (groupSearch) groupSearch.style.display = 'none';
    }
}

// Handle form submission
function handleFormSubmit(event) {
    const form = event.target;
    const searchCodeInput = document.getElementById('searchpaymentcode');
    const accountMainType = document.getElementById('accountsmaintype');
    
    // Validate form
    if (searchCodeInput && searchCodeInput.value === '2' && 
        accountMainType && accountMainType.value === '') {
        event.preventDefault();
        showAlert('Please select the Main Type', 'error');
        accountMainType.focus();
        return false;
    }
    
    // Show loading state
    showLoadingState();
    
    return true;
}

// Show loading state
function showLoadingState() {
    const submitButton = document.querySelector('button[type="submit"]');
    if (submitButton) {
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating Report...';
    }
}

// Hide loading state
function hideLoadingState() {
    const submitButton = document.querySelector('button[type="submit"]');
    if (submitButton) {
        submitButton.disabled = false;
        submitButton.innerHTML = '<i class="fas fa-search"></i> Generate Report';
    }
}

// Show alert message
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alert = document.createElement('div');
    alert.className = `alert ${type}`;
    alert.innerHTML = `
        <div class="alert-content">
            <i class="fas fa-${getAlertIcon(type)}"></i>
            <span>${message}</span>
            <button class="alert-close" onclick="closeAlert(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    alertContainer.appendChild(alert);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (alert.parentNode) {
            alert.parentNode.removeChild(alert);
        }
    }, 5000);
}

// Get alert icon based on type
function getAlertIcon(type) {
    const icons = {
        'success': 'check-circle',
        'error': 'exclamation-circle',
        'warning': 'exclamation-triangle',
        'info': 'info-circle'
    };
    return icons[type] || 'info-circle';
}

// Close alert
function closeAlert(button) {
    const alert = button.closest('.alert');
    if (alert && alert.parentNode) {
        alert.parentNode.removeChild(alert);
    }
}

// Reset form
function resetForm() {
    const form = document.querySelector('form[name="cbform1"]');
    if (form) {
        form.reset();
        
        // Reset to ledger search by default
        const ledgerRadio = document.getElementById('searchpaymenttype11');
        if (ledgerRadio) {
            ledgerRadio.checked = true;
            handleSearchTypeChange({ target: ledgerRadio });
        }
        
        // Focus on ledger name input
        const ledgerNameInput = document.getElementById('ledgername');
        if (ledgerNameInput) {
            ledgerNameInput.focus();
        }
    }
}

// Export to Excel
function exportToExcel() {
    const downloadButton = document.getElementById('download');
    if (downloadButton) {
        downloadButton.click();
    }
}

// Utility function to disable enter key
function disableEnterKey(e) {
    const key = e.which || e.keyCode;
    return key !== 13;
}

// Format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-IN', {
        style: 'currency',
        currency: 'INR',
        minimumFractionDigits: 2
    }).format(amount);
}

// Format date
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-IN', {
        year: 'numeric',
        month: 'short',
        day: '2-digit'
    });
}

// Debounce function for search inputs
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

// Search functionality with debounce
const debouncedSearch = debounce(function(query) {
    // Implement search logic here
    console.log('Searching for:', query);
}, 300);

// Initialize search inputs
document.addEventListener('DOMContentLoaded', function() {
    const searchInputs = document.querySelectorAll('input[type="text"]');
    searchInputs.forEach(input => {
        input.addEventListener('input', function() {
            debouncedSearch(this.value);
        });
    });
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl + / to toggle sidebar
    if (e.ctrlKey && e.key === '/') {
        e.preventDefault();
        toggleSidebar();
    }
    
    // Escape to close mobile sidebar
    if (e.key === 'Escape') {
        const sidebar = document.getElementById('leftSidebar');
        if (sidebar && sidebar.classList.contains('mobile') && sidebar.classList.contains('show')) {
            sidebar.classList.remove('show');
        }
    }
    
    // Ctrl + Enter to submit form
    if (e.ctrlKey && e.key === 'Enter') {
        const form = document.querySelector('form[name="cbform1"]');
        if (form) {
            form.submit();
        }
    }
});

// Print functionality
function printReport() {
    window.print();
}

// Responsive table handling
function handleResponsiveTable() {
    const tables = document.querySelectorAll('.report-table');
    tables.forEach(table => {
        if (table.scrollWidth > table.clientWidth) {
            table.parentElement.classList.add('table-scrollable');
        }
    });
}

// Initialize responsive tables
document.addEventListener('DOMContentLoaded', function() {
    handleResponsiveTable();
    window.addEventListener('resize', handleResponsiveTable);
});

// Smooth scrolling for anchor links
document.addEventListener('DOMContentLoaded', function() {
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Initialize tooltips (if needed)
function initializeTooltips() {
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', showTooltip);
        element.addEventListener('mouseleave', hideTooltip);
    });
}

function showTooltip(e) {
    const tooltip = document.createElement('div');
    tooltip.className = 'tooltip';
    tooltip.textContent = e.target.getAttribute('data-tooltip');
    document.body.appendChild(tooltip);
    
    const rect = e.target.getBoundingClientRect();
    tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
    tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
}

function hideTooltip() {
    const tooltip = document.querySelector('.tooltip');
    if (tooltip) {
        tooltip.remove();
    }
}

// Initialize tooltips on DOM ready
document.addEventListener('DOMContentLoaded', initializeTooltips);








