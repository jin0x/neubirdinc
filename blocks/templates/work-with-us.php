<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();

$title = get_field('title') ? : '';
$text = get_field('text') ? : '';
$button = get_field('button') ? : '';
$image = get_field('image') ? : '';
$image_2 = get_field('image_2') ? : '';
$image_3 = get_field('image_3') ? : '';

if($title || $text || $image || $image_2 || $image_3 || $button):
?>
<section class="careers join_team work_with_us">
  <div class="content-area">
    <?php if($image || (isset($title_2) && $title_2)): ?>
        <div class="life-at-neubird">
          <div class="left-area">
            <?php if($title): ?>
                <h2><?php echo $title ?></h2>
            <?php endif; ?>
            <?php echo $text; ?>

            <?php if($button):
                $button_url = $button['url'];
                $button_title = $button['title'];
                $button_target = $button['target'] ? $button['target'] : '_self';
            ?>
            <a <?php echo $button_url && $button_url != '#' ? 'href="'.$button_url.'"' : '' ?> target="<?php echo $button_target ?>" class="btn btn-orange"><?php echo $button_title ?></a>
            <?php endif; ?>
          </div>
          <div class="right-area">
            <div class="img-area">
                <?php if($image): ?>
                    <img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>" class="img-fluid">
                <?php endif; ?>
                <?php if($image_2): ?>
                    <img src="<?php echo $image_2['url'] ?>" alt="<?php echo $image_2['alt'] ?>" class="img-fluid">
                <?php endif; ?>
                <?php if($image_3): ?>
                    <img src="<?php echo $image_3['url'] ?>" alt="<?php echo $image['alt'] ?>" class="img-fluid">
                <?php endif; ?>
            </div>
          </div>
        </div>
    <?php endif; ?>
  </div>
</section>
<?php
endif;