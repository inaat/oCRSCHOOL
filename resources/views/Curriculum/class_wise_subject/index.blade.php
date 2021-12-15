@extends("admin_layouts.app")
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">@lang('lang.class_curriculum')</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('lang.class_subjects')</li>
                        </ol>
                    </nav>
                </div>
            </div> 
            <!--end breadcrumb-->

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">@lang('lang.class_subject_list')
                        <small class="text-info font-13"></small>
                    </h5>


                    <div class="d-lg-flex align-items-center mb-4 gap-3">

                        <div class="ms-auto"><button type="button"
                                class="btn btn-primary radius-30 mt-2 mt-lg-0 btn-modal"
                                data-href="{{ action('Curriculum\CurriculumController@create',[$class_id]) }}"
                                data-container=".class_subjects_modal">
                                <i class="bx bxs-plus-square"></i>@lang('lang.add_new_class_subject')</button></div>

                    </div>


                    <hr>

                    <div class="table-responsive">
                        <table class="table mb-0" width="100%" id="class_subjects_table">
                            <thead class="table-light" width="100%">
                                <tr>
                                    <th>@lang('lang.class_subject_name')</th>
                                    <th>@lang('lang.campus_name')</th>
                                    <th>@lang('lang.class_name')</th>
                                    <th>@lang('lang.passing_percentage')</th>
                                    <th>@lang('lang.chapters')</th>
                                    <th>@lang('lang.description')</th>
                                    <th>@lang('lang.action')</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
    <div class="modal fade class_subjects_modal contains_select2" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
  @endsection


@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            //class_subjects table
            var class_subjects_table = $("#class_subjects_table").DataTable({
                processing: true,
                serverSide: true,
                ajax: "/class-curriculum/{{ $class_id }}",
                columns: [{
                    data: "subject_name",
                    name: "subject_name"
                }, {
              
                    data: "campus_name",
                    name: "campus_name"
                }, 
                 {
              
                    data: "class_name",
                    name: "class_name"
                },
                 {
                    data: "passing_percentage",
                    name: "passing_percentage"
                }, 
                 {
                    data: "chapters",
                    name: "chapters"
                }, 
                 {
                    data: "description",
                    name: "description"
                }, {
                    data: "action",
                    name: "action"
                }, ],
            });

            $(document).on("submit", "form#class_subject_add_form", function(e) {
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
                            $("div.class_subjects_modal").modal("hide");
                            toastr.success(result.msg);
                            class_subjects_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });
            });


            $(document).on("click", "a.edit_class_subject_button", function() {
                $("div.class_subjects_modal").load($(this).data("href"), function() {
                    $(this).modal("show");

                    $("form#class_subject_edit_form").submit(function(e) {
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
                                    $("div.class_subjects_modal").modal("hide");
                                    toastr.success(result.msg);
                                    class_subjects_table.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            },
                        });
                    });
                });
            });

            $(document).on("click", "a.delete_class_subject_button", function() {
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
                                    class_subjects_table.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            },
                        });
                    }
                });
            });
        });
    </script>
@endsection
