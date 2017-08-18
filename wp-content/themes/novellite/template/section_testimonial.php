<!-- *** Testimonial Slider Starts *** -->
<?php if (get_theme_mod('testimonial_parallax_image','') != '') { ?>
<section class="testimonial-wrapper" id="section2" data-type="background" style="background: url(<?php echo esc_url(get_theme_mod('testimonial_parallax_image','')); ?>) center repeat fixed;">
    <?php } else { ?>
    <section class="testimonial-wrapper" id="section2">
        <?php } ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="testimonial-inner animated bottom-to-top">
                        <?php if (get_theme_mod('testimonial_heading','') != '') { ?>
                        <h1 class="testimonial-header wow fadeInUp" data-wow-duration="2s"><?php echo esc_html(get_theme_mod('testimonial_heading','')); ?></h1>
                        <?php } else { ?>
                        <h1 class="testimonial-header wow fadeInUp" data-wow-duration="2s"><?php if(is_customize_preview()){ _e('Show Multiple Testimonials.', 'novellite'); } ?></h1>
                        <?php } ?>
                        <ul class="bxslider">
                            <!-- *Testimonial 1 Starts* -->
                            <?php if (get_theme_mod('first_author_desc','') != '') { ?>
                            <li class="wow fadeInRight" data-wow-duration="2s">
                                <img src="<?php if (get_theme_mod('first_author_image','') != '') { ?><?php echo esc_url(get_theme_mod('first_author_image','')); } else { echo get_template_directory_uri(); ?>/images/testimonial-image.png<?php } ?>" onMouseOver="javascript: this.title='';" title="<a class='arrow'></a>
                                <?php echo esc_textarea(get_theme_mod('first_author_desc','')); ?>
                                <p><a class='testimonial'><?php echo esc_html(get_theme_mod('first_author_name','')) ; ?></a></p>">
                            </li>
                            <?php } ?>
                            <!-- *Testimonial 2 Starts* -->
                            <?php if (get_theme_mod('second_author_desc','') != '') { ?>
                            <li class="wow fadeInRight" data-wow-duration="2s">
                                <img src="<?php if (get_theme_mod('second_author_image','') != '') { ?><?php echo esc_url(get_theme_mod('second_author_image','')); } else { echo get_template_directory_uri(); ?>/images/testimonial-image.png <?php } ?>" onMouseOver="javascript: this.title='';" title="<a class='arrow'></a>
                                <?php echo get_theme_mod('second_author_desc',''); ?>
                                <p><a class='testimonial'><?php echo esc_html(get_theme_mod('second_author_name','')); ?></a></p>">
                            </li>
                            <?php } else { ?>
                            <li class="wow fadeInRight" data-wow-duration="2s">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/testimonial-image.png" onMouseOver="javascript: this.title='';" title="<a class='arrow'></a>NovelLite comes with amazing business features. It is perfect for a business website with required features.<p><a class='testimonial'>NovelLite</a></p>">
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>