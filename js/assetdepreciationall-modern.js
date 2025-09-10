// Asset Depreciation All - Modern JavaScript
document.addEventListener('DOMContentLoaded', function() {
    console.log('Asset Depreciation All - Modern JavaScript loaded');
    
    // Initialize modern features
    initSearchFunctionality();
    initCheckboxFunctionality();
    initFormValidation();
    initTableInteractivity();
    
    // Show loading completion
    setTimeout(() => {
        document.body.classList.remove('loading');
    }, 500);
});

// Search functionality for the data table
function initSearchFunctionality() {
    const searchInput = document.getElementById('assetSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('.data-table tbody tr');
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const shouldShow = text.includes(searchTerm);
                row.style.display = shouldShow ? '' : 'none';
            });
        });
    }
}

// Checkbox functionality
function initCheckboxFunctionality() {
    const checkAllBox = document.getElementById('checkall');
    if (checkAllBox) {
        checkAllBox.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.depreciate_checkbox:not([disabled])');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
                updateRowSelection(checkbox);
            });
            updateTotalAmount();
        });
    }
    
    // Individual checkbox handling
    const depreciateCheckboxes = document.querySelectorAll('.depreciate_checkbox');
    depreciateCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateRowSelection(this);
            updateTotalAmount();
        });
    });
}

// Update row selection visual state
function updateRowSelection(checkbox) {
    const row = checkbox.closest('tr');
    if (row) {
        if (checkbox.checked) {
            row.classList.add('selected-row');
        } else {
            row.classList.remove('selected-row');
        }
    }
}

// Update total amount
function updateTotalAmount() {
    const checkedBoxes = document.querySelectorAll('.depreciate_checkbox:checked');
    let total = 0;
    
    checkedBoxes.forEach(checkbox => {
        const row = checkbox.closest('tr');
        if (row) {
            const depInput = row.querySelector('input[name^="depreciation"]');
            if (depInput && depInput.value) {
                const value = parseFloat(depInput.value.replace(/,/g, ''));
                if (!isNaN(value)) {
                    total += value;
                }
            }
        }
    });
    
    const totalInput = document.getElementById('totaldepcreationamt');
    if (totalInput) {
        totalInput.value = total.toFixed(2);
    }
}

// Form validation
function initFormValidation() {
    const form = document.querySelector('form[name="cbform1"]');
    if (form) {
        form.addEventListener('submit', function(e) {
            const location = document.getElementById('location');
            const assignmonth = document.getElementById('assignmonth');
            
            if (!location || !location.value) {
                e.preventDefault();
                alert('Please select a location');
                return false;
            }
            
            if (!assignmonth || !assignmonth.value) {
                e.preventDefault();
                alert('Please select a process month');
                return false;
            }
        });
    }
}

// Table interactivity
function initTableInteractivity() {
    const table = document.querySelector('.data-table');
    if (table) {
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = '';
                this.style.boxShadow = '';
            });
        });
    }
}

// Global functions
function refreshPage() {
    window.location.reload();
}

function exportToExcel() {
    const assignmonth = document.getElementById('assignmonth')?.value;
    if (assignmonth) {
        window.open(`assetdepreciationall_xl.php?assignmonth=${assignmonth}`, '_blank');
    } else {
        alert('Please select a process month first');
    }
}

// Make functions globally available
window.refreshPage = refreshPage;
window.exportToExcel = exportToExcel;

// Preserve original totalamount function
if (typeof totalamount === 'function') {
    window.originalTotalAmount = totalamount;
}

window.totalamount = function(sno, total) {
    if (typeof originalTotalAmount === 'function') {
        originalTotalAmount(sno, total);
    }
    updateTotalAmount();
};

// Add custom CSS
const customCSS = `
.selected-row {
    background: rgba(52, 152, 219, 0.1) !important;
    border-left: 4px solid #3498db;
}
`;

const styleSheet = document.createElement('style');
styleSheet.textContent = customCSS;
document.head.appendChild(styleSheet);

console.log('Asset Depreciation All - Modern JavaScript fully loaded');