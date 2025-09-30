/**
 * Revenue vs Footfall Modern JavaScript
 * Modern functionality for the revenue vs footfall report system
 */

// Global variables
let isLoading = false;
let sidebarCollapsed = false;
let revenueFootfallChart = null;
let chartVisible = false;

// Initialize when DOM is loaded
$(document).ready(function() {
    initializePage();
    setupEventListeners();
    setupFormValidation();
    initializeTooltips();
    initializeSidebar();
    initializeCharts();
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
    
    // Initialize date pickers
    initializeDatePickers();
    
    // Setup table interactions
    setupTableInteractions();
}

/**
 * Setup event listeners
 */
function setupEventListeners() {
    // Form submission
    $('.search-form').on('submit', function(e) {
        e.preventDefault();
        generateReport();
    });
    
    // Reset button
    $('button[type="reset"]').on('click', function(e) {
        resetForm();
    });
    
    // Location change
    $('#locationcode').on('change', function() {
        handleLocationChange();
    });
    
    // Date changes
    $('#ADate1, #ADate2').on('change', function() {
        validateDateRange();
    });
    
    // Export button
    $('button[onclick="exportToExcel()"]').on('click', function() {
        exportToExcel();
    });
    
    // Print button
    $('button[onclick="printReport()"]').on('click', function() {
        printReport();
    });
    
    // Chart toggle button
    $('button[onclick="toggleChartView()"]').on('click', function() {
        toggleChartView();
    });
}

/**
 * Setup form validation
 */
function setupFormValidation() {
    // Validate form on submission
    $('.search-form').on('submit', function() {
        return validateForm();
    });
    
    // Real-time validation
    $('#ADate1, #ADate2').on('blur', function() {
        validateField(this);
    });
    
    // Add input event listeners for real-time feedback
    $('#ADate1, #ADate2').on('input', function() {
        clearFieldError(this);
    });
}

/**
 * Initialize tooltips
 */
function initializeTooltips() {
    // Add tooltips to form elements
    $('.form-input').each(function() {
        $(this).tooltip({
            placement: 'top',
            trigger: 'focus',
            title: getTooltipText($(this).attr('id'))
        });
    });
    
    // Add tooltips to buttons
    $('.btn').each(function() {
        $(this).tooltip({
            placement: 'top',
            trigger: 'hover'
        });
    });
    
    // Add tooltips to summary cards
    $('.summary-card').each(function() {
        $(this).tooltip({
            placement: 'top',
            trigger: 'hover',
            title: 'Click to view details'
        });
    });
    
    // Add tooltips to performance indicators
    $('.performance-indicator').each(function() {
        const performance = $(this).hasClass('performance-good') ? 'Good Performance' : 
                          $(this).hasClass('performance-moderate') ? 'Moderate Performance' : 'Poor Performance';
        $(this).tooltip({
            placement: 'top',
            trigger: 'hover',
            title: performance
        });
    });
}

/**
 * Get tooltip text for form elements
 */
function getTooltipText(elementId) {
    const tooltips = {
        'locationcode': 'Select location to filter the report',
        'ADate1': 'Select the start date for the report',
        'ADate2': 'Select the end date for the report'
    };
    return tooltips[elementId] || '';
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
        if (revenueFootfallChart) {
            revenueFootfallChart.resize();
        }
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
        $('.form-row').css('grid-template-columns', '1fr');
        $('.form-actions').css('flex-direction', 'column');
        $('.summary-cards').css('grid-template-columns', '1fr');
        $('.report-header').css('flex-direction', 'column');
        $('.modern-data-table').addClass('mobile-table');
    } else if (windowWidth < 1024) {
        // Tablet layout
        $('.summary-cards').css('grid-template-columns', 'repeat(auto-fit, minmax(180px, 1fr))');
        $('.modern-data-table').removeClass('mobile-table');
    } else {
        // Desktop layout
        $('.summary-cards').css('grid-template-columns', 'repeat(auto-fit, minmax(200px, 1fr))');
        $('.modern-data-table').removeClass('mobile-table');
    }
}

/**
 * Initialize form enhancements
 */
function initializeFormEnhancements() {
    // Add input validation classes
    $('.form-input').each(function() {
        if ($(this).val().trim() !== '') {
            $(this).addClass('has-value');
        }
    });
    
    // Add change detection
    $('.form-input').on('input', function() {
        if ($(this).val().trim() !== '') {
            $(this).addClass('has-value');
        } else {
            $(this).removeClass('has-value');
        }
    });
    
    // Add focus effects
    $('.form-input').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        $(this).parent().removeClass('focused');
    });
}

/**
 * Initialize date pickers
 */
function initializeDatePickers() {
    // Set default dates if not set
    if (!$('#ADate1').val()) {
        $('#ADate1').val(getCurrentDate());
    }
    if (!$('#ADate2').val()) {
        $('#ADate2').val(getCurrentDate());
    }
    
    // Validate date range on initialization
    validateDateRange();
}

/**
 * Get current date in YYYY-MM-DD format
 */
function getCurrentDate() {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

/**
 * Setup table interactions
 */
function setupTableInteractions() {
    // Table row clicks
    $('.modern-data-table tbody tr').on('click', function() {
        handleTableRowClick(this);
    });
    
    // Summary card clicks
    $('.summary-card').on('click', function() {
        handleSummaryCardClick(this);
    });
}

/**
 * Handle table row click
 */
function handleTableRowClick(row) {
    // Add visual feedback
    $(row).addClass('row-clicked');
    setTimeout(() => {
        $(row).removeClass('row-clicked');
    }, 200);
    
    // Track row click
    const provider = $(row).find('.provider-name').text();
    trackTableRowClick(provider);
}

/**
 * Handle summary card click
 */
function handleSummaryCardClick(card) {
    // Add visual feedback
    $(card).addClass('card-clicked');
    setTimeout(() => {
        $(card).removeClass('card-clicked');
    }, 200);
    
    // Track card click
    const cardTitle = $(card).find('.summary-content p').text();
    trackSummaryCardClick(cardTitle);
}

/**
 * Validate individual field
 */
function validateField(field) {
    const $field = $(field);
    const fieldId = $field.attr('id');
    let isValid = true;
    let errorMessage = '';
    
    // Clear previous errors
    clearFieldError($field);
    
    if (fieldId === 'ADate1' || fieldId === 'ADate2') {
        const dateValue = $field.val();
        if (!dateValue || !isValidDate(dateValue)) {
            errorMessage = 'Please enter a valid date';
            isValid = false;
        }
    }
    
    if (!isValid) {
        showFieldError($field, errorMessage);
    } else {
        showFieldSuccess($field);
    }
    
    return isValid;
}

/**
 * Validate date range
 */
function validateDateRange() {
    const startDate = $('#ADate1').val();
    const endDate = $('#ADate2').val();
    
    if (startDate && endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);
        
        if (start > end) {
            showAlert('Start date cannot be later than end date.', 'error');
            $('#ADate1').focus();
            return false;
        }
        
        // Check if date range is too large (more than 1 year)
        const diffTime = Math.abs(end - start);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        
        if (diffDays > 365) {
            showAlert('Date range should not exceed 1 year for optimal performance.', 'warning');
        }
    }
    
    return true;
}

/**
 * Validate date format
 */
function isValidDate(dateString) {
    const regex = /^\d{4}-\d{2}-\d{2}$/;
    if (!regex.test(dateString)) return false;
    
    const date = new Date(dateString);
    return date instanceof Date && !isNaN(date);
}

/**
 * Validate entire form
 */
function validateForm() {
    let isValid = true;
    
    // Validate start date
    if (!validateField($('#ADate1')[0])) {
        isValid = false;
    }
    
    // Validate end date
    if (!validateField($('#ADate2')[0])) {
        isValid = false;
    }
    
    // Validate date range
    if (!validateDateRange()) {
        isValid = false;
    }
    
    return isValid;
}

/**
 * Show field error
 */
function showFieldError(field, message) {
    const $field = $(field);
    $field.addClass('error').removeClass('success');
    
    // Remove existing error message
    $field.siblings('.error-message').remove();
    
    // Add error message
    $field.after(`<div class="error-message">${message}</div>`);
    
    // Add shake animation
    $field.addClass('shake');
    setTimeout(() => $field.removeClass('shake'), 500);
}

/**
 * Show field success
 */
function showFieldSuccess(field) {
    const $field = $(field);
    $field.addClass('success').removeClass('error');
    $field.siblings('.error-message').remove();
}

/**
 * Clear field error
 */
function clearFieldError(field) {
    const $field = $(field);
    $field.removeClass('error');
    $field.siblings('.error-message').remove();
}

/**
 * Handle location change
 */
function handleLocationChange() {
    const location = $('#locationcode').val();
    
    if (location) {
        // Update location display
        updateLocationDisplay(location);
        
        // Track location change
        trackLocationChange(location);
    }
}

/**
 * Update location display
 */
function updateLocationDisplay(locationCode) {
    // This would typically make an AJAX call to get location name
    // For now, we'll update the display text
    const locationText = locationCode ? `Location: ${locationCode}` : 'Location: All Locations';
    $('.location-display span').text(locationText);
}

/**
 * Generate report with validation
 */
function generateReport() {
    if (isLoading) return false;
    
    if (!validateForm()) {
        showAlert('Please fix the errors before generating the report.', 'error');
        return false;
    }
    
    isLoading = true;
    showLoadingState();
    
    // Show generation animation
    showGenerationAnimation();
    
    // Track report generation
    trackReportGeneration();
    
    // Submit the form after delay
    setTimeout(() => {
        hideLoadingState();
        isLoading = false;
        $('.search-form')[0].submit();
    }, 1000);
    
    return false; // Prevent default submission
}

/**
 * Reset form to initial state
 */
function resetForm() {
    if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
        // Clear all form inputs
        $('#locationcode').val('');
        $('#ADate1').val(getCurrentDate()).removeClass('success error has-value');
        $('#ADate2').val(getCurrentDate()).removeClass('success error has-value');
        
        // Clear error messages
        $('.error-message').remove();
        
        // Show reset animation
        showResetAnimation();
        
        // Track reset event
        trackResetEvent();
        
        // Focus on first input
        $('#locationcode').focus();
    }
}

/**
 * Initialize charts
 */
function initializeCharts() {
    // Check if Chart.js is available
    if (typeof Chart !== 'undefined') {
        setupRevenueFootfallChart();
    }
}

/**
 * Setup revenue vs footfall chart
 */
function setupRevenueFootfallChart() {
    const ctx = document.getElementById('revenueFootfallChart');
    if (!ctx) return;
    
    // Get data from table if available
    const chartData = extractChartData();
    
    revenueFootfallChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Footfall',
                data: chartData.footfall,
                backgroundColor: 'rgba(30, 64, 175, 0.8)',
                borderColor: 'rgba(30, 64, 175, 1)',
                borderWidth: 1,
                yAxisID: 'y'
            }, {
                label: 'Revenue',
                data: chartData.revenue,
                backgroundColor: 'rgba(16, 185, 129, 0.8)',
                borderColor: 'rgba(16, 185, 129, 1)',
                borderWidth: 1,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Revenue vs Footfall Analysis'
                },
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Providers'
                    }
                },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Footfall'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Revenue'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                }
            },
            interaction: {
                mode: 'index',
                intersect: false,
            }
        }
    });
}

/**
 * Extract chart data from table
 */
function extractChartData() {
    const labels = [];
    const footfall = [];
    const revenue = [];
    
    $('.modern-data-table tbody tr').each(function() {
        const provider = $(this).find('.provider-name').text();
        const footfallValue = parseFloat($(this).find('.footfall-badge').text().replace(/,/g, ''));
        const revenueValue = parseFloat($(this).find('.revenue-badge').text().replace(/,/g, ''));
        
        if (provider && !isNaN(footfallValue) && !isNaN(revenueValue)) {
            labels.push(provider);
            footfall.push(footfallValue);
            revenue.push(revenueValue);
        }
    });
    
    return { labels, footfall, revenue };
}

/**
 * Toggle chart view
 */
function toggleChartView() {
    const chartSection = $('#chartSection');
    const button = $('button[onclick="toggleChartView()"]');
    
    if (chartVisible) {
        chartSection.slideUp();
        button.html('<i class="fas fa-chart-pie"></i> Chart View');
        chartVisible = false;
    } else {
        chartSection.slideDown();
        button.html('<i class="fas fa-table"></i> Table View');
        chartVisible = true;
        
        // Redraw chart if needed
        if (revenueFootfallChart) {
            setTimeout(() => {
                revenueFootfallChart.resize();
            }, 300);
        }
    }
    
    // Track chart toggle
    trackChartToggle(chartVisible);
}

/**
 * Export to Excel
 */
function exportToExcel() {
    // TODO: Implement Excel export functionality
    showAlert('Excel export functionality will be implemented soon.', 'info');
    
    // Track export attempt
    trackExportAttempt('excel');
}

/**
 * Print report
 */
function printReport() {
    // Track print attempt
    trackPrintAttempt();
    
    // Use browser print functionality
    window.print();
}

/**
 * Show loading state
 */
function showLoadingState() {
    $('.main-content').addClass('loading');
    $('button[type="submit"]').prop('disabled', true);
}

/**
 * Hide loading state
 */
function hideLoadingState() {
    $('.main-content').removeClass('loading');
    $('button[type="submit"]').prop('disabled', false);
}

/**
 * Show generation animation
 */
function showGenerationAnimation() {
    $('.search-form-section').addClass('generation-animation');
    setTimeout(() => {
        $('.search-form-section').removeClass('generation-animation');
    }, 2000);
}

/**
 * Show reset animation
 */
function showResetAnimation() {
    $('.search-form').addClass('reset-animation');
    setTimeout(() => {
        $('.search-form').removeClass('reset-animation');
    }, 300);
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
    
    // Resize chart if visible
    if (revenueFootfallChart && chartVisible) {
        setTimeout(() => {
            revenueFootfallChart.resize();
        }, 300);
    }
}

/**
 * Track location change
 */
function trackLocationChange(locationCode) {
    console.log('Location change tracked:', {
        locationCode: locationCode,
        timestamp: new Date()
    });
}

/**
 * Track report generation
 */
function trackReportGeneration() {
    console.log('Report generation tracked:', {
        timestamp: new Date(),
        startDate: $('#ADate1').val(),
        endDate: $('#ADate2').val(),
        location: $('#locationcode').val()
    });
}

/**
 * Track table row click
 */
function trackTableRowClick(provider) {
    console.log('Table row click tracked:', {
        provider: provider,
        timestamp: new Date()
    });
}

/**
 * Track summary card click
 */
function trackSummaryCardClick(cardTitle) {
    console.log('Summary card click tracked:', {
        cardTitle: cardTitle,
        timestamp: new Date()
    });
}

/**
 * Track chart toggle
 */
function trackChartToggle(visible) {
    console.log('Chart toggle tracked:', {
        visible: visible,
        timestamp: new Date()
    });
}

/**
 * Track export attempt
 */
function trackExportAttempt(format) {
    console.log('Export attempt tracked:', {
        format: format,
        timestamp: new Date()
    });
}

/**
 * Track print attempt
 */
function trackPrintAttempt() {
    console.log('Print attempt tracked:', {
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
    .focused {
        border-color: var(--medstar-primary) !important;
        box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1) !important;
    }
    
    .has-value {
        background: var(--background-primary);
        border-color: var(--medstar-primary-light);
    }
    
    .error {
        border-color: var(--error-color) !important;
        background: rgba(239, 68, 68, 0.05);
    }
    
    .success {
        border-color: var(--success-color) !important;
        background: rgba(16, 185, 129, 0.05);
    }
    
    .error-message {
        color: var(--error-color);
        font-size: 0.8rem;
        margin-top: 0.25rem;
        font-weight: 500;
    }
    
    .shake {
        animation: shake 0.5s ease-in-out;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    .generation-animation {
        animation: generationGlow 2s ease-out;
    }
    
    @keyframes generationGlow {
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
    
    .row-clicked {
        background: var(--medstar-primary) !important;
        color: white !important;
        transform: scale(1.02);
    }
    
    .card-clicked {
        transform: scale(0.98);
        box-shadow: var(--shadow-medium);
    }
    
    .modern-data-table.mobile-table {
        font-size: 0.7rem;
        min-width: 600px;
    }
    
    .modern-data-table.mobile-table th,
    .modern-data-table.mobile-table td {
        padding: 0.25rem;
        font-size: 0.6rem;
    }
    
    .table-row {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .table-row:hover {
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .table-row:hover .footfall-badge,
    .table-row:hover .revenue-badge,
    .table-row:hover .value-badge {
        transform: scale(1.05);
    }
    
    .summary-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }
    
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }
    
    .loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid var(--medstar-primary);
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
`;
document.head.appendChild(style);

