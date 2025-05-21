<?php
    $getPanelSidebarSettings = getPanelSidebarSettings();
    $group = Auth::user()->userGroup->group->name ?? "basic"; //
?>

<div class="xs-panel-nav d-flex d-lg-none justify-content-between py-5 px-15">
    <div class="user-info d-flex align-items-center justify-content-between">
        <div class="user-avatar bg-gray200">
            <img src="<?php echo e($authUser->getAvatar(100)); ?>" class="img-cover" alt="<?php echo e($authUser->full_name); ?>">
        </div>

        <div class="user-name ml-15">
            <h3 class="font-16 font-weight-bold"><?php echo e($authUser->full_name); ?></h3>
        </div>
    </div>

    <button class="sidebar-toggler btn-transparent d-flex flex-column-reverse justify-content-center align-items-center p-5 rounded-sm sidebarNavToggle" type="button">
        <span><?php echo e(trans('navbar.menu')); ?></span>
        <i data-feather="menu" width="16" height="16"></i>
    </button>
</div>

<div class="panel-sidebar pt-50 pb-25 px-25 <?php echo e(strtolower($group)); ?>-group" id="panelSidebar">
    <button class="btn-transparent panel-sidebar-close sidebarNavToggle">
        <i data-feather="x" width="24" height="24"></i>
    </button>

   

    <div class="user-info d-flex align-items-center flex-row">
        <a href="/panel" class="user-avatar bg-gray200" style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden;">
            <img src="<?php echo e($authUser->getAvatar(50)); ?>" class="img-cover" style="width: 100%; height: 100%;" alt="<?php echo e($authUser->full_name); ?>">
        </a>

        <div class="d-flex flex-column ms-3 mx-3">
            <a href="/panel" class="user-name">
                <h3 class="font-14 font-weight-bold mb-0"><?php echo e($authUser->full_name); ?></h3>
            </a>

            <?php if(!empty($authUser->getUserGroup())): ?>
                <span class="create-new-user text-muted font-12"><?php echo e($authUser->getUserGroup()->name); ?></span>
            <?php endif; ?>
        </div>
    </div>

    <ul id="panel-sidebar-scroll" class="sidebar-menu h-100 pt-10 <?php if(!empty($authUser->userGroup)): ?> has-user-group <?php endif; ?> <?php if(empty($getPanelSidebarSettings) or empty($getPanelSidebarSettings['background'])): ?> without-bottom-image <?php endif; ?>" <?php if((!empty($isRtl) and $isRtl)): ?> data-simplebar-direction="rtl" <?php endif; ?>>

        <li class="sidenav-item <?php echo e((request()->is('panel')) ? 'sidenav-item-active' : ''); ?>">
            <a href="/panel" class="d-flex align-items-center">
                <span class="sidenav-item-icon mr-10">
                    <?php echo $__env->make('web.default.panel.includes.sidebar_icons.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </span>
                <span class="font-14 text-dark-blue font-weight-500"><?php echo e(trans('panel.dashboard')); ?></span>
            </a>
        </li>

        <li class="sidenav-item">
            <a class="d-flex align-items-center" data-toggle="collapse" href="#tutorsCollapse" role="button" aria-expanded="false" aria-controls="tutorsCollapse">
                <span class="sidenav-item-icon mr-10">
                    <?php echo $__env->make('web.default.panel.includes.sidebar_icons.teachers', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </span>
                <span class="font-14 text-dark-blue font-weight-500">Tutors</span>
            </a>
            <div class="collapse <?php echo e((request()->is('panel/tutors') or request()->is('panel/tutors/*') or request()->is('tutorlist')) ? 'sidenav-item-active' : ''); ?>" id="tutorsCollapse">
                <ul class="sidenav-item-collapse">
                    <li class="mt-5 <?php echo e((request()->is('panel/tutors')) ? 'active' : ''); ?>">
                        <a href="/panel/tutorlist">Search</a>
                    </li>
                    <li class="mt-5 <?php echo e((request()->is('panel/tutors')) ? 'active' : ''); ?>">
                        <a href="/panel/tutors">All Tutors</a>
                    </li>
                </ul>
            </div>


        </li>

        <?php if($authUser->isOrganization()): ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('panel_organization_instructors')): ?>
                <li class="sidenav-item <?php echo e((request()->is('panel/instructors') or request()->is('panel/manage/instructors*')) ? 'sidenav-item-active' : ''); ?>">
                    <a class="d-flex align-items-center" data-toggle="collapse" href="#instructorsCollapse" role="button" aria-expanded="false" aria-controls="instructorsCollapse">
                <span class="sidenav-item-icon mr-10">
                    <?php echo $__env->make('web.default.panel.includes.sidebar_icons.teachers', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </span>
                        <span class="font-14 text-dark-blue font-weight-500"><?php echo e(trans('public.instructors')); ?></span>
                    </a>

                    <div class="collapse <?php echo e((request()->is('panel/instructors') or request()->is('panel/manage/instructors*')) ? 'show' : ''); ?>" id="instructorsCollapse">
                        <ul class="sidenav-item-collapse">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('panel_organization_instructors_create')): ?>
                                <li class="mt-5 <?php echo e((request()->is('panel/instructors/new')) ? 'active' : ''); ?>">
                                    <a href="/panel/manage/instructors/new"><?php echo e(trans('public.new')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('panel_organization_instructors_lists')): ?>
                                <li class="mt-5 <?php echo e((request()->is('panel/manage/instructors')) ? 'active' : ''); ?>">
                                    <a href="/panel/manage/instructors"><?php echo e(trans('public.list')); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('panel_organization_students')): ?>
                <li class="sidenav-item <?php echo e((request()->is('panel/students') or request()->is('panel/manage/students*')) ? 'sidenav-item-active' : ''); ?>">
                    <a class="d-flex align-items-center" data-toggle="collapse" href="#studentsCollapse" role="button" aria-expanded="false" aria-controls="studentsCollapse">
                <span class="sidenav-item-icon mr-10">
                    <?php echo $__env->make('web.default.panel.includes.sidebar_icons.students', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </span>
                        <span class="font-14 text-dark-blue font-weight-500"><?php echo e(trans('quiz.students')); ?></span>
                    </a>

                    <div class="collapse <?php echo e((request()->is('panel/students') or request()->is('panel/manage/students*')) ? 'show' : ''); ?>" id="studentsCollapse">
                        <ul class="sidenav-item-collapse">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('panel_organization_students_create')): ?>
                                <li class="mt-5 <?php echo e((request()->is('panel/manage/students/new')) ? 'active' : ''); ?>">
                                    <a href="/panel/manage/students/new"><?php echo e(trans('public.new')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('panel_organization_students_lists')): ?>
                                <li class="mt-5 <?php echo e((request()->is('panel/manage/students')) ? 'active' : ''); ?>">
                                    <a href="/panel/manage/students"><?php echo e(trans('public.list')); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>
        <?php endif; ?>


        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('panel_meetings')): ?>
            <li class="sidenav-item <?php echo e((request()->is('panel/meetings') or request()->is('panel/meetings/*')) ? 'sidenav-item-active' : ''); ?>">
                <a class="d-flex align-items-center" data-toggle="collapse" href="#meetingCollapse" role="button" aria-expanded="false" aria-controls="meetingCollapse">
                <span class="sidenav-item-icon mr-10">
                    <?php echo $__env->make('web.default.panel.includes.sidebar_icons.requests', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </span>
                    <span class="font-14 text-dark-blue font-weight-500"><?php echo e(trans('panel.meetings')); ?></span>
                </a>

                <div class="collapse <?php echo e((request()->is('panel/meetings') or request()->is('panel/meetings/*')) ? 'show' : ''); ?>" id="meetingCollapse">
                    <ul class="sidenav-item-collapse">

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('panel_meetings_my_reservation')): ?>
                            <li class="mt-5 <?php echo e((request()->is('panel/meetings/reservation')) ? 'active' : ''); ?>">
                                <a href="/panel/meetings/reservation"><?php echo e(trans('public.my_reservation')); ?></a>
                            </li>
                        <?php endif; ?>

                        <?php if($authUser->isOrganization() || $authUser->isTeacher()): ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('panel_meetings_requests')): ?>
                                <li class="mt-5 <?php echo e((request()->is('panel/meetings/requests')) ? 'active' : ''); ?>">
                                    <a href="/panel/meetings/requests"><?php echo e(trans('panel.requests')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('panel_meetings_settings')): ?>
                                <li class="mt-5 <?php echo e((request()->is('panel/meetings/settings')) ? 'active' : ''); ?>">
                                    <a href="/panel/meetings/settings"><?php echo e(trans('panel.settings')); ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </li>
        <?php endif; ?>


        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('panel_financial')): ?>
            <li class="sidenav-item <?php echo e((request()->is('panel/financial') or request()->is('panel/financial/*')) ? 'sidenav-item-active' : ''); ?>">
                <a class="d-flex align-items-center" data-toggle="collapse" href="#financialCollapse" role="button" aria-expanded="false" aria-controls="financialCollapse">
                <span class="sidenav-item-icon mr-10">
                    <?php echo $__env->make('web.default.panel.includes.sidebar_icons.financial', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </span>
                    <span class="font-14 text-dark-blue font-weight-500"><?php echo e(trans('panel.financial')); ?></span>
                </a>

                <div class="collapse <?php echo e((request()->is('panel/financial') or request()->is('panel/financial/*')) ? 'show' : ''); ?>" id="financialCollapse">
                    <ul class="sidenav-item-collapse">

                        <?php if($authUser->isOrganization() || $authUser->isTeacher()): ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('panel_financial_sales_reports')): ?>
                                <li class="mt-5 <?php echo e((request()->is('panel/financial/sales')) ? 'active' : ''); ?>">
                                    <a href="/panel/financial/sales"><?php echo e(trans('financial.sales_report')); ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('panel_financial_summary')): ?>
                            <li class="mt-5 <?php echo e((request()->is('panel/financial/summary')) ? 'active' : ''); ?>">
                                <a href="/panel/financial/summary"><?php echo e(trans('financial.financial_summary')); ?></a>
                            </li>
                        <?php endif; ?>

                    
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('panel_financial_charge_account')): ?>
                            <li class="mt-5 <?php echo e((request()->is('panel/financial/account')) ? 'active' : ''); ?>">
                                <a href="/panel/financial/account"><?php echo e(trans('financial.charge_account')); ?></a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </div>
            </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('panel_support')): ?>
            <li class="sidenav-item <?php echo e((request()->is('panel/support') or request()->is('panel/support/*')) ? 'sidenav-item-active' : ''); ?>">
                <a class="d-flex align-items-center" data-toggle="collapse" href="#supportCollapse" role="button" aria-expanded="false" aria-controls="supportCollapse">
                <span class="sidenav-item-icon assign-fill mr-10">
                    <?php echo $__env->make('web.default.panel.includes.sidebar_icons.support', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </span>
                    <span class="font-14 text-dark-blue font-weight-500"><?php echo e(trans('panel.support')); ?></span>
                </a>

                <div class="collapse <?php echo e((request()->is('panel/support') or request()->is('panel/support/*')) ? 'show' : ''); ?>" id="supportCollapse">
                    <ul class="sidenav-item-collapse">

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('panel_support_create')): ?>
                            <li class="mt-5 <?php echo e((request()->is('panel/support/new')) ? 'active' : ''); ?>">
                                <a href="/panel/support/new"><?php echo e(trans('public.new')); ?></a>
                            </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('panel_support_tickets')): ?>
                            <li class="mt-5 <?php echo e((request()->is('panel/support/tickets')) ? 'active' : ''); ?>">
                                <a href="/panel/support/tickets"><?php echo e(trans('panel.support_tickets')); ?></a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </div>
            </li>
        <?php endif; ?>


        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('panel_others_profile_setting')): ?>
            <li class="sidenav-item <?php echo e((request()->is('panel/setting')) ? 'sidenav-item-active' : ''); ?>">
                <a href="/panel/setting" class="d-flex align-items-center">
                <span class="sidenav-setting-icon sidenav-item-icon mr-10">
                    <?php echo $__env->make('web.default.panel.includes.sidebar_icons.setting', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </span>
                    <span class="font-14 text-dark-blue font-weight-500"><?php echo e(trans('panel.settings')); ?></span>
                </a>
            </li>
        <?php endif; ?>

        <?php if($authUser->isTeacher() or $authUser->isOrganization()): ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('panel_others_profile_url')): ?>
                <li class="sidenav-item ">
                    <a href="<?php echo e($authUser->getProfileUrl()); ?>" class="d-flex align-items-center">
                <span class="sidenav-item-icon assign-strock mr-10">
                    <i data-feather="user" stroke="#1f3b64" stroke-width="1.5" width="24" height="24" class="mr-10 webinar-icon"></i>
                </span>
                        <span class="font-14 text-dark-blue font-weight-500"><?php echo e(trans('public.my_profile')); ?></span>
                    </a>
                </li>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('panel_others_logout')): ?>
            <li class="sidenav-item">
                <a href="/logout" class="d-flex align-items-center">
                <span class="sidenav-logout-icon sidenav-item-icon mr-10">
                    <?php echo $__env->make('web.default.panel.includes.sidebar_icons.logout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </span>
                    <span class="font-14 text-dark-blue font-weight-500"><?php echo e(trans('panel.log_out')); ?></span>
                </a>
            </li>
        <?php endif; ?>

    </ul>

</div>
<?php /**PATH C:\teachme\public_html\resources\views/web/default/panel/includes/sidebar.blade.php ENDPATH**/ ?>