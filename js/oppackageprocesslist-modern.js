// OP Package Process List Modern JavaScript - MedStar Hospital Management

$(document).ready(function() {
    // Initialize page
    initializePage();
    
    // Setup event listeners
    setupEventListeners();
    
    // Initialize functionality
    initializeFunctionality();
});

function initializePage() {
    // Setup sidebar toggle
    $('#menuToggle').click(function() {
        $('#leftSidebar').toggleClass('collapsed');
        $(this).find('i').toggleClass('fa-bars fa-times');
    });
    
    // Setup sidebar toggle button
    $('#sidebarToggle').click(function() {
        $('#leftSidebar').toggleClass('collapsed');
    });
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
}

function setupEventListeners() {
    // Form validation
    $('form').on('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return false;
        }
    });
    
    // Execute link confirmation
    $('.executelink').click(function(e) {
        if (!confirm("Are you sure you want to process this package?")) {
            e.preventDefault();
            return false;
        }
    });
    
    // Show/hide document details
    $('.showdocument').click(function() {
        var sno = $(this).attr('id');
        $('#show' + sno).toggle();
        
        // Toggle icon
        var img = $(this).find('img');
        if ($('#show' + sno).is(':visible')) {
            img.attr('src', 'images/minus1.gif');
        } else {
            img.attr('src', 'images/plus1.gif');
        }
    });
}

function initializeFunctionality() {
    // Initialize any additional functionality
    console.log('OP Package Process List initialized');
}

// Original functions from the legacy code
function cbcustomername1() {
    document.cbform1.submit();
}

function pharmacy(patientcode, visitcode) {
    var patientcode = patientcode;
    var visitcode = visitcode;
    var url = "pharmacy1.php?RandomKey=" + Math.random() + "&&patientcode=" + patientcode + "&&visitcode=" + visitcode;
    
    window.open(url, "Pharmacy", 'width=600,height=400');
}

function disableEnterKey(varPassed) {
    if (event.keyCode == 8) {
        event.keyCode = 0;
        return event.keyCode;
        return false;
    }
    
    var key;
    if (window.event) {
        key = window.event.keyCode;     //IE
    } else {
        key = e.which;     //firefox
    }
    
    if (key == 13) { // if enter key press
        return false;
    } else {
        return true;
    }
}

function ajaxlocationfunction(val) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("ajaxlocation").innerHTML = xmlhttp.responseText;
        }
    }
    
    xmlhttp.open("GET", "ajax/ajaxgetlocationname.php?loccode=" + val, true);
    xmlhttp.send();
}

// Modern utility functions
function showAlert(message, type) {
    var alertClass = 'alert-' + type;
    var iconClass = 'fas fa-info-circle';
    
    switch(type) {
        case 'success':
            iconClass = 'fas fa-check-circle';
            break;
        case 'error':
            iconClass = 'fas fa-exclamation-triangle';
            break;
        case 'warning':
            iconClass = 'fas fa-exclamation-circle';
            break;
    }
    
    var alertHtml = '<div class="alert ' + alertClass + '">' +
        '<i class="' + iconClass + ' alert-icon"></i>' +
        '<span>' + message + '</span>' +
        '</div>';
    
    $('#alertContainer').html(alertHtml);
    
    // Auto-hide after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
}

function validateForm() {
    // Basic form validation
    var isValid = true;
    
    // Check if location is selected
    if ($('#location').val() === '') {
        showAlert('Please select a location', 'error');
        isValid = false;
    }
    
    // Check date range
    var fromDate = $('#ADate1').val();
    var toDate = $('#ADate2').val();
    
    if (fromDate && toDate) {
        var fromDateObj = new Date(fromDate);
        var toDateObj = new Date(toDate);
        
        if (fromDateObj > toDateObj) {
            showAlert('From date cannot be greater than To date', 'error');
            isValid = false;
        }
    }
    
    return isValid;
}

function refreshPage() {
    window.location.reload();
}

function exportToExcel() {
    // Create a simple Excel export
    var table = document.getElementById('dataTable');
    if (table) {
        var wb = XLSX.utils.table_to_book(table);
        XLSX.writeFile(wb, 'wellness_package_list.xlsx');
    } else {
        showAlert('No data to export', 'warning');
    }
}

function printReport() {
    // Print the current page
    window.print();
}

// Enhanced table functionality
function sortTable(columnIndex) {
    var table = document.querySelector('.data-table');
    var tbody = table.querySelector('tbody');
    var rows = Array.from(tbody.querySelectorAll('tr'));
    
    // Toggle sort direction
    var isAscending = table.getAttribute('data-sort-direction') !== 'asc';
    table.setAttribute('data-sort-direction', isAscending ? 'asc' : 'desc');
    
    rows.sort(function(a, b) {
        var aText = a.cells[columnIndex].textContent.trim();
        var bText = b.cells[columnIndex].textContent.trim();
        
        // Try to parse as numbers
        var aNum = parseFloat(aText);
        var bNum = parseFloat(bText);
        
        if (!isNaN(aNum) && !isNaN(bNum)) {
            return isAscending ? aNum - bNum : bNum - aNum;
        } else {
            return isAscending ? aText.localeCompare(bText) : bText.localeCompare(aText);
        }
    });
    
    // Re-append sorted rows
    rows.forEach(function(row) {
        tbody.appendChild(row);
    });
}

// Search functionality
function filterTable() {
    var searchTerm = $('#patient').val().toLowerCase();
    var patientCode = $('#patientcode').val().toLowerCase();
    var visitCode = $('#visitcode').val().toLowerCase();
    
    $('.data-table tbody tr').each(function() {
        var row = $(this);
        var patientName = row.find('td:eq(4)').text().toLowerCase();
        var patCode = row.find('td:eq(2)').text().toLowerCase();
        var visCode = row.find('td:eq(3)').text().toLowerCase();
        
        var showRow = true;
        
        if (searchTerm && !patientName.includes(searchTerm)) {
            showRow = false;
        }
        
        if (patientCode && !patCode.includes(patientCode)) {
            showRow = false;
        }
        
        if (visitCode && !visCode.includes(visitCode)) {
            showRow = false;
        }
        
        if (showRow) {
            row.show();
        } else {
            row.hide();
        }
    });
}

// Real-time search
$(document).ready(function() {
    $('#patient, #patientcode, #visitcode').on('input', function() {
        filterTable();
    });
});

// Enhanced service details toggle
function toggleServiceDetails(sno) {
    var detailsRow = $('#show' + sno);
    var toggleImg = $('#toggleimg');
    
    if (detailsRow.is(':visible')) {
        detailsRow.hide();
        toggleImg.attr('src', 'images/plus1.gif');
    } else {
        detailsRow.show();
        toggleImg.attr('src', 'images/minus1.gif');
    }
}

// Keyboard shortcuts
$(document).keydown(function(e) {
    // Ctrl + F for search focus
    if (e.ctrlKey && e.which === 70) {
        e.preventDefault();
        $('#patient').focus();
    }
    
    // Ctrl + R for refresh
    if (e.ctrlKey && e.which === 82) {
        e.preventDefault();
        refreshPage();
    }
    
    // Escape to clear search
    if (e.which === 27) {
        $('#patient, #patientcode, #visitcode').val('');
        filterTable();
    }
});

// Auto-refresh functionality (optional)
function enableAutoRefresh(intervalMinutes = 5) {
    setInterval(function() {
        if (confirm('Auto-refresh: Update the page with latest data?')) {
            refreshPage();
        }
    }, intervalMinutes * 60 * 1000);
}

// Initialize auto-refresh (uncomment if needed)
// enableAutoRefresh(5);

// Enhanced error handling
window.onerror = function(msg, url, lineNo, columnNo, error) {
    console.error('JavaScript Error:', {
        message: msg,
        source: url,
        line: lineNo,
        column: columnNo,
        error: error
    });
    
    showAlert('An error occurred. Please refresh the page.', 'error');
    return false;
};

// Service worker registration for offline functionality (optional)
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js')
            .then(function(registration) {
                console.log('ServiceWorker registration successful');
            })
            .catch(function(err) {
                console.log('ServiceWorker registration failed');
            });
    });
}


