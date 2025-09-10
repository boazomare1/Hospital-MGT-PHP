/**
 * Modern JavaScript for Consultation Master with Department
 * Handles form validation, autocomplete, AJAX, and modern interactions
 */

// Modern ES6+ JavaScript with enhanced functionality
class ConsultationMaster {
    constructor() {
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.setupAutocomplete();
        this.setupFormValidation();
        this.setupScrollLoading();
    }

    setupEventListeners() {
        // Payment type change handler
        const paymentTypeSelect = document.getElementById('paymenttype');
        if (paymentTypeSelect) {
            paymentTypeSelect.addEventListener('change', (e) => {
                this.handlePaymentTypeChange(e.target.value);
            });
        }

        // Location change handler
        const locationSelect = document.getElementById('location');
        if (locationSelect) {
            locationSelect.addEventListener('change', (e) => {
                this.handleLocationChange(e.target.value);
            });
        }

        // Form submission handler
        const form = document.getElementById('form1');
        if (form) {
            form.addEventListener('submit', (e) => {
                if (!this.validateForm()) {
                    e.preventDefault();
                }
            });
        }

        // Clear functions for search fields
        this.setupClearFunctions();
    }

    setupAutocomplete() {
        // Doctor name autocomplete
        if (typeof $ !== 'undefined' && $('#consultationdoctorname').length) {
            $('#consultationdoctorname').autocomplete({
                source: 'ajaxdoctornamesearch.php',
                html: true,
                minLength: 2,
                select: (event, ui) => {
                    $('#consultationdoctorcode').val(ui.item.doctorcode);
                    $('#consultationdoctorname').val(ui.item.value);
                    return false;
                }
            });
        }

        // Supplier/Subtype autocomplete
        if (typeof $ !== 'undefined' && $('#searchsuppliername').length) {
            $('#searchsuppliername').autocomplete({
                source: "ajaxaccountsub_search.php",
                matchContains: true,
                minLength: 1,
                html: true,
                select: (event, ui) => {
                    $("#searchsuppliercode").val(ui.item.id);
                    $("#searchsupplieranum").val(ui.item.anum);
                    $('#searchsuppliername').val(ui.item.value);
                    return false;
                }
            });
        }

        // Department autocomplete
        if (typeof $ !== 'undefined' && $('#searchdepartmentname').length) {
            $('#searchdepartmentname').autocomplete({
                source: "ajaxdepartment_search.php",
                matchContains: true,
                minLength: 1,
                html: true,
                select: (event, ui) => {
                    $("#searchdepartmentcode").val(ui.item.id);
                    $("#searchdepartmentanum").val(ui.item.anum);
                    $('#searchdepartmentname').val(ui.item.value);
                    return false;
                }
            });
        }
    }

    setupFormValidation() {
        // Real-time validation
        const consultationType = document.getElementById('consultationtype');
        if (consultationType) {
            consultationType.addEventListener('input', (e) => {
                this.validateConsultationType(e.target.value);
            });
        }

        const consultationFees = document.getElementById('consultationfees');
        if (consultationFees) {
            consultationFees.addEventListener('input', (e) => {
                this.validateConsultationFees(e.target.value);
            });
        }
    }

    setupClearFunctions() {
        // Clear department code
        window.cleardepartmentcode = () => {
            document.getElementById("searchdepartmentanum").value = '';
        };

        // Clear subtype code
        window.clearsubtypecode = () => {
            document.getElementById("searchsupplieranum").value = '';
        };
    }

    setupScrollLoading() {
        if (typeof $ !== 'undefined') {
            $(window).scroll(() => {
                if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
                    this.loadMoreData();
                }
            });
        }
    }

    handlePaymentTypeChange(paymentTypeValue) {
        if (!paymentTypeValue) return;

        // Modern AJAX call using fetch
        fetch(`ajax/get_subtypes.php?paymenttype=${paymentTypeValue}`)
            .then(response => response.json())
            .then(data => {
                this.updateSubtypeOptions(data);
            })
            .catch(error => {
                console.error('Error loading subtypes:', error);
                // Fallback to legacy method if needed
                this.legacyPaymentTypeChange(paymentTypeValue);
            });
    }

    updateSubtypeOptions(subtypes) {
        const subtypeSelect = document.getElementById('subtype');
        if (!subtypeSelect) return;

        // Clear existing options
        subtypeSelect.innerHTML = '<option value="">Select Sub Type</option>';

        // Add new options
        subtypes.forEach(subtype => {
            const option = document.createElement('option');
            option.value = subtype.auto_number;
            option.textContent = subtype.subtype;
            subtypeSelect.appendChild(option);
        });
    }

    legacyPaymentTypeChange(paymentTypeValue) {
        // Legacy method for backward compatibility
        const subtypeSelect = document.getElementById('subtype');
        if (!subtypeSelect) return;

        subtypeSelect.innerHTML = '<option value="">Select Sub Type</option>';
        
        // This would need to be populated from server-side data
        // For now, we'll use the existing PHP-generated JavaScript
        if (typeof funcPaymentTypeChange1 === 'function') {
            funcPaymentTypeChange1();
        }
    }

    handleLocationChange(locationValue) {
        if (!locationValue) return;

        // Modern AJAX call
        fetch(`ajax/ajaxgetlocationname.php?loccode=${locationValue}`)
            .then(response => response.text())
            .then(data => {
                const ajaxLocation = document.getElementById('ajaxlocation');
                if (ajaxLocation) {
                    ajaxLocation.innerHTML = data;
                }
            })
            .catch(error => {
                console.error('Error loading location:', error);
                // Fallback to legacy method
                if (typeof ajaxlocationfunction === 'function') {
                    ajaxlocationfunction(locationValue);
                }
            });
    }

    validateForm() {
        const errors = [];

        // Location validation
        const location = document.getElementById('location');
        if (!location || !location.value) {
            errors.push('Please select a location.');
            this.showFieldError(location, 'Please select a location.');
        } else {
            this.clearFieldError(location);
        }

        // Department validation
        const department = document.getElementById('department');
        if (!department || !department.value) {
            errors.push('Please select a department.');
            this.showFieldError(department, 'Please select a department.');
        } else {
            this.clearFieldError(department);
        }

        // Consultation type validation
        const consultationType = document.getElementById('consultationtype');
        if (!consultationType || !consultationType.value.trim()) {
            errors.push('Please enter consultation type name.');
            this.showFieldError(consultationType, 'Please enter consultation type name.');
        } else if (consultationType.value.length > 100) {
            errors.push('Consultation type name must be 100 characters or less.');
            this.showFieldError(consultationType, 'Maximum 100 characters allowed.');
        } else {
            this.clearFieldError(consultationType);
        }

        // Consultation fees validation
        const consultationFees = document.getElementById('consultationfees');
        if (!consultationFees || !consultationFees.value.trim()) {
            errors.push('Please enter consultation fees.');
            this.showFieldError(consultationFees, 'Please enter consultation fees.');
        } else if (!this.isValidNumber(consultationFees.value)) {
            errors.push('Please enter a valid consultation fee amount.');
            this.showFieldError(consultationFees, 'Please enter a valid number.');
        } else {
            this.clearFieldError(consultationFees);
        }

        if (errors.length > 0) {
            this.showAlert(errors.join(' '), 'error');
            return false;
        }

        return true;
    }

    validateConsultationType(value) {
        const field = document.getElementById('consultationtype');
        if (value.length > 100) {
            this.showFieldError(field, 'Maximum 100 characters allowed.');
        } else {
            this.clearFieldError(field);
        }
    }

    validateConsultationFees(value) {
        const field = document.getElementById('consultationfees');
        if (value && !this.isValidNumber(value)) {
            this.showFieldError(field, 'Please enter a valid number.');
        } else {
            this.clearFieldError(field);
        }
    }

    isValidNumber(value) {
        return !isNaN(parseFloat(value)) && isFinite(value) && parseFloat(value) >= 0;
    }

    showFieldError(field, message) {
        if (!field) return;

        field.style.borderColor = '#dc3545';
        
        // Remove existing error message
        const existingError = field.parentNode.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }

        // Add error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.style.color = '#dc3545';
        errorDiv.style.fontSize = '12px';
        errorDiv.style.marginTop = '2px';
        errorDiv.textContent = message;
        field.parentNode.appendChild(errorDiv);
    }

    clearFieldError(field) {
        if (!field) return;

        field.style.borderColor = '';
        const errorDiv = field.parentNode.querySelector('.field-error');
        if (errorDiv) {
            errorDiv.remove();
        }
    }

    showAlert(message, type = 'info') {
        // Create modern alert
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'error' ? 'error' : 'success'}`;
        alertDiv.textContent = message;
        alertDiv.style.position = 'fixed';
        alertDiv.style.top = '20px';
        alertDiv.style.right = '20px';
        alertDiv.style.zIndex = '9999';
        alertDiv.style.maxWidth = '400px';
        alertDiv.style.padding = '15px 20px';
        alertDiv.style.borderRadius = '4px';
        alertDiv.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';

        document.body.appendChild(alertDiv);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.parentNode.removeChild(alertDiv);
            }
        }, 5000);
    }

    loadMoreData() {
        const scrollFunc = document.getElementById('scrollfunc');
        if (!scrollFunc || scrollFunc.value !== 'getdata') return;

        const serialNo = document.getElementById('serialno');
        const searchDeptAnum = document.getElementById('searchdepartmentanum');
        const searchSupplrAnum = document.getElementById('searchsupplieranum');

        if (!serialNo || !searchDeptAnum || !searchSupplrAnum) return;

        const data = {
            serialno: serialNo.value,
            action: 'scrollplanfunction',
            textid: '',
            sortfunc: 'asc',
            searchdepartmentanum: searchDeptAnum.value,
            searchsupplieranum: searchSupplrAnum.value
        };

        // Modern fetch API
        fetch('ajax/consultationtypedata.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(data)
        })
        .then(response => response.text())
        .then(html => {
            const insertPlan = document.getElementById('insertplan');
            if (insertPlan) {
                insertPlan.insertAdjacentHTML('beforeend', html);
                serialNo.value = parseFloat(serialNo.value) + 50;
            }
        })
        .catch(error => {
            console.error('Error loading more data:', error);
        });
    }

    // Delete confirmation with modern dialog
    confirmDelete(consultationType, autoNumber) {
        if (confirm(`Are you sure you want to delete consultation type "${consultationType}"?`)) {
            // Show loading state
            this.showAlert('Deleting consultation type...', 'info');
            
            // The actual deletion will be handled by the form submission
            return true;
        }
        return false;
    }
}

// Legacy function compatibility
window.funcPaymentTypeChange1 = function() {
    // Legacy payment type change function
    // This will be called if the modern method fails
};

window.ajaxlocationfunction = function(val) {
    // Legacy location function
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            const ajaxLocation = document.getElementById("ajaxlocation");
            if (ajaxLocation) {
                ajaxLocation.innerHTML = xmlhttp.responseText;
            }
        }
    };
    
    xmlhttp.open("GET", "ajax/ajaxgetlocationname.php?loccode=" + val, true);
    xmlhttp.send();
};

window.addward1process1 = function() {
    const consultationMaster = new ConsultationMaster();
    return consultationMaster.validateForm();
};

window.funcDeleteconsultationtype1 = function(varConsultationTypeAutoNumber) {
    const consultationMaster = new ConsultationMaster();
    return consultationMaster.confirmDelete(varConsultationTypeAutoNumber, varConsultationTypeAutoNumber);
};

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    new ConsultationMaster();
});

// Initialize with jQuery if available
if (typeof $ !== 'undefined') {
    $(document).ready(function() {
        new ConsultationMaster();
    });
}
