// Bill Estimate Modern JavaScript

document.addEventListener('DOMContentLoaded', function() {
    setupSidebarToggle();
    setupFormValidation();
    setupPrescriptionTable();
});

function setupSidebarToggle() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
}

function setupFormValidation() {
    const form = document.querySelector('form[name="form1"]');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }
        });
    }
}

function validateForm() {
    const patientcode = document.getElementById('patientcode');
    const visitcode = document.getElementById('visitcode');
    
    if (!patientcode || !patientcode.value.trim()) {
        alert('Please select a patient');
        return false;
    }
    
    if (!visitcode || !visitcode.value.trim()) {
        alert('Please enter visit code');
        return false;
    }
    
    return true;
}

function setupPrescriptionTable() {
    const addRowBtn = document.getElementById('addRowBtn');
    if (addRowBtn) {
        addRowBtn.addEventListener('click', addPrescriptionRow);
    }
}

function addPrescriptionRow() {
    const tableBody = document.querySelector('.prescription-table tbody');
    if (!tableBody) return;
    
    const rowCount = tableBody.querySelectorAll('.prescription-row').length + 1;
    
    const newRow = document.createElement('tr');
    newRow.className = 'prescription-row';
    newRow.innerHTML = `
        <td><input type="text" class="medicine-name" name="medicinename_${rowCount}" placeholder="Medicine name"></td>
        <td><input type="number" class="quantity" name="quantity_${rowCount}" min="1" value="1" onchange="calculateRowAmount(this.closest('tr'))"></td>
        <td><input type="number" class="rate" name="rate_${rowCount}" min="0" step="0.01" value="0" onchange="calculateRowAmount(this.closest('tr'))"></td>
        <td><input type="number" class="amount" name="amount_${rowCount}" readonly></td>
        <td><button type="button" class="action-btn remove" onclick="removePrescriptionRow(this)"><i class="fas fa-trash"></i></button></td>
    `;
    
    tableBody.appendChild(newRow);
}

function calculateRowAmount(row) {
    const quantityInput = row.querySelector('.quantity');
    const rateInput = row.querySelector('.rate');
    const amountInput = row.querySelector('.amount');
    
    if (!quantityInput || !rateInput || !amountInput) return;
    
    const quantity = parseFloat(quantityInput.value) || 0;
    const rate = parseFloat(rateInput.value) || 0;
    const amount = quantity * rate;
    
    amountInput.value = amount.toFixed(2);
    calculateTotalEstimate();
}

function removePrescriptionRow(button) {
    const row = button.closest('.prescription-row');
    if (row) {
        row.remove();
        calculateTotalEstimate();
    }
}

function calculateTotalEstimate() {
    const rows = document.querySelectorAll('.prescription-row');
    let totalAmount = 0;
    
    rows.forEach(row => {
        const amountInput = row.querySelector('.amount');
        if (amountInput) {
            totalAmount += parseFloat(amountInput.value) || 0;
        }
    });
    
    const totalDisplay = document.getElementById('totalAmount');
    if (totalDisplay) {
        totalDisplay.textContent = `₹ ${totalAmount.toFixed(2)}`;
    }
    
    const totalHidden = document.getElementById('total5');
    if (totalHidden) {
        totalHidden.value = totalAmount.toFixed(2);
    }
}

function printEstimate() {
    window.print();
}