// Add IP Package Modern JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize elements
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainContainer = document.querySelector('.main-container-with-sidebar');

    // Sidebar toggle functionality
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }

    // Form validation
    const form = document.querySelector('form[name="cbform1"]');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
            }
        });
    }

    // Initialize package form functionality
    initializePackageForm();
});

function validateForm() {
    // Add form validation logic here
    const requiredFields = document.querySelectorAll('[required]');
    for (let field of requiredFields) {
        if (!field.value.trim()) {
            showAlert(`Please fill in ${field.previousElementSibling.textContent}`, 'error');
            field.focus();
            return false;
        }
    }
    
    // Validate package name
    const packageName = document.getElementById('packagename');
    if (packageName && !packageName.value.trim()) {
        showAlert('Please enter a package name', 'error');
        packageName.focus();
        return false;
    }
    
    // Validate days
    const days = document.getElementById('days');
    if (days && (!days.value || isNaN(days.value) || days.value <= 0)) {
        showAlert('Please enter a valid number of days', 'error');
        days.focus();
        return false;
    }
    
    return true;
}

function initializePackageForm() {
    // Initialize package form functionality
    const serviceItems = document.querySelectorAll('.service-item input[type="checkbox"]');
    serviceItems.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updatePackageSummary();
        });
    });
    
    const rateInputs = document.querySelectorAll('.service-rate');
    rateInputs.forEach(input => {
        input.addEventListener('input', function() {
            updatePackageSummary();
        });
    });
    
    // Initialize package summary
    updatePackageSummary();
}

function updatePackageSummary() {
    // Update package summary calculations
    const summaryContainer = document.getElementById('packageSummary');
    if (!summaryContainer) return;
    
    let totalAmount = 0;
    const selectedServices = [];
    
    const serviceItems = document.querySelectorAll('.service-item');
    serviceItems.forEach(item => {
        const checkbox = item.querySelector('input[type="checkbox"]');
        const rateInput = item.querySelector('.service-rate');
        
        if (checkbox && checkbox.checked && rateInput) {
            const rate = parseFloat(rateInput.value) || 0;
            const serviceName = item.querySelector('label').textContent.trim();
            totalAmount += rate;
            selectedServices.push({
                name: serviceName,
                rate: rate
            });
        }
    });
    
    // Update summary display
    const totalElement = summaryContainer.querySelector('.total-amount');
    if (totalElement) {
        totalElement.textContent = totalAmount.toFixed(2);
    }
    
    // Update services list
    const servicesList = summaryContainer.querySelector('.selected-services');
    if (servicesList) {
        servicesList.innerHTML = selectedServices.map(service => 
            `<div class="summary-item">
                <span>${service.name}</span>
                <span>${service.rate.toFixed(2)}</span>
            </div>`
        ).join('');
    }
}

function addService() {
    // Add new service to package
    const servicesContainer = document.querySelector('.package-services');
    if (servicesContainer) {
        const serviceItem = document.createElement('div');
        serviceItem.className = 'service-item';
        serviceItem.innerHTML = `
            <input type="checkbox" id="service_${Date.now()}">
            <label for="service_${Date.now()}">New Service</label>
            <input type="number" class="service-rate form-control" placeholder="Rate" step="0.01">
        `;
        servicesContainer.appendChild(serviceItem);
        
        // Add event listeners to new service
        const checkbox = serviceItem.querySelector('input[type="checkbox"]');
        const rateInput = serviceItem.querySelector('.service-rate');
        
        checkbox.addEventListener('change', updatePackageSummary);
        rateInput.addEventListener('input', updatePackageSummary);
    }
}

function removeService(serviceId) {
    // Remove service from package
    const serviceItem = document.getElementById(serviceId);
    if (serviceItem) {
        serviceItem.remove();
        updatePackageSummary();
    }
}

function savePackage() {
    // Save package configuration
    const packageName = document.getElementById('packagename').value;
    const days = document.getElementById('days').value;
    const bedCharges = document.getElementById('bedcharges').value;
    
    if (!packageName || !days) {
        showAlert('Please fill in all required fields', 'error');
        return;
    }
    
    console.log('Saving package:', packageName);
    showAlert('Saving package configuration...', 'info');
    
    // Here you would typically submit the form or make an AJAX call
    // document.querySelector('form[name="cbform1"]').submit();
}

function previewPackage() {
    // Preview package configuration
    const packageName = document.getElementById('packagename').value;
    const days = document.getElementById('days').value;
    
    if (!packageName || !days) {
        showAlert('Please fill in package name and days', 'error');
        return;
    }
    
    console.log('Previewing package:', packageName);
    showAlert('Generating package preview...', 'info');
}

function resetPackageForm() {
    // Reset package form
    const form = document.querySelector('form[name="cbform1"]');
    if (form) {
        form.reset();
        updatePackageSummary();
        showAlert('Package form reset', 'info');
    }
}

// Utility functions
function showAlert(message, type = 'info') {
    const alertContainer = document.querySelector('.alert-container');
    if (alertContainer) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} alert-icon"></i>
            ${message}
        `;
        alertContainer.appendChild(alert);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            alert.remove();
        }, 5000);
    }
}

// Export functions for global access
window.showAlert = showAlert;
window.addService = addService;
window.removeService = removeService;
window.savePackage = savePackage;
window.previewPackage = previewPackage;
window.resetPackageForm = resetPackageForm;
