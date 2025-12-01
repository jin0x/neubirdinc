<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();

$items = get_field('items') ? : '';
$title = get_field('title') ? : '';
$background_color = get_field('background_color') ? : '';

if($title || $items):
?>
<section class="investors <?php echo $background_color ? 'add_bg_color' : '' ?>" <?php echo $background_color ? 'style="background-color:'.$background_color.';"' : '' ?>>
  <div class="content-area">
    <?php if($title): ?>
        <div class="title-area" data-aos="fade-in">
          <?php if($background_color): ?>
            <h3><?php echo $title ?></h3>
          <?php else: ?>
            <h2><?php echo $title ?></h2>
          <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if($items): ?>
        <div class="logo-list" data-aos="fade-in">
            <?php 
                foreach ($items as $key => $value) {
                   $logo = $value['logo'];
                   $add_a_custom_width_for_the_logo = $value['add_a_custom_width_for_the_logo'];
                   $logo_width = $value['logo_width'];
                   $url = $value['url'];

                   if($logo) {
                    ?>
                    <div class="logo-area">
                        <img src="<?php echo $logo['url'] ?>" alt="<?php echo $logo['alt'] ?>" class="img-fluid" <?php echo $logo_width && $add_a_custom_width_for_the_logo ? 'width="'.$logo_width.'px"' : '' ?>>
                        <?php if($url): ?>
                            <a href="<?php echo $url ?>" target="_blank">Link</a>
                        <?php endif; ?>
                    </div>
                    <?php
                   }
                }
            ?>
        </div>
    <?php endif; ?>
  </div>
</section>
<?php
endif;