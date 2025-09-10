/**
 * OP Revenue Report Details Manager - March 13, 2020
 * Modern JavaScript functionality for historical revenue report management
 */

class OPRevenueReportMarch2020Manager extends OPRevenueReportManager {
    constructor() {
        super();
        this.reportDate = '2020-03-13';
        this.isHistoricalReport = true;
        this.initHistoricalFeatures();
    }

    initHistoricalFeatures() {
        this.addHistoricalIndicators();
        this.addArchiveBadge();
        this.addDateDisplay();
        this.addHistoricalComparison();
        this.setupHistoricalDataHandling();
    }

    addHistoricalIndicators() {
        const reportHeader = document.querySelector('.report-header') || 
                            document.querySelector('td[bgcolor="#ecf0f5"] strong');
        
        if (reportHeader) {
            const historicalIndicator = document.createElement('span');
            historicalIndicator.className = 'historical-indicator';
            historicalIndicator.textContent = 'Historical Data';
            historicalIndicator.title = 'This is a historical report from March 13, 2020';
            
            if (reportHeader.parentNode) {
                reportHeader.parentNode.appendChild(historicalIndicator);
            }
        }
    }

    addArchiveBadge() {
        const container = document.querySelector('.revenue-report-container') || document.body;
        
        const archiveBadge = document.createElement('div');
        archiveBadge.className = 'archive-badge';
        archiveBadge.innerHTML = '📁 Archive';
        archiveBadge.title = 'Historical Report - March 13, 2020';
        
        container.appendChild(archiveBadge);
    }

    addDateDisplay() {
        const container = document.querySelector('.revenue-report-container') || document.body;
        
        const dateDisplay = document.createElement('div');
        dateDisplay.className = 'date-display';
        dateDisplay.innerHTML = `Report Generated: March 13, 2020 (Historical Data)`;
        
        // Insert after the header
        const header = container.querySelector('.report-header');
        if (header) {
            header.parentNode.insertBefore(dateDisplay, header.nextSibling);
        } else {
            container.insertBefore(dateDisplay, container.firstChild);
        }
    }

    addHistoricalComparison() {
        const container = document.querySelector('.revenue-report-container') || document.body;
        
        const historicalSection = document.createElement('div');
        historicalSection.className = 'historical-comparison';
        historicalSection.innerHTML = `
            <h4>Historical Comparison</h4>
            <div class="comparison-grid">
                <div class="comparison-item">
                    <div class="item-value" id="currentPeriod">₹0.00</div>
                    <div class="item-label">Current Period</div>
                    <div class="item-change" id="currentChange">-</div>
                </div>
                <div class="comparison-item">
                    <div class="item-value" id="previousPeriod">₹0.00</div>
                    <div class="item-label">Previous Period</div>
                    <div class="item-change" id="previousChange">-</div>
                </div>
                <div class="comparison-item">
                    <div class="item-value" id="yearOverYear">0%</div>
                    <div class="item-label">Year over Year</div>
                    <div class="item-change" id="yoyChange">-</div>
                </div>
                <div class="comparison-item">
                    <div class="item-value" id="trendIndicator">📈</div>
                    <div class="item-label">Trend</div>
                    <div class="item-change" id="trendChange">-</div>
                </div>
            </div>
        `;
        
        // Insert before the table
        const table = document.getElementById('AutoNumber3');
        if (table && table.parentNode) {
            table.parentNode.insertBefore(historicalSection, table);
        }
    }

    setupHistoricalDataHandling() {
        // Override the financial calculations to include historical context
        this.calculateHistoricalMetrics();
        this.updateHistoricalComparison();
        
        // Add historical data export
        this.addHistoricalExportButton();
    }

    calculateHistoricalMetrics() {
        // Get current period data
        const currentData = this.calculateRevenueSummary();
        
        // Simulate historical comparison data (in real implementation, this would come from database)
        const historicalData = {
            previousPeriod: currentData.totalRevenue * 0.95, // 5% less than current
            yearOverYear: currentData.totalRevenue * 1.12,   // 12% more than last year
            trend: this.calculateTrend(currentData.totalRevenue)
        };
        
        this.historicalMetrics = {
            current: currentData,
            previous: historicalData.previousPeriod,
            yoy: historicalData.yearOverYear,
            trend: historicalData.trend
        };
    }

    calculateTrend(currentRevenue) {
        // Simple trend calculation based on revenue amount
        if (currentRevenue > 100000) return '📈 Strong Growth';
        if (currentRevenue > 50000) return '📊 Stable';
        if (currentRevenue > 25000) return '📉 Moderate Decline';
        return '📉 Significant Decline';
    }

    updateHistoricalComparison() {
        if (!this.historicalMetrics) return;

        const currentPeriodEl = document.getElementById('currentPeriod');
        const previousPeriodEl = document.getElementById('previousPeriod');
        const yearOverYearEl = document.getElementById('yearOverYear');
        const trendIndicatorEl = document.getElementById('trendIndicator');

        if (currentPeriodEl) {
            currentPeriodEl.textContent = this.formatCurrency(this.historicalMetrics.current.totalRevenue);
        }

        if (previousPeriodEl) {
            previousPeriodEl.textContent = this.formatCurrency(this.historicalMetrics.previous);
        }

        if (yearOverYearEl) {
            const yoyPercentage = ((this.historicalMetrics.current.totalRevenue - this.historicalMetrics.yoy) / this.historicalMetrics.yoy * 100);
            yearOverYearEl.textContent = `${yoyPercentage.toFixed(1)}%`;
        }

        if (trendIndicatorEl) {
            trendIndicatorEl.textContent = this.historicalMetrics.trend.split(' ')[0]; // Just the emoji
            trendIndicatorEl.title = this.historicalMetrics.trend;
        }

        // Update change indicators
        this.updateChangeIndicators();
    }

    updateChangeIndicators() {
        const currentChange = document.getElementById('currentChange');
        const previousChange = document.getElementById('previousChange');
        const yoyChange = document.getElementById('yoyChange');
        const trendChange = document.getElementById('trendChange');

        if (currentChange) {
            const change = this.historicalMetrics.current.totalRevenue - this.historicalMetrics.previous;
            const changePercent = (change / this.historicalMetrics.previous * 100);
            currentChange.textContent = `${change >= 0 ? '+' : ''}${changePercent.toFixed(1)}%`;
            currentChange.className = `item-change ${change >= 0 ? 'positive' : 'negative'}`;
        }

        if (previousChange) {
            previousChange.textContent = 'Baseline';
            previousChange.className = 'item-change';
        }

        if (yoyChange) {
            const yoyPercent = ((this.historicalMetrics.current.totalRevenue - this.historicalMetrics.yoy) / this.historicalMetrics.yoy * 100);
            yoyChange.textContent = `${yoyPercent >= 0 ? '+' : ''}${yoyPercent.toFixed(1)}%`;
            yoyChange.className = `item-change ${yoyPercent >= 0 ? 'positive' : 'negative'}`;
        }

        if (trendChange) {
            trendChange.textContent = this.historicalMetrics.trend.split(' ').slice(1).join(' '); // Text without emoji
            trendChange.className = 'item-change';
        }
    }

    addHistoricalExportButton() {
        const container = document.querySelector('.revenue-report-container') || document.body;
        
        const historicalExportBtn = document.createElement('button');
        historicalExportBtn.className = 'btn btn-warning historical-export-btn';
        historicalExportBtn.innerHTML = '<i class="fas fa-archive"></i> Export Historical Data';
        historicalExportBtn.addEventListener('click', () => this.exportHistoricalData());
        
        // Insert after other action buttons
        const actionButtons = container.querySelector('.action-buttons');
        if (actionButtons) {
            actionButtons.appendChild(historicalExportBtn);
        } else {
            // Create action buttons container if it doesn't exist
            const actionContainer = document.createElement('div');
            actionContainer.className = 'action-buttons';
            actionContainer.appendChild(historicalExportBtn);
            
            const table = document.getElementById('AutoNumber3');
            if (table && table.parentNode) {
                table.parentNode.insertBefore(actionContainer, table.nextSibling);
            }
        }
    }

    exportHistoricalData() {
        this.showAlert('Exporting historical data...', 'info');
        
        setTimeout(() => {
            // Create comprehensive historical export
            const historicalExportData = {
                reportDate: this.reportDate,
                reportType: 'Historical Revenue Report',
                generatedAt: new Date().toISOString(),
                currentPeriod: this.historicalMetrics.current,
                historicalComparison: {
                    previousPeriod: this.historicalMetrics.previous,
                    yearOverYear: this.historicalMetrics.yoy,
                    trend: this.historicalMetrics.trend
                },
                tableData: this.getTableData(),
                metadata: {
                    isHistorical: true,
                    archiveDate: '2020-03-13',
                    version: '1.0',
                    notes: 'This is a historical report from March 13, 2020'
                }
            };
            
            // Create downloadable file
            const dataStr = JSON.stringify(historicalExportData, null, 2);
            const dataBlob = new Blob([dataStr], { type: 'application/json' });
            
            const link = document.createElement('a');
            link.href = URL.createObjectURL(dataBlob);
            link.download = `historical-revenue-report-${this.reportDate}.json`;
            link.click();
            
            this.showAlert('Historical data exported successfully!', 'success');
        }, 1500);
    }

    // Override the main export function to include historical context
    exportReport() {
        this.showAlert('Exporting historical report...', 'info');
        
        setTimeout(() => {
            // Create enhanced export data with historical context
            const exportData = {
                reportType: this.currentReportType,
                reportDate: this.reportDate,
                isHistorical: true,
                generatedAt: new Date().toISOString(),
                revenueData: this.revenueData,
                historicalMetrics: this.historicalMetrics,
                tableData: this.getTableData()
            };
            
            // Create downloadable file
            const dataStr = JSON.stringify(exportData, null, 2);
            const dataBlob = new Blob([dataStr], { type: 'application/json' });
            
            const link = document.createElement('a');
            link.href = URL.createObjectURL(dataBlob);
            link.download = `historical-revenue-report-${this.reportDate}-${new Date().toISOString().split('T')[0]}.json`;
            link.click();
            
            this.showAlert('Historical report exported successfully!', 'success');
        }, 1500);
    }

    // Override the main print function to include historical context
    printReport() {
        this.showAlert('Preparing historical report for print...', 'info');
        
        // Add historical watermark to print
        const style = document.createElement('style');
        style.textContent = `
            @media print {
                .report-header::after {
                    content: 'Historical Report - March 13, 2020';
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
            this.showAlert('Historical report print dialog opened!', 'success');
        }, 500);
    }

    // Override the main onPageLoad function
    onPageLoad() {
        // Add historical loading animation
        document.body.classList.add('loading');
        
        setTimeout(() => {
            document.body.classList.remove('loading');
            this.showAlert('Historical revenue report loaded successfully!', 'success');
            
            // Add historical data note
            this.showAlert('This is a historical report from March 13, 2020. Data is for reference purposes.', 'info');
        }, 1000);
    }

    // Override the main showAlert function to include historical context
    showAlert(message, type = 'info') {
        // Add historical context to alerts
        if (type === 'info') {
            message = `[Historical Report] ${message}`;
        }
        
        super.showAlert(message, type);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new OPRevenueReportMarch2020Manager();
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
    }
    
    // Make it globally available
    window.OPRevenueReportManager = OPRevenueReportManager;
}




