// Template Purchase Modern JavaScript - Based on vat.php functionality

$(document).ready(function() {
    // Initialize modern functionality
    initializeModernFeatures();
    
    // Setup form validation
    setupFormValidation();
    
    // Setup responsive sidebar
    setupResponsiveSidebar();
    
    // Setup modern alerts
    setupModernAlerts();
    
    // Setup template enhancements
    setupTemplateEnhancements();
});

// Initialize modern features
function initializeModernFeatures() {
    // Add fade-in animation to main content
    $('.main-content').addClass('fade-in');
    
    // Setup tooltips for action buttons
    $('[title]').each(function() {
        $(this).tooltip({
            position: { my: "left+15 center", at: "right center" }
        });
    });
    
    // Add loading states to buttons
    $('.submit-btn').on('click', function() {
        $(this).addClass('loading');
        setTimeout(() => {
            $(this).removeClass('loading');
        }, 2000);
    });
}

// Setup form validation
function setupFormValidation() {
    $('#templateForm').on('submit', function(e) {
        var isValid = true;
        var errorMessages = [];
        
        // Validate template name
        if ($('#rolename').val().trim() === '') {
            errorMessages.push('Please enter a template name');
            $('#rolename').addClass('error');
            isValid = false;
        } else {
            $('#rolename').removeClass('error');
        }
        
        // Validate template ID
        if ($('#roleid').val().trim() === '') {
            errorMessages.push('Template ID is required');
            $('#roleid').addClass('error');
            isValid = false;
        } else {
            $('#roleid').removeClass('error');
        }
        
        if (!isValid) {
            e.preventDefault();
            showAlert(errorMessages.join('<br>'), 'error');
            return false;
        }
        
        // Show loading state
        showAlert('Creating template...', 'info');
    });
}

// Setup responsive sidebar
function setupResponsiveSidebar() {
    // Toggle sidebar
    $('#sidebarToggle').on('click', function() {
        $('#leftSidebar').toggleClass('collapsed');
        $(this).find('i').toggleClass('fa-chevron-left fa-chevron-right');
    });
    
    // Floating menu toggle
    $('#menuToggle').on('click', function() {
        $('#leftSidebar').toggleClass('collapsed');
        $('#sidebarToggle i').toggleClass('fa-chevron-left fa-chevron-right');
    });
    
    // Close sidebar on mobile when clicking outside
    $(document).on('click', function(e) {
        if ($(window).width() <= 768) {
            if (!$(e.target).closest('#leftSidebar, #menuToggle').length) {
                $('#leftSidebar').addClass('collapsed');
            }
        }
    });
    
    // Handle window resize
    $(window).on('resize', function() {
        if ($(window).width() > 768) {
            $('#leftSidebar').removeClass('collapsed');
        }
    });
}

// Setup modern alerts
function setupModernAlerts() {
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut(500, function() {
            $(this).remove();
        });
    }, 5000);
    
    // Add close button to alerts
    $('.alert').each(function() {
        if (!$(this).find('.alert-close').length) {
            $(this).append('<button class="alert-close" onclick="$(this).parent().fadeOut()"><i class="fas fa-times"></i></button>');
        }
    });
}

// Show modern alert
function showAlert(message, type) {
    var alertClass = 'alert-' + type;
    var iconClass = 'fas fa-info-circle';
    
    switch(type) {
        case 'success':
            iconClass = 'fas fa-check-circle';
            break;
        case 'error':
            iconClass = 'fas fa-exclamation-triangle';
            break;
        case 'warning':
            iconClass = 'fas fa-exclamation-circle';
            break;
    }
    
    var alertHtml = `
        <div class="alert ${alertClass} fade-in">
            <i class="${iconClass} alert-icon"></i>
            <span>${message}</span>
            <button class="alert-close" onclick="$(this).parent().fadeOut()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    $('#alertContainer').html(alertHtml);
    
    // Auto-hide after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut(500, function() {
            $(this).remove();
        });
    }, 5000);
}

// Setup template enhancements
function setupTemplateEnhancements() {
    // Setup table enhancements
    setupTableEnhancements();
    
    // Setup search functionality
    setupSearchFunctionality();
}

// Setup table enhancements
function setupTableEnhancements() {
    // Add hover effects to table rows
    $('.data-table tbody tr').hover(
        function() {
            $(this).addClass('hover');
        },
        function() {
            $(this).removeClass('hover');
        }
    );
    
    // Add sorting functionality to table headers
    $('.data-table th').each(function() {
        if ($(this).text().trim() !== '') {
            $(this).addClass('sortable');
            $(this).append(' <i class="fas fa-sort sort-icon"></i>');
        }
    });
    
    // Add click handlers for sorting
    $('.data-table th.sortable').on('click', function() {
        var column = $(this).index();
        var table = $(this).closest('table');
        var rows = table.find('tbody tr').toArray();
        
        // Simple sorting logic
        rows.sort(function(a, b) {
            var aVal = $(a).find('td').eq(column).text().trim();
            var bVal = $(b).find('td').eq(column).text().trim();
            
            // Try to parse as numbers first
            var aNum = parseFloat(aVal.replace(/[^\d.-]/g, ''));
            var bNum = parseFloat(bVal.replace(/[^\d.-]/g, ''));
            
            if (!isNaN(aNum) && !isNaN(bNum)) {
                return aNum - bNum;
            }
            
            return aVal.localeCompare(bVal);
        });
        
        // Reorder rows
        table.find('tbody').empty().append(rows);
        
        // Update sort icons
        $('.data-table th .sort-icon').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort');
        $(this).find('.sort-icon').removeClass('fa-sort').addClass('fa-sort-up');
    });
}

// Setup search functionality
function setupSearchFunctionality() {
    // Add search input event listener
    $('#searchInput').on('input', function() {
        var searchTerm = $(this).val().toLowerCase();
        searchTemplates(searchTerm);
    });
}

// Search templates function
function searchTemplates(searchTerm) {
    $('.data-table tbody tr').each(function() {
        var templateId = $(this).find('td:nth-child(2)').text().toLowerCase();
        var templateName = $(this).find('td:nth-child(3)').text().toLowerCase();
        
        if (templateId.includes(searchTerm) || templateName.includes(searchTerm)) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
    
    // Update search results count
    var visibleRows = $('.data-table tbody tr:visible').length;
    var totalRows = $('.data-table tbody tr').length;
    
    if (searchTerm !== '') {
        showAlert(`Found ${visibleRows} of ${totalRows} templates`, 'info');
    }
}

// Clear search
function clearSearch() {
    $('#searchInput').val('');
    $('.data-table tbody tr').show();
}

// Reset form
function resetForm() {
    $('#templateForm')[0].reset();
    $('.form-input').removeClass('error');
    showAlert('Form has been reset', 'info');
}

// Refresh page
function refreshPage() {
    showAlert('Refreshing page...', 'info');
    setTimeout(function() {
        window.location.reload();
    }, 1000);
}

// Export to Excel
function exportToExcel() {
    showAlert('Preparing Excel export...', 'info');
    
    // Create a simple CSV export
    var csvContent = "data:text/csv;charset=utf-8,";
    csvContent += "Template ID,Template Name,Template Mapping\n";
    
    $('.data-table tbody tr:visible').each(function() {
        var templateId = $(this).find('td:nth-child(2)').text();
        var templateName = $(this).find('td:nth-child(3)').text();
        var templateMapping = $(this).find('td:nth-child(4)').text();
        
        csvContent += `"${templateId}","${templateName}","${templateMapping}"\n`;
    });
    
    // Create download link
    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "purchase_templates.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    setTimeout(function() {
        showAlert('Excel export completed', 'success');
    }, 2000);
}

// Confirm delete function (keeping original functionality)
function confirmDelete(templateId, autoNumber) {
    if (confirm('Are you sure you want to delete template ' + templateId + '?')) {
        showAlert('Deleting template...', 'info');
        
        // Create delete URL
        var deleteUrl = `template_purchase.php?st=del&&anum=${autoNumber}&&roleid=${templateId}`;
        
        // Redirect to delete URL
        window.location.href = deleteUrl;
    }
}

// Enhanced form validation function (keeping original functionality)
function addsalutation1process1() {
    // This function is called from the form's onSubmit event
    // The modern validation is handled by setupFormValidation()
    return true;
}

// Setup keyboard shortcuts
function setupKeyboardShortcuts() {
    $(document).on('keydown', function(e) {
        // Ctrl + R to refresh
        if (e.ctrlKey && e.keyCode === 82) {
            e.preventDefault();
            refreshPage();
        }
        
        // Ctrl + E to export
        if (e.ctrlKey && e.keyCode === 69) {
            e.preventDefault();
            exportToExcel();
        }
        
        // Ctrl + N to focus on template name input
        if (e.ctrlKey && e.keyCode === 78) {
            e.preventDefault();
            $('#rolename').focus();
        }
        
        // Escape to close sidebar
        if (e.keyCode === 27) {
            $('#leftSidebar').addClass('collapsed');
        }
    });
}

// Initialize all enhancements
$(document).ready(function() {
    setupKeyboardShortcuts();
    
    // Add smooth scrolling
    $('a[href^="#"]').on('click', function(e) {
        e.preventDefault();
        var target = $(this.getAttribute('href'));
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 500);
        }
    });
    
    // Add loading animation to page
    $('body').addClass('loaded');
    
    // Auto-focus on template name input when page loads
    $('#rolename').focus();
});

// Utility functions
function formatTemplateId(templateId) {
    return templateId.toUpperCase();
}

function validateTemplateName(name) {
    // Basic validation for template name
    if (name.length < 3) {
        return 'Template name must be at least 3 characters long';
    }
    
    if (name.length > 50) {
        return 'Template name must be less than 50 characters';
    }
    
    if (!/^[a-zA-Z0-9\s\-_]+$/.test(name)) {
        return 'Template name can only contain letters, numbers, spaces, hyphens, and underscores';
    }
    
    return null;
}

// Template management functions
function duplicateTemplate(templateId) {
    showAlert('Duplicating template...', 'info');
    
    // This would typically make an AJAX call to duplicate the template
    // For now, we'll just show a message
    setTimeout(function() {
        showAlert('Template duplication feature coming soon', 'info');
    }, 1000);
}

function previewTemplate(templateId) {
    showAlert('Opening template preview...', 'info');
    
    // Open template mapping in a new window
    var previewUrl = `template_mapping.php?template_id=${templateId}&preview=true`;
    window.open(previewUrl, '_blank', 'width=800,height=600');
}

// Error handling
window.addEventListener('error', function(e) {
    console.error('JavaScript Error:', e.error);
    showAlert('An error occurred. Please refresh the page.', 'error');
});

// Performance monitoring
window.addEventListener('load', function() {
    console.log('Template Purchase page loaded successfully');
    
    // Log performance metrics
    if (window.performance && window.performance.timing) {
        var loadTime = window.performance.timing.loadEventEnd - window.performance.timing.navigationStart;
        console.log('Page load time:', loadTime + 'ms');
    }
});

