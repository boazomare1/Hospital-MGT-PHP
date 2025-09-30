// Add Employee Job Title Modern JavaScript
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

    // Initialize form validation
    initializeFormValidation();
});

function initializeFormValidation() {
    const form = document.getElementById('form1');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
            }
        });
    }
}

function validateForm() {
    const jobTitle = document.getElementById('jobtitle');
    
    if (!jobTitle || jobTitle.value.trim() === '') {
        showAlert('Please Enter Job Title.', 'error');
        if (jobTitle) {
            jobTitle.focus();
        }
        return false;
    }
    
    return true;
}

function ajaxlocationfunction(val) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            const ajaxLocation = document.getElementById("ajaxlocation");
            if (ajaxLocation) {
                ajaxLocation.innerHTML = xmlhttp.responseText;
            }
        }
    }
    
    xmlhttp.open("GET", "ajax/ajaxgetlocationname.php?loccode=" + val, true);
    xmlhttp.send();
}

function addward1process1() {
    const jobTitle = document.getElementById('jobtitle');
    
    if (!jobTitle || jobTitle.value.trim() === '') {
        showAlert('Please Enter Job Title.', 'error');
        if (jobTitle) {
            jobTitle.focus();
        }
        return false;
    }
    
    return true;
}

function funcDeleteDepartment1(varDepartmentAutoNumber) {
    const fRet = confirm('Are you sure want to delete this Job Title ' + varDepartmentAutoNumber + '?');
    
    if (fRet == true) {
        showAlert('Job Title Entry Delete Completed.', 'success');
        return true;
    } else {
        showAlert('Job Title Entry Delete Not Completed.', 'info');
        return false;
    }
}

function noDecimal(evt) {
    const charCode = (evt.which) ? evt.which : event.keyCode;
    
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    } else {
        return true;
    }
}

function refreshData() {
    showAlert('Refreshing data...', 'info');
    location.reload();
}

function goToPage(page) {
    const url = new URL(window.location);
    url.searchParams.set('page', page);
    window.location.href = url.toString();
}

function nextPage() {
    const currentPage = getCurrentPage();
    const totalPages = getTotalPages();
    if (currentPage < totalPages) {
        goToPage(currentPage + 1);
    }
}

function previousPage() {
    const currentPage = getCurrentPage();
    if (currentPage > 1) {
        goToPage(currentPage - 1);
    }
}

function getCurrentPage() {
    const urlParams = new URLSearchParams(window.location.search);
    return parseInt(urlParams.get('page')) || 1;
}

function getTotalPages() {
    // This would need to be passed from PHP or calculated
    // For now, we'll use a simple approach
    return 1; // This should be updated based on actual data
}

function addNewJobTitle() {
    const jobTitleInput = document.getElementById('jobtitle');
    if (jobTitleInput) {
        jobTitleInput.focus();
    }
}

function editJobTitle(jobTitleId) {
    showAlert('Opening edit form for Job Title ID: ' + jobTitleId, 'info');
    // Redirect to edit page
    window.location.href = 'editempjobtitle.php?st=edit&&anum=' + jobTitleId;
}

function deleteJobTitle(jobTitleId, jobTitleName) {
    if (funcDeleteDepartment1(jobTitleName)) {
        // Redirect to delete action
        window.location.href = 'addempjobtitle.php?st=del&&anum=' + jobTitleId;
    }
}

function activateJobTitle(jobTitleId) {
    if (confirm('Are you sure you want to activate this Job Title?')) {
        showAlert('Activating Job Title...', 'info');
        // Redirect to activate action
        window.location.href = 'addempjobtitle.php?st=activate&&anum=' + jobTitleId;
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
window.ajaxlocationfunction = ajaxlocationfunction;
window.addward1process1 = addward1process1;
window.funcDeleteDepartment1 = funcDeleteDepartment1;
window.noDecimal = noDecimal;
window.refreshData = refreshData;
window.addNewJobTitle = addNewJobTitle;
window.editJobTitle = editJobTitle;
window.deleteJobTitle = deleteJobTitle;
window.activateJobTitle = activateJobTitle;
