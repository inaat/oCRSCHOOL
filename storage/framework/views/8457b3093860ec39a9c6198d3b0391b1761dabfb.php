<script type="text/javascript">
    base_path = "<?php echo e(url('/'), false); ?>";
    //used for push notification
    
</script>

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js?v=$asset_v"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js?v=$asset_v"></script>
<![endif]-->
<script src="<?php echo e(asset('js/vendor.js?v=' . $asset_v), false); ?>"></script>

<?php if(file_exists(public_path('js/lang/' . session()->get('user.language', config('app.locale')) . '.js'))): ?>
    <script src="<?php echo e(asset('js/lang/' . session()->get('user.language', config('app.locale') ) . '.js?v=' . $asset_v), false); ?>"></script>
<?php else: ?>
    <script src="<?php echo e(asset('js/lang/en.js?v=' . $asset_v), false); ?>"></script>
<?php endif; ?>
    

<?php
    $system_details_date_format = session('system_details.date_format', config('constants.default_date_format'));
    $datepicker_date_format = str_replace('d', 'dd', $system_details_date_format);
    $datepicker_date_format = str_replace('m', 'mm', $datepicker_date_format);
    $datepicker_date_format = str_replace('Y', 'yyyy', $datepicker_date_format);

    $moment_date_format = str_replace('d', 'DD', $system_details_date_format);
    $moment_date_format = str_replace('m', 'MM', $moment_date_format);
    $moment_date_format = str_replace('Y', 'YYYY', $moment_date_format);

    $system_details_time_format = session('system_details.time_format');
    $moment_time_format = 'HH:mm';
    if($system_details_time_format == 12){
        $moment_time_format = 'hh:mm A';
    }

    $common_settings = !empty(session('system_details.common_settings')) ? session('system_details.common_settings') : [];

    $default_datatable_page_entries = !empty($common_settings['default_datatable_page_entries']) ? $common_settings['default_datatable_page_entries'] : 25;
?>

<script>
    moment.tz.setDefault('<?php echo e(Session::get("system_details.time_zone"), false); ?>');
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        <?php if(config('app.debug') == false): ?>
            $.fn.dataTable.ext.errMode = 'throw';
        <?php endif; ?>
    });
        
    var financial_year = {
        start: moment('2021-01-01'),
        end: moment('2021-12-31'),
    }
    var admission_date_year = {
        start: moment('2021-01-01'),
        end: moment('2040-12-31'),
    }
    <?php if(file_exists(public_path('AdminLTE/plugins/select2/lang/' . session()->get('user.language', config('app.locale')) . '.js'))): ?>
    //Default setting for select2
    $.fn.select2.defaults.set("language", "<?php echo e(session()->get('user.language', config('app.locale')), false); ?>");
    <?php endif; ?>

    var datepicker_date_format = "<?php echo e($datepicker_date_format, false); ?>";
    var moment_date_format = "<?php echo e($moment_date_format, false); ?>";
    var moment_time_format = "<?php echo e($moment_time_format, false); ?>";

    var app_locale = "<?php echo e(session()->get('user.language', config('app.locale')), false); ?>";

    var non_utf8_languages = [
        <?php $__currentLoopData = config('constants.non_utf8_languages'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $const): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        "<?php echo e($const, false); ?>",
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    ];

    var __default_datatable_page_entries = "<?php echo e($default_datatable_page_entries, false); ?>";

    var __new_notification_count_interval = "<?php echo e(config('constants.new_notification_count_interval', 60), false); ?>000";
</script>

<?php if(file_exists(public_path('js/lang/' . session()->get('user.language', config('app.locale')) . '.js'))): ?>
    <script src="<?php echo e(asset('js/lang/' . session()->get('user.language', config('app.locale') ) . '.js?v=' . $asset_v), false); ?>"></script>
<?php else: ?>
    <script src="<?php echo e(asset('js/lang/en.js?v=' . $asset_v), false); ?>"></script>
<?php endif; ?>
		<script src="<?php echo e(asset('/js/tinymce/tinymce.js?v=' . $asset_v), false); ?>"></script>
		<script src="<?php echo e(asset('/js/tinymce/matheditor/plugin.js?v=' . $asset_v), false); ?>"></script>

<script src="<?php echo e(asset('js/functions.js?v=' . $asset_v), false); ?>"></script>
<script src="<?php echo e(asset('js/common.js?v=' . $asset_v), false); ?>"></script>
<script src="<?php echo e(asset('assets/js/app.js?v=' . $asset_v), false); ?>"></script>
<script src="<?php echo e(asset('/js/apps.js?v=' . $asset_v), false); ?>"></script>


<!-- TODO -->
<?php if(file_exists(public_path('AdminLTE/plugins/select2/lang/' . session()->get('user.language', config('app.locale')) . '.js'))): ?>
    <script src="<?php echo e(asset('AdminLTE/plugins/select2/lang/' . session()->get('user.language', config('app.locale') ) . '.js?v=' . $asset_v), false); ?>"></script>
<?php endif; ?>
<?php
    $validation_lang_file = 'messages_' . session()->get('user.language', config('app.locale') ) . '.js';
?>
<?php if(file_exists(public_path() . '/js/jquery-validation-1.16.0/src/localization/' . $validation_lang_file)): ?>
    <script src="<?php echo e(asset('js/jquery-validation-1.16.0/src/localization/' . $validation_lang_file . '?v=' . $asset_v), false); ?>"></script>
<?php endif; ?>

<?php if(!empty($__system_settings['additional_js'])): ?>
    <?php echo $__system_settings['additional_js']; ?>

<?php endif; ?>
<?php echo $__env->yieldContent('javascript'); ?>

<script type="text/javascript">
    $(document).ready( function(){
        var locale = "<?php echo e(session()->get('user.language', config('app.locale')), false); ?>";
        var isRTL = <?php if(in_array(session()->get('user.language', config('app.locale')), config('constants.langs_rtl'))): ?> true; <?php else: ?> false; <?php endif; ?>

        $('#calendar').fullCalendar('option', {
            locale: locale,
            isRTL: isRTL
        });
    });
</script><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/common/javascripts.blade.php ENDPATH**/ ?>