@extends("admin_layouts.app")
@section("wrapper")
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">@lang('class.manage_your_classes')</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('class.classes')</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                            <h5 class="card-title text-primary">@lang('class.class_list')</h5>

               <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="ms-auto"><button type="button"
                                class="btn btn-primary radius-30 mt-2 mt-lg-0 btn-modal"
                                data-href="{{ action('ClassController@create') }}"
                                data-container=".classes_modal">
                                <i class="bx bxs-plus-square"></i>@lang('class.add_new_class')</button></div>
                </div>



                <hr>

                <div class="table-responsive">
                    <table class="table mb-0" width="100%" id="classes_table">
                        <thead class="table-light" width="100%">
                            <tr>
                                <th>@lang('global_lang.action')</th>
                                <th>@lang('campus.campus_name')</th>
                                <th>@lang('class_level.class_level')</th>
                                <th>@lang('class.title')</th>
                                <th>@lang('class.tuition_fee')</th>
                                <th>@lang('class.admission_fee')</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
</div>
 <div class="modal fade classes_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  </div>
@endsection
@section('javascript')
<script>
    $(document).ready(function() {

        //classes_table
        var classes_table = $("#classes_table").DataTable({
            processing: true
            , serverSide: true
            , ajax: "/classes"
            , columns: [{
                    data: "action"
                    , name: "action"
                }
                , {
                    data: "campus_name"
                    , name: "campus_name"
                }
                , {
                    data: "class_level"
                    , name: "class_level"
                }
                 , {
                    data: "title"
                    , name: "title"
                }
                , {
                    data: "tuition_fee"
                    , name: "tuition_fee"
                }
                , {
                    data: "admission_fee"
                    , name: "admission_fee"
                }
            , ]
        , });

   $(document).on("submit", "form#class_add_form", function (e) {
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
                    $("div.classes_modal").modal("hide");
                    toastr.success(result.msg);
                    classes_table.ajax.reload();
                } else {
                    toastr.error(result.msg);
                }
            },
        });
    });
 $(document).on("click", ".edit_class_button", function () {
        $("div.classes_modal").load($(this).data("href"), function () {
            $(this).modal("show");

            $("form#class_edit_form").submit(function (e) {
                e.preventDefault();
                var form = $(this);
                var data = form.serialize();

                $.ajax({
                    method: "POST",
                    url: $(this).attr("action"),
                    dataType: "json",
                    data: data,
                    beforeSend: function (xhr) {
                        __disable_submit_button(
                            form.find('button[type="submit"]')
                        );
                    },
                    success: function (result) {
                        if (result.success == true) {
                            $("div.classes_modal").modal("hide");
                            toastr.success(result.msg);
                           classes_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });
            });
        });
    });
    });

</script>
@endsection
