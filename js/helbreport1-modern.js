// HELB Report Modern JavaScript - MedStar Hospital Management

$(document).ready(function() {
    // Initialize page
    initializePage();
    
    // Setup event listeners
    setupEventListeners();
    
    // Initialize autocomplete
    initializeAutocomplete();
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
    $('#searchemployee, #searchmonth, #searchyear').on('change', function() {
        validateForm();
    });
}

function initializeAutocomplete() {
    // Initialize employee autocomplete if available
    if (typeof AutoSuggestControl !== 'undefined' && typeof StateSuggestions !== 'undefined') {
        var oTextbox = new AutoSuggestControl(document.getElementById("searchemployee"), new StateSuggestions());
    }
}

// Original functions from the legacy code
function process1backkeypress1() {
    if (event.keyCode == 8) {
        event.keyCode = 0;
        return event.keyCode;
        return false;
    }
}

function captureEscapeKey1() {
    if (event.keyCode == 8) {
        // Handle escape key if needed
    }
}

function from1submit1() {
    // Form submission validation
    return validateForm();
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
    
    // Check if month is selected
    if ($('#searchmonth').val() === '') {
        errors.push('Please select a month');
        isValid = false;
    }
    
    // Check if year is selected
    if ($('#searchyear').val() === '') {
        errors.push('Please select a year');
        isValid = false;
    }
    
    // Check if year is not in the future
    var selectedYear = parseInt($('#searchyear').val());
    var currentYear = new Date().getFullYear();
    if (selectedYear > currentYear) {
        errors.push('Year cannot be in the future');
        isValid = false;
    }
    
    // Display errors if any
    if (!isValid) {
        showAlert(errors.join('<br>'), 'error');
    }
    
    return isValid;
}

function refreshPage() {
    window.location.reload();
}

function exportToPDF() {
    var form = document.getElementById('form1');
    if (validateForm()) {
        // Create a hidden form for PDF export
        var hiddenForm = document.createElement('form');
        hiddenForm.method = 'POST';
        hiddenForm.action = 'print_helbreport1.php';
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
    var form = document.getElementById('form1');
    if (validateForm()) {
        // Create a hidden form for Excel export
        var hiddenForm = document.createElement('form');
        hiddenForm.method = 'POST';
        hiddenForm.action = 'print_helbreportxl.php';
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
    var form = document.getElementById('form1');
    if (validateForm()) {
        // Create a hidden form for CSV export
        var hiddenForm = document.createElement('form');
        hiddenForm.method = 'POST';
        hiddenForm.action = 'print_helbreportcsv1.php';
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
    $('#searchemployee').val('');
    $('#searchmonth').val('');
    $('#searchyear').val('');
    $('#searchemployeecode').val('');
    $('#autobuildemployee').val('');
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
        if (columnIndex === 3) { // Amount column
            var aNum = parseFloat(aText.replace(/,/g, ''));
            var bNum = parseFloat(bText.replace(/,/g, ''));
            
            if (!isNaN(aNum) && !isNaN(bNum)) {
                return isAscending ? aNum - bNum : bNum - aNum;
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
    var searchTerm = $('#searchemployee').val().toLowerCase();
    
    $('.data-table tbody tr').each(function() {
        var row = $(this);
        var employeeName = row.find('td:eq(1)').text().toLowerCase();
        var idNumber = row.find('td:eq(0)').text().toLowerCase();
        var payrollNo = row.find('td:eq(2)').text().toLowerCase();
        
        var showRow = true;
        
        if (searchTerm && !employeeName.includes(searchTerm) && !idNumber.includes(searchTerm) && !payrollNo.includes(searchTerm)) {
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
    $('#searchemployee').on('input', function() {
        filterTable();
    });
});

// Keyboard shortcuts
$(document).keydown(function(e) {
    // Ctrl + F for search focus
    if (e.ctrlKey && e.which === 70) {
        e.preventDefault();
        $('#searchemployee').focus();
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
        $('#searchemployee').val('');
        filterTable();
    }
});

// Form auto-save functionality
function saveFormData() {
    var formData = {
        searchemployee: $('#searchemployee').val(),
        searchmonth: $('#searchmonth').val(),
        searchyear: $('#searchyear').val()
    };
    
    localStorage.setItem('helbreport_form_data', JSON.stringify(formData));
}

function loadFormData() {
    var savedData = localStorage.getItem('helbreport_form_data');
    if (savedData) {
        var formData = JSON.parse(savedData);
        $('#searchemployee').val(formData.searchemployee || '');
        $('#searchmonth').val(formData.searchmonth || '');
        $('#searchyear').val(formData.searchyear || '');
    }
}

// Auto-save form data
$(document).ready(function() {
    loadFormData();
    
    $('#searchemployee, #searchmonth, #searchyear').on('change', function() {
        saveFormData();
    });
});

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

// Initialize on page load
window.onload = function() {
    if (typeof AutoSuggestControl !== 'undefined' && typeof StateSuggestions !== 'undefined') {
        var oTextbox = new AutoSuggestControl(document.getElementById("searchemployee"), new StateSuggestions());
    }
};


