// Lab Item Template Modern JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initializeSidebar();
    initializeSearch();
    initializePagination();
    initializeAlerts();
    initializeTemplateSelection();
    initializeFileUpload();
    initializeInlineEdit();
    initializeBulkActions();
});

// Sidebar functionality
function initializeSidebar() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }
    
    // Close sidebar when clicking outside
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 1024) {
            if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 1024) {
            sidebar.classList.remove('open');
        }
    });
}

// Search functionality
function initializeSearch() {
    const searchInput = document.querySelector('input[name="search1"]');
    const searchForm = document.querySelector('form[method="get"]');
    
    if (!searchInput || !searchForm) return;
    
    // Debounced search
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            performSearch();
        }, 500);
    });
    
    // Search form submission
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        performSearch();
    });
}

function performSearch() {
    const searchInput = document.querySelector('input[name="search1"]');
    const searchForm = document.querySelector('form[method="get"]');
    
    if (!searchInput || !searchForm) return;
    
    const searchValue = searchInput.value.trim();
    
    // Add search flag
    const searchFlag = document.createElement('input');
    searchFlag.type = 'hidden';
    searchFlag.name = 'searchflag1';
    searchFlag.value = 'searchflag1';
    searchForm.appendChild(searchFlag);
    
    // Submit form
    searchForm.submit();
}

// Pagination functionality
function initializePagination() {
    const paginationLinks = document.querySelectorAll('.pagination a');
    
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.href;
            window.location.href = url;
        });
    });
}

// Template selection functionality
function initializeTemplateSelection() {
    const templateSelect = document.querySelector('select[name="labtemplate"]');
    
    if (templateSelect) {
        templateSelect.addEventListener('change', function() {
            const form = this.closest('form');
            if (form) {
                form.submit();
            }
        });
    }
}

// File upload functionality
function initializeFileUpload() {
    const fileInput = document.querySelector('input[type="file"]');
    const uploadBtn = document.querySelector('input[name="uploadexcel"]');
    
    if (fileInput && uploadBtn) {
        fileInput.addEventListener('change', function() {
            const fileName = this.files[0]?.name;
            if (fileName) {
                uploadBtn.value = `Upload ${fileName}`;
                uploadBtn.style.background = '#10b981';
            } else {
                uploadBtn.value = 'Upload Excel';
                uploadBtn.style.background = '#3b82f6';
            }
        });
    }
}

// Inline edit functionality
function initializeInlineEdit() {
    // This will be called by the inline edit functions
}

function enablerate(sno) {
    const showElement = document.querySelector(`.showit${sno}`);
    const hideElement = document.querySelector(`.hideit${sno}`);
    
    if (showElement && hideElement) {
        showElement.style.display = 'block';
        hideElement.style.display = 'none';
        
        // Focus on the input field
        const input = showElement.querySelector('input');
        if (input) {
            input.focus();
            input.select();
        }
    }
}

function updaterate(sno, itemcode) {
    const tablename = document.getElementById('labtemplate')?.value || 'master_lab';
    const rateInput = document.getElementById(`rateperunit${sno}`);
    const getRate = rateInput?.value;
    
    if (!getRate) {
        alert('Please enter a valid rate');
        return;
    }
    
    // Show loading state
    const updateBtn = document.querySelector(`input[onclick="updaterate('${sno}','${itemcode}')"]`);
    if (updateBtn) {
        updateBtn.value = 'Updating...';
        updateBtn.disabled = true;
    }
    
    // Make AJAX request
    fetch('ajaxtemplate_rates.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'tablename': tablename,
            'get_rate': getRate,
            'sno': sno,
            'itemcode': itemcode,
            'source': 'lab'
        })
    })
    .then(response => response.text())
    .then(data => {
        // Update the display
        const showElement = document.querySelector(`.showit${sno}`);
        const hideElement = document.querySelector(`.hideit${sno}`);
        const displayElement = document.getElementById(`caredittxno_${sno}`);
        
        if (showElement && hideElement && displayElement) {
            showElement.style.display = 'none';
            hideElement.style.display = 'block';
            displayElement.textContent = getRate;
        }
        
        // Reset button
        if (updateBtn) {
            updateBtn.value = 'Update';
            updateBtn.disabled = false;
        }
        
        // Show success message
        showAlert('Rate updated successfully', 'success');
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Failed to update rate', 'failed');
        
        // Reset button
        if (updateBtn) {
            updateBtn.value = 'Update';
            updateBtn.disabled = false;
        }
    });
}

// Bulk actions functionality
function initializeBulkActions() {
    const selectAllCheckbox = document.querySelector('input[type="checkbox"][onchange="toggleAll(this)"]');
    const itemCheckboxes = document.querySelectorAll('input[name="newserselect[]"]');
    const updateBtn = document.querySelector('input[name="update"]');
    
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateUpdateButton();
        });
    }
    
    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateUpdateButton();
            updateSelectAllCheckbox();
        });
    });
    
    function updateUpdateButton() {
        const checkedBoxes = document.querySelectorAll('input[name="newserselect[]"]:checked');
        if (updateBtn) {
            updateBtn.disabled = checkedBoxes.length === 0;
            updateBtn.style.opacity = checkedBoxes.length === 0 ? '0.5' : '1';
        }
    }
    
    function updateSelectAllCheckbox() {
        const checkedBoxes = document.querySelectorAll('input[name="newserselect[]"]:checked');
        const totalBoxes = itemCheckboxes.length;
        
        if (selectAllCheckbox) {
            selectAllCheckbox.checked = checkedBoxes.length === totalBoxes;
            selectAllCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < totalBoxes;
        }
    }
}

// Alert handling
function initializeAlerts() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        // Auto-hide success alerts after 5 seconds
        if (alert.classList.contains('success')) {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }, 5000);
        }
        
        // Add close button to alerts
        const closeButton = document.createElement('button');
        closeButton.innerHTML = '&times;';
        closeButton.style.cssText = `
            position: absolute;
            top: 0.5rem;
            right: 0.75rem;
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
            color: inherit;
            opacity: 0.7;
            transition: opacity 0.2s;
        `;
        
        closeButton.addEventListener('click', function() {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                alert.remove();
            }, 300);
        });
        
        closeButton.addEventListener('mouseenter', function() {
            this.style.opacity = '1';
        });
        
        closeButton.addEventListener('mouseleave', function() {
            this.style.opacity = '0.7';
        });
        
        alert.style.position = 'relative';
        alert.appendChild(closeButton);
    });
}

// Utility functions
function showAlert(message, type = 'info') {
    const alertContainer = document.querySelector('.alert-container');
    if (!alertContainer) return;
    
    const alert = document.createElement('div');
    alert.className = `alert ${type}`;
    alert.textContent = message;
    
    alertContainer.appendChild(alert);
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            alert.remove();
        }, 300);
    }, 5000);
}

function confirmAction(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

// Delete confirmation
function confirmDelete(itemName, deleteUrl) {
    confirmAction(`Are you sure you want to delete "${itemName}"?`, function() {
        window.location.href = deleteUrl;
    });
}

// Activate confirmation
function confirmActivate(itemName, activateUrl) {
    confirmAction(`Are you sure you want to activate "${itemName}"?`, function() {
        window.location.href = activateUrl;
    });
}

// Export functionality
function exportToExcel() {
    const exportUrl = document.querySelector('.export-btn')?.href;
    if (exportUrl) {
        window.open(exportUrl, '_blank');
    }
}

// Download template functionality
function downloadTemplate() {
    const downloadUrl = document.querySelector('.download-btn')?.href;
    if (downloadUrl) {
        window.open(downloadUrl, '_blank');
    }
}

// Search and filter functionality
function clearSearch() {
    const searchInput = document.querySelector('input[name="search1"]');
    if (searchInput) {
        searchInput.value = '';
        performSearch();
    }
}

// Template management
function changeTemplate(templateName) {
    const form = document.createElement('form');
    form.method = 'GET';
    form.action = window.location.pathname;
    
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'labtemplate';
    input.value = templateName;
    
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
}

// Toggle all checkboxes
function toggleAll(selectAllCheckbox) {
    const itemCheckboxes = document.querySelectorAll('input[name="newserselect[]"]');
    itemCheckboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
    updateUpdateButton();
}

function updateUpdateButton() {
    const checkedBoxes = document.querySelectorAll('input[name="newserselect[]"]:checked');
    const updateBtn = document.querySelector('input[name="update"]');
    
    if (updateBtn) {
        updateBtn.disabled = checkedBoxes.length === 0;
        updateBtn.style.opacity = checkedBoxes.length === 0 ? '0.5' : '1';
    }
}

// Export functions to global scope for use in HTML
window.confirmDelete = confirmDelete;
window.confirmActivate = confirmActivate;
window.exportToExcel = exportToExcel;
window.downloadTemplate = downloadTemplate;
window.clearSearch = clearSearch;
window.changeTemplate = changeTemplate;
window.enablerate = enablerate;
window.updaterate = updaterate;
window.toggleAll = toggleAll;
window.updateUpdateButton = updateUpdateButton;
