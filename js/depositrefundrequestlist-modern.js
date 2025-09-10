/**
 * Deposit Refund Request List Manager
 * Modern JavaScript functionality for deposit refund request management
 */

class DepositRefundRequestListManager {
    constructor() {
        this.sidebarOpen = false;
        this.currentFilters = {};
        this.init();
    }

    init() {
        this.initializeEventListeners();
        this.setupSidebar();
        this.setupFormValidation();
        this.setupTableEnhancements();
        this.setupResponsiveHandling();
        this.setupAutoSuggest();
    }

    initializeEventListeners() {
        // Menu and sidebar toggles
        const menuToggle = document.getElementById('menuToggle');
        const sidebarToggle = document.getElementById('sidebarToggle');

        if (menuToggle) {
            menuToggle.addEventListener('click', () => this.toggleSidebar());
        }

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => this.toggleSidebar());
        }

        // Form submission
        const searchForm = document.getElementById('searchForm');
        if (searchForm) {
            searchForm.addEventListener('submit', (e) => this.handleFormSubmission(e));
        }

        // Form reset
        const resetBtn = document.querySelector('.btn-reset');
        if (resetBtn) {
            resetBtn.addEventListener('click', () => this.resetForm());
        }

        // Action buttons
        document.addEventListener('click', (e) => {
            if (e.target.matches('.approve-btn')) {
                this.handleApproveAction(e.target);
            }
        });

        // Close sidebar when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.left-sidebar') &&
                !e.target.closest('#menuToggle') &&
                !e.target.closest('#sidebarToggle') &&
                this.sidebarOpen) {
                this.toggleSidebar();
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey || e.metaKey) {
                switch (e.key) {
                    case 'k':
                        e.preventDefault();
                        this.focusSearch();
                        break;
                    case 'r':
                        e.preventDefault();
                        this.refreshPage();
                        break;
                    case 'p':
                        e.preventDefault();
                        this.printPage();
                        break;
                }
            }
        });
    }

    setupSidebar() {
        const sidebar = document.getElementById('leftSidebar');
        if (sidebar) {
            sidebar.style.transition = 'transform 0.3s ease-in-out';
        }
    }

    toggleSidebar() {
        const sidebar = document.getElementById('leftSidebar');
        const menuToggle = document.getElementById('menuToggle');

        if (sidebar) {
            this.sidebarOpen = !this.sidebarOpen;

            if (this.sidebarOpen) {
                sidebar.classList.add('open');
                if (menuToggle) {
                    menuToggle.innerHTML = '<i class="fas fa-times"></i>';
                }
                document.body.style.overflow = 'hidden';
            } else {
                sidebar.classList.remove('open');
                if (menuToggle) {
                    menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
                }
                document.body.style.overflow = '';
            }
        }
    }

    setupFormValidation() {
        const requiredFields = document.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            field.addEventListener('blur', () => this.validateField(field));
            field.addEventListener('input', () => this.clearFieldError(field));
        });

        // Date range validation
        const fromDate = document.getElementById('ADate1');
        const toDate = document.getElementById('ADate2');
        
        if (fromDate && toDate) {
            fromDate.addEventListener('change', () => this.validateDateRange());
            toDate.addEventListener('change', () => this.validateDateRange());
        }
    }

    validateField(field) {
        const value = field.value.trim();
        const label = this.getFieldLabel(field);

        if (!value) {
            this.showFieldError(field, `${label} is required`);
            return false;
        }

        // Specific validation rules
        if (field.name === 'ADate1' || field.name === 'ADate2') {
            if (!this.isValidDate(value)) {
                this.showFieldError(field, 'Please enter a valid date');
                return false;
            }
        }

        this.clearFieldError(field);
        return true;
    }

    validateDateRange() {
        const fromDate = document.getElementById('ADate1');
        const toDate = document.getElementById('ADate2');

        if (fromDate && toDate && fromDate.value && toDate.value) {
            const from = new Date(fromDate.value);
            const to = new Date(toDate.value);

            if (to < from) {
                this.showFieldError(toDate, 'End date cannot be before start date');
                return false;
            }

            // Check if date range is not more than 1 year
            const diffTime = Math.abs(to - from);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            if (diffDays > 365) {
                this.showFieldError(toDate, 'Date range cannot exceed 1 year');
                return false;
            }

            this.clearFieldError(toDate);
            return true;
        }

        return true;
    }

    isValidDate(dateString) {
        const date = new Date(dateString);
        return date instanceof Date && !isNaN(date);
    }

    showFieldError(field, message) {
        this.clearFieldError(field);

        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.textContent = message;
        errorDiv.style.cssText = `
            color: var(--error-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        `;

        field.parentNode.appendChild(errorDiv);
        field.style.borderColor = 'var(--error-color)';
    }

    clearFieldError(field) {
        const errorDiv = field.parentNode.querySelector('.field-error');
        if (errorDiv) {
            errorDiv.remove();
        }
        field.style.borderColor = '';
    }

    getFieldLabel(field) {
        const label = field.previousElementSibling?.textContent ||
                     field.placeholder ||
                     field.name ||
                     'This field';
        return label.replace(':', '').trim();
    }

    setupTableEnhancements() {
        const tableRows = document.querySelectorAll('.refund-table tbody tr');
        tableRows.forEach((row, index) => {
            // Add hover effect
            row.addEventListener('mouseenter', () => {
                row.style.backgroundColor = 'var(--hover-bg)';
            });

            row.addEventListener('mouseleave', () => {
                row.style.backgroundColor = index % 2 === 0 ? 'var(--row-bg)' : 'var(--row-alt-bg)';
            });

            // Add click effect for action buttons
            const actionBtns = row.querySelectorAll('.approve-btn');
            actionBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                });
            });

            // Add row selection
            row.addEventListener('click', () => {
                this.selectRow(row);
            });
        });
    }

    selectRow(row) {
        // Remove previous selection
        const selectedRows = document.querySelectorAll('.refund-table tbody tr.selected');
        selectedRows.forEach(r => r.classList.remove('selected'));

        // Add selection to current row
        row.classList.add('selected');
        row.style.backgroundColor = 'var(--primary-color)';
        row.style.color = 'var(--text-inverse)';
    }

    setupResponsiveHandling() {
        const handleResize = () => {
            if (window.innerWidth > 1024 && this.sidebarOpen) {
                this.toggleSidebar();
            }
        };

        window.addEventListener('resize', handleResize);

        // Touch support for mobile
        let touchStartX = 0;
        let touchEndX = 0;

        document.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        });

        document.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            this.handleSwipe();
        });
    }

    handleSwipe() {
        const swipeThreshold = 50;
        const swipeDistance = touchEndX - touchStartX;

        if (Math.abs(swipeDistance) > swipeThreshold) {
            if (swipeDistance > 0 && this.sidebarOpen) {
                // Swipe right - close sidebar
                this.toggleSidebar();
            } else if (swipeDistance < 0 && !this.sidebarOpen) {
                // Swipe left - open sidebar
                this.toggleSidebar();
            }
        }
    }

    setupAutoSuggest() {
        // Patient name auto-suggest
        const patientField = document.getElementById('patient');
        if (patientField) {
            this.setupAutoComplete(patientField, 'patient');
        }

        // Patient code auto-suggest
        const patientCodeField = document.getElementById('patientcode');
        if (patientCodeField) {
            this.setupAutoComplete(patientCodeField, 'patientcode');
        }

        // Visit code auto-suggest
        const visitCodeField = document.getElementById('visitcode');
        if (visitCodeField) {
            this.setupAutoComplete(visitCodeField, 'visitcode');
        }
    }

    setupAutoComplete(field, type) {
        let suggestions = [];
        let currentFocus = -1;

        field.addEventListener('input', (e) => {
            const value = e.target.value;
            if (value.length < 2) {
                this.removeSuggestions();
                return;
            }

            this.getSuggestions(value, type).then(data => {
                suggestions = data;
                this.showSuggestions(field, suggestions);
            });
        });

        field.addEventListener('keydown', (e) => {
            const suggestionBox = field.parentNode.querySelector('.suggestions');
            if (!suggestionBox) return;

            if (e.key === 'ArrowDown') {
                currentFocus++;
                this.addActive(suggestionBox, currentFocus);
            } else if (e.key === 'ArrowUp') {
                currentFocus--;
                this.addActive(suggestionBox, currentFocus);
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (currentFocus > -1) {
                    if (suggestionBox.children[currentFocus]) {
                        suggestionBox.children[currentFocus].click();
                    }
                }
            } else if (e.key === 'Escape') {
                this.removeSuggestions();
            }
        });

        // Close suggestions when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.suggestions') && !e.target.closest('input')) {
                this.removeSuggestions();
            }
        });
    }

    async getSuggestions(query, type) {
        // This would typically make an AJAX call to get suggestions
        // For now, return mock data
        const mockData = {
            patient: [
                'John Doe',
                'Jane Smith',
                'Mike Johnson',
                'Sarah Wilson',
                'David Brown'
            ],
            patientcode: [
                'P001',
                'P002',
                'P003',
                'P004',
                'P005'
            ],
            visitcode: [
                'V001',
                'V002',
                'V003',
                'V004',
                'V005'
            ]
        };

        return mockData[type]?.filter(item => 
            item.toLowerCase().includes(query.toLowerCase())
        ) || [];
    }

    showSuggestions(field, suggestions) {
        this.removeSuggestions();

        if (suggestions.length === 0) return;

        const suggestionBox = document.createElement('div');
        suggestionBox.className = 'suggestions';
        suggestionBox.style.cssText = `
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-top: none;
            border-radius: 0 0 var(--radius-md) var(--radius-md);
            box-shadow: var(--shadow-lg);
            z-index: 1000;
            max-height: 200px;
            overflow-y: auto;
        `;

        suggestions.forEach((suggestion, index) => {
            const item = document.createElement('div');
            item.textContent = suggestion;
            item.style.cssText = `
                padding: var(--spacing-sm) var(--spacing-md);
                cursor: pointer;
                border-bottom: 1px solid var(--border-color);
                transition: background-color var(--transition-fast);
            `;

            item.addEventListener('mouseenter', () => {
                item.style.backgroundColor = 'var(--bg-tertiary)';
            });

            item.addEventListener('mouseleave', () => {
                item.style.backgroundColor = 'var(--bg-primary)';
            });

            item.addEventListener('click', () => {
                field.value = suggestion;
                this.removeSuggestions();
                field.focus();
            });

            suggestionBox.appendChild(item);
        });

        field.parentNode.style.position = 'relative';
        field.parentNode.appendChild(suggestionBox);
    }

    addActive(suggestionBox, index) {
        if (!suggestionBox) return;

        this.removeActive(suggestionBox);
        if (index >= 0 && index < suggestionBox.children.length) {
            suggestionBox.children[index].classList.add('active');
            suggestionBox.children[index].style.backgroundColor = 'var(--primary-color)';
            suggestionBox.children[index].style.color = 'var(--text-inverse)';
        }
    }

    removeActive(suggestionBox) {
        const items = suggestionBox.querySelectorAll('div');
        items.forEach(item => {
            item.classList.remove('active');
            item.style.backgroundColor = 'var(--bg-primary)';
            item.style.color = 'var(--text-primary)';
        });
    }

    removeSuggestions() {
        const suggestions = document.querySelectorAll('.suggestions');
        suggestions.forEach(suggestion => suggestion.remove());
    }

    handleFormSubmission(e) {
        e.preventDefault();

        const form = e.target;
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });

        if (!this.validateDateRange()) {
            isValid = false;
        }

        if (isValid) {
            this.showAlert('Searching for refund requests...', 'info');
            // Form would be submitted here
            setTimeout(() => {
                this.showAlert('Search completed successfully!', 'success');
            }, 1000);
        } else {
            this.showAlert('Please fix the errors above before submitting.', 'error');
        }
    }

    resetForm() {
        const form = document.getElementById('searchForm');
        if (form) {
            form.reset();
            this.clearAllFieldErrors();
            this.removeSuggestions();
            this.showAlert('Form has been reset.', 'info');
        }
    }

    clearAllFieldErrors() {
        const errorDivs = document.querySelectorAll('.field-error');
        errorDivs.forEach(div => div.remove());

        const fields = document.querySelectorAll('input, select, textarea');
        fields.forEach(field => {
            field.style.borderColor = '';
        });
    }

    handleApproveAction(button) {
        const patientcode = button.dataset.patientcode;
        const visitcode = button.dataset.visitcode;
        const docno = button.dataset.docno;

        if (confirm(`Are you sure you want to approve the refund request for patient ${patientcode}?`)) {
            this.showAlert(`Processing approval for patient ${patientcode}...`, 'info');
            
            // Simulate approval process
            setTimeout(() => {
                this.showAlert(`Refund request for patient ${patientcode} has been approved successfully!`, 'success');
                // Remove the row from the table
                const row = button.closest('tr');
                if (row) {
                    row.style.opacity = '0.5';
                    setTimeout(() => {
                        row.remove();
                        this.updateRefundCount();
                    }, 1000);
                }
            }, 1500);
        }
    }

    updateRefundCount() {
        const countElement = document.querySelector('.refund-count');
        if (countElement) {
            const currentCount = parseInt(countElement.textContent) || 0;
            countElement.textContent = Math.max(0, currentCount - 1);
        }
    }

    // Utility functions
    focusSearch() {
        const searchField = document.getElementById('patient') || document.getElementById('patientcode');
        if (searchField) {
            searchField.focus();
        }
    }

    refreshPage() {
        window.location.reload();
    }

    printPage() {
        window.print();
    }

    exportToPDF() {
        this.showAlert('Exporting to PDF...', 'info');
        // Implementation for PDF export
        setTimeout(() => {
            this.showAlert('PDF export completed!', 'success');
        }, 2000);
    }

    exportToExcel() {
        this.showAlert('Exporting to Excel...', 'info');
        // Implementation for Excel export
        setTimeout(() => {
            this.showAlert('Excel export completed!', 'success');
        }, 2000);
    }

    showAlert(message, type = 'info') {
        const alertContainer = document.getElementById('alertContainer');
        if (!alertContainer) return;

        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = `
            <span class="alert-icon">${this.getAlertIcon(type)}</span>
            <span class="alert-message">${message}</span>
            <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
        `;

        alertContainer.appendChild(alert);

        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (alert.parentElement) {
                alert.remove();
            }
        }, 5000);
    }

    getAlertIcon(type) {
        const icons = {
            success: '✓',
            error: '✗',
            warning: '⚠',
            info: 'ℹ'
        };
        return icons[type] || icons.info;
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new DepositRefundRequestListManager();
});

// Global functions for legacy compatibility
function cbcustomername1() {
    document.cbform1.submit();
}

function pharmacy(patientcode, visitcode) {
    var url = "pharmacy1.php?RandomKey=" + Math.random() + "&&patientcode=" + patientcode + "&&visitcode=" + visitcode;
    window.open(url, "Pharmacy", 'width=600,height=400');
}

function disableEnterKey(varPassed) {
    if (event.keyCode == 8) {
        event.keyCode = 0; 
        return event.keyCode 
        return false;
    }
    
    var key;
    if (window.event) {
        key = window.event.keyCode;     //IE
    } else {
        key = e.which;     //firefox
    }

    if (key == 13) // if enter key press
    {
        return false;
    } else {
        return true;
    }
}



