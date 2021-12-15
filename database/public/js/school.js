$(document).ready(function () {
    ///Progress 
    var progress_table = $("#progress_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/class-subject-progress",
            data: function (d) {
                if ($('#subject_id').length) {
                    d.subject_id = $('#subject_id').val();
                }
                d = __datatable_ajax_callback(d);
            },
        },

        columns: [
            {
                data: "action",
                name: "action",
            },
            {
                data: "name",
                name: "name",
            },
            {
                data: "chapter",
                name: "chapter",
            },
            {
                data: "status",
                name: "status",
            },
        ],
    });

    $(document).on("change", "#chapter_progress", function () {
        var chapter_progress = $("#chapter_progress").val();
        var subject_id = $("#subject_id").val();

        __get_chapter_lessons(subject_id, chapter_progress);
        progress_table.ajax.reload();
    });
    $("form#progress_add_form").validate({
        rules: {
            start_date: {
                required: true,
            },
        },
    });

    $(document).on("submit", "form#progress_add_form", function (e) {
        e.preventDefault();
        var form = $(this);
        var data = form.serialize();

        $.ajax({
            method: "POST",
            url: $(this).attr("action"),
            dataType: "json",
            data: data,
            beforeSend: function (xhr) {
                __disable_submit_button(form.find('button[type="submit"]'));
            },
            success: function (result) {
                if (result.success == true) {
                    toastr.success(result.msg);
                    progress_table.ajax.reload();
                    form.each(function () {
                        this.reset();
                    });
                    $("#chapter_progress").val("").trigger("change");
                    $("#lessons_ids").val("").trigger("change");

                    __enable_submit_button(form.find('button[type="submit"]'));
                } else {
                    toastr.error(result.msg);
                    __enable_submit_button(form.find('button[type="submit"]'));
                }
            },
        });
    });

    $(document).on("click", "a.delete_progress_button", function () {
        swal({
            title: LANG.sure,
            text: LANG.confirm_delete_class_subject,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                var href = $(this).data("href");
                var data = $(this).serialize();

                $.ajax({
                    method: "DELETE",
                    url: href,
                    dataType: "json",
                    data: data,
                    success: function (result) {
                        if (result.success == true) {
                            toastr.success(result.msg);
                            progress_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });
            }
        });
    });
    $(document).on("click", "a.class_subject_progress_status", function () {
        swal({
            title: LANG.sure,
            text: LANG.confirm_session_activate,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                var href = $(this).data("href");
                var data = $(this).serialize();

                $.ajax({
                    method: "GET",
                    url: href,
                    dataType: "json",
                    data: data,
                    success: function (result) {
                        if (result.success == true) {
                            toastr.success(result.msg);
                            progress_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });
            }
        });
    });
    ////Lesson
    var lessons_table = $("#lessons_table").DataTable({
        processing: true
        , serverSide: true
        , "ajax": {
            "url": "/class-subject"
            , "data": function(d) {

                if ($('#subject_id').length) {
                    d.subject_id = $('#subject_id').val();
                }
                if ($('#chapter_number').length) {
                    d.chapter_number = $('#chapter_number').val();
                }
                d = __datatable_ajax_callback(d);
            }
        }

        , columns: [{
                data: "action"
                , name: "action"
            }
            , {
                data: "name"
                , name: "name"
            }
            , {
                data: "chapter_number"
                , name: "chapter_number"
            }
            , {
                data: "description"
                , name: "description"
            },

        ]
    , });

$(document).on('change',
            '#chapter_number',
            function() {
                lessons_table.ajax.reload();
            });
              $(document).on("submit", "form#lesson_add_form", function(e) {
           e.preventDefault();
           var form = $(this);
           var data = form.serialize();

           $.ajax({
               method: "POST",
               url: $(this).attr("action"),
               dataType: "json",
               data: data,
               beforeSend: function(xhr) {
                   __disable_submit_button(form.find('button[type="submit"]'));
               },
               success: function(result) {
                   if (result.success == true) {
                       $("div.lesson_modal").modal("hide");
                       toastr.success(result.msg);
                       lessons_table.ajax.reload();
                   } else {
                       toastr.error(result.msg);
                   }
               },
           });
       });
       
       $(document).on("click", "a.edit_lesson_button", function() {
           $("div.lesson_modal").load($(this).data("href"), function() {
               $(this).modal("show");

               $("form#lesson_edit_form").submit(function(e) {
                   e.preventDefault();
                   var form = $(this);
                   var data = form.serialize();

                   $.ajax({
                       method: "POST",
                       url: $(this).attr("action"),
                       dataType: "json",
                       data: data,
                       beforeSend: function(xhr) {
                           __disable_submit_button(
                               form.find('button[type="submit"]')
                           );
                       },
                       success: function(result) {
                           if (result.success == true) {
                               $("div.lesson_modal").modal("hide");
                               toastr.success(result.msg);
                               lessons_table.ajax.reload();
                           } else {
                               toastr.error(result.msg);
                           }
                       },
                   });
               });
           });
       });
        $(document).on("click", "a.delete_lesson_button", function() {
           swal({
               title: LANG.sure,
               text: LANG.confirm_delete_class_subject,
               icon: "warning",
               buttons: true,
               dangerMode: true,
           }).then((willDelete) => {
               if (willDelete) {
                   var href = $(this).data("href");
                   var data = $(this).serialize();

                   $.ajax({
                       method: "DELETE",
                       url: href,
                       dataType: "json",
                       data: data,
                       success: function(result) {
                           if (result.success == true) {
                               toastr.success(result.msg);
                               lessons_table.ajax.reload();
                           } else {
                               toastr.error(result.msg);
                           }
                       },
                   });
               }
           });
       });
       ////Question Bank
       if ($('textarea#product_description').length > 0) {
        tinymce.init({
            selector: 'textarea#product_description',
            height:250
        });
    }

});
