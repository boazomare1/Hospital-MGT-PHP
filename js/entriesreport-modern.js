// Entries Report Modern JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initializeSidebar();
    initializeFormValidation();
    initializeAlerts();
    initializeDataTable();
    initializePrint();
});

// Sidebar functionality
function initializeSidebar() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('leftSidebar');
    const mainContainer = document.querySelector('.main-container-with-sidebar');

    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 1024) {
            if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                mainContainer.classList.add('sidebar-collapsed');
            }
        }
    });
}

// Form validation
function initializeFormValidation() {
    const form = document.getElementById('form1');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
            }
        });
    }
}

function validateForm() {
    const transactiondatefrom = document.getElementById('transactiondatefrom');
    const transactiondateto = document.getElementById('transactiondateto');

    if (!transactiondatefrom || !transactiondatefrom.value.trim()) {
        showAlert('Please select From Date', 'error');
        if (transactiondatefrom) transactiondatefrom.focus();
        return false;
    }

    if (!transactiondateto || !transactiondateto.value.trim()) {
        showAlert('Please select To Date', 'error');
        if (transactiondateto) transactiondateto.focus();
        return false;
    }

    // Validate date range
    const fromDate = new Date(transactiondatefrom.value);
    const toDate = new Date(transactiondateto.value);
    
    if (fromDate > toDate) {
        showAlert('From Date cannot be greater than To Date', 'error');
        if (transactiondatefrom) transactiondatefrom.focus();
        return false;
    }

    return true;
}

// Alert system
function initializeAlerts() {
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
}

function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;

    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    
    const icon = getAlertIcon(type);
    alert.innerHTML = `
        <i class="fas ${icon}"></i>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; margin-left: auto; cursor: pointer;">
            <i class="fas fa-times"></i>
        </button>
    `;

    alertContainer.appendChild(alert);

    // Auto-hide after 5 seconds
    setTimeout(() => {
        alert.style.opacity = '0';
        setTimeout(() => {
            alert.remove();
        }, 300);
    }, 5000);
}

function getAlertIcon(type) {
    const icons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-circle',
        warning: 'fa-exclamation-triangle',
        info: 'fa-info-circle'
    };
    return icons[type] || icons.info;
}

// Data table functionality
function initializeDataTable() {
    // Add any data table specific initialization here
    console.log('Data table initialized');
}

// Print functionality
function initializePrint() {
    const printButton = document.getElementById('printButton');
    if (printButton) {
        printButton.addEventListener('click', function() {
            printReport();
        });
    }
}

function printReport() {
    // Show loading message
    showAlert('Preparing report for printing...', 'info');
    
    // Create a new window for printing
    const printWindow = window.open('', '_blank');
    
    // Get the current page content
    const content = document.querySelector('.main-content').innerHTML;
    
    // Create print-friendly HTML
    const printHTML = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Journal Entries Report - MedStar</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .page-header { text-align: center; margin-bottom: 30px; }
                .page-title { font-size: 24px; font-weight: bold; margin-bottom: 10px; }
                .page-subtitle { font-size: 16px; color: #666; }
                .data-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                .data-table th, .data-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                .data-table th { background-color: #f2f2f2; font-weight: bold; }
                .summary-cards { display: flex; justify-content: space-around; margin: 20px 0; }
                .summary-card { text-align: center; padding: 15px; border: 1px solid #ddd; }
                .summary-card-value { font-size: 18px; font-weight: bold; }
                .summary-card-label { font-size: 12px; color: #666; }
                @media print {
                    body { margin: 0; }
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>
            <div class="page-header">
                <div class="page-title">Journal Entries Report</div>
                <div class="page-subtitle">MedStar Hospital Management System</div>
                <div class="page-subtitle">Generated on: ${new Date().toLocaleString()}</div>
            </div>
            ${content}
        </body>
        </html>
    `;
    
    printWindow.document.write(printHTML);
    printWindow.document.close();
    
    // Wait for content to load, then print
    printWindow.onload = function() {
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    };
}

// Utility functions
function refreshData() {
    showAlert('Refreshing data...', 'info');
    location.reload();
}

function exportToExcel() {
    showAlert('Exporting to Excel...', 'info');
    
    // Create a simple CSV export
    const table = document.querySelector('.data-table');
    if (!table) {
        showAlert('No data to export', 'error');
        return;
    }
    
    let csv = '';
    const rows = table.querySelectorAll('tr');
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('th, td');
        const rowData = Array.from(cells).map(cell => {
            return '"' + cell.textContent.replace(/"/g, '""') + '"';
        });
        csv += rowData.join(',') + '\n';
    });
    
    // Create and download file
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'journal_entries_report_' + new Date().toISOString().split('T')[0] + '.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
    
    showAlert('Report exported successfully', 'success');
}

// Initialize date pickers
$(function() {
    $('.from_date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    
    $('.to_date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
});

// Auto-submit form when dates are selected
$(document).ready(function() {
    $('#transactiondatefrom, #transactiondateto').on('change', function() {
        if ($('#transactiondatefrom').val() && $('#transactiondateto').val()) {
            // Auto-submit form after a short delay
            setTimeout(function() {
                $('#form1').submit();
            }, 500);
        }
    });
});
