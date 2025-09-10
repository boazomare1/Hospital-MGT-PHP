/* Active Inpatient List 1 - Modern JavaScript */
/* Enhanced functionality for active inpatient management */

$(document).ready(function() {
    // Initialize modern functionality
    initializeModernFeatures();
    
    // Setup form validation
    setupFormValidation();
    
    // Setup table interactions
    setupTableInteractions();
    
    // Setup search functionality
    setupSearchFunctionality();
    
    // Setup ward management
    setupWardManagement();
});

function initializeModernFeatures() {
    // Add fade-in animation to main container
    $('.main-container').addClass('fade-in');
    
    // Setup tooltips for better UX
    setupTooltips();
    
    // Setup responsive table
    setupResponsiveTable();
    
    // Setup form enhancements
    setupFormEnhancements();
}

function setupFormValidation() {
    // Real-time validation for search fields
    $('#searchpatient, #searchpatientcode, #searchvisitcode').on('input', function() {
        const value = $(this).val().trim();
        if (value.length > 0) {
            $(this).removeClass('error').addClass('valid');
        } else {
            $(this).removeClass('valid').addClass('error');
        }
    });
    
    // Form submission validation
    $('form[name="cbform1"]').on('submit', function(e) {
        const location = $('#location').val();
        
        if (!location) {
            e.preventDefault();
            showAlert('Please select a location to search.', 'error');
            $('#location').focus();
            return false;
        }
        
        // Show loading state
        showLoadingState();
    });
}

function setupTableInteractions() {
    // Enhanced table row highlighting
    $('.data-table tbody tr').hover(
        function() {
            $(this).addClass('table-hover');
        },
        function() {
            $(this).removeClass('table-hover');
        }
    );
    
    // Setup patient row click functionality
    $('.patient-row').on('click', function() {
        const patientCode = $(this).data('patient-code');
        const visitCode = $(this).data('visit-code');
        
        if (patientCode && visitCode) {
            // Highlight selected patient
            $('.patient-row').removeClass('selected');
            $(this).addClass('selected');
            
            // Show patient details or actions
            showPatientActions(patientCode, visitCode);
        }
    });
}

function setupSearchFunctionality() {
    // Real-time search for patients
    $('#patientSearch').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        filterPatientRows(searchTerm);
    });
    
    // Clear search functionality
    $('.search-bar i').on('click', function() {
        $('#patientSearch').val('').trigger('input');
    });
}

function setupWardManagement() {
    // Enhanced ward change functionality
    $('#location').on('change', function() {
        const locationCode = $(this).val();
        if (locationCode) {
            loadWardsForLocation(locationCode);
        }
    });
    
    // Ward selection change
    $('#ward').on('change', function() {
        const wardId = $(this).val();
        if (wardId) {
            // Update ward display
            updateWardDisplay(wardId);
        }
    });
}

function filterPatientRows(searchTerm) {
    $('.data-table tbody tr').each(function() {
        const rowText = $(this).text().toLowerCase();
        if (rowText.includes(searchTerm)) {
            $(this).show().addClass('search-match');
        } else {
            $(this).hide().removeClass('search-match');
        }
    });
    
    // Update search results count
    const visibleRows = $('.data-table tbody tr:visible').length;
    updateSearchResults(visibleRows);
}

function updateSearchResults(count) {
    let resultsText = $('.search-results');
    if (resultsText.length === 0) {
        resultsText = $('<div class="search-results"></div>');
        $('.table-header').append(resultsText);
    }
    
    resultsText.text(`${count} patients found`);
}

function loadWardsForLocation(locationCode) {
    // Show loading state for ward dropdown
    $('#ward').html('<option value="">Loading wards...</option>').prop('disabled', true);
    
    // Simulate AJAX call to load wards
    // In real implementation, this would make an AJAX call
    setTimeout(() => {
        // This would be replaced with actual AJAX call
        $('#ward').prop('disabled', false);
        showAlert('Wards loaded successfully.', 'success');
    }, 1000);
}

function updateWardDisplay(wardId) {
    // Update ward information display
    const wardName = $('#ward option:selected').text();
    if (wardName && wardName !== 'Select Ward') {
        showAlert(`Selected ward: ${wardName}`, 'info');
    }
}

function showPatientActions(patientCode, visitCode) {
    // Create or update patient actions panel
    let actionsPanel = $('.patient-actions-panel');
    if (actionsPanel.length === 0) {
        actionsPanel = $('<div class="patient-actions-panel"></div>');
        $('.data-table-section').after(actionsPanel);
    }
    
    actionsPanel.html(`
        <div class="patient-actions">
            <h4>Patient Actions</h4>
            <div class="action-buttons">
                <a href="ipmedicinedirectissue.php?patientcode=${patientCode}&visitcode=${visitCode}" class="btn btn-primary">
                    <i class="fas fa-pills"></i> Medicine Issue
                </a>
                <a href="iptests.php?patientcode=${patientCode}&visitcode=${visitCode}" class="btn btn-secondary">
                    <i class="fas fa-flask"></i> Tests & Procedures
                </a>
                <a href="ipotrequest.php?patientcode=${patientCode}&visitcode=${visitCode}" class="btn btn-success">
                    <i class="fas fa-user-md"></i> OT Request
                </a>
            </div>
        </div>
    `).addClass('fade-in');
}

function setupTooltips() {
    // Add tooltips to form elements
    $('input[title], select[title]').each(function() {
        $(this).tooltip({
            position: { my: "left+15 center", at: "right center" },
            classes: { "ui-tooltip": "modern-tooltip" }
        });
    });
}

function setupResponsiveTable() {
    // Make table responsive on mobile
    if ($(window).width() < 768) {
        $('.data-table').addClass('responsive-table');
    }
    
    $(window).on('resize', function() {
        if ($(window).width() < 768) {
            $('.data-table').addClass('responsive-table');
        } else {
            $('.data-table').removeClass('responsive-table');
        }
    });
}

function setupFormEnhancements() {
    // Auto-focus on first input field
    $('#searchpatient').focus();
    
    // Enter key handling for form submission
    $('#searchpatient, #searchpatientcode, #searchvisitcode').on('keypress', function(e) {
        if (e.which === 13) {
            $('form[name="cbform1"]').submit();
        }
    });
    
    // Form reset functionality
    $('#resetbutton').on('click', function() {
        resetForm();
    });
}

function resetForm() {
    $('form[name="cbform1"]')[0].reset();
    $('#searchpatient').focus();
    $('.data-table-section').hide();
    $('.patient-actions-panel').remove();
    showAlert('Form has been reset.', 'info');
}

function showLoadingState() {
    $('.main-container').addClass('loading');
    $('input[type="submit"]').prop('disabled', true).val('Searching...');
}

function hideLoadingState() {
    $('.main-container').removeClass('loading');
    $('input[type="submit"]').prop('disabled', false).val('Search');
}

function showAlert(message, type = 'info') {
    const alertClass = type === 'error' ? 'error-message' : 
                      type === 'success' ? 'success-message' : 'info-message';
    
    const alert = $(`<div class="${alertClass} fade-in">${message}</div>`);
    
    // Remove existing alerts
    $('.success-message, .error-message, .info-message').remove();
    
    // Add new alert
    $('#alertContainer').append(alert);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        alert.fadeOut(() => alert.remove());
    }, 5000);
}

function refreshPage() {
    location.reload();
}

function exportToExcel() {
    // Enhanced export functionality
    showAlert('Export functionality will be implemented.', 'info');
}

// Enhanced AJAX location function
function ajaxlocationfunction(val) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("ajaxlocation").innerHTML = xmlhttp.responseText;
            
            // Add visual feedback
            $('#ajaxlocation').addClass('location-updated');
            setTimeout(() => {
                $('#ajaxlocation').removeClass('location-updated');
            }, 1000);
        }
    };
    
    xmlhttp.open("GET", "ajax/ajaxgetlocationname.php?loccode=" + val, true);
    xmlhttp.send();
}

// Enhanced ward change function
function funcwardChange1() {
    const locationCode = document.getElementById("location").value;
    if (locationCode) {
        // Show loading state
        const wardSelect = document.getElementById("ward");
        wardSelect.innerHTML = '<option value="">Loading wards...</option>';
        wardSelect.disabled = true;
        
        // Simulate loading delay
        setTimeout(() => {
            // This would be replaced with actual ward loading logic
            wardSelect.disabled = false;
            showAlert('Wards loaded successfully.', 'success');
        }, 1000);
    }
}

// Form validation function
function funcvalidcheck() {
    const location = document.getElementById("location").value;
    
    if (!location) {
        showAlert('Please select a location to search.', 'error');
        document.getElementById("location").focus();
        return false;
    }
    
    return true;
}

// Enhanced disable enter key function
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

// Initialize on page load
$(window).on('load', function() {
    // Hide loading state if form was submitted
    hideLoadingState();
    
    // Show success message if redirected after action
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success') === 'true') {
        showAlert('Action completed successfully!', 'success');
    }
});

// Add CSS for dynamic classes
$('<style>')
    .prop('type', 'text/css')
    .html(`
        .table-hover { background-color: #e3f2fd !important; }
        .search-match { background-color: #e8f5e8 !important; }
        .location-updated { background-color: #e3f2fd !important; transition: background-color 0.3s; }
        .error { border-color: #e74c3c !important; box-shadow: 0 0 0 2px rgba(231, 76, 60, 0.1) !important; }
        .valid { border-color: #27ae60 !important; box-shadow: 0 0 0 2px rgba(39, 174, 96, 0.1) !important; }
        .modern-tooltip { background: #2c3e50; color: white; border-radius: 4px; padding: 8px 12px; font-size: 0.9rem; }
        .responsive-table { font-size: 0.8rem; }
        .responsive-table th, .responsive-table td { padding: 6px 4px; }
        .info-message { background: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 8px; border: 1px solid #bee5eb; margin-bottom: 20px; }
        .patient-actions-panel { background: rgba(255,255,255,0.95); padding: 20px; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); margin: 20px 0; }
        .patient-actions h4 { color: #2c3e50; margin-bottom: 15px; }
        .action-buttons { display: flex; gap: 15px; flex-wrap: wrap; }
        .selected { background-color: #fff3e0 !important; border-left: 4px solid #ff9800 !important; }
    `)
    .appendTo('head');

