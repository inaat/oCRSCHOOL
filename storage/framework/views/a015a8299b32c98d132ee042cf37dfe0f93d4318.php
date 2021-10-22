<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        <?php echo Form::open(['url' => action('\App\Http\Controllers\SessionController@store'), 'method' => 'post', 'id' =>'session_add_form' ]); ?>


        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('session.register_new_session'); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
        <p class="text-muted"><?php echo app('translator')->get('session.register_as_many_sessions_as_you_need._please_provide_required_information_to_proceed_next...'); ?></p>
            <div class="form-group">
                <?php echo Form::label('session', __( 'session.session_information' ) . ':'); ?>

                <?php echo Form::text('title', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'session.session_title' ) ]); ?>

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
<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/admin\global_configuration\session/create.blade.php ENDPATH**/ ?>