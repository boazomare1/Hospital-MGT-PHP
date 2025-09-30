// ICD Data Import Modern JavaScript - MedStar Hospital Management

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
    
    // File input change
    $('#uploadedfile').on('change', function() {
        handleFileSelect(this);
    });
    
    // Drag and drop functionality
    setupDragAndDrop();
    
    // Form reset
    $('button[type="reset"]').on('click', function() {
        resetForm();
    });
}

function initializeFunctionality() {
    // Initialize any additional functionality
    console.log('ICD Data Import page initialized');
    
    // Setup file validation
    setupFileValidation();
}

// Original functions from the legacy code
function dataimport1verify() {
    // Modern form validation
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
    
    // Remove existing alerts
    $('.alert').remove();
    
    // Add new alert
    $('#alertContainer').html(alertHtml);
    
    // Auto-hide after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
}

function validateForm() {
    var isValid = true;
    var errors = [];
    
    // Check if file is selected
    var fileInput = document.getElementById('uploadedfile');
    if (!fileInput.files || fileInput.files.length === 0) {
        errors.push('Please select a TAB delimited file to proceed.');
        $('#uploadedfile').addClass('error');
        isValid = false;
    } else {
        $('#uploadedfile').removeClass('error');
        
        // Validate file type
        var file = fileInput.files[0];
        var fileName = file.name;
        var fileExtension = fileName.split('.').pop().toLowerCase();
        
        if (fileExtension !== 'txt') {
            errors.push('Only .txt files are allowed.');
            isValid = false;
        }
        
        // Validate file size (10MB max)
        var maxSize = 10 * 1024 * 1024; // 10MB in bytes
        if (file.size > maxSize) {
            errors.push('File size too large. Maximum allowed size is 10MB.');
            isValid = false;
        }
    }
    
    // Display errors if any
    if (!isValid) {
        showAlert(errors.join('<br>'), 'error');
    }
    
    return isValid;
}

function handleFileSelect(input) {
    var file = input.files[0];
    if (file) {
        displayFileInfo(file);
        validateFile(file);
    } else {
        hideFileInfo();
    }
}

function displayFileInfo(file) {
    var fileInfo = $('#fileInfo');
    var fileName = file.name;
    var fileSize = formatFileSize(file.size);
    
    fileInfo.find('.file-name').text(fileName);
    fileInfo.find('.file-size').text(fileSize);
    fileInfo.show();
}

function hideFileInfo() {
    $('#fileInfo').hide();
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    
    var k = 1024;
    var sizes = ['Bytes', 'KB', 'MB', 'GB'];
    var i = Math.floor(Math.log(bytes) / Math.log(k));
    
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function validateFile(file) {
    var isValid = true;
    var errors = [];
    
    // Check file extension
    var fileName = file.name;
    var fileExtension = fileName.split('.').pop().toLowerCase();
    
    if (fileExtension !== 'txt') {
        errors.push('Invalid file format. Only .txt files are allowed.');
        isValid = false;
    }
    
    // Check file size
    var maxSize = 10 * 1024 * 1024; // 10MB
    if (file.size > maxSize) {
        errors.push('File size too large. Maximum allowed size is 10MB.');
        isValid = false;
    }
    
    // Update UI based on validation
    var fileUploadDisplay = $('.file-upload-display');
    if (isValid) {
        fileUploadDisplay.removeClass('error').addClass('valid');
        showAlert('File selected successfully. Ready to upload.', 'success');
    } else {
        fileUploadDisplay.removeClass('valid').addClass('error');
        showAlert(errors.join('<br>'), 'error');
    }
    
    return isValid;
}

function setupDragAndDrop() {
    var fileUploadDisplay = $('.file-upload-display');
    var fileInput = $('#uploadedfile');
    
    // Prevent default drag behaviors
    $(document).on('dragover dragenter', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });
    
    $(document).on('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });
    
    // Handle drag over
    fileUploadDisplay.on('dragover dragenter', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass('dragover');
    });
    
    // Handle drag leave
    fileUploadDisplay.on('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('dragover');
    });
    
    // Handle drop
    fileUploadDisplay.on('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('dragover');
        
        var files = e.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            fileInput[0].files = files;
            handleFileSelect(fileInput[0]);
        }
    });
}

function setupFileValidation() {
    // Real-time file validation
    $('#uploadedfile').on('change', function() {
        var file = this.files[0];
        if (file) {
            validateFile(file);
        }
    });
}

function refreshPage() {
    window.location.reload();
}

function resetForm() {
    // Reset form
    document.getElementById('form1').reset();
    
    // Hide file info
    hideFileInfo();
    
    // Remove validation classes
    $('.file-upload-display').removeClass('error valid dragover');
    
    // Hide alerts
    $('.alert').fadeOut();
    
    // Hide upload progress
    $('#uploadProgress').hide();
    
    showAlert('Form has been reset.', 'info');
}

// Enhanced form submission with progress indication
$('#form1').on('submit', function(e) {
    if (!validateForm()) {
        e.preventDefault();
        return false;
    }
    
    // Show loading state
    $(this).addClass('form-loading');
    $('#submitBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Uploading...');
    
    // Show upload progress
    showUploadProgress();
    
    // Simulate progress (in real implementation, this would be handled by server)
    simulateUploadProgress();
});

function showUploadProgress() {
    $('#uploadProgress').show();
    $('.progress-fill').css('width', '0%');
    $('.progress-text').text('Preparing upload...');
}

function simulateUploadProgress() {
    var progress = 0;
    var interval = setInterval(function() {
        progress += Math.random() * 15;
        if (progress > 100) progress = 100;
        
        $('.progress-fill').css('width', progress + '%');
        
        if (progress < 30) {
            $('.progress-text').text('Uploading file...');
        } else if (progress < 70) {
            $('.progress-text').text('Processing data...');
        } else if (progress < 100) {
            $('.progress-text').text('Validating format...');
        } else {
            $('.progress-text').text('Upload complete!');
            clearInterval(interval);
        }
    }, 200);
}

// Keyboard shortcuts
$(document).keydown(function(e) {
    // Ctrl + R for refresh
    if (e.ctrlKey && e.which === 82) {
        e.preventDefault();
        refreshPage();
    }
    
    // Escape to reset form
    if (e.which === 27) {
        if (confirm('Are you sure you want to reset the form?')) {
            resetForm();
        }
    }
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

// Form field focus management
$('input, select, textarea').on('focus', function() {
    $(this).closest('.form-group').addClass('focused');
}).on('blur', function() {
    $(this).closest('.form-group').removeClass('focused');
});

// File input click handler
$('.file-upload-display').on('click', function() {
    $('#uploadedfile').click();
});

// Sample file download tracking
$('a[href*="sample_import_file1.xls"]').on('click', function() {
    showAlert('Sample file download started. Please wait...', 'info');
    
    // Track download
    setTimeout(function() {
        showAlert('Sample file downloaded successfully. Please open it and follow the instructions.', 'success');
    }, 2000);
});

// File type validation helper
function isValidFileType(fileName) {
    var allowedExtensions = ['txt'];
    var fileExtension = fileName.split('.').pop().toLowerCase();
    return allowedExtensions.indexOf(fileExtension) !== -1;
}

// File size validation helper
function isValidFileSize(fileSize) {
    var maxSize = 10 * 1024 * 1024; // 10MB
    return fileSize <= maxSize;
}

// Enhanced file validation with detailed feedback
function validateFileDetailed(file) {
    var validation = {
        isValid: true,
        errors: [],
        warnings: []
    };
    
    // Check file name
    if (!file.name || file.name.trim() === '') {
        validation.isValid = false;
        validation.errors.push('File name is required.');
    }
    
    // Check file extension
    if (!isValidFileType(file.name)) {
        validation.isValid = false;
        validation.errors.push('Invalid file type. Only .txt files are allowed.');
    }
    
    // Check file size
    if (!isValidFileSize(file.size)) {
        validation.isValid = false;
        validation.errors.push('File size too large. Maximum allowed size is 10MB.');
    }
    
    // Check if file is empty
    if (file.size === 0) {
        validation.isValid = false;
        validation.errors.push('File is empty. Please select a valid file.');
    }
    
    // Check file name length
    if (file.name.length > 255) {
        validation.warnings.push('File name is very long. Consider using a shorter name.');
    }
    
    return validation;
}

// Update file validation display
function updateFileValidationDisplay(validation) {
    var fileUploadDisplay = $('.file-upload-display');
    
    if (validation.isValid) {
        fileUploadDisplay.removeClass('error').addClass('valid');
        if (validation.warnings.length > 0) {
            showAlert('File is valid. ' + validation.warnings.join(' '), 'warning');
        } else {
            showAlert('File is valid and ready to upload.', 'success');
        }
    } else {
        fileUploadDisplay.removeClass('valid').addClass('error');
        showAlert(validation.errors.join('<br>'), 'error');
    }
}

// Enhanced file selection handler
$('#uploadedfile').on('change', function() {
    var file = this.files[0];
    if (file) {
        var validation = validateFileDetailed(file);
        updateFileValidationDisplay(validation);
        displayFileInfo(file);
    } else {
        hideFileInfo();
        $('.file-upload-display').removeClass('error valid');
    }
});

// Form submission with enhanced validation
$('#form1').on('submit', function(e) {
    var fileInput = document.getElementById('uploadedfile');
    var file = fileInput.files[0];
    
    if (!file) {
        e.preventDefault();
        showAlert('Please select a file to upload.', 'error');
        return false;
    }
    
    var validation = validateFileDetailed(file);
    if (!validation.isValid) {
        e.preventDefault();
        updateFileValidationDisplay(validation);
        return false;
    }
    
    // Show loading state
    $(this).addClass('form-loading');
    $('#submitBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Uploading...');
    
    // Show upload progress
    showUploadProgress();
});

// Remove loading state when page loads
$(window).on('load', function() {
    $('.form-loading').removeClass('form-loading');
    $('#submitBtn').prop('disabled', false).html('<i class="fas fa-upload"></i> Proceed to Data Import');
    $('#uploadProgress').hide();
});

// Auto-save form state (optional)
function saveFormState() {
    var formData = {
        hasFile: $('#uploadedfile').val() !== ''
    };
    
    localStorage.setItem('icddataimport_form_state', JSON.stringify(formData));
}

function loadFormState() {
    var savedState = localStorage.getItem('icddataimport_form_state');
    if (savedState) {
        var formData = JSON.parse(savedState);
        // Restore form state if needed
    }
}

// Clear form state on successful submission
$('#form1').on('submit', function() {
    setTimeout(function() {
        localStorage.removeItem('icddataimport_form_state');
    }, 1000);
});

// Initialize form state
$(document).ready(function() {
    loadFormState();
});

// Auto-save form state
$('#uploadedfile').on('change', function() {
    saveFormState();
});

// Enhanced drag and drop with visual feedback
$(document).ready(function() {
    var fileUploadDisplay = $('.file-upload-display');
    
    // Add visual feedback for drag and drop
    fileUploadDisplay.on('dragover', function(e) {
        e.preventDefault();
        $(this).addClass('dragover');
    });
    
    fileUploadDisplay.on('dragleave', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
    });
    
    fileUploadDisplay.on('drop', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
    });
});

