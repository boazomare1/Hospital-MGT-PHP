/**
 * Modern JavaScript for Debtors Upload
 */

class DebtorsUploadManager {
    constructor() {
        this.form = null;
        this.sidebar = null;
        this.fileInput = null;
        this.init();
    }

    init() {
        this.initializeElements();
        this.setupEventListeners();
        this.initializeSidebar();
    }

    initializeElements() {
        this.form = document.querySelector('form[name="cbform1"]');
        this.fileInput = document.getElementById('upload_file');
        this.sidebar = document.getElementById('leftSidebar');
        this.sidebarToggle = document.getElementById('sidebarToggle');
        this.menuToggle = document.getElementById('menuToggle');
    }

    setupEventListeners() {
        if (this.form) {
            this.form.addEventListener('submit', (e) => this.handleFormSubmit(e));
        }

        if (this.sidebarToggle) {
            this.sidebarToggle.addEventListener('click', () => this.toggleSidebar());
        }

        if (this.menuToggle) {
            this.menuToggle.addEventListener('click', () => this.toggleSidebar());
        }

        if (this.fileInput) {
            this.fileInput.addEventListener('change', (e) => this.handleFileChange(e));
        }
    }

    initializeSidebar() {
        if (window.innerWidth <= 768) {
            this.collapseSidebar();
        }
    }

    handleFormSubmit(e) {
        if (!this.validateForm()) {
            e.preventDefault();
            this.showAlert('Please select a file to upload.', 'error');
            return;
        }
        
        this.showLoadingOverlay();
        this.showAlert('Uploading file... Please wait.', 'info');
    }

    validateForm() {
        if (!this.fileInput || !this.fileInput.files || this.fileInput.files.length === 0) {
            this.showAlert('Please select an Excel file to upload.', 'error');
            return false;
        }

        const file = this.fileInput.files[0];
        const allowedTypes = [
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'text/csv'
        ];

        if (!allowedTypes.includes(file.type)) {
            this.showAlert('Please select a valid Excel file (.xls, .xlsx, .csv).', 'error');
            return false;
        }

        const maxSize = 10 * 1024 * 1024; // 10MB
        if (file.size > maxSize) {
            this.showAlert('File size must be less than 10MB.', 'error');
            return false;
        }

        return true;
    }

    handleFileChange(e) {
        const file = e.target.files[0];
        if (file) {
            this.updateFileDisplay(file);
            this.showAlert(`File selected: ${file.name}`, 'success');
        }
    }

    updateFileDisplay(file) {
        const fileDisplay = document.querySelector('.file-upload-text h4');
        const fileInfo = document.querySelector('.file-upload-text p');
        
        if (fileDisplay && fileInfo) {
            fileDisplay.textContent = file.name;
            fileInfo.textContent = `Size: ${this.formatFileSize(file.size)} | Type: ${file.type}`;
        }
    }

    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    toggleSidebar() {
        if (this.sidebar) {
            this.sidebar.classList.toggle('collapsed');
        }
    }

    collapseSidebar() {
        if (this.sidebar) {
            this.sidebar.classList.add('collapsed');
        }
    }

    showAlert(message, type = 'info') {
        const alertContainer = document.getElementById('alertContainer');
        if (!alertContainer) return;
        
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        
        const iconMap = {
            success: 'fas fa-check-circle',
            error: 'fas fa-exclamation-triangle',
            info: 'fas fa-info-circle',
            warning: 'fas fa-exclamation-circle'
        };
        
        alert.innerHTML = `
            <i class="${iconMap[type] || iconMap.info} alert-icon"></i>
            <span>${message}</span>
        `;
        
        alertContainer.appendChild(alert);
        
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }

    showLoadingOverlay() {
        const overlay = document.createElement('div');
        overlay.className = 'loading-overlay';
        overlay.id = 'loadingOverlay';
        
        overlay.innerHTML = `
            <div class="loading-content">
                <div class="loading-spinner"></div>
                <div class="loading-text">Processing Upload</div>
                <div class="loading-subtext">Please wait while we process your file...</div>
                <div class="progress-bar">
                    <div class="progress-fill" id="progressFill"></div>
                </div>
            </div>
        `;
        
        document.body.appendChild(overlay);
        
        // Simulate progress
        this.simulateProgress();
    }

    hideLoadingOverlay() {
        const overlay = document.getElementById('loadingOverlay');
        if (overlay) {
            overlay.remove();
        }
    }

    simulateProgress() {
        const progressFill = document.getElementById('progressFill');
        if (!progressFill) return;
        
        let progress = 0;
        const interval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress > 90) {
                progress = 90;
            }
            progressFill.style.width = progress + '%';
            
            if (progress >= 90) {
                clearInterval(interval);
            }
        }, 200);
    }

    // Utility functions
    formatCurrency(amount) {
        return new Intl.NumberFormat('en-IN', {
            style: 'currency',
            currency: 'INR',
            minimumFractionDigits: 2
        }).format(amount);
    }

    formatNumber(number) {
        return new Intl.NumberFormat('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(number);
    }

    // Download sample files
    downloadSample(type) {
        const sampleUrl = type === 'debtor' ? 'debtorsupload_sample_xl.php' : 'planupload_sample_xl.php';
        window.open(sampleUrl, '_blank');
    }

    // View uploaded data
    viewUploadedData(type) {
        const viewUrl = type === 'debtor' ? 'debtorsupload_view.php' : 'planupload_view.php';
        window.open(viewUrl, 'mapping', 'location=yes,height=800,width=1400,scrollbars=yes,status=yes');
    }

    // Refresh page
    refreshPage() {
        window.location.reload();
    }

    // Clear form
    clearForm() {
        if (this.form) {
            this.form.reset();
        }
        
        const fileDisplay = document.querySelector('.file-upload-text h4');
        const fileInfo = document.querySelector('.file-upload-text p');
        
        if (fileDisplay && fileInfo) {
            fileDisplay.textContent = 'Choose file or drag and drop';
            fileInfo.textContent = 'Excel files (.xls, .xlsx, .csv) up to 10MB';
        }
        
        this.showAlert('Form cleared', 'info');
    }

    // Initialize data table enhancements
    initializeDataTable() {
        const table = document.querySelector('.data-table');
        if (!table) return;

        // Add hover effects to rows
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.addEventListener('mouseenter', () => {
                row.style.backgroundColor = 'var(--background-accent)';
            });
            
            row.addEventListener('mouseleave', () => {
                row.style.backgroundColor = '';
            });
        });
    }

    // Drag and drop functionality
    initializeDragAndDrop() {
        const fileUpload = document.querySelector('.file-upload');
        if (!fileUpload) return;

        fileUpload.addEventListener('dragover', (e) => {
            e.preventDefault();
            fileUpload.classList.add('drag-over');
        });

        fileUpload.addEventListener('dragleave', (e) => {
            e.preventDefault();
            fileUpload.classList.remove('drag-over');
        });

        fileUpload.addEventListener('drop', (e) => {
            e.preventDefault();
            fileUpload.classList.remove('drag-over');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                this.fileInput.files = files;
                this.handleFileChange({ target: { files: files } });
            }
        });
    }
}

// Global functions
function refreshPage() {
    if (window.debtorsUploadManager) {
        window.debtorsUploadManager.refreshPage();
    }
}

function downloadSample(type) {
    if (window.debtorsUploadManager) {
        window.debtorsUploadManager.downloadSample(type);
    }
}

function viewUploadedData(type) {
    if (window.debtorsUploadManager) {
        window.debtorsUploadManager.viewUploadedData(type);
    }
}

function clearForm() {
    if (window.debtorsUploadManager) {
        window.debtorsUploadManager.clearForm();
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    const debtorsUploadManager = new DebtorsUploadManager();
    window.debtorsUploadManager = debtorsUploadManager;
    
    // Initialize data table enhancements
    debtorsUploadManager.initializeDataTable();
    
    // Initialize drag and drop
    debtorsUploadManager.initializeDragAndDrop();
});