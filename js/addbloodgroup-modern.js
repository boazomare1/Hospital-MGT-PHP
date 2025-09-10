// Blood Group Master Modern JavaScript

// Global variables
let currentPage = 1;
let itemsPerPage = 10;
let allBloodGroups = [];
let filteredBloodGroups = [];

// DOM elements
let bloodGroupInput;
let submitBtn;
let bloodGroupTableBody;
let deletedBloodGroupTableBody;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
});

// Initialize DOM elements
function initializeElements() {
    bloodGroupInput = document.getElementById('bloodgroup');
    submitBtn = document.getElementById('submitBtn');
    bloodGroupTableBody = document.getElementById('bloodGroupTableBody');
    deletedBloodGroupTableBody = document.getElementById('deletedBloodGroupTableBody');
}

// Setup event listeners
function setupEventListeners() {
    // Form submission
    const form = document.getElementById('bloodGroupForm');
    if (form) {
        form.addEventListener('submit', handleFormSubmit);
    }

    // Input validation
    if (bloodGroupInput) {
        bloodGroupInput.addEventListener('input', validateInput);
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
}

// Setup sidebar toggle functionality
function setupSidebarToggle() {
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
}

// Handle form submission
function handleFormSubmit(event) {
    event.preventDefault();
    
    const bloodGroup = bloodGroupInput.value.trim();
    
    if (!bloodGroup) {
        showAlert('Please enter a blood group name.', 'error');
        bloodGroupInput.focus();
        return;
    }
    
    if (bloodGroup.length > 100) {
        showAlert('Blood group name must be 100 characters or less.', 'error');
        bloodGroupInput.focus();
        return;
    }
    
    // Submit the form
    event.target.submit();
}

// Validate input
function validateInput() {
    const bloodGroup = bloodGroupInput.value.trim();
    
    if (bloodGroup.length > 100) {
        showAlert('Blood group name must be 100 characters or less.', 'error');
        bloodGroupInput.value = bloodGroup.substring(0, 100);
    }
}

// Show alert message
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;

    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    alert.innerHTML = `
        <i class="fas fa-${getAlertIcon(type)} alert-icon"></i>
        <span>${message}</span>
    `;

    alertContainer.appendChild(alert);

    // Auto-remove after 5 seconds
    setTimeout(() => {
        alert.remove();
    }, 5000);
}

// Get alert icon based on type
function getAlertIcon(type) {
    switch (type) {
        case 'success': return 'check-circle';
        case 'error': return 'exclamation-triangle';
        case 'warning': return 'exclamation-circle';
        default: return 'info-circle';
    }
}

// Confirm delete action
function confirmDelete(bloodGroupName, autoNumber) {
    if (confirm(`Are you sure you want to delete the blood group "${bloodGroupName}"?`)) {
        window.location.href = `addbloodgroup.php?st=del&anum=${autoNumber}`;
    }
}

// Confirm activate action
function confirmActivate(bloodGroupName, autoNumber) {
    if (confirm(`Are you sure you want to activate the blood group "${bloodGroupName}"?`)) {
        window.location.href = `addbloodgroup.php?st=activate&anum=${autoNumber}`;
    }
}

// Utility function to escape HTML
function escapeHtml(text) {
    if (text === null || text === undefined) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Format date
function formatDate(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString();
}

// Reset form
function resetForm() {
    if (bloodGroupInput) {
        bloodGroupInput.value = '';
    }
    showAlert('Form has been reset.', 'info');
}

// Refresh page
function refreshPage() {
    window.location.reload();
}

// Export to Excel
function exportToExcel() {
    // Create a simple CSV export
    let csvContent = "data:text/csv;charset=utf-8,";
    csvContent += "Blood Group,Status,Record Date,Username\n";
    
    // Add data rows
    allBloodGroups.forEach(group => {
        csvContent += `"${group.bloodgroup}","${group.recordstatus || 'Active'}","${group.recorddate || ''}","${group.username || ''}"\n`;
    });
    
    // Create download link
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "blood_groups.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    showAlert('Blood groups exported to CSV successfully.', 'success');
}

// Search functionality
function searchBloodGroups(searchTerm) {
    if (!searchTerm) {
        filteredBloodGroups = [...allBloodGroups];
    } else {
        filteredBloodGroups = allBloodGroups.filter(group => 
            group.bloodgroup.toLowerCase().includes(searchTerm.toLowerCase())
        );
    }
    
    currentPage = 1;
    renderTable();
    updatePagination();
}

// Clear search
function clearSearch() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.value = '';
    }
    searchBloodGroups('');
}

// Pagination functions
function goToPage(page) {
    currentPage = page;
    renderTable();
    updatePagination();
}

function updatePagination() {
    const totalPages = Math.ceil(filteredBloodGroups.length / itemsPerPage);
    const paginationContainer = document.getElementById('paginationContainer');
    
    if (!paginationContainer) return;
    
    let paginationHTML = '';
    
    // Previous button
    paginationHTML += `
        <button class="btn btn-outline" onclick="goToPage(${currentPage - 1})" 
                ${currentPage === 1 ? 'disabled' : ''}>
            <i class="fas fa-chevron-left"></i> Previous
        </button>
    `;
    
    // Page numbers
    for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
            paginationHTML += `
                <button class="btn ${i === currentPage ? 'btn-primary' : 'btn-outline'}" 
                        onclick="goToPage(${i})">
                    ${i}
                </button>
            `;
        } else if (i === currentPage - 3 || i === currentPage + 3) {
            paginationHTML += `<span class="pagination-ellipsis">...</span>`;
        }
    }
    
    // Next button
    paginationHTML += `
        <button class="btn btn-outline" onclick="goToPage(${currentPage + 1})" 
                ${currentPage === totalPages ? 'disabled' : ''}>
            Next <i class="fas fa-chevron-right"></i>
        </button>
    `;
    
    paginationContainer.innerHTML = paginationHTML;
}

// Render table
function renderTable() {
    if (!bloodGroupTableBody) return;
    
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const pageData = filteredBloodGroups.slice(startIndex, endIndex);
    
    if (pageData.length === 0) {
        bloodGroupTableBody.innerHTML = `
            <tr>
                <td colspan="4" class="no-data">
                    <i class="fas fa-search"></i>
                    <p>No blood groups found matching the current search.</p>
                </td>
            </tr>
        `;
        return;
    }
    
    bloodGroupTableBody.innerHTML = pageData.map((group, index) => {
        const serialNumber = startIndex + index + 1;
        
        return `
            <tr>
                <td>${serialNumber}</td>
                <td>${escapeHtml(group.bloodgroup)}</td>
                <td>
                    <div class="action-buttons">
                        <button class="action-btn delete" 
                                onclick="confirmDelete('${escapeHtml(group.bloodgroup)}', '${group.auto_number}')"
                                title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                        <a href="editbloodgroup.php?st=edit&anum=${group.auto_number}" 
                           class="action-btn edit" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </td>
            </tr>
        `;
    }).join('');
}

// Initialize data (this would be populated from PHP)
function initializeData(bloodGroupsData) {
    allBloodGroups = bloodGroupsData || [];
    filteredBloodGroups = [...allBloodGroups];
    renderTable();
    updatePagination();
}

// Show loading state
function showLoading() {
    if (bloodGroupTableBody) {
        bloodGroupTableBody.innerHTML = `
            <tr>
                <td colspan="4" class="loading">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Loading blood groups...</p>
                </td>
            </tr>
        `;
    }
}

// Show error state
function showError(message) {
    if (bloodGroupTableBody) {
        bloodGroupTableBody.innerHTML = `
            <tr>
                <td colspan="4" class="error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p>${message}</p>
                </td>
            </tr>
        `;
    }
}















