<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();

$pretitle = get_field('pretitle') ? : '';
$title = get_field('title') ? : '';
$text = get_field('text') ? : '';
$image = get_field('image') ? : '';

if($title || $text || $image || $pretitle):
?>
<section class="what-we-do <?php echo !$image ? 'add_padding_mobile' : '' ?>">
  <div class="content-area">
    <?php if($image): ?>
        <div class="image-area" data-aos="fade-in">
          <img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>" class="img-fluid">
        </div>
    <?php endif; ?>
    <div class="text-area" data-aos="fade-in">
        <?php if($pretitle): ?>
            <h3><?php echo $pretitle ?></h3>
        <?php endif; ?>

        <?php if($title): ?>
            <h2><?php echo $title ?></h2>
        <?php endif; ?>

        <?php if($text): ?>
            <p><?php echo $text; ?></p>
        <?php endif; ?>
    </div>
  </div>
</section>
<?php if(!$image): ?>
  <script>
    var reduce_padding_homebanner = 1;
  </script>
<?php endif; ?>
<?php
endif;