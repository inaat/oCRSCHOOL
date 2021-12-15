
$(document).ready(function () {
    fileinput_setting = {
        showUpload: false,
        showPreview: false,
        progress:false,
        browseLabel: LANG.file_browse_label,
        removeLabel: LANG.remove,
    };
    $(document).ajaxStart(function () {
        Pace.restart();
    });

    __select2($(".select2"));
    $('.date-picker').datepicker();
    $('.select2').select2({
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
    });
    $('.view_modal').on('show.bs.modal', function() {
        $('.view_modal')
            .find('.select2')
            .each(function() {
                var $p = $(this).parent();
                $(this).select2({
                    theme: 'bootstrap4'
                    , width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style'
                    , placeholder: $(this).data('placeholder')
                    , allowClear: Boolean($(this).data('allow-clear'))
                    , dropdownParent: $p
                });
            });
    })

    // popover
    $("body").on("mouseover", '[data-toggle="popover"]', function () {
        if ($(this).hasClass("popover-default")) {
            return false;
        }
        $(this).popover("show");
    });
    $(document).on('change', '#sms_service', function (e) {
        var sms_service = $(this).val();
        $('div.sms_service_settings').each(function () {
            if (sms_service == $(this).data('service')) {
                $(this).removeClass('d-none');
            } else {
                $(this).addClass('d-none');
            }
        });
    });
    //Date picker
    $(".start-date-picker").datepicker({
        autoclose: true,
        endDate: "today",
    });
 
    $(document).on("click", ".btn-modal", function (e) {
        e.preventDefault();
        var container = $(this).data("container");

        $.ajax({
            url: $(this).data("href"),
            dataType: "html",
            success: function (result) {
                $(container).html(result).modal("show");
            },
        });
    });


 


    var active = false;
    $(document).on("mousedown", ".drag-select", function (ev) {
        active = true;
        $(".active-cell").removeClass("active-cell"); // clear previous selection

        $(this).addClass("active-cell");
        cell_value = $(this).find("input").val();
    });
    $(document).on("mousemove", ".drag-select", function (ev) {
        if (active) {
            $(this).addClass("active-cell");
            $(this).find("input").val(cell_value);
        }
    });

    $(document).mouseup(function (ev) {
        active = false;
        if (
            !$(ev.target).hasClass("drag-select") &&
            !$(ev.target).hasClass("dpp") &&
            !$(ev.target).hasClass("dsp")
        ) {
            $(".active-cell").each(function () {
                $(this).removeClass("active-cell");
            });
        }
    });

    //End: CRUD for product variations
    $(document).on("change", ".toggler", function () {
        var parent_id = $(this).attr("data-toggle_id");
        if ($(this).is(":checked")) {
            $("#" + parent_id).removeClass("hide");
        } else {
            $("#" + parent_id).addClass("hide");
        }
    });

    $("#upload_document").fileinput(fileinput_setting);
    $(".upload_document").fileinput(fileinput_setting);
    //user profile
    $("form#edit_user_profile_form").validate();
    $("form#edit_password_form").validate({
        rules: {
            current_password: {
                required: true,
                minlength: 5,
            },
            new_password: {
                required: true,
                minlength: 5,
            },
            confirm_password: {
                equalTo: "#new_password",
            },
        },
    });

    $(document).on("ifChecked", ".check_all", function () {
        $(this)
            .closest(".check_group")
            .find(".input-icheck")
            .each(function () {
                $(this).iCheck("check");
            });
    });
    $(document).on("ifUnchecked", ".check_all", function () {
        $(this)
            .closest(".check_group")
            .find(".input-icheck")
            .each(function () {
                $(this).iCheck("uncheck");
            });
    });
    $(".check_all").each(function () {
        var length = 0;
        var checked_length = 0;
        $(this)
            .closest(".check_group")
            .find(".input-icheck")
            .each(function () {
                length += 1;
                if ($(this).iCheck("update")[0].checked) {
                    checked_length += 1;
                }
            });
        length = length - 1;
        if (checked_length != 0 && length == checked_length) {
            $(this).iCheck("check");
        }
    });

    if ($("#header_text").length) {
        init_tinymce("header_text");
    }

    if ($("#footer_text").length) {
        init_tinymce("footer_text");
    }

    $("button#full_screen").click(function (e) {
        element = document.documentElement;
        if (screenfull.isEnabled) {
            screenfull.toggle(element);
        }
    });

    //Search Settings
    //Set all labels as select2 options
    label_objects = [];
    search_options = [
        {
            id: "",
            text: "",
        },
    ];
    var i = 0;
    $(".pos-tab-container label").each(function () {
        label_objects.push($(this));
        var label_text = $(this)
            .text()
            .trim()
            .replace(":", "")
            .replace("*", "");
        search_options.push({
            id: i,
            text: label_text,
        });
        i++;
    });
    $("#search_settings").select2({
        data: search_options,
        placeholder: LANG.search,
    });
    $("#search_settings").change(function () {
        //Get label position and add active class to the tab
        var label_index = $(this).val();
        var label = label_objects[label_index];
        $(".pos-tab-content.active").removeClass("active");
        var tab_content = label.closest(".pos-tab-content");
        tab_content.addClass("active");
        tab_index = $(".pos-tab-content").index(tab_content);
        $(".list-group-item.active").removeClass("active");
        $(".list-group-item").eq(tab_index).addClass("active");

        //Highlight the label for three seconds
        $([document.documentElement, document.body]).animate(
            {
                scrollTop: label.offset().top - 100,
            },
            500
        );
        label.css("background-color", "yellow");
        setTimeout(function () {
            label.css("background-color", "");
        }, 3000);
    });
});

$(document).on("click", "table.ajax_view tbody tr", function (e) {
    if (
        !$(e.target).is("td.selectable_td input[type=checkbox]") &&
        !$(e.target).is("td.selectable_td") &&
        !$(e.target).is("td.clickable_td") &&
        !$(e.target).is("a") &&
        !$(e.target).is("button") &&
        !$(e.target).hasClass("label") &&
        !$(e.target).is("li") &&
        $(this).data("href") &&
        !$(e.target).is("i")
    ) {
        $.ajax({
            url: $(this).data("href"),
            dataType: "html",
            success: function (result) {
                $(".view_modal").html(result).modal("show");
            },
        });
    }
});
$(document).on("click", "td.clickable_td", function (e) {
    e.preventDefault();
    e.stopPropagation();
    if (
        e.target.tagName == "SPAN" ||
        e.target.tagName == "TD" ||
        e.target.tagName == "I"
    ) {
        return false;
    }
    var link = $(this).find("a");
    if (link.length) {
        if (!link.hasClass("no-ajax")) {
            var href = link.attr("href");
            var container = $(".payment_modal");

            $.ajax({
                url: href,
                dataType: "html",
                success: function (result) {
                    $(container).html(result).modal("show");
                    __currency_convert_recursively(container);
                },
            });
        }
    }
});

$(document).on("click", "button.select-all", function () {
    var this_select = $(this).closest(".form-group").find("select");
    this_select.find("option").each(function () {
        $(this).prop("selected", "selected");
    });
    this_select.trigger("change");
});
$(document).on("click", "button.deselect-all", function () {
    var this_select = $(this).closest(".form-group").find("select");
    this_select.find("option").each(function () {
        $(this).prop("selected", "");
    });
    this_select.trigger("change");
});

$(document).on("change", "input.row-select", function () {
    if (this.checked) {
        $(this).closest("tr").addClass("selected");
    } else {
        $(this).closest("tr").removeClass("selected");
    }
});

$(document).on("click", "#select-all-row", function (e) {
    var table_id = $(this).data("table-id");
    if (this.checked) {
        $("#" + table_id)
            .find("tbody")
            .find("input.row-select")
            .each(function () {
                if (!this.checked) {
                    $(this).prop("checked", true).change();
                }
            });
    } else {
        $("#" + table_id)
            .find("tbody")
            .find("input.row-select")
            .each(function () {
                if (this.checked) {
                    $(this).prop("checked", false).change();
                }
            });
    }
});

$(document).on("shown.bs.modal", ".view_modal", function (e) {
    if ($("#shipping_documents_dropzone").length) {
        $(this)
            .find("div#shipping_documents_dropzone")
            .dropzone({
                url: $("#media_upload_url").val(),
                paramName: "file",
                uploadMultiple: true,
                autoProcessQueue: false,
                addRemoveLinks: true,
                params: {
                    model_id: $("#model_id").val(),
                    model_type: $("#model_type").val(),
                    model_media_type: $("#model_media_type").val(),
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function (file, response) {
                    if (response.success) {
                        toastr.success(response.msg);
                        $("div.view_modal").modal("hide");
                    } else {
                        toastr.error(response.msg);
                    }
                },
            });
    }
});

$(document).on("show.bs.modal", function () {
    __currency_convert_recursively($(this));
});
$('#datetimepicker').datetimepicker({
    format: moment_date_format + ' ' + moment_time_format,
    ignoreReadonly: true,
});
    
$(document).on("shown.bs.modal", ".view_modal", function (e) {
    if ($(this).find("#email_body").length) {
        tinymce.init({
            selector: "textarea#email_body",
        });
    }
});
$(document).on("hidden.bs.modal", ".view_modal", function (e) {
    if ($(this).find("#email_body").length) {
        tinymce.remove("textarea#email_body");
    }

    //check if modal opened then make it scrollable
    if ($(".modal.in").length > 0) {
        $("body").addClass("modal-open");
    }
});

$(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
        $(".scrolltop:hidden").stop(true, true).fadeIn();
    } else {
        $(".scrolltop").stop(true, true).fadeOut();
    }
});
$(document).on('change', '.payment_types_dropdown', function () {
    var payment_type = $(this).val();
    var to_show = null;

    $(this)
        .closest('.payment_row')
        .find('.payment_details_div')
        .each(function () {
            if ($(this).attr('data-type') == payment_type) {
                to_show = $(this);
            } else {
                if (!$(this).hasClass('d-none')) {
                    $(this).addClass('d-none');
                }
            }
        });

    if (to_show && to_show.hasClass('d-none')) {
        to_show.removeClass('d-none');
        to_show.find('input').filter(':visible:first').focus();
    }
});

$(document).on('change', '.payment_types_dropdown', function(e) {
    var payment_type = $('#transaction_payment_add_form .payment_types_dropdown').val();
    account_dropdown = $('#transaction_payment_add_form #account_id');
    if (payment_type == 'advance') {
        if (account_dropdown) {
            account_dropdown.prop('disabled', true);
            account_dropdown.closest('.form-group').addClass('d-none');
        }
    } else {
        if (account_dropdown) {
            account_dropdown.prop('disabled', false); 
            account_dropdown.closest('.form-group').removeClass('d-none');
        }    
    }
});
$(document).on('click', 'a.pay_fee_due', function (e) {
    e.preventDefault();
    $.ajax({
        url: $(this).attr('href'),
        dataType: 'html',
        success: function (result) {
            $('.pay_fee_due_modal').html(result).modal('show');
            __currency_convert_recursively($('.pay_fee_due_modal'));
            $('#datetimepicker').datetimepicker({
                format: moment_date_format + ' ' + moment_time_format,
                
            });
            $('.pay_fee_due_modal').find('form#pay_student_due_form').validate();
        },
    });
});
$(document).on('click', 'a.pay_payroll_due', function (e) {
    e.preventDefault();
    $.ajax({
        url: $(this).attr('href'),
        dataType: 'html',
        success: function (result) {
            $('.pay_payroll_due_modal').html(result).modal('show');
            __currency_convert_recursively($('.pay_payroll_due_modal'));
            $('#datetimepicker').datetimepicker({
                format: moment_date_format + ' ' + moment_time_format,
                
            });
            $('.pay_payroll_due_modal').find('form#pay_employee_due_form').validate();
        },
    });
});
$(document).on('click', '.view_payment_modal', function(e) {
    e.preventDefault();
    var container = $('.payment_modal');

    $.ajax({
        url: $(this).attr('href'),
        dataType: 'html',
        success: function(result) {
            $(container)
                .html(result)
                .modal('show');
            __currency_convert_recursively(container);
        },
    });
});


$(function () {
    $(".scroll").click(function () {
        $("html,body").animate(
            { scrollTop: $(".thetop").offset().top },
            "1000"
        );
        return false;
    });
});




