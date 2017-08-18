<?php
$contactus_shortcode = get_theme_mod('cf_shtcd_','[lead-form form-id=1 title=Contact Us]');
?>
<!-- blog title -->
<!-- blog title ends -->
<?php if (get_theme_mod('cf_image','') != '') { ?>
<section id="section5" class="contact_section" style="background: url(<?php echo esc_url(get_theme_mod('cf_image','')); ?>) center repeat fixed;">
    <?php } else { ?>
    <section id="section5" class="contact_section">
        <?php } ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <?php if (get_theme_mod('cf_head_','') != '') { ?>
                    <h2 class="section-heading"><?php echo esc_html(get_theme_mod('cf_head_','')); ?></h2>
                    <?php } else { ?>
                    <h2 class="section-heading"><?php _e('Contact Us','novellite'); ?></h2>
                    <?php } ?>
                    <?php if (get_theme_mod('cf_desc_','') != '') { ?>
                    <h3 class="section-subheading text-muted contact"><?php echo esc_textarea(get_theme_mod('cf_desc_','')); ?></h3>
                    <?php } ?>
                </div>
            </div>
            <div class="row">
                <div class="cnt-div  wow fadeInRight" data-wow-delay="0s">
                    <?php 
                    if ( shortcode_exists( 'lead-form' ) ) {
                    echo do_shortcode($contactus_shortcode);

                    }
                     ?>
                </div>
            </div>
        </div>
    </section>