/**
 * Modern JavaScript for Amend Pending IP Pharmacy
 * Following VAT Modern Design Patterns
 */

class AmendPendingIPPharmacyManager {
    constructor() {
        this.isSidebarOpen = false;
        this.currentFilters = {};
        this.init();
    }

    init() {
        this.initializeEventListeners();
        this.setupSidebar();
        this.setupFormValidation();
        this.setupTableEnhancements();
        this.setupResponsiveHandling();
        this.setupInputEnhancements();
        this.setupSearchEnhancements();
        this.setupActionButtons();
        this.setupAutoRefresh();
        this.setupKeyboardShortcuts();
        this.setupPrintFunctionality();
        this.setupExportFunctionality();
        this.setupBulkActions();
        this.setupPatientSearch();
        this.setupDateRangeValidation();
        this.setupFormAutoSave();
        this.setupNotificationSystem();
        this.setupAccessibilityFeatures();
    }

    initializeEventListeners() {
        // Menu toggle
        const menuToggle = document.querySelector('.floating-menu-toggle');
        if (menuToggle) {
            menuToggle.addEventListener('click', () => this.toggleSidebar());
        }

        // Sidebar toggle
        const sidebarToggle = document.querySelector('.sidebar-toggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => this.toggleSidebar());
        }

        // Form submission
        const searchForm = document.querySelector('#searchForm');
        if (searchForm) {
            searchForm.addEventListener('submit', (e) => this.handleFormSubmission(e));
        }

        // Form reset
        const resetBtn = document.querySelector('.btn-secondary');
        if (resetBtn) {
            resetBtn.addEventListener('click', () => this.resetForm());
        }

        // Export buttons
        const exportBtns = document.querySelectorAll('[data-export]');
        exportBtns.forEach(btn => {
            btn.addEventListener('click', (e) => this.handleExport(e));
        });

        // Print button
        const printBtn = document.querySelector('.btn-print');
        if (printBtn) {
            printBtn.addEventListener('click', () => this.printReport());
        }

        // Refresh button
        const refreshBtn = document.querySelector('.btn-refresh');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', () => this.refreshData());
        }

        // Location change
        const locationSelect = document.querySelector('#location');
        if (locationSelect) {
            locationSelect.addEventListener('change', () => this.handleLocationChange());
        }

        // Date inputs
        const dateInputs = document.querySelectorAll('input[type="date"]');
        dateInputs.forEach(input => {
            input.addEventListener('change', () => this.validateDateRange());
        });

        // Search input
        const searchInput = document.querySelector('#searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => this.handleSearchInput(e));
        }

        // Bulk action checkboxes
        const bulkCheckboxes = document.querySelectorAll('.bulk-checkbox');
        bulkCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => this.updateBulkActions());
        });

        // Select all checkbox
        const selectAllCheckbox = document.querySelector('#selectAll');
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', (e) => this.toggleSelectAll(e));
        }

        // Action buttons
        const actionButtons = document.querySelectorAll('.action-btn');
        actionButtons.forEach(btn => {
            btn.addEventListener('click', (e) => this.handleActionButton(e));
        });

        // Patient search
        const patientSearchInput = document.querySelector('#patientSearch');
        if (patientSearchInput) {
            patientSearchInput.addEventListener('input', (e) => this.handlePatientSearch(e));
        }

        // Form auto-save
        const formInputs = document.querySelectorAll('.form-input');
        formInputs.forEach(input => {
            input.addEventListener('blur', () => this.autoSaveForm());
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => this.handleKeyboardShortcuts(e));

        // Window resize
        window.addEventListener('resize', () => this.handleWindowResize());

        // Touch events for mobile
        this.setupTouchEvents();
    }

    setupSidebar() {
        const sidebar = document.querySelector('.left-sidebar');
        if (!sidebar) return;

        // Check if sidebar should be open by default on larger screens
        if (window.innerWidth > 1024) {
            this.isSidebarOpen = true;
            sidebar.classList.add('open');
        }
    }

    toggleSidebar() {
        const sidebar = document.querySelector('.left-sidebar');
        if (!sidebar) return;

        this.isSidebarOpen = !this.isSidebarOpen;
        
        if (this.isSidebarOpen) {
            sidebar.classList.add('open');
            document.body.classList.add('sidebar-open');
        } else {
            sidebar.classList.remove('open');
            document.body.classList.remove('sidebar-open');
        }

        // Save preference
        localStorage.setItem('sidebarOpen', this.isSidebarOpen);
    }

    setupFormValidation() {
        const form = document.querySelector('#searchForm');
        if (!form) return;

        // Real-time validation
        const inputs = form.querySelectorAll('.form-input');
        inputs.forEach(input => {
            input.addEventListener('blur', () => this.validateField(input));
            input.addEventListener('input', () => this.clearFieldError(input));
        });

        // Date range validation
        const startDate = form.querySelector('#startDate');
        const endDate = form.querySelector('#endDate');
        if (startDate && endDate) {
            endDate.addEventListener('change', () => this.validateDateRange());
        }
    }

    validateField(input) {
        const value = input.value.trim();
        const fieldName = input.name || input.id;
        
        // Clear previous error
        this.clearFieldError(input);
        
        // Required field validation
        if (input.hasAttribute('required') && !value) {
            this.showFieldError(input, `${this.getFieldLabel(fieldName)} is required`);
            return false;
        }
        
        // Date validation
        if (input.type === 'date' && value) {
            const date = new Date(value);
            if (isNaN(date.getTime())) {
                this.showFieldError(input, 'Please enter a valid date');
                return false;
            }
        }
        
        // Patient code validation
        if (fieldName === 'patientCode' && value) {
            if (!/^[A-Z0-9]+$/.test(value)) {
                this.showFieldError(input, 'Patient code should contain only uppercase letters and numbers');
                return false;
            }
        }
        
        // Visit code validation
        if (fieldName === 'visitCode' && value) {
            if (!/^[A-Z0-9]+$/.test(value)) {
                this.showFieldError(input, 'Visit code should contain only uppercase letters and numbers');
                return false;
            }
        }
        
        return true;
    }

    showFieldError(input, message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.textContent = message;
        errorDiv.style.cssText = 'color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;';
        
        input.parentNode.appendChild(errorDiv);
        input.classList.add('error');
    }

    clearFieldError(input) {
        const errorDiv = input.parentNode.querySelector('.field-error');
        if (errorDiv) {
            errorDiv.remove();
        }
        input.classList.remove('error');
    }

    getFieldLabel(fieldName) {
        const labelMap = {
            'startDate': 'Start Date',
            'endDate': 'End Date',
            'patientCode': 'Patient Code',
            'visitCode': 'Visit Code',
            'location': 'Location',
            'searchInput': 'Search'
        };
        return labelMap[fieldName] || fieldName;
    }

    validateDateRange() {
        const startDate = document.querySelector('#startDate');
        const endDate = document.querySelector('#endDate');
        
        if (!startDate || !endDate) return true;
        
        const start = new Date(startDate.value);
        const end = new Date(endDate.value);
        
        if (startDate.value && endDate.value && start > end) {
            this.showAlert('End date must be after start date', 'error');
            endDate.value = '';
            return false;
        }
        
        // Check if date range is not more than 1 year
        if (startDate.value && endDate.value) {
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            if (diffDays > 365) {
                this.showAlert('Date range cannot exceed 1 year', 'warning');
            }
        }
        
        return true;
    }

    setupTableEnhancements() {
        const table = document.querySelector('.data-table');
        if (!table) return;

        // Add row hover effects
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach((row, index) => {
            row.classList.add(index % 2 === 0 ? 'even-row' : 'odd-row');
            
            // Add click to expand functionality
            row.addEventListener('click', (e) => {
                if (!e.target.closest('.action-btn')) {
                    this.toggleRowExpansion(row);
                }
            });
        });

        // Add sorting functionality
        const headers = table.querySelectorAll('th[data-sortable]');
        headers.forEach(header => {
            header.addEventListener('click', () => this.sortTable(header));
        });

        // Add search/filter functionality
        this.setupTableSearch();
    }

    toggleRowExpansion(row) {
        const expandedRow = row.nextElementSibling;
        
        if (expandedRow && expandedRow.classList.contains('expanded-details')) {
            expandedRow.remove();
            row.classList.remove('expanded');
        } else {
            this.expandRow(row);
        }
    }

    expandRow(row) {
        // Remove any existing expanded rows
        const existingExpanded = document.querySelector('.expanded-details');
        if (existingExpanded) {
            existingExpanded.remove();
        }

        // Create expanded content
        const expandedRow = document.createElement('tr');
        expandedRow.className = 'expanded-details';
        
        const cell = document.createElement('td');
        cell.colSpan = row.querySelectorAll('td').length;
        cell.style.padding = '1rem';
        cell.style.backgroundColor = '#f8fafc';
        
        // Get patient data from the row
        const patientCode = row.querySelector('.patient-code')?.textContent || '';
        const visitCode = row.querySelector('.visit-code')?.textContent || '';
        
        cell.innerHTML = `
            <div class="expanded-content">
                <h4>Patient Details</h4>
                <div class="patient-details-grid">
                    <div class="detail-item">
                        <strong>Patient Code:</strong> ${patientCode}
                    </div>
                    <div class="detail-item">
                        <strong>Visit Code:</strong> ${visitCode}
                    </div>
                    <div class="detail-item">
                        <strong>Pharmacy Status:</strong> <span class="status-badge pending">Pending</span>
                    </div>
                </div>
                <div class="expanded-actions">
                    <button class="btn btn-primary btn-sm" onclick="this.viewPatientDetails('${patientCode}')">
                        <i class="fas fa-user"></i> View Patient
                    </button>
                    <button class="btn btn-secondary btn-sm" onclick="this.viewPharmacyHistory('${patientCode}')">
                        <i class="fas fa-pills"></i> Pharmacy History
                    </button>
                </div>
            </div>
        `;
        
        expandedRow.appendChild(cell);
        row.parentNode.insertBefore(expandedRow, row.nextSibling);
        row.classList.add('expanded');
    }

    setupTableSearch() {
        const searchInput = document.querySelector('#tableSearch');
        if (!searchInput) return;

        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.data-table tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const isVisible = text.includes(searchTerm);
                row.style.display = isVisible ? '' : 'none';
            });
        });
    }

    sortTable(header) {
        const table = header.closest('table');
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const columnIndex = Array.from(header.parentNode.children).indexOf(header);
        const isAscending = header.classList.contains('sort-asc');
        
        // Clear previous sort indicators
        table.querySelectorAll('th').forEach(th => {
            th.classList.remove('sort-asc', 'sort-desc');
        });
        
        // Sort rows
        rows.sort((a, b) => {
            const aValue = a.children[columnIndex]?.textContent || '';
            const bValue = b.children[columnIndex]?.textContent || '';
            
            if (isAscending) {
                return bValue.localeCompare(aValue);
            } else {
                return aValue.localeCompare(bValue);
            }
        });
        
        // Reorder rows
        rows.forEach(row => tbody.appendChild(row));
        
        // Update sort indicator
        header.classList.add(isAscending ? 'sort-desc' : 'sort-asc');
        
        // Update row classes
        rows.forEach((row, index) => {
            row.className = index % 2 === 0 ? 'even-row' : 'odd-row';
        });
    }

    setupResponsiveHandling() {
        // Handle window resize
        const handleResize = () => {
            if (window.innerWidth <= 1024) {
                document.body.classList.add('mobile-view');
                if (this.isSidebarOpen) {
                    this.toggleSidebar();
                }
            } else {
                document.body.classList.remove('mobile-view');
            }
        };

        handleResize();
        window.addEventListener('resize', handleResize);
    }

    setupInputEnhancements() {
        // Auto-format patient codes
        const patientCodeInput = document.querySelector('#patientCode');
        if (patientCodeInput) {
            patientCodeInput.addEventListener('input', (e) => {
                e.target.value = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
            });
        }

        // Auto-format visit codes
        const visitCodeInput = document.querySelector('#visitCode');
        if (visitCodeInput) {
            visitCodeInput.addEventListener('input', (e) => {
                e.target.value = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
            });
        }

        // Date picker enhancements
        const dateInputs = document.querySelectorAll('input[type="date"]');
        dateInputs.forEach(input => {
            this.enhanceDateInput(input);
        });

        // Search input enhancements
        const searchInput = document.querySelector('#searchInput');
        if (searchInput) {
            this.enhanceSearchInput(searchInput);
        }
    }

    enhanceDateInput(input) {
        // Add quick date buttons
        const quickDateContainer = document.createElement('div');
        quickDateContainer.className = 'quick-date-buttons';
        quickDateContainer.style.cssText = 'margin-top: 0.5rem; display: flex; gap: 0.5rem; flex-wrap: wrap;';
        
        const quickDates = [
            { label: 'Today', days: 0 },
            { label: 'Yesterday', days: -1 },
            { label: 'Last 7 days', days: -7 },
            { label: 'Last 30 days', days: -30 }
        ];
        
        quickDates.forEach(({ label, days }) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'btn btn-outline btn-sm';
            button.textContent = label;
            button.style.cssText = 'font-size: 0.75rem; padding: 0.25rem 0.5rem;';
            
            button.addEventListener('click', () => {
                const date = new Date();
                date.setDate(date.getDate() + days);
                input.value = date.toISOString().split('T')[0];
                this.validateDateRange();
            });
            
            quickDateContainer.appendChild(button);
        });
        
        input.parentNode.appendChild(quickDateContainer);
    }

    enhanceSearchInput(input) {
        // Add search suggestions
        const suggestionsContainer = document.createElement('div');
        suggestionsContainer.className = 'search-suggestions';
        suggestionsContainer.style.cssText = 'position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #e2e8f0; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); z-index: 1000; display: none;';
        
        input.parentNode.style.position = 'relative';
        input.parentNode.appendChild(suggestionsContainer);
        
        input.addEventListener('input', (e) => {
            const value = e.target.value.trim();
            if (value.length >= 2) {
                this.showSearchSuggestions(value, suggestionsContainer);
            } else {
                suggestionsContainer.style.display = 'none';
            }
        });
        
        // Hide suggestions when clicking outside
        document.addEventListener('click', (e) => {
            if (!input.parentNode.contains(e.target)) {
                suggestionsContainer.style.display = 'none';
            }
        });
    }

    showSearchSuggestions(query, container) {
        // Mock suggestions - in real app, this would come from API
        const suggestions = [
            'Patient consultation',
            'Pharmacy orders',
            'Pending medications',
            'Completed prescriptions'
        ].filter(item => item.toLowerCase().includes(query.toLowerCase()));
        
        if (suggestions.length > 0) {
            container.innerHTML = suggestions.map(suggestion => 
                `<div class="suggestion-item" style="padding: 0.5rem; cursor: pointer; border-bottom: 1px solid #f1f5f9;">${suggestion}</div>`
            ).join('');
            
            container.style.display = 'block';
            
            // Add click handlers
            container.querySelectorAll('.suggestion-item').forEach(item => {
                item.addEventListener('click', () => {
                    document.querySelector('#searchInput').value = item.textContent;
                    container.style.display = 'none';
                });
            });
        } else {
            container.style.display = 'none';
        }
    }

    setupSearchEnhancements() {
        // Debounced search
        let searchTimeout;
        const searchInput = document.querySelector('#searchInput');
        
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.performSearch(e.target.value);
                }, 300);
            });
        }
    }

    performSearch(query) {
        const rows = document.querySelectorAll('.data-table tbody tr');
        const searchTerm = query.toLowerCase();
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const isVisible = text.includes(searchTerm);
            row.style.display = isVisible ? '' : 'none';
        });
        
        // Update results count
        this.updateSearchResultsCount();
    }

    updateSearchResultsCount() {
        const visibleRows = document.querySelectorAll('.data-table tbody tr:not([style*="display: none"])');
        const totalRows = document.querySelectorAll('.data-table tbody tr').length;
        
        const resultsCount = document.querySelector('.results-count');
        if (resultsCount) {
            resultsCount.textContent = `Showing ${visibleRows.length} of ${totalRows} results`;
        }
    }

    setupActionButtons() {
        // Amend button
        const amendButtons = document.querySelectorAll('.action-btn.amend');
        amendButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const row = btn.closest('tr');
                const patientCode = row.querySelector('.patient-code')?.textContent || '';
                this.handleAmendAction(patientCode);
            });
        });

        // View button
        const viewButtons = document.querySelectorAll('.action-btn.view');
        viewButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const row = btn.closest('tr');
                const patientCode = row.querySelector('.patient-code')?.textContent || '';
                this.handleViewAction(patientCode);
            });
        });

        // Print button
        const printButtons = document.querySelectorAll('.action-btn.print');
        printButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const row = btn.closest('tr');
                const patientCode = row.querySelector('.patient-code')?.textContent || '';
                this.handlePrintAction(patientCode);
            });
        });

        // Pharmacy button
        const pharmacyButtons = document.querySelectorAll('.action-btn.pharmacy');
        pharmacyButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const row = btn.closest('tr');
                const patientCode = row.querySelector('.patient-code')?.textContent || '';
                this.handlePharmacyAction(patientCode);
            });
        });
    }

    handleAmendAction(patientCode) {
        if (this.confirmAction('amend', patientCode)) {
            // Show loading state
            this.showLoadingState();
            
            // Simulate API call
            setTimeout(() => {
                this.hideLoadingState();
                this.showAlert(`Successfully amended pharmacy consultation for patient ${patientCode}`, 'success');
                this.refreshData();
            }, 1000);
        }
    }

    handleViewAction(patientCode) {
        // Navigate to patient view page
        window.open(`patient_view.php?code=${patientCode}`, '_blank');
    }

    handlePrintAction(patientCode) {
        // Print patient pharmacy report
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Pharmacy Report - ${patientCode}</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        .header { text-align: center; margin-bottom: 30px; }
                        .patient-info { margin-bottom: 20px; }
                        table { width: 100%; border-collapse: collapse; }
                        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                        th { background-color: #f2f2f2; }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>Pharmacy Consultation Report</h1>
                        <p>Patient Code: ${patientCode}</p>
                        <p>Date: ${new Date().toLocaleDateString()}</p>
                    </div>
                    <div class="patient-info">
                        <h3>Patient Information</h3>
                        <p><strong>Code:</strong> ${patientCode}</p>
                        <p><strong>Status:</strong> Pending Amendment</p>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Medication</th>
                                <th>Status</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Prescription</td>
                                <td>Pending</td>
                                <td>Requires amendment</td>
                            </tr>
                        </tbody>
                    </table>
                </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    }

    handlePharmacyAction(patientCode) {
        // Navigate to pharmacy management page
        window.open(`pharmacy_management.php?patient=${patientCode}`, '_blank');
    }

    confirmAction(action, patientCode) {
        const actionLabels = {
            'amend': 'amend the pharmacy consultation',
            'delete': 'delete this record',
            'activate': 'activate this record'
        };
        
        return confirm(`Are you sure you want to ${actionLabels[action]} for patient ${patientCode}?`);
    }

    setupAutoRefresh() {
        // Auto-refresh every 5 minutes
        setInterval(() => {
            if (document.visibilityState === 'visible') {
                this.refreshData();
            }
        }, 5 * 60 * 1000);
    }

    setupKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Ctrl/Cmd + F for search
            if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                e.preventDefault();
                const searchInput = document.querySelector('#searchInput');
                if (searchInput) {
                    searchInput.focus();
                }
            }
            
            // Ctrl/Cmd + R for refresh
            if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
                e.preventDefault();
                this.refreshData();
            }
            
            // Ctrl/Cmd + P for print
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                this.printReport();
            }
            
            // Escape to close sidebar
            if (e.key === 'Escape' && this.isSidebarOpen) {
                this.toggleSidebar();
            }
        });
    }

    setupPrintFunctionality() {
        const printBtn = document.querySelector('.btn-print');
        if (printBtn) {
            printBtn.addEventListener('click', () => this.printReport());
        }
    }

    printReport() {
        // Hide elements not needed for printing
        const elementsToHide = document.querySelectorAll('.floating-menu-toggle, .left-sidebar, .page-header-actions, .search-form-section');
        elementsToHide.forEach(el => el.style.display = 'none');
        
        // Print
        window.print();
        
        // Restore elements
        elementsToHide.forEach(el => el.style.display = '');
    }

    setupExportFunctionality() {
        const exportBtns = document.querySelectorAll('[data-export]');
        exportBtns.forEach(btn => {
            btn.addEventListener('click', (e) => this.handleExport(e));
        });
    }

    handleExport(e) {
        const exportType = e.target.dataset.export;
        const patientCode = e.target.dataset.patient || '';
        
        switch (exportType) {
            case 'excel':
                this.exportToExcel(patientCode);
                break;
            case 'pdf':
                this.exportToPDF(patientCode);
                break;
            case 'csv':
                this.exportToCSV(patientCode);
                break;
        }
    }

    exportToExcel(patientCode = '') {
        // Implementation for Excel export
        this.showAlert('Excel export functionality will be implemented here', 'info');
    }

    exportToPDF(patientCode = '') {
        // Implementation for PDF export
        this.showAlert('PDF export functionality will be implemented here', 'info');
    }

    exportToCSV(patientCode = '') {
        // Implementation for CSV export
        this.showAlert('CSV export functionality will be implemented here', 'info');
    }

    setupBulkActions() {
        const bulkActionSelect = document.querySelector('#bulkAction');
        if (bulkActionSelect) {
            bulkActionSelect.addEventListener('change', (e) => {
                if (e.target.value) {
                    this.executeBulkAction(e.target.value);
                }
            });
        }
    }

    executeBulkAction(action) {
        const selectedRows = document.querySelectorAll('.bulk-checkbox:checked');
        if (selectedRows.length === 0) {
            this.showAlert('Please select at least one record', 'warning');
            return;
        }
        
        const confirmMessage = `Are you sure you want to ${action} ${selectedRows.length} selected record(s)?`;
        if (confirm(confirmMessage)) {
            this.showLoadingState();
            
            // Simulate bulk action
            setTimeout(() => {
                this.hideLoadingState();
                this.showAlert(`Successfully ${action}ed ${selectedRows.length} record(s)`, 'success');
                this.refreshData();
            }, 2000);
        }
    }

    setupPatientSearch() {
        const patientSearchInput = document.querySelector('#patientSearch');
        if (!patientSearchInput) return;
        
        let searchTimeout;
        patientSearchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                this.searchPatients(e.target.value);
            }, 300);
        });
    }

    searchPatients(query) {
        if (query.length < 2) return;
        
        // Mock patient search - in real app, this would be an API call
        const mockPatients = [
            { code: 'P001', name: 'John Doe', age: 35 },
            { code: 'P002', name: 'Jane Smith', age: 28 },
            { code: 'P003', name: 'Bob Johnson', age: 42 }
        ].filter(patient => 
            patient.code.toLowerCase().includes(query.toLowerCase()) ||
            patient.name.toLowerCase().includes(query.toLowerCase())
        );
        
        this.displayPatientSearchResults(mockPatients);
    }

    displayPatientSearchResults(patients) {
        let resultsContainer = document.querySelector('.patient-search-results');
        if (!resultsContainer) {
            resultsContainer = document.createElement('div');
            resultsContainer.className = 'patient-search-results';
            resultsContainer.style.cssText = 'position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #e2e8f0; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); z-index: 1000; max-height: 200px; overflow-y: auto;';
            
            const searchInput = document.querySelector('#patientSearch');
            searchInput.parentNode.style.position = 'relative';
            searchInput.parentNode.appendChild(resultsContainer);
        }
        
        if (patients.length > 0) {
            resultsContainer.innerHTML = patients.map(patient => `
                <div class="patient-result-item" style="padding: 0.75rem; border-bottom: 1px solid #f1f5f9; cursor: pointer;">
                    <div style="font-weight: 600;">${patient.code}</div>
                    <div style="color: #64748b; font-size: 0.875rem;">${patient.name} (${patient.age} years)</div>
                </div>
            `).join('');
            
            resultsContainer.style.display = 'block';
            
            // Add click handlers
            resultsContainer.querySelectorAll('.patient-result-item').forEach((item, index) => {
                item.addEventListener('click', () => {
                    const patient = patients[index];
                    document.querySelector('#patientSearch').value = patient.code;
                    resultsContainer.style.display = 'none';
                });
            });
        } else {
            resultsContainer.style.display = 'none';
        }
    }

    setupDateRangeValidation() {
        const startDate = document.querySelector('#startDate');
        const endDate = document.querySelector('#endDate');
        
        if (startDate && endDate) {
            endDate.addEventListener('change', () => {
                this.validateDateRange();
            });
        }
    }

    setupFormAutoSave() {
        const form = document.querySelector('#searchForm');
        if (!form) return;
        
        const formData = new FormData(form);
        const formKey = 'amendPendingIPPharmacyForm';
        
        // Load saved form data
        const savedData = localStorage.getItem(formKey);
        if (savedData) {
            try {
                const data = JSON.parse(savedData);
                Object.keys(data).forEach(key => {
                    const input = form.querySelector(`[name="${key}"]`);
                    if (input) {
                        input.value = data[key];
                    }
                });
            } catch (e) {
                console.error('Error loading saved form data:', e);
            }
        }
        
        // Auto-save form data
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('change', () => {
                this.saveFormData(form, formKey);
            });
        });
    }

    saveFormData(form, key) {
        const formData = new FormData(form);
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            if (value) {
                data[key] = value;
            }
        }
        
        localStorage.setItem(key, JSON.stringify(data));
    }

    setupNotificationSystem() {
        // Create notification container
        const notificationContainer = document.createElement('div');
        notificationContainer.id = 'notificationContainer';
        notificationContainer.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 400px;';
        document.body.appendChild(notificationContainer);
    }

    setupAccessibilityFeatures() {
        // Add ARIA labels
        const actionButtons = document.querySelectorAll('.action-btn');
        actionButtons.forEach(btn => {
            const action = btn.classList.contains('amend') ? 'amend' :
                          btn.classList.contains('view') ? 'view' :
                          btn.classList.contains('print') ? 'print' : 'pharmacy';
            
            btn.setAttribute('aria-label', `${action} patient record`);
        });
        
        // Add skip links
        const skipLink = document.createElement('a');
        skipLink.href = '#main-content';
        skipLink.textContent = 'Skip to main content';
        skipLink.style.cssText = 'position: absolute; top: -40px; left: 6px; z-index: 10000; padding: 8px; background: #000; color: #fff; text-decoration: none;';
        skipLink.addEventListener('focus', () => {
            skipLink.style.top = '6px';
        });
        skipLink.addEventListener('blur', () => {
            skipLink.style.top = '-40px';
        });
        
        document.body.insertBefore(skipLink, document.body.firstChild);
    }

    setupTouchEvents() {
        // Swipe gestures for mobile
        let startX = 0;
        let startY = 0;
        
        document.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
        });
        
        document.addEventListener('touchend', (e) => {
            const endX = e.changedTouches[0].clientX;
            const endY = e.changedTouches[0].clientY;
            const diffX = startX - endX;
            const diffY = startY - endY;
            
            // Swipe left to open sidebar
            if (diffX > 50 && Math.abs(diffY) < 50 && !this.isSidebarOpen) {
                this.toggleSidebar();
            }
            
            // Swipe right to close sidebar
            if (diffX < -50 && Math.abs(diffY) < 50 && this.isSidebarOpen) {
                this.toggleSidebar();
            }
        });
    }

    handleFormSubmission(e) {
        e.preventDefault();
        
        // Validate form
        const form = e.target;
        const inputs = form.querySelectorAll('.form-input');
        let isValid = true;
        
        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            this.showAlert('Please fix the errors in the form', 'error');
            return;
        }
        
        // Show loading state
        this.showLoadingState();
        
        // Simulate form submission
        setTimeout(() => {
            this.hideLoadingState();
            this.showAlert('Search completed successfully', 'success');
            this.performSearch(document.querySelector('#searchInput')?.value || '');
        }, 1000);
    }

    resetForm() {
        const form = document.querySelector('#searchForm');
        if (form) {
            form.reset();
            this.clearAllFieldErrors();
            this.showAlert('Form has been reset', 'info');
        }
    }

    clearAllFieldErrors() {
        const errorDivs = document.querySelectorAll('.field-error');
        errorDivs.forEach(div => div.remove());
        
        const errorInputs = document.querySelectorAll('.form-input.error');
        errorInputs.forEach(input => input.classList.remove('error'));
    }

    handleLocationChange() {
        const locationSelect = document.querySelector('#location');
        if (locationSelect) {
            const selectedLocation = locationSelect.value;
            this.showAlert(`Location changed to: ${selectedLocation}`, 'info');
            
            // Refresh data for new location
            this.refreshData();
        }
    }

    handleSearchInput(e) {
        const query = e.target.value.trim();
        if (query.length >= 2) {
            this.performSearch(query);
        }
    }

    handleActionButton(e) {
        e.preventDefault();
        const action = e.target.classList.contains('amend') ? 'amend' :
                      e.target.classList.contains('view') ? 'view' :
                      e.target.classList.contains('print') ? 'print' : 'pharmacy';
        
        const row = e.target.closest('tr');
        const patientCode = row.querySelector('.patient-code')?.textContent || '';
        
        switch (action) {
            case 'amend':
                this.handleAmendAction(patientCode);
                break;
            case 'view':
                this.handleViewAction(patientCode);
                break;
            case 'print':
                this.handlePrintAction(patientCode);
                break;
            case 'pharmacy':
                this.handlePharmacyAction(patientCode);
                break;
        }
    }

    handlePatientSearch(e) {
        const query = e.target.value.trim();
        if (query.length >= 2) {
            this.searchPatients(query);
        }
    }

    handleKeyboardShortcuts(e) {
        // Already implemented in setupKeyboardShortcuts
    }

    handleWindowResize() {
        this.setupResponsiveHandling();
    }

    toggleSelectAll(e) {
        const isChecked = e.target.checked;
        const checkboxes = document.querySelectorAll('.bulk-checkbox');
        
        checkboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
        });
        
        this.updateBulkActions();
    }

    updateBulkActions() {
        const selectedCount = document.querySelectorAll('.bulk-checkbox:checked').length;
        const bulkActionSelect = document.querySelector('#bulkAction');
        
        if (bulkActionSelect) {
            bulkActionSelect.disabled = selectedCount === 0;
        }
        
        // Update bulk action button text
        const bulkActionBtn = document.querySelector('.bulk-action-btn');
        if (bulkActionBtn) {
            bulkActionBtn.textContent = `Apply to ${selectedCount} selected`;
            bulkActionBtn.disabled = selectedCount === 0;
        }
    }

    showLoadingState() {
        const loadingOverlay = document.createElement('div');
        loadingOverlay.id = 'loadingOverlay';
        loadingOverlay.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); display: flex; justify-content: center; align-items: center; z-index: 10000;';
        loadingOverlay.innerHTML = '<div style="background: white; padding: 2rem; border-radius: 0.5rem; text-align: center;"><div class="spinner" style="border: 4px solid #f3f3f3; border-top: 4px solid #3498db; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; margin: 0 auto 1rem;"></div><p>Processing...</p></div>';
        
        document.body.appendChild(loadingOverlay);
        
        // Add spinner animation
        const style = document.createElement('style');
        style.textContent = '@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }';
        document.head.appendChild(style);
    }

    hideLoadingState() {
        const loadingOverlay = document.getElementById('loadingOverlay');
        if (loadingOverlay) {
            loadingOverlay.remove();
        }
    }

    refreshData() {
        this.showLoadingState();
        
        // Simulate data refresh
        setTimeout(() => {
            this.hideLoadingState();
            this.showAlert('Data refreshed successfully', 'success');
            
            // Update table data
            this.updateTableData();
        }, 1000);
    }

    updateTableData() {
        // Mock data update - in real app, this would fetch new data
        const rows = document.querySelectorAll('.data-table tbody tr');
        rows.forEach((row, index) => {
            row.classList.remove('even-row', 'odd-row');
            row.classList.add(index % 2 === 0 ? 'even-row' : 'odd-row');
        });
    }

    showAlert(message, type = 'info') {
        const alertContainer = document.getElementById('alertContainer');
        if (!alertContainer) return;
        
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = `
            <i class="alert-icon fas fa-${this.getAlertIcon(type)}"></i>
            <span>${message}</span>
            <button type="button" class="alert-close" onclick="this.parentElement.remove()" style="margin-left: auto; background: none; border: none; font-size: 1.25rem; cursor: pointer; color: inherit;">×</button>
        `;
        
        alertContainer.appendChild(alert);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }

    getAlertIcon(type) {
        const iconMap = {
            'success': 'check-circle',
            'error': 'exclamation-circle',
            'warning': 'exclamation-triangle',
            'info': 'info-circle'
        };
        return iconMap[type] || 'info-circle';
    }

    clearAlerts() {
        const alertContainer = document.getElementById('alertContainer');
        if (alertContainer) {
            alertContainer.innerHTML = '';
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new AmendPendingIPPharmacyManager();
});

// Export for global access
window.AmendPendingIPPharmacyManager = AmendPendingIPPharmacyManager;






