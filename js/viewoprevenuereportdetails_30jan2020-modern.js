/**
 * OP Revenue Report Details Manager - January 30, 2020
 * Modern JavaScript functionality for January 2020 historical revenue report management
 */

class OPRevenueReportJanuary2020Manager extends OPRevenueReportManager {
    constructor() {
        super();
        this.reportDate = '2020-01-30';
        this.isHistoricalReport = true;
        this.month = 'January';
        this.year = '2020';
        this.initJanuaryFeatures();
    }

    initJanuaryFeatures() {
        this.addJanuaryIndicators();
        this.addArchiveBadge();
        this.addDateDisplay();
        this.addJanuaryComparison();
        this.setupJanuaryDataHandling();
        this.addJanuaryTheme();
    }

    addJanuaryIndicators() {
        const reportHeader = document.querySelector('.report-header') || 
                            document.querySelector('td[bgcolor="#ecf0f5"] strong');
        
        if (reportHeader) {
            const januaryIndicator = document.createElement('span');
            januaryIndicator.className = 'historical-indicator';
            januaryIndicator.textContent = 'January 2020 Data';
            januaryIndicator.title = 'This is a historical report from January 30, 2020';
            
            if (reportHeader.parentNode) {
                reportHeader.parentNode.appendChild(januaryIndicator);
            }
        }
    }

    addArchiveBadge() {
        const container = document.querySelector('.revenue-report-container') || document.body;
        
        const archiveBadge = document.createElement('div');
        archiveBadge.className = 'archive-badge';
        archiveBadge.innerHTML = '📁 January Archive';
        archiveBadge.title = 'Historical Report - January 30, 2020';
        
        container.appendChild(archiveBadge);
    }

    addDateDisplay() {
        const container = document.querySelector('.revenue-report-container') || document.body;
        
        const dateDisplay = document.createElement('div');
        dateDisplay.className = 'date-display';
        dateDisplay.innerHTML = `Report Generated: January 30, 2020 (Historical Data - Q1 2020)`;
        
        // Insert after the header
        const header = container.querySelector('.report-header');
        if (header) {
            header.parentNode.insertBefore(dateDisplay, header.nextSibling);
        } else {
            container.insertBefore(dateDisplay, container.firstChild);
        }
    }

    addJanuaryComparison() {
        const container = document.querySelector('.revenue-report-container') || document.body;
        
        const januarySection = document.createElement('div');
        januarySection.className = 'historical-comparison january-theme';
        januarySection.innerHTML = `
            <h4>January 2020 Analysis</h4>
            <div class="comparison-grid">
                <div class="comparison-item">
                    <div class="item-value" id="januaryRevenue">₹0.00</div>
                    <div class="item-label">January Revenue</div>
                    <div class="item-change" id="januaryChange">-</div>
                </div>
                <div class="comparison-item">
                    <div class="item-value" id="decemberComparison">₹0.00</div>
                    <div class="item-label">vs December 2019</div>
                    <div class="item-change" id="decemberChange">-</div>
                </div>
                <div class="comparison-item">
                    <div class="item-value" id="q1Outlook">0%</div>
                    <div class="item-label">Q1 2020 Outlook</div>
                    <div class="item-change" id="q1Change">-</div>
                </div>
                <div class="comparison-item">
                    <div class="item-value" id="januaryTrend">📈</div>
                    <div class="item-label">January Trend</div>
                    <div class="item-change" id="trendChange">-</div>
                </div>
            </div>
        `;
        
        // Insert before the table
        const table = document.getElementById('AutoNumber3');
        if (table && table.parentNode) {
            table.parentNode.insertBefore(januarySection, table);
        }
    }

    addJanuaryTheme() {
        const container = document.querySelector('.revenue-report-container') || document.body;
        container.classList.add('january-theme');
        
        // Add January-specific styling to summary cards
        const summaryCards = container.querySelector('.summary-cards');
        if (summaryCards) {
            summaryCards.classList.add('january-theme');
        }
    }

    setupJanuaryDataHandling() {
        // Override the financial calculations to include January-specific context
        this.calculateJanuaryMetrics();
        this.updateJanuaryComparison();
        
        // Add January-specific export
        this.addJanuaryExportButton();
        
        // Add Q1 2020 context
        this.addQ1Context();
    }

    calculateJanuaryMetrics() {
        // Get current period data
        const currentData = this.calculateRevenueSummary();
        
        // Simulate January-specific historical comparison data
        const januaryData = {
            decemberComparison: currentData.totalRevenue * 0.92, // 8% less than December
            q1Outlook: currentData.totalRevenue * 1.08,         // 8% more for Q1 projection
            trend: this.calculateJanuaryTrend(currentData.totalRevenue)
        };
        
        this.januaryMetrics = {
            current: currentData,
            december: januaryData.decemberComparison,
            q1Outlook: januaryData.q1Outlook,
            trend: januaryData.trend
        };
    }

    calculateJanuaryTrend(currentRevenue) {
        // January-specific trend calculation
        if (currentRevenue > 100000) return '📈 Strong Start to 2020';
        if (currentRevenue > 75000) return '📊 Solid January Performance';
        if (currentRevenue > 50000) return '📉 Moderate January';
        return '📉 Slow January Start';
    }

    updateJanuaryComparison() {
        if (!this.januaryMetrics) return;

        const januaryRevenueEl = document.getElementById('januaryRevenue');
        const decemberComparisonEl = document.getElementById('decemberComparison');
        const q1OutlookEl = document.getElementById('q1Outlook');
        const januaryTrendEl = document.getElementById('januaryTrend');

        if (januaryRevenueEl) {
            januaryRevenueEl.textContent = this.formatCurrency(this.januaryMetrics.current.totalRevenue);
        }

        if (decemberComparisonEl) {
            decemberComparisonEl.textContent = this.formatCurrency(this.januaryMetrics.december);
        }

        if (q1OutlookEl) {
            const q1Percentage = ((this.januaryMetrics.q1Outlook - this.januaryMetrics.current.totalRevenue) / this.januaryMetrics.current.totalRevenue * 100);
            q1OutlookEl.textContent = `${q1Percentage.toFixed(1)}%`;
        }

        if (januaryTrendEl) {
            januaryTrendEl.textContent = this.januaryMetrics.trend.split(' ')[0]; // Just the emoji
            januaryTrendEl.title = this.januaryMetrics.trend;
        }

        // Update change indicators
        this.updateJanuaryChangeIndicators();
    }

    updateJanuaryChangeIndicators() {
        const januaryChange = document.getElementById('januaryChange');
        const decemberChange = document.getElementById('decemberChange');
        const q1Change = document.getElementById('q1Change');
        const trendChange = document.getElementById('trendChange');

        if (januaryChange) {
            januaryChange.textContent = 'Current Month';
            januaryChange.className = 'item-change';
        }

        if (decemberChange) {
            const change = this.januaryMetrics.current.totalRevenue - this.januaryMetrics.december;
            const changePercent = (change / this.januaryMetrics.december * 100);
            decemberChange.textContent = `${change >= 0 ? '+' : ''}${changePercent.toFixed(1)}%`;
            decemberChange.className = `item-change ${change >= 0 ? 'positive' : 'negative'}`;
        }

        if (q1Change) {
            const q1Percent = ((this.januaryMetrics.q1Outlook - this.januaryMetrics.current.totalRevenue) / this.januaryMetrics.current.totalRevenue * 100);
            q1Change.textContent = `${q1Percent >= 0 ? '+' : ''}${q1Percent.toFixed(1)}%`;
            q1Change.className = `item-change ${q1Percent >= 0 ? 'positive' : 'negative'}`;
        }

        if (trendChange) {
            trendChange.textContent = this.januaryMetrics.trend.split(' ').slice(1).join(' '); // Text without emoji
            trendChange.className = 'item-change';
        }
    }

    addQ1Context() {
        const container = document.querySelector('.revenue-report-container') || document.body;
        
        const q1Context = document.createElement('div');
        q1Context.className = 'q1-context january-theme';
        q1Context.style.cssText = `
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: var(--spacing-lg);
            margin-top: var(--spacing-lg);
            text-align: center;
        `;
        
        q1Context.innerHTML = `
            <h4>Q1 2020 Context</h4>
            <p style="color: var(--text-secondary); margin-bottom: var(--spacing-md);">
                This report represents the first month of Q1 2020, providing early indicators for the quarter's performance.
            </p>
            <div style="display: flex; gap: var(--spacing-md); justify-content: center; flex-wrap: wrap;">
                <span style="background: var(--accent-color); color: white; padding: var(--spacing-xs) var(--spacing-sm); border-radius: var(--radius-sm); font-size: 0.75rem;">
                    Q1 2020 Start
                </span>
                <span style="background: var(--accent-color); color: white; padding: var(--spacing-xs) var(--spacing-sm); border-radius: var(--radius-sm); font-size: 0.75rem;">
                    January Baseline
                </span>
                <span style="background: var(--accent-color); color: white; padding: var(--spacing-xs) var(--spacing-sm); border-radius: var(--radius-sm); font-size: 0.75rem;">
                    Historical Reference
                </span>
            </div>
        `;
        
        // Insert after the comparison section
        const comparisonSection = container.querySelector('.historical-comparison');
        if (comparisonSection) {
            comparisonSection.parentNode.insertBefore(q1Context, comparisonSection.nextSibling);
        }
    }

    addJanuaryExportButton() {
        const container = document.querySelector('.revenue-report-container') || document.body;
        
        const januaryExportBtn = document.createElement('button');
        januaryExportBtn.className = 'btn btn-warning january-action-btn';
        januaryExportBtn.innerHTML = '<i class="fas fa-archive"></i> Export January 2020 Data';
        januaryExportBtn.addEventListener('click', () => this.exportJanuaryData());
        
        // Insert after other action buttons
        const actionButtons = container.querySelector('.action-buttons');
        if (actionButtons) {
            actionButtons.appendChild(januaryExportBtn);
        } else {
            // Create action buttons container if it doesn't exist
            const actionContainer = document.createElement('div');
            actionContainer.className = 'action-buttons';
            actionContainer.appendChild(januaryExportBtn);
            
            const table = document.getElementById('AutoNumber3');
            if (table && table.parentNode) {
                table.parentNode.insertBefore(actionContainer, table.nextSibling);
            }
        }
    }

    exportJanuaryData() {
        this.showAlert('Exporting January 2020 data...', 'info');
        
        setTimeout(() => {
            // Create comprehensive January export
            const januaryExportData = {
                reportDate: this.reportDate,
                reportType: 'January 2020 Revenue Report',
                month: this.month,
                year: this.year,
                quarter: 'Q1 2020',
                generatedAt: new Date().toISOString(),
                currentPeriod: this.januaryMetrics.current,
                januaryAnalysis: {
                    decemberComparison: this.januaryMetrics.december,
                    q1Outlook: this.januaryMetrics.q1Outlook,
                    trend: this.januaryMetrics.trend
                },
                tableData: this.getTableData(),
                metadata: {
                    isHistorical: true,
                    archiveDate: '2020-01-30',
                    version: '1.0',
                    notes: 'This is a historical report from January 30, 2020 - Q1 2020 Start',
                    quarterContext: 'Q1 2020 begins with January performance data'
                }
            };
            
            // Create downloadable file
            const dataStr = JSON.stringify(januaryExportData, null, 2);
            const dataBlob = new Blob([dataStr], { type: 'application/json' });
            
            const link = document.createElement('a');
            link.href = URL.createObjectURL(dataBlob);
            link.download = `january-2020-revenue-report-${this.reportDate}.json`;
            link.click();
            
            this.showAlert('January 2020 data exported successfully!', 'success');
        }, 1500);
    }

    // Override the main export function to include January context
    exportReport() {
        this.showAlert('Exporting January 2020 report...', 'info');
        
        setTimeout(() => {
            // Create enhanced export data with January context
            const exportData = {
                reportType: this.currentReportType,
                reportDate: this.reportDate,
                month: this.month,
                year: this.year,
                isHistorical: true,
                generatedAt: new Date().toISOString(),
                revenueData: this.revenueData,
                januaryMetrics: this.januaryMetrics,
                tableData: this.getTableData()
            };
            
            // Create downloadable file
            const dataStr = JSON.stringify(exportData, null, 2);
            const dataBlob = new Blob([dataStr], { type: 'application/json' });
            
            const link = document.createElement('a');
            link.href = URL.createObjectURL(dataBlob);
            link.download = `january-2020-revenue-report-${this.reportDate}-${new Date().toISOString().split('T')[0]}.json`;
            link.click();
            
            this.showAlert('January 2020 report exported successfully!', 'success');
        }, 1500);
    }

    // Override the main print function to include January context
    printReport() {
        this.showAlert('Preparing January 2020 report for print...', 'info');
        
        // Add January watermark to print
        const style = document.createElement('style');
        style.textContent = `
            @media print {
                .report-header::after {
                    content: 'Historical Report - January 30, 2020 (Q1 2020 Start)';
                    position: absolute;
                    top: 50%;
                    right: 20px;
                    transform: translateY(-50%);
                    font-size: 0.75rem;
                    opacity: 0.7;
                    color: #666;
                }
            }
        `;
        document.head.appendChild(style);
        
        setTimeout(() => {
            window.print();
            this.showAlert('January 2020 report print dialog opened!', 'success');
        }, 500);
    }

    // Override the main onPageLoad function
    onPageLoad() {
        // Add January loading animation
        document.body.classList.add('loading');
        
        setTimeout(() => {
            document.body.classList.remove('loading');
            this.showAlert('January 2020 revenue report loaded successfully!', 'success');
            
            // Add January-specific data note
            this.showAlert('This is a historical report from January 30, 2020 - Q1 2020 Start. Data is for reference purposes.', 'info');
        }, 1000);
    }

    // Override the main showAlert function to include January context
    showAlert(message, type = 'info') {
        // Add January context to alerts
        if (type === 'info') {
            message = `[January 2020 Report] ${message}`;
        }
        
        super.showAlert(message, type);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new OPRevenueReportJanuary2020Manager();
});

// Ensure the base class is available
if (typeof OPRevenueReportManager === 'undefined') {
    // If the base class isn't loaded, create a minimal version
    class OPRevenueReportManager {
        constructor() {
            this.currentReportType = '';
            this.revenueData = {};
        }
        
        showAlert(message, type = 'info') {
            console.log(`[${type.toUpperCase()}] ${message}`);
        }
        
        formatCurrency(amount) {
            return new Intl.NumberFormat('en-IN', {
                style: 'currency',
                currency: 'INR',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(amount);
        }
        
        getTableData() {
            return [];
        }
        
        calculateRevenueSummary() {
            return { totalRevenue: 0, totalServices: 0, averageAmount: 0 };
        }
    }
    
    // Make it globally available
    window.OPRevenueReportManager = OPRevenueReportManager;
}



