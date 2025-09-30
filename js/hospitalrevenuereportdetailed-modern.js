// Hospital Revenue Report Detailed Modern JavaScript - MedStar Hospital Management

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
    
    // Real-time form validation
    $('#ADate1, #ADate2, #location').on('change', function() {
        validateForm();
    });
    
    // Date range validation
    $('#ADate1, #ADate2').on('change', function() {
        validateDateRange();
    });
}

function initializeFunctionality() {
    // Initialize any additional functionality
    console.log('Hospital Revenue Report initialized');
    
    // Load saved form data
    loadFormData();
}

// Original functions from the legacy code
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

function disableEnterKey() {
    if (event.keyCode == 13) {
        return false;
    }
    return true;
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
    var isValid = true;
    var errors = [];
    
    // Check if from date is selected
    if ($('#ADate1').val() === '') {
        errors.push('Please select a start date');
        isValid = false;
    }
    
    // Check if to date is selected
    if ($('#ADate2').val() === '') {
        errors.push('Please select an end date');
        isValid = false;
    }
    
    // Check date range
    if (isValid && !validateDateRange()) {
        isValid = false;
    }
    
    // Display errors if any
    if (!isValid) {
        showAlert(errors.join('<br>'), 'error');
    }
    
    return isValid;
}

function validateDateRange() {
    var fromDate = $('#ADate1').val();
    var toDate = $('#ADate2').val();
    
    if (fromDate && toDate) {
        var fromDateObj = new Date(fromDate);
        var toDateObj = new Date(toDate);
        
        if (fromDateObj > toDateObj) {
            showAlert('Start date cannot be greater than end date', 'error');
            return false;
        }
        
        // Check if date range is not too far in the future
        var today = new Date();
        if (toDateObj > today) {
            showAlert('End date cannot be in the future', 'error');
            return false;
        }
        
        // Check if date range is not too old (more than 2 years)
        var twoYearsAgo = new Date();
        twoYearsAgo.setFullYear(twoYearsAgo.getFullYear() - 2);
        if (fromDateObj < twoYearsAgo) {
            showAlert('Date range cannot be more than 2 years old', 'warning');
        }
    }
    
    return true;
}

function refreshPage() {
    window.location.reload();
}

function exportToPDF() {
    if (validateForm()) {
        var form = document.getElementById('cbform1');
        var hiddenForm = document.createElement('form');
        hiddenForm.method = 'POST';
        hiddenForm.action = 'print_hospitalrevenue_pdf.php';
        hiddenForm.target = '_blank';
        
        // Add form data
        var inputs = form.querySelectorAll('input, select');
        inputs.forEach(function(input) {
            if (input.type !== 'submit' && input.type !== 'reset') {
                var hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = input.name;
                hiddenInput.value = input.value;
                hiddenForm.appendChild(hiddenInput);
            }
        });
        
        document.body.appendChild(hiddenForm);
        hiddenForm.submit();
        document.body.removeChild(hiddenForm);
    }
}

function exportToExcel() {
    if (validateForm()) {
        var form = document.getElementById('cbform1');
        var hiddenForm = document.createElement('form');
        hiddenForm.method = 'POST';
        hiddenForm.action = 'print_hospitalrevenue_excel.php';
        hiddenForm.target = '_blank';
        
        // Add form data
        var inputs = form.querySelectorAll('input, select');
        inputs.forEach(function(input) {
            if (input.type !== 'submit' && input.type !== 'reset') {
                var hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = input.name;
                hiddenInput.value = input.value;
                hiddenForm.appendChild(hiddenInput);
            }
        });
        
        document.body.appendChild(hiddenForm);
        hiddenForm.submit();
        document.body.removeChild(hiddenForm);
    }
}

function exportToCSV() {
    if (validateForm()) {
        var form = document.getElementById('cbform1');
        var hiddenForm = document.createElement('form');
        hiddenForm.method = 'POST';
        hiddenForm.action = 'print_hospitalrevenue_csv.php';
        hiddenForm.target = '_blank';
        
        // Add form data
        var inputs = form.querySelectorAll('input, select');
        inputs.forEach(function(input) {
            if (input.type !== 'submit' && input.type !== 'reset') {
                var hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = input.name;
                hiddenInput.value = input.value;
                hiddenForm.appendChild(hiddenInput);
            }
        });
        
        document.body.appendChild(hiddenForm);
        hiddenForm.submit();
        document.body.removeChild(hiddenForm);
    }
}

function printReport() {
    // Print the current page
    window.print();
}

function clearForm() {
    $('#ADate1').val('');
    $('#ADate2').val('');
    $('#location').val('');
    $('#ajaxlocation').html('<strong>Location: </strong>');
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
        
        // Try to parse as numbers for amount column
        if (columnIndex === 5) { // Amount column
            var aNum = parseFloat(aText.replace(/[$,]/g, ''));
            var bNum = parseFloat(bText.replace(/[$,]/g, ''));
            
            if (!isNaN(aNum) && !isNaN(bNum)) {
                return isAscending ? aNum - bNum : bNum - aNum;
            }
        }
        
        // Try to parse as dates for date column
        if (columnIndex === 0) { // Date column
            var aDate = new Date(aText);
            var bDate = new Date(bText);
            
            if (!isNaN(aDate.getTime()) && !isNaN(bDate.getTime())) {
                return isAscending ? aDate - bDate : bDate - aDate;
            }
        }
        
        return isAscending ? aText.localeCompare(bText) : bText.localeCompare(aText);
    });
    
    // Re-append sorted rows
    rows.forEach(function(row) {
        tbody.appendChild(row);
    });
}

// Search functionality
function filterTable() {
    var searchTerm = $('#searchInput').val().toLowerCase();
    
    $('.data-table tbody tr').each(function() {
        var row = $(this);
        var patientName = row.find('td:eq(2)').text().toLowerCase();
        var patientId = row.find('td:eq(1)').text().toLowerCase();
        var service = row.find('td:eq(3)').text().toLowerCase();
        var department = row.find('td:eq(4)').text().toLowerCase();
        
        var showRow = true;
        
        if (searchTerm && !patientName.includes(searchTerm) && !patientId.includes(searchTerm) && 
            !service.includes(searchTerm) && !department.includes(searchTerm)) {
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
    // Add search input if it doesn't exist
    if ($('#searchInput').length === 0) {
        $('.report-header').append('<div class="search-input-group"><input type="text" id="searchInput" placeholder="Search patients, services..." class="form-input"></div>');
    }
    
    $('#searchInput').on('input', function() {
        filterTable();
    });
});

// Keyboard shortcuts
$(document).keydown(function(e) {
    // Ctrl + F for search focus
    if (e.ctrlKey && e.which === 70) {
        e.preventDefault();
        $('#searchInput').focus();
    }
    
    // Ctrl + R for refresh
    if (e.ctrlKey && e.which === 82) {
        e.preventDefault();
        refreshPage();
    }
    
    // Ctrl + P for print
    if (e.ctrlKey && e.which === 80) {
        e.preventDefault();
        printReport();
    }
    
    // Escape to clear search
    if (e.which === 27) {
        $('#searchInput').val('');
        filterTable();
    }
});

// Form auto-save functionality
function saveFormData() {
    var formData = {
        ADate1: $('#ADate1').val(),
        ADate2: $('#ADate2').val(),
        location: $('#location').val()
    };
    
    localStorage.setItem('hospitalrevenue_form_data', JSON.stringify(formData));
}

function loadFormData() {
    var savedData = localStorage.getItem('hospitalrevenue_form_data');
    if (savedData) {
        var formData = JSON.parse(savedData);
        $('#ADate1').val(formData.ADate1 || '');
        $('#ADate2').val(formData.ADate2 || '');
        $('#location').val(formData.location || '');
        
        // Trigger location change if location is set
        if (formData.location) {
            ajaxlocationfunction(formData.location);
        }
    }
}

// Auto-save form data
$(document).ready(function() {
    $('#ADate1, #ADate2, #location').on('change', function() {
        saveFormData();
    });
});

// Calculate summary statistics
function calculateSummaryStats() {
    var totalRevenue = 0;
    var totalPatients = 0;
    var totalProcedures = 0;
    
    $('.data-table tbody tr').each(function() {
        var amountText = $(this).find('td:eq(5)').text().replace(/[$,]/g, '');
        var amount = parseFloat(amountText) || 0;
        totalRevenue += amount;
        totalPatients++;
        totalProcedures++;
    });
    
    // Update summary cards
    $('.summary-amount').eq(0).text('$' + totalRevenue.toFixed(2));
    $('.summary-amount').eq(1).text(totalPatients);
    $('.summary-amount').eq(2).text(totalProcedures);
    
    // Calculate growth rate (placeholder)
    var growthRate = 0; // This would be calculated based on previous period
    $('.summary-amount').eq(3).text(growthRate + '%');
}

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

// Initialize summary calculation when page loads
$(document).ready(function() {
    setTimeout(function() {
        calculateSummaryStats();
    }, 1000);
});


