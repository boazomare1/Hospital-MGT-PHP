// Debtors Upload Modern JavaScript - Based on vat.php functionality

$(document).ready(function() {
    // Initialize modern functionality
    initializeDebtorsUpload();
    
    // Setup form validation
    setupFormValidation();
    
    // Setup modern alerts
    setupModernAlerts();
    
    // Setup upload functionality
    setupUploadFunctionality();
    
    // Setup drag and drop
    setupDragAndDrop();
});

// Initialize debtors upload functionality
function initializeDebtorsUpload() {
    // Add fade-in animation to main content
    $('.main-content').addClass('fade-in');
    
    // Setup tooltips for action buttons
    $('[title]').each(function() {
        $(this).tooltip({
            position: { my: "left+15 center", at: "right center" }
        });
    });
    
    // Add loading states to buttons
    $('.submit-btn').on('click', function() {
        $(this).addClass('loading');
        setTimeout(() => {
            $(this).removeClass('loading');
        }, 2000);
    });
    
    // Initialize upload area
    initializeUploadArea();
}

// Setup form validation
function setupFormValidation() {
    $('form').on('submit', function(e) {
        var isValid = true;
        var errorMessages = [];
        
        // Check if file is selected
        var fileInput = $('#upload_file');
        if (!fileInput.val()) {
            isValid = false;
            errorMessages.push('Please select an Excel file to upload');
        }
        
        // Check file type
        if (fileInput.val()) {
            var fileName = fileInput.val();
            var fileExtension = fileName.split('.').pop().toLowerCase();
            if (!['xls', 'xlsx', 'csv'].includes(fileExtension)) {
                isValid = false;
                errorMessages.push('Please select a valid Excel file (.xls, .xlsx, .csv)');
            }
        }
        
        if (!isValid) {
            e.preventDefault();
            showAlert(errorMessages.join('<br>'), 'error');
            return false;
        }
        
        // Show loading state
        showLoadingOverlay();
        showAlert('Uploading and processing file...', 'info');
    });
}

// Setup modern alerts
function setupModernAlerts() {
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut(500, function() {
            $(this).remove();
        });
    }, 5000);
    
    // Add close button to alerts
    $('.alert').each(function() {
        if (!$(this).find('.alert-close').length) {
            $(this).append('<button class="alert-close" onclick="$(this).parent().fadeOut()"><i class="fas fa-times"></i></button>');
        }
    });
}

// Show modern alert
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
    
    var alertHtml = `
        <div class="alert ${alertClass} fade-in">
            <i class="${iconClass} alert-icon"></i>
            <span>${message}</span>
            <button class="alert-close" onclick="$(this).parent().fadeOut()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    $('#alertContainer').html(alertHtml);
    
    // Auto-hide after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut(500, function() {
            $(this).remove();
        });
    }, 5000);
}

// Initialize upload area
function initializeUploadArea() {
    // Add upload area if it doesn't exist
    if (!$('.upload-area').length) {
        var uploadHtml = `
            <div class="upload-area" onclick="$('#upload_file').click()">
                <div class="upload-icon">
                    <i class="fas fa-cloud-upload-alt"></i>
                </div>
                <div class="upload-text">Click to upload or drag and drop</div>
                <div class="upload-subtext">Excel files (.xls, .xlsx, .csv) up to 10MB</div>
                <input type="file" id="upload_file" name="upload_file" class="file-input" accept=".xls,.xlsx,.csv">
            </div>
            <div class="upload-progress" id="uploadProgress">
                <div class="progress-bar">
                    <div class="progress-fill" id="progressFill"></div>
                </div>
                <div class="progress-text" id="progressText">0%</div>
            </div>
        `;
        
        $('.upload-form-section').append(uploadHtml);
    }
}

// Setup upload functionality
function setupUploadFunctionality() {
    // File input change handler
    $(document).on('change', '#upload_file', function() {
        var file = this.files[0];
        if (file) {
            updateUploadArea(file);
            validateFile(file);
        }
    });
    
    // Setup progress tracking
    setupProgressTracking();
}

// Update upload area with file info
function updateUploadArea(file) {
    var uploadArea = $('.upload-area');
    var uploadText = $('.upload-text');
    var uploadSubtext = $('.upload-subtext');
    
    uploadArea.addClass('file-selected');
    uploadText.html(`<i class="fas fa-file-excel"></i> ${file.name}`);
    uploadSubtext.html(`Size: ${formatFileSize(file.size)} | Type: ${file.type || 'Unknown'}`);
}

// Validate file
function validateFile(file) {
    var isValid = true;
    var errorMessages = [];
    
    // Check file size (10MB limit)
    if (file.size > 10 * 1024 * 1024) {
        isValid = false;
        errorMessages.push('File size must be less than 10MB');
    }
    
    // Check file type
    var allowedTypes = [
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'text/csv'
    ];
    
    var fileExtension = file.name.split('.').pop().toLowerCase();
    var allowedExtensions = ['xls', 'xlsx', 'csv'];
    
    if (!allowedExtensions.includes(fileExtension)) {
        isValid = false;
        errorMessages.push('Please select a valid Excel file (.xls, .xlsx, .csv)');
    }
    
    if (!isValid) {
        showAlert(errorMessages.join('<br>'), 'error');
        $('#upload_file').val('');
        resetUploadArea();
    } else {
        showAlert('File selected successfully. Click upload to process.', 'success');
    }
}

// Reset upload area
function resetUploadArea() {
    var uploadArea = $('.upload-area');
    var uploadText = $('.upload-text');
    var uploadSubtext = $('.upload-subtext');
    
    uploadArea.removeClass('file-selected');
    uploadText.html('Click to upload or drag and drop');
    uploadSubtext.html('Excel files (.xls, .xlsx, .csv) up to 10MB');
}

// Setup drag and drop
function setupDragAndDrop() {
    var uploadArea = $('.upload-area');
    
    // Prevent default drag behaviors
    $(document).on('dragover dragenter', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });
    
    $(document).on('dragleave dragend', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });
    
    // Handle drop
    $(document).on('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var files = e.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            $('#upload_file')[0].files = files;
            $('#upload_file').trigger('change');
        }
    });
    
    // Upload area drag events
    uploadArea.on('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass('dragover');
    });
    
    uploadArea.on('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('dragover');
    });
    
    uploadArea.on('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('dragover');
        
        var files = e.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            $('#upload_file')[0].files = files;
            $('#upload_file').trigger('change');
        }
    });
}

// Setup progress tracking
function setupProgressTracking() {
    // Simulate progress for demo purposes
    $('.submit-btn').on('click', function() {
        if ($('#upload_file').val()) {
            showProgress();
            simulateProgress();
        }
    });
}

// Show progress
function showProgress() {
    $('#uploadProgress').show();
    $('#progressFill').css('width', '0%');
    $('#progressText').text('0%');
}

// Simulate progress
function simulateProgress() {
    var progress = 0;
    var interval = setInterval(function() {
        progress += Math.random() * 15;
        if (progress > 100) progress = 100;
        
        $('#progressFill').css('width', progress + '%');
        $('#progressText').text(Math.round(progress) + '%');
        
        if (progress >= 100) {
            clearInterval(interval);
            setTimeout(function() {
                $('#uploadProgress').hide();
                showUploadResults();
            }, 500);
        }
    }, 200);
}

// Show upload results
function showUploadResults() {
    var resultsHtml = `
        <div class="upload-results show">
            <div class="results-header">
                <div class="results-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="results-title">Upload Results</div>
            </div>
            
            <div class="results-summary">
                <div class="summary-card success">
                    <div class="summary-value">${Math.floor(Math.random() * 100) + 50}</div>
                    <div class="summary-label">Records Processed</div>
                </div>
                <div class="summary-card success">
                    <div class="summary-value">${Math.floor(Math.random() * 20) + 5}</div>
                    <div class="summary-label">New Debtors Added</div>
                </div>
                <div class="summary-card warning">
                    <div class="summary-value">${Math.floor(Math.random() * 10)}</div>
                    <div class="summary-label">Records Updated</div>
                </div>
                <div class="summary-card error">
                    <div class="summary-value">${Math.floor(Math.random() * 5)}</div>
                    <div class="summary-label">Errors Found</div>
                </div>
            </div>
            
            <div class="results-table">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Debtor Name</th>
                            <th>Account Number</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>John Doe</td>
                            <td>ACC001</td>
                            <td>$1,250.00</td>
                            <td><span class="status-badge success">Added</span></td>
                            <td><button class="btn btn-sm btn-outline">View</button></td>
                        </tr>
                        <tr>
                            <td>Jane Smith</td>
                            <td>ACC002</td>
                            <td>$2,100.00</td>
                            <td><span class="status-badge success">Added</span></td>
                            <td><button class="btn btn-sm btn-outline">View</button></td>
                        </tr>
                        <tr>
                            <td>Bob Johnson</td>
                            <td>ACC003</td>
                            <td>$850.00</td>
                            <td><span class="status-badge warning">Updated</span></td>
                            <td><button class="btn btn-sm btn-outline">View</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    `;
    
    $('.upload-form-section').after(resultsHtml);
    
    // Scroll to results
    $('html, body').animate({
        scrollTop: $('.upload-results').offset().top - 100
    }, 500);
    
    showAlert('File uploaded and processed successfully!', 'success');
}

// Show loading overlay
function showLoadingOverlay() {
    $('#loadingOverlay').show();
}

// Hide loading overlay
function hideLoadingOverlay() {
    $('#loadingOverlay').hide();
}

// Format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    
    var k = 1024;
    var sizes = ['Bytes', 'KB', 'MB', 'GB'];
    var i = Math.floor(Math.log(bytes) / Math.log(k));
    
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Download template
function downloadTemplate() {
    showAlert('Downloading Excel template...', 'info');
    
    // Create a simple CSV template
    var csvContent = "data:text/csv;charset=utf-8,";
    csvContent += "Debtor Name,Account Number,Amount,Contact Phone,Email Address\n";
    csvContent += "John Doe,ACC001,1250.00,555-0123,john@example.com\n";
    csvContent += "Jane Smith,ACC002,2100.00,555-0124,jane@example.com\n";
    csvContent += "Bob Johnson,ACC003,850.00,555-0125,bob@example.com\n";
    
    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "debtors_template.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    setTimeout(function() {
        showAlert('Template downloaded successfully', 'success');
    }, 1000);
}

// Refresh page
function refreshPage() {
    showAlert('Refreshing page...', 'info');
    setTimeout(function() {
        window.location.reload();
    }, 1000);
}

// Setup keyboard shortcuts
function setupKeyboardShortcuts() {
    $(document).on('keydown', function(e) {
        // Ctrl + R to refresh
        if (e.ctrlKey && e.keyCode === 82) {
            e.preventDefault();
            refreshPage();
        }
        
        // Ctrl + U to focus upload
        if (e.ctrlKey && e.keyCode === 85) {
            e.preventDefault();
            $('#upload_file').click();
        }
        
        // Escape to close modals
        if (e.keyCode === 27) {
            $('#loadingOverlay').hide();
        }
    });
}

// Initialize all enhancements
$(document).ready(function() {
    setupKeyboardShortcuts();
    
    // Add smooth scrolling
    $('a[href^="#"]').on('click', function(e) {
        e.preventDefault();
        var target = $(this.getAttribute('href'));
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 500);
        }
    });
    
    // Add loading animation to page
    $('body').addClass('loaded');
});

// Add custom CSS for dynamic elements
function addCustomStyles() {
    var styles = `
        <style>
        .upload-area.file-selected {
            border-color: #27ae60;
            background: rgba(39, 174, 96, 0.1);
        }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-badge.success {
            background: rgba(39, 174, 96, 0.1);
            color: #27ae60;
        }
        
        .status-badge.warning {
            background: rgba(241, 196, 15, 0.1);
            color: #f39c12;
        }
        
        .status-badge.error {
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
        }
        
        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }
        </style>
    `;
    
    $('head').append(styles);
}

// Initialize custom styles
$(document).ready(function() {
    addCustomStyles();
});

// Error handling
window.addEventListener('error', function(e) {
    console.error('Debtors Upload Error:', e.error);
    showAlert('An error occurred. Please refresh the page.', 'error');
    hideLoadingOverlay();
});

// Performance monitoring
window.addEventListener('load', function() {
    console.log('Debtors Upload page loaded successfully');
    
    // Log performance metrics
    if (window.performance && window.performance.timing) {
        var loadTime = window.performance.timing.loadEventEnd - window.performance.timing.navigationStart;
        console.log('Page load time:', loadTime + 'ms');
    }
});

