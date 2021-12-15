<?php if($status=='UPCOMING'): ?>
<div class="col">
    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
        <div class="btn-group" role="group">
            <button type="button" class="btn-badge  badge  rounded-pill text-white bg-info p-2 text-uppercase px-3 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><?php echo app('translator')->get('session.upcoming'); ?></button>
            <ul class="dropdown-menu">
                <li>
                <a data-href="<?php echo e(action('SessionController@activateSession', [$id]), false); ?>" class="dropdown-item session_activate"><?php echo app('translator')->get('session.activate'); ?></a></li>

                </li>
                
            </ul>
        </div>
    </div>
</div>
<?php elseif($status=='ACTIVE'): ?>
<div class="col">
    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
        <div class="btn-group" role="group">
            <button type="button" class="btn badge  rounded-pill text-white bg-success p-2 text-uppercase px-3 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><?php echo app('translator')->get('session.active'); ?></button>
            <ul class="dropdown-menu">
                <li>
                <a data-href="<?php echo e(action('SessionController@activateSession', [$id]), false); ?>" class="dropdown-item session_activate"><?php echo app('translator')->get('session.mark_passed'); ?></a></li>

                </li>
                
            </ul>
        </div>
    </div>
</div>
<?php else: ?>
<div class="badge btn-badge  rounded-pill text-white bg-danger p-2 text-uppercase px-3"><?php echo app('translator')->get('session.passed'); ?></div>
<?php endif; ?><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/admin\global_configuration\session/session_status.blade.php ENDPATH**/ ?>