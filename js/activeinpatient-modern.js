// Active Inpatient List Modern JavaScript

// Global variables
let currentPage = 1;
let itemsPerPage = 10;
let totalPages = 0;
let totalRecords = 0;
let allInpatients = [];
let filteredInpatients = [];
let currentFilters = {};

// DOM elements
let inpatientsTableBody;
let paginationInfo;
let prevPageBtn;
let nextPageBtn;
let pageNumbersContainer;
let itemsPerPageSelect;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    loadInitialData();
});

// Initialize DOM elements
function initializeElements() {
    inpatientsTableBody = document.getElementById('inpatientsTableBody');
    paginationInfo = document.getElementById('paginationInfo');
    prevPageBtn = document.getElementById('prevPage');
    nextPageBtn = document.getElementById('nextPage');
    pageNumbersContainer = document.getElementById('pageNumbers');
    itemsPerPageSelect = document.getElementById('itemsPerPage');
}

// Setup event listeners
function setupEventListeners() {
    // Filter form submission
    const filterForm = document.getElementById('filterForm');
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            applyFilters();
        });
    }

    // Items per page change
    if (itemsPerPageSelect) {
        itemsPerPageSelect.addEventListener('change', function() {
            itemsPerPage = parseInt(this.value);
            currentPage = 1;
            renderTable();
            updatePagination();
        });
    }

    // Sidebar toggle
    const menuToggle = document.getElementById('menuToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainContainer = document.querySelector('.main-container-with-sidebar');

    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }

    // Search input debouncing
    const searchInputs = ['patientSearch', 'patientCodeSearch', 'visitCodeSearch'];
    searchInputs.forEach(inputId => {
        const input = document.getElementById(inputId);
        if (input) {
            input.addEventListener('input', debounce(function() {
                applyFilters();
            }, 300));
        }
    });

    // Filter dropdowns
    const filterDropdowns = ['locationFilter', 'wardFilter'];
    filterDropdowns.forEach(dropdownId => {
        const dropdown = document.getElementById(dropdownId);
        if (dropdown) {
            dropdown.addEventListener('change', function() {
                applyFilters();
            });
        }
    });
}

// Load initial data
function loadInitialData() {
    showLoading();
    fetchInpatients();
}

// Fetch inpatients data from API
function fetchInpatients() {
    const params = new URLSearchParams({
        page: currentPage,
        limit: itemsPerPage,
        ...currentFilters
    });

    fetch(`get_active_inpatients.php?${params}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                allInpatients = data.inpatients;
                filteredInpatients = data.inpatients;
                totalRecords = data.pagination.total;
                totalPages = data.pagination.pages;
                
                // Populate filter dropdowns
                populateLocationFilter(data.locations);
                populateWardFilter(data.wards);
                
                renderTable();
                updatePagination();
                hideLoading();
            } else {
                showError(data.message || 'Error loading data');
                hideLoading();
            }
        })
        .catch(error => {
            console.error('Error fetching inpatients:', error);
            showError('Error loading data. Please try again.');
            hideLoading();
        });
}

// Populate location filter dropdown
function populateLocationFilter(locations) {
    const locationFilter = document.getElementById('locationFilter');
    if (locationFilter && locations) {
        // Keep the "All Locations" option
        const allOption = locationFilter.querySelector('option[value=""]');
        locationFilter.innerHTML = '';
        if (allOption) {
            locationFilter.appendChild(allOption);
        }
        
        locations.forEach(location => {
            const option = document.createElement('option');
            option.value = location.code;
            option.textContent = location.name;
            locationFilter.appendChild(option);
        });
    }
}

// Populate ward filter dropdown
function populateWardFilter(wards) {
    const wardFilter = document.getElementById('wardFilter');
    if (wardFilter && wards) {
        // Keep the "All Wards" option
        const allOption = wardFilter.querySelector('option[value=""]');
        wardFilter.innerHTML = '';
        if (allOption) {
            wardFilter.appendChild(allOption);
        }
        
        wards.forEach(ward => {
            const option = document.createElement('option');
            option.value = ward.id;
            option.textContent = ward.name;
            wardFilter.appendChild(option);
        });
    }
}

// Apply filters
function applyFilters() {
    currentFilters = {
        location: document.getElementById('locationFilter')?.value || '',
        ward: document.getElementById('wardFilter')?.value || '',
        searchPatient: document.getElementById('patientSearch')?.value || '',
        searchPatientCode: document.getElementById('patientCodeSearch')?.value || '',
        searchVisitCode: document.getElementById('visitCodeSearch')?.value || ''
    };
    
    currentPage = 1;
    fetchInpatients();
}

// Render the table
function renderTable() {
    if (!inpatientsTableBody) return;
    
    if (filteredInpatients.length === 0) {
        inpatientsTableBody.innerHTML = `
            <tr>
                <td colspan="12" class="no-data">
                    <i class="fas fa-inbox"></i>
                    <p>No inpatients found matching the current filters.</p>
                </td>
            </tr>
        `;
        return;
    }
    
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const pageData = filteredInpatients.slice(startIndex, endIndex);
    
    inpatientsTableBody.innerHTML = pageData.map((inpatient, index) => {
        const serialNumber = startIndex + index + 1;
        
        return `
            <tr>
                <td>${serialNumber}</td>
                <td>
                    <span class="package-label">${inpatient.package || 'N/A'}</span>
                </td>
                <td>${escapeHtml(inpatient.patientname || 'N/A')}</td>
                <td>${inpatient.age || 'N/A'}</td>
                <td>${inpatient.gender || 'N/A'}</td>
                <td>${escapeHtml(inpatient.patientcode || 'N/A')}</td>
                <td>${formatDate(inpatient.consultationdate) || 'N/A'}</td>
                <td>${escapeHtml(inpatient.visitcode || 'N/A')}</td>
                <td>${escapeHtml(inpatient.ward_name || inpatient.ward || 'N/A')}</td>
                <td>${escapeHtml(inpatient.bed_name || inpatient.bed || 'N/A')}</td>
                <td>${escapeHtml(inpatient.accountfullname || 'N/A')}</td>
                <td>
                    <select class="action-dropdown" onchange="handleAction(this.value, '${escapeHtml(inpatient.patientcode)}', '${escapeHtml(inpatient.visitcode)}')">
                        <option value="">Select Action</option>
                        <option value="view">View Details</option>
                        <option value="edit">Edit</option>
                        <option value="discharge">Discharge</option>
                    </select>
                </td>
            </tr>
        `;
    }).join('');
}

// Update pagination controls
function updatePagination() {
    if (!paginationInfo || !prevPageBtn || !nextPageBtn || !pageNumbersContainer) return;
    
    const startItem = (currentPage - 1) * itemsPerPage + 1;
    const endItem = Math.min(currentPage * itemsPerPage, totalRecords);
    
    paginationInfo.textContent = `Showing ${startItem} to ${endItem} of ${totalRecords} items`;
    
    // Update previous/next buttons
    prevPageBtn.disabled = currentPage <= 1;
    nextPageBtn.disabled = currentPage >= totalPages;
    
    // Generate page numbers
    pageNumbersContainer.innerHTML = '';
    
    const maxVisiblePages = 5;
    let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
    let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
    
    if (endPage - startPage + 1 < maxVisiblePages) {
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
    }
    
    for (let i = startPage; i <= endPage; i++) {
        const pageBtn = document.createElement('button');
        pageBtn.textContent = i;
        pageBtn.className = i === currentPage ? 'active' : '';
        pageBtn.onclick = () => goToPage(i);
        pageNumbersContainer.appendChild(pageBtn);
    }
}

// Navigation functions
function previousPage() {
    if (currentPage > 1) {
        goToPage(currentPage - 1);
    }
}

function nextPage() {
    if (currentPage < totalPages) {
        goToPage(currentPage + 1);
    }
}

function goToPage(page) {
    currentPage = page;
    renderTable();
    updatePagination();
}

// Handle action dropdown changes
function handleAction(action, patientCode, visitCode) {
    switch (action) {
        case 'view':
            viewPatientDetails(patientCode, visitCode);
            break;
        case 'edit':
            editPatient(patientCode, visitCode);
            break;
        case 'discharge':
            dischargePatient(patientCode, visitCode);
            break;
        default:
            break;
    }
}

// View patient details
function viewPatientDetails(patientCode, visitCode) {
    // Implement view functionality
    console.log('View patient:', patientCode, visitCode);
    alert(`View details for patient: ${patientCode}, visit: ${visitCode}`);
}

// Edit patient
function editPatient(patientCode, visitCode) {
    // Implement edit functionality
    console.log('Edit patient:', patientCode, visitCode);
    alert(`Edit patient: ${patientCode}, visit: ${visitCode}`);
}

// Discharge patient
function dischargePatient(patientCode, visitCode) {
    if (confirm(`Are you sure you want to discharge patient ${patientCode}?`)) {
        // Implement discharge functionality
        console.log('Discharge patient:', patientCode, visitCode);
        alert(`Patient ${patientCode} discharged successfully`);
    }
}

// Clear all filters
function clearFilters() {
    const filterForm = document.getElementById('filterForm');
    if (filterForm) {
        filterForm.reset();
    }
    
    currentFilters = {};
    currentPage = 1;
    fetchInpatients();
}

// Refresh data
function refreshData() {
    fetchInpatients();
}

// Show loading state
function showLoading() {
    if (inpatientsTableBody) {
        inpatientsTableBody.innerHTML = `
            <tr>
                <td colspan="12" class="loading-spinner">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Loading inpatients data...</p>
                </td>
            </tr>
        `;
    }
}

// Hide loading state
function hideLoading() {
    // Loading state is cleared when renderTable() is called
}

// Show error message
function showError(message) {
    if (inpatientsTableBody) {
        inpatientsTableBody.innerHTML = `
            <tr>
                <td colspan="12" class="no-data">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p>${escapeHtml(message)}</p>
                </td>
            </tr>
        `;
    }
}

// Utility functions
function escapeHtml(text) {
    if (text === null || text === undefined) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function formatDate(dateString) {
    if (!dateString) return '';
    try {
        const date = new Date(dateString);
        return date.toLocaleDateString();
    } catch (e) {
        return dateString;
    }
}

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
