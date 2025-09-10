// Corporate Outstanding Modern JavaScript
// Global variables
let currentPage = 1;
let itemsPerPage = 10;
let allTransactions = [];
let filteredTransactions = [];

// Initialize when document is ready
$(document).ready(function() {
    loadTransactions();
    setupEventListeners();
    setupSidebar();
});

// Setup event listeners
function setupEventListeners() {
    // Search input event
    $('#transactionSearch').on('input', function() {
        filterTransactions();
    });

    // Age filter change
    $('#ageFilter').on('change', function() {
        filterTransactions();
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

// Load transactions from server
function loadTransactions() {
    // Get form values
    const searchAccount = $('#searchsuppliername').val();
    const asOnDate = $('#ADate2').val();

    // Build query parameters
    const params = new URLSearchParams();
    if (searchAccount) params.append('search_account', searchAccount);
    if (asOnDate) params.append('as_on_date', asOnDate);

    // Make AJAX call
    $.ajax({
        url: 'get_corporate_outstanding.php',
        method: 'GET',
        data: params.toString(),
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                allTransactions = response.transactions;
                filteredTransactions = [...allTransactions];
                currentPage = 1;
                updateSummary(response.summary);
                renderTable();
                updatePagination();
                $('#summaryCards').show();
            } else {
                console.error('Error loading transactions:', response.error);
                $('#outstandingTableBody').html('<tr><td colspan="10" class="no-data">Error loading data. Please try again.</td></tr>');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            $('#outstandingTableBody').html('<tr><td colspan="10" class="no-data">Error loading data. Please try again.</td></tr>');
        }
    });
}

// Update summary cards
function updateSummary(summary) {
    $('#totalOutstanding').text('₹' + summary.total_outstanding);
    $('#totalCount').text(summary.total_count);
    $('#aging30').text('₹' + summary.age_buckets['0-30']);
    $('#aging90').text('₹' + (parseFloat(summary.age_buckets['61-90'].replace(/,/g, '')) + parseFloat(summary.age_buckets['91-120'].replace(/,/g, '')) + parseFloat(summary.age_buckets['120+'].replace(/,/g, ''))).toLocaleString('en-IN', {minimumFractionDigits: 2}));
}

// Filter transactions
function filterTransactions() {
    const searchTerm = $('#transactionSearch').val().toLowerCase();
    const ageFilter = $('#ageFilter').val();

    filteredTransactions = allTransactions.filter(transaction => {
        const matchesSearch = !searchTerm || 
            transaction.description.toLowerCase().includes(searchTerm) ||
            transaction.billnumber.toLowerCase().includes(searchTerm) ||
            transaction.mrdnumber.toLowerCase().includes(searchTerm);

        const matchesAge = !ageFilter || transaction.age_bucket === ageFilter;

        return matchesSearch && matchesAge;
    });

    currentPage = 1;
    renderTable();
    updatePagination();
}

// Clear all filters
function clearFilters() {
    $('#transactionSearch').val('');
    $('#ageFilter').val('');
    filteredTransactions = [...allTransactions];
    currentPage = 1;
    renderTable();
    updatePagination();
}

// Render table with current data
function renderTable() {
    const tbody = $('#outstandingTableBody');
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const pageData = filteredTransactions.slice(startIndex, endIndex);

    if (pageData.length === 0) {
        tbody.html('<tr><td colspan="10" class="no-data">No outstanding transactions found. Try adjusting your search criteria.</td></tr>');
        return;
    }

    tbody.empty();
    pageData.forEach((transaction, index) => {
        const row = `
            <tr class="table-row ${index % 2 === 0 ? 'even' : 'odd'}">
                <td class="sno-cell">${startIndex + index + 1}</td>
                <td class="date-cell">${transaction.transactiondate}</td>
                <td class="description-cell">${transaction.description}</td>
                <td class="mrd-cell">${transaction.mrdnumber}</td>
                <td class="bill-number-cell">${transaction.billnumber}</td>
                <td class="disp-date-cell">${transaction.dispatchdate || '-'}</td>
                <td class="amount-cell">₹${transaction.transactionamount}</td>
                <td class="outstanding-cell">₹${transaction.outstanding_amount}</td>
                <td class="days-cell">${transaction.days_outstanding} days</td>
                <td class="actions-cell">
                    <div class="action-buttons">
                        <a href="corporateoutstanding.php?view=${transaction.auto_number}" class="action-btn view-btn" title="View Details">
                            <span class="action-icon">👁️</span>
                        </a>
                        <a href="print_corporateoutstandingpdf.php?id=${transaction.auto_number}" class="action-btn print-btn" title="Print PDF" target="_blank">
                            <span class="action-icon">📄</span>
                        </a>
                        <a href="print_corporateoutstanding.php?id=${transaction.auto_number}" class="action-btn edit-btn" title="Export Excel" target="_blank">
                            <span class="action-icon">📊</span>
                        </a>
                    </div>
                </td>
            </tr>
        `;
        tbody.append(row);
    });
}

// Update pagination controls
function updatePagination() {
    const totalPages = Math.ceil(filteredTransactions.length / itemsPerPage);
    const startIndex = (currentPage - 1) * itemsPerPage + 1;
    const endIndex = Math.min(currentPage * itemsPerPage, filteredTransactions.length);

    // Update info
    $('#startIndex').text(filteredTransactions.length > 0 ? startIndex : 0);
    $('#endIndex').text(endIndex);
    $('#totalItems').text(filteredTransactions.length);

    // Update buttons
    $('#prevBtn').prop('disabled', currentPage === 1);
    $('#nextBtn').prop('disabled', currentPage === totalPages);

    // Update page numbers
    const pageNumbers = $('#pageNumbers');
    pageNumbers.empty();

    if (totalPages <= 7) {
        // Show all page numbers
        for (let i = 1; i <= totalPages; i++) {
            pageNumbers.append(`
                <button class="pagination-btn ${i === currentPage ? 'active' : ''}" onclick="goToPage(${i})">${i}</button>
            `);
        }
    } else {
        // Show first, last, current, and neighbors
        const pages = [1];
        
        if (currentPage > 3) {
            pages.push('<span class="pagination-ellipsis">...</span>');
        }
        
        for (let i = Math.max(2, currentPage - 1); i <= Math.min(totalPages - 1, currentPage + 1); i++) {
            if (!pages.includes(i)) {
                pages.push(i);
            }
        }
        
        if (currentPage < totalPages - 2) {
            pages.push('<span class="pagination-ellipsis">...</span>');
        }
        
        if (totalPages > 1) {
            pages.push(totalPages);
        }

        pages.forEach(page => {
            if (typeof page === 'number') {
                pageNumbers.append(`
                    <button class="pagination-btn ${page === currentPage ? 'active' : ''}" onclick="goToPage(${page})">${page}</button>
                `);
            } else {
                pageNumbers.append(page);
            }
        });
    }
}

// Navigation functions
function goToPage(page) {
    currentPage = page;
    renderTable();
    updatePagination();
}

function previousPage() {
    if (currentPage > 1) {
        currentPage--;
        renderTable();
        updatePagination();
    }
}

function nextPage() {
    const totalPages = Math.ceil(filteredTransactions.length / itemsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        renderTable();
        updatePagination();
    }
}

function changeItemsPerPage() {
    itemsPerPage = parseInt($('#itemsPerPage').val());
    currentPage = 1;
    renderTable();
    updatePagination();
}

// Form submission handler
$('#searchForm').on('submit', function(e) {
    e.preventDefault();
    loadTransactions();
});















