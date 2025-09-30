/**
 * Purchase Indent Modern JavaScript
 * Modern functionality for the purchase indent approval system
 */

// Global variables
let isLoading = false;
let currentSearchTerm = '';
let sidebarCollapsed = false;

// Initialize when DOM is loaded
$(document).ready(function() {
    initializePage();
    setupEventListeners();
    setupFormValidation();
    initializeTooltips();
    initializeSidebar();
});

/**
 * Initialize page functionality
 */
function initializePage() {
    // Add loading states
    addLoadingStates();
    
    // Initialize search functionality
    initializeSearch();
    
    // Setup responsive behavior
    setupResponsiveBehavior();
    
    // Initialize date pickers
    initializeDatePickers();
    
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
}

/**
 * Setup event listeners
 */
function setupEventListeners() {
    // Search form submission
    $('.search-form').on('submit', function(e) {
        e.preventDefault();
        performSearch();
    });
    
    // Reset button
    $('.btn-secondary').on('click', function(e) {
        if ($(this).text().includes('Reset')) {
            resetForm();
        }
    });
    
    // Export button
    $('.btn-outline').on('click', function(e) {
        if ($(this).text().includes('Export')) {
            exportToExcel();
        }
    });
    
    // Refresh button
    $('.btn-secondary').on('click', function(e) {
        if ($(this).text().includes('Refresh')) {
            refreshPage();
        }
    });
    
    // Real-time search
    $('#docno').on('input', function() {
        const searchTerm = $(this).val();
        if (searchTerm.length > 2) {
            debounceSearch(searchTerm);
        }
    });
    
    // Table row hover effects
    $('.modern-data-table tbody tr').hover(
        function() {
            $(this).addClass('table-hover');
        },
        function() {
            $(this).removeClass('table-hover');
        }
    );
}

/**
 * Setup form validation
 */
function setupFormValidation() {
    // Date validation
    $('#ADate1, #ADate2').on('change', function() {
        validateDateRange();
    });
    
    // Document number validation
    $('#docno').on('blur', function() {
        validateDocumentNumber();
    });
    
    // Status selection validation
    $('#searchstatus').on('change', function() {
        validateStatusSelection();
    });
}

/**
 * Initialize tooltips
 */
function initializeTooltips() {
    // Add tooltips to action buttons
    $('.action-btn').each(function() {
        const title = $(this).attr('title');
        if (title) {
            $(this).tooltip({
                placement: 'top',
                trigger: 'hover'
            });
        }
    });
    
    // Add tooltips to badges
    $('.status-badge, .priority-badge, .location-badge').each(function() {
        $(this).tooltip({
            placement: 'top',
            trigger: 'hover'
        });
    });
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
}

/**
 * Restore sidebar state from localStorage
 */
function restoreSidebarState() {
    const savedState = localStorage.getItem('sidebarCollapsed');
    if (savedState === 'true' && $(window).width() > 1024) {
        toggleSidebar();
    }
}

/**
 * Add loading states to buttons and forms
 */
function addLoadingStates() {
    // Add loading state to submit button
    $('.search-form').on('submit', function() {
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.addClass('loading');
        submitBtn.prop('disabled', true);
        
        setTimeout(() => {
            submitBtn.removeClass('loading');
            submitBtn.prop('disabled', false);
        }, 2000);
    });
}

/**
 * Initialize search functionality
 */
function initializeSearch() {
    // Add search icon animation
    $('.search-form-icon').addClass('pulse');
    
    // Setup search suggestions (if needed)
    setupSearchSuggestions();
}

/**
 * Setup search suggestions
 */
function setupSearchSuggestions() {
    // This could be expanded to include autocomplete functionality
    // For now, we'll just add some basic enhancements
    
    $('#docno').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        $(this).parent().removeClass('focused');
    });
}

/**
 * Perform search with loading state
 */
function performSearch() {
    if (isLoading) return;
    
    isLoading = true;
    showLoadingState();
    
    // Simulate search delay (remove in production)
    setTimeout(() => {
        hideLoadingState();
        isLoading = false;
        
        // Show search results animation
        animateSearchResults();
        
        // Track search analytics (if needed)
        trackSearchEvent();
    }, 1000);
}

/**
 * Debounced search for real-time functionality
 */
function debounceSearch(searchTerm) {
    clearTimeout(window.searchTimeout);
    window.searchTimeout = setTimeout(() => {
        if (searchTerm !== currentSearchTerm) {
            currentSearchTerm = searchTerm;
            performRealTimeSearch(searchTerm);
        }
    }, 300);
}

/**
 * Perform real-time search
 */
function performRealTimeSearch(searchTerm) {
    // Filter visible rows based on search term
    $('.modern-data-table tbody tr').each(function() {
        const rowText = $(this).text().toLowerCase();
        const isVisible = rowText.includes(searchTerm.toLowerCase());
        
        if (isVisible) {
            $(this).show().addClass('search-match');
        } else {
            $(this).hide().removeClass('search-match');
        }
    });
    
    // Update search results count
    updateSearchResultsCount();
}

/**
 * Update search results count
 */
function updateSearchResultsCount() {
    const visibleRows = $('.modern-data-table tbody tr:visible').length;
    const totalRows = $('.modern-data-table tbody tr').length;
    
    $('.data-table-count').html(`Showing: <strong>${visibleRows}</strong> of ${totalRows}`);
}

/**
 * Reset form to initial state
 */
function resetForm() {
    $('.search-form')[0].reset();
    
    // Reset date fields to default values
    const today = new Date();
    const lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
    
    $('#ADate1').val(formatDate(lastMonth));
    $('#ADate2').val(formatDate(today));
    
    // Clear search results
    $('.modern-data-table tbody tr').show().removeClass('search-match');
    
    // Reset search results count
    updateSearchResultsCount();
    
    // Show reset animation
    showResetAnimation();
    
    // Track reset event
    trackResetEvent();
}

/**
 * Refresh page with loading animation
 */
function refreshPage() {
    showRefreshAnimation();
    
    setTimeout(() => {
        window.location.reload();
    }, 500);
}

/**
 * Export to Excel functionality
 */
function exportToExcel() {
    // Show export loading state
    showExportLoading();
    
    // Create export data
    const exportData = prepareExportData();
    
    // Generate and download Excel file
    generateExcelFile(exportData);
    
    // Track export event
    trackExportEvent();
}

/**
 * Prepare data for export
 */
function prepareExportData() {
    const data = [];
    
    // Add headers
    data.push([
        'Date', 'From', 'Doc No', 'Status', 'Remarks', 'Location', 'Priority', 'Action'
    ]);
    
    // Add data rows
    $('.modern-data-table tbody tr:visible').each(function() {
        const row = [];
        $(this).find('td').each(function() {
            row.push($(this).text().trim());
        });
        data.push(row);
    });
    
    return data;
}

/**
 * Generate Excel file
 */
function generateExcelFile(data) {
    // This would integrate with a library like SheetJS
    // For now, we'll create a simple CSV export
    
    let csvContent = '';
    data.forEach(row => {
        csvContent += row.map(cell => `"${cell}"`).join(',') + '\n';
    });
    
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `purchase_indents_${formatDate(new Date())}.csv`;
    a.click();
    window.URL.revokeObjectURL(url);
}

/**
 * Validate date range
 */
function validateDateRange() {
    const fromDate = new Date($('#ADate1').val());
    const toDate = new Date($('#ADate2').val());
    
    if (fromDate > toDate) {
        showAlert('Date From cannot be greater than Date To', 'error');
        $('#ADate2').focus();
        return false;
    }
    
    const diffTime = Math.abs(toDate - fromDate);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    
    if (diffDays > 365) {
        showAlert('Date range cannot exceed 365 days', 'warning');
    }
    
    return true;
}

/**
 * Validate document number
 */
function validateDocumentNumber() {
    const docNo = $('#docno').val().trim();
    
    if (docNo && docNo.length < 3) {
        showAlert('Document number must be at least 3 characters', 'error');
        return false;
    }
    
    return true;
}

/**
 * Validate status selection
 */
function validateStatusSelection() {
    const status = $('#searchstatus').val();
    
    if (!status) {
        showAlert('Please select a status', 'error');
        return false;
    }
    
    return true;
}

/**
 * Setup responsive behavior
 */
function setupResponsiveBehavior() {
    // Handle window resize
    $(window).on('resize', function() {
        adjustTableLayout();
    });
    
    // Initial adjustment
    adjustTableLayout();
}

/**
 * Adjust table layout for different screen sizes
 */
function adjustTableLayout() {
    const windowWidth = $(window).width();
    
    if (windowWidth < 768) {
        // Mobile layout adjustments
        $('.modern-data-table').addClass('mobile-layout');
        $('.form-row').css('grid-template-columns', '1fr');
    } else {
        // Desktop layout
        $('.modern-data-table').removeClass('mobile-layout');
        $('.form-row').css('grid-template-columns', 'repeat(auto-fit, minmax(300px, 1fr))');
    }
}

/**
 * Initialize date pickers with enhanced functionality
 */
function initializeDatePickers() {
    // Add custom date picker enhancements
    $('.date-picker-icon').on('click', function() {
        $(this).addClass('active');
        setTimeout(() => {
            $(this).removeClass('active');
        }, 200);
    });
}

/**
 * Show loading state
 */
function showLoadingState() {
    $('.main-container').addClass('loading');
    $('.search-form button[type="submit"]').prop('disabled', true);
}

/**
 * Hide loading state
 */
function hideLoadingState() {
    $('.main-container').removeClass('loading');
    $('.search-form button[type="submit"]').prop('disabled', false);
}

/**
 * Show refresh animation
 */
function showRefreshAnimation() {
    $('.btn-secondary').addClass('rotating');
    setTimeout(() => {
        $('.btn-secondary').removeClass('rotating');
    }, 500);
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
 * Show export loading
 */
function showExportLoading() {
    $('.btn-outline').addClass('export-loading');
    setTimeout(() => {
        $('.btn-outline').removeClass('export-loading');
    }, 2000);
}

/**
 * Animate search results
 */
function animateSearchResults() {
    $('.modern-data-table tbody tr').each(function(index) {
        $(this).css('animation-delay', `${index * 0.1}s`);
        $(this).addClass('fade-in');
    });
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
 * Format date for display
 */
function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

/**
 * Track search event (analytics)
 */
function trackSearchEvent() {
    // This would integrate with analytics services
    console.log('Search performed:', {
        timestamp: new Date(),
        searchTerm: $('#docno').val(),
        status: $('#searchstatus').val(),
        dateFrom: $('#ADate1').val(),
        dateTo: $('#ADate2').val()
    });
}

/**
 * Track reset event (analytics)
 */
function trackResetEvent() {
    console.log('Form reset:', {
        timestamp: new Date()
    });
}

/**
 * Track export event (analytics)
 */
function trackExportEvent() {
    console.log('Data exported:', {
        timestamp: new Date(),
        recordCount: $('.modern-data-table tbody tr:visible').length
    });
}

/**
 * Utility function to disable Enter key (legacy compatibility)
 */
function disableEnterKey() {
    if (event.keyCode === 13) {
        return false;
    }
    return true;
}

/**
 * Legacy function for customername callback (maintained for compatibility)
 */
function cbcustomername1() {
    document.cbform1.submit();
}

/**
 * Legacy function for pharmacy window (maintained for compatibility)
 */
function pharmacy(patientcode, visitcode) {
    const url = `pharmacy1.php?RandomKey=${Math.random()}&patientcode=${patientcode}&visitcode=${visitcode}`;
    window.open(url, "Pharmacy", 'width=600,height=400');
}

// Add CSS animations via JavaScript
const style = document.createElement('style');
style.textContent = `
    .pulse {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .rotating {
        animation: rotate 0.5s linear;
    }
    
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    .fade-in {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
        transform: translateY(20px);
    }
    
    .search-match {
        background: rgba(52, 152, 219, 0.1) !important;
        border-left: 4px solid #3498db;
    }
    
    .mobile-layout .modern-data-table {
        font-size: 0.8rem;
    }
    
    .mobile-layout .modern-data-table th,
    .mobile-layout .modern-data-table td {
        padding: 0.5rem 0.25rem;
    }
    
    .focused {
        border-color: #3498db !important;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    }
    
    .reset-animation {
        animation: resetPulse 0.3s ease-out;
    }
    
    @keyframes resetPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
    }
    
    .export-loading {
        position: relative;
        color: transparent !important;
    }
    
    .export-loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 16px;
        height: 16px;
        margin: -8px 0 0 -8px;
        border: 2px solid #3498db;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 1s linear infinite;
    }
`;
document.head.appendChild(style);
