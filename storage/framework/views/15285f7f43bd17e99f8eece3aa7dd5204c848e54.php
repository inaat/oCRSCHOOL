<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        <?php echo Form::open(['url' => action('\App\Http\Controllers\AwardController@store'), 'method' => 'post', 'id' =>'award_add_form' ]); ?>


        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('award.add_new_award'); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 p-3">
                    <?php echo Form::label('award', __( 'award.award_title' ) . ':*'); ?>

                    <?php echo Form::text('title', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'award.award_title' ) ]); ?>

                </div>
                <div class="col-md-12 p-3">
                    <?php echo Form::label('award', __( 'award.description' ) . ':*'); ?>

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

<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/admin\global_configuration\award/create.blade.php ENDPATH**/ ?>