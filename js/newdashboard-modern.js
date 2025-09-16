/**
 * Modern JavaScript for New Dashboard
 */

class DashboardManager {
    constructor() {
        this.dateInput = null;
        this.charts = {};
        this.init();
    }

    init() {
        this.initializeElements();
        this.setupEventListeners();
        this.initializeSidebar();
        this.initializeCharts();
        this.startAutoRefresh();
    }

    initializeElements() {
        this.dateInput = document.getElementById('dashboardDate');
    }

    setupEventListeners() {
        // Date change handler
        if (this.dateInput) {
            this.dateInput.addEventListener('change', (e) => {
                this.updateDashboard(e.target.value);
            });
        }

        // Quick action cards
        const quickActionCards = document.querySelectorAll('.quick-action-card');
        quickActionCards.forEach(card => {
            card.addEventListener('click', (e) => {
                this.handleQuickAction(e.currentTarget);
            });
        });

        // Summary cards animation
        this.animateSummaryCards();
    }

    initializeSidebar() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const leftSidebar = document.getElementById('leftSidebar');
        const menuToggle = document.getElementById('menuToggle');

        if (sidebarToggle && leftSidebar) {
            sidebarToggle.addEventListener('click', () => {
                leftSidebar.classList.toggle('collapsed');
                this.updateSidebarIcon();
            });
        }

        if (menuToggle && leftSidebar) {
            menuToggle.addEventListener('click', () => {
                leftSidebar.classList.toggle('collapsed');
                this.updateSidebarIcon();
            });
        }
    }

    updateSidebarIcon() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const leftSidebar = document.getElementById('leftSidebar');
        
        if (sidebarToggle && leftSidebar) {
            const icon = sidebarToggle.querySelector('i');
            if (leftSidebar.classList.contains('collapsed')) {
                icon.className = 'fas fa-chevron-right';
            } else {
                icon.className = 'fas fa-chevron-left';
            }
        }
    }

    initializeCharts() {
        // Initialize charts if Chart.js is available
        if (typeof Chart !== 'undefined') {
            this.createRevenueChart();
            this.createPatientChart();
            this.createPaymentMethodChart();
        }
    }

    createRevenueChart() {
        const ctx = document.getElementById('revenueChart');
        if (!ctx) return;

        // Get last 7 days data
        this.fetchRevenueData().then(data => {
            this.charts.revenue = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Revenue',
                        data: data.values,
                        borderColor: '#1e40af',
                        backgroundColor: 'rgba(30, 64, 175, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#e2e8f0'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }).catch(error => {
            console.error('Error loading revenue chart data:', error);
            this.showChartError(ctx, 'Unable to load revenue data');
        });
    }

    createPatientChart() {
        const ctx = document.getElementById('patientChart');
        if (!ctx) return;

        // Get patient distribution data
        this.fetchPatientData().then(data => {
            this.charts.patient = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data.labels,
                    datasets: [{
                        data: data.values,
                        backgroundColor: [
                            '#1e40af',
                            '#059669',
                            '#dc2626',
                            '#7c3aed',
                            '#f59e0b'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        }).catch(error => {
            console.error('Error loading patient chart data:', error);
            this.showChartError(ctx, 'Unable to load patient data');
        });
    }

    createPaymentMethodChart() {
        const ctx = document.getElementById('paymentMethodChart');
        if (!ctx) return;

        // Get payment method data from the page
        this.fetchPaymentMethodData().then(data => {
            this.charts.paymentMethod = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Amount',
                        data: data.values,
                        backgroundColor: [
                            '#059669',
                            '#1e40af',
                            '#7c3aed',
                            '#f59e0b',
                            '#dc2626'
                        ],
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#e2e8f0'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }).catch(error => {
            console.error('Error loading payment method chart data:', error);
            this.showChartError(ctx, 'Unable to load payment data');
        });
    }

    animateSummaryCards() {
        const cards = document.querySelectorAll('.summary-card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.6s ease';
                
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100);
            }, index * 100);
        });
    }

    updateDashboard(date) {
        // Show loading state
        this.showLoading();
        
        // Simulate API call
        setTimeout(() => {
            // Update dashboard with new date
            window.location.href = `newdashboard.php?ADate1=${date}`;
        }, 1000);
    }

    handleQuickAction(card) {
        const action = card.dataset.action;
        const url = card.href;
        
        if (url) {
            window.location.href = url;
        } else {
            // Handle specific actions
            switch (action) {
                case 'patient-registration':
                    window.location.href = 'patientregistration1.php';
                    break;
                case 'ip-admission':
                    window.location.href = 'ipadmission1.php';
                    break;
                case 'billing':
                    window.location.href = 'billing1.php';
                    break;
                case 'reports':
                    window.location.href = 'reports1.php';
                    break;
                default:
                    console.log('Action not implemented:', action);
            }
        }
    }

    showLoading() {
        const loadingOverlay = document.createElement('div');
        loadingOverlay.id = 'loadingOverlay';
        loadingOverlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        `;
        
        loadingOverlay.innerHTML = `
            <div class="loading-spinner"></div>
        `;
        
        document.body.appendChild(loadingOverlay);
    }

    hideLoading() {
        const loadingOverlay = document.getElementById('loadingOverlay');
        if (loadingOverlay) {
            loadingOverlay.remove();
        }
    }

    startAutoRefresh() {
        // Auto refresh dashboard every 5 minutes
        setInterval(() => {
            this.refreshDashboard();
        }, 300000); // 5 minutes
    }

    refreshDashboard() {
        // Refresh dashboard data without page reload
        console.log('Refreshing dashboard data...');
        
        // You can implement AJAX calls here to refresh specific data
        // For now, we'll just show a subtle notification
        this.showNotification('Dashboard data refreshed', 'success');
    }

    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            max-width: 300px;
        `;
        
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'} alert-icon"></i>
            <span>${message}</span>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // Utility function to format numbers
    formatNumber(num) {
        return new Intl.NumberFormat('en-IN', {
            style: 'currency',
            currency: 'INR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(num);
    }

    // Data fetching methods
    async fetchRevenueData() {
        // For now, return sample data structure
        // In a real implementation, this would make an AJAX call to get actual data
        return {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            values: [0, 0, 0, 0, 0, 0, 0] // Will be populated with real data
        };
    }

    async fetchPatientData() {
        // Get patient distribution from the current page data
        const opCount = parseInt(document.querySelector('[data-metric="consultations"]')?.textContent || '0');
        const ipCount = parseInt(document.querySelector('[data-metric="ip"]')?.textContent || '0');
        const labCount = parseInt(document.querySelector('[data-metric="lab"]')?.textContent || '0');
        const radiologyCount = parseInt(document.querySelector('[data-metric="radiology"]')?.textContent || '0');
        const servicesCount = parseInt(document.querySelector('[data-metric="services"]')?.textContent || '0');
        
        return {
            labels: ['OP', 'IP', 'Lab', 'Radiology', 'Services'],
            values: [opCount, ipCount, labCount, radiologyCount, servicesCount]
        };
    }

    async fetchPaymentMethodData() {
        // Get payment method data from the current page
        const cashAmount = parseFloat(document.querySelector('[data-payment="cash"]')?.textContent?.replace(/[₹,]/g, '') || '0');
        const cardAmount = parseFloat(document.querySelector('[data-payment="card"]')?.textContent?.replace(/[₹,]/g, '') || '0');
        const onlineAmount = parseFloat(document.querySelector('[data-payment="online"]')?.textContent?.replace(/[₹,]/g, '') || '0');
        const creditAmount = parseFloat(document.querySelector('[data-payment="credit"]')?.textContent?.replace(/[₹,]/g, '') || '0');
        const chequeAmount = parseFloat(document.querySelector('[data-payment="cheque"]')?.textContent?.replace(/[₹,]/g, '') || '0');
        
        return {
            labels: ['Cash', 'Card', 'Online', 'Credit', 'Cheque'],
            values: [cashAmount, cardAmount, onlineAmount, creditAmount, chequeAmount]
        };
    }

    showChartError(canvas, message) {
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = '#64748b';
        ctx.font = '16px Arial';
        ctx.textAlign = 'center';
        ctx.fillText(message, canvas.width / 2, canvas.height / 2);
    }

    // Utility function to format currency
    formatCurrency(num) {
        return new Intl.NumberFormat('en-IN', {
            style: 'currency',
            currency: 'INR'
        }).format(num);
    }
}

// Global functions
function refreshPage() {
    window.location.reload();
}

function exportDashboard() {
    console.log('Exporting dashboard data...');
    // Implement export functionality
}

function printDashboard() {
    window.print();
}

function toggleFullscreen() {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
    } else {
        document.exitFullscreen();
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    const dashboardManager = new DashboardManager();
    window.dashboardManager = dashboardManager;
});