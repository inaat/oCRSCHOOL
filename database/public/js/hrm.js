$(document).ready(function() {
    $('#month_year').datepicker({
        autoclose: true
        , format: 'mm/yyyy'
        , minViewMode: "months"
    });

    if ($(".table").length) {
        $(".table").DataTable({
            dom: 'T<"clear"><"button">lfrtip'
            , bFilter: false
            , bLengthChange: false
        , });
    }

__calculateTotalGrossAmount();

    $(document).on('change', 'input.allowance-amount,input.allowance-check', function() {
        var total = 0;
        var table = $(this).closest('table');
        table.find('tbody tr').each(function() {
            if ($(this).find('input.allowance-check').is(':checked')) {
                var allowance = __read_number($(this).find('input.allowance-amount')) ? __read_number($(
                        this)
                    .find('input.allowance-amount')) : 0;
                var subtotal = allowance;
                total = total + subtotal;
            }
        });
        table.find('span.allowance_final_total').text(__currency_trans_from_en(total, true));
         __write_number($('input#allowance_final_total'),total);
        __calculateTotalGrossAmount();


    });
    $(document).on('change', '.deduction-amount,.deduction-check', function() {
        var total = 0;
        var table = $(this).closest('.deduction-table');
        table.find('tbody tr').each(function() {
            if ($(this).find('.deduction-check').is(':checked')) {
                var deduction = __read_number($(this).find('.deduction-amount')) ? __read_number($(this)
                    .find('.deduction-amount')) : 0;
                var subtotal = deduction;
                total = total + subtotal;

                $(this).find('.deduction-divider').val(0);
            }
        });
        table.find('span.deduction_final_total').text(__currency_trans_from_en(total, true));
         __write_number($('#deduction_final_total'),total);
        __calculateTotalGrossAmount();

    });
    $(document).on('change', '.deduction-divider,.deduction-check', function() {
        var total = 0;
        var table = $(this).closest('.deduction-table');
        table.find('tbody tr').each(function() {
            if ($(this).find('.deduction-check').is(':checked')) {
                 var transaction_final_total = __read_number($('#transaction_final_total'));
                if (transaction_final_total > 0) {
                    var day_salary = transaction_final_total / 30;
                    var divider = $(this).find('.deduction-divider').val();

                   __write_number($(this).find('.deduction-amount'),day_salary * divider);

                }
                var deduction = __read_number($(this).find('.deduction-amount')) ? __read_number($(this)
                    .find('.deduction-amount')) : 0;
                var subtotal = deduction;
                total = total + subtotal;
            }
        });
        table.find('span.deduction_final_total').text(__currency_trans_from_en(total, true));
         __write_number($('#deduction_final_total'),total);
        __calculateTotalGrossAmount();

    });

});