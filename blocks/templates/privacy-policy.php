<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();

$title = get_field('title') ? : '';
$last_updated_text = get_field('last_updated_text') ? : '';
$text = get_field('text') ? : '';

if($title || $last_updated_text || $text):
?>
<section class="text-only-container">
  <div class="content-area">
    <div class="text-box">
        <?php if($title): ?>
            <h1><?php echo $title ?></h1>
        <?php endif; ?>

        <?php if($last_updated_text): ?>
            <h6><?php echo $last_updated_text ?></h6>
        <?php endif; echo $text; ?>
    </div>
  </div>
</section>
<?php
endif;