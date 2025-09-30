$(document).ready(function() {
    // Sidebar toggle functionality
    const sidebar = $('#leftSidebar');
    const sidebarToggle = $('#sidebarToggle');
    const menuToggle = $('#menuToggle');
    const mainContent = $('.main-content');

    // Function to toggle sidebar
    function toggleSidebar() {
        sidebar.toggleClass('collapsed');
        mainContent.toggleClass('sidebar-collapsed');
        sidebarToggle.find('i').toggleClass('fa-chevron-left fa-chevron-right');
    }

    // Toggle sidebar on button click
    sidebarToggle.on('click', toggleSidebar);

    // Toggle sidebar on floating menu icon click (for mobile)
    menuToggle.on('click', toggleSidebar);

    // Close sidebar if clicked outside on mobile
    $(document).on('click touchstart', function(event) {
        if ($(window).width() <= 768) {
            if (!sidebar.is(event.target) && sidebar.has(event.target).length === 0 &&
                !menuToggle.is(event.target) && menuToggle.has(event.target).length === 0 &&
                !sidebar.hasClass('collapsed')) {
                toggleSidebar();
            }
        }
    });

    // Adjust sidebar on window resize
    $(window).on('resize', function() {
        if ($(window).width() > 768) {
            sidebar.removeClass('collapsed');
            mainContent.removeClass('sidebar-collapsed');
            sidebarToggle.find('i').removeClass('fa-chevron-right').addClass('fa-chevron-left');
        } else {
            sidebar.addClass('collapsed');
            mainContent.addClass('sidebar-collapsed');
            sidebarToggle.find('i').removeClass('fa-chevron-left').addClass('fa-chevron-right');
        }
    }).trigger('resize');

    // Form reset functionality
    window.resetForm = function() {
        document.forms["cbform1"].reset();
        $('#alertContainer').empty();
    };

    // Payment form reset
    window.resetPaymentForm = function() {
        document.forms["form1"].reset();
        $('#paymentamount').val('0.00');
        $('#netpayable').val('0.00');
        $('#taxamount').val('');
        $('#bankcharges').val('0.00');
    };

    // Page refresh functionality
    window.refreshPage = function() {
        location.reload();
    };

    // Print receipt functionality
    window.printReceipt = function() {
        var docno = "<?php echo isset($docno) ? $docno : ''; ?>";
        if (docno) {
            window.open("print_doctorremittances.php?docno=" + docno, "PrintWindow", 
                'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
        } else {
            alert('No receipt available to print.');
        }
    };

    // Alert message auto-hide
    setTimeout(function() {
        $('.alert').fadeOut('slow', function() {
            $(this).remove();
        });
    }, 5000);

    // Form validation enhancements
    $('.form-input').on('blur', function() {
        if ($(this).hasClass('amount-input')) {
            var value = $(this).val();
            if (value && !isNaN(value)) {
                $(this).val(parseFloat(value).toFixed(2));
            }
        }
    });

    // Payment mode change handler
    $('#paymentmode').on('change', function() {
        var mode = $(this).val();
        var chequeNumberField = $('#chequenumber');
        var bankNameField = $('#bankname');
        
        if (mode === 'CHEQUE' || mode === 'MPESA') {
            chequeNumberField.prop('required', true);
            bankNameField.prop('required', true);
        } else {
            chequeNumberField.prop('required', false);
            bankNameField.prop('required', false);
        }
    });

    // Auto-format amount inputs
    $('.amount-input').on('input', function() {
        var value = $(this).val();
        // Remove non-numeric characters except decimal point
        value = value.replace(/[^0-9.]/g, '');
        // Ensure only one decimal point
        value = value.replace(/(\..*)\./g, '$1');
        $(this).val(value);
    });
});






