<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        <?php echo Form::open(['url' => action('\App\Http\Controllers\CategoryController@store'), 'method' => 'post', 'id' =>'category_add_form' ]); ?>


        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('categories.add_new_category'); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 p-3">
                    <?php echo Form::label('cat_name', __( 'categories.cat_name') . ':*'); ?>

                    <?php echo Form::text('cat_name', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'categories.cat_name') ]); ?>

                </div>
                <div class="col-md-12 p-3">
                    <?php echo Form::label('cdescription', __( 'categories.description' ) . ':*'); ?>

                    <?php echo Form::textarea('description', null, ['class' => 'form-control' ]); ?>

                </div>
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

<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/admin\global_configuration\categories/create.blade.php ENDPATH**/ ?>