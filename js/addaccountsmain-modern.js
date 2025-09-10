// Add Accounts Main Modern JavaScript
$(document).ready(function() {
    initializePage();
    setupEventListeners();
    setupSidebar();
    loadAccountsData();
});

// Page initialization
function initializePage() {
    // Setup pagination variables
    window.currentPage = 1;
    window.itemsPerPage = 10;
    window.totalPages = 1;
    window.currentSearch = '';
    window.currentSectionFilter = '';
    window.currentStatusFilter = '';
}

// Setup event listeners
function setupEventListeners() {
    // Search functionality
    $('#accountSearch').on('input', debounce(function() {
        window.currentSearch = $(this).val();
        window.currentPage = 1;
        loadAccountsData();
    }, 300));

    // Search button
    $('#searchBtn').on('click', function() {
        window.currentSearch = $('#accountSearch').val();
        window.currentPage = 1;
        loadAccountsData();
    });

    // Clear search
    $('#clearSearchBtn').on('click', function() {
        $('#accountSearch').val('');
        window.currentSearch = '';
        window.currentPage = 1;
        loadAccountsData();
    });

    // Section filter
    $('#sectionFilter').on('change', function() {
        window.currentSectionFilter = $(this).val();
        window.currentPage = 1;
        loadAccountsData();
    });

    // Status filter
    $('#statusFilter').on('change', function() {
        window.currentStatusFilter = $(this).val();
        window.currentPage = 1;
        loadAccountsData();
    });

    // Items per page
    $('#itemsPerPage').on('change', function() {
        window.itemsPerPage = parseInt($(this).val());
        window.currentPage = 1;
        loadAccountsData();
    });

    // Form submission
    $('#addAccountForm').on('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return false;
        }
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

    // Auto-uppercase for inputs
    $('#accountsmain, #id').on('input', function() {
        this.value = this.value.toUpperCase();
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

// Load accounts data via AJAX
function loadAccountsData() {
    showLoading();
    
    const params = {
        page: window.currentPage,
        limit: window.itemsPerPage,
        search: window.currentSearch,
        section: window.currentSectionFilter,
        status: window.currentStatusFilter
    };

    $.ajax({
        url: 'get_accounts_main.php',
        method: 'GET',
        data: params,
        dataType: 'json',
        success: function(response) {
            hideLoading();
            
            if (response.success) {
                updatePaginationInfo(response.pagination);
                renderAccountsTable(response.accounts);
                renderPagination(response.pagination);
            } else {
                showError('Error loading accounts: ' + (response.message || 'Unknown error'));
                $('#accountsTableBody').html('<tr><td colspan="5" class="text-center">Error loading data</td></tr>');
            }
        },
        error: function(xhr, status, error) {
            hideLoading();
            console.error('AJAX Error:', error);
            showError('Failed to load accounts data. Please try again.');
            $('#accountsTableBody').html('<tr><td colspan="5" class="text-center">Error loading data</td></tr>');
        }
    });
}

// Update pagination info
function updatePaginationInfo(pagination) {
    const start = ((pagination.page - 1) * pagination.limit) + 1;
    const end = Math.min(pagination.page * pagination.limit, pagination.total);
    $('#paginationInfo').text(`Showing ${start} to ${end} of ${pagination.total} items`);
}

// Render accounts table
function renderAccountsTable(accounts) {
    const tbody = $('#accountsTableBody');
    
    if (accounts.length === 0) {
        tbody.html(`
            <tr>
                <td colspan="5" class="text-center py-8">
                    <div class="no-data">
                        <i class="fas fa-inbox"></i>
                        <p>No accounts found</p>
                    </div>
                </td>
            </tr>
        `);
        return;
    }

    let html = '';
    accounts.forEach(account => {
        const statusBadge = account.status === 'Active' 
            ? '<span class="status-badge status-active"><i class="fas fa-check-circle"></i> Active</span>'
            : '<span class="status-badge status-inactive"><i class="fas fa-times-circle"></i> Inactive</span>';

        const actions = account.status === 'Active'
            ? `<a href="addaccountsmain.php?id=${account.id}&st=edit" class="action-btn edit-btn" title="Edit Account">
                   <i class="fas fa-edit"></i>
               </a>
               <a href="addaccountsmain.php?id=${account.id}&st=del" class="action-btn delete-btn" title="Delete Account" onclick="return confirmDelete('${account.account_name}')">
                   <i class="fas fa-trash"></i>
               </a>`
            : `<a href="addaccountsmain.php?id=${account.id}&st=activate" class="action-btn activate-btn" title="Activate Account" onclick="return confirmActivate('${account.account_name}')">
                   <i class="fas fa-check"></i>
               </a>`;

        html += `
            <tr class="account-row">
                <td class="account-id">${escapeHtml(account.id)}</td>
                <td class="account-name">${escapeHtml(account.account_name)}</td>
                <td class="account-section">${escapeHtml(account.parent_section)}</td>
                <td class="account-status">${statusBadge}</td>
                <td class="account-actions">${actions}</td>
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
        loadAccountsData();
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
    $('#accountsTableBody').html(`
        <tr>
            <td colspan="5" class="text-center py-8">
                <div class="loading-spinner">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Loading accounts...</p>
                </div>
            </td>
        </tr>
    `);
}

// Hide loading state
function hideLoading() {
    // Loading state is handled by renderAccountsTable
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

// Form validation
function validateForm() {
    let isValid = true;
    
    // Clear previous errors
    $('.form-group').removeClass('error');
    $('.error-message').remove();
    
    // Validate account ID
    const accountId = $('#id').val().trim();
    if (!accountId) {
        showFieldError($('#id').closest('.form-group'), 'Account ID is required');
        isValid = false;
    }
    
    // Validate account name
    const accountName = $('#accountsmain').val().trim();
    if (!accountName) {
        showFieldError($('#accountsmain').closest('.form-group'), 'Account name is required');
        isValid = false;
    }
    
    // Validate section
    const section = $('#section').val();
    if (!section) {
        showFieldError($('#section').closest('.form-group'), 'Section is required');
        isValid = false;
    }
    
    return isValid;
}

// Show field error
function showFieldError(formGroup, message) {
    formGroup.addClass('error');
    formGroup.append(`<div class="error-message">${message}</div>`);
}

// Clear form
function clearForm() {
    $('#addAccountForm')[0].reset();
    $('.form-group').removeClass('error');
    $('.error-message').remove();
    $('#id').focus();
}

// Reset form
function resetForm() {
    clearForm();
    showSuccess('Form has been reset');
}

// Confirmation dialogs
function confirmDelete(accountName) {
    return confirm(`Are you sure you want to delete the account "${accountName}"?\n\nThis action cannot be undone.`);
}

function confirmActivate(accountName) {
    return confirm(`Are you sure you want to activate the account "${accountName}"?`);
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
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}