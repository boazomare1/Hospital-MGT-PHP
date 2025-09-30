// Lab Revenue Report Modern JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initializeSidebar();
    initializeFormValidation();
    initializeSearch();
    initializeDatePickers();
    initializeAlerts();
    initializeAutocomplete();
    initializeTableEnhancements();
    initializeFinancialSummary();
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
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 1024) {
            if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
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

// Form validation
function initializeFormValidation() {
    const form = document.querySelector('form[name="cbform1"]');
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        const fromDate = document.getElementById('ADate1');
        const toDate = document.getElementById('ADate2');
        
        // Validate date range
        if (fromDate && toDate) {
            const fromDateValue = new Date(fromDate.value);
            const toDateValue = new Date(toDate.value);
            
            if (fromDateValue > toDateValue) {
                e.preventDefault();
                showAlert('From date cannot be greater than To date', 'error');
                fromDate.focus();
                return false;
            }
        }
        
        // Show loading state
        const submitBtn = form.querySelector('input[type="submit"]');
        if (submitBtn) {
            submitBtn.value = 'Searching...';
            submitBtn.disabled = true;
        }
    });
}

// Search functionality
function initializeSearch() {
    const searchInputs = document.querySelectorAll('input[name="lab"]');
    
    searchInputs.forEach(function(input) {
        // Debounced search
        let searchTimeout;
        input.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                // Auto-search functionality can be added here
            }, 500);
        });
        
        // Enter key search
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const form = input.closest('form');
                if (form) {
                    form.submit();
                }
            }
        });
    });
}

// Date picker initialization
function initializeDatePickers() {
    // Initialize date pickers if the library is available
    if (typeof NewCssCal !== 'undefined') {
        const dateInputs = document.querySelectorAll('input[id^="ADate"]');
        dateInputs.forEach(function(input) {
            // Date picker is already initialized via onclick in HTML
        });
    }
}

// Alert system
function initializeAlerts() {
    // Auto-hide success alerts after 5 seconds
    const successAlerts = document.querySelectorAll('.alert.success');
    successAlerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.remove();
            }, 300);
        }, 5000);
    });
}

// Show alert function
function showAlert(message, type = 'info') {
    const alertContainer = document.querySelector('.alert-container');
    if (!alertContainer) return;
    
    const alert = document.createElement('div');
    alert.className = `alert ${type}`;
    alert.textContent = message;
    
    alertContainer.appendChild(alert);
    
    // Auto-hide after 5 seconds
    setTimeout(function() {
        alert.style.opacity = '0';
        setTimeout(function() {
            alert.remove();
        }, 300);
    }, 5000);
}

// Autocomplete initialization
function initializeAutocomplete() {
    if (typeof $ !== 'undefined' && $.fn.autocomplete) {
        $('#lab').autocomplete({
            source: "ajaxlab_search.php",
            matchContains: true,
            minLength: 1,
            html: true,
            select: function(event, ui) {
                var accountname = ui.item.value;
                var accountid = ui.item.id;
                var accountanum = ui.item.anum;
                $("#labcode").val(accountid);
                $("#lab").val(accountname);
            }
        });
    }
}

// Form submission handler
function cbsuppliername1() {
    const form = document.cbform1;
    if (form) {
        form.submit();
    }
}

// Disable enter key function
function disableEnterKey() {
    if (event.keyCode == 8) {
        event.keyCode = 0;
        return event.keyCode;
        return false;
    }
    
    var key;
    if (window.event) {
        key = window.event.keyCode;
    } else {
        key = e.which;
    }
    
    if (key == 13) {
        return false;
    } else {
        return true;
    }
}

// Print receipt function
function funcPrintReceipt1(varRecAnum) {
    var varRecAnum = varRecAnum;
    window.open("print_payment_receipt1.php?receiptanum=" + varRecAnum + "", "OriginalWindow", 'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

// Delete payment function
function funcDeletePayment1(varPaymentSerialNumber) {
    var varPaymentSerialNumber = varPaymentSerialNumber;
    var fRet;
    fRet = confirm('Are you sure want to delete this payment entry serial number ' + varPaymentSerialNumber + '?');
    
    if (fRet == true) {
        showAlert("Payment Entry Delete Completed.", 'success');
    }
    
    if (fRet == false) {
        showAlert("Payment Entry Delete Not Completed.", 'error');
        return false;
    }
}

// Table enhancements
function initializeTableEnhancements() {
    const table = document.querySelector('.data-table');
    if (!table) return;
    
    // Add hover effects
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(function(row) {
        row.addEventListener('mouseenter', function() {
            if (!this.classList.contains('total-row') && !this.classList.contains('grand-total-row')) {
                this.style.backgroundColor = '#f8f9fa';
            }
        });
        
        row.addEventListener('mouseleave', function() {
            if (!this.classList.contains('total-row') && !this.classList.contains('grand-total-row')) {
                this.style.backgroundColor = '';
            }
        });
    });
    
    // Add sorting functionality
    addSortingToTable();
}

// Add sorting functionality to table headers
function addSortingToTable() {
    const table = document.querySelector('.data-table');
    if (!table) return;
    
    const headers = table.querySelectorAll('th');
    headers.forEach(function(header, index) {
        if (index > 0) { // Skip first column (No.)
            header.style.cursor = 'pointer';
            header.addEventListener('click', function() {
                sortTable(index);
            });
            
            // Add sort indicator
            const sortIcon = document.createElement('i');
            sortIcon.className = 'fas fa-sort';
            sortIcon.style.marginLeft = '5px';
            sortIcon.style.opacity = '0.5';
            header.appendChild(sortIcon);
        }
    });
}

// Sort table by column
function sortTable(columnIndex) {
    const table = document.querySelector('.data-table');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr:not(.total-row):not(.grand-total-row)'));
    
    rows.sort(function(a, b) {
        const aText = a.cells[columnIndex].textContent.trim();
        const bText = b.cells[columnIndex].textContent.trim();
        
        // Try to parse as numbers first
        const aNum = parseFloat(aText.replace(/[,$]/g, ''));
        const bNum = parseFloat(bText.replace(/[,$]/g, ''));
        
        if (!isNaN(aNum) && !isNaN(bNum)) {
            return aNum - bNum;
        }
        
        // Otherwise sort as strings
        return aText.localeCompare(bText);
    });
    
    // Clear tbody and re-append sorted rows
    const totalRows = tbody.querySelectorAll('.total-row, .grand-total-row');
    tbody.innerHTML = '';
    
    rows.forEach(function(row) {
        tbody.appendChild(row);
    });
    
    // Re-append total rows
    totalRows.forEach(function(row) {
        tbody.appendChild(row);
    });
}

// Financial summary enhancements
function initializeFinancialSummary() {
    // Animate numbers on load
    animateNumbers();
    
    // Add export functionality
    addExportFunctionality();
}

// Animate numbers in summary cards
function animateNumbers() {
    const summaryValues = document.querySelectorAll('.summary-value');
    
    summaryValues.forEach(function(element) {
        const finalValue = parseFloat(element.textContent.replace(/[,$]/g, ''));
        if (!isNaN(finalValue)) {
            animateNumber(element, 0, finalValue, 1000);
        }
    });
}

// Animate number counting
function animateNumber(element, start, end, duration) {
    const startTime = performance.now();
    const isCurrency = element.textContent.includes('$');
    
    function updateNumber(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        
        const current = start + (end - start) * progress;
        const displayValue = isCurrency ? formatCurrency(current) : formatNumber(current);
        
        element.textContent = displayValue;
        
        if (progress < 1) {
            requestAnimationFrame(updateNumber);
        }
    }
    
    requestAnimationFrame(updateNumber);
}

// Add export functionality
function addExportFunctionality() {
    const exportBtn = document.querySelector('.export-btn');
    if (exportBtn) {
        exportBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // Export functionality is handled by the href
            window.open(this.href, '_blank');
        });
    }
}

// Utility functions
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

function formatNumber(number) {
    return new Intl.NumberFormat('en-US').format(number);
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

// Filter functionality
function filterTable() {
    const searchTerm = document.querySelector('.search-input').value.toLowerCase();
    const table = document.querySelector('.data-table');
    const rows = table.querySelectorAll('tbody tr:not(.total-row):not(.grand-total-row)');
    
    rows.forEach(function(row) {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Print functionality
function printReport() {
    window.print();
}

// Export to Excel
function exportToExcel() {
    const exportBtn = document.querySelector('.export-btn');
    if (exportBtn) {
        exportBtn.click();
    }
}

// Responsive table handling
function handleResponsiveTable() {
    const table = document.querySelector('.data-table');
    if (!table) return;
    
    if (window.innerWidth <= 768) {
        table.classList.add('responsive');
    } else {
        table.classList.remove('responsive');
    }
}

// Handle window resize for responsive table
window.addEventListener('resize', handleResponsiveTable);

// Initialize responsive table on load
document.addEventListener('DOMContentLoaded', handleResponsiveTable);

// Chart functionality (if needed)
function createRevenueChart() {
    // This can be implemented with Chart.js or similar library
    console.log('Revenue chart functionality can be added here');
}

// Summary calculations
function calculateSummary() {
    const table = document.querySelector('.data-table');
    if (!table) return;
    
    let totalIncome = 0;
    let totalRefund = 0;
    
    const incomeRows = table.querySelectorAll('tbody tr:not(.total-row):not(.grand-total-row)');
    incomeRows.forEach(function(row) {
        const rateCell = row.cells[8]; // Assuming rate is in column 8
        if (rateCell) {
            const rate = parseFloat(rateCell.textContent.replace(/[,$]/g, ''));
            if (!isNaN(rate)) {
                totalIncome += rate;
            }
        }
    });
    
    // Update summary cards if they exist
    const incomeCard = document.querySelector('.summary-card.income .summary-value');
    if (incomeCard) {
        incomeCard.textContent = formatCurrency(totalIncome);
    }
    
    const netCard = document.querySelector('.summary-card.net .summary-value');
    if (netCard) {
        netCard.textContent = formatCurrency(totalIncome - totalRefund);
    }
}

// Initialize summary calculations
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(calculateSummary, 1000);
});
