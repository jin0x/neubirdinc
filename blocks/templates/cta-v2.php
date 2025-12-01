<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();

$background_color = get_field('background_color') ? : '';
$title = get_field('title') ? : '';
$text = get_field('text') ? : '';
$button_color = get_field('button_color') ? : '';
$button_text_color = get_field('button_text_color') ? : '';
$button = get_field('button') ? : '';

if($title || $text || $button):
?>
<section class="let-ai-do-work new_cta_v2" <?php echo $background_color ? 'style="background-color:'.$background_color.';"' : '' ?>>
  <div class="content-area">
    <div class="text-area" data-aos="fade-in">
        <?php if($title): ?>
            <h2><?php echo $title ?></h2>
        <?php endif; echo $text ?>

    </div>
        <?php if($button):
            $button_url = $button['url'];
            $button_title = $button['title'];
            $button_target = $button['target'] ? $button['target'] : '_self';

            $style_button = '';
            if($button_color) {
                $style_button .= 'background-color:'.$button_color.';';
            }
            if($button_text_color) {
                $style_button .= 'color:'.$button_text_color.';';
            }
        ?>
    <div class="button_area">
        <a <?php echo $button_url && $button_url != '#' ? 'href="'.$button_url.'"' : '' ?> style="<?php echo $style_button ?>" target="<?php echo $button_target ?>" class="btn btn-primary"><?php echo $button_title ?></a>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php
endif;