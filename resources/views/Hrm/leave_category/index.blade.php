@extends("admin_layouts.app")
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">@lang('hrm.all_your_leave_categories')</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('hrm.leave_categories')</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary">@lang('hrm.settings')</button>
                        <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item"
                                href="javascript:;">Action</a>
                            <a class="dropdown-item" href="javascript:;">Another action</a>
                            <a class="dropdown-item" href="javascript:;">Something else here</a>
                            <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated
                                link</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">@lang('hrm.leave_category_list')
                        <small class="text-info font-13"></small>
                    </h5>


                    <div class="d-lg-flex align-items-center mb-4 gap-3">

                        <div class="ms-auto"><button type="button"
                                class="btn btn-primary radius-30 mt-2 mt-lg-0 btn-modal"
                                data-href="{{ action('HRM\HrmLeaveCategoryController@create') }}"
                                data-container=".leave_categories_modal">
                                <i class="bx bxs-plus-square"></i>@lang('hrm.add_new_leave_category')</button></div>

                    </div>


                    <hr>

                    <div class="table-responsive">
                        <table class="table mb-0" width="100%" id="leave_categories_table">
                            <thead class="table-light" width="100%">
                                <tr>
                                    <th>@lang('hrm.leave_category_name')</th>
                                    <th>@lang('hrm.max_leave_count')</th>
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
    <div class="modal fade leave_categories_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
@endsection


@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {

            $(".upload_org_logo").on('change', function() {
                __readURL(this, '.org_logo');
            });
            $(".upload_org_favicon").on('change', function() {
                __readURL(this, '.org_favicon');
            });
            //leave_categories table
            var leave_categories_table = $("#leave_categories_table").DataTable({
                processing: true,
                serverSide: true,
                ajax: "/hrm-leave_category",
             columnDefs: [
                    {
                        targets: 2,
                        orderable: false,
                        searchable: false,
                    },
                ],
            });

            $(document).on("submit", "form#leave_category_add_form", function(e) {
                e.preventDefault();
                var form = $(this);
                var data = form.serialize();
                $.ajax({
                    method: "POST",
                    url: $(this).attr("action"),
                    dataType: "json",
                    data: data,
                    beforeSend: function(xhr) {
                        __enable_submit_button(form.find('button[type="submit"]'));
                    },
                    success: function(result) {
                        if (result.success == true) {
                            $("div.leave_categories_modal").modal("hide");
                            toastr.success(result.msg);
                            leave_categories_table.ajax.reload();
                        } else {
                            if ($.isEmptyObject(result.error)) {
                                toastr.error(result.msg);
                            }
                            __printErrorMsg(result.error)
                            __enable_submit_button(form.find('button[type="submit"]'));

                            //
                        }
                    },
                });
            });

            ///Check Error Handling And Remove Error Data
            $(document).on("keyup", "input", function(e) {
                var checkError = $('.error-text').text();
                if ($.isEmptyObject(checkError)) {} else {
                    $('.error-text').empty();
                }
            });
            ////
            $(document).on("click", "button.edit_leave_category_button", function() {
                $("div.leave_categories_modal").load($(this).data("href"), function() {
                    $(this).modal("show");

                    $("form#leave_category_edit_form").submit(function(e) {
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
                                    $("div.leave_categories_modal").modal(
                                        "hide");
                                    toastr.success(result.msg);
                                    leave_categories_table.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            },
                        });
                    });
                });
            });

            $(document).on("click", "button.delete_leave_category_button", function() {
                swal({
                    title: LANG.sure,
                    text: LANG.confirm_delete_leave_category,
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
                                    leave_categories_table.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            },
                        });
                    }
                });
            });

            function printErrorMsg(msg) {
                $(".print-error-msg").find("ul").html('');
                $(".print-error-msg").css('display', 'block');
                $.each(msg, function(key, value) {
                    $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
                });
            }
        });
    </script>
@endsection
