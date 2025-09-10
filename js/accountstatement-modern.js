// Account Statement Modern JavaScript
// Global variables
let currentPage = 1;
let itemsPerPage = 10;
let allTransactions = [];
let filteredTransactions = [];
let currentAccountInfo = null;
let currentSummary = null;

// Initialize when document is ready
$(document).ready(function() {
    setupEventListeners();
    setupSidebar();
    setupAutocomplete();
});

// Setup event listeners
function setupEventListeners() {
    // Search form submission
    $('#accountStatementForm').on('submit', function(e) {
        e.preventDefault();
        loadAccountStatement();
    });

    // Search input event for filtering
    $('#transactionSearch').on('input', function() {
        filterTransactions();
    });

    // Date range change
    $('#dateFrom, #dateTo').on('change', function() {
        // Auto-search when dates change
        if ($('#searchAccountCode').val() && $('#searchAccountAnum').val()) {
            loadAccountStatement();
        }
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
    $('#menuToggle').on('click', function() {
        toggleSidebar();
    });

    $('#sidebarToggle').on('click', function() {
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

// Setup autocomplete for account search
function setupAutocomplete() {
    $('#searchAccountName').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: 'ajaxaccount_search.php',
                dataType: 'json',
                data: {
                    term: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 1,
        select: function(event, ui) {
            $('#searchAccountCode').val(ui.item.id);
            $('#searchAccountAnum').val(ui.item.anum);
            $('#searchAccountName').val(ui.item.value);
            
            // Auto-load statement if dates are set
            if ($('#dateFrom').val() && $('#dateTo').val()) {
                loadAccountStatement();
            }
        }
    });
}

// Load account statement from server
function loadAccountStatement() {
    const searchAccount = $('#searchAccountName').val();
    const searchAccountCode = $('#searchAccountCode').val();
    const searchAccountAnum = $('#searchAccountAnum').val();
    const dateFrom = $('#dateFrom').val();
    const dateTo = $('#dateTo').val();

    // Validate required fields
    if (!searchAccountCode || !searchAccountAnum) {
        showAlert('Please select an account first.', 'error');
        return;
    }

    if (!dateFrom || !dateTo) {
        showAlert('Please select both start and end dates.', 'error');
        return;
    }

    // Show loading state
    $('#loadingIndicator').show();
    $('#summaryCards').hide();
    $('#statementTableBody').html('<tr><td colspan="10" class="no-data">Loading...</td></tr>');

    // Build query parameters
    const params = new URLSearchParams();
    params.append('search_account', searchAccount);
    params.append('search_account_code', searchAccountCode);
    params.append('search_account_anum', searchAccountAnum);
    params.append('date_from', dateFrom);
    params.append('date_to', dateTo);

    // Make AJAX call
    $.ajax({
        url: 'get_account_statement.php',
        method: 'GET',
        data: params.toString(),
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                currentAccountInfo = response.account_info;
                currentSummary = response.summary;
                allTransactions = response.transactions;
                filteredTransactions = [...allTransactions];
                currentPage = 1;
                
                updateAccountInfo();
                updateSummaryCards();
                renderTable();
                updatePagination();
                
                $('#summaryCards').show();
                showAlert('Account statement loaded successfully.', 'success');
            } else {
                showAlert('Error loading account statement: ' + response.error, 'error');
                $('#statementTableBody').html('<tr><td colspan="10" class="no-data">Error loading data. Please try again.</td></tr>');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            showAlert('Error loading account statement. Please try again.', 'error');
            $('#statementTableBody').html('<tr><td colspan="10" class="no-data">Error loading data. Please try again.</td></tr>');
        },
        complete: function() {
            $('#loadingIndicator').hide();
        }
    });
}

// Update account information display
function updateAccountInfo() {
    if (currentAccountInfo) {
        $('#accountName').text(currentAccountInfo.name);
        $('#accountCode').text(currentAccountInfo.code);
        $('#accountCurrency').text(currentAccountInfo.currency);
        $('#exchangeRate').text(currentAccountInfo.exchange_rate);
    }
}

// Update summary cards
function updateSummaryCards() {
    if (currentSummary) {
        $('#openingBalance').text('₹' + currentSummary.opening_balance);
        $('#totalDebit').text('₹' + currentSummary.total_debit);
        $('#totalCredit').text('₹' + currentSummary.total_credit);
        $('#currentBalance').text('₹' + currentSummary.current_balance);
        $('#aging30').text('₹' + currentSummary.aging_buckets['30_days']);
        $('#aging60').text('₹' + currentSummary.aging_buckets['60_days']);
        $('#aging90').text('₹' + currentSummary.aging_buckets['90_days']);
        $('#aging120').text('₹' + currentSummary.aging_buckets['120_days']);
        $('#aging180').text('₹' + currentSummary.aging_buckets['180_days']);
        $('#aging180Plus').text('₹' + currentSummary.aging_buckets['180_plus_days']);
    }
}

// Filter transactions
function filterTransactions() {
    const searchTerm = $('#transactionSearch').val().toLowerCase();

    filteredTransactions = allTransactions.filter(transaction => {
        return !searchTerm || 
            transaction.description.toLowerCase().includes(searchTerm) ||
            transaction.bill_number.toLowerCase().includes(searchTerm) ||
            transaction.mrd_number.toLowerCase().includes(searchTerm);
    });

    currentPage = 1;
    renderTable();
    updatePagination();
}

// Clear all filters
function clearFilters() {
    $('#transactionSearch').val('');
    filteredTransactions = [...allTransactions];
    currentPage = 1;
    renderTable();
    updatePagination();
}

// Render table with current data
function renderTable() {
    const tbody = $('#statementTableBody');
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const pageData = filteredTransactions.slice(startIndex, endIndex);

    if (pageData.length === 0) {
        tbody.html('<tr><td colspan="10" class="no-data">No transactions found. Try adjusting your search criteria.</td></tr>');
        return;
    }

    tbody.empty();
    pageData.forEach((transaction, index) => {
        const row = `
            <tr class="table-row ${index % 2 === 0 ? 'even' : 'odd'}">
                <td class="sno-cell">${startIndex + index + 1}</td>
                <td class="date-cell">${transaction.date}</td>
                <td class="description-cell">${transaction.description}</td>
                <td class="mrd-cell">${transaction.mrd_number || '-'}</td>
                <td class="bill-number-cell">${transaction.bill_number}</td>
                <td class="dispatch-date-cell">${transaction.dispatch_date || '-'}</td>
                <td class="debit-cell amount-cell">${transaction.debit ? '₹' + transaction.debit : ''}</td>
                <td class="credit-cell amount-cell">${transaction.credit ? '₹' + transaction.credit : ''}</td>
                <td class="days-cell">${transaction.days} days</td>
                <td class="balance-cell amount-cell">₹${transaction.current_balance}</td>
            </tr>
        `;
        tbody.append(row);
    });
}

// Update pagination controls
function updatePagination() {
    const totalPages = Math.ceil(filteredTransactions.length / itemsPerPage);
    const pagination = $('.pagination');
    
    if (totalPages <= 1) {
        pagination.hide();
        return;
    }
    
    pagination.show();
    
    // Update pagination info
    const startItem = (currentPage - 1) * itemsPerPage + 1;
    const endItem = Math.min(currentPage * itemsPerPage, filteredTransactions.length);
    $('.pagination-info').text(`Showing ${startItem} to ${endItem} of ${filteredTransactions.length} transactions`);
    
    // Update pagination buttons
    const controls = $('.pagination-controls');
    controls.empty();
    
    // Previous button
    const prevBtn = `<button class="pagination-btn" onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>Previous</button>`;
    controls.append(prevBtn);
    
    // Page numbers
    for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
            const pageBtn = `<button class="pagination-btn ${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">${i}</button>`;
            controls.append(pageBtn);
        } else if (i === currentPage - 3 || i === currentPage + 3) {
            controls.append('<span class="pagination-ellipsis">...</span>');
        }
    }
    
    // Next button
    const nextBtn = `<button class="pagination-btn" onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>Next</button>`;
    controls.append(nextBtn);
}

// Change page
function changePage(page) {
    const totalPages = Math.ceil(filteredTransactions.length / itemsPerPage);
    if (page >= 1 && page <= totalPages) {
        currentPage = page;
        renderTable();
        updatePagination();
        
        // Scroll to top of table
        $('.data-table-container')[0].scrollIntoView({ behavior: 'smooth' });
    }
}

// Export to Excel
function exportToExcel() {
    if (!currentAccountInfo || filteredTransactions.length === 0) {
        showAlert('No data to export. Please load an account statement first.', 'warning');
        return;
    }
    
    const dateFrom = $('#dateFrom').val();
    const dateTo = $('#dateTo').val();
    const url = `print_accountstatement.php?cbfrmflag1=cbfrmflag1&ADate1=${dateFrom}&ADate2=${dateTo}&searchsuppliername=${encodeURIComponent(currentAccountInfo.name)}&searchsupplieranum=${currentAccountInfo.anum}&searchsuppliercode=${currentAccountInfo.code}`;
    
    window.open(url, '_blank');
}

// Export to PDF
function exportToPDF() {
    if (!currentAccountInfo || filteredTransactions.length === 0) {
        showAlert('No data to export. Please load an account statement first.', 'warning');
        return;
    }
    
    const dateFrom = $('#dateFrom').val();
    const dateTo = $('#dateTo').val();
    const url = `print_accountstatementpdf.php?cbfrmflag1=cbfrmflag1&ADate1=${dateFrom}&ADate2=${dateTo}&searchsuppliername=${encodeURIComponent(currentAccountInfo.name)}&searchsupplieranum=${currentAccountInfo.anum}&searchsuppliercode=${currentAccountInfo.code}`;
    
    window.open(url, '_blank');
}

// Show alert message
function showAlert(message, type = 'info') {
    const alertDiv = $('<div>')
        .addClass(`alert alert-${type}`)
        .text(message)
        .css({
            position: 'fixed',
            top: '20px',
            right: '20px',
            zIndex: 9999,
            padding: '1rem',
            borderRadius: '0.5rem',
            color: 'white',
            backgroundColor: type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : type === 'warning' ? '#f59e0b' : '#3b82f6',
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

// Initialize date pickers
function initializeDatePickers() {
    // Set default dates
    const today = new Date();
    const lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
    
    $('#dateFrom').val(lastMonth.toISOString().split('T')[0]);
    $('#dateTo').val(today.toISOString().split('T')[0]);
}

// Call date picker initialization when document is ready
$(document).ready(function() {
    initializeDatePickers();
});
