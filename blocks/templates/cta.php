<?php
$id = 'row'.get_row_index();
$themeurl = get_stylesheet_directory_uri();

$pretitle = get_field('pretitle') ? : '';
$title = get_field('title') ? : '';
$text = get_field('text') ? : '';
$button = get_field('button') ? : '';
$chats = get_field('chats') ? : '';
$lottie = get_field('lottie') ? : '';

if($title || $text || $button || $pretitle || $chats):
?>
<section class="let-ai-do-work cta_version">
  <div class="content-area">
    <div class="text-area" data-aos="fade-in">
        <?php if($button):
            $button_url = $button['url'];
            $button_title = $button['title'];
            $button_target = $button['target'] ? $button['target'] : '_self';
        ?>
        <a <?php echo $button_url && $button_url != '#' ? 'href="'.$button_url.'"' : '' ?> target="<?php echo $button_target ?>" class="btn btn-primary"><?php echo $button_title ?></a>
        <?php endif; ?>
    </div>
  </div>
</section>
<?php
endif;