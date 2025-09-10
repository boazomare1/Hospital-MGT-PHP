/**
 * Modern JavaScript for addcategory1.php - Category Management System
 * Enhances the existing functionality with modern UI interactions
 */

class CategoryManager {
    constructor() {
        this.currentCategory = null;
        this.isEditing = false;
        this.isLoading = false;
        this.initialize();
    }

    initialize() {
        this.bindEvents();
        this.setupFormValidation();
        this.setupKeyboardShortcuts();
        this.setupCategoryTable();
        this.initializeForm();
        this.setupSearchAndFilter();
    }

    bindEvents() {
        // Form submission
        const form = document.querySelector('form[name="categoryForm"]');
        if (form) {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleFormSubmit();
            });
        }

        // Reset button
        const resetButton = document.querySelector('input[type="reset"]');
        if (resetButton) {
            resetButton.addEventListener('click', (e) => {
                e.preventDefault();
                this.resetForm();
            });
        }

        // Category name input
        const categoryNameInput = document.getElementById('categoryName');
        if (categoryNameInput) {
            categoryNameInput.addEventListener('input', (e) => {
                this.handleCategoryNameChange(e.target.value);
            });
            
            categoryNameInput.addEventListener('blur', () => {
                this.validateCategoryName();
            });
        }

        // Category description input
        const categoryDescInput = document.getElementById('categoryDesc');
        if (categoryDescInput) {
            categoryDescInput.addEventListener('input', (e) => {
                this.handleCategoryDescChange(e.target.value);
            });
            
            categoryDescInput.addEventListener('blur', () => {
                this.validateCategoryDesc();
            });
        }

        // Category status select
        const categoryStatusSelect = document.getElementById('categoryStatus');
        if (categoryStatusSelect) {
            categoryStatusSelect.addEventListener('change', (e) => {
                this.handleStatusChange(e.target.value);
            });
        }

        // Search input
        const searchInput = document.getElementById('categorySearch');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                this.handleSearch(e.target.value);
            });
        }

        // Filter buttons
        const filterButtons = document.querySelectorAll('.filter-chip');
        filterButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                this.handleFilterClick(e.target);
            });
        });
    }

    setupFormValidation() {
        // Real-time validation for category name
        const categoryNameInput = document.getElementById('categoryName');
        if (categoryNameInput) {
            categoryNameInput.addEventListener('keyup', () => {
                this.validateCategoryName();
            });
        }
        
        // Real-time validation for category description
        const categoryDescInput = document.getElementById('categoryDesc');
        if (categoryDescInput) {
            categoryDescInput.addEventListener('keyup', () => {
                this.validateCategoryDesc();
            });
        }
        
        // Real-time validation for category code
        const categoryCodeInput = document.getElementById('categoryCode');
        if (categoryCodeInput) {
            categoryCodeInput.addEventListener('blur', () => {
                this.validateCategoryCode();
            });
        }
    }

    setupKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Ctrl/Cmd + Enter to submit form
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                e.preventDefault();
                this.handleFormSubmit();
            }
            
            // Escape to reset form
            if (e.key === 'Escape') {
                this.resetForm();
            }
            
            // Ctrl/Cmd + S to save
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                this.handleFormSubmit();
            }
            
            // Tab navigation enhancement
            if (e.key === 'Tab') {
                this.handleTabNavigation(e);
            }
        });
    }

    setupCategoryTable() {
        const categoryTable = document.querySelector('table[id="categoryTable"]');
        if (categoryTable) {
            this.enhanceCategoryTable(categoryTable);
        }
    }

    setupSearchAndFilter() {
        // Initialize search functionality
        this.initializeSearch();
        
        // Initialize filter functionality
        this.initializeFilters();
    }

    initializeForm() {
        // Set initial form state
        this.clearForm();
        
        // Set default values
        this.setDefaultValues();
        
        // Focus on first input
        const firstInput = document.querySelector('input[type="text"]');
        if (firstInput) {
            firstInput.focus();
        }
    }

    handleCategoryNameChange(value) {
        this.currentCategory = this.currentCategory || {};
        this.currentCategory.name = value;
        
        // Auto-generate category code if empty
        this.autoGenerateCategoryCode(value);
        
        // Real-time validation
        this.validateCategoryName();
    }

    handleCategoryDescChange(value) {
        this.currentCategory = this.currentCategory || {};
        this.currentCategory.description = value;
        
        // Real-time validation
        this.validateCategoryDesc();
    }

    handleStatusChange(value) {
        this.currentCategory = this.currentCategory || {};
        this.currentCategory.status = value;
        
        // Update UI based on status
        this.updateStatusUI(value);
    }

    handleSearch(searchTerm) {
        if (!searchTerm) {
            this.showAllCategories();
            return;
        }
        
        this.filterCategories(searchTerm);
    }

    handleFilterClick(filterButton) {
        // Remove active class from all filters
        document.querySelectorAll('.filter-chip').forEach(btn => {
            btn.classList.remove('active');
        });
        
        // Add active class to clicked filter
        filterButton.classList.add('active');
        
        // Apply filter
        const filterType = filterButton.dataset.filter;
        this.applyFilter(filterType);
    }

    autoGenerateCategoryCode(categoryName) {
        if (!categoryName) return;
        
        const categoryCodeInput = document.getElementById('categoryCode');
        if (categoryCodeInput && !categoryCodeInput.value) {
            // Generate code from category name
            const code = categoryName
                .toUpperCase()
                .replace(/[^A-Z0-9]/g, '')
                .substring(0, 8);
            
            categoryCodeInput.value = code;
        }
    }

    updateStatusUI(status) {
        const statusIndicator = document.querySelector('.status-indicator');
        if (statusIndicator) {
            statusIndicator.className = `status-indicator status-${status}`;
            statusIndicator.textContent = status;
        }
    }

    validateCategoryName() {
        const categoryNameInput = document.getElementById('categoryName');
        if (!categoryNameInput) return true;
        
        const value = categoryNameInput.value.trim();
        
        if (!value) {
            this.showFieldError(categoryNameInput, 'Category name is required');
            return false;
        }
        
        if (value.length < 2) {
            this.showFieldError(categoryNameInput, 'Category name must be at least 2 characters');
            return false;
        }
        
        if (value.length > 50) {
            this.showFieldError(categoryNameInput, 'Category name cannot exceed 50 characters');
            return false;
        }
        
        this.clearFieldError(categoryNameInput);
        return true;
    }

    validateCategoryDesc() {
        const categoryDescInput = document.getElementById('categoryDesc');
        if (!categoryDescInput) return true;
        
        const value = categoryDescInput.value.trim();
        
        if (value && value.length > 200) {
            this.showFieldError(categoryDescInput, 'Description cannot exceed 200 characters');
            return false;
        }
        
        this.clearFieldError(categoryDescInput);
        return true;
    }

    validateCategoryCode() {
        const categoryCodeInput = document.getElementById('categoryCode');
        if (!categoryCodeInput) return true;
        
        const value = categoryCodeInput.value.trim();
        
        if (!value) {
            this.showFieldError(categoryCodeInput, 'Category code is required');
            return false;
        }
        
        if (value.length < 2) {
            this.showFieldError(categoryCodeInput, 'Category code must be at least 2 characters');
            return false;
        }
        
        if (value.length > 10) {
            this.showFieldError(categoryCodeInput, 'Category code cannot exceed 10 characters');
            return false;
        }
        
        // Check for valid characters (alphanumeric and hyphens)
        if (!/^[A-Z0-9-]+$/i.test(value)) {
            this.showFieldError(categoryCodeInput, 'Category code can only contain letters, numbers, and hyphens');
            return false;
        }
        
        this.clearFieldError(categoryCodeInput);
        return true;
    }

    showFieldError(field, message) {
        if (!field) return;
        
        // Remove existing error
        this.clearFieldError(field);
        
        // Add error class
        field.classList.add('error');
        
        // Create error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.textContent = message;
        
        // Insert error message after field
        field.parentNode.insertBefore(errorDiv, field.nextSibling);
    }

    clearFieldError(field) {
        if (!field) return;
        
        field.classList.remove('error');
        
        const errorDiv = field.parentNode.querySelector('.field-error');
        if (errorDiv) {
            errorDiv.remove();
        }
    }

    validateForm() {
        let isValid = true;
        
        // Validate category name
        if (!this.validateCategoryName()) {
            isValid = false;
        }
        
        // Validate category description
        if (!this.validateCategoryDesc()) {
            isValid = false;
        }
        
        // Validate category code
        if (!this.validateCategoryCode()) {
            isValid = false;
        }
        
        return isValid;
    }

    handleFormSubmit() {
        if (!this.validateForm()) {
            this.showNotification('Please fix the errors in the form', 'error');
            return;
        }
        
        this.setLoadingState(true);
        
        // Show loading indicator
        this.showLoadingIndicator();
        
        // Collect form data
        const formData = this.collectFormData();
        
        // Simulate form submission (replace with actual AJAX call)
        setTimeout(() => {
            this.setLoadingState(false);
            this.hideLoadingIndicator();
            
            if (this.isEditing) {
                this.updateCategory(formData);
            } else {
                this.createCategory(formData);
            }
        }, 1000);
    }

    collectFormData() {
        const form = document.querySelector('form[name="categoryForm"]');
        if (!form) return {};
        
        const formData = new FormData(form);
        return Object.fromEntries(formData.entries());
    }

    createCategory(formData) {
        // Simulate category creation
        const newCategory = {
            id: Date.now(),
            ...formData,
            createdAt: new Date().toISOString(),
            status: formData.status || 'active'
        };
        
        // Add to table
        this.addCategoryToTable(newCategory);
        
        // Show success message
        this.showNotification('Category created successfully', 'success');
        
        // Reset form
        this.resetForm();
        
        // Update category count
        this.updateCategoryCount();
    }

    updateCategory(formData) {
        // Simulate category update
        const updatedCategory = {
            ...this.currentCategory,
            ...formData,
            updatedAt: new Date().toISOString()
        };
        
        // Update in table
        this.updateCategoryInTable(updatedCategory);
        
        // Show success message
        this.showNotification('Category updated successfully', 'success');
        
        // Reset form
        this.resetForm();
        
        // Exit edit mode
        this.exitEditMode();
    }

    addCategoryToTable(category) {
        const table = document.querySelector('table[id="categoryTable"] tbody');
        if (!table) return;
        
        const row = document.createElement('tr');
        row.className = 'data-row';
        row.dataset.categoryId = category.id;
        
        row.innerHTML = `
            <td>${category.code}</td>
            <td>${category.name}</td>
            <td>${category.description || '-'}</td>
            <td>
                <span class="category-status ${category.status}">${category.status}</span>
            </td>
            <td class="category-actions-cell">
                <button class="btn btn-sm btn-primary edit-category" data-category-id="${category.id}">
                    Edit
                </button>
                <button class="btn btn-sm btn-danger delete-category" data-category-id="${category.id}">
                    Delete
                </button>
            </td>
        `;
        
        // Add event listeners
        this.addCategoryRowEventListeners(row);
        
        // Add to table
        table.appendChild(row);
    }

    updateCategoryInTable(category) {
        const row = document.querySelector(`tr[data-category-id="${category.id}"]`);
        if (!row) return;
        
        row.innerHTML = `
            <td>${category.code}</td>
            <td>${category.name}</td>
            <td>${category.description || '-'}</td>
            <td>
                <span class="category-status ${category.status}">${category.status}</span>
            </td>
            <td class="category-actions-cell">
                <button class="btn btn-sm btn-primary edit-category" data-category-id="${category.id}">
                    Edit
                </button>
                <button class="btn btn-sm btn-danger delete-category" data-category-id="${category.id}">
                    Delete
                </button>
            </td>
        `;
        
        // Re-add event listeners
        this.addCategoryRowEventListeners(row);
    }

    addCategoryRowEventListeners(row) {
        // Edit button
        const editButton = row.querySelector('.edit-category');
        if (editButton) {
            editButton.addEventListener('click', (e) => {
                this.editCategory(e.target.dataset.categoryId);
            });
        }
        
        // Delete button
        const deleteButton = row.querySelector('.delete-category');
        if (deleteButton) {
            deleteButton.addEventListener('click', (e) => {
                this.deleteCategory(e.target.dataset.categoryId);
            });
        }
    }

    editCategory(categoryId) {
        // Find category data
        const row = document.querySelector(`tr[data-category-id="${categoryId}"]`);
        if (!row) return;
        
        // Extract category data from row
        const categoryData = {
            id: categoryId,
            code: row.cells[0].textContent,
            name: row.cells[1].textContent,
            description: row.cells[2].textContent === '-' ? '' : row.cells[2].textContent,
            status: row.cells[3].querySelector('.category-status').textContent
        };
        
        // Populate form
        this.populateForm(categoryData);
        
        // Enter edit mode
        this.enterEditMode(categoryData);
        
        // Focus on first input
        const firstInput = document.querySelector('input[type="text"]');
        if (firstInput) {
            firstInput.focus();
        }
    }

    deleteCategory(categoryId) {
        if (!confirm('Are you sure you want to delete this category? This action cannot be undone.')) {
            return;
        }
        
        // Remove from table
        const row = document.querySelector(`tr[data-category-id="${categoryId}"]`);
        if (row) {
            row.remove();
        }
        
        // Show success message
        this.showNotification('Category deleted successfully', 'success');
        
        // Update category count
        this.updateCategoryCount();
        
        // Check if we're editing this category
        if (this.currentCategory && this.currentCategory.id === categoryId) {
            this.resetForm();
            this.exitEditMode();
        }
    }

    populateForm(categoryData) {
        const codeInput = document.getElementById('categoryCode');
        const nameInput = document.getElementById('categoryName');
        const descInput = document.getElementById('categoryDesc');
        const statusSelect = document.getElementById('categoryStatus');
        
        if (codeInput) codeInput.value = categoryData.code;
        if (nameInput) nameInput.value = categoryData.name;
        if (descInput) descInput.value = categoryData.description;
        if (statusSelect) statusSelect.value = categoryData.status;
        
        // Update current category
        this.currentCategory = categoryData;
    }

    enterEditMode(categoryData) {
        this.isEditing = true;
        this.currentCategory = categoryData;
        
        // Update form title
        const formTitle = document.querySelector('.category-form h2');
        if (formTitle) {
            formTitle.textContent = 'Edit Category';
        }
        
        // Update submit button
        const submitButton = document.querySelector('input[type="submit"]');
        if (submitButton) {
            submitButton.value = 'Update Category';
        }
        
        // Show cancel button
        this.showCancelButton();
        
        // Update status UI
        this.updateStatusUI(categoryData.status);
    }

    exitEditMode() {
        this.isEditing = false;
        this.currentCategory = null;
        
        // Update form title
        const formTitle = document.querySelector('.category-form h2');
        if (formTitle) {
            formTitle.textContent = 'Add New Category';
        }
        
        // Update submit button
        const submitButton = document.querySelector('input[type="submit"]');
        if (submitButton) {
            submitButton.value = 'Create Category';
        }
        
        // Hide cancel button
        this.hideCancelButton();
        
        // Clear status UI
        this.clearStatusUI();
    }

    showCancelButton() {
        let cancelButton = document.querySelector('.cancel-edit');
        if (!cancelButton) {
            cancelButton = document.createElement('button');
            cancelButton.type = 'button';
            cancelButton.className = 'btn btn-secondary cancel-edit';
            cancelButton.textContent = 'Cancel';
            cancelButton.addEventListener('click', () => {
                this.cancelEdit();
            });
            
            // Insert after submit button
            const submitButton = document.querySelector('input[type="submit"]');
            if (submitButton && submitButton.parentNode) {
                submitButton.parentNode.insertBefore(cancelButton, submitButton.nextSibling);
            }
        }
    }

    hideCancelButton() {
        const cancelButton = document.querySelector('.cancel-edit');
        if (cancelButton) {
            cancelButton.remove();
        }
    }

    cancelEdit() {
        this.resetForm();
        this.exitEditMode();
        this.showNotification('Edit cancelled', 'info');
    }

    clearStatusUI() {
        const statusIndicator = document.querySelector('.status-indicator');
        if (statusIndicator) {
            statusIndicator.className = 'status-indicator';
            statusIndicator.textContent = '';
        }
    }

    resetForm() {
        const form = document.querySelector('form[name="categoryForm"]');
        if (form) {
            form.reset();
        }
        
        // Clear current category
        this.currentCategory = null;
        
        // Clear all field errors
        this.clearAllFieldErrors();
        
        // Set default values
        this.setDefaultValues();
        
        // Exit edit mode if editing
        if (this.isEditing) {
            this.exitEditMode();
        }
    }

    clearAllFieldErrors() {
        const errorFields = document.querySelectorAll('.error');
        errorFields.forEach(field => {
            this.clearFieldError(field);
        });
    }

    setDefaultValues() {
        const statusSelect = document.getElementById('categoryStatus');
        if (statusSelect) {
            statusSelect.value = 'active';
        }
    }

    setLoadingState(loading) {
        this.isLoading = loading;
        
        const submitButton = document.querySelector('input[type="submit"]');
        if (submitButton) {
            submitButton.disabled = loading;
            submitButton.value = loading ? 'Processing...' : (this.isEditing ? 'Update Category' : 'Create Category');
        }
        
        const resetButton = document.querySelector('input[type="reset"]');
        if (resetButton) {
            resetButton.disabled = loading;
        }
    }

    showLoadingIndicator() {
        // Create loading overlay
        const loadingOverlay = document.createElement('div');
        loadingOverlay.id = 'loading-overlay';
        loadingOverlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        `;
        
        const loadingSpinner = document.createElement('div');
        loadingSpinner.className = 'loading-spinner';
        loadingSpinner.style.cssText = `
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        `;
        
        loadingOverlay.appendChild(loadingSpinner);
        document.body.appendChild(loadingOverlay);
    }

    hideLoadingIndicator() {
        const loadingOverlay = document.getElementById('loading-overlay');
        if (loadingOverlay) {
            loadingOverlay.remove();
        }
    }

    enhanceCategoryTable(table) {
        // Add modern classes
        table.classList.add('category-table');
        
        // Enhance table rows
        const rows = table.querySelectorAll('tr');
        rows.forEach((row, index) => {
            if (index === 0) {
                // Header row
                row.classList.add('table-header');
            } else {
                // Data row
                row.classList.add('data-row');
                if (index % 2 === 0) {
                    row.classList.add('even-row');
                }
                
                // Add event listeners
                this.addCategoryRowEventListeners(row);
            }
        });
        
        // Add hover effects
        this.addTableHoverEffects(table);
        
        // Add sorting capabilities
        this.addTableSorting(table);
    }

    addTableHoverEffects(table) {
        const rows = table.querySelectorAll('tr:not(.table-header)');
        rows.forEach(row => {
            row.addEventListener('mouseenter', () => {
                row.style.backgroundColor = 'var(--bg-tertiary)';
            });
            
            row.addEventListener('mouseleave', () => {
                if (row.classList.contains('even-row')) {
                    row.style.backgroundColor = 'var(--bg-secondary)';
                } else {
                    row.style.backgroundColor = 'var(--bg-primary)';
                }
            });
        });
    }

    addTableSorting(table) {
        const headers = table.querySelectorAll('th');
        headers.forEach((header, index) => {
            if (index < headers.length - 1) { // Skip actions column
                header.style.cursor = 'pointer';
                header.addEventListener('click', () => {
                    this.sortTable(table, index);
                });
                
                // Add sort indicator
                const sortIndicator = document.createElement('span');
                sortIndicator.textContent = ' ↕';
                sortIndicator.style.cssText = `
                    font-size: 0.8rem;
                    opacity: 0.5;
                    margin-left: 0.5rem;
                `;
                header.appendChild(sortIndicator);
            }
        });
    }

    sortTable(table, columnIndex) {
        const tbody = table.querySelector('tbody');
        if (!tbody) return;
        
        const rows = Array.from(tbody.querySelectorAll('tr'));
        
        // Sort rows
        rows.sort((a, b) => {
            const aValue = a.cells[columnIndex]?.textContent || '';
            const bValue = b.cells[columnIndex]?.textContent || '';
            
            // Try to parse as number first
            const aNum = parseFloat(aValue.replace(/[^\d.-]/g, ''));
            const bNum = parseFloat(bValue.replace(/[^\d.-]/g, ''));
            
            if (!isNaN(aNum) && !isNaN(bNum)) {
                return aNum - bNum;
            }
            
            // Fall back to string comparison
            return aValue.localeCompare(bValue);
        });
        
        // Reorder rows
        rows.forEach(row => {
            tbody.appendChild(row);
        });
        
        this.showNotification('Table sorted successfully', 'success');
    }

    initializeSearch() {
        // Create search input if it doesn't exist
        let searchInput = document.getElementById('categorySearch');
        if (!searchInput) {
            const searchContainer = document.createElement('div');
            searchContainer.className = 'category-search';
            
            searchContainer.innerHTML = `
                <div class="form-group">
                    <label for="categorySearch" class="form-label">Search Categories</label>
                    <input type="text" id="categorySearch" class="form-control" placeholder="Search by name, code, or description...">
                </div>
            `;
            
            // Insert before category table
            const categoryTable = document.querySelector('table[id="categoryTable"]');
            if (categoryTable && categoryTable.parentNode) {
                categoryTable.parentNode.insertBefore(searchContainer, categoryTable);
            }
            
            searchInput = document.getElementById('categorySearch');
        }
        
        // Add event listener
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                this.handleSearch(e.target.value);
            });
        }
    }

    initializeFilters() {
        // Create filter chips if they don't exist
        let filterContainer = document.querySelector('.category-filters');
        if (!filterContainer) {
            filterContainer = document.createElement('div');
            filterContainer.className = 'category-filters';
            
            filterContainer.innerHTML = `
                <span class="filter-chip active" data-filter="all">All</span>
                <span class="filter-chip" data-filter="active">Active</span>
                <span class="filter-chip" data-filter="inactive">Inactive</span>
                <span class="filter-chip" data-filter="pending">Pending</span>
            `;
            
            // Insert after search
            const searchContainer = document.querySelector('.category-search');
            if (searchContainer && searchContainer.parentNode) {
                searchContainer.parentNode.insertBefore(filterContainer, searchContainer.nextSibling);
            }
        }
        
        // Add event listeners
        const filterChips = filterContainer.querySelectorAll('.filter-chip');
        filterChips.forEach(chip => {
            chip.addEventListener('click', (e) => {
                this.handleFilterClick(e.target);
            });
        });
    }

    filterCategories(searchTerm) {
        const rows = document.querySelectorAll('table[id="categoryTable"] tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const matches = text.includes(searchTerm.toLowerCase());
            
            if (matches) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        
        // Update category count
        this.updateCategoryCount();
    }

    showAllCategories() {
        const rows = document.querySelectorAll('table[id="categoryTable"] tbody tr');
        rows.forEach(row => {
            row.style.display = '';
        });
        
        // Update category count
        this.updateCategoryCount();
    }

    applyFilter(filterType) {
        const rows = document.querySelectorAll('table[id="categoryTable"] tbody tr');
        
        rows.forEach(row => {
            if (filterType === 'all') {
                row.style.display = '';
            } else {
                const statusCell = row.querySelector('.category-status');
                if (statusCell) {
                    const status = statusCell.textContent.toLowerCase();
                    const matches = status === filterType;
                    row.style.display = matches ? '' : 'none';
                }
            }
        });
        
        // Update category count
        this.updateCategoryCount();
    }

    updateCategoryCount() {
        const visibleRows = document.querySelectorAll('table[id="categoryTable"] tbody tr:not([style*="display: none"])');
        const totalRows = document.querySelectorAll('table[id="categoryTable"] tbody tr');
        
        // Update count display if it exists
        let countDisplay = document.querySelector('.category-count');
        if (!countDisplay) {
            countDisplay = document.createElement('div');
            countDisplay.className = 'category-count';
            countDisplay.style.cssText = `
                text-align: right;
                color: var(--text-muted);
                font-size: var(--font-size-sm);
                margin-bottom: var(--spacing-md);
            `;
            
            // Insert before table
            const categoryTable = document.querySelector('table[id="categoryTable"]');
            if (categoryTable && categoryTable.parentNode) {
                categoryTable.parentNode.insertBefore(countDisplay, categoryTable);
            }
        }
        
        countDisplay.textContent = `Showing ${visibleRows.length} of ${totalRows.length} categories`;
    }

    handleTabNavigation(e) {
        // Add visual feedback for tab navigation
        const activeElement = document.activeElement;
        if (activeElement && (activeElement.tagName === 'INPUT' || activeElement.tagName === 'SELECT')) {
            activeElement.classList.add('tab-highlight');
            
            setTimeout(() => {
                activeElement.classList.remove('tab-highlight');
            }, 200);
        }
    }

    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        
        // Style the notification
        Object.assign(notification.style, {
            position: 'fixed',
            top: '20px',
            right: '20px',
            padding: '12px 20px',
            borderRadius: '8px',
            color: 'white',
            fontWeight: '600',
            zIndex: '9999',
            transform: 'translateX(100%)',
            transition: 'transform 0.3s ease'
        });
        
        // Set background color based on type
        const colors = {
            success: 'var(--success-color)',
            error: 'var(--danger-color)',
            warning: 'var(--warning-color)',
            info: 'var(--info-color)'
        };
        notification.style.backgroundColor = colors[type] || colors.info;
        
        // Add to page
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }

    // Initialize the manager when DOM is ready
    static init() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                window.categoryManager = new CategoryManager();
            });
        } else {
            window.categoryManager = new CategoryManager();
        }
    }
}

// Initialize the category manager
CategoryManager.init();

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = CategoryManager;
}



