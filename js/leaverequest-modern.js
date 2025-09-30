// Modern JavaScript for Leave Request Page

$(document).ready(function() {
    // Initialize sidebar toggle
    initializeSidebar();
    
    // Initialize autocomplete
    initializeAutocomplete();
    
    // Initialize form validation
    initializeFormValidation();
    
    // Initialize date calculations
    initializeDateCalculations();
    
    // Auto-hide alerts after 5 seconds
    autoHideAlerts();
});

// Sidebar functionality
function initializeSidebar() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
}

// Autocomplete functionality
function initializeAutocomplete() {
    // Employee autocomplete
    $('#employeename').autocomplete({
        source: 'autoemployeesearch.php?requestfrm=employeename&',
        select: function(event, ui) {
            var accountname = ui.item.value;
            var code = ui.item.code;
            var anum = ui.item.anum;
            var supervisorcode = ui.item.supervisorcode;
            var supervisorname = ui.item.supervisorname;
            
            $('#employeecode').val(code);
            $('#supervisorcode').val(supervisorcode);
            $('#supervisor').val(supervisorname);
        },
        html: true,
        minLength: 1
    });
    
    // Supervisor autocomplete
    $('#supervisor').keyup(function() {
        $('#supervisorcode').val('');
    });
    
    $('#supervisor').autocomplete({
        source: "ajaxsupervisor_search.php",
        matchContains: true,
        minLength: 1,
        html: true,
        select: function(event, ui) {
            var accountname = ui.item.value;
            var s_code = ui.item.s_code;
            var accountanum = ui.item.anum;
            $('#supervisorcode').val(s_code);
        }
    });
}

// Form validation
function initializeFormValidation() {
    // Real-time validation
    $('#fromdate, #todate').on('change', function() {
        validateDateRange();
    });
    
    $('#leavestype').on('change', function() {
        if ($(this).val() === '') {
            showFieldError('leavestype', 'Please select a leave type');
        } else {
            clearFieldError('leavestype');
        }
    });
    
    $('#remarks').on('input', function() {
        if ($(this).val().trim() === '') {
            showFieldError('remarks', 'Please provide leave remarks');
        } else {
            clearFieldError('remarks');
        }
    });
}

// Date range validation
function validateDateRange() {
    const fromDate = $('#fromdate').val();
    const toDate = $('#todate').val();
    
    if (fromDate && toDate) {
        const from = new Date(fromDate);
        const to = new Date(toDate);
        
        if (to < from) {
            showFieldError('todate', 'To date cannot be before from date');
            $('#todate').val('');
            $('#totaldays').val('');
        } else {
            clearFieldError('todate');
        }
    }
}

// Show field error
function showFieldError(fieldId, message) {
    const field = $('#' + fieldId);
    const errorId = fieldId + '_error';
    
    // Remove existing error
    $('#' + errorId).remove();
    
    // Add error message
    field.after(`<div id="${errorId}" class="field-error">${message}</div>`);
    field.addClass('error');
}

// Clear field error
function clearFieldError(fieldId) {
    const field = $('#' + fieldId);
    const errorId = fieldId + '_error';
    
    $('#' + errorId).remove();
    field.removeClass('error');
}

// Date calculations
function initializeDateCalculations() {
    // Add date picker functionality
    if (typeof NewCssCal !== 'undefined') {
        // Date picker is already loaded
    }
}

// Main form validation function
function addward1process1() {
    let isValid = true;
    
    // Clear previous errors
    $('.field-error').remove();
    $('.error').removeClass('error');
    
    // Validate from date
    if (document.form1.fromdate.value === "") {
        showFieldError('fromdate', 'Please enter from date');
        document.form1.fromdate.focus();
        isValid = false;
    }
    
    // Validate to date
    if (document.form1.todate.value === "") {
        showFieldError('todate', 'Please enter to date');
        document.form1.todate.focus();
        isValid = false;
    }
    
    // Validate remarks
    if (document.form1.remarks.value === "") {
        showFieldError('remarks', 'Please enter remarks');
        document.form1.remarks.focus();
        isValid = false;
    }
    
    // Validate supervisor
    if (document.form1.supervisorcode.value === "") {
        showFieldError('supervisor', 'Please enter supervisor');
        document.form1.supervisor.focus();
        isValid = false;
    }
    
    // Validate leave type
    if (document.form1.leavestype.value === "") {
        showFieldError('leavestype', 'Please select leave type');
        document.form1.leavestype.focus();
        isValid = false;
    }
    
    if (!isValid) {
        showAlert('Please correct the errors above', 'error');
        return false;
    }
    
    return true;
}

// Date calculation functions
Date.prototype.addDays = function(days) {
    var date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);
    return date;
}

function DayCalc() {
    if (document.form1.fromdate.value === "") {
        showAlert('Please enter from date', 'error');
        document.form1.fromdate.focus();
        document.form1.todate.value = '';
        return false;
    }
    
    var startDate1 = document.getElementById("fromdate").value;
    var endDate1 = document.getElementById("todate").value;
    
    if (!endDate1) {
        return false;
    }
    
    var startDate = new Date(startDate1);
    var endDate = new Date(endDate1);
    
    var count = 0;
    var curDate = startDate;
    while (curDate <= endDate) {
        var dayOfWeek = curDate.getDay();
        var isWeekend = (dayOfWeek == 0);
        if (!isWeekend) {
            count++;
        }
        curDate = curDate.addDays(1);
    }
    
    document.getElementById("totaldays").value = count;
}

function DateCalc() {
    if (document.form1.leavestype.value === "") {
        showAlert('Please select leave type', 'error');
        document.form1.leavestype.focus();
        document.form1.todate.value = '';
        document.form1.totaldays.value = '';
        return false;
    }
    
    var numberOfDays = document.getElementById("leavestype").value;
    var numberOfDays = numberOfDays.split('|');
    var noOfDays = numberOfDays[0];
    var noOfDaysType = numberOfDays[1];
    
    if (noOfDays != "0") {
        var startDate1 = document.getElementById("fromdate").value;
        
        if (!startDate1) {
            showAlert('Please enter from date first', 'error');
            return false;
        }
        
        var count1 = 0;
        var endDate = "";
        var startDate = new Date(startDate1);
        var noOfDaysToAdd = noOfDays - 1;
        
        while (count1 < noOfDaysToAdd) {
            endDate = new Date(startDate.setDate(startDate.getDate() + 1));
            if (endDate.getDay() != 0) {
                count1++;
            }
        }
        
        var month = '' + (endDate.getMonth() + 1),
            day = '' + endDate.getDate(),
            year = endDate.getFullYear();
            
        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;
            
        var endDate1 = year + "-" + month + "-" + day;
        
        document.getElementById("todate").value = endDate1;
        document.getElementById("totaldays").value = noOfDays;
    } else {
        // Calculate days between dates
        var startDate1 = document.getElementById("fromdate").value;
        var endDate1 = document.getElementById("todate").value;
        
        if (!startDate1 || !endDate1) {
            return false;
        }
        
        var startDate = new Date(startDate1);
        var endDate = new Date(endDate1);
        
        var count = 0;
        var curDate = startDate;
        while (curDate <= endDate) {
            var dayOfWeek = curDate.getDay();
            var isWeekend = (dayOfWeek == 0);
            if (!isWeekend) {
                count++;
            }
            curDate = curDate.addDays(1);
        }
        
        document.getElementById("totaldays").value = count;
    }
}

// Utility functions
function refreshPage() {
    window.location.reload();
}

function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    const alertId = 'alert_' + Date.now();
    
    const alertHTML = `
        <div id="${alertId}" class="alert alert-${type}">
            <i class="fas fa-${type === 'success' ? 'check-circle' : (type === 'error' ? 'exclamation-triangle' : 'info-circle')} alert-icon"></i>
            <span>${message}</span>
        </div>
    `;
    
    alertContainer.insertAdjacentHTML('beforeend', alertHTML);
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        const alert = document.getElementById(alertId);
        if (alert) {
            alert.remove();
        }
    }, 5000);
}

function autoHideAlerts() {
    setTimeout(() => {
        $('.alert').fadeOut(500, function() {
            $(this).remove();
        });
    }, 5000);
}

// Form reset functionality
function resetForm() {
    document.getElementById('form1').reset();
    $('.field-error').remove();
    $('.error').removeClass('error');
    $('#totaldays').val('');
}

// Add CSS for field errors
const errorStyles = `
    <style>
    .field-error {
        color: #dc2626;
        font-size: 0.75rem;
        margin-top: 0.25rem;
        font-weight: 500;
    }
    
    .form-input.error,
    .form-textarea.error {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }
    
    .alert {
        animation: slideIn 0.3s ease-out;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>
`;

// Inject error styles
document.head.insertAdjacentHTML('beforeend', errorStyles);


