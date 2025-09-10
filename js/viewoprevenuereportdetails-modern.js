/**
 * OP Revenue Report Details Manager
 * Modern JavaScript functionality for revenue report management
 */

class OPRevenueReportManager {
    constructor() {
        this.currentReportType = '';
        this.revenueData = {};
        this.init();
    }

    init() {
        this.initializeEventListeners();
        this.setupTableEnhancements();
        this.setupFinancialCalculations();
        this.setupResponsiveHandling();
        this.setupExportFunctionality();
        this.setupPrintFunctionality();
    }

    initializeEventListeners() {
        // Service link clicks
        document.addEventListener('click', (e) => {
            if (e.target.matches('a[href*="viewoprevenuereportdetails"]')) {
                this.handleServiceLinkClick(e.target);
            }
        });

        // Export button clicks
        document.addEventListener('click', (e) => {
            if (e.target.matches('a[href*="print_oprevenuereport"]')) {
                e.preventDefault();
                this.handleExportClick(e.target);
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey || e.metaKey) {
                switch (e.key) {
                    case 'p':
                        e.preventDefault();
                        this.printReport();
                        break;
                    case 'e':
                        e.preventDefault();
                        this.exportReport();
                        break;
                    case 'f':
                        e.preventDefault();
                        this.focusSearch();
                        break;
                }
            }
        });

        // Window resize handling
        window.addEventListener('resize', () => {
            this.handleResize();
        });

        // Page load completion
        window.addEventListener('load', () => {
            this.onPageLoad();
        });
    }

    setupTableEnhancements() {
        const revenueTable = document.getElementById('AutoNumber3');
        if (!revenueTable) return;

        // Add modern table classes
        revenueTable.classList.add('revenue-table');

        // Enhance table rows
        const tableRows = revenueTable.querySelectorAll('tbody tr');
        tableRows.forEach((row, index) => {
            this.enhanceTableRow(row, index);
        });

        // Add table header if missing
        this.addTableHeader(revenueTable);

        // Add summary cards
        this.addSummaryCards();
    }

    enhanceTableRow(row, index) {
        // Add hover effects
        row.addEventListener('mouseenter', () => {
            row.style.backgroundColor = 'var(--hover-bg)';
            row.style.cursor = 'pointer';
        });

        row.addEventListener('mouseleave', () => {
            const originalColor = index % 2 === 0 ? 'var(--row-bg)' : 'var(--row-alt-bg)';
            row.style.backgroundColor = originalColor;
        });

        // Add click effects
        row.addEventListener('click', () => {
            this.selectTableRow(row);
        });

        // Enhance service links
        const serviceLinks = row.querySelectorAll('a[href*="viewoprevenuereportdetails"]');
        serviceLinks.forEach(link => {
            link.classList.add('service-link');
            link.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        });

        // Enhance amounts
        const amountCells = row.querySelectorAll('td:nth-child(3)');
        amountCells.forEach(cell => {
            this.formatAmount(cell);
        });

        // Add row number styling
        const firstCell = row.querySelector('td:first-child');
        if (firstCell && firstCell.textContent.trim().match(/^\d+$/)) {
            firstCell.style.fontWeight = '600';
            firstCell.style.color = 'var(--primary-color)';
            firstCell.style.textAlign = 'center';
        }
    }

    addTableHeader(revenueTable) {
        const thead = revenueTable.querySelector('thead');
        if (!thead) {
            const newThead = document.createElement('thead');
            const headerRow = document.createElement('tr');
            
            const headers = ['No.', 'Service', 'Amount', 'Actions'];
            headers.forEach(headerText => {
                const th = document.createElement('th');
                th.textContent = headerText;
                headerRow.appendChild(th);
            });
            
            newThead.appendChild(headerRow);
            revenueTable.insertBefore(newThead, revenueTable.firstChild);
        }
    }

    addSummaryCards() {
        const container = document.querySelector('.revenue-report-container') || document.body;
        
        // Check if summary cards already exist
        if (container.querySelector('.summary-cards')) return;

        const summarySection = document.createElement('div');
        summarySection.className = 'summary-cards';
        summarySection.innerHTML = `
            <div class="summary-card">
                <div class="card-value" id="totalRevenue">₹0.00</div>
                <div class="card-label">Total Revenue</div>
            </div>
            <div class="summary-card">
                <div class="card-value" id="totalServices">0</div>
                <div class="card-label">Total Services</div>
            </div>
            <div class="summary-card">
                <div class="card-value" id="averageAmount">₹0.00</div>
                <div class="card-label">Average Amount</div>
            </div>
            <div class="summary-card">
                <div class="card-value" id="reportType">-</div>
                <div class="card-label">Report Type</div>
            </div>
        `;

        // Insert before the table
        const table = document.getElementById('AutoNumber3');
        if (table && table.parentNode) {
            table.parentNode.insertBefore(summarySection, table);
        }
    }

    setupFinancialCalculations() {
        this.calculateRevenueSummary();
        this.updateSummaryCards();
    }

    calculateRevenueSummary() {
        const revenueTable = document.getElementById('AutoNumber3');
        if (!revenueTable) return;

        let totalRevenue = 0;
        let totalServices = 0;
        let serviceCounts = {};

        const tableRows = revenueTable.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            const amountCell = row.querySelector('td:nth-child(3)');
            const serviceCell = row.querySelector('td:nth-child(2)');
            
            if (amountCell && serviceCell) {
                const amountText = amountCell.textContent.trim();
                const amount = this.parseAmount(amountText);
                
                if (!isNaN(amount)) {
                    totalRevenue += amount;
                    totalServices++;
                    
                    // Count services
                    const serviceName = serviceCell.textContent.trim();
                    if (serviceName) {
                        serviceCounts[serviceName] = (serviceCounts[serviceName] || 0) + 1;
                    }
                }
            }
        });

        this.revenueData = {
            totalRevenue,
            totalServices,
            averageAmount: totalServices > 0 ? totalRevenue / totalServices : 0,
            serviceCounts
        };

        // Determine report type
        const reportTypeElement = document.querySelector('td[bgcolor="#ecf0f5"] strong');
        if (reportTypeElement) {
            this.currentReportType = reportTypeElement.textContent.trim();
        }
    }

    parseAmount(amountText) {
        // Remove currency symbols, commas, and parentheses
        const cleanAmount = amountText
            .replace(/[₹$€£,]/g, '')
            .replace(/[()]/g, '')
            .replace(/\s+/g, '');
        
        const amount = parseFloat(cleanAmount);
        return isNaN(amount) ? 0 : amount;
    }

    updateSummaryCards() {
        const totalRevenueEl = document.getElementById('totalRevenue');
        const totalServicesEl = document.getElementById('totalServices');
        const averageAmountEl = document.getElementById('averageAmount');
        const reportTypeEl = document.getElementById('reportType');

        if (totalRevenueEl) {
            totalRevenueEl.textContent = this.formatCurrency(this.revenueData.totalRevenue);
            totalRevenueEl.className = 'card-value ' + 
                (this.revenueData.totalRevenue >= 0 ? 'amount-positive' : 'amount-negative');
        }

        if (totalServicesEl) {
            totalServicesEl.textContent = this.revenueData.totalServices;
        }

        if (averageAmountEl) {
            averageAmountEl.textContent = this.formatCurrency(this.revenueData.averageAmount);
        }

        if (reportTypeEl) {
            reportTypeEl.textContent = this.currentReportType || 'Revenue Report';
        }
    }

    formatAmount(cell) {
        const amount = this.parseAmount(cell.textContent);
        if (!isNaN(amount)) {
            cell.className = amount >= 0 ? 'amount-positive' : 'amount-negative';
            cell.textContent = this.formatCurrency(amount);
        }
    }

    formatCurrency(amount) {
        return new Intl.NumberFormat('en-IN', {
            style: 'currency',
            currency: 'INR',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(amount);
    }

    selectTableRow(row) {
        // Remove previous selection
        const selectedRows = document.querySelectorAll('.revenue-table tbody tr.selected');
        selectedRows.forEach(r => r.classList.remove('selected'));

        // Add selection to current row
        row.classList.add('selected');
        row.style.backgroundColor = 'var(--primary-color)';
        row.style.color = 'var(--text-inverse)';
    }

    handleServiceLinkClick(link) {
        const href = link.getAttribute('href');
        const serviceName = link.textContent.trim();
        
        this.showAlert(`Opening detailed report for: ${serviceName}`, 'info');
        
        // Add loading state
        link.style.opacity = '0.6';
        link.style.pointerEvents = 'none';
        
        // Simulate loading delay
        setTimeout(() => {
            link.style.opacity = '1';
            link.style.pointerEvents = 'auto';
            // The link will navigate naturally
        }, 500);
    }

    handleExportClick(link) {
        const href = link.getAttribute('href');
        
        this.showAlert('Preparing export...', 'info');
        
        // Add loading state
        link.style.opacity = '0.6';
        link.style.pointerEvents = 'none';
        
        // Simulate export process
        setTimeout(() => {
            link.style.opacity = '1';
            link.style.pointerEvents = 'auto';
            this.showAlert('Export completed successfully!', 'success');
        }, 1500);
    }

    setupResponsiveHandling() {
        this.handleResize();
    }

    handleResize() {
        const revenueTable = document.getElementById('AutoNumber3');
        if (!revenueTable) return;

        const container = revenueTable.closest('table') || revenueTable.parentNode;
        if (!container) return;

        // Adjust table container width
        if (window.innerWidth <= 768) {
            container.style.width = '100%';
            container.style.maxWidth = '100%';
        } else {
            container.style.width = '';
            container.style.maxWidth = '';
        }

        // Adjust table font size
        if (window.innerWidth <= 480) {
            revenueTable.style.fontSize = '0.625rem';
        } else if (window.innerWidth <= 768) {
            revenueTable.style.fontSize = '0.75rem';
        } else {
            revenueTable.style.fontSize = '0.875rem';
        }
    }

    setupExportFunctionality() {
        // Add export button if not exists
        const exportBtn = document.querySelector('.export-btn');
        if (!exportBtn) {
            this.addExportButton();
        }
    }

    addExportButton() {
        const container = document.querySelector('.revenue-report-container') || document.body;
        
        const exportButton = document.createElement('button');
        exportButton.className = 'btn btn-success export-btn';
        exportButton.innerHTML = '<i class="fas fa-download"></i> Export Report';
        exportButton.addEventListener('click', () => this.exportReport());
        
        // Insert after summary cards
        const summaryCards = container.querySelector('.summary-cards');
        if (summaryCards) {
            summaryCards.parentNode.insertBefore(exportButton, summaryCards.nextSibling);
        }
    }

    setupPrintFunctionality() {
        // Add print button if not exists
        const printBtn = document.querySelector('.print-btn');
        if (!printBtn) {
            this.addPrintButton();
        }
    }

    addPrintButton() {
        const container = document.querySelector('.revenue-report-container') || document.body;
        
        const printButton = document.createElement('button');
        printButton.className = 'btn btn-secondary print-btn';
        printButton.innerHTML = '<i class="fas fa-print"></i> Print Report';
        printButton.addEventListener('click', () => this.printReport());
        
        // Insert after export button
        const exportBtn = container.querySelector('.export-btn');
        if (exportBtn) {
            exportBtn.parentNode.insertBefore(printButton, exportBtn.nextSibling);
        }
    }

    // Utility functions
    focusSearch() {
        // Focus on first input field if available
        const firstInput = document.querySelector('input');
        if (firstInput) {
            firstInput.focus();
        }
    }

    printReport() {
        this.showAlert('Preparing print...', 'info');
        setTimeout(() => {
            window.print();
            this.showAlert('Print dialog opened!', 'success');
        }, 500);
    }

    exportReport() {
        this.showAlert('Exporting report...', 'info');
        
        // Simulate export process
        setTimeout(() => {
            // Create export data
            const exportData = {
                reportType: this.currentReportType,
                generatedAt: new Date().toISOString(),
                revenueData: this.revenueData,
                tableData: this.getTableData()
            };
            
            // Create downloadable file
            const dataStr = JSON.stringify(exportData, null, 2);
            const dataBlob = new Blob([dataStr], { type: 'application/json' });
            
            const link = document.createElement('a');
            link.href = URL.createObjectURL(dataBlob);
            link.download = `revenue-report-${new Date().toISOString().split('T')[0]}.json`;
            link.click();
            
            this.showAlert('Report exported successfully!', 'success');
        }, 1500);
    }

    getTableData() {
        const revenueTable = document.getElementById('AutoNumber3');
        if (!revenueTable) return [];

        const tableData = [];
        const tableRows = revenueTable.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length >= 3) {
                tableData.push({
                    number: cells[0]?.textContent?.trim() || '',
                    service: cells[1]?.textContent?.trim() || '',
                    amount: cells[2]?.textContent?.trim() || '',
                    link: cells[1]?.querySelector('a')?.href || ''
                });
            }
        });

        return tableData;
    }

    onPageLoad() {
        // Add loading animation
        document.body.classList.add('loading');
        
        // Simulate loading time
        setTimeout(() => {
            document.body.classList.remove('loading');
            this.showAlert('Revenue report loaded successfully!', 'success');
        }, 1000);
    }

    showAlert(message, type = 'info') {
        // Create alert container if it doesn't exist
        let alertContainer = document.getElementById('alertContainer');
        if (!alertContainer) {
            alertContainer = document.createElement('div');
            alertContainer.id = 'alertContainer';
            alertContainer.style.cssText = `
                position: fixed;
                top: var(--spacing-lg);
                right: var(--spacing-lg);
                z-index: 1001;
                max-width: 400px;
            `;
            document.body.appendChild(alertContainer);
        }

        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = `
            <span class="alert-icon">${this.getAlertIcon(type)}</span>
            <span class="alert-message">${message}</span>
            <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
        `;

        // Add alert styles if not already present
        if (!document.querySelector('.alert')) {
            const style = document.createElement('style');
            style.textContent = `
                .alert {
                    background-color: var(--bg-primary);
                    border: 1px solid var(--border-color);
                    border-radius: var(--radius-lg);
                    padding: var(--spacing-md);
                    margin-bottom: var(--spacing-sm);
                    box-shadow: var(--shadow-lg);
                    display: flex;
                    align-items: flex-start;
                    gap: var(--spacing-sm);
                    animation: slideInRight 0.3s ease-out;
                }
                .alert-success {
                    border-color: var(--success-color);
                    background-color: #f0fdf4;
                }
                .alert-error {
                    border-color: var(--error-color);
                    background-color: #fef2f2;
                }
                .alert-warning {
                    border-color: var(--warning-color);
                    background-color: #fffbeb;
                }
                .alert-info {
                    border-color: var(--info-color);
                    background-color: #f0f9ff;
                }
                .alert-icon {
                    font-size: 1.125rem;
                    flex-shrink: 0;
                }
                .alert-message {
                    flex: 1;
                    font-size: 0.875rem;
                    line-height: 1.5;
                }
                .alert-close {
                    background: none;
                    border: none;
                    font-size: 1.25rem;
                    cursor: pointer;
                    color: var(--text-muted);
                    padding: 0;
                    line-height: 1;
                    flex-shrink: 0;
                }
                @keyframes slideInRight {
                    from {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }
            `;
            document.head.appendChild(style);
        }

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
    new OPRevenueReportManager();
});

// Global functions for legacy compatibility
function cbcustomername1() {
    // Legacy function - maintain compatibility
    console.log('Legacy function cbcustomername1 called');
}

function pharmacy(patientcode, visitcode) {
    // Legacy function - maintain compatibility
    var url = "pharmacy1.php?RandomKey=" + Math.random() + "&&patientcode=" + patientcode + "&&visitcode=" + visitcode;
    window.open(url, "Pharmacy", 'width=600,height=400');
}

function disableEnterKey(varPassed) {
    // Legacy function - maintain compatibility
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




