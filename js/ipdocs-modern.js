// Modern JavaScript for IP Documents - MedStar Hospital Management System

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
    
    // Initialize document features
    setupDocumentFeatures();
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

    // Add sorting functionality
    setupTableSorting();
}

function setupTableSorting() {
    const table = document.querySelector('.data-table');
    if (!table) return;

    const headers = table.querySelectorAll('th');
    headers.forEach((header, index) => {
        header.style.cursor = 'pointer';
        header.addEventListener('click', () => {
            sortTable(table, index);
        });
        
        // Add sort indicator
        const sortIcon = document.createElement('i');
        sortIcon.className = 'fas fa-sort sort-icon';
        sortIcon.style.cssText = 'margin-left: 0.5rem; opacity: 0.5;';
        header.appendChild(sortIcon);
    });
}

function sortTable(table, columnIndex) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    const isAscending = table.getAttribute('data-sort-direction') !== 'asc';
    table.setAttribute('data-sort-direction', isAscending ? 'asc' : 'desc');
    
    rows.sort((a, b) => {
        const aText = a.cells[columnIndex].textContent.trim();
        const bText = b.cells[columnIndex].textContent.trim();
        
        // Check if content is numeric
        const aNum = parseFloat(aText.replace(/[^0-9.-]/g, ''));
        const bNum = parseFloat(bText.replace(/[^0-9.-]/g, ''));
        
        if (!isNaN(aNum) && !isNaN(bNum)) {
            return isAscending ? aNum - bNum : bNum - aNum;
        } else {
            return isAscending ? aText.localeCompare(bText) : bText.localeCompare(aText);
        }
    });
    
    // Clear tbody and re-append sorted rows
    tbody.innerHTML = '';
    rows.forEach(row => tbody.appendChild(row));
    
    // Update sort icons
    updateSortIcons(table, columnIndex, isAscending);
}

function updateSortIcons(table, activeColumn, isAscending) {
    const headers = table.querySelectorAll('th');
    headers.forEach((header, index) => {
        const icon = header.querySelector('.sort-icon');
        if (index === activeColumn) {
            icon.className = isAscending ? 'fas fa-sort-up sort-icon' : 'fas fa-sort-down sort-icon';
            icon.style.opacity = '1';
        } else {
            icon.className = 'fas fa-sort sort-icon';
            icon.style.opacity = '0.5';
        }
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

function setupDocumentFeatures() {
    // Enhance document selects
    const documentSelects = document.querySelectorAll('.document-select');
    documentSelects.forEach(select => {
        select.addEventListener('change', function() {
            if (this.value) {
                handleDocumentGeneration(this);
            }
        });
    });

    // Add document preview functionality
    setupDocumentPreview();
}

function handleDocumentGeneration(selectElement) {
    // Add loading state
    selectElement.disabled = true;
    selectElement.style.opacity = '0.6';
    
    // Show loading message
    const loadingMessage = document.createElement('div');
    loadingMessage.className = 'document-loading';
    loadingMessage.innerHTML = `
        <div class="loading-content">
            <i class="fas fa-spinner fa-spin"></i>
            <span>Generating document...</span>
        </div>
    `;
    loadingMessage.style.cssText = `
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        display: flex;
        align-items: center;
        gap: 1rem;
    `;
    
    document.body.appendChild(loadingMessage);
    
    // Simulate document generation
    setTimeout(() => {
        // Remove loading message
        loadingMessage.remove();
        
        // Open document in new window
        window.open(selectElement.value, '_blank');
        
        // Reset select
        selectElement.disabled = false;
        selectElement.style.opacity = '1';
        selectElement.selectedIndex = 0;
        
        showAlert('Document generated successfully!', 'success');
    }, 2000);
}

function setupDocumentPreview() {
    // Add preview functionality for documents
    const documentSelects = document.querySelectorAll('.document-select');
    documentSelects.forEach(select => {
        // Add preview option
        const previewOption = document.createElement('option');
        previewOption.value = 'preview';
        previewOption.textContent = 'Preview Document';
        previewOption.style.background = '#e0e7ff';
        select.appendChild(previewOption);
        
        select.addEventListener('change', function() {
            if (this.value === 'preview') {
                showDocumentPreview(this);
                this.selectedIndex = 0; // Reset to default
            }
        });
    });
}

function showDocumentPreview(selectElement) {
    // Create preview modal
    const previewModal = document.createElement('div');
    previewModal.className = 'document-preview';
    previewModal.innerHTML = `
        <div class="preview-content">
            <button class="document-preview-close" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
            <div class="preview-info">
                <h3>Document Preview</h3>
                <p>This feature allows you to preview documents before generating them.</p>
                <div class="preview-actions">
                    <button class="btn btn-primary" onclick="generateDocument('${selectElement.value}')">
                        <i class="fas fa-file-pdf"></i> Generate PDF
                    </button>
                    <button class="btn btn-secondary" onclick="this.closest('.document-preview').remove()">
                        <i class="fas fa-times"></i> Close
                    </button>
                </div>
            </div>
        </div>
    `;
    
    previewModal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2000;
    `;
    
    document.body.appendChild(previewModal);
}

function generateDocument(url) {
    // Close preview modal
    const previewModal = document.querySelector('.document-preview');
    if (previewModal) {
        previewModal.remove();
    }
    
    // Generate document
    window.open(url, '_blank');
    showAlert('Document generated successfully!', 'success');
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
    
    .clear-btn:hover {
        color: #1e40af;
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
    
    .sort-icon {
        transition: all 0.2s ease;
    }
    
    .document-loading {
        animation: fadeIn 0.3s ease-in;
    }
    
    .loading-content {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-weight: 500;
    }
    
    .preview-content {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        width: 90%;
        position: relative;
    }
    
    .preview-info h3 {
        margin-bottom: 1rem;
        color: #1e40af;
    }
    
    .preview-info p {
        margin-bottom: 1.5rem;
        color: #64748b;
    }
    
    .preview-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }
    
    .document-preview-close {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: #ef4444;
        color: white;
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
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

function getDocumentIcon(documentType) {
    const icons = {
        'admission': 'fas fa-file-medical',
        'consent': 'fas fa-file-signature',
        'payment': 'fas fa-file-invoice-dollar',
        'label': 'fas fa-tag',
        'discharge': 'fas fa-file-export',
        'ama': 'fas fa-file-times'
    };
    return icons[documentType] || 'fas fa-file';
}

// Export functions for global access
window.refreshData = refreshData;
window.showAlert = showAlert;
window.handleDocumentAction = handleDocumentGeneration;
window.formatDate = formatDate;
window.formatTime = formatTime;
window.getStatusColor = getStatusColor;
window.getTypeColor = getTypeColor;
window.getDocumentIcon = getDocumentIcon;
