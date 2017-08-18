<?php if(get_theme_mod('txt_desc_','')!==''):?>
<?php $pricetext = get_theme_mod('txt_desc_','');
?>
<section id="price-package" <?php if(get_theme_mod('pricing_img_first')!='') { ?>style="background-image: url(<?php echo esc_url(get_theme_mod('pricing_img_first','')); ?>);" <?php } ?>>
  <div class="container">
    <div class="price-page">
      <div class="post-title">
        <?php if (get_theme_mod('pricing_head_') != '') { ?>
        <h1><?php echo esc_html(get_theme_mod('pricing_head_')); ?></h1>
        <?php }else { ?>
        <h1><?php if(is_customize_preview()){ _e('Price and Packages','novellite'); } ?></h1>
        <?php } ?>
        <?php if (get_theme_mod('pricing_desc_') != '') { ?>
        <p><?php echo esc_textarea(get_theme_mod('pricing_desc_')); ?></p>
        <?php } ?>
      </div>
      <div class="price-block">
        <div class="price-class">
          <?php   echo do_shortcode($pricetext); ?>
          </div><!--price-class-->
          </div><!-- price-block -->
          </div><!-- price-page -->
          </div><!-- container -->
        </section>
        <?php endif ?>