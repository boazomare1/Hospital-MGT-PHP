// Lab Item Interpret Modern JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initializeSidebar();
    initializeSearch();
    initializePagination();
    initializeAlerts();
    initializeTemplateSelection();
});

// Sidebar functionality
function initializeSidebar() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }
    
    // Close sidebar when clicking outside
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 1024) {
            if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 1024) {
            sidebar.classList.remove('open');
        }
    });
}

// Search functionality
function initializeSearch() {
    const searchInput = document.querySelector('input[name="search1"]');
    const searchForm = document.querySelector('form[method="get"]');
    
    if (!searchInput || !searchForm) return;
    
    // Debounced search
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            performSearch();
        }, 500);
    });
    
    // Search form submission
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        performSearch();
    });
}

function performSearch() {
    const searchInput = document.querySelector('input[name="search1"]');
    const searchForm = document.querySelector('form[method="get"]');
    
    if (!searchInput || !searchForm) return;
    
    const searchValue = searchInput.value.trim();
    
    // Add search flag
    const searchFlag = document.createElement('input');
    searchFlag.type = 'hidden';
    searchFlag.name = 'searchflag1';
    searchFlag.value = 'searchflag1';
    searchForm.appendChild(searchFlag);
    
    // Submit form
    searchForm.submit();
}

// Pagination functionality
function initializePagination() {
    const paginationLinks = document.querySelectorAll('.pagination a');
    
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.href;
            window.location.href = url;
        });
    });
}

// Template selection functionality
function initializeTemplateSelection() {
    const templateSelect = document.querySelector('select[name="labtemplate"]');
    
    if (templateSelect) {
        templateSelect.addEventListener('change', function() {
            const form = this.closest('form');
            if (form) {
                form.submit();
            }
        });
    }
}

// Alert handling
function initializeAlerts() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        // Auto-hide success alerts after 5 seconds
        if (alert.classList.contains('success')) {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }, 5000);
        }
        
        // Add close button to alerts
        const closeButton = document.createElement('button');
        closeButton.innerHTML = '&times;';
        closeButton.style.cssText = `
            position: absolute;
            top: 0.5rem;
            right: 0.75rem;
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
            color: inherit;
            opacity: 0.7;
            transition: opacity 0.2s;
        `;
        
        closeButton.addEventListener('click', function() {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                alert.remove();
            }, 300);
        });
        
        closeButton.addEventListener('mouseenter', function() {
            this.style.opacity = '1';
        });
        
        closeButton.addEventListener('mouseleave', function() {
            this.style.opacity = '0.7';
        });
        
        alert.style.position = 'relative';
        alert.appendChild(closeButton);
    });
}

// Utility functions
function showAlert(message, type = 'info') {
    const alertContainer = document.querySelector('.alert-container');
    if (!alertContainer) return;
    
    const alert = document.createElement('div');
    alert.className = `alert ${type}`;
    alert.textContent = message;
    
    alertContainer.appendChild(alert);
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            alert.remove();
        }, 300);
    }, 5000);
}

function confirmAction(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

// Delete confirmation
function confirmDelete(itemName, deleteUrl) {
    confirmAction(`Are you sure you want to delete "${itemName}"?`, function() {
        window.location.href = deleteUrl;
    });
}

// Activate confirmation
function confirmActivate(itemName, activateUrl) {
    confirmAction(`Are you sure you want to activate "${itemName}"?`, function() {
        window.location.href = activateUrl;
    });
}

// Export functionality
function exportToExcel() {
    const exportUrl = document.querySelector('.export-btn')?.href;
    if (exportUrl) {
        window.open(exportUrl, '_blank');
    }
}

// Search and filter functionality
function clearSearch() {
    const searchInput = document.querySelector('input[name="search1"]');
    if (searchInput) {
        searchInput.value = '';
        performSearch();
    }
}

// Template management
function changeTemplate(templateName) {
    const form = document.createElement('form');
    form.method = 'GET';
    form.action = window.location.pathname;
    
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'labtemplate';
    input.value = templateName;
    
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
}

// Export functions to global scope for use in HTML
window.confirmDelete = confirmDelete;
window.confirmActivate = confirmActivate;
window.exportToExcel = exportToExcel;
window.clearSearch = clearSearch;
window.changeTemplate = changeTemplate;
