<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();

$pretitle = get_field('pretitle') ? : '';
$title = get_field('title') ? : '';
$text = get_field('text') ? : '';
$link = get_field('link') ? : '';
$button_2 = get_field('button_2') ? : '';
$show_mobile_only = get_field('show_mobile_only') ? : '';


$background_image_lottie = get_field('background_image_lottie') ? : '';
$image = get_field('image') ? : '';
$lottie = get_field('lottie') ? : '';

if($title || $text || $link || $pretitle):
?>
<section class="home-banner <?php echo $show_mobile_only ? 'd-md-none' : '' ?>">
  <div class="background-area <?php echo $lottie && $background_image_lottie ? 'with_lottie' : ''; ?>">
    <!-- <img src="<?php echo $themeurl ?>/images/home-banner-bg.png" alt="#" class="img-fluid d-none d-md-block">
    <img src="<?php echo $themeurl ?>/images/home-banner-bg-mobile.png" alt="#" class="img-fluid d-md-none"> -->

    <?php if($image && !$background_image_lottie): ?>
      <img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>" class="img-fluid">
    <?php endif; ?>

    <?php if($lottie && $background_image_lottie): ?>
        <lottie-player src="<?php echo $lottie['url'] ?>" background="transparent" speed="1" loop autoplay></lottie-player>
    <?php endif; ?>
  </div>
  <div class="content-area" data-aos="fade-in">
    <?php if($pretitle): ?>
        <h5><?php echo $pretitle ?></h5>
    <?php endif; ?>

    <?php if($title): ?>
        <h1><?php echo $title ?></h1>
    <?php endif; ?>

    <?php if($text): ?>
        <?php echo $text ?>
    <?php endif; ?>

    <div class="button_area">
      <?php if($link):
      $link_url = $link['url'];
      $link_title = $link['title'];
      $link_target = $link['target'] ? $link['target'] : '_self';
      ?>
      <a <?php echo $link_url && $link_url != '#' ? 'href="'.$link_url.'"' : '' ?> target="<?php echo $link_target ?>" class="btn btn-secondary"><?php echo $link_title ?></a>
      <?php endif; ?>
  
      <?php if($button_2):
      $button_2_url = $button_2['url'];
      $button_2_title = $button_2['title'];
      $button_2_target = $button_2['target'] ? $button_2['target'] : '_self';

      $show_fancy = 0;
      if(strpos($button_2_url, 'youtube')) {
        $show_fancy = 1;
        $button_2_url = str_replace('#', '', $button_2_url);
      }
      ?>
      <a <?php echo $show_fancy ? 'data-fancybox' : ''; ?> <?php echo $button_2_url && $button_2_url != '#' ? 'href="'.$button_2_url.'"' : '' ?> target="<?php echo $button_2_target ?>" class="btn btn-secondary-alt <?php echo $show_fancy ? 'fancybox' : '' ?>"><?php echo $button_2_title ?></a>
      <?php endif; ?>
    </div>

    <?php if($lottie && $background_image_lottie): ?>
      <div class="background-area d-md-none">
      <lottie-player src="<?php echo $lottie['url'] ?>" background="transparent" speed="1" loop autoplay></lottie-player>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php
endif;