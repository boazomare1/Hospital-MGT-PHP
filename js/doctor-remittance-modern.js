/**
 * Doctor Remittance Report - Modern JavaScript
 * Enhanced functionality for doctor remittance report page
 */

document.addEventListener('DOMContentLoaded', function() {
    initializeModernFeatures();
});

function initializeModernFeatures() {
    // Initialize sidebar toggle
    initializeSidebarToggle();
    
    // Initialize form enhancements
    initializeFormEnhancements();
    
    // Initialize table enhancements
    initializeTableEnhancements();
    
    // Initialize responsive features
    initializeResponsiveFeatures();
    
    // Initialize loading states
    initializeLoadingStates();
    
    // Initialize export functionality
    initializeExportFeatures();
}

/**
 * Sidebar Toggle Functionality
 */
function initializeSidebarToggle() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            updateMenuToggleIcon();
        });
    }
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            updateMenuToggleIcon();
        });
    }
    
    // Auto-collapse sidebar on mobile
    if (window.innerWidth <= 768) {
        sidebar.classList.add('collapsed');
    }
}

function updateMenuToggleIcon() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    const icon = menuToggle?.querySelector('i');
    
    if (icon && sidebar) {
        if (sidebar.classList.contains('collapsed')) {
            icon.className = 'fas fa-bars';
        } else {
            icon.className = 'fas fa-times';
        }
    }
}

/**
 * Form Enhancements
 */
function initializeFormEnhancements() {
    // Form validation
    const reportForm = document.querySelector('form[name="cbform1"]');
    if (reportForm) {
        reportForm.addEventListener('submit', function(e) {
            if (!validateReportForm()) {
                e.preventDefault();
                return false;
            }
            showLoadingOverlay('Generating Doctor Remittance Report...');
        });
    }
    
    // Date validation
    const fromDate = document.getElementById('ADate1');
    const toDate = document.getElementById('ADate2');
    
    if (fromDate && toDate) {
        fromDate.addEventListener('change', function() {
            validateDateRange();
        });
        
        toDate.addEventListener('change', function() {
            validateDateRange();
        });
    }
    
    // Doctor search autocomplete
    const doctorSearch = document.getElementById('searchsuppliername');
    if (doctorSearch) {
        initializeDoctorAutocomplete(doctorSearch);
    }
}

function validateReportForm() {
    const fromDate = document.getElementById('ADate1');
    const toDate = document.getElementById('ADate2');
    
    // Clear previous errors
    clearFormErrors();
    
    if (!fromDate || fromDate.value.trim() === '') {
        showFormError(fromDate, 'Please select a start date');
        return false;
    }
    
    if (!toDate || toDate.value.trim() === '') {
        showFormError(toDate, 'Please select an end date');
        return false;
    }
    
    // Validate date range
    if (!validateDateRange()) {
        return false;
    }
    
    return true;
}

function validateDateRange() {
    const fromDate = document.getElementById('ADate1');
    const toDate = document.getElementById('ADate2');
    
    if (!fromDate || !toDate || !fromDate.value || !toDate.value) {
        return true; // Let individual field validation handle empty dates
    }
    
    const from = new Date(fromDate.value);
    const to = new Date(toDate.value);
    
    if (from > to) {
        showFormError(toDate, 'End date must be after start date');
        return false;
    }
    
    // Check if date range is too large (more than 1 year)
    const diffTime = Math.abs(to - from);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    
    if (diffDays > 365) {
        showFormError(toDate, 'Date range cannot exceed 365 days');
        return false;
    }
    
    return true;
}

function initializeDoctorAutocomplete(input) {
    let timeout;
    
    input.addEventListener('input', function() {
        clearTimeout(timeout);
        const query = this.value.trim();
        
        if (query.length < 2) {
            hideAutocomplete();
            return;
        }
        
        timeout = setTimeout(() => {
            searchDoctors(query, input);
        }, 300);
    });
    
    // Hide autocomplete when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.autocomplete-container')) {
            hideAutocomplete();
        }
    });
}

function searchDoctors(query, input) {
    // This would typically make an AJAX call to search for doctors
    // For now, we'll simulate with a simple search
    const doctors = getDoctorSuggestions(query);
    
    if (doctors.length > 0) {
        showAutocomplete(doctors, input);
    } else {
        hideAutocomplete();
    }
}

function getDoctorSuggestions(query) {
    // This would typically come from an AJAX call
    // For now, return empty array
    return [];
}

function showAutocomplete(doctors, input) {
    hideAutocomplete();
    
    const container = document.createElement('div');
    container.className = 'autocomplete-container';
    container.style.cssText = `
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-medium);
        z-index: 1000;
        max-height: 200px;
        overflow-y: auto;
    `;
    
    doctors.forEach(doctor => {
        const item = document.createElement('div');
        item.className = 'autocomplete-item';
        item.style.cssText = `
            padding: 0.75rem;
            cursor: pointer;
            border-bottom: 1px solid var(--border-color);
            transition: var(--transition);
        `;
        item.textContent = doctor.name;
        
        item.addEventListener('click', function() {
            input.value = doctor.name;
            hideAutocomplete();
        });
        
        item.addEventListener('mouseenter', function() {
            this.style.background = 'var(--background-accent)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.background = 'white';
        });
        
        container.appendChild(item);
    });
    
    input.parentNode.style.position = 'relative';
    input.parentNode.appendChild(container);
}

function hideAutocomplete() {
    const existing = document.querySelector('.autocomplete-container');
    if (existing) {
        existing.remove();
    }
}

function showFormError(input, message) {
    if (!input) return;
    
    // Add error class
    input.classList.add('error');
    
    // Create error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'form-error';
    errorDiv.textContent = message;
    errorDiv.style.color = '#dc2626';
    errorDiv.style.fontSize = '0.8rem';
    errorDiv.style.marginTop = '0.25rem';
    
    // Insert error message
    input.parentNode.appendChild(errorDiv);
}

function clearFormErrors() {
    const errorInputs = document.querySelectorAll('.form-input.error');
    errorInputs.forEach(input => {
        input.classList.remove('error');
    });
    
    const errorMessages = document.querySelectorAll('.form-error');
    errorMessages.forEach(message => {
        message.remove();
    });
}

/**
 * Table Enhancements
 */
function initializeTableEnhancements() {
    const tables = document.querySelectorAll('.modern-table, .remittance-table');
    tables.forEach(table => {
        // Add sorting functionality
        initializeTableSorting(table);
        
        // Add row highlighting
        initializeRowHighlighting(table);
        
        // Add responsive table wrapper
        wrapTableForResponsiveness(table);
        
        // Add remittance link enhancements
        enhanceRemittanceLinks(table);
    });
}

function initializeTableSorting(table) {
    const headers = table.querySelectorAll('th');
    headers.forEach((header, index) => {
        // Skip action columns and non-sortable columns
        if (header.textContent.includes('Actions') || 
            header.textContent.includes('Action') ||
            header.textContent.includes('Print') ||
            header.textContent.includes('Doctor')) {
            return;
        }
        
        header.style.cursor = 'pointer';
        header.style.userSelect = 'none';
        header.innerHTML += ' <i class="fas fa-sort" style="opacity: 0.5; margin-left: 0.5rem;"></i>';
        
        header.addEventListener('click', function() {
            sortTable(table, index);
        });
    });
}

function sortTable(table, columnIndex) {
    const tbody = table.querySelector('tbody');
    if (!tbody) return;
    
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    // Determine sort direction
    const isAscending = !table.dataset.sortDirection || table.dataset.sortDirection === 'desc';
    table.dataset.sortDirection = isAscending ? 'asc' : 'desc';
    
    // Sort rows
    rows.sort((a, b) => {
        const aValue = a.cells[columnIndex]?.textContent.trim() || '';
        const bValue = b.cells[columnIndex]?.textContent.trim() || '';
        
        // Handle numeric values (remove commas and currency symbols)
        const aNum = parseFloat(aValue.replace(/[^\d.-]/g, ''));
        const bNum = parseFloat(bValue.replace(/[^\d.-]/g, ''));
        
        if (!isNaN(aNum) && !isNaN(bNum)) {
            return isAscending ? aNum - bNum : bNum - aNum;
        }
        
        // Handle text values
        return isAscending ? 
            aValue.localeCompare(bValue) : 
            bValue.localeCompare(aValue);
    });
    
    // Reorder rows
    rows.forEach(row => tbody.appendChild(row));
    
    // Update sort indicators
    updateSortIndicators(table, columnIndex, isAscending);
}

function updateSortIndicators(table, columnIndex, isAscending) {
    const headers = table.querySelectorAll('th');
    headers.forEach((header, index) => {
        const icon = header.querySelector('i');
        if (index === columnIndex && icon) {
            icon.className = isAscending ? 'fas fa-sort-up' : 'fas fa-sort-down';
            icon.style.opacity = '1';
        } else if (icon) {
            icon.className = 'fas fa-sort';
            icon.style.opacity = '0.5';
        }
    });
}

function initializeRowHighlighting(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.01)';
            this.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.1)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = 'none';
        });
    });
}

function wrapTableForResponsiveness(table) {
    if (table.parentNode.classList.contains('table-responsive')) return;
    
    const wrapper = document.createElement('div');
    wrapper.className = 'table-responsive';
    wrapper.style.overflowX = 'auto';
    wrapper.style.borderRadius = 'var(--border-radius)';
    wrapper.style.boxShadow = 'var(--shadow-light)';
    
    table.parentNode.insertBefore(wrapper, table);
    wrapper.appendChild(table);
}

function enhanceRemittanceLinks(table) {
    const links = table.querySelectorAll('a[href*="print_doctorremittances.php"]');
    links.forEach(link => {
        link.classList.add('remittance-link');
        link.addEventListener('click', function(e) {
            // Add loading state for print links
            showLoadingOverlay('Generating Remittance Print...');
        });
    });
}

/**
 * Export Functionality
 */
function initializeExportFeatures() {
    // Add export buttons if they don't exist
    const reportSection = document.querySelector('.report-section');
    if (reportSection && !document.getElementById('exportButtons')) {
        const exportButtons = document.createElement('div');
        exportButtons.id = 'exportButtons';
        exportButtons.className = 'report-actions';
        exportButtons.innerHTML = `
            <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                <i class="fas fa-file-excel"></i> Export Excel
            </button>
            <button type="button" class="btn btn-outline" onclick="exportToPDF()">
                <i class="fas fa-file-pdf"></i> Export PDF
            </button>
            <button type="button" class="btn btn-outline" onclick="printReport()">
                <i class="fas fa-print"></i> Print Report
            </button>
        `;
        
        const reportHeader = reportSection.querySelector('.report-header');
        if (reportHeader) {
            reportHeader.appendChild(exportButtons);
        }
    }
}

function exportToExcel() {
    showLoadingOverlay('Exporting to Excel...');
    
    // Create a simple Excel export
    const table = document.querySelector('.remittance-table, .modern-table');
    if (!table) {
        showAlert('No data table found for export', 'error');
        hideLoadingOverlay();
        return;
    }
    
    // Simple CSV export (can be enhanced with proper Excel library)
    let csvContent = '';
    const rows = table.querySelectorAll('tr');
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('th, td');
        const rowData = Array.from(cells).map(cell => {
            return '"' + cell.textContent.replace(/"/g, '""') + '"';
        });
        csvContent += rowData.join(',') + '\n';
    });
    
    // Download CSV
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', 'doctor_remittance_report.csv');
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    hideLoadingOverlay();
    showAlert('Excel export completed successfully', 'success');
}

function exportToPDF() {
    showLoadingOverlay('Exporting to PDF...');
    
    // Simple PDF export using browser print
    setTimeout(() => {
        window.print();
        hideLoadingOverlay();
        showAlert('PDF export completed successfully', 'success');
    }, 1000);
}

function printReport() {
    showLoadingOverlay('Preparing for print...');
    
    setTimeout(() => {
        window.print();
        hideLoadingOverlay();
    }, 500);
}

/**
 * Responsive Features
 */
function initializeResponsiveFeatures() {
    // Handle window resize
    window.addEventListener('resize', function() {
        handleResponsiveLayout();
    });
    
    // Initial responsive setup
    handleResponsiveLayout();
}

function handleResponsiveLayout() {
    const sidebar = document.getElementById('leftSidebar');
    const menuToggle = document.getElementById('menuToggle');
    
    if (window.innerWidth <= 768) {
        // Mobile layout
        if (sidebar) {
            sidebar.classList.add('collapsed');
        }
        if (menuToggle) {
            menuToggle.style.display = 'flex';
        }
    } else {
        // Desktop layout
        if (sidebar) {
            sidebar.classList.remove('collapsed');
        }
        if (menuToggle) {
            menuToggle.style.display = 'none';
        }
    }
}

/**
 * Loading States
 */
function initializeLoadingStates() {
    // Add loading states to form submissions
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('input[type="submit"], button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            }
        });
    });
}

function showLoadingOverlay(message = 'Loading...') {
    // Remove existing overlay
    hideLoadingOverlay();
    
    const overlay = document.createElement('div');
    overlay.id = 'loadingOverlay';
    overlay.className = 'loading-overlay';
    
    overlay.innerHTML = `
        <div class="loading-content">
            <div class="loading-spinner">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
            <p><strong>${message}</strong></p>
            <p>Please wait...</p>
        </div>
    `;
    
    document.body.appendChild(overlay);
}

function hideLoadingOverlay() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) {
        overlay.remove();
    }
}

/**
 * Alert System
 */
function showAlert(message, type = 'info', duration = 5000) {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    
    const iconMap = {
        success: 'check-circle',
        error: 'exclamation-triangle',
        warning: 'exclamation-triangle',
        info: 'info-circle'
    };
    
    alert.innerHTML = `
        <i class="fas fa-${iconMap[type] || 'info-circle'} alert-icon"></i>
        <span>${message}</span>
        <button class="alert-close" onclick="this.parentElement.remove()" style="margin-left: auto; background: none; border: none; color: inherit; cursor: pointer; font-size: 1.2rem;">&times;</button>
    `;
    
    alertContainer.appendChild(alert);
    
    // Auto-remove after duration
    if (duration > 0) {
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, duration);
    }
}

/**
 * Utility Functions
 */
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-IN', {
        style: 'currency',
        currency: 'INR',
        minimumFractionDigits: 2
    }).format(amount);
}

function formatNumber(number) {
    return new Intl.NumberFormat('en-IN').format(number);
}

/**
 * Page Refresh Functionality
 */
function refreshPage() {
    showLoadingOverlay('Refreshing Page...');
    setTimeout(() => {
        window.location.reload();
    }, 1000);
}

/**
 * Global Functions
 */
window.refreshPage = refreshPage;
window.printPage = printReport;
window.showAlert = showAlert;
window.exportToExcel = exportToExcel;
window.exportToPDF = exportToPDF;
window.printReport = printReport;



