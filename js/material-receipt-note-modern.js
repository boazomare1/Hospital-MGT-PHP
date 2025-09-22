// Material Receipt Note Modern JavaScript

$(document).ready(function() {
    // Initialize components
    initializeSidebar();
    initializeSearch();
    initializeTable();
    initializeActions();
});

// Sidebar Management
function initializeSidebar() {
    const menuToggle = $('#menuToggle');
    const sidebar = $('#leftSidebar');
    const sidebarToggle = $('#sidebarToggle');
    
    // Toggle sidebar from floating button
    menuToggle.on('click', function() {
        sidebar.toggleClass('open');
        updateMenuIcon();
    });
    
    // Toggle sidebar from sidebar button
    sidebarToggle.on('click', function() {
        sidebar.toggleClass('open');
        updateMenuIcon();
    });
    
    // Close sidebar when clicking outside
    $(document).on('click', function(e) {
        if (!sidebar.is(e.target) && sidebar.has(e.target).length === 0 && 
            !menuToggle.is(e.target) && menuToggle.has(e.target).length === 0) {
            sidebar.removeClass('open');
            updateMenuIcon();
        }
    });
    
    // Handle window resize
    $(window).on('resize', function() {
        if ($(window).width() > 768) {
            sidebar.removeClass('open');
            updateMenuIcon();
        }
    });
}

function updateMenuIcon() {
    const sidebar = $('#leftSidebar');
    const menuIcon = $('#menuToggle i');
    
    if (sidebar.hasClass('open')) {
        menuIcon.removeClass('fa-bars').addClass('fa-times');
    } else {
        menuIcon.removeClass('fa-times').addClass('fa-bars');
    }
}

// Search Functionality
function initializeSearch() {
    const searchInput = $('#searchInput');
    
    if (searchInput.length) {
        searchInput.on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            searchMRNRecords(searchTerm);
        });
    }
}

function searchMRNRecords(searchTerm) {
    const tableRows = $('.data-table tbody tr');
    
    tableRows.each(function() {
        const row = $(this);
        const text = row.text().toLowerCase();
        
        if (text.includes(searchTerm)) {
            row.show();
        } else {
            row.hide();
        }
    });
    
    // Update visible row count
    updateRowCount();
}

function updateRowCount() {
    const visibleRows = $('.data-table tbody tr:visible').length;
    const totalRows = $('.data-table tbody tr').length;
    
    // Update count display if it exists
    const countDisplay = $('.row-count-display');
    if (countDisplay.length) {
        countDisplay.text(`${visibleRows} of ${totalRows} records`);
    }
}

// Table Management
function initializeTable() {
    // Add hover effects
    $('.data-table tbody tr').hover(
        function() {
            $(this).addClass('table-row-hover');
        },
        function() {
            $(this).removeClass('table-row-hover');
        }
    );
    
    // Initialize row count
    updateRowCount();
}

// Action Handlers
function initializeActions() {
    // Edit button handlers
    $('.action-btn.edit').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        if (href) {
            showLoadingState($(this));
            window.location.href = href;
        }
    });
    
    // Print button handlers
    $('.action-btn.print').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        if (href) {
            showLoadingState($(this));
            window.open(href, '_blank');
        }
    });
    
    // Refresh button
    $('.btn-secondary').on('click', function() {
        if ($(this).text().includes('Refresh')) {
            refreshPage();
        }
    });
}

// Utility Functions
function showLoadingState(element) {
    const originalText = element.html();
    element.html('<i class="fas fa-spinner fa-spin"></i> Loading...');
    element.prop('disabled', true);
    
    // Reset after 2 seconds
    setTimeout(function() {
        element.html(originalText);
        element.prop('disabled', false);
    }, 2000);
}

function refreshPage() {
    showAlert('Refreshing page...', 'info');
    setTimeout(function() {
        window.location.reload();
    }, 1000);
}

function exportToExcel() {
    showAlert('Export functionality would be implemented here', 'info');
}

function clearSearch() {
    $('#searchInput').val('');
    $('.data-table tbody tr').show();
    updateRowCount();
}

// Alert System
function showAlert(message, type = 'info', duration = 5000) {
    const alertContainer = $('#alertContainer');
    
    const alertClass = `alert-${type}`;
    const iconClass = getAlertIcon(type);
    
    const alertHtml = `
        <div class="alert ${alertClass} fade-in">
            <i class="fas ${iconClass} alert-icon"></i>
            <span>${message}</span>
            <button type="button" class="alert-close" onclick="closeAlert(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    alertContainer.append(alertHtml);
    
    // Auto-remove after duration
    if (duration > 0) {
        setTimeout(function() {
            alertContainer.find('.alert').last().fadeOut(300, function() {
                $(this).remove();
            });
        }, duration);
    }
}

function getAlertIcon(type) {
    const icons = {
        'success': 'fa-check-circle',
        'error': 'fa-exclamation-triangle',
        'warning': 'fa-exclamation-circle',
        'info': 'fa-info-circle'
    };
    return icons[type] || 'fa-info-circle';
}

function closeAlert(button) {
    $(button).closest('.alert').fadeOut(300, function() {
        $(this).remove();
    });
}

// Form Validation
function validateSearchForm() {
    const searchInput = $('#searchInput');
    const searchTerm = searchInput.val().trim();
    
    if (searchTerm.length < 2) {
        showAlert('Please enter at least 2 characters to search', 'warning');
        searchInput.focus();
        return false;
    }
    
    return true;
}

// Print Functionality
function printMRN(billautonumber, billnum) {
    const printUrl = `print_mrn_dmp4inch1.php?billautonumber=${billautonumber}&billnum=${billnum}`;
    
    // Show loading state
    showAlert('Opening print preview...', 'info', 2000);
    
    // Open print window
    const printWindow = window.open(printUrl, '_blank', 'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
    
    // Check if window was blocked
    if (!printWindow) {
        showAlert('Popup blocked. Please allow popups for this site.', 'warning');
    }
}

// Edit Functionality
function editMRN(ponumber, mrnnumber) {
    const editUrl = `editmaterialreceiptnote.php?ponumber=${ponumber}&mrnnumber=${mrnnumber}`;
    
    // Show loading state
    showAlert('Loading edit form...', 'info', 2000);
    
    // Navigate to edit page
    window.location.href = editUrl;
}

// Data Refresh
function refreshMRNData() {
    showAlert('Refreshing MRN data...', 'info', 2000);
    
    // Reload the page to get fresh data
    setTimeout(function() {
        window.location.reload();
    }, 1500);
}

// Keyboard Shortcuts
$(document).on('keydown', function(e) {
    // Ctrl + F for search focus
    if (e.ctrlKey && e.keyCode === 70) {
        e.preventDefault();
        $('#searchInput').focus();
    }
    
    // Escape to clear search
    if (e.keyCode === 27) {
        clearSearch();
        $('#searchInput').blur();
    }
    
    // Enter in search to trigger search
    if (e.keyCode === 13 && $('#searchInput').is(':focus')) {
        e.preventDefault();
        if (validateSearchForm()) {
            searchMRNRecords($('#searchInput').val());
        }
    }
});

// Auto-refresh functionality (optional)
function enableAutoRefresh(intervalMinutes = 5) {
    setInterval(function() {
        // Only auto-refresh if user is active
        if (!document.hidden) {
            refreshMRNData();
        }
    }, intervalMinutes * 60 * 1000);
}

// Initialize auto-refresh (uncomment to enable)
// enableAutoRefresh(5);

// Error Handling
window.addEventListener('error', function(e) {
    console.error('JavaScript Error:', e.error);
    showAlert('An error occurred. Please refresh the page.', 'error');
});

// Performance Monitoring
function logPerformance() {
    if (window.performance && window.performance.timing) {
        const timing = window.performance.timing;
        const loadTime = timing.loadEventEnd - timing.navigationStart;
        console.log(`Page load time: ${loadTime}ms`);
    }
}

// Initialize performance monitoring
$(window).on('load', logPerformance);

// Accessibility Improvements
function initializeAccessibility() {
    // Add ARIA labels
    $('.action-btn').each(function() {
        const button = $(this);
        const action = button.hasClass('edit') ? 'Edit' : 
                      button.hasClass('print') ? 'Print' : 'Action';
        
        if (!button.attr('aria-label')) {
            button.attr('aria-label', `${action} this record`);
        }
    });
    
    // Add keyboard navigation for table rows
    $('.data-table tbody tr').attr('tabindex', '0').on('keydown', function(e) {
        if (e.keyCode === 13 || e.keyCode === 32) { // Enter or Space
            const editLink = $(this).find('.action-btn.edit');
            if (editLink.length) {
                editLink[0].click();
            }
        }
    });
}

// Initialize accessibility features
$(document).ready(initializeAccessibility);

// Export functions for global access
window.refreshPage = refreshPage;
window.exportToExcel = exportToExcel;
window.clearSearch = clearSearch;
window.printMRN = printMRN;
window.editMRN = editMRN;
window.refreshMRNData = refreshMRNData;

