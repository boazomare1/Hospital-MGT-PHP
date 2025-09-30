// Lab Test Report Modern JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initializeSidebar();
    initializeFormValidation();
    initializeSearch();
    initializeDatePickers();
    initializeAlerts();
    initializeTableEnhancements();
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
    const searchInputs = document.querySelectorAll('input[name="patient"], input[name="patientcode"], input[name="visitcode"]');
    
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

// Location change handler
function ajaxlocationfunction(val) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            const locationElement = document.getElementById("ajaxlocation");
            if (locationElement) {
                locationElement.innerHTML = xmlhttp.responseText;
            }
        }
    };
    
    xmlhttp.open("GET", "ajax/ajaxgetlocationname.php?loccode=" + val, true);
    xmlhttp.send();
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

// Payment entry process
function paymententry1process2() {
    const cbfrmflag1 = document.getElementById("cbfrmflag1");
    if (!cbfrmflag1 || cbfrmflag1.value == "") {
        showAlert("Search Bill Number Cannot Be Empty.", 'error');
        if (cbfrmflag1) {
            cbfrmflag1.focus();
        }
        return false;
    }
    return true;
}

// Print receipt function
function funcPrintReceipt1() {
    window.open("print_payment_receipt1.php", "OriginalWindow", 'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

// Table enhancements
function initializeTableEnhancements() {
    const table = document.querySelector('.data-table');
    if (!table) return;
    
    // Add hover effects
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(function(row) {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f8f9fa';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });
    
    // Add status indicators
    addStatusIndicators();
}

// Add status indicators to table cells
function addStatusIndicators() {
    const statusCells = document.querySelectorAll('td');
    statusCells.forEach(function(cell) {
        const text = cell.textContent.trim();
        if (text === 'Yes') {
            cell.classList.add('status-completed');
        } else if (text === 'No' || text === '') {
            cell.classList.add('status-pending');
        }
    });
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

function formatTime(timeString) {
    if (!timeString) return '';
    return timeString.substring(0, 5); // Show only HH:MM
}

// Export functionality
function exportToExcel() {
    const exportBtn = document.querySelector('.export-btn');
    if (exportBtn) {
        exportBtn.click();
    }
}

// Print functionality
function printReport() {
    window.print();
}

// Filter functionality
function filterTable() {
    const searchTerm = document.querySelector('.search-input').value.toLowerCase();
    const table = document.querySelector('.data-table');
    const rows = table.querySelectorAll('tbody tr');
    
    rows.forEach(function(row) {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Sort functionality
function sortTable(columnIndex) {
    const table = document.querySelector('.data-table');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    rows.sort(function(a, b) {
        const aText = a.cells[columnIndex].textContent.trim();
        const bText = b.cells[columnIndex].textContent.trim();
        
        // Try to parse as numbers first
        const aNum = parseFloat(aText);
        const bNum = parseFloat(bText);
        
        if (!isNaN(aNum) && !isNaN(bNum)) {
            return aNum - bNum;
        }
        
        // Otherwise sort as strings
        return aText.localeCompare(bText);
    });
    
    // Clear tbody and re-append sorted rows
    tbody.innerHTML = '';
    rows.forEach(function(row) {
        tbody.appendChild(row);
    });
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

// Test count animation
function animateTestCount() {
    const countElement = document.querySelector('.test-count');
    if (!countElement) return;
    
    const finalCount = parseInt(countElement.textContent.replace(/[<>]/g, ''));
    let currentCount = 0;
    const increment = Math.ceil(finalCount / 50);
    
    const timer = setInterval(function() {
        currentCount += increment;
        if (currentCount >= finalCount) {
            currentCount = finalCount;
            clearInterval(timer);
        }
        countElement.textContent = `<<${currentCount}>>`;
    }, 50);
}

// Initialize test count animation
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(animateTestCount, 500);
});
