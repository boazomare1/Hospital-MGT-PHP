// Cost Center Report Modern JavaScript
document.addEventListener('DOMContentLoaded', function() {
    console.log('Cost Center Report page initialized');
});

function funchangeperiod(period) {
    // Backward compatibility function
    console.log('Period changed to:', period);
}

function valid() {
    // Backward compatibility function
    return true;
}

function disableEnterKey(varPassed) {
    if (event.keyCode === 13) {
        return false;
    }
    return true;
}

function process1backkeypress1() {
    if (event.keyCode === 8) {
        event.keyCode = 0;
        return false;
    }
}

function exportExcel() {
    console.log('Exporting to Excel...');
}

function refreshPage() {
    window.location.reload();
}

function printReport() {
    window.print();
}