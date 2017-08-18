<!-- Services Section -->
<section id="section1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <?php if (get_theme_mod('col_heading','') != '') { ?>
                <h2 class="section-heading"><?php echo esc_html(get_theme_mod('col_heading')); ?></h2>
                <?php } else { ?>
                <h2 class="section-heading"><?php if(is_customize_preview()){ _e('Services','novellite'); } ?> </h2>
                <?php } ?>
                <?php if (get_theme_mod('col_sub','') != '') { ?>
                <h3 class="section-subheading text-muted"><?php echo esc_html(get_theme_mod('col_sub','')); ?></h3>
                <?php } ?>
            </div>
        </div>
        <div class="row text-center servies wow fadeInRight" data-wow-duration="2s">
            <div class="col-md-4 th-1">
                <a href="<?php if (get_theme_mod('first_feature_link','') != '') {
                    echo esc_url(get_theme_mod('first_feature_link',''));
                    } ?>">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa <?php
                        if (get_theme_mod('first_feature_font_icon','') != '') {
                        echo esc_html(get_theme_mod('first_feature_font_icon',''));
                        } else {
                        ?> fa-microphone <?php } ?> fa-stack-1x fa-inverse"></i>
                    </span></a>
                    <?php if (get_theme_mod('first_feature_heading','') != '') { ?>
                    <a href="<?php
                        if (get_theme_mod('first_feature_link','') != '') {
                        echo esc_url(get_theme_mod('first_feature_link',''));
                    } ?>"><h4 class="service-heading"><?php echo esc_html(get_theme_mod('first_feature_heading','')); ?></h4></a>
                    <?php } else { ?>
                    <a href="#"><h4 class="service-heading"><?php if(is_customize_preview()){ _e('E-Commerce','novellite'); } ?></h4></a>
                    <?php } if (get_theme_mod('first_feature_desc','') != '') { ?>
                    <p class="text-muted"><?php echo esc_textarea(get_theme_mod('first_feature_desc','')); ?></p>
                    <?php } ?>
                </div>
                <div class="col-md-4 th-2">
                    <a href="<?php  if (get_theme_mod('second_feature_link','') != '') {
                        echo esc_url(get_theme_mod('second_feature_link',''));
                        } ?>">
                        <span class="fa-stack fa-4x">
                            <i class="fa fa-circle fa-stack-2x text-primary"></i>
                            <i class="fa <?php
                            if (get_theme_mod('second_feature_font_icon','') != '') {
                            echo esc_html(get_theme_mod('second_feature_font_icon',''));
                            } else {
                            ?> fa-rocket <?php } ?> fa-stack-1x fa-inverse"></i>
                        </span></a>
                        <?php if (get_theme_mod('second_feature_heading','') != '') { ?>
                        <a href="<?php  if (get_theme_mod('second_feature_link','') != '') {
                            echo esc_url(get_theme_mod('second_feature_link',''));
                        } ?>"><h4 class="service-heading"><?php echo esc_html(get_theme_mod('second_feature_heading','')); ?></h4></a>
                        <?php } else { ?>
                        <a href="#"><h4 class="service-heading">
                        <?php if(is_customize_preview()){ _e('Responsive Design','novellite'); } ?></h4></a>
                        <?php } if (get_theme_mod('second_feature_desc','') != '') { ?>
                        <p class="text-muted"><?php echo esc_textarea(get_theme_mod('second_feature_desc','')); ?></p>
                        <?php } ?>
                    </div>
                    <div class="col-md-4 th-3">
                        <a href="<?php if (get_theme_mod('third_feature_link','') != '') {
                            echo esc_url(get_theme_mod('third_feature_link',''));
                            } ?>">
                            <span class="fa-stack fa-4x">
                                <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                <i class="fa <?php
                                if (get_theme_mod('third_feature_font_icon','') != '') {
                                echo esc_html(get_theme_mod('third_feature_font_icon',''));
                                } else {
                                ?>fa-signal <?php } ?> fa-stack-1x fa-inverse"></i>
                            </span></a>
                            <?php if (get_theme_mod('third_feature_heading','') != '') { ?>
                            <a href="<?php if (get_theme_mod('third_feature_link','') != '') {
                                echo esc_url(get_theme_mod('third_feature_link',''));
                            } ?>"><h4 class="service-heading"><?php echo esc_html(get_theme_mod('third_feature_heading','')); ?></h4></a>
                            <?php } else { ?>
                            <a href="#"><h4 class="service-heading"> <?php if(is_customize_preview()){ _e('Web Security','novellite'); } ?></h4></a>
                            <?php } if (get_theme_mod('third_feature_desc','') != '') { ?>
                            <p class="text-muted"><?php echo esc_textarea(get_theme_mod('third_feature_desc','')); ?></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </section>