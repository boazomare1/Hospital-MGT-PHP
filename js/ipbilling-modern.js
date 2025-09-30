// Inpatient Billing Modern JavaScript

// Sidebar toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const menuToggle = document.getElementById('menuToggle');

    if (sidebar && sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            sidebarToggle.querySelector('i').classList.toggle('fa-chevron-left');
            sidebarToggle.querySelector('i').classList.toggle('fa-chevron-right');
        });
    }

    if (sidebar && menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            // Adjust main content margin if sidebar is fixed and not collapsed
            const mainContent = document.querySelector('.main-content');
            if (mainContent) {
                if (sidebar.classList.contains('collapsed')) {
                    mainContent.style.marginLeft = '0';
                } else {
                    mainContent.style.marginLeft = sidebar.offsetWidth + 'px';
                }
            }
        });
    }

    // Initialize form validation
    initializeFormValidation();
    
    // Initialize table interactions
    initializeTableInteractions();
    
    // Initialize keyboard shortcuts
    initializeKeyboardShortcuts();
    
    // Initialize autocomplete
    initializeAutocomplete();
});

// Function to refresh the page
function refreshPage() {
    // Show loading overlay
    const loadingOverlay = document.getElementById('imgloader');
    if (loadingOverlay) {
        loadingOverlay.style.display = 'flex';
    }
    
    window.location.reload();
}

// Function to export data to Excel
function exportToExcel() {
    // Show loading overlay
    const loadingOverlay = document.getElementById('imgloader');
    if (loadingOverlay) {
        loadingOverlay.style.display = 'flex';
    }
    
    // Get current form data
    const form = document.querySelector('.search-form');
    if (form) {
        const formData = new FormData(form);
        const params = new URLSearchParams();
        
        for (let [key, value] of formData.entries()) {
            params.append(key, value);
        }
        
        // Redirect to Excel export with parameters
        const exportUrl = `ipbilling_export.php?${params.toString()}`;
        window.open(exportUrl, '_blank');
    } else {
        alert('No data to export. Please search for patients first.');
    }
    
    // Hide loading overlay after a short delay
    setTimeout(() => {
        if (loadingOverlay) {
            loadingOverlay.style.display = 'none';
        }
    }, 1000);
}

// Form validation function
function funcvalidcheck() {
    const location = document.getElementById('location');
    const customer = document.getElementById('customer');
    
    if (!location.value) {
        alert('Please select a location.');
        location.focus();
        return false;
    }
    
    if (!customer.value.trim()) {
        alert('Please enter a patient name, registration number, or visit code to search.');
        customer.focus();
        return false;
    }
    
    // Show loading overlay
    const loadingOverlay = document.getElementById('imgloader');
    if (loadingOverlay) {
        loadingOverlay.style.display = 'flex';
    }
    
    return true;
}

// Initialize form validation
function initializeFormValidation() {
    const form = document.querySelector('.search-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!funcvalidcheck()) {
                e.preventDefault();
                return false;
            }
        });
    }
    
    // Add real-time validation feedback
    const locationSelect = document.getElementById('location');
    const customerInput = document.getElementById('customer');
    
    if (locationSelect) {
        locationSelect.addEventListener('change', function() {
            validateField(this);
        });
    }
    
    if (customerInput) {
        customerInput.addEventListener('blur', function() {
            validateField(this);
        });
    }
}

// Validate individual field
function validateField(field) {
    const value = field.value.trim();
    const isValid = value !== '';
    
    // Remove existing validation classes
    field.classList.remove('field-valid', 'field-invalid');
    
    if (isValid) {
        field.classList.add('field-valid');
    } else {
        field.classList.add('field-invalid');
    }
    
    return isValid;
}

// Initialize table interactions
function initializeTableInteractions() {
    const table = document.querySelector('.billing-table');
    if (table) {
        // Add row selection functionality
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.addEventListener('click', function() {
                // Remove selection from other rows
                rows.forEach(r => r.classList.remove('row-selected'));
                // Add selection to clicked row
                this.classList.add('row-selected');
            });
        });
        
        // Add keyboard navigation
        let selectedRowIndex = -1;
        
        table.addEventListener('keydown', function(e) {
            const rows = table.querySelectorAll('tbody tr');
            
            switch(e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    selectedRowIndex = Math.min(selectedRowIndex + 1, rows.length - 1);
                    selectRow(rows, selectedRowIndex);
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    selectedRowIndex = Math.max(selectedRowIndex - 1, 0);
                    selectRow(rows, selectedRowIndex);
                    break;
                case 'Enter':
                    e.preventDefault();
                    if (selectedRowIndex >= 0 && rows[selectedRowIndex]) {
                        rows[selectedRowIndex].click();
                    }
                    break;
            }
        });
        
        // Initialize billing action handlers
        initializeBillingActions();
    }
}

// Select table row
function selectRow(rows, index) {
    rows.forEach((row, i) => {
        row.classList.toggle('row-selected', i === index);
    });
    
    if (rows[index]) {
        rows[index].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

// Initialize billing action handlers
function initializeBillingActions() {
    // Handle billing select changes
    const billingSelects = document.querySelectorAll('.billing-select');
    billingSelects.forEach(select => {
        select.addEventListener('change', function() {
            if (this.value) {
                // Show loading overlay
                const loadingOverlay = document.getElementById('imgloader');
                if (loadingOverlay) {
                    loadingOverlay.style.display = 'flex';
                }
                
                // Open the billing page
                window.open(this.value, '_blank');
                
                // Reset the select
                this.value = '';
                
                // Hide loading overlay after a short delay
                setTimeout(() => {
                    if (loadingOverlay) {
                        loadingOverlay.style.display = 'none';
                    }
                }, 1000);
            }
        });
    });
    
    // Handle action button clicks
    const actionButtons = document.querySelectorAll('.btn-action');
    actionButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Show loading overlay
            const loadingOverlay = document.getElementById('imgloader');
            if (loadingOverlay) {
                loadingOverlay.style.display = 'flex';
            }
            
            // Hide loading overlay after a short delay
            setTimeout(() => {
                if (loadingOverlay) {
                    loadingOverlay.style.display = 'none';
                }
            }, 1000);
        });
    });
}

// Initialize keyboard shortcuts
function initializeKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        // Ctrl + S for Search
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            const searchButton = document.querySelector('.search-form .submit-btn');
            if (searchButton) {
                searchButton.click();
            }
        }

        // Ctrl + R for Refresh
        if (e.ctrlKey && e.key === 'r') {
            e.preventDefault();
            refreshPage();
        }
        
        // Ctrl + E for Export
        if (e.ctrlKey && e.key === 'e') {
            e.preventDefault();
            exportToExcel();
        }
        
        // Escape to clear selection
        if (e.key === 'Escape') {
            const selectedRows = document.querySelectorAll('.row-selected');
            selectedRows.forEach(row => row.classList.remove('row-selected'));
        }
    });
    
    // Show keyboard shortcuts help
    showKeyboardShortcuts();
}

// Show keyboard shortcuts help
function showKeyboardShortcuts() {
    const shortcutsHelp = document.createElement('div');
    shortcutsHelp.className = 'keyboard-shortcuts-help';
    shortcutsHelp.innerHTML = `
        <div class="shortcuts-content">
            <h4>Keyboard Shortcuts</h4>
            <ul>
                <li><kbd>Ctrl</kbd> + <kbd>S</kbd> - Search Patients</li>
                <li><kbd>Ctrl</kbd> + <kbd>R</kbd> - Refresh Page</li>
                <li><kbd>Ctrl</kbd> + <kbd>E</kbd> - Export to Excel</li>
                <li><kbd>↑</kbd>/<kbd>↓</kbd> - Navigate table rows</li>
                <li><kbd>Enter</kbd> - Select table row</li>
                <li><kbd>Esc</kbd> - Clear selection</li>
            </ul>
        </div>
    `;
    
    // Add styles for keyboard shortcuts help
    const style = document.createElement('style');
    style.textContent = `
        .keyboard-shortcuts-help {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--background-primary);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-medium);
            padding: 1rem;
            z-index: 1000;
            max-width: 300px;
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .keyboard-shortcuts-help h4 {
            margin: 0 0 0.5rem 0;
            color: var(--medstar-primary);
            font-size: 1rem;
        }
        
        .keyboard-shortcuts-help ul {
            margin: 0;
            padding-left: 1rem;
        }
        
        .keyboard-shortcuts-help li {
            margin-bottom: 0.25rem;
            color: var(--text-secondary);
        }
        
        .keyboard-shortcuts-help kbd {
            background: var(--background-accent);
            border: 1px solid var(--border-color);
            border-radius: 3px;
            padding: 0.2rem 0.4rem;
            font-size: 0.8rem;
            font-family: monospace;
        }
    `;
    
    document.head.appendChild(style);
    
    // Show help initially, then hide after 5 seconds
    document.body.appendChild(shortcutsHelp);
    setTimeout(() => {
        if (shortcutsHelp.parentNode) {
            shortcutsHelp.parentNode.removeChild(shortcutsHelp);
        }
    }, 5000);
}

// Initialize autocomplete functionality
function initializeAutocomplete() {
    const customerInput = document.getElementById('customer');
    if (customerInput) {
        // Add autocomplete functionality
        customerInput.addEventListener('input', function() {
            const value = this.value.trim();
            if (value.length >= 2) {
                // Trigger autocomplete search
                // This would typically make an AJAX call to search for patients
                console.log('Searching for patients with:', value);
            }
        });
        
        // Add focus/blur effects
        customerInput.addEventListener('focus', function() {
            this.parentElement.classList.add('input-focused');
        });
        
        customerInput.addEventListener('blur', function() {
            this.parentElement.classList.remove('input-focused');
        });
    }
}

// AJAX function for location (from original code, adapted)
function ajaxlocationfunction(val) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("ajaxlocation").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "ajax/ajaxgetlocationname.php?loccode=" + val, true);
    xmlhttp.send();
}

// Customer dropdown search function (from original code, adapted)
function funcCustomerDropDownSearch1() {
    // This function is typically defined in the included dropdownlistipbilling.php
    // We'll call it if it exists
    if (typeof funcCustomerDropDownSearch1 === 'function') {
        funcCustomerDropDownSearch1();
    }
}

// Popup on load function (from original code, adapted)
function funcPopupOnLoad1() {
    // This function is defined in the original code for handling popups
    // We'll call it if it exists
    if (typeof funcPopupOnLoad1 === 'function') {
        funcPopupOnLoad1();
    }
}

// Disable Enter Key (from original code, adapted)
function disableEnterKey(e) {
    var key;
    if (window.event) {
        key = window.event.keyCode; //IE
    } else {
        key = e.which; //firefox
    }
    if (key == 13) {
        return false;
    } else {
        return true;
    }
}

// Performance monitoring
document.addEventListener('DOMContentLoaded', function() {
    const loadTime = performance.now();
    console.log(`Inpatient Billing page loaded in ${loadTime.toFixed(2)} ms`);

    // Monitor form submission performance
    const form = document.querySelector('.search-form');
    if (form) {
        form.addEventListener('submit', function() {
            const submitTime = performance.now();
            console.log(`Patient search form submitted at ${submitTime.toFixed(2)} ms`);
        });
    }
    
    // Monitor table rendering performance
    const table = document.querySelector('.billing-table');
    if (table) {
        const rows = table.querySelectorAll('tbody tr');
        console.log(`Billing table rendered with ${rows.length} patient records`);
    }
});

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.parentNode.removeChild(alert);
                }
            }, 300);
        }, 5000);
    });
});

// Add smooth scrolling for better UX
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for anchor links
    const links = document.querySelectorAll('a[href^="#"]');
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Billing action helper functions
function openBillingPage(url, title) {
    // Show loading overlay
    const loadingOverlay = document.getElementById('imgloader');
    if (loadingOverlay) {
        loadingOverlay.style.display = 'flex';
    }
    
    // Open billing page
    window.open(url, title, 'width=800,height=600,scrollbars=yes,resizable=yes');
    
    // Hide loading overlay after a short delay
    setTimeout(() => {
        if (loadingOverlay) {
            loadingOverlay.style.display = 'none';
        }
    }, 1000);
}

// Quick billing actions
function quickInterimInvoice(patientcode, visitcode, menuid) {
    const url = `ipinteriminvoiceserver.php?patientcode=${patientcode}&&visitcode=${visitcode}&&menuid=${menuid}`;
    openBillingPage(url, 'InterimInvoice');
}

function quickFinalInvoice(patientcode, visitcode, menuid) {
    const url = `ipfinalinvoice.php?patientcode=${patientcode}&&visitcode=${visitcode}&&menuid=${menuid}`;
    openBillingPage(url, 'FinalInvoice');
}

function quickDepositForm(patientcode, visitcode, menuid) {
    const url = `depositform1.php?patientcode=${patientcode}&&visitcode=${visitcode}&&menuid=${menuid}`;
    openBillingPage(url, 'DepositForm');
}

function quickNHIFProcessing(patientcode, visitcode, menuid) {
    const url = `nhifprocessing.php?patientcode=${patientcode}&&visitcode=${visitcode}&&menuid=${menuid}`;
    openBillingPage(url, 'NHIFProcessing');
}

function quickMiscBilling(patientcode, visitcode, menuid) {
    const url = `ipmiscbilling.php?patientcode=${patientcode}&&visitcode=${visitcode}&&menuid=${menuid}`;
    openBillingPage(url, 'MiscBilling');
}


