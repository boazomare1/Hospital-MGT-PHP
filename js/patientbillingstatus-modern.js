// Patient Billing Status Modern JavaScript
// Handles form validation, responsive design, and enhanced user experience for patient billing status management

document.addEventListener('DOMContentLoaded', function() {
    initializeFormValidation();
    initializeResponsiveDesign();
    initializeTouchSupport();
    initializeFormEnhancements();
    initializePatientSearch();
    initializeLocationDependency();
    initializeDatePickers();
    initializeTableEnhancements();
    initializeAutoComplete();
    initializeFormAutoSave();
});

// Form Validation
function initializeFormValidation() {
    const searchForm = document.querySelector('form[name="cbform1"]');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            if (!validateSearchForm()) {
                e.preventDefault();
            }
        });
        
        initializeRealTimeValidation();
    }
}

function validateSearchForm() {
    let isValid = true;
    const locationSelect = document.getElementById('location');
    const patientInput = document.querySelector('input[name="patient"]');
    const patientCodeInput = document.querySelector('input[name="patientcode"]');
    const visitCodeInput = document.querySelector('input[name="visitcode"]');
    const dateFromInput = document.getElementById('ADate1');
    const dateToInput = document.getElementById('ADate2');
    
    // Validate date range
    if (dateFromInput && dateToInput) {
        if (!validateDateRange(dateFromInput.value, dateToInput.value)) {
            isValid = false;
        }
    }
    
    // At least one search criteria should be provided
    const hasSearchCriteria = (patientInput && patientInput.value.trim()) ||
                            (patientCodeInput && patientCodeInput.value.trim()) ||
                            (visitCodeInput && visitCodeInput.value.trim());
    
    if (!hasSearchCriteria) {
        showNotification('Please provide at least one search criteria (Patient Name, Registration No, or Visit Code)', 'warning');
        isValid = false;
    }
    
    return isValid;
}

function validateDateRange(dateFrom, dateTo) {
    if (!dateFrom || !dateTo) {
        return true; // Dates are optional
    }
    
    const fromDate = new Date(dateFrom);
    const toDate = new Date(dateTo);
    
    if (fromDate > toDate) {
        showNotification('Date From cannot be later than Date To', 'error');
        return false;
    }
    
    // Check if date range is not more than 1 year
    const oneYearFromNow = new Date();
    oneYearFromNow.setFullYear(oneYearFromNow.getFullYear() + 1);
    
    if (toDate > oneYearFromNow) {
        showNotification('Date range cannot exceed 1 year', 'warning');
        return false;
    }
    
    return true;
}

function initializeRealTimeValidation() {
    const formFields = document.querySelectorAll('input, select');
    
    formFields.forEach(field => {
        field.addEventListener('blur', function() {
            validateField(field);
        });
        
        field.addEventListener('input', function() {
            if (field.classList.contains('error')) {
                validateField(field);
            }
        });
    });
}

function validateField(field) {
    const value = field.value.trim();
    
    if (field.hasAttribute('required') && !value) {
        showFieldError(field, 'This field is required');
        return false;
    }
    
    // Validate date fields
    if (field.type === 'date' || field.id === 'ADate1' || field.id === 'ADate2') {
        if (value && !isValidDate(value)) {
            showFieldError(field, 'Please enter a valid date');
            return false;
        }
    }
    
    clearFieldError(field);
    return true;
}

function isValidDate(dateString) {
    const date = new Date(dateString);
    return date instanceof Date && !isNaN(date);
}

// Field Error Handling
function showFieldError(field, message) {
    clearFieldError(field);
    
    field.classList.add('error');
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    field.classList.remove('error');
    const errorDiv = field.parentNode.querySelector('.field-error');
    if (errorDiv) {
        errorDiv.remove();
    }
}

// Responsive Design
function initializeResponsiveDesign() {
    window.addEventListener('resize', debounce(adjustLayoutForScreenSize, 250));
    adjustLayoutForScreenSize();
}

function adjustLayoutForScreenSize() {
    const width = window.innerWidth;
    
    if (width <= 768) {
        document.body.classList.add('mobile-view');
        adjustTablesForMobile();
    } else {
        document.body.classList.remove('mobile-view');
        restoreTableLayout();
    }
}

function adjustTablesForMobile() {
    const tables = document.querySelectorAll('.results-table table');
    tables.forEach(table => {
        if (!table.classList.contains('mobile-adjusted')) {
            table.classList.add('mobile-adjusted');
            addMobileTableEnhancements(table);
        }
    });
}

function restoreTableLayout() {
    const tables = document.querySelectorAll('.results-table table');
    tables.forEach(table => {
        table.classList.remove('mobile-adjusted');
        removeMobileTableEnhancements(table);
    });
}

function addMobileTableEnhancements(table) {
    const rows = table.querySelectorAll('tr');
    rows.forEach((row, index) => {
        if (index === 0) return; // Skip header row
        
        const cells = row.querySelectorAll('td');
        cells.forEach((cell, cellIndex) => {
            const header = table.querySelector(`th:nth-child(${cellIndex + 1})`);
            if (header) {
                cell.setAttribute('data-label', header.textContent);
            }
        });
    });
}

function removeMobileTableEnhancements(table) {
    const cells = table.querySelectorAll('td[data-label]');
    cells.forEach(cell => {
        cell.removeAttribute('data-label');
    });
}

// Touch Support
function initializeTouchSupport() {
    if ('ontouchstart' in window) {
        document.body.classList.add('touch-device');
        
        // Add touch-specific enhancements
        addTouchEnhancements();
    }
}

function addTouchEnhancements() {
    // Increase touch target sizes
    const buttons = document.querySelectorAll('.action-btn, input[type="submit"], input[type="reset"]');
    buttons.forEach(button => {
        button.style.minHeight = '44px';
        button.style.minWidth = '44px';
    });
    
    // Add touch-friendly form interactions
    addTouchFormEnhancements();
}

function addTouchFormEnhancements() {
    // Add swipe gestures for mobile tables
    initializeSwipeGestures();
    
    // Enhance touch targets for form inputs
    const formInputs = document.querySelectorAll('input, select');
    formInputs.forEach(input => {
        input.style.minHeight = '44px';
    });
}

function initializeSwipeGestures() {
    const tables = document.querySelectorAll('.results-table');
    tables.forEach(table => {
        let startX = 0;
        let startY = 0;
        
        table.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
        });
        
        table.addEventListener('touchmove', function(e) {
            if (!startX || !startY) return;
            
            const deltaX = e.touches[0].clientX - startX;
            const deltaY = e.touches[0].clientY - startY;
            
            if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 50) {
                // Horizontal swipe detected
                if (deltaX > 0) {
                    // Swipe right - show previous page if pagination exists
                    handleSwipeRight();
                } else {
                    // Swipe left - show next page if pagination exists
                    handleSwipeLeft();
                }
            }
            
            startX = 0;
            startY = 0;
        });
    });
}

function handleSwipeRight() {
    const prevButton = document.querySelector('.pagination .prev, .pagination .previous');
    if (prevButton && !prevButton.disabled) {
        prevButton.click();
    }
}

function handleSwipeLeft() {
    const nextButton = document.querySelector('.pagination .next');
    if (nextButton && !nextButton.disabled) {
        nextButton.click();
    }
}

// Form Enhancements
function initializeFormEnhancements() {
    // Add loading states to submit buttons
    const submitButtons = document.querySelectorAll('input[type="submit"]');
    submitButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (this.form && this.form.checkValidity()) {
                this.style.opacity = '0.7';
                this.disabled = true;
                this.value = 'Searching...';
            }
        });
    });
    
    // Add form reset confirmation
    const resetButtons = document.querySelectorAll('input[type="reset"]');
    resetButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
                e.preventDefault();
            }
        });
    });
    
    // Add keyboard shortcuts
    addKeyboardShortcuts();
}

function addKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'f') {
            e.preventDefault();
            const patientInput = document.querySelector('input[name="patient"]');
            if (patientInput) {
                patientInput.focus();
            }
        }
        
        if (e.ctrlKey && e.key === 'Enter') {
            e.preventDefault();
            const submitButton = document.querySelector('input[type="submit"]');
            if (submitButton) {
                submitButton.click();
            }
        }
        
        if (e.key === 'Escape') {
            // Clear focus from current input
            document.activeElement.blur();
        }
    });
}

// Patient Search Enhancement
function initializePatientSearch() {
    const patientInput = document.querySelector('input[name="patient"]');
    const patientCodeInput = document.querySelector('input[name="patientcode"]');
    const visitCodeInput = document.querySelector('input[name="visitcode"]');
    
    if (patientInput) {
        patientInput.addEventListener('input', debounce(function() {
            const searchTerm = this.value.trim();
            if (searchTerm.length >= 2) {
                searchPatients(searchTerm, this);
            } else {
                hideSearchResults();
            }
        }, 300));
        
        // Add search icon
        addSearchIcon(patientInput);
    }
    
    if (patientCodeInput) {
        patientCodeInput.addEventListener('input', debounce(function() {
            const searchTerm = this.value.trim();
            if (searchTerm.length >= 2) {
                searchPatientCodes(searchTerm, this);
            } else {
                hideSearchResults();
            }
        }, 300));
    }
    
    if (visitCodeInput) {
        visitCodeInput.addEventListener('input', debounce(function() {
            const searchTerm = this.value.trim();
            if (searchTerm.length >= 2) {
                searchVisitCodes(searchTerm, this);
            } else {
                hideSearchResults();
            }
        }, 300));
    }
}

function addSearchIcon(input) {
    const container = input.parentNode;
    container.style.position = 'relative';
    
    const icon = document.createElement('span');
    icon.innerHTML = '🔍';
    icon.style.cssText = `
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #95a5a6;
        pointer-events: none;
        font-size: 16px;
    `;
    
    container.appendChild(icon);
}

function searchPatients(searchTerm, input) {
    // Simulate patient search (replace with actual API call)
    const mockPatients = [
        { name: 'John Doe', code: 'P001', visitCode: 'V001', status: 'Pending' },
        { name: 'Jane Smith', code: 'P002', visitCode: 'V002', status: 'Completed' },
        { name: 'Mike Johnson', code: 'P003', visitCode: 'V003', status: 'Awaiting' },
        { name: 'Sarah Wilson', code: 'P004', visitCode: 'V004', status: 'Pending' },
        { name: 'David Brown', code: 'P005', visitCode: 'V005', status: 'Completed' }
    ];
    
    const filteredPatients = mockPatients.filter(patient => 
        patient.name.toLowerCase().includes(searchTerm.toLowerCase())
    );
    
    showPatientSearchResults(filteredPatients, input);
}

function searchPatientCodes(searchTerm, input) {
    // Simulate patient code search
    const mockPatientCodes = [
        { code: 'P001', name: 'John Doe', visitCode: 'V001' },
        { code: 'P002', name: 'Jane Smith', visitCode: 'V002' },
        { code: 'P003', name: 'Mike Johnson', visitCode: 'V003' }
    ];
    
    const filteredCodes = mockPatientCodes.filter(patient => 
        patient.code.toLowerCase().includes(searchTerm.toLowerCase())
    );
    
    showPatientCodeSearchResults(filteredCodes, input);
}

function searchVisitCodes(searchTerm, input) {
    // Simulate visit code search
    const mockVisitCodes = [
        { visitCode: 'V001', patientName: 'John Doe', patientCode: 'P001' },
        { visitCode: 'V002', patientName: 'Jane Smith', patientCode: 'P002' },
        { visitCode: 'V003', patientName: 'Mike Johnson', patientCode: 'P003' }
    ];
    
    const filteredCodes = mockVisitCodes.filter(visit => 
        visit.visitCode.toLowerCase().includes(searchTerm.toLowerCase())
    );
    
    showVisitCodeSearchResults(filteredCodes, input);
}

function showPatientSearchResults(patients, input) {
    hideSearchResults();
    
    if (patients.length === 0) return;
    
    const container = input.parentNode;
    
    const resultsDiv = document.createElement('div');
    resultsDiv.className = 'search-results';
    
    patients.forEach(patient => {
        const item = document.createElement('div');
        item.className = 'search-result-item';
        
        item.innerHTML = `
            <div>
                <strong>${patient.name}</strong><br>
                <small>Code: ${patient.code} | Visit: ${patient.visitCode}</small>
            </div>
            <div style="font-size: 0.8rem; color: #666;">
                ${patient.status}
            </div>
        `;
        
        item.addEventListener('click', function() {
            selectPatient(patient, input);
            hideSearchResults();
        });
        
        resultsDiv.appendChild(item);
    });
    
    container.appendChild(resultsDiv);
}

function showPatientCodeSearchResults(patientCodes, input) {
    hideSearchResults();
    
    if (patientCodes.length === 0) return;
    
    const container = input.parentNode;
    
    const resultsDiv = document.createElement('div');
    resultsDiv.className = 'search-results';
    
    patientCodes.forEach(patient => {
        const item = document.createElement('div');
        item.className = 'search-result-item';
        
        item.innerHTML = `
            <div>
                <strong>${patient.code}</strong><br>
                <small>${patient.name} | Visit: ${patient.visitCode}</small>
            </div>
        `;
        
        item.addEventListener('click', function() {
            selectPatientCode(patient, input);
            hideSearchResults();
        });
        
        resultsDiv.appendChild(item);
    });
    
    container.appendChild(resultsDiv);
}

function showVisitCodeSearchResults(visitCodes, input) {
    hideSearchResults();
    
    if (visitCodes.length === 0) return;
    
    const container = input.parentNode;
    
    const resultsDiv = document.createElement('div');
    resultsDiv.className = 'search-results';
    
    visitCodes.forEach(visit => {
        const item = document.createElement('div');
        item.className = 'search-result-item';
        
        item.innerHTML = `
            <div>
                <strong>${visit.visitCode}</strong><br>
                <small>${visit.patientName} | Code: ${visit.patientCode}</small>
            </div>
        `;
        
        item.addEventListener('click', function() {
            selectVisitCode(visit, input);
            hideSearchResults();
        });
        
        resultsDiv.appendChild(item);
    });
    
    container.appendChild(resultsDiv);
}

function hideSearchResults() {
    const existingResults = document.querySelectorAll('.search-results');
    existingResults.forEach(result => result.remove());
}

function selectPatient(patient, input) {
    input.value = patient.name;
    
    // Auto-fill other fields if they exist
    const patientCodeInput = document.querySelector('input[name="patientcode"]');
    const visitCodeInput = document.querySelector('input[name="visitcode"]');
    
    if (patientCodeInput) patientCodeInput.value = patient.code;
    if (visitCodeInput) visitCodeInput.value = patient.visitCode;
}

function selectPatientCode(patient, input) {
    input.value = patient.code;
    
    // Auto-fill other fields
    const patientNameInput = document.querySelector('input[name="patient"]');
    const visitCodeInput = document.querySelector('input[name="visitcode"]');
    
    if (patientNameInput) patientNameInput.value = patient.name;
    if (visitCodeInput) visitCodeInput.value = patient.visitCode;
}

function selectVisitCode(visit, input) {
    input.value = visit.visitCode;
    
    // Auto-fill other fields
    const patientNameInput = document.querySelector('input[name="patient"]');
    const patientCodeInput = document.querySelector('input[name="patientcode"]');
    
    if (patientNameInput) patientNameInput.value = visit.patientName;
    if (patientCodeInput) patientCodeInput.value = visit.patientCode;
}

// Location Dependency
function initializeLocationDependency() {
    const locationSelect = document.getElementById('location');
    if (locationSelect) {
        locationSelect.addEventListener('change', function() {
            updateLocationDisplay(this.value);
            clearSearchResults();
        });
        
        // Initialize location display
        if (locationSelect.value) {
            updateLocationDisplay(locationSelect.value);
        }
    }
}

function updateLocationDisplay(locationCode) {
    const locationDisplay = document.getElementById('ajaxlocation');
    if (locationDisplay) {
        // Simulate location name fetch (replace with actual API call)
        const locationName = getLocationName(locationCode);
        locationDisplay.innerHTML = `<strong>Location: ${locationName}</strong>`;
    }
}

function getLocationName(locationCode) {
    // Mock data - replace with actual API call
    const mockLocations = {
        'LOC1': 'General Hospital',
        'LOC2': 'Specialty Clinic',
        'LOC3': 'Emergency Center'
    };
    
    return mockLocations[locationCode] || 'Unknown Location';
}

function clearSearchResults() {
    // Clear search form fields
    const searchForm = document.querySelector('form[name="cbform1"]');
    if (searchForm) {
        const inputs = searchForm.querySelectorAll('input[type="text"]');
        inputs.forEach(input => {
            input.value = '';
        });
    }
    
    // Hide any existing search results
    hideSearchResults();
}

// Date Picker Enhancements
function initializeDatePickers() {
    const dateInputs = document.querySelectorAll('#ADate1, #ADate2');
    
    dateInputs.forEach(input => {
        // Add quick date buttons
        addQuickDateButtons(input);
        
        // Add date validation
        input.addEventListener('change', function() {
            validateDateField(this);
        });
    });
}

function addQuickDateButtons(dateInput) {
    const container = dateInput.parentNode;
    
    const quickDateDiv = document.createElement('div');
    quickDateDiv.className = 'quick-date-buttons';
    
    const quickDates = [
        { label: 'Today', days: 0 },
        { label: 'Yesterday', days: -1 },
        { label: 'Last Week', days: -7 },
        { label: 'Last Month', days: -30 }
    ];
    
    quickDates.forEach(quickDate => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'quick-date-btn';
        button.textContent = quickDate.label;
        
        button.addEventListener('click', function() {
            const targetDate = new Date();
            targetDate.setDate(targetDate.getDate() + quickDate.days);
            dateInput.value = targetDate.toISOString().split('T')[0];
            dateInput.dispatchEvent(new Event('change'));
        });
        
        quickDateDiv.appendChild(button);
    });
    
    container.appendChild(quickDateDiv);
}

function validateDateField(dateInput) {
    const dateValue = dateInput.value;
    
    if (dateValue && !isValidDate(dateValue)) {
        showFieldError(dateInput, 'Please enter a valid date');
        return false;
    }
    
    clearFieldError(dateInput);
    return true;
}

// Table Enhancements
function initializeTableEnhancements() {
    const tables = document.querySelectorAll('.results-table table');
    tables.forEach(table => {
        addTableSorting(table);
        addExpandableRows(table);
        addStatusIndicators(table);
    });
}

function addTableSorting(table) {
    const headers = table.querySelectorAll('th');
    headers.forEach((header, index) => {
        if (header.textContent.trim() !== '') {
            header.style.cursor = 'pointer';
            header.addEventListener('click', function() {
                sortTable(table, index);
            });
            
            // Add sort indicator
            const sortIndicator = document.createElement('span');
            sortIndicator.className = 'sort-indicator';
            sortIndicator.innerHTML = ' ↕';
            sortIndicator.style.color = '#999';
            header.appendChild(sortIndicator);
        }
    });
}

function sortTable(table, columnIndex) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    // Remove existing sort indicators
    table.querySelectorAll('.sort-indicator').forEach(indicator => {
        indicator.innerHTML = ' ↕';
        indicator.style.color = '#999';
    });
    
    // Add sort indicator to clicked header
    const clickedHeader = table.querySelector(`th:nth-child(${columnIndex + 1})`);
    const indicator = clickedHeader.querySelector('.sort-indicator');
    
    // Determine sort direction
    const currentDirection = indicator.getAttribute('data-direction') || 'none';
    const newDirection = currentDirection === 'asc' ? 'desc' : 'asc';
    
    indicator.setAttribute('data-direction', newDirection);
    indicator.innerHTML = newDirection === 'asc' ? ' ↑' : ' ↓';
    indicator.style.color = '#3498db';
    
    // Sort rows
    rows.sort((a, b) => {
        const aValue = a.cells[columnIndex]?.textContent.trim() || '';
        const bValue = b.cells[columnIndex]?.textContent.trim() || '';
        
        if (newDirection === 'asc') {
            return aValue.localeCompare(bValue);
        } else {
            return bValue.localeCompare(aValue);
        }
    });
    
    // Reorder rows
    rows.forEach(row => tbody.appendChild(row));
}

function addExpandableRows(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const expandButton = document.createElement('button');
        expandButton.className = 'expand-btn';
        expandButton.innerHTML = '▶';
        expandButton.style.cssText = `
            background: none;
            border: none;
            cursor: pointer;
            font-size: 12px;
            color: #666;
            padding: 2px;
        `;
        
        expandButton.addEventListener('click', function() {
            toggleRowDetails(row, this);
        });
        
        // Add expand button to first cell
        const firstCell = row.querySelector('td:first-child');
        if (firstCell) {
            firstCell.insertBefore(expandButton, firstCell.firstChild);
        }
    });
}

function toggleRowDetails(row, button) {
    const detailRow = row.nextElementSibling;
    
    if (detailRow && detailRow.classList.contains('detail-row')) {
        // Hide details
        detailRow.style.display = 'none';
        button.innerHTML = '▶';
        button.style.transform = 'rotate(0deg)';
    } else {
        // Show details
        const newDetailRow = createDetailRow(row);
        row.parentNode.insertBefore(newDetailRow, row.nextSibling);
        button.innerHTML = '▼';
        button.style.transform = 'rotate(90deg)';
    }
}

function createDetailRow(row) {
    const detailRow = document.createElement('tr');
    detailRow.className = 'detail-row';
    detailRow.style.backgroundColor = '#f8f9fa';
    
    const detailCell = document.createElement('td');
    detailCell.colSpan = row.cells.length;
    detailCell.style.padding = '1rem';
    
    // Extract patient information from the row
    const patientName = row.cells[4]?.textContent || 'N/A';
    const patientCode = row.cells[1]?.textContent || 'N/A';
    const visitCode = row.cells[2]?.textContent || 'N/A';
    const consultationDate = row.cells[3]?.textContent || 'N/A';
    
    detailCell.innerHTML = `
        <div class="patient-detail-expanded">
            <h4>Patient Details</h4>
            <div class="detail-grid">
                <div class="detail-item">
                    <strong>Name:</strong> ${patientName}
                </div>
                <div class="detail-item">
                    <strong>Code:</strong> ${patientCode}
                </div>
                <div class="detail-item">
                    <strong>Visit Code:</strong> ${visitCode}
                </div>
                <div class="detail-item">
                    <strong>Consultation Date:</strong> ${consultationDate}
                </div>
            </div>
            <div class="action-buttons">
                <button class="action-btn view">View Details</button>
                <button class="action-btn bill">Create Bill</button>
                <button class="action-btn edit">Edit</button>
            </div>
        </div>
    `;
    
    detailRow.appendChild(detailCell);
    return detailRow;
}

function addStatusIndicators(table) {
    // Add status indicators to the table
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const statusCell = row.querySelector('td:last-child'); // Adjust index as needed
        if (statusCell && statusCell.textContent.includes('Awaiting')) {
            const statusBadge = document.createElement('span');
            statusBadge.className = 'status-badge status-awaiting';
            statusBadge.textContent = 'Awaiting';
            statusCell.appendChild(statusBadge);
        }
    });
}

// Auto-complete Enhancement
function initializeAutoComplete() {
    // Add auto-complete for location field
    const locationSelect = document.getElementById('location');
    if (locationSelect) {
        addAutoCompleteToSelect(locationSelect, getLocationSuggestions());
    }
}

function getLocationSuggestions() {
    return ['General Hospital', 'Specialty Clinic', 'Emergency Center', 'Rehabilitation Unit'];
}

function addAutoCompleteToSelect(select, suggestions) {
    // Convert select to searchable input with dropdown
    const container = select.parentNode;
    const input = document.createElement('input');
    input.type = 'text';
    input.placeholder = select.options[0]?.textContent || 'Search...';
    input.className = select.className;
    input.style.cssText = select.style.cssText;
    
    // Hide original select
    select.style.display = 'none';
    
    // Add input to container
    container.appendChild(input);
    
    // Add dropdown functionality
    input.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const filteredSuggestions = suggestions.filter(suggestion => 
            suggestion.toLowerCase().includes(searchTerm)
        );
        
        showAutoCompleteDropdown(input, filteredSuggestions, select);
    });
}

function showAutoCompleteDropdown(input, suggestions, originalSelect) {
    hideAutoCompleteDropdown();
    
    const dropdown = document.createElement('div');
    dropdown.className = 'autocomplete-dropdown';
    
    suggestions.forEach(suggestion => {
        const item = document.createElement('div');
        item.className = 'autocomplete-item';
        item.textContent = suggestion;
        
        item.addEventListener('click', function() {
            input.value = suggestion;
            hideAutoCompleteDropdown();
            
            // Update original select value if possible
            for (let option of originalSelect.options) {
                if (option.textContent === suggestion) {
                    originalSelect.value = option.value;
                    originalSelect.dispatchEvent(new Event('change'));
                    break;
                }
            }
        });
        
        dropdown.appendChild(item);
    });
    
    input.parentNode.appendChild(dropdown);
}

function hideAutoCompleteDropdown() {
    const existingDropdown = document.querySelector('.autocomplete-dropdown');
    if (existingDropdown) {
        existingDropdown.remove();
    }
}

// Form Auto-save
function initializeFormAutoSave() {
    const form = document.querySelector('form[name="cbform1"]');
    if (!form) return;
    
    const autoSaveKey = 'patient_billing_status_autosave';
    
    // Load auto-saved data
    const savedData = localStorage.getItem(autoSaveKey);
    if (savedData) {
        try {
            const data = JSON.parse(savedData);
            Object.keys(data).forEach(key => {
                const field = form.querySelector(`[name="${key}"]`);
                if (field) {
                    field.value = data[key];
                }
            });
        } catch (e) {
            console.error('Error loading auto-saved data:', e);
        }
    }
    
    // Auto-save on input
    form.addEventListener('input', debounce(function() {
        const formData = new FormData(form);
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }
        
        localStorage.setItem(autoSaveKey, JSON.stringify(data));
    }, 1000));
}

// Notification System
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 4px;
        color: white;
        font-weight: 500;
        z-index: 10000;
        max-width: 300px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transform: translateX(100%);
        transition: transform 0.3s ease;
    `;
    
    // Set background color based on type
    const colors = {
        success: '#27ae60',
        error: '#e74c3c',
        warning: '#f39c12',
        info: '#3498db'
    };
    
    notification.style.background = colors[type] || colors.info;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 5000);
}

// Utility Functions
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

// Export functions for global access
window.PatientBillingStatusModern = {
    validateSearchForm,
    showNotification,
    updateLocationDisplay,
    searchPatients,
    sortTable,
    toggleRowDetails
};




