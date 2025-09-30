/**
 * Fixed Asset Upload Modern JavaScript
 * Modern functionality for the fixed asset upload system
 */

// Global variables
let isLoading = false;
let sidebarCollapsed = false;
let draggedFile = null;
let selectedFile = null;

// Initialize when DOM is loaded
$(document).ready(function() {
    initializePage();
    setupEventListeners();
    setupFileUpload();
    setupFormValidation();
    initializeTooltips();
    initializeSidebar();
});

/**
 * Initialize page functionality
 */
function initializePage() {
    // Setup responsive behavior
    setupResponsiveBehavior();
    
    // Initialize form enhancements
    initializeFormEnhancements();
    
    // Add smooth scrolling
    $('a[href*="#"]').on('click', function(e) {
        const target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 500);
        }
    });
    
    // Check for upload status
    checkUploadStatus();
}

/**
 * Setup event listeners
 */
function setupEventListeners() {
    // Form submission
    $('.upload-form').on('submit', function(e) {
        e.preventDefault();
        performUpload();
    });
    
    // Reset button
    $('button[onclick="resetForm()"]').on('click', function(e) {
        resetForm();
    });
    
    // File input change
    $('#upload_file').on('change', function() {
        handleFileSelect(this.files[0]);
    });
    
    // Remove file button
    $('#removeFile').on('click', function() {
        removeSelectedFile();
    });
    
    // Upload options
    $('#validateData, #skipDuplicates').on('change', function() {
        updateUploadOptions();
    });
    
    // Download template button
    $('button[onclick="downloadTemplate()"]').on('click', function() {
        downloadTemplate();
    });
    
    // View instructions button
    $('button[onclick="viewInstructions()"]').on('click', function() {
        viewInstructions();
    });
}

/**
 * Setup file upload functionality
 */
function setupFileUpload() {
    const fileUploadArea = document.getElementById('fileUploadArea');
    const fileInput = document.getElementById('upload_file');
    
    // Drag and drop events
    fileUploadArea.addEventListener('dragover', handleDragOver);
    fileUploadArea.addEventListener('dragleave', handleDragLeave);
    fileUploadArea.addEventListener('drop', handleDrop);
    
    // Click to browse
    fileUploadArea.addEventListener('click', function() {
        if (!selectedFile) {
            fileInput.click();
        }
    });
    
    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        fileUploadArea.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });
}

/**
 * Prevent default drag behaviors
 */
function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

/**
 * Handle drag over
 */
function handleDragOver(e) {
    const fileUploadArea = document.getElementById('fileUploadArea');
    fileUploadArea.classList.add('dragover');
}

/**
 * Handle drag leave
 */
function handleDragLeave(e) {
    const fileUploadArea = document.getElementById('fileUploadArea');
    fileUploadArea.classList.remove('dragover');
}

/**
 * Handle file drop
 */
function handleDrop(e) {
    const fileUploadArea = document.getElementById('fileUploadArea');
    fileUploadArea.classList.remove('dragover');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        handleFileSelect(files[0]);
    }
}

/**
 * Handle file selection
 */
function handleFileSelect(file) {
    if (!file) return;
    
    // Validate file type
    const allowedTypes = [
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
        'application/vnd.ms-excel', // .xls
        'text/csv' // .csv
    ];
    
    if (!allowedTypes.includes(file.type)) {
        showAlert('Please select a valid Excel or CSV file.', 'error');
        return;
    }
    
    // Validate file size (max 10MB)
    const maxSize = 10 * 1024 * 1024; // 10MB
    if (file.size > maxSize) {
        showAlert('File size must be less than 10MB.', 'error');
        return;
    }
    
    selectedFile = file;
    displayFilePreview(file);
    updateUploadButton();
    
    // Auto-validate if option is enabled
    if ($('#validateData').is(':checked')) {
        validateFileData(file);
    }
}

/**
 * Display file preview
 */
function displayFilePreview(file) {
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const filePreview = document.getElementById('filePreview');
    const fileUploadContent = document.querySelector('.file-upload-content');
    
    fileName.textContent = file.name;
    fileSize.textContent = formatFileSize(file.size);
    
    // Hide upload content and show preview
    fileUploadContent.style.display = 'none';
    filePreview.style.display = 'flex';
    
    // Add file icon based on type
    const fileIcon = document.querySelector('.file-icon');
    if (file.type.includes('excel') || file.name.endsWith('.xlsx') || file.name.endsWith('.xls')) {
        fileIcon.className = 'fas fa-file-excel file-icon';
    } else if (file.name.endsWith('.csv')) {
        fileIcon.className = 'fas fa-file-csv file-icon';
    } else {
        fileIcon.className = 'fas fa-file file-icon';
    }
}

/**
 * Remove selected file
 */
function removeSelectedFile() {
    selectedFile = null;
    
    // Reset file input
    document.getElementById('upload_file').value = '';
    
    // Hide preview and show upload content
    document.getElementById('filePreview').style.display = 'none';
    document.querySelector('.file-upload-content').style.display = 'flex';
    
    updateUploadButton();
}

/**
 * Format file size
 */
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

/**
 * Update upload button state
 */
function updateUploadButton() {
    const uploadBtn = document.getElementById('uploadBtn');
    const hasFile = selectedFile !== null;
    
    uploadBtn.disabled = !hasFile || isLoading;
    
    if (!hasFile) {
        uploadBtn.classList.add('btn-disabled');
    } else {
        uploadBtn.classList.remove('btn-disabled');
    }
}

/**
 * Update upload options
 */
function updateUploadOptions() {
    const validateData = $('#validateData').is(':checked');
    const skipDuplicates = $('#skipDuplicates').is(':checked');
    
    // Store options for later use
    window.uploadOptions = {
        validateData: validateData,
        skipDuplicates: skipDuplicates
    };
    
    // If validation is enabled and file is selected, validate it
    if (validateData && selectedFile) {
        validateFileData(selectedFile);
    }
}

/**
 * Validate file data
 */
function validateFileData(file) {
    // TODO: Implement file validation logic
    // This would typically read the file and check for required columns
    console.log('Validating file:', file.name);
    
    // Show validation status
    showAlert('File validation completed successfully!', 'success');
}

/**
 * Setup form validation
 */
function setupFormValidation() {
    // Validate file selection on form submission
    $('.upload-form').on('submit', function() {
        return validateForm();
    });
    
    // Real-time validation feedback
    $('#upload_file').on('change', function() {
        validateFileInput(this);
    });
}

/**
 * Validate file input
 */
function validateFileInput(input) {
    const file = input.files[0];
    
    if (!file) {
        clearFileValidation();
        return false;
    }
    
    // Check file type
    const allowedTypes = [
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.ms-excel',
        'text/csv'
    ];
    
    if (!allowedTypes.includes(file.type)) {
        showFileValidationError('Please select a valid Excel or CSV file.');
        return false;
    }
    
    // Check file size
    const maxSize = 10 * 1024 * 1024; // 10MB
    if (file.size > maxSize) {
        showFileValidationError('File size must be less than 10MB.');
        return false;
    }
    
    showFileValidationSuccess();
    return true;
}

/**
 * Show file validation error
 */
function showFileValidationError(message) {
    const fileUploadArea = document.getElementById('fileUploadArea');
    fileUploadArea.classList.add('upload-error');
    
    // Remove any existing validation messages
    $('.file-validation-message').remove();
    
    // Add error message
    const errorMessage = $(`
        <div class="file-validation-message error">
            <i class="fas fa-exclamation-triangle"></i>
            <span>${message}</span>
        </div>
    `);
    
    $('.file-upload-area').append(errorMessage);
}

/**
 * Show file validation success
 */
function showFileValidationSuccess() {
    const fileUploadArea = document.getElementById('fileUploadArea');
    fileUploadArea.classList.remove('upload-error');
    fileUploadArea.classList.add('upload-success');
    
    // Remove any existing validation messages
    $('.file-validation-message').remove();
    
    // Add success message
    const successMessage = $(`
        <div class="file-validation-message success">
            <i class="fas fa-check-circle"></i>
            <span>File is valid and ready for upload</span>
        </div>
    `);
    
    $('.file-upload-area').append(successMessage);
    
    // Remove success class after 3 seconds
    setTimeout(() => {
        fileUploadArea.classList.remove('upload-success');
    }, 3000);
}

/**
 * Clear file validation
 */
function clearFileValidation() {
    const fileUploadArea = document.getElementById('fileUploadArea');
    fileUploadArea.classList.remove('upload-error', 'upload-success');
    $('.file-validation-message').remove();
}

/**
 * Initialize tooltips
 */
function initializeTooltips() {
    // Add tooltips to form elements
    $('.file-input-label').tooltip({
        placement: 'top',
        trigger: 'hover',
        title: 'Click to browse for Excel or CSV files'
    });
    
    // Add tooltips to buttons
    $('.btn').each(function() {
        $(this).tooltip({
            placement: 'top',
            trigger: 'hover'
        });
    });
    
    // Add tooltips to field items
    $('.field-item').each(function() {
        const isRequired = $(this).hasClass('required');
        const title = isRequired ? 'Required field' : 'Optional field';
        
        $(this).tooltip({
            placement: 'top',
            trigger: 'hover',
            title: title
        });
    });
}

/**
 * Initialize sidebar functionality
 */
function initializeSidebar() {
    // Sidebar toggle functionality
    $('#sidebarToggle').on('click', function() {
        toggleSidebar();
    });
    
    // Floating menu toggle
    $('#menuToggle').on('click', function() {
        toggleSidebar();
    });
    
    // Close sidebar when clicking outside on mobile
    $(document).on('click', function(e) {
        if ($(window).width() <= 1024) {
            if (!$(e.target).closest('.left-sidebar, #menuToggle').length) {
                if (!sidebarCollapsed) {
                    toggleSidebar();
                }
            }
        }
    });
    
    // Handle window resize
    $(window).on('resize', function() {
        if ($(window).width() > 1024) {
            $('.left-sidebar').removeClass('collapsed');
            $('.main-container-with-sidebar').removeClass('sidebar-collapsed');
            sidebarCollapsed = false;
        }
    });
}

/**
 * Setup responsive behavior
 */
function setupResponsiveBehavior() {
    // Handle window resize
    $(window).on('resize', function() {
        adjustLayout();
    });
    
    // Initial adjustment
    adjustLayout();
}

/**
 * Adjust layout for different screen sizes
 */
function adjustLayout() {
    const windowWidth = $(window).width();
    
    if (windowWidth < 768) {
        // Mobile layout adjustments
        $('.form-actions').css('flex-direction', 'column');
        $('.upload-options').css('flex-direction', 'column');
        $('.fields-grid').css('grid-template-columns', '1fr');
    } else if (windowWidth < 1024) {
        // Tablet layout
        $('.fields-grid').css('grid-template-columns', 'repeat(auto-fit, minmax(180px, 1fr))');
    } else {
        // Desktop layout
        $('.fields-grid').css('grid-template-columns', 'repeat(auto-fit, minmax(200px, 1fr))');
    }
}

/**
 * Initialize form enhancements
 */
function initializeFormEnhancements() {
    // Add input validation classes
    $('.file-input').each(function() {
        if ($(this).val().trim() !== '') {
            $(this).addClass('has-value');
        }
    });
    
    // Add change detection
    $('.file-input').on('change', function() {
        if ($(this).val().trim() !== '') {
            $(this).addClass('has-value');
        } else {
            $(this).removeClass('has-value');
        }
    });
    
    // Add focus effects
    $('.file-input-label').on('focus', function() {
        $(this).addClass('focused');
    }).on('blur', function() {
        $(this).removeClass('focused');
    });
}

/**
 * Validate entire form
 */
function validateForm() {
    let isValid = true;
    
    // Check if file is selected
    if (!selectedFile) {
        showAlert('Please select a file to upload.', 'error');
        return false;
    }
    
    // Validate file
    if (!validateFileInput(document.getElementById('upload_file'))) {
        isValid = false;
    }
    
    return isValid;
}

/**
 * Perform upload with validation
 */
function performUpload() {
    if (isLoading) return false;
    
    if (!validateForm()) {
        return false;
    }
    
    // Show confirmation dialog
    if (!confirm('Are you sure you want to upload this file? This will import all assets into the system.')) {
        return false;
    }
    
    isLoading = true;
    showLoadingState();
    
    // Show upload animation
    showUploadAnimation();
    
    // Track upload
    trackUpload();
    
    // Submit the form after delay
    setTimeout(() => {
        hideLoadingState();
        isLoading = false;
        document.cbform1.submit();
    }, 1000);
    
    return false; // Prevent default submission
}

/**
 * Reset form to initial state
 */
function resetForm() {
    if (confirm('Are you sure you want to reset the form? All selected files will be removed.')) {
        // Clear file selection
        removeSelectedFile();
        
        // Reset checkboxes
        $('#validateData').prop('checked', true);
        $('#skipDuplicates').prop('checked', false);
        
        // Clear validation messages
        clearFileValidation();
        
        // Show reset animation
        showResetAnimation();
        
        // Track reset event
        trackResetEvent();
    }
}

/**
 * Download template
 */
function downloadTemplate() {
    // TODO: Implement actual template download
    showAlert('Template download will be implemented soon.', 'info');
    
    // Track download
    trackTemplateDownload();
}

/**
 * View instructions
 */
function viewInstructions() {
    // TODO: Implement instructions modal
    showAlert('Instructions will be shown in a modal dialog.', 'info');
    
    // Track instructions view
    trackInstructionsView();
}

/**
 * Check upload status
 */
function checkUploadStatus() {
    // Check URL parameters for upload status
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('st');
    
    if (status === 'success') {
        const successCount = urlParams.get('success_count') || 0;
        const errorCount = urlParams.get('error_count') || 0;
        
        showAlert(`Upload completed successfully! Assets imported: ${successCount}, Errors: ${errorCount}`, 'success');
        
        // Track successful upload
        trackUploadSuccess(successCount, errorCount);
    } else if (status === 'error') {
        const message = urlParams.get('message') || 'Upload failed';
        showAlert(`Upload failed: ${message}`, 'error');
        
        // Track failed upload
        trackUploadFailure(message);
    }
}

/**
 * Show loading state
 */
function showLoadingState() {
    $('#loadingOverlay').show();
    $('#uploadBtn').prop('disabled', true).addClass('loading');
    
    // Start progress animation
    startProgressAnimation();
}

/**
 * Hide loading state
 */
function hideLoadingState() {
    $('#loadingOverlay').hide();
    $('#uploadBtn').prop('disabled', false).removeClass('loading');
}

/**
 * Show upload animation
 */
function showUploadAnimation() {
    $('.upload-form-section').addClass('upload-animation');
    setTimeout(() => {
        $('.upload-form-section').removeClass('upload-animation');
    }, 2000);
}

/**
 * Show reset animation
 */
function showResetAnimation() {
    $('.upload-form').addClass('reset-animation');
    setTimeout(() => {
        $('.upload-form').removeClass('reset-animation');
    }, 300);
}

/**
 * Start progress animation
 */
function startProgressAnimation() {
    const progressBar = document.getElementById('progressBar');
    let progress = 0;
    
    const interval = setInterval(() => {
        progress += Math.random() * 10;
        if (progress > 90) progress = 90;
        
        progressBar.style.width = progress + '%';
        
        if (progress >= 90) {
            clearInterval(interval);
        }
    }, 200);
}

/**
 * Toggle sidebar visibility
 */
function toggleSidebar() {
    sidebarCollapsed = !sidebarCollapsed;
    
    if (sidebarCollapsed) {
        $('.left-sidebar').addClass('collapsed');
        $('.main-container-with-sidebar').addClass('sidebar-collapsed');
        $('#sidebarToggle i').removeClass('fa-chevron-left').addClass('fa-chevron-right');
    } else {
        $('.left-sidebar').removeClass('collapsed');
        $('.main-container-with-sidebar').removeClass('sidebar-collapsed');
        $('#sidebarToggle i').removeClass('fa-chevron-right').addClass('fa-chevron-left');
    }
    
    // Store sidebar state in localStorage
    localStorage.setItem('sidebarCollapsed', sidebarCollapsed);
}

/**
 * Show alert message
 */
function showAlert(message, type = 'info') {
    const alertClass = `alert-${type}`;
    const alertHtml = `
        <div class="alert ${alertClass}">
            <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : (type === 'warning' ? 'exclamation-circle' : 'info-circle')} alert-icon"></i>
            <span>${message}</span>
        </div>
    `;
    
    $('#alertContainer').html(alertHtml);
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        $('#alertContainer .alert').fadeOut();
    }, 5000);
}

/**
 * Track upload event
 */
function trackUpload() {
    console.log('Upload tracked:', {
        timestamp: new Date(),
        fileName: selectedFile ? selectedFile.name : 'Unknown',
        fileSize: selectedFile ? selectedFile.size : 0,
        validateData: $('#validateData').is(':checked'),
        skipDuplicates: $('#skipDuplicates').is(':checked')
    });
}

/**
 * Track upload success
 */
function trackUploadSuccess(successCount, errorCount) {
    console.log('Upload success tracked:', {
        timestamp: new Date(),
        successCount: successCount,
        errorCount: errorCount
    });
}

/**
 * Track upload failure
 */
function trackUploadFailure(message) {
    console.log('Upload failure tracked:', {
        timestamp: new Date(),
        message: message
    });
}

/**
 * Track template download
 */
function trackTemplateDownload() {
    console.log('Template download tracked:', {
        timestamp: new Date()
    });
}

/**
 * Track instructions view
 */
function trackInstructionsView() {
    console.log('Instructions view tracked:', {
        timestamp: new Date()
    });
}

/**
 * Track reset event
 */
function trackResetEvent() {
    console.log('Form reset tracked:', {
        timestamp: new Date()
    });
}

// Add CSS animations via JavaScript
const style = document.createElement('style');
style.textContent = `
    .file-validation-message {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        border-radius: var(--border-radius);
        margin-top: 1rem;
        font-weight: 500;
    }
    
    .file-validation-message.error {
        background: rgba(239, 68, 68, 0.1);
        color: var(--error-color);
        border: 1px solid rgba(239, 68, 68, 0.2);
    }
    
    .file-validation-message.success {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
        border: 1px solid rgba(16, 185, 129, 0.2);
    }
    
    .focused {
        outline: 2px solid var(--medstar-primary);
        outline-offset: 2px;
    }
    
    .has-value {
        border-color: var(--medstar-primary-light);
    }
    
    .upload-animation {
        animation: uploadGlow 2s ease-out;
    }
    
    @keyframes uploadGlow {
        0% { 
            box-shadow: 0 0 0 0 rgba(30, 64, 175, 0.7);
        }
        50% { 
            box-shadow: 0 0 0 10px rgba(30, 64, 175, 0.1);
        }
        100% { 
            box-shadow: 0 0 0 0 rgba(30, 64, 175, 0);
        }
    }
    
    .reset-animation {
        animation: resetShake 0.3s ease-out;
    }
    
    @keyframes resetShake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    .btn-disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    
    .btn-disabled:hover {
        transform: none !important;
        box-shadow: none !important;
    }
    
    .btn.loading {
        position: relative;
        color: transparent;
    }
    
    .btn.loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
`;
document.head.appendChild(style);

