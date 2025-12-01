<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();

$mobile_image = get_field('mobile_image') ? : '';
$desktop_image = get_field('desktop_image') ? : '';
$title = get_field('title') ? : '';
$text = get_field('text') ? : '';
$button = get_field('button') ? : '';

if($title || $button || $desktop_image):
?>
<section class="page-banner-image">
  <div class="background-image" data-aos="fade-in">
    <?php if($desktop_image): ?>
        <img src="<?php echo $desktop_image['url'] ?>" alt="<?php echo $desktop_image['alt'] ?>" class="img-fluid d-none d-md-block">
    <?php endif; ?>

    <?php if($mobile_image): ?>
        <img src="<?php echo $mobile_image['url'] ?>" alt="<?php echo $mobile_image['alt'] ?>" class="img-fluid d-md-none">
        <?php else: ?>
        <img src="<?php echo $desktop_image['url'] ?>" alt="<?php echo $desktop_image['alt'] ?>" class="img-fluid d-md-none">
    <?php endif; ?>
  </div>
  <div class="content-area">
    <div class="text-box" data-aos="fade-in">
      <?php if($title): ?>
        <h1><?php echo $title ?></h1>
      <?php endif; ?>

      <?php if($text): ?>
        <p><?php echo $text ?></p>
      <?php endif; ?>

        <?php if($button):
            $button_url = $button['url'];
            $button_title = $button['title'];
            $button_target = $button['target'] ? $button['target'] : '_self';
        ?>
            <a <?php echo $button_url && $button_url != '#' ? 'href="'.$button_url.'"' : '' ?> target="<?php echo $button_target ?>" class="btn btn-orange"><?php echo $button_title ?></a>
        <?php endif; ?>
    </div>
  </div>
</section>
<?php
endif;