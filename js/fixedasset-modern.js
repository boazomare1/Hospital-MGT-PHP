// Fixed Asset Acquisition Report Modern JavaScript
$(document).ready(function() {
    initializePage();
    setupEventListeners();
    setupSidebar();
    loadAssetsData();
    loadLocationOptions();
});

// Page initialization
function initializePage() {
    // Setup pagination variables
    window.currentPage = 1;
    window.itemsPerPage = 10;
    window.totalPages = 1;
    window.currentSearch = '';
    window.currentLocationFilter = '';
    window.currentDateFrom = new Date();
    window.currentDateTo = new Date();
    window.currentDateFrom.setMonth(window.currentDateFrom.getMonth() - 1);
}

// Setup event listeners
function setupEventListeners() {
    // Search functionality
    $('#assetSearch').on('input', debounce(function() {
        window.currentSearch = $(this).val();
        window.currentPage = 1;
        loadAssetsData();
    }, 300));

    // Search form submission
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        window.currentDateFrom = $('#dateFrom').val();
        window.currentDateTo = $('#dateTo').val();
        window.currentLocationFilter = $('#locationFilter').val();
        window.currentPage = 1;
        loadAssetsData();
    });

    // Location filter
    $('#locationFilter').on('change', function() {
        window.currentLocationFilter = $(this).val();
        window.currentPage = 1;
        loadAssetsData();
    });

    // Items per page
    $('#itemsPerPage').on('change', function() {
        window.itemsPerPage = parseInt($(this).val());
        window.currentPage = 1;
        loadAssetsData();
    });

    // Input focus effects
    $('.form-input, .form-select').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        $(this).parent().removeClass('focused');
    });

    // Keyboard shortcut for menu toggle
    $(document).on('keydown', function(e) {
        if (e.ctrlKey && e.key === 'm') {
            e.preventDefault();
            toggleSidebar();
        }
    });
}

// Setup sidebar functionality
function setupSidebar() {
    $('#menuToggle, #sidebarToggle').on('click', function() {
        toggleSidebar();
    });
}

// Toggle sidebar
function toggleSidebar() {
    const sidebar = $('#leftSidebar');
    const container = $('.main-container-with-sidebar');
    const toggle = $('#menuToggle');
    
    sidebar.toggleClass('collapsed');
    container.toggleClass('sidebar-collapsed');
    toggle.toggleClass('active');
}

// Load location options for filter
function loadLocationOptions() {
    $.ajax({
        url: 'get_fixed_asset_acquisition.php',
        method: 'GET',
        data: { page: 1, limit: 1 }, // Just to get locations
        dataType: 'json',
        success: function(response) {
            if (response.success && response.locations) {
                populateLocationOptions(response.locations);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading location options:', error);
        }
    });
}

// Populate location options in filter
function populateLocationOptions(locations) {
    const filterSelect = $('#locationFilter');
    
    // Clear existing options (keep "All Locations")
    filterSelect.find('option:not(:first)').remove();
    
    // Add new options
    locations.forEach(location => {
        const option = `<option value="${location.code}">${location.name}</option>`;
        filterSelect.append(option);
    });
}

// Load assets data via AJAX
function loadAssetsData() {
    showLoading();
    
    const params = {
        page: window.currentPage,
        limit: window.itemsPerPage,
        dateFrom: window.currentDateFrom,
        dateTo: window.currentDateTo,
        location: window.currentLocationFilter,
        search: window.currentSearch
    };

    $.ajax({
        url: 'get_fixed_asset_acquisition.php',
        method: 'GET',
        data: params,
        dataType: 'json',
        success: function(response) {
            hideLoading();
            
            if (response.success) {
                updateSummaryCards(response);
                updatePaginationInfo(response.pagination);
                renderAssetsTable(response.assets);
                renderPagination(response.pagination);
            } else {
                showError('Error loading assets: ' + (response.message || 'Unknown error'));
                $('#assetsTableBody').html('<tr><td colspan="10" class="text-center">Error loading data</td></tr>');
            }
        },
        error: function(xhr, status, error) {
            hideLoading();
            console.error('AJAX Error:', error);
            showError('Failed to load assets data. Please try again.');
            $('#assetsTableBody').html('<tr><td colspan="10" class="text-center">Error loading data</td></tr>');
        }
    });
}

// Update summary cards
function updateSummaryCards(response) {
    $('#totalAssets').text(response.assets.length);
    $('#totalAcquisitionCost').text('$' + numberFormat(response.totalAcquisitionCost));
    
    const dateFrom = new Date(window.currentDateFrom).toLocaleDateString();
    const dateTo = new Date(window.currentDateTo).toLocaleDateString();
    $('#dateRange').text(dateFrom + ' - ' + dateTo);
}

// Update pagination info
function updatePaginationInfo(pagination) {
    const start = ((pagination.page - 1) * pagination.limit) + 1;
    const end = Math.min(pagination.page * pagination.limit, pagination.total);
    $('#paginationInfo').text(`Showing ${start} to ${end} of ${pagination.total} items`);
}

// Render assets table
function renderAssetsTable(assets) {
    const tbody = $('#assetsTableBody');
    
    if (assets.length === 0) {
        tbody.html(`
            <tr>
                <td colspan="10" class="text-center py-8">
                    <div class="no-data">
                        <i class="fas fa-inbox"></i>
                        <p>No fixed assets found for the selected criteria</p>
                    </div>
                </td>
            </tr>
        `);
        return;
    }

    let html = '';
    assets.forEach((asset, index) => {
        const serialNumber = ((window.currentPage - 1) * window.itemsPerPage) + index + 1;
        const acquisitionDate = formatDate(asset.entrydate);
        
        html += `
            <tr class="asset-row">
                <td>${serialNumber}</td>
                <td>${escapeHtml(asset.asset_id)}</td>
                <td>${escapeHtml(asset.itemname)}</td>
                <td>${escapeHtml(asset.responsible_employee || 'N/A')}</td>
                <td>${escapeHtml(asset.locationcode)}</td>
                <td>${escapeHtml(asset.serial_number || 'N/A')}</td>
                <td class="text-right">$${numberFormat(asset.rate)}</td>
                <td>${acquisitionDate}</td>
                <td>${escapeHtml(asset.suppliername || 'N/A')}</td>
                <td>${escapeHtml(asset.asset_category || 'N/A')}</td>
            </tr>
        `;
    });

    tbody.html(html);
}

// Render pagination
function renderPagination(pagination) {
    const container = $('#pageNumbers');
    
    if (pagination.pages <= 1) {
        $('#prevPage, #nextPage').prop('disabled', true);
        container.html('');
        return;
    }

    // Update global pagination state
    window.currentPage = pagination.page;
    window.totalPages = pagination.pages;

    // Enable/disable previous/next buttons
    $('#prevPage').prop('disabled', pagination.page <= 1);
    $('#nextPage').prop('disabled', pagination.page >= pagination.pages);

    // Generate page numbers
    let html = '';
    const startPage = Math.max(1, pagination.page - 2);
    const endPage = Math.min(pagination.pages, pagination.page + 2);

    for (let i = startPage; i <= endPage; i++) {
        html += `<button class="page-number ${i === pagination.page ? 'active' : ''}" onclick="changePage(${i})">${i}</button>`;
    }

    container.html(html);
}

// Change page
function changePage(page) {
    if (page >= 1 && page <= window.totalPages && page !== window.currentPage) {
        window.currentPage = page;
        loadAssetsData();
    }
}

// Previous page
function previousPage() {
    if (window.currentPage > 1) {
        changePage(window.currentPage - 1);
    }
}

// Next page
function nextPage() {
    if (window.currentPage < window.totalPages) {
        changePage(window.currentPage + 1);
    }
}

// Show loading state
function showLoading() {
    $('#assetsTableBody').html(`
        <tr>
            <td colspan="10" class="text-center py-8">
                <div class="loading-spinner">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Loading fixed assets...</p>
                </div>
            </td>
        </tr>
    `);
}

// Hide loading state
function hideLoading() {
    // Loading state is handled by renderAssetsTable
}

// Show error message
function showError(message) {
    showAlert(message, 'error');
}

// Show success message
function showSuccess(message) {
    showAlert(message, 'success');
}

// Show alert message
function showAlert(message, type = 'info') {
    const alertDiv = $('<div>')
        .addClass(`alert alert-${type}`)
        .html(`<i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i> ${message}`)
        .css({
            position: 'fixed',
            top: '20px',
            right: '20px',
            zIndex: 9999,
            padding: '1rem 1.5rem',
            borderRadius: '0.5rem',
            color: 'white',
            backgroundColor: type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6',
            boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.1)',
            maxWidth: '400px',
            wordWrap: 'break-word'
        });
    
    $('body').append(alertDiv);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        alertDiv.fadeOut(300, function() {
            $(this).remove();
        });
    }, 5000);
}

// Clear search
function clearSearch() {
    $('#assetSearch').val('');
    $('#dateFrom').val(new Date().toISOString().split('T')[0]);
    $('#dateTo').val(new Date().toISOString().split('T')[0]);
    $('#locationFilter').val('');
    
    window.currentSearch = '';
    window.currentLocationFilter = '';
    window.currentDateFrom = new Date().toISOString().split('T')[0];
    window.currentDateTo = new Date().toISOString().split('T')[0];
    window.currentPage = 1;
    
    loadAssetsData();
}

// Refresh data
function refreshData() {
    loadAssetsData();
    showSuccess('Data refreshed successfully');
}

// Export to Excel
function exportToExcel() {
    const dateFrom = window.currentDateFrom;
    const dateTo = window.currentDateTo;
    
    // Create export URL
    const exportUrl = `fixedasset_acquisition_report_xl.php?ADate1=${dateFrom}&ADate2=${dateTo}`;
    
    // Open in new window/tab
    window.open(exportUrl, '_blank');
    showSuccess('Export initiated. Please wait for the file to download.');
}

// Utility functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function escapeHtml(text) {
    if (text === null || text === undefined) return '';
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.toString().replace(/[&<>"']/g, function(m) { return map[m]; });
}

function formatDate(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

function numberFormat(number) {
    if (number === null || number === undefined) return '0.00';
    return parseFloat(number).toFixed(2);
}
