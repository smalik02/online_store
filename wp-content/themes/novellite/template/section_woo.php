<?php if ( class_exists( 'WooCommerce' ) ): ?>
<section id="section8" class="woo-wrapper" >
    <?php $woo_product = get_theme_mod('woo_shortcode','[recent_products]');
    ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <?php if (get_theme_mod('woo_head_','') != '') { ?>
                <h2 class="section-heading"><?php echo esc_html(get_theme_mod('woo_head_','')); ?></h2>
                <?php } else { ?>
                <h2 class="section-heading"><?php if(is_customize_preview()){ _e('Latest Woo Commerce Product','novellite'); } ?></h2>
                <?php } ?>
                <?php if (get_theme_mod('woo_desc_','') != '') { ?>
                <h3 class="section-subheading text-muted"><?php echo esc_textarea(get_theme_mod('woo_desc_','')); ?></h3>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 wow fadeInLeft" data-wow-duration="2s">
                <div class="woo_content">
                    <?php  
                    if ( shortcode_exists( 'recent_products' ) ) {
                     echo do_shortcode($woo_product);
                 }
                      ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>