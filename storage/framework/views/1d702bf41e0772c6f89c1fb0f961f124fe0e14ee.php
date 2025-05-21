<?php $__env->startPush('styles_top'); ?>
    <link rel="stylesheet" href="/assets/default/vendors/chartjs/chart.min.css"/>
    <link rel="stylesheet" href="/assets/default/vendors/apexcharts/apexcharts.css"/>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <section class="">
        <div class="d-flex align-items-start align-items-md-center justify-content-between flex-column flex-md-row">
            <h1 class="section-title"><?php echo e(trans('panel.dashboard')); ?></h1>

            <?php if(!$authUser->isUser()): ?>
                <div class="d-flex align-items-center flex-row-reverse flex-md-row justify-content-start justify-content-md-center mt-20 mt-md-0">
                    <label class="mb-0 mr-10 cursor-pointer text-gray font-14 font-weight-500" for="iNotAvailable"><?php echo e(trans('panel.i_not_available')); ?></label>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="disabled" <?php if($authUser->offline): ?> checked <?php endif; ?> class="custom-control-input" id="iNotAvailable">
                        <label class="custom-control-label" for="iNotAvailable"></label>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php if(!$authUser->financial_approval and !$authUser->isUser()): ?>
            <div class="p-15 mt-20 p-lg-20 not-verified-alert font-weight-500 text-dark-blue rounded-sm panel-shadow">
                <?php echo e(trans('panel.not_verified_alert')); ?>

                <a href="/panel/setting/step/7" class="text-decoration-underline"><?php echo e(trans('panel.this_link')); ?></a>.
            </div>
        <?php endif; ?>

        <div class="bg-white dashboard-banner-container position-relative px-15 px-ld-35 py-10 panel-shadow rounded-sm">
            <h2 class="font-30 text-primary line-height-1">
                <span class="d-block"><?php echo e(trans('panel.hi')); ?> <?php echo e($authUser->full_name); ?>,</span>
                <span class="font-16 text-secondary font-weight-bold"><?php echo e(trans('panel.have_event',['count' => !empty($unReadNotifications) ? count($unReadNotifications) : 0])); ?></span>
            </h2>

            <ul class="mt-15 unread-notification-lists">
                <?php if(!empty($unReadNotifications) and !$unReadNotifications->isEmpty()): ?>
                    <?php $__currentLoopData = $unReadNotifications->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unReadNotification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="font-14 mt-1 text-gray">- <?php echo e($unReadNotification->title); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php if(count($unReadNotifications) > 5): ?>
                        <li>&nbsp;&nbsp;...</li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>

            <a href="/panel/notifications" class="mt-15 font-weight-500 text-dark-blue d-inline-block"><?php echo e(trans('panel.view_all_events')); ?></a>

            <div class="dashboard-banner">
                <img src="<?php echo e(getPageBackgroundSettings('dashboard')); ?>" alt="" class="img-cover">
            </div>
        </div>
    </section>

    <section class="dashboard">
        <div class="row">
            <div class="col-12 col-lg-6 mt-35">
                <div class="bg-white account-balance rounded-sm panel-shadow py-15 py-md-30 px-10 px-md-20">
                    <div class="text-center">
                        <img src="/assets/default/img/activity/36.svg" class="account-balance-icon" alt="">

                        <h3 class="font-16 font-weight-500 text-gray mt-25"><?php echo e(trans('panel.account_balance')); ?></h3>
                        <span class="mt-5 d-block font-30 text-secondary"><?php echo e(handlePrice($authUser->getAccountingBalance())); ?></span>
                    </div>

                    <?php
                        $getFinancialSettings = getFinancialSettings();
                        $drawable = $authUser->getPayout();
                        $can_drawable = ($drawable > ((!empty($getFinancialSettings) and !empty($getFinancialSettings['minimum_payout'])) ? (int)$getFinancialSettings['minimum_payout'] : 0))
                    ?>

                    <div class="mt-20 pt-30 border-top border-gray300 d-flex align-items-center <?php if($can_drawable): ?> justify-content-between <?php else: ?> justify-content-center <?php endif; ?>">
                        <?php if($can_drawable): ?>
                            <span class="font-16 font-weight-500 text-gray"><?php echo e(trans('panel.with_drawable')); ?>:</span>
                            <span class="font-16 font-weight-bold text-secondary"><?php echo e(handlePrice($drawable)); ?></span>
                        <?php else: ?>
                            <a href="/panel/financial/account" class="font-16 font-weight-bold text-dark-blue"><?php echo e(trans('financial.charge_account')); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 mt-35">
             
                <div class="bg-white account-balance rounded-sm panel-shadow py-15 py-md-30 px-10 px-md-20">
                    <div class="text-center">
                        <div class="dashboard-stats d-flex justify-content-center">
                            <div class="stat-icon monthly-sales">
                                <img src="<?php if($authUser->isUser()): ?> /assets/default/img/icons/meeting.svg <?php else: ?> /assets/default/img/icons/monay.svg <?php endif; ?>" alt="">
                            </div>
                        </div>
                        <h3 class="font-16 font-weight-500 text-gray"><?php echo e($authUser->isUser() ? trans('panel.meetings') : trans('panel.monthly_sales')); ?></h3>
                        <span class="mt-5 d-block font-30 text-secondary"><?php echo e(!empty($monthlySalesCount) ? handlePrice($monthlySalesCount) : (!empty($reserveMeetingsCount) ? $reserveMeetingsCount : 0)); ?></span>
                    </div>
                    <div class="mt-20 pt-30 border-top border-gray300 d-flex align-items-center justify-content-between">
                        <a href="<?php if($authUser->isUser()): ?> /panel/meetings/reservation <?php else: ?> /panel/financial/sales <?php endif; ?>" class="font-16 font-weight-bold text-dark-blue">
                          <?php echo e($authUser->isUser() ? "View my meetings" : "View my sales"); ?>

                        </a>
                        <a href="/instructors" class="font-16 font-weight-bold text-dark-blue">Book new meeting</a>
                    </div>
                </div>
            </div>

            

        </div>

        <div class="row">
          

            <div class="col-12 col-lg-12 mt-35">
                <div class="bg-white monthly-sales-card rounded-sm panel-shadow py-10 py-md-20 px-15 px-md-30">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="font-16 text-dark-blue font-weight-bold"><?php echo e(($authUser->isUser()) ? trans('panel.learning_statistics') : trans('panel.monthly_sales')); ?></h3>

                        <span class="font-16 font-weight-500 text-gray"><?php echo e(dateTimeFormat(time(),'M Y')); ?></span>
                    </div>

                    <div class="monthly-sales-chart">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="d-none" id="iNotAvailableModal">
        <div class="offline-modal">
            <h3 class="section-title after-line"><?php echo e(trans('panel.offline_title')); ?></h3>
            <p class="mt-20 font-16 text-gray"><?php echo e(trans('panel.offline_hint')); ?></p>

            <div class="form-group mt-15">
                <label><?php echo e(trans('panel.offline_message')); ?></label>
                <textarea name="message" rows="4" class="form-control "><?php echo e($authUser->offline_message); ?></textarea>
                <div class="invalid-feedback"></div>
            </div>

            <div class="mt-30 d-flex align-items-center justify-content-end">
                <button type="button" class="js-save-offline-toggle btn btn-primary btn-sm"><?php echo e(trans('public.save')); ?></button>
                <button type="button" class="btn btn-danger ml-10 close-swl btn-sm"><?php echo e(trans('public.close')); ?></button>
            </div>
        </div>
    </div>

    <div class="d-none" id="noticeboardMessageModal">
        <div class="text-center">
            <h3 class="modal-title font-20 font-weight-500 text-dark-blue"></h3>
            <span class="modal-time d-block font-12 text-gray mt-25"></span>
            <p class="modal-message font-weight-500 text-gray mt-4"></p>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts_bottom'); ?>
    <script src="/assets/default/vendors/apexcharts/apexcharts.min.js"></script>
    <script src="/assets/default/vendors/chartjs/chart.min.js"></script>

    <script>
        var offlineSuccess = '<?php echo e(trans('panel.offline_success')); ?>';
        var $chartDataMonths = <?php echo json_encode($monthlyChart['months'], 15, 512) ?>;
        var $chartData = <?php echo json_encode($monthlyChart['data'], 15, 512) ?>;
    </script>

    <script src="/assets/default/js/panel/dashboard.min.js"></script>
<?php $__env->stopPush(); ?>

<?php if(!empty($giftModal)): ?>
    <?php $__env->startPush('scripts_bottom2'); ?>
        <script>
            (function () {
                "use strict";

                handleLimitedAccountModal('<?php echo $giftModal; ?>', 40)
            })(jQuery)
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>

<?php echo $__env->make(getTemplate() .'.panel.layouts.panel_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\teachme\public_html\resources\views/web/default/panel/dashboard/index.blade.php ENDPATH**/ ?>