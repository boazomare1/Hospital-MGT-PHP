// Doctor Advance Payment Entry Modern JavaScript
class DoctorAdvancePaymentManager {
    constructor() {
        this.currentPage = 1;
        this.itemsPerPage = 10;
        this.totalItems = 0;
        this.totalPages = 0;
        this.currentDoctor = null;
        this.ledgerBalance = 0;
        this.init();
    }

    init() {
        this.initializeElements();
        this.bindEvents();
        this.setupAutocomplete();
        this.loadInitialData();
    }

    initializeElements() {
        // Main containers
        this.sidebar = document.querySelector('.left-sidebar');
        this.mainContainer = document.querySelector('.main-container-with-sidebar');
        this.floatingMenuToggle = document.querySelector('.floating-menu-toggle');
        this.alertContainer = document.getElementById('alertContainer');
        
        // Form elements
        this.doctorSearchForm = document.getElementById('doctorSearchForm');
        this.paymentEntryForm = document.getElementById('paymentEntryForm');
        this.doctorSearchInput = document.getElementById('doctorSearch');
        this.doctorSelect = document.getElementById('doctorSelect');
        
        // Payment form elements
        this.amountInput = document.getElementById('amount');
        this.paymentModeSelect = document.getElementById('paymentMode');
        this.chequeNumberInput = document.getElementById('chequeNumber');
        this.bankNameInput = document.getElementById('bankName');
        this.mpesaNumberInput = document.getElementById('mpesaNumber');
        this.onlineReferenceInput = document.getElementById('onlineReference');
        this.bankChargesInput = document.getElementById('bankCharges');
        this.whtRateInput = document.getElementById('whtRate');
        this.whtAmountInput = document.getElementById('whtAmount');
        this.netPayableInput = document.getElementById('netPayable');
        
        // Display elements
        this.ledgerBalanceDisplay = document.getElementById('ledgerBalanceDisplay');
        this.amountDisplay = document.getElementById('amountDisplay');
        this.whtDisplay = document.getElementById('whtDisplay');
        this.netPayableDisplay = document.getElementById('netPayableDisplay');
        
        // Buttons
        this.searchButton = document.querySelector('button[type="submit"]');
        this.saveButton = document.querySelector('button[name="save"]');
        this.resetButton = document.querySelector('button[name="reset"]');
        this.exportButton = document.querySelector('button[name="export"]');
        
        // Tables
        this.paymentHistoryTable = document.querySelector('.data-table');
        
        // Pagination
        this.paginationContainer = document.querySelector('.pagination-controls');
    }

    bindEvents() {
        // Sidebar toggle
        if (this.floatingMenuToggle) {
            this.floatingMenuToggle.addEventListener('click', () => this.toggleSidebar());
        }

        // Form submissions
        if (this.doctorSearchForm) {
            this.doctorSearchForm.addEventListener('submit', (e) => this.handleDoctorSearch(e));
        }

        if (this.paymentEntryForm) {
            this.paymentEntryForm.addEventListener('submit', (e) => this.handlePaymentEntry(e));
        }

        // Input validations
        if (this.amountInput) {
            this.amountInput.addEventListener('input', (e) => this.validateAmount(e.target));
            this.amountInput.addEventListener('change', () => this.calculateNetPayable());
        }

        if (this.paymentModeSelect) {
            this.paymentModeSelect.addEventListener('change', () => this.togglePaymentFields());
        }

        if (this.bankChargesInput) {
            this.bankChargesInput.addEventListener('input', (e) => this.validateNumeric(e.target, 0));
            this.bankChargesInput.addEventListener('change', () => this.calculateNetPayable());
        }

        if (this.whtRateInput) {
            this.whtRateInput.addEventListener('input', (e) => this.validateWhtRate(e.target));
            this.whtRateInput.addEventListener('change', () => this.calculateWhtAmount());
        }

        // Button events
        if (this.resetButton) {
            this.resetButton.addEventListener('click', () => this.resetForm());
        }

        if (this.exportButton) {
            this.exportButton.addEventListener('click', () => this.exportToExcel());
        }

        // Prevent Enter key on specific inputs
        this.preventEnterKey();
    }

    setupAutocomplete() {
        if (this.doctorSearchInput) {
            this.doctorSearchInput.addEventListener('input', (e) => {
                const query = e.target.value.trim();
                if (query.length >= 2) {
                    this.searchDoctors(query);
                }
            });
        }
    }

    async searchDoctors(query) {
        try {
            const response = await fetch('autocompletebuild_doctor.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `query=${encodeURIComponent(query)}`
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.text();
            this.displayDoctorResults(data);
        } catch (error) {
            console.error('Error searching doctors:', error);
            this.showAlert('Error searching doctors. Please try again.', 'error');
        }
    }

    displayDoctorResults(data) {
        // Parse and display doctor search results
        // This would need to be implemented based on the actual response format
        console.log('Doctor search results:', data);
    }

    async handleDoctorSearch(e) {
        e.preventDefault();
        
        const formData = new FormData(this.doctorSearchForm);
        const doctorId = formData.get('doctorSelect');
        
        if (!doctorId) {
            this.showAlert('Please select a doctor.', 'warning');
            return;
        }

        try {
            // Get doctor details and ledger balance
            await this.loadDoctorDetails(doctorId);
            this.showPaymentForm();
        } catch (error) {
            console.error('Error loading doctor details:', error);
            this.showAlert('Error loading doctor details. Please try again.', 'error');
        }
    }

    async loadDoctorDetails(doctorId) {
        try {
            const response = await fetch('get_doctor_details.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `doctorId=${encodeURIComponent(doctorId)}`
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();
            this.currentDoctor = data.doctor;
            this.ledgerBalance = data.ledgerBalance;
            this.updateDisplay();
        } catch (error) {
            console.error('Error loading doctor details:', error);
            throw error;
        }
    }

    updateDisplay() {
        if (this.ledgerBalanceDisplay) {
            this.ledgerBalanceDisplay.innerHTML = `
                <h4>Current Ledger Balance</h4>
                <div class="ledger-amount">${this.formatCurrency(this.ledgerBalance)}</div>
            `;
        }
    }

    showPaymentForm() {
        const paymentSection = document.querySelector('.payment-entry-section');
        if (paymentSection) {
            paymentSection.style.display = 'block';
            paymentSection.classList.add('fade-in');
        }
    }

    async handlePaymentEntry(e) {
        e.preventDefault();
        
        if (!this.validatePaymentForm()) {
            return;
        }

        const formData = new FormData(this.paymentEntryForm);
        formData.append('doctorId', this.currentDoctor.id);

        try {
            const response = await fetch('process_payment.php', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const result = await response.json();
            
            if (result.success) {
                this.showAlert('Payment processed successfully!', 'success');
                this.resetForm();
                this.loadPaymentHistory();
            } else {
                this.showAlert(result.message || 'Error processing payment.', 'error');
            }
        } catch (error) {
            console.error('Error processing payment:', error);
            this.showAlert('Error processing payment. Please try again.', 'error');
        }
    }

    validatePaymentForm() {
        const amount = parseFloat(this.amountInput.value) || 0;
        const paymentMode = this.paymentModeSelect.value;

        if (amount <= 0) {
            this.showAlert('Please enter a valid amount.', 'warning');
            return false;
        }

        if (!paymentMode) {
            this.showAlert('Please select a payment mode.', 'warning');
            return false;
        }

        // Validate payment mode specific fields
        switch (paymentMode) {
            case 'cheque':
                if (!this.chequeNumberInput.value.trim()) {
                    this.showAlert('Please enter cheque number.', 'warning');
                    return false;
                }
                if (!this.bankNameInput.value.trim()) {
                    this.showAlert('Please enter bank name.', 'warning');
                    return false;
                }
                break;
            case 'mpesa':
                if (!this.mpesaNumberInput.value.trim()) {
                    this.showAlert('Please enter MPESA number.', 'warning');
                    return false;
                }
                break;
            case 'online':
                if (!this.onlineReferenceInput.value.trim()) {
                    this.showAlert('Please enter online reference.', 'warning');
                    return false;
                }
                break;
        }

        return true;
    }

    togglePaymentFields() {
        const paymentMode = this.paymentModeSelect.value;
        
        // Hide all payment-specific fields
        const paymentFields = document.querySelectorAll('.payment-field');
        paymentFields.forEach(field => field.style.display = 'none');
        
        // Show relevant fields based on payment mode
        switch (paymentMode) {
            case 'cheque':
                document.querySelectorAll('.cheque-field').forEach(field => field.style.display = 'block');
                break;
            case 'mpesa':
                document.querySelectorAll('.mpesa-field').forEach(field => field.style.display = 'block');
                break;
            case 'online':
                document.querySelectorAll('.online-field').forEach(field => field.style.display = 'block');
                break;
        }
    }

    calculateWhtAmount() {
        const amount = parseFloat(this.amountInput.value) || 0;
        const whtRate = parseFloat(this.whtRateInput.value) || 0;
        
        if (amount > 0 && whtRate >= 0) {
            const whtAmount = (amount * whtRate) / 100;
            this.whtAmountInput.value = whtAmount.toFixed(2);
            this.calculateNetPayable();
        }
    }

    calculateNetPayable() {
        const amount = parseFloat(this.amountInput.value) || 0;
        const bankCharges = parseFloat(this.bankChargesInput.value) || 0;
        const whtAmount = parseFloat(this.whtAmountInput.value) || 0;
        
        const netPayable = amount - bankCharges - whtAmount;
        this.netPayableInput.value = netPayable.toFixed(2);
        
        this.updateAmountDisplays(amount, whtAmount, netPayable);
    }

    updateAmountDisplays(amount, whtAmount, netPayable) {
        if (this.amountDisplay) {
            this.amountDisplay.innerHTML = `
                <div class="label">Amount</div>
                <div class="value">${this.formatCurrency(amount)}</div>
            `;
        }
        
        if (this.whtDisplay) {
            this.whtDisplay.innerHTML = `
                <div class="label">WHT Amount</div>
                <div class="value">${this.formatCurrency(whtAmount)}</div>
            `;
        }
        
        if (this.netPayableDisplay) {
            this.netPayableDisplay.innerHTML = `
                <div class="label">Net Payable</div>
                <div class="value">${this.formatCurrency(netPayable)}</div>
            `;
        }
    }

    validateAmount(input) {
        const value = parseFloat(input.value);
        if (value < 0) {
            input.value = 0;
        }
        this.calculateNetPayable();
    }

    validateWhtRate(input) {
        const value = parseFloat(input.value);
        if (value < 0) {
            input.value = 0;
        } else if (value > 100) {
            input.value = 100;
        }
    }

    validateNumeric(input, minValue = 0) {
        const value = parseFloat(input.value);
        if (value < minValue) {
            input.value = minValue;
        }
    }

    preventEnterKey() {
        const inputs = document.querySelectorAll('input[type="text"], input[type="number"], select');
        inputs.forEach(input => {
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                }
            });
        });
    }

    resetForm() {
        if (this.paymentEntryForm) {
            this.paymentEntryForm.reset();
        }
        
        // Reset displays
        this.updateAmountDisplays(0, 0, 0);
        
        // Hide payment-specific fields
        const paymentFields = document.querySelectorAll('.payment-field');
        paymentFields.forEach(field => field.style.display = 'none');
        
        this.showAlert('Form has been reset.', 'success');
    }

    async loadPaymentHistory() {
        try {
            const response = await fetch('get_payment_history.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `page=${this.currentPage}&itemsPerPage=${this.itemsPerPage}`
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();
            this.totalItems = data.total;
            this.totalPages = Math.ceil(this.totalItems / this.itemsPerPage);
            
            this.displayPaymentHistory(data.payments);
            this.updatePagination();
        } catch (error) {
            console.error('Error loading payment history:', error);
            this.showAlert('Error loading payment history.', 'error');
        }
    }

    displayPaymentHistory(payments) {
        if (!this.paymentHistoryTable) return;

        const tbody = this.paymentHistoryTable.querySelector('tbody');
        if (!tbody) return;

        tbody.innerHTML = '';

        payments.forEach(payment => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${payment.date}</td>
                <td>${payment.doctorName}</td>
                <td>${this.formatCurrency(payment.amount)}</td>
                <td>${payment.paymentMode}</td>
                <td>${payment.reference}</td>
                <td>${this.formatCurrency(payment.netPayable)}</td>
                <td>
                    <button class="btn btn-sm btn-outline" onclick="viewPayment(${payment.id})">View</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    updatePagination() {
        if (!this.paginationContainer) return;

        const paginationInfo = this.paginationContainer.querySelector('.pagination-info');
        const paginationButtons = this.paginationContainer.querySelector('.pagination-buttons');

        if (paginationInfo) {
            const start = (this.currentPage - 1) * this.itemsPerPage + 1;
            const end = Math.min(this.currentPage * this.itemsPerPage, this.totalItems);
            paginationInfo.textContent = `Showing ${start}-${end} of ${this.totalItems} payments`;
        }

        if (paginationButtons) {
            paginationButtons.innerHTML = '';

            // Previous button
            if (this.currentPage > 1) {
                const prevBtn = document.createElement('button');
                prevBtn.className = 'page-number';
                prevBtn.textContent = '←';
                prevBtn.onclick = () => this.goToPage(this.currentPage - 1);
                paginationButtons.appendChild(prevBtn);
            }

            // Page numbers
            for (let i = 1; i <= this.totalPages; i++) {
                if (i === 1 || i === this.totalPages || (i >= this.currentPage - 2 && i <= this.currentPage + 2)) {
                    const pageBtn = document.createElement('button');
                    pageBtn.className = `page-number ${i === this.currentPage ? 'active' : ''}`;
                    pageBtn.textContent = i;
                    pageBtn.onclick = () => this.goToPage(i);
                    paginationButtons.appendChild(pageBtn);
                } else if (i === this.currentPage - 3 || i === this.currentPage + 3) {
                    const ellipsis = document.createElement('span');
                    ellipsis.textContent = '...';
                    ellipsis.style.padding = '0.5rem';
                    paginationButtons.appendChild(ellipsis);
                }
            }

            // Next button
            if (this.currentPage < this.totalPages) {
                const nextBtn = document.createElement('button');
                nextBtn.className = 'page-number';
                nextBtn.textContent = '→';
                nextBtn.onclick = () => this.goToPage(this.currentPage + 1);
                paginationButtons.appendChild(nextBtn);
            }
        }
    }

    goToPage(page) {
        this.currentPage = page;
        this.loadPaymentHistory();
    }

    toggleSidebar() {
        this.mainContainer.classList.toggle('sidebar-collapsed');
    }

    showAlert(message, type = 'info') {
        if (!this.alertContainer) return;

        const alert = document.createElement('div');
        alert.className = `alert alert-${type} fade-in`;
        alert.innerHTML = `
            <span class="alert-icon">${this.getAlertIcon(type)}</span>
            <span>${message}</span>
            <button class="alert-close" onclick="this.parentElement.remove()">×</button>
        `;

        this.alertContainer.appendChild(alert);

        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (alert.parentElement) {
                alert.remove();
            }
        }, 5000);
    }

    getAlertIcon(type) {
        switch (type) {
            case 'success': return '✓';
            case 'warning': return '⚠';
            case 'error': return '✗';
            default: return 'ℹ';
        }
    }

    formatCurrency(amount) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(amount);
    }

    exportToExcel() {
        // Implementation for exporting to Excel
        this.showAlert('Export functionality will be implemented soon.', 'info');
    }

    loadInitialData() {
        // Load initial data like payment history
        this.loadPaymentHistory();
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.doctorAdvancePaymentManager = new DoctorAdvancePaymentManager();
});

// Global functions for onclick handlers
function viewPayment(paymentId) {
    // Implementation for viewing payment details
    console.log('Viewing payment:', paymentId);
}

// Sidebar navigation functions
function toggleSidebar() {
    const mainContainer = document.querySelector('.main-container-with-sidebar');
    if (mainContainer) {
        mainContainer.classList.toggle('sidebar-collapsed');
    }
}

function showDoctorSearch() {
    // Show doctor search section
    document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
    event.target.closest('.nav-link').classList.add('active');
    
    // Show doctor search form, hide payment entry form and history
    const doctorSearchForm = document.querySelector('#doctorSearchForm').closest('table');
    const paymentEntryForm = document.querySelector('#paymentEntryForm').closest('table');
    const paymentHistory = document.querySelector('.payment-history-section');
    
    if (doctorSearchForm) doctorSearchForm.style.display = 'table';
    if (paymentEntryForm) paymentEntryForm.style.display = 'none';
    if (paymentHistory) paymentHistory.style.display = 'none';
    
    console.log('Showing doctor search section');
}

function showPaymentEntry() {
    // Show payment entry section
    document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
    event.target.closest('.nav-link').classList.add('active');
    
    // Show payment entry form, hide doctor search form and history
    const doctorSearchForm = document.querySelector('#doctorSearchForm').closest('table');
    const paymentEntryForm = document.querySelector('#paymentEntryForm').closest('table');
    const paymentHistory = document.querySelector('.payment-history-section');
    
    if (doctorSearchForm) doctorSearchForm.style.display = 'none';
    if (paymentEntryForm) paymentEntryForm.style.display = 'table';
    if (paymentHistory) paymentHistory.style.display = 'none';
    
    console.log('Showing payment entry section');
}

function showPaymentHistory() {
    // Show payment history section
    document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
    event.target.closest('.nav-link').classList.add('active');
    
    // Show payment history, hide forms
    const doctorSearchForm = document.querySelector('#doctorSearchForm').closest('table');
    const paymentEntryForm = document.querySelector('#paymentEntryForm').closest('table');
    const paymentHistory = document.querySelector('.payment-history-section');
    
    if (doctorSearchForm) doctorSearchForm.style.display = 'none';
    if (paymentEntryForm) paymentEntryForm.style.display = 'none';
    if (paymentHistory) paymentHistory.style.display = 'block';
    
    // Load payment history data
    if (window.doctorAdvancePaymentManager) {
        window.doctorAdvancePaymentManager.loadPaymentHistory();
    }
    
    console.log('Showing payment history section');
}

function showReports() {
    // Show reports section
    document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
    event.target.closest('.nav-link').classList.add('active');
    
    // Hide all other sections
    const doctorSearchForm = document.querySelector('#doctorSearchForm').closest('table');
    const paymentEntryForm = document.querySelector('#paymentEntryForm').closest('table');
    const paymentHistory = document.querySelector('.payment-history-section');
    
    if (doctorSearchForm) doctorSearchForm.style.display = 'none';
    if (paymentEntryForm) paymentEntryForm.style.display = 'none';
    if (paymentHistory) paymentHistory.style.display = 'none';
    
    // Show reports content (placeholder for now)
    console.log('Showing reports section');
}

function editPayment(paymentId) {
    // Implementation for editing payment
    console.log('Editing payment:', paymentId);
}

function deletePayment(paymentId) {
    if (confirm('Are you sure you want to delete this payment?')) {
        // Implementation for deleting payment
        console.log('Deleting payment:', paymentId);
    }
}

// Utility functions
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}
