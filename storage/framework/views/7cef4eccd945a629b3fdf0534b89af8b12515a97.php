<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        <?php echo Form::open(['url' => action('\App\Http\Controllers\RegionController@store'), 'method' => 'post', 'id' =>'region_add_form' ]); ?>


        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('class.add_new_region'); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 p-3">
                    <?php echo Form::label('city', __('region.city') . ':*', ['classs' => 'form-lable']); ?>

                    <?php echo Form::text('city', null, ['class' => 'form-control', 'required', 'placeholder' => __('region.city')]); ?>


                </div>

                <div class="col-md-6 p-3">
                    <?php echo Form::label('region.village', __('region.village') . ':*'); ?>

                    <?php echo Form::text('village', null, ['class' => 'form-control', 'required', 'placeholder' => __('region.village')]); ?>

                </div>


            </div>


            <div class="modal-footer">




                <button type="submit" class="btn btn-primary"><?php echo app('translator')->get( 'global_lang.save' ); ?></button>
                <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?php echo app('translator')->get( 'global_lang.close' ); ?></button>
            </div>
        </div>

        <?php echo Form::close(); ?>


    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/admin\global_configuration\regions/create.blade.php ENDPATH**/ ?>