// Payment Approval Modern JavaScript
$(document).ready(function() {
    initializePage();
    setupEventListeners();
    setupSidebar();
    loadPaymentData();
});

// Page initialization
function initializePage() {
    // Setup pagination variables
    window.currentPage = 1;
    window.itemsPerPage = 10;
    window.totalPages = 1;
    window.currentSearch = '';
    window.currentModeFilter = '';
    window.currentStatusFilter = '';
    
    // Setup search parameters
    window.supplierSearch = '';
    window.docnoSearch = '';
    window.dateFrom = '';
    window.dateTo = '';
}

// Setup event listeners
function setupEventListeners() {
    // Search functionality
    $('#paymentSearch').on('input', debounce(function() {
        window.currentSearch = $(this).val();
        window.currentPage = 1;
        loadPaymentData();
    }, 300));

    // Search button
    $('#searchBtn').on('click', function() {
        window.currentSearch = $('#paymentSearch').val();
        window.currentPage = 1;
        loadPaymentData();
    });

    // Clear search
    $('#clearSearchBtn').on('click', function() {
        $('#paymentSearch').val('');
        window.currentSearch = '';
        window.currentPage = 1;
        loadPaymentData();
    });

    // Mode filter
    $('#modeFilter').on('change', function() {
        window.currentModeFilter = $(this).val();
        window.currentPage = 1;
        loadPaymentData();
    });

    // Status filter
    $('#statusFilter').on('change', function() {
        window.currentStatusFilter = $(this).val();
        window.currentPage = 1;
        loadPaymentData();
    });

    // Items per page
    $('#itemsPerPage').on('change', function() {
        window.itemsPerPage = parseInt($(this).val());
        window.currentPage = 1;
        loadPaymentData();
    });

    // Form inputs
    $('#supplierSearch').on('input', debounce(function() {
        window.supplierSearch = $(this).val();
    }, 300));

    $('#docnoSearch').on('input', debounce(function() {
        window.docnoSearch = $(this).val();
    }, 300));

    $('#dateFrom').on('change', function() {
        window.dateFrom = $(this).val();
    });

    $('#dateTo').on('change', function() {
        window.dateTo = $(this).val();
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

// Search payments using form
function searchPayments() {
    window.currentPage = 1;
    loadPaymentData();
}

// Load payment data via AJAX
function loadPaymentData() {
    showLoading();
    
    const params = {
        page: window.currentPage,
        limit: window.itemsPerPage,
        search: window.currentSearch,
        supplier: window.supplierSearch,
        docno: window.docnoSearch,
        dateFrom: window.dateFrom,
        dateTo: window.dateTo,
        mode: window.currentModeFilter,
        status: window.currentStatusFilter
    };

    $.ajax({
        url: 'get_payment_approval.php',
        method: 'GET',
        data: params,
        dataType: 'json',
        success: function(response) {
            hideLoading();
            
            if (response.success) {
                updatePaginationInfo(response.pagination);
                renderPaymentsTable(response.payments);
                renderPagination(response.pagination);
            } else {
                showError('Error loading payments: ' + (response.message || 'Unknown error'));
                $('#paymentsTableBody').html('<tr><td colspan="11" class="text-center">Error loading data</td></tr>');
            }
        },
        error: function(xhr, status, error) {
            hideLoading();
            console.error('AJAX Error:', error);
            showError('Failed to load payment data. Please try again.');
            $('#paymentsTableBody').html('<tr><td colspan="11" class="text-center">Error loading data</td></tr>');
        }
    });
}

// Update pagination info
function updatePaginationInfo(pagination) {
    const start = ((pagination.page - 1) * pagination.limit) + 1;
    const end = Math.min(pagination.page * pagination.limit, pagination.total);
    $('#paginationInfo').text(`Showing ${start} to ${end} of ${pagination.total} items`);
}

// Render payments table
function renderPaymentsTable(payments) {
    const tbody = $('#paymentsTableBody');
    
    if (payments.length === 0) {
        tbody.html(`
            <tr>
                <td colspan="11" class="text-center py-8">
                    <div class="no-data">
                        <i class="fas fa-inbox"></i>
                        <p>No payment transactions found</p>
                    </div>
                </td>
            </tr>
        `);
        return;
    }

    let html = '';
    payments.forEach((payment, index) => {
        const serialNumber = ((window.currentPage - 1) * window.itemsPerPage) + index + 1;
        
        html += `
            <tr class="payment-row">
                <td>${serialNumber}</td>
                <td>${escapeHtml(payment.date)}</td>
                <td>${escapeHtml(payment.docno)}</td>
                <td>${escapeHtml(payment.mode)}</td>
                <td>${escapeHtml(payment.instrument_number)}</td>
                <td>${escapeHtml(payment.supplier_name)}</td>
                <td>${escapeHtml(payment.bank_code)}</td>
                <td>${escapeHtml(payment.bank_name)}</td>
                <td>${escapeHtml(payment.account_number)}</td>
                <td class="amount-cell">${formatCurrency(payment.amount)}</td>
                <td class="actions-cell">
                    <a href="paymententry1.php?paymentdocno=${payment.docno}&cbfrmflag1=cbfrmflag1" 
                       class="action-btn view-btn" title="View Payment">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="paymentapprovallist1.php?st=del&anum=${payment.docno}" 
                       class="action-btn delete-btn" title="Delete Payment" 
                       onclick="return confirmDeletePayment('${payment.docno}')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
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
        loadPaymentData();
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
    $('#paymentsTableBody').html(`
        <tr>
            <td colspan="11" class="text-center py-8">
                <div class="loading-spinner">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Loading payment transactions...</p>
                </div>
            </td>
        </tr>
    `);
}

// Hide loading state
function hideLoading() {
    // Loading state is handled by renderPaymentsTable
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

// Clear form
function clearForm() {
    $('#searchForm')[0].reset();
    $('#supplierSearch').val('');
    $('#docnoSearch').val('');
    $('#dateFrom').val('');
    $('#dateTo').val('');
    
    // Reset global variables
    window.supplierSearch = '';
    window.docnoSearch = '';
    window.dateFrom = '';
    window.dateTo = '';
    
    // Reset search and reload
    window.currentSearch = '';
    window.currentPage = 1;
    loadPaymentData();
}

// Reset form
function resetForm() {
    clearForm();
    showSuccess('Search form has been reset');
}

// Confirmation dialog for deleting payment
function confirmDeletePayment(docno) {
    return confirm(`Are you sure you want to delete the Payment Voucher ${docno}?\n\nThis action cannot be undone.`);
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

function formatCurrency(amount) {
    if (amount === null || amount === undefined) return '0.00';
    return parseFloat(amount).toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}
