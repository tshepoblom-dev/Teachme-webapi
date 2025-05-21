<?php
    $socials = getSocials();
    if (!empty($socials) and count($socials)) {
        $socials = collect($socials)->sortBy('order')->toArray();
    }

    $footerColumns = getFooterColumns();
?>


<footer class="footer bg-dark text-dark position-relative user-select-none">
   
    <?php
        $columns = ['first_column','second_column','third_column','forth_column'];
    ?>


    <div class="container">
       

        <div class="mt-40 py-25 d-flex align-items-center justify-content-between">
            <div class="footer-logo">
                <a href="/">
                    <?php if(!empty($generalSettings['footer_logo'])): ?>
                        <img src="<?php echo e($generalSettings['footer_logo']); ?>" class="img-cover" alt="footer logo">
                    <?php endif; ?>
                </a>
            </div>

            <div class="footer-social">
                <?php if(!empty($socials) and count($socials)): ?>
                    <?php $__currentLoopData = $socials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e($social['link']); ?>" target="_blank">
                            <img src="<?php echo e($social['image']); ?>" alt="<?php echo e($social['title']); ?>" class="mr-15">
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if(getOthersPersonalizationSettings('platform_phone_and_email_position') == 'footer'): ?>
        <div class="footer-copyright-card">
            <div class="container d-flex align-items-center justify-content-between py-15">
           

                <div class="d-flex align-items-center justify-content-center">
                    <?php if(!empty($generalSettings['site_phone'])): ?>
                        <div class="d-flex align-items-center text-white font-14">
                            <i data-feather="phone" width="20" height="20" class="mr-10"></i>
                            <a href="tel:<?php echo e($generalSettings['site_phone']); ?>" style="color:white">
                            <?php echo e($generalSettings['site_phone']); ?></a>
                        </div>
                    <?php endif; ?>

                    <?php if(!empty($generalSettings['site_email'])): ?>
                        <div class="border-left mx-5 mx-lg-15 h-100"></div>

                        <div class="d-flex align-items-center text-white font-14">
                            <i data-feather="mail" width="20" height="20" class="mr-10"></i>
                            <a href="mailto:<?php echo e($generalSettings['site_email']); ?>" style="color:white">
                            <?php echo e($generalSettings['site_email']); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

</footer>
<?php /**PATH C:\teachme\public_html\resources\views/web/default/includes/footer.blade.php ENDPATH**/ ?>