// Modern JavaScript for Approved Credit List - MedStar Hospital Management System

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all functionality
    initSidebar();
    initDataTable();
    initDeleteConfirmations();
    initSearchAndFilter();
    initResponsiveFeatures();
});

// Sidebar functionality
function initSidebar() {
    const sidebar = document.getElementById('leftSidebar');
    const mainContainer = document.getElementById('mainContainer');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (!sidebar || !mainContainer) return;
    
    // Mobile menu toggle
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }
    
    // Sidebar toggle button
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 1024) {
            if (!sidebar.contains(event.target) && !mobileMenuToggle.contains(event.target)) {
                mainContainer.classList.remove('sidebar-collapsed');
            }
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 1024) {
            mainContainer.classList.remove('sidebar-collapsed');
        }
    });
}

// Data table functionality
function initDataTable() {
    const dataTable = document.querySelector('.data-table');
    if (!dataTable) return;
    
    // Add row hover effects
    const rows = dataTable.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-1px)';
            this.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.1)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });
    
    // Add loading states for actions
    const actionButtons = dataTable.querySelectorAll('.btn');
    actionButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (this.classList.contains('btn-danger')) {
                // Don't add loading state for delete buttons as they show confirmation
                return;
            }
            
            this.classList.add('loading');
            this.disabled = true;
            
            // Re-enable after 3 seconds
            setTimeout(() => {
                this.classList.remove('loading');
                this.disabled = false;
            }, 3000);
        });
    });
}

// Delete confirmation functionality
function initDeleteConfirmations() {
    const deleteButtons = document.querySelectorAll('.btn-danger[onclick*="delete"]');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const patientName = this.closest('tr').querySelector('td:nth-child(3)')?.textContent || 'this record';
            const visitCode = this.closest('tr').querySelector('td:nth-child(4)')?.textContent || '';
            
            if (confirm(`Are you sure you want to delete the credit approval for ${patientName}${visitCode ? ' (Visit: ' + visitCode + ')' : ''}?\n\nThis action cannot be undone.`)) {
                // Show loading state
                this.classList.add('loading');
                this.disabled = true;
                
                // Execute the original onclick function
                const originalOnclick = this.getAttribute('onclick');
                if (originalOnclick) {
                    eval(originalOnclick);
                }
            }
        });
    });
}

// Search and filter functionality
function initSearchAndFilter() {
    // Add search functionality if search input exists
    const searchInput = document.querySelector('input[type="search"]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('.data-table tbody tr');
            
            tableRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                if (rowText.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Update row numbers
            updateRowNumbers();
        });
    }
    
    // Add filter functionality
    const filterSelects = document.querySelectorAll('select[data-filter]');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            const filterValue = this.value;
            const filterColumn = this.getAttribute('data-filter');
            const tableRows = document.querySelectorAll('.data-table tbody tr');
            
            tableRows.forEach(row => {
                if (filterValue === '' || filterValue === 'all') {
                    row.style.display = '';
                } else {
                    const cellValue = row.querySelector(`td[data-column="${filterColumn}"]`)?.textContent.toLowerCase();
                    if (cellValue && cellValue.includes(filterValue.toLowerCase())) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
            
            updateRowNumbers();
        });
    });
}

// Update row numbers after filtering
function updateRowNumbers() {
    const visibleRows = document.querySelectorAll('.data-table tbody tr:not([style*="display: none"])');
    visibleRows.forEach((row, index) => {
        const snoCell = row.querySelector('td:first-child');
        if (snoCell) {
            snoCell.textContent = index + 1;
        }
    });
}

// Responsive features
function initResponsiveFeatures() {
    // Handle table responsiveness
    const dataTable = document.querySelector('.data-table');
    if (!dataTable) return;
    
    // Add horizontal scroll indicator
    const tableContainer = dataTable.closest('.data-table-container');
    if (tableContainer) {
        const scrollIndicator = document.createElement('div');
        scrollIndicator.className = 'scroll-indicator';
        scrollIndicator.innerHTML = '<i class="fas fa-arrows-alt-h"></i> Scroll horizontally to see more columns';
        scrollIndicator.style.cssText = `
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: var(--medstar-primary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-size: 0.8rem;
            opacity: 0.8;
            z-index: 10;
        `;
        
        tableContainer.style.position = 'relative';
        tableContainer.appendChild(scrollIndicator);
        
        // Hide indicator if table doesn't overflow
        if (tableContainer.scrollWidth <= tableContainer.clientWidth) {
            scrollIndicator.style.display = 'none';
        }
    }
    
    // Add mobile-friendly action buttons
    if (window.innerWidth <= 768) {
        const actionButtons = document.querySelectorAll('.action-buttons');
        actionButtons.forEach(buttonGroup => {
            buttonGroup.style.flexDirection = 'column';
            buttonGroup.style.gap = '0.25rem';
        });
    }
}

// Utility functions
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type}`;
    notification.innerHTML = `
        <i class="fas fa-${getIconForType(type)} alert-icon"></i>
        <span>${message}</span>
    `;
    
    const container = document.querySelector('.main-content');
    if (container) {
        container.insertBefore(notification, container.firstChild);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
}

function getIconForType(type) {
    const icons = {
        'success': 'check-circle',
        'error': 'exclamation-triangle',
        'warning': 'exclamation-triangle',
        'info': 'info-circle'
    };
    return icons[type] || 'info-circle';
}

// Export functionality
function exportToCSV() {
    const table = document.querySelector('.data-table');
    if (!table) return;
    
    const rows = table.querySelectorAll('tr');
    let csv = [];
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('th, td');
        const rowData = Array.from(cells).map(cell => {
            let text = cell.textContent.trim();
            // Escape quotes and wrap in quotes if contains comma
            if (text.includes(',') || text.includes('"')) {
                text = '"' + text.replace(/"/g, '""') + '"';
            }
            return text;
        });
        csv.push(rowData.join(','));
    });
    
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    
    const a = document.createElement('a');
    a.href = url;
    a.download = 'approved_credit_list.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
    
    showNotification('Data exported to CSV successfully!', 'success');
}

// Print functionality
function printTable() {
    const printWindow = window.open('', '_blank');
    const table = document.querySelector('.data-table');
    
    if (!table) return;
    
    const printContent = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Approved Credit List - MedStar Hospital</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #1e40af; color: white; }
                tr:nth-child(even) { background-color: #f2f2f2; }
                .header { text-align: center; margin-bottom: 20px; }
                .header h1 { color: #1e40af; }
                .print-date { text-align: right; margin-bottom: 20px; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>🏥 MedStar Hospital Management</h1>
                <h2>Approved Credit List</h2>
            </div>
            <div class="print-date">
                Printed on: ${new Date().toLocaleDateString()} at ${new Date().toLocaleTimeString()}
            </div>
            ${table.outerHTML}
        </body>
        </html>
    `;
    
    printWindow.document.write(printContent);
    printWindow.document.close();
    printWindow.print();
    
    showNotification('Print dialog opened!', 'info');
}

// Legacy function compatibility
function funcPopupOnLoader() {
    // Initialize any legacy popup functionality
    console.log('Legacy popup loader function called');
}

// Add keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + P for print
    if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
        e.preventDefault();
        printTable();
    }
    
    // Ctrl/Cmd + E for export
    if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
        e.preventDefault();
        exportToCSV();
    }
    
    // Escape to close sidebar on mobile
    if (e.key === 'Escape') {
        const mainContainer = document.getElementById('mainContainer');
        if (mainContainer) {
            mainContainer.classList.remove('sidebar-collapsed');
        }
    }
});

