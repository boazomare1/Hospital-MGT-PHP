/**
 * Modern JavaScript for consultationtype_upload.php
 * Enhanced functionality with modern ES6+ features
 */

class ConsultationTypeUploadManager {
    constructor() {
        this.init();
        this.setupEventListeners();
        this.setupFormValidation();
        this.setupFileUpload();
        this.setupDragAndDrop();
    }

    init() {
        // Add modern styling classes
        this.addModernStyling();
        
        // Initialize animations
        this.initializeAnimations();
        
        // Setup form enhancements
        this.enhanceFormElements();
        
        console.log('Consultation Type Upload Manager initialized');
    }

    addModernStyling() {
        // Add modern classes to existing elements
        const containers = document.querySelectorAll('table[width="101%"]');
        containers.forEach(container => {
            container.classList.add('main-container', 'fade-in');
        });

        // Enhance form sections
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.classList.add('form-section');
        });

        // Enhance file input
        const fileInput = document.getElementById('upload_file');
        if (fileInput) {
            this.enhanceFileInput(fileInput);
        }

        // Enhance buttons
        const buttons = document.querySelectorAll('input[type="submit"]');
        buttons.forEach(button => {
            button.classList.add('btn', 'btn-success');
            button.innerHTML = '📤 Upload & Import Data';
        });

        // Add instructions section
        this.addInstructionsSection();
    }

    enhanceFileInput(fileInput) {
        const container = document.createElement('div');
        container.className = 'file-upload-container';
        
        const label = document.createElement('label');
        label.className = 'file-upload-label';
        label.htmlFor = fileInput.id;
        
        label.innerHTML = `
            <div class="file-upload-icon">📁</div>
            <div class="file-upload-text">Click to select file or drag & drop</div>
            <div class="file-upload-hint">Excel files (.xls, .xlsx) are supported</div>
        `;
        
        const fileInfo = document.createElement('div');
        fileInfo.className = 'file-info';
        fileInfo.id = 'fileInfo';
        
        fileInput.parentNode.insertBefore(container, fileInput);
        container.appendChild(label);
        container.appendChild(fileInput);
        container.appendChild(fileInfo);
        
        // Hide original file input
        fileInput.style.display = 'none';
    }

    addInstructionsSection() {
        const formSection = document.querySelector('.form-section');
        if (formSection) {
            const instructions = document.createElement('div');
            instructions.className = 'instructions-section';
            instructions.innerHTML = `
                <h3>Upload Instructions</h3>
                <ul class="instructions-list">
                    <li>Download the sample Excel file to understand the required format</li>
                    <li>Ensure your Excel file has the correct column headers: Name, Dept, Docno, Docname, Amt, Payment Type</li>
                    <li>Payment Type should be one of: CASH, INSURANCE, or CREDIT</li>
                    <li>Make sure all required fields are filled in each row</li>
                    <li>File size should not exceed 10MB</li>
                    <li>Only Excel files (.xls, .xlsx) are supported</li>
                </ul>
            `;
            
            formSection.insertBefore(instructions, formSection.firstChild);
        }
    }

    setupEventListeners() {
        // Form submission enhancement
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                this.handleFormSubmit(e);
            });
        });

        // File input change
        const fileInput = document.getElementById('upload_file');
        if (fileInput) {
            fileInput.addEventListener('change', (e) => {
                this.handleFileSelect(e);
            });
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            this.handleKeyboardShortcuts(e);
        });
    }

    setupFormValidation() {
        // Custom validation rules
        this.validationRules = {
            upload_file: {
                required: true,
                allowedTypes: ['.xls', '.xlsx'],
                maxSize: 10 * 1024 * 1024, // 10MB
                message: 'Please select a valid Excel file (.xls or .xlsx) under 10MB'
            }
        };
    }

    validateFile(file) {
        const rules = this.validationRules.upload_file;
        
        // Check if file is selected
        if (!file) {
            this.showNotification('Please select a file to upload', 'warning');
            return false;
        }
        
        // Check file type
        const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
        if (!rules.allowedTypes.includes(fileExtension)) {
            this.showNotification('Please select a valid Excel file (.xls or .xlsx)', 'error');
            return false;
        }
        
        // Check file size
        if (file.size > rules.maxSize) {
            this.showNotification('File size must be less than 10MB', 'error');
            return false;
        }
        
        return true;
    }

    handleFileSelect(e) {
        const file = e.target.files[0];
        if (file) {
            if (this.validateFile(file)) {
                this.displayFileInfo(file);
                this.showNotification('File selected successfully', 'success');
            } else {
                e.target.value = '';
                this.hideFileInfo();
            }
        }
    }

    displayFileInfo(file) {
        const fileInfo = document.getElementById('fileInfo');
        if (fileInfo) {
            fileInfo.innerHTML = `
                <div class="file-name">📄 ${file.name}</div>
                <div class="file-size">Size: ${this.formatFileSize(file.size)}</div>
                <div class="file-progress">
                    <div class="file-progress-bar" style="width: 0%"></div>
                </div>
            `;
            fileInfo.classList.add('show');
        }
    }

    hideFileInfo() {
        const fileInfo = document.getElementById('fileInfo');
        if (fileInfo) {
            fileInfo.classList.remove('show');
        }
    }

    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    setupFileUpload() {
        // Enhanced file upload with progress tracking
        const form = document.querySelector('form[name="form1"]');
        if (form) {
            form.addEventListener('submit', (e) => {
                this.handleFileUpload(e);
            });
        }
    }

    handleFileUpload(e) {
        const fileInput = document.getElementById('upload_file');
        const file = fileInput.files[0];
        
        if (!this.validateFile(file)) {
            e.preventDefault();
            return false;
        }
        
        // Show upload progress
        this.showUploadProgress();
        
        // Simulate progress (in real implementation, this would track actual upload progress)
        this.simulateUploadProgress();
        
        return true;
    }

    showUploadProgress() {
        const progressSection = document.createElement('div');
        progressSection.className = 'upload-progress';
        progressSection.id = 'uploadProgress';
        progressSection.innerHTML = `
            <h3>Uploading File...</h3>
            <div class="progress-bar">
                <div class="progress-bar-fill" id="progressBarFill"></div>
            </div>
            <div class="progress-text" id="progressText">0%</div>
        `;
        
        const formSection = document.querySelector('.form-section');
        if (formSection) {
            formSection.appendChild(progressSection);
        }
        
        setTimeout(() => {
            progressSection.classList.add('show');
        }, 100);
    }

    simulateUploadProgress() {
        const progressBar = document.getElementById('progressBarFill');
        const progressText = document.getElementById('progressText');
        let progress = 0;
        
        const interval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress > 100) progress = 100;
            
            if (progressBar) progressBar.style.width = progress + '%';
            if (progressText) progressText.textContent = Math.round(progress) + '%';
            
            if (progress >= 100) {
                clearInterval(interval);
                setTimeout(() => {
                    this.showNotification('File uploaded successfully! Processing data...', 'success');
                }, 500);
            }
        }, 200);
    }

    setupDragAndDrop() {
        const fileUploadLabel = document.querySelector('.file-upload-label');
        if (fileUploadLabel) {
            // Prevent default drag behaviors
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                fileUploadLabel.addEventListener(eventName, this.preventDefaults, false);
                document.body.addEventListener(eventName, this.preventDefaults, false);
            });
            
            // Highlight drop area when item is dragged over it
            ['dragenter', 'dragover'].forEach(eventName => {
                fileUploadLabel.addEventListener(eventName, () => {
                    fileUploadLabel.classList.add('dragover');
                }, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                fileUploadLabel.addEventListener(eventName, () => {
                    fileUploadLabel.classList.remove('dragover');
                }, false);
            });
            
            // Handle dropped files
            fileUploadLabel.addEventListener('drop', (e) => {
                this.handleDrop(e);
            }, false);
        }
    }

    preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            const file = files[0];
            const fileInput = document.getElementById('upload_file');
            
            // Create a new FileList with the dropped file
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInput.files = dataTransfer.files;
            
            // Trigger change event
            const event = new Event('change', { bubbles: true });
            fileInput.dispatchEvent(event);
        }
    }

    handleFormSubmit(e) {
        const fileInput = document.getElementById('upload_file');
        const file = fileInput.files[0];
        
        if (!this.validateFile(file)) {
            e.preventDefault();
            return false;
        }
        
        // Show loading state
        const submitBtn = e.target.querySelector('input[type="submit"]');
        if (submitBtn) {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            submitBtn.value = '⏳ Uploading...';
        }
        
        return true;
    }

    handleKeyboardShortcuts(e) {
        // Ctrl/Cmd + U to focus file input
        if ((e.ctrlKey || e.metaKey) && e.key === 'u') {
            e.preventDefault();
            const fileInput = document.getElementById('upload_file');
            if (fileInput) {
                fileInput.click();
            }
        }
        
        // Escape to clear file selection
        if (e.key === 'Escape') {
            const fileInput = document.getElementById('upload_file');
            if (fileInput) {
                fileInput.value = '';
                this.hideFileInfo();
            }
        }
    }

    initializeAnimations() {
        // Add fade-in animation to elements
        const elements = document.querySelectorAll('.form-section, .instructions-section');
        elements.forEach((element, index) => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }, index * 100);
        });
    }

    enhanceFormElements() {
        // Add form tips
        this.addFormTips();
        
        // Enhance sample file link
        this.enhanceSampleFileLink();
    }

    addFormTips() {
        const formSection = document.querySelector('.form-section');
        if (formSection) {
            const tipsDiv = document.createElement('div');
            tipsDiv.className = 'form-tips';
            tipsDiv.style.cssText = `
                margin-top: 20px;
                padding: 15px;
                background: #f8f9fa;
                border-radius: 8px;
                border: 1px solid #e9ecef;
            `;
            
            tipsDiv.innerHTML = `
                <h4 style="margin-bottom: 10px; color: #495057;">💡 Quick Tips:</h4>
                <ul style="margin: 0; padding-left: 20px; color: #6c757d;">
                    <li>Press Ctrl+U to quickly select a file</li>
                    <li>Drag and drop files directly onto the upload area</li>
                    <li>Press Escape to clear the current file selection</li>
                    <li>Make sure your Excel file follows the sample format</li>
                </ul>
            `;
            
            formSection.appendChild(tipsDiv);
        }
    }

    enhanceSampleFileLink() {
        const sampleLink = document.querySelector('a[href*="consultation_type_sub_update.xls"]');
        if (sampleLink) {
            sampleLink.classList.add('sample-file-link');
            sampleLink.innerHTML = '📥 Download Sample Excel File';
        }
    }

    showNotification(message, type = 'info', duration = 5000) {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : type === 'warning' ? '#ffc107' : '#17a2b8'};
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 10000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        `;
        
        const icon = type === 'success' ? '✅' : type === 'error' ? '❌' : type === 'warning' ? '⚠️' : 'ℹ️';
        notification.innerHTML = `${icon} ${message}`;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Auto remove
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, duration);
    }

    // Utility methods
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }
}

// Enhanced legacy functions for backward compatibility
function dataimport1verify() {
    const fileInput = document.getElementById('upload_file');
    if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
        uploadManager.showNotification('Please select a file to proceed', 'warning');
        return false;
    }
    
    const file = fileInput.files[0];
    if (!uploadManager.validateFile(file)) {
        return false;
    }
    
    return true;
}

// Initialize the manager when DOM is ready
let uploadManager;

document.addEventListener('DOMContentLoaded', () => {
    uploadManager = new ConsultationTypeUploadManager();
});

// Export for potential module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ConsultationTypeUploadManager;
}


