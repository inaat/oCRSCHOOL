<div class="modal-dialog modal-md" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('\App\Http\Controllers\StudentController@postAdmissionFee'), 'method' => 'post', 'id' => 'admission_fee_add_form']) !!}

        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">@lang('lang.create_admission_voucher')
                ({{ ucwords($student->first_name . ' ' . $student->last_name) }})</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="d-flex flex-column align-items-center text-center">
                <img src="{{ !empty($student->student_image) ? url('uploads/student_image/', $student->student_image) : url('uploads/student_image/default.png') }}"
                    alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
                <h5>({{ ucwords($student->first_name . ' ' . $student->last_name) }})</h5>
            </div>
            <input type="hidden" name="student_id" value="{{$student->id}}"/>
            <input type="hidden" name="class_id" value="{{$student->current_class_id}}"/>
            <input type="hidden" name="class_section_id" value="{{$student->current_class_section_id}}"/>
            <input type="hidden" name="campus_id" value="{{$student->campus_id}}"/>
            <div class="col-sm-12">
                <strong>@lang('lang.admission_fee_details')</strong>
                <div class="form-group">
                    <table class="table table-condensed table-striped " id="admisssion-table">
                        <thead>
                            <tr>
                                <th class="text-center">@lang('lang.fee_heads')</th>
                                <th class="text-center">@lang('lang.enable')</th>
                                <th class="text-center ">@lang('lang.amount')</th>
                            </tr>
                        </thead>
                        <tbody>
                         
                          @foreach ($fee_heads as $fee_head)
                                   <tr>
                                <td class="text-center"><div class="mt-2">{{ $fee_head->description }}</div></td>
                                <td class="text-center">
                                        {{-- <input class="" name='fee_heads[{{ $loop->iteration }}][check]'  type="checkbox" value="0"  id="flexCheckChecked"> --}}
                               
                                     {!! Form::checkbox('fee_heads[' . $loop->iteration  . '][is_enabled]', 1, null, ['class' => 'form-check-input mt-2 fee-head-check']); !!}                                 </td>

                        
                                </td>

                                <td class="text-center ">
                                    <input  name="fee_heads[{{ $loop->iteration }}][amount]" type="number" value={{ @num_format($fee_head->amount) }} class="form-control amount"
                                        value="0">
                                    <input type="hidden" name="fee_heads[{{ $loop->iteration }}][fee_head_id]" value="{{ $fee_head->id }}">

                                </td>
                            </tr> 
                            @endforeach
                             <tfoot>
                      <tr>
                        <th colspan="2" class="text-center">Total</th>
                        <td><span class="final_total">0</span></td>
                        <input type="hidden" name="final_total" id="final_total" value="0">
                      </tr>
                    </tfoot>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="modal-footer">

            <button type="submit" class="btn btn-primary">@lang( 'global_lang.save' )</button>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal">@lang( 'global_lang.close' )</button>
        </div>
    </div>

    {!! Form::close() !!}

</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
