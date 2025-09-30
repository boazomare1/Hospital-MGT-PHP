// Modern JavaScript for Global Closing Stock Report

$(document).ready(function() {
    // Initialize page
    initializePage();
    
    // Setup event listeners
    setupEventListeners();
    
    // Initialize autocomplete
    initializeAutocomplete();
});

// Initialize page elements
function initializePage() {
    // Setup sidebar toggle
    setupSidebarToggle();
    
    // Setup menu toggle
    setupMenuToggle();
    
    // Initialize tooltips
    initializeTooltips();
}

// Setup event listeners
function setupEventListeners() {
    // Form validation
    $('form[name="stockinward"]').on('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return false;
        }
    });
    
    // Auto-refresh functionality
    setupAutoRefresh();
    
    // Export functionality
    setupExportFunctionality();
    
    // Print functionality
    setupPrintFunctionality();
}

// Setup sidebar toggle
function setupSidebarToggle() {
    $('#sidebarToggle').on('click', function() {
        $('#leftSidebar').toggleClass('collapsed');
        const icon = $(this).find('i');
        if ($('#leftSidebar').hasClass('collapsed')) {
            icon.removeClass('fa-chevron-left').addClass('fa-chevron-right');
        } else {
            icon.removeClass('fa-chevron-right').addClass('fa-chevron-left');
        }
    });
}

// Setup menu toggle
function setupMenuToggle() {
    $('#menuToggle').on('click', function() {
        $('#leftSidebar').toggleClass('collapsed');
        const icon = $(this).find('i');
        if ($('#leftSidebar').hasClass('collapsed')) {
            icon.removeClass('fa-bars').addClass('fa-times');
        } else {
            icon.removeClass('fa-times').addClass('fa-bars');
        }
    });
}

// Initialize autocomplete for item names
function initializeAutocomplete() {
    // This would integrate with existing autocomplete functionality
    // The existing autocomplete scripts are already included in the HTML
}

// Form validation
function stockinwardvalidation1() {
    if (document.stockinward.itemcode.value == "") {
        showAlert("Please Select Item Name.", 'error');
        return false;
    } else if (document.stockinward.servicename.value == "") {
        showAlert("Please Select Item Name.", 'error');
        document.stockinward.servicename.focus();
        return false;
    } else if (document.stockinward.stockquantity.value == "") {
        showAlert("Please Enter Stock Quantity.", 'error');
        document.stockinward.stockquantity.focus();
        return false;
    } else if (isNaN(document.stockinward.stockquantity.value)) {
        showAlert("Please Enter Only Numbers Stock Quantity.", 'error');
        document.stockinward.stockquantity.focus();
        return false;
    } else if (document.stockinward.stockquantity.value == "0") {
        showAlert("Please Enter Stock Quantity.", 'error');
        document.stockinward.stockquantity.focus();
        return false;
    } else if (document.stockinward.stockquantity.value == "0.0") {
        showAlert("Please Enter Stock Quantity.", 'error');
        document.stockinward.stockquantity.focus();
        return false;
    } else if (document.stockinward.stockquantity.value == "0.00") {
        showAlert("Please Enter Stock Quantity.", 'error');
        document.stockinward.stockquantity.focus();
        return false;
    } else if (document.stockinward.stockquantity.value == "0.000") {
        showAlert("Please Enter Stock Quantity.", 'error');
        document.stockinward.stockquantity.focus();
        return false;
    }
    
    return true;
}

// Validate form before submission
function validateForm() {
    // Check if location is selected
    if (document.getElementById("location").value == '') {
        showAlert("Please Select Location", 'error');
        document.getElementById("location").focus();
        return false;
    }
    
    return true;
}

// Location check function
function Locationcheck() {
    if (document.getElementById("location").value == '') {
        showAlert("Please Select Location", 'error');
        document.getElementById("location").focus();
        return false;
    }
    
    return true;
}

// Item code entry function
function itemcodeentry2() {
    let key;
    if (window.event) {
        key = window.event.keyCode; // IE
    } else {
        key = event.which; // Firefox
    }
    
    if (key == 13) { // if enter key press
        return false;
    } else {
        return true;
    }
}

// Disable enter key function
function disableEnterKey() {
    if (event.keyCode == 8) {
        event.keyCode = 0;
        return event.keyCode;
        return false;
    }
    
    let key;
    if (window.event) {
        key = window.event.keyCode; // IE
    } else {
        key = event.which; // Firefox
    }
    
    if (key == 13) { // if enter key press
        return false;
    } else {
        return true;
    }
}

// Store function for AJAX
function storefunction(loc) {
    const username = document.getElementById("username").value;
    
    let xmlhttp;
    
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("store").innerHTML = xmlhttp.responseText;
        }
    }
    
    xmlhttp.open("GET", "ajax/ajaxstore.php?loc=" + loc + "&username=" + username, true);
    xmlhttp.send();
}

// Process rate per unit
function process1rateperunit() {
    servicenameonchange1();
}

// Delete record function
function deleterecord1(varEntryNumber, varAutoNumber) {
    const varEntryNumber = varEntryNumber;
    const varAutoNumber = varAutoNumber;
    let fRet;
    fRet = confirm('Are you sure want to delete the stock entry no. ' + varEntryNumber + ' ?');
    
    if (fRet == false) {
        showAlert("Stock Entry Delete Not Completed.", 'error');
        return false;
    } else {
        window.location = "stockreport2.php?task=del&&delanum=" + varAutoNumber;
    }
}

// Setup auto-refresh functionality
function setupAutoRefresh() {
    // Auto-refresh every 10 minutes if no user activity
    let lastActivity = Date.now();
    const refreshInterval = 10 * 60 * 1000; // 10 minutes
    
    $(document).on('mousemove keypress scroll', function() {
        lastActivity = Date.now();
    });
    
    setInterval(function() {
        if (Date.now() - lastActivity > refreshInterval) {
            location.reload();
        }
    }, 60000); // Check every minute
}

// Setup export functionality
function setupExportFunctionality() {
    // Export to Excel functionality
    window.exportToExcel = function() {
        const table = document.querySelector('.data-table');
        if (!table) {
            showAlert('No data to export.', 'error');
            return;
        }
        
        // Create a simple CSV export
        let csv = [];
        const rows = table.querySelectorAll('tr');
        
        for (let i = 0; i < rows.length; i++) {
            const row = [];
            const cols = rows[i].querySelectorAll('td, th');
            
            for (let j = 0; j < cols.length; j++) {
                let cellText = cols[j].innerText || cols[j].textContent || '';
                cellText = cellText.replace(/"/g, '""');
                row.push('"' + cellText + '"');
            }
            
            csv.push(row.join(','));
        }
        
        const csvContent = csv.join('\n');
        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'global_closing_stock_' + new Date().toISOString().split('T')[0] + '.csv';
        a.click();
        window.URL.revokeObjectURL(url);
    };
}

// Setup print functionality
function setupPrintFunctionality() {
    window.printReport = function() {
        // Hide elements that shouldn't be printed
        const elementsToHide = document.querySelectorAll('.floating-menu-toggle, .left-sidebar, .page-header-actions, .results-actions, .export-actions, .btn');
        elementsToHide.forEach(el => el.style.display = 'none');
        
        // Print the page
        window.print();
        
        // Show elements back
        elementsToHide.forEach(el => el.style.display = '');
    };
}

// Refresh page function
function refreshPage() {
    location.reload();
}

// Show alert function
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alertClass = type === 'error' ? 'alert-error' : 
                     type === 'success' ? 'alert-success' : 'alert-info';
    
    const iconClass = type === 'error' ? 'exclamation-triangle' : 
                     type === 'success' ? 'check-circle' : 'info-circle';
    
    const alertHtml = `
        <div class="alert ${alertClass}">
            <i class="fas fa-${iconClass} alert-icon"></i>
            <span>${message}</span>
        </div>
    `;
    
    alertContainer.innerHTML = alertHtml;
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        const alert = alertContainer.querySelector('.alert');
        if (alert) {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }
    }, 5000);
}

// Initialize tooltips
function initializeTooltips() {
    $('[data-tooltip]').each(function() {
        const tooltip = $(this).attr('data-tooltip');
        $(this).attr('title', tooltip);
    });
}

// Utility functions
function formatCurrency(amount) {
    return parseFloat(amount).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}

function formatNumber(number) {
    return parseFloat(number).toLocaleString();
}

function validateNumericInput(input) {
    const value = input.value.replace(/[^0-9\.]/g, '');
    input.value = value;
    return value;
}

// Table sorting functionality
function sortTable(columnIndex) {
    const table = document.querySelector('.data-table');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    const isNumeric = columnIndex >= 5; // Assuming columns 5+ are numeric
    
    rows.sort((a, b) => {
        const aText = a.cells[columnIndex].textContent.trim();
        const bText = b.cells[columnIndex].textContent.trim();
        
        if (isNumeric) {
            const aNum = parseFloat(aText.replace(/,/g, '')) || 0;
            const bNum = parseFloat(bText.replace(/,/g, '')) || 0;
            return aNum - bNum;
        } else {
            return aText.localeCompare(bText);
        }
    });
    
    rows.forEach(row => tbody.appendChild(row));
}

// Search functionality
function searchTable() {
    const input = document.getElementById('itemname');
    const filter = input.value.toUpperCase();
    const table = document.querySelector('.data-table');
    const rows = table.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        let found = false;
        
        cells.forEach(cell => {
            if (cell.textContent.toUpperCase().indexOf(filter) > -1) {
                found = true;
            }
        });
        
        row.style.display = found ? '' : 'none';
    });
}

// Initialize search on input
$(document).ready(function() {
    $('#itemname').on('keyup', function() {
        searchTable();
    });
});

// Loading state management
function showLoading(element) {
    element.classList.add('loading');
}

function hideLoading(element) {
    element.classList.remove('loading');
}

// Data refresh functionality
function refreshData() {
    const form = document.querySelector('form[name="stockinward"]');
    if (form) {
        showLoading(document.querySelector('.results-section'));
        form.submit();
    }
}

// Initialize on page load
$(document).ready(function() {
    // Add click handlers for table headers to enable sorting
    $('.data-table th').each(function(index) {
        $(this).css('cursor', 'pointer');
        $(this).on('click', function() {
            sortTable(index);
        });
    });
    
    // Add hover effects to table rows
    $('.data-table tbody tr').hover(
        function() {
            $(this).addClass('hover');
        },
        function() {
            $(this).removeClass('hover');
        }
    );
});


