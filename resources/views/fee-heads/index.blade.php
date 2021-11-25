@extends("admin_layouts.app")
@section("wrapper")
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">@lang('lang.manage_your_heads')</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.fee_heads')</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                            <h5 class="card-title text-primary">@lang('lang.fee_head_list')</h5>

               <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="ms-auto"><button type="button"
                                class="btn btn-primary radius-30 mt-2 mt-lg-0 btn-modal"
                                data-href="{{ action('FeeHeadController@create') }}"
                                data-container=".fee-head_modal">
                                <i class="bx bxs-plus-square"></i>@lang('lang.add_new_fee_head')</button></div>
                </div>



                <hr>

                <div class="table-responsive">
                    <table class="table mb-0" width="100%" id="fee_heead_table">
                        <thead class="table-light" width="100%">
                            <tr>
                                <th>@lang('global_lang.action')</th>
                                <th>@lang('campus.campus_name')</th>
                                <th>@lang('class.title')</th>
                                <th>@lang('lang.fee_head')</th>
                                <th>@lang('lang.fee_amount')</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
</div>
 <div class="modal fade fee-head_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  </div>
@endsection
@section('javascript')
<script>
    $(document).ready(function() {

        //fee_heead_table
        var fee_heead_table = $("#fee_heead_table").DataTable({
            processing: true
            , serverSide: true
            , ajax: "/fee-heads"
            , columns: [{
                    data: "action"
                    , name: "action"
                }
                , {
                    data: "campus_name"
                    , name: "campus_name"
                }
                 , {
                    data: "class_name"
                    , name: "class_name"
                }
                , {
                    data: "description"
                    , name: "description"
                }
                , {
                    data: "amount"
                    , name: "amount"
                }
            , ]
        , });

   $(document).on("submit", "form#fee_head_add_form", function (e) {
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
                    $("div.fee-head_modal").modal("hide");
                    toastr.success(result.msg);
                    fee_heead_table.ajax.reload();
                } else {
                    toastr.error(result.msg);
                }
            },
        });
    });
 $(document).on("click", ".edit_fee_head_button", function () {
        $("div.fee-head_modal").load($(this).data("href"), function () {
            $(this).modal("show");

            $("form#fee_head_edit_form").submit(function (e) {
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
                            $("div.fee-head_modal").modal("hide");
                            toastr.success(result.msg);
                           fee_heead_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });
            });
        });
    });  $(document).on("click", "button.delete_fee_head_button", function() {
                swal({
                    title: LANG.sure,
                    text: LANG.confirm_delete_district,
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
                                   fee_heead_table.ajax.reload();
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
