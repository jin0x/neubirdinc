<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();

$image_lottie = get_field('image_lottie') ? : '';
$title = get_field('title') ? : '';
$lottie = get_field('lottie') ? : '';
$image = get_field('image') ? : '';

if($title || $lottie || $image):
?>
<section class="integration">
  <div class="content-area text-center" data-aos="fade-in">
    <?php if($title): ?>
        <h2><?php echo $title ?></h2>
    <?php endif; ?>

    <?php if($image && !$image_lottie): ?>
        <img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>" class="img-fluid">
    <?php endif; ?>

    <?php if($lottie && $image_lottie): ?>
        <lottie-player src="<?php echo $lottie['url'] ?>" background="transparent" speed="1" loop autoplay></lottie-player>
    <?php endif; ?>
    
  </div>
</section>
<?php
endif;